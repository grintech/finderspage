<?php
use App\Models\Admin\HomeSettings;
use App\Models\Setting;
use App\Models\Admin\Testimonials;
use App\Models\UserAuth;

$loggedInUser = UserAuth::getloginuser();
$testimonials = Testimonials::where('status', 1)->get();
?>
@extends('layouts.frontlayout')
@section('content')
<style type="text/css">
    .successfully-saved.show {
        display: block;
    }
    input#get-Location {
        height: 40px;
        font-size: 13px;
        background-color: #EEECEC;
        border-color: rgb(183, 174, 150);
        color: #212529;
        padding-right: 35px;
        top: 60px;
    }

    .searcRes {
        position: absolute;
        background-color: #fff;
        z-index: 999999;
        clear: both !important;
        width: 300px;
        display: none;
        padding: 0 !important;
        max-height: 400px;
        overflow-y: scroll;
    }
    .searcRes::-webkit-scrollbar{display: none;}
    .searcRes{
        -ms-overflow-style: none; 
         scrollbar-width: none; }

    li.Search_val {
        list-style: none;
        cursor: pointer;
        font-size: 14px;
        padding: 8px 20px;
    }

    li.Search_val:hover {
        background-color: #ccc;
    }


    .testimonial {
  width: 100%;
  height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  background-color: #3d5a80;
  color: #3d5a80;
}
.testimonial-slide {
  padding: 40px 20px;
}
.testimonial_box-top {
  background-color: #e0fbfc;
  padding: 30px;
  border-radius: 15px;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  text-align: center;
  box-shadow: 5px 5px 20px rgba(152, 193, 217, 0.493);
}
.testimonial_box-icon {
  padding: 10px 0;
}
.testimonial_box-icon i {
  font-size: 25px;
  color: #14213d;
}
.testimonial_box-text {
  padding: 10px 0;
}
.testimonial_box-text p {
  color: #293241;
  font-size: 14px;
  line-height: 20px;
  margin-bottom: 0;
}
.testimonial_box-img {
  padding: 20px 0 10px;
  display: flex;
  justify-content: center;
}
.testimonial_box-img img {
  width: 70px;
  height: 70px;
  border-radius: 50px;
  border: 2px solid #e5e5e5;
}
.testimonial_box-name {
  padding-top: 10px;
}
.testimonial_box-name h4 {
  font-size: 20px;
  line-height: 25px;
  color: #293241;
  margin-bottom: 0;
}
.testimonial_box-job p {
  color: #293241;
  font-size: 14px;
  text-transform: uppercase;
  letter-spacing: 3px;
  line-height: 20px;
  font-weight: 300;
  margin-bottom: 0;
}


.video-bg{background-color: #d5c59f; justify-content: center; align-items: center; border-radius: 10px; padding: 10px 10px 3px;}
.video-bg video{width: 100%;height:400px;}
.video-text{padding: 0 20px;}

/*#banner-section{position: relative;}
#banner-section .carousel-caption{left:-18%;}
.header-video {position: absolute; right:14px; top:36px; z-index: 111;}
.header-video video {width:100%;height:400px;}
.top-search{width: 70%;}*/

@media only screen and (max-width:767px){
.video-bg video {width: 100%;height:300px;}
.video-text{padding: 0 10px;}
}


@media only screen and (min-width:321px) and (max-width:768px) {
    .slick-prev, .slick-next {
        display: none;
    }
}
#fundraiser-feature-type .element, #business-feature-type .element {
  height: 280px !important;
}
</style>
<section id="banner-section">
    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active" data-bs-interval="3000">
                <img src="{{asset('banner-img/pexels-fauxels-3182804.jpg')}}" class="d-block  w-100" alt="home-banner.jpg">
                <div class="carousel-caption " >
                    <h1 class="bnr-medal">World's number 🥇 choice</h1>
                    <h2><span style="color:#FBD050;"><b>The Ultimate Solution for Modern <br><span style="color:#fff!important">Business </span> Needs</b></span></h2>
                </div>
            </div>
            <div class="carousel-item " data-bs-interval="3000">
                <img src="{{asset('banner-img/slide2 (1).jpg')}}" class="d-block  w-100" alt="home-banner.jpg">
                <div class="carousel-caption ">
                <!-- <h1 class="bnr-medal">World's number 🥇 choice</h1> -->
                    <h2><span style="color:#FBD050;"><b>Discover Your Dream <br><span style="color:#fff!important">Job </span> Today </b></span></h2>
                </div>
            </div>
            <div class="carousel-item" data-bs-interval="3000">
                <img src="{{asset('banner-img/pexels-vicente-vidal-1397490-2697050.jpg')}}" class="d-block  w-100" alt="Perfect Home.png">
                <div class="carousel-caption ">
                <!-- <h1 class="bnr-medal">World's number 🥇 choice</h1> -->
                    <h2><span style="color:#FBD050;"><b>Find Your Perfect <br><span style="color:#fff!important">Home</span> Today</b></span></h2>
                </div>
            </div>
            <div class="carousel-item" data-bs-interval="3000">
                <img src="{{asset('banner-img/3.png')}}" class="d-block  w-100" alt="community (1).png">
                <div class="carousel-caption ">
                <!-- <h1 class="bnr-medal">World's number 🥇 choice</h1> -->
                    <h2><span style="color:#FBD050;"><b>Join Our Vibrant <br><span style="color:#fff!important"> Community</span><br> Connect, Share, and Grow!</b></span></h2>
                </div>
            </div>
            <div class="carousel-item" data-bs-interval="3000">
                <img src="{{asset('banner-img/New Project.jpg')}}" class="d-block  w-100" alt="Shop (2).png">
                <div class="carousel-caption ">
                <!-- <h1 class="bnr-medal">World's number 🥇 choice</h1> -->
                    <h2><span style="color:#FBD050;"><b>FindersPage  <span style="color:#fff!important">Shop </span><br>Find the Best Deals Now!</b></span></h2>
                </div>
            </div>
            <div class="carousel-item" data-bs-interval="3000">
                <img src="{{asset('banner-img/5.png')}}" class="d-block  w-100" alt="LATEST BLOG.png">
                <div class="carousel-caption ">
                <!-- <h1 class="bnr-medal">World's number 🥇 choice</h1> -->
                    <h2><span style="color:#FBD050;"><b>Stay Informed with the Latest  <span style="color:#fff!important">Posts </span>
                    <br>Stay updated</b></span></h2>
                </div>
            </div>
            {{-- <div class="carousel-item">
                <img src="{{asset('new_assets/assets/images/startup-business.jpg')}}" class="d-block  w-100" alt="startup-business.jpg">
                <div class="carousel-caption ">
                    <h2><span style="color:#FBD050;"><b>{{ HomeSettings::get('main_title') }}
                    </b></h2>
                </div>
            </div>
            <div class="carousel-item">
                <img src="{{asset('new_assets/assets/images/new-jobs.jpg')}}" class="d-block  w-100" alt="new-jobs.jpg">
                <div class="carousel-caption ">
                    <h2><span style="color:#FBD050;"><b>{{ HomeSettings::get('main_title') }}
                    </b></span><br>{{ HomeSettings::get('short_description') }}<br>{{ $button =  HomeSettings::get('button')}}
                    </h2>
                </div>
            </div> --}}
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <!-- <div class="header-video">
        <video controls="controls">
            <source src="https://finderspage.com/public/new_assets/assets/images/intro-video.mp4" type="video/mp4" />
        </video>
    </div> -->
