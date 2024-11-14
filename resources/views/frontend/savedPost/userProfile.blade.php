<?php
use App\Models\Admin\Notification;
use App\Models\UserAuth;
use App\Models\Setting;
$notification = new Notification();
// $notifications = $notification->getAllNoticeForUser(UserAuth::getLoginId());
$countNotice = $notification->getUserCount(UserAuth::getLoginId());


?>
@extends('layouts.frontlayout')
@section('content')
<style type="text/css">
  .card-body {
    display: block;
  }

  p.mb-4 {
    display: grid;
  }

  a span,
  .card-body .col-sm-3 p {
    font-weight: 600;
  }
  .icon-container {
  width: 80px;
  height: 80px;
  position: relative;
  margin-left: 41px;
  filter: drop-shadow(0 0 4px #eac14a);
}

.status-circle {
  width: 15px;
  height: 15px;
  border-radius: 50%;
  background-color: #fb0000;
  border: 2px solid white;
  bottom: 0;
  right: 0;
  position: absolute;
}
.mekestyle{
  padding: 12px;
  display: inline-flex;
  overflow: hidden;
  overflow-x: auto;
  overflow-y: hidden;
  white-space: nowrap;
  scrollbar-width: thin;
}

 .connectedMember {
  height: 100%;
  width: 100%;
  border-radius: 50%;
 
}

</style>
<section style="background-color: #ab8b43;">
  @if($user->id == UserAuth::getLoginId())
  <div class="container pt-3">
    <div class="row">
      <div class="col-lg-12 mekestyle">
        @foreach($followerDetailsArray as $followers)
        <?php $notifications = $notification->getAllNoticeForUser($followers['id']); ?>
        <a href="{{route('UserProfileFrontend',$followers['id'])}}" >
          <div class='icon-container'>
            <img class="connectedMember" src="{{ $followers['image'] != '' ? asset('assets/images/profile/'.$followers['image']) : asset('front/images/user3.png') }}"/>
            <!-- <div class='status-circle'></div> -->
            @foreach($notifications as $notice)
              @if($notice->to_id == $followers['id'])
                <div data-id="{{$notice->to_id}}" class='status-circle'></div>
              @endif
            @endforeach
          </div>
        </a>
      @endforeach
      </div>
    </div>
  </div>
  @endif
  <div class="container pt-2 pb-5">

    <div class="row">
      <div class="col-lg-4">
        <div class="card mb-4 p-1">
          <div class="card-body text-center cx">
            <!-- <div class="popup">
              <img src="{{ $user->image != '' ? asset('assets/images/profile/'.$user->image) : asset('front/images/user3.png') }}" alt="avatar" class="rounded-circle img-fluid" style="width: 150px;">
            </div> -->
            <div class="popup">
              <img src="{{ $user->image != '' ? asset('assets/images/profile/'.$user->image) : asset('front/images/user3.png') }}" alt="avatar" class="rounded-circle img-fluid" style="width: 150px;">

            </div>

            <div class="show1">
              <div class="img-show">
                <span class="close1" title="Close"><i class="fas fa-times"></i></span>
                <img src="" alt="">
              </div>
            </div>
            <h1 style="font-size: 20px;" class="my-3"> <?php
                                                        $currentDate = date("Y-m-d");
                                                        ?>
              <strong style="text-transform: capitalize;">{{$user->first_name}}@if($user->feature_end_date != null && $user->feature_end_date >= $currentDate )<i class="fas fa-star" style="color:#c9a53f;"></i>@endif</strong>
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
            </h1>
            <p class="text-muted mb-1">
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

            </p><br>

            @if($user->id == UserAuth::getLoginId())
            <strong class="zodiac_img"><img src="{{asset('zodiac_image/eye.png')}}" alt="eye.png"></strong> <strong>{{ $profile_view ?? 0 }}</strong>
            @endif
            <p class="text-muted mb-4"></p>
            <div class="d-flex justify-content-center mb-2 button-area">
              @if(UserAuth::getLoginId() == $user->id)
              <a href="{{route('get.followers',UserAuth::getLoginId())}}" class="btn create-post-button" dataProfile-id="{{$user->id}}" dataLogin-id="{{UserAuth::getLoginId()}}">Connections @if($user->id == UserAuth::getLoginId())({{$profile_connected ?? 0 }}) @endif</a>
              @else
              <button type="button" class="btn create-post-button" id="connect" dataProfile-id="{{$user->id}}" dataLogin-id="{{UserAuth::getLoginId()}}">Connect</button>
              @endif

              @foreach($get_connected_user as $connectedUser)
              @if($connectedUser->following_id == UserAuth::getLoginId())
              <button type="button" class="btn create-post-button" dataProfile-id="{{$user->id}}" dataLogin-id="{{UserAuth::getLoginId()}}">Connected</button>

              <button type="button" class="btn create-post-button" id="disconnect" dataProfile-id="{{$user->id}}" dataLogin-id="{{UserAuth::getLoginId()}}">Disconnect</button>

              <script type="text/javascript">
                jQuery(document).ready(function() {
                  $('#connect').hide();
                });
              </script>
              @endif
              @endforeach
            </div>
            <div class="chat-btn-area">
              <a target="blank" href="{{url('/chatify')}}/{{$user->id}}" class="btn create-post-button ms-1">Chat</a>
            </div>
            <hr class="mt-4">
            <ul class="list-unstyled d-inline-flex profile-social">
              @if(isset($user->business_website))
              <li class="">
                <a href="{{$user->business_website}}">
                  <i class="fas fa-globe fa-lg text-warning"></i>
                </a>
                <!-- <p class="mb-0">{{$user->business_website}}</p> -->
              </li>
              @endif
              @if(isset($user->twitter))
              <li class="">
                <a href="https://twitter.com/{{$user->twitter}}">
                  <i class="fab fa-twitter fa-lg" style="color: #55acee;"></i>
                </a>
                <!-- <p class="mb-0">{{$user->twitter}}</p> -->
              </li>
              @endif
              @if(isset($user->instagram))
              <li class="">
                <a href="https://www.instagram.com/{{$user->instagram}}">
                  <i class="fab fa-instagram fa-lg" style="color: #ac2bac;"></i>
                </a>
                <!-- <p class="mb-0">{{$user->instagram}}</p> -->
              </li>
              @endif
              @if(isset($user->facebook))
              <li class="">
                <a href="https://www.facebook.com/{{$user->facebook}}">
                  <i class="fab fa-facebook-f fa-lg" style="color: #3b5998;"></i>
                </a>
                <!-- <p class="mb-0">{{$user->facebook}}</p> -->
              </li>
              @endif
            </ul>
          </div>
        </div>
        @if($resume_setting = Setting::get_setting("resume_setting") == "show")
        <!-- @if(!empty($resume->id)) -->
        <div class="card mb-4 p-1">
          <div class="card-body text-center cx">
            <h5 class="fw-bold">Talent Resume</h5>
            <a href="{{route('resume.single-post',$resume->id)}}">
              <img src="{{asset('new_assets/assets/images/download.png')}}" alt="download.png">
            </a>
            <br>
            <a class="btn create-post-button mt-2" href="{{route('resume.single-post',$resume->id)}}">View Resume</a>
          </div>
        </div>
        <!-- @endif -->
        @endif




      </div>
      <div class="col-lg-8">
        @if(Setting::get_setting("account") == "Public")
        <div class="card mb-4 w-100 p-3">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0 text-black">Full Name</p>
              </div>
              <div class="col-sm-9">
                <p class="text-black mb-0">{{$user->first_name}}</p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0 text-black">Email</p>
              </div>
              <div class="col-sm-9">
                <p class="text-black mb-0">{{$user->email}}</p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0 text-black">Phone</p>
              </div>
              <div class="col-sm-9">
                <p class="text-black mb-0">{{$user->phonenumber}}</p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0 text-black">Address</p>
              </div>
              <div class="col-sm-9">
                <p class="text-black mb-0">{{$user->address}}
                </p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0 text-black">Bio</p>
              </div>
              <div class="col-sm-9 dev">
                <p class="text-black mb-0">{{$user->bio}}</p>
              </div>
            </div>
            <hr>
          </div>
        </div>
        @endif
        <div class="row">

          <div class="col-md-4 mb-4">
            <div class="card mb-4 mb-md-0 p-2">
              <a href="{{route('profile.job',$user->id)}}">
                <div class="card-body">
                  <p class="mb-4"><span class="text-black font-italic me-1">Jobs</span>
                    <hr> {{$jobCount}}
                  </p>
                </div>
              </a>
            </div>
          </div>

          <div class="col-md-4 mb-4">
            <div class="card mb-4 mb-md-0 p-2">
              <a href="{{route('profile.realestate',$user->id)}}">
                <div class="card-body">
                  <p class="mb-4"><span class="text-black font-italic me-1">Real Estate</span>
                    <hr> {{$realestateCount}}
                  </p>
                </div>
              </a>
            </div>
          </div>
          <div class="col-md-4 mb-4">
            <div class="card mb-4 mb-md-0 p-2">
              <a href="{{route('profile.community',$user->id)}}">
                <div class="card-body">
                  <p class="mb-4"><span class="text-black font-italic me-1">Welcome to our community</span>
                    <hr> {{$realestateCount}}
                  </p>
                </div>
              </a>
            </div>
          </div>
          <div class="col-md-4 mb-4">
            <div class="card mb-4 mb-md-0 p-2">
              <a href="{{route('profile.shopping',$user->id)}}">
                <div class="card-body">
                  <p class="mb-4"><span class="text-black font-italic me-1">Shopping</span>
                    <hr>{{$shoppingCount}}
                  </p>
                </div>
              </a>
            </div>
          </div>
          <div class="col-md-4 mb-4">
            <div class="card mb-4 mb-md-0 p-2">
              <a href="{{route('profile.services',$user->id)}}">
                <div class="card-body">
                  <p class="mb-4"><span class="text-black font-italic me-1">Services</span>
                    <hr>{{$servicesCount}}
                  </p>
                </div>
              </a>
            </div>
          </div>
          <div class="col-md-4 mb-4">
            <div class="card mb-4 mb-md-0 p-2">
              <a href="{{route('profile.services',$user->id)}}">
                <div class="card-body">
                  <p class="mb-4"><span class="text-black font-italic me-1">Blogs</span>
                    <hr>{{$Blogs}}
                  </p>
                </div>
              </a>
            </div>
          </div>

          <div class="col-md-4 mb-4">
            <div class="card mb-4 mb-md-0 p-2">
              <a href="{{route('profile.services',$user->id)}}">
                <div class="card-body">
                  <p class="mb-4"><span class="text-black font-italic me-1">Entertainment Industry</span>
                    <hr>{{$Entertainment_count}}
                  </p>
                </div>
              </a>
            </div>
          </div>

          <div class="col-md-4 mb-4">
            <div class="card mb-4 mb-md-0 p-2">
              <a href="{{route('profile.services',$user->id)}}">
                <div class="card-body">
                  <p class="mb-4"><span class="text-black font-italic me-1">Videos</span>
                    <hr>{{$video}}
                  </p>
                </div>
              </a>
            </div>
          </div>
        </div>
        <div class="col-md-12 mb-4 row">
          <div class="col-md-8">
            <input type="text" class="form-control" value="{{url('/user')}}/{{$user->id}}" id="linkInput" readonly>
          </div>
          <div class="col-md-4 ">
            @if(UserAuth::isLogin())
            <a href="{{url('/chatify')}}" class="btn create-post-button ms-1" id="copyButton">Share</a>
            @else
            <a href="{{route('auth.signupuser')}}" class="btn create-post-button ms-1" id="copyButton">Share</a>
            @endif
          </div>
        </div>

      </div>
    </div>
  </div>
</section>

<section class="mt-5 mb-5 ">
  <!-- <div class="container" id="latest-post-section"> -->
  <div class="container">
    <div class="row mt-4">
      <h2 class="text-center explore-heading ">Blogs</h2>
      @if(empty($pin_blog))
      <p class="card-text">Data not available.</p>
      @endif
      @foreach($pin_blog as $post)
      <?php

      $img  = explode(',', $post->image);
      ?>

      <div class="col-lg-4 col-md-4 col-12 blog-box">
        <a href="{{route('blogPostSingle',$post->id)}}">
          <div class="card">
            @if(isset($post->image))
            <img class="card-img-top" src="{{asset('images_blog_img')}}/{{$img[0]}}" alt="img...">
            @else
            <img class="card-img-top" src="{{asset('images_blog_img/1688636936.jpg')}}" alt="img...">
            @endif
            <div class="card-body">
              <h5 class="card-title">{{$post->title}}</h5>
              <p class="card-title">
                <?php
                $givenTime = strtotime($post->created_at);
                $currentTimestamp = time();
                $timeDifference = $currentTimestamp - $givenTime;

                $days = floor($timeDifference / (60 * 60 * 24));
                $hours = floor(($timeDifference % (60 * 60 * 24)) / (60 * 60));
                $minutes = floor(($timeDifference % (60 * 60)) / 60);
                $seconds = $timeDifference % 60;

                $timeAgo = "";
                if ($days > 0) {
                  $timeAgo .= $days . " days ";
                }
                if ($hours > 0) {
                  $timeAgo .= $hours . " hr ";
                }
                if ($minutes > 0) {
                  $timeAgo .= $minutes . " min ";
                }
                $timeAgo .= $seconds . " sec ago";

                echo $timeAgo;
                ?>
              </p>
              <!-- <p class="card-text content-box">{!! $post->content !!}</p> -->
              <a href="{{route('blogPostSingle',$post->id)}}" class="btn blog-read-button">Read More</a>
            </div>
          </div>
        </a>
      </div>
      @endforeach
    </div>
  </div>
</section>

<script type="text/javascript">
  // jQuery(document).ready(function() {
  //                     $('#connect').show();
  //                  });
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

  ////////////////////////Profile Pic Zoom Effect////////////////////////////////////

  $(function() {
    $(".popup img").click(function() {
      let $src = $(this).attr("src");
      $(".show1").fadeIn(10);
      $(".img-show img").attr("src", $src);
    });

    $("span.close1").click(function() {
      $(".show1").fadeOut(10);
      $('.img-show img').css({
        'width': '100%',
        'height': '100%'
      });
    });

    // let ovrflow_width
    $(".img-show img").draggable({

      scroll: true,
      stop: function() {},
      drag: function(e, ui) {

        let popup_img_width = $('.img-show img').width();
        let popup_width = $('.img-show').width();
        let new_img_width = popup_width - popup_img_width;

        let popup_img_height = $('.img-show img').height();
        let popup_height = $('.img-show').height();
        let new_img_height = popup_height - popup_img_height;

        if (ui.position.left > 0) {
          ui.position.left = 0;
        }
        if (ui.position.left < new_img_width) {
          ui.position.left = new_img_width;
        }

        if (ui.position.top > 0) {
          ui.position.top = 0;
        }
        if (ui.position.top < new_img_height) {
          ui.position.top = new_img_height;
        }
      }
    });

  });

  ////////////////////////Profile Pic Zoom Effect////////////////////////////////////

  // Function to copy the link when the button is clicked
  function copyLinkToClipboard() {
    const linkInput = document.getElementById('linkInput');
    linkInput.select();
    document.execCommand('copy');
    // alert('Link copied to clipboard: ' + linkInput.value);
  }

  // Attach the copyLinkToClipboard function to the button's click event
  const copyButton = document.getElementById('copyButton');
  copyButton.addEventListener('click', copyLinkToClipboard);
</script>

@endsection