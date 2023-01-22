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

//  API Version beta 1.2.0.6

$prefix = 'api/';
//user relatet api endpoint
$router->group(['prefix' => $prefix], function () use ($router) {
    $router->post('login', 'UserController@login');
    $router->post('register', ['middleware' => 'auth', 'uses' =>  'UserController@register']);
    $router->get('user/all', ['middleware' => 'auth', 'uses' => 'UserController@getAllUser']);
    $router->get('user/{id}', ['middleware' => 'auth', 'uses' => 'UserController@getUser']);
    $router->get('user/', ['middleware' => 'auth', 'uses' => 'UserController@getUser']);
    $router->delete('user/{id}', ['middleware' => 'auth', 'uses' => 'UserController@destroy']);
    $router->put('user/', ['middleware' => 'auth', 'uses' => 'UserController@update']);
    $router->put('user/{id}', ['middleware' => 'auth', 'uses' => 'UserController@update']);
});
//product related api endpoint
$router->group(['prefix' =>$prefix, 'middleware' => 'auth'], function () use ($router) {
    //product request api endpoint
    $router->get('product/request', 'ProductRequestsController@index');
    $router->get('product/request/{id}', 'ProductRequestsController@show');
    $router->post('product/request', 'ProductRequestsController@store');
    $router->put('product/request/{id}', 'ProductRequestsController@update');
    $router->delete('product/request/{id}', 'ProductRequestsController@destroy');
    //product supplier api endpoint
    $router->get('product/supplier', 'SuppliersController@index');
    $router->get('product/supplier/{id}', 'SuppliersController@show');
    $router->post('product/supplier', 'SuppliersController@store');
    $router->put('product/supplier/{id}', 'SuppliersController@update');
    $router->delete('product/supplier/{id}', 'SuppliersController@destroy');
    //produxt category api endpoint
    $router->get('product/category', 'CategoriesController@index');
    $router->get('product/category/{id}', 'CategoriesController@show');
    $router->post('product/category', 'CategoriesController@store');
    $router->put('product/category/{id}', 'CategoriesController@update');
    $router->delete('product/category/{id}', 'CategoriesController@destroy');
    //product api endpoint
    $router->get('product', 'ProductsController@index');
    $router->post('product', 'ProductsController@store');
    $router->get('product/{id}', 'ProductsController@show');
    $router->put('product/{id}', 'ProductsController@update');
    $router->delete('product/{id}', 'ProductsController@destroy');
    $router->get('product/{id}/category', 'ProductsController@category');
    $router->get('product/{id}/supplier', 'ProductsController@supplier');
});
//branch related api endpoint
$router->group(['prefix' => $prefix, 'middleware' => 'auth'], function () use ($router) {
    $router->get('branch', 'BranchesController@index');
    $router->get('branch/user', 'BranchesController@user');
    $router->get('branch/user/{id}', 'BranchesController@index');
    $router->get('branch/{id}', 'BranchesController@show');
    $router->post('branch', 'BranchesController@store');
    $router->put('branch/{id}', 'BranchesController@update');
    $router->delete('branch/{id}', 'BranchesController@destroy');
});
//company profile related api endpoint
$router->group(['prefix' => $prefix, 'middleware' => 'auth'], function () use ($router) {
    $router->get('profile', 'AppController@profile');
    $router->put('profile', 'AppController@profile');
    //$router->post('profile', 'BranchesController@store');
    //$router->delete('profile', 'BranchesController@destroy');
});

$router->group(['prefix' => $prefix], function () use ($router) {
    $router->post('json', 'WarehouseController@stockup');
    $router->get('json', [WarehouseController::class, 'stockup']);
});