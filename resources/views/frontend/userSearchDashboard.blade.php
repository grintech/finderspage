<style>
    .mem-result .job-p {
        padding: 3px;
    }
    .job-type .thumbnail-video {
        width: 45px;
        height: 45px;
        position: relative;
        border-radius: 10px;
    }
</style>

@if($results['users']->isNotEmpty())
    <h5 class="headings ml-2">
        Members
    </h5>
    @foreach($results['users'] as $user)
        <li class="dropdown-item">
            <a href="{{ route('UserProfileFrontend', $user->slug) }}" class="d-flex align-items-center">
                @if($user->image)
                    <img src="{{ asset('assets/images/profile') }}/{{ $user->image }}" alt="{{ $user->first_name }}" class="img-thumbnail mr-2" style="width: 45px; height: 45px;">
                @else
                    <img src="{{ asset('user_dashboard/img/undraw_profile.svg') }}" alt="no image" class="img-thumbnail mr-2" style="width: 45px; height: 45px;">
                @endif
                <p class="my-auto">{{ $user->first_name }}</p>
            </a>
        </li>
    @endforeach
    <hr>
@endif

@if($results['blogPosts']->isNotEmpty())
    <h5 class="headings ml-2">
        Posts
    </h5>
    @foreach($results['blogPosts'] as $post)
        <?php $img = explode(',', $post->image); ?>
        <li class="dropdown-item">
            <a href="{{ route('blogPostSingle', $post->slug) }}" class="d-flex align-items-center">
                @if($post->image)
                    <img src="{{ asset('images_blog_img') }}/{{ $img[0] }}" alt="{{ $post->title }}" class="img-thumbnail mr-2" style="width: 45px; height: 45px;">
                @else
                    <img src="{{ asset('images_blog_img/1688636936.jpg') }}" alt="no image" class="img-thumbnail mr-2" style="width: 45px; height: 45px;">
                @endif
                <p class="my-auto">{{ $post->title }}</p>
            </a>
        </li>
    @endforeach
    <hr>
@endif

{{-- @if($results['videos']->isNotEmpty())
    <h5 class="headings ml-2">
        Videos
        <a href="{{ route('allVideos') }}" class="show-more-link">Show more</a>
    </h5>
    @foreach($results['videos'] as $video)
        <li class="dropdown-item">
            <a href="{{ route('single.video', $video->id) }}" class="d-flex align-items-center">
                @if($video->video)
                    <video class="thumbnail-video mr-2" style="width: 45px; height: 45px;">
                        <source src="{{ asset('video_short') }}/{{ $video->video }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                @else
                    <img src="{{ asset('images_blog_img/1688636936.jpg') }}" alt="no image" class="img-thumbnail mr-2" style="width: 45px; height: 45px;">
                @endif
                <p class="my-auto">{{ $video->title }}</p>
            </a>
        </li>
        <hr>
    @endforeach
@endif --}}

@if($results['entertainments']->isNotEmpty())
    <h5 class="headings ml-2">
        Entertainment
    </h5>
    @foreach($results['entertainments'] as $entertainment)
        <?php $img = explode(',', $entertainment->image); ?>
        <li class="dropdown-item">
            <a href="{{ route('Entertainment.single.listing', $entertainment->id) }}" class="d-flex align-items-center">
                @if($entertainment->image)
                    <?php $itemFeaturedImage = explode(',', trim($entertainment->image, '""')); ?>
                    <img src="{{ asset('images_entertainment') }}/{{ $itemFeaturedImage[0] }}" 
                    alt="Los Angeles" 
                    class="img-thumbnail mr-2" 
                    style="width: 45px; height: 45px;" 
                    onerror="this.onerror=null; this.src='{{ asset('images_blog_img/1688636936.jpg') }}';">
                @else
                    <img src="{{ asset('images_blog_img/1688636936.jpg') }}" alt="no image" class="img-thumbnail mr-2" style="width: 45px; height: 45px;">
                @endif
                <p class="my-auto">{{ $entertainment->Title }}</p>
            </a>
        </li>
    @endforeach
    <hr>
@endif

@if($results['business']->isNotEmpty())
    <h5 class="headings ml-2">Business</h5>
        @foreach($results['business'] as $post)
            @php $img = explode(',', $post->business_logo); @endphp
            <li class="dropdown-item">
                <a href="{{ route('business_page.front.single.listing', $post->slug) }}" class="d-flex align-items-center">
                    @if(!empty($post->business_logo) && isset($img[0]))
                        <img src="{{ asset('business_img/' . $img[0]) }}" alt="{{ $post->business_name }}" class="img-thumbnail mr-2" style="width: 45px; height: 45px;">
                    @else
                        <img src="{{ asset('images_blog_img/1688636936.jpg') }}" alt="No image" class="img-thumbnail mr-2" style="width: 45px; height: 45px;">
                    @endif
                    <p class="my-auto">{{ $post->business_name }}</p>
                </a>
            </li>
        @endforeach
    <hr>
@endif


@if($results['blogs']->isNotEmpty())
    <h5 class="headings ml-2">
        Ads
    </h5>
    @foreach($results['blogs'] as $blog)
        @php
            $routes = [
                '2' => 'jobpost',
                '4' => 'real_esate_post',
                '5' => 'community_single_post',
                '6' => 'shopping_post_single',
                '7' => 'single.fundraisers',
                '705' => 'service_single'
            ];

            $route = isset($routes[$blog->category_id]) ? route($routes[$blog->category_id], $blog->slug) : '#';
        @endphp
        <?php $img = explode(',', $blog->image1); ?>
        <li class="dropdown-item">
            <a href="{{ $route }}" class="d-flex align-items-center">
                @if($blog->image1)
                    <?php $itemFeaturedImage = explode('","', trim($blog->image1, '[""]')); ?>
                    <img src="{{ asset('images_blog_img') }}/{{ $itemFeaturedImage[0] }}" 
                    alt="Los Angeles" 
                    class="img-thumbnail mr-2" 
                    style="width: 45px; height: 45px;" 
                    onerror="this.onerror=null; this.src='{{ asset('images_blog_img/1688636936.jpg') }}';">
                @else
                    <img src="{{ asset('images_blog_img/1688636936.jpg') }}" alt="no image" class="img-thumbnail mr-2" style="width: 45px; height: 45px;">
                @endif
                <p class="my-auto">{{ $blog->title }}</p>
            </a>
        </li>
    @endforeach
@endif