</section>
<section id="search-section">
    <div class="container">
        <div class="top-search">
            <form id="searchForm" method="POST" action="{{ route('search') }}">
                <div class="row">
                    @csrf
                    <div class="col-lg-3 col-md-6 coll-1">
                        <div class="select-job">
                            <select id="searcjob" class="form-select" name="searcjobParent">
                                <option value="">Categories</option>
                                @foreach($blog_categories as $main_category)
                                    @if ($main_category->id !=727 && $main_category->id !=728)
                                        <option value="{{$main_category->id}}">{{$main_category->title}}</option>        
                                    @endif
                                @endforeach

                            </select>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 coll-1">
                        <div class="select-job">
                            <select id="searcjobChild" name="searcjobChild" class="form-select" data-live-search="true">
                                <option value="">Sub Categories</option>
                            </select>

                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 coll-1">
                        <div class="location-search">
                            <input type="location" name="location" class="form-control get_loc" id="get-Location" placeholder="Location">
                            <i id="getLocation" class="bi bi-geo-alt"></i>
                        </div>
                        <div class="searcRes" id="autocomplete-results">

                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-12 col-md-6 coll-2">
                        <div class="search-fields">
                            <!-- <a href="#">Search<i class="bi bi-arrow-right"></i></a> -->
                            <button class="btn fields-search" type="submit">Search<i class="bi bi-arrow-right"></i></button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
        <div class="row justify-content-center mt-2">
            <h2 class="text-center explore-heading ">Find a Featured Post by Category</h2>
            <div class="col home-post-cat">
                <a href="{{route('job_listing')}}">
                    <div class="box-part">
                        <div class="image">
                            <img src="{{asset('new_assets/assets/images/job.png')}}" alt="job.png" class="img-fluid">
                        </div>
                        <h5>Jobs</h5>
                        <div class="right-arrow">
                            <i class="bi bi-arrow-right"></i>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col home-post-cat">
                <a href="{{route('listing_realestate')}}">
                    <div class="box-part">
                        <div class="image">
                            <img src="{{asset('new_assets/assets/images/real-state.png')}}" alt="real-state.png" class="img-fluid">
                        </div>
                        <h5>Real Estate</h5>
                        <div class="right-arrow">
                            <i class="bi bi-arrow-right"></i>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col home-post-cat">
                <a href="{{route('community_post')}}">
                    <div class="box-part">
                        <div class="image">
                            <img src="{{asset('new_assets/assets/images/community.png')}}" alt="community.png" class="img-fluid">
                        </div>
                        <h5>Welcome to our
                            community</h5>
                        <div class="right-arrow">
                            <i class="bi bi-arrow-right"></i>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col home-post-cat">
                <a href="{{route('shopping_post')}}">
                    <div class="box-part">
                        <div class="image">
                            <img src="{{asset('new_assets/assets/images/shopping.png')}}" alt="shopping.png" class="img-fluid">
                        </div>
                        <h5>Shopping</h5>
                        <div class="right-arrow">
                            <i class="bi bi-arrow-right"></i>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col home-post-cat">
                <a href="{{route('service_listing')}}">
                    <div class="box-part">
                        <div class="image">
                            <img src="{{asset('new_assets/assets/images/f-services.png')}}" alt="services.png" class="img-fluid">
                        </div>
                        <h5>Services</h5>
                        <div class="right-arrow">
                            <i class="bi bi-arrow-right"></i>
                        </div>
                    </div>
                </a>
            </div>

            {{-- <div class="col home-post-cat">
                <a href="{{route('blogsViewAll')}}">
                    <div class="box-part">
                        <div class="image">
                            <img src="{{asset('new_assets/assets/images/blogging.png')}}" alt="blogging.png" class="img-fluid">
                        </div>
                        <h5>Blogs</h5>
                        <div class="right-arrow">
                            <i class="bi bi-arrow-right"></i>
                        </div>
                    </div>
                </a>
            </div> --}}

            <div class="col home-post-cat">
                <a href="{{route('Entertainment.listing')}}">
                    <div class="box-part">
                        <div class="image">
                            <img src="{{asset('new_assets/assets/images/entertainment.png')}}" alt="entertainment.png" class="img-fluid">
                        </div>
                        <h5>Entertainment Industry</h5>
                        <div class="right-arrow">
                            <i class="bi bi-arrow-right"></i>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col home-post-cat">
                <a href="{{route('listing.fundraisers')}}">
                    <div class="box-part">
                        <div class="image">
                            <img src="{{asset('new_assets/assets/images/fundraiser.png')}}" alt="fundraiser.png" class="img-fluid">
                        </div>
                        <h5>Fundraiser</h5>
                        <div class="right-arrow">
                            <i class="bi bi-arrow-right"></i>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col home-post-cat">
                 <a href="{{route('business_page.front.listing')}}">
               {{-- <a href="{{ route('comingSoon') }}">  --}}
                    <div class="box-part">
                        <div class="image">
                            <img src="{{asset('new_assets/assets/images/f-business.png')}}" alt="business.png" class="img-fluid">
                        </div>
                        <h5>Business</h5>
                        <div class="right-arrow">
                            <i class="bi bi-arrow-right"></i>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col home-post-cat">
                <a href="{{ route('comingSoon') }}">
                    <div class="box-part">
                        <div class="image">
                            <img src="{{asset('new_assets/assets/images/shopping.png')}}" class="img-fluid">
                        </div>
                        <h5>Posts</h5>
                        <div class="right-arrow">
                            <i class="bi bi-arrow-right"></i>
                        </div>
                    </div>
                </a>
            </div> 

            <div class="col home-post-cat">
                <a href="{{ route('comingSoon') }}">
                    <div class="box-part">
                        <div class="image">
                            <img src="{{asset('new_assets/assets/images/shopping.png')}}" class="img-fluid">
                        </div>
                        <h5>Videos</h5>
                        <div class="right-arrow">
                            <i class="bi bi-arrow-right"></i>
                        </div>
                    </div>
                </a>
            </div> 

            <!--  <div class="col-md-12 text-center mt-3">
                   <a href="{{route('post.posts')}}"><button class="btn fields-search" type="submit">Find Jobs</button></a> 
                </div> -->
        </div>
    </div>
