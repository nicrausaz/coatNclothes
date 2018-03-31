<?php
namespace App\Http\Controllers\Api\V1;

use Dingo\Api\Contract\Http\Request;
use Dingo\Api\Http\Response;
use Dingo\Api\Routing\Helpers;
use Illuminate\Routing\Controller;
use Lang;

class productsController extends Controller
{

    use Helpers;

    private $categories;
    private $categoriesStored;

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
        //print_r($gotProduct);
        $gotProduct['products_description']=$this->getTranslation($gotProduct, 'products_description');

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
    public function getAllCategories(){
        $category = \DB::select('SELECT category_name as name, category_id as id, fk_category_id as parent FROM `TB_Category` ');
        $arr=json_decode(json_encode($category), true);

        $new = array();
        foreach ($arr as $a){
            $new[$a['parent']][] = $a;
        }
        $parent=($new[NULL]);
        $data = self::createaTree($new, $parent);
        return $data;
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
    private function getTranslation($array, $translatedKey){
        $description=json_decode($array[$translatedKey], true);
        if(key_exists(\App::getLocale(), $description))$description=$description[\App::getLocale()];else $description = NULL;
        return $description;
    }
}
