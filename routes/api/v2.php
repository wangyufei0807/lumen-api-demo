<?php
$api = app('Dingo\Api\Routing\Router');

$api->version('v2',[
    'namespace' => 'App\Http\Controllers\Api\V2',
], function ($api) {
    $api->post('auth/token', [
        'as' => 'auth.store',
        'uses' => 'AuthController@store',
    ]);

    $api->put('auth/token', [
        'as' => 'auth.store',
        'uses' => 'AuthController@update',
    ]);

    // user detail
    $api->get('users', [
        'as' => 'users.show',
        'uses' => 'UserController@index',
    ]);

    // need authentication
    $api->group(['middleware' => 'api.auth'], function ($api) {
        // user detail
        $api->get('users/{id}', [
            'as' => 'users.show',
            'uses' => 'UserController@show',
        ]);
    });
});