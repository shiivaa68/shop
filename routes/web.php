<?php


// ------------------- FRONEND  -------------------------------------------
Route::get('/','HomeController@index');
//E 27
Route::get('/category/{category_id}/{category_name}','HomeController@displayCategoryProducts');
Route::get('/brand/{manufacture_id}/{manufacture_name}','HomeController@displayManufactureProducts');
//E 28
Route::get('/product/{product_id}/{product_name}','HomeController@displayProductDetails');
//E 29
Route::post('/cart/add','CartController@add');
// E30
Route::get('/cart','CartController@cart');
// E31 
Route::get('/cart/delete/item/{cart_id}','CartController@deletItem');
// E32
Route::get('/cart/{cart_id}/increment','CartController@increment');
Route::get('/cart/{cart_id}/decrement','CartController@decrement');
// E33   --------- Checkout routes -----------
Route::get('/cart/checkout','CartController@checkout');
Route::get('/customer/auth','CustomerController@auth');
// E 34 
Route::post('/customer/register','CustomerController@register');
Route::post('/customer/login','CustomerController@login');
// E36
Route::post('/cart/shipping/save','CartController@save_shipping');
Route::get('/cart/payment','CartController@payment');
// E38 
Route::post('/cart/payment/do','CartController@do_payment');

// E40
Route::get('/payment/zarinpal/callback','CartController@zarinpalCallback')->name('payment.zarinpal.callback');
// E42
Route::get('/cart/success','CartController@success');
//E44
Route::post('/search/keyword/','SearchController@keyword');
// E45
Route::get('/wishlist/all','WishlistController@all');
// E46
Route::get('/wishlist/add/{customer_id}/product/id/{product_id}','WishlistController@add');
Route::get('/wishlist/remove/{wishlist_id}','WishlistController@remove');
Route::get('/customer/logout','CustomerController@logout');


// ------------------- BACKEND  -------------------------------------------
Route::get('/admin','AdminController@login');
Route::post('/admin/dashboard','AdminController@dashboard'); // when post admin_email admin_password 
Route::get('/admin/dashboard','AdminController@dashboard'); // when nothing posted 
Route::get('/admin/destroy',function(){
	Session::flush();
});

// E 07 ---------
Route::get('/logout','SuperAdminController@logout');

// CATEGORY ROUTES
// E 08 
Route::get('/admin/category/add','CategoryController@add'); // Edited in E 17 -- 
// E 09
Route::get('/admin/category/all','CategoryController@all_categories');
// E 10 
Route::post('/admin/save_new_category','CategoryController@save_category');
//E 13
Route::get('/admin/category/{category_id}/unactive','CategoryController@unactive');
Route::get('/admin/category/{category_id}/active','CategoryController@active');
//E 14
Route::get('/admin/category/{category_id}/edit','CategoryController@edit');
Route::post('/admin/category/{category_id}/done_update/','CategoryController@done_update');
//E 15
Route::get('/admin/category/{category_id}/delete','CategoryController@delete');	


// MANUFACTURE ROUTES
//E 17 
Route::get('/admin/manufacture/add','ManufactureController@add');
Route::post('/admin/manufacture/save','ManufactureController@save');
Route::get('/admin/manufacture/all','ManufactureController@all');

//E 18
Route::get('/admin/manufacture/{manufacture_id}/delete','ManufactureController@delete');	
Route::get('/admin/manufacture/{manufacture_id}/active','ManufactureController@active');
Route::get('/admin/manufacture/{manufacture_id}/unactive','ManufactureController@unactive');
Route::get('/admin/manufacture/{manufacture_id}/update','ManufactureController@update');
Route::post('/admin/manufacture/{manufacture_id}/update/done','ManufactureController@update_done');

//E 19
Route::get('/admin/product/add','ProductController@add');

//E 20 
Route::post('/admin/product/save','ProductController@save');

// E 21 
Route::get('/admin/product/all','ProductController@all');

// E 22 
Route::get('/admin/product/{product_id}/unactive','ProductController@unactive');
Route::get('/admin/product/{product_id}/active','ProductController@active');
Route::get('/admin/product/{product_id}/delete','ProductController@delete');

// E 25
Route::get('/admin/slider/add','SliderController@add');
Route::get('/admin/slider/all','SliderController@all');
Route::post('/admin/slider/save','SliderController@save');

//E 27
Route::get('/admin/slider/{slider_id}/active','SliderController@active');
Route::get('/admin/slider/{slider_id}/unactive','SliderController@unactive');
Route::get('/admin/slider/{slider_id}/delete','SliderController@delete');