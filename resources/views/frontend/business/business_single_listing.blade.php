@php
use App\Models\UserAuth;
use App\Models\Setting;
use App\Models\Business;

$businessUser = UserAuth::getUser($business->user_id);
// dd($businessUser);
$current_user = UserAuth::getLoginUser();
$user_all_data = UserAuth::getUser($business->user_id);

$count=1; 
$user_id = $business->user_id;
$userSlug = UserAuth::getUserSlug($user_id);

$category_array = explode(',',$business->sub_category);

$category = Business::getCategory($category_array);

$setting_like_option = Setting::get_setting('likes',$business->user_id);
@endphp

<?php
$cleanString = function ($value) {
  // Remove unwanted characters like '[' ']', '\"'
  return preg_replace('/[\[\]"]/', '', stripslashes(trim($value)));
  
};
// dd($business);
$address_1 = explode(',', $business->address_1);
$address_2 = explode(',', $business->address_2);
$country = explode(',', $business->country);
$state = explode(',', $business->state);
$city = explode(',', $business->city);
$zip_code = explode(',', $business->zip_code);
$location = explode(',', $business->location);

$all_address = [
    'address_1' => $address_1,
    'address_2' => $address_2,
    'country' => $country,
    'city' => $city,
    'state' => $state,
    'zip_code' => $zip_code,
    'location' => $location,
];
// dd($all_address);
// Initialize an empty array to hold all addresses
$all_addresses = [];

// Loop through each index (assuming all arrays have the same length)
$max_count = max(array_map('count', $all_address));

for ($i = 0; $i < $max_count; $i++) {
      $all_addresses[] = [
        'address_1' => isset($all_address['address_1'][$i]) ? $cleanString($all_address['address_1'][$i]) : '',
        'address_2' => isset($all_address['address_2'][$i]) ? $cleanString($all_address['address_2'][$i]) : '',
        'country'   => isset($all_address['country'][$i]) ? $cleanString($all_address['country'][$i]) : '',
        'state'     => isset($all_address['state'][$i]) ? $cleanString($all_address['state'][$i]) : '',
        'city'      => isset($all_address['city'][$i]) ? $cleanString($all_address['city'][$i]) : '',
        'zip_code'  => isset($all_address['zip_code'][$i]) ? $cleanString($all_address['zip_code'][$i]) : '',
        'location'  => isset($all_address['location'][$i]) ? $cleanString($all_address['location'][$i]) : '',
    ];

}

// Debug output
// dd($all_addresses);
?>
@extends('layouts.frontlayout')
@section('content')
<!-- FancyBox CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css" />

<!-- FancyBox JS -->
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
<style>
/* .file-preview img, .file-preview video {
    max-width: 100px;
    max-height: 100px;
    object-fit: cover;
} */

.likes-list {
        max-height: 300px;
        overflow-y: auto;
    }
    
.like-item {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }
    
.like-user-image {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        margin-right: 10px;
    }
    
   .connect-btn {
        background-color: #dc7228;
        color: white;
        border: none;
        padding: 5px 10px;
        border-radius: 5px;
        cursor: pointer;
    }
    
    .connect-btn:hover {
        background-color: linear-gradient(90deg, rgba(220, 114, 40, 1) 50%, #a54db7 100%);
    }

.modal.fade.show{overflow: hidden; padding-right: 0!important;}
.business-list video.d-block.w-100, .business-list .carousel-item img{height: 500px; object-fit: cover;}
.file-edit-upload {
	position: relative;
	display: flex;
	justify-content: center;
	text-align: center;
	margin-block: 10px;
}

#file-preview-container .img-thumbnail {
  padding: .25rem;
  background-color: #fff;
  border: 1px solid #dee2e6;
  border-radius: .25rem;
  max-width: 90px;
  height: 90px;
  width: 90px;
  object-fit: cover;
}

#file-preview-container i{color: red;}

.file-edit-upload__label {
	display: block;
	padding: 10px;
	color: #000;
	background: transparent;
	border-radius: 0.35em;
	transition: background 0.3s;
	border: 1px solid #ced4da;
	width: 80%;
	font-size: 14px;
}

.file-edit-upload__input {
	position: absolute;
	left: 0;
	top: 0;
	right: 0;
	bottom: 0;
	font-size: 1;
	width: 0;
	height: 100%;
	opacity: 0;
}
#file-preview{display: flex; gap: 25px;}
#file-preview .file-preview-item .file-preview img {
  padding: .25rem;
  background-color: #fff;
  border: 1px solid #dee2e6;
  border-radius: .25rem;
  max-width: 90px !important;
  height: 90px;
  width: 90px;
  max-height: 90px !important;
  object-fit: cover;
}

.file-preview-item {
    display: inline-block;
    position: relative;
    margin:0px 0 30px;
}

.file-preview-item .file-preview {
    display: flex;
    align-items: center;
    position: relative;
}

.file-preview-item .file-preview i {
    position: absolute;
    top: -8px;
    right: -5px;
    cursor: pointer;
    color: red;
}

.dots-menu ul.dropdown-menu {right: 36px; left: auto; min-width: 80px;text-align: center;}
.dots-menu ul.dropdown-menu li {padding: 0;width: auto;display: inline-block;}
.dots-menu .dropdown-menu.show {display: inline-block;}
.dots-menu ul.dropdown-menu li a {margin: 0;padding: 5px 9px;border: 0;
}
.button_for {
    background-color: transparent !important;
    text-align: center;
}
.dots-menu ul.dropdown-menu li a:hover {
    border-radius: 0;
    border: 0;
}
.dots-menu .dropdown-menu a{
    display: block;
    font-size: 14px;
}
.dots-menu .dropdown-menu a:hover {
    background: #dc7228 !important;
    color: #fff!important;
}
.review-content {
	text-align: justify;
	white-space: pre-line;
}

.showmore_address {
  display: none;
  position: relative;
  background: #fff;
  z-index: 1;
  padding: 10px;
  width: 100%;
}

@media only screen and (max-width:767px){
	.business-list video.d-block.w-100{height:140px;}
	.business-list .carousel-item img{height: 300px;}
}

@media only screen and (min-width:768px) and (max-width:991px){
	.business-list video.d-block.w-100{height:300px;}
	.business-list .carousel-item img{height: 300px;}
}
.view_counts {
	position: relative;
}
    
i.fa-regular.fa-bookmark::before {
	font-size: 13px !important;
}
</style>

