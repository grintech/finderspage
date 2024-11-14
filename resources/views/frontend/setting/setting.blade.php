<?php 
use App\Models\UserAuth; 
use App\Models\Setting; 

$userData = UserAuth::getLoginUser();

$setting_sharebtn = Setting::get_setting('share_btn',$userData->id);
$setting_comment_option = Setting::get_setting('comments_option',$userData->id);

$settings = [
    'messages_option' => Setting::get_setting('messages_option', $userData->id),
    'likes' => Setting::get_setting('likes', $userData->id),
    'emails_option' => Setting::get_setting('emails_option', $userData->id),
    'connect_posts' => Setting::get_setting('connect_posts', $userData->id),
    'push_notify' => Setting::get_setting('push_notify', $userData->id),
    'reviews' => Setting::get_setting('reviews', $userData->id),
    'new_connects' => Setting::get_setting('new_connects', $userData->id),
    'mentions' => Setting::get_setting('mentions', $userData->id),
    'profile_views' => Setting::get_setting('profile_views', $userData->id),
    'reposts' => Setting::get_setting('reposts', $userData->id),
    'video_posts' => Setting::get_setting('video_posts', $userData->id),
    'events' => Setting::get_setting('events', $userData->id),
    'fundraisers' => Setting::get_setting('fundraisers', $userData->id),
];
//  dd($setting_sharebtn);
?>
@extends('layouts.user_dashboard.userdashboardlayout')
@section('content')
<style type="text/css">
	.notification_section .row{
    align-items: center;
    justify-content: space-between;
}
.notification_section .col-lg-4{
  display: flex;
  align-items: center;
}
.notification_section .col-lg-4 .switch{
    margin-left: 0 !important;
    margin-bottom: 0 !important;
}
.notification_section .switch{margin-bottom: 0; margin-left: 0;}
.sw-box{height: 34px;}

