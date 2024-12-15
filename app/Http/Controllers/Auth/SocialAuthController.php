<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Http\Traits\issueTokenTrait;

class SocialAuthController extends BaseController
{
    //
    use issueTokenTrait;
    public function redirectSocialLogin(Request $request) {
        $socialType = $request->social;
        return Socialite::driver($socialType)->redirect();
    }

    public function processSocialLogin(Request $request) {
        $socialType = $request->social;
        $userSocialData = Socialite::driver($socialType)->user();
        if(!$userSocialData) {
            return;
        }
        User::updateOrCreate([
            "{$socialType}_id" => $userSocialData->id,
        ], [
            'name' => $userSocialData->name,
            'email' => $userSocialData->email,
            'username' => "user_$userSocialData->id",
            "{$socialType}_id" => $userSocialData->id,
        ]);

        $token = $this->issueToken(['username' => $request['username'], 'password' => null]);
        $response['token'] = $token;
        return $this->sendResponse($response, 'User login successfully');
    }
}
