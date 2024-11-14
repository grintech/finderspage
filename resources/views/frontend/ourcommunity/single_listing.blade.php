<?php
use App\Models\UserAuth; 
use App\Models\Setting;
use App\Models\Blogs;
$user_all_data = UserAuth::getUser($blog->user_id);

$setting_like_option = Setting::get_setting('likes',$blog->user_id);
?>
@extends('layouts.frontlayout')
@section('content')

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

<style>
    a.copy_url.btn.create-post-button.ms-2 i {
        position: relative;
        left: 0;
    }

    /*div#social-links ul {
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

    .singel-post-by {
        font-size: 14px;
    }

    .singel-posted {
        font-size: 14px;
    }

    #job-post .job-type ul li {
        display: inline-flex;
        background-color: #fff;
        margin: 7px 0px;
        padding: 6px 7px;
        border-radius: 5px;
        color: #000;
        box-shadow: 0px 1px 7px #ddd;
        font-size: 12px;
        font-weight: 500;
    }

    #job-post .job-post-imges .carousel-item img {
        height: 190px;
    }

    #job-post .job-post-apply {
        display: block;
        justify-content: end;
        align-items: center;
        margin-top: 0;
    }

    #job-post .job-post-apply a.apply {
        background: rgb(170, 137, 65);
        background: linear-gradient(90deg, rgba(170, 137, 65, 1) 0%, rgba(205, 156, 49, 1) 13%, rgba(154, 128, 73, 1) 35%, rgba(246, 204, 78, 1) 51%, rgba(181, 147, 56, 1) 75%, rgba(163, 136, 68, 1) 100%);
        margin-top: 0px;
        margin-right: 5px;
        padding: 6px 10px;
        border-radius: 27px;
        border: 0px;
        box-shadow: none;
        /* color: #000 !important; */
        font-size: 13px;
        font-weight: 600;
        text-transform: capitalize;
    }

    .modal canvas {
        width: 100%;
    }

    .checkrepo {
        display: flex;
    }

    label.repo-label {
        margin: 12px;
        font-size: 14px;
    }

    a.report-btn i {
        background-color: #c69834;
        color: #fff;
        font-size: 9px;
        padding: 8px;
        border-radius: 50%;
    }

    a.copy_url.btn.create-post-button.ms-2 i {
        position: relative;
        /* left: 2px; */
        bottom: 3px;
    }

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

    .likes-container{flex-direction: column;}

    .likes-count {
        font-size: 12px;
    }
    .job-overview{padding: 20px;}

    .copy-button{background: rgb(170, 137, 65);border: none;outline: none;border-radius: 5px;cursor: pointer;padding: 2px;
    background: linear-gradient(90deg, rgba(170, 137, 65, 1) 0%, rgba(205, 156, 49, 1) 13%, rgba(154, 128, 73, 1) 35%, rgba(246, 204, 78, 1) 51%, rgba(181, 147, 56, 1) 75%, rgba(163, 136, 68, 1) 100%);}
    
    @media only screen and (max-width:767px){
     .job-overview{padding: 0px;}  
     .Serivce-right-sidebar .job-locatin {padding: 20px 0 20px 0px;} 
    }

    /*.reactions-emojis {
        position: absolute;
        top: 45px;
    }*/
    i.fa-regular.fa-bookmark::before {
        font-size: 13px !important;
    }
</style>

