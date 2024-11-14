@php
    use Illuminate\Support\Facades\DB;
    use App\Models\Admin\HomeSettings;
    use App\Models\UserAuth;
    use App\Models\Connected_business;
    use App\Models\Admin\Users;
    use App\Models\Admin\Notification;
    use App\Models\Admin\Follow;

    $userRole = Users::where('id',UserAuth::getLoginId())->first();
    $user_id = UserAuth::getLoginId();

    $loginUser = UserAuth::getLoginUser();
    $notification = new Notification();
    $notifications = $notification->getNotification(10,UserAuth::getLoginId());

    $notifications_admin_side = $notification->get_admin_notification_for_user(UserAuth::getLoginId());
    $countNotice = $notification->getUserCount(UserAuth::getLoginId());
    $unseenCounter = DB::table('ch_messages')
        ->where('to_id', UserAuth::getLoginId())
        ->where('seen', 0)
        ->count();

    $mergedNotifications = $notifications->merge($notifications_admin_side);

    $sortedNotifications = $mergedNotifications->sortBy('created');

    $get_connected_user = Follow::where('follower_id', UserAuth::getLoginId())->where('deleted_at',null)->get(); 

    


 
@endphp
<style>
    .dropdown-list.dropdown-menu.dropdown-menu-right.shadow.animated--grow-in.show {
        height: 500px;
        overflow-y: auto;
    }
    .search_listing {
        top: 28%;
    }
    .search_listing input[type=search] {
        transition: all 0.2s ease-in-out;
        background: rgba(255, 255, 255, 1);
        border: 0;
        color: #000;
        padding: 0rem 0;
        width: 100%;
        height: 30px;
        border-radius: 50px;
        padding-right: 6px;
        padding-left: 10px;
        font-size: 13px;
        font-weight: normal;
    }
    #search-results {
        margin-left: 100px;
    }
    #search-results-dropdown {
        width: 300px;
        overflow-y: scroll;
        height: 400px;
    }
    #search-results-dropdown a {
        background: #dc7228;
        border-radius: 5px;
    }
    /*.dropdown-item p {*/
    /*    display: -webkit-inline-box;*/
    /*    -webkit-line-clamp: 1;*/
    /*    -webkit-box-orient: vertical;*/
    /*    overflow: hidden;*/
    /*    clear: both;*/
    /*}*/
    input[type="search"]::-webkit-search-decoration,
    input[type="search"]::-webkit-search-cancel-button,
    input[type="search"]::-webkit-search-results-button,
    input[type="search"]::-webkit-search-results-decoration { display: none; }

    
    @media screen and (min-device-width: 360px) and (max-device-width: 445px) { 
        .search_listing {
            margin-left: 6px;
        }
        #sidebarToggleTop {
            height: auto;
        }

    }

    /*@media screen and (min-width: 575px) {*/
    /*    .approve_request{margin-left: 120px !important;}*/
    /*}*/
    .hide-notification, .block-notification {
        background: none;
    	color: inherit;
    	border: none;
    	padding: 0;
    	font: inherit;
    	cursor: pointer;
    	outline: inherit;
    }
    .action-btns {
        border-bottom: 1px solid #e3e6f0;
    }
</style>
<nav class="navbar navbar-expand navbar-light bg-yellow topbar mb-4 static-top shadow">
    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-lg-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Search -->

    <!-- <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
    </ul> -->

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

    <li class="nav-item">
        <div class="search_listing d-flex flex-column position-relative">
            <input type="search" name="search_listing" id="search-input" class="form-control dropdown-toggle" placeholder="Search" data-toggle="dropdown">
            <ul class="dropdown-menu" id="search-results-dropdown">
                <li><span id="search-results">No results found.</span></li>
            </ul>
        </div>
    </li>

