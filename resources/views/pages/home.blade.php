@extends('layout')
@section('feature-items')
    <h2 class="title text-center">محصولات</h2>
                @foreach($all_published_products as $product)
                  @include('items.product')
                @endforeach
 @endsection

 @section('category-tab')
 <div class="col-sm-12">
                        <ul class="nav nav-tabs">
                             @if(!empty($all_categories))
                                @php
                                     $isFirst = true;
                                @endphp
                                @foreach($all_categories as $category)
                                    @if($category->publication_status)
                                         <li 
                                            class="
                                            @if($isFirst)
                                            active
                                            @endif
                                            @php
                                                $isFirst=False;
                                            @endphp
                                            " 
                                         >
                                            <a href="#{{$category->category_name}}"   data-toggle="tab" > 
                                                {{$category->category_name}}
                                            </a>
                                         </li>
                                    @endif
                                @endforeach
                             @endif
                        </ul>
                    </div>


                    <div class="tab-content">
                        @if(!empty($all_categories))
                                @php
                                     $isFirst = true;
                                @endphp
                        @foreach($all_categories as $category)
                        <div class="tab-pane fade 
                        @if($isFirst)
                        active
                        @endif
                        @php
                            $isFirst=False;
                        @endphp
                         in" id="{{$category->category_name}}" >

                        @foreach($all_published_products as $product)
                            @if($product->category_id ==$category->category_id)
                            <div class="col-sm-3">
                                <div class="product-image-wrapper">
                                    <div class="single-products">
                                        <div class="productinfo text-center">
                                            <img src="{{URL::to($product->product_image)}}" alt="" />
                                            <h2>{{$product->product_price}}</h2>
                                            <p>{{$product->product_name}}</p>
                                            @include('items.btn_add_cart_once')
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        @endforeach


                        </div>
                        @endforeach
                        @endif

                    </div>
 @stop