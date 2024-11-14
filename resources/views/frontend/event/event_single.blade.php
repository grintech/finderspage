<?php use App\Models\UserAuth; ?>
@extends('layouts.frontlayout')
@section('content')
<style>
#job-post .job-type ul li {
    display: inline-flex;
    background-color: #fff;
    margin: 7px 0px;
    padding: 6px 7px;
    border-radius: 5px;
    color: #000;
    box-shadow: 0px 1px 7px #ddd;
    font-size: 12px;
    font-weight: 500;
}
#job-post .job-post-imges .carousel-item img {
    height: 190px;
}
#job-post .job-post-apply {
    display: block;
    justify-content: end;
    align-items: center;
    margin-top: 0;
}
#job-post .job-post-apply a.apply {
    background: rgb(170,137,65);
    background: linear-gradient(90deg, rgba(170,137,65,1) 0%, rgba(205,156,49,1) 13%, rgba(154,128,73,1) 35%, rgba(246,204,78,1) 51%, rgba(181,147,56,1) 75%, rgba(163,136,68,1) 100%);
    margin-top: 0px;
    margin-right: 5px;
    padding: 6px 10px;
    border-radius: 27px;
    border: 0px;
    box-shadow: none;
    color: #000 !important;
    font-size: 13px;
    font-weight: 600;
}
.save-post {
    font-size: 13px;
}
</style>

