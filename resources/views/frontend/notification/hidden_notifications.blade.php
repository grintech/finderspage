@php 
	use App\Models\UserAuth;
	use App\Models\Admin\Follow;
	use App\Models\Setting;
@endphp

@foreach($hiddenNotifications as $notice)

	@php

		$user = UserAuth::getUser($notice->from_id);

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
	} elseif (in_array($notice->type, ['follow', 'follow-approved', 'follow_notification'])) {
		$route = route('UserProfileFrontend', $user->slug);
	} elseif ($notice->type == 'ticket') {
		$route = route('support');
	} elseif ($notice->type == 'video') {
		$route = route('listing.video');
	} elseif ($notice->type == 'video_front') {
		$route = route('single.video', $notice->rel_id);
	} elseif ($notice->type == 'Entertainment_front') {
		$route = route('Entertainment.single.listing', $notice->rel_id);
	} elseif($notice->type == 'Blog_post' || $notice->type == 'post') {
		$route = $notice->url;
	} elseif ($notice->type == 'Blogpost_front') {
		$route = null;
	} elseif ($notice->type == 'payment') {
		$route = null;
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
	        
	      <div class="col-md-1">
	          <a href="{{ $route }}" data-id="{{ $notice->id }}">
				 <img alt="Image placeholder" src="{{ asset('assets/images/profile/' . ($user->image ?? 'undraw_profile.jpg')) }}" class="avatar rounded-circle">
			  </a>
		  </div>
		  
		  <div class="col-md-10">
			<div class="d-flex justify-content-between align-items-center">
		    	<div>
					<a href="{{ $route }}" data-id="{{ $notice->id }}">
						<h4 class="mb-0 text-sm">{{ $user->first_name }}</h4>
					</a>
				</div>
				
			    <div class="text-right text-muted">
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
					<p class="text-sm mb-0 request_fol">You are connected with {{ $user->first_name }}.</p>
				@else
					<p class="text-sm mb-0 request_fol">{{ $notice->message }}
						<span data-status="1" Cuser-id="{{ UserAuth::getLoginId() }}" data-id="{{ $notice->from_id }}" class="approve_request btn btn-warning">Accept request</span>
					</p>
				@endif
			@else
			<a href="{{ $route }}" data-id="{{ $notice->id }}">
				<p class="text-sm mb-0">{{ $notice->message }}</p>
			</a>
			@endif
		</div>
		
		<div class="col-md-1 text-right">
            <div class="dots-menu btn-group">
                <button type="button" class="btn btn-primary dots-btn" onclick="showDropdown({{ $notice->id }})">
                    <i class='fas fa-ellipsis-v'></i>
                </button>
                <ul class="dropdown-menu action-dots" id="dropdown-{{ $notice->id }}" style="display: none;">
                    <li>
                        <button class="btn btn-link text-decoration-none unhide-notification" data-id="{{ $notice->id }}" title="Unhide this">
                            <i class="fa fa-eye" style="font-size: 13px;"></i> Unhide this notification
                        </button>
                    </li>
                </ul>
            </div>
		</div>
    </div>
</div>
@endforeach
