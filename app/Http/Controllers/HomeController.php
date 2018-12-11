<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Redirect;
use Session;
use App\Http\Controllers\SuperAdminController;

session_start();

class HomeController extends Controller
{
    //
    public function index()
    {

    	$all_categories = DB::table('tbl_category')->get();
    	$all_manufactures = DB::table('tbl_manufacture')->get();
        $all_sliders = DB::table('tbl_slider')->get();
        $social_links = DB::table('tbl_social_links')->get();

        $all_wishlist = DB::table('tbl_wishlist')
        ->where('customer_id',session::get('customer_id'))
        ->get();

    	$all_published_products = DB::table('tbl_product')
        ->join('tbl_category','tbl_product.category_id','=','tbl_category.category_id')
        ->join('tbl_manufacture','tbl_product.manufacture_id','=','tbl_manufacture.manufacture_id')
        ->select('tbl_product.*','tbl_category.category_name','tbl_manufacture.manufacture_name')
        ->limit(9)
         ->get();



        //  echo '<pre>';
        //  print_r($all_published_products);
        //  echo '</pre>';
        // exit();
    	return View('pages.home')->with([
            'all_categories'=>$all_categories,
            'all_manufactures'=>$all_manufactures,
            'all_published_products'=>$all_published_products,
            'all_sliders'=>$all_sliders,
            'all_wishlist'=>$all_wishlist,
            'social_links'=>$social_links,
        ]);

    }

    public function displayCategoryProducts($category_id,$category_name)
    {
        // display all products inside special category 

        $all_categories = DB::table('tbl_category')->get();
        $all_manufactures = DB::table('tbl_manufacture')->get();
        $all_sliders = DB::table('tbl_slider')->get();
        $all_wishlist = DB::table('tbl_wishlist')
        ->where('customer_id',session::get('customer_id'))
        ->get();

        $category_published_products = DB::table('tbl_product')
        ->where('category_id',$category_id)
        //->limit(9)
        ->get();



        return View('pages.display_category_products')->with([
            'all_categories'=>$all_categories,
            'all_manufactures'=>$all_manufactures,
            'all_sliders'=>$all_sliders,
            'category_published_products'=>$category_published_products,
            'all_wishlist'=>$all_wishlist,
        ]);




    }
    public function displayManufactureProducts($manufacture_id,$manufacture_name)
    {
        // display all products inside special manufacture

        $all_categories = DB::table('tbl_category')->get();
        $all_manufactures = DB::table('tbl_manufacture')->get();
        $all_sliders = DB::table('tbl_slider')->get();

        $manufacture_published_products = DB::table('tbl_product')
        ->where('manufacture_id',$manufacture_id)
        //->limit(9)
        ->get();



        return View('pages.display_manufacture_products')->with([
            'all_categories'=>$all_categories,
            'all_manufactures'=>$all_manufactures,
            'all_sliders'=>$all_sliders,
            'manufacture_published_products'=>$manufacture_published_products
        ]);


    }

    public function displayProductDetails($product_id,$product_name)
    {
        $all_categories = DB::table('tbl_category')->get();
        $all_manufactures = DB::table('tbl_manufacture')->get();
        //$all_sliders = DB::table('tbl_slider')->get();

        $recommended_products = DB::table('tbl_product')->get();

        $product_details = DB::table('tbl_product')
        ->join('tbl_category','tbl_product.category_id','=','tbl_category.category_id')
        ->join('tbl_manufacture','tbl_product.manufacture_id','=','tbl_manufacture.manufacture_id')
        ->select('tbl_product.*','tbl_category.category_name','tbl_manufacture.manufacture_name')
        ->where('product_id',$product_id)
        ->get()->first();

         return View('pages.display_product_details')->with([
             'all_categories'=>$all_categories,
             'all_manufactures'=>$all_manufactures,
             'all_sliders'=>array(),
             'product_details'=>$product_details,
             'recommended_products'=>$recommended_products,

         ]);


    }

}
