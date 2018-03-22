<?php
namespace App\Http\Controllers\Api\V1;

use Dingo\Api\Contract\Http\Request;
use Dingo\Api\Http\Response;
use Dingo\Api\Routing\Helpers;
use Illuminate\Routing\Controller;


class productsController extends Controller
{

    use Helpers;

    private $categories;

    public function getAllProducts(){
        $products = \DB::select('select prod.products_id, prod.products_name, prod.products_price, pic.productsPics_altName, pic.productsPics_path from TB_Products prod LEFT JOIN TB_ProductsPics pic ON pic.fk_products_id = prod.products_id GROUP BY prod.products_id', array(1));
        return json_encode($products);
    }
    public function getspecificcategoryproducts(Request $request, $id){
        $products = \DB::select('select products_id, products_name from TB_Products WHERE fk_category_id = ?', [$id]);
        return json_encode($products);
    }


    public function getProductsDetails(Request $request, $id)
    {
        $gotProduct = \DB::select('select * from TB_Products WHERE products_id = ?', [$id]);
        $gotProduct=json_decode(json_encode($gotProduct[0]), true);
        $id=$gotProduct['products_id'];


        //brandName
        $brand=$gotProduct['fk_brand_id'];
        $brandName= \DB::select('select brand_name from TB_Brand WHERE brand_id = ?', [$brand]);
        $gotProduct['products_brand'] = $brandName[0]->brand_name;
        unset($gotProduct['fk_brand_id']);

        //size
        $size = \DB::select('SELECT productsSize_value FROM TB_ProductsSize WHERE fk_products_id = ?', [$id]);
        $sizeArray=array();
        foreach ($size as $key => $value){
            $sizeArray[]= $size[$key]->productsSize_value;
        }
        $gotProduct['products_size']=$sizeArray;

        //pictures
        $pictures = \DB::select('SELECT * FROM TB_ProductsPics WHERE fk_products_id = ?', [$id]);
        $picturesArray=array();
        foreach($pictures as $key => $value){
            $picturesArray[$key]['altName']=$pictures[$key]->productsPics_altName;
            $picturesArray[$key]['path']=$pictures[$key]->productsPics_path;
        }
        $gotProduct['products_pictures']=$picturesArray;

        return json_encode($gotProduct);
    }

    public function getCategory(){


        //Categories
        $category=$gotProduct['fk_category_id'];
        unset($gotProduct['fk_category_id']);
        while(!empty($category)){
            $feedback=$this->checkCategoryUpTo($category);
            $gotProduct[$feedback['name']]= $gotProduct;
            $category= $feedback['id'];
        }
    }
    public function getAllCategories(){
        $array=array();
        $categories = \DB::select('SELECT category_name, category_id FROM `TB_Category` WHERE `fk_category_id` IS NULL');
        $categories=json_decode(json_encode($categories), true);

        foreach($categories as $key => $value) {
            $this->categories=array($value['category_name']=>1);
            print_r('<br/>---<br/><br/><pre>');
            if ($this->checkIfCategoryBelow($value['category_id'])) {
            $array['category_name']=$this->getCategoryBelow($value['category_id']);
            print_r($array);
            } else{

            }
        }
        //cat
    }
    public function getAllCategories2(){
        $array= array('Homme'=>array('JeanLewis'=> array('jeans slim', 'jeans Stretch'), 'T-shirt'), 'Femme'=>array('Top', 'Débardeur'));
        return json_encode($array);
    }
	
	public function getCategroyName(Request $request, $id){
		$gotProduct = \DB::select('select category_name from TB_Category WHERE category_id = ?', [$id]);
		$gotProduct = json_decode(json_encode($gotProduct), true);
		return $gotProduct;
	
	
	
	}

	public function getProductsByCategory(Request $request, $id){
		$array=array();
		
		$gotProduct = \DB::select('select prod.products_id, prod.products_name, prod.products_price, prod.fk_category_id, prod.fk_brand_id, pic.productsPics_altName, pic.productsPics_path from TB_Products prod LEFT JOIN TB_ProductsPics pic ON pic.fk_products_id = prod.products_id WHERE prod.fk_category_id = ? GROUP BY prod.products_id', [$id]);
		$gotProduct = json_decode(json_encode($gotProduct), true);
		return $gotProduct; 

	}


	/*
     * Private function (notusable from api.php)
     */
    private function checkIfCategoryBelow($id){
        if(\DB::select('SELECT * FROM `TB_Category` WHERE `fk_category_id` = ?',[$id])){
            return true;
        }else{
            return false;
        }
    }
    private function checkCategoryUpTo($catId){
        $category= \DB::select('select category_name, fk_category_id from TB_Category WHERE category_id = ?', [$catId]);
        return array('name'=>$category[0]->category_name, 'id'=>$category[0]->fk_category_id);
    }
    private function getCategoryBelow($id){
        $dbfeedback=\DB::select('SELECT * FROM `TB_Category` WHERE `fk_category_id` = ?',[$id]);
        $dbfeedback=json_decode(json_encode($dbfeedback), true);
        print_r($dbfeedback);
            foreach($dbfeedback as $key => $value){
                if($this->checkIfCategoryBelow($value['category_id'])){
                    $array['category_name']=$this->getCategoryBelow($value['category_id']);
                }else{
                    print_r('top');
                    $array= array($value['category_name']);
                }
            }
        return $array;
    }
}
