<?php

use App\Models\UserAuth;
use App\Models\Setting;
?>
@extends('layouts.frontlayout')
@section('content')
<style>
    .user-input-found {
        border-radius: 14px;
        border: 1px solid #000;
        padding-left: 11px;
        padding: 3px;
        margin-right: -35px;
    }

    .search {
        text-align: right;
/*        margin-bottom: 20px;*/

    }

    @media only screen and (max-width: 767px) {
        .search_icon {
            border-radius: 14px;
            border: 1px solid #000;
            padding-left: 11px;
            padding: 3px;
            width: 100%;
            margin: auto;
        }

        .span_getuser {
            position: relative;
            top: -27px;
            right: 10px;
        }
    }

    .feature-box {
        overflow: inherit !important;
    }
    .top-search {
        top: 0px !important;
    }
    input#get-Location {
        height: 40px;
        background-color: #eeecec;
    }
    .main-cat {
        font-size: 13px;
        height: 40px !important;
    }
</style>
<section class="realestate-listing">
    <div class="container">
        <div class="row">
            <h1 class="text-center" style="font-size: 2.0rem;">Find a home you'll love! Real Estate Ads</h1>
            <div class="col-md-4 col-lg-3">
                <div class="top-search">
                    <form id="searchForm">
                        <div class="row">
                            @csrf
                            <div class="col-md-12 coll-1 mb-2">
                                <div class="select-job">
                                    <input class="form-control main-cat" id="searcjob" type="text" name="Real Estate" value="Real Estate" readonly>
                                </div>
                            </div>
                
                            <div class="col-md-12 coll-1 mb-2">
                                <div class="select-job">
                                    <select id="searcjobChild" name="searcjobChild" class="form-select" data-live-search="true">
                                        <option value="">Sub Categories</option>
                                    </select>
                                </div>
                            </div>
                
                            <div class="col-md-12 coll-1 mb-2">
                                <div class="location-search">
                                    <input type="text" name="location" class="form-control get_loc" id="get-Location" placeholder="Location">
                                    <i id="getLocation" class="bi bi-geo-alt"></i>
                                </div>
                                <div class="searcRes new_search_dropbox" id="autocomplete-results"></div>
                            </div>
                
                            <div class="col-sm-12 col-md-12 coll-2 mb-2">
                                <div class="search-fields">
                                    <button class="btn fields-search" type="submit">Search<i class="bi bi-arrow-right"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-8 col-lg-9 mt-2">
                <!-- <div class="row">
                    <div class="search">
                        <input type="search" name="search" class="user-input-found search_icon" placeholder="Search">
                        <span class="open-search toggle getUser span_getuser"><i class="fa-solid fa-magnifying-glass icon_search" aria-hidden="true"></i></span>
                    </div>
                </div> -->

                <div class="row related-job filterRes_search" style="display: none;"></div>
                <div class="row filterRes">
                    <div class="row">
                        @if ($matchingRecords->isNotEmpty())
                        @foreach($matchingRecords as $records)

                        <div class="col-lg-3 col-md-6 col-sm-6 col-6">

                            <div class="feature-box afterBefor" style="position:relative;">
                                @if($records->available_now == 1)
                                    <div class="ring-container1">
                                        <div class="av-now">Available</div>
                                    </div>
                                 @endif
                                @if($records->bumpPost=="1")
                                <div class="ribbon bump-ribbon" data-toggle="tooltip" data-placement="top" title="This  is bump listing .">
                                  <div class="text-div">
                                    Bumped
                                  </div>
                                </div>
                                @endif
                                <!-- @foreach($existingRecord as $saved)
                            @if($saved->post_id == $records->id && $saved->user_id == UserAuth::getLoginId())
                                <div data-postid="{{$records->id}}" data-Userid="{{UserAuth::getLoginId()}}" class="save-btn saved_post_btn" title="Save"><i class="fa fa-check" aria-hidden="true"></i>  Saved</i></div>
                            @else
                                <div data-postid="{{$records->id}}" data-Userid="{{UserAuth::getLoginId()}}" class="save-btn saved_post_btn" title="Save">Save</div>
                            @endif
                            @endforeach -->

                                <a href="{{route('real_esate_post',$records->slug)}}">
                                    <div id="demo" class="carousel1 slide">

                                        <!-- Indicators/dots -->

                                        <!-- The slideshow/carousel -->
                                        <div class="carousel-inner1">
                                            <?php
                                            $itemFeaturedImages = trim($records->image1, '[""]');
                                            $itemFeaturedImage  = explode('","', $itemFeaturedImages);
                                            if (is_array($itemFeaturedImage)) {
                                                foreach ($itemFeaturedImage as $keyitemFeaturedImage => $valueitemFeaturedImage) {
                                                    if ($keyitemFeaturedImage == 0) {
                                                        $class = 'active';
                                                    } else {
                                                        $class = 'in-active';
                                                    } ?>
                                                    <div class="carousel-item <?= $class; ?>">
                                                        <img src="{{asset('images_blog_img')}}/{{ $valueitemFeaturedImage }}" alt="Los Angeles" class="d-block w-100" onerror="this.onerror=null; this.src=\'' . asset('images_blog_img/1688636936.jpg') . '\'">
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
                                                    $timeAgo = Setting::get_formeted_time($days);
                                                }else{
                                                   $timeAgo = "Posted today"; 
                                                }
                                                echo $timeAgo;
                                            ?>

                                        </span>
                                    </div>
                                    <div class="review-section">
                                        <!-- <p>Review</p>
                                <ul class="review">
                                    <li><i class="bi bi-star-fill"></i></li>
                                    <li><i class="bi bi-star-fill"></i></li>
                                    <li><i class="bi bi-star-fill"></i></li>
                                    <li><i class="bi bi-star-fill"></i></li>
                                    <li><i class="bi bi-star-half"></i></li>
                                </ul> -->
                                    </div>
                                </a>
                            </div>

                        </div>
                        @endforeach
                        @else
                        <div class="col-12" style="text-align: center;">
                           <h3 style="padding: 5% 0% 2% 0%; font-size: 20px;">No data found under this category.</h3>
                           <a href="{{ url('/') }}">
                               <button style="margin-bottom: 5%;" class="btn create-post-button" type="button">Go to Search</button>
                           </a>
                        </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    $(document).ready(function() {
        function fetchSubCategories() {
            var selectedParent = $('#searcjob').val();

            if (selectedParent === "Real Estate") {
                selectedParent = 4;
            }
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: "{{ url('/getchildcat') }}",
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": csrfToken
                },
                data: {
                    selectedParent: selectedParent,    
                },
                success: function(response) {
                    let optionsHtml = "<option value=''>Sub Categories</option>";
                    $.each(response, function(index, item) {
                        optionsHtml += `<option data-id='${item.parentID}' data-sub_id='${item.id}' value='${item.slug}'>${item.title}</option>`;
                    });
                    $('#searcjobChild').html(optionsHtml);
                },
                error: function(response) {
                    console.log('error', response);
                }
            });
        }
    
        fetchSubCategories();
    
        $('#searchForm').on('submit', function(e) {
            e.preventDefault();
    
            var searcjobParent = $('#searcjob').val();

            if (searcjobParent === "Real Estate") {
                searcjobParent = 4;
            }
            var searcjobChild = $('#searcjobChild option:selected').attr('data-sub_id');
            var location = $('#get-Location').val();
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
    
            $.ajax({
                url: "{{ url('/realestate/filter') }}",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    searcjobParent: searcjobParent,
                    searcjobChild: searcjobChild,
                    location: location,
                },
                  success: function(response) {
                    console.log(response);
                       $(".filterRes").html(response);
                  },
                  error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                    console.error('Response Text:', xhr.responseText);
                  }
                });
        });
    });

    $(document).ready(function() {
    $('.get_loc').keyup(function () {
            var address = $(this).val();
            console.log(address);
             var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
             console.log('CSRF Token:', csrfToken);
            $.ajax({
                url: site_url+'/get/place/autocomplete',
                type: 'POST',
                headers: {
                  'X-CSRF-TOKEN': csrfToken,
                },
                data: {
                    address:address,
                },
                success: function(response){
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
    $(document).on("click",".Search_val",function() {
        var searchVal = $(this).text();
        // alert(searchVal);
        $('.get_loc').val(searchVal);
        $(this).addClass('active_li');
        $('#autocomplete-results').hide();

    });
</script>
@endsection