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

//  API Version beta 2.5.0.1

$prefix = 'api/';
//user relatet api endpoint
$router->group(['prefix' => $prefix], function () use ($router) {
    $router->post('login', 'UserController@login');
    $router->post('register', ['middleware' => 'auth', 'uses' =>  'UserController@register']);
    $router->get('user/all', ['middleware' => 'auth', 'uses' => 'UserController@getAllUser']);
    $router->get('user/{id}', ['middleware' => 'auth', 'uses' => 'UserController@getUser']);
    $router->get('user/', ['middleware' => 'auth', 'uses' => 'UserController@getUser']);
    //role related
    $router->get('role/', ['middleware' => 'auth', 'uses' => 'RoleController@index']);
    $router->get('role/{id}', ['middleware' => 'auth', 'uses' => 'RoleController@index']);
    $router->put('role/{id}', ['middleware' => 'auth', 'uses' => 'RoleController@update']);
    $router->get('role/{id}/permision', ['middleware' => 'auth', 'uses' => 'PermisionController@viewrole']);
    $router->delete('role/{id}', ['middleware' => 'auth', 'uses' => 'RoleController@destroy']);
    $router->get('permision/', ['middleware' => 'auth', 'uses' => 'PermisionController@index']);
    $router->get('permision/{id}', ['middleware' => 'auth', 'uses' => 'PermisionController@view']);
    $router->post('role/', ['middleware' => 'auth', 'uses' => 'RoleController@store']);
    //
    $router->delete('user/{id}', ['middleware' => 'auth', 'uses' => 'UserController@destroy']);
    $router->put('user/', ['middleware' => 'auth', 'uses' => 'UserController@update']);
    $router->put('user/{id}', ['middleware' => 'auth', 'uses' => 'UserController@update']);
});
//product related api endpoint
$router->group(['prefix' =>$prefix, 'middleware' => 'auth'], function () use ($router) {
    //product request api endpoint
    $router->get('product/request', 'ProductRequestController@index');
    $router->get('product/request/{id}', 'ProductRequestController@show');
    $router->post('product/request', 'ProductRequestController@store');
    $router->put('product/request/{id}', 'ProductRequestController@update');
    $router->delete('product/request/{id}', 'ProductRequestController@destroy');
    //product supplier api endpoint
    $router->get('product/supplier', 'SupplierController@index');
    $router->get('product/supplier/{id}', 'SupplierController@show');
    $router->post('product/supplier', 'SupplierController@store');
    $router->put('product/supplier/{id}', 'SupplierController@update');
    $router->delete('product/supplier/{id}', 'SupplierController@destroy');
    //produxt category api endpoint
    $router->get('product/category', 'CategoryController@index');
    $router->get('product/category/{id}', 'CategoryController@show');
    $router->post('product/category', 'CategoryController@store');
    $router->put('product/category/{id}', 'CategoryController@update');
    $router->delete('product/category/{id}', 'CategoryController@destroy');
    //product api endpoint
    $router->get('product', 'ProductController@index');
    $router->post('product', 'ProductController@store');
    $router->get('product/{id}', 'ProductController@show');
    $router->put('product/{id}', 'ProductController@update');
    $router->delete('product/{id}', 'ProductController@destroy');
    $router->get('product/{id}/category', 'ProductController@category');
    $router->get('product/{id}/supplier', 'ProductController@supplier');
});
//branch related api endpoint
$router->group(['prefix' => $prefix, 'middleware' => 'auth'], function () use ($router) {
    $router->get('branch', 'BranchController@index');
    $router->get('branch/user', 'BranchController@user');
    $router->get('branch/user/{id}', 'BranchController@index');
    $router->get('branch/{id}', 'BranchController@show');
    $router->post('branch', 'BranchController@store');
    $router->put('branch/{id}', 'BranchController@update');
    $router->delete('branch/{id}', 'BranchController@destroy');
});
//company profile related api endpoint
$router->group(['prefix' => $prefix, 'middleware' => 'auth'], function () use ($router) {
    $router->get('profile', 'AppController@profile');
    $router->put('profile', 'AppController@profile');
    //$router->post('profile', 'BranchController@store');
    //$router->delete('profile', 'BranchController@destroy');
});
//warehouse related api endpoint
$router->group(['prefix' => $prefix, 'middleware' => 'auth'], function () use ($router) {
    //warehouse order api endpoint
    $router->post('warehouse/order', 'ProductOrderRequestController@store');
    $router->get('warehouse/worder', 'ProductOrderRequestController@warehouseview');
    $router->get('admin/aorder', 'ProductOrderRequestController@adminview');
    $router->put('admin/editorder', 'ProductOrderRequestController@adminedit');
    $router->put('warehouse/weditorder', 'ProductOrderRequestController@warehousedit');
    //warehouse detail api endpoint
    $router->post('detail', 'WhsDetailController@store');
    $router->post('detail', 'WhsDetailController@store');
    //warehouse api endpoint
    $router->get('warehouse', 'WarehouseController@index');
    $router->post('warehouse', 'WarehouseController@store');
    $router->get('warehouse/{id}', 'WarehouseController@show');
    $router->put('warehouse/{id}', 'WarehouseController@update');
    $router->delete('warehouse/{id}', 'WarehouseController@destroy');
});
//admin related api endpoint
$router->group(['prefix' => $prefix], function () use ($router) {
    $router->post('admin', 'ProductOrderController@store');
    $router->get('json', [WarehouseController::class, 'stockup']);
    $router->post('warehouse', 'WarehouseController@store');
});
//test
$router->group(['prefix' => $prefix], function () use ($router){
    $router->post('test','AppController@test');
    $router->get('test/{id}','AppController@test');
    $router->put('test','AppController@test');
});