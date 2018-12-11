<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Redirect;
use Session;
use App\Http\Controllers\SuperAdminController;


class ManufactureController extends Controller
{
    //
    public function index()
    {
    	echo 'ManufactureController is working ... ';
    }

    public function add()
    {
        SuperAdminController::AdminAuthCheck();
    	return View('admin.add_manufacture');
    }

   public function save(Request $request)
    {
        SuperAdminController::AdminAuthCheck();
    	// add all new category data in DB ::
    	$data = array();
    	$data['manufacture_name'] = $request->manufacture_name;
    	$data['manufacture_description'] = $request->manufacture_description;

    	if ($request->publication_status == 'on') {
    		$data['publication_status'] = 1;
    	}else
    	{
    		$data['publication_status'] = 0;
    	}
		

		if(DB::table('tbl_manufacture')->insert($data))
			{
				session::put('msg','added successfully new manufacture to database');
				return Redirect::to('/admin/manufacture/add');	
			}else{ echo 'false'; }
    }

    public function all()
    {
        SuperAdminController::AdminAuthCheck();
    	 $all_manufactures = DB::table('tbl_manufacture')->get();
    	return View('admin.all_manufactures')
    	->with('all_manufactures',$all_manufactures);
    }

    public function delete($manufacture_id)
    {
        SuperAdminController::AdminAuthCheck();

         $isDeleted = DB::table('tbl_manufacture')
            ->where('manufacture_id',$manufacture_id)
            ->delete();

            if ($isDeleted) {
                session::put('msg','Brand Deleted successfully');
                return Redirect::to('/admin/manufacture/all'); 
            }else
            {
                session::put('msg','Brand Could Not Be Deleted');
                return Redirect::to('/admin/manufacture/all');    
            }
    }



   public function unactive($manufacture_id)
    {
        SuperAdminController::AdminAuthCheck();
       // Make Publication_status =  0 
        DB::table('tbl_manufacture')
        ->where('manufacture_id',$manufacture_id)
        ->update(['publication_status'=>0]);
        session::put('msg','Bramd publication status UnActived ! ');
        return Redirect::to('admin/manufacture/all');
    }

    public function active($manufacture_id)
    {
        SuperAdminController::AdminAuthCheck();
       // Make Publication_status =  1 
        DB::table('tbl_manufacture')
        ->where('manufacture_id',$manufacture_id)
        ->update(['publication_status'=>1]);
        session::put('msg','Bramd publication status UnActived ! ');
        return Redirect::to('admin/manufacture/all');
    }


    public function update($manufacture_id)
    {
        SuperAdminController::AdminAuthCheck();
            //echo $category_id;
       $data =  DB::table('tbl_manufacture')
        ->where('manufacture_id',$manufacture_id)
        ->get()->first();

        return View('admin.edit_manufacture')->with('manufacture_infos',$data);

    }
    public function update_done(Request $request , $manufacture_id)
    {
        SuperAdminController::AdminAuthCheck();
            //echo $category_id;
        $update_info = array();
        $update_info['manufacture_name']=$request->manufacture_name;
        $update_info['manufacture_description']=$request->manufacture_description;

        if ($request->publication_status == 'on') {
            $update_info['publication_status'] = 1;
        }else
        {
            $update_info['publication_status'] = 0;
        }

        $isUpdated = DB::table('tbl_manufacture')
        ->where('manufacture_id',$manufacture_id)
        ->update($update_info);
        if ($isUpdated) {
            session::put('msg','Manufacture Updated successfully');
            return Redirect::to('/admin/manufacture/all'); 
        }else
        {
            session::put('msg','Manufacture Could NOT updated');
            return Redirect::to('/admin/manufacture/all'); 
        }


    }


}
