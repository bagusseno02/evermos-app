<?php

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

use Illuminate\Support\Str;

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/key', function () {
    return Str::random(32);
});

$router->get('health', 'HealthController@index');

$router->group(['prefix' => 'product'], function () use ($router) {
    $router->post('create', 'ProductController@create');
    $router->get('detail/{id}', 'ProductController@detail');
    $router->post('list', 'ProductController@list');
    $router->put('update/{id}', 'ProductController@update');
    $router->delete('delete/{id}', 'ProductController@delete');
});

$router->group(['prefix' => 'shopping-cart'], function () use ($router) {
    $router->post('create', 'ShoppingCartController@create');
    $router->get('detail/{id}', 'ShoppingCartController@detail');
    $router->post('list', 'ShoppingCartController@list');
    $router->put('update/{id}', 'ShoppingCartController@update');
    $router->delete('delete/{id}', 'ShoppingCartController@delete');
});

$router->group(['prefix' => 'order'], function () use ($router) {
    $router->post('checkout', 'OrderController@checkout');
});
