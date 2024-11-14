<!-- Sidebar -->
@php 
use App\Models\UserAuth;
use App\Models\Entertainment;
use App\Models\Admin\Blogs;
use App\Models\Business;
use App\Models\Resume;
@endphp

<?php  
$user = UserAuth::getLoginUser();
$userId = UserAuth::getLoginId();
// dd($userId);
?>

<?php 
// echo $user->profile_percent;
$entertainmentCount = Entertainment::where('user_id',UserAuth::getLoginId())->count();
// dd($entertainmentCount);

$servicesCount = Blogs::whereIn('blogs.id', function ($query) {
    $query->select('blogs.id')
        ->from('blogs')
        ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
        ->where('blogs.user_id', '=', UserAuth::getLoginId())
        ->where('blog_category_relation.category_id', '=', 705)// Add this condition
        ->groupBy('blogs.id');
    })
        ->orderBy('blogs.id', 'desc')
        ->count();
// dd($servicesCount);

$realEstateCount = Blogs::whereIn('blogs.id', function ($query) {
    $query->select('blogs.id')
        ->from('blogs')
        ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
        ->where('blogs.user_id', '=', UserAuth::getLoginId())
        ->where('blog_category_relation.category_id', '=', 4)// Add this condition
        ->groupBy('blogs.id');
    })
        ->orderBy('blogs.id', 'desc')
        ->count();
// dd($realEstateCount);

$businessCount = Business::whereIn('businesses.id', function ($query) {
    $query->select('businesses.id')
        ->from('businesses')
        ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'businesses.id')
        ->where('businesses.user_id', '=', UserAuth::getLoginId())
        ->where('blog_category_relation.category_id', '=', 1)// Add this condition
        ->groupBy('businesses.id');
    })
        ->orderBy('businesses.id', 'desc')
        ->count();

$jobCount = Blogs::whereIn('blogs.id', function ($query) {
    $query->select('blogs.id')
        ->from('blogs')
        ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
        ->where('blogs.user_id', '=', UserAuth::getLoginId())
        ->where('blog_category_relation.category_id', '=', 2)// Add this condition
        ->groupBy('blogs.id');
    })
        ->orderBy('blogs.id', 'desc')
        ->count();
// dd($jobCount);

$commCount = Blogs::whereIn('blogs.id', function ($query) {
    $query->select('blogs.id')
        ->from('blogs')
        ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
        ->where('blogs.user_id', '=', UserAuth::getLoginId())
        ->where('blog_category_relation.category_id', '=', 5)// Add this condition
        ->groupBy('blogs.id');
    })
        ->orderBy('blogs.id', 'desc')
        ->count();
// dd($commCount);

$shoppingCount = Blogs::whereIn('blogs.id', function ($query) {
    $query->select('blogs.id')
        ->from('blogs')
        ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
        ->where('blogs.user_id', '=', UserAuth::getLoginId())
        ->where('blog_category_relation.category_id', '=', 6)// Add this condition
        ->groupBy('blogs.id');
    })
        ->orderBy('blogs.id', 'desc')
        ->count();


        $fundraiserCount = Blogs::whereIn('blogs.id', function ($query) {
            $query->select('blogs.id')
                ->from('blogs')
                ->join('blog_category_relation', 'blog_category_relation.blog_id', '=', 'blogs.id')
                ->where('blogs.user_id', '=', UserAuth::getLoginId())
                ->where('blog_category_relation.category_id', '=', 7)// Add this condition
                ->groupBy('blogs.id');
            })
                ->orderBy('blogs.id', 'desc')
                ->count();
// dd($shoppingCount);

