<section class="blog-videos-posts-tab py-4">
    <div class="container px-lr">
        <div class="row justify-content-center">
            @if ($Blogs->isNotEmpty())
                @php
                    $countBlog = $Blogs->count();
                @endphp
                <div class="col-lg-12">
                    <h4 class="text-center">My Posts</h4>
                </div>
                @foreach ($Blogs as $blog)
                    <div class="col-lg-3 col-md-4 gx-5">
                        <div class="card latest-blog-box">
                            <a href="{{route('blogPostSingle', $blog->slug )}}">
                                <?php
                                    $itemFeaturedImage  = explode(',', $blog->image);
                                    $imageUrl = isset($itemFeaturedImage[0]) && !empty($itemFeaturedImage[0]) ? asset("images_blog_img/" . $itemFeaturedImage[0]) : asset("images_blog_img/1688636936.jpg");
                                ?>
                                <img src="{{ $imageUrl }}" class="card-img-top" alt="img">
                                <div class="card-body p-4">
                                    <h5 class="card-title">{{ $blog->title }}</h5>
                                </div>
                                <div class="card-footer">
                                    <small class="text-muted">Last updated {{ $blog->created_at->diffForHumans() }}</small>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            {{-- @elseif ($video->isNotEmpty())
                @include('frontend.savedPost.content-section', [
                    'title' => 'My Videos',
                    'items' => $video,
                    'routeName' => 'single.video',
                    'imagePath' => 'video_short',
                    'isVideo' => true
                ]) --}}


            @elseif ($realestateCount->isNotEmpty())
                <div class="col-lg-12">
                    <h4 class="text-center">My Real Estate</h4>
                </div>
                @foreach ($realestateCount as $realestate)
                    <div class="col-lg-3 col-md-4 gx-5">
                        <div class="card latest-blog-box">
                            <a href="{{route('real_esate_post', $realestate->slug )}}">
                                <?php
                                    $image = trim($realestate->image1, '[""]');
                                    $itemFeaturedImage = explode(',', trim($image, '[]'));
                                    $imageUrl = isset($itemFeaturedImage[0]) && !empty($itemFeaturedImage[0]) ? asset("images_blog_img/" . $itemFeaturedImage[0]) : asset("images_blog_img/1688636936.jpg");
                                ?>
                                <img src="{{ $imageUrl }}" class="card-img-top" alt="img">
                                <div class="card-body p-4">
                                    <h5 class="card-title">{{ $realestate->title }}</h5>
                                </div>
                                <div class="card-footer">
                                    <small class="text-muted">
                                        Last updated {{ \Carbon\Carbon::parse($realestate->created)->diffForHumans() }}
                                    </small>   
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach

                @elseif ($shoppingCount->isNotEmpty())
                <div class="col-lg-12">
                    <h4 class="text-center">My Shop</h4>
                </div>
                @foreach ($shoppingCount as $shopping)
                    <div class="col-lg-3 col-md-4 gx-5">
                        <div class="card latest-blog-box">
                            <a href="{{ route('shopping_post_single', $shopping->slug) }}">
                                @php
                                    $image = trim($shopping->image1, '[""]');
                                    $itemFeaturedImage = explode(',', trim($image, '[]'));
                                    $imageUrl = !empty($itemFeaturedImage[0]) ? asset("images_blog_img/" . trim($itemFeaturedImage[0], '"')) : asset("images_blog_img/1688636936.jpg");
                                @endphp
                                <img src="{{ $imageUrl }}" class="card-img-top" alt="img">
                                <div class="card-body p-4">
                                    <h5 class="card-title">{{ $shopping->title }}</h5>
                                </div>
                                <div class="card-footer">
                                    <small class="text-muted">
                                        Last updated {{ \Carbon\Carbon::parse($shopping->created)->diffForHumans() }}
                                    </small>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            

            @elseif ($fundraisersCount->isNotEmpty())
                <div class="col-lg-12">
                    <h4 class="text-center">Fundraisers</h4>
                </div>
                @foreach ($fundraisersCount as $fundraisers)
                    <div class="col-lg-3 col-md-4 gx-5">
                        <div class="card latest-blog-box">
                            <a href="{{route('single.fundraisers', $fundraisers->slug )}}">
                                <?php
                                    $image = trim($fundraisers->image1, '[""]');
                                    $itemFeaturedImage = explode(',', trim($image, '[]'));
                                    $imageUrl = isset($itemFeaturedImage[0]) && !empty($itemFeaturedImage[0]) ? asset("images_blog_img/" . $itemFeaturedImage[0]) : asset("images_blog_img/1688636936.jpg");
                                ?>
                                <img src="{{ $imageUrl }}" class="card-img-top" alt="img">
                                <div class="card-body p-4">
                                    <h5 class="card-title">{{ $fundraisers->title }}</h5>
                                </div>
                                <div class="card-footer">
                                    <small class="text-muted">
                                        Last updated {{ \Carbon\Carbon::parse($fundraisers->created)->diffForHumans() }}
                                    </small>   
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
                
            @elseif ($Business_count->isNotEmpty())
                <div class="col-lg-12">
                    <h4 class="text-center">My Business</h4>
                </div>
                @foreach ($Business_count as $Business)
                    <div class="col-lg-3 col-md-4 gx-5">
                        <div class="card latest-blog-box">
                            <a href="{{ route('business_page.front.single.listing', $Business->slug) }}">
                                @php
                                    $itemFeaturedImage = explode(',', $Business->business_logo);
                                    $imageUrl = !empty($itemFeaturedImage[0]) ? asset("business_img/" . $itemFeaturedImage[0]) : asset("images_blog_img/1688636936.jpg");
                                @endphp
                                <img src="{{ $imageUrl }}" class="card-img-top" alt="{{ $Business->business_name  }}">
                                <div class="card-body p-4">
                                    <h5 class="card-title">{{ $Business->business_name  }}</h5>
                                </div>
                                <div class="card-footer">
                                    <small class="text-muted">
                                        Last updated {{ \Carbon\Carbon::parse($Business->created_at)->diffForHumans() }}
                                    </small>                                    
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach

            @elseif ($jobCount->isNotEmpty())
                <div class="col-lg-12">
                    <h4 class="text-center">My Jobs</h4>
                </div>
                @foreach ($jobCount as $job)
                    <div class="col-lg-3 col-md-4 gx-5">
                        <div class="card latest-blog-box">
                            <a href="{{ route('jobpost', $job->slug) }}">
                                @php
                                    $image = trim($job->image1, '[""]');
                                    $itemFeaturedImage = explode(',', trim($image, '[]'));
                                    $imageUrl = !empty($itemFeaturedImage[0]) ? asset("images_blog_img/" . $itemFeaturedImage[0]) : asset("images_blog_img/1688636936.jpg");
                                @endphp
                                <img src="{{ $imageUrl }}" class="card-img-top" alt="{{ $job->title }}">
                                <div class="card-body p-4">
                                    <h5 class="card-title">{{ $job->title }}</h5>
                                </div>
                                <div class="card-footer">
                                    <small class="text-muted">
                                        Last updated {{ \Carbon\Carbon::parse($job->created)->diffForHumans() }}
                                    </small>                                    
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach

            @elseif ($Entertainment_count->isNotEmpty())
                <div class="col-lg-12">
                    <h4 class="text-center">Entertainment</h4>
                </div>
                @foreach ($Entertainment_count as $Entertainment)
                    <div class="col-lg-3 col-md-4 gx-5">
                        <div class="card latest-blog-box">
                            <a href="{{route('Entertainment.single.listing', $Entertainment->slug )}}">
                                <?php
                                    $itemFeaturedImage  = explode(',', $Entertainment->image);
                                    $imageUrl = isset($itemFeaturedImage[0]) && !empty($itemFeaturedImage[0]) ? asset("images_entrtainment/" . $itemFeaturedImage[0]) : asset("images_blog_img/1688636936.jpg");
                                ?>
                                <img src="{{ $imageUrl }}" class="card-img-top" alt="img">
                                <div class="card-body p-4">
                                    <h5 class="card-title">{{ $Entertainment->Title }}</h5>
                                </div>
                                <div class="card-footer">
                                    <small class="text-muted">Last updated {{ $Entertainment->created_at->diffForHumans() }}</small>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach

            @elseif ($communityCount->isNotEmpty())
                <div class="col-lg-12">
                    <h4 class="text-center">My Community</h4>
                </div>
                @foreach ($communityCount as $community)
                    <div class="col-lg-3 col-md-4 gx-5">
                        <div class="card latest-blog-box">
                            <a href="{{route('community_single_post', $community->slug )}}">
                                <?php
                                    $image = trim($community->image1, '[""]');
                                    $itemFeaturedImage = explode(',', trim($image, '[]'));
                                    $imageUrl = isset($itemFeaturedImage[0]) && !empty($itemFeaturedImage[0]) ? asset("images_blog_img/" . $itemFeaturedImage[0]) : asset("images_blog_img/1688636936.jpg");
                                ?>
                                <img src="{{ $imageUrl }}" class="card-img-top" alt="img">
                                <div class="card-body p-4">
                                    <h5 class="card-title">{{ $community->title }}</h5>
                                </div>
                                <div class="card-footer">
                                    <small class="text-muted">
                                        Last updated {{ \Carbon\Carbon::parse($community->created)->diffForHumans() }}
                                    </small>   
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach

            @elseif ($servicesCount->isNotEmpty())
                <div class="col-lg-12">
                    <h4 class="text-center">Services</h4>
                </div>
                @foreach ($servicesCount as $services)
                    <div class="col-lg-3 col-md-4 gx-5">
                        <div class="card latest-blog-box">
                            <a href="{{route('service_single', $services->slug )}}">
                                <?php
                                    $image = trim($services->image1, '[""]');
                                    $itemFeaturedImage = explode(',', trim($image, '[]'));
                                    $imageUrl = isset($itemFeaturedImage[0]) && !empty($itemFeaturedImage[0]) ? asset("images_blog_img/" . $itemFeaturedImage[0]) : asset("images_blog_img/1688636936.jpg");
                                ?>
                                <img src="{{ $imageUrl }}" class="card-img-top" alt="img">
                                <div class="card-body p-4">
                                    <h5 class="card-title">{{ $services->title }}</h5>
                                </div>
                                <div class="card-footer">
                                    <small class="text-muted">
                                        Last updated {{ \Carbon\Carbon::parse($services->created)->diffForHumans() }}
                                    </small>   
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach

            @else
                <div class="col-lg-12 text-center">
                    <h4>No content is published by you at the moment.</h4>
                </div>
            @endif

        </div>
    </div>
</section>