<section class="business-list">
	<div class="container">
		<div class="card b-card list-card">
			<div class="row p-0 p-md-3">
				<div class="col-lg-4 col-md-5 lt">
					<div class="row">
						<div class="col-6 px-md-0 pe-0">
							<div class="b-logo">
								<a href="#">
									<img src="{{ $business->business_logo ? asset('/business_img/'.$business->business_logo) : asset('uploads/logos/16635000611696-logo.png') }}" alt="...">
								</a>
							</div>
							<!-- Views Icon and Count (conditional) -->
							@if(Setting::get_setting("no_of_views", $business->user_id) == 1 || $business->user_id == UserAuth::getLoginId())
								<div class="view_counts d-flex align-items-center ms-2 mt-2">
									<strong class="zodiac_img">
										<img src="{{ asset('zodiac_image/eye.png') }}" alt="eye.png">
									</strong>
									<span class="ms-1">{{$viewsCount}}</span>
								</div>
							@endif
						</div>
						<div class="col-6 ps-md-0 ps-0">
							<div class="b-gallery-area">
								<!-- <h6 class="text-center">Gallery</h6> -->
								<div class="gallery-cont">
									<?php
										$gallery_img = json_decode($business->gallery_image) ?? [];
										$gallery_img = array_slice($gallery_img, 0, 2); // Get only the first 2 images
										// dd($gallery_img);
									?>
									@foreach($gallery_img as $img)
									<!-- <a href="{{ $business->gallery_image ? asset('/business_img/'.$img) : 'https://www.finderspage.com/public/uploads/logos/16635000611696-logo.png' }}" data-fancybox="gallery" data-caption="{{$img}}">
										<img src="{{ $business->gallery_image ? asset('/business_img/'.$img) : 'https://www.finderspage.com/public/uploads/logos/16635000611696-logo.png' }}" alt="{{$img}}">
									</a> -->
									<a data-bs-toggle="modal" href="#galleryModalToggle" role="button">
										<img src="{{ $business->gallery_image ? asset('/business_img/'.$img) : 'https://www.finderspage.com/public/uploads/logos/16635000611696-logo.png' }}" alt="{{$img}}">
									</a>
									@endforeach
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-8 col-md-7">

					<div class="top-btns"> 
						@if($current_user)
							@if($current_user->id == $business->user_id)
								<div class="invite">
									<a class="btn create-post-button mx-2 mt-0" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Invite</a>
								</div>
							@endif
						@endif
						<?php
							$url = explode(",",$business->selected_button_url);
						?>
						@if($business->add_button == "on")
							@if(count($url) < 1)
								<div class="invite">
									<a href="{{ $business->selected_button_url }}" class="btn create-post-button mx-2">
										{{ $business->selected_button == 'order_online' ? 'Order online' : ucwords(str_replace('_', ' ', $business->selected_button)) }}
									</a>
								</div>							
							@else
							<div class="invite">
								<button class="btn create-post-button mx-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
									{{ $business->selected_button == 'order_online' ? 'Order online' : ucwords(str_replace('_', ' ', $business->selected_button)) }}
								</button>
							</div>							
						
							<div class="collapse online-collapse" id="collapseExample" style="margin-top: 45px;">
								<div class="card card-body">
									@foreach($url as $link)
									<a href="{{ $link }}" >
										{{ $link }}
									</a><br>
									@endforeach
								</div>
							</div>
						@endif
					@endif
					</div>

					<div class="row list-rt">
						<div class="col-lg-7 col-md-7 col-12 bdr-rt">
							<h5 class="card-title">{{$business->business_name}}</h5>
							<div class="share-btn-group">
								<a  terget="_blank" href="https://{{$business->business_website}}" class="btn create-post-button"><i class="bi bi-globe-americas"></i> Website</a>
								{{-- <a class="btn create-button"><i class="bi bi-sign-turn-right-fill"></i> Directions</a> --}}
								{{-- <a class="btn create-post-button"><i class="bi bi-bookmark"></i> Save</a>
								@php 
									$setting_sharebtn = Setting::get_setting('share_btn',$business->user_id);
								@endphp
								@if($setting_sharebtn == 'show'|| $setting_sharebtn == '')
								<button type="button" class="btn create-post-button " data-bs-toggle="modal" data-bs-target="#staticBackdrop_share">Share to 
									<span class="badge badge-secondary"></span><i class="fa fa-share share-icon"></i> </button>
								@endif --}}
								<a terget="_blank"href="tel:{{$business->business_phone}}" class="btn create-post-button"><i class="bi bi-telephone-fill"></i> Call</a>
							</div>
							<ul class="list-group list-group-flush">
							    <li class="list-group-item"><span class="l-text">Categories:</span> {{$category}}</li>

								@if ($business->location)
									<li class="list-group-item">
										<span class="l-text">Located In:</span>
										@php
											$all_location = explode(',',$business->location);
										@endphp
										<span class="show-content toggle_address"> {{$all_location[0]}} <i class="fas fa-angle-down"></i></span>
										<div class="showmore_address">
											<table class="more-cont">
												<tbody>
													<tr>
														<td>{{ implode(', ', array_map('trim', $all_location)) }}</td>
													</tr>
													
												</tbody>
											</table>
										</div>
									</li>
								@endif
							    
								{{-- @if($business->offers_free_consult)
							    <li class="list-group-item"><span class="l-text">Offers free consult:</span> <a href="#">{{ ucfirst($business->offers_free_consult) }}</a></li>
								@endif --}}

								@if($business->offers_free_consult)
							    <li class="list-group-item"><span class="l-text">Offers free consult</span></li>
								@endif

								@if($business->speak_language)
								<li class="list-group-item">
									<span class="l-text">Languages:</span>
									<a href="#">
										{{ implode(', ', array_map('trim', explode(',', $business->speak_language))) }}
									</a>
								</li>								
								@endif

								@if($business->location_of_service)
							    <li class="list-group-item"><span class="l-text">Service location:</span> <a href="#">{{$business->location_of_service}}</a></li>
								@endif

								@if($business->parking)
							    <li class="list-group-item"><span class="l-text">Parking:</span> {{ implode(', ', array_map('trim', explode(',', $business->parking))) }} </li>
								@endif

								@if($business->state_license_number)
							    <li class="list-group-item"><span class="l-text">State license number:</span> {{$business->state_license_number}} </li>
								@endif

								@if($business->state_license_number)
							    <li class="list-group-item"><span class="l-text">Contractor license number:</span> {{$business->contractor_license_number}} </li>
								@endif

							    

								{{-- @if ($BlogLikes->isNotEmpty() && UserAuth::isLogin())
								<li class="list-group-item">
									@if ($business->user_id == UserAuth::getLoginId())
										<div class="likes-container">
									@else 
										<div class="likes-container" style="display: inline !important;">
									@endif
											<div class="likes-info">
											@foreach($BlogLikes as $like)
												@php
													$likes = $like->likes;
													$likedBy = json_decode($like->liked_by, true);
													$userId = UserAuth::getLoginId();
													$userLiked = isset($likedBy[$userId]);
													$otherLikes = $likes - ($userLiked ? 1 : 0);
												@endphp
												{{-- @if ($business->user_id == UserAuth::getLoginId())
													@if ($userLiked && $otherLikes > 0)
													<b>Likes:</b>
														<span class="likes-preview" onclick="showLikes({{ $like->id }})">
														you & {{ $otherLikes }} {{ $otherLikes == 1 ? 'other' : 'others' }}
														</span>
													@elseif ($userLiked && $otherLikes == 0)
													<b>Likes:</b>
														<span class="likes-preview" onclick="showLikes({{ $like->id }})">1 like</span>
													@elseif (!$userLiked && $likes > 0)
													<b>Likes:</b>
														<span class="likes-preview" onclick="showLikes({{ $like->id }})">
														{{ $likes }} {{ $likes == 1 ? 'like' : 'likes' }}
														</span>
													@endif
												@endif 
												@endforeach
											</div>

											<div class="">
											@if ($business->user_id == UserAuth::getLoginId())
												<button type="button" class="like-button" id="toggleLikes" data-user-id="{{ $userId }}" data-blog-id="{{ $like->blog_id }}" data-blog-user-id="{{ $business->user_id }}" data-type="Business" data-cate-id="1" data-url={{ route('business_page.front.single.listing', $business->slug) }}>
											@else
												<button type="button" class="like-button" id="toggleLikes" data-user-id="{{ UserAuth::getLoginId() }}" data-blog-id="{{ $business->id }}" data-blog-user-id="{{ $business->user_id }}" data-type="Business" data-cate-id="1" data-url={{ route('business_page.front.single.listing', $business->slug) }} style="padding: 6px 8px !important; width: auto !important; margin: 0 !important;">
											@endif
													@if ($userLiked && $likedBy[$userId] == 1)
														<img src="{{ asset('images/heart-icon.png') }}" id="1" class="rxn-emoji" alt="emoji-icon" style="width: 23px; height: 23px;">
													@elseif ($userLiked && $likedBy[$userId] == 2)
														<img src="{{ asset('images/thumb-icon.png') }}" id="2" class="rxn-emoji" alt="emoji-icon" style="width: 23px; height: 23px;">
													@else
														<i class="fa-regular fa-thumbs-up emoji"></i>
													@endif

													@if ($business->user_id == UserAuth::getLoginId() || $setting_like_option == "1")
														<span class="likes-count">{{ $likes }}</span>
													@endif
												</button>
												<div class="reactions-emojis mt-1" style="display: none; width: 92px !important;">
													<img src="{{ asset('images/heart-icon.png') }}" class="heart-icon" data-id="1" alt="Heart Icon">
													<img src="{{ asset('images/thumb-icon.png') }}" class="thumb-icon" data-id="2" alt="Thumb Icon">
												</div>

										</div>
									</div>
								</li>
									
								@elseif ($business->user_id == UserAuth::getLoginId())
								<li class="list-group-item">
								@if(UserAuth::isLogin())
									<div class="likes-container">
										<div class="likes-info">
											<b>Likes: </b>
											<span class="likes-preview">no likes</span>
										</div>
										<div class="">
											<button type="button" class="like-button" id="toggleLikes" data-user-id="{{ UserAuth::getLoginId() }}" data-blog-id="{{ $business->id }}" data-blog-user-id="{{ $business->user_id }}" data-type="Business" data-cate-id="1" data-url={{ route('business_page.front.single.listing', $business->slug) }}>
												<i class="fa-regular fa-thumbs-up emoji"></i>
												<span class="likes-count">0</span>
											</button>
											<div class="reactions-emojis mt-1" style="display: none; width: 92px !important;">
												<img src="{{ asset('images/heart-icon.png') }}" class="heart-icon" data-id="1" alt="Heart Icon">
												<img src="{{ asset('images/thumb-icon.png') }}" class="thumb-icon" data-id="2" alt="Thumb Icon">
											</div>
										</div>
									</div>
								@else
									<a target="blank" href="{{route('auth.signupuser')}}" onclick="showAlertForLogin()"> 
										<button type="button" class="like-button">
											<i class="fa-regular fa-thumbs-up emoji"></i>
										</button>
									</a>
								@endif
								</li>

								@else 
									<li class="list-group-item">
										@if(UserAuth::isLogin())
											<div class="likes-container">
												<div class="">
													<button type="button" class="like-button" id="toggleLikes" data-user-id="{{ UserAuth::getLoginId() }}" data-blog-id="{{ $business->id }}" data-blog-user-id="{{ $business->user_id }}" data-type="Business" data-cate-id="1" data-url={{ route('business_page.front.single.listing', $business->slug) }}>
														<i class="fa-regular fa-thumbs-up emoji"></i>
													</button>
													<div class="reactions-emojis mt-1" style="display: none;">
														<img src="{{ asset('images/heart-icon.png') }}" class="heart-icon" data-id="1" alt="Heart Icon">
														<img src="{{ asset('images/thumb-icon.png') }}" class="thumb-icon" data-id="2" alt="Thumb Icon">
													</div>
												</div>
											</div>
										@else
											<a target="blank" href="{{route('auth.signupuser')}}" onclick="showAlertForLogin()"> 
												<button type="button" class="like-button">
													<i class="fa-regular fa-thumbs-up emoji"></i>
												</button>
											</a>
										@endif
									</li>
								@endif
							
						    </ul>
						    <!-- Likes Modal -->
							<div id="showLikesModal" class="showLikes-modal" style="display: none;">
								<div class="modal-content">
									<span class="close" onclick="closeShowLikes()">&times;</span>
									<h2 class="text-center">Likes</h2>
									<div class="showLikes-list px-1">

									</div>
								</div>
							</div> --}}

							<div class="single-job-apply d-flex justify-content-start flex-wrap gap-3">
								@if ($BlogLikes->isNotEmpty() && UserAuth::isLogin())
								@foreach($BlogLikes as $like)
									@php
										$likes = $like->likes;
										$likedBy = json_decode($like->liked_by, true);
										$userId = UserAuth::getLoginId();
										$userLiked = isset($likedBy[$userId]);
										$otherLikes = $likes - ($userLiked ? 1 : 0);
									@endphp
	
								<div class="d-flex align-items-center">
									@if ($business->user_id == UserAuth::getLoginId())
									<button type="button" class="like-button" id="toggleLikes" data-user-id="{{ $userId }}" data-blog-id="{{ $like->blog_id }}" data-blog-user-id="{{ $business->user_id }}" data-type="Business" data-cate-id="1" data-url={{ route('business_page.front.single.listing', $business->slug) }}>
									@else
									<button type="button" class="like-button" id="toggleLikes" data-user-id="{{ UserAuth::getLoginId() }}" data-blog-id="{{ $business->id }}" data-blog-user-id="{{ $business->user_id }}" data-type="Business" data-cate-id="1" data-url={{ route('business_page.front.single.listing', $business->slug) }} style="padding: 6px 8px !important; width: auto !important; margin: 0 !important;">
									@endif
										@if ($userLiked && $likedBy[$userId] == 1)
											<img src="{{ asset('images/heart-icon.png') }}" id="1" class="rxn-emoji" alt="emoji-icon" style="width: 23px; height: 23px;">
										@elseif ($userLiked && $likedBy[$userId] == 2)
											<img src="{{ asset('images/thumb-icon.png') }}" id="2" class="rxn-emoji" alt="emoji-icon" style="width: 23px; height: 23px;">
										@else
											<i class="fa-regular fa-thumbs-up emoji"></i>
										@endif
									</button>
									
									@if ($business->user_id == UserAuth::getLoginId())
										<span class="likes-count" onclick="showLikes({{ $like->id }})">{{ $likes }}</span>
									@elseif ($setting_like_option == "1")
										<span class="likes-count">{{ $likes }}</span>
									@endif
	
									<div class="reactions-emojis mt-1" style="display: none;">
										<img src="{{ asset('images/heart-icon.png') }}" class="heart-icon" data-id="1" alt="Heart Icon">
										<img src="{{ asset('images/thumb-icon.png') }}" class="thumb-icon" data-id="2" alt="Thumb Icon">
									</div>
								</div>
								@endforeach
	
								<!-- Likes Modal -->
								<div id="showLikesModal" class="showLikes-modal" style="display: none;">
									<div class="modal-content">
										<span class="close" onclick="closeShowLikes()">&times;</span>
										<h2 class="text-center">Likes</h2>
										<div class="showLikes-list px-1">
	
										</div>
									</div>
								</div>
								@else 
									@if(UserAuth::isLogin())
										<div class="d-flex align-items-center">
											<button type="button" class="like-button" id="toggleLikes" data-user-id="{{ UserAuth::getLoginId() }}" data-blog-id="{{ $business->id }}" data-blog-user-id="{{ $business->user_id }}" data-type="Business" data-cate-id="1" data-url={{ route('business_page.front.single.listing', $business->slug) }}>
												<i class="fa-regular fa-thumbs-up emoji"></i>
											</button>
											<span class="likes-count"></span>
											<div class="reactions-emojis mt-1" style="display: none;">
												<img src="{{ asset('images/heart-icon.png') }}" class="heart-icon" data-id="1" alt="Heart Icon">
												<img src="{{ asset('images/thumb-icon.png') }}" class="thumb-icon" data-id="2" alt="Thumb Icon">
											</div>
										</div>
									@else
										<a target="blank" href="{{route('auth.signupuser')}}" onclick="showAlertForLogin()"> 
											<button type="button" class="like-button">
												<i class="fa-regular fa-thumbs-up emoji"></i>
											</button>
										</a>
									@endif
								@endif
							
								@php 
									$setting_sharebtn = Setting::get_setting('share_btn', $business->user_id);
								@endphp
							
								@if($setting_sharebtn == 'show' || $setting_sharebtn == '')
									<div class="d-flex align-items-center">
										<button type="button" class="btn create-post-button" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
											<i class="fa-regular fa-paper-plane"></i>
										</button>
										<span class="ms-2">{{ $blogShares->shares ?? '' }}</span>
									</div>
								@endif
							
								<div class="d-flex align-items-center">
									<a data-postid="{{ $business->id }}" data-type="Business" data-Userid="{{ UserAuth::getLoginId() }}"
									   class="{{ $existingRecord ? 'unsaved_post_btn' : 'saved_post_btn' }} apply btn create-post-button"
									   href="javascript:void(0);">
										<i class="{{ $existingRecord ? 'fa-solid' : 'fa-regular' }} fa-bookmark" style="{{ $existingRecord ? 'color: #131313;' : '#fff;' }}"></i>
									</a>
								</div>                            
								
							</div>

							@if($business->facebook)
								<a href="https://www.facebook.com/{{$business->facebook}}" target="_blank" class="facebook">
									<i style="position: inherit;" class="fab fa-facebook-f" aria-hidden="true"></i>
								</a>
							@endif

							@if($business->instagram)
								<a href="https://www.instagram.com/{{$business->instagram}}" target="_blank" class="instagram">
									<i style="position: inherit;" class="fab fa-instagram" aria-hidden="true"></i>
								</a>
							@endif

							@if($business->whatsapp)
								<a href="https://wa.me/{{$business->whatsapp}}?text=Hello%2C%20World!" target="_blank" class="whatsapp">
									<i style="position: inherit;" class="fab fa-whatsapp" aria-hidden="true"></i>
								</a>
							@endif

							@if($business->youtube)
								<a href="https://www.youtube.com/{{$business->youtube}}" target="_blank" class="youtube">
									<i style="position: inherit;" class="fab fa-youtube" aria-hidden="true"></i>
								</a>
							@endif
							@if($business->tiktok)
                            <a href="https://www.tiktok.com/{{$business->tiktok}}" target="_blank" class="Tiktok"><i style="position: inherit;" class="bi bi-tiktok" aria-hidden="true"></i></a>
                            @endif

						</div>
						<div class="col-lg-5 col-md-5 col-12">
							<h5 class="card-title">Contact Infomation</h5>
							<ul class="list-group list-group-flush">
								@if ($business->business_phone)
									<li class="list-group-item"><span class="l-text">Phone:</span> <a href="tel:{{$business->business_phone}}">{{$business->business_phone}}</a></li>
								@endif
								@if ($business->business_email)
							    	<li class="list-group-item"><span class="l-text">Email:</span> <a href="mailto:{{$business->business_email}}">{{$business->business_email}}</a></li>
								@endif
								@if (!empty($all_addresses) && collect($all_addresses)->contains(function($address) {
									return !empty($address['address_1']);
								}))
									<li class="list-group-item">
										<span class="l-text">Address:</span>
										<span class="show-content toggle_address">
											{{$all_addresses[0]['address_1']}} <i class="fas fa-angle-down"></i>
										</span>
										<div class="showmore_address">
											<table class="more-cont">
												<tbody>
													@foreach($all_addresses as $address)
														@if(!empty($address['city']) || !empty($address['state']) || !empty($address['zip_code']) || !empty($address['country']))
															<tr>
																<td>
																	{{ implode(', ', array_filter([$address['city'], $address['state'], $address['zip_code'], $address['country']])) }}
																</td>
															</tr>
														@endif
													@endforeach
												</tbody>
											</table>
										</div>
									</li>
								@endif
								
						    	@if ($business->opening_hours)
								@php
									$opening_hours = explode(',',$business->opening_hours);
									
									$days = [
										"Monday" => 1,
										"Tuesday" => 2,
										"Wednesday" => 3,
										"Thursday" => 4,
										"Friday" => 5,
										"Saturday" => 6,
										"Sunday" => 7
									];
									usort($opening_hours, function($a, $b) use ($days) {
										$dayA = explode(':', $a)[0];
										$dayB = explode(':', $b)[0];
									
										return $days[$dayA] - $days[$dayB];
									});
									
									// dd($opening_hours);
									@endphp
									<li class="list-group-item"><span class="l-text">Hours:</span> <span class="show-content toggle"> {{$opening_hours[0]}} <i class="fas fa-angle-down"></i></span>
										<div class="showmore">
											<table class="more-cont">
												<tbody>
													@foreach($opening_hours as $hours)
													<tr>
														<td>{{$hours}}</td>
													</tr>
													@endforeach
												</tbody>
											</table>
										</div>
									</li>
								@endif

								<li><span class="l-text">Posted by:</span> 
									@if(UserAuth::isLogin())
										<a target="blank" href="{{route('UserProfileFrontend',$userSlug->slug)}}"> {{$user_all_data->first_name}}</a>
									@elseif(AdminAuth::isLogin())
										<a target="blank" href="{{route('UserProfileFrontend.admin', $userSlug->slug)}}"> {{$user_all_data->first_name}}</a>
									@else
										<a target="blank" href="{{route('auth.signupuser')}}" onclick="showAlertForSave()"> {{$user_all_data->first_name}}</a>
									@endif
								</li>
							</ul>
						</div>
						<div class="col-lg-12">
							<div class="b-description">
								<h6 class="">Description</h6>
								<div class="text-view view-description">
									<p>{!! $business->business_description !!}</p>
								</div>
							</div>
							<!-- <div class="show-more">Show more</div> -->
						</div>
							
					</div>

					<!-- <div class="list-rt">
						
						
						
					</div> -->
				</div>
				<!-- <div class="col-lg-12">
					<div class="b-description">
						<h6 class="text-center">Description</h6>
						<p>{!! $business->business_description !!}</p>
					</div>
				</div> -->

				<!-- <div class="col-lg-12">
					<div class="b-gallery-area">
						<h6 class="text-center">Gallery</h6>
						<div class="gallery-cont">
							<//?php
								$gallery_img = json_decode($business->gallery_image) ?? [];
								// dd($gallery_img);
							?>
							@foreach($gallery_img as $img)
							<a href="{{ $business->gallery_image ? asset('/business_img/'.$img) : 'https://www.finderspage.com/public/uploads/logos/16635000611696-logo.png' }}" data-fancybox="gallery" data-caption="{{$img}}">
								<img src="{{ $business->gallery_image ? asset('/business_img/'.$img) : 'https://www.finderspage.com/public/uploads/logos/16635000611696-logo.png' }}" alt="{{$img}}">
							</a>
							@endforeach
						</div>
					</div>
				</div> -->

				<div class="col-lg-12">
					<div class="b-reviews">
						<div class="review-head mb-4">
							<h6 class="text-center">Reviews</h6>
							<div class="btn-rt">
								@if (UserAuth::getLoginId())
									<a href="#" class="web-btn" data-bs-toggle="modal" data-bs-target="#writeModal">Write a review</a>
								@else
									<a target="blank" class="web-btn" href="{{route('auth.signupuser')}}" onclick="showAlertForSave()"> Write a review</a>
								@endif
							</div>
						</div>

						<!--Write Review Modal-->
						<div class="modal fade write-review" id="writeModal" tabindex="-1" aria-labelledby="writeModalLabel" aria-hidden="true">
							<div class="modal-dialog modal-dialog-centered">
								<div class="modal-content">
									{{-- <div class="modal-header">
										<h5 class="modal-title" id="writeModalLabel">Finders Business</h5>
									</div> --}}
									<div class="modal-body">
										<form id="reviewForm" enctype="multipart/form-data">
											@csrf
											<input type="hidden" name="product_id" value="{{ $business->id }}">
											<input type="hidden" name="email" value="{{ $businessUser->email }}">
											<input type="hidden" name="name" value="{{ $businessUser->first_name }}">
											<input type="hidden" name="blog_user_id" value="{{ $business->user_id }}">
											<input type="hidden" name="slug" value="{{ $business->slug }}">
											<input type="hidden" name="url" value="{{ route('business_page.front.single.listing', $business->slug) }}">
											<input type="hidden" name="type" value="business">
											<div class="row mb-3">
												<div class="col-lg-2">
													@if (UserAuth::getLoginId())
													<img src="{{ asset($current_user->image ? 'assets/images/profile/' . $current_user->image : 'user_dashboard/img/undraw_profile.svg') }}"
														class="rounded-circle img-fluid shadow-1"
														alt="Profile Avatar"
														width="50"
														height="50" />												   
													@else
													<img src="{{ asset('user_dashboard/img/undraw_profile.svg') }}"
														class="rounded-circle img-fluid shadow-1" 
														alt="Profile Avatar" 
														width="50" 
														height="50" />
													@endif
						
													{{-- <img src="{{ $current_user->image ? asset('assets/images/profile/' . $current_user->image) : asset('user_dashboard/img/undraw_profile.svg')}}"
													class="rounded-circle img-fluid shadow-1" alt="woman avatar" width="50" height="50" /> --}}
												</div>
												<div class="col-lg-10">
													@if (UserAuth::getLoginId())
														<h6>{{ $current_user->first_name }}</h6>
													@else
														<h6>Anonymous</h6>
													@endif
						
													{{-- <h6>{{ $current_user->first_name ?? 'Anonymous' }}</h6> --}}
													<p class="mb-0">Posting publicly across Google</p>
												</div>
											</div>
											<div class="mb-3">
												<div class="rating">
													<input type="number" name="rating" hidden>
													<i class='bx bx-star star' data-value="1" style="--i: 0;"></i>
													<i class='bx bx-star star' data-value="2" style="--i: 1;"></i>
													<i class='bx bx-star star' data-value="3" style="--i: 2;"></i>
													<i class='bx bx-star star' data-value="4" style="--i: 3;"></i>
													<i class='bx bx-star star' data-value="5" style="--i: 4;"></i>
												</div>
											</div>
											<div class="mb-3">
												<textarea class="form-control" name="description" id="message-text" rows="4" placeholder="Share details of your own experience at this place"></textarea>
											</div>
											<div class="file-upload">
												<label for="upload" class="file-upload__label"><i class="fas fa-camera"></i> Add photos or videos</label>
												<input id="upload" class="file-upload__input" type="file" name="files[]" multiple>
											</div>
											<div id="file-preview" class="mt-3"></div>
											<div class="modal-footer write-submit">
												<button type="button" class="btn" data-bs-dismiss="modal">Close</button>
												<button type="submit" class="btn" data-bs-dismiss="modal" id="submitReview">Post</button>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>

						<div id="reviews-list">
						@foreach($reviews as $index => $review)
						<div class="row mb-3 align-items-start">
							<div class="col-lg-1">
								@if($review->user && $review->user->image)
									<img src="{{ asset('assets/images/profile/' . $review->user->image) }}"
										class="rounded-circle img-fluid shadow-1"
										alt="member avatar"
										width="50"
										height="50" />
								@else
									<img src="{{ asset('user_dashboard/img/undraw_profile.svg') }}"
										class="rounded-circle img-fluid shadow-1"
										alt="default avatar"
										width="50"
										height="50" />
								@endif
							</div>
							<div class="col-lg-11 d-flex justify-content-between align-items-start">
								<div class="flex-grow-1">
									<p class="fw-bold lead mb-0"><strong>{{ $review->user->first_name ?? 'Anonymous' }}</strong></p>
				
									@if ($review->files)
										@php
											$files = json_decode($review->files, true);
											$fileCount = is_array($files) ? count($files) : 1;
										@endphp
										<a href="#" class="text-muted" data-bs-toggle="modal" data-bs-target="#filesModal-{{ $review->id }}">
											{{ $fileCount }} {{ $fileCount == 1 ? 'file' : 'files' }}
										</a>
									@endif
				
									<div class="rating py-0">
										<div class="star">
											@for ($i = 1; $i <= 5; $i++)
												@if ($i <= $review->rating)
													<i class="fas fa-star"></i>
												@else
													<i class="far fa-star"></i>
												@endif
											@endfor
											@php
												$givenTime = strtotime($review->created_at);
												$currentTimestamp = time();
												$timeDifference = $currentTimestamp - $givenTime;
											
												$years = floor($timeDifference / (60 * 60 * 24 * 365));
												$months = floor($timeDifference / (60 * 60 * 24 * 30));
												$days = floor($timeDifference / (60 * 60 * 24));
												$weeks = floor($timeDifference / (60 * 60 * 24 * 7));
											
												if ($years > 0) {
													$timeAgo = ($years == 1) ? "$years year ago" : "$years years ago";
												} elseif ($months > 0) {
													$timeAgo = ($months == 1) ? "$months month ago" : "$months months ago";
												} elseif ($weeks > 0) {
													$timeAgo = ($weeks == 1) ? "$weeks week ago" : "$weeks weeks ago";
												} elseif ($days > 0) {
													$timeAgo = ($days == 1) ? "$days day ago" : "$days days ago";
												} else {
													$timeAgo = "Posted today";
												}
											@endphp
											<span class="text-muted ml-1">{{ $timeAgo }}</span>
										</div>
									</div>
									
									<p class="review-content mb-0">{{ $review->description }}</p>
								</div>
				
								<div class="dots-menu btn-group ms-2">
									@if (UserAuth::getLoginId() == $review->user_id)
										<a data-toggle="dropdown" class="btn btn-primary" onclick="showDropdown({{ $review->id }})"><i class='fas fa-ellipsis-v'></i></a>
										<ul class="dropdown-menu" id="dropdown-{{ $review->id }}">
											<li><a class="btn button_for" data-bs-toggle="modal" id="editModal" href="#editModal-{{ $review->id }}" data-review-id="{{ $review->id }}" data-review-files="{{ $review->files }}"><i class="fa fa-pencil" style="font-size: 13px;"></i></a></li>
											<li><a class="btn btn-danger button_for" onclick="deleteComment({{ $review->id }})"><i class="fa fa-trash-o"></i></a></li>
										</ul>
									@endif
								</div>
							</div>
						</div>
				
						<!-- Modal for displaying media -->
						@if ($review->files)
						@php
							$files = json_decode($review->files, true);
						@endphp
							<div class="modal fade" id="filesModal-{{ $review->id }}" tabindex="-1" aria-labelledby="filesModalLabel-{{ $review->id }}" aria-hidden="true">
								<div class="modal-dialog modal-lg">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="filesModalLabel-{{ $review->id }}">Media Files</h5>
											<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
										</div>
										<div class="modal-body">
											<div id="carousel-{{ $review->id }}" class="carousel slide">
												<div class="carousel-inner">
													@foreach($files as $fileIndex => $file)
														@php
															$fileExtension = pathinfo($file, PATHINFO_EXTENSION);
															$activeClass = $fileIndex === 0 ? 'active' : '';
														@endphp
														<div class="carousel-item {{ $activeClass }}">
															@if(in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']))
																<img src="{{ asset('images_reviews/' . $file) }}" class="d-block w-100" alt="media image" />
															@elseif(in_array($fileExtension, ['mp4', 'avi', 'mov', 'wmv']))
																<video src="{{ asset('images_reviews/' . $file) }}" class="d-block w-100" controls></video>
															@else
																<p>Unsupported file type</p>
															@endif
														</div>
													@endforeach
												</div>
										
												@if(count($files) > 1)
													<a class="carousel-control-prev" href="#carousel-{{ $review->id }}" role="button" data-bs-slide="prev">
														<span class="carousel-control-prev-icon" aria-hidden="true"></span>
														<span class="visually-hidden">Previous</span>
													</a>
													<a class="carousel-control-next" href="#carousel-{{ $review->id }}" role="button" data-bs-slide="next">
														<span class="carousel-control-next-icon" aria-hidden="true"></span>
														<span class="visually-hidden">Next</span>
													</a>
												@endif
											</div>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
										</div>										
									</div>
								</div>
							</div>

							@endif

							<!-- Edit Review Modal -->
							<div class="modal fade write-review" id="editModal-{{ $review->id }}" tabindex="-1" aria-labelledby="editModalLabel-{{ $review->id }}" aria-hidden="true">
								<div class="modal-dialog modal-dialog-centered">
									<div class="modal-content">
										{{-- <div class="modal-header">
											<h5 class="modal-title" id="editModalLabel-{{ $review->id }}">Finders Business</h5>
										</div> --}}
										<div class="modal-body">
											<form id="updateReviewForm-{{ $review->id }}" enctype="multipart/form-data">
												@csrf
													<input type="hidden" name="product_id" value="{{ $business->id }}">
													<input type="hidden" name="email" value="{{ $businessUser->email }}">
													<input type="hidden" name="name" value="{{ $businessUser->first_name }}">
													<input type="hidden" name="blog_user_id" value="{{ $business->user_id }}">
													<input type="hidden" name="slug" value="{{ $business->slug }}">
													<input type="hidden" name="url" value="{{ route('business_page.front.single.listing', $business->slug) }}">
													<input type="hidden" name="type" value="business">
												<div class="row mb-3">
													<div class="col-lg-2">
														@if (UserAuth::getLoginId())
															<img src="{{ asset($current_user->image ? 'assets/images/profile/' . $current_user->image : 'user_dashboard/img/undraw_profile.svg') }}" class="rounded-circle img-fluid shadow-1" alt="user avatar" width="50" height="50" />
														@else
															<img src="{{ asset('user_dashboard/img/undraw_profile.svg') }}" class="rounded-circle img-fluid shadow-1" alt="default avatar" width="50" height="50" />
														@endif
													</div>
													<div class="col-lg-10">
														@if (UserAuth::getLoginId())
															<h6>{{ $current_user->first_name }}</h6>
														@else
															<h6>Anonymous</h6>
														@endif
														<p class="mb-0">Posting publicly across Google</p>
													</div>
												</div>
												<div class="mb-3">
													<div class="rating">
														<input type="hidden" name="rating" id="ratingValue-{{ $review->id }}" value="{{ $review->rating }}">
														@for ($i = 1; $i <= 5; $i++)
															<i class='bx {{ $i <= $review->rating ? 'bxs-star' : 'bx-star' }} star' data-value="{{ $i }}" style="--i: {{ $i - 1 }};"></i>
														@endfor
													</div>
												</div>
												<div class="mb-3">
													<textarea class="form-control" name="description" id="message-text-{{ $review->id }}" rows="4" placeholder="Share details of your own experience at this place">{{ $review->description }}</textarea>
												</div>
												
												<!-- File Upload -->
												<div class="file-edit-upload">
													<label for="upload-edit-{{ $review->id }}" class="file-edit-upload__label">
														<i class="fas fa-camera"></i> Add photos or videos
													</label>

    												<input id="upload-edit-{{ $review->id }}" 
    												       class="file-edit-upload__input" 
    												       type="file" 
    												       name="files[]" 
    												       multiple 
    												       data-review-id="{{ $review->id }}">
												</div>
												
												<div id="file-preview-container" class="row">
												  @if ($review->files)
													@foreach(json_decode($review->files) as $i => $file)
														@php
															$fileExtension = pathinfo($file, PATHINFO_EXTENSION);
															$isImage = in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif']);
															$isVideo = in_array(strtolower($fileExtension), ['mp4', 'webm', 'ogg']);
														@endphp
												
														<div id="file-preview-{{ $i }}" class="col-md-3 mb-3">
															<div class="position-relative">
																@if($isImage)
																	<img src="{{ asset('images_reviews/' . $file) }}" alt="file" class="img-thumbnail">
																@elseif($isVideo)
																	<video controls class="img-thumbnail">
																		<source src="{{ asset('images_reviews/' . $file) }}" type="video/{{ $fileExtension }}">
																		Your browser does not support the video tag.
																	</video>
																@endif
																<i class="fas fa-times position-absolute top-0 start-100 translate-middle"
																   style="cursor: pointer;"
																   onclick="removeFile('{{ $i }}', '{{ $review->id }}', '{{ $file }}')"
																   data-review-id="{{ $review->id }}"
																   data-file="{{ $file }}"
																   data-index="{{ $i }}">
																</i>
															</div>
														</div>
													@endforeach
												  @endif
												</div>												
											</div>

												<div class="modal-footer write-submit">
													<button type="button" class="btn" data-bs-dismiss="modal">Close</button>
													<button type="button" class="btn" onclick="submitEditReview(event, {{ $review->id }})">Post</button>
												</div>
											</form>
										</div>
									</div>
								</div>
						@endforeach
						</div>
						</div>
					</div>
				</div>				
			

				<div class="col-lg-12">
					<div class="b-gallery-area business-frame">
						<h6 class="text-center">Latest Business</h6>
					</div>
					<div class="row">
						@foreach($latest_business as $busines_new)
						<div class="col-lg-4 col-md-6">
							<div class="card b-card related-card">
								<div class="b-image-area">
									<div class="b-logo">
										<a href="{{ route('business_page.front.single.listing', $business->slug) }}">
											<img src="{{ $busines_new->business_logo ? asset('/business_img/'.$busines_new->business_logo) : 'https://www.finderspage.com/public/uploads/logos/16635000611696-logo.png' }}" alt="...">
										</a>
									</div>
									<?php
							$gallery_img = json_decode($busines_new->gallery_image) ?? [];
							$imageCount = count($gallery_img);
							?>
							<div class="b-gallery  @if($imageCount > 0 && $imageCount <= 4) single-img @elseif($imageCount > 4)multi-img @endif">
								@if($imageCount > 0 && $imageCount <= 4)
									{{-- Display one full-width image --}}
									<a href="{{route('business_page.front.single.listing',$busines_new->slug)}}">
										<img  src="{{ $busines_new->business_logo ? asset('/business_img/'.$gallery_img[0]) : 'https://www.finderspage.com/public/uploads/logos/16635000611696-logo.png' }}" alt="Business Image" >
									</a>
								@elseif($imageCount > 4)
									{{-- Display a gallery of 4 images --}}
									@foreach(array_slice($gallery_img, 0, 4) as $img)
										<a href="{{route('business_page.front.single.listing',$busines_new->slug)}}">
											<img  src="{{ $busines_new->business_logo ? asset('/business_img/'.$img) : 'https://www.finderspage.com/public/uploads/logos/16635000611696-logo.png' }}" alt="Business Image">
										</a>
									@endforeach
								@endif
								<a href="{{route('business_page.front.single.listing',$busines_new->slug)}}" class="b-btn">See Photos</a>
									</div>
								</div>
								<div class="card-body">
								    <h5 class="card-title">{{$busines_new->title}}</h5>
								    <div class="buttons-frame">
								    	<a terget="_blank" href="https://{{$busines_new->business_website}}" class="web-btn">Website</a>
								    	<a terget="_blank"href="tel:{{$busines_new->business_phone}}" class="web-btn">Call</a>
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

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Invite your connections</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        @foreach($followerDetailsArray as $followers)
        <div class="likes-list">
          <div class="like-item">
            <a href="#" target="_blank">
              <img src="{{asset('assets/images/profile')}}/{{$followers['image']}}" alt="{{$followers['username']}}" class="like-user-image">
            </a>
            <div class="like-user-info w-100 text-start px-2">
              <a href="#" target="_blank">
                <h6 class="font-weight-bold">{{$followers['first_name']}}</h6>
              </a>
            </div>
            
            @php $connectionFound = false; @endphp  <!-- Variable to check if a connection is found -->
            
            @foreach($connected_business_member as $connectd)
              @if($connectd->user_id == $followers['id'])
                @php $connectionFound = true; @endphp  <!-- Mark that a connection is found -->

                @if(isset($connectd->status) && $connectd->status == 1)
                  <button class="connect-btn">Accepted</button>
                @break  <!-- Stop further iterations for this user -->
                  
                @elseif(isset($connectd->status) && $connectd->status == 0)
                  <button class="connect-btn" >Requested</button>
                  @break  <!-- Stop further iterations for this user -->
                @endif

              @endif
            @endforeach
            
            <!-- Show Invite button only if no connection was found -->
            @if(!$connectionFound)
              <button class="connect-btn send_invitation" 
                      business_id="{{$business->id}}" 
                      from_id="{{$business->user_id}}" 
                      user_id="{{$followers['id']}}" 
                      business_url="{{route('business_page.front.single.listing',$business->slug)}}">Invite
              </button>
            @endif

          </div>
        </div>
        <hr>
        @endforeach
      </div>
    </div>
  </div>
</div>

</section>
<!--Share Modal Start-->
<div class="modal fade share-modal" id="staticBackdrop_share" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel_share" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
		<div class="modal-header border-0">
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<div class="modal-body">
			<div class="copy-text">
			<input type="text" class="text" value="{{url('/business-single-list')}}/{{$business->slug}}" id="field_input"/>
			<a href="javascript:void(0);" redirect-url="{{url('/chatify')}}/{{$user_all_data->id}}" copy-url="{{url('/business-single-list')}}/{{$business->slug}}" class="copy_url btn create-post-button ms-2" data-placement="top" data-toggle="tooltip" title="Share in Chat">
				<i class="fa fa-clone"></i>
			</a>
			</div>
			<hr>
			<div class="copy-text">
			<input type="text" class="text" value="Share link via email" readonly id="email_input"/>
			<a href="mailto:{{$user_all_data->email }}?subject={{$business->title}}&body=Page link : {{url('/business-single-list')}}/{{$business->slug}}" class="btn create-post-button ms-2" data-placement="top" data-toggle="tooltip" title="Email">
				<i class="fa-solid fa-envelope"></i>
			</a>
			</div>
			<div class="share-by">
			<i class="fa fa-share-alt" aria-hidden="true"></i> Share url on social media, click on the icons below.
			</div>
			<div class="modal-share-icon">
			{!! $shareComponent !!}
			</div>
		</div>
		</div>
	</div>
</div>
<!--Share Modal End--> 

<!--Business Gallery Modal-->
<div class="modal fade gallery-modal" id="galleryModalToggle" aria-hidden="true" aria-labelledby="galleryModalToggleLabel" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="galleryModalToggleLabel">Business Image Gallery</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body container">
        <div class="row">
        	<div class="col-lg-12">
				<div class="swiper-container-wrapper">
					<div class="swiper-container gallery-thumbs">
					    <div class="swiper-wrapper">
						<?php
							$gallery_img = json_decode($business->gallery_image) ?? [];
							// dd($gallery_img);
						?>
						@foreach($gallery_img as $img)
						    <div class="swiper-slide">
								<img src="{{ $busines_new->business_logo ? asset('/business_img/'.$img) : 'https://www.finderspage.com/public/uploads/logos/16635000611696-logo.png' }}" alt="...">
							</div>
						    {{-- <div class="swiper-slide">
								<img src="https://www.finderspage.com/public/business_img/1729572542_himm.jpg" alt="1729572542_himm.jpg">
							</div>
						    <div class="swiper-slide">
								<img src="https://www.finderspage.com/public/business_img/1729572542_images.jpg" alt="1729572542_images.jpg">
							</div>
						    <div class="swiper-slide">
						    	<img src="https://www.finderspage.com/public/business_img/1729572542.jpg" alt="...">
						    	<i class="bi bi-play"></i>
						    </div> --}}
						@endforeach
					    </div>
					</div>

					<div class="swiper-container gallery-top">
					    <div class="swiper-wrapper">
						@foreach($gallery_img as $img)
					        <div class="swiper-slide">
					        	<img src="{{ $busines_new->business_logo ? asset('/business_img/'.$img) : 'https://www.finderspage.com/public/uploads/logos/16635000611696-logo.png' }}" alt="...">
						    </div>
						@endforeach
						    {{-- <div class="swiper-slide">
						        <img src="https://www.finderspage.com/public/business_img/1729572542_himm.jpg" alt="1729572542_himm.jpg">
						    </div>
						    <div class="swiper-slide">
						        <img src="https://www.finderspage.com/public/business_img/1729572542_images.jpg" alt="1729572542_images.jpg">
						    </div> --}}
							@if(!empty($business->video) )
								<div class="swiper-slide">
									<video controls>
										<source src="{{asset('/business_img/'.$business->video)}}" type="video/mp4">
										Your browser does not support the video tag.
									</video>
								</div>
							@endif
					    </div>
					    <div class="swiper-button-next"></div>
					    <div class="swiper-button-prev"></div>
					</div>
				</div>
        	</div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--Business Gallery Modal-->

<link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
// $('.toggle').click(function() {
//     $(this).next('.showmore').toggle();
// });
// $('.toggle_address').click(function() {
//     $(this).next('.showmore_address').toggle();
// });

$('.toggle').click(function() {
    $(this).next('.showmore').stop(true, true).slideToggle();
});
$('.toggle_address').click(function() {
    $(this).next('.showmore_address').stop(true, true).slideToggle();
});


$(document).ready(function() {
    // Function to update star icons based on the active state
    // function updateStars(value) {
    //     $('.rating .star').each(function() {
    //         var starValue = $(this).data('value');
    //         if (starValue <= value) {
    //             $(this).removeClass('bx-star').addClass('bxs-star');
    //         } else {
    //             $(this).removeClass('bxs-star').addClass('bx-star');
    //         }
    //     });
    // }

    // Set up hover effect
    $('.rating .star').on('mouseover', function() {
        var value = $(this).data('value');
        updateStars(value);
    });

    // Remove hover effect
    $('.rating .star').on('mouseout', function() {
        var value = $('input[name="rating"]').val();
        updateStars(value);
    });

    // Handle click event
    $('.rating .star').on('click', function() {
        var value = $(this).data('value');
        $('input[name="rating"]').val(value);
        updateStars(value);
    });
});



$(document).ready(function() {
    $('[data-fancybox="gallery"]').fancybox({
        loop: true,
        transitionEffect: "slide",
        width: 800,  // Set max width for the lightbox view
        height: 600, // Set max height for the lightbox view
        fitToView: true, // Ensures images fit within the viewport
        buttons: [
            "zoom",
            "share",
            "slideShow",
            "fullScreen",
            "download",
            "thumbs",
            "close"
        ]
    });
});

$(document).ready(function () {
    $('#reviewForm').on('submit', function (e) {
        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            url: "{{ route('business_review.save') }}",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                console.log(data);
                if (data.success) {
                    toastr.success(data.success);
                    $('#reviews-list').append(data.html);
                    $('#reviewForm')[0].reset();
                } else if (data.error) {
                    toastr.error(data.error);
                }
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error:', status, error);
                toastr.error('An error occurred. Please try again later.');
            }
        });
    });
});


