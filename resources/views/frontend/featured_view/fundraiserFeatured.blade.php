<?php
use App\Models\UserAuth;
use App\Models\Setting;
use Illuminate\Support\Str;
?>
@extends('layouts.frontlayout')
@section('content')
<style type="text/css">
	span.onsale {
    background-color: red;
}
	.onsale {
    z-index: 6;
    position: absolute;
    top: 0px;
    left: 6px;
    padding: 2px 10px;
    background: var(--red);
    color: #fff;
    box-shadow: -1px 2px 3px rgba(0, 0, 0, 0.3);
    border-radius: 0 5px 5px 0;
    height: 25px;
    line-height: 25px;
    font-size: 0.8rem;
    font-weight: normal;
    padding-top: 0;
    padding-bottom: 0;
    min-height: 0;
}
.onsale:before {
    width: 7px;
    height: 33px;
    top: 0;
    left: -6.5px;
    padding: 0 0 7px;
    background: inherit;
    border-radius: 5px 0 0 5px;
}

.onsale:before, .onsale:after {
    content: "";
    position: absolute;
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


<section class="job-listing">
    <!-- <div class="visible-xs">
        <div class="container-fluid">
            <button class="btn btn-default navbar-btn" data-toggle="collapse" data-target="#filter-sidebar">
              <i class="fa fa-tasks"></i> Filters
            </button>
        </div>
    </div> -->
    <div class="container">
        <div class="row">
            <h1 class="text-center" style="font-size: 2.0rem;">Fundraisers</h1>
            <div class="col-md-3 col-lg-3">
                <div class="top-search">
                    <form id="searchForm">
                        <div class="row">
                            @csrf
                            <div class="col-md-12 coll-1 mb-2">
                                <div class="select-job">
                                    <input class="form-control main-cat" id="searcjob" type="text" name="Fundraisers" value="Fundraisers" readonly>
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
                                <div class="searcRes" id="autocomplete-results"></div>
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
            <div class="col-md-9 col-lg-9 mt-2">
            <div class="row related-job">
                    <div class="col-lg-12 col-md-12">
                        <div class="job-post-header">
                            <div class="row filterRes">
                                @if ($matchingRecords->isNotEmpty())
                                @foreach($matchingRecords as $Records)
                                    <?php //echo '<pre>'; print_r($Records); echo '</pre>'; ?>
                                    <div class="col-lg-3 col-md-6 col-sm-6 col-6 columnJoblistig mb-3">
                                        <div class="feature-box">
                                        	<span class="onsale">Featured!</span>
                                             <a href="{{route('single.fundraisers',$Records->slug)}}">   
                                            <div id="demo-new" class="">
                                                <!-- Indicators/dots -->
                                                <!-- The slideshow/carousel -->
                                                <div class="carousel-inner">
                                                    <?php
                                                        $itemFeaturedImages = trim($Records->image1,'[""]');
                                                        $itemFeaturedImage  = explode('","',$itemFeaturedImages);
                                                        if(is_array($itemFeaturedImage)) {
                                                            foreach($itemFeaturedImage as $keyitemFeaturedImage => $valueitemFeaturedImage) { if($keyitemFeaturedImage == 0) {$class='active'; } else { $class='in-active'; } ?>
                                                                    <div class="carousel-item <?= $class; ?>">
                                                                        <img src="{{asset('images_blog_img')}}/{{ $valueitemFeaturedImage }}" alt="Los Angeles" class="d-block w-100" onerror="this.onerror=null; this.src=\'' . asset('images_blog_img/1688636936.jpg') . '\'">
                                                                    </div>
                                                            <?php }     
                                                        }
                                                    ?>
                                                    
                                                    
                                                </div>
                                            </div>
                                                {{-- @foreach($users as $user)
                                                    @if($user->id == $Records->user_id)
                                                         <ul class="list-unstyled" style="margin-bottom: 0px;">
                                                            <li class="userIcon" style="display: flex;">
                                                                <div class="img-icon" bis_skin_checked="1">
                                                                  <img class="img-fluid rounded-circle" width="70%" alt="image" height="40" width="40" src="{{asset('assets/images/profile')}}/{{$user->image}}">
                                                                </div>
                                                                <div class="comments-area" bis_skin_checked="1">
                                                                  <h6>{{$user->username}}</h6>
                                                                   <p class="job-title"><b>{{ ucfirst($Records->title) }}</b></p>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    @endif
                                                @endforeach --}}
                                                <p class="job-title">{{ ucfirst($Records->title) }}</p>
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
                                                                $timeAgo = Setting::get_formeted_time($days);
                                                            }else{
                                                               $timeAgo .= "Posted today"; 
                                                            }
                                                            echo $timeAgo;
                                                        ?>

                                                    </span>
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
        
    </div>
</section>

<script>
$("#menu-toggle").click(function(e) {
  e.preventDefault();
  $("#wrapper").toggleClass("toggled");
});
$(document).ready(function() {
    function fetchSubCategories() {
        let selectedParent = $('#searcjob').val();
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
        var searcjobChild = $('#searcjobChild option:selected').attr('data-sub_id');
        var location = $('#get-Location').val();
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: "{{ url('/filter') }}",
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
                 $(".filterRes").html(response.html);
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
                console.error('Response Text:', xhr.responseText);
            }
        });
    });
});
     
</script>

@endsection