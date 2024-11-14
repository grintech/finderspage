<?php

use App\Models\Entertainment;
use App\Models\UserAuth; 
use App\Models\Setting;
use App\Models\Admin\AdminAuth; 
$user_all_data = UserAuth::getUser($Entertainment->user_id);
?>
@extends('layouts.frontlayout')
@section('content')

@php
    $user_id = $Entertainment->user_id;
    $userSlug = UserAuth::getUserSlug($user_id);


    $slug = request()->query('slug');

    if ($slug) {
        $EntValue = Entertainment::where('slug', $slug)->first();
        // dd($EntValue);
        if (!empty($EntValue)) {
            if ($EntValue->shares === null) {
                $EntValue->shares = 1;
            } else {
                $EntValue->shares += 1;
            }

            $EntValue->save();
        }
    }


    if ($Entertainment->slug) {
        $EntShares = Entertainment::where('slug', $Entertainment->slug)
            ->where('user_id', UserAuth::getLoginId())
            ->first();
    }

@endphp

<style type="text/css">
    a.copy_url.btn.create-post-button.ms-2 i {
        position: relative;
        left: 0;
    }

    div#social-links ul {
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
    }

    .disabled {
        pointer-events: none;
        /* Disable click events */
        opacity: 0.5;
        /* Apply a visual indication of disabled state */
        /* You can customize the styling further based on your needs */
    }
    .view_counts{
     z-index: 1;
     position: absolute;
     bottom: 2px;
    }
    @media only screen and (max-width:767px){
     .view_counts{position: initial !important;}
    }
    #demo .carousel-control-prev span {
        height: 25px !important;
        width:25px!important;
    }
    #demo .carousel-control-next span {
        height: 25px !important;
        width:25px!important;
    }
  /* .entertainment_listing-content{text-transform: capitalize;font-size: 30px;} */

  .copy-button{background: rgb(170, 137, 65);border: none;outline: none;border-radius: 5px;cursor: pointer;padding: 2px;
    background: linear-gradient(90deg, rgba(170, 137, 65, 1) 0%, rgba(205, 156, 49, 1) 13%, rgba(154, 128, 73, 1) 35%, rgba(246, 204, 78, 1) 51%, rgba(181, 147, 56, 1) 75%, rgba(163, 136, 68, 1) 100%);}

    ul.entertainment_sidebar-overview-new i {
        position: relative !important;
        left: 0 !important;
    }

    .carousel-control-next, .carousel-control-prev{display: none !important;}
    ul.entertainment_sidebar-overview-new li {left: 0px !important;}
    .entertainment_sidebar-overview-new button.btn.create-post-button.ms-2 {
        padding: 10px 20px !important;}

    /*.reactions-emojis {
        position: absolute;
        top: 45px;
    }*/
    i.fa-regular.fa-bookmark::before {
        font-size: 13px !important;
    }