<script>
jQuery(document).ready(function() {
    var typingTimer;
    var doneTypingInterval = 1000; // Adjust this interval as needed (in milliseconds)

    $("#search-input").on("click keyup", function() {
        clearTimeout(typingTimer);
        var user_name = $(this).val();

        if (user_name.length >= 3) {
            typingTimer = setTimeout(function() {
                makeAjaxCall(user_name);
            }, doneTypingInterval);
        }
    });

    function makeAjaxCall(user_name) {
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        $.ajax({
            url: '/search-listing',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {
                user_name: user_name
            },
            success: function(response) {
                $('#search-results-dropdown').empty().hide();

                if (response.suggestions.length > 0) {
                    var resultsHtml = response.suggestions;
                    $('#search-results-dropdown').html(resultsHtml).show();
                } else {
                    $('#search-results-dropdown').html('<li><span class="text-center">No results found.</span></li>').show();
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
                $('#search-results-dropdown').hide();
            }
        });
    }

    $(document).on('click', function(event) {
        if (!$(event.target).closest('.search_listing').length) {
            $('#search-results-dropdown').hide();
        }
    });
});
</script>
            @php
                $hasSpecialBlogPostNotifications = $sortedNotifications->contains(function($notice) {
                    return $notice->type == 'Blog_post';
                });
            @endphp

            <li class="nav-item dropdown no-arrow mx-1">
                <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="far fa-bell fa-fw icon-bg"></i>
                    @if($hasSpecialBlogPostNotifications)
                        <span class="badge badge-danger badge-counter">0</span>
                    @elseif($countNotice > 0)
                        <span class="badge badge-danger badge-counter">{{ ($countNotice > 9) ? '9+' : $countNotice }}</span>
                    @endif
                </a>

            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                    {{ 'Notifications' }}
                </h6>

                @foreach($sortedNotifications as $notice)
                    @php
                        $userSlug = UserAuth::getUserSlug($notice->from_id);
                        
                        $givenTime = strtotime($notice->created);
                        $currentTimestamp = time();
                        $timeDifference = $currentTimestamp - $givenTime;
                
                        $days = floor($timeDifference / (60 * 60 * 24));
                        $hours = floor(($timeDifference % (60 * 60 * 24)) / (60 * 60));
                        $minutes = floor(($timeDifference % (60 * 60)) / 60);
                        $seconds = $timeDifference % 60;
                
                        $timeAgo = '';
                        if ($days > 0) {
                            $timeAgo .= $days . ($days == 1 ? ' day ' : ' days ');
                        }
                        if ($hours > 0) {
                            $timeAgo .= $hours . ($hours == 1 ? ' hr ' : ' hrs ');
                        }
                        if ($minutes > 0) {
                            $timeAgo .= $minutes . ($minutes == 1 ? ' min ' : ' mins ');
                        }
                        $timeAgo .= $seconds . ' sec ago';
                    @endphp

                    @if($notice->type == 'user')
                        <a class="list-group-item list-group-item-action" href="{{route('user.users')}}" data-id="{{ $notice->id }}">
                    @elseif($notice->type == 'subscription')
                        <a class="list-group-notification-item dropdown-item d-flex align-items-center" href="{{ route('pricing') }}" data-id="{{ $notice->id }}">
                    @elseif(in_array($notice->type, ['follow', 'follow-approved']))
                        <a class="list-group-notification-item dropdown-item d-flex align-items-center" href="{{ route('UserProfileFrontend', $userSlug->slug) }}" data-id="{{ $notice->id }}">
                    @elseif($notice->type == 'follow_notification')
						<div class="list-group-notification-item dropdown-item d-flex align-items-center" data-id="{{ $notice->id }}">
                    @elseif($notice->type == 'ticket')
                        <a class="list-group-notification-item dropdown-item d-flex align-items-center" href="{{ route('support') }}" data-id="{{ $notice->id }}">
                    @elseif($notice->type == 'video')
                        <a class="list-group-notification-item dropdown-item d-flex align-items-center" href="{{ route('listing.video') }}" data-id="{{ $notice->id }}">
                    @elseif($notice->type == 'video_front')
                        <a class="list-group-notification-item dropdown-item d-flex align-items-center" href="{{ route('single.video', $notice->rel_id) }}" data-id="{{ $notice->id }}">
                    @elseif($notice->type == 'Entertainment_front')
                        <a class="list-group-notification-item dropdown-item d-flex align-items-center" href="{{ route('Entertainment.single.listing', $notice->rel_id) }}" data-id="{{ $notice->id }}">
                    @elseif($notice->type == 'Blogpost_front')
                        <a class="list-group-notification-item dropdown-item d-flex align-items-center" href="{{ $notice->url }}" data-id="{{ $notice->id }}">
                    @elseif($notice->type == 'invite')
                        <a class="list-group-notification-item dropdown-item d-flex align-items-center" href="{{ $notice->url }}" data-id="{{ $notice->id }}">
                    @elseif($notice->type == 'payment')
                        <a class="list-group-notification-item dropdown-item d-flex align-items-center" href="javascript:void(0);" data-id="{{ $notice->id }}">

                    
                    @elseif($notice->type == 'post_front')
                        @php
                            $route = '#';
                            switch ($notice->cate_id) {
                                case 1:
                                    $route = route('business_page.front.single.listing', $notice->rel_id);
                                    break;
                                case 2:
                                    $route = route('jobpost', $notice->rel_id);
                                    break;
                                case 4:
                                    $route = route('real_esate_post', $notice->rel_id);
                                    break;
                                case 5:
                                    $route = route('community_single_post', $notice->rel_id);
                                    break;
                                case 6:
                                    $route = route('shopping_post_single', $notice->rel_id);
                                    break;
                                case 7:
                                    $route = route('single.fundraisers', $notice->rel_id);
                                    break;
                                case 705:
                                    $route = route('service_single', $notice->rel_id);
                                    break;
                                case 728:
                                    $route = route('blogPostSingle', $notice->rel_id);
                                    break;
                                case 741:
                                    $route = route('Entertainment.single.listing', $notice->rel_id);
                                    break;
                            }
                        @endphp
                        <a class="list-group-notification-item dropdown-item d-flex align-items-center" href="{{ $route }}" data-id="{{ $notice->id }}">
                        @else
                            <a class="list-group-notification-item dropdown-item d-flex align-items-center" href="{{ $notice->url }}" data-id="{{ $notice->id }}">
                        @endif
                
                        @if($notice->type == 'follow_notification')
                            <div class="mr-3">
                                <a href="{{ route('UserProfileFrontend', $userSlug->slug) }}" data-id="{{ $notice->id }}">
                                <img 
                                    alt="Profile image" 
                                    src="{{ asset('assets/images/profile/' . ($notice->image ?? 'undraw_profile.jpg')) }}" 
                                    class="avatar rounded-circle">
                                </a>
                            </div>
                        @elseif($notice->type == "post")
                            <div class="mr-3">
                                <img 
                                    alt="Profile image" 
                                    src="{{ asset('assets/images/profile/undraw_profile.jpg')}}" 
                                    class="avatar rounded-circle">
                            </div>
                        @else
                            <div class="mr-3">
                                <img 
                                    alt="Profile image" 
                                    src="{{ asset('assets/images/profile/' . ($notice->image ?? 'undraw_profile.jpg')) }}" 
                                    class="avatar rounded-circle">
                            </div>
                        @endif

                        @if ($notice->type == 'follow_notification')
                            @foreach($get_connected_user as $connectedUser)              
                                @if($connectedUser->follower_id == UserAuth::getLoginId() && $connectedUser->following_id == $notice->from_id )
                                    @if($connectedUser->status==1)
                                        <p class="text-sm mb-0 font-weight-bold request_fol">You are connected with {{$notice->first_name}}.</p>
                                    @else
                                        <p class="text-sm mb-0 request_fol_btn">{{$notice->message}}<span style="font-size: 9px;margin-left: 6px;" data-status="1" Cuser-id="{{UserAuth::getLoginId()}}" data-id="{{$notice->from_id}}" class="approve_request btn btn-warning position-absolute">Accept request</span></p>
                                    @endif
                                @endif
                            @endforeach

                        @elseif($notice->type == 'invite')
                        <?php
                            $invitation = Connected_business::get_connections_data(UserAuth::getLoginId() , $notice->rel_id);
                            // dd($invitation);
                        ?>
                        
                        <p class="text-sm mb-0 request_fol_btn">{{$notice->message}}
                        @if($invitation->status=='1') 
                        <span style="font-size: 9px;margin-left: 6px;" class="btn btn-warning position-absolute">Invitation accepted</span>
                        @else
                        <span style="font-size: 9px;margin-left: 6px;" data-status="1" Cuser-id="{{UserAuth::getLoginId()}}" data-id="{{$notice->rel_id}}" class="accept_invitation btn btn-warning position-absolute">Accept invitation</span>
                        </p>
                        @endif
                        @else
                            <div>
                                <span class="font-weight-bold">{{ $notice->message }}</span>
                            </div>
                        @endif
					@if($notice->type == 'follow_notification')
                        </div>
                    @else
                        </a>
                    @endif
                    @if($notice->from_id != 19)
                    <div class="action-btns">
                        <div class="row py-1">
                            <div class="col d-flex justify-content-center">
                                <button class="btn btn-link text-decoration-none hide-notification" 
                                        data-id="{{ $notice->id }}" 
                                        data-toggle="tooltip" 
                                        data-placement="left" 
                                        title="Hide this notification">
                                    <i class="fa fa-eye-slash" aria-hidden="true"></i> Hide
                                </button>
                            </div>
                            
                            <span class="text-muted mx-2">|</span>
                            
                            <div class="col d-flex justify-content-center">
                                <button class="btn btn-link text-decoration-none block-notification" 
                                        data-id="{{ $notice->from_id }}" 
                                        data-toggle="tooltip" 
                                        data-placement="left" 
                                        title="Turn off all from {{ $notice->first_name }}">
                                    <i class="fa fa-bell-slash" aria-hidden="true"></i> Turn off
                                </button>
                            </div>
                        </div>
                    </div>
                    @endif        
                @endforeach
            
                <a href="{{route('user.notification')}}" class="dropdown-item text-center small text-gray-500" href="#">Show All</a>
            </div>
        </li>

        <li>
        <a class="mt-2 nav-link position-relative" href="{{url('/chatify')}}">
                <i class="far fa-comment fa-fw icon-bg"></i>
                <span class="badge badge-danger badge-counter position-absolute" style="top: 4px; right: 3px; border-radius: 50%;" >{!! $unseenCounter > 0 ? "<b>".$unseenCounter."</b>" : '' !!}</span>
            </a>
        </li>

        <!-- Nav Item - Messages -->

        <div class="topbar-divider d-none d-sm-block"></div>
        <?php $user = UserAuth::getLoginUser(); ?>
        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-white small">{{$user->first_name}}</span>
                <img class="img-profile rounded-circle" src="{{$user->image!= ''? asset('assets/images/profile/'.$user->image): asset('user_dashboard/img/undraw_profile.svg')}}" width="61px" alt="">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="{{route('user_profile', General::encrypt($user->id))}}">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>

                <a target="_blank" class="dropdown-item" href="{{route('UserProfileFrontend', $user->slug)}}">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    View as member
                </a>
                <a target="blank" class="dropdown-item" href="{{url('/')}}">
                    <i class="fas fa-link fa-sm fa-fw mr-2 text-gray-400"></i>
                    Visit Website
                </a>
                {{-- <a class="dropdown-item" href="#">
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                    Settings
                </a> --}}
                <a class="dropdown-item" href="{{route('privacy.activity')}}">
                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                    Privacy/Activity
                </a>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#exampleModal">
                    <i class="far fa-arrow-alt-circle-right"></i>
                    Switch Account
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>

    </ul>

<?php 

$cookieValue = Cookie::get('loginUser');
 
$uId = explode(',', $cookieValue);
unset($uId['0']);
  // dd($uId);
$usersData = []; // Initialize an empty array to store the user data

foreach ($uId as $new_Uid) {
    $user = Users::select('username', 'email', 'id','image')
                ->where('id', $new_Uid)
                ->first(); // Use first() instead of get() to retrieve a single user
            
    if ($user) {
        $usersData[] = $user; // Add the user data to the array
    }
}
// echo "<pre>";
// print_r($usersData);
?>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Switch Account</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            @if($usersData != "")
               @foreach($usersData as $acc)

                {{-- <ul>
                    <li  class="switchAccount" dataid="{{$acc->id}}" dataEmail="{{$acc->email}}" style="display: flex;">
                        <div class="img-icon">
                        <img class="img-fluid rounded-circle" alt="image" height="40" width="40" src="{{$acc->image!= ''? asset('assets/images/profile/'.$acc->image): asset('user_dashboard/img/undraw_profile.svg')}}">
                        </div>
                        <div class="comments-area" style="margin-left: 12px; margin-top: 12px;">
                            <a href="javascript:;">{{$acc->username}}</a>        
                        </div>
                                
                    </li>
                        <a dataid="{{$acc->id}}" dataEmail="{{$acc->email}}" class="btn btn-danger removeAccount" style="position:relative;left: 228px; z-index: 1111;" href="javascript:;">Remove</a> 
                    <hr>
                </ul> --}}
               
               <ul class="p-0 mx-2">
                <li  class="d-flex justify-content-between align-items-center flex-wrap">
                  <div class="d-flex switchAccount" dataid="{{$acc->id}}"  dataEmail="{{$acc->email}}">
                    <div class="img-icon">
                        <img class="img-fluid rounded-circle" alt="image" height="40" width="40" src="{{$acc->image!= ''? asset('assets/images/profile/'.$acc->image): asset('user_dashboard/img/undraw_profile.svg')}}">
                      </div>
                      <div class="comments-area" style="margin-left: 12px; margin-top: 12px;">
                        <a href="javascript:;">{{$acc->username}}</a>        
                      </div>
                  </div>

                  <a dataid="{{$acc->id}}" dataEmail="{{$acc->email}}" class="btn btn-danger removeAccount" style="position:relative; z-index: 1111;" href="javascript:;">Remove</a> 
                             
                </li>
                <hr>
               </ul>
               
               @endforeach
               <hr>
               <li class="mt-4" style="display: flex;">
                    <a href="{{route('auth.logout')}}">
                        <i class="fas fa-plus"></i><span class="ADDTEXT"> Add another account</span>
                    </a>
                </li>
            @endif
      </div>
      <div class="modal-footer">
        {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button> --}}
      </div>
    </div>
  </div>
