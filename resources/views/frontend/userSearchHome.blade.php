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
@if($users->isEmpty() && $blogPost->isEmpty() && $video->isEmpty() 
    && $entertainment->isEmpty() && $blogs->isNotEmpty() && $business->isNotEmpty()) 
       <p>No results found.</p>
@endif

@if ($users->isNotEmpty())
<h2 class="headings">Members</h2>
    @foreach($users as $Records)
    <a href="{{route('UserProfileFrontend',$Records->slug)}}">
        <div class="job-type job-p mt-1">
            @if($Records->image)
            <img src="{{asset('assets/images/profile')}}/{{$Records->image}}" alt="{{$Records->first_name}}">
            @else
            <img src="{{asset('user_dashboard/img/undraw_profile.svg')}}" alt="no image" class="d-block">
            @endif
            <p><small>{{$Records->first_name}}</small></p>

        </div>
    </a>
    @endforeach
@endif

@if ($blogPost->isNotEmpty())
<h2 class="headings">Posts</h2>
    @foreach($blogPost as $Records)
    <?php
    $img  = explode(',', $Records->image);
    ?>
    <a href="{{route('blogPostSingle',$Records->slug)}}">
        <div class="job-type job-p mt-1">
            @if($Records->image)
            <img src="{{asset('images_blog_img')}}/{{$img[0]}}" alt="{{$Records->title}}">
            @else
            <img src="{{asset('images_blog_img/1688636936.jpg')}}" alt="no image" class="d-block">
            @endif
            <p><small>{{$Records->title}}</small></p>

        </div>
    </a>
    <hr>
    @endforeach
@endif

@if ($video->isNotEmpty())
<h2 class="headings">Videos</h2>
    @foreach($video as $Records)
    <a href="{{route('single.video',$Records->id)}}">
        <div class="job-type job-p mt-1">
            @if($Records->video)
            <video class="thumbnail-video">
                <source src="{{asset('video_short')}}/{{$Records->video}}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            @else
            <img src="{{asset('images_blog_img/1688636936.jpg')}}" alt="no image" class="d-block">
            @endif
            <p><small>{{$Records->title}}</small></p>

        </div>
    </a>
    <hr>
    @endforeach
@endif

@if ($entertainment->isNotEmpty())
<h2 class="headings">Entertainment</h2>
    @foreach($entertainment as $Record)
    <?php
    $img  = explode(',', $Record->image);
    ?>

    <a href="{{route('Entertainment.single.listing',$Record->slug)}}">
        <div class="job-type job-p mt-1">
            @if($Record->image)
            <?php
            $itemFeaturedImages = trim($Record->image, '""');
            $itemFeaturedImage  = explode(',', $itemFeaturedImages);
            // echo "<pre>";print_r($itemFeaturedImage);die('bdeve');
            ?>
            <div>
                <img src="{{asset('images_entrtainment')}}/{{ $itemFeaturedImage[0] }}" 
                alt="Los Angeles" 
                class="img-thumbnail mr-2" 
                style="width: 45px; height: 45px;" 
                onerror="this.onerror=null; this.src='{{ asset('images_blog_img/1688636936.jpg') }}';">
            </div>
            @else
            <img src="{{asset('images_blog_img/1688636936.jpg')}}" alt="no image" class="d-block">
            @endif
            <p><small>{{$Record->Title}}</small></p>

        </div>
    </a>
    @endforeach
@endif

@if ($business->isNotEmpty())
<h2 class="headings">Business</h2>
    @foreach($business as $Record)
    <?php
    $img  = explode(',', $Record->business_logo);
    ?>

    <a href="{{route('business_page.front.single.listing',$Record->slug)}}">
        <div class="job-type job-p mt-1">
            @if($Record->business_logo)
            <?php
            $itemFeaturedImages = trim($Record->business_logo, '""');
            $itemFeaturedImage  = explode(',', $itemFeaturedImages);
            ?>
            <div>
                <img src="{{asset('business_img')}}/{{ $itemFeaturedImage[0] }}" 
                alt="Los Angeles" 
                class="img-thumbnail mr-2" 
                style="width: 45px; height: 45px;" 
                onerror="this.onerror=null; this.src='{{ asset('images_blog_img/1688636936.jpg') }}';">
            </div>
            @else
            <img src="{{asset('images_blog_img/1688636936.jpg')}}" alt="no image" class="d-block">
            @endif
            <p><small>{{$Record->business_name}}</small></p>
        </div>
    </a>
    @endforeach
@endif

@if ($blogs->isNotEmpty())
<h2 class="headings">Ads</h2>
    @foreach($blogs as $blog)
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
        <a href="{{ $route }}">
            <div class="job-type job-p mt-1">
                @if($blog->image1)
                    <?php $itemFeaturedImage = explode('","', trim($blog->image1, '[""]')); ?>
                    <img src="{{ asset('images_blog_img') }}/{{ $itemFeaturedImage[0] }}" 
                    alt="Los Angeles" 
                    class="img-thumbnail mr-2" 
                    style="width: 45px; height: 45px;" 
                    onerror="this.onerror=null; this.src='{{ asset('images_blog_img/1688636936.jpg') }}';">
                @else
                    <img src="{{ asset('images_blog_img/1688636936.jpg') }}" alt="no image" class="d-block">
                @endif
                <p><small>{{ $blog->title }}</small></p>
            </div>
        </a>
    <hr>
    @endforeach
@endif