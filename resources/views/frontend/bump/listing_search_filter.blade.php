@php
use App\Models\Setting;
@endphp
@if(isset($locations) && $locations->isNotEmpty())
    @foreach($locations as $location)
        <div class="col-lg-3 col-md-4 col-sm-6 col-6"> 
            <div class="feature-box afterBefor" style="position:relative;">
                @if($location->bumpPost == 1)
                    <div class="ribbon bump-ribbon">
                        <div class="text-div">Bumped</div>
                    </div>
                @endif

                @if($location->featured_post == "on" || $location->featured == "on")
                    <span class="onsale">Featured!</span>
                @endif

                @php
                    $route = '#';
                    $category_name = $category_name ?? '';
                
                    switch ($category_name) {
                        case 'Business':
                            $route = route('business_page.front.single.listing', $location->slug);
                            break;
                        case 'Jobs':
                            $route = route('jobpost', $location->slug);
                            break;
                        case 'Shopping':
                            $route = route('shopping_post_single', $location->slug);
                            break;
                        case 'Fundraiser':
                            $route = route('single.fundraisers', $location->slug);
                            break;
                        case 'Entertainment Industry':
                            $route = route('Entertainment.single.listing', $location->slug);
                            break;
                        case 'Welcome to our Community':
                            $route = route('community_single_post', $location->slug);
                            break;
                        case 'Real Estate':
                            $route = route('real_esate_post', $location->slug);
                            break;
                        case 'Services':
                            $route = route('service_single', $location->slug);
                            break;
                        case 'Blogs':
                            $route = route('blogPostSingle', $location->slug);
                            break;
                        default:
                            $route = match ($location->category_id) {
                                1 => route('business_page.front.single.listing', $location->slug),
                                2 => route('jobpost', $location->slug),
                                4 => route('real_esate_post', $location->slug),
                                5 => route('community_single_post', $location->slug),
                                6 => route('shopping_post_single', $location->slug),
                                7 => route('single.fundraisers', $location->slug),
                                705 => route('service_single', $location->slug),
                                741 => route('Entertainment.single.listing', $location->slug),
                                default => '#',
                            };
                            break;
                    }
                @endphp
            

                <a href="{{ $route }}">
                    @php
                        if (isset($location->image1)) {
                            $newImg = trim($location->image1, '[""]');
                            $img = $newImg ? explode('","', $newImg) : [];
                        } elseif (!empty($location->business_logo)) {
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
                                        if (!empty($location->business_logo)) {
                                            $imagePath = 'business_img/' . $image;
                                        } elseif (!file_exists(public_path($imagePath))) {
                                            $imagePath = 'images_entrtainment/' . $image;
                                        }
                                    @endphp
                                    <div class="carousel-item @if($index == 0) active @endif">
                                        <img src="{{ asset($imagePath) }}" alt="{{ $location->Title ?? $location->title ?? $location->business_name }}" class="d-block w-100">
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

                    @if ($category_name == 'Shopping')
                        <div class="caption">
                            <h6 class="product-title">{{ ucfirst($location->title) }}</h6>
                            <div class="price" style="font-size: 15px;padding: 0px 0px;"><del>${{$location->product_price}}</del> ${{$location->product_sale_price}}</div>
                            @php
                                $totalRating = $allreview->where('product_id', $location->id)->sum('rating');
                                $totalReviews = $allreview->where('product_id', $location->id)->count();
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
                                    <span class="likes-box">{{ $location->likes }}</span>
                                </div>
                            </div>

                        @else
                        <p class="job-title" style="color:#000;"><b>{{ ucfirst($location->title ?? $location->Title ?? $location->business_name) }}</b></p>
                            <div class="location-job-title">
                                <div class="job-type">
                                    <div class="main-days-frame">
                                        <span class="days-box">
                                            @php
                                                $givenTime = strtotime( $location->created ?? $location->created_at );
                                                $days = floor((time() - $givenTime) / (60 * 60 * 24));
                                                echo $days > 0 ? Setting::get_formeted_time($days) : 'Posted today.';
                                            @endphp
                                        </span>
                                    </div>

                                    <div class="likes-frame d-flex justify-content-end">
                                        <i class="fa-regular fa-thumbs-up me-2 mt-1"></i>
                                        <span class="likes-box">{{ $location->likes }}</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                            <div class="button-sell" style="margin-top: 0px;">
                                @if ($category_name == 'Blogs')
                                    <span><a href="{{ $route }}" class="btn create-post-button" data-product-id="{{ $location->id }}">Read more</a></span>
                                @else
                                    <span><a href="{{ $route }}" class="btn create-post-button" data-product-id="{{ $location->id }}">View details</a></span>
                                @endif
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@else 
    <div class="div_blank text-center p-5">
        <h5>No data found under this category.</h5>
    </div>
@endif
