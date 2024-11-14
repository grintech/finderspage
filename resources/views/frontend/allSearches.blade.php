@if(isset($locations) && $locations->isNotEmpty())
    @foreach($locations as $location)
        <div class="col-lg-3 col-md-4 col-sm-6 col-6"> 
            <div class="feature-box">
                
                @php
                    $route = '#';
                    $category_name ?? '';

                    switch($category_name) {
                        case 'Business':
                            $route = route('business_page.front.single.listing', $location->slug);
                            break;
                        case 'Jobs':
                            $route = route('jobpost', $location->slug);
                            break;
                        case 'Shopping':
                            $route = route('shopping_post_single', $location->slug);
                            break;
                        case 'Fundraisers':
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
                    }
                @endphp

                <a href="{{ $route }}">
                    @php
                        $img = [];
                        if (isset($location->image1)) {
                            $newImg = trim($location->image1, '[""]');
                            $img = $newImg ? explode('","', $newImg) : [];
                        } elseif (isset($location->business_logo)) {
                            $img = explode(',', $location->business_logo);
                        } elseif ($location->image) {
                            $img = explode(',', $location->image);
                        }
                    @endphp

                    @if(!empty($img))
                        @php $carouselId = 'carousel-' . $location->id; @endphp
                        <div id="{{ $carouselId }}" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @foreach($img as $index => $image)
                                    @php
                                        $imagePath = 'images_blog_img/' . $image;
                                        if (!file_exists(public_path($imagePath))) {
                                            $imagePath = file_exists(public_path('images_entrtainment/' . $image)) 
                                                ? 'images_entrtainment/' . $image 
                                                : 'business_img/' . $image;
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
                            $totalRating = $allreview->where('product_id', $location->id)->sum('rating');
                            $totalReviews = $allreview->where('product_id', $location->id)->count();
                            $averageRating = $totalReviews ? $totalRating / $totalReviews : 0;
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
                        <div class="location-job-title">
                            <div class="job-type">
                                <div class="main-days-frame">
                                    <span class="days-box">
                                        @php
                                            $timeAgo = now()->diffInDays($location->created ?? $location->created_at) > 0 
                                                ? (now()->diffInDays($location->created ?? $location->created_at) . ' days ago')
                                                : 'Posted today';
                                        @endphp
                                        {{ $timeAgo }}
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
    <div class="div_blank text-center p-5">
        <h5>No data found under this category.</h5>
    </div>
@endif
