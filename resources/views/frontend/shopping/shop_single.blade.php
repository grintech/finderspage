<?php
use App\Models\Admin\HomeSettings;
use App\Models\Admin\Testimonials;
use App\Models\UserAuth;
use App\Models\Blogs;
use App\Models\Setting;
use App\Models\Admin\AdminAuth; 


$setting_review_option = Setting::get_setting('reviews',$blog->user_id);
// dd($setting_review_option);
$user_all_data = UserAuth::getUser($blog->user_id);

$setting_like_option = Setting::get_setting('likes',$blog->user_id);

$testimonials = Testimonials::where('status', 1)->get();
$neimg = trim($blog->image1, '[""]');
$img  = explode('","', $neimg);


$user_id = $blog->user_id;
$userSlug = UserAuth::getUserSlug($user_id);
$slug = request()->query('slug');

if ($slug) {
    // dd($slug);
    $blogValue = Blogs::where('slug', $slug)->first();
    // dd($blogValue);
    if (!empty($blogValue)) {
        if ($blogValue->shares === null) {
            $blogValue->shares = 1;
        } else {
            $blogValue->shares += 1;
        }
        $blogValue->save();
    }
}

if ($blog->slug) {
    $blogShares = Blogs::where('slug', $blog->slug)
        ->where('user_id', UserAuth::getLoginId())
        ->first();
}
?>

<style>
html {
  scroll-behavior: smooth;
}
    /* Custom styles for the slider and thumb navigation */
