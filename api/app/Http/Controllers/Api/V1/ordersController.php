<?php
namespace App\Http\Controllers\Api\V1;

use Dingo\Api\Contract\Http\Request;
use Dingo\Api\Http\Response;
use Dingo\Api\Routing\Helpers;
use Illuminate\Routing\Controller;
use Lang;


class ordersController extends Controller
{
    //use Lang;
    use Helpers;

    /*****************************
     *
     * Orders
     *
     */

    public function getAllOrders(Request $request, $id){
        $this->checkTokenFromId($id);

        $orders = \DB::select('SELECT * FROM TB_Orders WHERE fk_users_id = ?', [$id]);
        return json_encode($orders);
    }

    public function getOrderContent(Request $request, $id){
        $this->checkTokenFromId($id);

        $ordersContent = \DB::select('SELECT * FROM `TB_OrdersContent` WHERE fk_orders_id = ?', [$id]);
        return json_encode($ordersContent);
    }

    public function getAllOrderContent(Request $request, $id){
        $this->checkTokenFromId($id);

        $orders = \DB::select('SELECT * FROM TB_Orders WHERE fk_users_id = ?', [$id]);
        foreach($orders as $key => $value){
            $ordersContent = \DB::select('SELECT * FROM `TB_OrdersContent` WHERE fk_orders_id = ?', [$orders[$key]->orders_id]);
            $orders[$key]->ordersContent=$ordersContent;
        }
        return json_encode($orders);
    }
    public function createNewOrders(Request $request, $id){
        $this->checkTokenFromId($id);

        $input =$request->all();
        if(!is_array($input)){
            \Log::error('Bad arg type for order input | user: '.$id);
            abort(403, lang::get('errors.notAuthorized'));
        }
        //Create new order
        try {
            $orderID = \DB::table('TB_Orders')->insertGetId(
                ['fk_users_id' => $id]
            );
        }
        catch (\PDOException $e) {
            \Log::error($e->getMessage());
            abort(403, lang::get('errors.uknError'));
        }

        foreach ($input as $key => $value){

            if(empty($value['quantity'])OR empty($value['product'])){
                \Log::error('missing argument for basket put | user: '.$id);
                self::deleteOrderAndSub($orderID);
                abort(403, lang::get('orders.missingArgument'));
            }
            if(!is_numeric($value['quantity'])OR !is_numeric($value['product'])){
                \Log::error('Bad arg type for input | user: '.$id);
                self::deleteOrderAndSub($orderID);
                abort(403, lang::get('errors.notAuthorized'));
            }
            if((isset($value['size']))OR(!empty($value['size']))){
                if(!is_numeric($value['size'])){
                    $getSizeId= \DB::select('SELECT productsSize_id FROM `TB_ProductsSize` WHERE `productsSize_value` LIKE ? AND `fk_products_id` = ?', [$value['size'], $value['product']]);
                    if(!empty($getSizeId[0]->productsSize_id)){
                        $size=$getSizeId[0]->productsSize_id;
                    }else{
                        \Log::error('Conflict, size given is not existing | user: '.$id);
                        self::deleteOrderAndSub($orderID);
                        abort(409, lang::get('errors.conflict'));
                    }
                }else{
                    \Log::error('Bad arg type for input size | user: '.$id);
                    self::deleteOrderAndSub($orderID);
                    abort(403, lang::get('errors.notAuthorized'));
                }
            }else{
                $size=NULL;
            }

            try {
                \DB::table('TB_OrdersContent')->insert([
                    ['ordersContent_quantity' => $value['quantity'], 'fk_products_id' => $value['product'], 'fk_orders_id'=>$orderID, 'fk_productsSize_id'=>$size]
                ]);
            }
            catch (\PDOException $e) {
                \Log::error($e->getMessage());
                self::deleteOrderAndSub($orderID);
                abort(403, lang::get('errors.uknError'));
            }

        }
        return $this->response->array([
            'status_code' => 200,
            'message' => lang::get('orders.OrdersSuccess')
        ]);



        //return array(array('product'=>1, 'quantity' => 5, 'size' => 'L'), array('product'=>3, 'quantity' => 6, 'size' => 'S'));
    }
    private function deleteOrderAndSub($orderID){
        return \DB::delete('DELETE FROM TB_Orders WHERE orders_id = ?', [$orderID]);
    }

