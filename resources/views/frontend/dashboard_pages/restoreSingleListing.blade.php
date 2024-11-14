@php
use App\Models\UserAuth;
@endphp

@extends('layouts.user_dashboard.userdashboardlayout')
@section('content')

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

        {{-- @if ($category_id == 728)
            <h4 class="text-center">Deleted Blog Posts </h4>
            <div class="row mt-4">
                @forelse($blogs_data as $blogPost)
                    @if($blogPost->user_id == UserAuth::getLoginId())
                        <div class="col-lg-4 col-md-6 mb-4 blog-post-listing" data-id="{{ $blogPost->id }}">
                            <div class="card">
                                <div class="card-body">
                                    <div class="pic">
                                        @php
                                            $itemFeaturedImages = trim($blogPost->image, '[""]');
                                            $itemFeaturedImages = explode('","', $itemFeaturedImages);
                                        @endphp

                                        @if(is_array($itemFeaturedImages))
                                            @foreach ($itemFeaturedImages as $keyitemFeaturedImage => $valueitemFeaturedImage)
                                                <div class="carousel-item {{ $keyitemFeaturedImage == 0 ? 'active' : 'in-active' }}">
                                                    <img src="{{ asset('images_blog_img') }}/{{ $valueitemFeaturedImage }}" alt="Image" class="img-fluid d-block w-100" onerror="this.onerror=null; this.src='https://finderspage.com/public/images_blog_img/1688636936.jpg';">
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
                                        <!-- <p>{{ $blogPost->created_at }}</p> -->
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
            </div>
        @endif --}}

        @if (in_array($category_id, [2, 4, 5, 6, 7, 705]))
            @php
                $categoryTitles = [
                    2 => 'Job Posts',
                    4 => 'Real Estate Posts',
                    5 => 'Community Posts',
                    6 => 'Shopping Posts',
                    7 => 'Fundraiser Posts',
                    705 => 'Services Posts'
                ];
            @endphp

            @php
                $blogs = $matchingRecords->where('category_id', $category_id);
                $title = $categoryTitles[$category_id];
            @endphp

            <h4 class="text-center">Deleted {{ $title }} </h4>
            <div class="row mt-4">
                @forelse($blogs as $blog)
                    @if($blog->user_id == UserAuth::getLoginId())
                        <div class="col-lg-4 col-md-6 mb-4 blog-post-listing" data-id="{{ $blog->id }}">
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
                                                    <img src="{{ asset('images_blog_img') }}/{{ $valueitemFeaturedImage }}" alt="Image" class="img-fluid d-block w-100" onerror="this.onerror=null; this.src='https://finderspage.com/public/images_blog_img/1688636936.jpg';">
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
                    @endif
                @empty
                    <div class="col-lg-12 text-center">
                        <p>No item here.</p>
                    </div>
                @endforelse
            </div>
        @endif

        @if ($category_id == 741)
            <h4 class="text-center">Deleted Entertainment Posts </h4>
            <div class="row mt-4">
                @forelse($entertainment_data as $entertainment)
                    @if($entertainment->user_id == UserAuth::getLoginId())
                        <div class="col-lg-4 col-md-6 mb-4 blog-post-listing" data-id="{{ $entertainment->id }}">
                            <div class="card">
                                <div class="card-body">
                                    <div class="pic">
                                        @php
                                            $itemFeaturedImages = explode(',', $entertainment->image);
                                        @endphp

                                        @if(is_array($itemFeaturedImages))
                                            @foreach ($itemFeaturedImages as $keyitemFeaturedImage => $valueitemFeaturedImage)
                                                <div class="carousel-item {{ $keyitemFeaturedImage == 0 ? 'active' : 'in-active' }}">
                                                    <img src="{{ asset('images_entrtainment') }}/{{ $valueitemFeaturedImage }}" alt="Image" class="img-fluid d-block w-100" onerror="this.onerror=null; this.src='https://finderspage.com/public/images_blog_img/1688636936.jpg';">
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
            </div>
        @endif

        @if ($category_id == 1)
        <h4 class="text-center">Deleted Business Posts </h4>
        <div class="row mt-4">
            @forelse($business_data as $business)
                @if($business->user_id == UserAuth::getLoginId())
                    <div class="col-lg-4 col-md-6 mb-4 blog-post-listing" data-id="{{ $business->id }}">
                        <div class="card">
                            <div class="card-body">
                                <div class="pic">
                                    @php
                                        $itemFeaturedImages = explode(',', $business->business_logo);
                                    @endphp

                                    @if(is_array($itemFeaturedImages))
                                        @foreach ($itemFeaturedImages as $keyitemFeaturedImage => $valueitemFeaturedImage)
                                            <div class="carousel-item {{ $keyitemFeaturedImage == 0 ? 'active' : 'in-active' }}">
                                                <img src="{{ asset('business_img') }}/{{ $valueitemFeaturedImage }}" alt="Image" class="img-fluid d-block w-100" onerror="this.onerror=null; this.src={{ asset('images_blog_img/1688636936.jpg') }};">
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="caption-frame">
                                    <h4>{{ $business->title }}</h4>
                                    <?php $timestamp = (strtotime($business->created_at));
                                    $date = date('j-n-Y', $timestamp); ?>
                                    <p>{{ $date }}</p>
                                    <!-- <p>{{ $business->created_at }}</p> -->
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
                @endif
            @empty
                <div class="col-lg-12 text-center">
                    <p>No item here.</p>
                </div>
            @endforelse
        </div>
    @endif
    </div>
</section>

@endsection
