<?php
namespace App\Http\Controllers\Api\V1;

use Dingo\Api\Contract\Http\Request;
use Dingo\Api\Http\Response;
use Dingo\Api\Routing\Helpers;
use Lang;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Http\Controllers\Api\V1\usersController;
use Illuminate\Support\Facades\Validator;



class adminController extends Controller
{

    use Helpers;
    use ValidatesRequests;

    public function __construct()
    {
        self::middleware('jwt.auth');
        self::checkAdmin();

    }

    /**
     * Products gestion
     */
    public function editProduct(Request $request, $prodID){
        $input = $request->all();

        $actualProduct = \DB::select('SELECT * FROM TB_Products WHERE products_id = ?', [$prodID]);
        if(empty($actualProduct[0])){
            \Log::error('Trying to edit an non existent object');
            abort(403, lang::get('orders.notIN'));
        }
        if(!empty($input['products_name'])) {
            self::checkIfLang($input['products_lang']);
            if (is_string($input['products_name'])){
                $products_name= self::interchangeLang($actualProduct[0]->products_name, $input['products_lang'], $input['products_name']);
            }else{
                \Log::error('Product name is not a string');
                abort(403, lang::get('errors.conflict'));
            }
        }else{
            $products_name=$actualProduct[0]->products_name;
        }
        if(!empty($input['products_description'])) {
            self::checkIfLang($input['products_lang']);
            if (is_string($input['products_description'])){
                $products_description= self::interchangeLang($actualProduct[0]->products_description, $input['products_lang'], $input['products_description']);
            }else{
                \Log::error('Product description is not a string');
                abort(403, lang::get('errors.conflict'));
            }
        }else{
            $products_description=$actualProduct[0]->products_description;
        }
        if(!empty($input['products_price'])) {
            if (is_numeric($input['products_price'])){
                $products_price=  $input['products_price'];
            }else{
                \Log::error('Product price is not a numeric');
                abort(403, lang::get('errors.charNotAuthorized'));
            }
        }else{
            $products_price=$actualProduct[0]->products_price;
        }
        if(!empty($input['products_category'])) {
            if (is_numeric($input['products_category'])){
                $count =\DB::select('SELECT count(category_id) as count FROM TB_Category WHERE category_id = ? AND  category_dlDate IS NULL', [$input['products_category']]);
                if($count[0]->count==1) {
                    $products_category = $input['products_category'];
                }else{
                    \Log::error('Trying to edit an non existent category');
                    abort(403, lang::get('orders.notIN'));
                }
            }else{
                \Log::error('Produit category n\'est pas un ID entier');
                abort(403, lang::get('errors.charNotAuthorized'));
            }
        }else{
            $products_category=$actualProduct[0]->fk_category_id;
        }
        if(!empty($input['products_brand'])) {
            if (is_numeric($input['products_brand'])){
                $count =\DB::select('SELECT count(brand_id) as count FROM TB_Brand WHERE brand_id = ?', [$input['products_brand']]);
                if($count[0]->count==1) {
                    $products_brand = $input['products_brand'];
                }else{
                    \Log::error('Trying to edit an non existent brand');
                    abort(403, lang::get('orders.notIN'));
                }
            }else{
                \Log::error('La marque n\'est pas un id numérique');
                abort(403, lang::get('errors.charNotAuthorized'));
            }
        }else{
            $products_brand=$actualProduct[0]->fk_brand_id;
        }
        if(!empty($input['products_size'])) {
            if (is_string($input['products_size'])){
                self::isJson($input['products_size']);
                self::removeAllSize($prodID);
                self::putNewSize($input['products_size'], $prodID);

            }else{
                \Log::error('Product Size is not a string');
                abort(403, lang::get('errors.conflict'));
            }
        }
        try {
            \DB::table('TB_Products')->where(['products_id'=> $prodID])->update(
                ['products_name' => $products_name, 'products_description' => $products_description, 'products_price'=>$products_price, 'fk_category_id'=> $products_category, 'fk_brand_id'=>$products_brand]
            );
        }
        catch (\PDOException $e) {
            \Log::error($e->getMessage());
            abort(403, lang::get('errors.uknError'));
        }
        return $this->response->array([
            'status_code' => 200,
            'message' => lang::get('orders.productsUpdated')
        ]);
    }
    public function addPicToProduct(Request $request, $prodID){


        $input=$request->all();

        $validator = Validator::make($request->all(), [
            'products_pic' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'productsPics_altName'=>'required'
        ]);
        if($validator->fails()){
            \Log::error('wrong argument for adding pic | user: '.$prodID);
            abort(403, $validator->errors());
        }


        $image = $request->file('products_pic');

        $input['imagename'] = rand(11111, 99999).trim(strtolower(str_replace(' ', '', $input['productsPics_altName']))).'.'.$image->getClientOriginalExtension();

        $destinationPath = public_path('/articles');

        $image->move($destinationPath, $input['imagename']);

        try {
            \DB::insert('INSERT INTO `TB_ProductsPics` (`productsPics_altName`, `productsPics_path`, `fk_products_id`) VALUES (?, ?, ?);', [$input['productsPics_altName'],'https://'.request()->getHost().'/public/articles/'.$input['imagename'], $prodID]);
        } catch (\PDOException $e) {
            \Log::error($e->getMessage());
            abort(403, lang::get('errors.uknError'));
        }

        return $this->response->array([
            'status_code' => 200,
            'message' => lang::get('auth.updatePicSuccess')
        ]);

    }
    public function removePicFromProduct($picID){
        $actualPath = public_path('/articles');
        $newPath = public_path('/articles/OLD');
        $actualPic=\DB::select('SELECT * FROM TB_ProductsPics WHERE productsPics_id = ?', [$picID]);
        if(!isset($actualPic[0])){
            \Log::error('Trying to remove an non existent picture');
            abort(404, lang::get('errors.uknError'));        }
        try {
            \DB::update('UPDATE `TB_ProductsPics` SET `productsPics_dlDate` = NOW() WHERE `productsPics_id` = ?', [$picID]);
        } catch (\PDOException $e) {
            \Log::error($e->getMessage());
            abort(403, lang::get('errors.uknError'));
        }

        $GetFileName = explode('/', $actualPic[0]->productsPics_path);
        if(file_exists($actualPath.'/'.$GetFileName[5])){
            rename($actualPath.'/'.$GetFileName[5], $newPath.'/'.$GetFileName[5]);
        }else{
            \Log::error('Trying to move an non existent picture');
            abort(404, lang::get('errors.uknError'));
        }
        return $this->response->array([
            'status_code' => 200,
            'message' => lang::get('auth.remPicSuccess')
        ]);
    }
    public function addProduct(Request $request){
        $input = $request->all();
        if((!isset($input['products_description']))OR(!isset($input['products_name']))OR(!isset($input['products_price']))OR(!isset($input['products_category']))OR(!isset($input['products_brand']))OR(!isset($input['products_size']))){
            \Log::error('missing argument for adding product');
            abort(403, lang::get('orders.missingArgument'));
        }

        if(!empty($input['products_name'])) {
            if (is_string($input['products_name'])){
                $products_name= self::interchangeLang('{}', 'en', $input['products_name']);
            }else{
                \Log::error('Product name is not a string');
                abort(403, lang::get('errors.conflict'));
            }
        }else{
            \Log::error('missing argument for adding product');
            abort(403, lang::get('orders.missingArgument'));
        }
        if(!empty($input['products_description'])) {
            if (is_string($input['products_description'])){
                $products_description= self::interchangeLang('{}', 'en', $input['products_description']);
            }else{
                \Log::error('Product description is not a string');
                abort(403, lang::get('errors.conflict'));
            }
        }else{
            \Log::error('missing argument for adding product');
            abort(403, lang::get('orders.missingArgument'));
        }
        if(!empty($input['products_price'])) {
            if (is_numeric($input['products_price'])){
                $products_price=  $input['products_price'];
            }else{
                \Log::error('Product price is not numeric');
                abort(403, lang::get('errors.charNotAuthorized'));
            }
        }else{
            \Log::error('missing argument for adding product');
            abort(403, lang::get('orders.missingArgument'));
        }
        if(!empty($input['products_category'])) {
            if (is_numeric($input['products_category'])){
                $count =\DB::select('SELECT count(category_id) as count FROM TB_Category WHERE category_id = ?', [$input['products_category']]);
                if($count[0]->count==1) {
                    $products_category = $input['products_category'];
                }else{
                    \Log::error('Trying to add products to an non existent category');
                    abort(403, lang::get('orders.notIN'));
                }
            }else{
                \Log::error('Product category is not numeric');
                abort(403, lang::get('errors.charNotAuthorized'));
            }
        }else{
            \Log::error('missing argument for adding product');
            abort(403, lang::get('orders.missingArgument'));
        }
        if(!empty($input['products_brand'])) {
            if (is_numeric($input['products_brand'])){
                $count =\DB::select('SELECT count(brand_id) as count FROM TB_Brand WHERE brand_id = ?', [$input['products_brand']]);
                if($count[0]->count==1) {
                    $products_brand = $input['products_brand'];
                }else{
                    \Log::error('Trying to edit an non existent brand');
                    abort(403, lang::get('orders.notIN'));
                }
            }else{
                \Log::error('products brand is not numeric');
                abort(403, lang::get('errors.charNotAuthorized'));
            }
        }else{
            \Log::error('missing argument for adding product');
            abort(403, lang::get('orders.missingArgument'));
        }
        if(!empty($input['products_size'])) {
            if (is_string($input['products_size'])){
                self::isJson($input['products_size']);
            }else{
                \Log::error('Products size no a string (json array)');
                abort(403, lang::get('errors.conflict'));
            }
        }else{
            \Log::error('missing argument for adding product');
            abort(403, lang::get('orders.missingArgument'));
        }
        try {
            \DB::table('TB_Products')->insert(
                ['products_name' => $products_name, 'products_description' => $products_description, 'products_price'=>$products_price, 'fk_category_id'=> $products_category, 'fk_brand_id'=>$products_brand]
            );
        }
        catch (\PDOException $e) {
            \Log::error($e->getMessage());
            abort(403, lang::get('errors.uknError'));
        }
        $lastInsertID = \DB::getPdo()->lastInsertId();
        self::putNewSize($input['products_size'], $lastInsertID);


        return $this->response->array([
            'status_code' => 200,
            'message' => lang::get('orders.productsAddedd')
        ]);
    }
    public function removeProduct($prodID){
        try {
            \DB::update('UPDATE TB_Products SET products_dlDate = NOW() WHERE products_id = ?', [$prodID]);
        }
        catch (\PDOException $e) {
            \Log::error($e->getMessage());
            abort(403, lang::get('errors.uknError'));
        }
        return $this->response->array([
            'status_code' => 200,
            'message' => lang::get('orders.removedProduct')
        ]);
    }

