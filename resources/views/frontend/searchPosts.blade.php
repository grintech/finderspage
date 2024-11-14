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
#search_post_page section#search-section{
    background-image: none !important;
}
#search_post_page .top-search{
    background-color: whitesmoke !important;
    padding: 25px 15px;
}
 #search_post_page .top-search #get-Location{
    height:40px !important;
    font-size: 14px !important;
 }
 #search_post_page .top-search #searcjob_search{
   background-color: white !important;
 }
 #search_post_page .top-search #searcjobChild{
   background-color: white !important;
 }

 #search_post_page #autocomplete-results{
    width: 300px;
    position: absolute;
    background-color: white;
    /* padding: 10px 0px; */
    list-style: none;
    z-index: 111;
    max-height: 400px;
    overflow-y: scroll;
 }
 #search_post_page #autocomplete-results::-webkit-scrollbar{display: none;}
 #search_post_page #autocomplete-results{
 -ms-overflow-style: none; 
 scrollbar-width: none; 
}

 #search_post_page #autocomplete-results li.Search_val {
    cursor: pointer;
    font-size: 14px;
    padding: 8px 20px;
 }
 #search_post_page #autocomplete-results li.Search_val:hover {
    background-color: #ccc;
 }

</style>


<div id="search_post_page">
<section id="search-section">
         <div class="container">
        <div class="top-search my-4">
                <form id="searchForm2" method="POST">
                    <div class="row">
                        @csrf
                            <div class="col-lg-3 col-md-6 coll-1">
                                <div class="select-job">
                                    <select id="searcjob_search" class="form-select" name="searcjobParent">
                                        <option value="">Category</option>
                                        @foreach($blog_categories_search as $main_category)
                                          @if ($main_category->id !=728)
                                            <option value="{{$main_category->id}}" 
                                                @if($main_category->id == $main_category_id) selected @endif>
                                                {{$main_category->title}}
                                            </option>
                                          @endif
                                        @endforeach  
                                    </select>
                                    
                                </div>
                            </div>
                    
                            <div class="col-lg-3 col-md-6 coll-1">
                                <div class="select-job">
                                    <select id="searcjobChild" class="form-select" name="searcjobChild">
                                        <option value="">Sub Category</option>
                                    </select>
                                    
                                </div>
                            </div>
                    
                            <div class="col-lg-3 col-md-6 coll-1">
                                <div class="location-search">
                                    <input type="location" name="location" class="form-control get_loc" id="get-Location"
                                        placeholder="location">
                                        <i class="bi bi-geo-alt"></i>
                                </div>
                                <div class="searcRes" id="autocomplete-results"></div>
                            </div>

                            <div class="col-lg-3 col-sm-12 col-md-6 coll-2">
                                <div class="search-fields">
                                    <button class="btn fields-search" type="submit">Search<i
                                            class="bi bi-arrow-right"></i></button>
                                </div>
                            </div>
                            
                        </div>
                  </form> 
              </div>
            </div>

        <div class="container">
        <div class="row" style="width: 100%;">
            <div class="col-sm-8 col-md-10 col-lg-12 mt-2">
                <div class="row related-job">
                            @if(isset($locations) && $locations->isNotEmpty())
                                @foreach($locations as $location)
                                    <div class="col-lg-3 col-md-4 col-sm-6 col-6"> 
                                        <div class="feature-box afterBefor" style="position:relative;">
                                            @if($location->bumpPost == "1")
                                                <div class="ribbon bump-ribbon" data-toggle="tooltip" data-placement="top" title="This is a bump listing.">
                                                    <div class="text-div">Bumped</div>
                                                </div>
                                            @endif
                                            
                                            @php
                                                $route = '#';
                                                $category_name ?? '';
                                            
                                                if ($category_name == 'Business') {
                                                    $route = route('business_page.front.single.listing', $location->slug);
                                                } elseif ($category_name == 'Jobs') {
                                                    $route = route('jobpost', $location->slug);
                                                } elseif ($category_name == 'Shopping') {
                                                    $route = route('shopping_post_single', $location->slug);
                                                } elseif ($category_name == 'Fundraisers') {
                                                    $route = route('single.fundraisers', $location->slug);
                                                } elseif ($category_name == 'Entertainment Industry') {
                                                    $route = route('Entertainment.single.listing', $location->slug);
                                                } elseif ($category_name == 'Welcome to our Community') {
                                                    $route = route('community_single_post', $location->slug);
                                                } elseif ($category_name == 'Real Estate') {
                                                    $route = route('real_esate_post', $location->slug);
                                                } elseif ($category_name == 'Services') {
                                                    $route = route('service_single', $location->slug);
                                                } elseif ($category_name == 'Blogs') {
                                                    $route = route('blogPostSingle', $location->slug);
                                                }
                                            @endphp

                                            <a href="{{ $route }}">
                                                @php
                                                    if (isset($location->image1)) {
                                                        $newImg = trim($location->image1, '[""]');
                                                        $img = $newImg ? explode('","', $newImg) : [];
                                                    } elseif (isset($location->business_logo)) {
                                                        $img = explode(',', $location->business_logo);
                                                    } else {
                                                        $img = $location->image ? explode(',', $location->image) : [];
                                                    }
                                                @endphp

                                                @if(!empty($img))
                                                    @php
                                                        $carouselId = 'carousel-' . $location->id;
                                                    @endphp
                                                    <div id="{{ $carouselId }}" class="carousel slide" data-bs-ride="carousel">
                                                        <div class="carousel-inner">
                                                            @foreach($img as $index => $image)
                                                                @php
                                                                    $imagePath = 'images_blog_img/' . $image;
                                                                    if (!file_exists(public_path($imagePath))) {
                                                                        $imagePath = 'images_entrtainment/' . $image;
                                                                        if (!file_exists(public_path($imagePath))){
                                                                            $imagePath = 'business_img/' . $image;
                                                                        }
                                                                    }
                                                                    if (!file_exists(public_path($imagePath))) {
                                                                        $imagePath = 'images_blog_img/1688636936.jpg';
                                                                    }
                                                                @endphp
                                                                <div class="carousel-item @if($index == 0) active @endif">
                                                                    <img src="{{ asset($imagePath) }}" alt="{{ $location->Title ?? $location->title }}" class="d-block w-100">
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        @if(count($img) > 1)
                                                            <a class="carousel-control-prev" href="#{{ $carouselId }}" role="button" data-bs-slide="prev">
                                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                                <span class="visually-hidden">Previous</span>
                                                            </a>
                                                            <a class="carousel-control-next" href="#{{ $carouselId }}" role="button" data-bs-slide="next">
                                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                                <span class="visually-hidden">Next</span>
                                                            </a>
                                                        @endif
                                                    </div>
                                                @else
                                                    <img src="{{ asset('images_blog_img/1688636936.jpg') }}" alt="Placeholder Image" class="d-block w-100">
                                                @endif
                                                
                                                <p class="job-title"><b>{{ ucfirst($location->Title ?? $location->title ?? $location->business_name) }}</b></p>
                                                @if ($category_name == 'Shopping') 
                                                    @php
                                                        $totalRating = 0;
                                                        $reviewsForProduct = $allreview->where('product_id', $location->id);
                                                        $totalReviews = count($reviewsForProduct);
                                                    @endphp
                            
                                                    @if($totalReviews > 0)
                                                        @foreach($reviewsForProduct as $review)
                                                            @php $totalRating += $review->rating; @endphp
                                                        @endforeach
                            
                                                        @php
                                                            $averageRating = $totalRating / $totalReviews;
                                                            $fullStars = floor($averageRating);
                                                            $halfStar = ($averageRating - $fullStars) >= 0.5 ? 1 : 0;
                                                            $emptyStars = 5 - $fullStars - $halfStar;
                                                        @endphp
                            
                                                        <div class="average-rating">
                                                            <ul class="review">
                                                                @for ($i = 0; $i < $fullStars; $i++)
                                                                    <li><i class="bi bi-star-fill"></i></li>
                                                                @endfor
                                                                @if ($halfStar)
                                                                    <li><i class="bi bi-star-half"></i></li>
                                                                @endif
                                                                @for ($i = 0; $i < $emptyStars; $i++)
                                                                    <li><i class="bi bi-star"></i></li>
                                                                @endfor
                                                            </ul>
                                                        </div>
                                                    @else
                                                        <div class="average-rating">
                                                            <ul class="review">
                                                                @for ($i = 0; $i < 5; $i++)
                                                                    <li><i class="bi bi-star"></i></li>
                                                                @endfor
                                                            </ul>
                                                        </div>
                                                    @endif
                                                @else
                                                    <div class="location-job-title">
                                                        <div class="job-type">
                                                            <div class="main-days-frame">
                                                                <span class="days-box">
                                                                    @php
                                                                        $givenTime = strtotime($location->created ?? $location->created_at);
                                                                        $currentTimestamp = time();
                                                                        $timeDifference = $currentTimestamp - $givenTime;
                                                                
                                                                        $days = floor($timeDifference / (60 * 60 * 24));
                                                                        $timeAgo = $days > 0 ? ($days == 1 ? "1 day ago" : "$days days ago") : "Posted today";
                                                                
                                                                        echo $timeAgo;
                                                                    @endphp
                                                                </span>
                                                            </div>

                                                        </div>
                                                    </div>
                                                @endif
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

