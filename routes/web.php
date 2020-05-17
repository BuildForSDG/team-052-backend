<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

    // reports endpoint
    $router->group([
        'prefix' => 'reports',
        'as' => 'reports'
    ], function () use ($router) {
        $router->post('', ['as' => 'create', 'uses' => 'ReportController@store']);

        $router->get('{id}', ['as' => 'read', 'uses' => 'ReportController@read']);

        $router->patch('{id}', ['as' => 'update', 'uses' => 'ReportController@update']);

        $router->delete('{id}', ['as' => 'delete', 'uses' => 'ReportController@delete']);

        $router->get('', ['as' => 'list', 'uses' => 'ReportController@list']);

        $router->get('', ['as' => 'list', 'uses' => 'UserReportController@list']);

        $router->get('{id}', ['as' => 'status', 'uses' => 'ReportController@status']);
    });
});
