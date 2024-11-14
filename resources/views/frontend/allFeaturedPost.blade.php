<?php
use App\Models\UserAuth;
use App\Models\Setting;
?>
@extends('layouts.frontlayout')

@section('content')
<style type="text/css">
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
.onsale:before,.onsale:after {
  content: "";
  position: absolute;
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
.onsale:after {
  width: 5px;
  height: 5px;
  bottom: -5px;
  left: -4.5px;
  border-radius: 5px 0 0 5px;
  background: #800;
}
span.onsale {
    background-color: red;
}
.top-search {
    top: 0px !important;
}
input#get-Location {
    height: 40px;
    background-color: #eeecec;
}
</style>

<section class="job-listing">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-lg-3">
                <div class="top-search">
                    <form id="searchForm" method="POST" action="{{ route('search') }}">
                        <div class="row">
                            @csrf
                            <div class="col-md-12 coll-1 mb-2">
                                <div class="select-job">
                                    <select id="searcjob" class="form-select" name="searcjobParent">
                                        <option value="">Categories</option>
                                        {{-- <option value="728">Blogs</option>  --}}
                                        <option value="1">Business</option>    
                                        <option value="741">Entertainment Industry</option> 
                                        <option value="7">Fundraisers</option>       
                                        <option value="2">Jobs</option>        
                                        <option value="5">Our Community</option>
                                        <option value="4">Real Estate</option>        
                                        <option value="705">Services</option>        
                                        <option value="6">Shopping</option>
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
            <div class="col-md-8 col-lg-9 mt-2">
                <div class="row related-job">
                @foreach($featuredPost as $feature)
                @php
                // Determine the route based on category_id
                $route = '#';
                $category_name = '';
                if ($feature->category_id == 1) {
                    $category_name = 'Business';
                    $route = route('business_page.front.single.listing', $feature->slug);
                } elseif ($feature->category_id == 2) {
                    $category_name = 'Jobs';
                    $route = route('jobpost', $feature->slug);
                } elseif ($feature->category_id == 4) {
                    $category_name = 'Real Estate';
                    $route = route('real_esate_post', $feature->slug);
                } elseif ($feature->category_id == 5) {
                    $category_name = 'Welcome to our Community';
                    $route = route('community_single_post', $feature->slug);
                } elseif ($feature->category_id == 6) {
                    $category_name = 'Shopping';
                    $route = route('shopping_post_single', $feature->slug);
                } elseif ($feature->category_id == 7) {
                    $category_name = 'Fundraisers';
                    $route = route('single.fundraisers', $feature->slug);
                } elseif ($feature->category_id == 705) {
                    $category_name = 'Services';
                    $route = route('service_single', $feature->slug);
                } elseif ($feature->category_id == 728) {
                    $category_name = 'Blogs';
                    $route = route('blogPostSingle', $feature->slug);
                } elseif ($feature->category_id == 741) {
                    $category_name = 'Entertainment Industry';
                    $route = route('Entertainment.single.listing', $feature->slug);
                }

                // $show_post = false;


                //     if ($feature->privacy_option == 'connections') {

                //         $is_connected = Follow::where('follower_id', $loggedInUser->id)
                //             ->where('following_id', $feature->user->id)
                //             ->whereNull('deleted_at')
                //             ->get();

                //             dd($is_connected);
                //         if ($is_connected || $feature->user_id == $loggedInUser->id) {
                //             $show_post = true;
                //         }

                //     } elseif ($feature->privacy_option == 'only_me') {
                //         if ($feature->user_id == $loggedInUser->id) {
                //             $show_post = true;
                //         }

                //     } else {
                //         $show_post = true;
                //     }
            @endphp

            {{-- @if($show_post) --}}
                <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                    <div class="feature-box">
                        @if($feature->category_id == 705 && $feature->available_now == 1)
                            <div class="ring-container1">
                                <div class="av-now">Available</div>
                            </div>
                        @endif
                        <span class="onsale">Featured!</span>
                        <a href="{{ $route }}">
                            <div id="demo-new" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner" id="idnametwo">
                                    @php
                                        // Extract images from feature
                                        if (isset($feature->image1)) {
                                            $featuredImages = trim($feature->image1, '[""]');
                                            $newImg = $featuredImages ? explode('","', $featuredImages) : [];
                                        } elseif (isset($feature->business_logo)) {
                                            $newImg = $feature->business_logo ? explode(',', $feature->business_logo) : [];
                                        } else {
                                            $newImg = $feature->image ? explode(',', $feature->image) : [];
                                        }
                                    @endphp
                                    
                                    @if(!empty($newImg))
                                        @php
                                            $carouselId = 'carousel-' . $feature->id;
                                        @endphp
                                        <div id="{{ $carouselId }}" class="carousel slide" data-bs-ride="carousel">
                                            <div class="carousel-inner">
                                                @foreach($newImg as $index => $image)
                                                    @php
                                                        $imagePath = 'images_blog_img/' . $image;
                                                        if (isset($feature->business_logo)) {
                                                            $imagePath = 'business_img/' . $image;
                                                        } elseif (!file_exists(public_path($imagePath))) {
                                                            $imagePath = 'images_entrtainment/' . $image;
                                                        }
                                                    @endphp
                                                    <div class="carousel-item @if($index == 0) active @endif">
                                                        <img src="{{ asset($imagePath) }}" alt="{{ $feature->Title ?? $feature->title ?? $feature->business_name }}" class="d-block w-100">
                                                    </div>
                                                @endforeach
                                            </div>
                                            @if(count($newImg) > 1)
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
                                </div>
                            </div>
                            
                            @if($feature->category_id == 6)
                                <div class="caption">
                                    <p class="job-title"><b>{{ ucfirst( $feature->title ?? $feature->Title) }}</b></p>
                                    <div class="price" style="font-size: 15px;padding: 0px 0px;"><del>${{ $feature->product_price }}</del> ${{ $feature->product_sale_price }}</div>
                                    @php
                                        $totalRating = 0;
                                        $reviewsForProduct = $allreview->where('product_id', $feature->id);
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
                            @else
                                <p class="job-title"><b>{{ ucfirst($feature->title ?? $feature->Title ?? $feature->business_name) }}</b></p>
                                <div class="location-job-title">
                                    <div class="job-type">
                                        <div class="main-days-frame">
                                            <span class="days-box">
                                                @php
                                                    $givenTime = strtotime($feature->created ?? $feature->created_at);
                                                    $days = floor((time() - $givenTime) / (60 * 60 * 24));
                                                    echo $days > 0 ? Setting::get_formeted_time($days) : 'Posted today.';
                                                @endphp
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            {{-- <div class="button-sell" style="margin-top: 0px;">
                                <span><a href="{{ $route }}" class="btn create-post-button" data-product-id="{{ $feature->id }}">View details</a></span>
                            </div> --}}
                        </a>
                    </div>
                </div>
            {{-- @endif --}} 
			    @endforeach   

                    @if(@isset($jobs) && $jobs->isNotEmpty())
                                @foreach($jobs as $feature) 
                                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                                        <div class="feature-box">
                                            <span class="onsale">Featured!</span>
                                            <?php $useid = UserAuth::getLoginId();?>
                                            <a href="{{route('jobpost', $feature->slug)}}">  
                                                <div id="demo-new" class="carousel slide" data-bs-ride="carousel">
                                                    <div class="carousel-inner">
                                                        <?php
                                                        $neimg = trim($feature->image1, '[""]');
                                                        $img  = explode('","', $neimg);
                                                        ?>
                                                        @if($feature->image1)
                                                            <img src="{{asset('images_blog_img')}}/{{$img[0]}}" alt="{{$feature->title}}" class="d-block w-100">
                                                        @else
                                                            <img src="{{asset('images_blog_img/1688636936.jpg')}}" alt="New York" class="d-block w-100">
                                                        @endif
                                                    </div>
                                                </div>
                                                <p class="job-title"><b>{{ ucfirst($feature->title) }}</b></p>
                                                <div class="location-job-title">
                                                    <div class="job-type">
                                                        <div class="main-days-frame">
                                                            <span class="days-box"> 
                                                                @php
                                                                    $givenTime = strtotime($feature->created ?? $feature->created_at);
                                                                    $days = floor((time() - $givenTime) / (60 * 60 * 24));
                                                                    echo $days > 0 ? Setting::get_formeted_time($days) : 'Posted today.';
                                                                @endphp
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                        @endif

                        @if(@isset($realestate) && $realestate->isNotEmpty())
                                @foreach($realestate as $feature)
                                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                                        <a href="{{route('real_esate_post', $feature->slug)}}">
                                            <div class="feature-box">
                                                <span class="onsale">Featured!</span>
                                                <?php $useid = UserAuth::getLoginId();?>
                                                <div class="img-area">
                                                    <?php
                                                    $neimg = trim($feature->image1, '[""]');
                                                    $img  = explode('","', $neimg);
                                                    ?>
                                                    @if($feature->image1)
                                                        <img src="{{asset('images_blog_img')}}/{{$img[0]}}" alt="{{$feature->title}}" class="d-block w-100">
                                                    @else
                                                        <img src="{{asset('images_blog_img/1688636936.jpg')}}" alt="New York" class="d-block w-100">
                                                    @endif
                                                </div>
                                                <p><b>{{$feature->title}}</b></p>
                                                <div class="row overflow-section">
                                                    <span class="days-box"> 
                                                        @php
                                                            $givenTime = strtotime($feature->created ?? $feature->created_at);
                                                            $days = floor((time() - $givenTime) / (60 * 60 * 24));
                                                            echo $days > 0 ? Setting::get_formeted_time($days) : 'Posted today.';
                                                        @endphp
                                                    </span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            @endif
                            
                            @if(@isset($service) && $service->isNotEmpty())
                                @foreach($service as $feature)
                                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                                        <div class="feature-box">
                                            <span class="onsale">Featured!</span>
                                            <?php $useid = UserAuth::getLoginId();?>
                                            <a href="{{route('service_single', $feature->id)}}">
                                                <div class="img-area">
                                                    <?php
                                                    $neimg = trim($feature->image1, '[""]');
                                                    $img  = explode('","', $neimg);
                                                    ?>
                                                    @if($feature->image1)
                                                        <img src="{{asset('images_blog_img')}}/{{$img[0]}}" alt="{{$feature->title}}" class="d-block w-100">
                                                    @else
                                                        <img src="{{asset('images_blog_img/1688636936.jpg')}}" alt="New York" class="d-block w-100">
                                                    @endif
                                                </div>
                                                <p><b>{{$feature->title}}</b></p>
                                                <div class="row overflow-section">
                                                    <span class="days-box"> 
                                                        @php
                                                            $givenTime = strtotime($feature->created ?? $feature->created_at);
                                                            $days = floor((time() - $givenTime) / (60 * 60 * 24));
                                                            echo $days > 0 ? Setting::get_formeted_time($days) : 'Posted today.';
                                                        @endphp
                                                    </span>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                        @endif

                        @if(@isset($shopping) && $shopping->isNotEmpty())

                                @foreach($shopping as $feature)
                                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                                        <div class="feature-box">
                                            <span class="onsale">Featured!</span>
                                            <?php $useid = UserAuth::getLoginId();?>
                                            <a href="{{route('shopping_post_single', $feature->slug)}}">
                                                <div class="img-area">
                                                    <?php
                                                    $neimg = trim($feature->image1, '[""]');
                                                    $img  = explode('","', $neimg);
                                                    ?>
                                                    @if($feature->image1)
                                                        <img src="{{asset('images_blog_img')}}/{{$img[0]}}" alt="{{$feature->title}}" class="d-block w-100">
                                                    @else
                                                        <img src="{{asset('images_blog_img/1688636936.jpg')}}" alt="New York" class="d-block w-100">
                                                    @endif
                                                </div>
                                                <p><b>{{$feature->title}}</b></p>
                                                <div class="row overflow-section">
                                                    <span class="days-box"> 
                                                        @php
                                                            $givenTime = strtotime($feature->created ?? $feature->created_at);
                                                            $days = floor((time() - $givenTime) / (60 * 60 * 24));
                                                            echo $days > 0 ? Setting::get_formeted_time($days) : 'Posted today.';
                                                        @endphp
                                                    </span>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                        @endif

                        @if(@isset($entertainment) && $entertainment->isNotEmpty())

                                @foreach($entertainment as $feature)
                                <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                                    <div class="feature-box">
                                        <span class="onsale">Featured!</span>
                                        <?php $useid = UserAuth::getLoginId();?>
                                        <a href="{{route('Entertainment.single.listing', $feature->slug)}}">
                                            <div class="img-area">
                                                <?php
                                                $img  = explode(',', $feature->image);
                                                ?>
                                                @if($feature->image)
                                                    <img src="{{asset('images_entrtainment')}}/{{$img[0]}}" alt="{{$feature->Title}}" class="d-block w-100">
                                                @else
                                                    <img src="{{asset('images_blog_img/1688636936.jpg')}}" alt="New York" class="d-block w-100">
                                                @endif
                                            </div>
                                            <p><b>{{$feature->Title}}</b></p>
                                            <div class="row overflow-section">
                                                <span class="days-box"> 
                                                    @php
                                                        $givenTime = strtotime($feature->created ?? $feature->created_at);
                                                        $days = floor((time() - $givenTime) / (60 * 60 * 24));
                                                        echo $days > 0 ? Setting::get_formeted_time($days) : 'Posted today.';
                                                    @endphp
                                                </span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                    @endif

                    @if(@isset($blogs) && $blogs->isNotEmpty())

                            @foreach($blogs as $feature)
                            <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                                <div class="feature-box">
                                    <span class="onsale">Featured!</span>
                                    <?php $useid = UserAuth::getLoginId();?>
                                    <a href="{{route('blogPostSingle', $feature->slug)}}">
                                        <div class="img-area">
                                            <?php
                                            $img  = explode(',', $feature->image);
                                            ?>
                                            @if($feature->image)
                                                <img src="{{asset('images_blog_img')}}/{{$img[0]}}" alt="{{$feature->title}}" class="d-block w-100">
                                            @else
                                                <img src="{{asset('images_blog_img/1688636936.jpg')}}" alt="New York" class="d-block w-100">
                                            @endif
                                        </div>
                                        <p><b>{{$feature->title}}</b></p>
                                        <div class="row overflow-section">
                                            <span class="days-box"> 
                                                @php
                                                    $givenTime = strtotime($feature->created ?? $feature->created_at);
                                                    $days = floor((time() - $givenTime) / (60 * 60 * 24));
                                                    echo $days > 0 ? Setting::get_formeted_time($days) : 'Posted today.';
                                                @endphp
                                            </span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endforeach

                    @endif

                </div>                    
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function() {
    $('#searcjob').on('change', function() {
    let selectedParent = $(this).val();
    console.log(selectedParent);
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
                    // console.log('item', item);
                    optionsHtml += "<option data-id='" + item.parentID + "' data-sub_id='" + item.id + "' value='" + item.slug + "'>" + item.title + "</option>";
                });
                $('#searcjobChild').html(optionsHtml);
            },
            error: function(response) {
                console.log('error', response);
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
            url: "{{ route('getLocationSearch') }}",
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