<?php 
$itemFeaturedImages = trim($blog->image1,'[""]');
$itemFeaturedImage  = explode('","',$itemFeaturedImages);
$count =  count($itemFeaturedImage);
?>
<section id="job-post">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="job-post-imges">
                    <?php
                        if(is_array($itemFeaturedImage)) {
                            foreach($itemFeaturedImage as $keyitemFeaturedImage => $valueitemFeaturedImage) { if($keyitemFeaturedImage == 0) {$class='active'; } else { $class='in-active'; } ?>
                                    <div class="front-cover-img <?= $class; ?>">
                                        <img src="{{asset('images_blog_img')}}/{{ $valueitemFeaturedImage }}" alt="{{ $blog->title }}" class="d-block w-100" >
                                    </div>
                            <?php }     
                        }
                    ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-md-8">
                <div class="bg-white" style="padding: 20px;margin-top: 0px;border-radius: 10px;">
                    <div class="job-post-header">
                        <div class="row">
                            
                        <!-- <div class="col-lg-3 col-md-3">
                            <div class="job-post-imges">
                            <div id="demo" class="carousel slide" data-bs-ride="carousel">
                                    
                                    <div class="carousel-inner">
                                        <?php
                                            if(is_array($itemFeaturedImage)) {
                                                foreach($itemFeaturedImage as $keyitemFeaturedImage => $valueitemFeaturedImage) { if($keyitemFeaturedImage == 0) {$class='active'; } else { $class='in-active'; } ?>
                                                        <div class="carousel-item <?= $class; ?>">
                                                            <a href="{{asset('images_blog_img')}}/{{ $valueitemFeaturedImage }}" data-lightbox="carousel">
                                                                <img src="{{asset('images_blog_img')}}/{{ $valueitemFeaturedImage }}" alt="{{ $blog->title }}" class="d-block w-100"  onerror="this.onerror=null; this.src='https://finder.harjassinfotech.org/public/images_blog_img/1688636936.jpg';">
                                                            </a>
                                                        </div>
                                                <?php }     
                                            }
                                        ?>
                                        
                                    
                                        @if($blog->post_video) 
                                            <div class="carousel-item">
                                            <a href="{{asset('images_blog_video')}}/{{$blog->post_video}}" data-lightbox="carousel">
                                                <video width="320" height="240" controls class="d-block w-100">
                                                <source src="{{asset('images_blog_video')}}/{{$blog->post_video}}" type="video/mp4">
                                                </video>
                                            </a>
                                            </div>
                                        @endif
                                    
                                  
                                    </div>
                                    @if($count > 1)
                                    <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon"></span>
                                    </button>

                                    <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
                                        <span class="carousel-control-next-icon"></span>
                                    </button>
                                    @endif
                            </div>
                            <div class="lightbox-overlay">
                                <img class="lightbox-img" src="" alt="">
                            </div>
                            <div class="job-type job-p mt-1" style="display:none;">
                                <?php
                                        if ($blog->post_by == 'admin') {
                                            foreach ($admins as $add) {
                                                if ($blog->user_id == $add->id) {
                                                    $adminId = $add->id;
                                                     $userName = $add->first_name;
                                                     $userNumber = '';
                                                     $facebook = '';
                                                     $twitter = '';
                                                     $instagram = '';
                                                     $linkedin = '';
                                                     $linkedin = '';   
                                                     $youtube = '';   
                                                     $whatsapp = ''; 
                                                     $Tiktok = '';
                                                    echo '<img src="' . asset($add->image) . '" alt="Image">';
                                                    echo '<p>' . $blog->title . '<br><small>By ' . $add->first_name . '</small></p>';
                                                }
                                            }
                                        } else {
                                            // Assuming $users is an array or collection
                                            foreach ($users as $user) {
                                                if ($blog->user_id == $user->id) {
                                                    $userId = $user->id;
                                                     $userName = $user->first_name;
                                                     $userNumber = $user->phonenumber;
                                                     $facebook = $user->facebook;
                                                     $twitter = $user->twitter;
                                                     $instagram = $user->instagram;
                                                     $linkedin = $user->linkedin;
                                                     $linkedin = $user->linkedin;   
                                                     $youtube = $user->youtube;   
                                                     $whatsapp = $user->whatsapp; 
                                                     $Tiktok = $user->Tiktok;
                                                    echo '<img src="' . asset('assets/images/profile') . '/' . $user->image . '" alt="Image">';
                                                    echo '<p>' . $blog->title . '<br><small>By ' . $user->first_name . '</small></p>';
                                                }
                                            }
                                        }
                                        ?>
                            </div> 

                            </div>
                        </div> -->
                        <div class="col-lg-9 col-md-9">
                            <div class="job-post-content">
                                <h2 class="mb-0">{{$blog->title}}</h2>
                                <span class="event-date-time">SEP 30 AT 11:30 AM</span>
                                <div class="job-type">
                                    <ul class="job-list">
                                        <li><span><i class="bi bi-cash"></i></span>${{ ucfirst($blog->rate) }}</li>
                                        
                                      <li><span><i class="bi bi-clock-fill"></i></span>{{$blog->event_start_time}}  To {{$blog->event_end_time}}</li>

                                      <li><span><i class="bi bi-calendar-check"></i></span>{{$blog->event_start_date}}</li>

                                        @if($blog->service_end_time != null)
                                            <li><span><i class="bi bi-alarm"></i></span>{{$blog->service_start_time}} - {{$blog->service_end_time}}</li>
                                        @endif
                                        
                                        @if($blog->personal_detail == 'true')
                                            <li><span><i class="bi bi-phone"></i></span><a href="tel:{{$blog->phone}}" target="_blank;">{{$blog->phone}}</a></li>
                                            
                                            <li><span><i class="bi bi-globe"></i></span><a href="{{$blog->website}}" target="_blank">{{$blog->website}}</a></li>
                                            
                                            <li><span><i class="bi bi-map"></i></span>{{$blog->address}}</li>



                                        @endif
                                    </ul>
                                    
                                    
                                </div>
                                <div class="job-type">
                                    <!-- <ul>
                                        <li>Full Time</li>
                                        <li>Private </li>
                                        <li>Urgent</li>
                                    </ul> -->
                                </div>
                            </div>
                        </div>
                         <hr>
                        <div class="job-detail pt-2 mt-2">
                                <h4>Event Description</h4>
                                {{-- <?php $cleanString = strip_tags($blog->description); ?> --}}
                                <p>{!! $blog->description !!}</p>
                            </div>
                    </div>
                </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4">
                

                <div class="Serivce-right-sidebar bg-white">
                    
                    <div class="job-overview" style="padding: 20px;">
                        <h4>Event Overview</h4>
                        <ul class="job-overview-new">
                            <?php
                               $timestamp = strtotime($blog->created);
                                $current_time = time();
                                $time_difference = $current_time - $timestamp;
                                $hours_ago = floor($time_difference / 3600);
                                $time_ago = $hours_ago . " hours ago";
                                
                            ?>
                            <li><i class="bi bi-calendar-check"></i><h6>Date Posted:</h6><span>Posted {{$time_ago}} </span></li>
                            
                           

                                <li><i class="bi bi-geo-alt"></i> <h6>Location:</h6><span>
                                    {{$blog->address}}
                                </span></li>
                                @if($blog->personal_detail == 'true')
                                <li><i class="bi bi-telephone-fill"></i><h6>Phone:</h6><span><a href="tel:{{$userNumber}}" target="_blank;">{{$userNumber}}</a></span></li>

                                <li><i class="bi bi-people"></i> <h6>Event Title:</h6><span>{{$blog->title}}</span></li>
                            
                                <li><i class="bi bi-tags-fill"></i><h6>Charges:</h6><span>${{ ucfirst($blog->rate) }}</span></li>

                                <!-- <li><i class="bi bi-card-checklist"></i><h6 style="margin-bottom: 10px;">Follow Us:</h6>
                                    
                                    @if($blog->facebook) 
                                        <a href="{{$facebook}}" target="_blank" class="facebook"><i style="position: inherit;" class="fab fa-facebook-f" aria-hidden="true"></i></a>
                                    @else 
                                        <a href="https://www.facebook.com" target="_blank" class="facebook"><i style="position: inherit;" class="fab fa-facebook-f" aria-hidden="true"></i></a>
                                    @endif

                                    @if($blog->linkedin) 
                                        <a href="{{$linkedin}}" target="_blank" class="linkedin"><i style="position: inherit;" class="fab fa-linkedin-in" aria-hidden="true"></i></a>
                                    @else 
                                        <a href="https://www.linkedin.com" target="_blank" class="linkedin"><i style="position: inherit;" class="fab fa-linkedin-in" aria-hidden="true"></i></a>
                                    @endif
                                    
                                    @if($blog->instagram)
                                        <a href="{{$instagram}}" target="_blank" class="instagram"><i style="position: inherit;" class="fab fa-instagram" aria-hidden="true"></i></a>
                                    @else
                                        <a href="https://www.instagram.com" target="_blank" class="instagram"><i style="position: inherit;" class="fab fa-instagram" aria-hidden="true"></i></a>
                                    @endif
                                    
                                    @if($blog->whatsapp)
                                        <a href="whatsapp://send?abid={{$whatsapp}}&text=Hello%2C%20World!" target="_blank"class="whatsapp"><i style="position: inherit;" class="fab fa-whatsapp" aria-hidden="true"></i></a>
                                    @else
                                        <a href="whatsapp://send?abid=9898989898&text=Hello%2C%20World!" target="_blank"class="whatsapp"><i style="position: inherit;" class="fab fa-whatsapp" aria-hidden="true"></i></a>
                                    @endif
                                    
                                    @if($blog->youtube)
                                        <a href="{{$youtube}}" target="_blank" class="youtube"><i style="position: inherit;" class="fab fa-youtube" aria-hidden="true"></i></a> 
                                    @else
                                        <a href="https://www.youtube.com" target="_blank" class="youtube"><i style="position: inherit;" class="fab fa-youtube" aria-hidden="true"></i></a>
                                    @endif
                                    @if($blog->Tiktok)
                                        <a href="{{$Tiktok}}" target="_blank" class="Tiktok"><i style="position: inherit;" class="bi bi-tiktok" aria-hidden="true"></i></a> 
                                    @else
                                        <a href="https://www.youtube.com" target="_blank" class="Tiktok"><i style="position: inherit;" class="bi bi-tiktok" aria-hidden="true"></i></a>
                                    @endif
                                    
                                </li> -->
                            @endif
                            
                            
                            <li>
                                 <div class="job-post-apply single-job-apply">
                                   @if ($blog->post_by == 'admin')
                                    <a target="blank" href="{{route('UserProfileFrontend', $adminId)}}" class="save-post" >View Profile</a>
                                    @else
                                     <a target="blank" href="{{route('UserProfileFrontend', $userId)}}" class="save-post" >View Profile</a>
                                    @endif
                                <a data-postid="{{$blog->id}}" data-Userid="{{UserAuth::getLoginId()}}" class="saved_post_btn save-post" title="Save"  href="javascript:void();" >Save</a>
                                 </div>
                            </li>
                        </ul>
                    </div>

                    <div class="job-locatin" style="padding: 20px;">
                        <h4>Event Location</h4>
                        <div class="responsive-map">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2822.7806761080233!2d-93.29138368446431!3d44.96844997909819!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x52b32b6ee2c87c91%3A0xc20dff2748d2bd92!2sWalker+Art+Center!5e0!3m2!1sen!2sus!4v1514524647889" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
                        </div>
                    </div>
                    
                   <!--  <div class="job-skill">
                        <h5>Serivce Skills</h5>
                        <a href="">app</a><a href="">administrative</a><a href="">android</a>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</section>
