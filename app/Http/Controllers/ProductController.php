<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Redirect;
use Session;

session_start();

class ProductController extends Controller
{
    //

    public function add()
    {
    	$all_categories = DB::table('tbl_category')->get();
    	$all_manufactures = DB::table('tbl_manufacture')->get();
    	return View('admin.add_product')->with(['all_categories'=>$all_categories,'all_manufactures'=>$all_manufactures]);
    }


    public function save(Request $request)
    {
    	$data = array();
    	$data['product_name'] = $request->product_name;
    	$data['product_long_description'] = $request->product_long_description;
    	$data['product_short_description'] = $request->product_short_description;
    	$data['manufacture_id'] = $request->brand_name;
    	$data['category_id'] = $request->category_name;
    	$data['product_price'] = $request->product_price;
    	$data['product_price'] = $request->product_price;
		$data['product_color'] = $request->product_colors;

		$image = $request->file('product_image');
		if ($image) {
			$image_name = date('mdYHis');
			$ext = strtolower($image->getClientOriginalExtension());
			$image_full_name = $image_name.".".$ext;
			$upload_url = 'images/';
			$image_url = $upload_url.$image_full_name;
			$isUploaded = $image->move($upload_url,$image_full_name);
			if ($isUploaded) {
				$data['product_image']=$image_url;
			}else
			{
				$data['product_image']=null;
			}

		}

		if ($request->publication_status == 'on') {
    		$data['publication_status'] = 1;
    	}else
    	{
    		$data['publication_status'] = 0;
    	}
		
		if(DB::table('tbl_product')->insert($data))
        {
                session::put('msg','product saved ! ');
                return Redirect::to('/admin/product/all'); 
        }else

        {
                session::put('msg','product not saved!');
                return Redirect::to('/admin/product/all'); 
        }

    }

    public function all()
    {
         $all_products = DB::table('tbl_product')
        ->join('tbl_category','tbl_product.category_id','=','tbl_category.category_id')
        ->join('tbl_manufacture','tbl_product.manufacture_id','=','tbl_manufacture.manufacture_id')
        ->select('tbl_product.*','tbl_category.category_name','tbl_manufacture.manufacture_name')
         ->get();

        return View('admin.all_products')->with('all_products',$all_products);
    }


     public function unactive($product_id)
    {
       // Make Publication_status =  0 
        DB::table('tbl_product')
        ->where('product_id',$product_id)
        ->update(['publication_status'=>0]);
        session::put('msg','Product UnActived ');
        return Redirect::to('admin/product/all');
    }

    public function active($product_id)
    {
       // Make Publication_status =  1
        DB::table('tbl_product')
        ->where('product_id',$product_id)
        ->update(['publication_status'=>1]);
        session::put('msg','Product Actived ! ');
        return Redirect::to('admin/product/all');
    }

    public function delete($product_id)
    {
          $isDeleted = DB::table('tbl_product')
            ->where('product_id',$product_id)
            ->delete();

            if ($isDeleted) {
                session::put('msg','Product Deleted ! ');
                return Redirect::to('/admin/product/all'); 
            }else
            {
                session::put('msg','Product Can Not Deleted');
                return Redirect::to('/admin/product/all');    
            }
    }

}