</section>

<!--  <section id="background-with-image-text" class="mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-5 girl-image">
                    <img src="./new_assets/assets/images/girl.png" class="img-fluid">
                </div>
                <div class="col-md-7">
                    <h3>Lorem ipsum is dimply dummy</h3>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.Lorem Ipsum is simply dummy text of the printing and typesetting industry.Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                    <a href="{{route('post.posts')}}"><button class="btn fields-search" type="submit">Find Jobs</button></a> 
                </div>

            </div>
        </div>
    </section>  -->

<section id="bump-type" class="mt-5 mb-5">


</section>

<section id="shop-all" class="shop-all">

</section>

<section id="business-feature-type" class="mt-5 mb-5">

</section>


<!-- <section id="bump-type" class="mt-5 mb-5">
    <h4 class="text-center pb-1">Posts</h4>
    <div class="container">
        <div class="row slick-slider featured-slider d-flex flex-wrap justify-content-center">
            @forelse($blog_post as $post)
            <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-3">
                <div class="element element-1">
                    <div class="feature-box">
                        <span class="onsale">Featured!</span>
                        <a href="{{ route('blogPostSingle', $post->slug) }}">
                            @php
                                $newImg = $post->image ? explode(',', $post->image) : [];
                                $carouselId = 'carousel-' . $post->id;
                            @endphp
                            <div id="{{ $carouselId }}" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    @if(!empty($newImg))
                                        @foreach($newImg as $index => $image)
                                        @php
                                            $imagePath = 'images_blog_img/' . $image;
                                        @endphp
                                        <div class="carousel-item @if($index == 0) active @endif">
                                            <img src="{{ asset($imagePath) }}" alt="{{ $post->title }}" class="d-block w-100">
                                        </div>
                                        @endforeach
                                        @if(count($newImg) > 1)
                                            <a class="carousel-control-prev" href="#{{ $carouselId }}" role="button" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Previous</span>
                                            </a>
                                            <a class="carousel-control-next" href="#{{ $carouselId }}" role="button" data-bs-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Next</span>
                                            </a>
                                        @endif
                                    @else
                                        <img class="d-block w-100" src="{{ asset('images_blog_img/default.jpg') }}" alt="Default image">
                                    @endif
                                </div>
                            </div>
                            <p class="job-title-custom" style="color:#000;"><b>{{ $post->title }}</b></p>
                            <div class="location-job-title">
                                <div class="job-type">
                                    <div class="main-days-frame">
                                        <span class="days-box">
                                            @php
                                                $givenTime = strtotime($post->created_at);
                                                $days = floor((time() - $givenTime) / (60 * 60 * 24));
                                                echo $days > 0 ? Setting::get_formeted_time($days) : 'Posted today.';
                                            @endphp
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="button-sell" style="margin-top: 0px;">
                                <span><a href="{{ route('blogPostSingle', $post->slug) }}" class="btn create-post-button">Read More</a></span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            @empty
                <p class="card-text">Data not available.</p>
            @endforelse
        </div>
        <div class="text-center">
            <a href="{{ route('blogsViewAll') }}" class="btn fields-search text-center">View All</a>
        </div>
    </div>