.slider {width: 80%;margin: 0 auto;}
.slider img {width: 100%;height: auto;}
.thumbs {display: flex;justify-content: center;margin-top: 20px;}
.thumbs img {width: 80px;height: 60px;margin: 0 5px;cursor: pointer;}
.slick-current img {border: 2px solid #007bff;}
/* Styles for the image container and magnifier */
.image-container {position: relative;width: 100%;}
.magnifier {display: none;position: absolute;border: 2px solid #000;border-radius: 50%;cursor: crosshair;pointer-events: none;background-size: 400% 400%;}
ul.job-overview-new {justify-content: space-between;}
ul.job-overview-new li a i {line-height: 35px;}
a.Tiktok {padding: 8px 12px !important;}
#myTab li button {font-weight: 500;font-size: 14px;}
.product-detalis {margin-bottom: 50px;}
.checkrepo {display: flex;}
label.repo-label {margin: 12px;font-size: 14px;}
a.report-btn i {background-color: #c69834;color: #fff;font-size: 15px;padding: 10px;border-radius: 35px;}
/* a.report-btn {margin-top: -55px;position: relative;left: 17px;} */

.review_section .modal-header{border:0; position: relative;}
.review_section .modal-header h5{font-weight: 700;font-size: 17px;}
.review_section .btn-close{position: absolute;top: -10px;right: -10px; box-shadow: none;}
.review_section input.form-control{border-radius: 5px;border:1px solid #ced4da;}
.review_section label{font-weight: 600; font-size: 14px;}

.drop-zone {max-width: 100%;height: 200px;padding: 10px;display: flex;align-items: center;justify-content: center;text-align: center;font-weight: 500;font-size: 36px;cursor: pointer;color: #212121;border: 2px dashed #ced4da;border-radius: 5px;}
.drop-zone--over {border-style: solid;}
.drop-zone__input {display: none;}
.drop-zone__thumb {width: 100%;height: 100%;border-radius: 10px;overflow: hidden;background-color: #cccccc;background-size: cover;position: relative;}
.drop-zone__thumb::after {content: attr(data-label);position: absolute;bottom: 0;left: 0;width: 100%;padding: 5px 0;color: #ffffff;background: rgba(0, 0, 0, 0.75);font-size: 14px;text-align: center;}
.comments-area h6{text-transform: capitalize; margin-bottom: 10px!important; font-weight: 600;}
.comments-area .reviews{margin-bottom: 10px;}
.copy-button{background: rgb(170, 137, 65);border: none;outline: none;border-radius: 5px;cursor: pointer;padding: 2px;
    background: linear-gradient(90deg, rgba(170, 137, 65, 1) 0%, rgba(205, 156, 49, 1) 13%, rgba(154, 128, 73, 1) 35%, rgba(246, 204, 78, 1) 51%, rgba(181, 147, 56, 1) 75%, rgba(163, 136, 68, 1) 100%);}

.description-with-tabing  .tab-content .rev_img video{
    width:150px;
    margin: 15px 0;
    /* border: 2px solid #dc7228; */
}
.description-with-tabing  .tab-content .rev_img img{
    width:150px;
    margin: 15px 0;
}

.report_review_modal input[type='checkbox']{
    width: 20px !important;
    height: 20px !important;
}
.text-orange{
    color: #dc7228 !important;
}
.report_review_modal a.text-orange:hover{
    color: #dc7228 !important;
}
i.fa-regular.fa-bookmark::before {
        font-size: 13px !important;
    }
@media only screen and (max-width: 767px) {
    ul.job-overview-new {display: block !important;}
    section#shoping-single-page .thumbs {margin: -70px auto 0 !important;}
    a.report-btn {left: 115px;}
    .full-description .description-with-tabing button#profile-tab {padding: 8px !important;}
    .job-post-apply a.apply {margin-right: 0px !important;}
}

@media only screen and (min-width:768px) and (max-width: 991px) {
    section#shoping-single-page .thumbs {margin: -70px auto 0 !important;}
    a.report-btn {left: -30px;}
    .job-post-apply {justify-content: center;}
}

.job-post-apply a.apply {margin-right: 0px !important;}

/* div#social-links ul li {
padding: 12px 15px 0px 0px !important;
}*/

/*@media only screen and (min-width: 767px) {
.job-post-apply a.apply{
margin-right: 0px;
}
}*/
/* div#social-links ul {
padding: 0;
}

li.shareComponent {
left: 0 !important;
}

div#social-links ul li {
position: relative;
display: inline-flex;
justify-content: center;
padding: 12px 30px 12px 0px;
}*/

.disabled {pointer-events: none;opacity: 0.5;}
.view_counts{z-index: 1;position: absolute;bottom: -28px;}
.product-detalis h3{font-size: 1.5rem;}
.rate label {font-size: 35px!important;margin: 0 10px 0 10px!important;color: #ccc;cursor: pointer;}
sapn.rev_img img {width: 70px;height: auto;}
.single-product-type ul li {/*display: flex;*/justify-content: left;align-items: center;gap: 13px; font-size: 14px;}
div#starRating i {color: #ba923a;}
.single-product-type ul {padding-left: 10px;height: auto;/*    overflow-y: scroll;*/}
.review_rating_box label {margin-left: 0px !important;margin-right: 0px !important;}
.review_rating_box {text-align: left !important;}
.review_rating_box i{font-size: 20px;margin-top: 0px;}
.review_section input.form-control {height: 35px !important;font-size: 15px;}
.rate .checked {color: #af8b3f !important;}
textarea.form-control {height: 100px;}
.dots-menu a {border: none;}
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
.comments-area {
    width: 100%;
    padding-left: 60px;
}
.likes-container{flex-direction: row;}

.likes-count {
    font-size: 12px;
}
.likes-info b {
    font-size: 15px !important;
}
.likes-info .likes-preview {
    font-size: 15px !important;
}
.feature-box2 a span {
    color: #a54db7 !important;
}
.feature-box2 a:hover span {
    color: #a54db7 !important;
}
#related-product li i {
  font-size: 1rem !important;
}
</style>

@extends('layouts.frontlayout')
@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<section id="shoping-single-page">
    <span>
        @include('admin.partials.flash_messages')
    </span>
    <div class="container mb-5">
        <div class="row">
            <div class="col-lg-12 prev-next-arrows">
                <div class="left-arrow">

                    <a href="@if($nextPostId != null){{route('shopping_post_single',$nextPostId)}} @else # @endif" class="{{ $nextPostId == null ? 'disabled' : '' }}"><i class="bi bi-arrow-left"></i> <span>Prev</span></a>

                </div>
                <div class="right-arrow1">

                    <a href="@if($previousPostId != null){{route('shopping_post_single',$previousPostId)}} @else # @endif" class="{{ $previousPostId == null ? 'disabled' : '' }}"><span>Next</span> <i class="bi bi-arrow-right"></i></a>

                </div>
            </div>
        </div>
        <div class="row pt-3">
            <div class="col-lg-8 col-md-8 mb-5 mb-lg-0">
                <div class="shoping-product-slider position-relative">
                    @if(Setting::get_setting("no_of_views", $blog->user_id) == 1 || $blog->user_id == UserAuth::getLoginId())
                     <div class="view_counts">
                        <strong class="zodiac_img"><img src="{{ asset('zodiac_image/eye.png') }}" alt="eye.png"></strong>
                        <strong> {{$viewsCount}}</strong>
                     </div>
                    @endif
                    <div class="slider">
                        <?php
                        if (is_array($img)) {
                            foreach ($img as $keyPostImages => $valuePostImages) {
                        ?>
                                <div class="image-container">
                                    
                                    <a href="{{asset('images_blog_img')}}/{{$valuePostImages}}" data-lightbox="carousel">
                                        <img src="{{asset('images_blog_img')}}/{{$valuePostImages}}" alt="{{ $blog->title }}">
                                        <!-- <div class="magnifier"></div> -->
                                    </a>
                                </div>
                        <?php
                            }
                        }
                        ?>
                        @if($blog->post_video)
                        <div class="image-container">
                            <a href="{{asset('images_blog_img')}}/{{$valuePostImages}}" data-lightbox="carousel">
                                <video width="320" height="90" controls class="d-block w-100">
                                    <source src="{{asset('images_blog_video')}}/{{$blog->post_video}}" type="video/mp4">
                                </video>
                                <!-- <div class="magnifier"></div> -->
                            </a>
                        </div>

                        @endif
                    </div>

                    <div class="thumbs">
                        <?php
                        if (is_array($img)) {
                            foreach ($img as $keyPostImages => $valuePostImages) {
                        ?>
                        <div><img src="{{asset('images_blog_img')}}/{{$valuePostImages}}" alt="{{ $blog->title }}"></div>
                        <?php
                            }
                        }
                           ?>
                    </div>


                    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" style="display:none;">

                        <div class="carousel-inner">

                            <?php
                            if (is_array($img)) {
                                foreach ($img as $keyPostImages => $valuePostImages) {
                                    if ($keyPostImages == 0) {
                                        echo '<div class="carousel-item active">';
                                    } else {
                                        echo '<div class="carousel-item">';
                                    }
                            ?>
                                    <div mag-thumb="inner-inline" mag-flow="inline">
                                        <img src="img/canyon/500x300.jpg" alt="canyon" style="width: 400px; max-width:100%;" />
                                    </div>
                                    <div mag-zoom="inner-inline">
                                        <img src="img/canyon/2000x1200.jpg" alt="canyon" />
                                    </div>
                                    <img style="height: 600px;" src="{{asset('images_blog_img')}}/{{$valuePostImages}}" alt="{{ $blog->title }}" class="d-block w-100" onerror="this.onerror=null; this.src='https://placehold.jp/000000/ffffff/400x400.png?text={{ $blog->title }}'">
                        </div>
                    <?php
                                }
                            } else {
                    ?>
                    <div class="carousel-item active">
                        <img src="{{asset('images_blog_img')}}/{{$blog->image1}}" alt="Los Angeles" class="d-block w-100" onerror="this.onerror=null; this.src='https://placehold.jp/000000/ffffff/400x400.png?text={{ $blog->title }}'">
                    </div>
                <?php
                            }
                ?>

                @if($blog->post_video)
                <div class="carousel-item">
                    <video width="320" height="90" controls class="d-block w-100">
                        <source src="{{asset('images_blog_video')}}/{{$blog->post_video}}" type="video/mp4">
                    </video>
                </div>
                @endif
                    </div>

                    <!-- Left and right controls/icons -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>

                    <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4">
            <div class="shoping-single-product bg-white p-4">
                <div class="pro_categ" style="padding: 0px 0px;">
                    <a href="">
                        <h1>{{$blog->title}}</h1>
                    </a>
                </div>
                @if ($blog->sub_category == 1656)
                    <div class="prouct-selling-price">
                        <del style="font-size: 13px;">${{$blog->product_price}}</del>
                        <span style="font-size: 15px;">${{$blog->product_sale_price}} @if(isset($blog->crypto_currency) && $blog->crypto_currency == 1) <span class="shipping_text">(Accepted Crypto) </span> @endif</span>
                    </div>
                @else
                    <div class="prouct-selling-price">
                        <del style="font-size: 13px;">${{$blog->product_price}}</del>
                        <span style="font-size: 15px;">${{$blog->product_sale_price}} @if(isset($blog->shipping) && $blog->shipping == 'included') <span class="shipping_text">(Shipping included) </span> @endif</span>
                    </div>
                @endif


                @if ($blog->sub_category == 1656)
                <div class="pro_short_description">
                    <ul class="list-unstyled">
                        @if(isset($blog->vehicle_vin))
                        <li><span>VIN - </span>{{$blog->vehicle_vin}}</li>
                        @endif
                        @if(isset($blog->vehicle_model))
                        <li><span>Vehicle model - </span>{{$blog->vehicle_model}}</li>
                        @endif
                        @if(isset($blog->vehicle_odometer))
                        <li><span>Vehicle odometer - </span>{{$blog->vehicle_odometer}}</li>
                        @endif
                        @if(isset($blog->odometer_break) && $blog->odometer_break == 1)
                        <li>Odometer broken</li>
                        @endif
                        @if(isset($blog->odometer_rolled_over) && $blog->odometer_rolled_over == 1)
                        <li>Odometer rolled over</li>
                        @endif
                        @if(isset($blog->vehicle_cylinders))
                        <li><span>Cylinders - </span>{{$blog->vehicle_cylinders}}</li>
                        @endif
                        @if(isset($blog->vehicle_drive))
                        <li><span>Drive - </span>{{$blog->vehicle_drive}}</li>
                        @endif
                        @if(isset($blog->vehicle_fuel))
                        <li><span>Fuel Type - </span>{{$blog->vehicle_fuel}}</li>
                        @endif
                        @if(isset($blog->vehicle_paint_color))
                        <li><span>Paint color - </span>{{$blog->vehicle_paint_color}}</li>
                        @endif
                        @if(isset($blog->vehicle_transmission))
                        <li><span>Transmission - </span>{{$blog->vehicle_transmission}}</li>
                        @endif
                        @if(isset($blog->vehicle_type))
                        <li><span>Type - </span>{{$blog->vehicle_type}}</li>
                        @endif
                        @if(isset($blog->vehicle_model_year))
                        <li><span>Model year - </span>{{$blog->vehicle_model_year}}</li>
                        @endif
                        @if(isset($blog->vehicle_condition))
                        <li><span>Condition - </span>{{$blog->vehicle_condition}}</li>
                        @endif
                        @if(isset($blog->delivery_available) && $blog->delivery_available == 1)
                        <li><i class="fas fa-check-square"></i>Delivery available</li>
                        @endif
                    </ul>
                </div>
                @else
                <div class="pro_short_description">
                    <ul class="list-unstyled">
                        @if(isset($blog->product_condition) && $blog->product_condition != '')
                        <li><i class="fas fa-check-square"></i>{{$blog->product_condition}}</li>
                        @endif
                        @if(isset($blog->delivery_option) && $blog->delivery_option == "available")
                        <li><i class="fas fa-check-square"></i>Delivery available</li>
                        @endif
                        @if(isset($blog->pickup) && $blog->pickup == "available")
                        <li><i class="fas fa-check-square"></i>Pickup option</li>
                        @endif
                        @if(isset($blog->bid) && $blog->bid == "allow")
                        <li><i class="fas fa-check-square"></i>Allow Offers/bids</li>
                        @endif
                        @if(isset($blog->buy_at_face_value) && $blog->buy_at_face_value == "allow")
                        <li><i class="fas fa-check-square"></i>Buy at Face Value</li>
                        @endif
                    </ul>
                </div>
                @endif

                @if(!empty($blog->stock))
                <div class="number">
                    <p>Stock: <span>{{$blog->stock}}</span></p>

                </div>
                @endif

                @if(!empty($blog->product_size))
                <div class="number">
                    <p>Size Available: <span>{{$blog->product_size}}</span></p>

                </div>
                @endif

                @if(!empty($blog->type_of_animal))
                <div class="number">
                    <p>Type of animal: <span>{{$blog->type_of_animal}}</span></p>

                </div>
                @endif

                @if(!empty($blog->pet_name))
                <div class="number">
                    <p>Pet name: <span>{{$blog->pet_name}}</span></p>

                </div>
                @endif

                 @if(!empty($blog->breed))
                <div class="number">
                    <p>Breed: <span>{{$blog->breed}}</span></p>

                </div>
                @endif 

                @if(!empty($blog->pet_color))
                <div class="number">
                    <p>Color: <span>{{$blog->pet_color}}</span></p>

                </div>
                @endif

                @if(!empty($blog->pet_age))
                <div class="number">
                    <p>Pet age: <span>{{$blog->pet_age}}</span></p>

                </div>
                @endif

                @if(!empty($blog->pet_gender))
                <div class="number">
                    <p>Pet gender: <span>{{$blog->pet_gender}}</span></p>

                </div>
                @endif

                @if(!empty($blog->pet_size))
                <div class="number">
                    <p>Pet size: <span>{{$blog->pet_size}}</span></p>

                </div>
                @endif 

                @if(!empty($blog->coat))
                <div class="number">
                    <p>Pet gender: <span>{{$blog->coat}}</span></p>

                </div>
                @endif 

                @if(!empty($blog->adoption_fee))
                <div class="number">
                    <p>Adoption fee: <span>{{$blog->adoption_fee}}</span></p>

                </div>
                @endif

                @if(!empty($blog->health))
                <div class="number">
                    <p>Health: <span>{{$blog->health}}</span></p>

                </div>
                @endif

                @if(!empty($blog->house_trained))
                <div class="number">
                    <p>House trained: <span>{{$blog->house_trained}}</span></p>

                </div>
                @endif

                <!-- <div class="number">
                    <p>Quantity:</p>
                    <span class="minus">-</span>
                    <input type="text" value="1" />
                    <span class="plus">+</span>
                </div> -->

                {{-- @if ($BlogLikes->isNotEmpty() && UserAuth::isLogin()) 
                    <div class="col-12 single-top-apply">
                        <div class="mt-2 d-flex justify-content-start">
                            @if ($blog->user_id == UserAuth::getLoginId())
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
                                        {{-- @if ($blog->user_id == UserAuth::getLoginId())
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
                                @if ($blog->user_id == UserAuth::getLoginId())
                                    <button type="button" class="like-button" id="toggleLikes" data-user-id="{{ $userId }}" data-blog-id="{{ $like->blog_id }}" data-blog-user-id="{{ $blog->user_id }}" data-type="Shopping" data-cate-id="6" data-url={{ route('shopping_post_single', $blog->slug) }}>
                                @else
                                    <button type="button" class="like-button" id="toggleLikes" data-user-id="{{ UserAuth::getLoginId() }}" data-blog-id="{{ $blog->id }}" data-blog-user-id="{{ $blog->user_id }}" data-type="Shopping" data-cate-id="6"  data-url={{ route('shopping_post_single', $blog->slug) }} style="padding: 6px 8px !important; width: auto !important; margin: 0 !important;">
                                @endif
                                        @if ($userLiked && $likedBy[$userId] == 1)
                                            <img src="{{ asset('images/heart-icon.png') }}" id="1" class="rxn-emoji" alt="emoji-icon" style="width: 23px; height: 23px;">
                                        @elseif ($userLiked && $likedBy[$userId] == 2)
                                            <img src="{{ asset('images/thumb-icon.png') }}" id="2" class="rxn-emoji" alt="emoji-icon" style="width: 23px; height: 23px;">
                                        @else
                                            <i class="fa-regular fa-thumbs-up emoji"></i>
                                        @endif

                                        @if ($blog->user_id == UserAuth::getLoginId() || $setting_like_option == "1")
                                            <span class="likes-count">{{ $likes }}</span>
                                        @endif
                                    </button>
                                    <div class="reactions-emojis mt-1" style="display: none;">
                                        <img src="{{ asset('images/heart-icon.png') }}" class="heart-icon" data-id="1" alt="Heart Icon">
                                        <img src="{{ asset('images/thumb-icon.png') }}" class="thumb-icon" data-id="2" alt="Thumb Icon">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    

                @elseif ($blog->user_id == UserAuth::getLoginId())
                    <div class="col-12 single-top-apply">
                        <div class="mt-2 d-flex justify-content-start">
                            @if(UserAuth::isLogin())
                                <div class="likes-container">
                                    <div class="likes-info">
                                        <b>Likes: </b>
                                        <span class="likes-preview">no likes</span>
                                    </div>
                                    <div class="">
                                        <button type="button" class="like-button" id="toggleLikes" data-user-id="{{ UserAuth::getLoginId() }}" data-blog-id="{{ $blog->id }}" data-blog-user-id="{{ $blog->user_id }}" data-type="Shopping" data-cate-id="6" data-url={{ route('shopping_post_single', $blog->slug) }}>
                                            <i class="fa-regular fa-thumbs-up emoji"></i>
                                            <span class="likes-count">0</span>
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
                        </div>
                    </div>
                @else 
                    <div class="col-12 single-top-apply">
                        <div class="mt-2 d-flex justify-content-start">
                            @if(UserAuth::isLogin())
                                <div class="likes-container">
                                    <div class="">
                                        <button type="button" class="like-button" id="toggleLikes" data-user-id="{{ UserAuth::getLoginId() }}" data-blog-id="{{ $blog->id }}" data-blog-user-id="{{ $blog->user_id }}" data-type="Shopping" data-cate-id="6" data-url={{ route('shopping_post_single', $blog->slug) }}>
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
                        </div>
                    </div>
                @endif
                
                <!-- Likes Modal -->
                <div id="showLikesModal" class="showLikes-modal" style="display: none;">
                    <div class="modal-content">
                        <span class="close" onclick="closeShowLikes()">&times;</span>
                        <h2 class="text-center">Likes</h2>
                        <div class="showLikes-list px-1">

                        </div>
                    </div>
                </div> --}}


                @if(UserAuth::isLogin())
                    <a class="report-btn" href="#" data-bs-toggle="modal" data-bs-target="#exampleModal1" data-toggle="tooltip" data-placement="top" title="Report this product."><i class="fa-regular fa-flag text-dark"></i></a>
                @else
                    <a href="{{route('auth.signupuser')}}" class="report-btn" data-toggle="tooltip" data-placement="top" title="Report this product."><i class="fa-regular fa-flag text-dark"></i></a>
                @endif


                <div class="button-frame d-flex align-items-center flex-wrap">

                    <div class="single-job-apply d-flex justify-content-start flex-wrap gap-2">
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
                            @if ($blog->user_id == UserAuth::getLoginId())
                            <button type="button" class="like-button" id="toggleLikes" data-user-id="{{ $userId }}" data-blog-id="{{ $like->blog_id }}" data-blog-user-id="{{ $blog->user_id }}" data-type="Shopping" data-cate-id="6" data-url={{ route('shopping_post_single', $blog->slug) }}>
                            @else
                            <button type="button" class="like-button" id="toggleLikes" data-user-id="{{ UserAuth::getLoginId() }}" data-blog-id="{{ $blog->id }}" data-blog-user-id="{{ $blog->user_id }}" data-type="Shopping" data-cate-id="6" data-url={{ route('shopping_post_single', $blog->slug) }} style="padding: 6px 8px !important; width: auto !important; margin: 0 !important;">
                            @endif
                                @if ($userLiked && $likedBy[$userId] == 1)
                                    <img src="{{ asset('images/heart-icon.png') }}" id="1" class="rxn-emoji" alt="emoji-icon" style="width: 23px; height: 23px;">
                                @elseif ($userLiked && $likedBy[$userId] == 2)
                                    <img src="{{ asset('images/thumb-icon.png') }}" id="2" class="rxn-emoji" alt="emoji-icon" style="width: 23px; height: 23px;">
                                @else
                                    <i class="fa-regular fa-thumbs-up emoji"></i>
                                @endif
                            </button>
                            
                            @if ($blog->user_id == UserAuth::getLoginId())
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
                                    <button type="button" class="like-button" id="toggleLikes" data-user-id="{{ UserAuth::getLoginId() }}" data-blog-id="{{ $blog->id }}" data-blog-user-id="{{ $blog->user_id }}" data-type="Shopping" data-cate-id="6" data-url={{ route('shopping_post_single', $blog->slug) }}>
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

                        <div class="d-flex align-items-center">
                            <a href="#description-frame" class="overview">
                                <button class="btn create-post-button">
                                    <i class="fa-regular fa-comment"></i>
                                </button>
                            </a>
                        </div>
                    
                        @php 
                            $setting_sharebtn = Setting::get_setting('share_btn', $blog->user_id);
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
                            <a data-postid="{{ $blog->id }}" data-type="Shopping" data-Userid="{{ UserAuth::getLoginId() }}"
                               class="{{ $existingRecord ? 'unsaved_post_btn' : 'saved_post_btn' }} apply btn create-post-button"
                               href="javascript:void(0);">
                                <i class="{{ $existingRecord ? 'fa-solid' : 'fa-regular' }} fa-bookmark" style="{{ $existingRecord ? 'color: #131313;' : '#fff;' }}"></i>
                            </a>
                        </div>                            
                        
                    </div>
                            <!--Share Modal Start-->
                            <div class="modal fade share-modal" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-header border-0">
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="copy-text">
                                            <input type="text" class="text" value="{{url('/shopping-post-single')}}/{{$blog->slug}}" id="field_input"/>
                                            <a href="javascript:void(0);" redirect-url="{{url('/chatify')}}/{{UserAuth::getLoginId()}}" copy-url="{{url('/shopping-post-single')}}/{{$blog->slug}}" class="copy_url btn create-post-button ms-2" data-placement="top" data-toggle="tooltip" title="Share">
                                                <i class="fa fa-clone"></i>
                                            </a>
                                        </div>
                                      <hr>
                                        <div class="copy-text">
                                        <input type="text" class="text" value="Share link via email" readonly id="email_input"/>
                                        <a href="mailto:{{$user_all_data->email }}?subject={{$blog->title}}&body=Page link : {{url('/shopping-post-singlet')}}/{{$blog->slug}}" class="btn create-post-button ms-2" data-placement="top" data-toggle="tooltip" title="Email">
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

                            <input type="hidden" id="copy-url-input" value="" class="hidden-input">

                    </div>
                    <div class="button-sell shoping-sell d-flex align-items-center">
                        <span><a target="_blank" href="{{$blog->product_url}}">Buy Now</a></span>
                        <!-- <span><a href="#" class="direct-checkout-btn" data-product-id="{{$blog->id}}">Direct Checkout</a></span> -->
                    </div>
                </div>

                

                <!-- <div class="singel-posted">
                    <ul class="single-list">
                        <li>
                            <h6>Share to:</h6>
                        </li>
                        {!! $shareComponent !!}
                    </ul>
                </div> -->
            </div>
        </div>
    </div>
    </div>
</section>

    <section class="description-frame" id="description-frame">
        <div class="container product-detalis">
            <h3 style="text-align:center;">Product Details</h3>
            <div class="full-description mt-5">
                <div class="description-with-tabing">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Description</button>
                        </li>
                        @if($blog->personal_detail == 'true')
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Seller Information</button>
                        </li>
                        @elseif($blog->personal_detail == 'true' && AdminAuth::isLogin())
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Seller Information</button>
                        </li>
                        @else 
                            @if(UserAuth::isLogin())
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Seller Information</button>
                            </li>
                            @endif
                        @endif



                        @if(UserAuth::isLogin())
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="Question-tab" data-bs-toggle="tab" data-bs-target="#ask-Question" type="button" role="tab" aria-controls="Question" aria-selected="false">Question
                            </button>
                        </li>
                        @else
                        <li class="nav-item" role="presentation">
                            <a target="blank" href="{{route('auth.signupuser')}}" onclick="showAlertForSave()">
                                <button class="nav-link" id="Question-tab" type="button" aria-controls="Question" aria-selected="false">Question
                                </button>
                            </a>
                        </li>
                        @endif

                        

                        <!-- <li class="nav-item" role="presentation">
                        <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Reviews (0) </button>
                    </li> -->

                    @if(UserAuth::isLogin() && (!isset($setting_review_option) || $setting_review_option == "1"))
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="review-tab" data-bs-toggle="tab" data-bs-target="#review-tab_content" type="button" role="tab" aria-controls="review-tab" aria-selected="false">Reviews
                        </button>
                    </li>
                    @endif
                    
                    </ul>


                    <div class="tab-content" id="myTabContent">
                        <div class="job-detail tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div class="single-product-type pt-3 review-part">
                                <div calss="contentArea">
                                <?php
                                    $processedText = Setting::makeLinksClickable($blog->description);
                                ?>
                                    <p>{!! $processedText !!}</p>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="single-product-type pt-3">

                                <h4>Seller Overview</h4>
                                <?php
                                // echo "<pre>"; print_r($users);die();
                                if ($blog->post_by == 'admin') {
                                    foreach ($admins as $add) {
                                        if ($blog->user_id == $add->id) {
                                            $userName = $add->first_name;
                                            $userimage = $add->image;
                                            $userEmail = $add->email;
                                            $userAddress = $add->address;
                                            $userNumber = '';
                                            $facebook = '';
                                            $twitter = '';
                                            $instagram = '';
                                            $linkedin = '';
                                            $linkedin = '';
                                            $youtube = '';
                                            $whatsapp = '';
                                            $Tiktok = '';
                                            $adminId = $add->id;
                                            echo '<img style="border-radius: 76px" src="' . asset($add->image) . '" alt="">';
                                        }
                                    }
                                } else {
                                    // Assuming $users is an array or collection

                                    foreach ($users as $user) {
                                        if ($blog->user_id == $user->id) {
                                            $userimage = $user->image;
                                            $userslug = $user->slug;
                                            $userName = $user->first_name;
                                            $userEmail = $user->email;
                                            $website = $user->business_website;
                                            $userAddress = $user->address;
                                            $userId = $user->id;
                                            $userNumber = $user->phonenumber;
                                            $facebook = $user->facebook;
                                            $twitter = $user->twitter;
                                            $instagram = $user->instagram;
                                            $linkedin = $user->linkedin;
                                            $linkedin = $user->linkedin;
                                            $youtube = $user->youtube;
                                            $whatsapp = $user->whatsapp;
                                            $Tiktok = $user->Tiktok;

                                            // echo '<img style="border-radius: 76px" src="' . asset('assets/images/profile') . '/' . $user->image . '" alt="">';

                                        }
                                    }
                                }
                                ?>
                                <div class="row">
                                    <div class="col-lg-3 col-3 col-md-6 col-6 singel-post-by" style="border-right: 1px solid #c6c7c8;"><b>Seller Name:</b>
                                        @if(UserAuth::isLogin())
                                            <a target="blank" href="{{route('UserProfileFrontend', $userSlug->slug)}}"> {{$userName}}</a>
                                        @elseif(AdminAuth::isLogin())
                                            <a target="blank" href="{{route('UserProfileFrontend.admin', $userSlug->slug)}}"> {{$userName}}</a>
                                        @else
                                            <a target="blank" href="{{route('auth.signupuser')}}" onclick="showAlertForSave()"> {{$userName}}</a>
                                        @endif


                                    </div>
                                    @if(!empty($blog->email))
                                    <div class="col-lg-3 col-3 col-md-6 col-6 singel-posted" style="border-right: 1px solid #c6c7c8;"><b>Email:</b>&nbsp;&nbsp; <a href="mailto:{{$blog->email}}" target="_blank;">{{$blog->email}}</a>
                                    </div>
                                    @endif
                                    @if(!empty($blog->phone))
                                    <div class="col-lg-3 col-3 col-md-6 col-6 singel-posted" style="border-right: 1px solid #c6c7c8;"><b>Phone No:</b>&nbsp;&nbsp; <a href="tel:{{$blog->phone}}" target="_blank;">{{$blog->phone}}</a>
                                    </div>
                                    @endif
                                    @if(!empty($blog->website))
                                    <div class="col-lg-3 col-3 col-md-6 col-6 singel-posted" style="border-right: 1px solid #c6c7c8;"><b>Website:</b>&nbsp;&nbsp; <a href="tel:{{$blog->website}}" target="_blank;">{{$blog->website}}</a>
                                    </div>
                                    @endif
                                    


                                </div>
                                <div class="Job-right-sidebar bg-white">
                                    <div class="job-overview">
                                        <ul class="job-overview-new">

                                            <div class="col-lg-12 col-12 col-md-12 col-6  mb-md-2 single-top-apply">
                                                <div class="job-post-apply text-center" style="display:block;">
                                                    @if(UserAuth::isLogin())
                                                    <a target="blank" class="apply" href="{{route('UserProfileFrontend', $userSlug->slug)}}"> Profile</a>
                                                    @elseif(AdminAuth::isLogin())
                                                    <a target="blank" class="apply" href="{{route('UserProfileFrontend.admin', $userSlug->slug)}}">Profile</a>
                                                    @else
                                                    <a target="blank" class="apply" href="{{route('auth.signupuser')}}" onclick="showAlertForSave()"> Profile</a>
                                                    @endif


                                                </div>
                                            </div>

                                        </ul>
                                    </div>


                                </div>


                            </div>
                        </div>


                        <div class="tab-pane fade" id="ask-Question" role="tabpanel" aria-labelledby="Question-tab">
                            <div class="single-product-type pt-3">
                                <div class="quest-btn-box">
                                    <button type="button" class="btn create-post-button" data-bs-toggle="modal" data-bs-target="#staticBackdrop_question">
                                        Post a Question
                                    </button>
                                </div>

                                @foreach($shopQuestion as $question)
                                <h5 class="mt-3">Q{{$loop->iteration}}.&nbsp;{{$question->question}}</h5>
                                <p><a href="#" data-bs-toggle="modal" data-bs-target="#answer-modal{{$question->id}}">Answer this question</a></p>


                                <div class="modal fade" id="answer-modal{{$question->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="staticBackdropLabel">Write your answer</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{route('shop.answer.save')}}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="post_id" value="{{$blog->id}}">
                                                    <input type="hidden" name="question_id" value="{{$question->id}}">
                                                    <textarea class="form-control" name="answer" placeholder="Write your answer"></textarea>
                                                    <button type="submit" class="btn create-post-button mt-2" style="float:right;">Post</button>
                                                </form>
                                            </div>
                                            <div class="modal-footer">

                                            </div>
                                        </div>
                                    </div>
                                </div>


                                @foreach($ShopAnswer as $answer)
                                @foreach ($users as $user)
                                @if ($user->id == $answer->user_id)
                                @if($question->id == $answer->question_id)
                                <hr>
                                <ul>
                                    <li>
                                        <div class="img-icon">
                                            <img class="img-fluid rounded-circle" alt="image" height="40" width="40" src="{{asset('assets/images/profile')}}/{{$user->image}}">
                                        </div>
                                        <div class="comments-area">
                                            <h6>{{$user->first_name}}</h6>
                                            <p>{{$answer->answer}} </p>

                                        </div>
                                    </li>
                                </ul>
                                <hr>
                                @endif
                                @endif
                                @endforeach
                                @endforeach
                                @endforeach



                            </div>
                        </div>



                        <div class="tab-pane fade" id="review-tab_content" role="tabpanel" aria-labelledby="review-tab">
                            <div class="single-product-type pt-3">
                                <div class="quest-btn-box">
                                    <button type="button" class="btn create-post-button" data-bs-toggle="modal" data-bs-target="#review-modal">
                                    How's your item?
                                    </button>
                                </div>
                                <div class="modal fade" id="review-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog review_section">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="staticBackdropLabel">Write a Product Review</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="reviewForm" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{$blog->id}}">
                                                    <input type="hidden" name="email" value="{{$userEmail}}">
                                                    <input type="hidden" name="name" value="{{$userName}}">
                                                    <input type="hidden" name="blog_user_id" value="{{$blog->user_id}}">
                                                    <input type="hidden" name="slug" value="{{$blog->slug}}">
                                                    <input type="hidden" name="url" value="{{route('shopping_post_single',$blog->slug)}}">
                                                    <input type="hidden" name="type" value="shopping">
                                                    <div class="row">
                                                        <div class="col-lg-12 mb-2">  
                                                            <label for="title " class="col-form-label">Title your review</label>   
                                                            <input type="text" class="form-control" name="title" value="" placeholder="Enter review title">
                                                        </div>
                                                        <div class="col-lg-12 mb-2">  
                                                            <label for="description " class="col-form-label">Write your review </label>   
                                                            <textarea class="form-control" name="description" placeholder="Write your review"></textarea>
                                                        </div>
                                                        <div class="col-lg-12 mb-2"> 
                                                            <label for="rating" class="col-form-label">How would you rate it?</label> 
                                                            <div class="rate review_rating_box">
                                                                <input type="radio" id="star1" name="rating" value="1">
                                                                <label for="star1"><i class="fas fa-star"></i></label>
                                                                <input type="radio" id="star2" name="rating" value="2">
                                                                <label for="star2"><i class="fas fa-star"></i></label>
                                                                <input type="radio" id="star3" name="rating" value="3">
                                                                <label for="star3"><i class="fas fa-star"></i></label>
                                                                <input type="radio" id="star4" name="rating" value="4">
                                                                <label for="star4"><i class="fas fa-star"></i></label>
                                                                <input type="radio" id="star5" name="rating" value="5">
                                                                <label for="star5"><i class="fas fa-star"></i></label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 mb-2"> 
                                                            <label for="rating " class="col-form-label">Share a Video or Photo</label>  
                                                            <div class="drop-zone">
                                                                <span class="drop-zone__prompt"><i class="fa fa-camera" aria-hidden="true"></i></span>
                                                                <input type="file" name="file" class="drop-zone__input">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- <div class="row mt-4">
                                                        <div class="col-lg-2">     
                                                        <label for="rating " class="col-form-label">Rating:</label>
                                                        </div>
                                                        <div class="col-lg-10">  
                                                            <div class="rate review_rating_box">
                                                                <input type="radio" id="star1" name="rating" value="1">
                                                                <label for="star1"><i class="fas fa-star"></i></label>
                                                                <input type="radio" id="star2" name="rating" value="2">
                                                                <label for="star2"><i class="fas fa-star"></i></label>
                                                                <input type="radio" id="star3" name="rating" value="3">
                                                                <label for="star3"><i class="fas fa-star"></i></label>
                                                                <input type="radio" id="star4" name="rating" value="4">
                                                                <label for="star4"><i class="fas fa-star"></i></label>
                                                                <input type="radio" id="star5" name="rating" value="5">
                                                                <label for="star5"><i class="fas fa-star"></i></label>
                                                            </div>
                                                        </div>
                                                    </div> -->
                                                
                                                    <!-- <div class="row mt-4">
                                                        <div class="col-lg-12">  
                                                            <textarea class="form-control" name="description" placeholder="Write your review"></textarea>
                                                        </div>
                                                    </div> -->

                                                    <!-- <div class="row mt-4">
                                                        <div class="col-lg-12">  
                                                            <input type="file" class="form-control" name="file" >
                                                        </div>
                                                    </div> -->

                                                    <div class="row mt-2">
                                                        <div class="col-lg-12">  
                                                            <button type="submit" class="btn create-post-button mt-2" data-bs-dismiss="modal">Post your Review</button>
                                                        </div>
                                                    </div>
                                                    
                                                </form>
                                            </div>
                                            <div class="modal-footer">

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr>
                                <ul id="review-section">
                                    @foreach($allreview as $review)
                                    <li>
                                        <div class="review-header d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center">
                                                <div class="img-icon">
                                                    @foreach($users as $user)
                                                        @if($user->id == $review->user_id)
                                                        <img class="img-fluid rounded-circle" alt="image" height="40" width="40" src="{{asset('assets/images/profile')}}/{{$user->image}}">
                                                        @endif
                                                    @endforeach
                                                </div>
                                                <div class="ms-3">
                                                    <h6>{{$review->name}}</h6>
                                                    <div class="reviews" id="starRating">
                                                        <?php
                                                            for ($i = 1; $i <= 5; $i++) {
                                                                if ($i <= $review->rating) {
                                                                    // Full star
                                                                    echo '<i class="fas fa-star"></i>';
                                                                } else {
                                                                    // Empty star
                                                                    echo '<i class="far fa-star"></i>';
                                                                }
                                                            }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                @if (UserAuth::getLoginId() != $review->user_id)
                                                <button type="button" class="btn create-post-button" data-bs-toggle="modal" data-bs-target="#staticBackdrop_review{{$review->id}}">Report</button>
                                                @endif

                                                <div class="dots-menu btn-group ms-2">
                                                    @if (UserAuth::getLoginId() == $review->user_id)
                                                    <a data-toggle="dropdown" class="btn btn-primary" onclick="showDropdown({{ $review->id }})"><i class='fas fa-ellipsis-v'></i></a>
                                                    <ul class="dropdown-menu" id="dropdown-{{ $review->id }}">
                                                        <li><a class="btn button_for" data-bs-toggle="modal" href="#editModal{{ $review->id }}"><i class="fa fa-pencil" style="font-size: 13px;"></i></a></li>
                                                        <li><a class="btn btn-danger button_for" onclick="deleteComment({{ $review->id }})"><i class="fa fa-trash-o"></i></a></li>
                                                    </ul>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="comments-area mt-3">
                                            <p><strong>{{$review->title}}</strong></p>
                                            <p>{{$review->description}}</p>
                                            @if(isset($review->file))
                                                @php
                                                    $fileExtension = pathinfo($review->file, PATHINFO_EXTENSION);
                                                    $imageExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                                                    $videoExtensions = ['mp4', 'webm', 'ogg'];
                                                @endphp
                                
                                                @if(in_array($fileExtension, $imageExtensions))
                                                    <span class="rev_img">
                                                        <img class="" src="{{ asset('images_reviews/' . $review->file) }}" alt="">
                                                    </span>
                                                @elseif(in_array($fileExtension, $videoExtensions))
                                                    <span class="rev_img">
                                                        <video class="" controls>
                                                            <source src="{{ asset('images_reviews/' . $review->file) }}" type="video/{{ $fileExtension }}">
                                                            Your browser does not support the video tag.
                                                        </video>
                                                    </span>
                                                @else
                                                    <span class="rev_img">Unsupported file type.</span>
                                                @endif
                                            @endif
                                        </div>
                                
                                        <!-- Modal -->
                                        <div class="modal fade" id="editModal{{ $review->id }}" aria-hidden="true" aria-labelledby="editModalLabel{{ $review->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                              <div class="modal-content">
                                                <div class="modal-header">
                                                  <h5 class="modal-title" id="editModalLabel{{ $review->id }}">Edit this review</h5>
                                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                  <form id="updateReview{{ $review->id }}" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $blog->id }}">
                                                    <input type="hidden" name="email" value="{{ $userEmail }}">
                                                    <input type="hidden" name="name" value="{{ $userName }}">
                                                    <input type="hidden" name="blog_user_id" value="{{ $blog->user_id }}">
                                                    <input type="hidden" name="slug" value="{{ $blog->slug }}">
                                                    <input type="hidden" name="url" value="{{ route('shopping_post_single', $blog->slug) }}">
                                                    <input type="hidden" name="type" value="shopping">
                                                    
                                                    @php
                                                      $rating = isset($review) ? $review->rating : null;
                                                      $title = isset($review) ? $review->title : '';
                                                      $description = isset($review) ? $review->description : '';
                                                      $existingFile = isset($review) ? $review->file : '';
                                                    @endphp
                                          
                                                    <div class="row">
                                                      <div class="col-lg-12 mb-2">
                                                        <label for="title" class="col-form-label">Title your review</label>
                                                        <input type="text" class="form-control" name="title" value="{{ $title }}" placeholder="Enter review title">
                                                      </div>
                                                      <div class="col-lg-12 mb-2">
                                                        <label for="description" class="col-form-label">Write your review</label>
                                                        <textarea class="form-control" name="description" placeholder="Write your review">{{ $description }}</textarea>
                                                      </div>
                                                      <div class="col-lg-12 mb-2">
                                                        <label for="rating" class="col-form-label">How would you rate it?</label>
                                                        <div class="rate review_rating_box">
                                                          @for ($i = 1; $i <= 5; $i++)
                                                            <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" {{ $i == $rating ? 'checked' : '' }}>
                                                            <label for="star{{ $i }}" class="{{ $i <= $rating ? 'checked' : '' }}">
                                                              <i class="fas fa-star"></i>
                                                            </label>
                                                          @endfor
                                                        </div>
                                                      </div>
                                                      <div class="col-lg-12 mb-2">
                                                        <label for="file" class="col-form-label">Share a Video or Photo</label>
                                                        <div class="drop-zone">
                                                          @if (!$existingFile)
                                                            <span class="drop-zone__prompt"><i class="fa fa-camera" aria-hidden="true"></i></span>
                                                          @endif
                                                          <input type="file" name="file" class="drop-zone__input" data-existing-file="{{ asset('images_reviews/' . $existingFile) }}">
                                                          <img id="existing-file-preview" style="display: none;">
                                                          <video id="existing-file-video" style="display: none;" controls></video>
                                                        </div>
                                                      </div>
                                                    </div>
                                          
                                                    <div class="row mt-2">
                                                      <div class="col-lg-12">
                                                        <button type="button" class="btn create-post-button mt-2" onclick="submitEditReview(event, {{ $review->id }})" data-bs-dismiss="modal">Post your Review</button>
                                                      </div>
                                                    </div>
                                                  </form>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                          
                                
                                    </li>
                                    <hr>
                                    @endforeach
                                </ul>
                                
                                <hr>
                            

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

<section id="related-product">
    <div class="container">
        <h3 style="text-align: center;">Related Products<h3>
            <div class="row">
                @foreach($relatedPro as $Rproduct)
                <div class="col-md-4 col-lg-2 col-6">
                    <a href="{{ route('shopping_post_single', $Rproduct->slug) }}">
                        <div class="feature-box2">
                            <div id="demo-new" class="carousel1 slide">
                                <div class="carousel-inner">
                                    <?php
                                    $itemFeaturedImages = trim($Rproduct->image1, '[""]');
                                    $itemFeaturedImage  = explode('","', $itemFeaturedImages);
                                    if (is_array($itemFeaturedImage)) {
                                        foreach ($itemFeaturedImage as $keyitemFeaturedImage => $valueitemFeaturedImage) {
                                            $class = $keyitemFeaturedImage == 0 ? 'active' : 'in-active';
                                            ?>
                                            <div class="carousel-item <?= $class; ?>">
                                                <img src="{{ asset('images_blog_img') }}/{{ $valueitemFeaturedImage }}" alt="Los Angeles" class="d-block w-100" onerror="this.onerror=null; this.src='https://finder.harjassinfotech.org/public/images_blog_img/1688636936.jpg';">
                                            </div>
                                    <?php }
                                    } ?>
                                </div>
                            </div>
                            <h6>{{ $Rproduct->title }}</h6>
                            <div class="price">
                                Price
                                <del style="font-size: 13px;">${{ $Rproduct->product_price }}</del>
                                <span style="font-size: 13px;">${{ $Rproduct->product_sale_price }}</span>
                            </div>
            
                            @php
                                // Fetch all reviews for the current product
                                $totalRating = 0;
                                $reviewsForProduct = $allreview->where('product_id', $Rproduct->id);
                                $totalReviews = count($reviewsForProduct);
                            @endphp
                            
                            @if($totalReviews > 0)
                                @foreach($reviewsForProduct as $review)
                                    @php
                                        $totalRating += $review->rating;
                                    @endphp
                                @endforeach
            
                                @php
                                    // Calculate average rating
                                    $averageRating = $totalRating / $totalReviews;
                                    $fullStars = floor($averageRating);
                                    $halfStar = ($averageRating - $fullStars) >= 0.5 ? 1 : 0;
                                    $emptyStars = 5 - $fullStars - $halfStar;
                                @endphp
            
                                <div class="average-rating">
                                    <ul class="review">
                                        @for ($i = 0; $i < $fullStars; $i++)
                                            <li><i class="bi bi-star-fill"></i></li>
                                        @endfor
            
                                        @if ($halfStar)
                                            <li><i class="bi bi-star-half"></i></li>
                                        @endif
            
                                        @for ($i = 0; $i < $emptyStars; $i++)
                                            <li><i class="bi bi-star"></i></li>
                                        @endfor
                                    </ul>
                                </div>
                            @else
                                <div class="average-rating">
                                    <ul class="review">
                                        @for ($i = 0; $i < 5; $i++)
                                            <li><i class="bi bi-star"></i></li>
                                        @endfor
                                    </ul>
                                </div>
                            @endif
            
                            <a href="{{ $Rproduct->product_url }}" class="btn create-post-button">View Details</a>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
            
        </div>
    </div>

    <!-------model apply job--------->
    <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Why are you reporting this post?</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ">
                    <form class="row" action="{{route('post.report')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="post_id" value="{{$blog->id}}">
                        <input type="hidden" name="type" value="post">


                        <div>

                            <div class="checkrepo">
                                <input class="form-check" name="reason[]" type="checkbox" value="It's spam"><label class="repo-label">It's spam</label>
                            </div>


                            <div class="checkrepo">
                                <input class="form-check" name="reason[]" type="checkbox" value="Nudity or sexual activity"><label class="repo-label">Nudity or sexual activity</label>
                            </div>

                            <div class="checkrepo">
                                <input class="form-check" name="reason[]" type="checkbox" value="Hate speech or symbols"><label class="repo-label">Hate speech or symbols</label>
                            </div>

                            <div class="checkrepo">
                                <input class="form-check" name="reason[]" type="checkbox" value="Violence or dangerous organizations"><label class="repo-label">Violence or dangerous organizations</label>
                            </div>

                            <div class="checkrepo">
                                <input class="form-check" name="reason[]" type="checkbox" value="Sale of illegal or regulated goods"><label class="repo-label">Sale of illegal or regulated goods</label>
                            </div>

                            <div class="checkrepo">
                                <input class="form-check" name="reason[]" type="checkbox" value="Bullying or harassment"><label class="repo-label">Bullying or harassment</label>
                            </div>

                            <div class="checkrepo">
                                <input class="form-check" name="reason[]" type="checkbox" value="Intellectual property violation"><label class="repo-label">Intellectual property violation</label>
                            </div>

                            <div class="checkrepo">
                                <input class="form-check" name="reason[]" type="checkbox" value="Suicide or self-injury"><label class="repo-label">Suicide or self-injury</label>
                            </div>

                            <div class="checkrepo">
                                <input class="form-check" name="reason[]" type="checkbox" value="Eating disorders"><label class="repo-label">Eating disorders</label>
                            </div>

                            <div class="checkrepo">
                                <input class="form-check" name="reason[]" type="checkbox" value="Scam or fraud"><label class="repo-label">Scam or fraud</label>
                            </div>

                            <div class="checkrepo">
                                <input class="form-check" name="reason[]" type="checkbox" value="False information"><label class="repo-label">False information</label>
                            </div>

                            <div class="checkrepo">
                                <input class="form-check" name="reason[]" type="checkbox" value="Account may have been hacked"><label class="repo-label">Account may have been hacked</label>
                            </div>

                            <div class="checkrepo">
                                <input class="form-check" name="reason[]" type="checkbox" value="I just don't like it"><label class="repo-label">I just don't like it</label>
                            </div>
                        </div>


                        <div class="modal-footer">
                            <button type="submit" class="contact-from-button">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>





    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop_question" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Post your question</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('shop.question.save')}}" method="post">
                        @csrf
                        <p>Your question might be answered by sellers, manufacturers, or customers who bought this product. </p>
                        <input type="hidden" name="post_id" value="{{$blog->id}}">
                        <textarea class="form-control" name="question" placeholder="Type your question"></textarea>
                        <button type="submit" class="btn create-post-button mt-2" style="float:right;">Post</button>
                    </form>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <style>
    .slick-prev::before, .slick-next::before {
        font-size: 30px !important;
        color: #ae8408 !important;
    }
    </style>

    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
        // Initialize the slider and thumb navigation
        $(document).ready(function() {

            // Function to get the product IDs from the cart cookie
            function getCartProductIds() {
                const cookieValue = document.cookie.replace(/(?:(?:^|.*;\s*)cart_product_ids\s*=\s*([^;]*).*$)|^.*$/, "$1");
                if (cookieValue) {
                    return cookieValue.split('|');
                }
                return [];
            }

            // Function to set the cart cookie with the updated product IDs
            function setCartProductIds(productIds) {
                document.cookie = `cart_product_ids=${productIds.join('|')}; path=/`;
            }

            // Function to handle the "Add to Cart" button click
            function handleAddToCartClick(event) {
                event.preventDefault();
                const productId = event.target.dataset.productId;
                const cartProductIds = getCartProductIds();

                if (!cartProductIds.includes(productId)) {
                    cartProductIds.push(productId);
                    setCartProductIds(cartProductIds);
                    alert(`Product with ID ${productId} has been added to the cart.`);
                    location.reload();
                } else {
                    alert(`Product with ID ${productId} is already in the cart.`);
                }
            }

            // Attach click event listeners to the "Add to Cart" buttons
            const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');
            addToCartButtons.forEach((button) => {
                button.addEventListener('click', handleAddToCartClick);
            });

            const slider = $('.slider').slick({
                arrows: true,
                dots: false,
                infinite: true,
                slidesToShow: 1,
                slidesToScroll: 1,
                asNavFor: '.thumbs', // Connect slider to thumb navigation
            });

            $('.thumbs').slick({
                arrows: false,
                dots: false,
                slidesToShow: 3,
                slidesToScroll: 1,
                focusOnSelect: true,
                asNavFor: '.slider', // Connect thumb navigation to slider
            });

            // Function to handle the magnification effect
            function handleMagnifier(event) {
                const containerRect = $(this).get(0).getBoundingClientRect();
                const x = event.clientX - containerRect.left;
                const y = event.clientY - containerRect.top;

                $(this).find('.magnifier').css({
                    display: 'block',
                    left: `${x - 50}px`, // Adjust the value to position the magnifier correctly
                    top: `${y - 50}px`, // Adjust the value to position the magnifier correctly
                    backgroundImage: `url('${$(this).find('img').attr('src')}')`,
                    backgroundPosition: `-${x * 3}px -${y * 3}px`, // Adjust the value to control the zoom level
                });
            }

            // Function to hide the magnifier when the mouse leaves the image
            function hideMagnifier() {
                $(this).find('.magnifier').css('display', 'none');
            }

            // Attach event listeners to the image containers
            $('.image-container').on('mousemove', handleMagnifier);
            $('.image-container').on('mouseleave', hideMagnifier);

        });

        $('.copy_url').click(function() {
            var urlToCopy = $(this).attr('copy-url');
            var redirect_url = $(this).attr('redirect-url');
            console.log('URL to copy:', urlToCopy);

            navigator.clipboard.writeText(urlToCopy)
                .then(function() {
                    // Swal.fire({
                    //     title: "URL copied to clipboard!",
                    //     text: urlToCopy,
                    //     icon: "success",
                    //     showConfirmButton: false
                    // });
                    setTimeout(function() {
                        window.location.href = redirect_url;
                    }, 1500);
                })
                .catch(function(err) {
                    console.error('Unable to copy text to clipboard', err);
                });
        });


    $(document).ready(function(){
        $('.rate label').on('click', function(){
            var selectedValue = $(this).prev('input').val();
            $('.rate label').removeClass('checked');
            $(this).addClass('checked').prevAll('label').addClass('checked');
        });

        $('#submitReview').on('click', function(){
            var rating = $('input[name="rating"]:checked').val();
            var description = $('#message-text').val();
            // Here you can perform further actions like submitting the data via AJAX
            console.log("Rating: " + rating);
            console.log("Description: " + description);
        });
    });
    

document.querySelectorAll(".drop-zone__input").forEach((inputElement) => {
  const dropZoneElement = inputElement.closest(".drop-zone");

  dropZoneElement.addEventListener("click", (e) => {
    inputElement.click();
  });

  inputElement.addEventListener("change", (e) => {
    if (inputElement.files.length) {
      updateThumbnail(dropZoneElement, inputElement.files[0]);
    }
  });

  dropZoneElement.addEventListener("dragover", (e) => {
    e.preventDefault();
    dropZoneElement.classList.add("drop-zone--over");
  });

  ["dragleave", "dragend"].forEach((type) => {
    dropZoneElement.addEventListener(type, (e) => {
      dropZoneElement.classList.remove("drop-zone--over");
    });
  });

  dropZoneElement.addEventListener("drop", (e) => {
    e.preventDefault();

    if (e.dataTransfer.files.length) {
      inputElement.files = e.dataTransfer.files;
      updateThumbnail(dropZoneElement, e.dataTransfer.files[0]);
    }

    dropZoneElement.classList.remove("drop-zone--over");
  });

  // Handle existing file preview
  const existingFile = dropZoneElement.querySelector(".drop-zone__input").getAttribute("data-existing-file");
  if (existingFile) {
    fetch(existingFile)
      .then(response => response.blob())
      .then(blob => {
        const file = new File([blob], "existing-file", { type: blob.type });
        updateThumbnail(dropZoneElement, file);
      });
  }
});

function updateThumbnail(dropZoneElement, file) {
  let thumbnailElement = dropZoneElement.querySelector(".drop-zone__thumb");

  // First time - remove the prompt
  if (dropZoneElement.querySelector(".drop-zone__prompt")) {
    dropZoneElement.querySelector(".drop-zone__prompt").remove();
  }

  // First time - there is no thumbnail element, so let's create it
  if (!thumbnailElement) {
    thumbnailElement = document.createElement("div");
    thumbnailElement.classList.add("drop-zone__thumb");
    dropZoneElement.appendChild(thumbnailElement);
  }

  thumbnailElement.dataset.label = file.name;

  // Show thumbnail for image files
  if (file.type.startsWith("image/")) {
    const reader = new FileReader();

    reader.readAsDataURL(file);
    reader.onload = () => {
      thumbnailElement.style.backgroundImage = `url('${reader.result}')`;
    };
  } else {
    thumbnailElement.style.backgroundImage = null;
  }
}




function showAlertForSave() {
    Swal.fire({
        // title: "Are you sure?",
        text: "You have to login first to see member profile",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Go to login"
    }).then((result) => {
        if (result.isConfirmed) {
            // Swal.fire({
            //   title: "Redirect!",
            //   text: "You will be redirected to the login page.",
            //   icon: "success"
            // });
            window.location.href = site_url + "/login";
        }
    });
}

$(document).ready(function() {
  $('#reviewForm').on('submit', function(event) {
    event.preventDefault(); // Prevent the default form submission

    var formData = new FormData(this); // Create FormData object from the form

    $.ajax({
      url: "{{ route('save.product.review') }}",
      type: 'POST',
      data: formData,
      processData: false, // Required for FormData
      contentType: false, // Required for FormData
      dataType: 'json',  // Expect JSON response
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function(response) {
        console.log(response);
            if (response.success) {
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true
                };
                toastr.success(response.success);
            }
            if (response.error) {
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true
                };
                toastr.error(response.error);
            }
            setTimeout(function() {
                window.location.reload();
            }, 3000);
        },
      error: function(xhr, status, error) {
        console.error('AJAX Error:', status, error);
        console.error('Response Text:', xhr.responseText);
            var responseText = xhr.responseText;
            try {
                var jsonResponse = JSON.parse(responseText);
                if (jsonResponse.error) {
                    toastr.error('Error: ' + jsonResponse.error);
                } else {
                    toastr.error('An unexpected error occurred.');
                }
            } catch (e) {
                toastr.error('An unexpected error occurred.');
            }
        }
    });
  });
});

function submitEditReview(event, reviewId) {
    event.preventDefault();

    var form = document.getElementById('updateReview' + reviewId);
    var formData = new FormData(form);

    $.ajax({
        url: "{{ route('update.product.review', ['id' => 'REVIEW_ID']) }}".replace('REVIEW_ID', reviewId),
        type: 'POST',
        data: formData,
        processData: false, // Required for FormData
        contentType: false, // Required for FormData
        dataType: 'json',  // Expect JSON response
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            console.log(response);
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            };
            if (response.success) {
                toastr.success(response.message);
            } else if (response.error) {
                toastr.error(response.message);
            }
            // Optionally reload page after a delay
            setTimeout(function() {
                window.location.reload();
            }, 3000);
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', status, error);
            console.error('Response Text:', xhr.responseText);

            // Since dataType is set to 'json', the response should already be parsed
            var responseText = xhr.responseText;

            // Check if the response is JSON and contains an error message
            if (responseText) {
                try {
                    var jsonResponse = JSON.parse(responseText);
                    if (jsonResponse.error) {
                        toastr.error('Error: ' + jsonResponse.error);
                    } else {
                        toastr.error('An unexpected error occurred.');
                    }
                } catch (e) {
                    toastr.error('An unexpected error occurred.');
                }
            } else {
                toastr.error('An unexpected error occurred.');
            }
        }
    });
}

function submitReportForm(reviewId) {
    var form = document.getElementById('reportForm' + reviewId);
    var formData = new FormData(form);

    fetch('{{ route('add.product.report', '') }}/' + reviewId, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        }
    })
    .then(response => {
        // Handle HTTP error status
        if (!response.ok) {
            return response.json().then(data => {
                throw new Error(data.message || 'An unexpected error occurred.');
            });
        }
        return response.json();
    })
    .then(data => {
        console.log(data);
            if (data.success) {
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true
                };
                toastr.success(data.success);
            }
            if (data.error) {
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true
                };
                toastr.error(data.error);
            }
        setTimeout(function() {
            window.location.reload();
        }, 3000);
    })
    .catch(error => {
        console.error('AJAX Error:', error);
        toastr.error(error.message || 'An unexpected error occurred.');
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

document.addEventListener('click', function(event) {
    var dropdowns = document.querySelectorAll('.dropdown-menu');
    var isClickInsideDropdown = event.target.closest('.dropdown-menu') || event.target.closest('.btn-group');

    if (!isClickInsideDropdown) {
        dropdowns.forEach(function(dropdown) {
            dropdown.classList.remove('show');
        });
    }
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

    $(document).ready(function() {
        $('.overview').on('click', function() {
            if ($("#home-tab").hasClass('active')) {
                $("#home-tab").removeClass('active').attr('aria-selected', 'false');
            }
            if ($("#profile-tab").hasClass('active')) {
                $("#profile-tab").removeClass('active').attr('aria-selected', 'false');
            }
            if ($("#Question-tab").hasClass('active')) {
                $("#Question-tab").removeClass('active').attr('aria-selected', 'false');
            }

            $("#review-tab").addClass('active').attr('aria-selected', 'true');

            $(".tab-pane").removeClass('active show');
            $("#review-tab_content").addClass('active show');

            $('html, body').animate({
                scrollTop: $('.description-frame').offset().top
            }, 500);

            // $('html,body').animate({'scrollTop':$('.description-frame').position().top}, 500);
            
        });
    });


</script>

@endsection