<section class="job-post-description mt-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="share-job mb-2" style="display:none;">
                    <h5>Follow Us</h5>
                    
                    @if($blog->facebook) 
                        <a href="{{$blog->facebook}}" target="_blank" class="facebook"><i class="fab fa-facebook-f" aria-hidden="true"></i>Facbook</a>
                    @else 
                        <a href="https://www.facebook.com" target="_blank" class="facebook"><i class="fab fa-facebook-f" aria-hidden="true"></i>Facbook</a>
                    @endif


                    @if($blog->linkedin) 
                        <a href="{{$blog->linkedin}}" target="_blank" class="linkedin"><i class="fab fa-linkedin-in" aria-hidden="true"></i>linkedin</a>
                    @else 
                        <a href="https://www.linkedin.com" target="_blank" class="linkedin"><i class="fab fa-linkedin-in" aria-hidden="true"></i>linkedin</a>
                    @endif
                    
                    @if($blog->instagram)
                        <a href="{{$blog->instagram}}" target="_blank" class="instagram"><i class="fab fa-instagram" aria-hidden="true"></i>instagram</a>
                    @else
                        <a href="https://www.instagram.com" target="_blank" class="instagram"><i class="fab fa-instagram" aria-hidden="true"></i>instagram</a>
                    @endif
                    
                    @if($blog->whatsapp)
                        <a href="whatsapp://send?abid={{$blog->whatsapp}}&text=Hello%2C%20World!" target="_blank"class="whatsapp"><i class="fab fa-whatsapp" aria-hidden="true"></i>Whatsapp</a>
                    @else
                        <a href="whatsapp://send?abid=9898989898&text=Hello%2C%20World!" target="_blank"class="whatsapp"><i class="fab fa-whatsapp" aria-hidden="true"></i>Whatsapp</a>
                    @endif
                    
                    @if($blog->youtube)
                        <a href="{{$blog->youtube}}" target="_blank" class="youtube"><i class="fab fa-youtube" aria-hidden="true"></i>Youtube</a> </div> 
                    @else
                        <a href="https://www.youtube.com" target="_blank" class="youtube"><i class="fab fa-youtube" aria-hidden="true"></i>Youtube</a> </div> 
                    @endif
            <div class="related-new-job mt-2 text-center mb-5"><h3>Related Events</h3></div>
    <div class="row related-job"> 
        <div class="col-lg-12 col-md-12">
            <div class="job-post-header"> 
                <div class="row"> 
                 @foreach($related_event as $RService)  
                    <div class="col-lg-2 col-md-3 col-sm-6 col-6">
                        
                            <div class="feature-box">

                               @foreach($existingRecord as $saved)
                                                @if($saved->post_id == $RService->id && $saved->user_id == UserAuth::getLoginId())
                                                    <div data-postid="{{$RService->id}}" data-Userid="{{UserAuth::getLoginId()}}" class="save-btn saved_post_btn" title="Save"><i class="fa fa-check" aria-hidden="true"></i>  Saved</i></div>
                                                @else
                                                    <div data-postid="{{$RService->id}}" data-Userid="{{UserAuth::getLoginId()}}" class="save-btn saved_post_btn" title="Save">Save</div>
                                                @endif
                                                @endforeach
                                <a href="{{route('service_single',$RService->id)}}">
                                <div id="demo-new" class="carousel1 slide">
                                    <!-- Indicators/dots -->
                                    <!-- The slideshow/carousel -->
                                    <div class="carousel-inner">
                                        <?php
                                            $itemFeaturedImages = trim($RService->image1,'[""]');
                                            $itemFeaturedImage  = explode('","',$itemFeaturedImages);
                                            if(is_array($itemFeaturedImage)) {
                                                foreach($itemFeaturedImage as $keyitemFeaturedImage => $valueitemFeaturedImage) { if($keyitemFeaturedImage == 0) {$class='active'; } else { $class='in-active'; } ?>
                                                        <div class="carousel-item <?= $class; ?>">
                                                            <img src="{{asset('images_blog_img')}}/{{ $valueitemFeaturedImage }}" alt="Los Angeles" class="d-block w-100" onerror="this.onerror=null; this.src='https://finderspage.com/public/images_blog_img/1688636936.jpg';">
                                                        </div>
                                                <?php }     
                                            }
                                        ?>
                                    </div>
                                </div>
                                
                                <div class="job-post-content">
                                    <h4><b>{{$RService->title}}</b></h4>
                                    
                                    <div class="job-type">
                                        <ul class="job-list">
                                            <div class="main-days-frame">
                                                    <span class="location-box">
                                                       
                                                    </span>
                                               
                                                    <span class="days-box"> 
                                                    <?php
                                                        $givenTime = strtotime($RService->created);
                                                        $currentTimestamp = time();
                                                        $timeDifference = $currentTimestamp - $givenTime;

                                                        $days = floor($timeDifference / (60 * 60 * 24));
                                                        $hours = floor(($timeDifference % (60 * 60 * 24)) / (60 * 60));
                                                        $minutes = floor(($timeDifference % (60 * 60)) / 60);
                                                        $seconds = $timeDifference % 60;

                                                        $timeAgo = "";
                                                            if ($days > 0) {
                                                                $timeAgo .= $days . " Days Ago ";
                                                            }else{
                                                               $timeAgo .= "Today"; 
                                                            }
                                                            
                                                            // if ($minutes > 0) {
                                                            //     $timeAgo .= $minutes . " min, ";
                                                            // }
                                                            // $timeAgo .= $seconds . " sec ago";

                                                            echo $timeAgo;
                                                        ?>

                                                    </span>
                                                </div>
                                            
                                            
                                        </ul>
                                    </div>
                                </div>


                                <div class="job-type job-hp">
                                    <?php
                                        if ($RService->post_by == 'admin') {
                                            foreach ($admins as $add) {
                                                if ($RService->user_id == $add->id) {
                                                    echo '<img src="' . asset($add->image) . '" alt="Image">';
                                                    echo '<p>' . $RService->title . '<br><small>By ' . $add->first_name . '</small></p>';
                                                }
                                            }
                                        } else {
                                            // Assuming $users is an array or collection
                                            foreach ($users as $user) {
                                                if ($RService->user_id == $user->id) {
                                                    echo '<img src="' . asset('assets/images/profile') . '/' . $user->image . '" alt="Image">';
                                                    echo '<p>' . $RService->title . '<br><small>By ' . $user->first_name . '</small></p>';
                                                }
                                            }
                                        }
                                    ?>
                                </div>
                                </a>
                            </div>
                        
                    </div>
                @endforeach
                    </div>
                </div>
            </div>
           <!--  <div class="col-lg-1 col-md-1">
                <div class="job-post-apply">
                    <span><a href="#"><i class="bi bi-save"></i></a></span>
                </div>
            </div> -->
        </div>
    </div>      
                         
        </div>
    </div>
