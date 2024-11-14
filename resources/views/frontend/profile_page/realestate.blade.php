<?php
use App\Models\UserAuth;
?>
@extends('layouts.frontlayout')
@section('content')

<section class="realestate-listing">
    <div class="container">
        <div class="row" style="display: flex; justify-content:end; margin-right: 4px;">
            <button type="button" class="btn filterBTN">Filters</button>
        </div>
        <div class="row">
            <div class="col-md-4 col-lg-3" id="FiltersJob">
                <div class="closeIcon"><i class="fa fa-close"></i></div>
                <div class="realstate-left-sidebar">
                    <h4>Housing </h4>
                    <div class="form-check mb-3">
                        <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="house_type" value="526"> Apartments / Housing 
                            </label><br>
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="house_type" value="533"> Real Estate for Sale
                            </label><br>
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="house_type" value="528"> Office & Commercial
                            </label><br>
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="house_type" value="529"> Parking & Storage
                            </label><br>
                             <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="house_type" value="527"> Housing Swap
                            </label><br>
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="house_type" value="532"> Land/Property
                            </label><br>
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="house_type" value="525"> Rooms & Shares
                            </label><br>
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="house_type" value="530"> Sublets & Temporary
                            </label> <br>
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="house_type" value="531"> Vacation Rentals
                            </label>
                    </div>
                    <h4>Price</h4>
                    <div class="price-realestate">
                        <div class="min-price">
                            <label for="exampleFormControlInput1" class="form-label">Min-Price</label>
                            <input type="text" name="min_price" class="form-control" id="exampleFormControlInput1">
                        </div>
                        <div class="max-price">
                            <label for="exampleFormControlInput1" class="form-label">Max-Price</label>
                            <input type="text" name="max_price" class="form-control" id="exampleFormControlInput1">
                        </div>
                    </div>
                    <div class="filter-check mt-3 mb-3">
                            <span><a href="">Reset</a></span><span><a class="realEstate_filter" href="#">Apply</a></span>
                        </div>
                </div>
            </div>
            <div class="col-md-8 col-lg-9 mt-2">
            <div class="row related-job filterRes">
                @if(!empty($matchRecords))
                @foreach($matchRecords as $records)
                
                <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                    
                    <div class="feature-box">
                        @foreach($existingRecord as $saved)
                            @if($saved->post_id == $records->id && $saved->user_id == UserAuth::getLoginId())
                                <div data-postid="{{$records->id}}" data-Userid="{{UserAuth::getLoginId()}}" class="save-btn saved_post_btn" title="Save"><i class="fa fa-check" aria-hidden="true"></i>  Saved</i></div>
                            @else
                                <div data-postid="{{$records->id}}" data-Userid="{{UserAuth::getLoginId()}}" class="save-btn saved_post_btn" title="Save">Save</div>
                            @endif
                            @endforeach

                        <a href="{{route('real_esate_post',$records->id)}}">
                    <div id="demo" class="carousel1 slide">

                        <!-- Indicators/dots -->

                        <!-- The slideshow/carousel -->
                        <div class="carousel-inner1">
                                <?php
                                    $itemFeaturedImages = trim($records->image1,'[""]');
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
                         <p class="job-title">{{ ucfirst($records->title) }}</p>
                        
                        <div class="job-type">
                            <ul>
                                @if($records->sale_price)
                                    <li><span><i class="bi bi-cash"></i></span>${{$records->sale_price}}</li>
                                @endif
                                
                                
                                
                            </ul>
                        </div>
                        <div class="main-days-frame">
                                <span class="location-box">
                                    @foreach($city as $ctt)@if($ctt->id == $records->city){{$ctt->name}}@endif @endforeach<span>&nbsp;</span> @foreach($state as $stt)@if($stt->id == $records->state){{$stt->name}}@endif @endforeach
                                </span>

                                <span class="days-box"> 
                                <?php
                                    $givenTime = strtotime($records->created);
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
                            <div class="review-section">
                                <p>Review</p>
                                <ul class="review">
                                    <li><i class="bi bi-star-fill"></i></li>
                                    <li><i class="bi bi-star-fill"></i></li>
                                    <li><i class="bi bi-star-fill"></i></li>
                                    <li><i class="bi bi-star-fill"></i></li>
                                    <li><i class="bi bi-star-half"></i></li>
                                </ul>
                            </div>
                        </a>
                    </div>
               
            </div>
                @endforeach

                @else
                <div>
                    <h6>No Post Available</h6>
                </div>

                @endif
             
            </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    jQuery(document).ready(function() {
         $(".realEstate_filter").on("click", function(e) {
            e.preventDefault();

            var house_type = $('input[name="house_type"]:checked').val();
            var min_price = $('input[name="min_price"]').val();
            var max_price = $('input[name="max_price"]').val();

            // alert(house_type);
            // alert(min_price);
            // alert(max_price);
                var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                $.ajax({
                    url: site_url+'/realestate/filter',
                    type: 'POST',
                    headers: {
                      'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        house_type: house_type,
                        min_price: min_price,
                        max_price: max_price
                        
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