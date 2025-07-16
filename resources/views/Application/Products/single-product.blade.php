@props(['product','related_products' , 'user_reviews'])
<x-app
:title="__('index.single_product')" 

:show_bread_crump="true"
:breadcumptitle="__('index.single_product')" 
:breadcumpdescription="'See More Details'"
>	
<link rel="stylesheet" href="{{asset('assets/css/products/single-product-gallery.css')}}">

	{{-- start single product --}}
	<div class="single-product mt-150 mb-150">
		<div class="container">
			<div class="row">
				<div class="col-md-5">

					<div class="single-product-img">
						 <!-- Product Gallery with data attributes -->
						<div id="product-gallery" 
							data-images='@json($product->images && $product->images->count() > 0 ? $product->images->pluck("file_object_key")->map(fn($key) => Illuminate\Support\Facades\Storage::url($key)) : [])'
							data-fallback-image="{{ Illuminate\Support\Facades\Storage::url($product->file_object_key) }}"
							class="single-product-img">
							
							<div class="main-image-container">
								<img id="mainProductImage" src="{{ Illuminate\Support\Facades\Storage::url($product->file_object_key) }}" 
								alt="">

								<!-- Navigation arrows INSIDE the image container -->
								<button class="gallery-nav prev-btn" onclick="previousImage()">
									<i class="fas fa-chevron-left"></i>
								</button>
								<button class="gallery-nav next-btn" onclick="nextImage()">
									<i class="fas fa-chevron-right"></i>
								</button>

								<div class="image-counter">
									<span id="currentIndex">1</span> / <span id="totalImages">{{ $product->images->count() ?: 1 }}</span>
								</div>
								
							</div>

							<!-- Thumbnail slider -->
							<div class="thumbnail-slider">
								<div id="thumbnailContainer" class="thumbnail-container">
									<!-- Thumbnails will be populated by JavaScript -->
								</div>
							</div>

						</div>
					</div>

				</div>

				{{-- product-details --}}
				<div class="col-md-7">
					<div class="single-product-content">
						<h3>{{$product->name}}</h3>
						<p class="single-product-pricing"><span><i class="fas fa-box-open" style=" margin-right: 6px;color: #555"></i>{{__('index.quantity')}}</span>{{$product->quantity}}</p>
                        <p class="single-product-pricing"><span><i class="fas fa-coins" style=" margin-right: 6px;color: #555"></i>{{__('index.price')}}</span> $ {{$product->price}}</p>
						<p>{{$product->description}}</p>
						<div class="single-product-form">
							
							<form>
								<input type="number" placeholder="quantity" name="quantity" id="quantity_{{$product->id}}" min="1" value="1">
								<a href="#" onclick="addToCart({{$product->id}})" class="cart-btn">
									<i class="fas fa-shopping-cart"></i>{{__('index.add_to_cart')}}
								</a>
                        	</form>

							<p><strong>{{__('index.categories')}}: </strong>{{$product->category->name}}</p>

							<a href="{{route('rating_reviews.review-form',['question_type'=>'products' , 'product_id'=>$product->id])}}" class="cart-btn">
    							<i class="fas fa-pencil-alt"></i>{{__('index.write_review')}}
							</a>
						</div>
						<h4>{{__('index.share')}}</h4>
						<ul class="product-share">
							<li><a href=""><i class="fab fa-facebook-f"></i></a></li>
							<li><a href=""><i class="fab fa-twitter"></i></a></li>
							<li><a href=""><i class="fab fa-google-plus-g"></i></a></li>
							<li><a href=""><i class="fab fa-linkedin"></i></a></li>
						</ul>
					</div>
				</div>
				
			</div>
		</div>
	</div>
	<!-- end single product -->

	
	 <!-- single-product-reviews-section -->
    <div class="testimonail-section mt-80 mb-150">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 offset-lg-1 text-center">
                    <div class="section-title">
                        <h3><span class="orange-text">{{__('index.review_product')}}</span>{{__('index.review_product_2')}}</h3>
                        <p>{{__('index.review_product_description')}}</p>
                    </div>
                    
                    <!-- Filter Buttons -->
					<div class="filter-buttons">
						<button class="filter-btn active" data-filter="all">
							<i class="fas fa-list"></i> All Reviews
						</button>
						<button class="filter-btn" data-filter="my">
							<i class="fas fa-user"></i> My Reviews
						</button>
						<button class="filter-btn" data-filter="others">
							<i class="fas fa-users"></i> Other Reviews
						</button>
					</div>
					@if($user_reviews === null || $user_reviews === [])
						<!-- No Reviews Message (hidden by default) -->
						<div class="no-reviews" id="noReviews" style="display: none;">
							<i class="far fa-comment-alt"></i>
							<h4>No reviews found</h4>
							<p>No reviews match your current filter selection.</p>
						</div>
					@else 
						<!-- Reviews Container -->
						<div class="reviews-container" id="reviewsContainer">
							
							<!-- Sample Review 1 - Current User -->
							@foreach($user_reviews as $uv)
							<div class="single-testimonial-slider review-item" data-type="{{$uv->type}}">
								<div class="review-badge badge-own">{{$uv->type == 'my' ? 'Your Review' : 'Other Review'}}</div>
								<div class="review-header">
									<div class="client-avater">
										<img src="assets/img/avaters/avatar1.png" alt="">
									</div>
									<div class="client-info">
										<div class="rating-display">
											<div class="stars">
												@for($i = 1; $i <= 5; $i++)
													@if($i <= floor($uv->rating))
														<i class="fas fa-star"></i>
													@elseif($i == ceil($uv->rating) && $uv->rating != floor($uv->rating))
														<i class="fas fa-star-half-alt"></i>
													@else
														<i class="far fa-star"></i>
													@endif
												@endfor
											</div>
											<span class="rating-text">{{$uv->rating}}/5</span>
										</div>
									</div>
								</div>
								<div class="review-content">
									<div class="review-section">
										<div class="review-label">{{__('index.pros')}}</div>
										<p class="review-text">{{$uv->bros}}</p>
									</div>
									<div class="review-section">
										<div class="review-label">{{__('index.cons')}}</div>
										<p class="review-text">{{$uv->cons}}</p>
									</div>
								</div>
								<div class="review-date">{{ $uv->created_at->diffForHumans() }}</div>
							</div>
							@endforeach
						
							
							
						</div>
					@endif
                    
                </div>
            </div>
        </div>
    </div>
    <!-- end-single-product-reviews-section -->

	
	{{-- for navigation js --}}
	<div id="relatedProductsContainer" data-total-products="{{ count($related_products) }}">
		<!-- more related products -->
		<div class="more-products mb-150">
			<div class="container">
				<div class="row">
					<div class="col-lg-8 offset-lg-2 text-center">
						<div class="section-title">	
							<h3><span class="orange-text">Related</span> Products</h3>
							<p>Discover items that perfectly complement your choice. These handpicked products are tailored to enhance your experience and meet your needs with style and quality.</p>
						</div>

					</div>
				</div>
				
				<!-- Navigation Controls -->
				<div class="related-products-navigation">
					<button id="prevRelatedBtn" class="nav-btn prev-btn" onclick="navigateRelatedProducts('prev')">
						<i class="fas fa-chevron-left"></i>
					</button>
					<button id="nextRelatedBtn" class="nav-btn next-btn" onclick="navigateRelatedProducts('next')">
						<i class="fas fa-chevron-right"></i>
					</button>
				</div>
	
				<!-- Products Container -->
				<div class="related-products-container" style="position: relative; overflow: hidden;">
					<div id="relatedProductsSlider" class="row" style="padding-bottom: 150px; transition: transform 0.3s ease;">
						@foreach($related_products as $index => $related_product)
							<div class="col-lg-4 col-md-6 text-center related-product-item" data-index="{{ $index }}">
								<div class="single-product-item">
									<div class="product-image">
										<a href="{{route('product-details',[$related_product->id])}}"><img 
											src="{{ Illuminate\Support\Facades\Storage::url($related_product->file_object_key) }}" 
											alt=""
											style="height: 150px; width:150px;"></a>
									</div>
									<h3>{{$related_product->name}}</h3>
									<p class="product-price"><span>Per Unit</span> $ {{$related_product->price}} </p>
									<form>
										<a href="#" onclick="addToCart({{$related_product->id}})" class="cart-btn">
											<i class="fas fa-shopping-cart"></i> Add to Cart
										</a>
									</form>
								</div>
							</div>
						@endforeach
					</div>
				</div>
	
				<!-- Pagination Dots (Optional) -->
				<div class="related-products-dots" id="relatedProductsDots">
					<!-- Dots will be generated by JavaScript -->
				</div>
			</div>
		</div>
		<!-- end more products -->
	</div>

	{{-- Related Products Arrows  --}}
	<script src="{{ asset('assets/js/related-products-arrows.js') }}"></script>

	<script>

		// product-images ; 
		let currentImageIndex = 0;
		let productImages = [];

		function initializeGallery() {
		    // Get images from data attribute
		    const galleryContainer = document.getElementById('product-gallery');
		    const imagesData = galleryContainer.dataset.images;
		    const fallbackImage = galleryContainer.dataset.fallbackImage;

		    try {
		        productImages = JSON.parse(imagesData);
		        if (!productImages.length) {
		            productImages = [fallbackImage];
		        }
		    } catch (e) {
		        productImages = [fallbackImage];
		    }

		    const thumbnailContainer = document.getElementById('thumbnailContainer');
		    const totalImagesSpan = document.getElementById('totalImages');

		    totalImagesSpan.textContent = productImages.length;

		    // Only show thumbnails if there are multiple images
		    if (productImages.length > 1) {
		        productImages.forEach((image, index) => {
		            const thumbnail = document.createElement('img');
		            thumbnail.src = image;
		            thumbnail.className = 'thumbnail' + (index === 0 ? ' active' : '');
		            thumbnail.onclick = () => showImage(index);
		            thumbnailContainer.appendChild(thumbnail);
		        });
		    } else {
		        const thumbnailSlider = document.querySelector('.thumbnail-slider');
		        if (thumbnailSlider) {
		            thumbnailSlider.style.display = 'none';
		        }
		    }

		    // Hide navigation buttons if only one image
		    if (productImages.length <= 1) {
		        const navButtons = document.querySelectorAll('.gallery-nav');
		        navButtons.forEach(btn => btn.style.display = 'none');
		    }
		}

		function showImage(index) {
		    const mainImage = document.getElementById('mainProductImage');
		    const currentIndexSpan = document.getElementById('currentIndex');
		    const thumbnails = document.querySelectorAll('.thumbnail');

		    mainImage.src = productImages[index];
		    currentIndexSpan.textContent = index + 1;
		    currentImageIndex = index;

		    thumbnails.forEach((thumb, i) => {
		        thumb.classList.toggle('active', i === index);
		    });
		}

		function nextImage() {
		    if (productImages.length <= 1) return;
		    const nextIndex = (currentImageIndex + 1) % productImages.length;
		    showImage(nextIndex);
		}

		function previousImage() {
		    if (productImages.length <= 1) return;
		    const prevIndex = (currentImageIndex - 1 + productImages.length) % productImages.length;
		    showImage(prevIndex);
		}

		document.addEventListener('DOMContentLoaded', function() {
		    const mainImage = document.getElementById('mainProductImage');
		    // Keyboard navigation
		    document.addEventListener('keydown', function(e) {
		        if (productImages.length <= 1) return;
		        if (e.key === 'ArrowLeft') previousImage();
		        if (e.key === 'ArrowRight') nextImage();
		    });

		    // Initialize gallery
		    initializeGallery();
		});

		// Cart With Products , Related-Products ; 
		function addToCart(productId) {
			// Try to get quantity from input, default to 1 if not found
			const quantityElement = document.getElementById('quantity_' + productId);
			const quantity = quantityElement ? quantityElement.value : 1;
			// Generate the route URL dynamically
			const baseUrl = "{{ url('carts/carts') }}/" + productId;
			window.location.href = baseUrl + '/' + quantity;
		}

		// Keep the old function for backward compatibility (if needed elsewhere)
		function redirectToCart() {
			addToCart({{$product->id}});
		}


		  document.addEventListener('DOMContentLoaded', function() {
            const filterButtons = document.querySelectorAll('.filter-btn');
            const reviewItems = document.querySelectorAll('.review-item');
            const noReviewsMessage = document.getElementById('noReviews');
            
            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const filterType = this.getAttribute('data-filter');
                    
                    // Update active button
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                    
                    // Filter reviews
                    let visibleCount = 0;
                    
                    reviewItems.forEach(review => {
                        const reviewType = review.getAttribute('data-type');
                        
                        if (filterType === 'all' || filterType === reviewType) {
                            review.style.display = 'block';
                            review.style.animation = 'fadeInUp 0.5s ease forwards';
                            visibleCount++;
                        } else {
                            review.style.display = 'none';
                        }
                    });
                    
                    // Show/hide no reviews message
                    if (visibleCount === 0) {
                        noReviewsMessage.style.display = 'block';
                    } else {
                        noReviewsMessage.style.display = 'none';
                    }
                });
            });
        });
        
        // Add CSS animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        `;
        document.head.appendChild(style);
	
	</script>

</x-app>