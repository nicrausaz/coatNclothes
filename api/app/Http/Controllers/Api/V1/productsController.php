<?php
namespace App\Http\Controllers\Api\V1;

use Dingo\Api\Contract\Http\Request;
use Dingo\Api\Http\Response;
use Dingo\Api\Routing\Helpers;
use Lang;

class productsController extends Controller
{

    use Helpers;

    /**
     * Products
     */
    public function home(){
        $best = \DB::select('SELECT avg(comment.commentsAndOpinions_note) as commentsAndOpinions_avg, prod.products_id, prod.products_name,  prod.products_price, CASE WHEN pic.productsPics_dlDate is NULL THEN pic.productsPics_id ELSE NULL END as productsPics_id, CASE WHEN pic.productsPics_dlDate is NULL THEN pic.productsPics_altName ELSE NULL END as productsPics_altName, CASE WHEN pic.productsPics_dlDate is NULL THEN pic.productsPics_path ELSE NULL END as productsPics_path FROM TB_CommentsAndOpinions comment LEFT JOIN TB_Products prod ON comment.fk_products_id = prod.products_id LEFT JOIN TB_ProductsPics pic ON pic.fk_products_id = prod.products_id AND pic.productsPics_dlDate IS NULL WHERE prod.`products_dlDate` IS NULL GROUP BY comment.fk_products_id ORDER BY commentsAndOpinions_avg DESC LIMIT 15  ');
        $newest=\DB::select('SELECT prod.products_id, prod.products_name, prod.products_price, CASE WHEN pic.productsPics_dlDate is NULL THEN pic.productsPics_id ELSE NULL END as productsPics_id,CASE WHEN pic.productsPics_dlDate is NULL THEN pic.productsPics_altName ELSE NULL END as productsPics_altName, CASE WHEN pic.productsPics_dlDate is NULL THEN  pic.productsPics_path ELSE NULL END as productsPics_path FROM TB_Products prod LEFT JOIN TB_ProductsPics pic ON pic.fk_products_id = prod.products_id AND pic.productsPics_dlDate IS NULL WHERE  prod.`products_dlDate` IS NULL GROUP BY prod.products_id ORDER BY `products_crDate` DESC LIMIT 15');
        $best =self::foreachHome($best);
        $newest = self::foreachHome($newest);
        return array('5best'=> $best, '5newest'=> $newest);
    }
    public function getAllProducts(){
        $products = \DB::select('SELECT prod.fk_brand_id, prod.products_id, prod.products_name, prod.products_price, CASE WHEN pic.productsPics_dlDate is NULL THEN pic.productsPics_id ELSE NULL END as productsPics_id,CASE WHEN pic.productsPics_dlDate is NULL THEN pic.productsPics_altName ELSE NULL END as productsPics_altName, CASE WHEN pic.productsPics_dlDate is NULL THEN  pic.productsPics_path ELSE NULL END as productsPics_path FROM TB_Products prod LEFT JOIN TB_ProductsPics pic ON pic.fk_products_id = prod.products_id AND pic.productsPics_dlDate IS NULL WHERE  prod.`products_dlDate` IS NULL GROUP BY prod.products_id',array(1));
        foreach ($products as $key=>$value){
            $products[$key]->products_name=$this->getTranslation($value->products_name);
        }
        return $products;
    }
    public function getProductUnrestricted($prodID){
        $gotProduct = \DB::select('SELECT prod.products_id, prod.fk_brand_id as products_brand, prod.products_name, prod.products_price, CASE WHEN pic.productsPics_dlDate is NULL THEN pic.productsPics_id ELSE NULL END as productsPics_id,CASE WHEN pic.productsPics_dlDate is NULL THEN pic.productsPics_altName ELSE NULL END as productsPics_altName, CASE WHEN pic.productsPics_dlDate is NULL THEN  pic.productsPics_path ELSE NULL END as productsPics_path FROM TB_Products prod LEFT JOIN TB_ProductsPics pic ON pic.fk_products_id = prod.products_id AND pic.productsPics_dlDate IS NULL WHERE prod.products_id = ?',[$prodID]);
        if(!isset($gotProduct[0])){
            \Log::error('Trying to get a non existent product');
            abort(403, lang::get('errors.nonExistentProduct'));
        }
        $gotProduct[0]->products_name=self::getTranslation($gotProduct[0]->products_name);
        return (array) $gotProduct[0];

    }
    public function getProductsDetails($id)
    {
        $gotProduct = \DB::select('select * from TB_Products WHERE products_id = ? AND `products_dlDate` IS NULL', [$id]);
        if(!isset($gotProduct[0])){
            \Log::error('Trying to get a non existent product');
            abort(403, lang::get('errors.nonExistentProduct'));
        }
        $gotProduct=json_decode(json_encode($gotProduct[0]), true);
        $gotProduct['products_name']=$this->getTranslation($gotProduct['products_name']);

        $gotProduct['products_description']=$this->getTranslation($gotProduct['products_description']);

        $id=$gotProduct['products_id'];


        //brandName
        $brand=$gotProduct['fk_brand_id'];
        $brandName= \DB::select('select brand_name from TB_Brand WHERE brand_id = ?', [$brand]);
        $gotProduct['products_brand'] = $brandName[0]->brand_name;

        //size
        $size = \DB::select('SELECT productsSize_value FROM TB_ProductsSize WHERE productsSize_dlDate IS NULL AND fk_products_id = ?', [$id]);
        $sizeArray=array();
        foreach ($size as $key => $value){
            $sizeArray[]= $size[$key]->productsSize_value;
        }
        $gotProduct['products_size']=$sizeArray;

        //pictures
        $pictures = \DB::select('SELECT * FROM TB_ProductsPics WHERE productsPics_dlDate IS NULL AND fk_products_id = ?', [$id]);
        $picturesArray=array();
        foreach($pictures as $key => $value){
            $picturesArray[$key]['altName']=$pictures[$key]->productsPics_altName;
            $picturesArray[$key]['path']=$pictures[$key]->productsPics_path;
            $picturesArray[$key]['id']=$pictures[$key]->productsPics_id;
        }
        $gotProduct['products_pictures']=$picturesArray;

        return $gotProduct;
    }
    public function getProductsByCategory($id){

        $gotProduct = \DB::select('SELECT prod.products_id, prod.products_name, prod.products_price, prod.fk_category_id, prod.fk_brand_id, CASE WHEN pic.productsPics_dlDate is NULL THEN pic.productsPics_id ELSE NULL END as productsPics_id,CASE WHEN pic.productsPics_dlDate is NULL THEN pic.productsPics_altName ELSE NULL END as productsPics_altName, CASE WHEN pic.productsPics_dlDate is NULL THEN  pic.productsPics_path ELSE NULL END as productsPics_path FROM TB_Products prod LEFT JOIN TB_ProductsPics pic ON pic.fk_products_id = prod.products_id AND pic.productsPics_dlDate IS NULL WHERE  prod.fk_category_id = ? AND prod.`products_dlDate` IS NULL GROUP BY prod.products_id', [$id]);
        foreach ($gotProduct as $key=>$value){
            $gotProduct[$key]->products_name=$this->getTranslation($value->products_name);
        }
        return $gotProduct;

    }
    public function getProductsByCategoryAndSubs($id){
        $categories=self::getAllCategories();
        $idOfAllCatAndSub =self::walkUntilFind($categories, $id);

        $result = array();

        foreach ($idOfAllCatAndSub as $value){

            if(!empty($this->getProductsByCategory($value))) $result = array_merge($this->getProductsByCategory($value), $result);
        }
        return $result;
    }