<?php
$itemFeaturedImages = trim($blog->image1, '[""]');
$itemFeaturedImage  = explode('","', $itemFeaturedImages);
$count = count($itemFeaturedImage);
?>
<script src="https://mozilla.github.io/pdf.js/build/pdf.js"></script>
<section id="job-post">
    <div class="container">
        <span>
            @include('admin.partials.flash_messages')
        </span>
        <div class="row">
            <!-- <div class="col-lg-12 prev-next-arrows">
                <div class="left-arrow">
                    @if($previousPostId != null)
                    <a href="{{route('community_single_post',$previousPostId)}}"><i class="bi bi-arrow-left"></i> <span>Prev</span></a>
                    @endif 
                </div>
                <div class="right-arrow1">
                    @if($nextPostId != null)
                    <a href="{{route('community_single_post',$nextPostId)}}"><span>Next</span> <i class="bi bi-arrow-right"></i></a>
                    @endif
                </div>
            </div> -->

            <div class="col-lg-12 prev-next-arrows">
                <div class="left-arrow">
                    <a href="@if($nextPostId != null){{route('community_single_post',$nextPostId)}} @else # @endif"
                        class="{{ $nextPostId == null ? 'disabled' : '' }}"><i class="bi bi-arrow-left"></i>
                        <span>Prev</span></a>

                </div>
                <div class="right-arrow1">
                    <a href="@if($previousPostId != null){{route('community_single_post',$previousPostId)}} @else # @endif"
                        class="{{ $previousPostId == null ? 'disabled' : '' }}"><span>Next</span> <i
                            class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-md-8">
                <div class="bg-white" style="padding: 20px;margin-top: 0px;border-radius: 10px;">
                    <div class="job-post-header">
                        
                        <div class="row">
                            <div class="col-lg-3 col-md-3 mb-4">
                                <div class="job-post-imges position-relative">

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
                                                <a href="{{asset('images_blog_img')}}/{{ $valueitemFeaturedImage }}"
                                                    data-lightbox="carousel">
                                                    <img src="{{asset('images_blog_img')}}/{{ $valueitemFeaturedImage }}"
                                                        alt="{{ $blog->title }}" class="d-block w-100"
                                                        onerror="this.onerror=null; this.src='https://finderspage.com/public/images_blog_img/1688636936.jpg';">
                                                </a>
                                            </div>
                                            <?php }
                                            }
                                            ?>


                                            <!-- @if($blog->post_video) 
                                            <div class="carousel-item">
                                            <a href="{{asset('images_blog_video')}}/{{$blog->post_video}}" data-lightbox="carousel">
                                                <video width="320" height="240" controls class="d-block w-100">
                                                <source src="{{asset('images_blog_video')}}/{{$blog->post_video}}" type="video/mp4">
                                                </video>
                                            </a>
                                            </div>
                                        @endif -->


                                        </div>
                                        @if($count > 1)
                                        <!-- Left and right controls/icons -->
                                        <button class="carousel-control-prev" type="button" data-bs-target="#demo"
                                            data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon"></span>
                                        </button>

                                        <button class="carousel-control-next" type="button" data-bs-target="#demo"
                                            data-bs-slide="next">
                                            <span class="carousel-control-next-icon"></span>
                                        </button>
                                        @endif
                                    </div>

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

                                    <!-- <div class="lightbox-overlay">
                                        <img class="lightbox-img" src="" alt="">
                                    </div> -->
                                    <div class="job-type job-p mt-1" style="display:none;">
                                        <?php
                                        if ($blog->post_by == 'admin') {
                                            foreach ($admins as $add) {
                                                if ($blog->user_id == $add->id) {
                                                    $userName = $add->first_name;
                                                    $adminId = $add->id;
                                                    $email = '';
                                                    $phone = '';
                                                    $website = '';
                                                    $facebook = '';
                                                    $instagram = '';
                                                    $linkedin = '';
                                                    $whatsapp = '';
                                                    $youtube = '';
                                                    $Tiktok = '';
                                                    echo '<img src="' . asset($add->image) . '" alt="Image">';
                                                    echo '<p>' . $blog->title . '<br><small>By ' . $add->first_name . '</small></p>';
                                                }
                                            }
                                        } else {
                                            // Assuming $users is an array or collection
                                            foreach ($users as $user) {
                                                if ($blog->user_id == $user->id) {
                                                    $userName = $user->first_name;
                                                    $userId = $user->id;
                                                    $email = $user->email;
                                                    $phone = $user->phonenumber;
                                                    $website = $user->business_website;
                                                    $facebook = $user->facebook;
                                                    $instagram = $user->instagram;
                                                    $linkedin = $user->linkedin;
                                                    $whatsapp = $user->whatsapp;
                                                    $youtube = $user->youtube;
                                                    $Tiktok = $user->Tiktok;


                                                    $userId = $user->id;
                                                    echo '<img src="' . asset('assets/images/profile') . '/' . $user->image . '" alt="Image">';
                                                    echo '<p>' . $blog->title . '<br><small>By ' . $user->first_name . '</small></p>';
                                                }
                                            }
                                        }
                                        ?>

                                        <!-- <img src="https://finder.harjassinfotech.org/public/assets/images/profile/1687521756.png" alt="">
                                    <p>Test Serivce <br> <small>By Manit</small></p> -->
                                    </div>
                                    <!-- <img src="./new_assets/assets/images/business.png" class="w-100 h-100" alt="..."> -->
                                </div>
                            </div>
                            <div class="col-lg-9 col-md-9 mb-4">
                                <div class="job-post-content">
                                    <h2>{{$blog->title}}</h2>
                                    <div class="job-type">
                                   
                                        <hr>
                                        <div class="row btn-row">
                                            <div class="col-lg-5 col-md-6 col-6 singel-post-by"
                                                style="border-right: 1px solid #c6c7c8;"><b>Posted by:</b> 
                                                @if(UserAuth::isLogin())
                                                <a target="blank" href="{{route('UserProfileFrontend', $userSlug->slug)}}"> {{$userName}} </a>
                                                @elseif(AdminAuth::isLogin())
                                                <a target="blank" href="{{route('UserProfileFrontend.admin', $userSlug->slug)}}"> {{$userName}} </a>
                                                @else
                                                <a target="blank" href="{{route('auth.signupuser')}}" onclick="showAlertForSave()"> {{$userName}} </a>
                                                @endif
                                            </div>
                                            <div class="col-lg-4 col-md-6 col-6 singel-posted"><b>Posted:</b>
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
                                                    $timeAgo = "Today";
                                                }
                                                echo $timeAgo;
                                                ?>


                                            </div>

                                            {{-- @if ($BlogLikes->isNotEmpty() && UserAuth::isLogin())
                                               
                                            <div class="col-lg-3 col-md-12 col-12 single-top-apply">
                                                <div class="job-post-apply">
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
                                                            <button type="button" class="like-button" id="toggleLikes" data-user-id="{{ $userId }}" data-blog-id="{{ $like->blog_id }}" data-blog-user-id="{{ $blog->user_id }}" data-type="Community" data-cate-id="5" data-url={{ route('community_single_post', $blog->slug) }}>
                                                        @else
                                                            <button type="button" class="like-button" id="toggleLikes" data-user-id="{{ UserAuth::getLoginId() }}" data-blog-id="{{ $blog->id }}" data-blog-user-id="{{ $blog->user_id }}" data-type="Community" data-cate-id="5" data-url={{ route('community_single_post', $blog->slug) }} style="padding: 6px 8px !important; width: auto !important; margin: 0 !important;">
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
                                           
                                            @elseif ($blog->user_id == UserAuth::getLoginId())
                                                <div class="col-lg-3 col-md-12 col-12 single-top-apply">
                                                    <div class="job-post-apply">
                                                        @if(UserAuth::isLogin())
                                                            <div class="likes-container">
                                                                <div class="likes-info">
                                                                    <b>Likes: </b>
                                                                    <span class="likes-preview">no likes</span>
                                                                </div>
                                                                <div class="">
                                                                    <button type="button" class="like-button" id="toggleLikes" data-user-id="{{ UserAuth::getLoginId() }}" data-blog-id="{{ $blog->id }}" data-blog-user-id="{{ $blog->user_id }}" data-type="Community" data-cate-id="5" data-url={{ route('community_single_post', $blog->slug) }}>
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
                                                <div class="col-lg-3 col-md-12 col-12 single-top-apply">
                                                    <div class="job-post-apply">
                                                        @if(UserAuth::isLogin())
                                                            <div class="likes-container">
                                                                <div class="">
                                                                    <button type="button" class="like-button" id="toggleLikes" data-user-id="{{ UserAuth::getLoginId() }}" data-blog-id="{{ $blog->id }}" data-blog-user-id="{{ $blog->user_id }}" data-type="Community" data-cate-id="5" data-url={{ route('community_single_post', $blog->slug) }}>
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

                                            <!-- {{-- <div class="col-4">
                                            <div class="job-post-apply">
                                                <a  class="apply" href="">Apply For Serivce</a><span><a href="#"><i class="bi bi-save"></i></a></span>
                                            </div>
                                        </div> --}} -->
                                        </div>
                                    </div>
                                    <div class="job-type">
                                        <!-- <ul>
                                        <li>Full Time</li>
                                        <li>Private </li>
                                        <li>Urgent</li>
                                    </ul> -->
                                    </div>
                                </div>
                            </div>
                            @if(!empty($blog->description))
                            <div class="job-detail pt-2 mt-4">

                                <h4>Description</h4>
                                <div calss="contentArea">
                                <?php
                                        $processedText = Setting::makeLinksClickable($blog->description);
                                    ?>
                                    <p>{!! $processedText !!}</p>
                                </div>
                            </div>
                            @endif

                            <div class="col-xl-12 pt-2 mt-2 ">
                                <div class="row">
                                    @if(!empty($blog->document))
                                    <?php
                                    $doc_m = trim($blog->document, '[""]');
                                    $doc  = explode('","', $doc_m);

                                    // echo "<pre>";print_r($doc);die('dev');
                                    ?>
                                    
                                    @foreach($doc as $docs)
                                    <div id="pdf-container" class="col-lg-3 col-md-4 col-4 docShow "
                                        dataPath="{{asset('images_blog_doc')}}/{{$docs}}">
                                        <img src="{{asset('new_assets/assets/images/download.png')}}" alt="Image">
                                    </div>
                                    @endforeach
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4">


                <div class="Serivce-right-sidebar bg-white">
                    <div class="job-overview community-overview">
                        <h4>Community Overview</h4>
                        <ul class="job-overview-new">

                            <li><i class="bi bi-calendar-check"></i>
                                <h6>Date Posted:</h6><span>

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
                                            if ( $days == 1 ) {
                                                $timeAgo .= $days . " day ago ";
                                            } else {
                                                $timeAgo .= $days . " days ago ";
                                            }
                                        }else{
                                            $timeAgo .= "Today"; 
                                        }
                                        echo $timeAgo;
                                    ?>
                                </span>
                            </li>


                             @if(!empty($blog->location))
                            <li><i class="bi bi-geo-alt"></i>

                                <h6>Location:</h6><span>
                                    {{$blog->location}}
                                    

                                </span>
                            </li>
                            @endif

                            @if($blog->personal_detail == 'true')

                            @if(!empty($phone))
                            <li><i class="bi bi-telephone-fill"></i>
                                <h6>Phone:</h6><span><a href="tel:{{$phone}}" target="_blank;">{{$phone}}</a></span>
                            </li>
                            @endif
                            @if(!empty($email))
                            <li><i class="bi bi-envelope"></i>
                                <h6>Email:</h6><span><a href="mailto:{{$email}}" target="_blank;">{{$email}}</a></span>
                            </li>
                            @endif
                            @if(!empty($blog->website))
                            <li><i class="bi bi-globe2"></i>
                                <h6>Website:</h6><span><a href="{{$blog->website}}">{{$blog->website}}</a></span>
                            </li>
                            @endif  
                            <!-- <li><i class="bi bi-card-checklist"></i><h6 style="margin-bottom: 10px;">Follow Us:</h6>
                                    
                                    @if($facebook) 
                                        <a href="{{$facebook}}" target="_blank" class="facebook"><i style="position: inherit;" class="fab fa-facebook-f" aria-hidden="true"></i></a>
                                    @else 
                                        <a href="https://www.facebook.com" target="_blank" class="facebook"><i style="position: inherit;" class="fab fa-facebook-f" aria-hidden="true"></i></a>
                                    @endif

                                    @if($linkedin) 
                                        <a href="{{$linkedin}}" target="_blank" class="linkedin"><i style="position: inherit;" class="fab fa-linkedin-in" aria-hidden="true"></i></a>
                                    @else 
                                        <a href="https://www.linkedin.com" target="_blank" class="linkedin"><i style="position: inherit;" class="fab fa-linkedin-in" aria-hidden="true"></i></a>
                                    @endif
                                    
                                    @if($instagram)
                                        <a href="{{$instagram}}" target="_blank" class="instagram"><i style="position: inherit;" class="fab fa-instagram" aria-hidden="true"></i></a>
                                    @else
                                        <a href="https://www.instagram.com" target="_blank" class="instagram"><i style="position: inherit;" class="fab fa-instagram" aria-hidden="true"></i></a>
                                    @endif
                                    
                                    @if($whatsapp)
                                        <a href="whatsapp://send?abid={{$whatsapp}}&text=Hello%2C%20World!" target="_blank"class="whatsapp"><i style="position: inherit;" class="fab fa-whatsapp" aria-hidden="true"></i></a>
                                    @else
                                        <a href="whatsapp://send?abid=9898989898&text=Hello%2C%20World!" target="_blank"class="whatsapp"><i style="position: inherit;" class="fab fa-whatsapp" aria-hidden="true"></i></a>
                                    @endif
                                    
                                    @if($youtube)
                                        <a href="{{$youtube}}" target="_blank" class="youtube"><i style="position: inherit;" class="fab fa-youtube" aria-hidden="true"></i></a> 
                                    @else
                                        <a href="https://www.youtube.com" target="_blank" class="youtube"><i style="position: inherit;" class="fab fa-youtube" aria-hidden="true"></i></a>
                                    @endif
                                    @if($blog->Tiktok)
                                        <a href="{{$Tiktok}}" target="_blank" class="Tiktok"><i style="position: inherit;" class="bi bi-tiktok" aria-hidden="true"></i></a> 
                                    @else
                                        <a href="https://www.tiktok.com" target="_blank" class="Tiktok"><i style="position: inherit;" class="bi bi-tiktok" aria-hidden="true"></i></a>
                                    @endif
                                    
                                </li> -->
                                @else
                                @if(UserAuth::isLogin())

                                    @if(!empty($phone))
                                    <li><i class="bi bi-telephone-fill"></i>
                                        <h6>Phone:</h6><span><a href="tel:{{$phone}}" target="_blank;">{{$phone}}</a></span>
                                    </li>
                                    @endif
                                    @if(!empty($email))
                                    <li><i class="bi bi-envelope"></i>
                                        <h6>Email:</h6><span><a href="mailto:{{$email}}" target="_blank;">{{$email}}</a></span>
                                    </li>
                                    @endif
                                    @if(!empty($blog->website))
                                    <li><i class="bi bi-globe2"></i>
                                        <h6>Website:</h6><span><a href="{{$blog->website}}">{{$blog->website}}</a></span>
                                    </li>
                                    @endif  
                                @endif
                            @endif
                            <li><i class="bi bi-people"></i>
                                <h6>Community Title:</h6><span>{{$blog->title}}</span>
                            </li>

                            <!-- <li><i class="bi bi-tags-fill"></i><h6>Charges</h6><span>${{ ucfirst($blog->rate) }}</span></li> -->
                            <!-- <li class="shareComponent">
                            <li>
                                <i class="fal fa-share"></i>
                                <h6>Share to:</h6>
                            </li>
                            {!! $shareComponent !!}
                            </li> -->

                            <li>
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
                                        <button type="button" class="like-button" id="toggleLikes" data-user-id="{{ $userId }}" data-blog-id="{{ $like->blog_id }}" data-blog-user-id="{{ $blog->user_id }}" data-type="Community" data-cate-id="5" data-url={{ route('community_single_post', $blog->slug) }}>
                                        @else
                                        <button type="button" class="like-button" id="toggleLikes" data-user-id="{{ UserAuth::getLoginId() }}" data-blog-id="{{ $blog->id }}" data-blog-user-id="{{ $blog->user_id }}" data-type="Community" data-cate-id="5" data-url={{ route('community_single_post', $blog->slug) }} style="padding: 6px 8px !important; width: auto !important; margin: 0 !important;">
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
                                                <button type="button" class="like-button" id="toggleLikes" data-user-id="{{ UserAuth::getLoginId() }}" data-blog-id="{{ $blog->id }}" data-blog-user-id="{{ $blog->user_id }}" data-type="Community" data-cate-id="5" data-url={{ route('community_single_post', $blog->slug) }}>
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
                                        <a data-postid="{{ $blog->id }}" data-type="Community" data-Userid="{{ UserAuth::getLoginId() }}"
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
                                                <input type="text" class="text" value="{{url('/community-single-post')}}/{{$blog->slug}}" id="field_input"/>
                                                <a href="javascript:void(0);" redirect-url="{{url('/chatify')}}/{{$user->id}}" copy-url="{{url('/community-single-post')}}/{{$blog->slug}}" class="copy_url btn create-post-button ms-2" data-placement="top" data-toggle="tooltip" title="Share">
                                                    <i class="fa fa-clone"></i>
                                                </a>
                                              </div>
                                              <hr>
                                              <div class="copy-text">
                                                <input type="text" class="text" value="Share link via email" readonly id="email_input"/>
                                                <a href="mailto:{{$user_all_data->email }}?subject={{$blog->title}}&body=Page link : {{url('/community-single-post')}}/{{$blog->slug}}" class="btn create-post-button ms-2" data-placement="top" data-toggle="tooltip" title="Email">
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
                    @if(!empty($blog->post_video))
                    <div class="job-locatin">
                        <h4>Video</h4>
                        <a href="{{asset('images_blog_video')}}/{{$blog->post_video}}">
                            <video width="100%" height="350" controls class="d-block w-100">
                                <source src="{{asset('images_blog_video')}}/{{$blog->post_video}}" type="video/mp4">
                            </video>
                        </a>
                    </div>
                    @endif
                    <div class="job-locatin mt-4">
                        <h4>Location</h4>
                        <div class="responsive-map">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2822.7806761080233!2d-93.29138368446431!3d44.96844997909819!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x52b32b6ee2c87c91%3A0xc20dff2748d2bd92!2sWalker+Art+Center!5e0!3m2!1sen!2sus!4v1514524647889"
                                width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
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
<section class="job-post-description mt-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="share-job mb-5" style="display:none;">
                    <h5>Follow Us</h5>

                    @if($blog->facebook)
                    <a href="{{$blog->facebook}}" target="_blank" class="facebook"><i class="fab fa-facebook-f"
                            aria-hidden="true"></i>Facbook</a>
                    @else
                    <a href="https://www.facebook.com" target="_blank" class="facebook"><i class="fab fa-facebook-f"
                            aria-hidden="true"></i>Facbook</a>
                    @endif


                    @if($blog->linkedin)
                    <a href="{{$blog->linkedin}}" target="_blank" class="linkedin"><i class="fab fa-linkedin-in"
                            aria-hidden="true"></i>linkedin</a>
                    @else
                    <a href="https://www.linkedin.com" target="_blank" class="linkedin"><i class="fab fa-linkedin-in"
                            aria-hidden="true"></i>linkedin</a>
                    @endif

                    @if($blog->instagram)
                    <a href="{{$blog->instagram}}" target="_blank" class="instagram"><i class="fab fa-instagram"
                            aria-hidden="true"></i>instagram</a>
                    @else
                    <a href="https://www.instagram.com" target="_blank" class="instagram"><i class="fab fa-instagram"
                            aria-hidden="true"></i>instagram</a>
                    @endif

                    @if($blog->whatsapp)
                    <a href="whatsapp://send?abid={{$blog->whatsapp}}&text=Hello%2C%20World!" target="_blank"
                        class="whatsapp"><i class="fab fa-whatsapp" aria-hidden="true"></i>Whatsapp</a>
                    @else
                    <a href="whatsapp://send?abid=9898989898&text=Hello%2C%20World!" target="_blank" class="whatsapp"><i
                            class="fab fa-whatsapp" aria-hidden="true"></i>Whatsapp</a>
                    @endif

                    @if($blog->youtube)
                    <a href="{{$blog->youtube}}" target="_blank" class="youtube"><i class="fab fa-youtube"
                            aria-hidden="true"></i>Youtube</a>
                </div>
                @else
                <a href="https://www.youtube.com" target="_blank" class="youtube"><i class="fab fa-youtube"
                        aria-hidden="true"></i>Youtube</a>
            </div>
            @endif
            <div class="related-new-job mt-4 text-center mb-3">
                <h3>Related Post</h3>
            </div>
            <div class="row related-job">
                <div class="col-lg-12 col-md-12">
                    <div class="job-post-header">
                        <div class="row">
                            @foreach($related_estate as $Rjob)
                            <div class="col-lg-2 col-md-4 col-sm-6 col-6">

                                <div class="feature-box">
                                    <a href="{{route('community_single_post',$Rjob->slug)}}">
                                        <div id="demo-new" class="carousel1 slide">
                                            <!-- Indicators/dots -->
                                            <!-- The slideshow/carousel -->
                                            <div class="carousel-inner">
                                                <?php
                                                $itemFeaturedImages = trim($Rjob->image1, '[""]');
                                                $itemFeaturedImage  = explode('","', $itemFeaturedImages);
                                                if (is_array($itemFeaturedImage)) {
                                                    foreach ($itemFeaturedImage as $keyitemFeaturedImage => $valueitemFeaturedImage) {
                                                        if ($keyitemFeaturedImage == 0) {
                                                            $class = 'active';
                                                        } else {
                                                            $class = 'in-active';
                                                        } ?>
                                                <div class="carousel-item <?= $class; ?>">
                                                    <img src="{{asset('images_blog_img')}}/{{ $valueitemFeaturedImage }}"
                                                        alt="Los Angeles" class="d-block w-100"
                                                        onerror="this.onerror=null; this.src='https://finderspage.com/public/images_blog_img/1688636936.jpg';">
                                                </div>
                                                <?php }
                                                }
                                                ?>


                                            </div>
                                        </div>

                                        <div class="Name">
                                            <span>{{$Rjob->title}}</span>
                                        </div>

                                        <div class="main-days-frame">
                                            <span class="days-box">
                                                <?php
                                                $givenTime = strtotime($Rjob->created);
                                                $currentTimestamp = time();
                                                $timeDifference = $currentTimestamp - $givenTime;

                                                $days = floor($timeDifference / (60 * 60 * 24));
                                                $hours = floor(($timeDifference % (60 * 60 * 24)) / (60 * 60));
                                                $minutes = floor(($timeDifference % (60 * 60)) / 60);
                                                $seconds = $timeDifference % 60;

                                                $timeAgo = "";
                                                if ($days > 0) {
                                                    $timeAgo .= $days . " Days Ago ";
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

                                        {{-- <div class="review-customer">
                                            <ul class="review">
                                                <li><i class="bi bi-star-fill"></i></li>
                                                <li><i class="bi bi-star-fill"></i></li>
                                                <li><i class="bi bi-star-fill"></i></li>
                                                <li><i class="bi bi-star-fill"></i></li>
                                                <li><i class="bi bi-star-half"></i></li>
                                            </ul>
                                        </div> --}}

                                        <div class="job-type job-hp ">
                                            <?php
                                            if ($Rjob->post_by == 'admin') {
                                                foreach ($admins as $add) {
                                                    if ($Rjob->user_id == $add->id) {
                                                        echo '<img src="' . asset($add->image) . '" alt="Image">';
                                                        echo '<p>' . $Rjob->title . '<br><small>By ' . $add->first_name . '</small></p>';
                                                    }
                                                }
                                            } else {
                                                // Assuming $users is an array or collection
                                                foreach ($users as $user) {
                                                    if ($Rjob->user_id == $user->id) {
                                                        echo '<img src="' . asset('assets/images/profile') . '/' . $user->image . '" alt="Image">';
                                                        echo '<p>' . $Rjob->title . '<br><small>By ' . $user->first_name . '</small></p>';
                                                    }
                                                }
                                            }
                                            ?>
                                        </div>
                                    </a>
                                </div>

                            </div>
                            @endforeach

                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
    </div>
</section>

<!------- Model Apply job--------->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Apply Now!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body row">
                <div class="col-lg-6">
                    <div class="field">
                        <div class="control has-icons-left">
                            <input type="text" name="name" id="Name" class="input" placeholder="First Name">
                            <span class="icon is-left">
                                <i class="fa fa-user"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="field">
                        <div class="control has-icons-left">
                            <input type="text" name="name" id="Name" class="input" placeholder="Last Name">
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
                            <input type="tel" name="Number" id="email" class="input" placeholder="Phone Number">
                            <span class="icon is-left">
                                <i class="bi bi-telephone-fill"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="field">
                        <div class="control has-icons-left">
                            <input type="file" name="file" id="multiple" class="input resume">
                            <span class="icon is-left">
                                <i class="bi bi-cloud-upload"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="contact-from-button">Submit</button>
            </div>
        </div>
    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <!-- <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5> -->
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="dataDiv">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Understood</button>
            </div>
        </div>
    </div>
</div>



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
                            <input class="form-check" name="reason[]" type="checkbox" value="It's spam"><label
                                class="repo-label">It's spam</label>
                        </div>


                        <div class="checkrepo">
                            <input class="form-check" name="reason[]" type="checkbox"
                                value="Nudity or sexual activity"><label class="repo-label">Nudity or sexual
                                activity</label>
                        </div>

                        <div class="checkrepo">
                            <input class="form-check" name="reason[]" type="checkbox"
                                value="Hate speech or symbols"><label class="repo-label">Hate speech or symbols</label>
                        </div>

                        <div class="checkrepo">
                            <input class="form-check" name="reason[]" type="checkbox"
                                value="Violence or dangerous organizations"><label class="repo-label">Violence or
                                dangerous organizations</label>
                        </div>

                        <div class="checkrepo">
                            <input class="form-check" name="reason[]" type="checkbox"
                                value="Sale of illegal or regulated goods"><label class="repo-label">Sale of illegal or
                                regulated goods</label>
                        </div>

                        <div class="checkrepo">
                            <input class="form-check" name="reason[]" type="checkbox"
                                value="Bullying or harassment"><label class="repo-label">Bullying or harassment</label>
                        </div>

                        <div class="checkrepo">
                            <input class="form-check" name="reason[]" type="checkbox"
                                value="Intellectual property violation"><label class="repo-label">Intellectual property
                                violation</label>
                        </div>

                        <div class="checkrepo">
                            <input class="form-check" name="reason[]" type="checkbox"
                                value="Suicide or self-injury"><label class="repo-label">Suicide or self-injury</label>
                        </div>

                        <div class="checkrepo">
                            <input class="form-check" name="reason[]" type="checkbox" value="Eating disorders"><label
                                class="repo-label">Eating disorders</label>
                        </div>

                        <div class="checkrepo">
                            <input class="form-check" name="reason[]" type="checkbox" value="Scam or fraud"><label
                                class="repo-label">Scam or fraud</label>
                        </div>

                        <div class="checkrepo">
                            <input class="form-check" name="reason[]" type="checkbox" value="False information"><label
                                class="repo-label">False information</label>
                        </div>

                        <div class="checkrepo">
                            <input class="form-check" name="reason[]" type="checkbox"
                                value="Account may have been hacked"><label class="repo-label">Account may have been
                                hacked</label>
                        </div>

                        <div class="checkrepo">
                            <input class="form-check" name="reason[]" type="checkbox"
                                value="I just don't like it"><label class="repo-label">I just don't like it</label>
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
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $(".docShow").on("click", function () {
            // URL of the PDF file you want to preview
            var pdfUrl = $(this).attr('dataPath');
            $("#staticBackdrop").modal("toggle");
            // Create a PDFJS worker using the provided workerSrc
            pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://mozilla.github.io/pdf.js/build/pdf.worker.js';

            // Fetch the PDF document
            pdfjsLib.getDocument(pdfUrl).promise.then(function (pdfDoc) {
                // Set the page number you want to display
                var pageNumber = 1;

                // Get the page from the PDF document
                pdfDoc.getPage(pageNumber).then(function (page) {
                    var scale = 1.5; // You can adjust the scale as needed
                    var viewport = page.getViewport({
                        scale: scale
                    });

                    // Prepare a canvas element to render the PDF page
                    var canvas = document.createElement('canvas');
                    var context = canvas.getContext('2d');
                    canvas.height = viewport.height;
                    canvas.width = viewport.width;

                    // Replace 'pdf-container' with the appropriate container element ID
                    document.getElementById('dataDiv').innerHTML = ''; // Clear previous content
                    document.getElementById('dataDiv').appendChild(canvas);

                    // Render the PDF page on the canvas
                    var renderContext = {
                        canvasContext: context,
                        viewport: viewport
                    };
                    page.render(renderContext);
                });
            });
        });
    });

    $('.copy_url').click(function () {
        var urlToCopy = $(this).attr('copy-url');
        var redirect_url = $(this).attr('redirect-url');
        console.log('URL to copy:', urlToCopy);

        navigator.clipboard.writeText(urlToCopy)
            .then(function () {
                // Swal.fire({
                //     title: "URL copied to clipboard!",
                //     text: urlToCopy,
                //     icon: "success",
                //     showConfirmButton: false
                // });
                setTimeout(function () {
                    window.location.href = redirect_url;
                }, 1500);
            })
            .catch(function (err) {
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