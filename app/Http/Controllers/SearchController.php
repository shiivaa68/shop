<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Redirect;
use Session;

class SearchController extends Controller
{
    //

    public function keyword(Request $request)
    {
		$keyword = $request->search_word;

		$data = DB::table('tbl_product')
		->where('product_name','like',"%$keyword%")
		->orWhere('product_long_description','like',"%$keyword%")
		->orWhere('product_short_description','like',"%$keyword%")
		->get();
		
		//return view here 
		
    }
}
