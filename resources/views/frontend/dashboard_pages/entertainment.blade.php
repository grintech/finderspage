@extends('layouts.user_dashboard.userdashboardlayout')
@section('content')
<style>
	.error-message {color: #e74a3b;}
	@media only screen and (max-width:767px){
        .container {padding-bottom: 50px !important;}
    }
	.slider {position: relative; top: 4px;}
	.slider:before {
    position: relative!important;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
}
</style>
<div class="container px-sm-5 px-4 pb-4">
	<form method="post" action="<?php echo route('Entertainment.save'); ?>" class="form-validation" enctype="multipart/form-data">
		{{ @csrf_field() }}
		<div class="d-sm-flex flex-column  mb-3">
			<h1 class="h3 mb-0 text-gray-800 fw-bold">Create An Entertainment Job Listing</h1>
			<p>Choose the best category that fits your needs and create a free listing</p>
		</div>
		<span>
			@include('admin.partials.flash_messages')
		</span>
		<input type="hidden" name="categories" value="741">

		<div class="row bg-white border-radius pb-4 p-3">
			<div class="col-md-6 mb-4">
				<label class="labels">Title</label>
				<input type="text" id="title-input" class="form-control" name="title" placeholder="Title" value="">
				<span class="error-message" id="title-error"></span>
				@error('title')
				<small class="text-danger">{{ $message }}</small>
				@enderror
			</div>
			<div class="col-md-6 mb-4">
				<label class="labels">Sub categories</label>
				<select class="form-control form-control-xs selectpicker" name="sub_category" data-size="7" data-live-search="true" data-title="Sub categories" id="category_list" data-width="100%">

					@foreach($categories as $cate)
					<option data-tokens="{{$cate->title}}" value="{{$cate->id}}">{{$cate->title}}</option>
					@endforeach
				</select>
			</div>

			<div class="col-md-6 mb-2">
				<label class="labels">Gender</label>
				<select class="form-control Age-range" name="gender">
					<option value="">Select</option>
					<option value="Male">Male</option>
					<option value="Female">Female</option>
				</select>
				@error('choices')
				<small class="text-danger">{{ $message }}</small>
				@enderror

				<div class="form-group d-none mt-2" id="Male-Range">
					<div class="slider-container">
						<label class="form-check-label" for="male_age_range">Male Age </label>
						<input type="range" id="male_age_range" name="male_age_range" min="0" max="100" class="slider" value="0" style="width: 75%;"> 
						<span id="male_age_value" class="slider-value"></span>
					</div>
					<span class="text-danger" id="range_error"></span>
				</div>
				
				<div class="form-group d-none mt-2" id="Female-Range">
					<div class="slider-container">
						<label class="form-check-label" for="female_age_range">Female Age</label>
						<input type="range" id="female_age_range" name="female_age_range" min="0" max="100" class="slider" value="0" style="width: 75%;">
						<span id="female_age_value" class="slider-value"></span>
					</div>
					<span class="text-danger" id="range_error"></span>
				</div>
			</div>
			<div class="col-md-6 mb-4">
				<label class="labels">Choose your choice</label>
				<select class="form-control Paying-Nonpaying" name="paying">
					<option value="">Select</option>
					<option value="Paying">Paying</option>
					<option value="Non-Paying">Non-Paying</option>
					<option value="SAG-AFTRA">SAG-AFTRA</option>
					<option value="Non-Union">Non-Union</option>
				</select>
				@error('choices')
				<small class="text-danger">{{ $message }}</small>
				@enderror

				<div class="form-group d-none" id="Paying">
					<div class="row">
						<div class="col-md-12">
							<label class="form-check-label" for="exampleInput">Amount ($)</label>
							<input type="number" class="form-control" name="amount">

						</div>
					</div>
				</div>
				<div class="form-group d-none" id="Non-Paying">
					<label class="form-check-label" for="exampleInput">Publish</label>
					<input type="date" name="publish_date" class="form-control">
					<span class="text-danger" id="fixed_error"> </span>
				</div>
			</div>


			<div class="col-md-6 mb-4">
				<label class="labels">Role name</label>
				<input type="text" class="form-control" name="role_name" placeholder="Enter Role name" value="">
				<span class="error-message" id="title-error"></span>
				@error('role_name')
				<small class="text-danger">{{ $message }}</small>
				@enderror
			</div>

			

			<div class="col-md-6 mb-4">
				<label class="labels">Deadline date</label>
				<input type="date" class="form-control" name="deadline" value="">
				<span class="error-message" id="title-error"></span>
				@error('Deadline')
				<small class="text-danger">{{ $message }}</small>
				@enderror
			</div>
			<div class="col-md-6 mb-4">
				<label class="labels">Name of the producer</label>
				<input type="text" class="form-control" name="producer" placeholder="Enter producer name" value="">
				<span class="error-message" id="title-error"></span>
				@error('producer')
				<small class="text-danger">{{ $message }}</small>
				@enderror
			</div>
			<div class="col-md-6 mb-4">
				<label class="labels">Name of the director</label>
				<input type="text" class="form-control" name="director" placeholder="Enter director name" value="">
				<span class="error-message" id="title-error"></span>
				@error('director')
				<small class="text-danger">{{ $message }}</small>
				@enderror
			</div>
			<div class="col-md-6 mb-4">
				<label class="labels">Name of the writer</label>
				<input type="text" class="form-control" name="writer" placeholder="Enter writer name" value="">
				<span class="error-message" id="title-error"></span>
				@error('writer')
				<small class="text-danger">{{ $message }}</small>
				@enderror
			</div>
			<div class="col-md-6 mb-4">
				<label class="labels">Name of the casting director</label>
				<input type="text" class="form-control" name="casting_director" placeholder="Enter casting director" value="">
				<span class="error-message" id="title-error"></span>
				@error('casting_director')
				<small class="text-danger">{{ $message }}</small>
				@enderror
			</div>
			<div class="col-md-6 mb-4">
				<label class="labels">Audition dates</label>
				<input type="date" class="form-control" name="audition_dates" value="">
				<span class="error-message" id="title-error"></span>
				@error('audition_dates')
				<small class="text-danger">{{ $message }}</small>
				@enderror
			</div>

			<div class="col-md-6 mb-4">
				<label class="labels">Email</label>
				<input type="email" class="form-control" name="email" placeholder="Enter email " value="">
				<span class="error-message" id="title-error"></span>
				@error('email')
				<small class="text-danger">{{ $message }}</small>
				@enderror
			</div>
			<div class="col-md-6 mb-4">
				<label class="labels">Phone number</label>
				<input type="tel" class="form-control" id="phone" name="phone_no" placeholder="Enter phone " value="">
				<span class="error-message" id="title-error"></span>
				@error('email')
				<small class="text-danger">{{ $message }}</small>
				@enderror
			</div>
			<div class="col-md-6 mb-4">
				<label class="labels">Website</label>
				<input type="links" class="form-control" name="website" placeholder="Enter website " value="" >
				<span class="error-message" id="title-error"></span>
				@error('email')
				<small class="text-danger">{{ $message }}</small>
				@enderror
			</div>
			<div class="col-md-6 mb-4">
				<label class="labels">Portfolio/Social Links</label>
				<input type="link" class="form-control" name="links" placeholder="Enter links " value="" >
				<span class="error-message" id="title-error"></span>
				@error('links')
				<small class="text-danger">{{ $message }}</small>
				@enderror
			</div>

			<!-- <div class="col-md-6 mb-4">
				<label class="labels">SAG-AFTRA</label>
				<input type="link" class="form-control" name="" placeholder="Enter links " value="" >
				<span class="error-message" id="title-error"></span>
				@error('links')
				<small class="text-danger">{{ $message }}</small>
				@enderror
			</div>

			<div class="col-md-6 mb-4">
				<label class="labels">Non-Union</label>
				<input type="link" class="form-control" name="" placeholder="Enter links " value="" >
				<span class="error-message" id="title-error"></span>
				@error('links')
				<small class="text-danger">{{ $message }}</small>
				@enderror
			</div> -->

			<div class="col-md-12 mb-4">
				<label class="labels">Want to reach a larger audience? Add location</label>
				<input type="text" class="form-control get_loc" name="location" placeholder="Location" value="" > 
				<div class="searcRes" id="autocomplete-results">
                </div>
				@error('location')
				<small class="text-danger">{{ $message }}</small>
				@enderror
			</div>

			<div class="col-md-6 mb-4">
			<label class="labels" data-toggle="tooltip" data-placement="top" title="Any photo that signals an intention to commit, solicit, promote or encourage a criminal act and/or violate the  Advertiser Agreement will not be accepted.">Post featured image <em>(Select multiple)</em> <i class="fa fa-question popup2"> </i></label>
				<!-- <div class="image-upload post_img ">
					<label style="cursor: pointer;" for="image_upload">
						<div class="h-100">
							<div class="dplay-tbl">
								<div class="dplay-tbl-cell">
									
									<i class="far fa-file-image mb-3"></i>
									<h6 class="mt-10 mb-70">Upload Or Drop Your Image Here</h6>
								</div>
							</div>
						</div>
						<input data-required="image" type="file" name="image[]" id="image_upload" class="image-input" data-traget-resolution="image_resolution" value="" multiple accept="image/gif, image/jpeg, image/png" onchange="checkImageCount(this, maxImageCount )">
					</label>

				</div> -->

				<div class="upload-icon"><a class="cam btn btn-warning"  href="javascript:void(0)">
                    <i class="fa fa-upload" aria-hidden="true"></i>
                        Upload image
                    </a> 
                </div>
               
                <div class="gallery" id="sortableImgThumbnailPreview"></div>
				<div class="show-img">

				</div>
				@error('image')
				<small class="text-danger">{{ $message }}</small>
				@enderror
			</div>

			<div class="col-md-12 mb-4">
				<label class="labels">Description</label>
				<div id="summernote">
					<textarea id="editor1" class="form-control" name="description" placeholder="Description"><?php echo old('description'); ?></textarea>
					@error('description')
					<small class="text-danger">{{ $message }}</small>
					@enderror
				</div>
			</div>

		</div>
	
		<!-- <div class="row bg-white border-radius mt-5 p-3">
			<div class="col-md-6 social-area" style="justify-content: center;">
				<input type="radio" name="post_type" value="Feature Post" required>
				<label class="labels" data-toggle="tooltip" data-placement="top" title="Feature your listing on the homepage starting at just $55 per month.">Feature Listing <i class="fa fa-question popup1">
						
					</i></label>
				@error('post_type')
				<small class="text-danger">{{ $message }}</small>
				@enderror
			</div>
			<div class="col-md-6 social-area" style="justify-content: center;">
				<input type="radio" name="post_type" value="Normal Post" required>
				<label class="labels" data-toggle="tooltip" data-placement="top" title="Your free listing will expire after 44 days. If you renew it before the 44 days is up, your listing will stay up for another 44 days.">Free Listing <i class="fa fa-question popup2">
						
					</i></label>
				@error('post_type')
				<small class="text-danger">{{ $message }}</small>
				@enderror
			</div>
		</div> -->
		<input type="hidden" name="post_type" value="Normal Post" required>
		<div class="col-md-12 mb-4">
			<div class="mt-5 text-center">
				<button class="btn profile-button" type="submit">Publish</button>
			</div>
		</div>

	</form>
</div>
<script type="text/javascript">
	jQuery(document).ready(function() {
		$(".Paying-Nonpaying").change(function() {
			var value = $(this).val();

			if (value === 'Paying') {
				$('#Paying').removeClass('d-none');
				$('#Non-Paying').addClass('d-none');
			}
			if (value === 'Non-Paying') {
				$('#Paying').addClass('d-none');
				$('#Non-Paying').removeClass('d-none');
			}
			if (value === 'SAG-AFTRA') {
				$('#Paying').addClass('d-none');
				$('#Non-Paying').removeClass('d-none');
			}
			if (value === 'Non-Union') {
				$('#Paying').addClass('d-none');
				$('#Non-Paying').removeClass('d-none');
			}

		});
	});

	jQuery(document).ready(function() {
		function handleAgeRangeChange() {
			var value = $(".Age-range").val();

			if (value === 'Male') {
				$('#Male-Range').removeClass('d-none');
				$('#Female-Range').addClass('d-none');
			}
			if (value === 'Female') {
				$('#Male-Range').addClass('d-none');
				$('#Female-Range').removeClass('d-none');
			}
		}

		$(".Age-range").change(function() {
			handleAgeRangeChange();
		});

		handleAgeRangeChange();

		function updateSliderValue(slider, valueSpan) {
			valueSpan.textContent = slider.value;
		}

		var maleRange = document.getElementById('male_age_range');
		var femaleRange = document.getElementById('female_age_range');
		var maleAgeValue = document.getElementById('male_age_value');
		var femaleAgeValue = document.getElementById('female_age_value');

		if (maleRange && femaleRange) {
			maleRange.addEventListener('input', function() {
				updateSliderValue(maleRange, maleAgeValue);
			});

			femaleRange.addEventListener('input', function() {
				updateSliderValue(femaleRange, femaleAgeValue);
			});

			updateSliderValue(maleRange, maleAgeValue);
			updateSliderValue(femaleRange, femaleAgeValue);
		}
	});



	$(document).ready(function() {
		$('[data-toggle="tooltip"]').tooltip();
	});
</script>
@endsection