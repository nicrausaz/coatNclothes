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

$api->version('v1',  function (Router $api) {

        /*
         * PUBLIC
         */

        $api->get('products', '\App\Http\Controllers\Api\V1\productsController@getAllProducts');
        $api->get('product/{id}', '\App\Http\Controllers\Api\V1\productsController@getProductsDetails');

        $api->get('category/{id}/products', '\App\Http\Controllers\Api\V1\productsController@getspecificcategoryproducts');
        $api->get('categories', '\App\Http\Controllers\Api\V1\productsController@getAllCategories');
        $api->get('categories2', '\App\Http\Controllers\Api\V1\productsController@getAllCategories2');
		$api->get('category/{id}/products', '\App\Http\Controllers\Api\V1\productsController@getProductsByCategory');
		$api->get('category/{id}', '\App\Http\Controllers\Api\V1\productsController@getCategroyName');
        /*
         * POST - Login and Registration
         */
        $api->post('login', 'App\Http\Controllers\Auth\LoginController@login');
        $api->post('register', 'App\Http\Controllers\Auth\RegisterController@register');

        /*
        * Protégé
        */
        $api->group(['middleware' => 'jwt.auth'], function (Router $api) {
            $api->get('/orders/user/{id}', '\App\Http\Controllers\Api\V1\ordersController@getAllOrders');
            $api->get('/order/{id}', '\App\Http\Controllers\Api\V1\ordersController@getOrderContent');
            $api->get('/orders/user/{id}/contents', '\App\Http\Controllers\Api\V1\ordersController@getAllOrderContent');

            $api->get('/basket/user/{id}', '\App\Http\Controllers\Api\V1\ordersController@getBasket');

            $api->get('/wishlists/user/{id}', '\App\Http\Controllers\Api\V1\ordersController@getAllWishlists');
            $api->get('/wishlist/{id}', '\App\Http\Controllers\Api\V1\ordersController@getWishlistContent');
            $api->get('/wishlists/user/{id}/contents', '\App\Http\Controllers\Api\V1\ordersController@getAllWishlistsContent');


            /*
             * PUT - Update des informations en db
             */
            $api->put('/basket/user/{id}', '\App\Http\Controllers\Api\V1\ordersController@putInBasket');


        });

});

