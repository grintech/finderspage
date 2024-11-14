@extends('layouts.adminlayout')

@section('content')
<?php
 // echo "<pre>";print_r($user);die('developer'); 
?>

<div class="header bg-primary pb-6">

	<div class="container-fluid">

		<div class="header-body">

			<div class="row align-items-center py-4">

				<div class="col-lg-6 col-7">

					<h6 class="h2 text-white d-inline-block mb-0">Manage Users</h6>

				</div>

				<div class="col-lg-6 col-5 text-right">

					<a href="<?php echo route('user.users.add') ?>" class="btn btn-neutral"><i class="ni ni-bold-left"></i> Back</a>

				</div>

			</div>

		</div>

	</div>

</div>

<!-- Page content -->

<div class="container-fluid mt--6">

	<form method="post" action="<?php echo route('user.users.edit', ['id' => $user->id]) ?>" class="form-validation" enctype="multipart/form-data">

		<!--!! CSRF FIELD !!-->

		{{ @csrf_field() }}

		<div class="row">

			<div class="col-xl-7 order-xl-1">

				<div class="card">

					<!--!! FLAST MESSAGES !!-->

					@include('admin.partials.flash_messages')

					

					<div class="card-header">

						<div class="row align-items-center">

							<div class="col-8">

								<h3 class="mb-0">Update User Details Here.</h3>

							</div>

						</div>

					</div>

					<div class="card-body">		

						<h6 class="heading-small text-muted mb-4">User information</h6>

						<div class="pl-lg-4">

							<div class="row">

								<div class="col-lg-12">

									<div class="form-group">

										<label class="form-control-label" for="input-first-name">First name</label>

										<input type="text" class="form-control" name="first_name" required placeholder="First name" value="<?php echo $user->first_name ?>">

										@error('first_name')

										    <small class="text-danger">{{ $message }}</small>

										@enderror

									</div>



								</div>

								<!-- <div class="col-lg-6">

									<div class="form-group">

										<label class="form-control-label" for="input-last-name">Last name</label>

										<input type="text" id="input-last-name" class="form-control" placeholder="Last name" name="last_name" value="<?php echo $user->last_name ?>" required>

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

										<input type="text" id="input-last-name" class="form-control" required placeholder="username" name="username" value="<?php echo $user->username ?>">

										@error('username')

										    <small class="text-danger">{{ $message }}</small>

										@enderror

									</div>

								</div>


							</div>

							<div class="row">

								<div class="col-lg-6">

									<div class="form-group">

										<label class="form-control-label" for="input-username">Email Address</label>

										<input type="email" id="input-username" class="form-control" placeholder="info@example.com" name="email" required value="<?php echo $user->email ?>">

										@error('email')

										    <small class="text-danger">{{ $message }}</small>

										@enderror

									</div>

								</div>

								<div class="col-lg-6">

									<div class="form-group">

										<label class="form-control-label" for="input-email">Phone Number</label>

										<input type="text" id="input-email" class="form-control number" placeholder="9988774455" name="phonenumber" value="<?php echo $user->phonenumber ?>">

										@error('phonenumber')

										    <small class="text-danger">{{ $message }}</small>

										@enderror

									</div>

								</div>

							</div>

							<div class="row">

								<div class="col-lg-12">

									<div class="form-group">

										<label class="form-control-label">Address</label>

										<textarea rows="2" class="form-control" placeholder="Your address" name="address"><?php echo $user->address ?></textarea>

										@error('address')

										    <small class="text-danger">{{ $message }}</small>

										@enderror

									</div>

								</div>

							</div>

						</div>

						<hr class="my-4" />

						<button href="#" class="btn btn-sm py-2 px-3 btn-primary float-right">

							<i class="fa fa-save"></i> Submit

						</button>

					</div>

				</div>

			</div>

			<div class="col-xl-5 order-xl-1">

				

				<div class="col-md-12 mb-4">
	                 <label class="labels">Post Featured Image *[Max-Size - 1 MB]</label> 
	                    <div class="image-upload post_img ">
	                        <label style="cursor: pointer;" for="image_upload">
	                           
	                            <div class="h-100">
	                                <div class="dplay-tbl">
	                                    <div class="dplay-tbl-cell">
	                                        <!-- <i class="fas fa-cloud-upload-alt mb-3"></i>
	                                        <h6><b>Upload Image</b></h6>
	                                        <h6 class="mt-10 mb-70">Or Drop Your Image Here</h6> -->
	                                        <i class="far fa-file-image mb-3"></i>
		                                    <h6 class="mt-10 mb-70">Upload Or Drop Your Image Here</h6>
	                                    </div>
	                                </div>
	                            </div>
	                            <!--upload-content-->
	                            <input data-required="image" type="file" name="image" id="image_upload" class="image-input" data-traget-resolution="image_resolution" value=""> 
	                        </label>
	                      
	                    </div>
	                    <div class="show-img ">

	                         <img widt="40%"; src="{{asset('/assets/images/profile/'.$user->image)}}" alt="" class="uploaded-image" id="image-container" >
	                         <i class="fas fa-times" id="cancel-btn"></i>
	                    </div>
	                    @error('image')
	                        <small class="text-danger">{{ $message }}</small>
	                    @enderror 
	                </div>

				<!-- <div class="card">

					<div class="card-header">

						<div class="row align-items-center">

							<div class="col-8">

								<h3 class="mb-0">Reset Password.</h3>

							</div>

						</div>

					</div>

					<div class="card-body">

						<div class="pl-lg-4">

							<div class="form-group">

								<div class="custom-control">

									<label class="custom-toggle">

										<input type="hidden" name="send_password_email" value="0">

										<input type="checkbox" name="send_password_email" value="1" id="sendPasswordEmail">

										<span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>

									</label>

									<label class="custom-control-label">Send new password on email ?</label>

								</div>

								@error('send_password_email')

								    <small class="text-danger">{{ $message }}</small>

								@enderror

							</div>



							<div class="form-group passwordGroup">

								<div class="input-group">

									<input type="password" class="form-control" placeholder="****" aria-label="" aria-describedby="button-addon4" name="password">

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

				</div> -->

			</div>

		</div>

	</form>

</div>

@endsection