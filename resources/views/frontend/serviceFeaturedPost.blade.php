<?php
use App\Models\UserAuth;
use App\Models\Setting;
?>
@if($servicefeaturedPost->isNotEmpty())
    <h4 class="text-center pb-1">Services </h4>
    <div class="container">
        <div class="row">
            @foreach($servicefeaturedPost as $feature)
            <?php
            // echo "<pre>";print_r($feature); 
            ?>
            <div class="col-lg-2 col-md-4 col-sm-12 col-6">
                <div class="feature-box">
                    @if($feature->available_now==1)
                        <div class="ring-container1">
                            <!-- <span>Available Now</span> -->
                            <div class="av-now">Available</div>
                            <!-- <div class="circle"></div> -->
                        </div>
                    @endif
                    
                    <span class="onsale">Featured!</span>
                    <a href="{{ route('service_single', $feature->slug) }}">
                        <div class="img-area">
                            <?php
                            $neimg = trim($feature->image1, '[""]');
                            $img  = explode('","', $neimg);
                            ?>
                            @if($feature->image1)
                                <img src="{{ asset('images_blog_img/' . $img[0]) }}" alt="{{ $feature->title }}" class="d-block w-100">
                            @else
                                <img src="{{ asset('images_blog_img/1688636936.jpg') }}" alt="New York" class="d-block w-100">
                            @endif
                        </div>

                        <div class="job-post-content">
                            <p class="job-title"><b>{{ ucfirst($feature->title) }}</b></p>
                            <div class="main-days-frame">
                                <span class="days-box"> 
                                    <?php
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
                                    } else {
                                        $timeAgo .= "Posted today"; 
                                    }

                                    echo $timeAgo;
                                    ?>
                                </span>
                            </div>
                        </div>
                    </a>
                    <div class="button-sell" style="margin-top: 0px;">
                        <span><a href="{{ route('service_single', $feature->slug) }}" class="btn create-post-button" data-product-id="{{ $feature->id }}">View details</a></span>
                    </div>
                </div>
            </div>
            @endforeach

            <div class="col-lg-12 text-center">
                <a href="{{ route('servicViewAll') }}" class="btn fields-search">View All</a>
            </div>
        </div>
    </div>
@endif
