<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Redirect;
use Session;
use App\Http\Controllers\SuperAdminController;

session_start();

class CustomerController extends Controller
{
    //

    public function auth()
    {
    	return View('pages.customer_auth');
    }

    public function register(Request $request)

    {
    		$data= array();
    		$data['customer_name'] = $request->customer_name;
    		$data['customer_email'] = $request->customer_email;
    		$data['customer_tel'] = $request->customer_tel;
    		$data['customer_password'] =md5($request->customer_password);

    		$insertedId = DB::table('tbl_customer')
    		->insertGetId($data);

    		session::put('customer_id',$insertedId);
    		return Redirect::to('/cart/checkout');
    		    }

    public function login(Request $request)
    {
        $customer_email = $request->customer_email;
        $customer_password =md5($request->customer_password);
            
            $resutl = DB::table('tbl_customer')
            ->where('customer_email',$customer_email)
            ->where('customer_password',$customer_password)
            ->first();

            if ($resutl) {
                
                session::put('customer_email',$resutl->customer_email);
                session::put('customer_name',$resutl->customer_name);
                session::put('customer_id',$resutl->customer_id);

                return Redirect::to('/cart/checkout');
            }
    }


    public function logout()
    {
        if (session::get('customer_id')) {
            session::put('customer_id',null);
            session::put('customer_email',null);
            session::put('customer_name',null);

            return Redirect::to('/');
        }
    }
}
