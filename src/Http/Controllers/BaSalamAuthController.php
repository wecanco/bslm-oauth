<?php

namespace BaSalam\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use BaSalam\Auth\Services\BaSalamAuth;
use Illuminate\Http\Request;

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
                'scopes'=>'required,array'
            ]
        );

        return response()->redirectTo($this->baSalamAuth->createAccessUrl($request->input('scopes')));
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
            return response()->json(['data'=>[$token->getBody(), $request->all()]]);
        }
    }
}
