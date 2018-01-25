<?php
namespace App\Http\Controllers\Api\V1;

use Dingo\Api\Contract\Http\Request;
use Dingo\Api\Http\Response;
use Dingo\Api\Routing\Helpers;
use Illuminate\Routing\Controller;


class productsController extends Controller
{
    use Helpers;

    public function getAllProducts(){
        $products = \DB::select('select products_id, products_name from TB_Products', array(1));
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

        //color
        $color = \DB::select('SELECT * FROM TB_Colors WHERE fk_products_id = ?', [$id]);
        $colorArray=array();
        foreach ($color as $key => $value){
            $colorArray[$key]['name']= $color[$key]->colors_name;
            $colorArray[$key]['rgb']=$color[$key]->colors_rgb;
            $colorArray[$key]['hex']=$color[$key]->colors_hexa;
        }
        $gotProduct['products_colors']=$colorArray;

        //pictures
        $pictures = \DB::select('SELECT * FROM TB_ProductsPics WHERE fk_products_id = ?', [$id]);
        $picturesArray=array();
        foreach($pictures as $key => $value){
            $picturesArray[$key]['altName']=$pictures[$key]->productsPics_altName;
            $picturesArray[$key]['path']=$pictures[$key]->productsPics_path;
        }
        $gotProduct['products_pictures']=$picturesArray;

        //print_r('<pre>');
        //print_r(json_encode($gotProduct,true));
        //print_r('</pre>');
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
        $categories = \DB::select('SELECT category_name, category_id FROM `TB_Category` WHERE `fk_category_id` IS NULL');
        $categories=json_decode(json_encode($categories), true);

        //cat
    }

    /*
     * Private function (notusable from api.php)
     */

    private function checkCategoryUpTo($catId){
        $category= \DB::select('select category_name, fk_category_id from TB_Category WHERE category_id = ?', [$catId]);
        return array('name'=>$category[0]->category_name, 'id'=>$category[0]->fk_category_id);
    }
    private function getCategoryBelow($categories){
        foreach($categories as $key=> $value){
            $catBelow= \DB::select('SELECT category_name, category_id FROM `TB_Category` WHERE `fk_category_id` = ?', [$value['category_id']]);
            $catBelow=json_decode(json_encode($catBelow), true);
            foreach($catBelow as $value22 => $key22){
                if(!empty($catBelow)) {
                    $catBelow = $this->getCategoryBelow($catBelow);
                }
            }
            $categories[$key]['categories_below']=$catBelow;

            return $categories;
        }
    }
}