    /*****************************
     *
     * Basket
     *
     */
    public function getBasket(Request $request, $id){
        $this->checkTokenFromId($id);

        $basket = \DB::select('SELECT basket_id, basket_quantity, fk_products_id as products_id, fk_productsSize_id FROM TB_Basket WHERE fk_users_id = ?', [$id]);
        foreach($basket as $key => $value){
            if($value->fk_productsSize_id==NULL){
                $basket[$key]->fk_productsSize_id=NULL;
            }else{
                $gotSize=\DB::select('SELECT productsSize_value FROM TB_ProductsSize WHERE productsSize_id = ?', [$value->fk_productsSize_id]);

                if(!empty($gotSize[0]->productsSize_value)){
                    $basket[$key]->fk_productsSize_id=$gotSize[0]->productsSize_value;
                }else{
                    \Log::error('Error on productsSize DB  | user: '.$id.' | product:'.$basket[$key]->fk_productsSize_id);
                    abort(409, lang::get('errors.InternalErrorOnDB'));
                }
            }
        }

        return json_encode($basket);

    }
    public function updateBasket(Request $request, $id){
        $this->checkTokenFromId($id);
        $input = $request->all();
        if(empty($input['basketItemID'])){
            \Log::error('missing basketItemID for basket update | user: '.$id);
            abort(403, lang::get('orders.missingArgument'));
        }else{
            if(!is_numeric($input['basketItemID'])){
                \Log::error('Bad arg type for update | user: '.$id);
                abort(403, lang::get('errors.notAuthorized'));
            }
        }
        if(empty($input['quantity'])AND empty($input['size'])){
            \Log::error('missing argument for basket update | user: '.$id);
            abort(403, lang::get('orders.missingArgument'));
        }

        $getBackExisting=\DB::select('SELECT * FROM TB_Basket WHERE basket_id = ?', [$input['basketItemID']]);
        if(!empty($input['quantity'])){
            if(is_numeric($input['quantity'])){
                $quantity=$input['quantity'];
            }else{
                \Log::error('Bad arg type for update | user: '.$id);
                abort(403, lang::get('errors.notAuthorized'));
            }
        }else{
            $quantity=$getBackExisting[0]->basket_quantity;
        }
        if(!empty($input['size'])){
            if(!is_numeric($input['size'])){
                $getSizeId= \DB::select('SELECT productsSize_id FROM `TB_ProductsSize` WHERE `productsSize_value` LIKE ? AND `fk_products_id` = ?', [$input['size'], $getBackExisting[0]->fk_products_id]);
                if(!empty($getSizeId[0]->productsSize_id)){
                    $size=$getSizeId[0]->productsSize_id;
                }else{
                    \Log::error('Conflict, size given is not existing | user: '.$id);
                    abort(409, lang::get('errors.conflict'));
                }
            }else{
                \Log::error('Bad arg type for input size | user: '.$id);
                abort(403, lang::get('errors.notAuthorized'));
            }
        }else{
            $size=$getBackExisting[0]->fk_productsSize_id;
        }

        try {
            \DB::table('TB_Basket')->where(['basket_id'=> $input['basketItemID'], 'fk_users_id'=> $id])->update(
                ['basket_quantity' => $quantity, 'fk_productsSize_id' => $size]
            );
        }
        catch (\PDOException $e) {
            \Log::error($e->getMessage());
            abort(403, lang::get('errors.uknError'));
        }
        return $this->response->array([
            'status_code' => 200,
            'message' => lang::get('orders.updatedBasket')
        ]);

    }
    public function putInBasket(Request $request, $id){
        $this->checkTokenFromId($id);

        $input = $request->all();
        if(empty($input['quantity'])OR empty($input['product'])){
            \Log::error('missing argument for basket put | user: '.$id);
            abort(403, lang::get('orders.missingArgument'));
        }
        if(!is_numeric($input['quantity'])OR !is_numeric($input['product'])){
            \Log::error('Bad arg type for input | user: '.$id);
            abort(403, lang::get('errors.notAuthorized'));
        }
        if((isset($input['size']))OR(!empty($input['size']))){
            if(!is_numeric($input['size'])){
                $getSizeId= \DB::select('SELECT productsSize_id FROM `TB_ProductsSize` WHERE `productsSize_value` LIKE ? AND `fk_products_id` = ?', [$input['size'], $input['product']]);
                if(!empty($getSizeId[0]->productsSize_id)){
                    $size=$getSizeId[0]->productsSize_id;
                }else{
                    \Log::error('Conflict, size given is not existing | user: '.$id);
                    abort(409, lang::get('errors.conflict'));
                }
            }else{
                \Log::error('Bad arg type for input size | user: '.$id);
                abort(403, lang::get('errors.notAuthorized'));
            }
        }else{
            $size=NULL;
        }

        $number = \DB::select('SELECT count(basket_id) as number FROM `TB_Basket` WHERE fk_users_id = ? AND fk_products_id = ? ', [$id, $input['product']]);

        if($number[0]->number >= 1){
            abort(409, lang::get('orders.alreadinIn'));
        }
        try {
            \DB::table('TB_Basket')->insert(
                ['basket_quantity' => $input['quantity'], 'fk_productsSize_id' => $size, 'fk_users_id' => $id, 'fk_products_id' => $input['product']]
            );
        }
        catch (\PDOException $e) {
            \Log::error($e->getMessage());
            abort(403, lang::get('errors.uknError'));
        }
        return $this->response->array([
            'status_code' => 200,
            'message' => lang::get('orders.addToBasket')
        ]);
    }
    public function remFromBasket(Request $request, $id){
        $this->checkTokenFromId($id);

        $input = $request->all();

        if(!is_numeric($input['product'])){
            \Log::error('Bad arg type for input | user: '.$id);
            abort(403, lang::get('errors.notAuthorized'));
        }
        try {
            \DB::select('DELETE FROM `TB_Basket` WHERE `fk_users_id` = ? AND `fk_products_id` = ?;', [$id, $input['product']]);
        }
        catch (\PDOException $e) {
            \Log::error($e->getMessage());
            abort(403, lang::get('errors.uknError'));
        }
        return $this->response->array([
            'status_code' => 200,
            'message' => lang::get('orders.remFromBasket')
        ]);
    }
    /*****************************
     *
     * Wishlists
     *
     */
    public function getAllWishlists(Request $request, $id){
        $this->checkTokenFromId($id);

        $orders = \DB::select('SELECT * FROM TB_Wishlist WHERE fk_users_id = ?', [$id]);
        return json_encode($orders);
    }
    public function getWishlistContent(Request $request, $id){
        $this->checkTokenFromId($id);

        $ordersContent = \DB::select('SELECT * FROM `TB_WishlistContent` WHERE fk_wishlist_id = ?', [$id]);
        return json_encode($ordersContent);
    }
    public function getAllWishlistsContent(Request $request, $id){
        $this->checkTokenFromId($id);

        $orders = \DB::select('SELECT * FROM TB_Wishlist WHERE fk_users_id = ?', [$id]);
        foreach($orders as $key => $value){
            $ordersContent = \DB::select('SELECT * FROM `TB_WishlistContent` WHERE fk_wishlist_id = ?', [$orders[$key]->wishlist_id]);
            $orders[$key]->ordersContent=$ordersContent;
        }
        return json_encode($orders);
    }
    public function AddNewWishlist(Request $request, $id){
        $this->checkTokenFromId($id);
        $input = $request->all();
        $pattern ='/^[a-zA-Z0-9#-][a-zA-Z0-9éèöüàäïâôûù\\\'\/"*_ . -\#]+$/';

        if(empty($input['name'])){
            \Log::error('missing argument for wishlist creation | user: '.$id);
            abort(403, lang::get('orders.missingArgument'));
        }
        if(!empty($input['description'])){
            $description = $input['description'];
        }else $description = NULL;
        if(!preg_match($pattern, $input['name'])){
            \Log::error('characters for title not authorized | user: '.$id);
            abort(403, lang::get('errors.charNotAuthorized'));
        }
        $getExisting = \DB::select('SELECT * FROM TB_Wishlist WHERE fk_users_id = ? AND wishlist_name= ?', [$id, $input['name']]);
        if(!empty($getExisting)){
            abort(409, lang::get('orders.wishAlreadinIn'));
        }
        try {
            \DB::insert('INSERT INTO TB_Wishlist(`wishlist_name`, `wishlist_description`, `fk_users_id`) VALUES (?, ?, ?)', [$input['name'], $description, $id]);
        }
        catch (\PDOException $e) {
            \Log::error($e->getMessage());
            abort(403, lang::get('errors.uknError'));
        }
        return $this->response->array([
            'status_code' => 200,
            'message' => lang::get('orders.creatWishSuccess')
        ]);
    }
    public function remWishlist(Request $request,  $wishID, $id){
        $this->checkTokenFromId($id);


        try {
            \DB::delete('DELETE FROM `TB_Wishlist` WHERE `fk_users_id` = ? AND `wishlist_id` = ?;', [$id, $wishID]);
        }
        catch (\PDOException $e) {
            \Log::error($e->getMessage());
            abort(403, lang::get('errors.uknError'));
        }
        return $this->response->array([
            'status_code' => 200,
            'message' => lang::get('orders.remFromWish')
        ]);

    }
    public function updateWishlist(Request $request, $wishID, $id){
        $this->checkTokenFromId($id);
        $input = $request->all();
        $pattern ='/^[a-zA-Z0-9#-][a-zA-Z0-9éèöüàäïâôûù\\\'\/"*_ . -\#]+$/';

        if((empty($input['name']))AND(empty($input['description']))){
            \Log::error('missing argument for wishlist edition | user: '.$id);
            abort(403, lang::get('orders.missingArgument'));
        }
        $getExisting = \DB::select('SELECT * FROM TB_Wishlist WHERE fk_users_id = ? AND wishlist_id= ?', [$id, $wishID]);
        if(empty($getExisting)){
            \Log::error('Trying to edit an non existent wishlist | user: '.$id.' wishID: '.$wishID);
            abort(403, lang::get('errors.notAuthorized'));
        }
        if(!empty($input['name'])) {
            if (!preg_match($pattern, $input['name'])) {
                \Log::error('characters for title not authorized | user: ' . $id);
                abort(403, lang::get('errors.charNotAuthorized'));
            }
            $name = $input['name'];
        }else{
            $name=$getExisting[0]->wishlist_name;
        }
        if(!empty($input['description'])) {

            $description = $input['description'];
        }else{
            $description=$getExisting[0]->wishlist_description;
        }

        try {
            \DB::update('UPDATE `TB_Wishlist` SET `wishlist_name` = ?, `wishlist_description`=? WHERE `TB_Wishlist`.`wishlist_id` = ?; ', [$name, $description, $wishID]);
        }
        catch (\PDOException $e) {
            \Log::error($e->getMessage());
            abort(403, lang::get('errors.uknError'));
        }
        return $this->response->array([
            'status_code' => 200,
            'message' => lang::get('orders.updatedWishSuccess')
        ]);
    }
    public function AddNewWishlistContent(Request $request, $wishID, $id){
        $this->checkTokenFromId($id);
        $input = $request->all();
        if((empty($input['product']))){
            \Log::error('missing argument for wishlist content put | user: '.$id);
            abort(403, lang::get('orders.missingArgument'));
        }
        if(!is_numeric($input['product'])){
            \Log::error('Bad arg type for input | user: '.$id);
            abort(403, lang::get('errors.notAuthorized'));
        }
        $checkExistingWish = \DB::select('SELECT count(wishlist_id) as number FROM TB_Wishlist WHERE fk_users_id = ? AND wishlist_id = ?', [$id, $wishID]);
        if($checkExistingWish[0]->number < 1){
            abort(409, lang::get('orders.WishNotExistOrNoRight'));
        }
        $number = \DB::select('SELECT count(wishlistContent_id) as number FROM `TB_WishlistContent` WHERE fk_products_id = ? AND fk_wishlist_id = ?', [$input['product'], $wishID]);

        if($number[0]->number >= 1){
            abort(409, lang::get('orders.alreadinIn'));
        }

        try {
            \DB::table('TB_WishlistContent')->insert(
                ['fk_wishlist_id' => $wishID, 'fk_products_id' => $input['product']]
            );
        }
        catch (\PDOException $e) {
            \Log::error($e->getMessage());
            abort(403, lang::get('errors.uknError'));
        }
        return $this->response->array([
            'status_code' => 200,
            'message' => lang::get('orders.updatedWishSuccess')
        ]);
    }

