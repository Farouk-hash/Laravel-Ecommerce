<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Responsive Bootstrap4 Shop Template, Created by Imran Hossain from https://imransdesign.com/">
	<meta name="csrf-token" content="{{csrf_token()}}">
	<!-- title -->
	<title>{{$title}}</title>

	<!-- favicon -->
	<link rel="shortcut icon" type="image/png" href="{{asset('assets/img/favicon.png')}}">
	<!-- google font -->
	<link href="{{asset('https://fonts.googleapis.com/css?family=Open+Sans:300,400,700')}}" rel="stylesheet">
	<link href="{{asset('https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap')}}" rel="stylesheet">
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

	<link rel="stylesheet" href="{{asset('assets/css/language/language.css')}}">
</head>
<body>
	
	<!--PreLoader-->
    <div class="loader">
		<div class="loader-inner">
			<div class="circle"></div>
        </div>
    </div>
    <!--PreLoader Ends-->
	<!-- header -->
	<div class="top-header-area" id="sticker">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-sm-12 text-center">
					<div class="main-menu-wrap">
						<!-- logo -->
						<div class="site-logo">
							<a href="{{route('Home')}}">
								<img src="assets/img/logo.png" alt="">
							</a>
						</div>
						<!-- logo -->

						<!-- menu start -->
						<nav class="main-menu">
							<ul>
								<li class="current-list-item"><a href="{{route('Home')}}">{{trans('index.Home')}}</a></li>

								<li><a href="{{route('products')}}">{{trans('index.products')}}</a>
								</li>
								
								<li><a href="{{route('categories')}}">{{trans('index.categories')}}</a></li>
								
								<li><a href="news.html">{{trans('index.news')}}</a>
									<ul class="sub-menu">
										<li><a href="news.html">{{trans('index.news')}}</a></li>
										<li><a href="single-news.html">{{trans('index.single_news')}}</a></li>
									</ul>
								</li>

								@auth
								
								<li><a href="{{route('contacts.show-contact-form')}}">{{trans('index.contact')}}</a></li>
								@endauth
								
								@guest
								<li><a href="#">{{trans('index.user')}}</a>
									<ul class="sub-menu">
										<li><a href="{{route('auth.signup')}}">{{trans('index.register')}}</a></li>
										<li><a href="{{route('auth.login')}}">{{trans('index.login')}}</a></li>
									</ul>
								</li>

								@else
									<li>
										<a href="#" 
										onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
										{{__('index.logout')}}
										</a>
										<form id="logout-form" action="{{route('auth.logout')}}" method="POST" style="display: none;">
											@csrf
										</form>
									</li>
								@endguest

								<li><a href="about.html">{{trans('index.about')}}</a></li>

							<div class="language-switcher-dropdown">
								<form action="{{ route('language.switch') }}" method="POST" id="languageForm">
									@csrf
									<div class="language-select-wrapper">
										<i class="fas fa-globe language-icon"></i>
										<select name="locale" onchange="this.form.submit()" class="language-select">
											@foreach ($languages as $lang => $data)
												<option value="{{ $lang }}" {{ app()->getLocale() == $data['flag'] ? 'selected' : '' }}>
													{{ $data['flag'] }} {{ $data['name'] }}
												</option>
											@endforeach
										</select>
									</div>
								</form>
							</div>
							

								<li>
									<div class="header-icons">
										

										
										@auth
										
										<a class="shopping-cart" href="#">
											(<span style="color: #F28123;">{{auth()->user()->carts()->where('finished','==' ,false)
											->where('save_later','=',$cart_count)->count()}}</span>)
											<i class="fas fa-shopping-cart"></i>
										</a>
										<ul class="sub-menu">
											<li><a href="{{route('carts.carts-view')}}">Pending</a></li>
											<li><a href="{{route('carts.carts-view' , 1)}}">Save Later</a></li>
											<li><a href="{{route('checkout.checkout-form' , ['show_save_later'=>1 , 'check_out_form_history'=>1]) }}">Check Out</a></li>
											<li><a href="{{route('carts.carts-view')}}">History</a></li>
										</ul>
										<a class="mobile-hide search-bar-icon" href="{{route('user.profile')}}"><i class="fas fa-user"></i></a>

										@endauth
										<a class="mobile-hide search-bar-icon" href="#"><i class="fas fa-search"></i></a>
									
									</div>
								</li>
							</ul>
						</nav>
						<a class="mobile-show search-bar-icon" href="#"><i class="fas fa-search"></i></a>
						<div class="mobile-menu"></div>
						<!-- menu end -->
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end header -->
	
	<!-- search area -->
	<div class="search-area">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<span class="close-btn"><i class="fas fa-window-close"></i></span>
					<div class="search-bar">
						<div class="search-bar-tablecell">
							<h3>Search For:</h3>
							<input type="text" placeholder="Keywords">
							<button type="submit">Search <i class="fas fa-search"></i></button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end search area -->



{{$slot}}