</div>



<?php 

$cookieValue = Cookie::get('loginUser');
 
$uId = explode(',', $cookieValue);
unset($uId['0']);
  // dd($uId);
$usersData = []; // Initialize an empty array to store the user data

foreach ($uId as $new_Uid) {
    $user = Users::select('first_name', 'email', 'id','image')
                ->where('id', $new_Uid)
                ->first(); // Use first() instead of get() to retrieve a single user
            
    if ($user) {
        $usersData[] = $user; // Add the user data to the array
    }
}
// echo "<pre>";
// print_r($usersData);
?>



</nav>

<script>
    var channel = pusher.subscribe('notifications');
    // Listen for the 'App\Events\NewNotification' event
    channel.bind('App\\Events\\NewNotification', function(data) {
        // Handle the received notification data (e.g., display a real-time notification)
        console.log(data.notification);
    });
</script>
<script>
    $(document).ready(function() {
        $(".approve_request").on("click", function() {
            var status = $(this).attr('data-status');
            var id = $(this).attr('data-id');
            var Cid = $(this).attr('Cuser-id');
            var csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;
            // alert(csrfToken);
            $.ajax({
                type: 'POST',
                url: baseurl +'/request/accept',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    id: id,
                    status: status,
                    Cid: Cid,
                },
        		success: function(data) {
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
        		}
            });
        });
    });


    $(document).ready(function() {
        $(".accept_invitation").on("click", function() {
            var status = $(this).attr('data-status');
            var business_id = $(this).attr('data-id');
            var user_id = $(this).attr('Cuser-id');
            var csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;
            // alert(csrfToken);
            $.ajax({
                type: 'POST',
                url: baseurl +'/business-invite-accept',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    business_id: business_id,
                    status: status,
                    user_id: user_id,
                },
        		success: function(data) {
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
        		}
            });
        });
    });

