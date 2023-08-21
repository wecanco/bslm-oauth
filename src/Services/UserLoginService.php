<?php

namespace BaSalam\Auth\Services;

use BaSalam\Auth\Models\RefreshToken;
use BaSalam\Auth\Models\User;
use BaSalam\Auth\Services\ExternalServices\Auth;

class UserLoginService
{
    public function __construct()
    {

    }

    public function verifyToken(User $user): bool
    {
        $token = $user->token()->token;

        $baSalamAuth = new Auth();
        $responseToken = $baSalamAuth->verifyToken($token);

        if ($responseToken->getStatusCode() == 200){
            $responseToken = json_decode($responseToken->getBody());
            if ($responseToken){
                //TODO write by response
                return true;
            }
        }
        return false;
    }


    public function getUserByToken($token)
    {
        return RefreshToken::where('token', $token)->first()->user();
    }

}
