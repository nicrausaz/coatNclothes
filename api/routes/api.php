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

        $api->get('feed/{type?}', '\App\Http\Controllers\Api\V1\feedController@getFeed');

        $api->get('lang/interface', '\App\Http\Controllers\Api\V1\Controller@getLangageInterface');
        $api->get('lang/available', function(){return json_encode(array('status_code'=>200, 'lang'=> Config::get('app.languages')));});

        $api->get('products', '\App\Http\Controllers\Api\V1\productsController@getAllProducts');
        $api->get('product/{id}', '\App\Http\Controllers\Api\V1\productsController@getProductsDetails')->where('id', '[0-9]+');
        $api->get('product/{prodID}/unrestricted', '\App\Http\Controllers\Api\V1\productsController@getProductUnrestricted')->where('prodID', '[0-9]+');
        $api->get('product/{prodID}/notes', '\App\Http\Controllers\Api\V1\productsController@getNoteForProduct')->where('prodID', '[0-9]+');
        $api->get('product/{prodID}/comments', '\App\Http\Controllers\Api\V1\productsController@getCommentForProduct')->where('prodID', '[0-9]+');


        $api->get('categories/list', '\App\Http\Controllers\Api\V1\productsController@getListCategory');
        $api->get('category/{id}/products', '\App\Http\Controllers\Api\V1\productsController@getspecificcategoryproducts')->where('id', '[0-9]+');
        $api->get('categories', '\App\Http\Controllers\Api\V1\productsController@getAllCategories');
		$api->get('category/{id}/products', '\App\Http\Controllers\Api\V1\productsController@getProductsByCategory')->where('id', '[0-9]+');
		$api->get('category/{id}', '\App\Http\Controllers\Api\V1\productsController@getCategoryName')->where('id', '[0-9]+');
		$api->get('category/{id}/subs/products', 'App\Http\Controllers\Api\V1\productsController@getProductsByCategoryAndSubs')->where('id', '[0-9]+');

		$api->get('genders/available', '\App\Http\Controllers\Api\V1\usersController@getAllGender');

        $api->get('brands', '\App\Http\Controllers\Api\V1\productsController@getAllBrands');
        $api->get('brand/{brandID}', '\App\Http\Controllers\Api\V1\productsController@getBrand')->where('brandID', '[0-9]+');

    /*
     * POST - Login and Registration
     */
        $api->post('login', 'App\Http\Controllers\Auth\LoginController@login');
        $api->post('register', 'App\Http\Controllers\Auth\RegisterController@register');

        $api->patch('logout', 'App\Http\Controllers\Auth\LoginController@logout');
        /*
        * Protégé
        */
        $api->group(['middleware' => 'jwt.auth'], function (Router $api) {
            $api->get('mail/send', '\App\Http\Controllers\Api\V1\Mail\MailController@sendRegistration');


            $api->get('token', function(){return json_encode(array('status_code'=>200, 'message'=>'Token actif'));});

            $api->get('/orders/user/{id}', '\App\Http\Controllers\Api\V1\ordersController@getAllOrders')->where('id', '[0-9]+');
            $api->get('/order/{id}', '\App\Http\Controllers\Api\V1\ordersController@getOrderContent')->where('id', '[0-9]+');
            $api->get('/orders/user/{id}/contents', '\App\Http\Controllers\Api\V1\ordersController@getAllOrderContent');
            $api->get('/order/{orderID}/pdf', '\App\Http\Controllers\Api\V1\ordersController@generateOrderPDF')->where('orderID', '[0-9]+');


            $api->get('/basket/user/{id}', '\App\Http\Controllers\Api\V1\ordersController@getBasket')->where('id', '[0-9]+');

            $api->get('/wishlists/user/{id}', '\App\Http\Controllers\Api\V1\ordersController@getAllWishlists')->where('id', '[0-9]+');
            $api->get('/wishlist/{id}', '\App\Http\Controllers\Api\V1\ordersController@getWishlistContent')->where('id', '[0-9]+');
            $api->get('/wishlists/user/{id}/contents', '\App\Http\Controllers\Api\V1\ordersController@getAllWishlistsContent')->where('id', '[0-9]+');

            $api->get('/user/{id}', '\App\Http\Controllers\Api\V1\usersController@getUserInfo')->where('id', '[0-9]+');
            $api->get('/user/{id}/adresses', '\App\Http\Controllers\Api\V1\usersController@getUserAdresses')->where('id', '[0-9]+');

            /*
             * POST - Update or add protected data
             */

            $api->post('user/{id}/pass', '\App\Http\Controllers\Api\V1\usersController@changeUserPassword')->where('id', '[0-9]+');

            $api->post('/user/{id}/pic','\App\Http\Controllers\Api\V1\usersController@updateUserPic')->where('id', '[0-9]+');
            /*
             * PUT - Update des informations en db
             */
            $api->put('user/{id}/product/{prodID}', '\App\Http\Controllers\Api\V1\productsController@addNewComment')->where(['id'=> '[0-9]+', 'prodID' => '[0-9]+']);

            $api->put('/orders/user/{id}', '\App\Http\Controllers\Api\V1\ordersController@createNewOrders')->where('id', '[0-9]+');

            $api->put('/user/{id}/adresses', '\App\Http\Controllers\Api\V1\usersController@addAdresse')->where('id', '[0-9]+');

            $api->put('/basket/user/{id}', '\App\Http\Controllers\Api\V1\ordersController@putInBasket')->where('id', '[0-9]+');

            $api->put('/wishlist/user/{id}', '\App\Http\Controllers\Api\V1\ordersController@AddNewWishlist')->where('id', '[0-9]+');
            $api->put('/wishlist/{wishID}/user/{id}/content', '\App\Http\Controllers\Api\V1\ordersController@AddNewWishlistContent')->where(['id'=> '[0-9]+', 'wishID' => '[0-9]+']);
            $api->put('/wishlist/{wishID}/addToBasket', '\App\Http\Controllers\Api\V1\ordersController@addToBasket')->where('wishID', '[0-9]+');
            /*
             * PATCH update existing request
             */
            $api->patch('/basket/user/{id}', '\App\Http\Controllers\Api\V1\ordersController@updateBasket')->where('id', '[0-9]+');

            $api->patch('/wishlist/{wishID}/user/{id}', '\App\Http\Controllers\Api\V1\ordersController@updateWishlist')->where(['id'=> '[0-9]+', 'wishID' => '[0-9]+']);

            $api->patch('/user/{id}', '\App\Http\Controllers\Api\V1\usersController@changeUserInfo')->where('id', '[0-9]+');
            $api->patch('/user/{id}/gender/{genderID}', '\App\Http\Controllers\Api\V1\usersController@changeUserGender')->where(['id'=> '[0-9]+', 'genderID' => '[0-9]+']);
            $api->patch('/user/{id}/adresse/{addrID}', '\App\Http\Controllers\Api\V1\usersController@editAdresse')->where(['id'=> '[0-9]+', 'addrID' => '[0-9]+']);

            /*
             * DELETE - Update des informations en db
             */
            $api->delete('/basket/user/{id}', '\App\Http\Controllers\Api\V1\ordersController@remFromBasket')->where('id', '[0-9]+');

            $api->delete('/wishlist/{wishID}/user/{id}', '\App\Http\Controllers\Api\V1\ordersController@remWishlist')->where(['id'=> '[0-9]+', 'wishID' => '[0-9]+']);
            $api->delete('/wishlist/{wishID}/user/{id}/content', '\App\Http\Controllers\Api\V1\ordersController@remWishlistContent')->where(['id'=> '[0-9]+', 'wishID' => '[0-9]+']);

            $api->delete('/user/{id}/adresse/{addrID}', '\App\Http\Controllers\Api\V1\usersController@remAdresse')->where(['id'=> '[0-9]+', 'addrID' => '[0-9]+']);

            $api->delete('user/{id}/pic', '\App\Http\Controllers\Api\V1\usersController@deleteUserPic')->where('id', '[0-9]+');




        });
    /*
    * ADMIN requests only -----------------------------------------------------------------------
    */

        $api->group(['prefix'=>'admin'],  function (Router $api) {
            $api->patch('product/{prodID}', '\App\Http\Controllers\Api\V1\adminController@editProduct')->where('prodID', '[0-9]+');
            $api->post('product/{prodID}/pic', '\App\Http\Controllers\Api\V1\adminController@addPicToProduct')->where('prodID', '[0-9]+');
            $api->delete('pic/{picID}', '\App\Http\Controllers\Api\V1\adminController@removePicFromProduct')->where('picID', '[0-9]+');
            $api->put('product', '\App\Http\Controllers\Api\V1\adminController@addProduct');
            $api->delete('brand/{brandID}', '\App\Http\Controllers\Api\V1\adminController@removeBrand')->where('brandID', '[0-9]+');
            $api->put('brand', '\App\Http\Controllers\Api\V1\adminController@addBrand');
            $api->get('orders', '\App\Http\Controllers\Api\V1\adminController@getAllOrders');
            $api->patch('user/{id}', '\App\Http\Controllers\Api\V1\adminController@editUser')->where('id', '[0-9]+');
            $api->get('users', '\App\Http\Controllers\Api\V1\adminController@getAllUsers');
            $api->get('user/{id}/orders', '\App\Http\Controllers\Api\V1\adminController@getOrdersByUser')->where('id', '[0-9]+');
            $api->get('user/{id}', '\App\Http\Controllers\Api\V1\adminController@getUserInfo')->where('id', '[0-9]+');
            $api->get('user/{id}/adresses', '\App\Http\Controllers\Api\V1\adminController@getUserAdress')->where('id', '[0-9]+');
            $api->get('address/{addrID}', '\App\Http\Controllers\Api\V1\adminController@getAdress')->where('addrID', '[0-9]+');

            $api->delete('product/{prodID}', '\App\Http\Controllers\Api\V1\adminController@removeProduct')->where('prodID', '[0-9]+');
            $api->get('order/{orderID}', '\App\Http\Controllers\Api\V1\adminController@getOrderContent')->where('orderID', '[0-9]+');
            $api->get('orders/status/available', '\App\Http\Controllers\Api\V1\adminController@getOrderStateAvailable');
            $api->patch('order/{orderID}/status/{stateID}', '\App\Http\Controllers\Api\V1\adminController@editOrderState')->where(['stateID'=> '[0-9]+', 'orderID' => '[0-9]+']);
            $api->patch('order/{orderID}/paid', '\App\Http\Controllers\Api\V1\adminController@paidOrder')->where(['orderID' => '[0-9]+']);
            $api->put('category', '\App\Http\Controllers\Api\V1\adminController@addCategory');
            $api->patch('category/{catID}', '\App\Http\Controllers\Api\V1\adminController@editCategory')->where(['catID' => '[0-9]+']);


        });
});

