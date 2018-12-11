<form method="post" action="{{URL::to('/cart/add')}}">

	{{csrf_field()}}
	<input  name="qty" id="qty" type="hidden" value="1" />
	<input type="hidden" value="
	{{$product->product_id}}
	" id="product_id" name="product_id">

	<button type="Submit" class="btn btn-fefault cart">
		<i class="fa fa-shopping-cart"></i>
		افزودن به سبد خرید
	</button>
</form>
