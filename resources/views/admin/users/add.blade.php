@extends('layouts.adminlayout')

@section('content')

<div class="header bg-primary pb-6">

	<div class="container-fluid">

		<div class="header-body">

			<div class="row align-items-center py-4">

				<div class="col-lg-6 col-8">

					<h6 class="h2 text-white d-inline-block mb-0">Manage Users</h6>

				</div>

				<div class="col-lg-6 col-4 text-right">

					<a href="<?php echo route('user.users') ?>" class="btn btn-neutral"><i class="ni ni-bold-left"></i> Back</a>

				</div>

			</div>

		</div>

	</div>

</div>

<!-- Page content -->

<div class="container-fluid mt--6">

	<div class="row">

		<div class="col-xl-12 order-xl-1">

			<div class="card">

				<!--!! FLAST MESSAGES !!-->

				@include('admin.partials.flash_messages')

				<div class="card-header">

					<div class="row align-items-center">

						<div class="col-12">

							<h3 class="mb-0">Create New User Here.</h3>

						</div>

					</div>

				</div>

				<div class="card-body">

					<form method="post" action="<?php echo route('user.users.add') ?>" class="form-validation" enctype="multipart/form-data" id="adduserValidation">

						<!--!! CSRF FIELD !!-->

						{{ @csrf_field() }}

						<h6 class="heading-small text-muted mb-4">User information</h6>

						<div class="pl-lg-4">

							<div class="row">

								<div class="col-lg-12">

									<div class="form-group">

										<label class="form-control-label" for="input-first-name">First name</label>

										<input type="text" class="form-control" name="first_name" required placeholder="First name" value="{{ old('first_name') }}">

										@error('first_name')

										    <small class="text-danger">{{ $message }}</small>

										@enderror

									</div>
								</div>

								<!-- <div class="col-lg-6">

									<div class="form-group">

										<label class="form-control-label" for="input-last-name">Last name</label>

										<input type="text" id="input-last-name" class="form-control" required placeholder="Last name" name="last_name" value="{{ old('last_name') }}">

										@error('last_name')

										    <small class="text-danger">{{ $message }}</small>

										@enderror

									</div>

								</div> -->

							</div>

							<div class="row">

								<div class="col-lg-12">

									<div class="form-group">

										<label class="form-control-label" for="input-last-name">Username</label>

										<input type="text" id="input-last-name" class="form-control" required placeholder="username" name="username" value="{{ old('username') }}">

										@error('username')

										    <small class="text-danger">{{ $message }}</small>

										@enderror

									</div>

								</div>



								<!-- <div class="col-lg-6">

									<div class="form-group">

										<label class="form-control-label" for="input-username">Gender</label>

										<select class="form-control" name="gender">

											<option value="male" <?php echo old('gender') == 'male' ? 'selected' : '' ?>>Male</option>

											<option value="female" <?php echo old('gender') == 'female' ? 'selected' : '' ?>>Female</option>

										</select>

										@error('gender')

										    <small class="text-danger">{{ $message }}</small>

										@enderror

									</div>

								</div>-->

								<!-- <div class="col-lg-6">

									<div class="form-group">

										<label class="form-control-label" for="input-email">Date of Birth</label>

										<input type="date" id="input-email" class="form-control" name="dob"  value="{{ old('dob') }}" max="<?php echo date('Y-m-d') ?>">

										@error('dob')

										    <small class="text-danger">{{ $message }}</small>

										@enderror

									</div>

								</div> -->

							</div>

							<div class="row">

								<div class="col-lg-6">

									<div class="form-group">

										<label class="form-control-label" for="input-username">Email Address</label>

										<input type="email" id="input-username" class="form-control" placeholder="info@example.com" name="email"  value="{{ old('email') }}" required>

										@error('email')

										    <small class="text-danger">{{ $message }}</small>

										@enderror

									</div>

								</div>

								<div class="col-lg-6">

									<div class="form-group">

										<label class="form-control-label" for="input-email">Phone Number</label>

										<input type="text" id="input-email" maxlength="10" class="form-control number" placeholder="9988774455" name="phonenumber"  value="{{ old('phonenumber') }}">

										@error('phonenumber')

										    <small class="text-danger">{{ $message }}</small>

										@enderror

									</div>

								</div>

							</div>

						</div>

						<hr class="my-4" />

						<!-- Address -->

						<h6 class="heading-small text-muted mb-4">Other Information</h6>

						<div class="pl-lg-4">



							<div class="form-group">

								<label class="form-control-label">Address</label>

								<textarea rows="2" class="form-control" placeholder="Your address" name="address">{{ old('address') }}</textarea>

								@error('address')

								    <small class="text-danger">{{ $message }}</small>

								@enderror

							</div>



							<div class="row">

								

								<!-- <div class="col-md-6">
									<div 

										class="upload-image-section"

										data-type="image"

										data-multiple="false"

										data-path="users"

										data-resize-medium="350*350"

										data-resize-small="100*100"

									>

										<div class="upload-section">

											<div class="button-ref mb-3">

												<button class="btn btn-icon btn-primary btn-lg" type="button">

									                <span class="btn-inner--icon"><i class="fas fa-upload"></i></span>

									                <span class="btn-inner--text">Upload Image</span>
								              	</button>

								            </div>

								          

											<div class="progress d-none">

							                  <div class="progress-bar bg-default" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>

							                </div>

							            </div>

						              
						                <input type="hidden" name="image" id="uploaded_img" value="">
						                <textarea class="d-none"  ></textarea>

						                <div class="show-section <?php echo !old('image') ? 'd-none' : "" ?>">

						                	@include('admin.partials.previewFileRender', ['file' => old('image') ])

						                </div>

									</div>

								</div>-->
								 <div class="col-md-6 mb-4">
		                         <label class="labels text-white">Post Featured Image *[Max-Size - 1 MB]</label> 
		                            <div class="image-upload post_img bg-light">
		                                <label style="cursor: pointer;" for="image_upload">
		                                   
		                                    <div class="h-100">
		                                        <div class="dplay-tbl">
		                                            <div class="dplay-tbl-cell">
		                                                <!-- <i class="fas fa-cloud-upload-alt mb-3"></i>
		                                                <h6><b>Upload Image</b></h6> -->
		                                                <i class="far fa-file-image mb-3"></i>
		                                                <h6 class="mt-10 mb-70">Upload Or Drop Your Image Here</h6>
		                                            </div>
		                                        </div>
		                                    </div>
		                                    <!--upload-content-->
		                                    <input data-required="image" type="file" name="image" id="image_upload" class="image-input" data-traget-resolution="image_resolution" value=""> 
		                                </label>
		                              
		                            </div>
		                            <div class="show-img d-none">

		                                 <img src="" alt="" class="uploaded-image" id="image-container" >
		                                 <i class="fas fa-times" id="cancel-btn"></i>
		                            </div>
		                            @error('image')
		                                <small class="text-danger">{{ $message }}</small>
		                            @enderror 
		                        </div>
								<div class="col-md-6">

									<div class="form-group">

										<div class="custom-control">

											<label class="custom-toggle">

												<input type="hidden" name="send_password_email" value="0">

												<input type="checkbox" name="send_password_email" value="1" id="sendPasswordEmail" <?php echo (old('send_password_email') != '0' ? 'checked' : '') ?>>

												<span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>

											</label>

											<label class="custom-control-label">Send credentials on email ?</label>

										</div>

										@error('send_password_email')

										    <small class="text-danger">{{ $message }}</small>

										@enderror

									</div>



									<div class="form-group passwordGroup ">

										<div class="input-group">

											<input type="password" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username with two button addons" aria-describedby="button-addon4" name="password" value="{{ old('password') }}">

											<div class="input-group-append" id="button-addon4">

												<button class="btn btn-outline-primary viewPassword" type="button"><i class="fas fa-eye"></i></button>

												<button class="btn btn-outline-primary regeneratePassword" type="button"><i class="fas fa-redo-alt"></i></button>

											</div>

										</div>

										@error('password')

										    <small class="text-danger">{{ $message }}</small>

										@enderror

										<div class="form-group">

											<small class="text-info">Password must be minimum 8 characters long.<br></small>

											<small class="text-info">Password should contain at least one capital letter (A-Z), one small letter (a-z), one number (0-9) and one special character (!@#$%^&amp;*).</small>

										</div>

									</div>

								</div>

							</div>

						</div>

						<hr class="my-4" />

						<button href="#" class="btn btn-sm py-2 px-3 btn-primary float-right">

							<i class="fa fa-save"></i> Submit

						</button>

					</form>

				</div>

			</div>

		</div>

	</div>

</div>

@endsection