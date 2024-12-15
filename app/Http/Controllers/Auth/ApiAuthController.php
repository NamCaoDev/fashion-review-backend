<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RefreshTokenRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
use App\Http\Traits\issueTokenTrait;
use Illuminate\Support\Facades\Auth;

class ApiAuthController extends BaseController
{
    //
    use issueTokenTrait;

    public function register (RegisterRequest $request) {
        $passwordNotHash = $request['password'];
        $request['password']=Hash::make($request['password']);
        $request['remember_token'] = Str::random(10);
        $user = User::create($request->toArray());
        $token = $this->issueToken(['username' => $user->username, 'password' => $passwordNotHash]);
        $response['token'] = $token;
        return $this->sendResponse($response, 'User register successfully.');
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
        $response['token'] = $token;
        return $this->sendResponse($response, 'User login successfully');
    }


    public function logout(Request $request) {
        $token = $request->user()->token();

        DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $token->id)
            ->update(['revoked' => true]);

        $token->revoke();

        return $this->sendResponse(null, 'Logout successfully.');
    }

    public function refreshToken(RefreshTokenRequest $request) {
        $refresh_token = $request->refresh_token;

        $new_access_token = $this->issueToken(["refresh_token" => $refresh_token], 'refresh_token');

        $response['token'] = $new_access_token;

        return $this->sendResponse($response, 'Refresh token successfully');
    }

    public function getMe() {
        $user = Auth::user();
        return $this->sendResponse($user, 'User retrived successfully');
    }
}
