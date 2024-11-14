@extends('layouts.frontlayout')
@section('content')
<section class="job-listing">
	<!-- <div class="visible-xs">
        <div class="container-fluid">
            <button class="btn btn-default navbar-btn" data-toggle="collapse" data-target="#filter-sidebar">
              <i class="fa fa-tasks"></i> Filters
            </button>
        </div>
    </div> -->
	<div class="container">
		<div class="row" style="display: flex; justify-content:end; margin-right: 4px;">
			<button type="button" class="btn filterBTN">Filters</button>
		</div>
		<div class="row">
			<div class="col-md-3 col-lg-3" id="FiltersJob">
				<form method="post" action="">
					<div class="closeIcon"><i class="fa fa-close" aria-hidden="true"></i></div>  
					<div class="left-side-bar">
						<div class="job-search-box mt-2">
							<h1 style="font-size: 17px;">Date Posted</h1>
							<div class="form-check mb-3">
								<label class="form-check-label">
									<input class="form-check-input mydate" type="radio" name="days" value="1"> One day ago
								</label><br>
								<label class="form-check-label">
									<input class="form-check-input mydate" type="radio" name="days" value="3">Last 3 days
								</label><br>
								<label class="form-check-label">
									<input class="form-check-input mydate" type="radio" name="days" value="7">Last 7 days
								</label>
							</div>
						</div>
						<div class="job-search-box mt-2">
							<div class="filter-check">
								<span><a href="">Reset</a></span><input class="btn btn-warning post_filter" type="submit" value="Apply">
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="col-md-9 col-lg-9 mt-2">
				<div class="row related-job">
					<div class="col-lg-12 col-md-12">
						<div class="job-post-header">
							<div class="row filterRes">
								@foreach($video as $vid)
								<div class="col-lg-3 col-md-6 col-sm-12 col-12 columnJoblistig mb-3">
									<a href="{{route('single.video', $vid->id)}}">
										<!-- <a href="{{route('single.test.video', $vid->id)}}"> -->
										<div class="thumb-video-box">
											<div class="thumbnail-container">
												<!-- <img class="thumbnail-image" src="{{asset('video_short')}}/{{$vid->image}}" alt="Video Thumbnail"> -->
												<video class="thumbnail-video" loop muted playsinline="playsinline" poster="https://www.finderspage.com/public/{{$vid->image}}">
													<source src="{{ asset('video_short') }}/{{ $vid->video }}" type="video/mp4">
													<source src="{{ asset('video_short') }}/{{ $vid->video }}" type="video/webm">
													<source src="{{ asset('video_short') }}/{{ $vid->video }}" type="video/mov">
												</video>
											</div>
											<div class="thumbnail-caption">
												<h6 class="mb-0">{{$vid->title}}</h6>
												@if(!empty($vid->location))
												<div>
													<p style="font-size: 8px; margin-top: 5px;">
														<i class="fa fa-map-marker" aria-hidden="true"></i>
														{{ $vid->location }}
													</p>
												</div>
												@endif
											</div>
										</div>
									</a>
								</div>
								@endforeach
								<!-- <div class="col-lg-3 col-md-6 col-sm-6 col-6 columnJoblistig mb-3">
	                                <a href="">
		                                <div class="thumb-video-box">
									        <div class="thumbnail-container">
										        <img class="thumbnail-image" src="{{asset('images_blog_img/1690956940_61-YsVpu0zL._SX466_.jpg')}}" alt="Video Thumbnail">
										        <video class="thumbnail-video" autoplay muted loop>
										            <source src="{{asset('images_blog_video/1687410663.mp4')}}" type="video/mp4">
										            Your browser does not support the video tag.
										        </video>
										    </div>
										    <div class="thumbnail-caption">
										    	<h6 class="mb-0">Testing Video</h6>
										    	<small>15 Views</small>
										    </div>
		                                </div>
	                                </a>
	                            </div> -->
								<!--   <div class="col-lg-3 col-md-6 col-sm-6 col-6 columnJoblistig mb-3">
	                                <a href="">
		                                <div class="thumb-video-box">
									        <div class="thumbnail-container">
										        <img class="thumbnail-image" src="{{asset('images_blog_img/1690956940_61-YsVpu0zL._SX466_.jpg')}}" alt="Video Thumbnail">
										        <video class="thumbnail-video" autoplay muted loop>
										            <source src="{{asset('images_blog_video/1687410663.mp4')}}" type="video/mp4">
										            Your browser does not support the video tag.
										        </video>
										    </div>
										    <div class="thumbnail-caption">
										    	<h6 class="mb-0">Testing Video</h6>
										    	<small>15 Views</small>
										    </div>
		                                </div>
	                                </a>
	                            </div> -->
								<!--  <div class="col-lg-3 col-md-6 col-sm-6 col-6 columnJoblistig mb-3">
	                                <a href="">
		                                <div class="thumb-video-box">
									        <div class="thumbnail-container">
										        <img class="thumbnail-image" src="{{asset('images_blog_img/1690956940_61-YsVpu0zL._SX466_.jpg')}}" alt="Video Thumbnail">
										        <video class="thumbnail-video" autoplay muted loop>
										            <source src="{{asset('images_blog_video/1687410663.mp4')}}" type="video/mp4">
										            Your browser does not support the video tag.
										        </video>
										    </div>
										    <div class="thumbnail-caption">
										    	<h6 class="mb-0">Testing Video</h6>
										    	<small>15 Views</small>
										    </div>
		                                </div>
	                                </a>
	                            </div> -->
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<script>
	$("#menu-toggle").click(function(e) {
		e.preventDefault();
		$("#wrapper").toggleClass("toggled");
	});
</script>
@endsection