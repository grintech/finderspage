@php
use App\Models\UserAuth;
use App\Models\Setting;
use App\Models\Admin\Follow;
use App\Models\Admin\Users;

// Assume $loggedInUser represents the currently authenticated user.
$loggedInUser = UserAuth::getloginuser();
@endphp

<h4 class="text-center pb-1"> Featured </h4>
<div class="container">
    <div class="row slick-slider featured-slider d-flex flex-wrap justify-content-center">
        @foreach($blogs as $feature)
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
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-3">
                    <div class="element element-1">
                        <div class="feature-box">
                            @if($feature->category_id == 705  && $feature->available_now == 1)
                                <div class="ring-container1">
                                    <div class="av-now">Available</div>
                                </div>
                            @elseif($feature->category_id == 4 && $feature->available_now == 1)
                                <div class="ring-container1 realestate">
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
                                        <p class="job-title" style="color:#000;"><b>{{ ucfirst( $feature->title ?? $feature->Title) }}</b></p>
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
                                    <p class="job-title" style="color:#000;"><b>{{ ucfirst($feature->title ?? $feature->Title ?? $feature->business_name) }}</b></p>
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
                                <div class="button-sell" style="margin-top: 0px;">
                                    <span><a href="{{ $route }}" class="btn create-post-button" data-product-id="{{ $feature->id }}">View details</a></span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            {{-- @endif --}}
        @endforeach
    </div>
    <div class="row">    
        <div class="col-lg-12 text-center" bis_skin_checked="1">
            <a href="{{ route('getAllfeaturedpost') }}" class="btn fields-search">View All</a>
        </div>
    </div>
</div>