</section>
</div>

<script type="text/javascript">
    
    $(document).ready(function() {
    // Function to load subcategories based on the selected parent category
    function loadSubCategories(selectedParent) {
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
                console.log('success', response);
                let optionsHtml = "<option value=''>Sub Categories</option>";
                $.each(response, function(index, item) {
                    let selected = (item.id == {{ $sub_category_id }}) ? ' selected' : ''; // Check if item.id matches $sub_category_id
                    optionsHtml += "<option data-id='" + item.parentID + "' data-sub_id='" + item.id + "' value='" + item.id + "'" + selected + ">" + item.title + "</option>";
                });
                $('#searcjobChild').html(optionsHtml);
            },
            error: function(response) {
                console.log('error', response);
            }
        });
    }

    // Call the function when a parent category is selected
    $('#searcjob_search').on('change', function() {
        let selectedParent = $(this).val();
        console.log("Selected Parent:", selectedParent);
        loadSubCategories(selectedParent);
    });

    // Trigger the AJAX request to load subcategories on page load if a parent category is pre-selected
    let initialSelectedParent = $('#searcjob_search').val();
    if (initialSelectedParent) {
        loadSubCategories(initialSelectedParent);
    }


    $('#searchForm2').on('submit', function(e) {
        e.preventDefault();

        var searcjobParent = $('#searcjob_search').val();
        var searcjobChild = $('#searcjobChild option:selected', this).attr('data-sub_id');
        var location = $('#get-Location').val();

        $.ajax({
            type: 'POST',
            url: "{{ route('search_posts') }}",
            data: {
                searcjobParent: searcjobParent,
                searcjobChild: searcjobChild,
                location: location,
            },
            dataType: 'json',
            success: function(data) {
                console.log(data);
                $('.related-job').html(data.html);
            },
            error: function(xhr, status, error) {
                console.error('Error:', xhr.responseText);
            }
        });
    });


});


document.addEventListener("DOMContentLoaded", function () {
    const toggleButton = document.getElementById("toggleButton");
    const targetDiv = document.getElementById("targetDiv");

    toggleButton.addEventListener("click", function () {
        if (targetDiv.style.display === "none") {
            targetDiv.style.display = "block";
        } else {
            targetDiv.style.display = "none";
        }
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
</script>

@endsection