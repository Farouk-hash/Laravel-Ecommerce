


<x-app
	:title="__('index.products')" 
    :show_bread_crump="true"
	:breadcumptitle="__('index.products')"
>
	<!-- products -->
	<div class="product-section mt-150 mb-150">
		<div class="container">

			<x-table-toggle/>
			
			<div class="row product-lists">
				@foreach($products as $product)
					<div class="col-lg-4 col-md-6 text-center strawberry">
						<div class="single-product-item">
							<div class="product-image">
								<a href="{{route('product-details',[$product->id])}}">
									<img src="{{Illuminate\Support\Facades\Storage::url($product->file_object_key)}}"alt=""
									style="height: 150px;width:150px;"
									></a>

							</div>
							<h3>{{ Str::words($product->name, 2, '') }}</h3>
							<p class="product-price"><span>{{trans('index.price')}}</span> {{$product->price}} $ </p>
							<p class="product-price"><span>{{trans('index.quantity')}}</span> {{$product->quantity}} </p>

							<!-- 1) Cart Button (green, small) -->
							<a
							href="{{route('carts.add-to-cart' , $product->id)}}"
							class="btn btn-success btn-sm me-2"
							role="button"
							>
							<i class="fas fa-shopping-cart"></i>
							<span class="small">{{trans('index.add_to_cart')}}</span>
							</a>

							<!-- 2) Remove Button (red, small) -->
							<form
							action="{{ route('products.delete', $product->id) }}"
							method="POST"
							style="display: inline;"
							>
							@csrf
							@method('DELETE')
							<button
							type="submit"
							class="btn btn-danger btn-sm me-2"
							>
							<i class="fas fa-trash"></i>
							<span class="small">{{trans('index.remove')}}</span>
							</button>
							</form>

							<!-- 3) Edit Button (blue, small) -->
							<a
							href="{{ route('products.edit-form', $product->id) }}"
							class="btn btn-primary btn-sm"
							role="button"
							>
							<i class="fas fa-edit"></i>
							<span class="small">{{trans('index.edit')}}</span>
							</a>


						</div>
					</div>
				@endforeach
				
				
			</div>

			<x-application-pagination :items="$products" />

		</div>
	</div>
	<!-- end products -->
</x-app>