$(document).ready(function() {
    $(".switchAccount").click(function(){
    var id = $(this).attr('dataid');
    var email = $(this).attr('dataEmail');
    console.log(email);
    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
         $.ajax({
          type: 'POST',
          headers: {
          'X-CSRF-TOKEN': csrfToken
        },
        url: baseurl+'/switch-account',
        data: {
            id: id,
            email:email
            
        },
          
          success: function(response) {
            console.log(response);
            window.location.href = window.appUrl + "user-index";
            // window.location.href = "https://www.finderspage.com/user-index";
          },
          error: function() {
              // Handle the error if the AJAX request fails
          }
      });
    });



    $(".removeAccount").click(function(){
        var id = $(this).attr('dataid');
        var email = $(this).attr('dataEmail');
        
        // Display SweetAlert confirmation dialog
        Swal.fire({
            title: 'Are you sure?',
            text: "You are about to remove the account associated with " + email + ". This action cannot be undone.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, remove it!'
        }).then((result) => {
            if (result.isConfirmed) {
                var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                $.ajax({
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    url: baseurl+'/remove/users',
                    data: {
                        id: id,  
                    },
                    success: function(response) {
                        console.log(response.success);
                        Swal.fire(
                            'Deleted!',
                            'The account has been removed.',
                            'success'
                        ).then((result) => {
                            // Redirect after the user closes the alert
                            if (result.isConfirmed || result.dismiss === Swal.DismissReason.backdrop || result.dismiss === Swal.DismissReason.esc || result.dismiss === Swal.DismissReason.close) {
                                window.location.href = window.appUrl + "user-index";
                            }
                        });
                    },
                    error: function() {
                        Swal.fire(
                            'Error!',
                            'An error occurred while removing the account.',
                            'error'
                        );
                    }
                });
            }
        });
    });
});


