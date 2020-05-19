<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
$router->group([
    'prefix' => 'api/v1',
    'as'  =>  'api'
], function () use ($router) {
    $router->get('/dashboard', ['as' => 'dashboard', 'uses' => 'DashboardController@index']);

    // Authentication routes
    $router->group([
        'prefix' => 'auth', // /api/v1/auth
        'as' => 'auth'  // route('api.auth')
    ], function () use ($router) {

        // front end client logges in through this route
        // e.g POST req to http://localhost/api/v1/auth/login
        // route name: 'api.auth.login'
        $router->post('login', [ 'as' => 'login', 'uses' => 'AuthController@login' ]);

        // e.g POST req to http://localhost/api/v1/auth/logout
        // route name: 'api.auth.logout'
        $router->post('logout', [ 'as' => 'logout', 'uses' => 'AuthController@logout' ]);
    });

    // Route to get details about the currently authenticated user
    // e.g GET req to http://localhost/api/v1/auth/me
    $router->get('/me', [ 'as' => 'me', 'uses' => 'AuthController@me']);

    // This group of routes will require authentication to access
    $router->group([
        'prefix' => 'reports',
        'as' => 'reports',
    ], function () use ($router) {

        // Only the create report route will be unprotected so that guest users can make a report
        // frontend client creates or stores a new report through this route
        // e.g POST req to http://localhost/api/v1/reports
        $router->post('', ['as' => 'store', 'uses' => 'ReportController@store']);

        // these routes can only be accessible by an authenticated user
        Route::group(['middleware' => ['auth']], function ($router) {

            // frontend client reads a single report through this route
            // e.g GET req to http://localhost/api/v1/reports/1
            $router->get('{id}', ['as' => 'read', 'uses' => 'ReportController@read']);

            // frontend client updates an already existing report through this route
            // e.g PATCH req to http://localhost/api/v1/reports/1
            $router->patch('{id}', ['as' => 'update', 'uses' => 'ReportController@update']);

            // frontend client deletes a report through this route
            // e.g DELETE req to http://localhost/api/v1/reports/1
            $router->delete('{id}', ['as' => 'delete', 'uses' => 'ReportController@delete']);

            // Displays a listing of all reports
            // e.g GET req to http://localhost/api/v1/reports
            $router->get('', ['as' => 'list', 'uses' => 'ReportController@list']);

            // Gets report metrics
            // e.g GET req to http://localhost/api/v1/reports/metrics
            $router->get('metrics', ['as' => 'metrics', 'uses' => 'ReportController@metrics']);
        });
    });

    // These group of routes are guest routes and does not require authentication
    $router->group([
        'prefix' => 'guest',
        'as' => 'guest'
    ], function () use ($router) {
        $router->get('reports', ['as' => 'reports', 'uses' => 'GuestController@reports']);

        $router->get('metrics', ['as' => 'metrics', 'uses' => 'GuestController@metrics']);
    });
});
