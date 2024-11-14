<?php

use App\Models\UserAuth;
?>
@extends('layouts.frontlayout')
@section('content')

<style>
    .picon-bg{position:relative; text-align: center; }
    .picon-bg img{border-radius: 50%; width: 140px; height: 140px; margin-bottom: 10px;}
    .edit-btn{position: relative; top:10px; margin-bottom: 10px;}
    .edit-btn a {
  background-color: #FCD152;
  background: rgb(170,137,65);
  background: linear-gradient(90deg, rgba(170,137,65,1) 0%, rgba(205,156,49,1) 13%, rgba(154,128,73,1) 35%, rgba(246,204,78,1) 51%, rgba(181,147,56,1) 75%, rgba(163,136,68,1) 100%);
  margin-top: 3px;
  border-radius: 35px;
  border: 0px;
  box-shadow: none;
  color: #000 !important;
  padding: 5px 15px;
}
.card{width: 100%; padding: 30px 20px 30px; margin-bottom:0; }
.detail-section{display: flex; justify-content: center; align-items: center; margin: 0; padding-bottom: 0;}
.badge{position: relative; border-radius: 5px; color: #fff!important; font-size: 14px!important; line-height: 20px!important;right:0;}
.box {
  display: flex;
  gap: 10px;
  justify-content: center;
  align-items: center;
}
.box a{font-size: 14px; font-weight: 500;}
.pond{padding-left: 0;}
.pond span{color: #fff;}
.url_section, .gmail_section, .phone_section {
  background: #FFFFFF;
  box-shadow: 0px 0px 4px rgb(0 0 0 / 25%);
  border-radius: 40px;
  padding: 5px 10px;
  margin: 0px;
}
	button.btn.btn-add {
		border-radius: 30px;
		background-color: #000000;
		font-size: 16px;
		padding: 10px 20px;
		color: #ffffff;
	}

	.counts {
		display: flex;
		justify-content: space-evenly;
		align-items: center;
		width: 100%;
	}

	.counts div {
		text-align: center;
	}

	.counts span:first-of-type {
		font-size: 1.5rem;
		font-weight: bold;
		display: block;
	}

	.counts span:last-of-type {
		font-size: 0.8rem;
		color: #fff;
		display: block;
		text-transform: uppercase;
		padding: 5px;
	}

	.fa_font {
		font-weight: 100;
		font-size: large;
	}

	.counts div{
		background: #000!important;
    padding: 20px 20px!important;
    border-radius: 20px!important;
	}
	/* .the-header {

		position: relative;
		padding: 100px 674px;
	}

	.header-background {

		position: absolute;
		width: 100%;
		height: 96%;
		object-fit: cover;
		z-index: -100;
		bottom: 0;
		left: 0;
		right: 0;
	} */

	@media only screen and (max-width:767px){
		.profle_tag{flex-direction: column;}
		.pond{padding: 40px 0 0 0;}
	}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/style_home.css">

<!-- Breadcrumb -->
<div class="breadcrumb-main">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<a href="#"> Home / </a> Profile
			</div>
		</div>
	</div>
</div>
<!-- //Breadcrumb -->
<section class="profile-view">
	<div class="container">
			<div class="row">
				@include('admin.partials.flash_messages')
				<div class="col-lg-3">
					<div class="card">
						<div class="picon-bg"> 
							@if($user->image)
							<img src="{{url('/assets/images/profile')}}/{{$user->image}}" alt="Image">
							@else
							<img src="https://finderspage.com/new-web/public/front/images/dummy-user.jpg" alt="Image">
							@endif
							@if($user->isfeatured_user == '1')
							<span><img src="{{ url('') }}/front/images/profile-icon.svg" alt="Image"></span>
							@endif
							@if(UserAuth::getLoginId() == $user->id)
							<h6>{{ $user->first_name }}</h6> 
							<div class="edit-btn">
								<a href="{{url('/edit-user-profile')}}/<?php echo General::encrypt(UserAuth::getLoginId()) ?>">Edit Profile</a>
							</div>
							@endif
						</div>
					</div>
				</div>
				<div class="col-lg-9">
					<div class="card">
						<div class="profle_tag">
							<!-- <div class="columns the-header">
								<img class="header-background" src="https://unsplash.it/1000/1000/?random&pic=1" id="header-background-id" alt="background-img">
							</div> -->
							
							<div class="pond">
								<span class="user_role badge bg-primary small" style="text-transform: capitalize;">{{ $user->role_category }}</span>
								@if($user->role == "individual")
								<span>{{ $user->role_category }}</span>
								@endif
								<div class="counts">
									<div class="followers">
										<span>{{$followers}}</span>
										<span>Connections</span>
									</div>
									<div class="following">
										<span>{{$following}}</span>
										<span>Connected</span>
									</div>
								</div>
								<div>
									@if(UserAuth::getLoginId() != $user->id && UserAuth::getLoginId())
									@if(isset($follows->following_id) == UserAuth::getLoginId())
									<button class="btn btn-primary" id="unfollow" data-id="{{$follows->id }}">Disconnect</button>
									@else
									<button class="btn btn-primary" id="follow" data-id="{{$user->id }}">Connect</button>
									@endif
									@endif
								</div>
							</div>
						</div>

	          <div class="detail-section">
							<div class="box">
								<div class="phone_section">
									<a href="tel:13109404110"><img src="{{ url('') }}/front/images/phone.png" alt="Image">
										<span> {{ $user->phonenumber }}</span></a>
								</div>
								<div class="gmail_section">
									<a href="{{ $user->email }}"><img src="{{ url('') }}/front/images/gmail.png" alt="Image">
										<span>{{ $user->email }}</span></a>
								</div>
								<div class="url_section">
									<a href="{{ $user->business_website }}" target="_blank"><img src="{{ url('') }}/front/images/global.png" alt="Image">
										<span>{{ $user->business_website }}</span></a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
	</div>
</section>

<!-- banner section -->

<section class="business_banner" style="background:#F5F5F5; display:none">
	<div class="container">
		<div class="about-business">
			<h6>About Business</h6>
			@if(UserAuth::getLoginId() == $user->id)
			<a href="{{url('/edit-business-profile')}}/<?php echo General::encrypt(UserAuth::getLoginId()) ?>">Edit Business Info</a>
			@endif
		</div>
		<div class="about-business-profile">
			<img src="{{url('/assets/images/business/')}}/{{$user->business_images}}" alt="Image" style="width: 180px;">
			<div class="taining">
				<h6>{{$user->business_name}}</h6>
				<br>
				@if($user->business_address)
				<div class="location">
					<img src="{{ url('') }}/front/images/address.png" alt="Image">
					<span>{{$user->business_address}}</span>
				</div>
				@endif
				<div class="box">
					@if($user->business_phone)
					<div class="phone_section1">
						<a href="{{$user->business_phone}}"><img src="{{ url('') }}/front/images/phone.png" alt="Image">
							<span> {{$user->business_phone}}</span></a>
					</div>
					@endif
					@if($user->business_email)
					<div class="gmail_section1">
						<a href="mail:{{$user->business_email}}"><img src="{{ url('') }}/front/images/gmail.png" alt="Image">
							<span>{{$user->business_email}}</span></a>
					</div>
					@endif
					@if($user->business_website)
					<div class="url_section1">
						<a href="{{ $user->business_website }}" target="_blank"><img src="{{ url('') }}/front/images/global.png" alt="Image">
							<span>{{ $user->business_website }}</span></a>
					</div>
					@endif
					<div class="url_section1">
						<!-- Button trigger modal -->
						<a type="button" class="model-cst" data-bs-toggle="modal" data-bs-target="#hour">
							<img src="{{ url('') }}/front/images/home.png" width="30px">
							<span>About Business And Hour</span>
						</a>
					</div>
				</div>
				@if($user->business_btnname || $user->business_btnurl)
				<div class="url_section1">
					<a href="{{ $user->business_btnurl }}">
						<button type="button" class="btn btn-add">{{ $user->business_btnname }}</button></a>
				</div>
				@endif
			</div>
		</div>
		<div class="card" style="display: none;">
			<div class="hour_slt">
				<div class="row">
					<label for="exampleInput">Hours </label>
					<div class="col-lg-4">
						<label for="exampleInput">Monday </label>
					</div>
					<div class="col-lg-4">

						@if($user->mon_am != 0)
						<label for="exampleInput">{{ $user->mon_am }}</label>
						@endif

					</div>
					<div class="col-lg-4">

						@if($user->mon_pm != 0)
						<label for="exampleInput">{{ $user->mon_pm }}</label>
						@endif

					</div>
					<div class="col-lg-4">
						<label for="exampleInput">Tuesday </label>
					</div>
					<div class="col-lg-4">

						@if($user->tue_am != 0)
						<label for="exampleInput">{{ $user->tue_am }}</label>
						@endif

					</div>
					<div class="col-lg-4">

						@if($user->tue_pm != 0)
						<label for="exampleInput">{{ $user->tue_pm }}</label>
						@endif

					</div>
					<div class="col-lg-4">
						<label for="exampleInput">Wednesday </label>
					</div>
					<div class="col-lg-4">

						@if($user->wed_am != 0)
						<label for="exampleInput">{{ $user->wed_am }}</label>
						@endif

					</div>
					<div class="col-lg-4">

						@if($user->wed_pm != 0)
						<label for="exampleInput">{{ $user->wed_pm }}</label>
						@endif

					</div>
					<div class="col-lg-4">
						<label for="exampleInput">Thursday </label>
					</div>
					<div class="col-lg-4">

						@if($user->thur_am != 0)
						<label for="exampleInput">{{ $user->thur_am }}</label>
						@endif

					</div>
					<div class="col-lg-4">

						@if($user->wed_pm != 0)
						<label for="exampleInput">{{ $user->thur_pm }}</label>
						@endif

					</div>
					<div class="col-lg-4">
						<label for="exampleInput">Friday </label>
					</div>
					<div class="col-lg-4">

						@if($user->fri_am != 0)
						<label for="exampleInput">{{ $user->fri_am }}</label>
						@endif

					</div>
					<div class="col-lg-4">

						@if($user->fri_pm != 0)
						<label for="exampleInput">{{ $user->fri_pm }}</label>
						@endif

					</div>
					<div class="col-lg-4">
						<label for="exampleInput">Saturday </label>
					</div>
					<div class="col-lg-4">

						@if($user->sat_am != '0')
						<label for="exampleInput">{{ $user->sat_am }}</label>
						@endif

					</div>
					<div class="col-lg-4">

						@if($user->sat_pm != '0')
						<label for="exampleInput">{{ $user->sat_pm }}</label>
						@endif

					</div>
					<div class="col-lg-4">
						<label for="exampleInput">Sunday </label>
					</div>
					<div class="col-lg-4">

						@if($user->sun_am != '0')
						<label for="exampleInput">{{ $user->sun_am }}</label>
						@endif

					</div>
					<div class="col-lg-4">

						@if($user->sun_pm != '0')
						<label for="exampleInput">{{ $user->sun_pm }}</label>
						@endif

					</div>
				</div>
			</div>
		</div>
		<hr>
		<div>
			<h3 class="text-center">Our Services</h3>
			@if($user->role_category)
			<div class="">
				@if($user->role == "business")
				@php $roles= json_decode($user->role_category) ?json_decode($user->role_category):[]@endphp
				<span>
					<ul class="list-inline">
						@foreach($roles as $role)
						<li class="p-4">{{$role}}</li>
						@endforeach
					</ul>
				</span>
				@endif
				</a>
			</div>
			@endif
		</div>
		<hr>
		<div>
			<h3 class="text-center">Amenities and more</h3>
			<div class="container">
				<div class="row pt-4">
					@if($user->all_business == 'no' || $user->all_business == 'yes')
					<div class="col-md-4">
						@if($user->all_business == 'no')
						<span class="fa_font"><i class="fa fa-times" aria-hidden="true"></i>Is open to All Business</span>
						@else
						<span class="fa_font"><i class="fa fa-check" aria-hidden="true"></i>Is open to All Business</span>
						@endif
					</div>
					@endif

					@if($user->wheelchair == 'no' || $user->wheelchair == 'yes')
					<div class="col-md-4">
						@if($user->wheelchair == 'no')
						<span class="fa_font"><i class="fa fa-times" aria-hidden="true"></i>Is Wheelchair Accessible</span>
						@else
						<span class="fa_font"><i class="fa fa-check" aria-hidden="true"></i>Is Wheelchair Accessible</span>
						@endif
					</div>
					@endif
					@if($user->black_owned == 'no' || $user->black_owned == 'yes')
					<div class="col-md-4">
						@if($user->black_owned == 'no')
						<span class="fa_font"><i class="fa fa-times" aria-hidden="true"></i>Black-owned</span>
						@else
						<span class="fa_font"><i class="fa fa-check" aria-hidden="true"></i>Black-owned</span>
						@endif
					</div>
					@endif

					@if($user->women_owned == 'no' || $user->women_owned == 'yes')
					<div class="col-md-4 pt-4">
						@if($user->women_owned == 'no')
						<span class="fa_font"><i class="fa fa-times" aria-hidden="true"></i>Women-owned</span>
						@else
						<span class="fa_font"><i class="fa fa-check" aria-hidden="true"></i>Women-owned</span>
						@endif
					</div>
					@endif
					@if($user->latinx_owned == 'no' || $user->latinx_owned == 'yes')
					<div class="col-md-4 pt-4 ">
						@if($user->latinx_owned == 'no')
						<span class="fa_font"><i class="fa fa-times" aria-hidden="true"></i>Latinx-owned</span>
						@else
						<span class="fa_font"><i class="fa fa-check" aria-hidden="true"></i>Latinx-owned</span>
						@endif
					</div>
					@endif
					@if($user->asian_owned == 'no' || $user->asian_owned == 'yes')
					<div class="col-md-4 pt-4 ">
						@if($user->asian_owned == 'no')
						<span class="fa_font"><i class="fa fa-times" aria-hidden="true"></i>Asian-owned</span>
						@else
						<span class="fa_font"><i class="fa fa-check" aria-hidden="true"></i>Asian-owned</span>
						@endif
					</div>
					@endif

					@if($user->lgbtq_owned == 'no' || $user->lgbtq_owned == 'yes')
					<div class="col-md-4 pt-4 ">
						@if($user->lgbtq_owned == 'no')
						<span class="fa_font"><i class="fa fa-times" aria-hidden="true"></i>LGBTQ-owned</span>
						@else
						<span class="fa_font"><i class="fa fa-check" aria-hidden="true"></i>LGBTQ-owned</span>
						@endif
					</div>
					@endif
					@if($user->veteran_owned == 'no' || $user->veteran_owned == 'yes')
					<div class="col-md-4 pt-4 ">
						@if($user->veteran_owned == 'no')
						<span class="fa_font"><i class="fa fa-times" aria-hidden="true"></i>Veteran-owned</span>
						@else
						<span class="fa_font"><i class="fa fa-check" aria-hidden="true"></i>Veteran-owned</span>
						@endif
					</div>
					@endif
					@if($user->bike_parking == 'no' || $user->bike_parking == 'yes')
					<div class="col-md-4 pt-4">
						@if($user->bike_parking == 'no')
						<span class="fa_font"><i class="fa fa-times" aria-hidden="true"></i>Has Bike Parking</span>
						@else
						<span class="fa_font"><i class="fa fa-check" aria-hidden="true"></i>Has Bike Parking</span>
						@endif
					</div>
					@endif

					@if($user->ev_charging == 'no' || $user->ev_charging == 'yes')
					<div class="col-md-4 pt-4 amenities">
						@if($user->ev_charging == 'no')
						<span class="fa_font"><i class="fa fa-times" aria-hidden="true"></i>EV charging station available</span>
						@else
						<span class="fa_font"><i class="fa fa-check" aria-hidden="true"></i>EV charging station available</span>
						@endif
					</div>
					@endif
					@if($user->plastic_free == 'no' || $user->plastic_free == 'yes')
					<div class="col-md-4 pt-4 amenities">
						@if($user->plastic_free == 'no')
						<span class="fa_font"><i class="fa fa-times" aria-hidden="true"></i>Plastic-free packaging</span>
						@else
						<span class="fa_font"><i class="fa fa-check" aria-hidden="true"></i>Plastic-free packaging</span>
						@endif
					</div>
					@endif
					@if($user->vaccination_required == 'no' || $user->vaccination_required == 'yes')
					<div class="col-md-4 pt-4 amenities">
						@if($user->vaccination_required == 'no')
						<span class="fa_font"><i class="fa fa-times" aria-hidden="true"></i>Proof of vaccination required</span>
						@else
						<span class="fa_font"><i class="fa fa-check" aria-hidden="true"></i>Proof of vaccination required</span>
						@endif
					</div>
					@endif

					@if($user->fully_vaccinated == 'no' || $user->fully_vaccinated == 'yes')
					<div class="col-md-4 pt-4 amenities">
						@if($user->fully_vaccinated == 'no')
						<span class="fa_font"><i class="fa fa-times" aria-hidden="true"></i>All staff fully vaccinated</span>
						@else
						<span class="fa_font"><i class="fa fa-check" aria-hidden="true"></i>All staff fully vaccinated</span>
						@endif
					</div>
					@endif
					@if($user->masks_required == 'no' || $user->masks_required == 'yes')
					<div class="col-md-4 pt-4 amenities">
						@if($user->masks_required == 'no')
						<span class="fa_font"><i class="fa fa-times" aria-hidden="true"></i>Masks required</span>
						@else
						<span class="fa_font"><i class="fa fa-check" aria-hidden="true"></i>Masks required</span>
						@endif
					</div>
					@endif
					@if($user->staff_wears_masks == 'no' || $user->staff_wears_masks == 'yes')
					<div class="col-md-4 pt-4 amenities">
						@if($user->staff_wears_masks == 'no')
						<span class="fa_font"><i class="fa fa-times" aria-hidden="true"></i>Staff wears masks</span>
						@else
						<span class="fa_font"><i class="fa fa-check" aria-hidden="true"></i>Staff wears masks</span>
						@endif
					</div>
					@endif

					@if($user->android_pay == 'no' || $user->android_pay == 'yes')
					<div class="col-md-4 pt-4 amenities">
						@if($user->android_pay == 'no')
						<span class="fa_font"><i class="fa fa-times" aria-hidden="true"></i>Accepts Android Pay</span>
						@else
						<span class="fa_font"><i class="fa fa-check" aria-hidden="true"></i>Accepts Android Pay</span>
						@endif
					</div>
					@endif
					@if($user->apple_pay == 'no' || $user->apple_pay == 'yes')
					<div class="col-md-4 pt-4 amenities">
						@if($user->apple_pay == 'no')
						<span class="fa_font"><i class="fa fa-times" aria-hidden="true"></i>Accepts Apple Pay</span>
						@else
						<span class="fa_font"><i class="fa fa-check" aria-hidden="true"></i>Accepts Apple Pay</span>
						@endif
					</div>
					@endif
					@if($user->credit_card == 'no' || $user->credit_card == 'yes')
					<div class="col-md-4 pt-4 amenities">
						@if($user->credit_card == 'no')
						<span class="fa_font"><i class="fa fa-times" aria-hidden="true"></i>Accepts Credit Cards</span>
						@else
						<span class="fa_font"><i class="fa fa-check" aria-hidden="true"></i>Accepts Credit Cards</span>
						@endif
					</div>
					@endif

					@if($user->cryptocurrency == 'no' || $user->cryptocurrency == 'yes')
					<div class="col-md-4 pt-4 amenities">
						@if($user->cryptocurrency == 'no')
						<span class="fa_font"><i class="fa fa-times" aria-hidden="true"></i>Accepts Cryptocurrency</span>
						@else
						<span class="fa_font"><i class="fa fa-check" aria-hidden="true"></i>Accepts Cryptocurrency</span>
						@endif
					</div>
					@endif
					@if($user->waitlist_reservations == 'no' || $user->waitlist_reservations == 'yes')
					<div class="col-md-4 pt-4 amenities">
						@if($user->waitlist_reservations == 'no')
						<span class="fa_font"><i class="fa fa-times" aria-hidden="true"></i>Offers Waitlist Reservations</span>
						@else
						<span class="fa_font"><i class="fa fa-check" aria-hidden="true"></i>Offers Waitlist Reservations</span>
						@endif
					</div>
					@endif
					@if($user->online_ordering == 'no' || $user->online_ordering == 'yes')
					<div class="col-md-4 pt-4 amenities">
						@if($user->online_ordering == 'no')
						<span class="fa_font"><i class="fa fa-times" aria-hidden="true"></i>Offers Online Ordering</span>
						@else
						<span class="fa_font"><i class="fa fa-check" aria-hidden="true"></i>Offers Online Ordering</span>
						@endif
					</div>
					@endif

					@if($user->dogs_allowed == 'no' || $user->dogs_allowed == 'yes')
					<div class="col-md-4 pt-4 amenities">
						@if($user->dogs_allowed == 'no')
						<span class="fa_font"><i class="fa fa-times" aria-hidden="true"></i>Dogs Allowed</span>
						@else
						<span class="fa_font"><i class="fa fa-check" aria-hidden="true"></i>Dogs Allowed</span>
						@endif
					</div>
					@endif
					@if($user->military == 'no' || $user->military == 'yes')
					<div class="col-md-4 pt-4 amenities">
						@if($user->military == 'no')
						<span class="fa_font"><i class="fa fa-times" aria-hidden="true"></i>Offers Military Discount</span>
						@else
						<span class="fa_font"><i class="fa fa-check" aria-hidden="true"></i>Offers Military Discount</span>
						@endif
					</div>
					@endif
					@if($user->flower_delivery == 'no' || $user->flower_delivery == 'yes')
					<div class="col-md-4 pt-4 amenities">
						@if($user->flower_delivery == 'no')
						<span class="fa_font"><i class="fa fa-times" aria-hidden="true"></i>Offers Flower Delivery</span>
						@else
						<span class="fa_font"><i class="fa fa-check" aria-hidden="true"></i>Offers Flower Delivery</span>
						@endif
					</div>
					@endif
				</div>
			</div>
			<div class="row pt-4">
				<div class="col-md-4">
					<button type="button" class="btn btn-primary" id="view_all">View all</button>
				</div>
			</div>
		</div>
	</div>
</section>


<!-- end banner section -->


<!-- ==== Find Feature Section Start ==== -->

<section class="tab-section">
	<!-- Tab content -->
	<div id="tab1" class="tabcontent">
		<section class="find_feature_section">
			<div class="container">
				<div class="tab">
					<button class="tablinks active" onclick="openCity(event, 'tab1')">All</button>
					<button class="tablinks" onclick="openCity(event, 'tab2')">JOBS</button>
					<button class="tablinks" onclick="openCity(event, 'tab3')">REAL ESTATE</button>
					<button class="tablinks" onclick="openCity(event, 'tab4')">WELCOME TO OUR COMMUNITY</button>
					<button class="tablinks" onclick="openCity(event, 'tab5')">SHOPPING</button>
				</div>
				<div class="row">
					<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
						<div class="find_feature_area" id="content-area">
							<div class="main_title">
								<div class="search_area_category">
									<div class="category_search">
									</div>
								</div>
							</div>
							<div class="find_feature_grid">
								<div class="row">
									@foreach($all_posts as $post)
									<div class="col-lg-4">
										<div class="col_cst">
											<a href="{{route('post.view', ['id' =>$post->id])}}">
												<div class="grid_cst">
													<div class="img_cst">
														<img src="{{url(@$post->getOneResizeImagesAttribute()['medium'])}}" alt="Image" />
													</div>
												</div>
											</a>
											<div class="content">
												<img src="{{$post->user->image!= ''? url('assets/images/profile/'.$post->user->image):'front/images/user3.png'}}" width="61px" alt="">
												<div class="img_content">
													<p>{{ @$post->title }}</p>
													<span>by {{ @$post->user->first_name.' '.@$post->user->last_name }}</span>
												</div>
												<div class="dropdown">
													<button class="dropbtn" style=" background-image: url({{ url('') }}/front/images/dot.png);"></button>
													<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
														<li style="display: none;"><a class="dropdown-item" href="#">Delete</a></li>
														</li><a class="dropdown-item" href="{{url('/')}}/post/{{base64_encode($post->id)}}/edit">Edit </a></li>
														<li style="display: none;"><a class="dropdown-item" href="#">Unpublished </a></li>
													</ul>
												</div>
											</div>
										</div>
									</div>
									@endforeach
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>

	<div id="tab2" class="tabcontent">
		<section class="find_feature_section">
			<div class="container">
				<div class="tab">
					<button class="tablinks" onclick="openCity(event, 'tab1')">All</button>
					<button class="tablinks active" onclick="openCity(event, 'tab2')">JOBS</button>
					<button class="tablinks" onclick="openCity(event, 'tab3')">REAL ESTATE</button>
					<button class="tablinks" onclick="openCity(event, 'tab4')">WELCOME TO OUR COMMUNITY</button>
					<button class="tablinks" onclick="openCity(event, 'tab5')">SHOPPING</button>
				</div>
				<div class="row">
					<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
						<div class="find_feature_area" id="content-area">
							<div class="main_title">
								<div class="search_area_category">
									<div class="category_search">
									</div>
								</div>
							</div>
							<div class="find_feature_grid">
								<div class="row">
									@foreach($find_job_posts as $post)
									<div class="col-lg-4">
										<div class="col_cst">
											<a href="{{route('post.view', ['id' =>$post->id])}}">
												<div class="grid_cst">
													<div class="img_cst">
														<img src="{{url(@$post->getOneResizeImagesAttribute()['medium'])}}" alt="Image" />
													</div>
												</div>
											</a>
											<div class="content">
												<img src="{{$post->user->image!= ''? url('assets/images/profile/'.$post->user->image):'front/images/user3.png'}}" width="61px" alt="Image">
												<div class="img_content">
													<p>{{ @$post->title }}</p>
													<span>by {{ @$post->user->first_name.' '.@$post->user->last_name }}</span>
												</div>
												<div class="dropdown">
													<button class="dropbtn" style=" background-image: url({{ url('') }}/front/images/dot.png);"></button>
													<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
														<li style="display: none;"><a class="dropdown-item" href="#">Delete</a></li>
														</li><a class="dropdown-item" href="{{url('/')}}/post/{{base64_encode($post->id)}}/edit">Edit </a></li>
														<li style="display: none;"><a class="dropdown-item" href="#">Unpublished </a></li>
													</ul>
												</div>
											</div>
										</div>
									</div>
									@endforeach
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>

	<div id="tab3" class="tabcontent">
		<section class="find_feature_section">
			<div class="container">
				<div class="tab">
					<button class="tablinks" onclick="openCity(event, 'tab1')">All</button>
					<button class="tablinks" onclick="openCity(event, 'tab2')">JOBS</button>
					<button class="tablinks active" onclick="openCity(event, 'tab3')">REAL ESTATE</button>
					<button class="tablinks" onclick="openCity(event, 'tab4')">WELCOME TO OUR COMMUNITY</button>
					<button class="tablinks" onclick="openCity(event, 'tab5')">SHOPPING</button>
				</div>
				<div class="row">
					<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
						<div class="find_feature_area" id="content-area">
							<div class="main_title">
								<div class="search_area_category">
									<div class="category_search">
									</div>
								</div>
							</div>
							<div class="find_feature_grid">
								<div class="row">
									@foreach($real_estate_posts as $post)
									<div class="col-lg-4">
										<div class="col_cst">
											<a href="{{route('post.view', ['id' =>$post->id])}}">
												<div class="grid_cst">
													<div class="img_cst">
														<img src="{{url(@$post->getOneResizeImagesAttribute()['medium'])}}" alt="Image" />
													</div>
												</div>
											</a>
											<div class="content">
												<img src="{{$post->user->image!= ''? url('assets/images/profile/'.$post->user->image):'front/images/user3.png'}}" width="61px" alt="Image">
												<div class="img_content">
													<p>{{ @$post->title }}</p>
													<span>by {{ @$post->user->first_name.' '.@$post->user->last_name }}</span>
												</div>
												<div class="dropdown">
													<button class="dropbtn" style=" background-image: url({{ url('') }}/front/images/dot.png);"></button>
													<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
														<li style="display: none;"><a class="dropdown-item" href="#">Delete</a></li>
														</li><a class="dropdown-item" href="{{url('/')}}/post/{{base64_encode($post->id)}}/edit">Edit </a></li>
														<li style="display: none;"><a class="dropdown-item" href="#">Unpublished </a></li>
													</ul>
												</div>
											</div>
										</div>
									</div>
									@endforeach
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>


	<div id="tab4" class="tabcontent">
		<section class="find_feature_section">
			<div class="container">
				<div class="tab">
					<button class="tablinks" onclick="openCity(event, 'tab1')">All</button>
					<button class="tablinks" onclick="openCity(event, 'tab2')">JOBS</button>
					<button class="tablinks" onclick="openCity(event, 'tab3')">REAL ESTATE</button>
					<button class="tablinks active" onclick="openCity(event, 'tab4')">WELCOME TO OUR COMMUNITY</button>
					<button class="tablinks" onclick="openCity(event, 'tab5')">SHOPPING</button>
				</div>
				<div class="row">
					<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
						<div class="find_feature_area" id="content-area">
							<div class="main_title">
								<div class="search_area_category">
									<div class="category_search">
									</div>
								</div>
							</div>
							<div class="find_feature_grid">
								<div class="row">
									@foreach($our_community_posts as $post)
									<div class="col-lg-4">
										<div class="col_cst">
											<a href="{{route('post.view', ['id' =>$post->id])}}">
												<div class="grid_cst">
													<div class="img_cst">
														<img src="{{url(@$post->getOneResizeImagesAttribute()['medium'])}}" alt="Image" />
													</div>
												</div>
											</a>
											<div class="content">
												<img src="{{$post->user->image!= ''? url('assets/images/profile/'.$post->user->image):'front/images/user3.png'}}" width="61px" alt="Image">
												<div class="img_content">
													<p>{{ @$post->title }}</p>
													<span>by {{ @$post->user->first_name.' '.@$post->user->last_name }}</span>
												</div>
												<div class="dropdown">
													<button class="dropbtn" style=" background-image: url({{ url('') }}/front/images/dot.png);"></button>
													<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
														<li style="display: none;"><a class="dropdown-item" href="#">Delete</a></li>
														</li><a class="dropdown-item" href="{{url('/')}}/post/{{base64_encode($post->id)}}/edit">Edit </a></li>
														<li style="display: none;"><a class="dropdown-item" href="#">Unpublished </a></li>
													</ul>
												</div>
											</div>
										</div>
									</div>
									@endforeach
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>

	<div id="tab5" class="tabcontent">
		<section class="find_feature_section">
			<div class="container">
				<div class="tab">
					<button class="tablinks" onclick="openCity(event, 'tab1')">All</button>
					<button class="tablinks" onclick="openCity(event, 'tab2')">JOBS</button>
					<button class="tablinks" onclick="openCity(event, 'tab3')">REAL ESTATE</button>
					<button class="tablinks" onclick="openCity(event, 'tab4')">WELCOME TO OUR COMMUNITY</button>
					<button class="tablinks active" onclick="openCity(event, 'tab5')">SHOPPING</button>
				</div>
				<div class="row">
					<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
						<div class="find_feature_area" id="content-area">
							<div class="main_title">
								<div class="search_area_category">
									<div class="category_search">
									</div>
								</div>
							</div>
							<div class="find_feature_grid">
								<div class="row">
									@foreach($online_shopping_posts as $post)
									<div class="col-lg-4">
										<div class="col_cst">
											<a href="{{route('post.view', ['id' =>$post->id])}}">
												<div class="grid_cst">
													<div class="img_cst">
														<img src="{{url(@$post->getOneResizeImagesAttribute()['medium'])}}" alt="Image" />
													</div>
												</div>
											</a>
											<div class="content">
												<img src="{{$post->user->image!= ''? url('assets/images/profile/'.$post->user->image):'front/images/user3.png'}}" width="61px" alt="Image">
												<div class="img_content">
													<p>{{ @$post->title }}</p>
													<span>by {{ @$post->user->first_name.' '.@$post->user->last_name }}</span>
												</div>
												<div class="dropdown">
													<button class="dropbtn" style=" background-image: url({{ url('') }}/front/images/dot.png);"></button>
													<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
														<li style="display: none;"><a class="dropdown-item" href="#">Delete</a></li>
														</li><a class="dropdown-item" href="{{url('/')}}/post/{{base64_encode($post->id)}}/edit">Edit </a></li>
														<li style="display: none;"><a class="dropdown-item" href="#">Unpublished </a></li>
													</ul>
												</div>
											</div>
										</div>
									</div>
									@endforeach
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
	<!-- Modal -->
	<div class="modal fade" id="hour" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" id="cst_model">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="exampleModalLabel">About Business And Hour</h4>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body hour_slt">
					<div class="div_cst1">
						<p><strong>Hours</strong></p>
						<table class="table">
							<tbody>
								<tr>
									<td>Monday</td>
									<td>@if($user->mon_am != 0) {{ $user->mon_am }} @endif</td>
									<td>To</td>
									<td>@if($user->mon_pm != 0) {{ $user->mon_pm }} @endif</td>
								</tr>
								<tr>
									<td>Tuesday</td>
									<td>@if($user->tue_am != 0) {{ $user->tue_am }} @endif</td>
									<td>To</td>
									<td>@if($user->tue_pm != 0) {{ $user->tue_pm }} @endif</td>
								</tr>
								<tr>
									<td>Wednesday</td>
									<td>@if($user->wed_am != 0) {{ $user->wed_am }} @endif</td>
									<td>To</td>
									<td>@if($user->wed_pm != 0) {{ $user->wed_pm }} @endif</td>
								</tr>
								<tr>
									<td>Thursday</td>
									<td>@if($user->thur_am != 0) {{ $user->thur_am }} @endif</td>
									<td>To</td>
									<td>@if($user->wed_pm != 0) {{ $user->thur_pm }} @endif</td>
								</tr>
								<tr>
									<td>Friday</td>
									<td>@if($user->fri_am != 0) {{ $user->fri_am }} @endif</td>
									<td>To</td>
									<td>@if($user->fri_pm != 0) {{ $user->fri_pm }} @endif</td>
								</tr>
								<tr>
									<td>Saturday</td>
									<td>@if($user->sat_am != '0') {{ $user->sat_am }} @endif</td>
									<td>To</td>
									<td>@if($user->sat_pm != '0') {{ $user->sat_pm }} @endif</td>
								</tr>
								<tr>
									<td>Sunday</td>
									<td>@if($user->sun_am != '0') {{ $user->sun_am }} @endif</td>
									<td>To</td>
									<td>@if($user->sun_pm != '0') {{ $user->sun_pm }} @endif</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="modal-footer">
					<p class="mb-2"><strong>About</strong></p>
					<p>Contrary to popular belief, Lorem Ipsum is not simply random text.</p>
				</div>
			</div>
		</div>
	</div>
	<!-- ==== Find Feature Section End ==== -->


</section>

<!-- ==== Find Feature Section End ==== -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
	function openCity(evt, cityName) {
		// Declare all variables
		var i, tabcontent, tablinks;

		// Get all elements with class="tabcontent" and hide them
		tabcontent = document.getElementsByClassName("tabcontent");
		//alert(tabcontent.length)
		for (i = 0; i < tabcontent.length; i++) {
			tabcontent[i].style.display = "none";
		}

		// Get all elements with class="tablinks" and remove the class "active"
		tablinks = document.getElementsByClassName("tablinks");
		for (i = 0; i < tablinks.length; i++) {
			tablinks[i].className = tablinks[i].className.replace(" active", "");
		}

		// Show the current tab, and add an "active" class to the button that opened the tab
		document.getElementById(cityName).style.display = "block";
		evt.currentTarget.className += " active";
	}
</script>
<script>
	$(document).ready(function() {
		$('.amenities').hide();

		if ($('.checkdiv').is(':empty')) {
			$('#view_all').hide();
		}

		$(".dropdown").hover(function() {
			var dropdownMenu = $(this).children(".dropdown-menu");
			if (dropdownMenu.is(":visible")) {
				dropdownMenu.parent().toggleClass("open");
			}
		});

		$('#follow').on('click', function() {
			var follower_id = $(this).data('id');
			var following_id = "{{UserAuth::getLoginId()}}";
			var token = "{{ csrf_token() }}";
			$.ajax({
				type: 'post',
				url: "{{url('/get/follow')}}",
				data: {
					follower_id: follower_id,
					following_id: following_id,
					_token: token
				},
				success: function(response) {
					console.log(response);
					if (response == 1) {
						const Toast = Swal.mixin({
							toast: true,
							position: 'top-end',
							showConfirmButton: false,
							timer: 3000,
							timerProgressBar: true,
							didOpen: (toast) => {
								toast.addEventListener('mouseenter', Swal.stopTimer)
								toast.addEventListener('mouseleave', Swal.resumeTimer)
							}
						})

						Toast.fire({
							icon: 'success',
							title: 'Successfully Connected'
						}).then(() => {
							window.location.reload();
						})
					} else {
						const Toast = Swal.mixin({
							toast: true,
							position: 'top-end',
							showConfirmButton: false,
							timer: 3000,
							timerProgressBar: true,
							didOpen: (toast) => {
								toast.addEventListener('mouseenter', Swal.stopTimer)
								toast.addEventListener('mouseleave', Swal.resumeTimer)
							}
						})

						Toast.fire({
							icon: 'error',
							title: 'Something went wrong'
						}).then(() => {
							window.location.reload();
						})
					}

				}
			})
		})

		$('#unfollow').on('click', function() {
			var follow_id = $(this).data('id');
			var token = "{{ csrf_token() }}";
			$.ajax({
				type: 'post',
				url: "{{url('/get/unfollow')}}",
				data: {
					follow_id: follow_id,
					_token: token
				},
				success: function(response) {
					console.log(response);
					if (response == 1) {
						const Toast = Swal.mixin({
							toast: true,
							position: 'top-end',
							showConfirmButton: false,
							timer: 3000,
							timerProgressBar: true,
							didOpen: (toast) => {
								toast.addEventListener('mouseenter', Swal.stopTimer)
								toast.addEventListener('mouseleave', Swal.resumeTimer)
							}
						})

						Toast.fire({
							icon: 'success',
							title: 'Successfully Unconnected'
						}).then(() => {
							window.location.reload();
						})
					} else {
						const Toast = Swal.mixin({
							toast: true,
							position: 'top-end',
							showConfirmButton: false,
							timer: 3000,
							timerProgressBar: true,
							didOpen: (toast) => {
								toast.addEventListener('mouseenter', Swal.stopTimer)
								toast.addEventListener('mouseleave', Swal.resumeTimer)
							}
						})

						Toast.fire({
							icon: 'error',
							title: 'Something went wrong'
						}).then(() => {
							window.location.reload();
						})
					}

				}
			})
		})
		$('#view_all').on('click', function() {
			$('.amenities').toggle(function() {
				if ($(".amenities").is(":visible")) {
					$('#view_all').html("Hide");
				} else {
					$('#view_all').html("View All");
				}
			});

		})

	});
</script>
@endsection