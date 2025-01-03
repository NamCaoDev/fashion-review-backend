<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;
use Laravel\Passport\AuthCode;
use Laravel\Passport\Client;
use Laravel\Passport\PersonalAccessClient;
use Laravel\Passport\RefreshToken;
use Laravel\Passport\Token;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        Passport::loadKeysFrom(__DIR__.'/../secrets/oauth');
        Passport::enablePasswordGrant();
        Passport::hashClientSecrets();
        Passport::useTokenModel(Token::class);
        Passport::useRefreshTokenModel(RefreshToken::class);
        Passport::useAuthCodeModel(AuthCode::class);
        Passport::useClientModel(Client::class);
        Passport::usePersonalAccessClientModel(PersonalAccessClient::class);
        Passport::tokensExpireIn(now()->addHours(24));
        Passport::refreshTokensExpireIn(now()->addDays(3));
        Passport::personalAccessTokensExpireIn(now()->addMonths(6));
    }
}
