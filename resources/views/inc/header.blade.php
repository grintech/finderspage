@php
use App\Models\Admin\HomeSettings;
use App\Models\UserAuth;
use App\Models\Admin\Users;
use App\Models\Admin\Notification;
$userRole = Users::where('id',UserAuth::getLoginId())->first();
$loginUser = UserAuth::getLoginUser();
$notification = new Notification();
$notifications = $notification->getNotification(10,UserAuth::getLoginId());
$countNotice = $notification->getUserCount(UserAuth::getLoginId());
@endphp


<style>
.badge {position: absolute;top: -10px;right: 4px;padding: 5px 5px;border-radius: 45%;background-color: red;color: white;}
.video-btn{color: #fff!important;padding-left:8px;  cursor: pointer;font-family: 'Poppins';}
#close-video {border: 1px solid #fff;border-radius: 50%;font-size: 20px;color: #fff;height: 40px;width:40px;text-align: center;line-height: 20px;padding: 0;position: relative;top: 38px;z-index: 1;background:#a54db7;}
.youtube-video .modal-dialog {position: absolute;left: 0;right: 0;top: 0;bottom: 0;margin: auto;width: 100%;padding: 0 15px;height: 100%;max-width: 1000px !important;display: flex;flex-direction: column;justify-content: center;}
#video-container {position: relative;padding-bottom: 50%;padding-top: 30px;height:auto;overflow: hidden;}
.embed-responsive.embed-responsive-16by9{text-align: center;width: 100%;height: 100%;}
iframe#youtubevideo {/*position: absolute;*/top: 0;left: 0;height: 500px;width: 100%;margin: 0 auto;background: #000;}
.youtube-video .modal-header {border: none;text-align: right;display: block;padding: 0;}
.youtube-video .modal-content {background: none !important;border: none;}

@media only screen and (max-width:767px){
  .video-btn{padding-left:0px; font-size: 12px!important;font-weight: 400;}
}
</style>
 <?php
  // echo "<pre>";print_r($loginUser);die();
 ?> 

 <!---top slider--->
 <section class="header_top_section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                <div class="header_area">
                    <div class="left_area">
                        <!-- <ul class="list-inline">
                            <li class="header-fade-txt">Find it on Finderspage!</li>
                            <li class="header-fade-txt">Reach more Customers</li>
                            <li class="header-fade-txt">Unleash your Brand</li>
                            <li class="header-fade-txt">Jobs</li>
                            <li class="header-fade-txt">Real Estate</li>
                            <li class="header-fade-txt">Welcome to our community</li>
                            <li class="header-fade-txt">Shopping</li>
                            <li class="header-fade-txt">Services</li>
                            <li class="header-fade-txt">Events</li>
                            <li class="header-fade-txt">Fundraiser</li>
                            <li class="header-fade-txt">Blogs</li>
                            <li class="header-fade-txt">Vlog Away</li>
                            <li class="header-fade-txt">Entertainment Industry</li>
                            <li class="header-fade-txt">Story time</li>
                            <li class="header-fade-txt">Tales</li>
                        </ul> -->
                    </div>

                </div>

            </div>
            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                <div class="right_area">  
                    <!-- <form method="POST" action="{{ route('search') }}">
                        <div class="row">
                            @csrf
                            <div class="col-lg-10 col-md-6">
                                <div class="location-search">
                                    <input type="search" name="user_name" class="form-control user-input" id="exampleFormControlInput1"
                                        placeholder="Search Members">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </div>
                            </div>

                            <div class="col-lg-2 col-sm-12 col-md-6">
                                <div class="search-fields">
                                    <a href="#">Search<i class="bi bi-arrow-right"></i></a> 
                                    <button class="btn btn-warning user-search" type="submit">Search</button>
                                </div>
                            </div>
                        </div>
                    </form>  --> 
                    <div class="search">
                        <input type="search" name="search" class="user-input"  placeholder="Search"/>
                        <span class="open-search toggle getUser"><i class="fa-solid fa-magnifying-glass"></i></span>
                    </div>
                    <div id="target">
                        <button type="button" class="btn-close" aria-label="Close"></button>
                        <ul>
                            <li><a href="#" class="mem-result">No results found.</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="top-header">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-mob1">
                    <!-- <div class="top-left"> -->
                        <div class="new-nav-link">
                            <ul class="nav-ul-link">
                                <li> <a href="{{route('comingSoon')}}">Get the App</a></li>
                                <!-- {{-- <li> <a href="{{route('video')}}">Videos</a></li> --}} -->
                                <!-- <li> <a href="{{route('listingResume')}}">Resume</a></li> -->
                                <!-- <li> <a href="{{route('save_post')}}">Saved</a></li> -->
                                <!-- <li> <a href="#">Avoid and report a scam</a></li> -->
                            </ul>
                        </div>
                    <!-- </div> -->
                </div>
                <div class="col-md-6 text-right col-mob2">
                    <div class="top-right-section">
                    <div class="country">
                        <div class="dropdown">
                            <button class="btn btn-lg dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><span class="flag-icon flag-icon-us me-1"></span> <span>English</span></button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li>
                                    <a class="dropdown-item active" href="#"><span class="flag-icon flag-icon-us me-1"></span> <span>English</span></a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#"><span class="flag-icon flag-icon-fr me-1"></span> <span>French</span></a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#"><span class="flag-icon flag-icon-es me-1"></span> <span>Spanish</span></a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#"><span class="flag-icon flag-icon-sa me-1"></span> <span>Arabic</span></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- <div class="sign-up">
                        <div class="dropdown-new">
                            <button class="btn  signup dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown-new" aria-expanded="false">
                              Account Type
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                              <li><a class="dropdown-item" href="#">Business Page</a></li>
                              <li><a class="dropdown-item" href="#">Subscriptions</a></li>
                            </ul>
                          </div>
                    </div> -->
                    @if(UserAuth::isLogin())
                    <!-- <div class="login-new"><a href="{{route('auth.logout')}}">Logout</a></div> -->
                    @else
                    <div class="login-new">
                        <a href="{{route('auth.login')}}">Login</a> | <a href="{{route('auth.signupuser')}}">Sign up</a>
                        {{-- <a href="{{route('auth.login')}}">Login</a> | <a href="{{route('auth.signupuser')}}">Sign up</a> | <a id="play-video" class="play-button video-btn" data-url="https://finderspage.com/public/new_assets/assets/images/intro-video.mp4?rel=0&autoplay=1" data-bs-toggle="modal" data-bs-target="#myModal" title="XJj2PbenIsU">Introductory Video</i></a> --}}
                    </div>
                    @endif

                    @if(UserAuth::isLogin())
                    <div class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-white small">{{$loginUser->first_name}}</span>
                                <img class="img-profile rounded-circle" src="{{$loginUser->image!= ''? asset('assets/images/profile/'.$loginUser->image): asset('user_dashboard/img/undraw_profile.svg')}}" alt="" width="61px">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{route('index_user')}}">
                                    <i class="fas fa-th-large fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Dashboard
                                </a>
                                <a class="dropdown-item" href="{{route('user_profile', General::encrypt($loginUser->id))}}">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="{{route('auth.logout')}}" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </div>
                        
                        {{-- <div class="login-new">| <a id="play-video" class="play-button video-btn" data-url="https://finderspage.com/public/new_assets/assets/images/intro-video.mp4?rel=0&autoplay=1" data-bs-toggle="modal" data-bs-target="#myModal" title="XJj2PbenIsU">Introductory Video</i></a>
                            </div>  --}}
                    @endif

                    <?php
                        if(isset($_COOKIE['cart_product_ids'])) {
                            $cartCount = $_COOKIE['cart_product_ids'];
                            $cartItems = explode('|', $cartCount);
                            $count = count($cartItems);
                        } else {
                            $count = 0;
                        }

                    ?>
                    <!-- <div class="cart"><a href="{{route('cart')}}"><i class="bi bi-cart"></i><span class="count" style="background-color: #fff;border-radius: 50%;padding: 4px;font-size: 9px;