@media only screen and (max-width:767px){
    .container {padding-bottom: 50px !important;}
}
</style>
<?php 
// echo"<pre>"; print_r($setting);die(); 
foreach ($setting as $sett => $value) {
	//  echo "Setting Name: " . $value['setting_name'] . "<br>";
    // echo "Setting Value: " . $value['setting_value'] . "<br>";
    // echo "<br>";

    // if($value['setting_name'] == 'zodiac_section'){
    // 		if($value['setting_value'] == 'show'){
    // 		echo "checked";
    // 		}
    // }
}
 ?>
        <span>
            @include('admin.partials.flash_messages')
         </span>
  <div class="container px-sm-5 px-4">
      <div class="row justify-content-between align-items-center bg-white border-radius mt-4 p-3">
      <div class=""> Do you want to hide or show these details?</div>
        <div class=" sett_ing">
          <span>Zodiac details </span>
            <label class="switch">
            <input type="checkbox" name="zodiac_sign" id="togBtn" 
            <?php
            foreach ($setting as $sett => $value) {
            if($value['setting_name'] == 'zodiac_section' || $value['setting_name']==""){
              if($value['setting_value'] == 'show' || $value['setting_value']==""){
              echo "checked";
              }
            } 
            }?>
            >
            <div class="slider round"><!--ADDED HTML -->
              <span class="on">Show</span>
              <span class="off">Hide</span><!--END-->
            </div>
          </label> 
          </div>
        
      </div>

      <div class="row justify-content-between align-items-center bg-white border-radius mt-4 p-3">
          <div class="col-md-9 p-0"> Account type 
          <p class="m-0" style="font-size: 13px;">
            When your account is public, your profile and posts can be seen by anyone on or off FindersPage, even if they don't have a FindersPage account. When your account is private, only the connections you approve can see what you share, including your photos, videos, hashtags, location, and your connections...</p>
          <!-- <p class="m-0" style="font-size: 13px;">When your account is private, only the connections you approve can see what you share, including your photos or videos on hashtag and location pages, and your connections. </p> -->
          </div>
          <div class="col-md-3 sett_ing">
            <!-- <span>Account type </span> -->
            <label class="switch">
            <input type="checkbox" id="togBtn1" name="account_type"
            <?php
            foreach ($setting as $sett => $value) {
            if($value['setting_name'] == 'account' || $value['setting_name']==""){
              if($value['setting_value'] == 'Public' || $value['setting_value']==""){
              echo "checked";
              }
            } 
            }?>


            >
            <div class="slider round">
              <span class="on">Public</span>
              <span class="off">Private</span>
            </div>
          </label>
          </div>
          </div>

          <div class="row justify-content-between align-items-center bg-white border-radius mt-4 p-3">
          <div class=""> Do you want to enable or disable tags?</div>
              <div class=" sett_ing">
              <span>Tags</span>
                  <label class="switch">
                    <input type="checkbox" data-userId="{{UserAuth::getLoginId()}}" name="tag_at" id="tagBtn" 
                    <?php
                      if($userData->tag_at == '1'){
                      echo "checked";
                      }
                  ?>
                    >
                    <div class="slider round">
                      <span class="on">enable</span>
                      <span class="off">disable</span>
                    </div>
                  </label> 
              </div>
          </div>

          <div class="row justify-content-between align-items-center bg-white border-radius mt-4 p-3">
          <div class=""> Do you want to hide views ?</div>
              <div class=" sett_ing">
                <span>Views</span>
                  <label class="switch">
                    <input type="checkbox" data-userId="{{UserAuth::getLoginId()}}" name="no_of_views" id="no_of_views" 
                    <?php
                      if($userData->tag_at == '1'){
                      echo "checked";
                      }
                  ?>
                    >
                    <div class="slider round">
                      <span class="on">show</span>
                      <span class="off">hide</span>
                    </div>
                  </label> 
              </div>
          </div>

      <div class="row justify-content-between align-items-center bg-white border-radius mt-4 p-3">
      <div class="">Do you want to permanently delete your account?</div>
          <div class=" sett_ing">
            <button  class="btn btn-warning" data-toggle="modal" data-target="#exampleModal_account_del">Delete account</button>
        </div>
      </div>


          @if(UserAuth::getLoginUser()->feature_end_date)
          @php
          $subscribedPlan = UserAuth::getLoginUser()->subscribedPlan;
      
          switch($subscribedPlan) {
              case 'three-month':
                  $subscribedPlan = "three months";
                  break;
              case 'six-month':
                  $subscribedPlan = "six months";
                  break;
              case 'year':
                  $subscribedPlan = "yearly";
                  break;
          }
          @endphp
          <div class="row justify-content-between align-items-center bg-white border-radius mt-4 p-3">
            <div class="mb-1 col-lg-12 p-0">Your current subscription plan is {{ $subscribedPlan }} and is set to expire on {{UserAuth::getLoginUser()->feature_end_date}}.<span class="float-right"> <a class="btn btn-warning" href="{{route('pricing')}}">View Plan</a> </span></div> 
            <div class=" sett_ing">
                <!-- <a class="btn btn-warning" href="{{route('pricing')}}">Change Plan</a> -->
            </div> 
          <!-- <div class="mb-4 col-lg-12"><ul><li>Your current subscription plan is  {{UserAuth::getLoginUser()->subscribedPlan}} and is set to expire on {{UserAuth::getLoginUser()->feature_end_date}} . <span class="float-right"> <a class="btn btn-warning" href="{{route('pricing')}}">Buy Plan</a> </span></li></ul></div> -->
          </div>
          @endif
          

          <div class="row justify-content-between align-items-center bg-white border-radius mt-4 p-3">
          <div class="">Enable or Disable Share button.</div>
              <div class=" sett_ing">
               
                  <label class="switch">
                    <input type="checkbox" data-userId="{{UserAuth::getLoginId()}}" name="share_btn" id="share_btn_check" @if($setting_sharebtn == '' || $setting_sharebtn =='show') checked @endif>
                    <div class="slider round">
                      <span class="on">Enable</span>
                      <span class="off">Disable</span>
                    </div>
                  </label> 
              </div>
          </div>



          <h4 class="mt-5">Notification Settings</h4>
          <div class="row notification_section">
            <div class="col-md-6">
              <div class="row bg-white border-radius mt-4 p-3 mx-1">
                <div class="">Messages</div>
                <div class="sw-box">
                <!-- <span>Views</span> -->
                  <label class="switch">
                    <input type="checkbox" data-userId="{{ $userData->id }}" name="messages_option" @if($settings['messages_option'] == '' || $settings['messages_option'] == '1') checked @endif>
                    <div class="slider round">
                      <span class="on">On</span>
                      <span class="off">Off</span>
                    </div>
                  </label> 
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="row bg-white border-radius mt-4 p-3 mx-1">
                <div class="">Emails</div>
                <div class="sw-box">
                  <label class="switch">
                    <input type="checkbox" data-userId="{{ $userData->id }}" name="emails_option" @if($settings['emails_option'] == '1') checked @endif>
                    <div class="slider round">
                      <span class="on">On</span>
                      <span class="off">Off</span>
                    </div>
                  </label> 
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="row bg-white border-radius mt-4 p-3 mx-1">
                <div class="">Posts from accounts you are connected to</div>
                <div class="sw-box">
                  <label class="switch">
                    <input type="checkbox" data-userId="{{ $userData->id }}" name="connect_posts" @if($settings['connect_posts'] == '1') checked @endif>
                    <div class="slider round">
                      <span class="on">On</span>
                      <span class="off">Off</span>
                    </div>
                  </label> 
                </div>
              </div>
            </div>
            <!-- <div class="col-md-6">
              <div class="row bg-white border-radius mt-4 p-3 mx-1">
                <div class="">Reposted by other's</div>
                <div class="sw-box">
                  <label class="switch">
                    <input type="checkbox"  name="repost_others" id="repost_others" >
                    <div class="slider round">
                      <span class="on">On</span>
                      <span class="off">Off</span>
                    </div>
                  </label> 
                </div>
              </div>
            </div> -->
            <div class="col-md-6">
              <div class="row bg-white border-radius mt-4 p-3 mx-1">
                <div class="">Push notifications</div>
                <div class="sw-box">
                  <label class="switch">
                    <input type="checkbox" data-userId="{{ $userData->id }}" name="push_notify" @if($settings['push_notify'] == '1') checked @endif>
                    <div class="slider round">
                      <span class="on">On</span>
                      <span class="off">Off</span>
                    </div>
                  </label> 
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="row bg-white border-radius mt-4 p-3 mx-1">
                <div class="">Likes</div>
                <div class="sw-box">
                  <label class="switch">
                    <input type="checkbox" data-userId="{{ $userData->id }}"  name="likes" id="likes" @if($settings['likes'] =='1') checked @endif>
                    <div class="slider round">
                      <span class="on">On</span>
                      <span class="off">Off</span>
                    </div>
                  </label> 
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="row bg-white border-radius mt-4 p-3 mx-1">
                <div class="">Comments</div>
                <div class="sw-box">
                  <label class="switch">
                    <input type="checkbox" data-userId="{{UserAuth::getLoginId()}}"  name="comments" id="comments" @if($setting_comment_option =='1') checked @endif>
                    <div class="slider round">
                      <span class="on">On</span>
                      <span class="off">Off</span>
                    </div>
                  </label> 
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="row bg-white border-radius mt-4 p-3 mx-1">
                <div class="">Reviews</div>
                <div class="sw-box">
                  <label class="switch">
                    <input type="checkbox" data-userId="{{ $userData->id }}" name="reviews" @if($settings['reviews'] == '1') checked @endif>
                    <div class="slider round">
                      <span class="on">On</span>
                      <span class="off">Off</span>
                    </div>
                  </label> 
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="row bg-white border-radius mt-4 p-3 mx-1">
                <div class="">New connections</div>
                <div class="sw-box">
                  <label class="switch">
                    <input type="checkbox" data-userId="{{ $userData->id }}" name="new_connects" @if($settings['new_connects'] == '1') checked @endif>
                    <div class="slider round">
                      <span class="on">On</span>
                      <span class="off">Off</span>
                    </div>
                  </label> 
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="row bg-white border-radius mt-4 p-3 mx-1">
                <div class="">Mentions and tags</div>
                <div class="sw-box">
                  <label class="switch">
                    <input type="checkbox" data-userId="{{ $userData->id }}" name="mentions" @if($settings['mentions'] == '1') checked @endif>
                    <div class="slider round">
                      <span class="on">On</span>
                      <span class="off">Off</span>
                    </div>
                  </label> 
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="row bg-white border-radius mt-4 p-3 mx-1">
                <div class="">Profile views</div>
                <div class="sw-box">
                  <label class="switch">
                    <input type="checkbox" data-userId="{{ $userData->id }}" name="profile_views" @if($settings['profile_views'] == '1') checked @endif>
                    <div class="slider round">
                      <span class="on">On</span>
                      <span class="off">Off</span>
                    </div>
                  </label> 
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="row bg-white border-radius mt-4 p-3 mx-1">
                <div class="">Reposts</div>
                <div class="sw-box">
                  <label class="switch">
                    <input type="checkbox" data-userId="{{ $userData->id }}" name="reposts" @if($settings['reposts'] == '1') checked @endif>
                    <div class="slider round">
                      <span class="on">On</span>
                      <span class="off">Off</span>
                    </div>
                  </label> 
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="row bg-white border-radius mt-4 p-3 mx-1">
                <div class="">Videos posted</div>
                <div class="sw-box">
                  <label class="switch">
                    <input type="checkbox" data-userId="{{ $userData->id }}" name="video_posts" @if($settings['video_posts'] == '1') checked @endif>
                    <div class="slider round">
                      <span class="on">On</span>
                      <span class="off">Off</span>
                    </div>
                  </label> 
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="row bg-white border-radius mt-4 p-3 mx-1">
                <div class="">Events</div>
                <div class="sw-box">
                  <label class="switch">
                    <input type="checkbox" data-userId="{{ $userData->id }}" name="events" @if($settings['events'] == '1') checked @endif>
                    <div class="slider round">
                      <span class="on">On</span>
                      <span class="off">Off</span>
                    </div>
                  </label> 
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="row bg-white border-radius mt-4 p-3 mx-1">
                <div class="">Fundraisers and crises</div>
                <div class="sw-box">
                  <label class="switch">
                    <input type="checkbox" data-userId="{{ $userData->id }}" name="fundraisers"  @if($settings['fundraisers'] == '1') checked @endif>
                    <div class="slider round">
                      <span class="on">On</span>
                      <span class="off">Off</span>
                    </div>
                  </label> 
                </div>
              </div>
            </div>
            
          </div>
          
    </div>

    <div class="modal fade" id="exampleModal_account_del" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-danger" id="exampleModalLabel">Delete Account</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <img width="100%" src="{{asset('images/new1.jpg')}}">
            <p class="text-center pt-3">
                Once you delete your account, there's a 30 day  grace period where you can opt to log in and reinstate your account.
            </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
        <button type="button" id="del_my_account" class="btn btn-warning" data-link="{{route('Delete_account',General::encrypt($userid))}}">Delete</button>
      </div>
    </div>
  </div>
