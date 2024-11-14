<?php
use App\Models\Admin\HomeSettings;
use App\Models\Admin\Testimonials;
use App\Models\UserAuth;
use Illuminate\Support\Str;

?>
@extends('layouts.frontlayout')
@section('content')
<style type="text/css">
    .top-search {
    top: 5px;
    z-index: 1;
    position: relative;
}
</style>
<section class="job-listing">
    <div class="container">
        <div class="row">
            <div class="col-12" style="text-align: center;padding: 10px 20px;background-color: #000;margin-bottom: 3%; border-radius:5px;">
                <div class="top-search" style="top: 0; padding: 8px 37px; border-radius: 5px; background-color: #000; border-color: #000;">
                <form method="POST" action="{{ route('search') }}">
                    <div class="row">
                        @csrf
                            <div class="col-lg-3 col-md-6">
                                <div class="select-job">
                                    <select id="searcjob_search" class="form-select" name="searcjobParent">
                                        <option>Category</option>
                                        @foreach($blog_categories_search as $b)
                                            <option value="{{$b->id}}">{{$b->title}}</option>
                                        @endforeach  
                                    
                                    </select>
                                </div>
                            </div>
                    
                            <div class="col-lg-3 col-md-6">
                                <div class="select-job">
                                    <select id="searcjobChild" class="form-select" name="searcjobChild">
                                        <option>Sub Category</option>
                                    </select>
                                    
                                </div>
                            </div>
                    
                            <div class="col-lg-3 col-md-6">
                                <div class="location-search">
                                    <input type="location" name="location" class="form-control" id="exampleFormControlInput1"
                                        placeholder="location">
                                        <i class="bi bi-geo-alt"></i>
                                </div>
                            </div>

                            <div class="col-lg-3 col-sm-12 col-md-6">
                                <div class="search-fields">
                                    <!-- <a href="#">Search<i class="bi bi-arrow-right"></i></a> -->
                                    <button class="btn fields-search" type="submit">Search<i
                                            class="bi bi-arrow-right"></i></button>
                                </div>
                            </div>
                        </div>
                  </form> 
              </div>
            </div>

                <h1 class="serch-value"><b><span style="color: #000;">Search Result For : </span></b>{{ $getCategoryLabel }}, {{ $getCategoryChildLabel }}</h1>
            </div>
        </div>
        <div class="container">
            <div class="row" style="float: right;margin-right: 4%;">
                <button type="button" class="btn filterBTN">Filters</button>
            </div>
        </div>
        <div class="container">
        <div class="row" style="width: 100%;">
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
                                <input class="form-check-input" type="radio" name="postDate" value="1"> one day ago
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
                <div class="row related-job">
                    <div class="col-lg-12 col-md-12">
                        <div class="job-post-header">
                            <div class="row filterRes">
                            
                            @if (!$matchingRecords->isEmpty())
                            <?php 
                             // echo"<pre>"; print_r($matchingRecords);die();
                             ?>
                                @foreach($matchingRecords as $Records) 
                                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                                        <div class="feature-box">
                                            <?php $useid = UserAuth::getLoginId();?>
                                                    @if($existingRecord->contains('post_id', $Records->id) && $existingRecord->contains('user_id', $useid))
                                                     <div data-postid="{{$Records->id}}" data-Userid="{{UserAuth::getLoginId()}}" class="save-btn saved_post_btn" title="Save"><i class="fa fa-check" aria-hidden="true"></i>  Saved</div>
                                                    @else
                                                        <div data-postid="{{$Records->id}}" data-Userid="{{UserAuth::getLoginId()}}" class="save-btn saved_post_btn" title="Save">Save</div>
                                                    @endif 
                                              <a href="{{route('service_single',$Records->id)}}">
                                                <div class="img-area">
                                                <?php
                                                $neimg = trim($Records->image1,'[""]');
                                                $img  = explode('","',$neimg);
                                            ?>
                                            @if($Records->image1)
                                                <img src="{{asset('images_blog_img')}}/{{$img[0]}}" alt="{{$Records->title}}" class="d-block w-100">
                                            @else
                                                <img src="./new_assets/assets/images/home.png" alt="New York" class="d-block w-100">
                                            @endif
                                                </div>
                                            
                                            <div class="job-post-content">
                                                <h4>{{$Records->title}}</h4>
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
                                                                            
                                                                            // if ($minutes > 0) {
                                                                            //     $timeAgo .= $minutes . " min, ";
                                                                            // }
                                                                            // $timeAgo .= $seconds . " sec ago";

                                                                            echo $timeAgo;
                                                                        ?>

                                                                    </span>
                                                                </div>
                                            </div>
                                        </a>
                                        </div>
                                    </div>
                                   

                                   
                                @endforeach
                            @else
                                <div class="col-12" style="text-align: center;">
                                      <h3 style="padding: 5% 0% 2% 0%;  font-size: 20px;">We couldn't find any data, Please adjust your search settings.</h3>          
                                      <a href="{{ url('/') }}"> <button style="margin-bottom: 5%;" class="btn create-post-button" type="button">Go to Search</button></a>                
                                </div>
                            @endif    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        
    </div>
</section>

<script type="text/javascript">
    
    $(document).ready(function(){
    $('#searcjob_search').on('change', function() {
        let selectedParent = this.value;
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        var optionsHtml = "";
        $.ajax({
            url: site_url+"/getchildcat",
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": csrfToken
            },
            data: {
               selectedParent:selectedParent,    
            },
            success:function(response) {
                console.log('success',response);
                if(selectedParent==6){
                    $('#searcjobChild').html(response);
                }else{
                   $('#searcjobChild').append(optionsHtml);
                    var optionsHtml = "";

                    $.each(response, function(index, item) {
                        optionsHtml += "<option value='" + item.id + "'>" + item.title + "</option>";
                    });
                    $('#searcjobChild').empty();
                    $('#searcjobChild').append(optionsHtml);
                }
            },
            error: function(response) {
                console.log('error',response);
            }
        });
    });


});

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