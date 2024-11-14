@php
    use App\Models\Setting;
    use App\Models\UserAuth;

    $loggedInUser = UserAuth::getloginuser();
@endphp
@extends('layouts.frontlayout')
@section('content')

<style>
    .latest-blog-box img {
        height: 200px;
    }
    .card-title {
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .carousel-control-prev, .carousel-control-next {
        display: none;
    }
    .go-back {
        background: linear-gradient(90deg, rgba(220, 114, 40, 1) 50%, #a54db7 100%);
        border-radius: 35px;
        border: 0px;
        box-shadow: none;
        color: #fff !important;
        padding: 6px 10px !important;
        font-size: 13px;
        font-weight: 500;
    }
</style>

<section class="latest-blog-post py-4">
    <div class="container px-lr">
        <div class="row justify-content-center">
            @if ($posts->isNotEmpty())
                <div class="col-lg-12">
                    <h4 class="text-center">Latest Posts</h4>
                </div>
                @foreach ($posts as $post)

                @php
                    $route = '#';

                    switch ($post->category_id) {
                        case 1:
                            $route = route('business_page.front.single.listing', $post->slug);
                            break;
                        case 2:
                            $route = route('jobpost', $post->slug);
                            break;
                        case 4:
                            $route = route('real_esate_post', $post->slug);
                            break;
                        case 5:
                            $route = route('community_single_post', $post->slug);
                            break;
                        case 6:
                            $route = route('shopping_post_single', $post->slug);
                            break;
                        case 7:
                            $route = route('single.fundraisers', $post->slug);
                            break;
                        case 705:
                            $route = route('service_single', $post->slug);
                            break;
                        case 741:
                            $route = route('Entertainment.single.listing', $post->slug);
                            break;
                        default:
                            $route = '#';
                            break;
                    }
                @endphp

                <div class="col-lg-3 col-md-4 gx-5">
                    <div class="card latest-blog-box">
                        <a class="card-link" href="{{ $route }}">
                            @php
                                if (isset($post->image1)) {
                                    $image = trim($post->image1, '[""]');
                                    $newImg = $image ? explode('","', $image) : [];
                                } elseif (isset($post->business_logo)) {
                                    $newImg = $post->business_logo ? explode(',', $post->business_logo) : [];
                                } else {
                                    $newImg = $post->image ? explode(',', $post->image) : [];
                                }
                            @endphp

                            @if(!empty($newImg))
                                @php
                                    $carouselId = 'carousel-' . $post->id;
                                @endphp
                                <div id="{{ $carouselId }}" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                        @foreach($newImg as $index => $image)
                                            @php
                                                $imagePath = 'images_blog_img/' . $image;
                                                if (isset($post->business_logo)) {
                                                    $imagePath = 'business_img/' . $image;
                                                } elseif (!file_exists(public_path($imagePath))) {
                                                    $imagePath = 'images_entrtainment/' . $image;
                                                }
                                            @endphp
                                            <div class="carousel-item @if($index == 0) active @endif">
                                                <img src="{{ asset($imagePath) }}" alt="{{ $post->Title ?? $post->title ?? $post->business_name }}" class="d-block w-100">
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

                            <div class="card-body p-4">
                                <h5 class="card-title">{{ ucfirst($post->title ?? $post->Title ?? $post->business_name) }}</h5>
                            </div>
                            <div class="card-footer">
                                @php
                                    $givenTime = strtotime($post->created ?? $post->created_at);
                                    $days = floor((time() - $givenTime) / (60 * 60 * 24));
                                @endphp
                                <small class="text-muted">Last updated: {{ $days > 0 ? Setting::get_formeted_time($days) : 'Posted today.' }}</small>
                            </div>
                        </a>
                    </div>
                </div>
                @endforeach
                <div class="col-12 text-center">
                    <a href="{{ URL::previous() }}">
                        <button class="go-back" type="button">Go Back</button>
                    </a>
                </div>
            @else
                <div class="col-12 text-center">
                    <h3 style="padding: 5% 0% 2% 0%; font-size: 20px;">Your friend has not publish any posts.</h3>
                    <a href="{{ URL::previous() }}">
                        <button class="go-back" type="button">Go Back</button>
                    </a>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
