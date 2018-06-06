<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Mail\MailController;
use Dingo\Api\Contract\Http\Request;
use Dingo\Api\Http\Response;
use Dingo\Api\Routing\Helpers;
use Lang;
use PDF;


class ordersController extends Controller
{
    use Helpers;

    /*****************************
     *
     * Orders
     *
     */

    public function getAllOrders($id){
        $this->checkTokenFromId($id);

        $orders = \DB::select('SELECT * FROM `TB_Orders` o INNER JOIN TB_OrdersStatus os ON os.ordersStatus_id = o.fk_ordersStatus_id where o.fk_users_id = ? ORDER BY o.orders_createdDate DESC', [$id]);
        foreach ($orders as $key=>$value){
            $orders[$key]->ordersStatus_name=$this->getTranslation($value->ordersStatus_name);
            if($value->orders_paidDate==NULL)$paid=0;else$paid=1;
            $orders[$key]->orders_paid=$paid;
        }


        return $orders;
    }
    public function getOrderContent($id){

        $ordersContent = \DB::select('SELECT * FROM `TB_OrdersContent` WHERE fk_orders_id = ? ', [$id]);

        foreach ($ordersContent as $key=> $value){
            $size=\DB::select('SELECT * FROM TB_ProductsSize WHERE productsSize_id = ?', [$value->fk_productsSize_id]);
            $ordersContent[$key]->productsSize_value=$size[0]->productsSize_value;
        }
        return json_encode($ordersContent);
    }
    public function generateOrderPDF($orderID){
        $order = \DB::select('SELECT * FROM TB_Orders WHERE orders_id = ?', [$orderID]);
        if(empty($order[0])){
            \Log::error('order not existent');
            abort(403, lang::get('orders.emtpyOrder'));
        }

        $data=array('keys'=>array(),'values'=>array());
        $data['keys']=(object)array(
            'local'=>\App::getLocale(),
            'bill'=>lang::get('view.bill'),
            'id'=>$orderID,
            'orders_id'=>lang::get('view.id'),
            'orders_name'=>lang::get('view.name'),
            'orders_quantity'=>lang::get('view.quantity'),
            'orders_price'=>lang::get('view.price'),
            'orders_priceTotal'=>lang::get('view.priceTotal'),
            'total'=>lang::get('view.total'),
            'footer'=>lang::get('view.footer')
            );

        $adresse=\DB::select('select * FROM TB_Adresses WHERE adresses_id = ?', [$order[0]->fk_adresses_id]);

        $data['values']['custommer']=(object)array(
            'users_completeName'=>\Auth::user()->users_fsname.' '.\Auth::user()->users_name,
            'adresses_street'=>$adresse[0]->adresses_street,
            'adresses_locality'=>$adresse[0]->adresses_locality,
            'adresses_npa'=>$adresse[0]->adresses_npa,
            'adresses_state'=>$adresse[0]->adresses_state
            );

        $orderContent=\DB::select('SELECT * FROM TB_OrdersContent WHERE fk_orders_id = ?', [$orderID]);

        $total=0;
        foreach ($orderContent as $key => $value){
            $product=\DB::select('SELECT * FROM TB_Products WHERE products_id = ?', [$value->fk_products_id]);
            $data['values']['products'][]=(object)array(
                'products_id'=>$value->fk_products_id,
                'products_name'=>self::getTranslation($product[0]->products_name),
                'orders_quantity'=>$value->ordersContent_quantity,
                'orders_price'=>$product[0]->products_price,
                'orders_priceTotal'=>($product[0]->products_price*$value->ordersContent_quantity)
            );
            $total=$total+($product[0]->products_price*$value->ordersContent_quantity);
        }

        $data['values']['total']=$total;
        $pdf= PDF::loadView('pdf.invoice', compact('data'));
        $pdf->setPaper('A4');
        return $pdf->stream('invoice.pdf');
    }
    public function getAllOrderContent($id){
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

        if(empty($input['data'])){
            \Log::error('command with an empty array | user: '.$id);
            abort(403, lang::get('orders.emtpyOrder'));
        }
        //Create new order
        if(isset($input['adresses_id'])) {
            if ((is_numeric($input['adresses_id'])) AND (!empty($input['adresses_id']))) {
                $back = \DB::select('SELECT count(adresses_id) AS count FROM TB_Adresses WHERE fk_users_id = ? AND adresses_id = ? AND adresses_dlDate IS NULL', [$id, $input['adresses_id']]);
                if($back[0]->count != 1){
                    \Log::error('command with a non existent adresse | user: '.$id);
                    abort(403, lang::get('errors.notAuthorized'));
                }
            }else{
                \Log::error('command with empty adresse | user: '.$id);
                abort(403, lang::get('orders.emptyAdress'));
            }
        }else{
            \Log::error('command with empty adresse | user: '.$id);
            abort(403, lang::get('orders.emptyAdress'));
        }
        try {
            $orderID = \DB::table('TB_Orders')->insertGetId(
                ['fk_users_id' => $id, 'fk_adresses_id' => $input['adresses_id']]
            );
        }
        catch (\PDOException $e) {
            \Log::error($e->getMessage());
            abort(403, lang::get('errors.uknError'));
        }

        foreach ($input['data'] as $key => $value){

            if(empty($value['quantity'])OR empty($value['product'])){
                \Log::error('missing argument for order put | user: '.$id);
                self::deleteOrderAndSub($orderID);
                abort(403, lang::get('orders.missingArgument'));
            }
            if(!is_numeric($value['quantity'])OR !is_numeric($value['product'])){
                \Log::error('Bad arg type for input | user: '.$id);
                self::deleteOrderAndSub($orderID);
                abort(403, lang::get('errors.notAuthorized'));
            }
            if(!empty($value['size'])){
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
                \Log::error('missing argument for order put (size)| user: '.$id);
                self::deleteOrderAndSub($orderID);
                abort(403, lang::get('orders.missingArgument'));
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
        MailController::sendOrderConfirmation($orderID);

        return $this->response->array([
            'status_code' => 200,
            'message' => lang::get('orders.OrdersSuccess'),
            'orders_id'=>$orderID
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
    public function getBasket($id){
        $this->checkTokenFromId($id);

        $basket = \DB::select('SELECT basket_id, basket_quantity, fk_products_id as products_id, fk_productsSize_id FROM TB_Basket LEFT JOIN TB_Products ON TB_Products.products_id = TB_Basket.fk_products_id WHERE fk_users_id = ? AND products_dlDate IS NULL', [$id]);
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
    public function countBasket($id){
        $this->checkTokenFromId($id);

        $count =  \DB::select('SELECT count(TB_Products.products_id) as count FROM TB_Basket LEFT JOIN TB_Products ON TB_Products.products_id = TB_Basket.fk_products_id WHERE fk_users_id = ? AND products_dlDate IS NULL', [$id]);

        return $count[0]->count;
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
    public function addToBasket($wishID){
        $userID=\Auth::user()->users_id;
        $count = \DB::select('SELECT count(wishlist_id) as count FROM TB_Wishlist WHERE wishlist_id = ?  AND fk_users_id = ?', [$wishID, $userID]);
        if($count[0]->count!=1){
            \Log::error('Trying to access an non existent wishlist | user: '.$id.' wishID: '.$wishID);
            abort(403, lang::get('errors.notAuthorized'));
        }

        $wishContent=\DB::select('SELECT fk_products_id FROM TB_WishlistContent WHERE fk_wishlist_id = ?', [$wishID]);
        foreach($wishContent as $value){
            $count= \DB::select('SELECT count(basket_id) as count FROM TB_Basket WHERE fk_users_id = ? AND fk_products_id = ?', [$userID, $value->fk_products_id]);

            if($count[0]->count==0){
                \DB::insert('INSERT INTO TB_Basket(basket_quantity, fk_users_id, fk_products_id) VALUES (1, ?, ?)', [$userID, $value->fk_products_id]);
            }
        }
        return $this->response->array([
            'status_code' => 200,
            'message' => lang::get('orders.contentAdded')
        ]);

    }

    /*****************************
     *
     * Wishlists
     *
     */
    public function getAllWishlists($id){
        $this->checkTokenFromId($id);

        $orders = \DB::select('SELECT * FROM TB_Wishlist WHERE fk_users_id = ?', [$id]);
        return json_encode($orders);
    }
    public function getWishlistContent($id){
        $this->checkTokenFromId($id);

        $ordersContent = \DB::select('SELECT * FROM `TB_WishlistContent` WHERE fk_wishlist_id = ?', [$id]);
        return json_encode($ordersContent);
    }
    public function getAllWishlistsContent($id){
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
            $id = \DB::table('TB_Wishlist')->insertGetId(
                ['wishlist_name' => $input['name'], 'wishlist_description' => $description, 'fk_users_id'=>$id]
            );
        }
        catch (\PDOException $e) {
            \Log::error($e->getMessage());
            abort(403, lang::get('errors.uknError'));
        }
        return $this->response->array([
            'status_code' => 200,
            'message' => lang::get('orders.creatWishSuccess'),
            'wishlist_id'=>$id
        ]);
    }
    public function remWishlist($wishID, $id){
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
            abort(409, lang::get('orders.alreadinInWish'));
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
