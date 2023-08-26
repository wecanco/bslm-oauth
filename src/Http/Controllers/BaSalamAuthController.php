<?php

namespace BaSalam\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use BaSalam\Auth\Models\Callback;
use BaSalam\Auth\Services\BaSalamAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class BaSalamAuthController extends Controller
{
    public BaSalamAuth $baSalamAuth;
    public function __construct()
    {
        $this->baSalamAuth = new BaSalamAuth();
    }

    public function userAccess(Request $request)
    {
        $validate = $request->validate(
            [
                'scopes'=>'required|array',
                'state'=>'required'
            ]
        );

        return Redirect::to($this->baSalamAuth->createAccessUrl($request->input('scopes'), $request->input('state')));
    }

    public function callback(Request $request)
    {
        $validate = $request->validate(
          [
              'code'=>'required,integer',
              'state'=>'required,integer,min:11,max:12'
          ]
        );

        $token = $this->baSalamAuth->getToken($request->input('code'));

        if(!$token){
            return response()->json(['data' => ['error'=>['token'=>'error get token']], 403]);
        }else{

            $callback = new Callback([
                'user_id' => $request->input("state"),
                'data' => [$token->getBody(), $request->all()]
            ]);

            return response()->redirectTo(config('basalam_auth.app_url'))->with($callback->id);
        }
    }
}
