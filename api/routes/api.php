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
$languages = Config::get('app.languages');

$locale = \Request::segment(1);
if (in_array($locale, $languages)) {
    \App::setLocale($locale);
} else {
    $locale = 'en';
    \App::setLocale($locale);
}

$api->version('v1', ['prefix' => $locale ], function (Router $api) {
        /*
         * PUBLIC
         */
        $api->get('lang/available', function(){return json_encode(array('status_code'=>200, 'lang'=> Config::get('app.languages')));});

        $api->get('products', '\App\Http\Controllers\Api\V1\productsController@getAllProducts');
        $api->get('product/{id}', '\App\Http\Controllers\Api\V1\productsController@getProductsDetails')->where('id', '[0-9]+');

        $api->get('category/{id}/products', '\App\Http\Controllers\Api\V1\productsController@getspecificcategoryproducts')->where('id', '[0-9]+');
        $api->get('categories', '\App\Http\Controllers\Api\V1\productsController@getAllCategories');
		$api->get('category/{id}/products', '\App\Http\Controllers\Api\V1\productsController@getProductsByCategory')->where('id', '[0-9]+');
		$api->get('category/{id}', '\App\Http\Controllers\Api\V1\productsController@getCategroyName')->where('id', '[0-9]+');
        /*
         * POST - Login and Registration
         */
        $api->post('login', 'App\Http\Controllers\Auth\LoginController@login');
        $api->post('register', 'App\Http\Controllers\Auth\RegisterController@register');

        /*
        * Protégé
        */
        $api->group(['middleware' => 'jwt.auth'], function (Router $api) {
            $api->get('token', function(){return json_encode(array('status_code'=>200, 'message'=>'Token actif'));});

            $api->get('/orders/user/{id}', '\App\Http\Controllers\Api\V1\ordersController@getAllOrders')->where('id', '[0-9]+');
            $api->get('/order/{id}', '\App\Http\Controllers\Api\V1\ordersController@getOrderContent')->where('id', '[0-9]+');
            $api->get('/orders/user/{id}/contents', '\App\Http\Controllers\Api\V1\ordersController@getAllOrderContent');

            $api->get('/basket/user/{id}', '\App\Http\Controllers\Api\V1\ordersController@getBasket')->where('id', '[0-9]+');

            $api->get('/wishlists/user/{id}', '\App\Http\Controllers\Api\V1\ordersController@getAllWishlists')->where('id', '[0-9]+');
            $api->get('/wishlist/{id}', '\App\Http\Controllers\Api\V1\ordersController@getWishlistContent')->where('id', '[0-9]+');
            $api->get('/wishlists/user/{id}/contents', '\App\Http\Controllers\Api\V1\ordersController@getAllWishlistsContent')->where('id', '[0-9]+');


            /*
             * PUT - Update des informations en db
             */
            $api->put('/orders/user/{id}', '\App\Http\Controllers\Api\V1\ordersController@createNewOrders')->where('id', '[0-9]+');


            $api->put('/basket/user/{id}', '\App\Http\Controllers\Api\V1\ordersController@putInBasket')->where('id', '[0-9]+');

            $api->put('/wishlist/user/{id}', '\App\Http\Controllers\Api\V1\ordersController@AddNewWishlist')->where('id', '[0-9]+');
            $api->put('/wishlist/{wishID}/user/{id}/content', '\App\Http\Controllers\Api\V1\ordersController@AddNewWishlistContent')->where(['id'=> '[0-9]+', 'wishID' => '[0-9]+']);

            /*
             * PATCH update existing request
             */
            $api->patch('/basket/user/{id}', '\App\Http\Controllers\Api\V1\ordersController@updateBasket')->where('id', '[0-9]+');

            $api->patch('/wishlist/{wishID}/user/{id}', '\App\Http\Controllers\Api\V1\ordersController@updateWishlist')->where(['id'=> '[0-9]+', 'wishID' => '[0-9]+']);

            /*
             * DELETE - Update des informations en db
             */
            $api->delete('/basket/user/{id}', '\App\Http\Controllers\Api\V1\ordersController@remFromBasket')->where('id', '[0-9]+');

            $api->delete('/wishlist/{wishID}/user/{id}', '\App\Http\Controllers\Api\V1\ordersController@remWishlist')->where(['id'=> '[0-9]+', 'wishID' => '[0-9]+']);
            $api->delete('/wishlist/{wishID}/user/{id}/content', '\App\Http\Controllers\Api\V1\ordersController@remWishlistContent')->where(['id'=> '[0-9]+', 'wishID' => '[0-9]+']);

        });

});

