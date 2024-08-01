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
    return view('welcome');
});

// Route::prefix('api')->group(function () {
//     Route::get('product', [products::class, 'index'])->name('user.index');
// });

//  API Version beta 3.5.5.2

$prefix = 'api/';
//user relatet api endpoint
$router->group(['prefix' => $prefix], function () use ($router) {$router->post('login', 'UserController@login');});
$router->group(['prefix' => $prefix, 'middleware' => 'auth'], function () use ($router) {
    $router->get('user/', 'UserController@getUser');
    $router->get('user/all', 'UserController@getAllUser');
    $router->post('register',  'UserController@register');
    $router->get('user/trash', 'UserController@trash');
    $router->delete('user/trash', 'UserController@delete');
    $router->post('user/trash/delete', 'UserController@delete');
    $router->get('user/trash/restore/all', 'UserController@restoreAll');
    $router->put('user/{id}/password/reset', 'UserController@resetPassword');
    $router->post('user/trash/restore', 'UserController@restore');
    $router->put('user/password/reset', 'UserController@resetPassword');
    $router->put('user/{id}/password', 'UserController@updatePassword');
    $router->get('user/trash/{id}', 'UserController@trash');
    $router->put('user/password', 'UserController@updatePassword');
    $router->delete('user/{id}', 'UserController@destroy');
    $router->get('user/{id}', 'UserController@getUser');
    $router->put('user/{id}', 'UserController@update');
    $router->put('user/', 'UserController@update');
    //role related
    $router->get('role/', 'RoleController@index');
    $router->get('role/trash', 'RoleController@trash');
    $router->get('role/deleted', 'RoleController@index');
    $router->post('role/trash/delete', 'RoleController@delete');
    $router->delete('role/trash', 'RoleController@delete');
    $router->get('role/trash/restore/all', 'RoleController@restoreAll');
    $router->get('role/{id}/permision', 'PermisionController@viewrole');
    $router->post('role/trash/restore', 'RoleController@restore');
    $router->get('role/trash/{id}', 'RoleController@trash');
    $router->get('permision/{id}', 'PermisionController@view');
    $router->delete('role/{id}', 'RoleController@destroy');
    $router->get('permision/', 'PermisionController@index');
    $router->get('role/{id}', 'RoleController@index');
    $router->put('role/{id}', 'RoleController@update');
    $router->post('role/', 'RoleController@store');
});
//product related api endpoint
$router->group(['prefix' =>$prefix, 'middleware' => 'auth'], function () use ($router) {
    //product request api endpoint
    $router->get('branch/request', 'ProductRequestController@index');
    $router->get('branch/request/trash', 'ProductRequestController@trash');
    $router->post('branch/request/trash/delete','ProductRequestController@delete');
    $router->delete('branch/request/trash', 'ProductRequestController@delete');
    $router->get('branch/request/trash/restore/all', 'ProductRequestController@restoreAll');
    $router->post('branch/request/trash/restore', 'ProductRequestController@restore');
    $router->get('branch/request/trash/{id}', 'ProductRequestController@trash');
    $router->get('branch/request/{id}', 'ProductRequestController@show');
    $router->post('branch/request', 'ProductRequestController@store');
    $router->post('branch/request/accept', 'ProductRequestController@accept');
    $router->post('branch/request/decline', 'ProductRequestController@decline');
    $router->put('branch/request/{id}', 'ProductRequestController@update');
    $router->get('branch/request/{productCode}/{stock}', 'ProductRequestController@showStock');
    $router->delete('branch/request/{id}', 'ProductRequestController@destroy');
    //product supplier api endpoint
    $router->get('product/supplier', 'SupplierController@index');
    $router->get('product/supplier/trash', 'SupplierController@trash');
    $router->post('product/supplier/trash/delete','SupplierController@delete');
    $router->delete('product/supplier/trash', 'SupplierController@delete');
    $router->get('product/supplier/trash/restore/all', 'SupplierController@restoreAll');
    $router->post('product/supplier/trash/restore', 'SupplierController@restore');
    $router->get('product/supplier/trash/{id}', 'SupplierController@trash');
    $router->get('product/supplier/{id}', 'SupplierController@show');
    $router->post('product/supplier/name', 'SupplierController@showByName'); //SEARCH NAME
    $router->post('product/supplier', 'SupplierController@store');
    $router->put('product/supplier/{id}', 'SupplierController@update');
    $router->delete('product/supplier/{id}', 'SupplierController@destroy');
    //produxt category api endpoint
    $router->get('product/category', 'CategoryController@index');
    $router->get('product/category/trash', 'CategoryController@trash');
    $router->post('product/category/trash/delete','CategoryController@delete');
    $router->delete('product/category/trash', 'CategoryController@delete');
    $router->get('product/category/trash/restore/all', 'CategoryController@restoreAll');
    $router->post('product/category/trash/restore', 'CategoryController@restore');
    $router->get('product/category/trash/{id}', 'CategoryController@trash');
    $router->get('product/category/{id}', 'CategoryController@show');
    $router->post('product/category', 'CategoryController@store');
    $router->put('product/category/{id}', 'CategoryController@update');
    $router->delete('product/category/{id}', 'CategoryController@destroy');
    //product order api endpoint
    $router->get('product/order', 'ProductOrderController@index');
    $router->get('product/order/all/{Code}', 'ProductOrderController@getProduct');
    $router->post('product/order', 'ProductOrderController@store');
    $router->post('product/order/distribute/{orderid}', 'ProductOrderController@distribute');
    //product response order api endpoint
    $router->get('order/response', 'ResponseOrderController@index');
    $router->post('order/response', 'ResponseOrderController@accept');
    $router->put('order/response', 'ResponseOrderController@position');
    //product api endpoint
    $router->get('product', 'ProductController@index');
    $router->post('product', 'ProductController@store');
    $router->get('product/trash', 'ProductController@trash');
    $router->post('product/trash/delete', 'ProductController@delete');
    $router->delete('product/trash', 'ProductController@delete');
    $router->get('product/trash/restore/all', 'ProductController@restoreAll');
    $router->post('product/trash/restore', 'ProductController@restore');
    $router->post('product/search', 'ProductController@showByName'); //SEARCH NAME
    $router->get('product/trash/{id}', 'ProductController@trash');
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
    $router->get('branch/trash', 'BranchController@trash');
    $router->get('branch/user/{id}', 'BranchController@index');
    $router->post('branch/trash/delete', 'BranchController@delete');
    $router->delete('branch/trash', 'BranchController@delete');
    $router->get('branch/trash/restore/all', 'BranchController@restoreAll');
    $router->post('branch/trash/restore', 'BranchController@restore');
    $router->get('branch/trash/{id}', 'BranchController@trash');
    $router->get('branch/{id}', 'BranchController@show');
    $router->post('branch/search', 'BranchController@showByName');
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
    //warehouse order Request api endpoint
    $router->get('warehouse/trash', 'ProductOrderRequestController@trash');
    $router->post('warehouse/trash/delete','ProductOrderRequestController@delete');
    $router->delete('warehouse/trash', 'ProductOrderRequestController@delete');
    $router->get('warehouse/trash/restore/all', 'ProductOrderRequestController@restoreAll');
    $router->post('warehouse/trash/restore', 'ProductOrderRequestController@restore');
    $router->get('warehouse/trash/{id}', 'ProductOrderRequestController@trash');
    $router->get('warehouse/request', 'ProductOrderRequestController@index');
    $router->get('warehouse/request/status', 'ProductOrderRequestController@getResponse');
    $router->post('warehouse/request', 'ProductOrderRequestController@store');
    $router->put('warehouse/request', 'ProductOrderRequestController@edit');
    $router->post('warehouse/request/accept', 'ProductOrderRequestController@accept');
    $router->post('warehouse/request/decline', 'ProductOrderRequestController@decline');
    //warehouse response api endpoint
    $router->get('warehouse/response', 'WarehouseResponseBranchController@index');
    $router->post('warehouse/response', 'WarehouseResponseBranchController@store');
    $router->get('warehouse/response/{request_id}', 'WarehouseResponseBranchController@getResponse');
    
});
$router->group(['prefix' => $prefix, 'middleware' => 'auth'], function () use ($router){
    //warehouse detail api endpoint
    $router->get('warehouse/batch', 'BatchController@index');
    $router->post('warehouse/batch', 'BatchController@store');
    $router->put('warehouse/batch', 'BatchController@checkExpired');
    $router->get('warehouse/batch/{Code}', 'BatchController@getProduct');
    //warehouse detail api endpoint
    $router->get('warehouse/detail', 'WhsDetailController@index');
    $router->post('warehouse/detail', 'WhsDetailController@store');
    $router->get('warehouse/detail/{id}', 'WhsDetailController@showEachWarehouse');
    //warehouse api endpoint
    // $router->put('warehouse/expired', 'BatchController@checkExpired');
    $router->put('warehouse/stock', 'WarehouseController@updateStock');
    $router->get('warehouse/product/{productCode}', 'WarehouseController@showProduct');
    $router->get('warehouse/product', 'WarehouseController@productInWarehouse');
    $router->post('warehouse/product', 'WarehouseController@productNameInWarehouse');
    $router->get('warehouse/{id}', 'WarehouseController@show');
    $router->put('warehouse/{id}', 'WarehouseController@update');
    $router->delete('warehouse/{id}', 'WarehouseController@destroy');
    $router->post('warehouse', 'WarehouseController@store');
    $router->get('warehouse', 'WarehouseController@index');
});
$router->group(['prefix' => $prefix, 'middleware' => 'auth'], function () use ($router){
    $router->post('upload','DailyReportController@store');
    $router->get('upload','DailyReportController@getDownload');
});
//test
$router->group(['prefix' => $prefix], function () use ($router){
    $router->post('test','BatchController@store');
    $router->get('test','ResponseOrderController@test');
    // $router->get('test','BatchController@checkExpired');
    // $router->get('test','WarehouseController@checkExpired');
    $router->put('test','AppController@test');
    $router->delete('test','AppController@test');
});