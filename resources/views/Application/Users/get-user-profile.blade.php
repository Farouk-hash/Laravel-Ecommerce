<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Customer Profile">
    <meta name="csrf-token" content="{{csrf_token()}}">
    
    <!-- title -->
    <title>My Account - {{$title ?? 'Customer Profile'}}</title>

    <!-- favicon -->
    <link rel="shortcut icon" type="image/png" href="{{asset('assets/img/favicon.png')}}">
    <!-- google font -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
    <!-- fontawesome -->
    <link rel="stylesheet" href="{{asset('assets/css/all.min.css')}}">
    <!-- bootstrap -->
    <link rel="stylesheet" href="{{asset('assets/bootstrap/css/bootstrap.min.css')}}">
    <!-- owl carousel -->
    <link rel="stylesheet" href="{{asset('assets/css/owl.carousel.css')}}">
    <!-- magnific popup -->
    <link rel="stylesheet" href="{{asset('assets/css/magnific-popup.css')}}">
    <!-- animate css -->
    <link rel="stylesheet" href="{{asset('assets/css/animate.css')}}">
    <!-- mean menu css -->
    <link rel="stylesheet" href="{{asset('assets/css/meanmenu.min.css')}}">
    <!-- main style -->
    <link rel="stylesheet" href="{{asset('assets/css/main.css')}}">
    <!-- responsive -->
    <link rel="stylesheet" href="{{asset('assets/css/responsive.css')}}">
    
    <style>
        :root {
            --primary-color: #051922;
            --secondary-color: #0a2831;
            --accent-color: #28a745;
            --light-bg: #f8f9fa;
            --border-color: #e9ecef;
            --text-muted: #6c757d;
            --success-bg: #d4edda;
            --success-text: #155724;
            --warning-bg: #fff3cd;
            --warning-text: #856404;
            --info-bg: #cce7ff;
            --info-text: #004085;
        }
        
        .account-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            padding: 40px 0;
            color: white;
        }
        
        .profile-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 3px solid #fff;
            object-fit: cover;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
        
        .account-name {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            color: #fff;
            margin-bottom: 5px;
        }
        
        .member-since {
            color: rgba(255,255,255,0.8);
            font-size: 14px;
        }
        
        .account-card {
            background: #fff;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 25px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(5,25,34,0.08);
        }
        
        .account-card:hover {
            box-shadow: 0 6px 20px rgba(5,25,34,0.15);
            transform: translateY(-2px);
        }
        
        .account-card h4 {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 20px;
            font-size: 18px;
        }
        
        .info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #f1f3f4;
        }
        
        .info-item:last-child {
            border-bottom: none;
        }
        
        .info-label {
            font-weight: 600;
            color: var(--primary-color);
        }
        
        .info-value {
            color: var(--text-muted);
        }
        
        .order-item {
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 15px;
            background: #fff;
            transition: all 0.3s ease;
        }
        
        .order-item:hover {
            box-shadow: 0 4px 12px rgba(5,25,34,0.1);
        }
        
        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .order-id {
            font-weight: 600;
            color: var(--primary-color);
        }
        
        .order-status {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .status-delivered {
            background: var(--success-bg);
            color: var(--success-text);
        }
        
        .status-pending {
            background: var(--warning-bg);
            color: var(--warning-text);
        }
        
        .status-processing {
            background: var(--info-bg);
            color: var(--info-text);
        }
        
        .product-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        
        .product-img {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            margin-right: 15px;
            object-fit: cover;
        }
        
        .product-details h6 {
            margin: 0 0 5px 0;
            font-weight: 600;
            color: var(--primary-color);
        }
        
        .product-price {
            color: var(--accent-color);
            font-weight: 600;
        }
        
        .link-edit {
            background: var(--primary-color);
            border: none;
            color: #fff;
            padding: 8px 20px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }
        
        .link-edit:hover {
            background: var(--secondary-color);
            color: #fff;
            transform: translateY(-1px);
            text-decoration: none;
        }
        
        .link-view-all {
            background: var(--accent-color);
            border: none;
            color: #fff;
            padding: 12px 25px;
            border-radius: 25px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            width: 100%;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }
        
        .link-view-all:hover {
            background: #218838;
            color: #fff;
            transform: translateY(-1px);
            text-decoration: none;
        }
        
        .link-messages {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            border: none;
            color: #fff;
            padding: 12px 25px;
            border-radius: 25px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            width: 100%;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }
        
        .link-messages::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }
        
        .link-messages:hover::before {
            left: 100%;
        }
        
        .link-messages:hover {
            background: linear-gradient(135deg, #0056b3 0%, #004085 100%);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0,123,255,0.3);
            text-decoration: none;
        }
        
        .link-messages i {
            margin-right: 8px;
            font-size: 14px;
        }
        
        .message-notification {
            position: absolute;
            top: 16px;
            right: 70px;
            background: #dc3545;
            color: #fff;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            border: 2px solid #fff;
        }
        
        .wishlist-item {
            display: flex;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #f1f3f4;
            transition: all 0.3s ease;
        }
        
        .wishlist-item:hover {
            padding-left: 10px;
            background: rgba(5,25,34,0.02);
            border-radius: 8px;
        }
        
        .wishlist-item:last-child {
            border-bottom: none;
        }
        
        .wishlist-img {
            width: 80px;
            height: 80px;
            border-radius: 8px;
            margin-right: 15px;
            object-fit: cover;
        }
        
        .wishlist-details {
            flex-grow: 1;
        }
        
        .wishlist-details h6 {
            margin: 0 0 8px 0;
            font-weight: 600;
            color: var(--primary-color);
        }
        
        .wishlist-price {
            color: var(--accent-color);
            font-weight: 600;
            font-size: 16px;
        }
        
        .rating-stars {
            color: #ffc107;
            margin-right: 10px;
        }
        
        .address-card {
            border: 2px solid var(--border-color);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 15px;
            position: relative;
            transition: all 0.3s ease;
        }
        
        .address-card.default {
            border-color: var(--accent-color);
            background: linear-gradient(135deg, rgba(40,167,69,0.05) 0%, rgba(40,167,69,0.1) 100%);
        }
        
        .default-badge {
            position: absolute;
            top: -8px;
            right: 15px;
            background: var(--accent-color);
            color: #fff;
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .quick-stats {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: #fff;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 25px;
            box-shadow: 0 8px 25px rgba(5,25,34,0.2);
        }
        
        .stat-item {
            text-align: center;
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 5px;
            color: #fff;
        }
        
        .stat-label {
            font-size: 12px;
            opacity: 0.9;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .badge-success {
            background-color: var(--accent-color) !important;
        }
        
        .badge-info {
            background-color: var(--primary-color) !important;
        }
        
        .text-info {
            color: var(--primary-color) !important;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }

        /* Address Section Styles */
        .address-item {
            margin-bottom: 15px;
        }
        
        .address-item.additional {
            display: none;
        }
        
        .btn-show-addresses {
            background: transparent;
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            padding: 8px 20px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            margin-top: 10px;
        }
        
        .btn-show-addresses:hover {
            background: var(--primary-color);
            color: #fff;
            transform: translateY(-1px);
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        ::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: var(--secondary-color);
        }
    </style>
</head>
<body>
    <!-- Account Header -->
    <div class="account-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="d-flex align-items-center">
                        <img src="https://ui-avatars.com/api/?name={{$user_informations->name}}&background=051922&color=ffffff&size=200&rounded=true" 
                             alt="Profile" class="profile-avatar">                           
                        <div style="padding-left:15px;">
                            <h2 class="account-name">{{$user_informations->name}}</h2>
                            <p class="member-since">
                                Member since {{ \Carbon\Carbon::parse($user_informations->created_at)->format('F Y') }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 text-md-right mt-3 mt-md-0">
                    <span class="badge badge-success mr-2">Verified Account</span>
                    <span class="badge badge-info">Premium Member</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Account Content -->
    <div class="container mt-4 mb-5">
        <div class="row">
            <!-- Left Sidebar -->
            <div class="col-lg-4">
                <!-- Quick Stats -->
                <div class="quick-stats">
                    <div class="row">
                        <div class="col-4 stat-item">
                            <div class="stat-number">{{$orders_count}}</div>
                            <div class="stat-label">Orders</div>
                        </div>
                        <div class="col-4 stat-item">
                            <div class="stat-number">{{$wish_list_count}}</div>
                            <div class="stat-label">Wishlist</div>
                        </div>
                        <div class="col-4 stat-item">
                            <div class="stat-number">892</div>
                            <div class="stat-label">Points</div>
                        </div>
                    </div>
                </div>

                <!-- Messages Link -->
                <div class="account-card">
                    <a href="{{route('user.messages')}}" class="link-messages">
                        <i class="fas fa-envelope"></i>Messages
                        <span class="message-notification">3</span>
                    </a>
                </div>

                <!-- Account Information -->
                <div class="account-card">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4><i class="fas fa-user mr-2"></i>Account Information</h4>
                        <a href="/profile/edit" class="link-edit">Edit</a>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Full Name</span>
                        <span class="info-value">{{$user_informations->name}}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Email</span>
                        <span class="info-value">{{$user_informations->email}}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Phone</span>
                        <span class="info-value">{{$user_informations->phone ?? 'Not provided'}}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Date of Birth</span>
                        <span class="info-value">Not provided</span>
                    </div>
                </div>

                <!-- Addresses -->
                <div class="account-card">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4><i class="fas fa-map-marker-alt mr-2"></i>Addresses</h4>
                    </div>
                    
                    @if($user_informations->billing_addresses->count() > 0)
                        <!-- Show first address -->
                        <div class="address-item address-card default">
                            <div class="default-badge">Primary</div>
                            <strong>{{$user_informations->billing_addresses->first()->name}}</strong><br>
                            {{$user_informations->billing_addresses->first()->address}}<br>
                         
                            <small class="text-muted">Phone: {{$user_informations->billing_addresses->first()->phone ?? 'Not provided'}}</small>
                        </div>
                        
                        <!-- Additional addresses (hidden initially) -->
                        @foreach($user_informations->billing_addresses->skip(1) as $billing_address)
                        <div class="address-item additional address-card">
                            <strong>{{$billing_address->name}}</strong><br>
                            {{$billing_address->address}}<br>
        
                            <small class="text-muted">Phone: {{$billing_address->phone ?? 'Not provided'}}</small>
                        </div>
                        @endforeach
                        
                        <!-- Show more button (only if there are additional addresses) -->
                        @if($user_informations->billing_addresses->count() > 1)
                        <button class="btn-show-addresses" id="showAddressesBtn">
                            Show {{$user_informations->billing_addresses->count() - 1}} More Address(es)
                        </button>
                        @endif
                    @else
                        <p class="text-muted">No addresses found. 
                        <a href="/addresses/add" class="text-primary">Add your first address</a></p>
                    @endif
                </div>
            </div>

            <!-- Right Content -->
            <div class="col-lg-8">
                <!-- Recent Orders -->
                <div class="account-card">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4><i class="fas fa-shopping-bag mr-2"></i>Recent Orders</h4>
                    </div>
                    
                    <div class="order-item">
                        <div class="order-header">
                            <div class="order-id">Order #ORD-2024-001</div>
                            <span class="order-status status-delivered">Delivered</span>
                        </div>
                        <div class="product-item">
                            <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80" alt="Product" class="product-img">
                            <div class="product-details">
                                <h6>Nike Running Shoes</h6>
                                <div class="product-price">$129.99</div>
                                <small class="text-muted">Delivered on Jan 15, 2024</small>
                            </div>
                        </div>
                    </div>

                    <div class="order-item">
                        <div class="order-header">
                            <div class="order-id">Order #ORD-2024-002</div>
                            <span class="order-status status-processing">Processing</span>
                        </div>
                        <div class="product-item">
                            <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80" alt="Product" class="product-img">
                            <div class="product-details">
                                <h6>Wireless Headphones</h6>
                                <div class="product-price">$89.99</div>
                                <small class="text-muted">Expected delivery: Jan 25, 2024</small>
                            </div>
                        </div>
                    </div>

                    <div class="order-item">
                        <div class="order-header">
                            <div class="order-id">Order #ORD-2024-003</div>
                            <span class="order-status status-pending">Pending</span>
                        </div>
                        <div class="product-item">
                            <img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80" alt="Product" class="product-img">
                            <div class="product-details">
                                <h6>Cotton T-Shirt</h6>
                                <div class="product-price">$24.99</div>
                                <small class="text-muted">Payment pending</small>
                            </div>
                        </div>
                    </div>

                    <a href="/orders" class="link-view-all mt-3">View All Orders</a>
                </div>

                <!-- Wishlist -->
                <div class="account-card">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4><i class="fas fa-heart mr-2"></i>Wishlist ({{$wish_list_count}} items)</h4>
                    </div>
                    
                    <div class="wishlist-item">
                        <img src="https://images.unsplash.com/photo-1560472354-b33ff0c44a43?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80" alt="Product" class="wishlist-img">
                        <div class="wishlist-details">
                            <h6>Smart Watch Pro</h6>
                            <div class="d-flex align-items-center mb-2">
                                <div class="rating-stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                                <small class="text-muted">(234 reviews)</small>
                            </div>
                            <div class="wishlist-price">$299.99</div>
                        </div>
                        <div>
                            <a href="/cart/add/123" class="btn btn-primary btn-sm">Add to Cart</a>
                        </div>
                    </div>

                    <div class="wishlist-item">
                        <img src="https://images.unsplash.com/photo-1572635196237-14b3f281503f?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80" alt="Product" class="wishlist-img">
                        <div class="wishlist-details">
                            <h6>Bluetooth Speaker</h6>
                            <div class="d-flex align-items-center mb-2">
                                <div class="rating-stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <small class="text-muted">(567 reviews)</small>
                            </div>
                            <div class="wishlist-price">$79.99</div>
                        </div>
                        <div>
                            <a href="/cart/add/456" class="btn btn-primary btn-sm">Add to Cart</a>
                        </div>
                    </div>

                    <div class="wishlist-item">
                        <img src="https://images.unsplash.com/photo-1484704849700-f032a568e944?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80" alt="Product" class="wishlist-img">
                        <div class="wishlist-details">
                            <h6>Laptop Backpack</h6>
                            <div class="d-flex align-items-center mb-2">
                                <div class="rating-stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                                <small class="text-muted">(123 reviews)</small>
                            </div>
                            <div class="wishlist-price">$49.99</div>
                        </div>
                        <div>
                            <a href="/cart/add/789" class="btn btn-primary btn-sm">Add to Cart</a>
                        </div>
                    </div>

                    <a href="/wishlist" class="link-view-all mt-3">View All Wishlist Items</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Minimal JavaScript only for address toggle -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // Address toggle functionality
            $('#showAddressesBtn').click(function() {
                const $additionalAddresses = $('.address-item.additional');
                const $button = $(this);
                
                if ($additionalAddresses.is(':visible')) {
                    // Hide additional addresses
                    $additionalAddresses.slideUp(300);
                    $button.text('Show ' + $additionalAddresses.length + ' More Address(es)');
                } else {
                    // Show additional addresses
                    $additionalAddresses.slideDown(300);
                    $button.text('Show Less');
                }
            });
        });
    </script>
</body>
</html>