</section>


<!------- Model Apply job--------->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Apply Now!</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body row">
            <div class="col-lg-6">
                 <div class="field">
                     <div class="control has-icons-left">
                         <input type="text" name="name" id="Name" class="input" placeholder="First Name">
                         <span class="icon is-left">
                         <i class="fa fa-user"></i>
                          </span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                 <div class="field">
                     <div class="control has-icons-left">
                         <input type="text" name="name" id="Name" class="input" placeholder="Last Name">
                         <span class="icon is-left">
                         <i class="fa fa-user"></i>
                          </span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                 <div class="field">
                     <div class="control has-icons-left">
                         <input type="email" name="email" id="email" class="input" placeholder="Email">
                         <span class="icon is-left">
                         <i class="fa fa-envelope"></i>
                          </span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                 <div class="field">
                     <div class="control has-icons-left">
                         <input type="tel" name="Number" id="email" class="input" placeholder="Phone Number">
                         <span class="icon is-left">
                         <i class="bi bi-telephone-fill"></i>
                          </span>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                 <div class="field">
                     <div class="control has-icons-left">
                         <input type="file" name="file" id="multiple" class="input resume">
                         <span class="icon is-left">
                         <i class="bi bi-cloud-upload"></i>
                          </span>
                    </div>
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="contact-from-button">Submit</button>
      </div>
    </div>
  </div>
</div>


@endsection