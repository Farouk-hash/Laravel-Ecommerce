@props(['order_id' => $order_id, 'order_products' => $order_products])

@php 
  
    
    $order_total = 0;
    $billing_address = $order_products;
    $order_products = $order_products->products;
    foreach($order_products as $product) {
        $order_total += $product->price * $product->quantity;
    }
     function getStatusDetails($status) {
        $status = strtolower(trim($status));
        switch($status) {
            case 'pending':
                return ['icon' => 'fas fa-clock', 'class' => 'status-pending'];
            case 'processing':
                return ['icon' => 'fas fa-spinner', 'class' => 'status-processing'];
            case 'shipped':
                return ['icon' => 'fas fa-truck', 'class' => 'status-shipped'];
            case 'delivered':
                return ['icon' => 'fas fa-check-circle', 'class' => 'status-delivered'];
            case 'completed':
                return ['icon' => 'fas fa-check-double', 'class' => 'status-completed'];
            case 'canceled':
            case 'cancelled':
                return ['icon' => 'fas fa-times-circle', 'class' => 'status-canceled'];
            case 'refunded':
                return ['icon' => 'fas fa-undo', 'class' => 'status-refunded'];
            case 'failed':
                return ['icon' => 'fas fa-exclamation-triangle', 'class' => 'status-failed'];
            default:
                return ['icon' => 'fas fa-question-circle', 'class' => 'status-unknown'];
        }
    }
@endphp

<x-app
    :title="'Order Details - #' . str_pad($order_id, 6, '0', STR_PAD_LEFT)" 
    :show_bread_crump="true"
    :breadcumptitle="'Order Details'"
    :breadcumpdescription="'View order information and products'"
    :cart_count="true"
>

    <!-- Include Orders Styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/carts/orders-styles.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/carts/orders-details-styles.css') }}">

    <!-- Order Details Section -->
    <div class="orders-section">
        <div class="orders-container">
            <div class="orders-header">
                <h1>Order Details</h1>
                <p>Order #{{ str_pad($order_id, 6, '0', STR_PAD_LEFT) }} - Complete order information</p>
                <div class="order-actions">
                    <a href="{{route('checkout.checkout-form',[1,1])}}" class="btn-back">
                        <i class="fas fa-arrow-left"></i> Back to Orders
                    </a>
                </div>
            </div>

            <!-- Order Summary Card -->
            <div class="order-summary-card">
                <div class="order-info-grid">
                    <div class="order-info-item">
                        <h4><i class="fas fa-hashtag"></i> Order ID</h4>
                        <p>#{{ str_pad($order_id, 6, '0', STR_PAD_LEFT) }}</p>
                    </div>
                    <div class="order-info-item">
                        <h4><i class="fas fa-calendar-alt"></i> Order Date</h4>
                        <p>{{ \Carbon\Carbon::parse($billing_address->created_at)->toDateString()}}</p>
                    </div>
                    <div class="order-info-item">
                        <h4><i class="fas fa-clock"></i> Order Time</h4>
                        <p>{{ \Carbon\Carbon::parse($billing_address->created_at)->format('h:i A') }}</p>
                    </div>
                    {{-- <div class="order-info-item">
                        <h4><i class="fas fa-tag"></i> Status</h4>
                        <span class="status-badge status-processing">{{$billing_address->status}}</span>
                    </div> --}}
                    <div class="order-info-item">
                        <h4><i class="fas fa-dollar-sign"></i> Total Amount</h4>
                        <p class="total-amount">${{ number_format($order_total, 2) }}</p>
                    </div>
                </div>
            </div>

            <!-- Products Table -->
            @if($order_products && count($order_products) > 0)
                <div class="orders-table-wrap">
                    <div class="table-header">
                        <h3><i class="fas fa-shopping-cart"></i> Ordered Products</h3>
                    </div>
                    <table class="orders-table">
                        <thead class="orders-table-head">
                            <tr class="table-head-row">
                                <th>Product Image</th>
                                <th>Product ID</th>
                                <th>Product Name</th>
                                <th>Description</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Total Price</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order_products as $product)
                                <tr class="table-body-row">
                                    <td class="product-image-cell">
                                        <div class="product-image-wrapper">
                                            <img 
                                                src="{{Illuminate\Support\Facades\Storage::url($product->image)}}" 
                                                 alt="{{ $product->name }}" 
                                                 class="product-image">
                                        </div>
                                    </td>
                                   <td class="product-id-cell">
                                        <a href="{{ route('product-details', $product->id) }}" class="product-id-link">
                                            <span class="product-id">
                                                #{{ str_pad($product->id, 4, '0', STR_PAD_LEFT) }}
                                            </span>
                                        </a>
                                    </td>
                                    <td class="product-name-cell">
                                        <div class="product-name">
                                            <strong>{{ $product->name }}</strong>
                                        </div>
                                    </td>
                                    <td class="product-description-cell">
                                        <div class="product-description">
                                            {{ $product->description }}
                                        </div>
                                    </td>
                                    <td class="quantity-cell">
                                        <div class="quantity-info">
                                            <span class="quantity-badge">{{ $product->quantity }}</span>
                                        </div>
                                    </td>
                                    <td class="price-cell">
                                        <div class="unit-price">
                                            ${{ number_format($product->price, 2) }}
                                        </div>
                                    </td>
                                    <td class="total-price-cell">
                                        <div class="product-total">
                                            ${{ number_format($product->price * $product->quantity, 2) }}
                                        </div>
                                    </td>
                                    <td class="order-info-item">
                                        @php $statusDetails = getStatusDetails($product->status) @endphp
                                        <span class="status-badge {{ $statusDetails['class'] }}">
                                            <i class="{{ $statusDetails['icon'] }}"></i>
                                            {{ ucfirst($product->status) }}
                                        </span>
                                    </td>
                                   
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="orders-table-foot">
                            <tr class="total-row">
                                <td colspan="6" class="total-label">
                                    <strong>Order Total:</strong>
                                </td>
                                <td class="grand-total">
                                    <strong>${{ number_format($order_total, 2) }}</strong>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @else
                <div class="empty-orders">
                    <i class="fas fa-box-open"></i>
                    <h3>No Products Found</h3>
                    <p>This order appears to be empty or the products could not be loaded.</p>
                    <a href="{{ route('orders.index') }}" class="btn">Back to Orders</a>
                </div>
            @endif
        </div>
    </div>
    <!-- end order details section -->

 

</x-app>