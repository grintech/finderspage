@extends('layouts.adminloginlayout')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<style>
	.height-100 {height: 100vh}
	body.bg-default{background-color: #000!important;}
	.card {background-color: #fff;width: 400px;border: none;/*height: 400px;*/z-index: 1;display: flex;justify-content: center;align-items: center;margin-bottom: 0;}
	.card-body1{width: 85%;}
	.logo-frame img{width: 70px; /*background-color: #fff; padding: 10px; border-radius: 16px;*/ margin-bottom: 30px;/*box-shadow: 0 1px 3px 2px rgba(50, 50, 93, .15), 0 1px 0 rgba(0, 0, 0, .02);*/}
	.input-group-alternative{position: relative; border-radius: 16px; box-shadow: none!important;border: 0!important;}
	.card-body .form-group span{background: transparent;}
	.input-group-alternative .icon1 {position: absolute;background: #a54db7;color: #f3be4a;left: -2px;top: 0;display: flex;align-items: center;height: 100%;width: 40px;height: 40px;justify-content: center;border-radius: 20px; z-index: 11;}
.input-group-alternative .icon1:after {content: "";display: block;width: 0;height: 0;border: 12px solid transparent;border-left: 12px solid #a54db7;position: absolute;top: 8px;right: -20px;}
.input-group-alternative .icon1 i{font-size: 16px; color: #fff;}
/*.input-group-alternative input{height: 40px; padding-left:55px; border-radius: 16px;}*/
.input-group-alternative input {border: 1px solid rgba(0, 0, 0, 0.6)!important;width: 100%;border-radius: 16px!important;height: 40px;background: rgba(255, 255, 255, 0.2)!important;color: #000!important;outline: none;transition: all 0.2s;padding-left: 55px;padding-top: 9px;}
.input-group-alternative input::placeholder {color: #000;}
.input-group-alternative input:hover,
.input-group-alternative input:focus {background: #fff!important;color: #000!important;transition: all 0.2s;}
.shadow-0{box-shadow: none!important;}
.signup-btn {
/*  background-color: #000!important;*/
background: linear-gradient(90deg, rgba(220, 114, 40, 1) 70%, #a54db7 100%);
  border-radius: 35px!important;
  color: #fff !important;
  border: 0;
  outline: 0;
  padding:8px 40px;
  font-size: 16px;
  font-weight: 500;
  border:0!important;
}
.signup-btn:hover, .signup-btn:focus{background: linear-gradient(90deg, rgba(220, 114, 40, 1) 50%, #a54db7 100%)!important;border-radius: 35px!important;color: #fff !important;border:0!important;}
@media only screen and (max-width:380px){
.card{width: 300px!important;height:100%; padding-top: 25px!important; padding-bottom: 25px!important;}
}
	@media only screen and (max-width:767px){
		.head{font-size: 26px;}
	}
</style>
	<!-- Header -->

	<!-- <div class="py-7 py-lg-7 pt-lg-8">

		<div class="container">

			<div class="header-body text-center mb-7">

				<div class="row justify-content-center">

					<div class="col-xl-5 col-lg-6 col-md-8 px-5">

						<h1 class="text-white head">Welcome!</h1>

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

	<div class="container height-100 d-flex justify-content-center align-items-center">

		<div class="position-relative">


				<div class="card p-2 py-4">

					<!-- <div class="card-header bg-transparent pb-3 text-center mt-5">

						<h1 class="text-white head py-3">Welcome!</h1>

						<div class="text-center mt-2 mb-3"><h2 class="text-white">Sign in with credentails</h2></div>

					</div> -->

					<div class="card-body1">
                        <div class="logo-frame text-center">
                        	<img src="https://finderspage.com/public/uploads/logos/new-logo.png" alt="...">
                        </div>
						<!--!! FLAST MESSAGES !!-->

						@include('admin.partials.flash_messages')

						<form method="post" role="form" id="sign_in" action="<?php echo route('admin.login') ?>">

							<!--!! CSRF FIELD !!-->

							{{ csrf_field() }}



							<?php if(isset($recaptchaEnabled) && $recaptchaEnabled): ?>

								<input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">

							<?php endif; ?>

							<div class="form-group mb-3">

								<div class="input-group input-group-merge input-group-alternative">

									<div class="input-group-prepend icon1">

										<!-- <span class="input-group-text"><i class="ni ni-email-83"></i></span> -->
										<span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>

									</div>

									<input class="form-control" required placeholder="Email" type="email" name="email" value="{{ old('email') }}">

								</div>

								@error('email')

								    <small class="text-danger">{{ $message }}</small>

								@enderror

							</div>

							<div class="form-group mb-1">

								<div class="input-group input-group-merge input-group-alternative">

									<div class="input-group-prepend icon1">

										<!-- <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span> -->
										<span class="input-group-text"><i class="bi bi-unlock-fill"></i></span>

									</div>

									<input class="form-control" required placeholder="Password" type="password" name="password" value="{{ old('password') }}">

								</div>

								@error('password')

								    <small class="text-danger">{{ $message }}</small>

								@enderror

							</div>

							<div class="custom-control text-right">

								<a href="<?php echo route('admin.forgotPassword') ?>" class="text-dark"><small>Forgot password?</small></a>

							</div>

							<div class="text-center">

						    	<button type="submit" class="signup-btn mt-2">Sign in</button>

							</div>

						</form>

					</div>

				</div>

			

		</div>

	</div>

@endsection