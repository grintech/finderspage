@php

use App\Models\UserAuth;
use App\Models\Setting;
use App\Models\BlogCategories;

$categories = BlogCategories::whereNull('parent_id')
        ->whereNull('deleted_at')
        ->where('status', 1)
        ->whereNotIn('id', [727, 728])
        ->orderBy('id', 'ASC')
        ->get();
$subcategories = BlogCategories::where('parent_id',"!=" ,null)->get();
$sub_subcate = BlogCategories::where('parent_id',"!=" ,null)->get();

// dd($blog_categories);
@endphp
<style>
    .Uncategorized{
      width: 100%;
      background: #b58f3d;
      color: white;
      font-size: 13px;
      border-radius: 3px;
      cursor: pointer;
    }
    .feature-box{
        overflow: inherit !important;
    }
    .top-search {
        top: 0px !important;
    }

    input#get-Location {
        height: 40px;
        background-color: #eeecec;
    }

    .side-bar {
        padding: 0 !important;
    }

    .form-select:focus {
        box-shadow: none!important;
    }

    .job-listing .related-job .feature-box .carousel-control-prev, .job-listing .related-job .feature-box .carousel-control-next{
        display: none;
    }
    .job-listing .related-job .feature-box{
        height: 260px !important;
    }
    .product-title {
        font-size: 15px;
        line-height: 16px;
        margin-bottom: 0 !important;
        color: #000;
        display: -webkit-inline-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .main-days-frame .days-frame {
        font-size: 15px !important;
        color: rgba(0,0,0,1) !important;
        font-weight: normal !important;
    }
</style>
@extends('layouts.frontlayout')
@section('content')

<section class="job-listing">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-lg-3">
                <div class="side-bar mt-2">

                    <div class="top-search">
                        <form id="searchForm" method="POST" action="{{ route('search') }}">
                            <div class="row">
                                @csrf
                                <div class="col-md-12 coll-1 mb-2">
                                    <div class="select-job">
                                        <select id="searcjob" class="form-select" name="searcjobParent">
                                            <option value="">Categories</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->title }}</option>
                                            @endforeach
                                        </select>                                                                               
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
            </div>

            <div class="col-md-8 col-lg-9 mt-2">
                <div class="row related-job">
                    @foreach($sortedCombined as $key => $post)
                        @php
                            // Define routes based on category ID
                            $route = match($post->category_id) {
                                1 => route('business_page.front.single.listing', $post->slug),
                                2 => route('jobpost', $post->slug),
                                4 => route('real_esate_post', $post->slug),
                                5 => route('community_single_post', $post->slug),
                                6 => route('shopping_post_single', $post->slug),
                                7 => route('single.fundraisers', $post->slug),
                                705 => route('service_single', $post->slug),
                                741 => route('Entertainment.single.listing', $post->slug),
                                default => '#',
                            };
                        @endphp
                    
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12 columnJoblistig mb-3" style="position: relative;">
                            <div class="feature-box afterBefor">
                                @if($post->bumpPost == 1)
                                    <div class="ribbon bump-ribbon">
                                        <div class="text-div">Bumped</div>
                                    </div>
                                @endif
                    
                                @if($post->featured_post == "on" || $post->featured == "on")
                                    <span class="onsale">Featured!</span>
                                @endif
                    
                                <a href="{{ $route }}">
                                    <div id="demo-new" class="carousel">
                                        <div class="carousel-inner">
                                            @php
                                                // Determine images based on available fields
                                                $images = [];
                                                if (!empty($post->image1)) {
                                                    $images = explode('","', trim($post->image1, '[""]'));
                                                } elseif (!empty($post->business_logo)) {
                                                    $images = explode(',', $post->business_logo);
                                                } elseif (!empty($post->image)) {
                                                    $images = explode(',', $post->image);
                                                }
                                            @endphp
                    
                                            @if (is_array($images) && !empty($images))
                                                @foreach ($images as $keyImage => $valueImage)
                                                    @php
                                                        // Set image paths
                                                        $imagePath = 'images_blog_img/' . $valueImage;
                                                        if (!empty($post->business_logo)) {
                                                            $imagePath = 'business_img/' . $valueImage;
                                                        } elseif (!file_exists(public_path($imagePath))) {
                                                            $imagePath = 'images_entrtainment/' . $valueImage;
                                                        }
                                                        $class = $keyImage == 0 ? 'active' : 'in-active';
                                                    @endphp
                                                    <div class="carousel-item {{ $class }}">
                                                        <img src="{{ asset($imagePath) }}" alt="{{ $post->Title ?? $post->title ?? $post->business_name }}" class="d-block w-100">
                                                    </div>
                                                @endforeach
                                            @else
                                                <img src="{{ asset('images_blog_img/1688636936.jpg') }}" alt="popular-{{$key}}" class="d-block w-100">
                                            @endif
                                        </div>
                                    </div>
                                </a>
                    
                                <p class="job-title">{{ ucfirst($post->Title ?? $post->title ?? $post->business_name) }}</p>
                    
                                @if ($post->category_id == 6)
                                    <div class="price" style="font-size: 15px; padding: 0;">
                                        <del>${{ $post->product_price }}</del> ${{ $post->product_sale_price }}
                                    </div>
                    
                                    @php
                                        $totalRating = $allreview->where('product_id', $post->id)->sum('rating');
                                        $totalReviews = $allreview->where('product_id', $post->id)->count();
                                        $averageRating = $totalReviews > 0 ? $totalRating / $totalReviews : 0;
                                        $fullStars = floor($averageRating);
                                        $halfStar = ($averageRating - $fullStars) >= 0.5 ? 1 : 0;
                                        $emptyStars = 5 - $fullStars - $halfStar;
                                    @endphp
                    
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="average-rating">
                                            <ul class="review mb-0">
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

                                        <div class="likes-frame d-flex align-items-center">
                                            <i class="fa-regular fa-thumbs-up me-2"></i>
                                            <span class="likes-box">{{ $post->likes }}</span>
                                        </div>
                                    </div>
                    
                                @else
                                    <div class="main-days-frame">
                                        <span class="days-frame">
                                            @php
                                                $postedTime = strtotime($post->created_at ?? $post->created);
                                                $daysSincePosted = floor((time() - $postedTime) / (60 * 60 * 24));
                                                echo $daysSincePosted > 0 ? Setting::get_formeted_time($daysSincePosted) : 'Posted today.';
                                            @endphp
                                        </span>
                                    </div>

                                    <div class="likes-frame d-flex justify-content-end">
                                        <i class="fa-regular fa-thumbs-up me-2 mt-1"></i>
                                        <span class="likes-box">{{ $post->likes }}</span>
                                    </div>
                                @endif
                    
                                <div class="button-sell" style="margin-top: 0;">
                                    <span><a href="{{ $route }}" class="btn create-post-button" data-product-id="{{ $post->id }}">View details</a></span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="related-job-popular"></div>
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
    // $('#searcjob').on('change', function() {
    // let selectedParent = $(this).val();
    // console.log(selectedParent);
    // var csrfToken = $('meta[name="csrf-token"]').attr('content');
    //     $.ajax({
    //         url: "{{ url('/getchildcat') }}",
    //         method: "POST",
    //         headers: {
    //             "X-CSRF-TOKEN": csrfToken
    //         },
    //         data: {
    //             selectedParent: selectedParent,    
    //         },
    //         success: function(response) {
    //             console.log('success', response);
    //             let optionsHtml = "<option value=''>Sub Categories</option>";
    //             $.each(response, function(index, item) {
    //                 // console.log('item', item);
    //                 optionsHtml += "<option data-id='" + item.parentID + "' data-sub_id='" + item.id + "' value='" + item.slug + "'>" + item.title + "</option>";
    //             });
    //             $('#searcjobChild').html(optionsHtml);
    //         },
    //         error: function(response) {
    //             console.log('error', response);
    //         }
    //     });
    // });

    $('#searcjobChild').on('change', function(e) {
        var slug = $(this).val();
        var id = $('option:selected', this).attr('data-id');
        var sub_id = $('option:selected', this).attr('data-sub_id');

        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        };

        $.ajax({
            type: 'post',
            url: '{{ route("filter.data") }}',
            data: {
                slug: slug,
                id: id,
                sub_id: sub_id,
            },
            headers: headers,
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

    $('#searchForm').on('submit', function(e) {
        e.preventDefault();

        var searcjobParent = $('#searcjob').val();
        var searcjobChild = $('#searcjobChild option:selected', this).attr('data-sub_id');
        var location = $('#get-Location').val();

        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        };

        $.ajax({
            type: 'POST',
            url: "{{ route('getPostsByLocation') }}",
            data: {
                searcjobParent: searcjobParent,
                searcjobChild: searcjobChild,
                location: location,
            },
            headers: headers,
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


    $('.Uncategorized').on('click', function(e) {
        e.preventDefault();
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: 'post',
            url: '{{ route("filter.data.uncategorized") }}',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(data) {
                console.log(data);
                $('.related-job').html(data.html);
            },
            error: function(xhr, status, error) {
                console.error('Error:', xhr.responseText);
            }
        });
    });

    $('#searcjob').on('change', function(e) {
        var id = $(this).val();
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: 'post',
            url: '{{ route("filter.data.category") }}',
            data: { id: id },
            headers: { 'X-CSRF-TOKEN': csrfToken },
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