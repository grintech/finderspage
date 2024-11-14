@extends('layouts.user_dashboard.userdashboardlayout')
@section('content')
<?php  use Carbon\Carbon; 
use App\Models\UserAuth;
$userData = UserAuth::getLoginUser();
?>
<style type="text/css">

</style>
<div class="container px-sm-5 px-4">
	<h1 class="mt-5 d-inline">Your Videos</h1>
	<a href="{{route('dashboard.video')}}" class="btn btn-warning float-right">New</a>

	<div class="row mt-4">
		@if(empty($video))
		<p class="card-text">Data not available.</p>
		@endif
		@foreach($video as $vid)
		<div class="col-md-4 mb-4 video-box">
			<div class="card">
						@if($vid->featured_post=="on")
             <div class="ribbon bump-ribbon" data-toggle="tooltip" data-placement="top" title="This listing is in draft. Please edit this post and proceed with the payment to publish.">
              <div class="text-div">
                Featured
              </div>
            </div>
            @endif

            @if($vid->draft=='0')
             <div class="ribbon" data-toggle="tooltip" data-placement="top" title="This listing is in draft. Please edit this post and proceed with the payment to publish.">
              <div class="text-div">
                Draft
              </div>
            </div>
            @endif
				<div class="card-body px-2 pt-2 pb-3 pb-md-3 pb-lg-3 pb-xl-0">
					<div class="row">
						<div class="col-xl-6 col-lg-12 col-md-12">
							<video height="120px" width="100%" controls id="video-tag">
								<source id="video-source" src="{{asset('video_short')}}/{{$vid->video}}">
								Your browser does not support the video tag.
							</video>
						</div>
						<div class="col-xl-6 col-lg-12 col-md-12 px-1">
							<h5 class="card-title">{{$vid->title}}</h5>
							@if(!empty($vid->location))
							<div class="">
								<p style="font-size: 10px; margin-top: 5px; color:black;">
									<i class="fa fa-map-marker" aria-hidden="true" style="font-size: 10px;"></i>
									{{ $vid->location }}
								</p>
							</div>
							@endif
							<p class="card-text">@if($vid->view_as == "on") public @else Only-me @endif</p>
							<a href="{{route('single.video',$vid->id)}}" class="btn btn-primary"><i class="fa fa-eye" aria-hidden="true"></i></a>

							<?php 
                                $currentDateTime = new DateTime();
                                $givenTime = $vid->created_at; // Assuming $post->created_at is a valid date string

                                // Convert the given time to a Carbon instance
                                $givenDateTime = Carbon::parse($givenTime);

                                // Add 10 days to the given date time
                                $nextTenDays = $givenDateTime->addDays(10);

                                // Output the next 10 days date time
                                // echo $nextTenDays;
                                // echo '<br>';
                                // echo $post->created_at;

                            ?>
            @if($userData->subscribedPlan != '7-day-14' && $userData->subscribedPlan != '1-month-55' && !empty($userData->subscribedPlan ))

               @if($currentDateTime <= $nextTenDays)
							<a href="{{route('edit.video',$vid->id)}}" class="btn btn-warning"><i class="far fa-edit"></i></a>
							@else
							 <a href="#" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="You can't make edits as you created this video more than 10 days ago. Thank you for understanding." ><i class="far fa-edit"></i></a>
							@endif

						 @else
               <a href="{{route('pricing')}}" class="btn btn-warning" style="" data-toggle="tooltip" data-placement="top" title="Edit this video you have to upgrade your plan" ><i class="far fa-edit"></i></a>
              @endif
							<a href="#" data-link="{{route('delete.video',$vid->id)}}" id="del_my_account" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>

							 @if($vid->bumpPost=="1")
                <a href="#" data-toggle="tooltip" data-placement="top" title="This video is already bumped"  class="btn btn-primary">Bumped</a>
               @else
                <a data-toggle="tooltip" data-placement="top" title="$3 for bump this video" href="{{route('stripe.bump.video',General::encrypt($vid->id))}}" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Bump">Bump</i></a>
                @endif

						</div>
					</div>
				</div>
			</div>
		</div>
		@endforeach
	</div>

	<!-- Add more video cards as needed -->

</div>
<script type="text/javascript">
	$(document).on("click", "#del_my_account", function(e) {
		e.preventDefault();
		var link = $(this).attr("data-link");
		Swal.fire({
			title: 'Delete',
			text: 'Are you sure you want to Delete?',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#fcd152',
			cancelButtonColor: '#1a202e',
			confirmButtonText: 'Yes, Delete!',
		}).then((result) => {
			if (result.isConfirmed) {
				window.location.href = link;
				Swal.fire(
					'Deleted!',
					'Video deleted successfully.',
					'success'
				)
			}
		});
	});
	 $(document).ready(function(){
          $('[data-toggle="tooltip"]').tooltip();   
        });
</script>
@endsection