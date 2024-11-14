<?php

use App\Models\Admin\Settings;  ?>
@extends('layouts.frontlayout')

@section('content')
<?php
// echo"<pre>";print_r(Settings::getTitle('about_us_title'));die();
?>
<seciton id="about-description">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="description-img">
                    <img src="{{asset('images_entrtainment')}}/<?php echo Settings::get('image') ?>" alt="Image" class="img-fluid">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="description-content">
                    <h6 class="title"><?php echo Settings::getShortDes('about_us_short_description') ?></h6>
                    <h1 style="font-size: 32px;"><?php echo Settings::getTitle('about_us_title') ?></h1>
                    <p><?php echo Settings::get('about_us_description') ?></p>
                    <div class="about-writer">
                        <p class="mb-1">Find it on FindersPage!</p>
                        <h4>Brenda Pond</h4>
                        <a href="{{route('about_brenda')}}" class="btn create-post-button">Meet the Founder/CEO</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
    </section>

    <section id="blog-section" class="mt-5 mb-5">
        <!-- <div class="container" id="latest-post-section"> -->
        <div class="container">
            <div class="row mt-4">
                <h2 class="text-center explore-heading ">Brenda's Blogs & Videos</h2>
                @if(empty($blog_post))
                <p class="card-text">Data not available.</p>
                @endif
                @foreach($blog_post as $post)
                <?php

                $img  = explode(',', $post->image);
                ?>
                @if($post->posted_by=="admin")
                <div class="col-lg-3 col-md-4 col-sm-6 blog-box ">
                    <a href="{{route('blogPostSingle',$post->slug)}}">
                        <div class="card">
                            @if(isset($post->image))
                            <img class="card-img-top" src="{{asset('images_blog_img')}}/{{$img[0]}}" alt="img...">
                            @else
                            <img class="card-img-top" src="{{asset('images_blog_img/1688636936.jpg')}}" alt="img...">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{$post->title}}</h5>
                                <p class="card-title">
                                    <?php
                                    $givenTime = strtotime($post->created_at);
                                    $currentTimestamp = time();
                                    $timeDifference = $currentTimestamp - $givenTime;

                                    $days = floor($timeDifference / (60 * 60 * 24));
                                    $hours = floor(($timeDifference % (60 * 60 * 24)) / (60 * 60));
                                    $minutes = floor(($timeDifference % (60 * 60)) / 60);
                                    $seconds = $timeDifference % 60;

                                    $timeAgo = "";
                                    if ($days > 0) {
                                        if ($days == 1) {
                                            $timeAgo .= $days . " day ago";
                                        }else {
                                            $timeAgo .= $days . " days ago";
                                        }
                                    }else { $timeAgo .= " Posted today ";}

                                    // if ($days > 0) {
                                    //     $timeAgo .= $days . " days ";
                                    // }
                                    // if ($hours > 0) {
                                    //     $timeAgo .= $hours . " hr ";
                                    // }
                                    // if ($minutes > 0) {
                                    //     $timeAgo .= $minutes . " min ";
                                    // }
                                    // $timeAgo .= $seconds . " sec ago";

                                    echo $timeAgo;
                                    ?>
                                </p>
                                <!-- <p class="card-text content-box">{!! $post->content !!}</p> -->
                                <div class="d-flex justify-content-center">
                                    <a href="{{route('blogPostSingle',$post->slug)}}" class="btn blog-read-button">Read More</a>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @endif
                @endforeach
            </div>
            <div class="text-center">
                <a href="{{route('blog.admin.blog')}}" class="btn fields-search text-center">View All</a>
            </div>

        </div>
    </section>

    <section id="video-section" class="mt-5 mb-5">
        <div class="container">
            <div class="row">
                @foreach($video as $vid)
                <div class="col-lg-2 col-md-4 col-sm-6 col-12 columnJoblistig mb-3">
                    <a href="{{route('single.video', $vid->id)}}">
                        <!-- <a href="{{route('single.test.video', $vid->id)}}"> -->
                        <div class="thumb-video-box">
                            <div class="thumbnail-container">
                                <!-- <img class="thumbnail-image" src="{{asset('video_short')}}/{{$vid->image}}" alt="Video Thumbnail"> -->
                                <video class="thumbnail-video" loop muted playsinline="playsinline" poster="https://www.finderspage.com/public/{{$vid->image}}">
                                    <source src="{{ asset('video_short') }}/{{ $vid->video }}" type="video/mp4">
                                    <source src="{{ asset('video_short') }}/{{ $vid->video }}" type="video/webm">
                                    <source src="{{ asset('video_short') }}/{{ $vid->video }}" type="video/mov">
                                </video>
                            </div>
                            <div class="thumbnail-caption">
                                <h6 class="mb-0">{{$vid->title}}</h6>
                                @if(!empty($vid->location))
                                <div>
                                    <p style="font-size: 8px; margin-top: 5px;">
                                        <i class="fa fa-map-marker" aria-hidden="true"></i>
                                        {{ $vid->location }}
                                    </p>
                                </div>
                                @endif
                                
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
                <div class="text-center">
                    <a href="{{route('admin-video')}}" class="btn fields-search text-center">View All</a>
                </div>
            </div>
        </div>
    </section>
    <!-- <section id="search-section" style="padding-top: 20px; margin-top: 20px;">
    <div class="container">
        <div class="row mt-2">
                  <h2 class="text-center explore-heading ">Find a Post by Category</h2>
                <div class="col home-post-cat">
                   <a href="{{route('job_listing')}}">
                    <div class="box-part">
                        <div class="image">
                            <img src="{{asset('new_assets/assets/images/job.png')}}" alt="Image" class="img-fluid">
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
                            <img src="{{asset('new_assets/assets/images/real-state.png')}}" alt="Image" class="img-fluid">
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
                            <img src="{{asset('new_assets/assets/images/community.png')}}" alt="Image" class="img-fluid">
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
                            <img src="{{asset('new_assets/assets/images/shopping.png')}}" alt="Image" class="img-fluid">
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
                                <img src="{{asset('new_assets/assets/images/shopping.png')}}" alt="Image" class="img-fluid">
                            </div>
                            <h5>Services</h5>
                            <div class="right-arrow">
                                <i class="bi bi-arrow-right"></i>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col home-post-cat">
                    <a href="{{route('event')}}">
                        <div class="box-part">
                            <div class="image">
                                <img src="{{asset('new_assets/assets/images/shopping.png')}}" alt="Image" class="img-fluid">
                            </div>
                            <h5>Events</h5>
                            <div class="right-arrow">
                                <i class="bi bi-arrow-right"></i>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col home-post-cat">
                    <a href="#">
                        <div class="box-part">
                            <div class="image">
                                <img src="{{asset('new_assets/assets/images/shopping.png')}}" alt="Image" class="img-fluid">
                            </div>
                            <h5>Fundraiser</h5>
                            <div class="right-arrow">
                                <i class="bi bi-arrow-right"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>  
    </div>