</section> -->


<section id="service-feature-type" class="mt-5 mb-5">

</section>

<section id="job-feature-type" class="mt-5 mb-5">

</section>

<section id="realestate-feature-type" class="mt-5 mb-5">

</section>

<section id="comminity-feature-type" class="mt-5 mb-5">

</section>

<section id="fundraiser-feature-type" class="mt-5 mb-5">

</section>

<section id="entertainment-feature-type" class="mt-5 mb-5">

</section>



{{-- <section id="videoSection" class="mt-5 mb-5">

</section> --}}






<section id="create-business-events" class="business-events mb-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-6">
                <div class="create-page" style="background: url(https://www.finderspage.com/public/new_assets/assets/images/home-banner.jpg) no-repeat center center / cover;">
                    <h3>Create Event</h3>
                    <!-- <p>Comming Soon</p> -->
                    <a href="{{route('comingSoon')}}" class="btn fields-search">Coming Soon</a>
                    <!-- <a href="{{route('comingSoon')}}" class="btn fields-search">Stay Connect</a> -->
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="container-calendar">
                    <h3 class="text-center">View Events</h3>
                    <h5 id="monthAndYear"></h5>
                    <div class="button-container-calendar">
                        <button id="previous" onclick="previous()">&#8249;</button>
                        <button id="next" onclick="next()">&#8250;</button>
                    </div>
                    <table class="table-calendar" id="calendar" data-lang="en">
                        <thead id="thead-month"></thead>
                        <tbody id="calendar-body"></tbody>
                    </table>
                    <div class="footer-container-calendar">
                        <label for="month">Jump To: </label>
                        <select id="month" onchange="jump()">
                            <option value=0>Jan</option>
                            <option value=1>Feb</option>
                            <option value=2>Mar</option>
                            <option value=3>Apr</option>
                            <option value=4>May</option>
                            <option value=5>Jun</option>
                            <option value=6>Jul</option>
                            <option value=7>Aug</option>
                            <option value=8>Sep</option>
                            <option value=9>Oct</option>
                            <option value=10>Nov</option>
                            <option value=11>Dec</option>
                        </select>
                        <select id="year" onchange="jump()"></select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>





    {{-- <section id="feature-post" class="mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-5 carousel slide" id="carouselExampleIndicators" data-bs-ride="carousel">

                    <div class="feature-content">
                        <h5>Feature your Post</h5>
                       
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. Previous</p>
                        <a href="{{route('index_user')}}"><button class="btn fields-search" type="submit">Subscribe</button></a> 
                    </div>
                </div>
                <div class="col-md-6 col-lg-7">
                  
                    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                            
                            <div class="carousel-inner">
                                
                                <div class="carousel-item active ">
                                <a href="#">
                                <img src="{{asset('new_assets/assets/images/business.png')}}" class="d-block w-100" alt="...">
                                </a>
                                </div>
                                 <div class="carousel-item">
                                <img src="./new_assets/assets/images/business.png" class="d-block w-100" alt="...">
                                </div>
                                <div class="carousel-item">
                                <img src="./new_assets/assets/images/business.png" class="d-block w-100" alt="...">
                                </div> 
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                            </div>
                        <div id="carouselExampleControls" class="carousel slide" data-bs-touch="false" data-bs-interval="false">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                <img src="./new_assets/assets/images/business.png" class="img-fluid" alt="...">
                                </div>
                                <div class="carousel-item">
                                <img src="./new_assets/assets/images/business.png" class="img-fluid" alt="...">
                                </div>
                                <div class="carousel-item">
                                <img src="./new_assets/assets/images/business.png" class="img-fluid" alt="...">
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
            </div>
        </div>
    </section> --}}


{{-- <section class="video-intro">
    <div class="container">
        <div class="row video-bg">
            <div class="col-lg-6 col-md-6 video-text">
                <h2 class="explore-heading mb-0">Promote your brand with Us</h2>
                <p>Finderspage is user friendly,  easy platform to use without any distractions, and drama free. A safe place where everyone is equal. I believe platforms are to be used to network, inspire, heal, and most of all promote your brand.  My mission is to give back by helping you save money. Everything will be verified before being published. . We are here to support each other and spread the love. I will continue to strive to better serve you and make a difference globally one day at a time.</p>
                <a href="{{route('homepage.about')}}" class="btn blog-read-button mb-5 mb-md-0">About Us</a>
            </div>
            <div class="col-lg-6 col-md-6 p-0">
                <video controls="controls" style="background-color: #000;">
                    <source src="https://finderspage.com/public/new_assets/assets/images/intro-video.mp4" type="video/mp4" />
                </video>
            </div>
        </div>
    </div>
</section> --}}

