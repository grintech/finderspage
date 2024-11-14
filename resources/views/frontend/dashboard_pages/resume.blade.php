@extends('layouts.user_dashboard.userdashboardlayout')
@section('content')

<style>
	.resume-frame {
		display: flex;
		margin-top: 20px;
	}

	/*.select2-container {
		width: 100% !important;
	}

	.select2-container--default .select2-selection--single .select2-selection__rendered {
		line-height: 41px;
	}

	.select2-container--default .select2-selection--single .select2-selection__arrow {
		top: 8px;
	}*/

	@media screen and (max-width:425px) {
		#imgviewer{
			width: 230px !important;
		}
	}
</style>
<div class="container px-sm-5 px-4">
	<form action="{{route('resume.store')}}" method="POST" enctype="multipart/form-data" id="resume_form" class="form-validation">
		{{ @csrf_field() }}
		<!-- Page Heading -->
		<div class="d-sm-flex flex-column  mb-3">
			<h1 class="h3 mb-0 text-gray-800 fw-bold">Create Resume</h1>

		</div>
		<span>
			@include('admin.partials.flash_messages')
		</span>
		<!-- Personal Information -->
		<div class="col-lg-12 bg-white border-radius pb-4 p-3">
			<div class="row">
				<div class="col-lg-6">
					<div class="mb-3">
						<label for="firstName" class="form-label">First name</label>
						<input type="text" class="form-control" id="firstName" name="firstName">
					</div>
				</div>
				<div class="col-lg-6">
					<div class="mb-3">
						<label for="lastName" class="form-label">Last name</label>
						<input type="text" class="form-control" id="lastName" name="lastName">
					</div>
				</div>
				<div class="col-lg-12">
					<div class="mb-3">
						<label for="phoneNumber" class="form-label">Phone number</label>
						<input type="tel" class="form-control" id="phoneNumber" name="phoneNumber">
					</div>
				</div>
				<!-- <div class="col-lg-6">
			             <div class="mb-3">
			                <label for="streetAddress" class="form-label">Street Sddress</label>
			                <input type="text" class="form-control" id="streetAddress" name="streetAddress" >
			            </div>
	            	</div> -->
				<div class="col-lg-6">
					<div class="mb-3">
						<label for="educationLevel" class="form-label">Level of education</label>
						<select class="form-control" id="educationLevel" name="educationLevel">
							<option value="" disabled selected>Select education level</option>
							<option value="High School">High School</option>
							<option value="Bachelor's">Bachelor's</option>
							<option value="Master's">Master's</option>
							<option value="PhD">PHD</option>
							<option value="Other">Other</option>
						</select>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="mb-3">
						<label for="fieldOfStudy" class="form-label">Field of study</label>
						<input type="text" class="form-control" id="fieldOfStudy" name="fieldOfStudy">
					</div>
				</div>
				<div class="col-lg-6">
					<div class="mb-3">
						<label for="schoolName" class="form-label">School name</label>
						<input type="text" class="form-control" id="schoolName" name="schoolName">
					</div>
				</div>
				<div class="col-lg-6">
					<div class="mb-3">
						<label for="timePeriod" class="form-label">Time period (e.g., MM/YYYY - MM/YYYY)</label>
						<input type="text" class="form-control" id="timePeriod" name="timePeriod">
					</div>
				</div>
				<div class="col-lg-6">
					<div class="mb-3">
						<!-- <label for="uploadPicture" class="form-label">Upload Picture</label>
			                <input type="file" class="form-control" id="uploadPicture" onchange="PreviewImage();" name="uploadPicture[]" accept="image/*" multiple > -->
						<label class="labels">Upload Picture</label>
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
								
								<input type="file" class="form-control" id="uploadPicture" name="uploadPicture[]" accept="image/*" multiple onchange="PreviewImage(); checkImageCount(this, maxImageCount );">

							</label>
						</div>
					</div> -->
					<!-- <div style="clear:both">
						<img src="{{asset('images/download123.jpg')}}" alt="Image" id="imgviewer" frameborder="0" scrolling="no" width="300" height="200">
					</div> -->

					<div class="upload-icon"><a class="cam btn btn-warning"  href="javascript:void(0)">
                    <i class="fa fa-upload" aria-hidden="true"></i>
                        Upload image
                    </a> 
                </div>
               
                <div class="gallery" id="sortableImgThumbnailPreview"></div>
					
				</div>
				</div>
				<div class="mb-3 resume-frame justify-content-between flex-wrap">
					<div class="form-check mx-2">
						<input class="form-check-input" type="radio" name="resumeType" id="workResume" value="work" checked>
						<label class="form-check-label" for="workResume">
							Work resume
						</label>
					</div>
					<div class="form-check  mx-2">
						<input class="form-check-input" type="radio" name="resumeType" id="talentResume" value="talent">
						<label class="form-check-label" for="talentResume">
							Talent resume
						</label>
					</div>
				</div>
				

				<div class="col-lg-6">
					<div class="mb-3">
						<label for="uploadResume" class="form-label">Upload cover letter</label>
						<div class="image-upload post_img ">
							<label style="cursor: pointer;" for="image_upload">
								<div class="h-100">
									<div class="dplay-tbl">
										<div class="dplay-tbl-cell">
											<!-- <i class="fas fa-cloud-upload-alt mb-3"></i> -->
											<!-- <h6><b>Upload Doc</b></h6> -->
											<i class="far fa-file-alt mb-3"></i>
											<h6 class="mt-10 mb-70">Upload or drop your cover letter here</h6>
										</div>
									</div>
								</div>
								<!--upload-content-->
								<!-- <input type="file" class="form-control" id="uploadPicture" onchange="PreviewImage();" name="uploadPicture[]" accept="image/*" multiple > -->
								<input type="file" class="form-control" id="uploadPDF" onchange="PreviewPdf();" name="upload_cover_letter" accept=".pdf,.doc,.docx" multiple>
							</label>
						</div>
					</div>
				</div>

				<div class="col-lg-6">
					<div class="mb-3">
						<label for="uploadResume" class="form-label">Upload resume</label>
						<div class="image-upload post_img ">
							<label style="cursor: pointer;" for="image_upload">
								<div class="h-100">
									<div class="dplay-tbl">
										<div class="dplay-tbl-cell">
											<!-- <i class="fas fa-cloud-upload-alt mb-3"></i> -->
											<!-- <h6><b>Upload Doc</b></h6> -->
											<i class="far fa-file-alt mb-3"></i>
											<h6 class="mt-10 mb-70">Upload or drop your documents here</h6>
										</div>
									</div>
								</div>
								<!--upload-content-->
								<!-- <input type="file" class="form-control" id="uploadPicture" onchange="PreviewImage();" name="uploadPicture[]" accept="image/*" multiple > -->
								<input type="file" class="form-control" id="uploadPDF" onchange="PreviewPdf();" name="uploadResume[]" accept=".pdf,.doc,.docx" multiple>
							</label>
						</div>
					</div>
				</div>
				



				<div class="col-lg-12 mt-3">
					<div class="mb-3">
						<label for="uploadCoverLetter" class="form-label">Description</label>
						<textarea id="editor1" class="form-control" name="coverLetter" placeholder="Write a text"></textarea>
					</div>
				</div>
				<div class="col-lg-2">
					<button type="submit" class="btn profile-button">Submit</button>
				</div>
			</div>
		</div>
	</form>