    /**
     * Orders gestion
     */
    public function paidOrder($orderID){
        try {
            \DB::update('UPDATE TB_Orders SET orders_paidDate = NOW() WHERE orders_id = ?', [$orderID]);
        } catch (\PDOException $e) {
            \Log::error($e->getMessage());
            abort(403, lang::get('errors.uknError'));
        }
        return $this->response->array([
            'status_code' => 200,
            'message' => lang::get('orders.orderUpdated')
        ]);
    }
    public function getAllOrders(){
        $orders = \DB::select('SELECT * FROM `TB_Orders` ORDER BY `TB_Orders`.`orders_createdDate` DESC ');
        foreach ($orders as $key => $value){
            $status =\DB::select('SELECT ordersStatus_name FROM TB_OrdersStatus WHERE ordersStatus_id = ?', [$value->fk_ordersStatus_id]);
            $orders[$key]->ordersStatus_name = self::getTranslation($status[0]->ordersStatus_name);

            if($value->orders_paidDate==NULL)$paid=0;else$paid=1;
            $orders[$key]->orders_paid=$paid;
        }

        return $orders;
    }
    public function getOrderContent($orderID){
        $ordersController = new ordersController();
        return $ordersController->getOrderContent($orderID);
    }
    public function getOrdersByUser($id){
        $ordersController = new ordersController();
        return $ordersController->getAllOrders($id);
    }
    public function editOrderState($orderID, $stateID){
        try {
            \DB::update('UPDATE TB_Orders SET fk_ordersStatus_id = ? WHERE orders_id = ?', [$stateID, $orderID]);
        }
        catch (\PDOException $e) {
            \Log::error($e->getMessage());
            abort(403, lang::get('errors.uknError'));
        }
        return $this->response->array([
            'status_code' => 200,
            'message' => lang::get('orders.orderUpdated')
        ]);
    }
    public function getOrderStateAvailable(){
        $ordersStatus =  \DB::select('SELECT * FROM TB_OrdersStatus');
        foreach ($ordersStatus as $key => $value){
            $ordersStatus[$key]->ordersStatus_name= self::getTranslation($value->ordersStatus_name);
        }
        return $ordersStatus;
    }

