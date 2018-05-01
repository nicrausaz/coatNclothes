<?php
namespace App\Http\Controllers\Api\V1;

use Dingo\Api\Contract\Http\Request;
use Dingo\Api\Http\Response;
use Dingo\Api\Routing\Helpers;
use Lang;
use Illuminate\Foundation\Validation\ValidatesRequests;


class adminController extends Controller
{

    use Helpers;
    use ValidatesRequests;


    function __construct(){
        if(self::checkIfAdmin()==false){
            \Log::error("ID: (" . \Auth::user()->users_id . ") tried to access an admin ressource");
            abort(403, lang::get('errors.notAuthorized'));
        }
    }

    public function editProduct(Request $request, $prodID){
        print_r('entré');
        $input = $request->all();

        $actualProduct = \DB::select('SELECT * FROM TB_Products WHERE products_id = ?', [$prodID]);
        if(empty($actualProduct[0])){
            \Log::error('Trying to edit an non existent object');
            abort(403, lang::get('orders.notIN'));
        }
        if(!empty($input['products_name'])) {
            self::checkIfLang($input);
            if (is_string($input['products_name'])){
                $products_name= self::interchangeLang($actualProduct[0]->products_name, $input['products_lang'], $input['products_name']);
            }else{
                \Log::error('lang not in the different language accepted');
                abort(403, lang::get('errors.conflict'));
            }
        }else{
            $products_name=$actualProduct[0]->products_name;
        }
        if(!empty($input['products_description'])) {
            self::checkIfLang($input);
            if (is_string($input['products_description'])){
                $products_description= self::interchangeLang($actualProduct[0]->products_description, $input['products_lang'], $input['products_description']);
            }else{
                \Log::error('lang not in the different language accepted');
                abort(403, lang::get('errors.conflict'));
            }
        }else{
            $products_description=$actualProduct[0]->products_description;
        }
        if(!empty($input['products_price'])) {
            if (is_numeric($input['products_price'])){
                $products_price=  $input['products_price'];
            }else{
                \Log::error('lang not in the different language accepted');
                abort(403, lang::get('errors.charNotAuthorized'));
            }
        }else{
            $products_price=$actualProduct[0]->products_price;
        }
        if(!empty($input['products_category'])) {
            if (is_numeric($input['products_category'])){
                $count =\DB::select('SELECT count(category_id) as count FROM TB_Category WHERE category_id = ?', [$input['products_category']]);
                if($count[0]->count==1) {
                    $products_category = $input['products_category'];
                }else{
                    \Log::error('Trying to edit an non existent category');
                    abort(403, lang::get('orders.notIN'));
                }
            }else{
                \Log::error('lang not in the different language accepted');
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
                \Log::error('lang not in the different language accepted');
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
                \Log::error('lang not in the different language accepted');
                abort(403, lang::get('errors.charNotAuthorized'));
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

        $this->validate($request, [
            'products_pic' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
        ]);


        $image = $request->file('products_pic');
        if(!isset($input['productsPics_altName'])){
            \Log::error('missing argument for adding new comment| user: '.$id);
            abort(403, lang::get('auth.missingArgument'));
        }
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
    public function removePicFromProduct(Request $request, $picID){
        try {
            \DB::update('UPDATE `TB_ProductsPics` SET `productsPics_dlDate` = NOW() WHERE `productsPics_id` = ?', [$picID]);
        } catch (\PDOException $e) {
            \Log::error($e->getMessage());
            abort(403, lang::get('errors.uknError'));
        }
        return $this->response->array([
            'status_code' => 200,
            'message' => lang::get('auth.remPicSuccess')
        ]);
    }
    public function addProduct(){

    }
    public function removeProduct(){

    }
    public function addCategory(){

    }
    public function moveCategory(){

    }
    public function removeCategory(){

    }
    public function editCategory(){

    }
    public function getAllUsers(){

    }
    public function editUser(){

    }
    public function getAllOrders(){

    }
    public function gerOrdersByUser(){

    }
    public function editOrderState(){

    }
    private function checkIfLang($input){
        $languages = \Config::get('app.languages');

        if(!isset($input['products_lang'])){
            \Log::error('missing lang');
            abort(403, lang::get('orders.missingArgument'));
        }
        if (!in_array($input['products_lang'], $languages)) {
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
            \DB::delete('UPDATE TB_ProductsSize SET productsSize_dlDate = NOW() WHERE fk_products_id = ?', [$prodID]);
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

}
