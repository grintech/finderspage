@php
use App\Models\UserAuth;
@endphp

@extends('layouts.user_dashboard.userdashboardlayout')
@section('content')

<style>
    .fields-search {
        color: #000 !important;
    }
</style>

<section id="post-listing" class="post-listing">
    <div class="container">

        <div class="row justify-content-end">
            <div class="col-lg-12">
                <span>
                    @include('admin.partials.flash_messages')
                </span>
                <h3 class="d-inline"><b>Deleted Data</b></h3>

                <div id="btnContainer" class="d-block mt-3">
                    <a href="javascript:void(0)" class="btn b1" data-view="grid" onclick="toggleView('grid')">
                        <i class="fa fa-th"></i>
                    </a>
                    <a href="javascript:void(0)" class="btn b1 active" data-view="list" onclick="toggleView('list')">
                        <i class="fa fa-bars"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="py-2">
            <div class="alert alert-info" role="alert">
            Only you can see your recently deleted data. It will be permanently deleted after the number of days shown. It expires in 30 days. After that, you won't be able to restore it.
            </div>
        </div>
        {{-- <hr>
        <h3 class="text-center">Deleted Blog Posts</h3>
        <div class="row my-4">
            @php
                $count = $blogs_data->count();
            @endphp
            
            @forelse ($blogs_data as $blogPost)
              @if($blogPost->user_id == UserAuth::getLoginid())
                <div class="col-lg-4 col-md-6 mb-4 blog-post-listing" data-id="{{ $blogPost->id }}">
                    <div class="card">
                        <div class="card-body">
                            <div class="pic">
                                @php
                                    $categoryId = 728;
                                    $itemFeaturedImages = explode(',', $blogPost->image);
                                    $itemFeaturedImages = array_filter($itemFeaturedImages, 'strlen');
                                    $itemFeaturedImages = array_values($itemFeaturedImages);
                                @endphp
        
                                @if(is_array($itemFeaturedImages))
                                    @foreach ($itemFeaturedImages as $keyitemFeaturedImage => $valueitemFeaturedImage)
                                        <div class="carousel-item {{ $keyitemFeaturedImage == 0 ? 'active' : 'in-active' }}">
                                            <img src="{{ asset('images_blog_img') }}/{{ $valueitemFeaturedImage }}" alt="Image" class="img-fluid d-block w-100" onerror="this.onerror=null; this.src='https://www.finderspage.com/public/images_blog_img/1688636936.jpg';">
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="caption-frame">
                                <h4>{{ $blogPost->title }}</h4>
                                @php    
                                    $timestamp = (strtotime($blogPost->created_at));
                                    $date = date('j-n-Y', $timestamp); 
                                @endphp
                                <p>{{ $date }}</p>
                            </div>
                            <div class="frame-inner">
                                <table class="table">
                                    <tbody>
                                        <tr class="action-list">
                                            <th valign="center">
                                                <a href="{{ route('deleted.restore.data', ['id' => $blogPost->id, 'type' => 'BlogPost']) }}" class="btn" data-toggle="tooltip" data-placement="top" title="Delete">Delete</a>
                                            </th>
                                            <td colspan="3" class="btn-list">
                                                <a href="{{ route('getPostsdeleted.restore', ['id' => $blogPost->id, 'type' => 'BlogPost']) }}" class="btn" data-toggle="tooltip" data-placement="top" title="Restore">Restore</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
              @endif
            @empty
                <div class="col-lg-12 text-center">
                    <p>No item here.</p>
                </div>
            @endforelse
        
            @if($count > 3)
                <div class="col-lg-12 text-center mt-4">
                    <a href="{{ url('restore-single-listing', [$categoryId]) }}" class="btn fields-search text-center">View All</a>
                </div>
            @endif
        </div> --}}
        
        <hr />

        @php
            $categories = [
                ['id' => 2, 'title' => 'Job Posts', 'route' => 'restore-single-listing'],
                ['id' => 4, 'title' => 'Real Estate Posts', 'route' => 'restore-single-listing'],
                ['id' => 5, 'title' => 'Community Posts', 'route' => 'restore-single-listing'],
                ['id' => 6, 'title' => 'Shopping Posts', 'route' => 'restore-single-listing'],
                ['id' => 7, 'title' => 'Fundraiser Posts', 'route' => 'restore-single-listing'],
                ['id' => 705, 'title' => 'Services Posts', 'route' => 'restore-single-listing']
            ];
        @endphp

        @foreach($categories as $category)
            @php
                $blogs = $matchingRecords->where('category_id', $category['id']);
                $count = $blogs->count();
                $displayedBlogs = $blogs->take(3);
            @endphp

            <h3 class="text-center">Deleted {{ $category['title'] }} </h3>
            <div class="row mb-4">
                @forelse($displayedBlogs as $blog)
                    <div class="col-lg-4 col-md-6 mb-4 job-post-listing" data-id="{{ $blog->id }}">
                        <div class="card">
                            <div class="card-body">
                                <div class="pic">
                                    @php
                                        $itemFeaturedImages = trim($blog->image1, '[""]');
                                        $itemFeaturedImages = explode('","', $itemFeaturedImages);
                                    @endphp

                                    @if(is_array($itemFeaturedImages))
                                        @foreach ($itemFeaturedImages as $keyitemFeaturedImage => $valueitemFeaturedImage)
                                            <div class="carousel-item {{ $keyitemFeaturedImage == 0 ? 'active' : 'in-active' }}">
                                                <img src="{{ asset('images_blog_img') }}/{{ $valueitemFeaturedImage }}" alt="Image" class="img-fluid d-block w-100" onerror="this.onerror=null; this.src='https://www.finderspage.com/public/images_blog_img/1688636936.jpg';">
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="caption-frame">
                                    <h4>{{ $blog->title }}</h4>
                                    <?php $timestamp = (strtotime($blog->created));
                                      $date = date('j-n-Y', $timestamp); ?>
                                <p>{{ $date }}</p>
                                    <!-- <p>{{ $blog->created }}</p> -->
                                </div>
                                <div class="frame-inner">
                                    <table class="table">
                                        <tbody>
                                            <tr class="action-list">
                                                <th valign="center">
                                                    <a href="{{ route('deleted.restore.data', ['id' => $blog->id, 'type' => 'Blogs']) }}" class="btn" data-toggle="tooltip" data-placement="top" title="Delete">Delete</a>
                                                </th>
                                                <td colspan="3" class="btn-list">
                                                    <a href="{{ route('getPostsdeleted.restore', ['id' => $blog->id, 'type' => 'Blogs']) }}" class="btn" data-toggle="tooltip" data-placement="top" title="Restore">Restore</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-lg-12 text-center">
                        <p>No item here.</p>
                    </div>
                @endforelse

                @if($count > 3)
                    <div class="col-lg-12 text-center mt-4">
                        <a href="{{ url( $category['route'], [$category['id']]) }}" class="btn fields-search text-center">View All</a>
                    </div>
                @endif
            </div>
          <hr />
        @endforeach

        <h3 class="text-center">Deleted Entertainment Posts</h3>
        <div class="row my-4">
            @php
                $count = $entertainment_data->count();
            @endphp
        
            @forelse ($entertainment_data as $entertainment)
              @if($entertainment->user_id == UserAuth::getLoginid())
                <div class="col-lg-4 col-md-6 mb-4 blog-post-listing" data-id="{{ $entertainment->id }}">
                    <div class="card">
                        <div class="card-body">
                            <div class="pic">
                                @php
                                    $categoryId = 741;
                                    $itemFeaturedImages = explode(',', $entertainment->image);
                                    // $itemFeaturedImages = array_filter($itemFeaturedImages, 'strlen');
                                    // $itemFeaturedImages = array_values($itemFeaturedImages);
                                @endphp

                                @if(is_array($itemFeaturedImages))
                                    @foreach ($itemFeaturedImages as $keyitemFeaturedImage => $valueitemFeaturedImage)
                                        <div class="carousel-item {{ $keyitemFeaturedImage == 0 ? 'active' : 'in-active' }}">
                                            <img src="{{ asset('images_entrtainment') }}/{{ $valueitemFeaturedImage }}" alt="Image" class="img-fluid d-block w-100" onerror="this.onerror=null; this.src='https://www.finderspage.com/public/images_entrtainment/1688636936.jpg';">
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="caption-frame">
                                <h4>{{ $entertainment->Title }}</h4>
                                <?php $timestamp = (strtotime($entertainment->created_at));
                                      $date = date('j-n-Y', $timestamp); ?>
                                <p>{{ $date }}</p>
                                <!-- <p>{{ $entertainment->created_at }}</p> -->
                            </div>
                            <div class="frame-inner">
                                <table class="table">
                                    <tbody>
                                        <tr class="action-list">
                                            <th valign="center">
                                                <a href="{{ route('deleted.restore.data', ['id' => $entertainment->id, 'type' => 'Entertainment']) }}" class="btn" data-toggle="tooltip" data-placement="top" title="Delete">Delete</a>
                                            </th>
                                            <td colspan="3" class="btn-list">
                                                <a href="{{ route('getPostsdeleted.restore', ['id' => $entertainment->id, 'type' => 'Entertainment']) }}" class="btn" data-toggle="tooltip" data-placement="top" title="Restore">Restore</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
              @endif
            @empty
                <div class="col-lg-12 text-center">
                    <p>No item here.</p>
                </div>
            @endforelse

            
            @if($count > 3)
                <div class="col-lg-12 text-center mt-4">
                    <a href="{{ url('restore-single-listing', [$categoryId]) }}" class="btn fields-search text-center">View All</a>
                </div>
            @endif
        </div>

        <hr />

        <h3 class="text-center">Deleted Business Posts</h3>
        <div class="row my-4">
            @php
                $business_count = $business_data->count();
                $business_data = $business_data->take(3);
            @endphp
        
            @forelse ($business_data as $business)
                <div class="col-lg-4 col-md-6 mb-4 blog-post-listing" data-id="{{ $business->id }}">
                    <div class="card">
                        <div class="card-body">
                            <div class="pic">
                                @php
                                    $categoryId = 1;
                                    $itemFeaturedImages = explode(',', $business->business_logo);
                                @endphp
        
                                @if(is_array($itemFeaturedImages))
                                    @foreach ($itemFeaturedImages as $keyitemFeaturedImage => $valueitemFeaturedImage)
                                        <div class="carousel-item {{ $keyitemFeaturedImage == 0 ? 'active' : 'in-active' }}">
                                            <img src="{{ asset('business_img') }}/{{ $valueitemFeaturedImage }}" alt="Image" class="img-fluid d-block w-100" onerror="this.onerror=null; this.src='https://www.finderspage.com/public/images_entrtainment/1688636936.jpg';">
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="caption-frame">
                                <h4>{{ $business->business_name }}</h4>
                                <p>{{ date('j-n-Y', strtotime($business->created_at)) }}</p>
                            </div>
                            <div class="frame-inner">
                                <table class="table">
                                    <tbody>
                                        <tr class="action-list">
                                            <th valign="center">
                                                <a href="{{ route('deleted.restore.data', ['id' => $business->id, 'type' => 'Business']) }}" class="btn" data-toggle="tooltip" data-placement="top" title="Delete">Delete</a>
                                            </th>
                                            <td colspan="3" class="btn-list">
                                                <a href="{{ route('getPostsdeleted.restore', ['id' => $business->id, 'type' => 'Business']) }}" class="btn" data-toggle="tooltip" data-placement="top" title="Restore">Restore</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-lg-12 text-center">
                    <p>No item here.</p>
                </div>
            @endforelse
        
            @if($business_count > 3)
                <div class="col-lg-12 text-center mt-4">
                    <a href="{{ url('restore-single-listing', [$categoryId]) }}" class="btn fields-search text-center">View All</a>
                </div>
            @endif
        </div>        


    </div>
</section>

@endsection
