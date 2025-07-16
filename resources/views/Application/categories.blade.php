
<?php 
	$title = 'Categories';
	if($activeCategory){
		foreach($categories as $index => $category){
			if($activeCategory == $category->id){
				$title = $category->name;
			}
		}
	}
?>
<x-app
    :title="$title" 
    :show_bread_crump="true"
    :breadcumptitle="$title"
>
	<!-- Categories With Products -->
	<div class="product-section mt-150 mb-150">
		<div class="container">

			<div class="row">
                <div class="col-md-12">
                    <div class="product-filters">
                        <ul>
							<li class="{{ empty($activeCategory) ? 'active' : '' }}">
								<a href="{{ route('categories') }}">{{__('index.all')}}</a>
							</li>`
							@foreach($categories as $category)
								<li class="{{ $activeCategory == $category->id ? 'active' : '' }}">
									<a href="{{ route('categories', ['category' => $category->id]) }}">
										{{ $category->name }}
									</a>
								</li>
							@endforeach
						</ul>

                    </div>
                </div>
            </div>

			


			<div class="row product-lists">
                @foreach($products as $product)
				<div class="col-lg-4 col-md-6 text-center _{{$product->category_id}}">
					<div class="single-product-item">
                        <div class="product-image">
                            <a href="single-product.html"><img style="height: 150px;width:150px;" src="{{Illuminate\Support\Facades\Storage::url($product->file_object_key)}}" alt=""></a>
						</div>
						<h3>{{$product->name}}</h3>
						<p class="product-price"><span>{{__('index.price')}}</span> {{$product->price}}$ </p>
                        <p class="product-price"><span>{{__('index.quantity')}}</span> {{$product->quantity}}</p>

						<a href="{{route('carts.add-to-cart' , $product->id)}}" class="cart-btn"><i class="fas fa-shopping-cart"></i> Add to Cart</a>
					</div>
				</div>
                @endforeach
				
			</div>

            {{-- pagnation --}}
			<x-application-pagination :items="$products" />

		</div>
	</div>
	<!-- end products -->
</x-app>