    /**
     * Users gestion
     */
    public function getUserInfo($id){
        $usersController = new usersController();
        return $usersController->getUserInfo($id);
    }
    public function getUserAdress($id){
        $usersController = new usersController();
        return $usersController->getUserAdresses($id);
    }
    public function getAdress($addrID){
        $address = \DB::select('SELECT * FROM TB_Adresses WHERE adresses_id = ?', [$addrID]);
        if(!isset($address[0])){
            \Log::error('Trying to get a non existente address');
            abort(403, lang::get('errors.nonExistentAddress'));
        }

        return (array)$address[0];
    }
    public function setAdmin($id, $value){
        \Log::error('id:'.$id.' value:'.$value.' user:'.\Auth::user()->users_id);

        try{
            \DB::update('UPDATE `TB_Users` SET `users_admin` = ? WHERE `TB_Users`.`users_id` = ?; ', [$value, $id]);
        }
        catch (\PDOException $e) {
            \Log::error($e->getMessage());
            abort(403, lang::get('errors.uknError'));
        }
        return $this->response->array([
            'status_code' => 200,
            'message' => lang::get('auth.setAdminSucccess')
        ]);
    }
    public function getAllUsers(){
        return \DB::select('SELECT users_id, users_name, users_login, users_fsname, users_email, users_enabled, users_createDate, users_admin, fk_gender_id FROM TB_Users WHERE users_dlDate IS NULL');
    }
    public function editUser(Request $request, $id){
        $usersController = new usersController();
        return $usersController->changeUserInfo($request, $id);

    }
    public function disableUser($id, $value){
        try {
            \DB::update('UPDATE `TB_Users` SET `users_enabled` = ? WHERE `TB_Users`.`users_id` = ?; ', [$value, $id]);
        }
        catch (\PDOException $e) {
            \Log::error($e->getMessage());
            abort(403, lang::get('errors.uknError'));
        }

        return $this->response->array([
            'status_code' => 200,
            'message' => lang::get('auth.disabledSuccess')
        ]);
    }
    public function remUser($id){
        try {
            \DB::update('UPDATE `TB_Users` SET `users_dlDate` = NOW() WHERE `TB_Users`.`users_id` = ?; ', [$id]);
        }
        catch (\PDOException $e) {
            \Log::error($e->getMessage());
            abort(403, lang::get('errors.uknError'));
        }
        self::disableUser($id, 0);

        return $this->response->array([
            'status_code' => 200,
            'message' => lang::get('auth.removedSuccess')
        ]);
    }