$(document).ready(function() {

    // Hide Notification
    $(document).on('click', '.hide-notification', function() {
        var noticeId = $(this).data('id');

        Swal.fire({
            title: 'Hide',
            text: 'Are you sure you want to hide this notification?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#fcd152',
            cancelButtonColor: '#1a202e',
            confirmButtonText: 'Yes, Hide!'
        }).then((result) => {
            if (result.isConfirmed) {

                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    type: 'POST',
                    url: '/hide-notification/' + noticeId,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function (response) {
                        console.log(response);

                        toastr.options = {
                            timeOut: 3000,
                            progressBar: true,
                            closeButton: true,
                            positionClass: 'toast-top-right',
                            toastClass: 'toast toast-success'
                        };

                        if (response.success) {
                            toastr.success('Notification hidden successfully.', 'Hide');
                            setTimeout(function() {
                                window.location.reload();
                            }, 3000);
                        } else {
                            toastr.error('Failed to hide notification.', 'Error');
                        }
                    },
                    error: function() {
                        Swal.fire({
                            title: 'Error',
                            text: 'Error hiding notification. Please try again.',
                            icon: 'error'
                        });
                    }
                });
            }
        });
    });

    // Block Notification
    $(document).on('click', '.block-notification', function() {
        var noticeId = $(this).data('id');

        Swal.fire({
            title: 'Block',
            text: 'Are you sure you want to block notifications from this user?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#1a202e',
            confirmButtonText: 'Yes, Block!'
        }).then((result) => {
            if (result.isConfirmed) {

                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    type: 'POST',
                    url: '/block-notification/' + noticeId,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function (response) {
                        console.log(response);

                        toastr.options = {
                            timeOut: 3000,
                            progressBar: true,
                            closeButton: true,
                            positionClass: 'toast-top-right',
                            toastClass: 'toast toast-danger'
                        };

                        if (response.success) {
                            toastr.success('Notifications blocked successfully.', 'Blocked');
                            setTimeout(function() {
                                window.location.reload();
                            }, 3000);
                        } else {
                            toastr.error('Failed to block notifications.', 'Error');
                        }
                    },
                    error: function() {
                        Swal.fire({
                            title: 'Error',
                            text: 'Error blocking notifications. Please try again.',
                            icon: 'error'
                        });
                    }
                });
            }
        });
    });
});

</script>