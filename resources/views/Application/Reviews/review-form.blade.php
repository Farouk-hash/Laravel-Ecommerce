<x-app
    :title="'Review Form'" 
    :show_bread_crump="true"
    :breadcumptitle="'Review Form'"
    :breadcumpdescription="'Create Your Own Review'"
>	


	<div class="product-section mt-150 mb-150">
		<div class="container">
            <div class="contact-form">
                {{-- Showing-Error --}}
                <form method="POST" action="{{route('store-product')}}">
                    @csrf
                    <p style="display: flex; justify-content: center; gap:5px;">
                        <input type="text" style="width: 50%;" placeholder="Name" name="name" id="name">
						<input type="text" style="width: 50%;" placeholder="Phonenumber" name="phonenumber" id="phonenumber">
                    </p>
                    <p style="display: flex;  justify-content: center; gap:5px;">
                        <input type="text" min="0" style="width: 50%; " 
                        placeholder="email" name="email" id="email" value=""
                        >
                        <input type="text" min="0"style="width: 50%;" 
                        placeholder="Address" name="address" id="address"value="" 
                        >
                    </p>
                 
                    <p><textarea name="description" id="description" cols="30" rows="2" placeholder="description">{{old('description',$product->description??'')}}</textarea></p>
                  
                    <p><input type="submit" value="Submit"></p>
                </form>
            </div>
		</div>
	</div>

	<!-- testimonail-section -->
	<div class="testimonail-section mt-80 mb-150">
		<div class="container">
			<div class="row">
				<div class="col-lg-10 offset-lg-1 text-center">
					<div class="testimonial-sliders">
						<div class="single-testimonial-slider">
							<div class="client-avater">
								<img src="assets/img/avaters/avatar1.png" alt="">
							</div>
							<div class="client-meta">
								<h3>Saira Hakim <span>Local shop owner</span></h3>
								<p class="testimonial-body">
									" Sed ut perspiciatis unde omnis iste natus error veritatis et  quasi architecto beatae vitae dict eaque ipsa quae ab illo inventore Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium "
								</p>
								<div class="last-icon">
									<i class="fas fa-quote-right"></i>
								</div>
							</div>
						</div>
						<div class="single-testimonial-slider">
							<div class="client-avater">
								<img src="assets/img/avaters/avatar2.png" alt="">
							</div>
							<div class="client-meta">
								<h3>David Niph <span>Local shop owner</span></h3>
								<p class="testimonial-body">
									" Sed ut perspiciatis unde omnis iste natus error veritatis et  quasi architecto beatae vitae dict eaque ipsa quae ab illo inventore Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium "
								</p>
								<div class="last-icon">
									<i class="fas fa-quote-right"></i>
								</div>
							</div>
						</div>
						<div class="single-testimonial-slider">
							<div class="client-avater">
								<img src="assets/img/avaters/avatar3.png" alt="">
							</div>
							<div class="client-meta">
								<h3>Jacob Sikim <span>Local shop owner</span></h3>
								<p class="testimonial-body">
									" Sed ut perspiciatis unde omnis iste natus error veritatis et  quasi architecto beatae vitae dict eaque ipsa quae ab illo inventore Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium "
								</p>
								<div class="last-icon">
									<i class="fas fa-quote-right"></i>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end testimonail-section -->



</x-app>