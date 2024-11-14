<?php

use App\Models\Admin\HomeSettings;
use App\Models\Admin\Testimonials;
use App\Models\UserAuth;
use App\Models\Blogs;
use App\Models\Setting;
use App\Models\Admin\AdminAuth; 
$userdata = UserAuth::getLoginUser();
$user_all_data = UserAuth::getUser($blog->user_id);
// dd($userdata);
$testimonials = Testimonials::where('status', 1)->get();
// dd($blog->slug);
$neimg = trim($blog->image1, '[""]');
$img  = explode('","', $neimg);
$count = count($img);

$setting_like_option = Setting::get_setting('likes',$blog->user_id);
?>

@php
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
@endphp

<style type="text/css">
    .checkrepo {
        display: flex;
    }

    label.repo-label {
        margin: 12px;
        font-size: 14px;
    }

    /*div#social-links ul {
        padding: 0;
    }*/

   /* li.shareComponent {
        left: 0 !important;
    }

    div#social-links ul li {
        position: relative;
        display: inline-flex;
        justify-content: center;
        padding: 12px 30px 12px 0px;
    }

    a.btn.create-post-button {
        height: 28px !important;
    }*/

    .disabled {
        pointer-events: none;
        /* Disable click events */
        opacity: 0.5;
        /* Apply a visual indication of disabled state */
        /* You can customize the styling further based on your needs */
    }
    .view_counts{
        position: initial !important;
    }
    .copy-button{background: rgb(170, 137, 65);border: none;outline: none;border-radius: 5px;cursor: pointer;padding: 2px;
    background: linear-gradient(90deg, rgba(170, 137, 65, 1) 0%, rgba(205, 156, 49, 1) 13%, rgba(154, 128, 73, 1) 35%, rgba(246, 204, 78, 1) 51%, rgba(181, 147, 56, 1) 75%, rgba(163, 136, 68, 1) 100%);}

    a.report-btn i {
        background-color: #c69834;
        color: #fff;
        font-size: 9px;
        padding: 8px;
        border-radius: 50%;
    }

    strong.zodiac_img {
        padding: 6px 6px !important;
    }
    .like-section {
        margin-right: 40px;
    }
    
    i.fa-regular.fa-bookmark::before {
        font-size: 13px !important;
    }
