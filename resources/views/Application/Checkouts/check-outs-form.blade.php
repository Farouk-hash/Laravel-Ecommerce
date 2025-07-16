@props(['cart_data'=>$cart_data , 'show_save_later'=>$show_save_later , 'user_data'=>$user_data])
@php 
    $sub_total = 0;
    $showSaveLaterFlag = $show_save_later == 0 ? true : false;
@endphp        
<x-app
    :title="'CheckOut'" 
    :show_bread_crump="true"
    :breadcumptitle="'CheckOut'"
    :breadcumpdescription="'See More Details'"
    :cart_count="$showSaveLaterFlag"
>

	<!-- check out section -->
	<div class="checkout-section mt-150 mb-150">
		<div class="container">
			<div class="row">
				<div class="col-lg-8">
					<div class="checkout-accordion-wrap">
						<div class="accordion" id="accordionExample">
						  <div class="card single-accordion">
						    <div class="card-header" id="headingOne">
						      <h5 class="mb-0">
						        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
						          Billing Address
						        </button>
						      </h5>
						    </div>

						    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
						      <div class="card-body">
						        <div class="billing-address-form">
						        	<form action="{{route('checkout.place-order')}}" method="POST">
										@csrf
						        		<p><input type="text" name="name" required placeholder="Name" value="{{old('name') ?? $user_data->name}}"></p>
						        		
										@error('email')
											<div class="error" style="color:red;">{{$message}}</div>
										@enderror
										<p><input type="email" name="email"  required placeholder="Email" value="{{old('email')??$user_data->email}}"></p>
						        		
						        		@error('address')
											<div class="error" style="color:red;">{{$message}}</div>
										@enderror
										<p><input type="text" name="address"  required placeholder="Address" value="{{old('address')??$user_data->address}}"></p>
										<p><input type="tel" name="phone"  required placeholder="Phone" value="{{old('phone')??$user_data->phone}}"></p>
						        		<p><textarea name="something" id="something" cols="30" rows="10" placeholder="Say Something"
											value="{{old('something')}}"></textarea></p>
						        	
						        </div>
						      </div>
						    </div>
						  </div>


						  <div class="card single-accordion">
						    <div class="card-header" id="headingTwo">
						      <h5 class="mb-0">
						        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
						          Shipping Address
						        </button>
						      </h5>
						    </div>
						    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
						      <div class="card-body">
						        <div class="shipping-address-form">
						        	<p>Your shipping address form is here.</p>
						        </div>
						      </div>
						    </div>
						  </div>
						 
						</div>

					</div>
				</div>

				<div class="col-lg-4">
					<div class="order-details-wrap">
						<table class="order-details">
							<thead>
								<tr> 
									<th>Your order Details</th>
									<th>Price</th>
								</tr>
							</thead>

							<tbody class="order-details-body">
								<tr>
									<td>Product</td>
									<td>Total</td>
								</tr>
                                @foreach ($cart_data as $items)
                                <tr>
									<input type="hidden" name="cart_id[]" value="{{$items->id}}">
									<td>{{$items->product->name}}</td>
									<td>${{$items->total}}</td>
                                    @php $sub_total += $items->total @endphp
								</tr>
                                @endforeach
								
							</tbody>

							<tbody class="checkout-details">
								<tr>
									<td>Subtotal</td>
									<td>${{$sub_total}}</td>
								</tr>
								<tr>
									<td>Shipping</td>
									<td>$50</td>
								</tr>
								<tr>
									<td>Total</td>
									<td>${{$sub_total}}</td>
								</tr>
							</tbody>
						</table>
						<button type="submit" name="place_order" value="place_order" class="boxed-btn" style="flex: 1;
							min-width: 120px;
							padding: 10px 0;
							font-size: 14px;
							font-weight: 600;
							border-radius: 999px;
							border: none;
							box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
							transition: background-color 0.3s ease;
							text-align: center;
							margin-bottom: 8px;
							cursor: pointer;
							text-decoration: none;
							display: inline-block;
							background-color: #F28123;
							margin-top: 15px;
    						color: white;"
						>
                            Place Order
                        </button>
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>
	<!-- end check out section -->


</x-app>