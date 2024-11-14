<?php
use App\Models\Admin\HomeSettings;
use App\Models\Admin\Testimonials;
use App\Models\UserAuth;

$testimonials = Testimonials::where('status', 1)->get();
?>
@extends('layouts.frontlayout')
@section('content')

<section id="shoplisting-page">
    <div class="container">
        <div class="row" style="display: flex; justify-content:end; margin-right: 4px;">
            <button type="button" class="btn filterBTN">Filters</button>
        </div>
        <div class="row">
            <div class="col-md-4 col-lg-3" id="FiltersJob">
                <div class="closeIcon"><i class="fa fa-close"></i></div>
                <div class="shoplisting-left-sidebar">
                    <h1 style="font-size: 17px;"><b>Event Search By Type</b></h1>
                    <div class="form-check mb-3">
                        <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="event_type" value="online">online
                            </label><br>
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="event_type" value="offline"> In person
                            </label><br>  
                    </div>
                   <div class="job-search-box mt-2">
                        <h5>Date Posted</h5>
                        <div class="form-check mb-3">
                            <label class="form-check-label">
                                <input class="form-check-input mydate" type="radio" name="days" value="1"> One day ago
                            </label><br>
                            <label class="form-check-label">
                                <input class="form-check-input mydate" type="radio" name="days" value="3">Last 3 days
                            </label><br>
                            <label class="form-check-label">
                                <input class="form-check-input mydate" type="radio" name="days" value="7">Last 7 days
                            </label>
                        </div>
                    </div>
                   <div class="new-price-range">
                    <label for="price-range" class="form-label">Price Range:</label>
                    <input type="range" class="form-range slider" min="0" max="10000" value="0" name="priceRange" id="price-range"  step="100"> <span  class="slider_label"></span>


                    <div class="job-search-box mt-2">
                        <div class="filter-check">
                            <span><a href="">Reset</a></span><span><a class="Shop_filter" href="#">Apply</a></span>
                            <div class="lds-dual-ring d-none"></div>

                        </div>

                    </div>
                 </div>
                </div>
            </div>
            <div class="col-md-8 col-lg-9">

                <div class="row related-job">
                    <div class="col-lg-12 col-md-12">
                        <div class="job-post-header">
                            <div class="row filterRes">
                                @foreach($matchingRecords as $record)
                                <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                                    
                                        <div class="feature-box">
                                            <!-- <div data-postid="{{$record->id}}" data-Userid="{{UserAuth::getLoginId()}}" class="save-btn saved_post_btn" title="Save"><i class="far fa-save" id="save" title="Save"></i></div> -->

                                             @foreach($existingRecord as $saved)
                                                @if($saved->post_id == $record->id && $saved->user_id == UserAuth::getLoginId())
                                                    <div data-postid="{{$record->id}}" data-Userid="{{UserAuth::getLoginId()}}" class="save-btn saved_post_btn" title="Save"><i class="fa fa-check" aria-hidden="true"></i>  Saved</i></div>
                                                @else
                                                    <div data-postid="{{$record->id}}" data-Userid="{{UserAuth::getLoginId()}}" class="save-btn saved_post_btn" title="Save">Save</div>
                                                @endif
                                            @endforeach

                                            <a href="{{route('event_single',$record->id)}}">
                                            <div id="demo-new" class="carousel1 slide">
                                                <!-- Indicators/dots -->
                                                <!-- The slideshow/carousel -->
                                                <div class="carousel-inner">
                                                    <?php
                                                        $itemFeaturedImages = trim($record->image1,'[""]');
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

                                            <div class="Name">
                                                <span>{{$record->title}}</span>
                                            </div>
                                             <div class="main-days-frame">
                                                    <span class="days-box"> 
                                                    <?php
                                                        $givenTime = strtotime($record->created);
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
                                           
                                            <div class="review-customer">
                                                <ul class="review">
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star-half"></i></li>
                                                </ul>
                                            </div>

                                              <div class="job-type job-hp ">
                                                <?php
                                                    if ($record->post_by == 'admin') {
                                                        foreach ($admins as $add) {
                                                            if ($record->user_id == $add->id) {
                                                                echo '<img src="' . asset($add->image) . '" alt="Image">';
                                                                echo '<p>' . $record->title . '<br><small>By ' . $add->first_name . '</small></p>';
                                                            }
                                                        }
                                                    } else {
                                                        // Assuming $users is an array or collection
                                                        foreach ($users as $user) {
                                                            if ($record->user_id == $user->id) {
                                                                echo '<img src="' . asset('assets/images/profile') . '/' . $user->image . '" alt="Image">';
                                                                echo '<p>' . $record->title . '<br><small>By ' . $user->first_name . '</small></p>';
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
                </div>

            </div>
            
        </div>
        
    </div>
</section>
<script type="text/javascript">
jQuery(document).ready(function() {
$(function()
{
$('.slider').on('input change', function(){
    console.log();
          $(this).next($('.slider_label')).html(this.value);
        });
      $('.slider_label').each(function(){
          var value = $(this).prev().attr('value');
          $(this).html(value);
        });  
  
  
})

         $(".Shop_filter").on("click", function(e) {
            e.preventDefault();

             var datePosted = $('input[name="days"]:checked').val();
            var priceRange = $('#price-range').val();
            var event_type = $('input[name="event_type"]:checked').val();
            // alert(event_type);
            // alert(startDate);
            // alert(priceRange);
            // alert(endDate);
                         $('.lds-dual-ring').removeClass('d-none');
                var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                $.ajax({
                    url: site_url+'/Event/filter',
                    type: 'POST',
                    headers: {
                      'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        event_type: event_type,
                        datePosted: datePosted,
                        priceRange: priceRange
                        
                    },
                    success: function(response) {
                      console.log(response);
                         $(".filterRes").html(response);
                         $('.lds-dual-ring').addClass('d-none');
                    },
                    error: function(xhr, status, error) {
                      console.log(xhr.responseText);
                      $('.lds-dual-ring').addClass('d-none');
                    }
                  });
        });
    });
</script>
@endsection