@php
    use App\Models\UserAuth;
@endphp

@extends('layouts.adminlayout')

@section('content')
<div class="header bg-primary pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    {{-- <h6 class="h2 text-white d-inline-block mb-0">
						@if($notify->count() > 1) 
							Notifications 
						@else 
							Notification 
						@endif
					</h6> --}}
                    <h6 class="h2 text-white d-inline-block mb-0">Notifications</h6>
                </div>
                <div class="col-lg-6 col-5 text-right">
                    <a class="btn btn-warning clearNotification" href="{{ route('notification.clear', 7) }}">Clear</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Page content -->
<div class="container-fluid mt--6">
    <div class="row">
        <div class="col">
            <div class="card listing-block">
                <!-- Flash messages -->
                @include('admin.partials.flash_messages')

                <div class="table-responsive">
                    <!-- Notification list -->
                    <div class="px-3 py-3">
                        <h6 class="text-sm text-muted m-0">
                            You have 
                            <strong class="text-primary">{{ $countNotice ?? 'no new' }}</strong> 
                            @if($countNotice > 1) 
                                notifications. 
                            @else 
                                notification. 
                            @endif
                        </h6>
                    </div>

                    <div class="list-group list-group-flush">
                        @foreach($notify as $notice)
                            @php
                                $userSlug = UserAuth::getUserSlug($notice->from_id);
                                
                                $now = new DateTime();
                                $last_updated = new DateTime($notice->created);
                                $diff = $now->diff($last_updated);
                                $hoursDiff = $diff->h + ($diff->days * 24);
                                $daysDiff = $diff->days;
                                $min = $diff->i + ($hoursDiff * 60);
                            @endphp

                            @if($notice->type == 'user')
                                <a href="{{ route('UserProfileFrontend', $userSlug->slug) }}" class="list-group-item list-group-item-action">
                            @elseif($notice->type == 'subscription')
                                <a href="https://www.finderspage.com/admin/post/payment" class="list-group-notification-item list-group-item list-group-item-action" data-id="{{ $notice->id }}">
                            @elseif($notice->type == 'video')
                                <a href="{{ route('video.list') }}" class="list-group-item list-group-item-action">
							@elseif($notice->type == 'ticket')
								<a href="{{ route('admin.support.ticket') }}" class="list-group-item list-group-item-action">
                            @else
                                <a href="{{ $notice->url }}" class="list-group-item list-group-item-action">
                            @endif
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <img alt="Profile image" src="{{ asset('assets/images/profile/' . ($notice->image ?? 'undraw_profile.jpg')) }}" class="avatar rounded-circle">
                                    </div>
                                    <div class="col ml--2">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h4 class="mb-0 text-sm">{{ $notice->first_name }}</h4>
                                            </div>
                                            <div class="text-right text-muted">
                                                @if($min > 60)
                                                    @if($hoursDiff < 24)
                                                        <small>{{ $hoursDiff }} hrs ago</small>
                                                    @else
                                                        <small>{{ $daysDiff }} days ago</small>
                                                    @endif
                                                @else
                                                    <small>{{ $min }} min ago</small>
                                                @endif
                                            </div>
                                        </div>
                                        <p class="text-sm mb-0">{{ $notice->message }}</p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
