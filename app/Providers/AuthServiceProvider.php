<?php

namespace App\Providers;

use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        $this->app['auth']->viaRequest('api', function ($request) {

            // we expect the client to pass an authorization header with a bearer token
            // before we can validate the request
            // ex. 'Authorization' => 'Bearer token_goes_here'
            if ($token = $request->bearerToken()) {

                // next we search our database for the user with such token
                // and return such user as our request user
                return User::where('api_token', $token)->first();
            }
        });
    }
}
