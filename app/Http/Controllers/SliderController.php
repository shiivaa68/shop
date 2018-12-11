<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Redirect;
use Session;

//session_start();

class SliderController extends Controller
{
    //
    public function all()
    {
    	$all_sliders = DB::table('tbl_slider')->get();
        return View('admin.all_sliders')->with('all_sliders',$all_sliders);
  
    }
    public function add()
    {
   		return View('admin.add_slider'); 	
    }

	public function save(Request $request)
    {
    	$data = array();

        $data['slider_title'] = $request->slider_title;
        $data['slider_description'] = $request->slider_description;
        $data['slider_button_lable'] = $request->slider_button_lable;
        $data['slider_link'] = $request->slider_link;

		$image = $request->file('slider_image');
        $image_off = $request->file('slider_off_image');

		if ($image) {
			$image_name = date('mdYHis');
			$ext = strtolower($image->getClientOriginalExtension());
			$image_full_name = $image_name.".".$ext;
			$upload_url = 'images/mSlider/';
			$image_url = $upload_url.$image_full_name;
			$isUploaded = $image->move($upload_url,$image_full_name);
			if ($isUploaded) {
				$data['slider_image']=$image_url;
			}else
			{
				$data['slider_image']=null;
			}


            if ($image_off) {
                $image_off_name = date('mdYHis');
                $ext_off = strtolower($image_off->getClientOriginalExtension());
                $image_off_full_name = $image_off_name.".".$ext_off;
                $upload_url_image_off = 'images/mSlider/off/';
                $image_off_url = $upload_url_image_off.$image_off_full_name;
                $isUploaded = $image_off->move($upload_url_image_off,$image_off_full_name);
                if ($isUploaded) {
                    $data['slider_off_image']=$image_off_url;
                }else
                {
                    $data['slider_off_image']=null;
                }
            }

			if ($request->publication_status == 'on') {
    			$data['publication_status'] = 1;
    		}else
    		{
    			$data['publication_status'] = 0;
    		}

    		// Insert data to database
			if(DB::table('tbl_slider')->insert($data))
       		 {
           	     session::put('msg','Slider saved ! ');
           	     return Redirect::to('/admin/slider/all'); 
       		 }else

      		  {
           	     session::put('msg','Slider not saved!');
           	     return Redirect::to('/admin/slider/all'); 
     		   }

		}
	}


  public function unactive($slider_id)
    {
        SuperAdminController::AdminAuthCheck();
       // Make Publication_status =  0 
        DB::table('tbl_slider')
        ->where('slider_id',$slider_id)
        ->update(['publication_status'=>0]);
        session::put('msg','slider publication status UnActived ! ');
        return Redirect::to('admin/slider/all');
    }

    public function active($slider_id)
    {
        SuperAdminController::AdminAuthCheck();
       // Make Publication_status =  0 
        DB::table('tbl_slider')
        ->where('slider_id',$slider_id)
        ->update(['publication_status'=>1]);
        session::put('msg','slider publication status Actived ! ');
        return Redirect::to('admin/slider/all');
    }

    public function delete($slider_id)
    {
        SuperAdminController::AdminAuthCheck();
            $isDeleted = DB::table('tbl_slider')
            ->where('slider_id',$slider_id)
            ->delete();

            if ($isDeleted) {
                session::put('msg','Slider Deleted successfully');
                return Redirect::to('/admin/slider/all'); 
            }else
            {
                session::put('msg','Slider Could Not Be Deleted');
                return Redirect::to('/admin/slider/all');    
            }
    }

}