document.addEventListener('DOMContentLoaded', function () {
    const fileInput = document.getElementById('upload');
    const previewContainer = document.getElementById('file-preview');
    let filesArray = [];

    // Handle file input change
    fileInput.addEventListener('change', function () {
        filesArray = Array.from(fileInput.files);

        filesArray.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function (e) {
                const fileType = file.type.split('/')[0];
                const fileElement = document.createElement('div');
                fileElement.classList.add('file-preview-item');
                fileElement.dataset.index = index;

                const removeIcon = `<i class="fa fa-times" aria-hidden="true" onclick="remove_file(${index})"></i>`;

                if (fileType === 'image') {
                    fileElement.innerHTML = `
                        <div class="file-preview">
                            <img src="${e.target.result}" alt="File Preview" style="max-width: 100px; max-height: 100px;">
                            ${removeIcon}
                        </div>
                    `;
                } else if (fileType === 'video') {
                    fileElement.innerHTML = `
                        <div class="file-preview">
                            <video src="${e.target.result}" controls style="max-width: 100px; max-height: 100px;"></video>
                            ${removeIcon}
                        </div>
                    `;
                }

                previewContainer.appendChild(fileElement);
            };
            reader.readAsDataURL(file);
        });
    });

    window.remove_file = function (index) {
        filesArray.splice(index, 1);
        fileInput.files = new FileListItems(filesArray);
        document.querySelector(`[data-index="${index}"]`).remove();
    };
});

