@extends('layouts.frontlayout')
@section('content')

<div class="register-photo">
   <div class="form-container">
      <style>
         .post-headng-sec h5 {
            line-height: 30px;
            margin-bottom: 10px;
         }

         .form-group.form-check {
            margin-right: 36px !important;
            margin-left: 20px;
         }
         .construction-img{padding: 0px; object-fit: cover;}

           @media only screen and (max-width:767px){
            .sign-bg{width: 100% !important; background-color: transparent;}
            .construction-img{width: 100%;}
         }
         
@media only screen and (min-width:768px) and (max-width:991px){
   .sign-bg{width: 41.66666667% !important; background-color: transparent;}
}
        
      </style>
      <div class="row">
         <span>
                        @include('admin.partials.flash_messages')
                    </span>
         <div class="col-md-5 col-sm-5 col-xs-12 sign-bg">
            <!-- <img src="{{ asset('front/images/newsignup.jpeg') }}" width="100%" height="100%" class="construction-img"> -->
            <img src="{{ asset('front/images/signup.jpg') }}" width="100%" height="100%" class="construction-img" alt="Image">
            
            <!-- <img src="{{ url('front/images/sign-up.png') }}" width="100%" height="100%" class="construction-img"> -->
         </div>


         <div class="col-md-7 col-sm-7 col-xs-12 pt-2 mt-2 pt-md-5 mt-md-5">
         	@include('admin.partials.flash_messages')
						<form method="post" action="<?php echo route('user.forgotPassword') ?>" role="form" id="forgot_password">
							<!--!! CSRF FIELD !!-->
							{{ csrf_field() }}
							<div class="post-headng-sec">
		                  <h1 style="font-size: 20px;" class="post-head">Enter email to recover password.</h1>
		               </div>
							<div class="form-group mb-3">
								<label for="exampleInputEmail1">Enter Email</label>
								<input class="form-control" required placeholder="Email" type="email" name="email" value="{{ old('email') }}">
								@error('email')
								    <small class="text-danger">{{ $message }}</small>
								@enderror
								<!-- <div class="input-group input-group-merge input-group-alternative">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="bi bi-email"></i></span>
									</div>
									<input class="form-control" required placeholder="Email" type="email" name="email" value="{{ old('email') }}">
								</div> -->
								
							</div>
							<div class="custom-control text-right back-button">
								<a href="<?php echo route('auth.login') ?>" class="text-dark"><small><i class="fas fa-arrow-left"></i> Back</small></a>
							</div>
							<!-- <div class="text-center">
						    	<button type="submit" class="btn btn-success signup-btn btn-block login-btn">Submit</button>
							</div> -->
							<div class="form-group submit-new-button">
		                  <button class="btn btn-success signup-btn btn-block login-btn" type="submit" style="padding: 6px 25px;">Submit</button>
		               </div>
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
</div><!--main-page-->
	<!-- Header -->
	<!-- <div class="header bg-gradient-warning py-7 py-lg-7 pt-lg-8">
		<div class="container">
			<div class="header-body text-center mb-7">
				<div class="row justify-content-center">
					<div class="col-xl-5 col-lg-6 col-md-8 px-5">
						<h1 class="text-white">Forgot Password?</h1>
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
	<!-- <div class="container mt--8 pb-5">
		<div class="row justify-content-center">
			<div class="col-lg-5 col-md-7">
				
			</div>
		</div>
	</div> -->
@endsection