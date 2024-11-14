@php
   use App\Models\UserAuth;
   use App\Models\Admin\Users;
   use App\Models\Blogs;
   use App\Models\Admin\BlogCategoryRelation;
   use App\Models\Setting;
   use App\Models\Admin\AdminAuth;
   use App\Models\BlogComments;
   
   // $userName = UserAuth::getLoginUserName();
   $user_data = UserAuth::getLoginUser();
   $user_all_data = UserAuth::getUser($blog->user_id);
   $setting_comment_option = Setting::get_setting('comments_option',$blog->user_id);
   $setting_like_option = Setting::get_setting('likes',$blog->user_id);
@endphp
@extends('layouts.frontlayout')
@section('content')
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.qrcode/1.0/jquery.qrcode.min.js"></script> -->
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
// dd($BlogComments);
@endphp
<style>
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
   /*display: block;*/
   /*justify-content: end;*/
   /*align-items: center;*/
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
   color: #fff !important;
   font-size: 13px;
   font-weight: 600;
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
   input[type="file"] {
   display: none;
   }
   .custom-file-upload {
   border: 1px solid #8f9797;
   display: inline-block;
   padding: 6px 12px;
   cursor: pointer;
   border-radius: 4px;
   width: 100%;
   color: #212529;
   }
   .view_counts{
        position: initial !important;
    }
   /*-------------*/
   .job_apply_modal input {
   border-radius: 50px !important;
   margin-bottom: 10px !important;
   font-size: 13px;
   }
   .job_apply_modal .custom-file-upload {
   border-radius: 50px !important;
   font-size: 13px;
   height: 40px;
   }
   a.btn.create-post-button {
   margin-right: 12px;
   }
   .copy-button {
   background: rgb(170, 137, 65);
   border: none;
   outline: none;
   border-radius: 5px;
   cursor: pointer;
   padding: 2px;
   background: linear-gradient(90deg, rgba(170, 137, 65, 1) 0%, rgba(205, 156, 49, 1) 13%, rgba(154, 128, 73, 1) 35%, rgba(246, 204, 78, 1) 51%, rgba(181, 147, 56, 1) 75%, rgba(163, 136, 68, 1) 100%);
   }
   .fund_comment{
   display:  block!important;
   }
   .fund_comment .comment-header {
   display: flex;
   justify-content: center;
   align-items: center;
   }
   .fund_comment .btn-reply {
   border: 0;
   font-size: 12px !important;
   padding: 0;
   font-weight: 600;
   }
   .reply-box {
   display: flex;
   position: relative;
   border-radius: 35px;
   background: #eaeaea;
   padding: 5px 0 5px 10px;
   box-shadow: 0px 0px 4px rgba(0, 0, 0, 0.22);
   }
   .reply-box input.form-control {
   background: transparent;
   border: 0;
   border-radius: 35px;
   height: 40px;
   width: 80%;
   font-size: 14px;
   }
   .sendreply {
   border-radius: 35px;
   border: 0px !important;
   box-shadow: none !important;
   padding: 9px 20px;
   position: absolute;
   right: 5px;
   font-size: 14px;
   }
   /* .dots-menu ul.dropdown-menu {
   right: 36px;
   left: auto;
   min-width: 80px;
   text-align: center;
   }
   .dropdown-menu.show {
   display: inline-block;
   }
   .dots-menu ul.dropdown-menu li {
   padding: 0;
   width: auto;
   display: inline-block;
   }
   .dots-menu ul.dropdown-menu li a {
   margin: 0;
   padding: 0 9px;
   border: 0;
   } */
   .btn-danger {background-color: unset !important;}
   .btn-danger:hover {background-color: #dc7228 !important;}

   .fundraiser-comments {
      background: #141212;
      margin-right: 10px;
      border: 0;
   }
   .fundraiser-comments i{
      width: 40px;
      height: 40px;
      line-height: 40px;
      color: #fff;
      font-size: 20px;
   }
   .comment-header{
      display: flex;
    width: 100%;
    align-items: start;
    margin-bottom: 10px;
   }
   ul.dropdown-menu {
    top: -1px;
    right: 35px;
  }
  .update-comment{
   background: linear-gradient(90deg, rgba(220, 114, 40, 1) 50%, #a54db7 100%);
    color: white !important;
    border-radius: 35px;
    border: 0px !important;
    box-shadow: none !important;
    padding: 9px 20px;
    position: absolute;
    right: 5px;
    font-size: 14px;
    font-weight: 400;
    margin: 0;
  }
  .comments-box{margin-bottom: 30px;}
  .comments-box .dropdown-menu.show{min-width: 50px; display: flex; justify-content: space-between; align-items: center;
    height: 42px; }
    .comments-box .dropdown-menu.show li .btn:hover{
      background-color: unset !important;
      border: 0 !important;
    }
    .comments-box .dropdown-menu.show li .btn{
      border: 0 !important;
      color: #000 !important;
    }
    .comments-box .dropdown-menu.show li .btn:hover i{
      color: #000 !important;
    }
  .btn-danger {border: 0 !important; border-color: unset !important;}
  .comment-actions button{font-size: 14px;font-weight: 600;}
  .dots-menu .btn-primary{border: 0 !important;}
  .blank-btn{background: #141212; margin-right: 10px; border: 0;}
  .blank-btn i {width: 40px; height: 40px; line-height: 40px; color: #fff; font-size: 20px;}
  .payment-div{background: linear-gradient(90deg, rgba(220, 114, 40, 1) 50%, #a54db7 100%);border-radius: 13px; display: flex; justify-content: space-between; align-items: center;}
   .payment-div h4{margin-bottom: 0; color: #fff;}
  .reportSubmit{
      background: rgb(170, 137, 65);
      background: linear-gradient(90deg, rgba(220, 114, 40, 1) 50%, #a54db7 100%);
      height: 40px;
      margin-top: 4px;
      border-radius: 35px;
      border: 0px;
      box-shadow: none;
      line-height: 29px;
      font-size: 13px !important;
      color: #fff !important;
      font-weight: 500;
      width: 100%;
  }
  
    .emojis {
        display: flex;
        margin-left: 10px;
        overflow-x: auto;
    }
    
    .emojis span {
        font-size: 36px;
        cursor: pointer;
        margin: 10px;
    }
    
    .comment-emoji {
        cursor: pointer;
    }
    
    .comment-emoji i {
        display: flex;   
    }
    .like-preview {
       width: 21%;
    }
    .like-icon.active {
      color: red;
      animation: like 0.5s 1;
    }
    
    .like-icon {
      color: black;
      transition: all 0.5s;
      cursor: pointer;
    }
    .fa-heart {
        color: red;
    }
    @-webkit-keyframes like {
      0% { transform: scale(1); }
      90% { transform: scale(1.2); }
      100% { transform: scale(1.1); }
    }
    .like-count {
        cursor: pointer;
    }
    .likes-modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
    }
    
    .likes-modal .modal-content {
        background-color: #fff;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        max-width: 500px;
        border-radius: 8px;
    }
    
    .likes-modal .modal-content .close {
        color: #aaa;
        float: right;
        font-size: 40px;
        font-weight: normal;
        top: 5px;
    }
    
    .likes-modal .modal-content .close:hover,
    .likes-modal .modal-content .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }
    
    .likes-modal .likes-list {
        max-height: 300px;
        overflow-y: auto;
    }
    
    .likes-modal .like-item {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }
    
    .likes-modal .like-user-image {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        margin-right: 10px;
    }
    
    .likes-modal .connect-btn {
        background-color: #dc7228;
        color: white;
        border: none;
        padding: 5px 10px;
        border-radius: 5px;
        cursor: pointer;
    }
    
    .likes-modal .connect-btn:hover {
        background-color: linear-gradient(90deg, rgba(220, 114, 40, 1) 50%, #a54db7 100%);
    }

    .emojiButton {
        cursor: pointer;
    }
    .hidden {
        display: none;
    }
    .emojiPicker {
      padding: 10px;
      border: 1px solid #ccc;
      width: 100%;
      background-color: white;
      position: absolute;
      z-index: 1000;
      max-width: 350px;
      border-radius: 5px;
      top: 50px;
      gap: 5px;
      grid-template-columns: repeat(7, 1fr); /* 7 emojis per row */
    }
    .emojiPicker .emoji {
        cursor: pointer;
        margin: 5px;
        font-size: 24px;
    }
    /*.reactions-emojis {
        position: absolute;
        top: 45px;
    }*/
    i.fa-regular.fa-bookmark::before {
        font-size: 13px !important;
    }
    .count_message1{position:relative; top:25px; display:flex; justify-content:space-between;}
    #char-count, #error-message-count{font-size:12px;}
    .singel-posted span{font-size: 12px;}

    @media only screen and (max-width:767px){
        .payment-div{width:90%; margin:0 auto;}
        .job-post-header{padding:10px;}
    }
</style>
<?php
   $neimg = trim($blog->image1, '[""]');
   $img = explode('","', $neimg);
   
   $itemFeaturedImages = trim($blog->image1, '[""]');
   $itemFeaturedImage = explode('","', $itemFeaturedImages);
   $count = count($itemFeaturedImage);


// $posts = BlogCategoryRelation::join('blogs', 'blogs.id', '=', 'blog_category_relation.blog_id')
//     ->where('blogs.status', '=', '1')
//     ->where('blog_category_relation.category_id', '=', 7)
//     ->select('blogs.*') 
//     ->get();

   ?>
<section id="job-post">
   <div class="container">
      <div class="row">
         <div class="col-lg-12 prev-next-arrows">
            <div class="left-arrow">
               <a href="@if($nextPostId != null){{route('single.fundraisers', $nextPostId)}} @else # @endif"
                  class="{{ $nextPostId == null ? 'disabled' : '' }}"><i class="bi bi-arrow-left"></i>
               <span>Prev</span></a>
            </div>
            <div class="right-arrow1">
               <a href="@if($previousPostId != null){{route('single.fundraisers', $previousPostId)}} @else # @endif"
                  class="{{ $previousPostId == null ? 'disabled' : '' }}"><span>Next</span> <i
                  class="bi bi-arrow-right"></i></a>
            </div>
         </div>
      </div>
      <div class="row">
         <span>
         @include('admin.partials.flash_messages')
         </span>
         <div class="col-lg-8 col-md-8 mb-4 mb-lg-0">
            <div class="bg-white" style="padding: 20px;margin-top: 20px;border-radius: 10px;">
               <div class="job-post-header">
                  <div class="row">
                     <div class="col-lg-3 col-md-3">
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
                                       onerror="this.onerror=null; this.src='https://www.finderspage.com/public/images_blog_img/1688636936.jpg';">
                                    </a>
                                 </div>
                                 <?php    
                                       }
                                    }
                                 ?>
                                 @if($blog->post_video)
                                 <div class="carousel-item">
                                    <a href="{{asset('images_blog_video')}}/{{$blog->post_video}}"
                                       data-lightbox="carousel">
                                       <video width="320" height="240" controls class="d-block w-100">
                                          <source
                                             src="{{asset('images_blog_video')}}/{{$blog->post_video}}"
                                             type="video/mp4">
                                       </video>
                                    </a>
                                 </div>
                                 @endif
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
                           <div class="job-type job-p mt-1" style="display:none;">
                              <?php
                                 if ($blog->post_by == 'admin') {
                                     foreach ($admins as $add) {
                                         if ($blog->user_id == $add->id) {
                                             $userName = $add->first_name;
                                             $userAddress = $add->address;
                                             $website = $add->business_website;
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
                                             echo '<img src="' . asset($add->image) . '" alt="Image">';
                                             echo '<p>' . $blog->title . '<br><small>By ' . $add->first_name . '</small></p>';
                                         }
                                     }
                                 } else {
                                     // Assuming $users is an array or collection
                                     foreach ($users as $user) {
                                         if ($blog->user_id == $user->id) {
                                             $userName = $user->first_name;
                                             $userAddress = $user->address;
                                             $website = $user->business_website;
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
                                 
                                             echo '<img src="' . asset('assets/images/profile') . '/' . $user->image . '" alt="Image">';
                                             echo '<p>' . $blog->title . '<br><small>By ' . $user->first_name . '</small></p>';
                                         }
                                     }
                                 }
                                 
                                                                         ?>
                           </div>
                           <!-- <img src="./new_assets/assets/images/business.png" class="w-100 h-100" alt="..."> -->
                        </div>
                     </div>
                     <div class="col-lg-9 col-md-9">
                        <div class="job-post-content">
                           <h2>{{$blog->title}}</h2>
                           <div class="job-type">
                              <ul class="job-list">
                                 <!-- @if($blog->pay_by == 'Fixed')
                                    <li><span><i class="bi bi-cash"></i></span>Fixed  ${{$blog->fixed_pay}} / {{ ucfirst($blog->rate) }}</li>
                                    @else
                                    <li><span><i class="bi bi-cash"></i></span>Range ${{$blog->min_pay}} - ${{$blog->max_pay}} / {{ ucfirst($blog->rate) }}</li>
                                    @endif -->
                                 
                                 @if($blog->personal_detail == 'true')
                                 <li><span><i class="bi bi-globe"></i></span><a href="{{$blog->website}}"
                                    target="_blank">{{$blog->website}}</a></li>
                                 @endif
                                 @if($blog->email == !null)
                                 <li><span><i class="bi bi-envelope"></i></span>{{$blog->email}}</li>
                                 @endif
                              </ul>
                              <hr>
                              <div class="row">
                                 <div class="col-lg-5 col-md-6 col-6 singel-post-by"
                                    style="border-right: 1px solid #c6c7c8;"><b>Posted by : </b>
                                    @if(UserAuth::isLogin())
                                    <a target="blank"
                                       href="{{route('UserProfileFrontend', $userSlug->slug)}}">
                                    {{$userName}}</a>
                                    @elseif(AdminAuth::isLogin())
                                    <a target="blank"
                                       href="{{route('UserProfileFrontend.admin', $userSlug->slug)}}">
                                    {{$userName}}</a>
                                    @else
                                    <a target="blank" href="{{route('auth.signupuser')}}"
                                       onclick="showAlertForSave()"> {{$userName}}</a>
                                    @endif
                                 </div>
                                 <div class="col-lg-4 col-md-6 col-6 singel-posted"
                                    style="border-right: 1px solid #c6c7c8;"><b>Posted:</b>
                                    <span>
                                    <?php
                                       $givenTime = strtotime($blog->created);
                                       // echo"<pre>";print_r($givenTime);die();
                                       $currentTimestamp = time();
                                       $timeDifference = $currentTimestamp - $givenTime;
                                       
                                       $days = floor($timeDifference / (60 * 60 * 24));
                                       // echo"<pre>";print_r($days);die();
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
                                          $timeAgo .= " Today "; 
                                       }
                                       echo $timeAgo;
                                       // echo"<pre>";print_r($timeAgo);die();
                                       ?>
                                       </span>
                                 </div>

                                 {{-- @if ($BlogLikes->isNotEmpty() && UserAuth::isLogin())
                                    
                                        <div class="col">
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
                                                    <button type="button" class="like-button" id="toggleLikes" data-user-id="{{ $userId }}" data-blog-id="{{ $like->blog_id }}" data-blog-user-id="{{ $blog->user_id }}" data-type="Fundraisers" data-cate-id="7" data-url={{ route('single.fundraisers', $blog->slug) }}>
                                                  @else
                                                    <button type="button" class="like-button" id="toggleLikes" data-user-id="{{ UserAuth::getLoginId() }}" data-blog-id="{{ $blog->id }}" data-blog-user-id="{{ $blog->user_id }}" data-type="Fundraisers" data-cate-id="7" data-url={{ route('single.fundraisers', $blog->slug) }} style="padding: 6px 8px !important; width: auto !important; margin: 0 !important;">
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
                                   

                                @elseif ($blog->user_id == UserAuth::getLoginId())
                                    <div class="col">
                                        @if(UserAuth::isLogin())
                                            <div class="likes-container">
                                                <div class="likes-info">
                                                    <b>Likes: </b>
                                                    <span class="likes-preview">no likes</span>
                                                </div>
                                                <div class="">
                                                    <button type="button" class="like-button" id="toggleLikes" data-user-id="{{ UserAuth::getLoginId() }}" data-blog-id="{{ $blog->id }}" data-blog-user-id="{{ $blog->user_id }}" data-type="Fundraisers" data-cate-id="7" data-url={{ route('single.fundraisers', $blog->slug) }}>
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
                                @else 
                                    <div class="col">
                                        @if(UserAuth::isLogin())
                                            <div class="likes-container">
                                                <div class="">
                                                    <button type="button" class="like-button" id="toggleLikes" data-user-id="{{ UserAuth::getLoginId() }}" data-blog-id="{{ $blog->id }}" data-blog-user-id="{{ $blog->user_id }}" data-type="Fundraisers" data-cate-id="7" data-url={{ route('single.fundraisers', $blog->slug) }}>
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
                           <div class="job-type">
                              <!-- <ul>
                                 <li>Full Time</li>
                                 <li>Private </li>
                                 <li>Urgent</li>
                                 </ul> -->
                           </div>
                        </div>
                     </div>
                     <div class="job-detail pt-2 mt-5">
                        @if(!empty($blog->description))
                        <h4>Description</h4>
                        <div calss="contentArea">
                           <p class="link-text"><?php echo Setting::makeUrlsClickable($blog->description); ?></p>
                           
                        </div>
                        @endif
                     </div>
                     <div class="py-2 mt-5 payment-div">
                     <h4>Amount to raise</h4>
                     <div class="QR-box d-flex align-items-center flex-wrap text-white fw-bold"><span class="fs-5">$</span>{{$blog->price}}</div>
                     
                     </div>
                     
                    <div class="py-2 mt-5">
                        <h4>Donate</h4>
                        @php
                            $decodedWebsites = json_decode($blog->payment_links);
                        @endphp
                        <div class="QR-box d-flex flex-wrap">
                            @if (is_array($decodedWebsites) && count($decodedWebsites) > 0)
                                @foreach ($decodedWebsites as $website)
                                    <a target="_blank" class="btn create-post-button mb-2" href="{{ $website->url }}">
                                        {{ trim($website->name) !== '' ? ucfirst($website->name) : $website->url }}
                                    </a>
                                @endforeach
                            @endif
                        </div>
                    </div>

                     <div class="butons align-items-baseline py-3">
                        @if(UserAuth::isLogin())
                           <button type="button" class="fundraiser-comments">
                              <i class="far fa-comment-dots"></i>
                           </button>
                        
                           <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal1" data-toggle="tooltip" data-placement="top" title="Report post" class="social-thumb-icon" style="background: #141212;">
                              <i class="fa-regular fa-flag"></i>
                           </button>
                        @else 
                           <button type="button" class="blank-btn" onclick="showAlertForSave()">
                              <i class="far fa-comment-dots"></i>
                           </button>
                        
                           <button type="button" class="blank-btn" onclick="showAlertForSave()">
                              <i class="fa-regular fa-flag"></i>
                           </button>
                        @endif

                     </div>
                     <div class="col-lg-12 col-md-12 show-comments mt-3 ms-0">
                        <div class="comments-header">
                            <h5>Post Comments</h5>
                            <button type="button" class="fundraiser-comments">
                                <i class="fas fa-close"></i>
                            </button>
                        </div>
                        <div class="comments-box">
                           <ul class="list-unstyled w-100" id="comments-list">
                               @foreach($BlogComments as $comm)
                                   @foreach($users as $user)
                                       @if($user->id == $comm->user_id && $comm->blog_id == $blog->id)
                                               <li class="comment-item{{ $comm->id }}">
                                                   <div class="comment-header">
                                                       <div class="img-icon">
                                                           <a href="{{ route('UserProfileFrontend', $user->slug) }}">
                                                                <img class="img-fluid rounded-circle" alt="image" height="40" width="40" src="{{ asset('assets/images/profile/' . $user->image) }}">
                                                           </a>
                                                       </div>
                                                       
                                                       <div class="comments-area">
                                                            <div class="d-flex align-items-center">
                                                              @if ( $comm->pin == '1')
                                                                <div class="w-100">
                                                                    <a href="{{ route('UserProfileFrontend', $user->slug) }}">
                                                                        {{ $user->first_name }}
                                                                        <i class="fa fa-thumb-tack" aria-hidden="true"></i>
                                                                    </a>
                                                                    <p>{{ $comm->comment }}</p>
                                                                </div>
                                                              @else
                                                                <div class="w-100">
                                                                  <a href="{{ route('UserProfileFrontend', $user->slug) }}">{{ $user->first_name }}</a>
                                                                  <p>{{ $comm->comment }}</p>
                                                                </div>
                                                              @endif
                                                                <!-- Like Preview Section -->
                                                                <div class="text-center like-preview">
                                                                    @php
                                                                        $userId = UserAuth::getLoginId();
                                                                        $liked_by = !empty($comm->liked_by) ? json_decode($comm->liked_by, true) : [];
                                                                        $likeCount = count($liked_by);
                                                                    @endphp
                                                                
                                                                    <i class="{{ in_array($userId, $liked_by) ? 'fa fa-heart' : 'fa fa-heart-o' }} like-icon" 
                                                                       aria-hidden="true" 
                                                                       data-comment-id="{{ $comm->id }}" 
                                                                       data-user-id="{{ $userId }}"></i>

                                                                    @if ($blog->user_id == UserAuth::getLoginId())
                                                                        <div class="like-count" onclick="showLikesModal({{ $comm->id }})">{{ $likeCount }}</div>
                                                                    @endif

                                                                    <!-- Likes Modal -->
                                                                    <div id="likesModal" class="likes-modal" style="display: none;">
                                                                        <div class="modal-content">
                                                                            <span class="close" onclick="closeLikesModal()">&times;</span>
                                                                            <h2>Likes</h2>
                                                                            <div class="likes-list">

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                           <div class="comment-actions">
                                                                @if ($comm->status == 1)
                                                                    <button type="button" class="btn btn-reply" data-bs-toggle="modal" data-bs-target="#replyModal{{ $comm->id }}">Reply</button>
                                                                @else 
                                                                    <button type="button" class="btn btn-reply"><del>Reply</del></button>
                                                                @endif
                                                               @if (UserAuth::getLoginId() == $blog->user_id)
                                                                @if ($comm->status == 1)
                                                                    <button type="button" class="btn btn-hide hide_comment" data-id="{{ $comm->id }}" blog-id="{{ $blog->id }}" blog-user="{{$blog->user_id}}">Hide</button>
                                                                @else 
                                                                    <button type="button" class="btn btn-hide unhide_comment" data-id="{{ $comm->id }}" blog-id="{{ $blog->id }}" blog-user="{{$blog->user_id}}">Unhide</button>
                                                                @endif
                                                               @endif
                                                           </div>
                                                       </div>
                       
                                                        @if ($comm->status == '1')
                                                           <div class="dots-menu btn-group">
                                                             @if(UserAuth::getLoginId() == $comm->user_id || UserAuth::getLoginId() == $blog->user_id)
                                                               <a data-toggle="dropdown" class="btn btn-primary" onclick="showDropdown({{ $comm->id }})"><i class='fas fa-ellipsis-v'></i></a>
                                                               <ul class="dropdown-menu" id="dropdown-{{ $comm->id }}">
                                                                @if (UserAuth::getLoginId() == $blog->user_id)
                                                                    @if ($comm->pin == '0')
                                                                    <li>
                                                                        <a data-blog-id="{{ $blog->id }}"
                                                                                data-comment-id="{{ $comm->id }}"
                                                                                data-blog-user="{{ $blog->user_id }}"
                                                                                data-url="{{ route('fundraisers', $blog->slug) }}"
                                                                                onclick="pin_comment({{ $comm->id }})">
                                                                            <i class="fa fa-thumb-tack" aria-hidden="true"></i>
                                                                        </a>
                                                                    </li>
                                                                    @else 
                                                                        <li>
                                                                            <a data-blog-id="{{ $blog->id }}"
                                                                                data-comment-id="{{ $comm->id }}"
                                                                                data-blog-user="{{ $blog->user_id }}"
                                                                                data-url="{{ route('fundraisers', $blog->slug) }}"
                                                                                onclick="unpin_comment({{ $comm->id }})">
                                                                                <i class="fa fa-thumbtack-slash" aria-hidden="true"></i>
                                                                            </a>
                                                                        </li>
                                                                    @endif
                                                                @endif
                                                                
                                                                @if(UserAuth::getLoginId() == $comm->user_id)
                                                                   <li><a class="btn button_for" data-bs-toggle="modal" href="#editModal{{ $comm->id }}"><i class="fa fa-pencil" style="font-size: 13px;"></i></a></li>
                                                                @endif
                                                                   <li><a class="btn btn-danger button_for" onclick="deleteComment({{ $comm->id }})"><i class="fa fa-trash-o"></i></a></li>
                                                               </ul>
                                                             @endif
                                                           </div>
                                                       @endif
                                                   </div>
                       
                                                   <!-- Modal for replying to a comment -->
                                                   <div class="modal fade" id="replyModal{{ $comm->id }}" tabindex="-1" aria-labelledby="replyModalLabel{{ $comm->id }}" aria-hidden="true">
                                                       <div class="modal-dialog modal-dialog-centered">
                                                           <div class="modal-content">
                                                               <div class="modal-header">
                                                                   <h5 class="modal-title" id="replyModalLabel{{ $comm->id }}">Reply</h5>
                                                                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                               </div>
                                                               <div class="modal-body">
                                                                   <p>{{ $comm->comment }}</p>
                                                                   <div class="row">
                                                                       <div class="col-lg-12">
                                                                           <div class="reply-box" id="reply-box-{{ $comm->id }}">
                                                                               <div id="emojiButton-{{ $comm->id }}" class="emojiButton my-auto"><i class="far fa-smile"></i></div>
                                                                                <div id="emojiPicker-{{ $comm->id }}" class="emojiPicker hidden">
                                                                                    <span class="emoji" onclick="insertEmoji('{{ $comm->id }}', '😊')">😊</span>
                                                                                    <span class="emoji" onclick="insertEmoji('{{ $comm->id }}', '😂')">😂</span>
                                                                                    <span class="emoji" onclick="insertEmoji('{{ $comm->id }}', '❤️')">❤️</span>
                                                                                    <span class="emoji" onclick="insertEmoji('{{ $comm->id }}', '👍')">👍</span>
                                                                                    <span class="emoji" onclick="insertEmoji('{{ $comm->id }}', '😢')">😢</span>
                                                                                    <span class="emoji" onclick="insertEmoji('{{ $comm->id }}', '😎')">😎</span>
                                                                                    <span class="emoji" onclick="insertEmoji('{{ $comm->id }}', '🤔')">🤔</span>
                                                                                    <span class="emoji" onclick="insertEmoji('{{ $comm->id }}', '🥳')">🥳</span>
                                                                                    <span class="emoji" onclick="insertEmoji('{{ $comm->id }}', '🔥')">🔥</span>
                                                                                    <span class="emoji" onclick="insertEmoji('{{ $comm->id }}', '🙌')">🙌</span>
                                                                                    <span class="emoji" onclick="insertEmoji('{{ $comm->id }}', '😇')">😇</span>
                                                                                </div>
                                                                               <input type="text" class="form-control reply_text" placeholder="Write a reply..." id="reply-input-{{ $comm->id }}">
                                                                               <button type="button" class="btn btn-primary sendreply"
                                                                                   blog-id="{{ $blog->id }}"
                                                                                   blog-user="{{ $blog->user_id }}"
                                                                                   userid="{{ UserAuth::getLoginId() }}"
                                                                                   comment-id="{{ $comm->id }}"
                                                                                   data-url="{{ route('fundraisers', $blog->slug) }}"
                                                                                   data-bs-dismiss="modal">Reply</button>
                                                                           </div>
                                                                       </div>
                                                                   </div>
                                                               </div>
                                                           </div>
                                                       </div>
                                                   </div>
                       
                                                   <!-- Modal for editing comment -->
                                                    <div class="modal fade" id="editModal{{ $comm->id }}" aria-hidden="true" aria-labelledby="editModalLabel{{ $comm->id }}" tabindex="-1">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content my-cont">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="editModalLabel{{ $comm->id }}">Edit Comment</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="reply-box">
                                                                        <div id="editEmojiButton-{{ $comm->id }}" class="emojiButton my-auto">
                                                                            <i class="far fa-smile"></i>
                                                                        </div>
                                                                        <div id="editEmojiPicker-{{ $comm->id }}" class="emojiPicker hidden">
                                                                            <span class="emoji" onclick="insertEmojiToComment('{{ $comm->id }}', '😊')">😊</span>
                                                                            <span class="emoji" onclick="insertEmojiToComment('{{ $comm->id }}', '😂')">😂</span>
                                                                            <span class="emoji" onclick="insertEmojiToComment('{{ $comm->id }}', '❤️')">❤️</span>
                                                                            <span class="emoji" onclick="insertEmojiToComment('{{ $comm->id }}', '👍')">👍</span>
                                                                            <span class="emoji" onclick="insertEmojiToComment('{{ $comm->id }}', '😢')">😢</span>
                                                                            <span class="emoji" onclick="insertEmojiToComment('{{ $comm->id }}', '😎')">😎</span>
                                                                            <span class="emoji" onclick="insertEmojiToComment('{{ $comm->id }}', '🤔')">🤔</span>
                                                                            <span class="emoji" onclick="insertEmojiToComment('{{ $comm->id }}', '🥳')">🥳</span>
                                                                            <span class="emoji" onclick="insertEmojiToComment('{{ $comm->id }}', '🔥')">🔥</span>
                                                                            <span class="emoji" onclick="insertEmojiToComment('{{ $comm->id }}', '🙌')">🙌</span>
                                                                            <span class="emoji" onclick="insertEmojiToComment('{{ $comm->id }}', '😇')">😇</span>
                                                                        </div>
                                                                        <input type="text" value="{{ $comm->comment }}" class="form-control edit-comment" id="commentInput-{{ $comm->id }}">
                                                                        <button type="button"
                                                                            comment_id="{{ $comm->id }}"
                                                                            blog-id="{{ $blog->id }}"
                                                                            blog-user="{{ $blog->user_id }}"
                                                                            data-url="{{ route('fundraisers', $blog->slug) }}"
                                                                            class="btn btn-primary update-comment"
                                                                            data-bs-dismiss="modal">
                                                                            Update
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                   @foreach($BlogCommentsReply as $comReply)
                                                       @if($comReply->com_id == $comm->id)
                                                           @php
                                                               $commentReply = BlogComments::select('user_id')->where('id', $comReply->id)->first();
                                                               $commentedUser = $commentReply ? UserAuth::getUser($commentReply->user_id) : null;
                                                           @endphp
                                                            <div class="comment-header mb-3" style="padding-left: 1.5rem; padding-rigth: 0.6rem;">
                                                                <div class="img-icon">
                                                                    <a href="{{ route('UserProfileFrontend', $commentedUser->slug) }}">
                                                                        <img class="img-fluid rounded-circle" alt="image" height="40" width="40" src="{{ asset('assets/images/profile/' . ($commentedUser->image ?? 'default.png')) }}">
                                                                    </a>
                                                                </div>
                                    
                                                                <div class="comments-area">
                                                                    <a href="{{ route('UserProfileFrontend', $commentedUser->slug) }}">{{ $commentedUser->first_name ?? 'Anonymous' }}</a>
                                                                    <p>{{ $comReply->comment }}</p>
                                                                </div>
                                                                
                                                                <div class="text-center like-preview">
                                                                    @php
                                                                        $userId = UserAuth::getLoginId();
                                                                        $liked_by = !empty($comReply->liked_by) ? json_decode($comReply->liked_by, true) : [];
                                                                        $likeCount = count($liked_by);
                                                                    @endphp
                                                                
                                                                    <i class="{{ in_array($userId, $liked_by) ? 'fa fa-heart' : 'fa fa-heart-o' }} like-icon" 
                                                                       aria-hidden="true" 
                                                                       data-comment-id="{{ $comReply->id }}" 
                                                                       data-user-id="{{ $userId }}"></i>
                                                                
                                                                    @if ($blog->user_id == UserAuth::getLoginId())
                                                                        <div class="like-count" onclick="showLikesModal({{ $comReply->id }})">{{ $likeCount }}</div>
                                                                    @endif

                                                                    <!-- Likes Modal -->
                                                                    <div id="likesModal" class="likes-modal" style="display: none;">
                                                                        <div class="modal-content">
                                                                            <span class="close" onclick="closeLikesModal()">&times;</span>
                                                                            <h2>Likes</h2>
                                                                            <div class="likes-list">

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @if($comReply->user_id == UserAuth::getLoginId() || $blog->user_id == UserAuth::getLoginId())
                                                                    <div class="dots-menu btn-group">
                                                                        <a data-toggle="dropdown" class="btn btn-secondary" onclick="showDropdown({{ $comReply->id }})"><i class='fas fa-ellipsis-v'></i></a>
                                                                        <ul class="dropdown-menu" id="dropdown-{{ $comReply->id }}">
                                                                            @if($comReply->user_id == UserAuth::getLoginId())
                                                                                <li><a class="btn button_for" data-bs-toggle="modal" href="#editModal{{ $comReply->id }}"><i class="fa fa-pencil" style="font-size: 13px;"></i></a></li>
                                                                            @endif
                                                                            <li><a class="btn btn-danger button_for" onclick="deleteComment({{ $comReply->id }})"><i class="fa fa-trash-o"></i></a></li>
                                                                        </ul>
                                                                    </div>
                                                                @endif
                                                            </div>

                                                            <!-- Modal for replying to a comment -->
                                                            <div class="modal fade" id="replyModal{{ $comReply->id }}" tabindex="-1" aria-labelledby="replyModalLabel{{ $comReply->id }}" aria-hidden="true">
                                                               <div class="modal-dialog modal-dialog-centered">
                                                                  <div class="modal-content">
                                                                     <div class="modal-header">
                                                                           <h5 class="modal-title" id="replyModalLabel{{ $comReply->id }}">Reply</h5>
                                                                           <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                     </div>
                                                                     <div class="modal-body">
                                                                           <p>{{ $comReply->comment }}</p>
                                                                           <div class="row">
                                                                              <div class="col-lg-12">
                                                                                 <div class="reply-box" id="reply-box-{{ $comReply->id }}">
                                                                                       <input type="text" class="form-control reply_text" placeholder="Write a reply..." id="reply-input-{{ $comReply->id }}">
                                                                                       <button type="button" class="btn btn-primary sendreply"
                                                                                          blog-id="{{ $blog->id }}"
                                                                                          blog-user="{{ $blog->user_id }}"
                                                                                          userid="{{ UserAuth::getLoginId() }}"
                                                                                          comment-id="{{ $comReply->id }}"
                                                                                          data-url="{{ route('fundraisers', $blog->slug) }}"
                                                                                          data-bs-dismiss="modal">Reply</button>
                                                                                 </div>
                                                                              </div>
                                                                           </div>
                                                                     </div>
                                                                  </div>
                                                               </div>
                                                         </div>
                              
                                                         <!-- Modal for editing comment -->
                                                         <div class="modal fade" id="editModal{{ $comReply->id }}" aria-hidden="true" aria-labelledby="editModalLabel{{ $comReply->id }}" tabindex="-1">
                                                               <div class="modal-dialog modal-dialog-centered">
                                                                  <div class="modal-content my-cont">
                                                                     <div class="modal-header">
                                                                           <h5 class="modal-title" id="editModalLabel{{ $comReply->id }}">Edit Comment</h5>
                                                                           <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                     </div>
                                                                     <div class="modal-body">
                                                                           <div class="reply-box">
                                                                           <div id="replyEmojiButton-{{ $comReply->id }}" class="emojiButton my-auto"><i class="far fa-smile"></i></div>
                                                                           <div id="replyEmojiPicker-{{ $comReply->id }}" class="emojiPicker hidden">
                                                                                <span class="emoji" onclick="insertEmojiToReply('{{ $comReply->id }}', '😊')">😊</span>
                                                                                <span class="emoji" onclick="insertEmojiToReply('{{ $comReply->id }}', '😂')">😂</span>
                                                                                <span class="emoji" onclick="insertEmojiToReply('{{ $comReply->id }}', '❤️')">❤️</span>
                                                                                <span class="emoji" onclick="insertEmojiToReply('{{ $comReply->id }}', '👍')">👍</span>
                                                                                <span class="emoji" onclick="insertEmojiToReply('{{ $comReply->id }}', '😢')">😢</span>
                                                                                <span class="emoji" onclick="insertEmojiToReply('{{ $comReply->id }}', '😎')">😎</span>
                                                                                <span class="emoji" onclick="insertEmojiToReply('{{ $comReply->id }}', '🤔')">🤔</span>
                                                                                <span class="emoji" onclick="insertEmojiToReply('{{ $comReply->id }}', '🥳')">🥳</span>
                                                                                <span class="emoji" onclick="insertEmojiToReply('{{ $comReply->id }}', '🔥')">🔥</span>
                                                                                <span class="emoji" onclick="insertEmojiToReply('{{ $comReply->id }}', '🙌')">🙌</span>
                                                                                <span class="emoji" onclick="insertEmojiToReply('{{ $comReply->id }}', '😇')">😇</span>
                                                                            </div>
                                                                              <input type="text" value="{{ $comReply->comment }}" class="form-control edit-comment" id="comReplyInput-{{ $comReply->id }}">
                                                                              <button comment_id="{{ $comReply->id }}" blog-id="{{ $blog->id }}" blog-user="{{$blog->user_id}}" data-url="{{ route('fundraisers', $blog->slug) }}" class="btn btn-primary update-comReply" data-bs-dismiss="modal">Update</button>
                                                                           </div>
                                                                     </div>
                                                                  </div>
                                                               </div>
                                                         </div>

                                                       @endif
                                                   @endforeach
                                               </li>
                                           @endif
                                   @endforeach
                               @endforeach

                               {{-- @foreach ($hiddenComments as $comm)
                               @if ($comm->user_id == UserAuth::getLoginId())
                                 @php
                                   $commUserSlug = UserAuth::getUserSlug($comm->user_id);
                                   $commUser = UserAuth::getUser($comm->user_id);
                                 @endphp
                                 <li class="comment-item">
                                   <span class="show-hidden">
                                     <i class="fa fa-eye-slash" aria-hidden="true"></i> See Hidden
                                   </span>
                                   <div class="hidden-section">
                                     <div class="comment-header">
                                       <div class="img-icon">
                                         <img class="img-fluid rounded-circle" alt="User Image" height="40" width="40" src="{{ asset('assets/images/profile/' . $commUser->image) }}">
                                       </div>
                                       <div class="comments-area">
                                         <a href="{{ route('UserProfileFrontend', $commUserSlug->slug) }}">{{ $commUser->first_name }}</a>
                                         <p>{{ $comm->comment }}</p>
                                       </div>
                                       <div class="comment-actions">
                                          <button type="button" class="btn btn-hide unhide_comment" data-id="{{ $comm->id }}" blog-id="{{ $blog->id }}" blog-user="{{$blog->user_id}}">Unhide</button>
                                      </div>
                                     </div>
                                   </div>
                                 </li>
                               @endif
                             @endforeach --}}
                             

                           </ul>
                       </div>

                        <div class="emojis" id="emoji-container" style="display: none;">
                            <span data-emoji="❤️">&#10084;</span>
                            <span data-emoji="🙌">&#x1F525;</span>
                            <span data-emoji="🔥">&#x1F44F;</span>
                            <span data-emoji="👏">&#128525;</span>
                            <span data-emoji="😍">&#x1F622;</span>
                            <span data-emoji="😢">&#x1F62E;</span>
                            <span data-emoji="😮">&#x1F602;</span>
                            <span data-emoji="😂">&#x1F923;</span>
                            <span data-emoji="🤣">&#x1F60A;</span>
                            <span data-emoji="😊">&#128536;</span>
                            <span data-emoji="😖">&#x1F4AF;</span>
                            <span data-emoji="💯">&#x1F44C;</span>
                            <span data-emoji="👌">&#x1F44B;</span>
                            <span data-emoji="👋">&#x270B;</span>
                            <span data-emoji="✋">&#x1F91F;</span>
                            <span data-emoji="🤟">&#x1F91A;</span>
                            <span data-emoji="🎉">&#x1F389;</span>
                            <span data-emoji="💖">&#10083;</span>
                        </div>
                        <div class="add-comments">
                            <div class="comment-emoji m-auto" id="toggle-emojis"> 
                                <i class="far fa-smile fs-4"></i>
                            </div>
                            <input type="text" id="comment-input" class="comment_count" placeholder="Add Comment" name="add_comment">
                            <button id="sendbtn" class="btn btn-warning" blog-id="{{$blog->id}}" blog-user="{{$blog->user_id}}" user-id="{{UserAuth::getLoginId()}}" data-url="{{route('fundraisers', $blog->slug)}}">Send</button>
                        </div>
                        <div class="count_message1">
                            <div id="char-count" class="">180 characters remaining</div>
                            <div id="error-message-count" class="" style="color:red;"></div>
                        </div>

                    </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-lg-4 col-md-4 mb-4 mb-lg-0">
            <div class="Job-right-sidebar bg-white">
               <div class="job-overview">
                  <h4>Fundraiser Overview</h4>
                  <ul class="job-overview-new p-0">
                     @if(!empty($blog->location))
                     <li>
                        <i class="bi bi-geo-alt"></i>
                        <h6>Location:</h6>
                        <span>{{$blog->location}}</span>
                     </li>
                     @endif
                    
                     @if($blog->personal_detail == 'true')
                     <li>
                        <i class="bi bi-card-checklist"></i>
                        <h6 style="margin-bottom: 10px;">Personal details:</h6>

                        @if($blog->phone)
                            <li>
                                <i class="bi bi-telephone-fill"></i>
                                    <h6>Phone:</h6>
                                    <span><a href="tel:{{$blog->phone}}"
                                    target="_blank;">{{$blog->phone}}</a></span>
                            </li>
                        @endif

                        @if($blog->email)
                            <li>
                                <i class="bi bi-envelope-fill"></i>
                                    <h6>Email:</h6>
                                    <span><a href="mailto:{{$blog->email}}"
                                    target="_blank;">{{$blog->email}}</a></span>
                            </li>
                        @endif

                        @if($blog->whatsapp)
                            <li>
                                <i class="fab fa-whatsapp" aria-hidden="true"></i>
                                    <h6>whatsapp:</h6>
                                    <span><a target="_blank;">{{$blog->whatsapp}}</a></span>
                            </li>
                        @endif
                    
                        @if($blog->facebook)
                            <a href="{{$facebook}}" target="_blank" class="facebook">
                                <i style="position: inherit;" class="fab fa-facebook-f" aria-hidden="true"></i>
                            </a>
                        @endif
                        @if($blog->linkedin)
                            <a href="{{$linkedin}}" target="_blank" class="linkedin">
                                <i style="position: inherit;" class="fab fa-linkedin-in" aria-hidden="true"></i>
                            </a>
                        @endif
                        @if($blog->instagram)
                            <a href="{{$instagram}}" target="_blank" class="instagram">
                                <i style="position: inherit;" class="fab fa-instagram" aria-hidden="true"></i>
                            </a>
                        @endif
                        
                        @if($blog->youtube)
                            <a href="{{$youtube}}" target="_blank" class="youtube">
                                <i style="position: inherit;" class="fab fa-youtube" aria-hidden="true"></i>
                            </a>
                        @endif
                        @if($blog->Tiktok)
                            <a href="https://www.tiktok.com/{{$Tiktok}}" target="_blank" class="Tiktok">
                                <i style="position: inherit;" class="bi bi-tiktok" aria-hidden="true"></i>
                            </a>
                        @endif
                     </li>
                     @endif
                     <li>
                        <div class="single-job-apply d-flex flex-wrap justify-content-start gap-2">
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
                                <button type="button" class="like-button" id="toggleLikes" data-user-id="{{ $userId }}" data-blog-id="{{ $like->blog_id }}" data-blog-user-id="{{ $blog->user_id }}" data-type="Fundraisers" data-cate-id="7" data-url={{ route('single.fundraisers', $blog->slug) }}>
                                @else
                                <button type="button" class="like-button" id="toggleLikes" data-user-id="{{ UserAuth::getLoginId() }}" data-blog-id="{{ $blog->id }}" data-blog-user-id="{{ $blog->user_id }}" data-type="Fundraisers" data-cate-id="7" data-url={{ route('single.fundraisers', $blog->slug) }} style="padding: 6px 8px !important; width: auto !important; margin: 0 !important;">
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
                                        <button type="button" class="like-button" id="toggleLikes" data-user-id="{{ UserAuth::getLoginId() }}" data-blog-id="{{ $blog->id }}" data-blog-user-id="{{ $blog->user_id }}" data-type="Fundraisers" data-cate-id="7" data-url={{ route('single.fundraisers', $blog->slug) }}>
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
                                <button class="btn create-post-button overview-comment">
                                    <i class="fa-regular fa-comment"></i>
                                </button>
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
                                <a data-postid="{{ $blog->id }}" data-type="Fundraisers" data-Userid="{{ UserAuth::getLoginId() }}"
                                   class="{{ $existingRecord ? 'unsaved_post_btn' : 'saved_post_btn' }} apply btn create-post-button"
                                   href="javascript:void(0);">
                                    <i class="{{ $existingRecord ? 'fa-solid' : 'fa-regular' }} fa-bookmark" style="{{ $existingRecord ? 'color: #131313;' : '#fff;' }}"></i>
                                </a>
                            </div>                            
                            
                        </div>
                        
                           <!--Share Modal Start-->
                           <div class="modal fade share-modal" id="staticBackdrop" data-bs-backdrop="static"
                              data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                              aria-hidden="true">
                              <div class="modal-dialog">
                                 <div class="modal-content">
                                    <div class="modal-header border-0">
                                       <button type="button" class="btn-close" data-bs-dismiss="modal"
                                          aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                       <div class="copy-text">
                                          <input type="text" class="text"
                                                value="{{url('/fundraiser/single/')}}/{{$blog->slug}}"
                                                id="field_input" />
                                            <a href="javascript:void(0);"
                                                redirect-url="{{url('/chatify')}}/{{$user->id}}"
                                                copy-url="{{url('/fundraiser/single/')}}/{{$blog->slug}}"
                                                class="copy_url btn create-post-button ms-2"
                                                data-placement="top" data-toggle="tooltip"
                                                title="Share in Chat">
                                              <i class="fa fa-clone"></i>
                                            </a>
                                        </div>
                                            <hr>
                                              <div class="copy-text">
                                                <input type="text" class="text" value="Share link via email" readonly id="email_input"/>
                                                    <a href="mailto:{{$user_all_data->email }}?subject={{$blog->title}}&body=Page link : {{url('/fundraiser/single/')}}/{{$blog->slug}}" class="btn create-post-button ms-2" data-placement="top" data-toggle="tooltip" title="Email">
                                                        <i class="fa-solid fa-envelope"></i>
                                                    </a>
                                              </div>
                                       <div class="share-by">
                                          <i class="fa fa-share-alt" aria-hidden="true"></i> Share url on
                                          social media, click on the icons below.
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
               <!-- <div class="job-locatin">
                  <h4>Location</h4>
                  <div class="responsive-map">
                      <iframe
                          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2822.7806761080233!2d-93.29138368446431!3d44.96844997909819!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x52b32b6ee2c87c91%3A0xc20dff2748d2bd92!2sWalker+Art+Center!5e0!3m2!1sen!2sus!4v1514524647889"
                          width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
                  </div>
                  </div> -->
               <!--  <div class="job-skill">
                  <h5>Job Skills</h5>
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
               <!-- @if($blog->whatsapp)
                  <a href="whatsapp://send?abid={{$blog->whatsapp}}&text=Hello%2C%20World!" target="_blank" class="whatsapp"><i class="fab fa-whatsapp" aria-hidden="true"></i>Whatsapp</a>
                  @else
                  <a href="whatsapp://send?abid=9898989898&text=Hello%2C%20World!" target="_blank" class="whatsapp"><i class="fab fa-whatsapp" aria-hidden="true"></i>Whatsapp</a>
                  @endif -->
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
            <h3>Related Posts</h3>
         </div>
         <div class="row related-job">
            <div class="col-lg-12 col-md-12">
               <div class="job-post-header">
                  <div class="row">
                     @foreach($relatedjob as $Rjob)
                     <?php    //echo '<pre>'; print_r($Rjob); echo '</pre>'; 
                        ?>
                     <div class="col-lg-2 col-md-3 col-sm-6 col-6 columnJoblistig mb-3">
                        <div class="feature-box">
                           <!-- <div data-postid="{{$Rjob->id}}" data-Userid="{{UserAuth::getLoginId()}}" class="save-btn saved_post_btn" title="Save"><i class="far fa-save" id="save" title="Save"></i></div> -->
                           <a href="{{route('single.fundraisers', $Rjob->slug)}}">
                              <div id="demo-new" class="">
                                 <!-- Indicators/dots -->
                                 <!-- The slideshow/carousel -->
                                 <div class="carousel-inner">
                                    <?php
                                       $itemFeaturedImages = trim($Rjob->image1, '[""]');
                                       $itemFeaturedImage = explode('","', $itemFeaturedImages);
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
                                          onerror="this.onerror=null; this.src='https://www.finderspage.com/public/images_blog_img/1688636936.jpg';">
                                    </div>
                                    <?php        
                                          }
                                       }
                                    ?>
                                    @if($Rjob->post_video)
                                    <!-- <div class="carousel-item">
                                       <video width="100%" height="140" controls class="d-block w-100">
                                       <source src="{{asset('images_blog_video')}}/{{$Rjob->post_video}}" type="video/mp4">
                                       </video>
                                       </div> -->
                                    @endif
                                 </div>
                                 <!-- Left and right controls/icons -->
                                 <!-- <button class="carousel-control-prev" type="button" data-bs-target="#demo-new" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon"></span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#demo-new" data-bs-slide="next">
                                    <span class="carousel-control-next-icon"></span>
                                    </button> -->
                              </div>
                              <p class="job-title">{{ ucfirst($Rjob->title) }}</p>
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
<!-------model apply job--------->
<div class="modal fade job_apply_modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
   aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Apply Now!</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body ">
            <form class="row" action="{{route('apply.job')}}" method="post" enctype="multipart/form-data">
               @csrf
               <input type="hidden" name="job_id" value="{{$blog->id}}">
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
               <div class="col-lg-12 mb-3">
                  <div class="field job-input">
                     <div class="control has-icons-left">
                        <!-- <input type="file" name="file" id="multiple" class="input resume" accept=".pdf,.doc,.docx">
                           <span class="icon is-left">
                           <i class="bi bi-cloud-upload"></i>
                           </span> -->
                        <label for="file-upload" class="custom-file-upload">
                        <i class="fa-solid fa-cloud-arrow-up"></i> Upload Resume
                        </label>
                        <input id="file-upload" type="file" name="file" class="input resume "
                           accept=".pdf,.doc,.docx" />
                     </div>
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
<!-------model apply job--------->
<div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Why are you reporting this post ?</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body ">
            <form id="reportForm">
               @csrf
               <input type="hidden" name="post_id" value="{{$blog->id}}">
               <input type="hidden" name="user_id" value="{{ UserAuth::getLoginId() }}">
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
                  <button type="submit" class="reportSubmit" data-bs-dismiss="modal">Submit</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
   $('.comment_count').on('keypress', function(e) {
        var maxLength = 180;
        var currentLength = $(this).val().length;

        // Prevent typing if the limit is reached
        if (currentLength >= maxLength) {
            e.preventDefault(); // Prevent further input
            $('#error-message-count').text('You cannot type more than 180 characters');
        } else {
            $('#error-message-count').text(''); // Clear error message if under limit
        }
   });

   // Update the character count on keyup
   $('.comment_count').on('keyup', function() {
        var maxLength = 180;
        var currentLength = $(this).val().length;

        // Show the remaining character count
        var remaining = maxLength - currentLength;
        $('#char-count').text(remaining + ' characters remaining');

        // Clear error message when within the limit
        if (currentLength <= maxLength) {
            $('#error-message-count').text('');
        }
   });
});


   $(document).ready(function () {
       $('[data-toggle="tooltip"]').tooltip();
   });

   // document.addEventListener('DOMContentLoaded', function () {
   //    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
   //    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
   //       return new bootstrap.Tooltip(tooltipTriggerEl);
   //    });
   // });

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
           text: "You have to login first.",
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
     $(".show-comments").hide();
     $(".fundraiser-comments").click(function() {
       $(".show-comments").toggle();
     });

     $('#sendbtn').click(function() {
        var comment = $('#comment-input').val().trim();
        var blogId = $(this).attr('blog-id');
        var blog_user = $(this).attr('blog-user');
        var userId = $(this).attr('user-id');
        var url = $(this).data('url');
        var type = 'fundraiser';

        if (comment === '') {
            alert('Comment cannot be empty');
            return;
        }

        $.ajax({
            url: site_url + '/fundraiser/comment',
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                comment: comment,
                video_id: blogId,
                blog_user: blog_user,
                userid: userId,
                type: type,
                url: url,
            },
            success: function(response) {
                console.log(response);
                $('#comments-list').append(response.html);
                $('#comment-input').val('');
                // toastr.success(response.success || 'Comment added successfully.');
            },
            error: function(xhr, status, error) {
               console.error('AJAX Error: ' + status + error);

               var responseText = xhr.responseText;

               var jsonResponse = JSON.parse(responseText);
               if (jsonResponse.error) {
                //  toastr.error(jsonResponse.error);
                 $('#comment-input').val('');
               } else {
                //  toastr.error('An unexpected error occurred.');
               }
            }           
        });
    });
   });

   $(document).ready(function() {
      $(".hidden-section").hide();

      $(".show-hidden").click(function() {
         var $this = $(this);
         var $hiddenSection = $this.next(".hidden-section");
         
         $hiddenSection.toggle();

         if ($hiddenSection.is(":visible")) {
            $this.html('<i class="fa fa-eye" aria-hidden="true"></i> Hide Hidden');
         } else {
            $this.html('<i class="fa fa-eye-slash" aria-hidden="true"></i> See Hidden');
         }
      });
   });


   $(document).ready(function() {
    // Handle reply button clicks with event delegation
      $('#comments-list').on('click', '.sendreply', function() {
         var userid = $(this).attr('userid');
         var video_id = $(this).attr('blog-id');
         var blog_user = $(this).attr('blog-user');
         var url = $(this).attr('data-url');
         var comment = $(this).closest('.reply-box').find('.reply_text').val(); // Use .closest() to find the reply box in the current context
         var comment_id = $(this).attr('comment-id');
         var type = 'fundraiser';

         console.log(comment + comment_id);

         var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
         $.ajax({
               url: site_url + '/fundraiser/comment_reply',
               type: 'POST',
               headers: {
                  'X-CSRF-TOKEN': csrfToken
               },
               data: {
                  userid: userid,
                  video_id: video_id,
                  blog_user: blog_user,
                  url: url,
                  type: type,
                  comment: comment,
                  comment_id: comment_id
               },
               success: function(response) {
                  console.log(response);

                  $('#comments-list').html(response.html); 
                  $('#comment-input').val('');
                  $('.reply_text').val(''); 
                //   toastr.success(response.success || 'Reply added successfully.');
               },
               error: function(xhr, status, error) {
                  console.error('AJAX Error: ' + status + error);
                  var responseText = xhr.responseText;

                  var jsonResponse = JSON.parse(responseText);
                  if (jsonResponse.error) {
                    //  toastr.error(jsonResponse.error);
                     $('#comment-input').val('');
                     $('.reply_text').val(''); 
                  } else {
                    //  toastr.error('An unexpected error occurred.');
                  }
               }
         });
      });
   });


   $(document).ready(function() {
    // Event delegation for hide_comment
      $('#comments-list').on('click', '.hide_comment', function() {
         Swal.fire({
               title: 'Hide',
               text: 'Are you sure you want to hide this comment?',
               icon: 'warning',
               showCancelButton: true,
               confirmButtonColor: '#fcd152',
               cancelButtonColor: '#1a202e',
               confirmButtonText: 'Yes, Hide!'
         }).then((result) => {
               if (result.isConfirmed) {
                  var commID = $(this).attr('data-id');
                  var blogId = $(this).attr('blog-id');
                  var blog_user = $(this).attr('blog-user');
                  var type = 'fundraiser';
                  var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                  
                  $.ajax({
                     url: site_url + '/fundraiser/hide_comment',
                     type: 'POST',
                     headers: {
                           'X-CSRF-TOKEN': csrfToken
                     },
                     data: {
                           id: commID,
                           status: 0,
                           type: type,
                           blog_id: blogId,
                           blog_user: blog_user,
                     },
                     success: function(response) {
                           console.log(response);
                           toastr.success(response.success);
                           location.reload();
                     },
                     error: function(xhr, status, error) {
                           console.error('AJAX Error: ' + status + error);
                           var responseText = xhr.responseText;
                           var jsonResponse = JSON.parse(responseText);
                           if (jsonResponse.error) {
                              toastr.error('Error: ' + jsonResponse.error);
                           } else {
                              toastr.error('An unexpected error occurred.');
                           }
                     }
                  });
               }
         });
      });

      // Event delegation for unhide_comment
      $('#comments-list').on('click', '.unhide_comment', function() {
         Swal.fire({
               title: 'Unhide',
               text: 'Are you sure you want to unhide this comment?',
               icon: 'warning',
               showCancelButton: true,
               confirmButtonColor: '#fcd152',
               cancelButtonColor: '#1a202e',
               confirmButtonText: 'Yes, Unhide!'
         }).then((result) => {
               if (result.isConfirmed) {
                  var commID = $(this).attr('data-id');
                  var blogId = $(this).attr('blog-id');
                  var blog_user = $(this).attr('blog-user');
                  var type = 'fundraiser';
                  var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                  
                  $.ajax({
                     url: site_url + '/fundraiser/unhide_comment',
                     type: 'POST',
                     headers: {
                           'X-CSRF-TOKEN': csrfToken
                     },
                     data: {
                           id: commID,
                           status: 1, 
                           type: type,
                           blog_id: blogId,
                           blog_user: blog_user,
                     },
                     success: function(response) {
                           console.log(response);
                           toastr.success(response.success);
                           location.reload();
                     },
                     error: function(xhr, status, error) {
                           console.error('AJAX Error: ' + status + error);
                           var responseText = xhr.responseText;
                           var jsonResponse = JSON.parse(responseText);
                           if (jsonResponse.error) {
                              toastr.error('Error: ' + jsonResponse.error);
                           } else {
                              toastr.error('An unexpected error occurred.');
                           }
                     }
                  });
               }
         });
      });
   });



    $(document).ready(function() {
        // Handle update comment button clicks with event delegation
        $('#comments-list').on('click', '.update-comment', function() {
            var comment_id = $(this).attr('comment_id');
            var blogId = $(this).attr('blog-id');
            var blogUser = $(this).attr('blog-user');
            var url = $(this).attr('data-url');
            var type = 'fundraiser';
    
            // Construct the comment input ID
            var commentInputId = 'commentInput-' + comment_id;
            var comment = $('#' + commentInputId).val();  // Get the value from the dynamically generated input field
    
            $.ajax({
                url: site_url + "/fundraiser/update_comment",
                type: "POST",
                data: {
                    _token: $('meta[name="csrf-token"]').attr("content"),
                    commentId: comment_id,
                    comment: comment,
                    type: type,
                    url: url,
                    blog_id: blogId,
                    blog_user: blogUser,
                },
                success: function(response) {
                    console.log(response);
                    // toastr.success(response.success);
                    $('#comments-list').html(response.html);
                    $('#' + commentInputId).val('');
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error: ' + status + error);
    
                    var responseText = xhr.responseText;
                    var jsonResponse = JSON.parse(responseText);
                    if (jsonResponse.error) {
                        // toastr.error('Error: ' + jsonResponse.error);
                    } else {
                        // toastr.error('An unexpected error occurred.');
                    }
                },
            });
        });
    });


    $(document).ready(function() {
    // Handle update reply button clicks with event delegation
        $('#comments-list').on('click', '.update-comReply', function() {
            var comment_id = $(this).attr('comment_id');  
            var blogId = $(this).attr('blog-id');      
            var blogUser = $(this).attr('blog-user');  
            var url = $(this).attr('data-url');        
            var type = 'fundraiser';                   
    
            // Use the replyId to target the correct input field for the reply
            var replyInputId = 'comReplyInput-' + comment_id; 
            var reply = $('#' + replyInputId).val();     
    
            $.ajax({
                url: site_url + "/fundraiser/update_comment",
                type: "POST",
                data: {
                    _token: $('meta[name="csrf-token"]').attr("content"),
                    commentId: comment_id,
                    comment: reply,
                    type: type,
                    url: url,
                    blog_id: blogId,
                    blog_user: blogUser,
                },
                success: function(response) {
                    console.log(response);
    
                    // toastr.success(response.success); // Optional success message
                    $('#comments-list').html(response.html); // Update comments list with new HTML
                    $('#' + replyInputId).val(''); // Clear the reply input field after the update
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error: ' + status + error);
    
                    var responseText = xhr.responseText;
                    var jsonResponse = JSON.parse(responseText);
                    if (jsonResponse.error) {
                        // toastr.error('Error: ' + jsonResponse.error); // Optional error message
                    } else {
                        // toastr.error('An unexpected error occurred.'); // Optional error message
                    }
                },
            });
        });
    });


   function deleteComment(commentId) {
     Swal.fire({
       title: 'Delete',
       text: 'Are you sure you want to delete this comment?',
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
           url: '/delete-comment/' + commentId,
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
               text: 'Error deleting comment. Please try again.',
               icon: 'error'
             });
           }
         });
       }
     });
   }

   $(document).ready(function() {
    $('#reportForm').on('submit', function(e) {
        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            url: site_url + "/fundraiser/report",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    toastr.success(response.success);
                    $('#reportForm')[0].reset();
                } else {
                    toastr.error(response.error);
                }
            },
        });
    });
});

