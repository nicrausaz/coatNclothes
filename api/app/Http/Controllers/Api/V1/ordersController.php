<?php
namespace App\Http\Controllers\Api\V1;

use Dingo\Api\Contract\Http\Request;
use Dingo\Api\Http\Response;
use Dingo\Api\Routing\Helpers;
use Illuminate\Routing\Controller;


class ordersController extends Controller
{

    use Helpers;



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
    public function getBasket(Request $request, $id){
        $this->checkTokenFromId($id);

        $basket = \DB::select('SELECT basket_quantity, fk_products_id as products_id FROM TB_Basket WHERE fk_users_id = ?', [$id]);
        return json_encode($basket);

    }
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
    public function putInBasket(Request $request, $id){
        $this->checkTokenFromId($id);

        $input = $request->all();
        $number = \DB::select('SELECT count(basket_id) as number FROM `TB_Basket` WHERE fk_users_id = ? AND fk_products_id = ? ', [$id, $input['product']]);

        if($number[0]->number >= 1){
            abort(409, 'Article déjà dane le panier.');
        }
        try {
            \DB::table('TB_Basket')->insert(
                ['basket_quantity' => $input['quantity'], 'fk_users_id' => $id, 'fk_products_id' => $input['product']]
            );
        }
        catch (\PDOException $e) {
            \Log::error($e->getMessage());
            abort(403, 'Action non autorisée.');
        }
        return $this->response->array([
            'status_code' => 200,
            'message' => 'Ajouté au panier !'
        ]);
    }
}
