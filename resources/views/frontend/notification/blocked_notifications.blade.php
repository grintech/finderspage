@php 
	use App\Models\UserAuth;
@endphp

@foreach($blockedUsers as $user)
    @php
        $blockedUser = UserAuth::getUser($user->following_id);
    @endphp
    <div class="list-group-item list-group-item-action">
        <div class="row align-items-center">
            <div class="col-md-1">
                <a href="{{ route('UserProfileFrontend', $blockedUser->slug) }}">
                    <img alt="Image placeholder" src="{{ asset('assets/images/profile/' . ($blockedUser->image ?? 'undraw_profile.jpg')) }}" class="avatar rounded-circle">
                </a>
            </div>
            <div class="col-md-10">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <a href="{{ route('UserProfileFrontend', $blockedUser->slug) }}">
                            <h4 class="mb-0 text-sm">{{ $blockedUser->first_name }}</h4>
                        </a>
                    </div>
                </div>
                <a href="{{ route('UserProfileFrontend', $blockedUser->slug) }}">
                    <p class="text-sm mb-0">This user's notifications have been turn off by you.</p>
                </a>
            </div>
            <div class="col-md-1 text-right">
                <div class="dots-menu btn-group">
                    <button type="button" class="btn btn-primary dots-btn" onclick="showDropdown({{ $blockedUser->id }})">
                        <i class='fas fa-ellipsis-v'></i>
                    </button>
                    <ul class="dropdown-menu action-dots" id="dropdown-{{ $blockedUser->id }}" style="display: none;">
                        <li>
                            <button class="btn btn-link text-decoration-none unblock-notification" data-id="{{ $blockedUser->id }}" title="Turn on all">
                                <i class="fa fa-bell" style="font-size: 13px;"></i> Turn on all from {{$blockedUser->first_name}}
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endforeach