// Helper function to create a FileList object from an array of files
function FileListItems(files) {
    const dataTransfer = new DataTransfer();
    files.forEach(file => dataTransfer.items.add(file));
    return dataTransfer.files;
}


function showDropdown(id) {
    var dropdown = document.getElementById("dropdown-" + id);
    var isVisible = dropdown.classList.contains("show");

    var allDropdowns = document.querySelectorAll(".dropdown-menu.show");
    allDropdowns.forEach(function(menu) {
        if (menu !== dropdown) {
            menu.classList.remove("show");
        }
    });

    if (isVisible) {
        dropdown.classList.remove("show");
    } else {
        dropdown.classList.add("show");
    }
}

document.addEventListener('click', function(event) {
    var dropdowns = document.querySelectorAll(".dropdown-menu");
    dropdowns.forEach(function(menu) {
        if (!menu.contains(event.target) && !event.target.closest(".btn-group")) {
            menu.classList.remove("show");
        }
    });
});


$(document).ready(function() {
    function updateStars(modalId, value) {
        $(`#${modalId} .rating .star`).each(function() {
            var starValue = $(this).data('value');
            if (starValue <= value) {
                $(this).removeClass('bx-star').addClass('bxs-star');
            } else {
                $(this).removeClass('bxs-star').addClass('bx-star');
            }
        });
    }

$(document).on('mouseover', '.rating .star', function() {
    var modalId = $(this).closest('.modal').attr('id');
    var value = $(this).data('value');
    updateStars(modalId, value);
});

$(document).on('mouseout', '.rating .star', function() {
    var modalId = $(this).closest('.modal').attr('id');
    var value = $(`#${modalId} input[name="rating"]`).val();
    updateStars(modalId, value);
});

$(document).on('click', '.rating .star', function() {
    var modalId = $(this).closest('.modal').attr('id');
    var value = $(this).data('value');
    $(`#${modalId} input[name="rating"]`).val(value);
    updateStars(modalId, value);
});

$(document).on('shown.bs.modal', '.modal', function() {
        var modalId = $(this).attr('id');
        var value = $(`#${modalId} input[name="rating"]`).val();
        updateStars(modalId, value);
    });
});



