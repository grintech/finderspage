@php 
	use App\Models\UserAuth;
	use App\Models\Admin\Follow;
	use App\Models\Setting;
    use App\Models\Connected_business;
@endphp
@extends('layouts.user_dashboard.userdashboardlayout')
@section('content')
<style type="text/css">
	span.approve.btn.btn-primary {
    margin-left: 100px;
}
.request_fol{
	display: flex;
    justify-content: space-between;
}
.clearNotification{
	float: right;
}

.dots-menu .dots-btn {
    border-top-right-radius: 5px !important;
    border-bottom-right-radius: 5px !important;
    background: #dc7228;
    color: #fff !important;
}

.action-dots {
    /*min-width: 100px;*/
    display: flex;
    justify-content: space-between;
    /*align-items: center;*/
    /*height: 42px;*/
    left: -240px;
    padding: 10px;
    flex-direction: column;
    min-width: 260px;
    gap:10px;
    box-shadow: 0 0 6px 0px rgba(0,0,0,0.1);
  border: 0;
}
.action-dots li .btn{color:#000!important;font-size:14px!important;}
.action-dots li .btn:hover, .action-dots li .btn:focus, .action-dots li .btn:active, .action-dots li .btn.active{color:#d96e22!important;}
.table-responsive1 .list-group-item a h5, .table-responsive1 .list-group-item a h4{font-size:18px;font-weight:600;}
</style>
<span class="Readallnotification">
<div class="header">
	<div class="container-fluid">
		<div class="header-body">
			<div class="row align-items-center py-4">
				<div class="col-lg-6 col-6">
					{{-- <h6 class="h2 d-inline-block mb-0">@if($sortedNotificationsAll->count() > 1)Notifications @else Notification @endif</h6> --}}
					<h6 class="h2 d-inline-block mb-0">Notifications</h6>
				</div>
				<div class="col-lg-6 col-6">
					<a class="btn btn-warning clearNotification" id="notification" href="{{route('notification.clear',UserAuth::getLoginId())}}">Clear </a>
				</div>
				<div class="col-lg-6 col-5 text-right">
					
				</div>
			</div>
		</div>
	</div>
</div>

<div class="d-flex justify-content-center mb-2">
    <a class="btn btn-warning d-inline-block mx-2 show_hidden" data-id="{{ UserAuth::getLoginId() }}" href="javascript:void(0);">Hidden</a>
    <a class="btn btn-success d-inline-block mx-2 notifications" href="javascript:void(0);">Notification</a>
    <a class="btn btn-danger d-inline-block mx-2 show_blocked" data-id="{{ UserAuth::getLoginId() }}" href="javascript:void(0);">Blocked</a>
</div>


<!-- Page content -->
<div class="container-fluid">
	<div class="row">
		<div class="col">
			<div class="card listing-block">
				<!--!! FLAST MESSAGES !!-->
				@include('admin.partials.flash_messages')
				<!-- Card header -->
				<div class="card-header border-0">
					<div class="heading">
						<h5 class="mb-0"></h5>
					</div>
				</div>
				<div class="table-responsive1">
					<!--!!!!! DO NOT REMOVE listing-table, mark_all  CLASSES. INCLUDE THIS IN ALL TABLES LISTING PAGES !!!!!-->
					<table class="table align-items-center table-flush listing-table">
						<thead class="thead-light">
							<tr>
								<div class="list-group list-group-flush" id="show_notifications">
                                @if ($sortedNotificationsAll->isNotEmpty())
									@foreach($sortedNotificationsAll as $notice)

										@php
											$userSlug = UserAuth::getUserSlug($notice->from_id);
											$now = new DateTime();
											$last_updated = new DateTime($notice->created);
											$diff = $now->diff($last_updated);
											$hoursDiff = $diff->h + ($diff->days * 24);
											$daysDiff = $diff->days;
											$min = $diff->i + ($hoursDiff * 60);
										
											$connectedUserStatus = null;
										@endphp

											@if($notice->type == 'follow_notification')
												@foreach($get_connected_user as $connectedUser)
													@if($connectedUser->follower_id == UserAuth::getLoginId() && $connectedUser->following_id == $notice->from_id)
														@php
															$connectedUserStatus = $connectedUser->status;
														@endphp
													@endif
												@endforeach
											@endif
											
										@php	
										$route = '#';
										if ($notice->type == 'user') {
											$route = route('user.users');
										} elseif ($notice->type == 'subscription') {
											$route = route('pricing');
										} elseif (in_array($notice->type, ['follow', 'follow-approved'])) {
											$route = route('UserProfileFrontend', $userSlug->slug);
										} elseif ($notice->type == 'ticket') {
											$route = route('support');
										} elseif ($notice->type == 'video') {
											$route = route('listing.video');
										} elseif ($notice->type == 'video_front') {
											$route = route('single.video', $notice->rel_id);
										} elseif ($notice->type == 'Entertainment_front') {
											$route = route('Entertainment.single.listing', $notice->rel_id);
										} elseif($notice->type == 'Blog_post' || $notice->type == 'post' || $notice->type == 'like' || $notice->type == 'unlike') {
											$route = $notice->url;
										} elseif ($notice->type == 'Blogpost_front') {
											$route = $notice->url;
										} elseif ($notice->type == 'payment') {
											$route = route('pricing');
                                        }elseif($notice->type == 'invite'){
                                            $route = $notice->url;
										} else {
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
										}
					                    @endphp
					                    
					                    
					                    <div class="list-group-item list-group-item-action" data-id="{{ $notice->id }}">
                                            <div class="row align-items-center">
                                                <div class="col-3 col-md-1">
                                                    <a href="{{ $route }}" data-id="{{ $notice->id }}">
                                                        <img alt="Image placeholder" src="{{ asset('assets/images/profile/' . ($notice->image ?? 'undraw_profile.jpg')) }}" class="avatar rounded-circle img-fluid">
                                                    </a>
                                                </div>
                                            
                                                <div class="col-7 col-md-10">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <a href="{{ $route }}" data-id="{{ $notice->id }}">
                                                                <h5 class="mb-0 text-sm">{{ $notice->first_name }}</h5>
                                                            </a>
                                                        </div>
                                                        
                                                        <div class="text-muted small">
                                                            @if($min > 60)
                                                                @if($hoursDiff < 24)
                                                                    <small>{{ $hoursDiff }} {{ $hoursDiff > 1 ? 'hrs' : 'hr' }} ago</small>
                                                                @else
                                                                    <small>{{ $daysDiff }} {{ $daysDiff > 1 ? 'days' : 'day' }} ago</small>
                                                                @endif
                                                            @else
                                                                <small>{{ $min }} {{ $min > 1 ? 'mins' : 'min' }} ago</small>
                                                            @endif
                                                        </div>
                                                    </div>
                                            
                                                    @if($notice->type == 'follow_notification' && $connectedUserStatus !== null)
                                                        @if($connectedUserStatus == 1)
                                                            <p class="text-sm mb-0 request_fol">You are connected with {{ $notice->first_name }}.</p>
                                                        @else
                                                            <p class="text-sm mb-0 request_fol">{{ $notice->message }}
                                                                <span data-status="1" Cuser-id="{{ UserAuth::getLoginId() }}" data-id="{{ $notice->from_id }}" class="approve_request btn btn-warning btn-sm">Accept request</span>
                                                            </p>
                                                        @endif

                                                    @elseif($notice->type == 'invite')
                                                    <?php
                                                        $invitation = Connected_business::get_connections_data(UserAuth::getLoginId() , $notice->rel_id);
                                                       
                                                    ?>
                                                        <p class="text-sm mb-0 request_fol_btn">{{$notice->message}}
                                                            @if($invitation->status == '1')     
                                                            <span style="font-size: 9px;margin-left: 6px;" class="btn btn-warning position-absolute">Invitation accepted</span>
                                                            @else
                                                            <span style="font-size: 9px;margin-left: 6px;" data-status="1" Cuser-id="{{UserAuth::getLoginId()}}" data-id="{{$notice->rel_id}}" class="accept_invitation btn btn-warning position-absolute">Accept invitation</span>
                                                            @endif
                                                        </p>
                                                    @else
                                                        <a href="{{ $route }}" data-id="{{ $notice->id }}">
                                                            <p class="text-sm mb-0">{{ $notice->message }}</p>
                                                        </a>
                                                    @endif
                                                </div>
                                            
                                                <div class="col-2 col-md-1 text-right">
                                                    <div class="dots-menu btn-group">
                                                        <button type="button" class="btn btn-primary dots-btn" onclick="showDropdown({{ $notice->id }})">
                                                            <i class='fas fa-ellipsis-v'></i>
                                                        </button>
                                                        <ul class="dropdown-menu action-dots" id="dropdown-{{ $notice->id }}" style="display: none;">
                                                            <li>
                                                                <button class="btn btn-link text-decoration-none hide-notification" data-id="{{ $notice->id }}" title="Hide this">
                                                                    <i class="fa fa-eye-slash" style="font-size: 13px;"></i> Hide this notification
                                                                </button>
                                                            </li>
                                                            <!--<span class="text-muted mx-2">|</span>-->
                                                            <li>
                                                                <button class="btn btn-link text-decoration-none block-notification" data-id="{{ $notice->from_id }}" title="Turn off all">
                                                                    <i class="fa fa-bell-slash"></i> Turn off all from {{$notice->first_name}}
                                                                </button>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

									</div>
									@endforeach
								@else	
									<div class="list-group-item list-group-item-action">
                                        <div class="row justify-content-center">
                                            <p class="text-sm mb-0">Empty Notification Section.</p>
                                        </div>
                                    </div>
								@endif
								</div>
								
								<div class="list-group list-group-flush" id="show_hidden" style="display: none;">

                                </div>
                                
                                <div class="list-group list-group-flush" id="show_blocked" style="display: none;">

                                </div>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

</span>
<script type="text/javascript">
$(document).ready(function() {
    $('.Readallnotification').on('click', function() {
		console.log('Notification Id is: ' + notificationId);

        const observerOptions = {
            root: null,
            rootMargin: '0px',
            threshold: 0.5 // Trigger when 50% of the element is visible
        };

		function markAsRead(notificationId) {
		    console.log("Marking notification as read:", notificationId);
				
		    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
		    var url = '{{ route("markAsRead", ["id" => ":id"]) }}'.replace(':id', notificationId);
				
		    $.ajax({
		        url: url,
		        method: 'POST',
		        headers: {
		            'X-CSRF-TOKEN': csrfToken
		        },
		        dataType: 'json',
		        success: function(response) {
		            console.log('success', response);
		        },
		        error: function(response) {
		            console.log('error', response);
		        }
		    });
		}

        

        // Callback function when the notification enters the viewport
        function handleIntersection(entries, observer) {
            entries.forEach(entry => {
            if (entry.isIntersecting) {
                // Get the data-id attribute to identify the notification
                const notificationId = entry.target.getAttribute('data-id');
                markAsRead(notificationId);

                // Unobserve the notification to avoid multiple triggers
                observer.unobserve(entry.target);
            }
            });
        }

        // Create an Intersection Observer
        const observer = new IntersectionObserver(handleIntersection, observerOptions);

        // Observe all elements with the class 'notification'
        document.querySelectorAll('.list-group-item').forEach(notification => {
            observer.observe(notification);
        });
    });
});

// $(".approve_request" ).on( "click", function() {
// 	 var status = $(this).attr('data-status');
// 	 var id = $(this).attr('data-id');
// 	 var Cid = $(this).attr('Cuser-id');
// 	 var csrfToken = document.head.querySelector('meta[name="csrf-token"]').content; 

//     alert(csrfToken);
// 	  $.ajax({
// 	    type: 'POST',
// 	    url: '{{route('request.accept')}}',
// 	    headers: {
//                 'X-CSRF-TOKEN': csrfToken
//             },
// 	    data: {
// 	      id: id, // Fix: use ":" instead of "="
// 	      status: status, // Fix: use ":" instead of "="
// 	      Cid: Cid, // Fix: use ":" instead of "="
// 	    },
// 		success: function(data) {
//             console.log(data);
//             if (data.success) {
//                 toastr.options = {
//                     "closeButton": true,
//                     "progressBar": true
//                 };
//                 toastr.success(data.success);
//             }
//             if (data.error) {
//                 toastr.options = {
//                     "closeButton": true,
//                     "progressBar": true
//                 };
//                 toastr.error(data.error);
//             }
//             setTimeout(function() {
//                 window.location.reload();
//             }, 3000);
// 		}
//   });
// });
	
	$(document).ready(function() {

        $('#show_hidden').hide();
        $('#show_blocked').hide();
    
        $('.show_hidden').on('click', function() {
            $('#show_blocked').hide();
            $('#show_notifications').hide();
            $('#show_hidden').show();
        });

        $('.show_blocked').on('click', function() {
            $('#show_hidden').hide();
            $('#show_notifications').hide();
            $('#show_blocked').show();
        });
        
        $('.notifications').on('click', function() {
            $('#show_hidden').hide();
            $('#show_blocked').hide();
            $('#show_notifications').show();
        });
    });

	function showDropdown(noticeId) {
        // Close any open dropdowns before opening a new one
        $('.dropdown-menu').not('#dropdown-' + noticeId).hide();
        
        // Toggle the specific dropdown
        $('#dropdown-' + noticeId).toggle();
    }


$(document).ready(function() {

    $(document).on('click', '.show_hidden', function() {
        var noticeId = $(this).data('id');
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            type: 'POST',
            url: '/notification/show-hidden/' + noticeId,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                if (response.html) {
                    $('#show_hidden').html('');
                    $('#show_hidden').html(response.html).show();
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
    
    $(document).on('click', '.show_blocked', function() {
        var noticeId = $(this).data('id');
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            type: 'POST',
            url: '/notification/show-blocked/' + noticeId,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                if (response.html) {
                    $('#show_blocked').html('');
                    $('#show_blocked').html(response.html).show();
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
});

$(document).ready(function() {
    $('.action-dots').hide();
    
});

$(document).ready(function() {
    $(document).on('click', '.unhide-notification', function() {
        var noticeId = $(this).data('id');

        Swal.fire({
            title: 'Unhide',
            text: 'Are you sure you want to unhide this notification?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#fcd152',
            cancelButtonColor: '#1a202e',
            confirmButtonText: 'Yes, Unhide!'
        }).then((result) => {
            if (result.isConfirmed) {

                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    type: 'POST',
                    url: '/unhide-notification/' + noticeId,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function (response) {
                        console.log(response);

                        toastr.options = {
                            timeOut: 3000,
                            progressBar: true,
                            closeButton: true,
                            positionClass: 'toast-top-right'
                            // toastClass: 'toast toast-success'
                        };

                        if (response.success) {
                            toastr.success('Notification unhidden successfully.', 'Unhide');
                            setTimeout(function() {
                                window.location.reload();
                            }, 3000);
                        } else {
                            toastr.error('Failed to unhide notification.', 'Error');
                        }
                    },
                    error: function() {
                        Swal.fire({
                            title: 'Error',
                            text: 'Error unhiding notification. Please try again.',
                            icon: 'error'
                        });
                    }
                });
            }
        });
    });

    $(document).on('click', '.unblock-notification', function() {
        var noticeId = $(this).data('id');

        Swal.fire({
            title: 'Unblock',
            text: 'Are you sure you want to unblock notifications from this user?',
            icon: 'warning', 
            showCancelButton: true,
            confirmButtonColor: '#dc3545', 
            cancelButtonColor: '#1a202e',
            confirmButtonText: 'Yes, Unblock!'
        }).then((result) => {
            if (result.isConfirmed) {
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    type: 'POST',
                    url: '/unblock-notification/' + noticeId,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function (response) {
                        console.log(response);

                        toastr.options = {
                            timeOut: 3000,
                            progressBar: true,
                            closeButton: true,
                            positionClass: 'toast-top-right'
                            // toastClass: 'toast toast-danger'
                        };

                        if (response.success) {
                            toastr.success('Notifications unblock successfully.', 'Unblock');
                            setTimeout(function() {
                                window.location.reload();
                            }, 3000);
                        } else {
                            toastr.error('Failed to unblock notifications.', 'Error');
                        }
                    },
                    error: function() {
                        Swal.fire({
                            title: 'Error',
                            text: 'Error unblocking notifications. Please try again.',
                            icon: 'error'
                        });
                    }
                });
            }
        });
    });
});
</script>
@endsection