document.getElementById('toggle-emojis').addEventListener('click', function() {
    const emojiContainer = document.getElementById('emoji-container');
    emojiContainer.style.display = emojiContainer.style.display === 'none' ? 'flex' : 'none';
});

document.querySelectorAll('.emojis span').forEach(emoji => {
    emoji.addEventListener('click', function() {
        const commentInput = document.getElementById('comment-input');
        commentInput.value += this.innerHTML;
        // document.getElementById('emoji-container').style.display = 'none';
    });
});

$(document).ready(function() {
//   $('.like-count').each(function() {
//     if ($(this).html() === '0') {
//       $(this).hide();
//     }
//   });

  $('.like-icon').on('click', function() {
    let likeCountElement = $(this).next('.like-count'); 
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    let currentCount = parseInt(likeCountElement.html()) || 0; 
    let commentId = $(this).data('comment-id'); 
    let userId = $(this).data('user-id'); 

    if ($(this).hasClass('fa-heart-o')) {
      currentCount += 1; 
      $(this).removeClass('fa-heart-o').addClass('fa-heart'); 

      $.ajax({
        url: '/fundraiser/likes', 
        type: 'POST',
        data: {
          comment_id: commentId,
          user_id: userId,
          action: 'like' 
        },
        headers: {
          'X-CSRF-TOKEN': csrfToken
        },
        success: function(response) {
          console.log('Liked successfully!', response);
        },
        error: function(xhr) {
          console.error('Error liking the post:', xhr);
        }
      });
    } else {
      currentCount -= 1; 
      $(this).removeClass('fa-heart').addClass('fa-heart-o'); 

      $.ajax({
        url: '/fundraiser/likes',
        type: 'POST',
        data: {
          comment_id: commentId,
          user_id: userId,
          action: 'unlike' 
        },
        headers: {
          'X-CSRF-TOKEN': csrfToken
        },
        success: function(response) {
          console.log('Unliked successfully!', response);
        },
        error: function(xhr) {
          console.error('Error unliking the post:', xhr);
        }
      });
    }

    // Update like count in the element
    likeCountElement.html(currentCount); 

    // if (currentCount > 0) {
    //   likeCountElement.show(); 
    // } else {
    //   likeCountElement.hide(); 
    // }
  });
});

