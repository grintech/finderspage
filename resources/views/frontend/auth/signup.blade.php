@extends('layouts.frontlayout')

@section('content')
<link rel="stylesheet" href="{{  asset('assets/css/slidercaptcha.css') }}" />
<style>
   .post-headng-sec h5 {

      line-height: 30px !important;

      margin-bottom: 10px !important;

   }

   .form-group.form-check {

      margin-right: 36px !important;

   }

   .social-login {
      display: grid;
   }

   .loginBtn--facebook {
      background-color: #4C69BA;
      background-image: linear-gradient(#4C69BA, #3B55A0);
      /*font-family: "Helvetica neue", Helvetica Neue, Helvetica, Arial, sans-serif;*/
      text-shadow: 0 -1px 0 #354C8C;
      /* margin-left: 110px; */
      color: white!important;

   }

   .loginBtn {
      box-sizing: border-box;
      position: relative;
      /* width: 13em;  - apply for fixed size */
      margin: 0.2em;
      border: none;
      text-align: center;
      line-height: 24px;
      white-space: nowrap;
      border-radius: 0.2em;
      font-size: 16px;
      color: #FFF;
      padding: 6px 10px 6px 40px;
      display: inline-block;
      width: 48%;
      height: 38px;
   }

   .loginBtn:before {
      content: "";
      box-sizing: border-box;
      position: absolute;
      top: 0;
      left: 0;
      width: 34px;
      height: 100%;
   }

   .loginBtn:focus {
      outline: none;
   }

   .loginBtn:active {
      box-shadow: inset 0 0 0 32px rgba(0, 0, 0, 0.1);
   }

   .loginBtn--facebook:before {
      border-right: #364e92 1px solid;
      background: url('https://s3-us-west-2.amazonaws.com/s.cdpn.io/14082/icon_facebook.png') center center no-repeat;
      /* margin-left: 110px; */
   }

   .loginBtn--facebook:hover,
   .loginBtn--facebook:focus {
      background-color: #5B7BD5;
      background-image: linear-gradient(#5B7BD5, #4864B1);
   }

   /* Google */
   .loginBtn--google {
      /*font-family: "Roboto", Roboto, arial, sans-serif;*/
      background: #DD4B39;
      color: white!important;

   }

   .loginBtn--google:before {
      border-right: #BB3F30 1px solid;
      background: url('https://s3-us-west-2.amazonaws.com/s.cdpn.io/14082/icon_google.png') center center no-repeat;
   }

   .loginBtn--google:hover,
   .loginBtn--google:focus {
      background: #E74B37;
   }

   .facebook_google {
      text-align: center;
   }
   .sighn{
      text-align: center;
   }
   span.txt5{font-size: 16px; font-weight: 600;}
   a.txt2.bo1 {color: #dc7228 !important;font-weight: 600;}
   .form-check label.form-check-label a{ color:#b90b0b!important;}
   label.form-check-label {
    font-size: 12px!important;
    line-height: 20px!important;
}
.construction-img{padding: 0px; object-fit: cover;}
.input-group-append #toggle-password, .input-group-append #toggle-CPass{border-color: #fb9e5d; height: 40px; background-color: transparent; border-radius: 0 .25rem .25rem 0;}

   @media only screen and (max-width:991px){
      .loginBtn {width: 46%;}
            .sign-bg{width: 100% !important; background-color: transparent;}
            .main{width: 100px;}
            .construction-img{width: 100%;}
         .form-check-input{width: 1.25em;height: 1.25em;}
         .otpmessage_cl {width: 60%;}
      }

@media only screen and (min-width:768px) and (max-width:991px){
   .sign-bg{width: 41.66666667% !important; background-color: transparent;}
}

      label.form-check-label{ font-size:11px!important;line-height: 25px!important;}

/*a.verify_btn {
    position: relative;
    bottom: -53px;}*/

.verify-email{position: relative;display: flex;justify-content: space-between;align-items: baseline;}
.verify_btn{font-size: 12px;text-transform: capitalize;color: #1C4CBF!important;position: relative;top: 2px;text-decoration: underline!important;}
.otpmessage_cl{font-size: 12px;}  
</style>

<div class="register-photo">

   <div class="form-container">

      <div class="row">

         <div class="col-md-5  col-xs-12 sign-bg">

            <!-- <img src="{{ url('front/images/sign-up.png') }}" width="100%" height="100%" class="construction-img">  -->

            <!-- <img src="{{asset('front/images/newsignup.jpeg') }}" width="100%" height="100%" class="construction-img"> -->
            <img src="{{ asset('front/images/signup.jpg') }}" alt="Image" width="100%" height="100%" class="construction-img">

         </div>

         <div class="col-md-7  col-xs-12 form-box">

            <form method="post" action="{{url('/usersignupfront')}}" id="signup">

               {{ @csrf_field() }}

               <input type="hidden" name="in_site_register" value="4">

               <input type="hidden" name="role" value="business">

               <div class="post-headng-sec">

                  <h1 style="font-size: 25px;" class="post-head">Sign Up </h1>

                  <!-- <h5>By signing up, I agree to the FindersPage </h5>

                    <span><a href="#">Terms of Use and Privacy Policy.</a></span> -->

               </div>



               <div style="display:none;" class="social-icon-sec"><br>

                  <a style="display:none;" href="#" class="btn-face m-b-20">

                     <i class="fa fa-facebook-square" aria-hidden="true"></i>Continue with Facebook

                  </a>



                  <a href="#" class="btn-google m-b-20">

                     <img src="{{ asset('front/images/icon-google.png') }}" alt="Image">Continue with Google

                  </a>

               </div>



               <!-- <div class="or-sec">

                    <h5>OR</h5>

                 </div> -->

               @include('inc.flash_messages')

               <div class="form-group">

                  <label for="exampleInputEmail1">Name</label>

                  <input type="text" class="form-control" id="exampleInputName" aria-describedby="" placeholder="Enter your name" name="first_name" value="{{old('first_name')}}" required>

                  @error('first_name')

                  <small class="text-danger">{{ $message }}</small>

                  @enderror

               </div>

               <div class="form-group">

                  <label for="exampleInputEmail1">Username</label>

                  <input type="text" class="form-control" placeholder="Enter Username" name="username" required value="{{old('username')}}">

                  @error('username')
                  <small class="text-danger">{{ $message }}</small>
                  @enderror

               </div>


               <!-- <div class="form-group">
                  <label for="exampleInputEmail1">Date of birth</label>

                  <input type="date" class="form-control"  name="dob" value="">
               </div> -->


               <div class="form-group col-lg-12">
                  <div class="verify-email">
                     <label for="exampleInputEmail1">Email</label> 
                     <span class="otpmessage_cl text-danger"></span><a class="verify_btn" id="otpmessage" href="javascript:void(0);"> verify email</a>
                  </div>
                  <input type="email" class="form-control emailval" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter your email" name="email" required value="{{old('email')}}">
                  <span class="text-danger get_err_msg" style="font-size: small;"></span>
                  @error('email')

                  <small class="text-danger">{{ $message }}</small>

                  @enderror

               </div>

                {{-- <div class="col-lg-2" style="font-size: xx-small;font-weight: 600;">
                     <a class="verify_btn" id="otpmessage" href="#"> verify email</a>

               </div> --}}
                <div class="form-group">
                   <label for="exampleInputEmail1">Otp</label>
                   <input type="text" class="form-control" name="otp" id="otpInput" placeholder="Enter the one time code to verify sent from your email" required>
                   @error('otp')
                   <small class="text-danger">{{ $message }}</small>
                   @enderror
               </div> 




               <div class="form-group">

                  <label for="exampleInputPassword1">Password</label>
                  <div class="input-group">
                     <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Enter Password" name="password" required>
                     <div class="input-group-append">
                         <span class="input-group-text" id="toggle-password" onclick="togglePasswordVisibility('exampleInputPassword1', 'toggle-password')">
                           <i class="fa fa-eye" aria-hidden="true"></i>
                       </span>
                     </div>
                 </div>
                  <!-- <div class="input-group">
                      <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Enter Password" name="password" required>
                      <div class="input-group-append">
                          <span class="input-group-text" id="toggle-password" onclick="togglePasswordVisibility('exampleInputPassword1', 'toggle-password')">
                              <i class="fa fa-eye" aria-hidden="true"></i>
                          </span>
                      </div>
                  </div> -->
                  @error('password')

                  <small class="text-danger">{{ $message }}</small>

                  @enderror

               </div>



               <div class="form-group">
                  <label for="exampleInputPassword2">Confirm Password</label>
                  <div class="input-group">
                     <input type="password" class="form-control" id="exampleInputPassword2" placeholder="Enter Password" name="confirm_password" required>
                     <div class="input-group-append">
                         <span class="input-group-text" id="toggle-CPass" onclick="togglePasswordVisibility('exampleInputPassword2', 'toggle-CPass')">
                           <i class="fa fa-eye" aria-hidden="true"></i>
                       </span>
                     </div>
                 </div>
                  <!-- <div class="input-group">
                     <input type="password" class="form-control" id="exampleInputPassword2" placeholder="Enter Password" name="confirm_password" required>
                     <div class="input-group-append">
                           <span class="input-group-text" id="toggle-CPass" onclick="togglePasswordVisibility('exampleInputPassword2', 'toggle-CPass')">
                              <i class="fa fa-eye" aria-hidden="true"></i>
                           </span>
                     </div>
                  </div> -->

                  @error('password')

                  <small class="text-danger">{{ $message }}</small>

                  @enderror

               </div>

            {{-- <div class="form-group{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Captcha</label>
                            <div class="col-md-6">
                                {!! app('captcha')->display() !!}
                                 @error('g-recaptcha-response')
                                    <span class="help-block">
                                        <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                    </span>
                                 @enderror
                            </div>
                        </div> --}}
               
               <style>
                  .slidercaptcha .card-body {
                     padding: 1rem;
                  }

                  .slidercaptcha canvas:first-child {
                     border-radius: 4px;
                     border: 1px solid #e6e8eb;
                  }

                  .slidercaptcha.card .card-header {
                     background-image: none;
                     background-color: rgba(0, 0, 0, 0.03);
                  }

               </style>
               <div class="">
                  <div class="form-row">
                        <div class="col-12">
                           <div class="slidercaptcha ccard">
                              <div class="card-body p-xs-0">
                                    <div id="captcha"></div>
                              </div>
                           </div>
                        </div>
                  </div>
               </div>

               <div class="form-group form-check" id="termsCondition">

                  <div class="col-md-12 col-sm-12 col-xs-12">

                     <input type="checkbox" class="form-check-input" name="privacyPolicy" value="1" id="exampleCheck1" required>

                     <label class="form-check-label" for="exampleCheck1">I agree to the <a href="https://finderspage.com/term-of-use">Terms of Use & Privacy Policy</a></label>

                     @error('privacyPolicy')

                     <small class="text-danger">{{ $message }}</small>

                     @enderror

                  </div>

               </div>
               <div class="form-group text-center">
                  <button class="btn btn-success signup-btn btn-block login-btn" type="submit">Sign Up</button>
               </div>
                <div class="form-group text-center">
                   <span class="txt2">Already have an account?</span>
                  <a href="<?php echo route('auth.login') ?>" class="txt2 bo1">Sign in</a>
                </div>

               <div class="form-group social-login">
                  <span class="txt5 mb-4 sighn">Or</span>
                  <div class="row facebook_google d-flex justify-content-center">
                     <div class="col-12">
                        {{-- <a href="{{route('auth.facebook')}}" class="loginBtn loginBtn--facebook">Facebook </a> --}}
                        <a href="{{route('auth.google')}}" class="loginBtn loginBtn--google">Google</a>
                     </div>
                  </div>
               </div>





               <!-- <div class="w-full text-center sign-txt">

                   <span class="txt2">Already have an account?</span>

                   <a href="<?php echo route('auth.login') ?>" class="txt2 bo1">Sign in</a>

                </div><br> -->

               <div class="w-full text-center sign-txt">

                  <span class="txt2">By Signing up, you agree to FindersPage</span>

                  <a href="{{route('term_of_use')}}" class="txt2 bo1">Terms of Use and Privacy Policy</a>

               </div>

            </form>



         </div>

      </div>

   </div>

</div><!--main-page-->

<script>
      $(document).ready(function() {
         $(".login-btn").css("pointer-events","none");
         $(".login-btn").css("opacity","0.5");
         $("#termsCondition").css("margin-top","0px");
         setTimeout(function () {
            var captcha = sliderCaptcha({
               id: 'captcha',
               repeatIcon: 'fa fa-redo',
               onSuccess: function () {
                  console.log('Success');
                  $(".login-btn").css("pointer-events","all");
                  $(".login-btn").css("opacity","1");
                  $("#termsCondition").css("margin-top","25px");
               },
               onFail: function () {
                  console.log('Error');
                  $(".login-btn").css("pointer-events","none");
                  $(".login-btn").css("opacity","0.5");
                  $("#termsCondition").css("margin-top","0px");
               }
            });
         }, 1000);
      });
</script>

<script>
    // Limit the OTP input to 6 digits
    document.getElementById('otpInput').addEventListener('input', function () {
        if (this.value.length > 6) 
            this.value = this.value.slice(0, 6); 
    });


         $(".verify_btn").click(function(){
            var email = $('.emailval').val();
            if(email!=''){
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            $.ajax({
                url: site_url + '/sendOTP',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    email: email,
                },
                success: function(response) {
                    console.log(response.success);
                    if(response.success){
                    // alert(response.success);
                    $(".otpmessage_cl").text('');
                    $(".otpmessage_cl").removeClass('text-danger');
                    $(".otpmessage_cl").addClass('text-success');
                    $('.otpmessage_cl').text(response.success);
                     }
                    
                  if(response.responseText){
                     $(".otpmessage_cl").text('');
                     $(".otpmessage_cl").addClass('text-danger');
                     $(".otpmessage_cl").text(response.responseText);
                  } 
                },
                error: function(xhr, status, error) {

                    
               }
            });
         }else{
            // $(".verify_btn").attr('disable',true);
            $(".otpmessage_cl").text('');
            $(".otpmessage_cl").text('email field can not be blank.');

         }
        });

        function togglePasswordVisibility(inputId, toggleId) {
            var passwordInput = document.getElementById(inputId);
            var toggleButton = document.getElementById(toggleId);

            if (passwordInput.type === "password") {
               passwordInput.type = "text";
               toggleButton.innerHTML = '<i class="fa fa-eye-slash" aria-hidden="true"></i>';
            } else {
               passwordInput.type = "password";
               toggleButton.innerHTML = '<i class="fa fa-eye" aria-hidden="true"></i>';
            }
         }

</script>

@endsection

