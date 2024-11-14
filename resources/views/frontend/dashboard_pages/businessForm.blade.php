@extends('layouts.user_dashboard.userdashboardlayout')
@section('content')


<div class="container-fluid business-page px-5">
	<div class="d-sm-flex flex-column  mb-3">
        <h1 class="h3 mb-0 text-gray-800 fw-bold">Create Business Page</h1>
        <p>Page Information</p>
    </div>
	<form method="post" action="https://finder.harjassinfotech.org/public/user-business" class="form-validation" enctype="multipart/form-data" id="crete-business_form">
        <div class="row justify-content-center">
        	<div class="col-mg-12 col-md-12">
        		<div class="card">
        			<div class="card-body">
        				<div class="row">
			        		<div class="col-lg-6 col-md-6 form-group">
			        			<label class="labels">Name</label>
			                    <input type="text" class="form-control" name="b_name" placeholder="Enter Name" required>
			        		</div>
			        		<div class="col-lg-6 col-md-6 form-group">
			        			<label class="labels">Email</label>
			                    <input type="text" class="form-control" name="bemail" placeholder="Enter Email" required>
			        		</div>
                        </div>
                        <div class="row">
			        		<div class="col-lg-6 col-md-6 form-group">
			        			<label class="labels">Business Page Name</label>
			                    <input type="text" class="form-control" name="page_name" placeholder="Enter Business Page Name" required>
			        		</div>
			        		<div class="col-lg-6 col-md-6 form-group">
			        			<label class="labels">Business Email</label>
			                    <input type="text" class="form-control" name="businessemail" placeholder="Enter Business Email" required>
			        		</div>
                        </div>
                        <div class="row">
			        		<div class="col-lg-6 col-md-6 form-group">
			        			<label class="labels">Category</label>
			                    <select id="searccategory" class="form-control" name="searcbusinessCat" required>
			                        <option>Choose Category</option>
			                        <option value="1">Jobs</option>
			                        <option value="2">Real Estate</option>
			                        <option value="3">Welcome to our Community</option>
			                        <option value="4">Shopping</option>
			                        <option value="5">Services</option>
			                    </select>
			        		</div>
			        		<div class="col-lg-6 col-md-6 form-group">
			        			<label class="labels">Description</label>
			                    <textarea class="form-control" name="desc" placeholder="Enter Description"></textarea>
			        		</div>
                        </div>
                        <div class="row">
                        	<div class="col-lg-6 col-md-6 form-group">
	        					<label class="labels">Profile Picture</label>
	        					<div class="image-upload">
	                                <label style="cursor: pointer;" for="file_upload">
	                                    <img src="" alt="" class="uploaded-image">
	                                    <div class="h-100">
	                                        <div class="dplay-tbl">
	                                            <div class="dplay-tbl-cell">
	                                                <i class="far fa-file-image mb-3"></i>
                                                	<h6 class="mt-10 mb-70">Upload Or Drop Your Profile Image Here</h6>
	                                            </div>
	                                        </div>
	                                    </div>
	                                    <input data-required="image" type="file" name="image_name" id="file_upload" class="image-input" data-traget-resolution="image_resolution" value="">
	                                </label>
	                            </div>
	        				</div>
	        				<div class="col-lg-6 col-md-6 form-group">
	        					<label class="labels">Cover Photo</label>
	        					<div class="image-upload">
	                                <label style="cursor: pointer;" for="photo_upload">
	                                    <img src="" alt="" class="uploaded-image">
	                                    <div class="h-100">
	                                           <div class="dplay-tbl">
	                                            <div class="dplay-tbl-cell">
	                                                <i class="far fa-file-image mb-3"></i>
                                                	<h6 class="mt-10 mb-70">Upload Or Drop Your Cover Photo Here</h6>
	                                            </div>
	                                        </div>
	                                    </div><!--upload-content-->
	                                    <input data-required="image" type="file" name="photo_name" id="photo_upload" class="image-input" data-traget-resolution="image_resolution" value="">
	                                </label>
	                            </div>
	        				</div>
                        </div>
                        <div class="col-lg-12">
                        	<div class="form-group">
	        					<input type="checkbox" id="customCheck1" name="customCheck1" value="Title">
	                            <label for="customCheck1" class="mb-0"> Make it Public or Private</label>
	        				</div>
	        				<div class="form-group">
	        					<input type="checkbox" id="customCheck1" name="customCheck1" value="Title">
	                            <label for="customCheck1" class="mb-0"> All Notifications About Your Page</label>
	        				</div>
	        				<div class="form-group">
	        					<input type="checkbox" id="customCheck2" name="customCheck2" value="Title">
	                            <label for="customCheck2" class="mb-0"> Marketing & Promotional Emails About Your Page</label>
	        				</div>
                        </div>

                        <div class="col-lg-12 mt-4">
			        		<div class="text-center">                   
			                 	<button type="submit" class="btn profile-button">Create Page</button>
			                </div>
			        	</div>
		        		
		            </div>
	            </div>
        	</div>
        	<!-- <div class="col-mg-12 col-md-12">
        		<div class="card">
        			<div class="card-body">
        				<div class="form-group">
        					<input type="checkbox" id="customCheck1" name="customCheck1" value="Title">
                            <label for="customCheck1" class="mb-0"> All notifications about your Page</label>
        				</div>
        				<div class="form-group">
        					<input type="checkbox" id="customCheck2" name="customCheck2" value="Title">
                            <label for="customCheck2" class="mb-0"> Marketing & promotional emails about your Page</label>
        				</div>
        			</div>
        		</div>
        	</div> -->
        	
        </div>
	</form>
</div>

@endsection