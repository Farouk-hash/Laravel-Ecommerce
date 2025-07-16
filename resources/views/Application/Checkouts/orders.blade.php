@props(['show_save_later'=>$show_save_later , 'billing_address_array'=>$billing_address_array])

@php 
    $sub_total = 0;
    $showSaveLaterFlag = $show_save_later == 0 ? true : false;
@endphp        

<x-app
    :title="'Orders'" 
    :show_bread_crump="true"
    :breadcumptitle="'Orders'"
    :breadcumpdescription="'See More Details'"
    :cart_count="$showSaveLaterFlag"
>

    <!-- Include Orders Styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/carts/orders-styles.css') }}">

    <!-- orders section -->
    <div class="orders-section">
        <div class="orders-container">
            <div class="orders-header">
                <h1>My Orders</h1>
                <p>Track and manage all your orders in one place</p>
            </div>

            @if($billing_address_array && count($billing_address_array) > 0)
                <div class="orders-table-wrap">
                    <table class="orders-table">
                        <thead class="orders-table-head">
                            <tr class="table-head-row">
                                <th>Order ID</th>
                                <th>Delivery Address</th>
                                <th>Customer Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Total Amount</th>
                                <th>Order Date</th>
                                <th>Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($billing_address_array as $billing_address)
                                    <tr class="table-body-row">
                                        <td class="order-id">
                                            <a href="{{route('checkout.checkout-form',['show_save_later'=>1,'check_out_form_history'=>1,'order_id'=>$billing_address->id])}}" 
                                                class="order-link">
                                                <strong>#{{ str_pad($billing_address->id, 6, '0', STR_PAD_LEFT) }}</strong>
                                            </a>
                                        </td>

                                        <td class="address-cell">
                                            <div class="address-info">
                                                <i class="fas fa-map-marker-alt"></i>
                                                {{ $billing_address->address }}
                                            </div>
                                        </td>
                                        <td class="contact-info">
                                            <div class="customer-name">
                                                <i class="fas fa-user"></i>
                                                {{ $billing_address->name }}
                                            </div>
                                        </td>
                                        <td class="email-cell">
                                            <a href="mailto:{{ $billing_address->email }}">
                                                <i class="fas fa-envelope"></i>
                                                {{ $billing_address->email }}
                                            </a>
                                        </td>
                                        <td class="phone-cell">
                                            <a href="tel:{{ $billing_address->phone }}">
                                                <i class="fas fa-phone"></i>
                                                {{ $billing_address->phone }}
                                            </a>
                                        </td>
                                        <td>
                                            <span class="status-badge status-{{ strtolower($billing_address->status) }}">
                                                {{ ucfirst($billing_address->status) }}
                                            </span>
                                        </td>
                                        <td class="total-amount">
                                            ${{ number_format($billing_address->total, 2) }}
                                        </td>
                                        <td class="date-time-cell">
                                            <div class="date-info">
                                                <i class="fas fa-calendar-alt"></i>
                                                {{ \Carbon\Carbon::parse($billing_address->updated_at)->format('M d, Y') }}
                                            </div>
                                        </td>
                                        <td class="date-time-cell">
                                            <div class="time-info">
                                                <i class="fas fa-clock"></i>
                                                {{ \Carbon\Carbon::parse($billing_address->updated_at)->format('h:i A') }}
                                            </div>
                                        </td>
                                    </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-orders">
                    <i class="fas fa-shopping-bag"></i>
                    <h3>No Orders Found</h3>
                    <p>You haven't placed any orders yet. Start shopping to see your orders here!</p>
                    <a href="{{ route('shop') }}" class="btn">Start Shopping</a>
                </div>
            @endif
        </div>
    </div>
    <!-- end orders section -->
</x-app>