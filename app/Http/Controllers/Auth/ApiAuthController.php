<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RefreshTokenRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\App;
use \Illuminate\Support\Facades\Log;
use App\Http\Traits\issueTokenTrait;
use Illuminate\Support\Facades\Auth;

class ApiAuthController extends Controller
{
    //
    use issueTokenTrait;

    public function register (RegisterRequest $request) {
        $passwordNotHash = $request['password'];
        $request['password']=Hash::make($request['password']);
        $request['remember_token'] = Str::random(10);
        $user = User::create($request->toArray());
        $token = $this->issueToken(['username' => $user->username, 'password' => $passwordNotHash]);
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
        $token = $this->issueToken(['username' => $request['username'], 'password' => $request['password']]);
        $response = ['token' => $token];
        return response($response, 200);
    }


    public function logout(Request $request) {
        $token = $request->user()->token();
        $token->revoke();

        DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $token->id)
            ->update(['revoked' => true]);

        $token->revoke();

        return response(["message" => "Logout successfully"], 200);
    }

    public function refreshToken(RefreshTokenRequest $request) {
        $refresh_token = $request->refresh_token;

        $new_access_token = $this->issueToken(["refresh_token" => $refresh_token], 'refresh_token');

        return response(["token" => $new_access_token], 200);
    }
}