function submitEditReview(event, reviewId) {
    event.preventDefault();

    var form = document.getElementById('updateReviewForm-' + reviewId);
    var formData = new FormData(form);

    $.ajax({
        url: "{{ route('business_review.update', ['id' => 'REVIEW_ID']) }}".replace('REVIEW_ID', reviewId),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            console.log(data);
            if (data.success) {
                toastr.success(data.message);
				$('#reviews-list').html(data.html);
				$('#reviewForm')[0].reset();
            } else if (data.error) {
                toastr.error(data.message); 
            } else {
                toastr.error('Unknown response format'); 
            }
        },
        error: function (xhr, status, error) {
            console.error('Error:', error);
            toastr.error('An error occurred.');
        }
    });
}



function deleteComment(reviewId) {
     Swal.fire({
       title: 'Delete',
       text: 'Are you sure you want to delete this review?',
       icon: 'warning',
       showCancelButton: true,
       confirmButtonColor: '#fcd152',
       cancelButtonColor: '#1a202e',
       confirmButtonText: 'Yes, Delete!'
     }).then((result) => {
       if (result.isConfirmed) {
         var csrfToken = $('meta[name="csrf-token"]').attr('content');
   
         $.ajax({
           type: 'DELETE',
           url: '/delete-review/' + reviewId,
           headers: {
             'X-CSRF-TOKEN': csrfToken
           },
           success: function(response) {
             if (response.success) {
               toastr.success(response.success);
               location.reload();
             } else {
               location.reload();
             }
           },
           error: function() {
             Swal.fire({
               title: 'Error',
               text: 'Error deleting review. Please try again.',
               icon: 'error'
             });
           }
         });
       }
     });
   }

   function removeFile(index, reviewId, fileName) {
		fetch('{{ route('reviews.deleteFile') }}', {
			method: 'POST',
			headers: {
				'X-CSRF-TOKEN': '{{ csrf_token() }}',
				'Content-Type': 'application/json'
			},
			body: JSON.stringify({ id: reviewId, file: fileName })
		})
		.then(response => response.json())
		.then(data => {
			if (data.success) {
				toastr.success(data.success);
				document.getElementById('file-preview-' + index).remove();
			}
		});
	}



   function showAlertForSave() {
        Swal.fire({
            // title: "Are you sure?",
            text: "You have to login first to review on this post.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Go to login"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = site_url + "/login";
            }
        });

    }
	$(document).ready(function() {
		$('.send_invitation').click(function() {
			var business_id = $(this).attr('business_id');
			var business_url = $(this).attr('business_url');
			var user_id = $(this).attr('user_id');
			var from_id = $(this).attr('from_id');
			var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
			$.ajax({
				url: "{{ route('business_page.invite') }}",
				type: 'POST',
				headers: {
					'X-CSRF-TOKEN': csrfToken
				},
				data: {
					business_id: business_id,
					business_url: business_url,
					user_id: user_id,
					from_id: from_id,
				},
				success: function(response) {
					console.log(response);
					if (response.status	==="success") {
						toastr.success(response.message);
					}

				},
				error: function(xhr, status, error) {

				}
			});
		});
	});

	function showAlertForLogin() {
        Swal.fire({
            text: "To like this post you have to log in first.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Go to login"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = site_url + "/login";
            }
        });

    }


$(function () {
  var galleryThumbs = new Swiper(".gallery-thumbs", {
    centeredSlides: true,
    centeredSlidesBounds: true, 
    direction: "horizontal",
    spaceBetween: 10,
    slidesPerView: 4,
    freeMode: false,
    watchSlidesVisibility: true,
    watchSlidesProgress: true,
    watchOverflow: true,
    breakpoints: {
      480: {
        direction: "vertical",
        slidesPerView: 4
      },
       768: {
        direction: "horizontal",
        slidesPerView: 4
      },
       992: {
        direction: "vertical",
        slidesPerView: 4
      }
    }
  });
  var galleryTop = new Swiper(".gallery-top", {
    direction: "horizontal",
    spaceBetween: 10,
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev"
    },
    a11y: {
      prevSlideMessage: "Previous slide",
      nextSlideMessage: "Next slide",
    },
    keyboard: {
      enabled: true,
    },
    thumbs: {
      swiper: galleryThumbs
    }
  });
  galleryTop.on("slideChangeTransitionStart", function () {
    galleryThumbs.slideTo(galleryTop.activeIndex);
  });
  galleryThumbs.on("transitionStart", function () {
    galleryTop.slideTo(galleryThumbs.activeIndex);
  });
});



</script>

@endsection