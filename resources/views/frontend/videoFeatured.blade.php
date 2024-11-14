@extends('layouts.frontlayout')
@section('content')
 <link href="https://vjs.zencdn.net/7.15.4/video-js.css" rel="stylesheet" />
  <script src="https://vjs.zencdn.net/7.15.4/video.js"></script>
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
            	<div class="closeIcon"><i class="fa fa-close"></i></div>
                <form method="post" action="">
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
                            <span><a href="javascript:void(0);">Reset</a></span><input class="btn btn-warning post_filter" type="button" value="Apply">
                        </div>
                    </div>
                    {{-- <div class="job-search-box mt-2">
                        <div class="filter-check">
                            <span><a href="">Reset</a></span><input class="btn btn-warning post_filter" type="submit" value="Apply">
                        </div>
                    </div> --}}
                </div>
                </form>
            </div>
            <div class="col-md-9 col-lg-9 mt-2">
	            <div class="row related-job">
	                <div class="col-lg-12 col-md-12">
	                    <div class="job-post-header">
	                        <div class="row filterRes">
				                @if(count($video) === 0)
								    <div class="text-center">Videos not available</div>
								@endif
	                        	@foreach($video as $vid)
	                            <div class="col-lg-3 col-md-6 col-sm-12 col-12 columnJoblistig mb-3">
	                            	<a href="{{route('single.video', $vid->id)}}">
	                            	<!-- <a href="{{route('single.test.video', $vid->id)}}"> -->
		                                <div class="thumb-video-box">
									        <div class="thumbnail-container">
									        	<video class="thumbnail-video" loop muted playsinline="playsinline" poster="https://www.finderspage.com/public/{{$vid->image}}">
											    <source src="{{ asset('video_short') }}/{{ $vid->video }}" type="video/mp4">
											    <source src="{{ asset('video_short') }}/{{ $vid->video }}" type="video/webm">
											    <source src="{{ asset('video_short') }}/{{ $vid->video }}" type="video/mov">
											</video>
									        	<!-- <video class="thumbnail-video" controls src="{{asset('video_short')}}/{{$vid->video}}" loop playsinline>
										           <track default kind="captions" srclang="en" src="https://finderspage.com/public/assets/your-subtitles.vtt" />
										        </video> -->
										        <!-- <video class="thumbnail-video" playsinline ">
										            <source src="{{asset('video_short')}}/{{$vid->video}}" type="video/mp4" >
										            Your browser does not support the video tag.
										        </video> -->
										    </div>
										    <div class="thumbnail-caption">
										    	@foreach($users as $user)
													@if($user->id == $vid->user_id)
												 <ul class="list-unstyled" style="margin-bottom: 0px;">
		                                           	<li class="userIcon">
										                <div class="img-icon" bis_skin_checked="1">
										                  <img class="img-fluid rounded-circle" alt="image" height="40" width="40" src="{{asset('assets/images/profile')}}/{{$user->image}}">
										                </div>
										                <div class="comments-area" bis_skin_checked="1">
										                  <h6>{{$user->username}}</h6>
										                  <p>{{$vid->title}}</p>
										                </div>
									              	</li>
									         	</ul>
									         	@endif
									         	@endforeach
										    	<!-- <small>15 Views</small> -->
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
  var player = videojs('my-video', {
    controls: true,
    autoplay: false,
    preload: 'auto',
    fluid: true,
    sources: [
      { src: 'your-video.mp4', type: 'video/mp4' },
      // Add additional source types if needed (e.g., WebM, Ogg)
    ]
  });

    $("#menu-toggle").click(function(e) {
  e.preventDefault();
  $("#wrapper").toggleClass("toggled");
});
</script>
@endsection