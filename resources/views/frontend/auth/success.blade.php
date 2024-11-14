@extends('layouts.frontlayout')
@section('content')
<div class="register-photo">
    <div class="form-container">
       <div class="row">
         <div class="col-md-12 col-sm-12 col-xs-12">
             <div class="post-headng-sec px-5 py-5">
                <h4 class="post-head mb-4">Thank you for your registration.</h4>
                <p class="px-5 text-center">A verification link has been sent to your email address.</p>
                <p class="px-6 pt-3 text-center text-primary">If you do not see the email, check your junk or spam folder. We make every effort to ensure that these emails are delivered.</p>
             </div>
         </div>
       </div> 
    </div>
     <div  class="btn_section mt-5">
      <!-- <a href="<?php //echo route('homepage.index') ?>" class="btn btn-primary">Go to Home Page</a> -->
      <!-- <span class="hrrr"><span>OR</span></span>
      <a href="<?php //echo route('post.create') ?>" class="btn btn-primary2">Create a Feature Post</a>
      <p style="text-align: center;margin-top: 20px">Choose the best category that fits your needs and create a post</p> -->
    </div>
</div><!--main-page-->

@endsection