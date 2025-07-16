<x-app>
	<x-slot:title>E-Commerce</x-slot:title>
	<x-slot:show_nav_bar>true</x-slot:show_nav_bar>
	<x-slot:show_feature_list>true</x-slot:show_feature_list>
	
	<!-- Category section -->
	<div class="product-section mt-150 mb-150">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 offset-lg-2 text-center">
					<div class="section-title">	
						<h3><span class="orange-text">Our</span> Categories</h3>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid, fuga quas itaque eveniet beatae optio.</p>
					</div>
				</div>
			</div>

			<div class="row">
				@foreach ($categories as $category)
					<div class="col-lg-4 col-md-6 text-center">
					<div class="single-product-item">
							<div class="product-image">
								<a href="/products/{{$category->id}}">
									<img src="{{ Illuminate\Support\Facades\Storage::url($category->file_object_key) }}" 
									style="max-height: 150px;max-width:150px;"  alt="">
								</a>

							</div>
							<h3>{{$category->name}}</h3>
							<p class="product-price"><span>Per Product</span> {{$category->products->count()}} </p>
							<a href="{{route('categories')}}?category={{$category->id}}" class="cart-btn"><i class="fas fa-eye"></i> Show Details</a>
						</div>
						
					</div>
				@endforeach

			</div>

		</div>
		<!-- Pagination Links -->
		<x-application-pagination :items="$categories" />
	</div>
	<!-- end product section -->
	

</x-app>	