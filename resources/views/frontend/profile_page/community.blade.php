<?php use App\Models\UserAuth; ?>
@extends('layouts.frontlayout')
@section('content')


<section id="shoplisting-page">
    <div class="container">
    <div class="row" style="display: flex; justify-content:end; margin-right: 4px;">
            <button type="button" class="btn filterBTN">Filters</button>
        </div>
        <div class="row">
            <div class="col-md-4 col-lg-3 "id="FiltersJob">
                <div class="closeIcon"><i class="fa fa-close"></i></div>
                <div class="shoplisting-left-sidebar">
                   <div class="job-search-box mt-2">
                     <h5>By Category</h5>
                        <div class="form-check mb-3">
                            <label class="form-check-label">
                                <input class="form-check-input category" type="radio" name="category" value="524"> Education and Learning
                            </label><br>
                            <label class="form-check-label">
                                <input class="form-check-input category" type="radio" name="category" value="522">Find a long lost Relative
                            </label><br>
                            <label class="form-check-label">
                                <input class="form-check-input category" type="radio" name="category" value="516">General Community
                            </label><br>

                            <label class="form-check-label">
                                <input class="form-check-input category" type="radio" name="category" value="517">Lost & Found
                            </label><br>
                            <label class="form-check-label">
                                <input class="form-check-input category" type="radio" name="category" value="519">Neighborhood alerts/safety
                            </label>
                            <label class="form-check-label">
                                <input class="form-check-input category" type="radio" name="category" value="518">Rideshare alerts/safety
                            </label>
                        </div>
                        <h5>Date Posted</h5>
                        <div class="form-check mb-3">
                            <label class="form-check-label">
                                <input class="form-check-input mydate" type="radio" name="days" value="1"> one days ago
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
                                @foreach($matchRecords as $record)
                                <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                                    
                                        <div class="feature-box">
                                             <?php $useid = UserAuth::getLoginId();?>
                                                    @if($existingRecord->contains('post_id', $record->id) && $existingRecord->contains('user_id', $useid))
                                                     <div data-postid="{{$record->id}}" data-Userid="{{UserAuth::getLoginId()}}" class="save-btn saved_post_btn" title="Save"><i class="fa fa-check" aria-hidden="true"></i>  Saved</div>
                                                    @else
                                                        <div data-postid="{{$record->id}}" data-Userid="{{UserAuth::getLoginId()}}" class="save-btn saved_post_btn" title="Save">Save</div>
                                                    @endif
                                              

                                              <a href="{{route('community_single_post',$record->id)}}">
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
                                                                        <img src="{{asset('images_blog_img')}}/{{ $valueitemFeaturedImage }}" alt="Los Angeles" class="d-block w-100" onerror="this.onerror=null; this.src='https://finder.harjassinfotech.org/public/images_blog_img/1688636936.jpg';">
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
            var category = $('input[name="category"]:checked').val();
            // alert(event_type);
            // alert(startDate);
            // alert(priceRange);
            // alert(endDate);
                         $('.lds-dual-ring').removeClass('d-none');
                var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                $.ajax({
                    url: site_url+'/community/filter',
                    type: 'POST',
                    headers: {
                      'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        category: category,
                        datePosted: datePosted,
                        
                        
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