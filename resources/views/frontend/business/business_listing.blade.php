<?php
use App\Models\UserAuth;

?>
@extends('layouts.frontlayout')
@section('content')
<style>
.main-cat {
    font-size: 13px;
    height: 40px !important;
}
</style>
<section class="business-list single-list">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<h1 class="text-center">Business Details</h1>
			</div>
			<div class="col-lg-3">
				<form method="POST" action="{{ route('search') }}">
					<div class="row">
						@csrf
						<div class="col-lg-12 col-md-6 mb-2">
							<div class="select-job">
								<input type="text" class="form-control main-cat" id="searcjob" name="Business" value="Business" readonly>
							</div>
						</div>

						<div class="col-lg-12 col-md-6 mb-2">
							<div class="select-job">
								<select id="searcjobChild" class="form-select" name="searcjobChild">
									<option>Sub Category</option>
								</select>

							</div>
						</div>

						<div class="col-lg-12 col-md-6 mb-2">
							<div class="location-search">
								<input type="location" name="location" class="form-control" id="exampleFormControlInput1" placeholder="location">
								<i class="bi bi-geo-alt"></i>
							</div>
						</div>

						<div class="col-lg-12 col-sm-12 col-md-6">
							<div class="search-fields">
								<!-- <a href="#">Search<i class="bi bi-arrow-right"></i></a> -->
								<button class="btn fields-search" type="submit">Search<i class="bi bi-arrow-right"></i></button>
							</div>
						</div>
					</div>
				</form>
			</div>
			@foreach($business_page as $business)
			<div class="col-lg-3 col-md-6">
				<div class="card b-card">
					<div class="b-image-area">
						<div class="b-logo">
							<a href="{{route('business_page.front.single.listing',$business->slug)}}">
								<img class="img-fluid" src="{{ $business->business_logo ? asset('/business_img/'.$business->business_logo) : 'https://www.finderspage.com/public/uploads/logos/16635000611696-logo.png' }}" alt="...">
							</a>
						</div>
						<?php
							$gallery_img = json_decode($business->gallery_image)?? [];
							$imageCount = count($gallery_img);
							?>
							<div class="b-gallery  @if($imageCount > 0 && $imageCount <= 4) single-img @elseif($imageCount > 4)multi-img @endif">
								@if($imageCount > 0 && $imageCount <= 4)
									{{-- Display one full-width image --}}
									<a href="{{route('business_page.front.single.listing',$business->slug)}}">
										<img  src="{{ $business->business_logo ? asset('/business_img/'.$gallery_img[0]) : 'https://www.finderspage.com/public/uploads/logos/16635000611696-logo.png' }}" alt="Business Image" >
									</a>
								@elseif($imageCount > 4)
									{{-- Display a gallery of 4 images --}}
									@foreach(array_slice($gallery_img, 0, 4) as $img)
										<a href="{{route('business_page.front.single.listing',$business->slug)}}">
											<img  src="{{ $business->business_logo ? asset('/business_img/'.$img) : 'https://www.finderspage.com/public/uploads/logos/16635000611696-logo.png' }}" alt="Business Image">
										</a>
									@endforeach
								@endif
								<a href="{{route('business_page.front.single.listing',$business->slug)}}" class="b-btn">See Photos</a>
							</div>
					</div>
					<div class="card-body">
					    <h5 class="card-title">{{$business->business_name}}</h5>
					    <div class="buttons-frame">
					    	<a terget="_blank" href="https://{{$business->business_website}}" class="web-btn">Website</a>
					    	<a href="{{route('business_page.front.single.listing',$business->slug)}}" class="web-btn">Save</a>
					    	<a terget="_blank"href="tel:{{$business->business_phone}}" class="web-btn">Call</a>
					    </div>
				    	<div class="rating">
						    <div class="star">
						    	<span>5.0</span>
						      	<i class="fa-solid fa-star"></i>
						      	<i class="fa-solid fa-star"></i>
						      	<i class="fa-solid fa-star"></i>
						      	<i class="fa-solid fa-star"></i>
						      	<i class="fa-solid fa-star"></i>
						      	<span><a href="{{route('business_page.front.single.listing',$business->slug)}}" class="r-link">10 Business Reviews</a></span>
						    </div>
						</div>
					    
					    <ul class="list-group list-group-flush">
						    <li class="list-group-item"><span class="l-text">Service options:</span> On-site services</li>
						    <li class="list-group-item"><span class="l-text">Located In:</span> <a href="#">{{$business->location}}</a></li>
						    <li class="list-group-item"><span class="l-text">Address:</span> {{$business->address_1}}</li>

							<li class="list-group-item"><span class="l-text">Phone:</span> <a href="#">{{$business->business_phone}}</a></li>
						    <li class="list-group-item"><span class="l-text">Email:</span> <a href="#">{{$business->business_email}}</a></li>

							<?php 
								$opening_hours = explode(',',$business->opening_hours);
								
								$days = [
									"Monday" => 1,
									"Tuesday" => 2,
									"Wednesday" => 3,
									"Thursday" => 4,
									"Friday" => 5,
									"Saturday" => 6,
									"Sunday" => 7
								];
								usort($opening_hours, function($a, $b) use ($days) {
									$dayA = explode(':', $a)[0];
									$dayB = explode(':', $b)[0];
								
									return $days[$dayA] - $days[$dayB];
								});
								
								// dd($opening_hours);
							?>
						    <li class="list-group-item"><span class="l-text">Hours:</span> <span class="show-content toggle"> {{$opening_hours[0]}} <i class="fas fa-angle-down"></i></span>
						    	<div class="showmore">
						    		<table class="more-cont">
						    			<tbody>
											@foreach($opening_hours as $hours)
						    				<tr>
						    					<td>{{$hours}}</td>
						    				</tr>
						    				@endforeach
						    			</tbody>
						    		</table>
						    	</div>
						    </li>
						    
						</ul>
						<!-- <div class="suggest-link">
						    <a href="https://www.finderspage.com/business-single-list" class="card-link">Suggest an edit</a>
						    <a href="https://www.finderspage.com/business-single-list" class="card-link">Own this business? </a>
						</div> -->
						<!-- <div class="send-link">
						    <span class="link-text"><i class="fa fa-share-square"></i> Send to your phone</span>
						    <a href="https://www.finderspage.com/business-single-list" class="web-btn">Send</a>
						</div> -->

						<div class="card-profile-area">
							<a href="{{route('business_page.front.single.listing',$business->slug)}}" class="view-btn">View Details</a>
							<div class="p-frame">
								@if($business->facebook)
								<span>
									<a href="{{$business->facebook}}" class="s-link">
										<img src="https://www.finderspage.com/public/images/b-fb.png" alt="facebook">
										Facebook
									</a>
								</span>
								@endif
								@if($business->whatsapp)
								<span>
									<a href="#" class="s-link">
										<img src="https://www.finderspage.com/public/images/b-x.png" alt="whatsapp">
										Whatsapp
									</a>
								</span>
								@endif
								@if($business->instagram)
								<span>
									<a href="#" class="s-link">
										<img src="https://www.finderspage.com/public/images/b-insta.png" alt="instagram">
										Instagram
									</a>
								</span>
								@endif
								@if($business->youtube)
								<span>
									<a href="#" class="s-link">
										<img src="https://www.finderspage.com/public/images/b-ytube.png" alt="youtube">
										YouTube
									</a>
								</span>
								@endif
								@if($business->tiktok)
								<span>
									<a href="#" class="s-link">
										<img src="https://www.finderspage.com/public/images/b-linkedIn.png" alt="linkedIn">
										Tiktok
									</a>
								</span>
								@endif
						    </div>
						</div>
					</div>
				</div>
			</div>
			@endforeach
		</div>
	</div>
</section>



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript">
$('.toggle').click(function() {
    $(this).next('.showmore').toggle();
});
</script>

@endsection
