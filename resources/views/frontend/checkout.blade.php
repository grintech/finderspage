
<?php
 use App\Libraries\General;
 // $blog_id = General::decrypt($post_id);
 // dd($blog_id);

?>
@extends('layouts.user_dashboard.userdashboardlayout')
@section('content')
<?php 
         use App\Models\Admin\SubPlan;
        $plan_week = SubPlan::where('plan', 'Weekly')->first();
        $plan_month = SubPlan::where('plan', 'Monthly')->first();
        $plan_3month = SubPlan::where('plan', "Three Month's")->first();
        $plan_6month = SubPlan::where('plan', "Six Month's")->first();
        $plan_year = SubPlan::where('plan', "Yearly")->first();
?>
<section id="payment-section">
   <div class="container mt-5 mb-5">
      <div class="card p-3">
         <div class="row">
            <!-- Grid column for the image -->

            <div class="col-md-6 img-frame"> <img src="{{asset
            ('user_dashboard/img/feature-banner.png')}}" alt="Banner Image"
            class="img-fluid payment-img"> </div>
            <div class="col-md-6 mt-4 mt-md-0" id="sec_new">
               <h1 class="strip-heading">Select your payment option</h1>
               <div class="panel panel-default credit-card-box">
                  <div class="col-md-12">
                     <!-- Image here, but it will be hidden because it's empty -->
                  </div>
                  
                  <div class="panel-body">
                     
                     <a href="{{route('paypal.featured_post', ['post_id' => General::encrypt($blog_id)])}}" class="btn btn-warning"> PayPal</a>
                    <a href="{{route('stripe.createstripe',['post_id' => General::encrypt($blog_id)])}}" class="btn btn-primary">Credit and Debit card</a>
                  </div>
               </div>
            </div>

        </div>
    </div>
</div>
</section>



@endsection