<section class="gtco-testimonials">
    <div class="container">
        <div class="row">
            <h2>Testimonials</h2>
            <div class="owl-carousel owl-carousel1 testimonials owl-theme">
                @foreach($reviews as $rev)
                <div class="card text-center">
                    @if(isset($rev->video))
                        <video class="card-img-top" width="50px" height="50px" controls>
                            <source src="{{asset('review_video')}}/{{$rev->video}}" type="video/mp4">
                            <source src="movie.ogg" type="video/ogg">
                            Your browser does not support the video tag.
                        </video>
                    @else
                        <img class="card-img-top" src="{{asset('/assets/images/profile')}}/{{$rev->image}}" alt="">
                    @endif
                    
                    <div class="card-body">
                      <h5>{{$rev->first_name}}</h5>
                      <p class="card-text">{{$rev->description}}</p>
                    </div>
                </div>
                @endforeach
                <div class="card text-center"><img class="card-img-top" src="https://images.unsplash.com/photo-1588361035994-295e21daa761?crop=entropy&cs=tinysrgb&fit=crop&fm=jpg&h=301&ixid=eyJhcHBfaWQiOjF9&ixlib=rb-1.2.1&q=50&w=301" alt="">
                    <div class="card-body">
                      <h5>Diane Barrameda</h5>
                      <p class="card-text">“ Great website! You can find anything there. It is truly a finders page! Highly recommended! ”</p>
                    </div>
                </div>


                <div class="card text-center"><img class="card-img-top" src="https://images.unsplash.com/photo-1575377222312-dd1a63a51638?crop=entropy&cs=tinysrgb&fit=crop&fm=jpg&h=302&ixid=eyJhcHBfaWQiOjF9&ixlib=rb-1.2.1&q=50&w=302" alt="">
                    <div class="card-body">
                      <h5>Ingrid Dietrich</h5>
                      <p class="card-text">“ FindersPage is a great site to list your products and services. I highly recommend it. ”</p>
                    </div>
                </div>


                <div class="card text-center"><img class="card-img-top" src="https://images.unsplash.com/photo-1549836938-d278c5d46d20?crop=entropy&cs=tinysrgb&fit=crop&fm=jpg&h=303&ixid=eyJhcHBfaWQiOjF9&ixlib=rb-1.2.1&q=50&w=303" alt="">
                    <div class="card-body">
                      <h5>Sarita Palo Alto</h5>
                      <p class="card-text">“ FindersPage seems to be a new and up and coming site . Pretty cool I like it. Definitely useful to advertise my business. ”</p>
                    </div>
                </div>

                <div class="card text-center"><img class="card-img-top" src="https://t3.ftcdn.net/jpg/00/57/55/40/240_F_57554079_g3LhdDR5C0f2mc2ZxjFgsbb6WMqouUwQ.jpg?crop=entropy&cs=tinysrgb&fit=crop&fm=jpg&h=303&ixid=eyJhcHBfaWQiOjF9&ixlib=rb-1.2.1&q=50&w=303" alt="">
                    <div class="card-body">
                      <h5>Arcy MUA</h5>
                      <p class="card-text">“ So thankful to have found Finders Page! It's a great place to advertise your business and find other professionals in your area, def recommend it!!! ”</p>
                    </div>
                </div>

                <div class="card text-center"><img class="card-img-top" src="https://t3.ftcdn.net/jpg/03/99/91/62/240_F_399916297_1JwXdmC6ViCG4YhZuhLVz7xfuZhfHCY9.jpg?crop=entropy&cs=tinysrgb&fit=crop&fm=jpg&h=303&ixid=eyJhcHBfaWQiOjF9&ixlib=rb-1.2.1&q=50&w=303" alt="">
                    <div class="card-body">
                      <h5>Scott Davis</h5>
                      <p class="card-text">“ Good day, Brenda: I went to your finderspage.com website and really saw the potential for this being a useful App or service. You set the categories up well and the site explains how it saves time and maximizes results. You look nice, sincere, trustworthy, and seem to have the answers. I could say more about the website yet most of what I would say you already know. I get to go through it as a new set of eyes searching for what will make this my go-to App or service. ”</p>
                    </div>
                </div>

                <div class="card text-center"><img class="card-img-top" src="https://images.unsplash.com/photo-1549836938-d278c5d46d20?crop=entropy&cs=tinysrgb&fit=crop&fm=jpg&h=303&ixid=eyJhcHBfaWQiOjF9&ixlib=rb-1.2.1&q=50&w=303" alt="">
                    <div class="card-body">
                      <h5>Mary Ann Van</h5>
                      <p class="card-text">“ Congratulations on your launch Brenda! Finders Page is a brilliant community platform. ”</p>
                    </div>
                </div>

                <div class="card text-center"><img class="card-img-top" src="https://t4.ftcdn.net/jpg/06/81/01/43/240_F_681014359_dyMjwn4JYLtY985umiBOeytmLmVxEjC0.jpg?crop=entropy&cs=tinysrgb&fit=crop&fm=jpg&h=303&ixid=eyJhcHBfaWQiOjF9&ixlib=rb-1.2.1&q=50&w=303" alt="">
                    <div class="card-body">
                      <h5>Taylor Made</h5>
                      <p class="card-text">“ I want to send a HUGE shoutout to Brenda Pond founder of FindersPage !! Just received a text from someone who saw my AD! ”</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


    {{-- <section id="explore-tab" class="mt-3 mb-5 mt-sm-5">
        <div class="container">
            <div class="row">
              <h2 class="text-center explore-heading ">Explore All Categories</h2>
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                            aria-selected="true">Jobs<br><img src="{{asset('new_assets/assets/images/down.png')}}" class="down">
                            <img src="{{asset('new_assets/assets/images/right.png')}}" class="right"></button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile"
                            aria-selected="false">Real Estate<br><img src="{{asset('new_assets/assets/images/down.png')}}" class="down">
                            <img src="{{asset('new_assets/assets/images/right.png')}}" class="right"></button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact"
                            aria-selected="false">Welcome to our community<br><img src="{{asset('new_assets/assets/images/down.png')}}"
                                class="down">
                            <img src="{{asset('new_assets/assets/images/right.png')}}" class="right"></button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-four-tab" data-bs-toggle="pill" data-bs-target="#pills-four"
                            type="button" role="tab" aria-controls="pills-four" aria-selected="false">Shopping<br><img
                                src="{{asset('new_assets/assets/images/down.png')}}" class="down">
                            <img src="{{asset('new_assets/assets/images/right.png')}}" class="right"></button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-fifth-tab" data-bs-toggle="pill" data-bs-target="#pills-fifth"
                            type="button" role="tab" aria-controls="pills-four" aria-selected="false">Events<br><img
                                src="{{asset('new_assets/assets/images/down.png')}}" class="down">
                            <img src="{{asset('new_assets/assets/images/right.png')}}" class="right"></button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-six-tab" data-bs-toggle="pill" data-bs-target="#pills-six"
                            type="button" role="tab" aria-controls="pills-four" aria-selected="false">Services<br><img
                                src="{{asset('new_assets/assets/images/down.png')}}" class="down">
                            <img src="{{asset('new_assets/assets/images/right.png')}}" class="right"></button>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                        aria-labelledby="pills-home-tab" tabindex="0">
                        <div class="row">
                          @foreach($sub_blog_categories as $b)
                          
                          @if($b->parent_id =="2" || $b->main_parent_id =="2")
                          
                            <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                                <ul class="tab-list-content" id="321">
                                    @if (empty($b->main_parent_id))
                                        <li><a href="{{ route('blog_category', $b->id) }}">{{ $b->title }}</a></li>
                                    @else
                                        <li><a href="{{ route('blog_category', $b->id) }}">{{ $b->title }}</a></li>
                                    @endif
                                </ul>
                            </div>
                            @endif
                            @endforeach
                            
                           
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab"
                        tabindex="0">                        
                        <div class="row">
                            
                           @foreach($sub_blog_categories as $b)
                            @if($b->parent_id =="4" || $b->main_parent_id =="4")
                            <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                                <ul class="tab-list-content" id="first">
                                    <li><a href="{{route('blog_category',$b->id)}}">{{$b->title}}</a></li>
                                </ul>
                            </div>
                            @endif
                            @endforeach
                            
                        </div>
                      </div>
                    <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab"
                        tabindex="0">
                        <div class="row">
                          @foreach($sub_blog_categories as $b)
                           @if($b->parent_id =="5" || $b->main_parent_id =="5")
                            <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                                <ul class="tab-list-content">
                                    <li><a href="{{route('blog_category',$b->id)}}">{{$b->title}}</a></li>
                                </ul>
                            </div>
                            @endif
                            @endforeach
                           
                        </div>
                    </div>

                    <div class="tab-pane fade" id="pills-four" role="tabpanel" aria-labelledby="pills-four-tab" tabindex="0">
                        <div class="row">
                            @php
                                $i = 0;
                                $parentList = [];
                            @endphp
                            @foreach($sub_blog_categories as $b)
                                @if($b->parent_id == "6" || $b->main_parent_id == "6")
                                    @if(empty($b->main_parent_id))
                                        @php
                                            $parentList[$i]['title'] = $b->title;
                                            $parentList[$i]['id'] = $b->id;
                                            $i++;
                                        @endphp
                                    @endif
                                @endif
                            @endforeach
                            
                            @foreach($parentList as $parentListKey => $parentListValue)
                                <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                                    <ul class="tab-list-content">
                                        <li><b><a href="{{ route('blog_category', $parentListValue['id']) }}">{{ $parentListValue['title'] }}</a></b></li>
                                        @foreach($sub_blog_categories as $b)
                                            @if($b->parent_id == $parentListValue['id'])
                                                <li><a href="{{ route('blog_category', $b->id) }}">{{ $b->title }}</a></li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="tab-pane fade" id="pills-fifth" role="tabpanel" aria-labelledby="pills-fifth-tab" tabindex="0">
                        <div class="row">
                            <div class="col-md-12 col-sm-2 ">
                                <div class="container mt-4">
                                    <h4>Which of these applies</h4>
                                    <div class="form-group">
                                        @php
                                            $options = [
                                                'I\'m selling a small number of tickets to an event',
                                                'My business is having a sale',
                                                'I\'m offering an event-related service (rentals, transportation, etc.)',
                                                'I\'m advertising a garage sale, estate sale, moving sale, flea market, or other non-corporate sale',
                                                'I\'m advertising a class or training session',
                                                'I\'m advertising an event, other than the above'
                                            ];
                                        @endphp
                                        @foreach($options as $key => $option)
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="options" id="option{{ $key + 1 }}" value="option{{ $key + 1 }}">
                                            <label class="form-check-label" for="option{{ $key + 1 }}">
                                                {{ $option }}
                                            </label>
                                        </div>
                                        @endforeach
                                    </div>
                                    <a type="submit" class="event-button" target="_blank" href="https://post.craigslist.org/k/Jpy8JasV7hGJn38CfPxWVg/dNTIl?s=edit">Continue</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="pills-six" role="tabpanel" aria-labelledby="pills-six-tab" tabindex="0">
                        <div class="row">
                            @php
                                $i = 0;
                                $parentList = [];
                            @endphp
                            @foreach($sub_blog_categories as $b)
                                @if($b->parent_id == "705" || $b->main_parent_id == "705")
                                    @if(empty($b->main_parent_id))
                                        @php
                                            $parentList[$i]['title'] = $b->title;
                                            $parentList[$i]['id'] = $b->id;
                                            $i++;
                                        @endphp
                                    @endif
                                @endif
                            @endforeach
                            
                            @foreach($parentList as $parentListKey => $parentListValue)
                                <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                                    <ul class="tab-list-content">
                                        <li><b><a href="{{ route('blog_category', $parentListValue['id']) }}">{{ $parentListValue['title'] }}</a></b></li>
                                        @foreach($sub_blog_categories as $b)
                                            @if($b->parent_id == $parentListValue['id'])
                                                <li><a href="{{ route('blog_category', $b->id) }}">{{ $b->title }}</a></li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <section id="coming-soon">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                <p class="strip-para"><marquee width="100%" direction="left">Brenda Pond Foundation Coming Soon </marquee>
                </p>
                <div>
            </div>
        </div>
    </section> --}}
