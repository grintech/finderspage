@extends('layouts.frontlayout')

@section('content')

<style type="text/css">
	 .post-headng-sec h5 {
            line-height: 30px;
            margin-bottom: 10px;
         }

         .form-group.form-check {
            margin-right: 36px !important;
            margin-left: 20px;
         }
	.construction-img{padding: 0px; object-fit: cover;}
	.text-primary {color: #A6750B !important;}
	@media only screen and (max-width:991px){
            .loginBtn {width: 46%;}
            .sign-bg{width: 100% !important; background-color: transparent;}
            .main{width: 100px;}
            .construction-img{width: 100%;}
         }
         
@media only screen and (min-width:768px) and (max-width:991px){
   .sign-bg{width: 41.66666667% !important; background-color: transparent;}
}
</style>

<div class="register-photo">
   <div class="form-container">
      <div class="row">
         <span>
                        @include('admin.partials.flash_messages')
                    </span>
         <div class="col-md-5 col-sm-5 col-xs-12 sign-bg">
            <!-- <img src="{{ url('front/images/sign-up.png') }}" width="100%" height="100%" class="construction-img"> -->
            <!-- <img src="{{ asset('front/images/newsignup.jpeg') }}" alt="Image" width="100%" height="100%" class="construction-img"> -->
            <img src="{{ asset('front/images/signup.jpg') }}" width="100%" height="100%" class="construction-img" alt="Image">
         </div>


         <div class="col-md-7 col-sm-7 col-xs-12">
         	@include('admin.partials.flash_messages')
						<form method="post" role="form" id="recover-password">

							<!--!! CSRF FIELD !!-->

							{{ csrf_field() }}
							<div class="post-headng-sec">
	                  	<h4 class="post-head">Recover Password!</h4>
            				<h5>Create new password for account.</h5>
	               	</div>

							<div class="col-lg-12">

								<div class="form-group passwordGroup">
									<label>New Password</label>
									<input type="password" class="form-control" name="new_password" placeholder="*****" aria-label="" aria-describedby="button-addon4" name="password" required>
								</div>

								<div class="form-group passwordGroup">
									<label>Confirm Password</label>
									<input type="password" class="form-control" name="confirm_password" placeholder="******" aria-label="" aria-describedby="button-addon4" name="password" required>
								</div>
								<div class="form-group">
									<small class="text-primary">Password must be minimum 8 characters long.<br></small>
									<small class="text-primary">Password should contain at least one capital letter (A-Z), one small letter (a-z), one number (0-9) and one special character (!@#$%^&amp;*).</small>
								</div>
								<div class="form-group">
			                  <button class="btn btn-success signup-btn btn-block login-btn" type="submit" style="padding: 6px 25px;">Submit</button>
			               </div>
							</div>

							<!-- <div class="col-lg-12">

								<div class="form-group passwordGroup">

									<label>Confirm Password</label>

									<div class="input-group">

										<input type="password" class="form-control" name="confirm_password" placeholder="******" aria-label="" aria-describedby="button-addon4" name="password" required>

										<div class="input-group-append" id="button-addon4">

											<button class="btn btn-outline-primary viewPassword" type="button"><i class="fas fa-eye"></i></button>

										</div>

									</div>

								</div>

								<div class="form-group">

									<small class="text-info">Password must be minimum 8 characters long.<br></small>

									<small class="text-info">Password should contain at least one capital letter (A-Z), one small letter (a-z), one number (0-9) and one special character (!@#$%^&amp;*).</small>

								</div>

							</div>

							<div class="text-center">

						    	<button type="submit" class="btn btn-primary signup-btn mt-4">Submit</button>

							</div> -->

						</form>
            <!-- <div class="card bg-secondary border-0 mb-0">
					<div class="card-header bg-transparent pb-3">
						<div class="text-center mt-2 mb-3"><h2 class="text-dark">Enter email to recover password.</h2></div>
					</div>
					<div class="card-body px-lg-5 py-lg-5">
						
						
					</div>
				</div> -->
         </div>
      </div>
   </div>
</div>

	<!-- Header -->

	<!-- <div class="header bg-gradient-warning py-7 py-lg-7 pt-lg-8">

		<div class="container">

			<div class="header-body text-center mb-7">

				<div class="row justify-content-center">

					<div class="col-xl-5 col-lg-6 col-md-8 px-5">

						<h1 class="text-white">Recover Password!</h1>

					</div>

				</div>

			</div>

		</div>

		<div class="separator separator-bottom separator-skew zindex-100">

			<svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">

				<polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>

			</svg>

		</div>

	</div> -->

	<!-- Page content -->

	
@endsection