function showLikesModal(element) {
    var modal = document.getElementById('likesModal');
    modal.style.display = 'block';
}

function closeLikesModal() {
    var modal = document.getElementById('likesModal');
    modal.style.display = 'none';
}

// Close the modal when the user clicks outside of it
window.onclick = function(event) {
    var modal = document.getElementById('likesModal');
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}

function showLikesModal(commentId) {

    var modal = document.getElementById('likesModal');
    modal.style.display = 'block';


    document.querySelector('.likes-list').innerHTML = '';

    fetch(`/comments/${commentId}/likes`)
        .then(response => response.json())
        .then(data => {
            var likesList = document.querySelector('.likes-list');
            const userProfileRoute = "{{ route('UserProfileFrontend', ':slug') }}";
            if (data.likedUsers.length === 0) {
                likesList.innerHTML = '<div class="no-likes">No one likes this comment.</div>';
            } else {
                data.likedUsers.forEach(user => {
                var likeItem = `
                    <div class="like-item">
                        <a href="${userProfileRoute.replace(':slug', user.slug)}" target="_blank">
                            <img src="${site_url}/public/assets/images/profile/${user.image}" alt="${user.first_name}" class="like-user-image">
                        </a>
                        <div class="like-user-info w-100 text-start px-2">
                        <a href="${userProfileRoute.replace(':slug', user.slug)}" target="_blank">
                            <h6 class="font-weight-bold">${user.first_name}</h6>
                        </a>
                        <a href="${userProfileRoute.replace(':slug', user.slug)}" target="_blank">
                            <span class="text-muted">${user.username}</span>
                        </a>
                        </div>
                        <button class="connect-btn" onclick="successAlert()">Connect</button>
                    </div>
                `;
                likesList.innerHTML += likeItem;
            });
        }
    });
}