</style>
<?php
$itemFeaturedImage  = explode(',', $Entertainment->image);
$count = count($itemFeaturedImage);
?>
<section class="entertainment-post">
    <div class="container">
        <div class="row">
            <span>
                @include('admin.partials.flash_messages')
            </span>
            <div class="col-lg-12 prev-next-arrows">
                <!-- <div class="left-arrow">
                @if($previousPostId != null)
                    <a  href="{{route('Entertainment.single.listing',$previousPostId)}}"><i class="bi bi-arrow-left"></i> <span>Prev</span></a>
                    @endif 
                </div>
                <div class="right-arrow1">
                    @if($nextPostId != null)
                    <a href="{{route('Entertainment.single.listing',$nextPostId)}}"><span>Next</span> <i class="bi bi-arrow-right"></i></a>
                    @endif
                </div> -->

                <div class="left-arrow">
                    <a href="@if($nextPostId != null){{route('Entertainment.single.listing',$nextPostId)}} @else # @endif" class="{{ $nextPostId == null ? 'disabled' : '' }}"><i class="bi bi-arrow-left"></i> <span>Prev</span></a>

                </div>
                <div class="right-arrow1">
                    <a href="@if($previousPostId != null){{route('Entertainment.single.listing',$previousPostId)}} @else # @endif" class="{{ $previousPostId == null ? 'disabled' : '' }}"><span>Next</span> <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-lg-8 col-md-8 mb-4 mb-lg-0">
                <div class="bg-white p-3">
                    <div class="row">
                        <div class="col-lg-3 col-md-3">
                            <div class="job-post-imges position-relative">
                                @if(Setting::get_setting("no_of_views", $Entertainment->user_id) == 1 || $Entertainment->user_id == UserAuth::getLoginId())
                                    <div class="view_counts d-flex align-items-center ms-2">
                                        <strong class="zodiac_img">
                                            <img src="{{ asset('zodiac_image/eye.png') }}" alt="eye.png">
                                        </strong>
                                        <span class="ms-1">{{$viewsCount}}</span>
                                    </div>
                                @endif
                                <div id="demo" class="carousel slide" data-bs-ride="carousel">
                                    <!-- Indicators/dots -->

                                    <!-- The slideshow/carousel -->
                                    <div class="carousel-inner">

                                        <?php
                                        if (is_array($itemFeaturedImage)) {
                                            foreach ($itemFeaturedImage as $keyitemFeaturedImage => $valueitemFeaturedImage) {
                                                if ($keyitemFeaturedImage == 0) {
                                                    $class = 'active';
                                                } else {
                                                    $class = 'in-active';
                                                } ?>
                                                <div class="carousel-item <?= $class; ?>">
                                                    <a href="{{asset('images_entrtainment')}}/{{ $valueitemFeaturedImage }}" data-lightbox="carousel">
                                                        <img src="{{asset('images_entrtainment')}}/{{ $valueitemFeaturedImage }}" alt="{{ $Entertainment->Title }}" class="d-block w-100">
                                                    </a>
                                                </div>
                                        <?php }
                                        }
                                        ?>

                                        @if($Entertainment->video)
                                        <div class="carousel-item">
                                            <a href="{{asset('images_entrtainment')}}/{{$Entertainment->video}}" data-lightbox="carousel">
                                                <video width="320" height="240" controls class="d-block w-100">
                                                    <source src="{{asset('images_entrtainment')}}/{{$Entertainment->video}}" type="video/mp4">
                                                </video>
                                            </a>
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
                                <div class="lightbox-overlay">
                                    <img class="lightbox-img" src="" alt="">
                                </div>
                                <div class="job-type job-p mt-1" style="display:none;">
                                    <img src="https://finder.harjassinfotech.org/public/assets/images/profile/1693808442.jpg" alt="Image">
                                    <p><br><small>By steven smith</small></p>
                                    <!-- <img src="https://finder.harjassinfotech.org/public/assets/images/profile/1687521756.png" alt="">
                            <p>Test Serivce <br> <small>By Manit</small></p> -->
                                </div>
                                <!-- <img src="./new_assets/assets/images/business.png" class="w-100 h-100" alt="..."> -->
                            </div>
                        </div>

                        <div class="col-md-9">
                            <div class="col-12">
                                <div class="entertainment_listing-content mt-3">
                                    <h1>{{$Entertainment->Title}}</h1>
                                    <div class="entertainment_listingg">
                                        <hr>
                                        <div class="row">
                                            <div class="col-lg-4 col-md-6 col-6" style="border-right: 1px solid #c6c7c8;"><b style="font-size: 12px;">Created by : </b>
                                                @if(UserAuth::isLogin())
                                                <a target="blank" href="{{route('UserProfileFrontend', $userSlug->slug)}}" style="font-size: 12px;"> {{$user->first_name}}</a>
                                                @elseif(AdminAuth::isLogin())
                                                <a target="blank" href="{{route('UserProfileFrontend.admin', $userSlug->slug)}}" style="font-size: 12px;"> {{$user->first_name}} </a>
                                                @else
                                                <a target="blank" href="{{route('auth.signupuser')}}" onclick="showAlertForSave()" style="font-size: 12px;"> {{$user->first_name}}</a>
                                                @endif

                                                <!-- <a href="https://finder.harjassinfotech.org/public/user/2132"> {{$user->first_name}} </a> -->
                                            </div>
                                            <div class="col-lg-3 col-md-6 col-6" style="border-right: 1px solid #c6c7c8;"><b style="font-size: 12px;">Posted: </b>
                                                <span style="font-size: 12px;">
                                                @php
                                                    $givenTime = strtotime($Entertainment->created_at);
                                                    $currentTimestamp = time();
                                                    $timeDifference = $currentTimestamp - $givenTime;
                                                    $days = floor($timeDifference / (60 * 60 * 24));
                                                    $hours = floor(($timeDifference % (60 * 60 * 24)) / (60 * 60));
                                                    $minutes = floor(($timeDifference % (60 * 60)) / 60);
                                                    $seconds = $timeDifference % 60;
                                                    $timeAgo = "";
                                                    if ($days > 0) {
                                                        if ( $days == 1 ) {
                                                            $timeAgo .= $days . " day ago ";
                                                        } else {
                                                            $timeAgo .= $days . " days ago ";
                                                        }
                                                    }else{
                                                        $timeAgo .= "Today";
                                                    }
                                                    echo $timeAgo;
                                                @endphp
                                                </span>
                                            </div>

                                            <div class="col-lg-3 col-md-6 col-6">
                                                <div class="entertainment_listing_view">
                                                <!-- <div class="job-post-apply"> -->
                                                    <a style="font-size: 12px;" class="apply text-center" href="" data-bs-toggle="modal" data-bs-target="#exampleModal">Apply</a>
                                                <!-- </div> -->
                                                </div>
                                            </div>

                                            {{-- @if ($BlogLikes->isNotEmpty() && UserAuth::isLogin())
                                               
                                            <div class="col-lg-2 col-md-2 col-2 single-top-apply">
                                                <div class="entertainment_listing_view">
                                                @if ($Entertainment->user_id == UserAuth::getLoginId())
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
                                                            {{-- @if ($Entertainment->user_id == UserAuth::getLoginId())
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
                                                        @if ($Entertainment->user_id == UserAuth::getLoginId())
                                                            <button type="button" class="like-button" id="toggleLikes" data-user-id="{{ $userId }}" data-blog-id="{{ $like->blog_id }}" data-blog-user-id="{{ $Entertainment->user_id }}" data-type="Entertainment" data-cate-id="741" data-url={{ route('Entertainment.single.listing', $Entertainment->slug) }}>
                                                        @else
                                                            <button type="button" class="like-button" id="toggleLikes" data-user-id="{{ UserAuth::getLoginId() }}" data-blog-id="{{ $Entertainment->id }}" data-blog-user-id="{{ $Entertainment->user_id }}" data-type="Entertainment" data-cate-id="741" data-url={{ route('Entertainment.single.listing', $Entertainment->slug) }} style="padding: 6px 8px !important; width: auto !important; margin: 0 !important;">
                                                        @endif
                                                                @if ($userLiked && $likedBy[$userId] == 1)
                                                                    <img src="{{ asset('images/heart-icon.png') }}" id="1" class="rxn-emoji" alt="emoji-icon" style="width: 23px; height: 23px;">
                                                                @elseif ($userLiked && $likedBy[$userId] == 2)
                                                                    <img src="{{ asset('images/thumb-icon.png') }}" id="2" class="rxn-emoji" alt="emoji-icon" style="width: 23px; height: 23px;">
                                                                @else
                                                                    <i class="fa-regular fa-thumbs-up emoji"></i>
                                                                @endif
        
                                                                @if ($Entertainment->user_id == UserAuth::getLoginId())
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
                                           
                                            @elseif ($Entertainment->user_id == UserAuth::getLoginId())
                                                <div class="col-lg-2 col-md-2 col-2 single-top-apply">
                                                    <div class="entertainment_listing_view">
                                                        @if(UserAuth::isLogin())
                                                            <div class="likes-container">
                                                                <div class="likes-info">
                                                                    <b>Likes: </b>
                                                                    <span class="likes-preview">no likes</span>
                                                                </div>
                                                                <div class="">
                                                                    <button type="button" class="like-button" id="toggleLikes" data-user-id="{{ UserAuth::getLoginId() }}" data-blog-id="{{ $Entertainment->id }}" data-blog-user-id="{{ $Entertainment->user_id }}" data-type="Entertainment" data-cate-id="741" data-url={{ route('Entertainment.single.listing', $Entertainment->slug) }}>
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
                                                <div class="col-lg-2 col-md-2 col-2 single-top-apply">
                                                    <div class="entertainment_listing_view">
                                                        @if(UserAuth::isLogin())
                                                            <div class="likes-container">
                                                                <div class="">
                                                                    <button type="button" class="like-button" id="toggleLikes" data-user-id="{{ UserAuth::getLoginId() }}" data-blog-id="{{ $Entertainment->id }}" data-blog-user-id="{{ $Entertainment->user_id }}" data-type="Entertainment" data-cate-id="741" data-url={{ route('Entertainment.single.listing', $Entertainment->slug) }}>
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

                                        </div>
                                    </div>
                                    <div class="entertainment_listing-type">
                                        <!-- <ul>
                                    <li>Full Time</li>
                                    <li>Private </li>
                                    <li>Urgent</li>
                                </ul> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if(!empty($Entertainment->description))
                <div class="job-detail entertainment_listing-detail bg-white p-3 mt-3">
                    <h4>Description</h4>
                    <div calss="contentArea">
                    <?php
                        $processedText = Setting::makeLinksClickable($Entertainment->description);
                    ?>
                       <p>{!! $processedText !!}</p>
                    </div>
                </div>
                @endif
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="entertainment_sidebar bg-white p-3">
                    <div class="entertainment_sidebar-overview">
                        <h4>Overview</h4>
                        <ul class="entertainment_sidebar-overview-new ">
                            {{-- <li><i class="bi bi-calendar-check"></i><h6>Date Posted:</h6><span>
                            @php
                            $givenTime = strtotime($Entertainment->created_at);
                            $currentTimestamp = time();
                            $timeDifference = $currentTimestamp - $givenTime;
                            $days = floor($timeDifference / (60 * 60 * 24));
                            $hours = floor(($timeDifference % (60 * 60 * 24)) / (60 * 60));
                            $minutes = floor(($timeDifference % (60 * 60)) / 60);
                            $seconds = $timeDifference % 60;
                            $timeAgo = "";
                            if ($days > 0) {
                                if ( $days == 1 ) {
                                    $timeAgo .= $days . " day ago ";
                                } else {
                                    $timeAgo .= $days . " days ago ";
                                }
                            }else{
                               $timeAgo .= "Today"; 
                            }
                            echo $timeAgo;
                            @endphp</span></li> --}}



                            {{-- <li><i class="bi bi-geo-alt"></i> <h6>Location:</h6><span>
                            </span></li>
                            <li><i class="bi bi-people"></i> <h6>Title:</h6><span>{{$Entertainment->Title}}</span></li>
                            @if($Entertainment->paying =='Paying')
                            <li><i class="bi bi-cash"></i><h6>Paying</h6><span>${{$Entertainment->amount}}</span></li>
                            @elseif($Entertainment->paying =='Non-Paying')
                            <li><i class="bi bi-cash"></i><h6>Non-Paying</h6><span>{{$Entertainment->publish_date}}</span></li>
                            @endif
                            <li><i class="bi bi-camera"></i><h6>Director</h6><span>{{$Entertainment->director}}</span></li>

                            <li><i class="bi bi-person"></i><h6>Producer</h6><span>{{$Entertainment->producer}}</span></li> --}}


                            @if(!empty($Entertainment->casting_director))
                            <li class="d-flex align-items-start" >
                                <i class="bi bi-camera-reels-fill me-2"></i>
                                <div class="d-flex align-items-center flex-wrap">
                                 <h6 class="me-2"><b>Casting Director :</b></h6>
                                 <span>{{$Entertainment->casting_director}}</span>
                                </div>
                            </li>
                            @endif

                             @if(!empty($Entertainment->email))
                            <li  class="d-flex align-items-start">
                                <i class="bi bi-envelope-fill me-2"></i>
                                <div class="d-flex align-items-center flex-wrap">
                                 <h6 class="me-2"><b>Email :</b></h6>
                                 <span><a href="mailto:{{$Entertainment->email}}"
                                    target="_blank;">{{$Entertainment->email}}</a></span>
                                </div>
                            </li>
                            @endif

                            @if(!empty($Entertainment->phone_no))
                            <li  class="d-flex align-items-start">
                                <i class="bi bi-telephone-fill me-2"></i>
                                <div class="d-flex align-items-center flex-wrap">
                                 <h6 class="me-2"><b>Phone no :</b></h6>
                                 <span><a href="tel:{{$Entertainment->phone_no}}"
                                    target="_blank;">{{$Entertainment->phone_no}}</a></span>
                                </div>
                            </li>
                           
                            @endif

                            @if(!empty($Entertainment->website))
                            @php
                                $url = $Entertainment->website;
                                
                                // Parse the URL to get the base URL
                                $parsedUrl = parse_url($url);
                                $baseUrl = isset($parsedUrl['scheme']) ? "{$parsedUrl['scheme']}://" : '';
                                $baseUrl .= isset($parsedUrl['host']) ? $parsedUrl['host'] : '';
                                $baseUrl .= isset($parsedUrl['path']) ? $parsedUrl['path'] : '';
                            
                                // Check for trailing slash
                                if (substr($baseUrl, -1) !== '/') {
                                    $baseUrl .= '/';
                                }
                                
                                $afterSlash = isset(parse_url($url)['path']) ? parse_url($url)['path'] : '';
                            @endphp
                            <li  class="d-flex align-items-start">
                                <i class="bi bi-globe me-2"></i>
                                <div class="d-flex align-items-center flex-wrap">
                                 <h6 class="me-2"><b>Website :</b></h6>
                                 <span>
                                    <a href="{{$Entertainment->website}}" target="_blank">
                                        {{ $baseUrl }}...
                                    </a>
                                </span>
                                </div>
                            </li>
                           
                            @endif

                            @if(!empty($Entertainment->gender))
                            <li class="d-flex align-items-start">
                                <i class="fa fa-child me-2" aria-hidden="true"></i>

                               <div class="d-flex align-items-center flex-wrap">
                               <h6 class="me-2"><b>{{ $Entertainment->gender }} Age :</b></h6>
                                <span>
                                    @if ($Entertainment->gender == "Male")
                                        {{ $Entertainment->male_age_range }}
                                    @else 
                                    {{ $Entertainment->female_age_range }}
                                    @endif
                                </span>
                               </div>
                            </li>
                            @endif

                            @if(!empty($Entertainment->links))
                            @php
                                $url = $Entertainment->links;
                                
                                // Parse the URL to get the base URL
                                $parsedUrl = parse_url($url);
                                $baseUrl = isset($parsedUrl['scheme']) ? "{$parsedUrl['scheme']}://" : '';
                                $baseUrl .= isset($parsedUrl['host']) ? $parsedUrl['host'] : '';
                                $baseUrl .= isset($parsedUrl['path']) ? $parsedUrl['path'] : '';
                            
                                // Check for trailing slash
                                if (substr($baseUrl, -1) !== '/') {
                                    $baseUrl .= '/';
                                }
                                
                                $afterSlash = isset(parse_url($url)['path']) ? parse_url($url)['path'] : '';
                            @endphp
                            <li class="d-flex align-items-start">
                                <i class="bi bi-camera-reels-fill me-2"></i>
                                <div class="align-items-center flex-wrap">
                                 <h6 class="me-2"><b>Portfolio/Social Links :</b></h6>
                                 <span class="text-truncate d-inline-block">
                                    <a href="{{ $Entertainment->links }}" target="_blank">
                                        {{ $baseUrl }}...
                                    </a>
                                </span>
                                </div>
                            </li>
                            @endif


                            <li class="shareComponent">
                            <!-- <li>
                                <i class="fal fa-share"></i>
                                <h6>Share to:</h6>
                            </li>
                            {!! $shareComponent !!}
                            </li> -->

                            <li>
                                <div class="entertainment_sidebar-post-apply single-entertainment_sidebar-apply flex-wrap gap-2">
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
                                            @if ($Entertainment->user_id == UserAuth::getLoginId())
                                            <button type="button" class="like-button" id="toggleLikes" data-user-id="{{ $userId }}" data-blog-id="{{ $like->blog_id }}" data-blog-user-id="{{ $Entertainment->user_id }}" data-type="Entertainment" data-cate-id="741" data-url={{ route('Entertainment.single.listing', $Entertainment->slug) }}>
                                            @else
                                            <button type="button" class="like-button" id="toggleLikes" data-user-id="{{ UserAuth::getLoginId() }}" data-blog-id="{{ $Entertainment->id }}" data-blog-user-id="{{ $Entertainment->user_id }}" data-type="Entertainment" data-cate-id="741" data-url={{ route('Entertainment.single.listing', $Entertainment->slug) }} style="padding: 6px 8px !important; width: auto !important; margin: 0 !important;">
                                            @endif
                                                @if ($userLiked && $likedBy[$userId] == 1)
                                                    <img src="{{ asset('images/heart-icon.png') }}" id="1" class="rxn-emoji" alt="emoji-icon" style="width: 23px; height: 23px;">
                                                @elseif ($userLiked && $likedBy[$userId] == 2)
                                                    <img src="{{ asset('images/thumb-icon.png') }}" id="2" class="rxn-emoji" alt="emoji-icon" style="width: 23px; height: 23px;">
                                                @else
                                                    <i class="fa-regular fa-thumbs-up emoji"></i>
                                                @endif
                                            </button>
                                            
                                            @if ($Entertainment->user_id == UserAuth::getLoginId())
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
                                                    <button type="button" class="like-button" id="toggleLikes" data-user-id="{{ UserAuth::getLoginId() }}" data-blog-id="{{ $Entertainment->id }}" data-blog-user-id="{{ $Entertainment->user_id }}" data-type="Entertainment" data-cate-id="741" data-url={{ route('Entertainment.single.listing', $Entertainment->slug) }}>
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
                                            $setting_sharebtn = Setting::get_setting('share_btn', $Entertainment->user_id);
                                        @endphp
                                    
                                        @if($setting_sharebtn == 'show' || $setting_sharebtn == '')
                                            <div class="d-flex align-items-center">
                                                <button type="button" class="btn create-post-button" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                                    <i class="fa-regular fa-paper-plane"></i>
                                                </button>
                                                <span class="ms-2">{{ $EntShares->shares ?? '' }}</span>
                                            </div>
                                        @endif
                                    
                                        <div class="d-flex align-items-center">
                                            <a data-postid="{{ $Entertainment->id }}" data-type="Entertainment" data-Userid="{{ UserAuth::getLoginId() }}"
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
                                                <input type="text" class="text" value="{{url('/Entertainment/single/listing')}}/{{$Entertainment->slug}}" id="field_input"/>
                                                <a href="javascript:void(0);" redirect-url="{{url('/chatify')}}/{{UserAuth::getLoginId()}}" copy-url="{{url('/Entertainment/single/listing')}}/{{$Entertainment->slug}}" class="copy_url btn create-post-button ms-2 mb-2 new-share-btn" data-placement="top" data-toggle="tooltip" title="Copy">
                                                    <i class="fa fa-clone"></i>
                                                </a>
                                              </div>
                                              <hr>
                                              <div class="copy-text">
                                                <input type="text" class="text" value="Share link via email" readonly id="email_input"/>
                                                <a href="mailto:{{$user_all_data->email }}?subject={{$Entertainment->title}}&body=Page link : {{url('/Entertainment/single/listing')}}/{{$Entertainment->slug}}" class="btn create-post-button ms-2" data-placement="top" data-toggle="tooltip" title="Email">
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
                                
                            </li>

                        </ul>
                    </div>
                    <div class="entertainment_sidebar-locatin">
                        <h4>Location</h4>
                        <div class="responsive-map">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2822.7806761080233!2d-93.29138368446431!3d44.96844997909819!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x52b32b6ee2c87c91%3A0xc20dff2748d2bd92!2sWalker+Art+Center!5e0!3m2!1sen!2sus!4v1514524647889" width="600" height="450" frameborder="0" style="border:0" allowfullscreen=""></iframe>
                        </div>
                    </div>
                    <!--  <div class="job-skill">
                    <h5>Serivce Skills</h5>
                    <a href="">app</a><a href="">administrative</a><a href="">android</a>
                </div> -->
                </div>
            </div>

        </div>
    </div>
</section>
<!-------model apply job--------->
<div class="modal fade job_apply_modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Apply Now!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body ">
                <form id="job-apply" class="row" action="{{route('apply.job')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="job_id" value="{{$Entertainment->id}}">
                    <input type="hidden" name="type" value="entertainment">
                    <div class="col-lg-6">
                        <div class="field">
                            <div class="control has-icons-left">
                                <input type="text" name="first_name" id="Name" class="input" placeholder="First Name">
                                <span class="icon is-left">
                                    <i class="fa fa-user"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="field">
                            <div class="control has-icons-left">
                                <input type="text" name="last_name" id="Name" class="input" placeholder="Last Name">
                                <span class="icon is-left">
                                    <i class="fa fa-user"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="field">
                            <div class="control has-icons-left">
                                <input type="email" name="email" id="email" class="input" placeholder="Email">
                                <span class="icon is-left">
                                    <i class="fa fa-envelope"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="field">
                            <div class="control has-icons-left">
                                <input type="tel" name="phone_no" id="email" class="input" placeholder="Phone Number">
                                <span class="icon is-left">
                                    <i class="bi bi-telephone-fill"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 mb-2">
                        <div class="field job-input">
                            <div class="control has-icons-left">
                               
                                <div class="col-lg-12">
                                    <lable>Images</lable><span class="info-text" style="font-size:10px">(Choose multiple images)</span>
                                    <input id="file-image"  type="file" multiple name="image[]" placeholder="&#8683; Upload Image" accept='.jpg,.jpeg,.png,.gif' />
                                    
                                </div>
                                <div class="col-lg-12">
                                <lable>Video</lable>
                                    <input id="file-video" type="file" name="video" placeholder="&#8683; Upload video" accept='video/mp4,video/x-m4v,video/*' />
                                </div>
                                <div class="col-lg-12">
                                <lable>Resume</lable>
                                    <input id="file-name" type="file" name="file" placeholder="&#8683; Upload Resume" accept='.pdf,.doc,.docx' />
                                </div>     
                        
                            </div>
                        </div>
                        
                    </div>

                    <div class="col-lg-12 mb-3 mt-1">
                        <div class="field job-input">
                            <div class="control has-icons-left">
                                {{-- <label for="coverLetter">
                                <i class="fas fa-envelope"></i> Cover Letter
                                </label> --}}
                                <textarea name="cover_letter" cols="" rows="" placeholder="&#9993; Cover Letter"></textarea>
                            </div>
                        </div>
                        
                    </div>
                   
                    <div class="modal-footer d-flex justify-content-center">
                        <button type="submit" class="contact-from-button">Submit</button>
                    </div>

                    @if($Entertainment->website)
                    <span class="text-center h5">Or</span>
                    <span class="text-center h6">Apply direct with website link</span>
                    <span class="text-center">
                        <a class="apply-btn" href="{{$Entertainment->website}}" target="_blank">{{$Entertainment->website}}</a>
                    </span>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
<script>
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
            text: "You have to login first to see member profile",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Go to login"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = window.appUrl + "login";
            }
        });
    }
    function updateFileType(input) {
    switch (input.name) {
        case 'resume':
            input.setAttribute('accept', '.pdf,.doc,.docx');
            break;
        case 'video':
            input.setAttribute('accept', 'video/mp4,video/x-m4v,video/*');
            break;
        case 'image':
            input.setAttribute('accept', '.jpg,.jpeg,.png,.gif');
            break;
        default:
            input.removeAttribute('accept'); // No specific restriction
    }
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

    $(document).ready(function() {
        // Select the likes count element
        var likesCount = $('.likes-count');

        // Check if the likes count is 0
        if (likesCount.text().trim() === '0') {
            // Hide the likes count element
            likesCount.hide();
        }
    });
</script>

@endsection