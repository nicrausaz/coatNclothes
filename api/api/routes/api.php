<?php

use Illuminate\Http\Request;
use Dingo\Api\Routing\Router;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function (Router $api) {
		$api->get('test', function(){return "Hello World !";});
        $api->get('products', '\App\Http\Controllers\Api\V1\productsController@getAllProducts');
        $api->get('product/{id}', '\App\Http\Controllers\Api\V1\productsController@getProductsDetails');
        $api->get('category/{id}/products', '\App\Http\Controllers\Api\V1\productsController@getspecificcategoryproducts');
        $api->get('categories', '\App\Http\Controllers\Api\V1\productsController@getAllCategories');
        $api->get('categories2', '\App\Http\Controllers\Api\V1\productsController@getAllCategories2');


});