function pin_comment(commentId) {
    var pinElement = $('a[onclick="pin_comment(' + commentId + ')"]');
    var blogId = pinElement.data('blog-id');
    var blogUser = pinElement.data('blog-user');
    var url = pinElement.data('url');

    $.ajax({
        url: site_url + "/fundraiser/pin_comment",
        type: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            comment_id: commentId,
            blog_id: blogId,
            blog_user: blogUser,
            url: url
        },
        success: function(response) {
            if (response.success) {
                // Hide the current comment
                $('.comment-item' + commentId).hide();

                // Prepend the pinned comment to the comments list
                $('#comments-list').prepend(response.html);

                // Optionally display a success message
                // toastr.success("Comment pinned successfully!");
            } else {
                console.log('Pinning failed:', response.message);
                // toastr.error("An error occurred while pinning the comment.");
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', status, error);
            // toastr.error("An unexpected error occurred.");
        }
    });
}

function unpin_comment(commentId) {
    var unpinElement = $('a[onclick="unpin_comment(' + commentId + ')"]');
    var blogId = unpinElement.data('blog-id');
    var blogUser = unpinElement.data('blog-user');
    var url = unpinElement.data('url');

    $.ajax({
        url: site_url + "/fundraiser/unpin_comment",
        type: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            comment_id: commentId,
            blog_id: blogId,
            blog_user: blogUser,
            url: url
        },
        success: function(response) {
            if (response.success) {
                // Remove the unpinned comment
                $('.comment-item' + commentId).remove();

                // Append the unpinned comment back to the comments list
                $('#comments-list').append(response.html);

                // Optionally display a success message
                // toastr.success("Comment unpinned successfully!");
            } else {
                console.log('Unpinning failed:', response.message);
                // toastr.error("An error occurred while unpinning the comment.");
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', status, error);
            // toastr.error("An unexpected error occurred.");
        }
    });
}


