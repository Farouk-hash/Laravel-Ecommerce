@props(['cart_data' , 'show_save_later'])
@php 
    $sub_total = 0;
    $showSaveLaterFlag = $show_save_later == 0 ? true : false;
@endphp        
<x-app
    :title="'Cart'" 
    :show_bread_crump="true"
    :breadcumptitle="'Cart'"
    :breadcumpdescription="'See More Details'"
    :cart_count="$showSaveLaterFlag"
>

    <!-- Cart Styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/carts/carts-style.css') }}">

    <!-- cart -->
	<div class="cart-section mt-150 mb-150">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 col-md-12">
                   
                        <form method="POST" action="{{route('carts.update-cart')}}">
                        @csrf
                        <div class="cart-table-wrap">
                            <table class="cart-table">
                                <thead class="cart-table-head">
                                    <tr class="table-head-row">

                                        <th class="product-select">
                                            <input type="checkbox" id="select-all" onchange="toggleAll(this)">
                                            <label for="select-all">Remove</label>
                                        </th>

                                        <th class="product-buy-now">
                                            <input type="checkbox" id="buy-now-all" checked onchange="toggleBuyNowAll(this)">
                                            <label for="buy-now-all">Buy Now</label>
                                        </th>
                                        
                                        <th class="product-image">Product Image</th>
                                        <th class="product-name">Name</th>
                                        <th class="product-price">Price</th>
                                        <th class="product-quantity">Quantity</th>
                                        <th class="product-total">Total</th>

                                        <th class="product-date">Date</th>
                                        <th class="product-time">Time</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cart_data as $index => $cart)
                                        <tr class="table-body-row">
                                            <td class="product-select">
                                                <input type="checkbox" 
                                                       name="remove_items[]" 
                                                       value="{{ $cart->id }}" 
                                                       class="remove-checkbox"
                                                       id="remove-{{ $cart->id }}">
                                            </td>

                                            <td class="product-buy-now">
                                                <input type="checkbox" 
                                                       name="buy_now_items[]" 
                                                       value="{{ $cart->id }}" 
                                                       class="buy-now-checkbox"
                                                       id="buy-now-{{ $cart->id }}"
                                                       checked
                                                       onchange="updateTotals()">
                                            </td>

                                            <td class="product-image"><img src="{{Illuminate\Support\Facades\Storage::url($cart->product->file_object_key)}}" alt=""></td>
                                            
                                            <td class="product-name">
                                            <a href="{{route('product-details',[$cart->product->id])}}">
                                            {{ $cart->product->name }}</a>
                                            </td>
                                            
                                            <td class="product-price">$ {{ $cart->price }}</td>
                                            <td class="product-quantity">
                                                <input type="hidden" name="cart_items[{{ $index }}][id]" value="{{ $cart->id }}">
                                                <input type="number" name="cart_items[{{ $index }}][quantity]" value="{{ $cart->quantity }}" min="1" onchange="updateTotals()">
                                            </td>
                                            <td class="product-total" data-total="{{ $cart->total }}">${{ $cart->total }}</td>

                                            <td class="product-date">{{ \Carbon\Carbon::parse($cart->updated_at)->toDateString() }}</td>
                                            <td class="product-time">{{ \Carbon\Carbon::parse($cart->updated_at)->toTimeString() }}</td>

                                            <?php $sub_total += $cart->total ?>
                                        </tr>
                                    @endforeach
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="total-section">
                            <table class="total-table">
                                <thead class="total-table-head">
                                    <tr class="table-total-row">
                                        <th>Total</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="total-data">
                                        <td><strong>Subtotal: </strong></td>
                                        <td id="subtotal-display">$ {{$sub_total}}</td>
                                    </tr>
                                    <tr class="total-data">
                                        <td><strong>Shipping: </strong></td>
                                        <td id="shipping-display">$45</td>
                                    </tr>
                                    <tr class="total-data">
                                        <td><strong>Total: </strong></td>
                                        <td id="total-display">$ {{$sub_total + 45}}</td>
                                    </tr>
                                </tbody>
                            </table>
                            
                            <div class="cart-buttons">
                                <button type="submit" name="update_cart" value="update" class="boxed-btn">
                                    Update Cart
                                </button>

                                <button type="submit" name="remove_selected" value="remove" class="boxed-btn">
                                    Remove Selected
                                </button>
                                
                                <button type="submit" name="save_for_later" 
                                        value="{{($show_save_later) ? 1 : 0}}"
                                        class="boxed-btn">
                                    {{($show_save_later) ? 'Save for Later' : 'Return to pending'}}
                                </button>

                                <a href="{{route('checkout.checkout-form',($show_save_later) ? 1 : 0)}}" class="boxed-btn black">
                                    Check Out
                                </a>
                            </div>

                        </div>
                        </form> 
                        
                        <div class="coupon-section">
                            <h3>Apply Coupon</h3>
                            <div class="coupon-form-wrap">
                                <form action="index.html">
                                    <p><input type="text" placeholder="Coupon"></p>
                                    <p><input type="submit" value="Apply"></p>
                                </form>
                            </div>
                        </div>
				</div>
			</div>
		</div>
	</div>
	<!-- end cart -->

    <script src="{{asset('assets/js/toggle-remove-carts.js')}}"></script>

</x-app>