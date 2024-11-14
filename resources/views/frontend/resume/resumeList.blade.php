<?php use App\Models\UserAuth; ?>
@extends('layouts.frontlayout')
@section('content')
<section class="job-listing">
    <!-- <div class="visible-xs">
        <div class="container-fluid">
            <button class="btn btn-default navbar-btn" data-toggle="collapse" data-target="#filter-sidebar">
              <i class="fa fa-tasks"></i> Filters
            </button>
        </div>
    </div> -->
    <div class="container">
        <div class="row" style="display: flex; justify-content:end; margin-right: 4px;">
            <button type="button" class="btn filterBTN">Filters</button>
        </div>
        <div class="row">
            <div class="col-md-3 col-lg-3" id="FiltersJob">
                <form method="post" action="">
                <div class="left-side-bar">
                    <div class="job-search-box mt-2">
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
                    <div class="job-search-box mt-2">
                        <div class="filter-check">
                            <span><a href="">Reset</a></span><input class="btn btn-warning post_filter" type="submit" value="Apply">
                        </div>
                    </div>
                </div>
                </form>
            </div>
            <div class="col-md-9 col-lg-9 mt-2">
            
            <div class="row related-job">
                    <div class="col-lg-12 col-md-12">
                        <div class="job-post-header">
                            <div class="row filterRes">
                                @foreach($resume as $Records)
                                    
                                    <div class="col-lg-3 col-md-6 col-sm-6 col-6 columnJoblistig mb-3">
                                            <div class="feature-box">
                                               
                                               <?php 
                                                 $useid = UserAuth::getLoginId();
                                                    ?>
                                                    @if($existingRecord->contains('post_id', $Records->id) && $existingRecord->contains('user_id', $useid))
                                                        <div data-postid="{{$Records->id}}" data-Userid="{{UserAuth::getLoginId()}}" class="save-btn saved_post_btn" title="Save"><i class="fa fa-check" aria-hidden="true"></i>  Saved</div>
                                                    @else
                                                        <div data-postid="{{$Records->id}}" data-Userid="{{UserAuth::getLoginId()}}" class="save-btn saved_post_btn" title="Save">Save</div>
                                                    @endif
                                             <a href="{{route('resume.single-post',$Records->id)}}">   
                                            <div id="demo-new" class="">
                                                <div class="carousel-inner">

                                                    <div class="carousel-item-test">
                                                        @if(isset($Records->uploadPicture))
                                                        <img src="{{asset('images_resume_img')}}/{{$Records->uploadPicture}}" alt="Los Angeles" class="d-block w-100">
                                                        @else

                                                        <img src="https://finderspage.com/public/images_blog_img/1688636936.jpg" alt="Los Angeles" class="d-block w-100" >

                                                        @endif
                                                    </div>
                                                </div>

                                               
                                            </div>

                                                <p class="job-title">{{$Records->firstName}}</p>
                                                <div class="main-days-frame">
                                                    <span class="location-box">
                                                       <!-- {{$Records->phoneNumber}} -->
                                                    </span>
                                               
                                                    <span class="days-box"> 
                                                    <?php
                                                        $givenTime = strtotime($Records->created_at);
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
</section>

<script>
    $("#menu-toggle").click(function(e) {
  e.preventDefault();
  $("#wrapper").toggleClass("toggled");
});
     jQuery(document).ready(function() {
         $(".post_filter").on("click", function(e) {
            e.preventDefault();
            var datePosted = $('input[name="days"]:checked').val();

            
             // alert(datePosted);
                var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                $.ajax({
                    url: site_url+'/resume-filter',
                    type: 'POST',
                    headers: {
                      'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        datePosted: datePosted,
                        
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