</div>

<script type="text/javascript">
	jQuery(document).ready(function() {
		$("#country_name").on("change", function() {
			var country_id = $(this).val();
			var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
			$.ajax({
				url: baseurl + '/filter/job/state',
				type: 'POST',
				headers: {
					'X-CSRF-TOKEN': csrfToken
				},
				data: {
					id: country_id

				},
				success: function(response) {
					console.log(response);
					$("#state_name").html(response.option_html);
				},
				error: function(xhr, status, error) {
					console.log(xhr.responseText);
				}
			});
		});
		$("#state_name").on("change", function() {
			var country_id = $(this).val();

			var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
			$.ajax({
				url: baseurl + '/filter/job/city',
				type: 'POST',
				headers: {
					'X-CSRF-TOKEN': csrfToken
				},
				data: {
					id: country_id
				},
				success: function(response) {
					console.log(response);
					$("#city_name").html(response.option_html);
				},
				error: function(xhr, status, error) {
					console.log(xhr.responseText);
				}
			});
		});
	});


	function PreviewPdf() {
		pdffile = document.getElementById("uploadPDF").files[0];
		pdffile_url = URL.createObjectURL(pdffile);
		$('#viewer').attr('src', pdffile_url);
	}


	function PreviewImage() {
		pdffileimg = document.getElementById("uploadPicture").files[0];
		pdffileimg_url = URL.createObjectURL(pdffileimg);
		$('#imgviewer').attr('src', pdffileimg_url);
	}
</script>
@endsection