@if(Session::has('success'))
<script type="text/javascript">
    // alert();
    // toastr.success('<?php echo session()->get('success') ?>');
    Swal.fire(
        'Thank You',
        '<?php echo session()->get('success') ?>',
        'success'
    )
</script>
@endif
<script>
    $(document).ready(function() {
        // home page sections ajax requests START
        $.ajax({
            url: site_url + '/bump-post-data',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                //   console.log("This is the response"+ data);

                if (data && data.html) {
                    // Append the received HTML to the #feature-type element
                    $('#bump-type').html(data.html);
                }
            },
            error: function(xhr, status, error) {
                // Handle errors
                console.error(error);
                // $('#bump-type').html('<p>Error loading posts.</p>');
            }
        });


        $.ajax({
            url: site_url + '/business/Feature/post',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                if (data && data.html) {
                    $('#business-feature-type').html(data.html);
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });

        $.ajax({
            url: site_url + '/job/Feature/post',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                //   console.log("This is the response"+ data);

                if (data && data.html) {
                    // Append the received HTML to the #feature-type element
                    $('#job-feature-type').html(data.html);
                }
            },
            error: function(xhr, status, error) {
                // Handle errors
                console.error(error);
                // $('#job-feature-type').html('<p>Error loading posts.</p>');
            }
        });

        $.ajax({
            url: site_url + '/realesate/Feature/post',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                //   console.log("This is the response"+ data);

                if (data && data.html) {
                    // Append the received HTML to the #feature-type element
                    $('#realestate-feature-type').html(data.html);
                }
            },
            error: function(xhr, status, error) {
                // Handle errors
                console.error(error);
                // $('#realestate-feature-type').html('<p>Error loading posts.</p>');
            }
        });

        $.ajax({
            url: site_url + '/community/Feature/post',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                //   console.log("This is the response"+ data);

                if (data && data.html) {
                    // Append the received HTML to the #feature-type element
                    $('#comminity-feature-type').html(data.html);
                }
            },
            error: function(xhr, status, error) {
                // Handle errors
                console.error(error);
                // $('#comminity-feature-type').html('<p>Error loading posts.</p>');
            }
        });

        $.ajax({
            url: site_url + '/service/Feature/post',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                //   console.log("This is the response"+ data);

                if (data && data.html) {
                    // Append the received HTML to the #feature-type element
                    $('#service-feature-type').html(data.html);
                }
            },
            error: function(xhr, status, error) {
                // Handle errors
                console.error(error);
                // $('#service-feature-type').html('<p>Error loading posts.</p>');
            }
        });

        $.ajax({
            url: site_url + '/fundraiser/Feature/post',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                if (data && data.html) {
                    $('#fundraiser-feature-type').html(data.html);
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });

        $.ajax({
            url: site_url + '/entertainment/Feature/post',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                //   console.log("This is the response"+ data);

                if (data && data.html) {
                    // Append the received HTML to the #feature-type element
                    $('#entertainment-feature-type').html(data.html);
                }
            },
            error: function(xhr, status, error) {
                // Handle errors
                console.error(error);
                // $('#entertainment-feature-type').html('<p>Error loading posts.</p>');
            }
        });

        $.ajax({
            url: site_url + '/video/homepage',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                if (data && data.html) {
                    // Append the received HTML to the #feature-type element

                    $('#videoSection').html(data.html);
                }
                //   console.log("This is the response"+ data);
                const postActionsControllers = document.querySelectorAll(
                    ".post-actions-controller"
                );

                // When post action controllers are clicked, the action content is opened and closed

                postActionsControllers.forEach((btn) => {
                    btn.addEventListener("click", () => {
                        const targetId = btn.getAttribute("data-target");
                        const postActionsContent = document.getElementById(targetId);

                        if (postActionsContent) {
                            const isVisible = postActionsContent.getAttribute("data-visible");

                            if (isVisible === "false") {
                                postActionsContent.setAttribute("data-visible", "true");
                                postActionsContent.setAttribute("aria-hidden", "false");
                                btn.setAttribute("aria-expanded", "true");
                            } else {
                                postActionsContent.setAttribute("data-visible", "false");
                                postActionsContent.setAttribute("aria-hidden", "true");
                                btn.setAttribute("aria-expanded", "false");
                            }
                        }
                    });
                });

                // If the action content is opened, it is closed by clicking outside of it

                function handleClickOutside(event) {
                    postActionsControllers.forEach((btn) => {
                        const targetId = btn.getAttribute("data-target");
                        const postActionsContent = document.getElementById(targetId);

                        if (postActionsContent && postActionsContent.getAttribute("data-visible") === "true") {
                            if (!postActionsContent.contains(event.target) && event.target !== btn) {
                                postActionsContent.setAttribute("data-visible", "false");
                                postActionsContent.setAttribute("aria-hidden", "true");
                                btn.setAttribute("aria-expanded", "false");
                            }
                        }
                    });
                }

                document.addEventListener("click", handleClickOutside);

                postActionsControllers.forEach((btn) => {
                    btn.addEventListener("click", (event) => {
                        event.stopPropagation();
                    });
                });

                const likeBtns = document.querySelectorAll(".post-like");

                // When the like buttons are clicked, they are colored red or this action is undone

                likeBtns.forEach((likeBtn) => {
                    likeBtn.addEventListener("click", () => {
                        if (likeBtn.classList.contains("active")) {
                            likeBtn.classList.remove("active");
                        } else {
                            likeBtn.classList.add("active");
                        }
                    });
                });

                var swiper = new Swiper(".swiper", {
                    grabCursor: true,
                    mousewheel: {
                        invert: true,
                    },
                    scrollbar: {
                        el: ".swiper-scrollbar",
                        draggable: true,
                    },
                    slidesPerView: 1,
                    spaceBetween: 10,
                    // Responsive breakpoints
                    breakpoints: {
                        0: {
                            slidesPerView: 1,
                            spaceBetween: 10,
                        },
                        900: {
                            slidesPerView: 2,
                            spaceBetween: 20,
                        },
                        1200: {
                            slidesPerView: 4,
                            spaceBetween: 30,
                        },
                    },
                });

            },
            error: function(xhr, status, error) {
                // Handle errors
                console.error(error);
                // $('#videoSection').html('<p>Error loading posts.</p>');
            }
        });

        $.ajax({
            url: site_url + '/shop-post-data',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                //console.log("This is the response"+ data);

                if (data && data.html) {
                    // Append the received HTML to the #feature-type element
                    $('#shop-all').html(data.html);
                }
            },
            error: function(xhr, status, error) {
                // Handle errors
                console.error(error);
                // $('#shop-all').html('<p>Error loading posts.</p>');
            }
        });

        $.ajax({
            url: site_url + '/latest-post-data',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                // console.log("This is the response"+ data);

                if (data && data.html) {
                    // Append the received HTML to the #feature-type element
                    $('#latest-post-section').html(data.html);
                }
            },
            error: function(xhr, status, error) {
                // Handle errors
                console.error(error);
                // $('#latest-post-section').html('<p>Error loading posts.</p>');
            }
        });


        // home page sections ajax requests ends

        $('.get_loc').keyup(function() {
            var address = $(this).val();
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            console.log('CSRF Token:', csrfToken);
            $.ajax({
                url: site_url + '/get/place/autocomplete',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                },
                data: {
                    address: address,
                },
                success: function(response) {
                    $('#autocomplete-results').show();
                    console.log(response);
                    $('#autocomplete-results').empty();
                    if (response.results) {
                        response.results.forEach(function(prediction) {
                            $('#autocomplete-results').append('<li class="Search_val">' + prediction.formatted_address + '</li>');
                        });
                    } else {
                        console.log('No predictions found.');
                    }
                },
                error: function(xhr, status, error) {

                }
            });
        });
        // $('.Search_val').removeClass('active_li');

    });
    $(document).on("click", ".Search_val", function() {
        var searchVal = $(this).text();
        // alert(searchVal);
        $('.get_loc').val(searchVal);
        $(this).addClass('active_li');
        $('#autocomplete-results').hide();

    });

    document.addEventListener("DOMContentLoaded", function() {
      const el = document.querySelector('.fa-save');
      if (el) {
        el.addEventListener('click', changeClass, true);
      }

      function changeClass() {
        if (el.classList.contains('far')) {
          el.classList.add('fas');
          el.classList.remove('far');
        } else {
          el.classList.add('far');
          el.classList.remove('fas');
        }
      }
    });
</script>



@endsection