    /**
     * Categories
     */
    public function getListCategory(){
        $gotProduct = \DB::select('select * from TB_Category WHERE category_dlDate IS NULL');
        foreach ($gotProduct as $key => $value){
            $gotProduct[$key]->category_name=self::getTranslation($value->category_name);
        }
        return $gotProduct;
    }
    public function getAllCategories(){
        $category = \DB::select('SELECT category_name as name, category_id as id, fk_category_id as parent FROM `TB_Category` WHERE category_dlDate IS NULL');
        foreach ($category as $key=>$value){
            $category[$key]->name=self::getTranslation($value->name);
        }
        $arr=json_decode(json_encode($category), true);

        $new = array();
        foreach ($arr as $a){

            $new[$a['parent']][] = $a;
        }
        $parent=($new[NULL]);
        $data = self::createaTree($new, $parent);
        return $data;
    }
	public function getCategoryName($id){
		$gotProduct = \DB::select('select category_name, fk_gender_id as gender_id from TB_Category WHERE category_id = ? AND category_dlDate IS NULL', [$id]);
		$gotProduct[0]->category_name=self::getTranslation($gotProduct[0]->category_name);

		return (array)$gotProduct[0];
	
	}

    /**
     * Brands
     */
    public function getAllBrands(){
        $gotProduct = \DB::select('select * from TB_Brand WHERE brand_dlDate IS NULL');
        return $gotProduct;
    }
    public function getBrand(Request $id, $brandID){
        $gotProduct = \DB::select('select brand_name from TB_Brand WHERE brand_id = ?', [$brandID]);
       //var_dump($gotProduct);
        if(isset($gotProduct[0]->brand_name)){
            return $this->response->array([
                'status_code' => 200,
                'brand_name' => $gotProduct[0]->brand_name
            ]);
        }else{
            \Log::error('brand Not existing| user: '.$id);
            abort(404, lang::get('errors.notFound'));
        }
    }