function successAlert() {
    toastr.options = {
        timeOut: 3000,
        progressBar: true,
        closeButton: true,
        positionClass: 'toast-top-right',
        // toastClass: 'toast toast-success'
    };
    toastr.success('Coming soon.', 'Connect');
    
    // setTimeout(function() {
    //     window.location.reload();
    // }, 3000);
}


// Toggle emoji picker visibility for all reply emoji buttons
document.querySelectorAll('[id^="emojiButton-"]').forEach(button => {
    button.addEventListener('click', function(event) {
        const id = this.id.split('-')[1];
        const emojiPicker = document.getElementById('emojiPicker-' + id);
        
        if (emojiPicker) {
            emojiPicker.classList.toggle('hidden');  // Toggle the visibility of the emoji picker
        }

        event.stopPropagation();  // Prevent the click from propagating
    });
});

// Hide reply emoji picker when clicking outside
document.addEventListener('click', function(event) {
    document.querySelectorAll('[id^="emojiPicker-"]').forEach(picker => {
        const id = picker.id.split('-')[1];
        const emojiButton = document.getElementById('emojiButton-' + id);
        
        if (!emojiButton.contains(event.target) && !picker.contains(event.target)) {
            picker.classList.add('hidden');  // Hide picker if clicked outside
        }
    });
});