</div>


 	<script type="text/javascript">
 		$(document).ready(function(){
    	$('#togBtn').on('change', function() {
         var zodiac_value = $('input[name="zodiac_sign"]').is(':checked');
        console.log(zodiac_value);
        if(zodiac_value === true){
               var zodiac_section = 'show';
            }else{
               var zodiac_section = 'hide';
            }
       console.log(zodiac_section+'zodiac_update');
       var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
       $.ajax({
            url: baseurl+"/zodiac_update",
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": csrfToken
            },
            data: {
               zodiac_section:zodiac_section,    
            },
            success:function(response) {
                console.log('success',response);
                toastr.success(response.message);
            },
            error: function(response) {
                console.log('error',response);
                toastr.success(response.error);
            }
        });


        });


      


       $('#togBtn1').on('change', function() {
         var account_type = $('input[name="account_type"]').is(':checked');
        if(account_type === true){
               var account = 'Public';
            }else{
               var account = 'Private';
            }
       console.log(account+'zodiac_update');
       var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
       $.ajax({
            url: baseurl+"/account/setting",
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": csrfToken
            },
            data: {
               account:account,    
            },
            success:function(response) {
                console.log('success',response);
                toastr.success(response.message);
            },
            error: function(response) {
                console.log('error',response);
                toastr.success(response.error);
            }
        });


        });







       $('#tagBtn').on('change', function() {
         var tag_type = $('input[name="tag_at"]').is(':checked');
         var id = $(this).attr('data-userId');
        if(tag_type === true){
               var tag = '1';
            }else{
               var tag = '0';
            }
       console.log(tag+'zodiac_update');
       var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
       $.ajax({
            url: baseurl+"/tag/update/"+id,
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": csrfToken
            },
            data: {
               tag:tag,    
               id:id,    
            },
            success:function(response) {
                console.log('success',response);
                toastr.success(response.message);
            },
            error: function(response) {
                console.log('error',response);
                toastr.success(response.error);
            }
        });


        });



    $('#no_of_views').on('change', function() {
         var no_of_views = $('input[name="no_of_views"]').is(':checked');
         var id = $(this).attr('data-userId');
        if(no_of_views === true){
               var views = '1';
            }else{
               var views = '0';
            }
       console.log(views);
       var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
       $.ajax({
            url: baseurl+"/views/update/"+id,
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": csrfToken
            },
            data: {
               views:views,    
               id:id,    
            },
            success:function(response) {
                console.log('success',response);
                toastr.success(response.message);
            },
            error: function(response) {
                console.log('error',response);
                toastr.success(response.error);
            }
        });


        });



        $('#comments').on('change', function() {
         var comments_option = $('input[name="comments"]').is(':checked');
         var id = $(this).attr('data-userId');
        if(comments_option === true){
               var comments_option = '1';
            }else{
               var comments_option = '0';
            }
       var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
       $.ajax({
            url: baseurl+"/coment/option",
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": csrfToken
            },
            data: {
            comments_option:comments_option,    
            id:id,    
            },
            success:function(response) {
                console.log('success',response);
                toastr.success(response.message);
            },
            error: function(response) {
                console.log('error',response);
                toastr.success(response.error);
            }
        });

        });



        $(document).ready(function() {
        $('input[type="checkbox"]').on('change', function() {
            var optionName = $(this).attr('name');
            var optionValue = $(this).is(':checked') ? '1' : '0';
            var id = $(this).attr('data-userId');
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            $.ajax({
                url: baseurl + "/setting/option",
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": csrfToken
                },
                data: {
                    option_name: optionName,
                    option_value: optionValue,
                    id: id,
                },
                success: function(response) {
                    console.log('success', response);
                    toastr.success(response.message);
                },
                error: function(response) {
                    console.log('error', response);
                    toastr.error(response.error);
                }
            });
        });
    });




    $('#share_btn_check').on('change', function() {
         var share_btn_value = $('input[name="share_btn"]').is(':checked');
        console.log(share_btn_value);
        if(share_btn_value === true){
               var share_btn_value = 'show';
            }else{
               var share_btn_value = 'hide';
            }
       var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
       $.ajax({
            url: baseurl+"/share_btn_setting",
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": csrfToken
            },
            data: {
              share_btn_value:share_btn_value,    
            },
            success:function(response) {
                console.log('success',response);
                toastr.success(response.message);
            },
            error: function(response) {
                console.log('error',response);
                toastr.success(response.error);
            }
        });


      });

});


 	$(document).on("click", "#del_my_account", function(e) {
        e.preventDefault();
        var link = $(this).attr("data-link");
         window.location.href = link;
    });
 	</script>
@endsection