$resumeCount = Resume::where('user_id', $user->id)->where('user_id', UserAuth::getLoginId())->count();
// dd($resumeCount);
?>
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion left-sidebar" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand navbar-brand d-flex align-items-center justify-content-center" href="{{url('/')}}">
                <div class="sidebar-brand-text">
                    <img src="{{asset('user_dashboard/img/logo.png')}}" class="img-fluid logo-img">
                    <img src="{{asset('images/newlogo.png')}}" class="img-fluid logo-icon">
                    <!-- <img src="{{asset('user_dashboard/img/logo-icon.png')}}" class="img-fluid logo-icon"> -->
                </div>
            </a>
          
            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                 <?php $active = strpos(request()->route()->getAction()['as'], 'index_user') > -1; ?>
                <a class="nav-link <?php echo ($active ? ' active' : '') ?>" href="{{route('index_user')}}"><i class="fas fa-th-large"></i> <span class="nav-link-text">Create a Post</span></a>
            </li>

            <!-- <li class="nav-item">
                @php
                    $active = strpos(request()->route()->getAction()['as'], 'commingSoon_bussiness') !== false;
                @endphp
                <a class="nav-link {{ $active ? 'active' : '' }}" href="{{ route('commingSoon_bussiness') }}">
                    <i class="fas fa-file-alt"></i>
                    <span>Business Page</span>
                </a>
            </li>  -->
            

           <li class="nav-item">
                @php
                    $active = strpos(request()->route()->getAction()['as'], 'business_page.list') !== false;
                @endphp
                <a class="nav-link {{ $active ? 'active' : '' }}" href="{{ route('business_page.list') }}">
                    <i class="fas fa-file-alt"></i>
                    <span>Business Page</span>
                </a>
            </li>
            

            
             <!-- <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne"
                    aria-expanded="true" aria-controls="collapseOne">
                    <i class="fas fa-user-edit"></i> <span>Create Post</span>
                </a>
                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionSidebar">
                    <div class="pb-2 collapse-inner">
                        <a class="collapse-item" href="{{route('post.create')}}">Jobs</a>
                            <a class="collapse-item" href="{{route('create_realestate')}}">Real Estate</a>+
                            <a class="collapse-item" href="{{route('community')}}">Welcome to our Community</a>
                            <a class="collapse-item" href="{{route('shopping')}}">Shopping</a>
                            <a class="collapse-item" href="{{route('add_services')}}">Services</a>
                    </div>
                </div>
            </li> -->
            <!-- <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-user"></i> <span>Profile </span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="pb-2 collapse-inner mbg-yellow">
                        <a class="collapse-item" href="#">View Profile</a>
                        <a class="collapse-item" href="#">Edit Profile</a>
                        <a class="collapse-item" href="#">Settings</a>
                        <a class="collapse-item" href="#">Change Password</a>
                    </div>
                </div>
            </li> -->
            <!-- <li class="nav-item">
                <a class="nav-link" href="{{route('my_post')}}"><i class="far fa-edit"></i> <span>My Posts</span></a>
            </li> -->
            <li class="nav-item">
                 <?php $active = strpos(request()->route()->getAction()['as'], 'resume') > -1; ?>
                <a class="nav-link <?php echo ($active ? ' active' : '') ?>" href="{{route('resume')}}"><i class="far fa-save"></i> <span>Create Resume</span></a>
            </li>

            <?php $active = strpos(request()->route()->getAction()['as'], 'job_post_list') > -1; ?>
            <?php $active = strpos(request()->route()->getAction()['as'], 'realEstate_post_list') > -1; ?>
            <?php $active = strpos(request()->route()->getAction()['as'], 'community_post_list') > -1; ?>
            <?php $active = strpos(request()->route()->getAction()['as'], 'shopping_post_list') > -1; ?>
            <?php $active = strpos(request()->route()->getAction()['as'], 'my_post') > -1; ?>
            <?php $active = strpos(request()->route()->getAction()['as'], 'resume.list') > -1; ?>
            <?php $active = strpos(request()->route()->getAction()['as'], 'Entertainment.d-list') > -1; ?>
             <li class="nav-item<?php echo ($active ? ' active' : ''); ?>">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#allpost"
        aria-expanded="true" aria-controls="allpost">
        <i class="fas fa-user-edit"></i> <span>Your Ads</span>
    </a>
    <div id="allpost" class="collapse<?php echo ($active ? ' show' : ''); ?>" aria-labelledby="headingOne" data-parent="#accordionSidebar">
        <div class="pb-2 collapse-inner">
            <a class="collapse-item<?php echo (request()->route()->getName() == 'job_post_list' ? ' active' : ''); ?>" href="{{route('job_post_list')}}">Your Job Ads <span class="badge badge-danger"> {{ $jobCount }} </span> </a>
            <a class="collapse-item<?php echo (request()->route()->getName() == 'realEstate_post_list' ? ' active' : ''); ?>" href="{{route('realEstate_post_list')}}">Your Real Estate Ads <span class="badge badge-danger"> {{ $realEstateCount }} </span> </a>
            <a class="collapse-item<?php echo (request()->route()->getName() == 'community_post_list' ? ' active' : ''); ?>" href="{{route('community_post_list')}}">Your Community Ads <span class="badge badge-danger"> {{ $commCount }} </span> </a>
            <a class="collapse-item<?php echo (request()->route()->getName() == 'shopping_post_list' ? ' active' : ''); ?>" href="{{route('shopping_post_list')}}">Your Shopping Ads <span class="badge badge-danger"> {{ $shoppingCount }} </span> </a>
            <a class="collapse-item<?php echo (request()->route()->getName() == 'my_post' ? ' active' : ''); ?>" href="{{route('my_post')}}">Your Services Ads <span class="badge badge-danger"> {{ $servicesCount }} </span> </a>
            <a class="collapse-item<?php echo (request()->route()->getName() == 'resume.list' ? ' active' : ''); ?>" href="{{ route('resume.list') }}">Your Resumes <span class="badge badge-danger"> {{ $resumeCount }} </span> </a>
            <a class="collapse-item<?php echo (request()->route()->getName() == 'Entertainment.d-list' ? ' active' : ''); ?>" href="{{ route('Entertainment.d-list') }}">Your Entertainment Industry Ads <span class="badge badge-danger"> {{ $entertainmentCount }} </span> </a>
            <a class="collapse-item<?php echo (request()->route()->getName() == 'list.fundraisers' ? ' active' : ''); ?>" href="{{ route('list.fundraisers') }}">Your Fundraiser Ads <span class="badge badge-danger"> {{$fundraiserCount}} </span> </a>
            <a class="collapse-item<?php echo (request()->route()->getName() == 'business_page.list' ? ' active' : ''); ?>" href="{{ route('business_page.list') }}">Business pages <span class="badge badge-danger"> {{$businessCount}} </span> </a>
        </div>
    </div>
