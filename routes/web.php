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
    $router->post('register', ['middleware' => 'auth', 'uses' =>  'UserController@register']);
    $router->post('login', 'UserController@login');
    $router->get('user/{id}', ['middleware' => 'auth', 'uses' => 'UserController@getuser']);
});

$router->group(['prefix' => 'api/'], function () use ($router) {
    $router->get('product', 'ProductsController@index');
    $router->post('product', 'ProductsController@store');
    $router->get('product/{id}', 'ProductsController@show');
    $router->patch('product/{id}', 'ProductsController@update');
    $router->delete('product/{id}', 'ProductsController@destroy');
});

$router->group(['prefix' => 'api/'], function () use ($router) {
    $router->get('Category', 'CategoriesController@index');
    $router->get('getCategory/{id}', 'CategoriesController@show');
    $router->post('addCategory', 'CategoriesController@store');
    $router->patch('updateCategory/{id}', 'CategoriesController@update');
    $router->delete('deleteCategory/{id}', 'CategoriesController@destroy');
});

$router->group(['prefix' => 'api/'], function () use ($router) {
    $router->get('Supplier', 'SuppliersController@index');
    $router->get('getSupplier/{id}', 'SuppliersController@show');
    $router->post('addSupplier', 'SuppliersController@store');
    $router->patch('updateSupplier/{id}', 'SuppliersController@update');
    $router->delete('deleteSupplier/{id}', 'SuppliersController@destroy');
}); 

$router->group(['prefix' => 'api/'], function () use ($router) {
    $router->get('Branch', 'BranchesController@index');
    $router->get('getBranch/{id}', 'BranchesController@show');
    $router->post('addBranch', 'BranchesController@store');
    $router->patch('updateBranch/{id}', 'BranchesController@update');
    $router->delete('deleteBranch/{id}', 'BranchesController@destroy');
});

$router->group(['prefix' => 'api/'], function () use ($router) {
    $router->get('Product_req', 'ProductRequestsController@index');
    $router->get('getProduct_req/{id}', 'ProductRequestsController@show');
    $router->post('addProduct_req', 'ProductRequestsController@store');
    $router->patch('updateProduct_req/{id}', 'ProductRequestsController@update');
    $router->delete('deleteProduct_req/{id}', 'ProductRequestsController@destroy');
});