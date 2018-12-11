@extends('admin.layout')
@section('admin_area')

			<ul class="breadcrumb">
				<li>
					<i class="icon-home"></i>
					<a href="{{URL::to('/admin/dashboard')}}">پیشخوان</a>
					<i class="icon-angle-right"></i> 
				</li>
				<li>
					<i class="icon-edit"></i>
					<a href="{{URL::to('/admin/manufacture/update')}}">بروزرسانی برند</a>
				</li>
			</ul>

				<?php 
						// Alert for success add new Manufacture

							if (Session::get('msg')) {
								echo '<p class="alert alert-success">';
								echo Session::get('msg');
								echo '</p>';

								Session::put('msg',null);
							}
						?>
						
			
			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon edit"></i><span class="break"></span>بروزرسانی برند </h2>
						<div class="box-icon">
							<a href="#" class="btn-setting"><i class="halflings-icon wrench"></i></a>
							<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
						</div>
					</div>
					
					<div class="box-content">
						<form class="form-horizontal" action="
						{{
							URL::to(
								'/admin/manufacture/'.$manufacture_infos->manufacture_id.'/update/done'
							)
						}}
							" method="POST" >
							{{csrf_field()}}
						  <fieldset>

							<div class="control-group">
							  <label class="control-label" for="manufacture_name">نام</label>
							  <div class="controls">
								<input type="text" class="input-xlarge" id="manufacture_name" name="manufacture_name" value="{{$manufacture_infos->manufacture_name}}">
							  </div>
							</div>
   
							<div class="control-group hidden-phone">
							  <label class="control-label" for="manufacture_description">توضیحات</label>
							  <div class="controls">
								<textarea class="cleditor" id="manufacture_description" name="manufacture_description" rows="3">
									{{$manufacture_infos->manufacture_description}}
								</textarea>
							  </div>
							</div>


							<div class="control-group hidden-phone">
							  <label class="control-label" for="publication_status">وضعیت انتشار </label>
							  <div class="controls">

								<input type="checkbox" class="cleditor" id="publication_status" name="publication_status" 
								@if($manufacture_infos->publication_status)
								checked 
								@endif 
								/>

							  </div>
							</div>


							<div class="form-actions">
							  <button type="submit" class="btn btn-success">بروزرسانی</button>
							  <a href="{{URL::to('/admin/manufacture/all')}}" class="btn">انصراف</a>
							</div>
						  </fieldset>
						</form>   

					</div>
				</div><!--/span-->

			</div><!--/row-->


@endsection