// Function to insert emoji into reply input
function insertEmoji(commentId, emoji) {
    const input = document.getElementById('reply-input-' + commentId);
    input.value += emoji;  // Append the emoji to the reply input field
}


// Toggle emoji picker visibility for all edit comment emoji buttons
document.querySelectorAll('[id^="editEmojiButton-"]').forEach(button => {
    button.addEventListener('click', function(event) {
        const id = this.id.split('-')[1];
        const emojiPicker = document.getElementById('editEmojiPicker-' + id);
        
        if (emojiPicker) {
            emojiPicker.classList.toggle('hidden');  // Toggle the visibility of the emoji picker
        }

        event.stopPropagation();  // Prevent the click from propagating
    });
});

// Hide edit comment emoji picker when clicking outside
document.addEventListener('click', function(event) {
    document.querySelectorAll('[id^="editEmojiPicker-"]').forEach(picker => {
        const id = picker.id.split('-')[1];
        const emojiButton = document.getElementById('editEmojiButton-' + id);
        
        if (!emojiButton.contains(event.target) && !picker.contains(event.target)) {
            picker.classList.add('hidden');  // Hide picker if clicked outside
        }
    });
});

// Function to insert emoji into edit comment input
function insertEmojiToComment(commentId, emoji) {
    const input = document.getElementById('commentInput-' + commentId);
    input.value += emoji;  // Append the emoji to the comment input field
}


