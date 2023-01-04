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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

// Route::prefix('api')->group(function () {
//     Route::get('product', [products::class, 'index'])->name('user.index');
// });

$router->group(['prefix' => 'api/'], function () use ($router) {
    $router->get('product', 'ProductsController@index');
    $router->post('product', 'ProductsController@store');
    $router->get('product/{id}', 'ProductsController@show');
    $router->patch('product/{id}', 'ProductsController@update');
    $router->delete('product/{id}', 'ProductsController@destroy');
    $router->post('register', ['middleware' => 'auth', 'uses' =>  'UserController@register']);
    $router->post('login', 'UserController@login');
    $router->get('user/{id}', ['middleware' => 'auth', 'uses' => 'UserController@getuser']);
});