</section> -->
    <!-- <section id="our-team" class="mt-5 mb-5">
    <div class="container">
        <h2 class="text-center mb-3">Our Team</h2>
        <div class="row">
            <div class="col-lg-3 team-profile mb-5">
                    <img src="https://finder.harjassinfotech.org/public/front/images/team-member.png" class="img-fluid">
                    <div class="short-info">
                        <div class="team-name">
                           <h4>John Doe</h4>
                           <p>Chief Financial Officer</p>
                        </div>
                        <div class="team-social-link">
                            <ul>
                                <li><i class="fa-brands fa-facebook-f"></i></li>
                                <li><i class="fa-brands fa-linkedin-in"></i></li>
                            </ul>
                        </div>
                    </div>
                </div>
            <div class="col-lg-3 team-profile mb-5">
                    <img src="https://finder.harjassinfotech.org/public/front/images/team-member.png" class="img-fluid">
                    <div class="short-info">
                        <div class="team-name">
                           <h4>John Doe</h4>
                           <p>Chief Financial Officer</p>
                        </div>
                        <div class="team-social-link">
                            <ul>
                                <li><i class="fa-brands fa-facebook-f"></i></li>
                                <li><i class="fa-brands fa-linkedin-in"></i></li>
                            </ul>
                        </div>
                    </div>
                </div>
            <div class="col-lg-3 team-profile mb-5">
                    <img src="https://finder.harjassinfotech.org/public/front/images/team-member.png" class="img-fluid">
                    <div class="short-info">
                        <div class="team-name">
                           <h4>John Doe</h4>
                           <p>Chief Financial Officer</p>
                        </div>
                        <div class="team-social-link">
                            <ul>
                                <li><i class="fa-brands fa-facebook-f"></i></li>
                                <li><i class="fa-brands fa-linkedin-in"></i></li>
                            </ul>
                        </div>
                    </div>
                </div>
            <div class="col-lg-3 team-profile mb-5">
                    <img src="https://finder.harjassinfotech.org/public/front/images/team-member.png" class="img-fluid">
                    <div class="short-info">
                        <div class="team-name">
                           <h4>John Doe</h4>
                           <p>Chief Financial Officer</p>
                        </div>
                        <div class="team-social-link">
                            <ul>
                                <li><i class="fa-brands fa-facebook-f"></i></li>
                                <li><i class="fa-brands fa-linkedin-in"></i></li>
                            </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> -->
    <!-- <section id=" Our-testimonials" class="mb-2 mt-3">

  
