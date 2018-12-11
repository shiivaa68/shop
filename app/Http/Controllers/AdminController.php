<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use DB;
use Session;

session_start();

class AdminController extends Controller
{
    //
    public function dashboard(Request $request)
    {
        if (session::get('admin_email')) {

            return View ('admin.dashboard');
        }else
        {  
        	// return View('admin.dashboard');	
        	$admin_email = $request->admin_email;
        	$admin_password =md5($request->admin_password);
        	
        	$resutl = DB::table('tbl_admin')
        	->where('admin_email',$admin_email)
        	->where('admin_password',$admin_password)
        	->first();
        	if ($resutl) {
                
        		session::put('admin_name',$resutl->admin_name);
        		session::put('admin_id',$resutl->admin_id);
                session::put('admin_email',$resutl->admin_email);
        		return Redirect('admin/dashboard');
        	}else
        	{
        
        			session::put('msg','ایمیل یا رمز شما اشتباه هست ');
        			return Redirect('admin/');//admin login
        	}

        }
    }

    public function login()
    {
    	return View ('admin.login');
    }
    
}
