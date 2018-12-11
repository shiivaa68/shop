@extends('admin.layout')
@section('admin_area')

		<ul class="breadcrumb">
				<li>
					<i class="icon-home"></i>
					<a href="{{URL::to('/admin/dashboard')}}">پیشخوان</a> 
					<i class="icon-angle-right"></i>
				</li>
				<li><a href="{{URL::to('/admin/all_categories')}}">همه ی دسته بندی ها</a></li>
			</ul>
						 <?php 
						// Alert for success add new Category
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
						<h2><i class="halflings-icon user"></i><span class="break"></span>همه ی دسته بندی ها</h2>
						<div class="box-icon">
							<a href="#" class="btn-setting"><i class="halflings-icon wrench"></i></a>
							<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>

							  	  <th>آیدی دسته</th>
								  <th>نام دسته</th>
								  <th>توضیحات دسته</th>
								  <th>وضعیت انتشار</th>
								  <th>عملیات</th>
							  </tr>
						  </thead>   
						  <tbody>
						  	@foreach($all_categories as $category)
							<tr>
								<td>{{ $category->category_id}}</td>
								<td class="center">{{ $category->category_name}}</td>
								<td class="center">{{ $category->category_description}}</td>
								<td class="center">
									@if($category->publication_status)
									<span class="label label-success">فعال</span>

									@else
									<span class="label label-unsuccess">غیرفعال</span>
									@endif 


								</td>
								<td class="center">
									
									@if($category->publication_status)
									<a class="btn btn-unsuccess" href="{{URL::to('/admin/category/'.$category->category_id.'/unactive')}}">
										<i class="halflings-icon white remove"></i>  
									</a>
									@else
									<a class="btn btn-success" href="{{URL::to('/admin/category/'.$category->category_id.'/active')}}">
										<i class="halflings-icon white ok"></i>  
									</a>
									@endif
									


									<a class="btn btn-info" href="{{URL::to('/admin/category/'.$category->category_id.'/edit')}}">
										<i class="halflings-icon white edit"></i>  
									</a>

									<a 
									class="btn btn-danger" 
									href="{{URL::to('/admin/category/'.$category->category_id.'/delete')}}"
									onclick="return confirm('آیا مطمئن هستید ؟  ')"
									>
										<i class="halflings-icon white trash"></i> 
									</a>
								</td>
							</tr>
							@endforeach
						  </tbody>
					  </table>            
					</div>
				</div><!--/span-->
			
			</div><!--/row-->
@endsection