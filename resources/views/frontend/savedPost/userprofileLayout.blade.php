<?php

use App\Models\Admin\Notification;
use App\Models\UserAuth;
use App\Models\Setting;

// $userData = UserAuth::getLoginUser();
$notification = new Notification();
// $notifications = $notification->getAllNoticeForUser(UserAuth::getLoginId());
$countNotice = $notification->getUserCount(UserAuth::getLoginId());
?>
@extends('layouts.frontlayout')
@section('content')
<style type="text/css">
    /* .show-text.show-more-height a {
  color: #db712b !important;
  font-weight: 600;
} */
    .profile-bio a{
        color: #db712b !important;
    }

    /* Loader */
    .loader {
        width: 5rem;
        height: 5rem;
        border: 0.6rem solid #999;
        border-bottom-color: transparent;
        border-radius: 50%;
        margin: 0 auto 20px;
        animation: loader 500ms linear infinite;
    }

    /* Spinner Animation */
    @keyframes loader {
        to {
            transform: rotate(360deg);
        }
    }

    .status-circle {
        width: 15px;
        height: 15px;
        border-radius: 50%;
        background-color: #fb0000;
        border: 2px solid white;
        bottom: 0px;
        left: 4px;
        position: absolute;
    }

    .mekestyle {
        padding: 12px;
        display: inline-flex;
        /* overflow: hidden;
        overflow-x: auto;
        overflow-y: hidden;
        white-space: nowrap;
        scrollbar-width: thin; */
        width: 100%;
        margin-bottom: 0px;
    }

    .icon-container {
        position: relative;
        filter: drop-shadow(0 0 2px #ac8c42);
    }

    .connectedMember {
        height: 75px;
        width: 75px;
        border-radius: 20px;
        margin-right: 20px;
        /*position: relative;
        -webkit-clip-path: polygon(23.48% 81.62%, 50% 66%, 79.37% 82.25%, 74.91% 52.73%, 96% 38.17%, 67.91% 27.09%, 49.68% 2.47%, 33.99% 25.82%, 6.21% 37.22%, 27.30% 52.73%);
        clip-path:polygon(23.48% 81.62%, 50% 66%, 79.37% 82.25%, 74.91% 52.73%, 96% 38.17%, 67.91% 27.09%, 49.68% 2.47%, 33.99% 25.82%, 6.21% 37.22%, 27.30% 52.73%);height: 140px;width: 140px;*/
    }

    /*.icon-container{
       position: relative;
       filter: drop-shadow(0 0 2px #000);
    }*/
    .bg-black {
        background-color: #000;
    }

    .profile-img {
        text-align: center;
    }

    .cover-profile-pic {
        position: relative;
        z-index: 1;
    }

    .cover-profile-pic img {
        background: #fff;
        border-radius: 50%;
        text-decoration: none;
        padding: .5rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
    }

    .profile-stats {
        margin-top: 6px;
    }

    .profile-stats ul {
        padding-left: 0;
    }

    /*.profile-stats li {display: inline-block;font-size: 1.2rem;line-height: 1.5;margin-right: 4rem;cursor: pointer;font-weight: 600;}*/
    .profile-stats li:last-of-type {
        margin-right: 0;
    }

    .profile-img input {
        display: none;
    }

    .profile-user-name {
        font-size: 20px;
        padding: 0px 0 0;
    }

    .profile-gallery#pills-tabContent {
        border: 0;
        box-shadow: none;
        padding: 0;
        margin: 0;
        padding: 5px 10px 0;
        background: transparent;
    }

    .gallery-tabs#pills-tab {
        justify-content: start;
    }

    .gallery-tabs#pills-tab li button {
        width: auto;
        height: auto;
        font-weight: 600;
        background: transparent;
        border: 0;
        border-bottom: 2px solid #fff;
        border-radius: 0;
        font-size: 15px;
        box-shadow: none;
        padding: 0;
        color: #000 !important;
    }

    .gallery-tabs#pills-tab li button.active,
    .gallery-tabs#pills-tab li button:active {
        font-size: 15px;
        font-weight: 600;
        background-color: transparent !important;
        border-bottom: 2px solid #ac8c42;
        color: #ac8c42 !important;
    }

    .copy-link-box input {
        width: 60%;
    }

    .desk-show {
        display: block;
    }

    .mob-show {
        display: none;
    }

    .show-text {
        margin-bottom: 0;
        font-size: 14px;
    }

    .show-more-height {
        height: 24px;
        overflow: hidden;
        margin-bottom: 0;
    }

    .show-more {
        color: #dc7228;
        text-decoration: underline;
        margin-bottom: 10px;
        cursor: pointer;
    }

    .profile-card {
        position: relative;
        display: flex;
        flex-direction: column;
        word-wrap: break-word;
        background-color: #fff;
        background-clip: border-box;
        border: 1px solid rgba(0, 0, 0, .1);
        border-radius: 20px;
        box-shadow: 0px 0px 20px rgb(61 65 67 / 20%);
        padding: 10px;
    }

    .profile-card .user-profile-pic {
        border-radius: 20px;
        margin-top: -100px;
        box-shadow: 0px 0px 10px rgb(61 65 67 / 40%);
        width: 150px;
        height: 150px;
    }

    .profile-user {
        padding-top: 20px;
    }

    .profile-user h4 {
        font-size: 18px;
        font-weight: 600;
        padding-top: 15px;
    }

    .profile-stats li {
        display: inline-flex;
        flex-direction: column;
        padding: 0 25px;
        font-size: 13px;
    }

    .profile-stats li span {
        font-weight: 600;
        font-size: 15px;
    }

    .cover-img {
        background-color: #fff;
        height: 350px;
         margin-bottom: 20px;
         overflow: hidden;
         margin-top: -30px;
    }

    .cover-img img {
        /*height: 250px;
        object-fit: cover;
        object-position: center;*/
        width: 100%;
        margin-top: -8%;

    }

    .sharing-area a.btn.create-post-button {
        height: auto;
        line-height: 19px;
        font-size: 13px;
        padding: .275rem .65rem;
    }

    .social-icon ul {
        display: inline-flex;
        padding-left: 0;
        margin-bottom: 0;
    }

    .social-icon ul li {
        padding: 16px 2px 0;
    }

    span.post-title {
        font-weight: 700;
    }

    video.video-part {
        height: 350px;
    }

    img.img-private {
        height: 100px;
        width: 100px;
    }

    .col-lg-12.privateAcc {
        text-align: center;
    }

    span.test-private {
        font-weight: 600;
    }

    ul.footer-social-icon i.bi.bi-tiktok {
        padding: 8px 10px;
        display: flex;
        justify-content: center;
        align-content: center;
    }

    /*---------------------*/
    /* .all_sml_profile::before{
        width: 12px;
        content: '';
        position: absolute;
        background: black;
        left: 6px;
        height: 100%;
        z-index: 1;
    } */

    @media only screen and (max-width:767px) {
        .desk-show {
            display: none;
        }

        .mob-show {
            display: block;
        }

        .cover-profile-pic img {
            width: 80px;
            padding: .3rem;
        }

        .copy-link-box {
            padding-top: 15px;
        }

        .copy-link-box input {
            width: 67%;
            height: 43px;
            font-size: 13px;
        }

        .profile-user-name {
            font-size: 18px;
        }

        .connectedMember {
            height: 50px;
            width: 50px;
            border-radius: 10px;
        }

        /*.n-mg {
            margin-top: -20px;
        }*/

        .profile-stats {
            margin-top: 15px;
        }

        .profile-gallery#pills-tabContent {
            padding: 5px;
        }

        .cover-img {
            height: 250px;
            margin-top: -35px;
        }

        .cover-img img {
           /*height: 150px;*/
           margin-top: 0;
           height: 100%;
        }
    }

    @media only screen and (min-width:992px) and (max-width:1199px) {
        .cover-profile-pic img {
            width: 120px;
            padding: .3rem;
        }

        .profile-stats {
            margin-top: 0rem;
        }
    }

    .profile-bio ul.footer-social-icon {
        text-align: center;
    }

    .profile-bio ul li a i {
        color: #fff !important;
        font-size: 14px;
    }

    .profile-bio ul li a {
        background-color: #000;
        padding: 1px;
        border-radius: 50px;
    }

    /* #showWebsitesBtn {
        background: black;
        border: 1px solid #fff;
        padding: 0px;
        border-radius: 50%;
        font-size: 15px;
        width: 32px;
        height: 32px;
        color: #fff;
        text-align: center;
        line-height: 28px;
    } */
    .links_more {
        margin-top: 25px;
        margin-bottom: -8px;
        font-size: 14px;
        cursor: pointer;
    }

    .links {
        margin-top: 16px;
        margin-bottom: -8px;
        font-size: 14px;
    }

