@extends('layouts.frontlayout')
@section('content')

      <style>
         .post-headng-sec h5 {
            line-height: 30px;
            margin-bottom: 10px;
         }

         .form-group.form-check {
            margin-right: 36px !important;
            margin-left: 20px;
         }

.main{
    padding: 2px;
    background-color: #3c3c3c;
    box-shadow: rgba(0,0,0,0.2) 0px 7px 29px 0px;
    border-radius: 5px;
    display: flex;
    flex-direction: inherit;
    justify-content: center;
    align-items: center;
    width: auto;
    min-height: 45px;
    overflow: hidden;
}

.d{
    border-radius: 15px 15px 0 0;
    padding: 5px;
    display: flex;
    align-items: center;
}

.d2{
    border-radius: 0 0 15px 15px;
}

/*hr{
    width: 340px;
    height: 2px;
    border: none;
    background-color: white;
}*/
.icon{
    height: 25px; width: 25px;
    background-color: #dc7228;
    border-radius: 50%;
    display: flex; justify-content: center;
    align-items: center;
    font-size: 13px;
    font-weight: 600;
}
.icon, .content_new{
    margin: 0 2px 0 2px;
}
.content_new{
    /*padding: 5px;
    margin: 0 5px 0 0;
    line-height: 8px;*/
    width: 70px;

}
.d.d3 h4{
    font-weight: lighter;
    font-size: 17px;
    border:1px solid white;
    border-radius: 10px;
}
.d3{
    border-radius: 0;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.register-photo .signup-btn {
    background: #FCD152;
    color: #212529;
    border: 1px solid #ab8b43;
}
.content_new h3 {
    color: #fff;
    font-size: 12px;
    font-weight: 500;
    margin: 0;
}
.content_new p {
    color: #fff;
    font-size: 15px;
}
span.txt5{font-size: 16px; font-weight: 600;}
 a.txt2.bo1 {color: #dc7228 !important;font-weight: 600;}

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
 .loginBtn--facebook:before, .loginBtn--google:before {background-position: center center;}
.construction-img{padding: 0px; object-fit: cover;}
.input-group-append #toggle-password{border-color: #fb9e5d; height: 40px; background-color: transparent; border-radius: 0 .25rem .25rem 0;}

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
         <div class="col-md-5 col-xs-12 sign-bg">
            <!-- <img src="{{ url('front/images/sign-up.png') }}" width="100%" height="100%" class="construction-img"> -->
            <!-- <img src="{{ asset('front/images/newsignup.jpeg') }}" width="100%" height="100%" class="construction-img"> -->
            <img src="{{ asset('front/images/signup.jpg') }}" alt="Image" width="100%" height="100%" class="construction-img">
         </div>


         <div class="col-md-7 col-xs-12">
            <form method="post" action="<?php echo route('auth.login') ?>" id="login" class="form-validation">
               {{ @csrf_field() }}
               <div class="post-headng-sec">
                  <h1 style="font-size: 22px;" class="post-head mb-2">Login </h1>
                  <h5>Login by providing your email and password</h5>
               </div>

               <!-- <div class="social-icon-sec">
                    <a href="#" class="btn-face m-b-20">
                        <i class="fa fa-facebook-square" aria-hidden="true"></i>Continue with Facebook
                    </a>
                    
                    <a href="#" class="btn-google m-b-20">
                       <img src="{{ url('front/images/icon-google.png') }}" alt="GOOGLE">Continue with Google
                    </a>
                 </div> -->

               <!-- <div class="or-sec">
                    <h5>OR</h5>
                 </div> -->
               <!-- @include('inc.flash_messages') -->
               <div class="form-group">
                  <label for="exampleInputEmail1">Email</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter your email" name="email" required>
                  <!-- <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter your email" name="email" required> -->
                  @error('email')
                  <small class="text-danger">{{ $message }}</small>
                  @enderror
               </div>

               <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password" required>
                        <div class="input-group-append">
                            <span class="input-group-text" id="toggle-password" onclick="togglePasswordVisibility()">
                              <i class="fa fa-eye" aria-hidden="true"></i>
                          </span>
                        </div>
                    </div>
                  <!-- <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password" required>
                  <div class="input-group-append d-flex justify-content-end">
                      <span class="input-group-text" id="toggle-password" onclick="togglePasswordVisibility()">
                          <i class="fa fa-eye" aria-hidden="true"></i>
                      </span>
                  </div> -->
                  @error('password')
                  <small class="text-danger">{{ $message }}</small>
                  @enderror
               </div>

               <div class="form-group text-center">
                  <button class="btn btn-success signup-btn btn-block login-btn" type="submit" style="padding: 6px 25px;">Log In</button>

                <div class="form-group social-login mt-3">
                  <span class="txt5 mb-4 sighn">Or</span>
                  <div class="row facebook_google d-flex justify-content-center">
                     <div class="col-12">
                        {{-- <a href="{{route('auth.facebook')}}" class="loginBtn loginBtn--facebook">Facebook </a> --}}
                        <a href="{{route('auth.google')}}" class="loginBtn loginBtn--google">Google</a>
                     </div>
                  </div>
               </div>

                   @if(Session::has('max_attempt_error_timestamp'))
                  <span>
                     <!-- Your HTML template -->
                     <div id="countdown-container" >
                       <p class="bg-danger text-white " style="font-size:12px; text-align: center;
    padding: 5px; border-radius: 5px;">Maximum attempts reached. Please wait for the next attempt in: <span id="countdown"></span></p>
                      
                     </div>
                  </span>
                  @endif
               </div>

               <div class="w-full text-center sign-txt">
                  <span class="txt2">Don't have an account?</span>
                  <a href="{{url('/signup')}}" class="txt2 bo1">Sign up</a>
               </div>
               <div class="w-full text-center sign-txt">
                  <span class="txt2">Don't Remember your  Password?</span>
                  <a href="<?php echo route('user.forgotPassword') ?>" class="txt2 bo1">Forgot Password</a>
               </div>
               
               @if($accounts != "")
               <div class="row log_attempt">
                <h3 class="mt-3 mt-md-5">Switch Account</h3>
               @foreach($accounts as $acc)
               <div class="col-md-3 col-3 mb-2 me-4 me-md-0">
                <a class="switchAccount" dataid="{{$acc->id}}" dataEmail="{{$acc->email}}" href="javascript:;">
                 
                    <div class="main">
                       <div class="icon">{{ strtoupper(substr($acc->first_name, 0, 1)) }}
                       </div>
                       <div class="content_new">
                           <h3>{{$acc->first_name}}</h3>
                       </div>
                   </div>
              
                </a>
               </div> 
               @endforeach
            </div>
            @endif
            </form>

         </div>

         
      </div>
   </div>
</div><!--main-page-->
 @if(Session::has('max_attempt_error_timestamp'))
<script type="text/javascript">
      $(document).ready(function() {
    $('.login-btn').addClass('d-none');
    $('.log_attempt').addClass('d-none');
    
    // Check if a countdown distance is stored in a cookie
    var storedDistance = getCookie('countdown_distance');
    if (storedDistance !== null) {
        startCountdown(parseInt(storedDistance));
    } else {
        // If no stored distance, start a new countdown
        startCountdown(15 * 60 * 1000); // 15 minutes in milliseconds
    }

    function startCountdown(initialDistance) {
        var countDownDate = new Date().getTime() + initialDistance;

        var countdown = setInterval(function() {
            var now = new Date().getTime();
            var distance = countDownDate - now;

            // Store the remaining time in a cookie
            document.cookie = 'countdown_distance=' + encodeURIComponent(distance) + '; expires=' + new Date(countDownDate).toUTCString() + '; path=/';

            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Display the time in the "countdown" div
            $('#countdown').text(minutes + ':' + (seconds < 10 ? '0' : '') + seconds);

            if (distance < 0) {
                clearInterval(countdown);
                // Countdown ended, do something here when the timer reaches 00:00
                $('#countdown').text('Time is up!');

                var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                $.ajax({
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    url: site_url+'/session-destroy', // Replace with the URL that handles session destruction on the server
                    success: function(response) {
                        // Handle the server response if needed
                        $('.login-btn').removeClass('d-none');
                        $('.log_attempt').removeClass('d-none');
                        location.reload(true);
                    },
                    error: function() {
                        // Handle the error if the AJAX request fails
                    }
                });
            }
        }, 1000);
    }

    // Function to get the value of a cookie by its name
    function getCookie(name) {
        var cookieValue = null;
        if (document.cookie && document.cookie !== '') {
            var cookies = document.cookie.split(';');
            for (var i = 0; i < cookies.length; i++) {
                var cookie = cookies[i].trim();
                // Check if this cookie contains the name we're looking for
                if (cookie.substring(0, name.length + 1) === (name + '=')) {
                    // Extract and return the cookie value
                    cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                    break;
                }
            }
        }
        return cookieValue;
    }
});

</script>
 @endif

 <script type="text/javascript">
     $(document).ready(function() {

             $(".switchAccount").click(function(){
             var id = $(this).attr('dataid');
             var email = $(this).attr('dataEmail');
             console.log(email);
             var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                     $.ajax({
                      type: 'POST',
                      headers: {
                      'X-CSRF-TOKEN': csrfToken
                    },
                    url: site_url+'/switch-account',
                    data: {
                        id: id,
                        email:email
                        
                    },
                      
                      success: function(response) {
                        console.log(response);
                        window.location.href = "https://www.finderspage.com/user-index";
                      },
                      error: function() {
                          // Handle the error if the AJAX request fails
                      }
                  });
            });

        });

        function togglePasswordVisibility() {
            var passwordInput = document.getElementById("exampleInputPassword1");
            var togglePassword = document.getElementById("toggle-password");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                togglePassword.innerHTML = '<i class="fa fa-eye-slash" aria-hidden="true"></i>';
            } else {
                passwordInput.type = "password";
                togglePassword.innerHTML = '<i class="fa fa-eye" aria-hidden="true"></i>';
            }
        }

 </script>

@endsection