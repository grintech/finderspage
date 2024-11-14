@extends('layouts.user_dashboard.userdashboardlayout')
@section('content')
	<div class="container px-sm-5 px-4">
		 <form action="{{route('resume.update',$resume->id)}}" method="POST" enctype="multipart/form-data">
		 	{{ @csrf_field() }}
                    <!-- Page Heading -->
                    <div class="d-sm-flex flex-column  mb-3">
                        <h1 class="h3 mb-0 text-gray-800 fw-bold">Edit Resume</h1>
                       
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
			                <input type="text" class="form-control" id="firstName" name="firstName" value="{{$resume->firstName}}" required>
			            </div>
		            </div>
		            <div class="col-lg-6">
			            <div class="mb-3">
			                <label for="lastName" class="form-label">Last name</label>
			                <input type="text" class="form-control" id="lastName" name="lastName" value="{{$resume->lastName}}" required>
			            </div>
	            	</div>
	            	<div class="col-lg-6">
			             <div class="mb-3">
			                <label for="phoneNumber" class="form-label">Phone number</label>
			                <input type="tel" class="form-control" id="phoneNumber" name="phoneNumber" value="{{$resume->phoneNumber}}" required>
			            </div>
	            	</div>
	            	<!-- <div class="col-lg-6">
			             <div class="mb-3">
			                <label for="streetAddress" class="form-label">Street Address</label>
			                <input type="text" class="form-control" id="streetAddress" name="streetAddress" value="{{$resume->streetAddress}}" required>
			            </div>
	            	</div> -->
	            	<div class="col-lg-6">
			             <div class="mb-3">
			                <label for="Country" class="form-label">Country</label>
			                <select title="Select Country" name="country" class="form-control" id="country_name" resume-id="{{$resume->id}}">      
                                <option value="">Select country</option>
                                <?php
                                foreach ($countries as $key => $element) { ?>
                                    <option {{ $resume->country == $element['id'] ? 'selected' : '' }}  value=" <?php echo $element['id']; ?>"> <?php echo $element['name']; ?></option>
                                <?php
                                    }
                                ?>
                            </select>
			            </div>
	            	</div>
	            	<div class="col-lg-6">
			             <div class="mb-3">
			                <label for="state" class="form-label">State</label>
			                <select title="Select Country" name="state"  class="form-control state1" id="state_name" >     
                                <option value="">Select state</option>
                                
                            </select>
                             @error('state')
                                <span class="error">{{ $message }}</span>
                            @enderror
			            </div>
	            	</div>
	            	<div class="col-lg-6">
			             <div class="mb-3">
			                <label for="city" class="form-label">City</label>
			                <select title="Select Country" name="city" class="form-control" id="city_name">      
                                <option value="">Select city</option>
                            </select>
                             @error('city')
                                <span class="error">{{ $message }}</span>
                            @enderror
			            </div>
	            	</div>
	            	
	            	
	            	<div class="col-lg-6">
			            <div class="mb-3">
			                <label for="educationLevel" class="form-label">Level of education</label>
			                <select class="form-control" id="educationLevel" name="educationLevel" required>
			                    <option disabled selected>Select education level</option>
			                    <option {{ $resume->educationLevel == 'High School' ? 'selected' : '' }} value="High School">High School</option>
			                    <option {{ $resume->educationLevel == 'Bachelor"s' ? 'selected' : '' }} value="Bachelor's">Bachelor's</option>
			                    <option {{ $resume->educationLevel == '' ? 'selected' : 'Master"s' }} value="Master's">Master's</option>
			                    <option {{ $resume->educationLevel == 'PHD' ? 'selected' : '' }} value="PHD">PHD</option>
			                </select>
			            </div>
	            	</div>
	            	<div class="col-lg-6">
			             <div class="mb-3">
			                <label for="fieldOfStudy" class="form-label">Field of study</label>
			                <input type="text" class="form-control" id="fieldOfStudy" name="fieldOfStudy" value="{{$resume->fieldOfStudy}}" required>
			            </div>
	            	</div>
	            	<div class="col-lg-6">
			             <div class="mb-3">
			                <label for="schoolName" class="form-label">School name</label>
			                <input type="text" value="{{$resume->schoolName}}" class="form-control" id="schoolName" name="schoolName" required>
			            </div>
	            	</div>
	            	<div class="col-lg-12">
			            <div class="mb-3">
			                <label for="timePeriod" class="form-label">Time period (e.g., MM/YYYY - MM/YYYY)</label>
			                <input type="text" value="{{$resume->timePeriod}}" class="form-control" id="timePeriod" name="timePeriod" required>
			            </div>
	            	</div>
	            	<div class="col-lg-6">
			              <div class="mb-3">
			                <label for="uploadPicture" class="form-label">Upload Picture</label>
			                <div class="upload-icon"><a class="cam btn btn-warning"  href="javascript:void(0)">
			                    <i class="fa fa-upload" aria-hidden="true"></i>
			                        Upload image
			                    </a> 
			                </div>
               
                			<div class="gallery" id="sortableImgThumbnailPreview"></div>
			            </div>
			            <div class="show-img" style="clear:both">
					       <img src="{{asset('images_resume_img')}}/{{$resume->uploadPicture}}" alt="Image" id="imgviewer" frameborder="0" scrolling="no" width="300" height="200">
					    </div>
	            	</div>
	            	<div class="col-lg-6">
			              <div class="mb-3">
			                <label for="uploadResume" class="form-label">Upload resume</label>
			                <input type="file" class="form-control" id="uploadPDF" onchange="PreviewPdf();" name="uploadResume[]" accept=".pdf,.doc,.docx" multiple >
			            </div>
			            <div class style="clear:both">
					       <iframe id="viewer" src="{{asset('images_blog_doc')}}/{{$resume->uploadResume}}" frameborder="0" scrolling="no" width="100%" height="200"></iframe>
					    </div>
	            	</div>
	            	
	            	<div class="col-lg-12">
			             <div class="mb-3">
			                <label for="uploadCoverLetter" class="form-label">Cover letter</label>
			            	<textarea id="editor1" class="form-control" name="coverLetter" placeholder="Write a text">{{$resume->coverLetter}}</textarea>
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
                    url: baseurl+'/filter/job/state',
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
                    url: baseurl+'/filter/job/city',
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


		jQuery(document).ready(function() {

            var countryid =   $("#country_name").val();
            var userid1 = $('#country_name').attr('resume-id');
            
               console.log(" countryid "+countryid);
               console.log("userid1 "+userid1);
           var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                $.ajax({
                    url: baseurl+'/fetch-state',
                    type: 'POST',
                    headers: {
                      'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        id: countryid,
                        userid: userid1,
                    },
                    success: function(response) {
                      console.log(response);
                        $("#state_name").html(response.option_html);
                    },
                    error: function(xhr, status, error) {
                      console.log(xhr.responseText);
                    }
                  });

                setTimeout(function() {
                   var stateID1 = $(".state1").val();
                   var userid2 = $('#country_name').attr('resume-id');
                      console.log('stateID1'+stateID1);
                      console.log('userid2'+userid2);
                     $.ajax({
                            url: baseurl+'/fetch-city',
                            type: 'POST',
                            headers: {
                              'X-CSRF-TOKEN': csrfToken
                            },
                            data: {
                                id: stateID1,
                                userid :userid2
                            },
                            success: function(response) {
                              console.log(response);
                                $("#city_name").html(response.option_html);
                            },
                            error: function(xhr, status, error) {
                              console.log(xhr.responseText);
                            }
                          });
                      }, 5000);
            

        });

		function PreviewPdf() {
		    pdffile=document.getElementById("uploadPDF").files[0];
		    pdffile_url=URL.createObjectURL(pdffile);
		    $('#viewer').attr('src',pdffile_url);
		}


		function PreviewImage() {
		    pdffileimg=document.getElementById("uploadPicture").files[0];
		    pdffileimg_url=URL.createObjectURL(pdffileimg);
		    $('#imgviewer').attr('src',pdffileimg_url);
		}
	</script>
@endsection