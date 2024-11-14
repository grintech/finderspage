<?php
use App\Models\UserAuth;
use App\Models\Setting;
?>
@if($realfeaturedPost->isNotEmpty())
<h4 class="text-center pb-1">Real Estate</h4>
    <div class="container">
        <div class="row">
                @foreach($realfeaturedPost as $feature)
                <?php
                 // echo "<pre>";print_r($feature); 
                ?>

                    <div class="col-lg-2 col-md-4 col-sm-12 col-12 element element-1">
                        <a href="{{route('real_esate_post',$feature->slug)}}">
                            <div class="feature-box">
                                 @if($feature->available_now == 1)
                                    <div class="ring-container1">
                                        <div class="av-now">Available</div>
                                    </div>
                                 @endif
                                <span class="onsale">Featured!</span>
                                 <?php $useid = UserAuth::getLoginId();?>
                                <div class="img-area">
                                    <?php
                                        $neimg = trim($feature->image1,'[""]');
                                        $img  = explode('","',$neimg);
                                    ?>
                                    @if($feature->image1)
                                        <img src="{{asset('images_blog_img')}}/{{$img[0]}}" alt="{{$feature->title}}" class="d-block w-100">
                                    @else
                                        <img src="{{ asset('images_blog_img/1688636936.jpg') }}" alt="New York" class="d-block w-100">
                                    @endif
                                
                                </div>
                                
                                <!-- <p><b>{{$feature->title}}</b></p> -->
                                
                                <div class="job-type">
                                    <ul>
                                        <li><b>{{$feature->title}}</b></li>
                                        <li><span>BHK</span>{{$feature->bedroom}} </li>
                                        <li><?php
                                                $givenTime = strtotime($feature->created);
                                                $currentTimestamp = time();
                                                $timeDifference = $currentTimestamp - $givenTime;

                                                $days = floor($timeDifference / (60 * 60 * 24));
                                                $hours = floor(($timeDifference % (60 * 60 * 24)) / (60 * 60));
                                                $minutes = floor(($timeDifference % (60 * 60)) / 60);
                                                $seconds = $timeDifference % 60;

                                                $timeAgo = "";
                                                    if ($days > 0) {
                                                        $timeAgo = Setting::get_formeted_time($days);
                                                    }else{
                                                        $timeAgo .= "Today"; 
                                                    }
                                                        echo $timeAgo;
                                                ?></li>
                                    </ul>
                                </div>
                                <div class="row overflow-section">
                                    <div class="button-sell" style="margin-top: 0px;">
                                        <span><a href="{{route('real_esate_post',$feature->slug)}}" class="btn create-post-button" data-product-id="{{$feature->id}}">View details</a></span>
                                    </div>
                                    <!-- <div class="review-section">
                                        <p>Review</p>
                                        <ul class="review">
                                            <li><i class="bi bi-star-fill"></i></li>
                                            <li><i class="bi bi-star-fill"></i></li>
                                            <li><i class="bi bi-star-fill"></i></li>
                                            <li><i class="bi bi-star-fill"></i></li>
                                            <li><i class="bi bi-star-half"></i></li>
                                        </ul>
                                    </div> -->
                                </div>
                            </div>
                        </a>
                    </div>
            
                   
                @endforeach
            
            <div class="col-lg-12 text-center" bis_skin_checked="1">
                <a href="{{route('realesteteViewAll')}}" class="btn fields-search">View All</a>
            </div>
        </div>
    </div>
@endif

    