    /**
     * Brands gestion
     */
    public function removeBrand($brandID){
        try {
            \DB::update('UPDATE TB_Brand SET brand_dlDate = NOW() WHERE brand_id = ?', [$brandID]);
        }
        catch (\PDOException $e) {
            \Log::error($e->getMessage());
            abort(403, lang::get('errors.uknError'));
        }
        return $this->response->array([
            'status_code' => 200,
            'message' => lang::get('orders.removedBrand')
        ]);
    }
    public function addBrand(Request $request){
        $input = $request->all();
        $this->validate($request, [
            'brand_name' => 'regex:/(^[A-Za-z0-9âàé\\\'èï&äçüö\- ]+$)+/|max:255|required'
        ]);
        $count = \DB::select('SELECT count(brand_id) as count FROM TB_Brand WHERE brand_name = ?', [$input['brand_name']]);
        if ($count[0]->count!=0){
            \Log::error('brand already existing');
            abort(403, lang::get('orders.alreadinInBrand'));
        }
        try {
            \DB::insert('INSERT INTO TB_Brand (`brand_name`) VALUE  (?)', [$input['brand_name']]);
        }
        catch (\PDOException $e) {
            \Log::error($e->getMessage());
            abort(403, lang::get('errors.uknError'));
        }
        return $this->response->array([
            'status_code' => 200,
            'message' => lang::get('orders.brandAdded')
        ]);
    }