    public function remWishlistContent(Request $request, $wishID, $id){
        $this->checkTokenFromId($id);
        $input = $request->all();
        if(empty($input['product'])){
            \Log::error('missing argument for wishlist content delete | user: '.$id);
            abort(403, lang::get('orders.missingArgument'));
        }


        $checkExistingWish = \DB::select('SELECT count(wishlist_id) as number FROM TB_Wishlist WHERE fk_users_id = ? AND wishlist_id = ?', [$id, $wishID]);
        if($checkExistingWish[0]->number < 1){
            abort(409, lang::get('orders.WishNotExistOrNoRight'));
        }

        $number = \DB::select('SELECT count(wishlistContent_id) as number FROM `TB_WishlistContent` WHERE fk_products_id = ? AND fk_wishlist_id = ?', [$input['product'], $wishID]);

        if($number[0]->number < 1){
            abort(409, lang::get('orders.notIN'));
        }


        try {
            \DB::delete('DELETE FROM `TB_WishlistContent` WHERE `fk_products_id` = ? AND `fk_wishlist_id` = ?;', [$input['product'], $wishID]);

        }
        catch (\PDOException $e) {
            \Log::error($e->getMessage());
            abort(403, lang::get('errors.uknError'));
        }
        return $this->response->array([
            'status_code' => 200,
            'message' => lang::get('orders.successRemFromWish')
        ]);

    }

}
