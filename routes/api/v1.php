<?php
$api = app('Dingo\Api\Routing\Router');

$api->version('v1',[
    'namespace' => 'App\Http\Controllers\Api\V1',
    'middleware' => 'api.throttle',
    'limit' => 1,
    'expires' => 1,
], function ($api) {
    $api->post('auth/token', [
        'as' => 'auth.store',
        'uses' => 'AuthController@store',
    ]);

    $api->put('auth/token', [
        'as' => 'auth.store',
        'uses' => 'AuthController@update',
    ]);
});