    /**
     * Categories gestion
     */
    public function addCategory(Request $request){
        $validator = Validator::make($request->all(), [
            'category_name' => 'required|regex:/(^[A-Za-z0-9âàéèïäç\'.üö\- ]+$)+/|max:200',
            'gender_id'=>'int|nullable',
            'fk_category_id'=>'int|nullable'
        ]);
        if($validator->fails()){
            \Log::error('wrong argument for adding cat');
            abort(403, $validator->errors());
        }
        $input=$request->all();
        $category_name=json_encode(array('en'=>$input['category_name']));
        try{
            \DB::insert('INSERT INTO TB_Category (category_name, fk_category_id, fk_gender_id) VALUES (?, ?, ?)', [$category_name, $input['fk_category_id'], $input['gender_id']]);
        }
        catch (\PDOException $e) {
            \Log::error($e->getMessage());
            abort(403, lang::get('errors.uknError'));
        }
        return $this->response->array([
            'status_code' => 200,
            'message' => lang::get('orders.catCreatSuccess')
        ]);

    }
    public function remCategory($catID){
        $product = new productsController;
        $categories= $product->getAllCategories();
        $idOfAllCatAndSub = $product->walkUntilFind($categories, $catID);

        $products =$product->getProductsByCategoryAndSubs($catID);

        foreach ($idOfAllCatAndSub as $value){
            try{
                \DB::update('UPDATE `TB_Category` SET `category_dlDate` = NOW() WHERE `TB_Category`.`category_id` = ?; ', [$value]);
            }
            catch (\PDOException $e) {
                \Log::error($e->getMessage());
                abort(403, lang::get('errors.uknError'));
            }
        }
        foreach ($products as $value){
            self::removeProduct($value->products_id);
        }
        return $this->response->array([
            'status_code' => 200,
            'message' => lang::get('orders.catRemoveSuccess')
        ]);
    }
    public function editCategory(Request $request, $catID){
        $validator = Validator::make($request->all(), [
            'category_name' => 'regex:/(^[A-Za-z0-9âàéèïäç\'.üö\- ]+$)+/|max:200',
            'gender_id'=>'int|nullable',
            'fk_category_id'=>'int|nullable',
            'category_lang'=>'required|string|max:2'
        ]);
        if($validator->fails()){
            \Log::error('wrong argument for adding cat');
            abort(403, $validator->errors());
        }
        $actualCat = \DB::select('SELECT * FROM TB_Category WHERE category_id = ? AND  category_dlDate IS NULL', [$catID]);

        if(!isset($actualCat[0])){
            \Log::error('missing argument for editing category');
            abort(403, lang::get('orders.missingArgument'));
        }
        $input=$request->all();

        $category_name=json_decode($actualCat[0]->category_name, true);
        if(!empty($input['category_name'])) $category_name[$input['category_lang']]=$input['category_name'];
        $category_name=json_encode($category_name);

        if(!empty($input['gender_id'])) $gender_id=$input['gender_id']; else $gender_id = $actualCat[0]->fk_gender_id;

        self::checkIfLang($input['category_lang']);

        if(!empty($input['fk_category_id'])) $fk_category_id=$input['fk_category_id']; else $fk_category_id = $actualCat[0]->fk_category_id;
        if ($fk_category_id==$catID) $fk_category_id = $actualCat[0]->fk_category_id;

        try{
            \DB::update('UPDATE TB_Category SET category_name=?, fk_category_id=?, fk_gender_id=? WHERE category_id = ?', [$category_name, $fk_category_id, $gender_id, $catID]);
        }
        catch (\PDOException $e) {
            \Log::error($e->getMessage());
            abort(403, lang::get('errors.uknError'));
        }
        return $this->response->array([
            'status_code' => 200,
            'message' => lang::get('orders.catSuccessEdit')
        ]);
    }



    /**
     * Private functions - intern job
     */
    private function checkIfLang($input){
        $languages = \Config::get('app.languages');
        foreach($languages as $value){
            $lang[]=$value['locale'];
        }

        if (!in_array($input, $lang)) {
            \Log::error('lang not in the different language accepted');
            abort(403, lang::get('errors.conflict'));
        }
    }
    private function interchangeLang($jsonString, $lang, $newString){
        $array=json_decode($jsonString, true);
        $array[$lang]=$newString;
        return json_encode($array);
    }
    private function isJson($string) {
        json_decode($string);
        if(json_last_error() == JSON_ERROR_NONE){
            return true;
        }else{
            \Log::error('not a json string');
            abort(403, lang::get('errors.conflict'));
        }
    }
    private function removeAllSize($prodID){
        try {
            \DB::update('UPDATE TB_ProductsSize SET productsSize_dlDate = NOW() WHERE fk_products_id = ?', [$prodID]);
        }
        catch (\PDOException $e) {
            \Log::error($e->getMessage());
            abort(403, lang::get('errors.uknError'));
        }
    }
    private function putNewSize($newSize, $prodID){
        $newSize = json_decode($newSize, true);
        foreach ($newSize as $value){
            try {
                \DB::insert('INSERT INTO `TB_ProductsSize` (`productsSize_value`, `fk_products_id`) VALUES (?, ?);', [$value, $prodID]);
            }
            catch (\PDOException $e) {
                \Log::error($e->getMessage());
                abort(403, lang::get('errors.uknError'));
            }
        }
    }
    private function checkAdmin(){
        if(self::checkIfAdmin()==false){
            \Log::error("access an admin ressource:hello");

            //abort(403, lang::get('errors.notAuthorized'));
        }
    }

}
