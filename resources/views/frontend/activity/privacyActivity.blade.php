@extends('layouts.user_dashboard.userdashboardlayout')
@section('content')

<!-- <div class="container px-sm-5 px-4">
	<div class="d-sm-flex flex-column  mb-3">
        <h1 class="h3 mb-0 text-gray-800 fw-bold">Privacy/Activity</h1>
    </div>
	<div class="row bg-white border-radius mt-4 p-5">
		<div class="col-lg-12 text-center">
			<h5 class="mb-3">Connections are only viewable to you and no one else.</h5> 
			<h5 class="mb-3">Comments are only viewable to you and none else.</h5> 
			<h5>Number of views are only viewable to you and no one else.</h5>
		</div>
	</div>
</div> -->


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">

<div class="container-fluid px-3 px-md-5">
    <div class="d-flex justify-content-between mb-3">
        <div class="support_1">
            <h1 class="h3 mb-0 text-gray-800 fw-bold">Activity</h1>
        <p>Click and see all the info</p>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row activity">
        <div class="col-xl-3 col-md-6 mb-2 mb-md-4">
        	<a href="#">
	            <div class="card border-left-warning shadow">
	                <div class="card-body">
	                    <div class="row no-gutters align-items-center">
	                        <div class="col">
	                            <div class="text-black"><i class="bi bi-chat"></i> Comments</div>
	                        </div>
	                        <div class="col-auto">
	                            <i class="bi bi-chevron-right"></i>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </a>
        </div>

        <div class="col-xl-3 col-md-6 mb-2 mb-md-4">
        	<a href="#">
	            <div class="card border-left-warning shadow">
	                <div class="card-body">
	                    <div class="row no-gutters align-items-center">
	                        <div class="col">
	                            <div class="text-black"><i class="bi bi-bookmark-star"></i> Tags</div>
	                        </div>
	                        <div class="col-auto">
	                            <i class="bi bi-chevron-right"></i>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </a>
        </div>

        <div class="col-xl-3 col-md-6 mb-2 mb-md-4">
        	<a href="#">
	            <div class="card border-left-warning shadow">
	                <div class="card-body">
	                    <div class="row no-gutters align-items-center">
	                        <div class="col">
	                            <div class="text-black"><i class="bi bi-star"></i> Reviews</div>
	                        </div>
	                        <div class="col-auto">
	                            <i class="bi bi-chevron-right"></i>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </a>
        </div>

        <div class="col-xl-3 col-md-6 mb-2 mb-md-4">
        	<a href="#">
	            <div class="card border-left-warning shadow">
	                <div class="card-body">
	                    <div class="row no-gutters align-items-center">
	                        <div class="col">
	                            <div class="text-black"><i class="bi bi-trash"></i> Deleted</div>
	                        </div>
	                        <div class="col-auto">
	                            <i class="bi bi-chevron-right"></i>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </a>
        </div>

        <div class="col-xl-3 col-md-6 mb-2 mb-md-4">
        	<a href="#">
	            <div class="card border-left-warning shadow">
	                <div class="card-body">
	                    <div class="row no-gutters align-items-center">
	                        <div class="col">
	                            <div class="text-black"><i class="bi bi-archive"></i> Archived</div>
	                        </div>
	                        <div class="col-auto">
	                            <i class="bi bi-chevron-right"></i>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </a>
        </div>

        <div class="col-xl-3 col-md-6 mb-2 mb-md-4">
        	<a href="#">
	            <div class="card border-left-warning shadow">
	                <div class="card-body">
	                    <div class="row no-gutters align-items-center">
	                        <div class="col">
	                            <div class="text-black"><i class="bi bi-stickies"></i> Posts</div>
	                        </div>
	                        <div class="col-auto">
	                            <i class="bi bi-chevron-right"></i>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </a>
        </div>

        <div class="col-xl-3 col-md-6 mb-2 mb-md-4">
        	<a href="#">
	            <div class="card border-left-warning shadow">
	                <div class="card-body">
	                    <div class="row no-gutters align-items-center">
	                        <div class="col">
	                            <div class="text-black"><i class="bi bi-file-play"></i> Reels</div>
	                        </div>
	                        <div class="col-auto">
	                            <i class="bi bi-chevron-right"></i>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </a>
        </div>

        <div class="col-xl-3 col-md-6 mb-2 mb-md-4">
        	<a href="#">
	            <div class="card border-left-warning shadow">
	                <div class="card-body">
	                    <div class="row no-gutters align-items-center">
	                        <div class="col">
	                            <div class="text-black"><i class="bi bi-aspect-ratio"></i> Highlights</div>
	                        </div>
	                        <div class="col-auto">
	                            <i class="bi bi-chevron-right"></i>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </a>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-2 mb-md-4">
        	<a href="#">
	            <div class="card border-left-warning shadow">
	                <div class="card-body">
	                    <div class="row no-gutters align-items-center">
	                        <div class="col">
	                            <div class="text-black"><i class="bi bi-clock-history"></i> Time spent</div>
	                        </div>
	                        <div class="col-auto">
	                            <i class="bi bi-chevron-right"></i>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </a>
        </div>

        <div class="col-xl-3 col-md-6 mb-2 mb-md-4">
        	<a href="#">
	            <div class="card border-left-warning shadow">
	                <div class="card-body">
	                    <div class="row no-gutters align-items-center">
	                        <div class="col">
	                            <div class="text-black"><i class="bi bi-hourglass-bottom"></i> History</div>
	                        </div>
	                        <div class="col-auto">
	                            <i class="bi bi-chevron-right"></i>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </a>
        </div>

        <div class="col-xl-3 col-md-6 mb-2 mb-md-4">
        	<a href="#">
	            <div class="card border-left-warning shadow">
	                <div class="card-body">
	                    <div class="row no-gutters align-items-center">
	                        <div class="col">
	                            <div class="text-black"><i class="bi bi-search"></i> Recent searches</div>
	                        </div>
	                        <div class="col-auto">
	                            <i class="bi bi-chevron-right"></i>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </a>
        </div>

    </div>

    <!-- Content Row -->

</div>

@endsection