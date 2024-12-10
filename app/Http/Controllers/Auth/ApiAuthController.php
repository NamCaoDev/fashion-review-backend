<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class ApiAuthController extends Controller
{
    //
    private function generateOauthToken($credentials) {
        $token = (object) Http::asForm()->post(url('/oauth/token'), [
            'grant_type' => 'password',
            'client_id' => config('auth.passport_grant_password.client_id'),
            'client_secret' =>config('auth.passport_grant_password.client_secret'),
            'scope' => '*',
            ...$credentials
        ])->json();
       return $token;
    }

    public function register (RegisterRequest $request) {
        $passwordNotHash = $request['password'];
        $request['password']=Hash::make($request['password']);
        $request['remember_token'] = Str::random(10);
        $user = User::create($request->toArray());
        $token = $this->generateOauthToken(['username' => $user->username, 'password' => $passwordNotHash]);
        $response = ['token' => $token];
        return response($response, 200);
    }


    public function logout (Request $request) {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }
}