    /**
     * Note
     */
    public function getNoteForProduct($prodID){
        $moyenne =\DB::select('SELECT avg(`commentsAndOpinions_note`) as commentsAndOpinions_note_average, count(commentsAndOpinions_id) as commentsAndOpinions_number FROM `TB_CommentsAndOpinions` WHERE `fk_products_id` = ?', [$prodID]);
        return $this->response->array([
            'status_code' => 200,
            'average' => $moyenne[0]->commentsAndOpinions_note_average,
            'number'=> $moyenne[0]->commentsAndOpinions_number
        ]);
    }
    public function getCommentForProduct($prodID){
        $lang=\App::getLocale();
        $selectAll=\DB::select('SELECT `commentsAndOpinions_id`, `commentsAndOpinions_note`, `commentsAndOpinions_comment`, `fk_users_id` FROM `TB_CommentsAndOpinions` WHERE `fk_products_id` = ? AND `commentsAndOpinions_comment`IS NOT NULL AND `commentsAndOpinions_lang`= ?', [$prodID, $lang]);
        foreach ($selectAll as $key => $item) {
            $login= self::getUserName($item->fk_users_id);
            unset($selectAll[$key]->fk_users_id);
            $selectAll[$key]->users_login=$login;
        }
        return $selectAll;
    }
    public function addNewComment(Request $request, $id, $prodID){
        $this->checkTokenFromId($id);
        self::checkIfAlreadyPosted($prodID, $id);

        $min= 0;
        $max= 10;

        $input = $request->all();

        if(isset($input['commentsAndOpinions_note'])){
            if(is_numeric($input['commentsAndOpinions_note'])) {
                if (($input['commentsAndOpinions_note'] <= $max) AND ($input['commentsAndOpinions_note'] >= $min)) {
                    $note = $input['commentsAndOpinions_note'];
                } else {
                    \Log::error('must be between '.$min.' and '.$max.' | user: '.$id);
                    abort(403, lang::get('orders.valueNotInScale', ['min' => $min, 'max'=>$max]));
                }
            }else{
                \Log::error('missing argument for changing info | user: '.$id);
                abort(403, lang::get('errors.charNotAuthorized'));
            }
        }else{
            \Log::error('missing argument for adding new comment| user: '.$id);
            abort(403, lang::get('auth.missingArgument'));
        }
        if(isset($input['commentsAndOpinions_comment'])) {
            $comment=$input['commentsAndOpinions_comment'];
        }else{
            $comment =null;
        }
        $lang=\App::getLocale();

        try {
            \DB::insert('INSERT INTO `TB_CommentsAndOpinions` (`commentsAndOpinions_note`, `commentsAndOpinions_comment`, `commentsAndOpinions_lang`, `fk_users_id`, `fk_products_id`) VALUES (?, ?, ?, ?, ?);', [$note, $comment, $lang, $id, $prodID]);
        }
        catch (\PDOException $e) {
            \Log::error($e->getMessage());
            abort(403, lang::get('errors.uknError'));
        }
        return $this->response->array([
            'status_code' => 200,
            'message' => lang::get('orders.commentAddedSuccess')
        ]);
    }

    /**
     * Internal job
     */
    private function foreachHome($array){
        foreach($array as $value){
            $value->products_name=self::getTranslation($value->products_name);
        }
        return $array;
    }
    public function getChildrenFor($ary, $id)
    {
        $results = array();

        foreach ($ary as $el)
        {
            if (($el['id'] == $id))
            {
                $results[] = $el['id'];
                if(isset($el['children'])) {
                    foreach ($el['children'] as $value) {
                        $children = self::getChildrenFor($el['children'], $value['id']);
                        $results = array_merge($results, $children);
                    }
                }
            }

        }
        return $results;
    }
    public function walkUntilFind($array, $id){

        foreach ($array as $key => $value){
            if($value['id']==$id) {
                $val= self::getChildrenFor($array, $id);
                break;
            }elseif(isset($value['children'])){
                $val=self::walkUntilFind($value['children'], $id);
                if($val != false) break 1;
            }
        }
        if(isset($val)){
            if($val != false){
                return $val;}
            else return false;
        }else return false;
    }
    private function createaTree(&$list, $parent){
        $tree = array();
        foreach ($parent as $k=>$l){
            if(isset($list[$l['id']])){
                $l['children'] = self::createaTree($list, $list[$l['id']]);
            }
            $tree[] = $l;
        }
        return $tree;
    }
    private function getUserName($id){
        $login = \DB::select('SELECT users_login FROM TB_Users WHERE users_id = ?', [$id]);
        return $login[0]->users_login;
    }
    private function checkIfAlreadyPosted($prodID, $userID){
        $count =\DB::select('SELECT count(`commentsAndOpinions_id`) as count FROM TB_CommentsAndOpinions WHERE fk_users_id = ? AND fk_products_id = ?', [$userID, $prodID]);
        if($count[0]->count!=0){
            abort(403, lang::get('orders.alreadyNoted'));
        }
    }
}