<section class="testimonials">
	<div class="container">
        <h3 style="text-align: center;">Our Testimonials</h3>
      <div class="row">
        <div class="col-sm-12">
          <div id="customers-testimonials" class="owl-carousel">

            
            <div class="item">
              <div class="shadow-effect">
                <img class="img-circle" src="http://themes.audemedia.com/html/goodgrowth/images/testimonial3.jpg" alt="">
                <p>Dramatically maintain clicks-and-mortar solutions without functional solutions. Completely synergize resource taxing </p>
                <div class="testimonial-name">EMILIANO AQUILANI</div>
              </div>
            </div>
           
            <div class="item">
              <div class="shadow-effect">
                <img class="img-circle" src="http://themes.audemedia.com/html/goodgrowth/images/testimonial3.jpg" alt="">
                <p>Dramatically maintain clicks-and-mortar solutions without functional solutions. Completely synergize resource taxing </p>
                <div class="testimonial-name">ANNA ITURBE</div>
              </div>
            </div>
            
            <div class="item">
              <div class="shadow-effect">
                <img class="img-circle" src="http://themes.audemedia.com/html/goodgrowth/images/testimonial3.jpg" alt="">
                <p>Dramatically maintain clicks-and-mortar solutions without functional solutions. Completely synergize resource taxing </p>
                <div class="testimonial-name">LARA ATKINSON</div>
              </div>
            </div>
            
            <div class="item">
              <div class="shadow-effect">
                <img class="img-circle" src="http://themes.audemedia.com/html/goodgrowth/images/testimonial3.jpg" alt="">
                <p>Dramatically maintain clicks-and-mortar solutions without functional solutions. Completely synergize resource taxing </p>
                <div class="testimonial-name">IAN OWEN</div>
              </div>
            </div>
            
            <div class="item">
              <div class="shadow-effect">
                <img class="img-circle" src="http://themes.audemedia.com/html/goodgrowth/images/testimonial3.jpg" alt="">
                <p>Dramatically maintain clicks-and-mortar solutions without functional solutions. Completely synergize resource taxing </p>
                <div class="testimonial-name">MICHAEL TEDDY</div>
              </div>
            </div>
           
          </div>
        </div>
      </div>
      </div>
    </section>
    
</section> -->




    @endsection