</li>


           
            {{-- <li class="nav-item">
                 <?php $active = strpos(request()->route()->getAction()['as'], 'blog.list') > -1; ?>
                <a class="nav-link  <?php echo ($active ? ' active' : '') ?>" href="{{route('blog.list')}}"><i class="fa fa-blog"></i> <span>Blogs</span></a>
            </li> --}}
            <!-- <li class="nav-item">
                <a class="nav-link" href="#!"><i class="fas fa-shopping-cart"></i> <span>Shop</span></a>
            </li> -->
            <li class="nav-item">
                <?php $active = strpos(request()->route()->getAction()['as'], 'pricing') > -1; ?>
                <a class="nav-link <?php echo ($active ? ' active' : '') ?>" href="{{route('pricing')}}"><i class="fas fa-dollar-sign"></i> <span>Subscriptions</span></a>
            </li>
            <li class="nav-item">
                <?php $active = strpos(request()->route()->getAction()['as'], 'saved_post') > -1; ?>
                <a class="nav-link  <?php echo ($active ? ' active' : '') ?>" href="{{route('saved_post')}}"><i class="far fa-save"></i> <span>Saved</span></a>
            </li>
             <!-- <li class="nav-item">
                <a class="nav-link" href="javascript:;"><i class="fa fa-calendar-alt"></i> <span>Events</span></a>
            </li> -->
            <!-- <li class="nav-item">
                <a class="nav-link" href="javascript:;"><i class="fa fa-layer-group"></i> <span>Group Page</span></a>
            </li> -->
            {{-- <li class="nav-item">
                <a class="nav-link" href="{{route('listing.video')}}"><i class="fa fa-video"></i> <span>Videos</span></a>
            </li> --}}

            
            <!-- <li class="nav-item">
                <a class="nav-link" href="javascript:;"><i class="fa fa-clock"></i> <span>Story Time</span></a>
            </li> -->

           

            <li class="nav-item">
                <?php $active = strpos(request()->route()->getAction()['as'], 'support') > -1; ?>
                <a class="nav-link <?php echo ($active ? ' active' : '') ?>" href="{{route('support')}}"><i class="fa fa-headset"></i> <span>Support</span></a>
            </li>
            <li class="nav-item">
                <?php $active = strpos(request()->route()->getAction()['as'], 'chatify') > -1; ?>
                <a class="nav-link <?php echo ($active ? ' active' : '') ?>" target="blank" href="{{url('/chatify')}}"><i class="far fa-comment"></i> <span>Chat</span></a>
            </li>
            <li class="nav-item">
                <?php $active = strpos(request()->route()->getAction()['as'], 'getPostsdeleted') > -1; ?>
                <a class="nav-link <?php echo ($active ? ' active' : '') ?>" target="blank" href="{{ url('restore-listing', [$userId]) }}"><i class="fa fa-trash"></i> <span>Recently deleted</span></a>
            </li>
            

            <hr class="sidebar-divider d-none d-md-block">
             <li class="nav-item">
                <?php $active = strpos(request()->route()->getAction()['as'], 'setting') > -1; ?>
                <a class="nav-link <?php echo ($active ? ' active' : '') ?>" href="{{route('setting')}}"><i class="fas fa-cogs"></i> <span>Settings</span></a>
                <!-- <i class="fa-solid fa-gear"></i> -->
            </li> 
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">
            <!-- Sidebar Toggler (Sidebar) -->
            <div class="side-toggle">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>

        <script type="text/javascript">
        // $( document ).ready(function() {
        //     $(".collapse-item").click(function(){
        //        var prc = $('.percent').val();
        //        // alert(prc);
        //         if(prc != '100'){
        //             event.preventDefault();
        //              toastr.options =
        //               {
        //                 "closeButton" : true,
        //                 "progressBar" : true
        //               }
        //               toastr.error("Please Complete your profile 100% ...!! "); 
        //             }  
                
        //     });
        // });


document.addEventListener("DOMContentLoaded", function () {
    const showButton = document.getElementById("sidebarToggleTop");
    const hiddenElement = document.getElementById("accordionSidebar");

    showButton.addEventListener("click", function () {
        // Check if the "mobile-hidden" class is applied (for mobile devices)
        if (hiddenElement.classList.contains("left-sidebar")) {
            hiddenElement.style.display = "block"; // Change the display property to "block"
        }
    });
});



        </script>