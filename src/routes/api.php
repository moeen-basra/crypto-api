<?php

use Laravel\Lumen\Routing\Router;

/** @var Router $router */

$router->get('/', function () use ($router) {
    return view('index');
});

$router->post('/login', [
    'as' => 'login',
    'uses' => 'Auth\LoginController@login',
]);

$router->post('/register', [
    'as' => 'register',
    'uses' => 'Auth\RegisterController@register',
]);

$router->get('/coins', [
    'as' => 'coins',
    'uses' => 'Coin\CoinController@index',
]);

// the following routes are only for logged in users
$router->group(['middleware' => 'auth',], function (Router $router) {
    $router->get('/ticker/{coin_code}', [
        'as' => 'ticker',
        'uses' => 'Coin\CoinController@show',
    ]);
});
