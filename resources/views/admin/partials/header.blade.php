@php
    use App\Models\Admin\HomeSettings;
    use App\Models\UserAuth;
    use App\Models\Admin\Users;
    use App\Models\Admin\Notification;

    $userRole = Users::where('id', UserAuth::getLoginId())->first();
    $loginUser = AdminAuth::getLoginUser();
    $notification = new Notification();
    $notifications = $notification->getNotification(5, 7);
    $countNotice = $notification->getCount(AdminAuth::getLoginId(), null);
@endphp

<style>
    .ico {
        position: absolute;
        top: 0px;
        right: 8px;
        padding: 0px 5px;
        border-radius: 45%;
        background-color: red;
        color: white;
        font-size: 12px;
    }
    i.bi.bi-bell-fill.ni-lg {
        color: #1a202e;
        background-color: #fff;
        width: 45px;
        height: 45px;
        padding: 14px;
        border-radius: 56px;
        font-size: 18px;
        display: inline-block;
        position: relative;
        top: 4px;
    }
</style>

<nav class="navbar navbar-top navbar-expand navbar-dark bg-primary border-bottom">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Search form -->
            <!-- Navbar links -->
            <ul class="navbar-nav align-items-center">
                <li class="nav-item d-xl-none">
                    <div class="pr-3 sidenav-toggler sidenav-toggler-dark" data-action="sidenav-pin" data-target="#sidenav-main">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                        </div>
                    </div>
                </li>
                <li class="nav-item d-sm-none d-none">
                    <a class="nav-link" href="#" data-action="search-show" data-target="#navbar-search-main">
                        <i class="ni ni-zoom-split-in"></i>
                    </a>
                </li>
            </ul>

            <ul class="navbar-nav align-items-center ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link notification-top" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="bi bi-bell-fill ni-lg"></i>
                        @if($countNotice > 0)
                            <span class="ico">{{ ($countNotice > 9) ? '9+' : $countNotice }}</span>
                        @endif
                    </a>
                    <div class="dropdown-menu dropdown-menu-xl dropdown-menu-right py-0 overflow-hidden">
                        <div class="px-3 py-3">
                            <h6 class="text-sm text-muted m-0">
                                You have <strong class="text-primary">{{ $countNotice ?? "no new" }}</strong>
                                @if($notifications->count() > 1) notifications. @else notification. @endif
								{{-- {{ $countNotice ?? "no new" }} --}}
                            </h6>
                        </div>
                        <div class="list-group list-group-flush">
                            @foreach($notifications as $notice)
                                @php
                                    $userSlug = UserAuth::getUserSlug($notice->from_id);
                                    
                                    $datetime1 = $notice->created;
                                    $date = strtotime($datetime1);
                                    $seconds = time() - $date;
                                    $days = floor($seconds / 86400);
                                    $seconds %= 86400;
                                    $hours = floor($seconds / 3600);
                                    $seconds %= 3600;
                                    $minutes = floor($seconds / 60);
                                    $seconds %= 60;
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
                                            <img 
                                                alt="Profile image" 
                                                src="{{ asset('assets/images/profile/' . ($notice->image ?? 'undraw_profile.jpg')) }}" 
                                                class="avatar rounded-circle">
                                        </div>
                                        <div class="col ml--2">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h4 class="mb-0 text-sm">{{ $notice->first_name }}</h4>
                                                </div>
                                                <div class="text-right text-muted">
                                                    @if($hours == 0)
                                                        <small>{{ $days }} days ago</small>
                                                    @else
                                                        <small>{{ $hours }} hrs ago</small>
                                                    @endif
                                                </div>
                                            </div>
                                            <p class="text-sm mb-0">{{ $notice->message }}.</p>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                        <a href="{{ route('admin.notification') }}" class="dropdown-item text-center text-primary font-weight-bold py-3">View all</a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="media align-items-center">
                            <span class="avatar avatar-sm rounded-circle">
                                <img alt="Image placeholder" src="{{ asset('/assets/images/profile/' . ($loginUser->image ?? 'undraw_profile.jpg')) }}">
                            </span>
                            <div class="media-body ml-2 d-none d-lg-block">
                                <span class="mb-0 text-sm font-weight-bold">{{ AdminAuth::getLoginUserName() }}</span>
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <div class="dropdown-header noti-title">
                            <h6 class="text-overflow m-0">Welcome!</h6>
                        </div>
                        <a href="{{ route('admin.profile') }}" class="dropdown-item">
                            <i class="bi bi-person-fill"></i>
                            <span>My profile</span>
                        </a>
                        <a href="{{ route('admin.changePassword') }}" class="dropdown-item">
                            <i class="bi bi-gear-fill"></i>
                            <span>Change Password</span>
                        </a>
                        <a target="blank" href="{{ route('homepage.index') }}" class="dropdown-item">
                            <i class="bi bi-gear-fill"></i>
                            <span>Visit Website</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('admin.logout') }}" class="dropdown-item">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Logout</span>
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