// Toggle emoji picker visibility for all reply emoji buttons
document.querySelectorAll('[id^="replyEmojiButton-"]').forEach(button => {
    button.addEventListener('click', function(event) {
        const id = this.id.split('-')[1];
        const emojiPicker = document.getElementById('replyEmojiPicker-' + id); // Updated ID

        if (emojiPicker) {
            emojiPicker.classList.toggle('hidden');  // Toggle the visibility of the emoji picker
        }

        event.stopPropagation();  // Prevent the click from propagating
    });
});

// Hide reply emoji picker when clicking outside
document.addEventListener('click', function(event) {
    document.querySelectorAll('[id^="replyEmojiPicker-"]').forEach(picker => { // Updated ID
        const id = picker.id.split('-')[1];
        const emojiButton = document.getElementById('replyEmojiButton-' + id);
        
        if (!emojiButton.contains(event.target) && !picker.contains(event.target)) {
            picker.classList.add('hidden');  // Hide picker if clicked outside
        }
    });
});

// Function to insert emoji into reply input
function insertEmojiToReply(commentId, emoji) {
    const input = document.getElementById('comReplyInput-' + commentId);
    input.value += emoji;  // Append the emoji to the reply input field
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

    $(document).ready(function(){
    $('.overview-comment').on('click', function() {
        $(".show-comments").toggle();

        if ($(".show-comments").is(":visible")) {
            $('html, body').animate({
                scrollTop: $('.show-comments').offset().top
            }, 500);
        }
    });
});


</script>
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
   <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script> -->
@endsection