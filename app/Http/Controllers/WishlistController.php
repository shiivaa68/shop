<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Redirect;
use Session;
use App\Http\Controllers\SuperAdminController;
use Cart;

class WishlistController extends Controller
{
    //
    public function all()
    {

    	if (session::get('customer_id')) {
           // all wishlist 
    		$customer_id = session::get('customer_id');

    		$all_wishlist = DB::table('tbl_wishlist')
    		->where('customer_id',$customer_id)
    		->join('tbl_product','tbl_product.product_id','=','tbl_wishlist.product_id')
    		->get();

 
    // 			echo '<pre>';
    // 			print_r($all_wishlist);
				// echo '</pre>';

			return View('pages.all_wishlist')->with('all_wishlist',$all_wishlist);

        }
        else
        {
          return Redirect('/customer/auth');
        }
    }


    public function add($customer_id,$product_id)
    {

            $data = array();
            $data['customer_id'] = $customer_id;
            $data['product_id'] = $product_id;


            $isInserted = DB::table('tbl_wishlist')
            ->insert($data);

            return Redirect::to('/');
    }
    public function remove($wishlist_id)
    {
        $isDeleted =DB::table('tbl_wishlist')
            ->where('wishlist_id',$wishlist_id)
            ->delete();
        return Redirect::to('/');

    }
}