position: absolute;top: 0px;right: 8.9%;"><?= $count; ?></span></a></div> -->

      
                    

                </div>
                </div>
            </div>
        </div>
    </section>
    

<!-- ==== Header Top Section End ==== -->

<header id="headerr">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="{{route('homepage.index')}}">
                    <?php if ($logo) : ?>
                        <img src="<?php echo asset($logo) ?>" alt="...">
                    <?php else : ?>
                        <h2><?php echo $companyName ?></h2>
                    <?php endif; ?>
                </a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="<?= url('/'); ?>">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="{{route('getAllpostpost')}}">Popular Post</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('homepage.about')}}">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('homepage.contact.form')}}">Contact Us</a>
                        </li> 
                    </ul>
                    
                        {{-- <li class="nav-item">
                            <a class="nav-link" href="{{route('user.search.page')}}">Members</a>
                        </li> --}}
                    <form class="d-flex ms-auto">

                       <a href="{{route('index_user')}}"> <button class="btn create-post-button" type="button">Create Free Post</button></a>
                    </form>
                </div>
            </div>
        </nav>
    </header>
<!-- ==== Header Section Start ==== -->


<!-- VIDEO MODAL -->
<div class="modal fade youtube-video" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button id="close-video" type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i></button>
      </div>
      <div class="modal-body">
        <div class="embed-responsive embed-responsive-16by9">
          <iframe class="embed-responsive-item" id="youtubevideo" src="" allowfullscreen></iframe>
        </div>        
      </div>
      
    </div> 
  </div>
</div>
<!-- VIDEO MODAL -->
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script> -->
<script>
$(document).ready(function() {
  $('#play-video').click(function() {
    var videoUrl = $(this).data('url');
    $('#youtubevideo').attr('src', videoUrl);
  });

  $('#myModal').on('hidden.bs.modal', function () {
    $('#youtubevideo').attr('src', '');
  });
});
</script>

<script>
    $(document).on("click", "#logout", function(e) {
        e.preventDefault();
        var link = $(this).attr("data-link");
         Swal.fire({
            title: 'Logout',
            text: 'Are you sure you want to logout?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#fcd152',
            cancelButtonColor: '#1a202e',
            confirmButtonText: 'Yes, logout!',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = link;
            }
        });
    });

    const headerElement = document.getElementById('headerr');

    window.onscroll = function() {
  if (window.scrollY > 40) {
    headerElement.classList.add('scrolledddd');
  } else {
    headerElement.classList.remove('scrolledddd');
  }
};


// $('.right_area').on('click', '.open-search', function() {
//   $('[name="search"]').toggleClass('show')
// });

// $('.user-input').click(function() {
//     $('#target').toggle('slow');
// });


jQuery(document).ready(function() {
    var typingTimer;
    var doneTypingInterval = 1000; // You can adjust this interval as needed (in milliseconds)

    $(".user-input").on("keyup", function() {
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
            url: site_url + '/user-search-result-home',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {
                user_name: user_name,
            },
            success: function(response) {
                console.log(response);
                
                    $('.mem-result').html(response.html);
                    
                
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                $('.mem-result').html('<p>Error loading posts.</p>');
            }
        });
    }
});



</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add event listener to the .user-input elements
    $('.user-input').click(function() {
        $('#target').fadeIn('slow');
    });
    
    // Add event listener to the close button
    $('.btn-close').click(function() {
        $('#target').fadeOut('slow');
    });
});
</script>

