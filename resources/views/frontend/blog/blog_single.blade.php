<?php
   use App\Models\UserAuth; 
   use App\Models\Admin\AdminAuth; 
   use App\Models\Setting;
   use App\Models\BlogComments;
   $setting_comment_option = Setting::get_setting('comments_option',$blog_post->user_id);
   // dd($setting_comment_option);
   $user_all_data = UserAuth::getUser($blog_post->user_id);
   ?>
@extends('layouts.frontlayout')
@section('content')

<style type="text/css">
   a.copy_url.btn.create-post-button.ms-2 i {position: relative;left: 0;}
   .shareComponent span{position: relative; top:15px;}
   div#social-links ul {padding: 0;}
   li.shareComponent {left: 0 !important;}
   div#social-links ul li {position: relative;display: inline-flex;justify-content: center;padding: 0px 10px 12px 0px;top: 0px;}
   .tab-container {display: flex;justify-content: center;margin-top: 20px;}
   .tab-button {padding: 10px 20px;background-color: #f0f0f0;border: none;margin: 0 5px;cursor: pointer;}
   .tab-button.active {background-color: #ccc;}
   .tab-content {display: none;padding: 20px;border: 1px solid #ccc;margin-top: 10px;}
   .tab-content p {margin: 0;}
   .tab-content.active {display: block;}
   .checkrepo {display: flex;}
   label.repo-label {margin: 12px;font-size: 14px;}
   .comments-box {position: relative;margin-bottom: 10px;}
   .dots-menu {font-size: 15px;position: absolute;right: 0;}
   .dots-menu.btn-group>.btn:first-child:not(:last-child):not(.dropdown-toggle) {border-radius: 5px;}
   .dots-menu a.btn {/* @extend .glyphicon !optional;  &:before{content: "\e235";} */}
   .dots-menu a.btn:active {box-shadow: none;}
   .dots-menu ul.dropdown-menu {right: 36px;left: auto;min-width: 80px; text-align: center;}
   .dropdown-menu.show {display: inline-block;}
   .dots-menu ul.dropdown-menu li {padding: 0;width: auto;display: inline-block;}
   .dots-menu ul.dropdown-menu li a {margin: 0;padding: 0 9px;border: 0;}
   .dots-menu ul.dropdown-menu li a:hover{border-radius: 0; border:0;}
   .myDropdown.show {display: block;top: 40px;}
   .myDropdown.dropdown-content a {padding: 6px 16px;}
   .btn-primary {color: #fff;background-color: #cc9c31;border-color: #cc9c31;}
   .button_for {display: inline-block;font-weight: 400;line-height: 1.5;color: #212529;text-align: center;text-decoration: none;vertical-align: middle;
   cursor: pointer;-webkit-user-select: none;-moz-user-select: none;user-select: none;background-color: transparent;border-top-color: transparent;border-right-color: transparent;border-bottom-color: transparent;border-left-color: transparent;padding: .375rem .75rem;font-size: 1rem;border-radius: .25rem;transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;}
   .btn-primary:hover {color: #fff;background-color: #cc9c31;border-color: #cc9c31;border-width: 1px;border-style: solid;}
   .button_update {background-color: #9b8149;}
   .button_update:hover {background-color: #cc9c31;}
   .comments-box ul{width: 100%;}
   .comment-header{display: flex; align-items: center;}
   .reply-box{display: flex;position: relative;border-radius: 35px;background: #eaeaea;padding: 5px 0 5px 10px;box-shadow: 0px 0px 4px rgba(0, 0, 0, 0.22);}
   .reply-box input.form-control {background: transparent;border: 0;border-radius: 35px;height: 40px;width: 80%; font-size: 14px;}
   .sendreply {background: linear-gradient(90deg, rgba(170, 137, 65, 1) 0%, rgba(205, 156, 49, 1) 13%, rgba(154, 128, 73, 1) 35%, rgba(246, 204, 78, 1) 51%, rgba(181, 147, 56, 1) 75%, rgba(163, 136, 68, 1) 100%);border-radius: 35px;border: 0px!important;box-shadow: none!important;color: #000 !important;padding: 9px 20px;position: absolute;right: 5px; font-size: 14px;}
   .reply-box .save-post {
   background: linear-gradient(90deg, rgba(220, 114, 40, 1) 50%, #a54db7 100%);
   color: white !important;
   border-radius: 35px;
   border: 0px!important;box-shadow: none!important; padding: 9px 20px;position: absolute;right: 5px; font-size: 14px; font-weight: 400; margin: 0;
   }
   .btn-reply{border:0; font-size: 12px; padding: 0;font-weight: 600;color: #cc9c31;}
   .btn-hide{border:0; font-size: 12px; padding: 0; margin-left: 15px;font-weight: 600;color: #cc9c31;}
   .post-comment-reply-area{display: flex; background-color: #000; padding: 10px 10px 10px 35px;position: relative;}
   .post-comment-reply-area .post-comment-user-img{width:30px; height: 30px;}
   .reply-content{font-size: 13px; font-weight: normal;padding-left: 10px;padding-right: 10px;color: #fff;}
   .close-area .close-comment{color: #fff;top:0; right:10px;position: absolute;cursor: pointer;}
   .reply-frame{padding:5px 10px 5px 35px;}
   .reply-frame img{width:30px; height: 30px;border-radius: 50%;}
   .reply-frame span{font-size: 13px; color: #000;padding-left: 5px;}
   .reply-box-show{display: none;}
   .reply-comment{flex-direction: column;}
   .my-cont{padding:5px 0;}
   .copy-button{background: rgb(170, 137, 65);border: none;outline: none;border-radius: 5px;cursor: pointer;padding: 2px;
   background: linear-gradient(90deg, rgba(170, 137, 65, 1) 0%, rgba(205, 156, 49, 1) 13%, rgba(154, 128, 73, 1) 35%, rgba(246, 204, 78, 1) 51%, rgba(181, 147, 56, 1) 75%, rgba(163, 136, 68, 1) 100%);}
   #exampleModal75 .modal-content{padding: 5px 0;}
   #exampleModal75 .modal-body p{font-size: 13px;}
   .butons button.btn.create-post-button.ms-2{
   margin-left: 10px !important;
   }
   a.btn.create-post-button {
      display: -webkit-box;
      -webkit-line-clamp: 1;
      -webkit-box-orient: vertical;
      overflow: hidden;
      text-overflow: ellipsis;
      line-height: inherit;
      width: 40%;
      text-align: start;
      padding: 4px 20px;
   }
   .show-comments{padding-bottom:60px;}
   .overlay {
   background: rgba(0,0,0,0.9);
   position: absolute;
   top: 0;
   bottom: 0;
   left: 0;
   right: 0;
   margin: auto;
   width: 100%;
   height: 100%;
   opacity: 0;
   visibility: hidden;
   -webkit-transition: all 0.2s ease-in-out;
   -o-transition: all 0.2s ease-in-out;
   transition: all 0.2s ease-in-out;
   display: inline-block;
   }
   .overlay.is-on {
   opacity: 1;
   visibility: visible;
   z-index: 11;
   }
   .overlay.is-on .content {
   opacity: 1;
   visibility: visible;
   top: 0;
   }
   .overlay .content-area {
   background: #fff;
   position: absolute;
   top: 0%;
   bottom: 0;
   left: 0;
   right: 0;
   margin: auto;
   width: 97%;
   height: 35%;
   opacity: 1;
   visibility: visible;
   -webkit-transition: all 0.3s ease-in-out;
   -o-transition: all 0.3s ease-in-out;
   transition: all 0.3s ease-in-out;
   color: #000;
   padding: 20px;
   }
   .content-area .post-comment-send {
   height: 35px;
   width: 35px;
   border-radius:0 4px 4px 0;
   border: 0;
   background-color: #cc9c31;
   cursor: pointer;
   margin-right: 6px;
   font-size: 14px;
   font-weight: normal;
   }
   #close1 {
   position: absolute;
   right: 0px;
   top: -5px;
   font-size: 20px;
   color: #000;
   cursor: pointer;
   }
   .input-area-box{margin-top: 10px;}
   .input-area-box input{
   width: 100%;
   height: 35px;
   border-radius: 4px;
   border: 1px solid #8f9797;
   padding-left: 15px;
   font-size: 14px;
   }
   .content-area .reply-content{color: #000;}
   span.highlight {
   font-weight: 500;
   color: #000;
   border-radius: 3px;
   padding: 0 5px;
   background: linear-gradient(90deg, rgba(170, 137, 65, 1) 0%, rgba(205, 156, 49, 1) 13%, rgba(154, 128, 73, 1) 35%, rgba(246, 204, 78, 1) 51%, rgba(181, 147, 56, 1) 75%, rgba(163, 136, 68, 1) 100%);
   }
   #content-ar{
   font-size: 14px;
   }
   .sendbtn {
   background: linear-gradient(90deg, rgba(220, 114, 40, 1) 50%, #a54db7 100%);
   border-radius: 35px;
   border: 0px;
   box-shadow: none;
   color: #fff !important;
   }
   .sendbtn:hover {
   border-radius: 35px !important;
   }
   button.slick-prev{
   background-image: url('{{ asset('new_assets/assets/images/right.png') }}') !important;
   transform: rotate(180deg);
   background-repeat: no-repeat;
   width: 35px;
   height: 35px;
   background-size: 80%;
   left: 0;
   }
   button.slick-next{
   background-image: url('{{ asset('new_assets/assets/images/right.png') }}') !important;
   background-repeat: no-repeat;
   width: 35px;
   height: 35px;
   background-size: 80%;
   right: 0;
   }
   .slick-prev:before, .slick-next:before{
   display: none !important;
   }
   [aria-label="Previous"]:after{
   display: none;
   }
   [aria-label="Next"]:after{
   display: none;
   }
.count_message1{position:relative; top:30px; display:flex; justify-content:space-between;}
#char-count, #error-message-count{font-size:12px;}

   @media only screen and (max-width:767px){
   .overlay .content-area{height:45%;}
   .comments-area{width: 70%;}
   }
   .fundraiser-link {
      display: -webkit-box;
      -webkit-line-clamp: 1;
      -webkit-box-orient: vertical;
      overflow: hidden;
      text-overflow: ellipsis;
      color: #db712b;
   }
   .fundraiser-link a { 
      color: #db712b !important;
   }
   strong.zodiac_img {
      padding: 0px 2px !important;
   }
   strong.zodiac_img img {
      margin-left: 3px;
   }
   .zodiac_img_count {
      margin-left: 3px;
   }
   .likes-container {
      width: 100%;justify-content: flex-end; gap: 10px;
   }
   .likes-info {
      margin-top: 2%;
   }
   .likes-preview {
      font-size: 14px !important;
   }
/* #char-count{
   position: absolute;
    top: 20px;
    margin: 3px 8px;
    font-size: 10px;
}

#error-message-count{
   position: absolute;
    top: 20px;
    margin: 3px 8px;
    font-size: 10px;
} */
   .likes-container .like-button{width:63px;display: flex;justify-content: space-around;align-items: center;}

   @media screen and (max-width:490px) {
      .likes-container {
         width: 100%; gap: 3px; align-items: center;
      }
      .likes-info {
         margin: 0 !important;
      }
      .likes-preview {
      font-size: 11px !important; margin-left: 0!important;
      }
      .likes-container .like-button{width:48px;}
      .likes-container .like-button img{width: 18px!important; height: 18px!important;}
      .likes-count{font-size: 12px;}
      .entry-content h6 div, .entry-content h6 a{font-size: 12px;}
   
   }
   /* .likes-info { display: block; } */
</style>
<section id="single-blog-post" class="single-blog-post">
   <span>
   @include('admin.partials.flash_messages')
   </span>
   <div class="container">
      <div class="row">
         <div class="col-lg-12 prev-next-arrows">
            <div class="left-arrow">
               <a href="@if($nextPostId != null){{route('blogPostSingle',$nextPostId)}} @else # @endif" class="{{ $nextPostId == null ? 'disabled' : '' }}"><i class="bi bi-arrow-left"></i> <span>Prev</span></a>
            </div>
            <div class="right-arrow1">
               <a href="@if($previousPostId != null){{route('blogPostSingle',$previousPostId)}} @else # @endif" class="{{ $previousPostId == null ? 'disabled' : '' }}"><span>Next</span> <i class="bi bi-arrow-right"></i></a>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-lg-8 blog" data-aos="fade-right">
            <article class="entry entry-single mb-0">
               <div class="entry-img">
                  <?php
                  $img  = explode(',', $blog_post->image);
                  $role = UserAuth::getUserRole(UserAuth::getLoginId());
                  // dd($role);
                  ?>
                  <div id="blog-slider" class="slick-carousel">
                     @foreach($img as $image)
                     <div class="slick-slide">
                        <img src="{{ asset('images_blog_img') }}/{{ $image }}" alt="Image" class="img-fluid">
                        <button type="button" class="slick-prev" aria-label="Previous">
                        Previous
                        </button>
                        <button type="button" class="slick-next" aria-label="Next">
                        Next
                        </button>
                     </div>
                     @endforeach
                  </div>
               </div>
               <div class="entry-content">
                  <h1 style="font-size: 25px;">{{$blog_post->title}}</h1>
                  @if(UserAuth::isLogin())
                     <h6 class="d-flex justify-content-between align-items-center">
                        <div>
                           Created by : <a href="{{route('UserProfileFrontend',$author->slug)}}"> {{$author->first_name}} </a>
                           @if(Setting::get_setting("no_of_views", $blog_post->user_id) == 1 || $blog_post->user_id == UserAuth::getLoginId())
                           <strong class="zodiac_img">
                              <img src="{{ asset('zodiac_image/eye.png') }}" alt="eye.png">
                           </strong>
                           <strong class="zodiac_img_count">{{ $BlogsViews }}</strong>
                           @endif
                        </div>


                        @if ($BlogLikes->isNotEmpty() && UserAuth::isLogin())
                           
                           <div class="col-lg-4 col-6 col-md-6 col-6 mb-md-2 single-top-apply">
                                 <div class="job-post-apply">
                                 @if ($blog_post->user_id == UserAuth::getLoginId())
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
                                          
                                             @if ($blog_post->user_id == UserAuth::getLoginId())
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

                                       <div class="d-flex justify-content-end">
                                       @if ($blog_post->user_id == UserAuth::getLoginId())
                                             <button type="button" class="like-button" id="toggleLikes" data-user-id="{{ $userId }}" data-blog-id="{{ $like->blog_id }}" data-blog-user-id="{{ $blog_post->user_id }}" data-type="Blogs" data-cate-id="728" data-url={{ route('blogPostSingle', $blog_post->slug) }}>
                                       @else
                                             <button type="button" class="like-button" id="toggleLikes" data-user-id="{{ UserAuth::getLoginId() }}" data-blog-id="{{ $blog_post->id }}" data-blog-user-id="{{ $blog_post->user_id }}" data-type="Blogs" data-cate-id="728" data-url={{ route('blogPostSingle', $blog_post->slug) }} style="padding: 6px 8px !important; width: auto !important; margin: 0 !important;">
                                       @endif
                                                @if ($userLiked && $likedBy[$userId] == 1)
                                                   <img src="{{ asset('images/heart-icon.png') }}" id="1" class="rxn-emoji" alt="emoji-icon" style="width: 23px; height: 23px;">
                                                @elseif ($userLiked && $likedBy[$userId] == 2)
                                                   <img src="{{ asset('images/thumb-icon.png') }}" id="2" class="rxn-emoji" alt="emoji-icon" style="width: 23px; height: 23px;">
                                                @else
                                                   <i class="fa-regular fa-thumbs-up emoji"></i>
                                                @endif

                                                {{-- @if ($blog_post->user_id == UserAuth::getLoginId())
                                                   <span class="likes-count">{{ $likes }}</span>
                                                @endif --}}
                                             </button>
                                             <div class="reactions-emojis mt-1" style="display: none;">
                                                <img src="{{ asset('images/heart-icon.png') }}" class="heart-icon" data-id="1" alt="Heart Icon">
                                                <img src="{{ asset('images/thumb-icon.png') }}" class="thumb-icon" data-id="2" alt="Thumb Icon">
                                             </div>
                                       </div>
                                    </div>
                                 </div>
                           </div>


                        @elseif ($blog_post->user_id == UserAuth::getLoginId())
                           <div class="col-lg-3 col-4 col-md-6 col-6 mb-md-2 single-top-apply">
                                 <div class="job-post-apply">
                                    @if(UserAuth::isLogin())
                                       <div class="likes-container">
                                             <div class="likes-info">
                                                <b>Likes: </b>
                                                <span class="likes-preview">no likes</span>
                                             </div>
                                             <div class="">
                                                <button type="button" class="like-button" id="toggleLikes" data-user-id="{{ UserAuth::getLoginId() }}" data-blog-id="{{ $blog_post->id }}" data-blog-user-id="{{ $blog_post->user_id }}" data-type="Blogs" data-cate-id="728" data-url={{ route('blogPostSingle', $blog_post->slug) }}>
                                                   <i class="fa-regular fa-thumbs-up emoji"></i>
                                                   {{-- <span class="likes-count">0</span> --}}
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
                           <div class="col-lg-3 col-4 col-md-6 col-6 mb-md-2 single-top-apply">
                                 <div class="job-post-apply">
                                    @if(UserAuth::isLogin())
                                       <div class="likes-container">
                                             <div class="">
                                                <button type="button" class="like-button" id="toggleLikes" data-user-id="{{ UserAuth::getLoginId() }}" data-blog-id="{{ $blog_post->id }}" data-blog-user-id="{{ $blog_post->user_id }}" data-type="Blogs"  data-cate-id="728" data-url={{ route('blogPostSingle', $blog_post->slug) }}>
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
                     </h6>
                  @elseif(AdminAuth::isLogin())
                     <h6 class="d-flex justify-content-between align-items-center">
                        <div>
                           by : <a href="{{route('UserProfileFrontend.admin',$author->slug)}}"> {{$author->first_name}} </a>
                        </div>
                        <div class="likes-container">
                           <!-- Add your likes-related content here -->
                        </div>
                     </h6>
                  @else
                     <h6 class="d-flex justify-content-between align-items-center">
                        <div>
                           by : <a href="{{route('auth.signupuser')}}"> {{$author->first_name}} </a>
                        </div>
                        <div class="likes-container">
                           <!-- Add your likes-related content here -->
                        </div>
                     </h6>
                  @endif

                  <!-- Likes Modal -->
                  <div id="showLikesModal" class="showLikes-modal" style="display: none;">
                     <div class="modal-content">
                           <span class="close" onclick="closeShowLikes()">&times;</span>
                           <h2 class="text-center">Likes</h2>
                           <div class="showLikes-list px-1">

                           </div>
                     </div>
                  </div>

                  @if ($blog_post->location)
                     <div class="post-location">
                        <p><b>Location: </b>{{ $blog_post->location }}</p>
                     </div>
                  @endif
                  
                  <div class="contentArea" >
                     <p>{!! $blog_post->content !!}</p>
                     
                  </div>
                  <div class="funfraiser-links">
                     @if ($blog_post->fundraiser_link)
                        @php
                              $links = explode(',', $blog_post->fundraiser_link);
                        @endphp
                        <div class="h6"> Fundraiser link </div>
                        @foreach ($links as $link)
                              <p class="fundraiser-link">
                                 <a class="btn create-post-button" href="{{ trim($link) }}" target="_blank">{{ trim($link) }}</a>
                              </p>
                        @endforeach
                     @endif
                  </div>

               </div>
            </article>
            <!-- End blog entry -->
            <div class="butons align-items-baseline py-3">
               @if($setting_comment_option == '1' || $blog_post->posted_by == 'admin')
               @if($blog_post->comment_view_public_private == "public")
               <button type="button" class="slide-toggle social-thumb-icon hello" style="background: #141212;">
               <i class="far fa-comment-dots"></i> <span></span>
               </button>
               @elseif($blog_post->comment_view_public_private == "private")
               @php $buttonRendered = false; @endphp
               @foreach($get_follower as $followers)
               @if(($followers->following_id == UserAuth::getLoginId() || $blog_post->user_id == UserAuth::getLoginId()) && !$buttonRendered)
               <button type="button" class="slide-toggle social-thumb-icon" style="background: #141212;">
               <i class="far fa-comment-dots"></i> <span></span>
               </button>
               @php $buttonRendered = true; @endphp
               @endif
               @endforeach
               @endif
               @endif
               <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal1" data-toggle="tooltip" data-placement="top" title="Report blog" class="social-thumb-icon" style="background: #141212;">
               <i class="fa-regular fa-flag"></i> <span></span>
               </button>
               {{-- <a href="{{route('auth.signupuser')}}">
                  <button type="button" class="social-thumb-icon" style="background: #141212;">
                    <i class="far fa-comment-dots"></i> <span></span>
                  </button>
                  </a>
                  <a href="{{route('auth.signupuser')}}">
                  <button type="button" data-toggle="tooltip" data-placement="top" title="Report blog" class="social-thumb-icon" style="background: #141212;">
                    <i class="fa-regular fa-flag"></i> <span></span>
                  </button>
                  </a> --}}

               <button class="btn create-post-button" 
                  data-postid="{{ $blog_post->id }}" 
                  data-Userid="{{ UserAuth::getLoginId() }}" 
                  data-type="Blog_post" 
                  onclick="savePost(this)"
                  title="Save">
                  Save
               </button>
              

               {{-- <a href="javascript:void();" redirect-url="{{url('/chatify')}}/{{UserAuth::getLoginId()}}" copy-url="{{url('/blog/single')}}/{{$blog_post->slug}}" class="copy_url btn create-post-button ms-2" data-placement="top" data-toggle="tooltip" title="Share"> <i class="fa fa-share share-icon"></i></a>
               <a href="#" class="btn create-post-button ms-2" ><i class="fa fa-share share-icon"></i></a> --}}
               <?php 
                  $setting_sharebtn = Setting::get_setting('share_btn',$blog_post->user_id);
               ?>
               @if($setting_sharebtn == 'show' || $setting_sharebtn == '')
               <button type="button" class="btn create-post-button ms-2" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Share <i class="fa fa-share share-icon"></i></button>
               @endif
               <!--Share Modal Start-->
               <div class="modal fade share-modal" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                  <div class="modal-dialog">
                     <div class="modal-content">
                        <div class="modal-header border-0">
                           <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                           <div class="copy-text">
                              <input type="text" class="text" value="{{url('/blog/single')}}/{{$blog_post->slug}}" id="field_input"/>
                              <a href="javascript:void(0);" redirect-url="{{url('/chatify')}}/{{UserAuth::getLoginId()}}" copy-url="{{url('/blog/single')}}/{{$blog_post->slug}}" class="copy_url btn create-post-button ms-2" data-placement="top" data-toggle="tooltip" title="Copy">
                              <i class="fa fa-clone"></i>
                              </a>
                           </div>
                           <hr>
                           <div class="copy-text">
                           <input type="text" class="text" value="Share link via email" readonly id="email_input"/>
                           <a href="mailto:{{$user_all_data->email }}?subject={{$blog_post->title}}&body=Page link : {{url('/blog/single')}}/{{$blog_post->slug}}" class="btn create-post-button ms-2" data-placement="top" data-toggle="tooltip" title="Email">
                                 <i class="fa-solid fa-envelope"></i>
                           </a>
                           </div>
                           <div class="share-by">
                              <i class="fa fa-share-alt" aria-hidden="true"></i> Share url on social media, click on the icons below.
                           </div>
                           <div class="modal-share-icon">
                              {!! $shareComponent !!}
                              <!-- <ul>
                                 <li><a href="#" class="social-button"><span class="fab fa-facebook-square" aria-hidden="true"></span></a></li>
                                 <li><a href="#" class="social-button"><span class="fab fa-twitter" aria-hidden="true"></span></a></li>
                                 <li><a href="#" class="social-button"><span class="fab fa-linkedin" aria-hidden="true"></span></a></li>
                                 <li><a target="_blank" href="#" class="social-button"><span class="fab fa-telegram" aria-hidden="true"></span></a></li>
                                 <li><a target="_blank" href="#" class="social-button"><span class="fab fa-whatsapp" aria-hidden="true"></span></a></li>
                                 <li><a target="_blank" href="#" class="social-button"><span class="fab fa-reddit" aria-hidden="true"></span></a></li>
                                 </ul> -->
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <!--Share Modal End-->
               <input type="hidden" id="copy-url-input" value="" class="hidden-input">
            </div>
            <div class="col-lg-12 col-md-12 comments-video show-comments  ms-0 mb-4">
               <div class="comments-header">
                  <h5>Blog Comments @if($blog_post->user_id == UserAuth::getLoginId() ){{$BlogComments_count->count()}} @endif</h5>
                  <button type="button" class="slide-toggle social-thumb-icon" style="background: #141212;">
                  <i class="fas fa-close"></i>
                  </button>
               </div>
               <div class="comments-box">
                  <ul class="list-unstyled">
                     @foreach($BlogComments as $comm)
                     @foreach($users as $user)
                     @if($user->id == $comm->user_id && $comm->blog_id == $blog_post->id)
                     @if(UserAuth::getLoginId())
                     <li class="comment-item">
                        <div class="comment-header">
                           <div class="img-icon">
                              <img class="img-fluid rounded-circle" alt="image" height="40" width="40" src="{{ asset('assets/images/profile/' . $user->image) }}">
                           </div>
                           <div class="comments-area">
                              <a href="{{ route('UserProfileFrontend', $user->slug) }}">{{ $user->first_name }}</a>
                              <p>{{ $comm->comment }}</p>
                              <!-- Reply and Hide buttons -->
                              <div class="comment-actions">
                                 <button type="button" class="btn btn-reply" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $comm->id }}">Reply</button>
                                 @if($blog_post->user_id == UserAuth::getLoginId())
                                 <button type="button" class="btn btn-hide hide_comment" data-id="{{ $comm->id }}">Hide</button>
                                 @endif
                              </div>
                              <!-- Reply box -->
                           </div>
                           @if($blog_post->user_id == UserAuth::getLoginId() || $comm->user_id == UserAuth::getLoginId() || $role->role == 'admin')
                           <div class="dots-menu btn-group">
                              <a data-toggle="dropdown" class="btn btn-primary" onclick="showDropdown({{ $comm->id }})"><i class='fas fa-ellipsis-v'></i></a>
                              <ul class="dropdown-menu" id="dropdown-{{ $comm->id }}">
                                 @if($comm->user_id == UserAuth::getLoginId())
                                 <li><a class="btn button_for" data-bs-toggle="modal" href="#editModal{{ $comm->id }}"><i class="fa fa-pencil" style="font-size: 13px;"></i></a></li>
                                 @endif
                                 <li><a class="btn btn-danger button_for" onclick="deleteComment({{ $comm->id }})"><i class="fa fa-trash-o"></i></a></li>
                              </ul>
                           </div>
                           @endif
                        </div>
                        @foreach($BlogCommentsReply as $comReply)
                        @if($comReply->com_id == $comm->id)
                        @php
                        $commentReply = BlogComments::select('user_id')->where('id', $comReply->id)->first();
                        if ($commentReply) {
                        $commentedUser = UserAuth::getUser($commentReply->user_id);
                        } else {
                        $commentedUser = null;
                        }
                        @endphp
                        <div class="comment-header">
                           <div class="img-icon">
                              <img class="img-fluid rounded-circle" alt="image" height="40" width="40" src="{{ asset('assets/images/profile/' . $commentedUser->image) }}">
                           </div>
                           <div class="comments-area">
                              <a href="{{ route('UserProfileFrontend', $commentedUser->slug) }}">{{ $commentedUser->first_name }}</a>
                              <p>{{ $comReply->comment }}</p>
                           </div>
                           @if($blog_post->user_id == UserAuth::getLoginId() || $comReply->user_id == UserAuth::getLoginId() || $role->role == 'admin')
                           <div class="dots-menu btn-group">
                              <a data-toggle="dropdown" class="btn btn-primary" onclick="showDropdown({{ $comReply->id }})"><i class='fas fa-ellipsis-v'></i></a>
                              <ul class="dropdown-menu" id="dropdown-{{ $comReply->id }}">
                                 @if($comm->user_id == UserAuth::getLoginId())
                                 <li><a class="btn button_for" data-bs-toggle="modal" href="#editModal{{ $comReply->id }}"><i class="fa fa-pencil" style="font-size: 13px;"></i></a></li>
                                 @endif
                                 <li><a class="btn btn-danger button_for" onclick="deleteComment({{ $comReply->id }})"><i class="fa fa-trash-o"></i></a></li>
                              </ul>
                           </div>
                           @endif
                        </div>
                        @endif
                        @endforeach
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal{{ $comm->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                           <div class="modal-dialog modal-dialog-centered">
                              <div class="modal-content">
                                 <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Reply</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                 </div>
                                 <div class="modal-body">
                                    <p>{{ $comm->comment }}</p>
                                    <form>
                                       <div class="row">
                                          <div class="col-lg-12">
                                             <div class="reply-box" id="reply-box-{{ $comm->id }}" >
                                                <input type="text" class="form-control comment_text" placeholder="Write a reply..." id="reply-input-{{ $comm->id }}">
                                                {{-- <input type="hidden" name="url" value="{{route('blogPostSingle', $blog_post->slug)}}"> --}}
                                                <button type="button" class="btn btn-primary sendreply" blog-id="{{$blog_post->id}}" blog-user="{{$blog_post->user_id}}" userid="{{UserAuth::getLoginId()}}" comment-id="{{$comm->id}}" data-url="{{route('blogPostSingle', $blog_post->slug)}}">Reply</button>
                                             </div>
                                          </div>
                                       </div>
                                       {{-- <div class="row">
                                          <div class="col-lg-12">
                                            <div class="reply-box">
                                              <button type="button" class="btn btn-primary  sendreply" blog-id="{{$blog_post->id}}" blog-user="{{$blog_post->user_id}}" userid="{{UserAuth::getLoginId()}}" comment-id="{{$comm->id}}">Reply</button>
                                            </div>
                                          </div>
                                          </div> --}}
                                    </form>
                                 </div>
                                 <!-- <div class="modal-footer">
                                    </div> -->
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
                                       <input type="text" value="{{ $comm->comment }}" class="form-control edit-comment-{{ $comm->id }}" id="commentInput{{ $comm->id }}">
                                       <button comment_id="{{ $comm->id }}" class="btn btn-primary save-post">Update</button>
                                    </div>
                                 </div>
                                 <!-- <div class="modal-footer">
                                    <button comment_id="{{ $comm->id }}" class="btn btn-primary save-post">Update</button>
                                    </div> -->
                              </div>
                           </div>
                        </div>
                     </li>
                     @else
                     <li class="comment-item">
                        <div class="comment-header">
                           <div class="img-icon">
                              <img class="img-fluid rounded-circle" alt="image" height="40" width="40" src="{{ asset('assets/images/profile/' . $user->image) }}">
                           </div>
                           <div class="comments-area">
                              <a href="{{ route('UserProfileFrontend', $user->slug) }}">{{ $user->first_name }}</a>
                              <p>{{ $comm->comment }}</p>
                           </div>
                        </div>
                     </li>
                     @endif
                     @endif
                     @endforeach
                     @endforeach
                  </ul>
               </div>
               <div class="overlay">
                  <div class="content-area">
                     <div id="close1"><i class="fa fa-times" aria-hidden="true"></i></div>
                     <div class="reply-content">Lorem ipsum is dummy text lorem ipsum is reply text</div>
                     <div class="input-area-box">
                        <form action="">
                           <div class="input-group">
                              <input type="text" class="form-control" placeholder="Reply here" name="reply">
                              <div class="input-group-btn">
                              
                                 <button class="post-comment-send btn btn-default" type="submit"><i class="fa fa-send send-btn" aria-hidden="true"></i></button>
                              </div>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
               @if(UserAuth::getLoginId())
               <div class="add-comments">
                  <input type="text" class="comment_count" id="comment-input" placeholder="Add Comment" name="add_comment">
                  <button id="sendbtn" class="btn btn-warning" blog-id="{{$blog_post->id}}" blog-user="{{$blog_post->user_id}}" userid="{{UserAuth::getLoginId()}}" data-url="{{route('blogPostSingle', $blog_post->slug)}}">Send</button>
               </div>
               <div class="count_message1">
                  <div id="char-count" class="">180 characters remaining</div>
                  <div id="error-message-count" class="" style="color:red;"></div>
               </div>
               @else
               <div class="add-comments d-none">
                  <div class="row">
                     <div class="span6">
                        <input type="text" class="comment_count" id="comment-input" placeholder="Add Comment" name="add_comment">
                        
                        <div id="error-message" style="color:red;"></div>
                     </div>
                  </div>
                  <a href="{{route('auth.signupuser')}}">
                  <button id="sendbtn" class="btn btn-warning" blog-id="{{$blog_post->id}}" blog-user="{{$blog_post->user_id}}" userid="{{UserAuth::getLoginId()}}">Send</button>
                  </a>
               </div>
               @endif
            </div>
         </div>
         <div class="col-lg-4 blog" data-aos="fade-left">
            <div class="sidebar">
               <h3 class="sidebar-title text-start">Recent Blogs</h3>
               <div class="sidebar-item recent-posts">
                  @foreach($recent_blog as $new_blog)
                  <a href="{{ route('blogPostSingle', $new_blog->slug) }}">
                     <div class="post-item clearfix">
                        <?php
                           $img_new  = explode(',', $new_blog->image);
                           ?>
                        <img src="{{asset('images_blog_img')}}/{{current($img_new)}}" alt="Image" class="img-fluid">
                        <h4>{{$new_blog->title}}</h4>
                     </div>
                  </a>
                  @endforeach
                  <!-- <div class="post-item clearfix">
                     <img src="{{asset('images_blog_img/1688636936.jpg')}}" alt="">
                     <h4><a href="#">Why do we use it?</a></h4>
                     </div>
                     
                     <div class="post-item clearfix">
                     <img src="https://finderspage.com/public/images_blog_img/1696484087_1693983622274-download-2.jpg" alt="">
                     <h4><a href="#">Where does it come from?</a></h4>
                     </div>
                     
                     <div class="post-item clearfix">
                     <img src="{{asset('images_blog_img/1688636936.jpg')}}" alt="">
                     <h4><a href="#">Where can I get some?</a></h4>
                     </div> -->
               </div>
               <!-- End sidebar recent posts-->
            </div>
         </div>
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
            <form id="reportForm">
               @csrf
               <input type="hidden" name="post_id" value="{{$blog_post->id}}">
               <input type="hidden" name="user_id" value="{{ UserAuth::getLoginId() }}">
               <input type="hidden" name="type" value="Blog_post">
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
                  <button type="submit" class="contact-from-button" data-bs-dismiss="modal">Submit</button>
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



   $(document).ready(function() {
     $('[data-toggle="tooltip"]').tooltip();
     $("#blog-slider").slick({
         dots: false,
         arrows: true,
        slidesToShow: 1,
        infinite:true,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2000,
       responsive: [
       {
         breakpoint: 1200,
         settings: {
           slidesToShow: 1
         }
       },
       {
         breakpoint: 1024,
         settings: {
           slidesToShow: 1
         }
       },
       {
         breakpoint: 800,
         settings: {
           slidesToShow: 1
         }
       },
       {
         breakpoint: 600,
         settings: {
           slidesToShow: 1
         }
       }
     ]
   });
   
   
   $('.slick-carousal').slick({
         slidesToShow: 1,
         slidesToScroll: 1,
         autoplay: true,
         autoplaySpeed: 2000, // Adjust as needed
         dots: false,
     });
   });
</script>
<script type="text/javascript">
   $(document).ready(function() {
     $(".comments-video").hide();
     $(".slide-toggle").click(function() {
       $(".comments-video").toggle();
     });
   
   
     $('#sendbtn').click(function() {
       var userid = $(this).attr('userid');
       var video_id = $(this).attr('blog-id');
       var blog_user = $(this).attr('blog-user');
       var url = $(this).attr('data-url');
       var comment = $('#comment-input').val();
       var type = 'blog';

       // console.log(comment);
   
       var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
       $.ajax({
         url: site_url + '/blog/comment',
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
         },
         success: function(response) {
           console.log(response);
   
           if (response.success) {
             toastr.success(response.success);
           } else {
             toastr.error(response.error);
           }
           setTimeout(function() {
             window.location.reload()
           }, 3000);
   
         },
         error: function(xhr, status, error) {
           console.log(response);
         }
       });
     });
   });
     
   
   
   $(document).ready(function() { 
    $('.sendreply').click(function() {
        var userid = $(this).attr('userid');
        var video_id = $(this).attr('blog-id');
        var blog_user = $(this).attr('blog-user');
        var url = $(this).attr('data-url');
        var comment_id = $(this).attr('comment-id');
        var type = 'blog';
        
        // Find the closest modal and get the comment value from the corresponding input
        var comment = $(this).closest('.modal-content').find('.comment_text').val();

      //   console.log(comment);
        
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        $.ajax({
            url: site_url + '/blog/comment/reply',
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
                comment_id: comment_id,
            },
            success: function(response) {
                console.log(response);
                
                if (response.success) {
                    toastr.success(response.success);
                } else {
                    toastr.error(response.error);
                }
                setTimeout(function() {
                    window.location.reload();
                }, 3000);
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    });
});

   
   
   
   
   
   function changeLanguage(language) {
     var element = document.getElementById("url");
     element.value = language;
     element.innerHTML = language;
   }
   // for dropdown in comments 
   function showDropdown(Id) {
     var dropdown = document.getElementById("dropdown-" + Id);
     dropdown.classList.toggle("show");
   }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script>
   document.getElementById('editLink').addEventListener('click', function() {
     $('#exampleModalToggle').modal('show');
   });
</script>
<script>
   $(document).ready(function() {
     $(".save-post").on("click", function() {
       var commentId = $(this).attr('comment_id');
       var editedComment = $(".edit-comment-" + commentId).val();
   
       $.ajax({
         url: "/update/" + commentId,
         type: "POST",
         data: {
           _token: $('meta[name="csrf-token"]').attr("content"),
           commentId: commentId,
           editedComment: editedComment,
         },
         success: function(response) {
           if (response.success) {
             location.reload();
           } else {
             alert("Error updating comment!");
           }
         },
         error: function() {
           alert("Error updating comment!");
         },
       });
     });
   });
</script>
<script>
   function deleteComment(commentId) {
     // Use SweetAlert for confirmation
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
         // Get the CSRF token value from the meta tag
         var csrfToken = $('meta[name="csrf-token"]').attr('content');
   
         // Make an AJAX request to delete the comment
         $.ajax({
           type: 'DELETE',
           url: '/delete-comment/' + commentId,
           headers: {
             'X-CSRF-TOKEN': csrfToken
           },
           success: function(response) {
             if (response.success) {
   
   
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
   
   $('.copy_url').click(function() {
     var urlToCopy = $(this).attr('copy-url');
     var redirect_url = $(this).attr('redirect-url');
     console.log('URL to copy:', urlToCopy);
   
     navigator.clipboard.writeText(urlToCopy)
       .then(function() {
         // Swal.fire({
         //   title: "URL copied to clipboard!",
         //   text: urlToCopy,
         //   icon: "success",
         //   showConfirmButton: false
         // });
         setTimeout(function() {
           window.location.href = redirect_url;
         }, 1500);
       })
       .catch(function(err) {
         console.error('Unable to copy text to clipboard', err);
       });
   });
</script>
<!-- <script>
   $(document).ready(function(){
     $("#show-box").click(function(){
       $(".reply-box-show").show();
     });
     $("#hide-box").click(function(){
       $(".reply-box-show").hide();
     });
     $("#hide-box1").click(function(){
       $(".reply-box-show").hide();
     });
   });
   </script> -->
<script type="text/javascript">
   $(document).ready(function() {
     $(".buttons").on("click", function() {
       $(".overlay").addClass("is-on");
     });
   
     // Event delegation for dynamically added elements
     $(document).on("click", "#close1", function() {
       $(".overlay").removeClass("is-on");
     });
   });
   
   
   
   
   $(document).ready(function(){
       var content = $("#content-ar").html();
       var highlightedContent = content.replace(/#\w+/g, function(match) {
           return '<span class="highlight">' + match + '</span>';
       });
       $("#content-ar").html(highlightedContent);
   });
   
   
   
   $(document).ready(function() {
       $('.hide_comment').click(function() {
   
   
   
         // Use SweetAlert for confirmation
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
          // alert('frbrbr _ hdfsjdfghsjdfh hfgsjdfh ');
         var commID = $(this).attr('data-id');
         var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
         
         $.ajax({
           url: site_url + '/blog/hide',
           type: 'POST',
           headers: {
             'X-CSRF-TOKEN': csrfToken
           },
           data: {
             id: commID,
             status: 0,
           },
           success: function(response) {
             console.log(response);
   
             if (response.success) {
               toastr.success(response.success);
             } else {
               toastr.error(response.error);
             }
             setTimeout(function() {
               window.location.reload()
             }, 3000);
   
           },
           error: function(xhr, status, error) {
             console.log(response);
           }
         });
         }
       });
         
       });
     });
   
   
   
     $(document).ready(function() {
       $('.replyComment').click(function() {
         var commID = $(this).attr('data-id');
         var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
         
         $.ajax({
           url: site_url + '/blog/hide',
           type: 'POST',
           headers: {
             'X-CSRF-TOKEN': csrfToken
           },
           data: {
             id: commID,
             status: 0,
           },
           success: function(response) {
             console.log(response);
   
             if (response.success) {
               toastr.success(response.success);
             } else {
               toastr.error(response.error);
             }
             setTimeout(function() {
               window.location.reload()
             }, 3000);
   
           },
           error: function(xhr, status, error) {
             console.log(response);
           }
         });
       });
     });
   
   $(document).ready(function() {
    $('#reportForm').on('submit', function(e) {
        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            url: site_url + "/report",
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

function savePost(button) {
    var post_id = $(button).attr('data-postid');
    if (!post_id) {
        toastr.error('Something went wrong..!'); 
        return false; 
    }
    console.log('data-postid: ' + post_id);

    var user_id = $(button).attr('data-Userid');
    if (!user_id) {
        toastr.error('You have to login first to save the post.');
        return false;  
    }
    console.log('data-Userid: ' + user_id);

    var post_type = $(button).attr('data-type');
    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    $.ajax({
        url: site_url + "/saved/post",
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": csrfToken
        },
        data: {
            userid: user_id,
            post_id: post_id,
            post_type: post_type
        },
        success: function(response) {
            console.log('success', response);
            toastr.success(response.success);
            if(response.saved === true){
                $(button).text('Saved');
            }
        },
        error: function(response) {
            console.log(response);
            if (response && response.responseJSON && response.responseJSON.error) {
                toastr.error(response.responseJSON.error);
            } else {
                toastr.error('An error occurred while saving the post.');
            }
        }
    });
}
document.addEventListener('DOMContentLoaded', function() {
    let isLiked = false;

    // Show reactions on emoji click
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('emoji')) {
            const likeButton = e.target.closest('.like-button');  // Get the closest like-button
            const reactionsEmojis = likeButton.nextElementSibling; // Get the corresponding reactions-emojis
            if (reactionsEmojis) {
                reactionsEmojis.style.display = reactionsEmojis.style.display === 'none' ? 'block' : 'none';
            }
        }
    });

    // Handle emoji reaction
    document.addEventListener('click', function(e) {
        if (e.target.closest('.reactions-emojis img')) {
            const selectedEmoji = e.target;
            const reactionsContainer = selectedEmoji.closest('.reactions-emojis');
            const likeButton = reactionsContainer.previousElementSibling;  // Get the corresponding like-button
            const selectedEmojiId = selectedEmoji.getAttribute('data-id');
            const selectedEmojiSrc = selectedEmoji.getAttribute('src');
            const userId = likeButton.getAttribute('data-user-id');
            const blogId = likeButton.getAttribute('data-blog-id');
            const blogUserId = likeButton.getAttribute('data-blog-user-id');
            const type = likeButton.getAttribute('data-type');
            const url = likeButton.getAttribute('data-url');

            console.log(type, selectedEmojiId, selectedEmojiSrc, userId, blogId);

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Replace the emoji in the like button with the selected emoji
            likeButton.innerHTML = `<img src="${selectedEmojiSrc}" class="rxn-emoji" id="${selectedEmojiId}" alt="emoji-icon" style="width: 23px; height: 23px;">`;
            reactionsContainer.style.display = 'none';  // Hide reactions

            isLiked = true;

            // AJAX request to like with reaction
            fetch('/listing-like', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    user_id: userId,
                    blog_id: blogId,
                    blog_user_id: blogUserId,
                    action: 'like',
                    type: type,
                    url: url,
                    reaction: selectedEmojiId
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log('Liked successfully.', data);
                updateLikeCount(isLiked, data.total_likes);
                updateLikesPreview(isLiked, data.total_likes);
            })
            .catch(error => {
                console.error("An error occurred: " + error);
            });
        }
    });

    // Handle unlike action
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('rxn-emoji')) {
            const rxnEmoji = e.target;
            const likeButton = rxnEmoji.closest('.like-button');
            const userId = likeButton.getAttribute('data-user-id');
            const blogId = likeButton.getAttribute('data-blog-id');
            const blogUserId = likeButton.getAttribute('data-blog-user-id');
            const type = likeButton.getAttribute('data-type');
            const url = likeButton.getAttribute('data-url');

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Replace the emoji with the thumbs-up icon again
            rxnEmoji.outerHTML = '<i class="fa-regular fa-thumbs-up emoji"></i>';
            isLiked = false;

            // AJAX request to unlike
            fetch('/listing-like', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    user_id: userId,
                    blog_id: blogId,
                    blog_user_id: blogUserId,
                    action: 'unlike',
                    type: type,
                    url: url
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log('Unliked successfully.', data);
                updateLikeCount(isLiked, data.total_likes);
                updateLikesPreview(isLiked, data.total_likes);
            })
            .catch(error => {
                console.error("An error occurred: " + error);
            });
        }
    });

    function updateLikeCount(isLiked, totalLikes) {
        const likeCountElement = $('.likes-count');
        let currentCount = parseInt(totalLikes) || 0; // Get the total likes from the server

        if (isLiked) {
            likeCountElement.text(currentCount);
        } else {
            likeCountElement.text(Math.max(currentCount - 1, 0));
        }
    }

    function updateLikesPreview(isLiked, totalLikes) {
        const likesPreviewElement = $('.likes-preview');
        let currentCount = parseInt(totalLikes) || 0;

         if (!isLiked & currentCount === 0) {
            $('.likes-info').hide();
         } else if (isLiked && currentCount > 1) {
            $('.likes-info').show();
            likesPreviewElement.text(`you and ${currentCount - 1} ${currentCount - 1 === 1 ? 'other' : 'others'}`);
         } else {
            $('.likes-info').show();
            likesPreviewElement.text(`${currentCount} ${currentCount === 1 ? 'like' : 'likes'}`);
         }
    }

});

function showLikes(element) {
    var modal = document.getElementById('showLikesModal');
    modal.style.display = 'block';
}

function closeShowLikes() {
    var modal = document.getElementById('showLikesModal');
    modal.style.display = 'none';
}

// Close the modal when the user clicks outside of it
window.onclick = function(event) {
    var modal = document.getElementById('showLikesModal');
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}

function showLikes(likeId) {

var modal = document.getElementById('showLikesModal');
modal.style.display = 'block';


document.querySelector('.showLikes-list').innerHTML = '';

fetch(`/likes/${likeId}/likes`)
    .then(response => response.json())
    .then(data => {
      console.log(data);
        var likesList = document.querySelector('.showLikes-list');

        if (data.likedUsers.length === 0) {
            likesList.innerHTML = '<div class="no-likes">No one likes this post.</div>';
        } else {
            data.likedUsers.forEach(user => {
               var reactionImage = user.reaction == 1 
                  ? `<img src="${site_url}/public/images/heart-icon.png" width="30px" height="30px" alt="reaction">` 
                  : `<img src="${site_url}/public/images/thumb-icon.png" width="30px" height="30px" alt="reaction">`;

                var likeItem = `
                    <div class="like-item">
                        <a href="${user.url}" target="_blank">
                           <img src="${user.image ? site_url + '/public/assets/images/profile/' + user.image : site_url + '/public/user_dashboard/img/undraw_profile.svg'}" 
                               alt="${user.first_name}" 
                               class="like-user-image">
                        </a>
                        <div class="like-user-info w-100 text-start px-2">
                            <a href="${user.url}" target="_blank">
                                <h6 class="font-weight-bold">${user.first_name}</h6>
                            </a>
                            <a href="${user.url}" target="_blank">
                                <span class="text-muted">${user.username}</span>
                            </a>
                        </div>
                        ${reactionImage}
                    </div>
                `;

                likesList.innerHTML += likeItem;
            });
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


    document.addEventListener('DOMContentLoaded', function() {
        var likesPreview = document.querySelector('.likes-preview');
        var likesInfo = document.querySelector('.likes-info');

        if (likesPreview.innerHTML.trim() === 'no likes') {
            likesInfo.style.display = 'none'; // Hide the likes-info div
        }
    });
</script>

@endsection