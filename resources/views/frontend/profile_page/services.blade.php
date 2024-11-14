<?php
use App\Models\UserAuth;
?>
@extends('layouts.frontlayout')
@section('content')

<section class="job-listing">
    <div class="container">
        <div class="row" style="display: flex; justify-content:end; margin-right: 4px;">
            <button type="button" class="btn filterBTN">Filters</button>
        </div>
        <div class="row">
            <div class="col-md-4 col-lg-3" id="FiltersJob">
                <div class="closeIcon"><i class="fa fa-close"></i></div>
                <div class="left-side-bar">
                    <div class="job-search-box">
                        <h5>Services type</h5>
                        <div class="form-check mb-3">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="service_type" value="706"> Automotive 
                            </label><br>
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="service_type" value="707"> Beauty
                            </label><br>
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="service_type" value="708"> Cell phone / Mobile
                            </label><br>
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="service_type" value="709"> Computer
                            </label><br>
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="service_type" value="710"> Creative
                            </label><br>
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="service_type" value="711"> Farm & Garden
                            </label><br>
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="service_type" value="712"> Financial
                            </label><br>
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="service_type" value="713"> Health/ Wellness
                            </label>
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="service_type" value="716"> Holistic medicine
                            </label>
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="service_type" value="714"> Household
                            </label>
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="service_type" value="715"> Labor / Hauling / Moving
                            </label>
                             <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="service_type" value="717"> Legal cannabis only
                            </label>
                             <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="service_type" value="718"> Lessons & Tutoring
                            </label><br>

                             <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="service_type" value="719"> Marine
                            </label><br>

                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="service_type" value="721"> Skilled trade
                            </label>
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="service_type" value="722"> Travel/ Vacation
                            </label>
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="service_type" value="723"> Writing/ Editor
                            </label>

                        </div>

                    </div>
                    <div class="job-search-box mt-2">
                        <h5>Date Posted</h5>
                        <div class="form-check mb-3">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="postDate" value="1"> one days ago
                            </label><br>
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="postDate" value="3">Last 3 days
                            </label><br>
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="postDate" value="7">Last 7 days
                            </label>
                        </div>

                    </div>
                    <div class="job-search-box mt-2">
                        <div class="filter-check">
                            <span><a href="">Reset</a></span><span><a class="service_filter" href="#">Apply</a></span>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-8 col-lg-9 mt-2">
                <div class="row related-job filterRes">
             @foreach($matchRecords as $Records)  
                    <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                        
                            <div class="feature-box">

                                @foreach($existingRecord as $saved)
                            @if($saved->post_id == $Records->id && $saved->user_id == UserAuth::getLoginId())
                                <div data-postid="{{$Records->id}}" data-Userid="{{UserAuth::getLoginId()}}" class="save-btn saved_post_btn" title="Save"><i class="fa fa-check" aria-hidden="true"></i>  Saved</i></div>
                            @else
                                <div data-postid="{{$Records->id}}" data-Userid="{{UserAuth::getLoginId()}}" class="save-btn saved_post_btn" title="Save">Save</div>
                            @endif
                            @endforeach
                                
                                <a href="{{route('service_single',$Records->id)}}">
                                <div id="demo-new" class="carousel1 slide">
                                    <!-- Indicators/dots -->
                                    <!-- The slideshow/carousel -->
                                    <div class="carousel-inner">
                                        <?php
                                            $itemFeaturedImages = trim($Records->image1,'[""]');
                                            $itemFeaturedImage  = explode('","',$itemFeaturedImages);
                                            if(is_array($itemFeaturedImage)) {
                                                foreach($itemFeaturedImage as $keyitemFeaturedImage => $valueitemFeaturedImage) { if($keyitemFeaturedImage == 0) {$class='active'; } else { $class='in-active'; } ?>
                                                        <div class="carousel-item <?= $class; ?>">
                                                            <img src="{{asset('images_blog_img')}}/{{ $valueitemFeaturedImage }}" alt="Los Angeles" class="d-block w-100" onerror="this.onerror=null; this.src='https://finder.harjassinfotech.org/public/images_blog_img/1688636936.jpg';">
                                                        </div>
                                                <?php }     
                                            }
                                        ?>
                                    </div>
                                </div>
                                
                                <div class="job-post-content">
                                    <h4><b>{{$Records->title}}</b></h4>
                                    
                                    <div class="job-type">
                                        <ul class="job-list">
                                            <div class="main-days-frame">
                                                    <span class="days-box"> 
                                                    <?php
                                                        $givenTime = strtotime($Records->created);
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
                                                            

                                                            echo $timeAgo;
                                                        ?>

                                                    </span>
                                                </div>
                                            
                                            
                                        </ul>
                                    </div>
                                </div>
                                </a>
                            </div>
                        
                    </div>
                @endforeach
            </div>
        </div>
        
    </div>
</section>
<script type="text/javascript">
    jQuery(document).ready(function() {
         $(".service_filter").on("click", function(e) {
            e.preventDefault();

            var service_type = $('input[name="service_type"]:checked').val();
            var postDate = $('input[name="postDate"]:checked').val();

            // alert(service_type);
            // alert(min_price);
            // alert(max_price);
                var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                $.ajax({
                    url: site_url+'/service/filter',
                    type: 'POST',
                    headers: {
                      'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        service_types: service_type,
                        postDate: postDate
                        
                    },
                    success: function(response) {
                      console.log(response);
                         $(".filterRes").html(response);
                    },
                    error: function(xhr, status, error) {
                      console.log(xhr.responseText);
                    }
                  });
        });
    });
</script>
@endsection