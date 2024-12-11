<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use \Illuminate\Support\Facades\Log;

class ApiAuthController extends Controller
{
    //
    private function generateOauthToken($credentials) {
        $payload = [
            'grant_type' => 'password',
            'client_id' => config('auth.passport_grant_password.client_id'),
            'client_secret' =>config('auth.passport_grant_password.client_secret'),
            'scope' => '*',
            ...$credentials
        ];
        $token = (object) Http::asForm()->post(url('http://localhost:8000/oauth/token'), $payload)->json();
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


    public function login (LoginRequest $request) {
        $userQuery = User::query();
        $userLogin = $userQuery->checkUsernameExist($request['username'])->first();
        if(!$userLogin) {
            return response(["error" => "User not found!"], 404);
        }
        $passwordMatch = Hash::check($request['password'], $userLogin->password);
        if(!$passwordMatch) {
            return response(["error" => "Password wrong!"], 404);
        }
        $token = $this->generateOauthToken(['username' => $request['username'], 'password' => $request['password']]);
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
