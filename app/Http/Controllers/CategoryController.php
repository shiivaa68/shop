<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Redirect;
use Session;
use App\Http\Controllers\SuperAdminController;

class CategoryController extends Controller
{
    public function add()
    {
       SuperAdminController::AdminAuthCheck();
       return View('admin.add_category');
    }


    public function all_categories()
    {
        SuperAdminController::AdminAuthCheck();
        $all_categories = DB::table('tbl_category')->get();
    	return View('admin.all_categories')->with('all_categories',$all_categories);

    }

    public function save_category(Request $request)
    {
        SuperAdminController::AdminAuthCheck();
    	
 		// add all new category data in DB ::
    	$data = array();
    	$data['category_name'] = $request->category_name;
    	$data['category_description'] = $request->category_description;
    	if ($request->publication_status == 'on') {
    		$data['publication_status'] = 1;
    	}else
    	{
    		$data['publication_status'] = 0;
    	}
		

		if(DB::table('tbl_category')->insert($data))
			{
				session::put('msg','دسته بندی با موفقیت اضافه شد');
				return Redirect::to('/admin/category/add');	
			}else{ echo 'false'; }

    }


    public function unactive($category_id)
    {
        SuperAdminController::AdminAuthCheck();
       // Make Publication_status =  0 
        DB::table('tbl_category')
        ->where('category_id',$category_id)
        ->update(['publication_status'=>0]);
        session::put('msg','category publication status UnActived ! ');
        return Redirect::to('admin/all_categories');
    }

    public function active($category_id)
    {
        SuperAdminController::AdminAuthCheck();
       // Make Publication_status =  1
        DB::table('tbl_category')
        ->where('category_id',$category_id)
        ->update(['publication_status'=>1]);
        session::put('msg','category publication status Actived ! ');
        return Redirect::to('admin/all_categories');
    }

    public function edit($category_id)
    {
        SuperAdminController::AdminAuthCheck();
            //echo $category_id;
       $data =  DB::table('tbl_category')
        ->where('category_id',$category_id)
        ->get()->first();

        return View('admin.edit_category')->with('category_infos',$data);

    }
    public function done_update(Request $request , $category_id)
    {
        SuperAdminController::AdminAuthCheck();
            //echo $category_id;
        $update_info = array();
        $update_info['category_name']=$request->category_name;
        $update_info['category_description']=$request->category_description;

        if ($request->publication_status == 'on') {
            $update_info['publication_status'] = 1;
        }else
        {
            $update_info['publication_status'] = 0;
        }

        $isUpdated = DB::table('tbl_category')
        ->where('category_id',$category_id)
        ->update($update_info);
        if ($isUpdated) {
            session::put('msg','Category Updated successfully');
            return Redirect::to('/admin/all_categories'); 
        }else
        {
            session::put('msg','Category Could NOT updated');
            return Redirect::to('/admin/all_categories'); 
        }


    }


    public function delete($category_id)
    {
        SuperAdminController::AdminAuthCheck();
            $isDeleted = DB::table('tbl_category')
            ->where('category_id',$category_id)
            ->delete();

            if ($isDeleted) {
                session::put('msg','Category Deleted successfully');
                return Redirect::to('/admin/all_categories'); 
            }else
            {
                session::put('msg','Category Could Not Be Deleted');
                return Redirect::to('/admin/all_categories');    
            }
    }
}
