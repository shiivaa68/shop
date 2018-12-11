<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use DB;
use Session;

session_start();


class SuperAdminController extends Controller
{
    //

    public function logout()
    {
    	//Session::put('admin_name',null);
    	//Session::put('admin_id',null);
    	//Session::put('admin_email',null);
    	Session::flush();
    	return Redirect::to('/admin');

    }


    public static function AdminAuthCheck()
    {
        $admin_auth_id = Session::get('admin_id');
        if ($admin_auth_id) {
           return;
        }else
        {
            session::put('msg','for access here you must login first ');
            return Redirect::to('/admin')->send();
        }
    }
}
