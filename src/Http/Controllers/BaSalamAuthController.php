<?php

namespace BaSalam\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use BaSalam\Auth\Models\RefreshToken;
use Basalam\Auth\Models\User;
use BaSalam\Auth\Services\ExternalServices\Auth;
use BaSalam\Auth\Services\ExternalServices\PlatformCore;
use BaSalam\Auth\Services\UserLoginService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BaSalamAuthController extends Controller
{
    public Auth $baSalamAuth;
    public UserLoginService $loginService;
    public function __construct()
    {
        $this->baSalamAuth = new Auth();
        $this->loginService = new UserLoginService();
    }

    public function userAccess()
    {
        return response()->redirectTo($this->baSalamAuth->createAccessUrl());
    }

    public function tokenVerify(Request $request)
    {
        $user = $this->loginService->getUserByToken($request->bearerToken());
        if (!$user){
            return response()->json(['data' => 'access forbidden.',403]);
        }
        if ($this->loginService->verifyToken($user)){
            return response()->json(['data' => 'token active.', 202]);
        }

        return response()->json(['data' => 'token expired.',401]);

    }

    public function refreshToken(Request $request)
    {
        $user = $this->loginService->getUserByToken($request->bearerToken());
        if (!$user){
            return response()->json(['data' => 'access forbidden.',403]);
        }

        if ($this->loginService->verifyToken($user)){
            return response()->json(['data'=>'token active.', 202]);
        }

        return response()->json(['data'=>'token expired.',401]);

    }

    public function token(Request $request)
    {
        $validate = $request->validate(
          [
              'code'=>'required,integer',
              'state'=>'required,integer,min:12,max:12'
          ]
        );

        $token = $this->baSalamAuth->getToken();

        if(!$token){
            return response()->json(['data' => ['error'=>['token'=>'error get token']], 403]);
        }else{
            $currentUser = PlatformCore::getCurrentUser($token->token);

            if ($currentUser->getStatusCode() == 200){
                $currentUser = json_decode($currentUser->getBody());

                $user = new User([
                    'data'          => json_encode($currentUser),
                    'basalam_id'    => $currentUser->id,
                    'vendor_id'     => $currentUser->vendor->id,
                    'hash_id'       => $currentUser->hash_id,
                    'mobile'        => $request->input('state'),
                    'vendor_status' => $currentUser->vendor->status,
                    'name'          => $currentUser->name
                ]);

                //TODO write by response
                $userToken = new RefreshToken(
                    [
                        'token'     => $token->token,
                        'user_id'   => $user->id
                    ]
                );

                return response()->json(['data'=>[$user, $userToken]]);
            }else{
                return response()->json(['data' => ['error'=> json_encode($currentUser->getBody())], $currentUser->getStatusCode()]);
            }
        }
    }
}
