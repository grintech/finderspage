<?php
use App\Models\UserAuth;
use App\Models\Setting;

?>
@if($businessFeaturedPost->isNotEmpty())
<h4 class="text-center pb-1">Business</h4>
    <div class="container">
        <div class="row">
                @foreach($businessFeaturedPost as $feature)
              <div class="col-lg-2 col-md-4 col-sm-12 col-12">
                <div class="element element-1">
                    <div class="feature-box">
                        <span class="onsale">Featured!</span>
                        <?php $useid = UserAuth::getLoginId();?>
                        <a href="{{route('business_page.front.single.listing', $feature->slug)}}">  
                            <div id="demo-new" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <?php
                                    $image = trim($feature->business_logo,'[""]');
                                    $img  = explode(',',$image);
                                    ?>
                                    @if($feature->business_logo)
                                        @foreach($img as $images)
                                            <img src="{{asset('business_img')}}/{{$images}}" alt="{{$feature->business_name}}" class="d-block w-100">
                                        @endforeach
                                    @else
                                        <img src="{{ asset('images_blog_img/1688636936.jpg') }}" alt="New York" class="d-block w-100">
                                    @endif
                                </div>
                            </div>
                            
                            <p class="job-title"><b>{{ ucfirst($feature->business_name) }}</b></p>
                            <div class="location-job-title">
                                <div class="job-type">
                                    <div class="main-days-frame">
                                        
                                        <span class="days-box"> 
                                        <?php
                                            $givenTime = strtotime($feature->created_at);
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
                            </div>
                            <div class="button-sell" style="margin-top: 0px;">
                                <span><a href="{{route('businessViewAll',$feature->slug)}}" class="btn create-post-button" data-product-id="{{$feature->id}}">View details</a></span>
                            </div>
                        </a>
                    </div>
                </div>
                </div> 
                @endforeach
            
            <div class="col-lg-12 text-center" bis_skin_checked="1">
                <a href="{{route('businessViewAll')}}" class="btn fields-search">View All</a>
            </div>
        </div>
    </div>
    @endif
<script type="text/javascript">  
$(".featured-slider1").slick({
    dots: false,
    arrows: true,
    slidesToShow: 6,
    infinite:true,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 2000,
    responsive: [
    {
        breakpoint: 1200,
        settings: {
            slidesToShow: 4
        }
    },
    {
        breakpoint: 1024,
        settings: {
            slidesToShow: 3
        }
    },
    {
        breakpoint: 800,
        settings: {
            slidesToShow: 2
        }
    },
    {
        breakpoint: 600,
        settings: {
            slidesToShow: 1
        }
    }
    ]
});

$(".idnamesix").each(function() {
    $(this).slick({
        arrows: true,
        slidesToShow: 1,
        infinite: true,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2000
    });
});


$("#idnamesevenfive").slick({
    arrows: true,
    slidesToShow: 1,
    infinite:true,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 2000
});

$("#idnamefour").slick({
    arrows: true,
    slidesToShow: 1,
    infinite:true,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 2000
});

$("#idnametwo").slick({
    arrows: true,
    slidesToShow: 1,
    infinite:true,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 2000
});

// Image Slider Demo:
// https://codepen.io/vone8/pen/gOajmOo
</script>
    