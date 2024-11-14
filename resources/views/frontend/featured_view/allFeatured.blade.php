<?php use App\Models\Setting;?>
@if(isset($locations) && $locations->isNotEmpty())
    @foreach($locations as $location)
        <div class="col-lg-3 col-md-4 col-sm-6 col-6"> 
            <div class="feature-box">
                <span class="onsale">Featured!</span>

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
                            $img = $location->business_logo ? explode(',', $location->business_logo) : [];
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
                                        if (isset($location->business_logo)) {
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

                    <p class="job-title"><b>{{ ucfirst($location->Title ?? $location->title ?? $location->business_name ) }}</b></p>
                    <div class="location-job-title">
                        <div class="job-type">
                            <div class="main-days-frame">
                                <span class="days-box">
                                    @php
                                        $givenTime = strtotime($location->created ?? $location->created_at);
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
@else 
    <div class="div_blank text-center p-5">
        <h5>No data found under this category.</h5>
    </div>
@endif