.new-blog-post{height: 450px;overflow: hidden;margin: 0px 0 40px;padding:0px 0;/*background-image: url("https://www.finderspage.com/public/new_assets/assets/images/search-background.png");background-size: cover;background-repeat: no-repeat;*/}
.blog-img-area{height: 450px;overflow: hidden; position: relative; }
.blog-img-area img{width:100%;height: 450px;object-fit: cover; position: relative;}
.blog-img-caption{cursor:pointer;position: absolute; left: 0;right: 0;top: 0;bottom: 0;text-align: center;display: flex;justify-content: center;align-items: center;}
.blog-img-caption::before{content: ''; position: absolute; width: 100%; height: 100%; top:0; bottom:0; left:0; right: 0;background-color: rgba(0, 0, 0, 0.4);}
.blog-img-caption h2{color: #fff; position: relative;}
.latest-blog-box{border: 1px solid #fcd152; border-radius: 5px;  padding: 0!important;}
.latest-blog-box img{height: 200px; width: 100%;}
.latest-blog-box .thumbnail-video{height: 250px; width: 100%;margin: 0; padding: 0; position: relative;}
.latest-blog-box .card-body{display: block;background-color: #f5f5f5;}
.latest-blog-box .card-title{font-size: 14px; font-weight: 600;display: -webkit-inline-box;-webkit-line-clamp: 2;-webkit-box-orient: vertical;overflow: hidden;text-overflow: ellipsis;height: 35px;}
.latest-blog-box .video-frame1{margin-top: -7px;}
.latest-blog-box .card-text{font-size: 14px;}
.latest-blog-box .card-footer{background-color: #f5f5f5;}
.latest-blog-box .card-footer small{font-size:12px;}

.shop-blog-post{background-color: #ececeb;}
.shop-blog-box {height: 250px;text-shadow: 0 1px 3px rgba(0,0,0,0.6);background-size: cover !important;color: white;position: relative;border-radius: 5px;margin-bottom: 20px;}
.shop-blog-box .card-description {position: absolute;bottom: 10px;left: 10px;}
.shop-blog-box .card-description h5 {font-size: 20px;}
.shop-blog-box .card-link {position: absolute;left: 0;top: 0;bottom: 0;width: 100%;z-index:2;background: black;opacity: 0;}
.card-link:hover{opacity: 0.8;}
.bottom-block{position: relative;height: 380px; margin-bottom: 130px;padding-top: 50px;background-color: #ececeb;}
.bottom-frame-area{position: relative; }
.bottom-frame-area .rt-img{width: 100%;height: 450px;object-fit: cover;}
.bottom-blog-box{width: 60%!important; padding:0!important; text-align: center;}
.bottom-blog-box .card-img{height: 250px; object-fit: cover;}
.bottom-blog-box .card-text{font-size: 14px;display: -webkit-inline-box;-webkit-line-clamp: 2;-webkit-box-orient: vertical;overflow: hidden;text-overflow: ellipsis;}
.bottom-blog-box .card-body{display: block;}
.px-lr{padding-left:0.8rem; padding-right:0.8rem;}

.new-blog-post .content-slider.slick-slider .slick-prev{background-image: url('{{ asset('new_assets/assets/images/right.png') }}') !important;transform: rotate(180deg);background-repeat: no-repeat;left: 0;width: 40px;height: 40px;}
.new-blog-post .content-slider.slick-slider .slick-prev::before{display: none;}

.new-blog-post .content-slider.slick-slider .slick-next{background-image: url('{{ asset('new_assets/assets/images/right.png') }}') !important;background-repeat: no-repeat;right: 0;width: 40px;height: 40px;}  
.new-blog-post .content-slider.slick-slider .slick-prev, .new-blog-post .content-slider.slick-slider .slick-next{top:46%;}
.new-blog-post .content-slider.slick-slider .slick-next::before{display: none;}

@media only screen and (max-width:767px){
.new-blog-post{height: auto;}   
.blog-img-area img{height: 200px;}
.blog-img-area{height: auto; overflow:visible;} 
.latest-blog-box img {height: 220px;}
.bottom-blog-box{width: 90%!important; padding:0!important; text-align: center;}
.bottom-block{height: auto; margin-bottom: 5px;}
.profile-card{padding: 20px 0;}
}

@media only screen and (min-width:768px) and (max-width:991px){
.new-blog-post, .blog-img-area, .blog-img-area img{height: 300px;}    
.bottom-block{height: auto; margin-bottom: 5px;}    
}



.discount {
  position: absolute;
  z-index: 1000;
  left: 138px;
}
.discount .discount-text {
  color: #fff;
  background: #ff1744;
  font-family: Arial, Verdana, sans-serif;
  font-size: 13px;
  padding: 8px;
  font-weight:bold;
}
.discount .discount-text span {
  display: block;
  font-size: 16px;
}
.discount .discount-text:before {
  content: " ";
  position: absolute;
  bottom: -7px;
  left: 0;
  width: 0;
  height: 0;
  border-left: 5px solid transparent;
  border-right: 0 solid transparent;
  border-top: 7px solid #420909;
}

.see_all_btn{
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: black;
    color: black;
    border: 0;
    position: absolute;
    right: 0;
    height: 100%;
    top: 0;
    padding: 10px;
    background: linear-gradient(90deg, rgba(170, 137, 65, 1) 0%, rgba(205, 156, 49, 1) 13%, rgba(154, 128, 73, 1) 35%, rgba(246, 204, 78, 1) 51%, rgba(181, 147, 56, 1) 75%, rgba(163, 136, 68, 1) 100%);
    z-index: 1;
}

 .see_all_btn::before {
    content: '';
    position: absolute;
    width: 13px;
    height: 100%;
    top: 0;
    left: -12px;
    background: #000;
 }
 /* .user-p-scroller::-webkit-scrollbar{
    display: none;
 } */
 .user-p-scroller {
    padding-bottom: 5px;
  /* -ms-overflow-style: none;   */
   scrollbar-width: thin; 
   overflow-x: scroll;
}
/* .user-p-scroller::-webkit-scrollbar {
    background: #000;
}
.user-p-scroller::-webkit-scrollbar-thumb {
background-color: black !important;
} */

</style>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-12">
            <div class="cover-img">
            @if($user->status === 0)
                <div class="discount" data-toggle="tooltip" data-placement="top" title="This user suspended By admin">
                <div class="discount-text ">
                  <span>Suspended</span>
                </div>
              </div>
            @endif
            <a href="{{ $user->cover_img != '' ? asset('assets/images/profile/'.$user->cover_img) : asset('images_blog_img/1688636936.jpg') }}" data-lightbox="cover-img" data-title="Cover Image">
                <img src="{{ $user->cover_img != '' ? asset('assets/images/profile/'.$user->cover_img) : asset('images_blog_img/1688636936.jpg') }}" alt="Cover Image">
            </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-5 mb-3">
            <div class="profile-card n-mg">
                <div class="card-body d-block">
                    <div class="d-flex flex-column align-items-center text-center justify-content-center">
                        <a href="{{ $user->image != '' ? asset('assets/images/profile/'.$user->image) : asset('images_blog_img/1688636936.jpg') }}" data-lightbox="profile-img" data-title="Profile Image">
                            <img src="{{ $user->image != '' ? asset('assets/images/profile/'.$user->image) : asset('images_blog_img/1688636936.jpg') }}" alt="Profile Image" class="user-profile-pic">
                        </a>
                        <div class="profile-user">

                             @if(Setting::get_setting("no_of_views", $user->id) == 1)
                            <strong class="zodiac_img"><img src="{{asset('zodiac_image/eye.png')}}" alt="eye.png"></strong> <strong>{{ $profile_view ?? 0 }}</strong>
                            @endif
                            &nbsp;
                            &nbsp;
                            <?php
                            foreach ($setting as $sett => $value) {
                                if ($value['setting_name'] == 'zodiac_section' || $value['setting_name'] == "") {
                                    if ($value['setting_value'] == 'show' || $value['setting_value'] == "") {
                            ?>
                                        @if(isset($user->Zodiac_image))
                                        <strong class="zodiac_img"><img src="{{asset('zodiac_image')}}/{{$user->Zodiac_image}}"></strong> <strong>{{$user->zodiac_name}}</strong>
                                        @endif

                            <?php
                                    }
                                }
                            } ?>
                            <?php $currentDate = date("Y-m-d"); ?>
                            <h4>{{$user->username}}@if($user->feature_end_date != null && $user->feature_end_date >= $currentDate )<i class="fas fa-star" style="color:#ffd55e;;"></i>@endif
                                <?php $created_date = $user->created;
                                $currentDateTime = date('Y-m-d H:i:s');

                                // Convert the dates to timestamps
                                $created_timestamp = strtotime($created_date);
                                $current_timestamp = strtotime($currentDateTime);

                                // Calculate the difference in seconds
                                $seconds_diff = $current_timestamp - $created_timestamp;

                                // Calculate the difference in days
                                $days_diff = floor($seconds_diff / (60 * 60 * 24));

                                // echo "Number of days between $created_date and $currentDateTime is $days_diff days.";
                                ?>
                                @if($days_diff <= '30' ) <!-- <span class="badge bg-secondary position-relative" style="top:0px;">New</span> -->
                                    <img src="{{ asset('front/images/new-blinking.gif') }}" alt="avatar" class="rounded-circle img-fluid" style="width: 60px;">
                                    @endif
                            </h4>

                            @foreach($categories as $cate)
                            @if($user->profession == $cate->id )
                            <strong class="zodiac_img how_do_you"> {{$cate->title}} </strong>
                            @endif
                            @endforeach()

                        </div>
                        <div class="profile-stats">
                            <!-- <ul>
                        <li><span class="profile-stat-count">164</span> Posts</li>
                        <li><span class="profile-stat-count">188</span> Connections</li>
                    </ul> -->
                        </div>
                        <div class="d-flex sharing-area justify-content-center align-items-center flex-wrap">
                        @if(UserAuth::getLoginId() == $user->id)
                            <a href="{{route('get.followers', UserAuth::getLoginId())}}" class="btn create-post-button mx-1">
                                All Connections @if($user->id == UserAuth::getLoginId())({{$profile_connected ?? 0}}) @endif
                            </a>
                        @else
                            @php
                                // Check if the logged-in user follows the other user
                                $isFollowing = DB::table('follows')
                                    ->where('follower_id', UserAuth::getLoginId())
                                    ->where('following_id', $user->id)
                                    ->where('status', 1)
                                    ->exists();
                                
                                // Check if the other user follows the logged-in user (to show 'Connect Back')
                                $isFollowedBack = DB::table('follows')
                                    ->where('follower_id', $user->id)
                                    ->where('following_id', UserAuth::getLoginId())
                                    ->where('status', 1)
                                    ->exists();
                                
                                // Check for pending connection requests
                                $isPending = DB::table('follows')
                                    ->where('follower_id', $user->id)
                                    ->where('following_id', UserAuth::getLoginId())
                                    ->where('status', 0)
                                    ->exists();
                            @endphp

                            @if($isFollowing && $isFollowedBack)
                                <a href="javascript:void(0)" class="btn create-post-button mx-1" id="connectedAlert">
                                    Connected
                                </a>
                                <a href="javascript:void(0)" class="btn create-post-button mx-1" id="disconnect" dataProfile-id="{{$user->id}}" dataLogin-id="{{UserAuth::getLoginId()}}">
                                    Disconnect
                                </a>
                            @elseif(!$isFollowedBack && $isFollowing)
                                <a href="javascript:void(0)" class="btn create-post-button mx-1" id="connect-back" dataProfile-id="{{$user->id}}" dataLogin-id="{{UserAuth::getLoginId()}}">
                                    Connect back
                                </a>
                            @elseif($isPending)
                                <a href="javascript:void(0)" class="btn create-post-button mx-1" id="requestedAlert">Requested</a>
                            @else
                                <a href="javascript:void(0)" class="btn create-post-button mx-1" id="connect" dataProfile-id="{{$user->id}}" dataLogin-id="{{UserAuth::getLoginId()}}">
                                    Connect
                                </a>
                            @endif
                        @endif
                        </div>

                        <div class="d-flex sharing-area justify-content-center align-items-center flex-wrap mt-2">
                            <a target="blank" href="{{url('/chatify')}}/{{$user->id}}" class="btn create-post-button mx-1" data-placement="top" data-toggle="tooltip" title="Chat"><i class="far fa-comment"></i></a>
                            <?php 
                                $setting_sharebtn = Setting::get_setting('share_btn',$user->id);
                            ?>
                            @if($setting_sharebtn == 'show'|| $setting_sharebtn == '')
                            <button type="button" class="btn create-post-button ms-2" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Share 
                                <span class="badge badge-secondary">{{ $blogShares->shares ?? ''}}</span><i class="fa fa-share share-icon"></i> </button>
                            @endif
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
                                                <input type="text" class="text" value="{{url('/chatify')}}/{{$user->id}}" id="field_input"/>
                                                <a href="javascript:void(0);" redirect-url="{{url('/chatify')}}/{{$user->id}}" copy-url="{{url('/chatify')}}/{{$user->id}}" class="copy_url btn create-post-button ms-2" data-placement="top" data-toggle="tooltip" title="Share in Chat">
                                                    <i class="fa fa-clone"></i>
                                                </a>
                                              </div>
                                                <hr>
                                              <div class="copy-text">
                                                <input type="text" class="text" value="Share link via email" readonly id="email_input"/>
                                                <a href="mailto:{!! $user->email !!}?subject=Profile share&body=Profile link : {{route('UserProfileFrontend', $user->slug)}}" class="btn create-post-button ms-2" data-placement="top" data-toggle="tooltip" title="Email">
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
                        <!-- <span class="social-icon">{!! $shareComponent !!}</span> -->
                        <span class="social-icon">
                            <div class="profile-bio">
                                <div class="col-lg-12 col-md-4" bis_skin_checked="1">

                                    <ul class="footer-social-icon">
                                        @if($user->instagram)
                                        <li><a target="_blank" href="https://www.instagram.com/{{$user->instagram}}">
                                                <i class="fab fa-instagram" aria-hidden="true"></i> </a>
                                        </li>
                                        @endif

                                        @if($user->twitter)
                                        <li><a target="_blank" href="https://www.twitter.com/{{$user->twitter}}">
                                                <i class="fa-brands fa-twitter"></i></a>
                                        </li>
                                        @endif

                                        @if($user->facebook)
                                        <li> <a target="_blank" href="https://www.facebook.com/{{$user->facebook}}/">
                                                <i class="fab fa-facebook-f" aria-hidden="true"></i> </a>
                                        </li>
                                        @endif

                                        @if($user->linkedin)
                                        <li><a href="https://www.linkedin.com/company/{{$user->linkedin}}" target="_blank">
                                                <i class="fab fa-linkedin-in" aria-hidden="true"></i></a>
                                        </li>
                                        @endif

                                        @if($user->youtube)
                                        <li>
                                            <a href="https://www.youtube.com/channel/{{$user->youtube}}" target="_blank"><i class="fab fa-youtube" aria-hidden="true"></i></a>
                                        </li>
                                        @endif

                                        @if($user->Tiktok)
                                        <li class="tiktok"><a target="_blank" href="https://www.tiktok.com/{{$user->Tiktok}}"><i class="bi bi-tiktok"></i></a>
                                        </li>
                                        @endif

                                    </ul> <br>
                                    @if($user->business_website && $user->website_title)
                                        @php
                                            $decodedWebsites = explode(',', $user->business_website);
                                            $decodedTitles = explode(',', $user->website_title);
                                        @endphp

                                        @if(count($decodedWebsites) > 1)
                                            @php
                                                $count_web = count($decodedWebsites) - 1;
                                                $firstWebsite = $decodedWebsites[0];
                                                $firstTitle = isset($decodedTitles[0]) ? $decodedTitles[0] : '';
                                                $displayText = strlen($firstWebsite) > 20 ? substr($firstWebsite, 0, 20) . ' <b>' . $count_web . ' More </b>' : $firstWebsite;
                                            @endphp

                                            <p id="showWebsitesBtn" data-toggle="modal" class="links_more" data-target="#websiteModal">
                                                <i class="fas fa-link fa-sm fa-fw mr-2 text-gray-400"></i> <?= $displayText; ?>
                                            </p>
                                        @else
                                            @php
                                                $singleWebsite = $decodedWebsites[0];
                                                $singleTitle = isset($decodedTitles[0]) ? $decodedTitles[0] : '';
                                                $displayText = strlen($singleWebsite) > 20 ? substr($singleWebsite, 0, 20) . '......' : $singleWebsite;
                                            @endphp
                                            <p class="links">
                                                <a href="{{ $singleWebsite }}" data-toggle="modal" data-target="#websiteModal">
                                                    <i class="fas fa-link fa-sm fa-fw mr-2 text-gray-400"></i> {{ $displayText }} 
                                                </a>
                                            </p>
                                        @endif

                                    <!-- Modal -->
                                    <div class="modal fade" id="websiteModal" tabindex="-1" role="dialog" aria-labelledby="websiteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="websiteModalLabel">Links</h5>
                                                    {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button> --}}
                                                </div>
                                                <div class="modal-body" style="text-align: left;">
                                                    @foreach ($decodedWebsites as $index => $website)
                                                        @php
                                                            $title = isset($decodedTitles[$index]) ? $decodedTitles[$index] : '';
                                                            $displayWebsite = strlen($website) > 30 ? substr($website, 0, 30) . '...' : $website;
                                                        @endphp
                                                        <div>
                                                            <strong>Title:</strong> {{ $title }}<br>
                                                            <strong>Link:</strong> <a target="_blank" href="{{ $website }}">
                                                                <i class="fas fa-link fa-sm fa-fw mr-2 text-gray-400"></i>
                                                                {{ $displayWebsite }}
                                                            </a><br><br>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="closeModalBtn">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                </div>
                            </div>
                        </span>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-lg-9 col-md-7">
            <div class="profile-card mb-3">
                <div class="card-body d-block">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="profile-bio">
                                @if($user->first_name)
                                <p class="show-text show-more-height"><i class="fa-solid fa-user"></i> &nbsp;&nbsp;{!! $user->first_name !!}&nbsp; {!! $user->last_name !!}</p>
                                @endif
                                @if($user->email)
                                <p class="show-text show-more-height"><i class="fa-solid fa-envelope"></i> &nbsp;&nbsp;{!! $user->email !!}</p>
                                @endif
                                <!--  @if($user->dob =="")
                             <span></span><p class="show-text show-more-height">{!! $user->dob !!}</p>
                            @endif -->
                                @if($user->phonenumber)
                                <p class="show-text show-more-height"><i class="fa-solid fa-mobile py-2"></i> &nbsp;&nbsp;{!! $user->phonenumber !!}</p>
                                @endif
                                @if($user->bio)
                                <div class="profile-bio" style="text-align: justify; white-space: pre-line;">
                                <?php
                                    $processedText = Setting::makeLinksClickable($user->bio);
                                ?>
                                    <p class="show-text show-more-height"> &nbsp;&nbsp;{!! $processedText !!}</p>
                                    <div class="show-more fw-bold" style="display: none;">Read More</div>
                                </div>
                                @endif
                            </div>


                        </div>
                    </div>

                    <hr>
                    @if($user->id == UserAuth::getLoginId())
                    <div class="row">
                        <div class="col-lg-12 all_sml_profile">
                            <div class="mekestyle bg-black d-flex position-relative">
                               <div class="d-flex align-items user-p-scroller">

                                @foreach($followerDetailsArray as $followers)
                                @php 
                                    $notifications = $notification->getAllNoticeForUser($followers['id']); 
                                @endphp
                                    <a href="{{ route('latestPostuser', $followers['slug']) }}" class="latestPosts" data-id="{{ $followers['id'] }}" data-slug="{{ $followers['slug'] }}">
                                        <div class='icon-container'>
                                            <img class="connectedMember" src="{{ $followers['image'] != '' ? asset('assets/images/profile/'.$followers['image']) : asset('user_dashboard/img/undraw_profile.svg') }}" />
                                            
                                            @if($followers['status'] == "1")
                                                <div class='status-circle'></div> 
                                            @endif
                                        </div>
                                    </a>
                                @endforeach                                
                            
                               </div>
                               <a href="{{route('get.followers', UserAuth::getLoginId())}}" class="text-white see_all_btn">All</a>

                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <?php
        //  dd($followerDetailsArray);
        // Extract "first_name" values into a separate array
        $followerID = array_column($followerDetailsArray, 'id');

        ?>
        @if(Setting::get_setting("account", $user->id) == "Public" || $user->id == UserAuth::getLoginId() || in_array(UserAuth::getLoginId(), $followerID, true))

        @php
            $countBlog = $Blogs->count();
            // $countVideo = $video->count();
            $countRealestateCount = $realestateCount->count();
            $countShoppingCount = $shoppingCount->count();
            $countFundraisersCount = $fundraisersCount->count();
            $countBusinessCount = $Business_count->count();
            $countJobCount = $jobCount->count();
            $countServicesCount = $servicesCount->count();
            $countEntertainment_count = $Entertainment_count->count();
            $countCommunityCount = $communityCount->count();

        @endphp
        <!-- <h5>Click category to view posts</h5> -->
         @if( !empty($countBlog) || !empty($countRealestateCount) || !empty($countShoppingCount) || !empty($countFundraisersCount) || !empty($countBusinessCount) || !empty($countJobCount) || !empty($countServicesCount) || !empty($countEntertainment_count) || !empty($countCommunityCount))
        <div class="col-md-12">
            <div class="profile-card mb-3">
                <div class="card-body d-block">
                    <section class="new-blog-post">
                        <div class="container-fluid px-lr">
                            <div class="row">
                            

                                <div class="content-slider">
                                    @if ($countBlog > 0)
                                    <div class="col-lg-6 col-md-6 col-6 gx-0 nbdr-r">
                                        <div id="blogs-posts-area" class="blog-img-area" dataProfile-id="{{$user->id}}" dataPofile-section="blogs">
                                            <img src="{{ asset('images_blog_img/bg1.jpg') }}" alt="img28" class="img-fluid">
                                            <div class="blog-img-caption">
                                                <h2>Posts</h2>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    {{-- @if ($countVideo > 0)
                                    <div class="col-lg-6 col-md-6 col-6 gx-0 nbdr-l">
                                        <div id="video-posts-area" class="blog-img-area" dataProfile-id="{{$user->id}}" dataPofile-section="video">
                                            <img src="{{ asset('images_blog_img/bg2.jpg') }}" alt="Polar Bear Penguin Outdoor Decoration" alt="img1" class="img-fluid">
                                            <div class="blog-img-caption">
                                                <h2>Videos</h2>
                                            </div>
                                        </div>
                                    </div>
                                    @endif --}}
                                    @if ($countRealestateCount > 0)
                                    <?php // echo"<pre>"; dd($user); echo "</pre>"; ?>
                                    <div class="col-lg-6 col-md-6 col-6 gx-0 nbdr-l">
                                        <div id="video-posts-area" class="blog-img-area" dataProfile-id="{{$user->id}}" dataPofile-section="real-estate">
                                            <img src="{{ asset('user_dashboard/img/c3.png') }}" alt="img3" class="img-fluid">
                                            <div class="blog-img-caption">
                                                <h2>Real Estate</h2>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @if ($countShoppingCount > 0)
                                    <div class="col-lg-6 col-md-6 col-6 gx-0 nbdr-l">
                                        <div id="video-posts-area" class="blog-img-area" dataProfile-id="{{$user->id}}" dataPofile-section="shopping">
                                            <img src="{{ asset('user_dashboard/img/c5.png') }}" alt="img5" class="img-fluid">
                                            <div class="blog-img-caption">
                                                <h2>Shopping</h2>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @if ($countFundraisersCount > 0)
                                    <div class="col-lg-6 col-md-6 col-6 gx-0 nbdr-l">
                                        <div id="video-posts-area" class="blog-img-area" dataProfile-id="{{$user->id}}" dataPofile-section="fundraisers">
                                            <img src="{{ asset('images_blog_img/fundraising.jpeg') }}" alt="img7" class="img-fluid">
                                            <div class="blog-img-caption">
                                                <h2>Fundraisers</h2>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @if ($countBusinessCount > 0)
                                    <div class="col-lg-6 col-md-6 col-6 gx-0 nbdr-l">
                                        <div id="video-posts-area" class="blog-img-area" dataProfile-id="{{$user->id}}" dataPofile-section="Business">
                                            <img src="{{ asset('images_blog_img/bg2.jpg') }}" alt="Polar Bear Penguin Outdoor Decoration" class="img-fluid">
                                            <div class="blog-img-caption">
                                                <h2>Business</h2>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @if ($countJobCount > 0)
                                    <div class="col-lg-6 col-md-6 col-6 gx-0 nbdr-l">
                                        <div id="video-posts-area" class="blog-img-area" dataProfile-id="{{$user->id}}" dataPofile-section="Find-a-Job">
                                            <img src="{{ asset('user_dashboard/img/c2.png') }}" alt="img1" class="img-fluid">
                                            <div class="blog-img-caption">
                                                <h2>Jobs</h2>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @if ($countEntertainment_count > 0)
                                    <div class="col-lg-6 col-md-6 col-6 gx-0 nbdr-l">
                                        <div id="video-posts-area" class="blog-img-area" dataProfile-id="{{$user->id}}" dataPofile-section="entertainment-industry">
                                            <img src="{{ asset('images_blog_img/hands-heart-coins.jpg') }}" alt="img41" class="img-fluid">
                                            <div class="blog-img-caption">
                                                <h2>Entertainment Industry</h2>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @if ($countCommunityCount > 0)
                                    <div class="col-lg-6 col-md-6 col-6 gx-0 nbdr-l">
                                        <div id="video-posts-area" class="blog-img-area" dataProfile-id="{{$user->id}}" dataPofile-section="our-community">
                                            <img src="{{ asset('user_dashboard/img/c4.png') }}" alt="img4" class="img-fluid">
                                            <div class="blog-img-caption">
                                                <h2>Our Community</h2>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @if ($countServicesCount > 0)
                                    <div class="col-lg-6 col-md-6 col-6 gx-0 nbdr-l">
                                        <div id="video-posts-area" class="blog-img-area" dataProfile-id="{{$user->id}}" dataPofile-section="services">
                                            <img src="{{ asset('images_blog_img/1688651557.jfif') }}" alt="img6" class="img-fluid">
                                            <div class="blog-img-caption">
                                                <h2>Services</h2>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </section>

                    
                        <!-- This section for blogs will be add after ajax request -->
                    

                    <section class="latest-blog-post py-4">
                        <div class="container px-lr">
                            <div class="row justify-content-center">
                                @if ($Blogs->isNotEmpty())

                                    <div class="col-lg-12">
                                        <h4 class="text-center">Latest Posts</h4>
                                    </div>

                                    @foreach ($Blogs as $blog)
                                    <div class="col-lg-3 col-md-4 gx-5">
                                        <div class="card latest-blog-box">
                                            <a class="card-link" href="{{ route('blogPostSingle', $blog->slug) }}">
                                                <?php
                                                    $itemFeaturedImage  = explode(',', $blog->image);
                                                    $imageUrl = isset($itemFeaturedImage[0]) && !empty($itemFeaturedImage[0]) ? asset("images_blog_img/" . $itemFeaturedImage[0]) : asset("images_blog_img/1688636936.jpg");
                                                ?>
                                                <img src="{{ $imageUrl }}" class="card-img-top" alt="img">
                                                <div class="card-body p-4">
                                                    <h5 class="card-title">{{ $blog->title }}</h5>
                                                </div>
                                                <div class="card-footer">
                                                    <small class="text-muted">Last updated {{ $blog->created_at->diffForHumans() }}</small>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    
                                    @endforeach
                                    {{-- @if ($totalBlogCount > 3)
                                        <div class="col-lg-12 text-center mt-4">
                                            <a href="#" class="btn fields-search text-center">View All</a>
                                        </div>
                                    @endif --}}
                                      
                                {{-- @else
                                    <div class="col-lg-12 text-center">
                                        <p>No Blogs</p>
                                    </div> --}}
                                @endif
                                
                                
                            </div>
                        </div>
                    </section>

                    <section class="shop-blog-post py-4">
                        <div class="container px-lr">
                            <div class="row">
                            <div class="col-lg-12">
                                    <h4 class="text-center">Shop the Look</h4>
                                </div>
                            @if ($shoppingCount->isNotEmpty())
                                @php
                                    $count = $shoppingCount->count();
                                @endphp
                                @foreach ($shoppingCount as $shop)
                                
                               
                                <div class="col-lg-3 col-md-6 gx-5">
                                    <?php
                                    $itemFeaturedImages = trim($shop->image1, '[""]');
                                    $itemFeaturedImage = explode('","', $itemFeaturedImages);

                                    $imageUrl = isset($itemFeaturedImage[0]) && !empty($itemFeaturedImage[0]) ? asset("images_blog_img/" . $itemFeaturedImage[0]) : asset("images_blog_img/1688636936.jpg");
                                    ?>
                                    
                                    <a class="card-link" href="{{ route('shopping_post_single', $shop->slug) }}">
                                        <div class="card shop-blog-box" style="background: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.2)), url('{{ $imageUrl }}');">
                                        </div>
                                    </a>
                                    
                                    <div class="card-description">
                                        <h5>{{ $shop->title }}</h5>
                                        <p>{{ $shop->location }}</p>
                                    </div>
                                </div>
                                
                                @endforeach
                                @if ($count > 4)
                                    <div class="col-lg-12 text-center mt-4">
                                        <a href="#" class="btn fields-search text-center">View All</a>
                                    </div>
                                @endif
                            @else
                                <div class="col-lg-12 text-center">
                                    <p>No content is published by you at the moment.</p>
                                </div>
                            @endif

                            </div>
                        </div>
                    </section>

                    <section class="bottom-block" style="display:none">
                        <div class="container-fluid px-lr">
                            <div class="row bottom-frame-area">
                                <div class="col-lg-6 gx-0">
                                    <div class="card bottom-blog-box">
                                        <a href="#">
                                            <h5 class="card-title p-2">Black Gem Square Necklace</h5>
                                            <img src="{{ asset('images_blog_img/bg4.jpg') }}" class="card-img" alt="img">
                                            <div class="card-body p-4">
                                                <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                                <div><a href="#" class="btn fields-search text-center">Read More</a></div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-6 gx-0">
                                    <img src="{{ asset('images_blog_img/bg3.jpg') }}" class="img-fluid rt-img">
                                </div>
                            </div>
                        </div>
                    </section>

                </div>
            </div>
        </div>
        @else
            <div class="col-md-12">
                <div class="profile-card mb-3">
                    <h1 class="text-center">No data found.</h1>
                </div>
            </div>
        @endif
        @else
        <div class="col-md-12">
            <div class="profile-card mb-3">
                <div class="card-body d-block">
                    <div class="row">
                        <div class="col-lg-12 privateAcc">
                            <img class="img-private" src="{{asset('images/download_private.png')}}">
                            <br>
                            <hr>
                            <span class="test-private">This account is private.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
<!-- End of container -->



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        var showText = $(".show-text");
        var showMore = $(".show-more");

        if (showText.text().length > 50) {
            showMore.show();
        }

        showMore.click(function() {
            if (showText.hasClass("show-more-height")) {
                $(this).text("Read Less");
            } else {
                $(this).text("Read More");
            }

            showText.toggleClass("show-more-height");
        });
    });

    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });


    jQuery(document).ready(function() {
        $("#connect").on("click", function() {
            var follower_id = $(this).attr('dataProfile-id');
            var following_id = $(this).attr('dataLogin-id');
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            $.ajax({
                url: site_url + '/get/follow',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    follower_id: follower_id,
                    following_id: following_id,
                },
                success: function(response) {
                    console.log(response.success);
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
                  setTimeout(function () {
                    window.location.reload();
                  }, 3000);
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    toastr.error(response.message);
                }
            });
        });


        $("#connect-back").on("click", function() {
            var follower_id = $(this).attr('dataProfile-id');
            var following_id = $(this).attr('dataLogin-id');
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            $.ajax({
                url: site_url + '/get/follow',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    follower_id: follower_id,
                    following_id: following_id,
                },
                success: function(response) {
                    console.log(response.success);
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
                  setTimeout(function () {
                    window.location.reload();
                  }, 3000);
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    toastr.error(response.message);
                }
            });
        });


        $("#disconnect").on("click", function() {
            var follower_id = $(this).attr('dataProfile-id');
            var following_id = $(this).attr('dataLogin-id');
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            $.ajax({
                url: site_url + '/get/unfollow',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    follower_id: follower_id,
                    following_id: following_id,
                },
                success: function(response) {
                    console.log(response.success);
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
                    setTimeout(function () {
                      window.location.reload();
                    }, 3000);
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    toastr.error(response.message);
                }
            });
        });


        $('.content-slider').slick({
            // Add your desired options here
            infinite: true,
            slidesToShow: 2,
            slidesToScroll: 1,
            autoplay: true, // Add this line for autoplay
            autoplaySpeed: 3000, 
            arrows: true,
            prevArrow: '<button type="button" class="slick-prev">Previous</button>',
            nextArrow: '<button type="button" class="slick-next">Next</button>',
         
        });
        // blog posts jquery
        
        $(document).on("click",'.blog-img-area', function() {
            
            var currentUserId = $(this).attr('dataProfile-id');
            var currentCalledSection = $(this).attr('dataPofile-section');
            
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            $.ajax({
                url: site_url + '/user-content',
                type: 'POST', 
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    current_user_id: currentUserId,
                    current_called_section: currentCalledSection,
                },
                success: function(response) {
                    console.log(response);

                    if ($('.blog-videos-posts-tab').length > 0) {
                        $('.blog-videos-posts-tab').remove();
                    }

                    if (response.html) {
                        $('.new-blog-post').after(response.html);
                        // toastr.success('Content loaded successfully!');
                    } else {
                        toastr.error('Failed to load content.');
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    toastr.error(response.message);
                }
            });
        });
    });



    $('.copy_url').click(function() {
        var urlToCopy = $(this).attr('copy-url');
        var redirect_url = $(this).attr('redirect-url');
        console.log('URL to copy:', urlToCopy);

        navigator.clipboard.writeText(urlToCopy)
            .then(function() {
                Swal.fire({
                    title: "URL copied to clipboard!",
                    text: urlToCopy,
                    icon: "success",
                    showConfirmButton: false
                });
                setTimeout(function() {
                    window.location.href = redirect_url;
                }, 1500);
            })
            .catch(function(err) {
                console.error('Unable to copy text to clipboard', err);
            });
    });

    $(document).ready(function() {
        // Show modal when clicking on the button inside the modal trigger
        $('#showWebsitesBtn').click(function() {
            $('#websiteModal').modal('show');
        });
        $('#closeModalBtn').click(function() {
            $('#websiteModal').modal('hide');
        });
    });



    $(document).ready(function() {
        toastr.options.timeOut = 1500;
        var userName = '{{ $user->first_name }}';
        // toastr.info('Page Loaded!');
        $('#connectedAlert').click(function() {
           toastr.error('You are already connected to ' + userName + '.');
        });

        $('#requestedAlert').click(function() {
           toastr.error('You already requested to ' + userName + '.');
        });
      });


    $(document).ready(function() {
        $(document).on('click', '.latestPosts', function(e) {
            e.preventDefault();

            var userId = $(this).data('id');
            var userSlug = $(this).data('slug');

            if (userId) {
                $.ajax({
                    url: '/latest-status',
                    method: 'POST',
                    data: {
                        id: userId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        console.log('Success:', response);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    },
                    complete: function() {
                        window.location.href = "{{ route('latestPostuser', '') }}/" + userSlug;
                    }
                });
            } else {
                console.log('User ID not found.');
            }
        });
    });


</script>

@endsection