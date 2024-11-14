<?php

use App\Models\UserAuth;
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

.feature-box2{
    position: relative;
}
.feature-box2 .onsale,.records-box2 .onsale{
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
.feature-box2 .onsale:before,.records-box2 .onsale:before{
    width: 7px;
    height: 33px;
    top: 0;
    left: -6.5px;
    padding: 0 0 7px;
    background: inherit;
    border-radius: 5px 0 0 5px;
    content: "";
    position: absolute;
}
#shoplisting-page .records-box2{
    height: 97% !important;
}

@media screen and (max-width: 475px) {
    .records-box2 {
      height: auto !important;
    }
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

.main-cat {
    font-size: 13px;
    height: 40px !important;
}
</style>
<section id="shoplisting-page">
    <div class="container">
        <div class="row">
            <h1 class="text-center">Shopping</h1>
            <div class="col-md-4 col-lg-3">
                <div class="top-search">
                    <form id="searchForm">
                        <div class="row">
                            @csrf
                            <div class="col-md-12 coll-1 mb-2">
                                <div class="select-job">
                                    <input type="text" class="form-control main-cat" id="searcjob" name="Shopping" value="Shopping" readonly>
                                </div>
                            </div>
                
                            <div class="col-md-12 coll-1 mb-2">
                                <div class="select-job">
                                    <select id="searcjobChild" name="searcjobChild" class="form-select" data-live-search="true">
                                        <option value="">Sub Categories</option>
                                        <option value="1277">Automotive</option>
                                        <option value="674">Beauty, Health & Personal Care</option>
                                        <option value="611">Books</option>
                                        <option value="695">Clothing & Shoes</option>
                                        <option value="602">Clothing, Shoes, Accessories</option>
                                        <option value="632">Computers</option>
                                        <option value="625">Electronics</option>
                                        <option value="1213">Fashion</option>
                                        <option value="1318">Find your favorite pet</option>
                                        <option value="1225">Free Stuff</option>
                                        <option value="1216">Girls</option>
                                        <option value="672">Grocery & Wine</option>
                                        <option value="1237">Handmade</option>
                                        <option value="643">Home, Garden & Pets</option>
                                        <option value="682">Household, Health & Baby Care</option>
                                        <option value="1284">Industrial & Scientific</option>
                                        <option value="919">Legal CBD & HEMP (Cannabidiol) This will be monitored!</option>
                                        <option value="1215">Men</option>
                                        <option value="617">Movies, Music & Games</option>
                                        <option value="920">Non Alcoholic Beverages ( This will be monitored)</option>
                                        <option value="1267">Outdoors</option>
                                        <option value="665">Pet Supplies</option>
                                        <option value="774">Spiritual</option>
                                        <option value="1254">Sports</option>
                                        <option value="657">Tools, Home Improvement</option>
                                        <option value="690">Toys, Kids & Baby</option>
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
            <div class="col-md-8 col-lg-9">
                <div class="row related-job filterRes_search" style="display: none;"></div>
                <div class="row related-job filterRes">


                    @foreach($matchingRecords as $records)
                    <div class="col-md-6 col-lg-3 col-6">

                        <div class="feature-box afterBefor" style="position:relative;">
                            <span class="onsale">Featured!</span>
                            <div id="demo-new" class="carousel1 slide">
                                <div class="carousel-inner">
                                    <a href="{{route('shopping_post_single',$records->slug)}}">
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
                                    </a>
                                </div>
                            </div>
                            <div class="caption">
                                <h6 class="product-title">{{ ucfirst($records->title) }}</h6>
                                <div class="price" style="font-size: 15px;padding: 0px 0px;">
                                    <del>${{$records->product_price}}</del> ${{$records->product_sale_price}}
                                </div>
                                @php
                                    $totalRating = 0;
                                    $reviewsForProduct = $allreview->where('product_id', $records->id);
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
                            </div>
                            <div class="button-sell" style="margin-top: 40px;">
                                <span><a href="{{route('shopping_post_single',$records->slug)}}" class="btn create-post-button">View Details</a></span>
                            </div> 
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    $(document).ready(function() {
        // function fetchSubCategories() {
        //     var selectedParent = $('#searcjob').val();

            // if (selectedParent === "Shopping") {
            //     selectedParent = 6;
            // }
        //     var csrfToken = $('meta[name="csrf-token"]').attr('content');
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
        //             let optionsHtml = "<option value=''>Sub Categories</option>";
        //             $.each(response, function(index, item) {
        //                 optionsHtml += `<option data-id='${item.parentID}' data-sub_id='${item.id}' value='${item.slug}'>${item.title}</option>`;
        //             });
        //             $('#searcjobChild').html(optionsHtml);
        //         },
        //         error: function(response) {
        //             console.log('error', response);
        //         }
        //     });
        // }
    
        // fetchSubCategories();
    
        $('#searchForm').on('submit', function(e) {
            e.preventDefault();
    
            var searcjobParent = $('#searcjob').val();

            if (searcjobParent === "Shopping") {
                searcjobParent = 6;
            }
            var searcjobChild = $('#searcjobChild option:selected').attr('data-sub_id');
            var location = $('#get-Location').val();
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
    
            $.ajax({
                url: "{{ url('/shop/filter') }}",
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
                        $('.lds-dual-ring').addClass('d-none');
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', status, error);
                        console.error('Response Text:', xhr.responseText);
                        $('.lds-dual-ring').addClass('d-none');
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