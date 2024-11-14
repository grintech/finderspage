@php
use App\Models\Setting;
@endphp
<style>
.button-sell span a {margin: 0 !important;}
.main-days-frame .days-frame {
    font-size: 15px !important;
    color: rgba(0,0,0,1) !important;
    font-weight: normal !important;
}
</style>
@if($Filter_data->isEmpty())
    <div class="div_blank text-center p-5">
        <h5>No data found under this category.</h5>
    </div>
@else
    {{-- @if($id == 728)
    <div class="heading text-center">
    <h6 class="py-3"> Explore what's new from your connections and what the world has to say.</h6>
    </div>
    @endif --}}

    @foreach($Filter_data as $services)
        <div class="col-lg-3 col-md-4 col-sm-6 col-6 ">
            <div class="feature-box afterBefor" style="position: relative;">
                @if($services->bumpPost == 1)
                    <div class="ribbon bump-ribbon">
                        <div class="text-div">
                            Bumped
                        </div>
                    </div>
                @endif

                @if($services->featured_post == "on" || $services->featured == "on")
                    <span class="onsale">Featured!</span>
                @endif

                @if($id == 705)
                    @if($services->available_now == 1)
                    <div class="ring-container1" >
                        <div class="av-now">Available</div>
                    </div>
                    @endif
                @endif

                @if($id == 1)
                    <a href="{{route('business_page.front.single.listing',$services->slug)}}">
                @elseif($id == 2)
                    <a href="{{route('jobpost',$services->slug)}}">
                @elseif($id == 4)
                    <a href="{{route('real_esate_post',$services->slug)}}">
                @elseif($id == 5)
                    <a href="{{route('community_single_post',$services->slug)}}">
                @elseif($id == 6)
                    <a href="{{route('shopping_post_single',$services->slug)}}">
                @elseif($id == 7)
                    <a href="{{route('single.fundraisers', $services->slug)}}">
                @elseif($id == 705)
                    <a href="{{route('service_single',$services->slug)}}">
                {{-- @elseif($id == 728)
                    <a href="{{route('blogPostSingle',$services->slug)}}"> --}}
                @elseif($id == 741)
                    <a href="{{route('Entertainment.single.listing',$services->slug)}}">
                @endif
                    <div class="img-area"> 
                        @if($id == 1) 
                            @php
                                $img = explode(',', $services->business_logo);
                            @endphp
                            @if($services->business_logo)
                                <img src="{{asset('business_img')}}/{{$img[0]}}" alt="{{$services->business_name}}" class="d-block w-100">
                            @else
                                <img src="{{asset('images_blog_img/1688636936.jpg')}}" alt="New York" class="d-block w-100">
                            @endif             
                        @elseif($id == 2)
                            <?php
                                $neimg = trim($services->image1, '[""]');
                                $img  = explode('","', $neimg);
                            ?>
                            @if($services->image1)
                                <img src="{{asset('images_blog_img')}}/{{$img[0]}}" alt="{{$services->title}}" class="d-block w-100">
                            @else
                                <img src="{{asset('images_blog_img/1688636936.jpg')}}" alt="New York" class="d-block w-100">
                            @endif
                        @elseif($id == 4)
                            <?php
                                $neimg = trim($services->image1, '[""]');
                                $img  = explode('","', $neimg);
                            ?>
                            @if($services->image1)
                                <img src="{{asset('images_blog_img')}}/{{$img[0]}}" alt="{{$services->title}}" class="d-block w-100">
                            @else
                                <img src="{{asset('images_blog_img/1688636936.jpg')}}" alt="New York" class="d-block w-100">
                            @endif
                        @elseif($id == 5)
                            <?php
                                $neimg = trim($services->image1, '[""]');
                                $img  = explode('","', $neimg);
                            ?>
                            @if($services->image1)
                                <img src="{{asset('images_blog_img')}}/{{$img[0]}}" alt="{{$services->title}}" class="d-block w-100">
                                @else
                                <img src="{{asset('images_blog_img/1688636936.jpg')}}" alt="New York" class="d-block w-100">
                            @endif
                        @elseif($id == 6)
                            <?php
                                $neimg = trim($services->image1, '[""]');
                                $img  = explode('","', $neimg);
                            ?>
                            @if($services->image1)
                                <img src="{{asset('images_blog_img')}}/{{$img[0]}}" alt="{{$services->title}}" class="d-block w-100">
                            @else
                                <img src="{{asset('images_blog_img/1688636936.jpg')}}" alt="New York" class="d-block w-100">
                            @endif
                        @elseif($id == 705)
                            <?php
                                $neimg = trim($services->image1, '[""]');
                                $img  = explode('","', $neimg);
                            ?>
                            @if($services->image1)
                                <img src="{{asset('images_blog_img')}}/{{$img[0]}}" alt="{{$services->title}}" class="d-block w-100">
                            @else
                                <img src="{{asset('images_blog_img/1688636936.jpg')}}" alt="New York" class="d-block w-100">
                            @endif

                        {{-- @elseif($id == 728)
                            @php
                                $img  = explode(',', $services->image);
                            @endphp
                            @if($services->image)
                                <img src="{{asset('images_blog_img')}}/{{$img[0]}}" alt="{{$services->title}}" class="d-block w-100">
                                @else
                                <img src="{{asset('images_blog_img/1688636936.jpg')}}" alt="New York" class="d-block w-100">
                            @endif --}}
                        @elseif($id == 741)
                            <?php
                                $img  = explode(',', $services->image);
                            ?>
                            @if($services->image)
                                <img src="{{asset('images_entrtainment')}}/{{$img[0]}}" alt="{{$services->Title}}" class="d-block w-100">
                                @else
                                <img src="{{asset('images_blog_img/1688636936.jpg')}}" alt="New York" class="d-block w-100">
                            @endif
                        @endif
                    </div>

                    <div class="job-post-content">
                        @php
                        if ($id == 1) {
                            echo '<h4>' . $services->business_name . '</h4>';
                        } elseif (in_array($id, [2, 4, 5, 7, 705])) {
                            echo '<h4>' . $services->title . '</h4>';
                        } elseif ($id == 741) {
                            echo '<h4>' . $services->Title . '</h4>';
                        } else {
                            echo '<h6 class="product-title">' . ucfirst($services->title) . '</h4>';
                        }
                        @endphp
                        
                        @if ($id == 6)
                            <div class="price" style="font-size: 15px;padding: 0px 0px;"><del>${{$services->product_price}}</del> ${{$services->product_sale_price}}</div>
                            @php
                                $totalRating = $allreview->where('product_id', $services->id)->sum('rating');
                                $totalReviews = $allreview->where('product_id', $services->id)->count();
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
                                    <span class="likes-box">{{ $services->likes }}</span>
                                </div>
                            </div>
                        @else
                            <div class="main-days-frame">
                                <span class="days-box">
                                    <?php
                                        if($id == 1) {
                                            $givenTime = strtotime($services->created_at);
                                        }elseif($id == 2){
                                            $givenTime = strtotime($services->created);
                                        }elseif($id == 4){
                                            $givenTime = strtotime($services->created);
                                        }elseif($id == 5){
                                            $givenTime = strtotime($services->created);
                                        // }elseif($id == 6){
                                        //     $givenTime = strtotime($services->created);
                                        }elseif($id == 7){
                                            $givenTime = strtotime($services->created);
                                        }elseif($id == 705){
                                            $givenTime = strtotime($services->created);
                                        // }elseif($id == 728){
                                        //     $givenTime = strtotime($services->created_at);
                                        }elseif($id == 741){
                                            $givenTime = strtotime($services->created_at);
                                        }

                                        $days = floor((time() - $givenTime) / (60 * 60 * 24));
                                        echo $days > 0 ? Setting::get_formeted_time($days) : 'Posted today.';
                                    ?>
                                </span>
                            </div>
                            <div class="likes-frame d-flex justify-content-end">
                                <i class="fa-regular fa-thumbs-up me-2 mt-1"></i>
                                <span class="likes-box">{{ $services->likes }}</span>
                            </div>
                        @endif

                        <div class="button-sell" style="margin-top: 0px;">
                            @if($id == 1)
                                <span><a href="{{ route('business_page.front.single.listing',$services->slug) }}" class="btn create-post-button" data-product-id="{{ $services->id }}">View details</a></span>
                            @elseif($id == 2)
                                <span><a href="{{ route('jobpost',$services->slug) }}" class="btn create-post-button" data-product-id="{{ $services->id }}">View details</a></span>
                            @elseif($id == 4)
                                <span><a href="{{ route('real_esate_post',$services->slug) }}" class="btn create-post-button" data-product-id="{{ $services->id }}">View details</a></span>
                            @elseif($id == 5)
                                <span><a href="{{ route('community_single_post',$services->slug) }}" class="btn create-post-button" data-product-id="{{ $services->id }}">View details</a></span>
                            @elseif($id == 6)
                                <span><a href="{{ route('shopping_post_single',$services->slug) }}" class="btn create-post-button" data-product-id="{{ $services->id }}">View details</a></span>
                            @elseif($id == 7)
                                <span><a href="{{ route('single.fundraisers',$services->slug) }}" class="btn create-post-button" data-product-id="{{ $services->id }}">View details</a></span>
                            @elseif($id == 705)
                                <span><a href="{{ route('service_single',$services->slug) }}" class="btn create-post-button" data-product-id="{{ $services->id }}">View details</a></span>
                            {{-- @elseif($id == 728)
                                <span><a href="{{ route('blogPostSingle',$services->slug) }}" class="btn create-post-button" data-product-id="{{ $services->id }}">Read more</a></span> --}}
                            @elseif($id == 741)
                                <span><a href="{{ route('Entertainment.single.listing',$services->slug) }}" class="btn create-post-button" data-product-id="{{ $services->id }}">View details</a></span>
                            @endif
                        </div>
                    </div>
                </a>
            </div>
        </div>
    @endforeach

@endif