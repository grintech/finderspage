<?php

use App\Models\UserAuth; 
$currentuser = UserAuth::getLoginUser();


?>
@extends('layouts.frontlayout')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style type="text/css">
/* core styling */
*, *:before, *:after {padding: 0;margin: 0;box-sizing: border-box;outline: none;}
*::-webkit-scrollbar {display: none;height: 0;width: 0;}
/*body {background-color: #333;font-family: Sans-Serif;}*/
a {text-decoration: none;color: #333;cursor: pointer;}

/* main styling */
/*.container {display: grid;place-items: center;height: 100vh;width: 100vw;}*/
.post-comments-area .dropdown-menu {min-width: max-content;padding: 0 0;}
.post-comments-area .dropdown-menu a {padding: 2px 5px;}
.dots-menu ul.dropdown-menu li .btn:hover {border: 1px solid #cc9c31 !important;border-radius: 0;}
.dots-menu.btn-group a:hover {border: 1px solid #cc9c31 !important;}
.video-container {position: relative;border-radius: 10px;height: 659px;width: 330px;box-shadow: 0 0 50px #000;margin: auto;overflow: scroll;scroll-snap-type: y mandatory;scroll-snap-align: center;scrollbar-width: thin;}
/* video container header */
.video-container-header {position: absolute;top: 20px;left: 0;width: 100%;height: 50px;display: flex;justify-content: space-between;align-items: center;text-align: center;z-index: 3;}
.video-container-header div {width: 100%;height: 100%;display: flex;font-size: 15px;color: #ccc;justify-content: center;align-items: center;cursor: pointer;}
.video-container-header div.active {font-size: 20px;color: #fff;}
.post {position: relative;height: 659px;width: 330px;overflow: hidden;scroll-snap-align: center;padding: 0 0 8px;}
.video-player {position: relative;height: 100%;width: 100%;}
.video-player::before {content: "";position: absolute;top: 0;left: 0;z-index: 1;height: 100%;width: 100%;box-shadow: inset 0 0 120px #000;}
.side-bar {position: absolute;right: 0;top: 50%;z-index: 2;transform: translate(0, -50%);}
.post-footer {position: absolute;width: 80%;bottom: 0;left: 0;padding: 10px;color: #fff;z-index: 2;}
.post-footer a {color: #fff;}
.post-footer .username {display: flex;height: 30px;align-items: center;}
.post-footer .username .username-link::before {content: "@ ";color: #fff;}
.username-link {color: #fff;}
.verfied .verfied-icon, .post-comment-user-verified {height: 20px;width: 20px;margin-left: 10px;font-size: 9px;border-radius: 50%;background-color: #008abf;display: grid;place-items: center;}
.post-description {padding-left: 10px;font-size: 10px;}
.disc-logo {position: absolute;right: 10px;bottom: 10px;height: 50px;width: 50px;border-radius: 50%;overflow: hidden;z-index: 2;animation: disc-anime infinite linear 2s;}
.disc-logo-img {height: 100%;width: 100%;object-fit: cover;transform: scale(1.4);}
.side-bar .profile-follow {position: relative;}
.side-bar .profile-follow .fa-plus {font-size: 10px;position: absolute;top: 65%;left: 50%;transform: translate(-50%);height: 20px;width: 20px;border-radius: 50%;background-color: #ff2828;display: flex;justify-content: center;align-items: center;}
.side-bar .profile-logo-img {overflow: hidden;height: 40px;width: 40px;border-radius: 50%;}
.side-bar .side-icon {cursor: pointer;padding: 6px;font-size: 25px;text-align: center;color: #fff;}
.side-icon p {font-size: 10px;padding-top: 5px;display: none;}

/* post comments */
.post-comments {position: absolute;bottom: -100%;left: 0;height: 50%;width: 100%;border-radius: 10px 10px 0 0;padding: 10px;background-color: #fff;z-index: 5;transition: all 0.5s ease;}
.post-comments::before {content: "";position: absolute;top: 5px;left: 50%;width: 50%;padding: 1px;background-color: #333;border-radius: 50px;transform: translate(-50%);}
.post-comments.open {bottom: 0;}
.close-comment {position: absolute;top: 10px;right: 23px;cursor: pointer;font-size: 20px;font-weight: 300px;color: #000;}
.post-comments-area {height: 250px;overflow: scroll;margin-top: 0px;scrollbar-width: thin; overflow-x: hidden;margin-bottom: 5px;}
.post-comment {margin: 10px auto;display: flex;width: 100%;height: auto;/*align-items: center;*/justify-content: space-between;text-align: left;}
.post-comment-user-name {display: flex;}
.post-comment-user-img {overflow: hidden;border-radius: 50%;height: 35px;width: 35px;}
.post-comment-user-verified {width: 15px;height: 15px;font-size: 10px;}
.post-comment-user-msg {font-size: 12px;color: #000;font-weight: normal;}
.post-comment-like-btn {text-align: center;cursor: pointer;}
.post-comment-like-btn p {font-size: 10px;}
.post-comment-like-btn .post-comment-like-icon.liked {color: #ff2828;}
.post-comment-content {display: flex;flex-direction: column;padding-left: 10px;width: 100%;position: relative;}
.post-comment-input {display: flex;height: 45px;width: 100%;align-items: center;justify-content: flex-start;background-color: #eaeaea;border-radius: 30px;}
.post-comment-text {height: 40px;width: 90%;border: 0;padding: 10px 20px;background-color: transparent;font-size: 14px;}
.post-comment-send {height: 35px;width: 35px;border-radius:50%;border: 0;background-color: #cc9c31;cursor: pointer;margin-right: 6px; font-size: 14px;font-weight: normal;}
.music-name {display: flex;font-size: 10px;padding: 5px;}
.song-name {margin-left: 10px;}
video.post-video {height: 100%;width: 100%;object-fit: cover;}
.post-comments h6{font-weight: 700;padding: 5px 0 10px;font-size: 15px;}
.post-comment-user-name a{font-size: 13px;font-weight: 600;}

/* follow me */
/*
body {background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);background-size: 400% 400%;display: grid;place-items: center;font-size: 20px;color: #000;cursor: pointer;animation: gradient 15s ease infinite;}*/
.follow-me {position: relative;background: #fff;color: #000;display: flex;justify-content: center;align-items: center;border-radius: 5px;width: 50px;height: 50px;position: fixed;top: 50%;right: 30px;transform: translate(-50%);text-align: center;z-index: 3;}
.follow-me::before {content: "Contact me";position: absolute;top: -40px;left: 50%;width: 150px;text-align: center;transform: translate(-50%);background-color: #fff;border-radius: 5px;font-size: 15px;padding: 5px;}
.follow-me::after {content: "";position: absolute;top: -13px;left: 50%;height: 0;width: 0;text-align: center;transform: translate(-50%);border-top: 10px #fff solid;border-right: 10px transparent solid;border-left: 10px transparent solid;}

@keyframes gradient {
0% {background-position: 0% 50%;}
50% {background-position: 100% 50%;}
100% {background-position: 0% 50%;}
}

@keyframes disc-anime {
0% {transform: rotate(0deg);}
100% {transform: rotate(360deg);}
}

#content-share-icons {top: 29%;z-index: 1;left: 80%;right: auto;}
.share-buttons-icons {margin-bottom: 0;}
.share-buttons-icons #social-links ul {padding-left: 0;background-color: #fff;border-radius: 5px;}
.side-bar .dropdown {right: -6px;}
.side-bar .dropdown-menu {bottom: 30px;}
.side-bar .dropdown button {margin-bottom: 0;}
.side-bar .dropdown .dropdown-toggle::after {display: none;}
.post-comments.open {bottom: -55px;}
.post-comments {height: auto;}
.post-comments-area {height: 220px;}
a.username-link {color: #fff !important;}

@media only screen and (max-width:767px) {
#content-share-icons {top: 22%;z-index: 1;left: auto;right: 6px;}
.video-container, .post {height: 500px;}
.fa-ellipsis-h::before, .fa-ellipsis::before {margin-left: 39px;}
.share-buttons-icons li {list-style: none;margin-bottom: -13px;}
}

.video-player {position: relative;}
.play-pause-overlay {position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);cursor: pointer;}
.play-icon, .pause-icon {font-size: 3rem;color: #fff;display: none;/* height: 10px; *//* width: 20px; */}
.play-icon {display: block;}
.play-icon img, .pause-icon img {width: 50px;background-color: white;border-radius: 25px;}
.post-video {width: 100%;height: auto;}
.fa-ellipsis-h::before, .fa-ellipsis::before {margin-left: -19px;}
#dropdownMenuButton i {margin-left: 10px;}
.social-button {font-size: 19px;}
.share-buttons-icons li {list-style: none;margin-bottom: -5px;}
.side-bar {margin-right: 29px;}
/* .share_contents{list-style: none;} */
.comments-box {position: relative;}
.dots-menu {font-size: 15px;position: absolute;right: 0;width: 20px;top: 0px;}
.dots-menu.btn-group>.btn:first-child:not(:last-child):not(.dropdown-toggle) {border-radius: 5px;}
.dots-menu a.btn {
/* @extend .glyphicon !optional;
&:before{
content: "\e235";
} */
}
.dots-menu a.btn:active {box-shadow: none;}
.dots-menu ul.dropdown-menu {right: 21px;}
.dots-menu ul.dropdown-menu li {padding: 0;display: inline-block;}
.dots-menu ul.dropdown-menu li a {margin: 0;width: 100%;}
.myDropdown.show {display: block;top: 40px;}
.myDropdown.dropdown-content a {padding: 6px 16px;}
.btn-primary {color: #fff;background-color: #cc9c31;border-color: #cc9c31;}
.button_for {display: inline-block;font-weight: 400;line-height: 1.5;color: #212529;text-align: center;text-decoration: none;vertical-align: middle;
cursor: pointer;-webkit-user-select: none;-moz-user-select: none;user-select: none;background-color: transparent;border-top-color: transparent;border-right-color: transparent;border-bottom-color: transparent;border-left-color: transparent;padding: .375rem .75rem;font-size: 1rem;border-radius: .25rem;transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;}
.btn-primary:hover {color: #fff;background-color: #cc9c31;border-color: #cc9c31;}
.dots-menu.btn-group>.btn:first-child:not(:last-child):not(.dropdown-toggle) {border-radius: 5px;margin-right: 34px;font-size: 10px;}
.fa-pencil {font-size: 11px;}
.fa-copy {font-size: 11px;}
.fa-trash-o {font-size: 11px;}
.reply-box{display: flex;padding-top: 5px;}
.btn-reply{border:0; font-size: 12px; padding: 0;font-weight: 600;color: #cc9c31;}
.btn-hide{border:0; font-size: 12px; padding: 0; margin-left: 15px;font-weight: 600;color: #cc9c31;}
.post-comment-reply-area{background-color: #000; padding: 10px;position: relative;}
.post-comment-reply-area ul{padding-left: 0;margin-bottom: 0;}
.post-comment-reply-area ul li{display: flex;border-bottom: 1px solid #1c1c1c;padding: 7px 0 15px; }
.post-comment-reply-area ul li:last-child{border-bottom: 0;}
.post-comment-reply-area .post-comment-user-img{width:30px; height: 30px;}
.reply-content{font-size: 13px; font-weight: normal;padding-left: 10px;padding-right: 10px;}
.close-area .close-comment{color: #fff;top:0; right:10px; cursor: pointer;}
.reply-frame{padding:5px 10px 5px 35px; display: flex;}
.reply-frame img{width:30px; height: 30px;border-radius: 50%;}
.reply-frame span{font-size: 13px; color: #000;padding-left: 5px;}
.reply-box-show{display: none;}

.btn-reply1{border:0; font-size: 11px; padding: 0;font-weight: 600;color: #cc9c31;position: relative;bottom: -13px;left: -34px;}
.video-player ~ .post-comments.open{height:60%;}
.video-player.shrink {
    width: 320px; /* Shrunk width */
    height: 300px; /* Shrunk height */
}

</style>
<div class="container">

  <div class="video-container">
    @foreach ($video as $v)
    <div class="post">
      <div class="video-player" id="test">

        <video class="post-video" controls src="{{asset('video_short')}}/{{$v['video']}}" loop playsinline>
          <!-- <track default kind="captions" srclang="en" src="https://finderspage.com/public/assets/your-subtitles.vtt" /> -->
        </video>
        <video style="display:none;" poster="" src="{{asset('video_short')}}/{{$v['video']}}" loop playsinline class="post-video">
          <track kind="subtitles" src="https://finderspage.com/public/assets/your-subtitles.vtt" srclang="en" label="English">
        </video>
        <div class="play-pause-overlay">
          <span class="play-icon videoplayicons"><img src="https://finderspage.com/public/assets/img/play.png" alt="play" /></span>
          <span class="pause-icon videoplayicons"><img src="https://finderspage.com/public/assets/img/pause.png" alt="play" /></span>
        </div>
      </div>
      <br>
      <div class="side-bar">
        <div class="side-icon profile-follow">
          @foreach ($users as $user)
          @if($user->id == $v['user_id'])
          <div class="profile-logo connect" dataProfile-id="{{$user->id}}" dataLogin-id="{{UserAuth::getLoginId()}}">
            <img src="{{asset('assets/images/profile')}}/{{$user->image}}" class="profile-logo-img" alt="">
            <i class="fa fa-plus"></i>
          </div>
          @endif
          @endforeach

        </div>
       <!--  @if(UserAuth::getLoginId())
        @if($v['comment_view_as'] == "public") -->
        <div class="side-icon comment-btn">
          <i class="fa fa-comment comment-icon"></i>
          <p class="comment-number"></p>
        </div>
        <!-- @endif
        @else
        <i class="fa fa-comment comment-icon" style="
            margin-top: 1px;
            font-size: 31px;
            margin-left: 12px;
        " onclick="showAlert()"></i>
        @endif -->
        <!-- Use a common class for all share buttons -->
        <div class="side-icon share-btn toggle-share" data-id="{{$v['id']}}">
          
          <i class="fa fa-share share-icon"></i>
          

          <div id="content-share-icons{{$v['id']}}" style="display: none;" class="">
            <div style="position: relative;">
              <ul class="share-buttons-icons">
                <li class="share_contents">
                {!! $shareComponent !!}
                </li>
                <!-- <li><a href="#" class="i1" title="Share on Email" rel="nofollow" target="_blank"><i class="fa fa-envelope"></i></a></li>
            <li><a href="{{url('/share/video/facebook')}}" class="i2" title="Share on Facebook" rel="nofollow" target="_blank"><i class="fa fa-facebook"></i></a></li>
            <li><a href="#" class="i3" title="Share on Twitter" rel="nofollow" target="_blank"><i class="fa fa-twitter"></i></a></li>
            <li><a href="#" class="i4" title="Share on LinkedIn" rel="nofollow" target="_blank"><i class="fa fa-linkedin"></i></a></li>
            <li><a href="#" class="i5" title="Share on Pinterest" rel="nofollow" target="_blank"><i class="fa fa-pinterest-p"></i></a></li>
            <li><a href="#" class="i6" title="Share on WhatsApp" rel="nofollow" target="_blank"><i class="fa fa-whatsapp"></i></a></li> -->
              </ul>
            </div>
          </div>

          <p class="share-number"></p>
        </div>


        <div class="dropdown">
          <button class="social-thumb-icon dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-ellipsis-h"></i>
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#exampleModal{{$v['id']}}"><i class="fas fa-grip-lines"></i> Description</a>

            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#exampleModalmension{{$v['id']}}"><i class="fas fa-at"></i>&nbsp;Mention</a>

            <a class="dropdown-item videoSaveData" data-id="{{$v['id']}}" href="javascript:void(0);"><i class="fas fa-plus"></i> Save Video</a>
          </div>
        </div>

      </div>


      <div class="post-comments ">
        <h6 class="text-center text-dark">Comments @if($v['user_id'] == UserAuth::getLoginId() ) {{$vid_comments->count()}} @endif</h6>
        <span class="close-comment">&times;</span>
        <div class="post-comments-area">

          @foreach($vidcomments as $comm)
          @foreach($users as $user)
          @if($user->id == $comm->user_id)
          @if($comm->user_id == UserAuth::getLoginId() && $comm->video_id == $v['id'] && $comm->status==1)
           
          <div class="post-comment">
            <div class="post-comment-user ">
              <img src="{{asset('assets/images/profile')}}/{{$user->image}}" alt="Image" class="post-comment-user-img">
            </div>
            <div class="post-comment-content">
              <div class="post-comment-user-name verfied">
                <a href="{{route('UserProfileFrontend',$user->id)}}">{{$user->first_name}}</a>
                <!-- <i class="fa fa-check post-comment-user-verified"></i> -->
              </div>
              <div class="post-comment-user-msg">
                {{$comm->comment}}
              </div>
              <div class="reply-box">
                <button type="button" class="btn btn-reply show-box" id="show-box"> 1 Reply</button>
                <!-- <button type="button" class="btn btn-hide" id="hide-box">Hide</button> -->
              </div>

              @if(UserAuth::getLoginId() == $v['user_id'])
              <div class="dots-menu btn-group">
                <a data-toggle="dropdown" class="btn btn-primary" onclick="showDropdown({{$comm->id}})"><i class='fas fa-ellipsis-v'></i></a>
                <ul class="dropdown-menu" id="dropdown-{{$comm->id}}">
                  <li><a class="btn btn-primary button_for" data-bs-toggle="modal" data-bs-target="#exampleModalToggle{{$comm->id}}" id="editLink{{$comm->id}}"><i class="fa fa-pencil"></i></a>
                  </li>
                  <li> <a class="btn btn-primary button_for copyButton" data-bs-toggle="modal" id="copyButton{{$comm->id}}">
                      <i class="fa-solid fa-copy"></i>
                    </a>
                  </li>
                  <li>
                    <a class="btn btn-danger button_for" onclick="deleteComment({{$comm->id}})">
                      <i class="fa fa-trash-o"></i>
                    </a>
                  </li>
                </ul>
              </div>

              @elseif($comm->user_id == UserAuth::getLoginId())

              <div class="dots-menu btn-group">
                <a data-toggle="dropdown" class="btn btn-primary" onclick="showDropdown({{$comm->id}})"><i class='fas fa-ellipsis-v'></i></a>
                <ul class="dropdown-menu" id="dropdown-{{$comm->id}}">
                  <li><a class="btn btn-primary button_for" data-bs-toggle="modal" data-bs-target="#exampleModalToggle{{$comm->id}}" id="editLink{{$comm->id}}"><i class="fa fa-pencil"></i></a>
                  </li>
                  <li> <a class="btn btn-primary button_for copyButton" data-bs-toggle="modal" id="copyButton{{$comm->id}}">
                      <i class="fa-solid fa-copy"></i>
                    </a>
                  </li>
                  <li>
                    <a class="btn btn-danger button_for" onclick="deleteComment({{$comm->id}})">
                      <i class="fa fa-trash-o"></i>
                    </a>
                  </li>
                </ul>
              </div>
              
              <!-- Modal for this comment -->
              <div class="modal fade" id="exampleModalToggle{{$comm->id}}" aria-hidden="true" aria-labelledby="exampleModalToggleLabel{{$comm->id}}" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalToggleLabel{{$comm->id}}">Edit Comment</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <input type="text" value="{{$comm->comment}}" class="form-control edit-comment-{{$comm->id}}">
                    </div>
                    <div class="modal-footer">
                      <button comment_id="{{$comm->id}}" class="saved_post_btn save-post">Update</button>
                    </div>
                  </div>
                </div>
              </div>
              @endif
            </div>

            <div class="post-comment-like-btn">
              <i class="fa fa-heart-o post-comment-like-icon"></i>
              <p class="post-comment-like-number">6</p>
            </div>
          </div>
         
          <div class="reply-box-show">
            @foreach($vidcommentsReply as $replyComment)
              @if($replyComment->vid_reply_id == $comm->id)
              <div class="post-comment-reply-area">
                <div class="post-comment-user ">
                  <img src="{{asset('assets/images/profile')}}/{{$user->image}}" alt="Image" class="post-comment-user-img">
                </div>
                <div class="reply-content">{{$replyComment->comment}}</div>
                <div class="close-area">
                  <span class="close-comment hide-box1" id="hide-box1">×</span>
                </div>
                <button type="button" class="btn btn-reply1">Reply</button>
              </div>
              @endif
            @endforeach
            <div class="reply-frame">
              <!-- <img src="{{asset('assets/images/profile')}}/{{$currentuser->image}}" alt="Image" class="post-comment-user-img"> -->
              <span>
                <input class="reply_comment" type="text" name="reply_comment" placeholder="Reply to user" style="border:none; width:118px;">
                <button class="post-comment-send send_btn_replay" video_ID="{{$v['id']}}"  user_id="{{UserAuth::getLoginId()}}" comm_id="{{$comm->id}}"   style="height: 30px; width: 30px; background-color: #ffffff;"><i vid-id="59" userid="2132" class="fa fa-send" aria-hidden="true"></i></button>
              </span>
            </div> 
          </div>


          @elseif($v['user_id'] == UserAuth::getLoginId() )
          @if($comm->video_id == $v['id'])

          @if($comm->status == 1)
          <div class="post-comment">
            
            <div class="post-comment-user ">
              <img src="{{asset('assets/images/profile')}}/{{$user->image}}" alt="Image" class="post-comment-user-img">
            </div>
            <div class="post-comment-content">
              
              <div class="post-comment-user-name verfied">
                <a href="{{route('UserProfileFrontend',$user->id)}}">{{$user->first_name}}</a>
                <!-- <i class="fa fa-check post-comment-user-verified"></i> -->
              </div>
              <div class="post-comment-user-msg">
                {{$comm->comment}}
              </div>
              <div class="reply-box">
                <button type="button" class="btn btn-reply show-box" id="show-box">1 Reply</button>
                <button data-toggle="tooltip" data-placement="top" title="Click to hide this comment." type="button" data-id="{{$comm->id}}" data-status="@if($comm->status == '1') 0 @else 1 @endif" class="btn btn-hide hide-box" id="hide-box">@if($comm->status == '1') Hide @else Show @endif</button>
              </div>

          <div class="reply-box-show">
            <div class="post-comment-reply-area">
                  <div class="close-area">
                    <span class="close-comment hide-box1" id="hide-box1">×</span>
                  </div>
              <ul>
                <?php echo"<pre>"; print_r($vidcommentsReply); echo"</pre>";?>
                @foreach($vidcommentsReply as $replyComment)



                @if($replyComment->vid_reply_id == $comm->id )
                  <li>
                    <div class="post-comment-user ">
                      <img src="{{asset('assets/images/profile')}}/{{$user->image}}" alt="Image" class="post-comment-user-img">
                    </div>
                    <div class="reply-content">{{$replyComment->comment}}</div>
                    
                       @if($replyComment->vid_reply_id == $replyComment->id)
                          <div class="reply-content sub-commnt">Reply comment here</div>
                       @endif
                  
                    <button type="button" class="btn btn-reply1 cmnt-in-cmnt">Reply</button>

                    <div class="cmnt-in-cmnt-frame" style="display:none; ">
                      <span>
                          <input class="reply_to_comment" type="text" name="reply_to_comment" placeholder="Reply to comment" style="border:none; width:118px;">
                          <button class="post-comment-send send_btn_comnt_in_comnt" video_ID="{{$v['id']}}"  user_id="{{UserAuth::getLoginId()}}" comm_id="{{$replyComment->id}}" style="height: 30px; width: 30px; background-color: #ffffff;"><i class="fa fa-send" aria-hidden="true"></i></button>
                      </span>
                    </div> 

                  </li>
                  @endif
                @endforeach
              </ul>
            </div>

         
            <div class="reply-frame">
              <!-- <img src="{{asset('assets/images/profile')}}/{{$currentuser->image}}" alt="Image" class="post-comment-user-img"> -->
              <span>
               <input class="reply_comment" type="text" name="reply_comment" placeholder="Reply to user" style="border:none; width:118px;">
                <button class="post-comment-send send_btn_replay" video_ID="{{$v['id']}}"  user_id="{{UserAuth::getLoginId()}}" comm_id="{{$comm->id}}"   style="height: 30px; width: 30px; background-color: #ffffff;"><i class="fa fa-send" aria-hidden="true"></i></button>
              </span>
            </div> 
          </div>
          
              @if(UserAuth::getLoginId() == $v['user_id'])
              <div class="dots-menu btn-group">
                <a data-toggle="dropdown" class="btn btn-primary" onclick="showDropdown({{$comm->id}})"><i class='fas fa-ellipsis-v'></i></a>
                <ul class="dropdown-menu" id="dropdown-{{$comm->id}}">
                  <li> <a class="btn btn-primary button_for copyButton" data-bs-toggle="modal" id="copyButton{{$comm->id}}">
                      <i class="fa-solid fa-copy"></i>
                    </a>
                  </li>
                  <li>
                    <a class="btn btn-danger button_for" onclick="deleteComment({{$comm->id}})">
                      <i class="fa fa-trash-o"></i>
                    </a>
                  </li>
                </ul>
              </div>

              @elseif($comm->user_id == UserAuth::getLoginId())
              <div class="dots-menu btn-group">
                <a data-toggle="dropdown" class="btn btn-primary" onclick="showDropdown({{$comm->id}})"><i class='fas fa-ellipsis-v'></i></a>
                <ul class="dropdown-menu" id="dropdown-{{$comm->id}}">
                  <li><a class="btn btn-primary button_for" data-bs-toggle="modal" data-bs-target="#exampleModalToggle{{$comm->id}}" id="editLink{{$comm->id}}"><i class="fa fa-pencil"></i></a>
                  </li>
                  <li> <a class="btn btn-primary button_for copyButton" data-bs-toggle="modal" id="copyButton{{$comm->id}}">
                      <i class="fa-solid fa-copy"></i>
                    </a>
                  </li>
                  <li>
                    <a class="btn btn-danger button_for" onclick="deleteComment({{$comm->id}})">
                      <i class="fa fa-trash-o"></i>
                    </a>
                  </li>
                </ul>
              </div>
              @endif


              <!-- Modal for this comment -->
              <div class="modal fade" id="exampleModalToggle{{$comm->id}}" aria-hidden="true" aria-labelledby="exampleModalToggleLabel{{$comm->id}}" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalToggleLabel{{$comm->id}}">Edit Comment</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <input type="text" value="{{$comm->comment}}" class="form-control edit-comment-{{$comm->id}}">
                    </div>
                    <div class="modal-footer">
                      <button comment_id="{{$comm->id}}" class="saved_post_btn save-post">Update</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="post-comment-like-btn">
              <i class="fa fa-heart-o post-comment-like-icon"></i>
              <p class="post-comment-like-number">6</p>
            </div>
          </div>

          @endif

          @if($comm->status == 0)
          <div class="post-comment hiddneComment">
            <div class="post-comment-user ">
              <img src="{{asset('assets/images/profile')}}/{{$user->image}}" alt="Image" class="post-comment-user-img">
            </div>
            <div class="post-comment-content">
              <div class="post-comment-user-name verfied">
                <a href="{{route('UserProfileFrontend',$user->id)}}">{{$user->first_name}}</a>
                <!-- <i class="fa fa-check post-comment-user-verified"></i> -->
              </div>
              <div class="post-comment-user-msg">
                {{$comm->comment}}
              </div>
              <div class="reply-box">
                <button type="button" class="btn btn-reply show-box" id="show-box">Reply</button>
                <button data-toggle="tooltip" data-placement="top" title="This comment hide click to show this comment to other members"  type="button" data-id="{{$comm->id}}" data-status="@if($comm->status == '1') 0 @else 1 @endif" class="btn btn-hide hide-box" id="hide-box">@if($comm->status == '1') Hide @else Show @endif</button>

                <button data-toggle="tooltip" data-placement="top" title="Delete comment"  type="button" onclick="deleteComment({{$comm->id}})"  class="btn btn-hide" id="hide-box"><i class="fa fa-trash-o"></i></button>
              </div>
            </div>
          </div>
          @endif

          @endif
          @endif
          @endif
          @endforeach
          @endforeach



        </div>
        <div class="post-comment-input">
          <input type="text" name="" class="post-comment-text comment-input" placeholder="Add a comment" />
          <button class="post-comment-send"><i vid-id="{{$v['id']}}" userid="{{UserAuth::getLoginId()}}" class="fa fa-send send-btn"></i></button>
        </div>
      </div>
      <div class="post-footer">
        <div class="username verfied">
          @foreach ($users as $user)
          @if($user->id == $v['user_id'])
          <h2 style="font-size:20px"><a href="#" class="username-link ">{{$user->username}}</a></h2>
          @if($user->feature_end_date != null && $user->feature_end_date >= $currentDate )<i class="fas fa-star" style="color: gold; margin-bottom:10px;"></i>@endif
          @endif
          @endforeach
        </div>
        <p class="post-description">
          {{$v['title']}}
        </p>

        <!-- <div class="music-name">
          <i class="fa fa-music"></i>
          <marquee behavior="" direction="" class="song-name">Tungevaag, Raaban - Bad Boy </marquee>
        </div> -->

      </div>
      <!-- <div class="disc-logo">
        <img src="https://www.nicepng.com/png/detail/329-3297274_compact-disc-cd-comments-disc-icon-png.png" alt="" class="disc-logo-img">
      </div> -->
    </div>

    <!-- Modal -->
    <div class="modal desc-modal fade" id="exampleModal{{$v['id']}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header py-0">
            <h5 class="modal-title" id="exampleModalLabel">Description</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="comments-box">
              <div class="comments-area1">

                <p id="description">{!!$v['description']!!}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>




    <!-- Modal -->
    <div class="modal desc-modal fade" id="exampleModalmension{{$v['id']}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header py-0">
            <h5 class="modal-title" id="exampleModalLabel">Mention</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="comments-box">
              <div class="comments-area1">
                <?php
                $withoutAt = str_replace("@", "", $v['mension']);
                $decode = json_decode($withoutAt);
                // echo "<pre>";
                // print_r($decode);

                // Check if decoding was successful
                if ($decode !== null) {
                  foreach ($decode as $Men_user) {
                    foreach ($users as $user) {
                      if ($user->username == $Men_user) {
                ?>
                        <div class="frame1">
                          <div class="img-icon1">
                            <img class="img-fluid rounded-circle" alt="image" height="40" width="40" src="@if($user->image != ''){{ asset('assets/images/profile/'.$user->image) }}@else{{ asset('user_dashboard/img/undraw_profile.svg') }}@endif">

                          </div>
                          <div class="comments-area2">
                            <h6> <em>@</em>{{$user->username}}</h6>
                          </div>
                        </div>

                <?php
                      }
                    }
                  }
                }
                ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>




</div>

<script>
$(document).ready(function(){
    // Get the text content of the element
    var description = $('#description').html();

    var urlRegex = /https?:\/\/[^\s]+(\s+[^\s]+)*/;
  
    var updatedDescription = description.replace(urlRegex, function(url) {
        return '<a href="' + url + '" class="btn btn-sm btn-primary">Check it</a>';
    });
    // console.log(updatedDescription);
    $('#description').html(updatedDescription);
});
</script>

<script>
  function showAlert() {
    Swal.fire({
      // title: "Are you sure?",
      text: "You have to login first to comment on this video.",
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
        window.location.href = "https://finderspage.com/login";
      }
    });

  }

  // function showAlertshare() {
  //   Swal.fire({
  //     // title: "Are you sure?",
  //     text: "You have to login first to share this video.",
  //     icon: "warning",
  //     showCancelButton: true,
  //     confirmButtonColor: "#3085d6",
  //     cancelButtonColor: "#d33",
  //     confirmButtonText: "Go to login"
  //   }).then((result) => {
  //     if (result.isConfirmed) {
  //       window.location.href = "https://finderspage.com/login";
  //     }
  //   });
  // }
</script>
<script type="text/javascript">
  const post = document.querySelectorAll(".post");


  $(document).ready(function() {
    var videos = $('.post-video');
    var currentPlayingVideo;

    var options = {
      root: null,
      rootMargin: '0px',
      threshold: 0.5
    };

    var observer = new IntersectionObserver(handleIntersection, options);

    videos.each(function(index, video) {
      observer.observe(video);
    });

    // Play the first video on page load
    var firstVideo = videos.first()[0];
    if (firstVideo) {
      currentPlayingVideo = firstVideo;
      togglePlayPause(currentPlayingVideo);
    }

    // Add click event listener to all .video-player elements
    $('.video-player').on('click', function() {
      // Find the corresponding video element
      var clickedVideo = $(this).find('video')[0];

      // Pause all videos except the clicked one
      videos.each(function(index, video) {
        if (video !== clickedVideo) {
          video.pause();
        }
      });

      // Toggle play/pause on the clicked video
      togglePlayPause(clickedVideo);
    });

    function handleIntersection(entries, observer) {
      entries.forEach(function(entry) {
        var video = entry.target;

        if (entry.isIntersecting) {
          if (video !== currentPlayingVideo) {
            // Pause the previously playing video
            togglePlayPause(currentPlayingVideo);

            // Set the new video as the currently playing video
            currentPlayingVideo = video;

            // Play the new video
            togglePlayPause(currentPlayingVideo);
          }
        } else {
          // Video is not in the viewport, pause it
          if (video !== currentPlayingVideo) {
            video.pause();
          }
        }
      });
    }


    function togglePlayPause(video) {
      var overlay = $(video).siblings('.play-pause-overlay');

      // Add this line to reset the blur when playing
      overlay.removeClass('blurred');

      overlay.find('.pause-icon').css('opacity', 1);
      overlay.find('.play-icon').css('opacity', 1);

      if (video.paused) {
        video.play().catch(function(error) {
          console.error('Error playing video:', error.message);
        });

        overlay.find('.play-icon').hide();
        overlay.find('.pause-icon').show();

        // Add a class to the overlay to trigger the blur effect
        overlay.addClass('blurred');
      } else {
        video.pause();
        overlay.find('.play-icon').show();
        overlay.find('.pause-icon').hide();
      }

      setTimeout(function() {
        overlay.find('.pause-icon').css('opacity', 0);
        overlay.find('.play-icon').css('opacity', 0);

        // Remove the class after the animation is complete
        overlay.removeClass('blurred');
      }, 3000); // Adjust the delay (in milliseconds) as needed


    }



    // Example: Mute/Unmute on button click
    $('#muteButton').on('click', function() {
      videos.each(function(index, video) {
        video.muted = !video.muted;
      });
    });
  });







  $(document).ready(function() {
    $('.videoSaveData').click(function() {
      var video_id = $(this).attr('data-id');
      // alert(video_id);
      var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
      $.ajax({
        url: site_url + '/video_save',
        type: 'POST',
        headers: {
          'X-CSRF-TOKEN': csrfToken
        },
        data: {
          video_id: video_id
        },
        success: function(response) {
          console.log(response.success);
          toastr.success(response.success);

        },
        error: function(xhr, status, error) {
          console.log(error);
          Swal.fire({
            // title: "Are you sure?",
            text: "You have to login first to save  this video.",
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
              window.location.href = "https://finderspage.com/login";
            }
          });
        }
      });
    });
  });

  jQuery(document).ready(function() {
    $(".connect").on("click", function() {
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
            toastr.success(response.success);
            window.location.reload();
          }

          if (response.error) {
            toastr.error(response.error);
          }

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
            toastr.success(response.success);
            window.location.reload();
          }

          if (response.error) {
            toastr.error(response.error);
          }

        },
        error: function(xhr, status, error) {
          console.log(xhr.responseText);
          toastr.error(response.message);
        }
      });
    });
  });


  // post comment box
  const postComments = document.querySelectorAll(".post-comments");
  const commentBtn = document.querySelectorAll(".comment-btn");
  const commentClose = document.querySelectorAll(".close-comment");
   

 postComments.forEach((item, index) => {
  if (commentBtn[index] && commentClose[index]) {
    commentBtn[index].addEventListener("click", function() {
      postComments[index].classList.add("open");
    });

    commentClose[index].addEventListener("click", function() {
      postComments[index].classList.remove("open");
    });
  }
});

  //add coments to post

  



  $('.send-btn').click(function() {
    var userid = $(this).attr('userid');
    var video_id = $(this).attr('vid-id');
    var comment = $('.comment-input').val();

    console.log('userid: ' + userid);
    console.log('video_id: ' + video_id);
    console.log('comment: ' + comment);

    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    $.ajax({
      url: site_url + '/video_comment',
      type: 'POST',
      headers: {
        'X-CSRF-TOKEN': csrfToken
      },
      data: {
        userid: userid,
        video_id: video_id,
        comment: comment,
      },
      success: function(response) {
        console.log(response);
        // location.reload();
        toastr.success(response.success);
        $('.post-comments-area').load(location.href + ' .post-comments-area');
       
      },
      error: function(xhr, status, error) {
        console.error(xhr.responseText);
        toastr.success(xhr.responseText);
      }
    });
  });

$('.send_btn_replay').click(function() {
    var userid = $(this).attr('user_id');
    var video_id = $(this).attr('video_ID');
    var comment_id = $(this).attr('comm_id');
    var comment = $(this).closest('.reply-frame').find('.reply_comment').val();
    // alert(comment);
    console.log('userid: ' + userid);
    console.log('video_id: ' + video_id);
    console.log('comment: ' + comment);

    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    $.ajax({
      url: site_url + '/video/reply',
      type: 'POST',
      headers: {
        'X-CSRF-TOKEN': csrfToken
      },
      data: {
        userid: userid,
        video_id: video_id,
        comment_id: comment_id,
        comment: comment,
      },
      success: function(response) {
        $('.post-comments-area').load(location.href + ' .post-comments-area');
         toastr.success(response.success);
      },
      error: function(xhr, status, error) {
        console.error(xhr.responseText);
        toastr.success(xhr.responseText);
      }
    });
  });

// comnt in comnt reply ajax

  $('.send_btn_comnt_in_comnt').click(function() {
    alert("Herer");
    var userid = $(this).attr('user_id');
    var video_id = $(this).attr('video_ID');
    var comment_id = $(this).attr('comm_id');
    var comment = $(this).closest('.cmnt-in-cmnt-frame').find('.reply_to_comment').val();
    console.log('userid: ' + userid);
    console.log('video_id: ' + video_id);
    console.log('comment: ' + comment);

    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    $.ajax({
      url: site_url + '/video/reply',
      type: 'POST',
      headers: {
        'X-CSRF-TOKEN': csrfToken
      },
      data: {
        userid: userid,
        video_id: video_id,
        comment_id: comment_id,
        comment: comment,
      },
      success: function(response) {
        $('.post-comments-area').load(location.href + ' .post-comments-area');
         toastr.success(response.success);
      },
      error: function(xhr, status, error) {
        console.error(xhr.responseText);
        toastr.success(xhr.responseText);
      }
    });
  });


  const postCommentSendBtn = document.querySelectorAll(".send-btn");
  const postCommentText = document.querySelectorAll(".post-comment-text");
  const postCommentArea = document.querySelectorAll(".post-comments-area");

  jQuery('.toggle-share').click(function() {
    var vidId = $(this).attr('data-id');
    const elToggle = $(".toggle-share[data-id='" + vidId + "']");
    const elContent = $("#content-share-icons" + vidId);

    // Toggle the 'display' property
    if (elContent.css('display') === 'block') {
      elContent.css({
        'display': 'none',
        'opacity': '0',
        'visibility': 'hidden'
      });
    } else {
      elContent.css({
        'display': 'block',
        'opacity': '1',
        'top': '25%',
        'position': 'absolute',
        'visibility': 'visible',
        'width': '51px',
        'right': '0',
        'left': '17px',
        'z-index': '1'

      });
    }
     // alert("jsdfjbh")

  });
</script>


<script>
  function showDropdown(Id) {
    var dropdown = document.getElementById("dropdown-" + Id);
    dropdown.classList.toggle("show");
  }
</script>


<script>
  document.getElementById('editLink{{$comm->id}}').addEventListener('click', function() {
    $('#exampleModalToggle{{$comm->id}}').modal('show');
  });
</script>
<script>
  $(document).ready(function() {
    $(".save-post").on("click", function() {
      var commentId = $(this).attr('comment_id');
      var editedComment = $(".edit-comment-" + commentId).val();

      $.ajax({
        url: "/video_comment_update/" + commentId,
        type: "POST",
        data: {
          _token: $('meta[name="csrf-token"]').attr("content"),
          commentId: commentId,
          editedComment: editedComment,
        },
        success: function(response) {
          if (response.success) {
              toastr.success(response.success);
             $('.post-comments-area').load(location.href + ' .post-comments-area');
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
          url: '/video_comment_delete/' + commentId,
          headers: {
            'X-CSRF-TOKEN': csrfToken
          },
          success: function(response) {
            if (response.success) {
              toastr.success(response.success);
              $('.post-comments-area').load(location.href + ' .post-comments-area');
            } else {
              toastr.success(response.success);
              $('.post-comments-area').load(location.href + ' .post-comments-area');
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
    $('.copyButton').click(function() {
      var comment_id = $(this).closest('.dropdown-menu').attr('id').replace('dropdown-', '');
      var comment = $('.edit-comment-' + comment_id).val().trim();
      if (comment !== "") {
        navigator.clipboard.writeText(comment).then(function() {
          console.log('Text copied to clipboard');
        }, function(err) {});
      }
    });
  });
</script>

<script>
$(document).ready(function(){
  $(document).on("click",".show-box",function(){
    $(this).parent().next(".reply-box-show").show();

    // $(".reply-box-show").show();
  });
  $(document).on("click",".hide-box",function(){
    $(this).parent().next(".reply-box-show").hide();
    // $(".reply-box-show").hide();
  });
  $(document).on("click",".hide-box1",function(){
  // $(".hide-box1").click(function(){
    $(this).closest(".reply-box-show").hide();
    // $(".reply-box-show").hide();
  });
});



$(document).ready(function() {
    $(document).on("click",".hide-box" ,function() {
      var commentId = $(this).attr('data-id');
      var status = $(this).attr('data-status');
      console.log(status);
      console.log(commentId);
      $.ajax({
        url: site_url +"/video-comment-hide",
        type: "POST",
        data: {
          _token: $('meta[name="csrf-token"]').attr("content"),
          commentId: commentId,
          status: status,
        },
        success: function(response) {
          if (response.success) {
            toastr.success(response.success);
             $('.post-comments-area').load(location.href + ' .post-comments-area');
          } else {
            toastr.success(response.success);
            // alert("Error hiding comment!");
          }
        },
        error: function() {
          alert("Error hide eeee comment!");
        },
      });
    });
  });


$(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
<script>
$(document).ready(function() {
    // $('.comment-btn').click(function() {
    $(document).on("click",".comment-btn" ,function() {
      // $('.video-player').addClass('shrink');
      $(this).closest('.side-bar').siblings('.video-player').addClass('shrink');
    });

    $(document).on("click",".close-comment" ,function() {
      $(this).closest('.post-comments').removeClass('open');
      $(this).closest('.post-comments').siblings('.video-player').removeClass('shrink');
      // $('.video-player').removeClass('shrink');
    });

    // coment in commment
    $(document).on("click",".cmnt-in-cmnt" ,function() {
      $(this).next('.cmnt-in-cmnt-frame').show();
    });

    
});
</script>
@endsection