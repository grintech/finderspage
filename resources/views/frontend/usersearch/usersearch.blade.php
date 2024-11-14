<?php
use App\Models\Admin\HomeSettings;
use App\Models\Admin\Testimonials;
use App\Models\UserAuth;
use Illuminate\Support\Str;

?>
@extends('layouts.frontlayout')
@section('content')
<style type="text/css">
.top-search {top: 0px;z-index: 1;position: relative;padding: 12px 37px; border-radius: 5px; background-color: #000; border-color: #000; margin-bottom: 20px;}
.profile-card {position: relative;display: flex;flex-direction: column;justify-content: center;align-items: center;word-wrap: break-word;background-color: #fff;background-clip: border-box;border: 1px solid rgba(0,0,0,.1);border-radius: 20px;box-shadow: 0px 0px 20px rgb(61 65 67 / 20%);padding: 20px;text-align: center;}
.profile-card .img-area{height: 100px;}
.profile-card .img-area img{width: 100px; height: 100px; border-radius: 50%;}
.user-search{font-size: 14px;padding: 7px 15px;}

@media only screen and (max-width:767px){
.job-post-content h4{font-size: 14px;}
.search-fields{margin-top: 5px;text-align: center;}  
.profile-card .img-area{height: 90px;}
.profile-card .img-area img{width: 90px; height: 90px; border-radius: 50%;}  
}
</style>
<section class="job-listing">
    {{-- <div class="container">
        <div class="row">

                <div class="col-md-12 top-search">
                    <form method="POST" action="{{ route('search') }}">
                        <div class="row">
                            @csrf
                                <div class="col-lg-10 col-md-9 col-sm-12">
                                    <div class="location-search">
                                        <input type="search" name="user_name" class="form-control user-input" id="exampleFormControlInput1"
                                            placeholder="Enter Name">
                                            <i class="bi bi-geo-alt"></i>
                                    </div>
                                </div>

                                <div class="col-lg-2 col-sm-12 col-md-3">
                                    <div class="search-fields">
                                        <!-- <a href="#">Search<i class="bi bi-arrow-right"></i></a> -->
                                        <button class="btn btn-warning user-search" type="submit">Search<i
                                                class="bi bi-arrow-right"></i></button>
                                    </div>
                                </div>
                            </div>
                      </form> 
                </div>


            <h1 class="serch-value text-black text-center"><span>Search Result For:</span></h1>
        </div>
    </div> --}}
    <!-- <div class="container">
        <div class="row" style="float: right;margin-right: 4%;">
            <button type="button" class="btn filterBTN">Filters</button>
        </div>
    </div> -->
    <div class="container">
        <!-- <div class="row">
            <div class="col-md-4 col-lg-3 "id="FiltersJob">
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
                                <input class="form-check-input mydate" type="radio" name="days" value="1"> one day ago
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
            <div class="col-md-12 col-lg-12 mt-2">
                <div class="row related-job">
                    <div class="col-lg-12 col-md-12">
                        <div class="job-post-header">
                            <div class="row" id="result_user">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <div class="row related-job border-0">
            <div class="col-lg-12 col-md-12">
                <div class="job-post-header">
                    <div class="row" id="result_user">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    
    

jQuery(document).ready(function() {
        $(".user-search").on("click", function(e) {
            e.preventDefault();
            var user_name = $('.user-input').val();
                var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                $.ajax({
                    url: site_url+'/user-search-result',
                    type: 'POST',
                    headers: {
                      'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        user_name: user_name,  
                    },
                    success: function(response) {
                      console.log(response);
                      if(response.html==""){
                        $('#result_user').html('<p>No data found</p>');
                      }else{
                        $('#result_user').html(response.html);
                      }
                        
                    },
                    error: function(xhr, status, error) {
                      console.log(xhr.responseText);
                     $('#result_user').html('<p>Error loading posts.</p>');
                    }
                  });
        });
    });

</script>

@endsection