</style>
@extends('layouts.frontlayout')
@section('content')
<section class="real-estate-post">
    <span>
        @include('admin.partials.flash_messages')
    </span>
    <div class="container">
        <div class="col-lg-12 prev-next-arrows">
            <div class="left-arrow">
                <a href="@if($nextPostId != null){{route('real_esate_post',$nextPostId)}} @else # @endif" class="{{ $nextPostId == null ? 'disabled' : '' }}"><i class="bi bi-arrow-left"></i> <span>Prev</span></a>

            </div>
            <div class="right-arrow1">
                <a href="@if($previousPostId != null){{route('real_esate_post',$previousPostId)}} @else # @endif" class="{{ $previousPostId == null ? 'disabled' : '' }}">
                    <span>Next</span> <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
        <!-- <div class="row">
            <div class="col-lg-12 prev-next-arrows">
                <div class="left-arrow">
                    @if($previousPostId != null)
                    <a  href="{{route('real_esate_post',$previousPostId)}}"><i class="bi bi-arrow-left"></i> <span>Prev</span></a>
                    @endif 
                </div>
                <div class="right-arrow1">
                    @if($nextPostId != null)
                    <a href="{{route('real_esate_post',$nextPostId)}}"><span>Next</span> <i class="bi bi-arrow-right"></i></a>
                    @endif
                </div>
            </div>
        </div> -->
        <div class="row">
            <div class="col-lg-8 col-md-8">
                <div class="bg-white p-4 position-relative">
                    <h5 class="mb-2"><b>Sale price:</b> ${{ number_format($blog->price, 2) }} / {{ $blog->bathroom }} Bathroom - {{ $blog->area_sq_ft }} Sq - {{ $blog->bedroom }} BHK </h5>
                    <div id="demo-new" class="carousel slide" data-bs-ride="carousel">
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
                                <a href="{{asset('images_blog_img')}}/{{$valuePostImages}}" data-lightbox="carousel">
                                    <img style="height: 600px;" src="{{asset('images_blog_img')}}/{{$valuePostImages}}" alt="{{ $blog->title }}" class="d-block w-100" onerror="this.onerror=null; this.src='https://www.finderspage.com/public/images_blog_img/1688636936.jpg'">
                                </a>
                        </div>
                        <?php
                                    }
                                } else {
                        ?>
                        <div class="carousel-item active">
                            <a href="{{asset('images_blog_img')}}/{{$valuePostImages}}" data-lightbox="carousel">
                                <img src="{{asset('images_blog_img')}}/{{$blog->image1}}" alt="Los Angeles" class="d-block w-100" onerror="this.onerror=null; this.src='https://www.finderspage.com/public/images_blog_img/1688636936.jpg'">
                            </a>
                        </div>
                            <?php
                                        }
                            ?>

                        @if($blog->post_video)
                        <div class="carousel-item">
                            <video width="100%" height="100%" controls class="d-block video-frame">
                                <source src="{{asset('images_blog_video')}}/{{$blog->post_video}}" type="video/mp4">
                            </video>
                        </div>
                        @endif
                    </div>
                    @if($count > 1)
                    <button class="carousel-control-prev" type="button" data-bs-target="#demo-new" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#demo-new" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                    @endif
                    <div class="d-flex justify-content-between align-items-center my-2">
                        <!-- Left Section: Report Button and Views Count -->
                        <div class="d-flex align-items-center">
                            <!-- Report Button -->
                            <a class="report-btn mr-2" href="#" data-bs-toggle="modal" data-bs-target="#exampleModal1" data-toggle="tooltip" data-placement="top" title="Report this post." style="margin-top: -3px !important;">
                                <i class="fa-regular fa-flag text-dark"></i>
                            </a>
                            
                            <!-- Views Icon and Count (conditional) -->
                            @if(Setting::get_setting("no_of_views", $blog->user_id) == 1 || $blog->user_id == UserAuth::getLoginId())
                                <div class="view_counts d-flex align-items-center ms-2">
                                    <strong class="zodiac_img">
                                        <img src="{{ asset('zodiac_image/eye.png') }}" alt="eye.png">
                                    </strong>
                                    <span class="ms-1">{{$viewsCount}}</span>
                                </div>
                            @endif
                        </div>
                            
                        <!-- Right Section: Likes Container -->

                        {{-- @if ($BlogLikes->isNotEmpty() && UserAuth::isLogin())
                           
                                @if ($blog->user_id == UserAuth::getLoginId())
                                    <div class="likes-container d-flex align-items-center">
                                @else
                                    <div class="likes-container d-flex align-items-center">
                                @endif

                                        <div class="likes-info me-2">
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

                                        <div class="like-section">
                                        @if ($blog->user_id == UserAuth::getLoginId())
                                            <button type="button" class="like-button" id="toggleLikes" data-user-id="{{ $userId }}" data-blog-id="{{ $like->blog_id }}" data-blog-user-id="{{ $blog->user_id }}" data-type="Real Estate" data-cate-id="4" data-url={{ route('real_esate_post', $blog->slug) }}>
                                        @else
                                            <button type="button" class="like-button" id="toggleLikes" data-user-id="{{ UserAuth::getLoginId() }}" data-blog-id="{{ $blog->id }}" data-blog-user-id="{{ $blog->user_id }}" data-type="Real Estate" data-cate-id="4" data-url={{ route('real_esate_post', $blog->slug) }} style="padding: 6px 8px !important; width: auto !important; margin: 0 !important;">
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

                                @elseif ($blog->user_id == UserAuth::getLoginId())
                                    @if(UserAuth::isLogin())
                                        <div class="likes-container d-flex align-items-center">
                                            <div class="likes-info">
                                                <b>Likes: </b>
                                                <span class="likes-preview">no likes</span>
                                            </div>
                                            <div class="">
                                                <button type="button" class="like-button" id="toggleLikes" data-user-id="{{ UserAuth::getLoginId() }}" data-blog-id="{{ $blog->id }}" data-blog-user-id="{{ $blog->user_id }}" data-type="Real Estate" data-cate-id="4" data-url={{ route('real_esate_post', $blog->slug) }}>
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
            
                                    @else 
                                        @if(UserAuth::isLogin())
                                            <div class="likes-container d-flex align-items-center">
                                                <div class="">
                                                    <button type="button" class="like-button" id="toggleLikes" data-user-id="{{ UserAuth::getLoginId() }}" data-blog-id="{{ $blog->id }}" data-blog-user-id="{{ $blog->user_id }}" data-type="Real Estate" data-cate-id="4" data-url={{ route('real_esate_post', $blog->slug) }}>
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
                        </div>
                    </div>
                </div>
                <div class="bg-white job-detail estate-description-data pt-4 p-3">
                    @if(!empty( $blog->description))
                    <h4>Description</h4>
                    <div calss="contentArea">
                    <?php
                        $processedText = Setting::makeLinksClickable($blog->description);
                    ?>
                    <p>{!! $processedText !!}</p>
                    </div><Br>
                    @endif
                    <?php
                    $givenTime = strtotime($blog->created);
                    $currentTimestamp = time();
                    $timeDifference = $currentTimestamp - $givenTime;

                    $days = floor($timeDifference / (60 * 60 * 24));
                    $hours = floor(($timeDifference % (60 * 60 * 24)) / (60 * 60));
                    $minutes = floor(($timeDifference % (60 * 60)) / 60);
                    $seconds = $timeDifference % 60;

                    $timeAgo = "";
                        if ($days > 0) {
                            $timeAgo = Setting::get_formeted_time($days);
                        }else{
                            $timeAgo = "Posted today"; 
                        }
                        echo $timeAgo;
                    ?>



                    @if($blog->personal_detail == 'true')
                        <div class="Job-right-sidebar bg-white">
                            <div class="row">
                                @if($blog->phone)
                                <div class="col-lg-4 col-md-12 col-sm-12 col-12 job-number">
                                    <h6><i class="bi bi-telephone"></i> Phone </h6><span><a href="tel:{{$blog->phone}}" target="_blank;">{{$blog->phone}}</a></span>
                                </div>
                                @endif
                                @if($blog->email)
                                <div class="col-lg-4 col-md-12 col-sm-12 col-12 job-email">
                                    <h6><i class="bi bi-envelope"></i> Email </h6><span><a href="mailto:{{$blog->email}}" target="_blank;">{{$blog->email}}</a></span>
                                </div>
                                @endif
                                @if($blog->website)
                                    <div class="col-lg-4 col-md-12 col-sm-12 col-12 job-website">
                                        <h6><i class="bi bi-globe2"></i> Website </h6><span><a href="{{$blog->website}}">{{$blog->website}}</a></span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @else
                        @if(UserAuth::isLogin())
                        <div class="Job-right-sidebar bg-white">
                            <div class="row">
                                @if($blog->phone)
                                <div class="col-lg-4 col-md-12 col-sm-12 col-12 job-number">
                                    <h6><i class="bi bi-telephone"></i> Phone </h6><span><a href="tel:{{$blog->phone}}" target="_blank;">{{$blog->phone}}</a></span>
                                </div>
                                @endif
                                @if($blog->email)
                                <div class="col-lg-4 col-md-12 col-sm-12 col-12 job-email">
                                    <h6><i class="bi bi-envelope"></i> Email </h6><span><a href="mailto:{{$blog->email}}" target="_blank;">{{$blog->email}}</a></span>
                                </div>
                                @endif
                                @if($blog->website)
                                <div class="col-lg-4 col-md-12 col-sm-12 col-12 job-website">
                                    <h6><i class="bi bi-globe2"></i> Website </h6><span><a href="{{$blog->website}}">{{$blog->website}}</a></span>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endif
                    @endif
                </div>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="home-details bg-white p-4">
                    <div class="col-12">
                        <div class="job-type job-hp ">
                            <?php
                                    $userId = $user->id;
                                    $email = $user->email;
                                    $phone_number = $user->phonenumber;
                                    $website = $user->website;
                                    $facebook = $user->facebook;
                                    $instagram = $user->instagram;
                                    $linkedin = $user->linkedin;
                                    $whatsapp = $user->whatsapp;
                                    $youtube = $user->youtube;
                                    $Tiktok = $user->Tiktok;
                                ?>
                                    <a target="blank" href="{{route('UserProfileFrontend', $user->slug)}}" class="apply">Posted by : {{$user->firstname}}</a>
                            
                        </div>
                    </div>
                    <div class="price">
                        <h1 style="font-size: 29px;">{{$blog->title}}</h1>
                    </div>
                    <div class="additional-info">
                        <div class="row">
                            <hr>
                            <div class="col-12">
                                @if(!empty($blog->area_sq_ft))
                                <p><b>Area sq. ft. :</b> {{$blog->area_sq_ft}}</p>
                                @endif
                                @if(!empty($blog->year_built))
                                <p><b>Built Year :</b> {{$blog->year_built}}</p>
                                @endif
                                @if(!empty($blog->price))
                                <p><b>Sale price :</b> ${{ number_format($blog->price, 2) }}</p>
                                @endif
                            </div>
                            <div class="col-12">
                                 @if(!empty($blog->units))
                                <p><b>Units :</b> {{$blog->units}}</p>
                                @endif
                                @if(!empty($blog->bedroom))
                                <p><b>Bedroom :</b> {{$blog->bedroom}}</p>
                                @endif
                                @if(!empty($blog->bathroom))
                                <p><b>Bathroom :</b> {{$blog->bathroom}}</p>
                                @endif
                                 @if(!empty($blog->grage))
                                <p><b>Garage :</b> {{$blog->grage}}</p>
                                @endif
                            </div>
                            <div class="col-12">
                                @if(!empty($blog->property_address))
                                <p><b>Property address :</b> {{$blog->property_address}}</p>
                                @endif
                                @if(!empty($blog->post_choices))
                                <p><b>Features :</b> {{ str_replace(['[', ']', '"'], '', $blog->post_choices)    }}</p>
                                @endif
                            </div>

                            @if($blog->post_by =='user')

                            <div class="col-12">
                                <?php
                                $userId = $user->id;
                                $phone_number = $user->phonenumber;
                                $email = $user->email;
                                $website = $user->website;
                                $facebook = $user->facebook;
                                $instagram = $user->instagram;
                                $linkedin = $user->linkedin;
                                $whatsapp = $user->whatsapp;
                                $youtube = $user->youtube;
                                $Tiktok = $user->Tiktok;
                                ?>
                                <p><b>Posted By:</b> 
                                    @if(UserAuth::isLogin())
                                    <a target="blank" href="{{route('UserProfileFrontend', $userSlug->slug)}}"> {{$user->first_name}} </a>
                                    @elseif(AdminAuth::isLogin())
                                    <a target="blank" href="{{route('UserProfileFrontend.admin', $userSlug->slug)}}"> {{$user->first_name}} </a>
                                    @else
                                    <a target="blank" href="{{route('auth.signupuser')}}" onclick="showAlertForSave()"> {{$user->first_name}} </a>
                                    @endif
                                </p>
                            </div>
                     
                            @endif

                            <!-- <div class="shareComponent">
                                <h6>Share to:</h6>
                                {!! $shareComponent !!}
                            </div> -->
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
                                    <button type="button" class="like-button" id="toggleLikes" data-user-id="{{ $userId }}" data-blog-id="{{ $like->blog_id }}" data-blog-user-id="{{ $blog->user_id }}" data-type="Real Estate" data-cate-id="4" data-url={{ route('real_esate_post', $blog->slug) }}>
                                    @else
                                    <button type="button" class="like-button" id="toggleLikes" data-user-id="{{ UserAuth::getLoginId() }}" data-blog-id="{{ $blog->id }}" data-blog-user-id="{{ $blog->user_id }}" data-type="Real Estate" data-cate-id="4" data-url={{ route('real_esate_post', $blog->slug) }} style="padding: 6px 8px !important; width: auto !important; margin: 0 !important;">
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
                                            <button type="button" class="like-button" id="toggleLikes" data-user-id="{{ UserAuth::getLoginId() }}" data-blog-id="{{ $blog->id }}" data-blog-user-id="{{ $blog->user_id }}" data-type="Real Estate" data-cate-id="4" data-url={{ route('real_esate_post', $blog->slug) }}>
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
                                    <a data-postid="{{ $blog->id }}" data-type="Real Estate" data-Userid="{{ UserAuth::getLoginId() }}"
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
                                                <input type="text" class="text" value="{{url('/real_esate-post')}}/{{$blog->slug}}" id="field_input"/>
                                                <a href="javascript:void(0);" redirect-url="{{url('/chatify')}}/{{$user->id}}" copy-url="{{url('/real_esate-post')}}/{{$blog->slug}}" class="copy_url btn create-post-button ms-2" data-placement="top" data-toggle="tooltip" title="Share">
                                                    <i class="fa fa-clone"></i>
                                                </a>
                                            </div>
                                          <hr>
                                            <div class="copy-text">
                                            <input type="text" class="text" value="Share link via email" readonly id="email_input"/>
                                            <a href="mailto:{{$user_all_data->email }}?subject={{$blog->title}}&body=Page link : {{url('/real_esate-post')}}/{{$blog->slug}}" class="btn create-post-button ms-2" data-placement="top" data-toggle="tooltip" title="Email">
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
                    </div>
                    <hr>
                    <div class="real-estate-description">
                        <div class="real-estate-location">
                            <div class="responsive-map">
                                <?php
                                $address = $blog->property_address; // Replace with your dynamic address variable
                                $encodedAddress = urlencode($address);
                                $embedUrl = "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2822.7806761080233!2d-93.29138368446431!3d44.96844997909819!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x52b32b6ee2c87c91%3A0xc20dff2748d2bd92!2sWalker+Art+Center!5e0!3m2!1sen!2sus!4v1514524647889";
                                $embedUrl .= "&q=" . $encodedAddress;
                                ?>
                                <iframe src="{{ $embedUrl }}" width="700" height="580" frameborder="0" style="border:0" allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</section>
<section class="related-real-state mb-4">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 pt-4">
                <h3 style="text-align:center;" class="mb-3">Related Post</h3>
            </div>
        </div>
        <div class="row related-job">
            @foreach($relatedPost as $Rrealestate)
            <div class="col-lg-2 col-md-3 col-sm-6 col-6">

                <div class="feature-box">


                    <a href="{{route('real_esate_post',$Rrealestate->slug)}}">
                        <div id="demo" class="carousel1 slide">

                            <!-- Indicators/dots -->

                            <!-- The slideshow/carousel -->
                            <div class="carousel-inner1">
                                <?php
                                $itemFeaturedImages = trim($Rrealestate->image1, '[""]');
                                $itemFeaturedImage  = explode('","', $itemFeaturedImages);
                                if (is_array($itemFeaturedImage)) {
                                    foreach ($itemFeaturedImage as $keyitemFeaturedImage => $valueitemFeaturedImage) {
                                        if ($keyitemFeaturedImage == 0) {
                                            $class = 'active';
                                        } else {
                                            $class = 'in-active';
                                        } ?>
                                        <div class="carousel-item <?= $class; ?>">
                                            <img src="{{asset('images_blog_img')}}/{{ $valueitemFeaturedImage }}" alt="Los Angeles" class="d-block w-100" onerror="this.onerror=null; this.src='https://www.finderspage.com/public/images_blog_img/1688636936.jpg';">
                                        </div>
                                <?php }
                                }
                                ?>



                            </div>
                        </div>
                        <p class="job-title">{{ ucfirst($Rrealestate->title) }}</p>

                        <div class="job-type">
                            <ul>
                                @if($Rrealestate->sale_price)
                                <li><span><i class="bi bi-cash"></i></span>${{$Rrealestate->sale_price}}</li>
                                @endif



                            </ul>
                        </div>
                        <div class="main-days-frame">
                            <span class="location-box">
                                
                            </span>

                            <span class="days-box">
                                <?php
                                $givenTime = strtotime($Rrealestate->created);
                                $currentTimestamp = time();
                                $timeDifference = $currentTimestamp - $givenTime;

                                $days = floor($timeDifference / (60 * 60 * 24));
                                $hours = floor(($timeDifference % (60 * 60 * 24)) / (60 * 60));
                                $minutes = floor(($timeDifference % (60 * 60)) / 60);
                                $seconds = $timeDifference % 60;

                                $timeAgo = "";
                                if ($days > 0) {
                                    $timeAgo = Setting::get_formeted_time($days);
                                } else {
                                    $timeAgo .= "Today";
                                }

                                // if ($minutes > 0) {
                                //     $timeAgo .= $minutes . " min, ";
                                // }
                                // $timeAgo .= $seconds . " sec ago";

                                echo $timeAgo;
                                ?>

                            </span>
                        </div>
                        <!-- <div class="review-section">
                            <p>Review</p>
                            <ul class="review">
                                <li><i class="bi bi-star-fill"></i></li>
                                <li><i class="bi bi-star-fill"></i></li>
                                <li><i class="bi bi-star-fill"></i></li>
                                <li><i class="bi bi-star-fill"></i></li>
                                <li><i class="bi bi-star-half"></i></li>
                            </ul>
                        </div> -->
                    </a>
                </div>

            </div>
            @endforeach
            <!--       <div class="col-md-6 col-lg-3">
                <div class="feature-box">
                   <img src="../new_assets/assets/images/home 2.jpg" class="img-fluid" alt="...">
                   <div class="price">
                     <span>₹ 3,50,000</span>
                   </div>
                     <p>The Property is in a Very Good Complex</p>
                   <div class="row">
                        <div class="loaction col-md-8">
                            <p>Vijaya Nagar Colony, Hyderabad</p>
                        </div>
                        <div class="date col-md-4">
                           <p>Today</p>
                        </div>
                        <div class="review-section">
                            <p>Review</p>
                            <ul class="review">
                                <li><i class="bi bi-star-fill"></i></li>
                                <li><i class="bi bi-star-fill"></i></li>
                                <li><i class="bi bi-star-fill"></i></li>
                                <li><i class="bi bi-star-fill"></i></li>
                                <li><i class="bi bi-star-half"></i></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="feature-box">
                   <img src="../new_assets/assets/images/home3.jpg" class="img-fluid" alt="...">
                   <div class="price">
                     <span>₹ 2,50,000</span>
                   </div>
                     <p>The Property is in a Very Good Complex</p>
                   <div class="row">
                        <div class="loaction col-md-8">
                            <p>Vijaya Nagar Colony, Hyderabad</p>
                        </div>
                        <div class="date col-md-4">
                           <p>Today</p>
                        </div>
                        <div class="review-section">
                            <p>Review</p>
                            <ul class="review">
                                <li><i class="bi bi-star-fill"></i></li>
                                <li><i class="bi bi-star-fill"></i></li>
                                <li><i class="bi bi-star-fill"></i></li>
                                <li><i class="bi bi-star-fill"></i></li>
                                <li><i class="bi bi-star-half"></i></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="feature-box">
                   <img src="../new_assets/assets/images/home.png" class="img-fluid" alt="...">
                   <div class="price">
                     <span>₹ 5,50,000</span>
                   </div>
                     <p>The Property is in a Very Good Complex</p>
                   <div class="row">
                        <div class="loaction col-md-8">
                            <p>Vijaya Nagar Colony, Hyderabad</p>
                        </div>
                        <div class="date col-md-4">
                           <p>Today</p>
                        </div>
                        <div class="review-section">
                            <p>Review</p>
                            <ul class="review">
                                <li><i class="bi bi-star-fill"></i></li>
                                <li><i class="bi bi-star-fill"></i></li>
                                <li><i class="bi bi-star-fill"></i></li>
                                <li><i class="bi bi-star-fill"></i></li>
                                <li><i class="bi bi-star-half"></i></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
    </div>
</section>
<!-------model apply job--------->
<div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Why are you reporting this post ?</h5>

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

<script type="text/javascript">
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
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
                window.location.href = "https://www.finderspage.com/login";
            }
        });

    }

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


</script>

@endsection