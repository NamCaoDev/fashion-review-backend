<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

trait issueTokenTrait {
    public function issueToken( $credentials, $grant_type = 'password', $scope = '*') {
        $payload = [
            'grant_type' => $grant_type,
            'client_id' => config('auth.passport_grant_password.client_id'),
            'client_secret' =>config('auth.passport_grant_password.client_secret'),
            ...$credentials,
            'scope' => $scope,
        ];
        $tokenRequest = Request::create('oauth/token', 'POST', $payload);

        $token = App::handle($tokenRequest)->getContent();
        return json_decode($token);
    }
}

