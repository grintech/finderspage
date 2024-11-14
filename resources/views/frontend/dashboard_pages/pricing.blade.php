<?php use App\Models\UserAuth; 
    $User_data = UserAuth::getLoginUser();

     // dd($User_data->subscribedPlan);
    
?>
@extends('layouts.user_dashboard.userdashboardlayout')
@section('content')
<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css" rel="stylesheet"> -->
<script src="https://www.paypal.com/sdk/js?client-id=AXCsp61Xi_n27Zd05WKr6JjvLp1SeDEZzL43f2zzjNNpjqdZNXIVGljO75dguLFMwBR6LS8ZGAm3wtvM"></script>
<style>
@import url("https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,400&display=swap");

.rounded {border-radius: 15px !important;}
.hidden {visibility: hidden;opacity: 0;}
.btn {transition: all 0.25s ease-in-out;}
.btn-teal {background: #000;color: #ffffff;}
.btn-teal:hover {background-color: #a54db7;color: #fff;}
.pricing-intro .sub-title {font-size: 12px;font-weight: 400;}
.pricing-plan {background: #f2f2f2;border: 1px solid #fff;cursor: pointer;transition: all 0.25s ease-in-out;display: flex;align-items: center;justify-content: center;}
.pricing-plan:hover {background: #000;color: #fff;}
.pricing-plan.active-btn {
background: linear-gradient(90deg, rgba(220, 114, 40, 1) 50%, #a54db7 100%);color: #fff;}
.pricing-plans h3{font-size: 20px; font-weight: 700;}
.pricing-plan h4{font-size: 14px; font-weight: 700;}

.pricing-table h2 {font-size: 1.10em;font-weight: 600;}
.pricing-table .sub-title {font-size: 12px;font-weight: 600!important;color: #000;margin-bottom: 0!important;}
.pricing-table .active-plan {display: block !important;width:50%;}
.col-compare .title-row {border-top-left-radius: 10px;}
.col-enterprise .title-row {border-top-right-radius: 0px;}
.col-free .title-row{border-top-right-radius: 10px;}
.pricing-compare {border-top-left-radius: 10px;border-bottom-left-radius: 10px;}
.pricing-enterprise {border-bottom-right-radius: 0px;}
.col-pricing:hover {z-index: 1;}
.pricing-single {background: #f7f7f7;min-height: 100px;margin-left: 1px;margin-right: 1px;transition: all 0.25s ease-in-out;border-right: 1px solid #dfdfdf;}
.pricing-single:first-child{border-left:1px solid #dfdfdf;}
.pricing-single:nth-child(7){border-right:1px solid #dfdfdf;}
.pricing-single:hover:not(.pricing-compare) {box-shadow: 0 0 10px rgba(0, 0, 0, 0.25);transform: scale(1.005);}
.pricing-single:last-of-type {border-top-right-radius: 10px;}
.title-row {background: #000;color: #fff;min-height: 50px;padding: 0px;align-items:center;}
.title-row h2{margin-bottom: 0;}
.pricing-popular {min-height: 30px;border-radius: 5px 5px 0 0;z-index: 2;margin-bottom: 8px;align-items:center;}
.pricing-popular h4 {font-size: 14px;font-weight: 400;}
.pricing-popular.active {
background: linear-gradient(90deg, rgba(220, 114, 40, 1) 50%, rgba(205, 89, 8, 1) 100%);color: #fff;}
.active-plan .pricing-single {
background: linear-gradient(90deg, rgba(220, 114, 40, 1) 50%, rgba(205, 89, 8, 1) 100%); color: #fff;}
.col-popular .btn-teal {color: #ffffff;}
.col-popular .btn-teal:hover {background-color: #a54db7;color: #fff;}
.cost-row {border-bottom: 1px solid #dfdfdf;min-height: 100px;align-items:center;}
.cost-row .cost {font-size: 30px;font-weight: 700;line-height: 1em;color: #dc7228;}
.cost-wrap .cost.price-text{font-size: 18px;color:#000;}
.active-plan .cost-row .cost{color: #fff;}
.compare-item-row {height: 60px;align-items:center;}
.compare-item-row:last-of-type {border-bottom: none;}
.compare-item-row .circle {font-size: 15px;font-weight: 600;}
.compare-item-row .compare-title {font-weight: 700;}
.sub-plan{font-weight: 600;}
.compare-item-row .cancel-button{background-color: #000; border-radius: 5px; font-size: 10px; color: #fff;}
.compare-item-row .current-btn{background-color: #000; border-radius: 5px; font-size: 10px; color: #fff;}
.compare-item-row .selection-frame label{font-size: 12px; display: inline-flex; flex-wrap: wrap; justify-content: center;}
input[type="checkbox"]:checked {background: #000;}

@media screen and (max-width: 1199px) {
.compare-item-row {height: 70px;}
}

@media screen and (max-width: 991px) {
.pricing-table {font-size: 14px;padding-bottom: 20px;}
}

@media screen and (max-width: 767px) {
.pricing-single:not(.pricing-compare) {border-top-right-radius: 10px;border-bottom-right-radius: 10px;}
.pricing-single:not(.pricing-compare) .title-row {border-top-right-radius: 10px;}
.pricing-single:hover {box-shadow: none !important;transform: none !important;}
.pricing-table{padding-bottom: 50px !important;}
}

@media screen and (max-width: 460px) {
.cost-row .cost {font-size: 30px;}
.cost-row{min-height: 80px;}
.compare-item-row {height: 50px;}

}
@media screen and (max-width: 300px) {
.compare-item-row {height: 60px;}
.compare-item-row:last-of-type{flex-direction: column;}
}
</style>

<body>
  <div class='container my-3 my-md-5'>
    <div class="row">
      <div class="col-12 text-center">
        <span>
            @include('admin.partials.flash_messages')
        </span>
        <h3 class='sub-plan pb-2 mb-0'>Subscription Plans</h3>
        <p class="mb-2">Get featured and get up to 10x more views</p>
        <p class="mb-3">Automatically notify your connections that follow you</p>
      </div>
    </div>
    <div class='row d-block d-md-none pricing-plans d-flex justify-content-center mb-4'>
      <div class='col-4 pricing-plan text-center  @if($User_data->subscribedPlan =="weekly") active-btn @endif' data-plan='weekly-plan'>
        <h4 class='py-2 mb-0'>One Week</h4>
      </div>
      <div class='col-4 pricing-plan text-center @if($User_data->subscribedPlan =="month") active-btn @elseif($User_data->subscribedPlan =="") active-btn @endif' data-plan='monthly-plan'>
        <h4 class='py-2 mb-0'>One Month</h4>
      </div>
      <div class='col-4 pricing-plan text-center @if($User_data->subscribedPlan =="three-month") active-btn @endif' data-plan='three-month-plan'>
        <h4 class='py-2 mb-0'>Three Months</h4>
      </div>
      <div class='col-4 pricing-plan text-center @if($User_data->subscribedPlan =="six-month") active-btn @endif' data-plan='six-month-plan'>
        <h4 class='py-2 mb-0'>Six Months</h4>
      </div>
      <div class='col-4 pricing-plan text-center @if($User_data->subscribedPlan =="yearly") active-btn @endif' data-plan='yearly-plan'>
        <h4 class='py-2 mb-0'>One Year</h4>
      </div>
      <!-- <div class='col-4 pricing-plan text-center @if($User_data->subscribedPlan =="") active-btn @endif' data-plan='free-plan'>
        <h4 class='py-2 mb-0'>Free</h4>
      </div> -->
    </div>

    <div class='row pricing-table'>
      <div class='col px-0 col-compare'>
        <div class='pricing-popular mb-2'></div>
        <div class='pricing-single pricing-compare'>
          <div class='title-row d-flex justify-content-start align-items-center px-1 px-md-3'>
            <div class='title-wrap'>
              <h2>Featured</h2>
            </div>
          </div>
          <div class='cost-row d-flex justify-content-start align-items-center px-1 px-md-3'>
            <div class='cost-wrap'>
              <h3 class='cost price-text mb-0'>Pricing</h3>
            </div>
          </div>
          <div class='compare-item-row d-flex justify-content-start align-items-center px-1 px-md-3'>
            <span class='compare-title'>Featured Posts</span>
          </div>
          <div class='compare-item-row d-flex justify-content-start align-items-center px-1 px-md-3'>
            <span class='compare-title'>Bump Posts</span>
          </div>
          
          <div class='compare-item-row d-flex justify-content-start align-items-center px-1 px-md-3'>
            <span class='compare-title'>Paid listing</span>
          </div>
          <div class='compare-item-row d-flex justify-content-start align-items-center px-1 px-md-3'>
            <span class='compare-title'>Display Post on Home Page</span>
          </div>
          
          <div class='compare-item-row d-flex justify-content-start align-items-center px-1 px-md-3'>
            <span class='compare-title'>Slideshow for Posts (Up to 15) </span>
          </div>

          
          <!-- <div class='compare-item-row d-flex justify-content-start align-items-center px-1 px-md-3'>
            <span class='compare-title'>Collage </span>
          </div> -->

          <div class='compare-item-row d-flex justify-content-start align-items-center px-1 px-md-3'>
            <span class='compare-title'>Golden Star Badge</span>
          </div>
          <div class='compare-item-row d-flex justify-content-start align-items-center px-1 px-md-3'>
            <span class='compare-title'>Cancellation</span>
          </div>
          <div class='compare-item-row d-flex justify-content-start align-items-center px-1 px-md-3'>
            <span class='compare-title'>Available Now</span>
          </div>
          <div class='compare-item-row d-flex justify-content-start align-items-center px-1 px-md-3'>
            <span class='compare-title'>Update Button</span>
          </div>
          <!-- <div class='compare-item-row d-flex justify-content-start align-items-center px-1 px-md-3'>
            <span class='compare-title'>Available for the holidays and on vacation</span>
          </div> -->
          <div class='compare-item-row d-flex justify-content-start align-items-center px-1 px-md-3'>
            <span class='compare-title'></span>
          </div>
        </div>
      </div>

      <div class='d-none d-md-block col  px-0 col-pricing col-basic @if($User_data->subscribedPlan =="weekly")active-plan @endif' id='weekly-plan'>
        <div class='pricing-popular mb-2'></div>
        <div class='pricing-single pricing-basic'>
          <div class='title-row d-flex justify-content-center align-items-center'>
            <div class='title-wrap text-center'>
              <h2>One Week </h2>
            </div>
          </div>
          <div class='cost-row d-flex justify-content-center align-items-center'>
            <div class='cost-wrap text-center'>
              <h3 class='cost mb-0'>${{$plan_week->price}}</h3>
              @if($User_data->subscribedPlan =='weekly') 
                <span class="pt-4">Current active plan</span>
               @endif
            </div>
          </div>
          <div class='compare-item-row d-flex justify-content-center align-items-center'>
            <div class='circle bg-teal'>{{$plan_week->feature_listing}}</div>
          </div> 

          <div class='compare-item-row d-flex justify-content-center align-items-center'>
            <div class='circle bg-teal'>2</div>
          </div>

          <div class='compare-item-row d-flex justify-content-center align-items-center'>
            <div class='circle bg-teal'>1</div>
          </div>

          <div class='compare-item-row d-flex justify-content-center align-items-center'>
            <div class='circle bg-teal'>✓</div>
          </div>
          
          <div class='compare-item-row d-flex justify-content-center align-items-center'>
            <!-- <div class='circle bg-teal'>Upto {{$plan_week->slideshow}}</div> -->
            <div class='circle bg-teal'>✗</div>
          </div>
          <!-- <div class='compare-item-row d-flex justify-content-center align-items-center'>
            <div class='circle bg-teal'>✗</div>
          </div> -->

          <div class='compare-item-row d-flex justify-content-center align-items-center'>
            <div class='circle bg-teal'>✓</div>
          </div>
          <div class='compare-item-row d-flex justify-content-center align-items-center'>
            <div class='circle bg-teal'>✓</div>
          </div>
          <div class='compare-item-row d-flex justify-content-center align-items-center'>
            <div class='circle bg-teal'>✗</div>
          </div>
          <div class='compare-item-row d-flex justify-content-center align-items-center'>
            <div class='circle bg-teal'>✗</div>
          </div>
          <!-- <div class='compare-item-row d-flex justify-content-center align-items-center'>
            <div class='circle bg-teal'>✗</div>
          </div> -->
           @if($User_data->subscribedPlan =='weekly') 
          {{-- <div class="compare-item-row d-flex justify-content-center align-items-center">
            <div class="selection-frame py-2">
              <label class="custom-toggle">
                
                <input type="checkbox" checked name="paymentType" value="true" {{ $User_data->payment_type == 'Automatic'? 'checked' : '' }}> &nbsp;&nbsp;<span>Auto repost</span> -->
              </label>
            </div>
          </div> --}}
          <div class='compare-item-row d-flex justify-content-between align-items-center px-2'>
            <a href="#" id="cancelSubscription" data-link="@if($User_data->payment_type =="Paypal"){{route('paypal.cancel_subscription')}}@else{{route('subscription.cancel.auth')}}@endif" data-subid="{{$User_data->paypal_subscriptionID}}" class="btn cancel-button cancelBtn  cancelSubscription">@if($User_data->subscribedPlan =='weekly' && $User_data->cancel_at == 1) Canceled @else Cancel @endif</a>
            
            <a  href="{{route('updateSubscription_form',[
                  'id' => General::encrypt($User_data->paypal_subscriptionID),
                  'planname' => 'month',
              ] )}}" class="btn current-btn">Upgrade</a> 
          </div>
          @elseif($User_data->subscribedPlan == "year" ||$User_data->subscribedPlan == "six-month" || $User_data->subscribedPlan == "three-month" || $User_data->subscribedPlan == "month")
          <div class='compare-item-row d-flex justify-content-center align-items-center'>
            <a class='btn btn-teal' data-toggle="tooltip" data-placement="top" title="You have an active plan and can't change it. You can change it after your current plan ends." href="javascript:void();">Order Now</a>

            
          </div>
          @else
          <div class='compare-item-row d-flex justify-content-center align-items-center'>
            <a class='btn btn-teal' href="{{route('pay.auth.reccuring_billing',[
                  'id' => General::encrypt(UserAuth::getLoginId()),
                  'planname' => 'weekly',
              ] )}}">Order Now</a>
          </div>
          @endif
          
        </div>
      </div>

      <div class='d-none d-md-block col  px-0 col-pricing col-pro col-popular @if($User_data->subscribedPlan =="month")active-plan @elseif($User_data->subscribedPlan =="") active-plan @endif' id='monthly-plan'>
        <div class='pricing-popular active w-100 d-flex justify-content-center align-items-center'>
          <h4 class='mb-0 text-center'>Most Popular</h4>
        </div>
        <div class='pricing-single pricing-pro'>
          <div class='title-row d-flex justify-content-center align-items-center'>
            <div class='title-wrap text-center'>
              <h2>One Month</h2>
            </div>
          </div>
          <div class='cost-row d-flex justify-content-center align-items-center'>
            <div class='cost-wrap text-center'>
              <h3 class='cost mb-0'>${{$plan_month->price}}</h3>
              @if($User_data->subscribedPlan =='month') 
                <span class="pt-4">Current active plan</span>
               @endif
            </div>
          </div>
          <div class='compare-item-row d-flex justify-content-center align-items-center'>
            <div class='circle bg-teal'>{{$plan_month->feature_listing}}</div>
          </div>
          <div class='compare-item-row d-flex justify-content-center align-items-center'>
            <div class='circle bg-teal'>4</div>
          </div>
          <div class='compare-item-row d-flex justify-content-center align-items-center'>
            <div class='circle bg-teal'>2</div>
          </div>
          <div class='compare-item-row d-flex justify-content-center align-items-center'>
            <div class='circle bg-teal'>✓</div>
          </div>
          <div class='compare-item-row d-flex justify-content-center align-items-center'>
            <!-- <div class='circle bg-teal'>Upto {{$plan_month->slideshow}}</div> -->
            <div class='circle bg-teal'>✓</div>
          </div>
          <div class='compare-item-row d-flex justify-content-center align-items-center'>
            <div class='circle bg-teal'>✓</div>
          </div>
         
          <div class='compare-item-row d-flex justify-content-center align-items-center'>
            <div class='circle bg-teal'>✓</div>
          </div>
          <div class='compare-item-row d-flex justify-content-center align-items-center'>
            <div class='circle bg-teal'>✓</div>
          </div>
          <div class='compare-item-row d-flex justify-content-center align-items-center'>
            <div class='circle bg-teal'>✓</div>
          </div>
          <!-- <div class='compare-item-row d-flex justify-content-center align-items-center'>
            <div class='circle bg-teal'>✗</div>
          </div> -->
          <!-- <div class='compare-item-row d-flex justify-content-center align-items-center'>
            <div class='circle bg-teal'>✗</div>
          </div> -->

          @if($User_data->subscribedPlan =='month') 
          {{-- <div class="compare-item-row d-flex justify-content-center align-items-center">
            <div class="selection-frame py-2">
              <label class="custom-toggle">
                
                <input type="checkbox"  checked name="paymentType" value="true" {{ $User_data->payment_type == 'Automatic'? 'checked' : '' }}> &nbsp;&nbsp;<span>Auto repost</span>
              </label>
            </div> 
          </div> --}}
          <div class='compare-item-row d-flex justify-content-between align-items-center px-2'>
            <a href="#" data-link="@if($User_data->payment_type =="Paypal"){{route('paypal.cancel_subscription')}}@else{{route('subscription.cancel.auth')}}@endif" data-subid="{{$User_data->paypal_subscriptionID}}" class="btn cancel-button cancelBtn cancelSubscription">@if($User_data->subscribedPlan =='month' && $User_data->cancel_at == 1) Canceled @else Cancel @endif</a>
            <a href="{{route('updateSubscription_form',[
                                            'id' => General::encrypt($User_data->paypal_subscriptionID),
                                            'planname' => 'three-month',
                                        ] )}}" class="btn current-btn">Upgrade</a>
            </div>
            @elseif($User_data->subscribedPlan == "year" ||$User_data->subscribedPlan == "six-month" || $User_data->subscribedPlan == "three-month" || $User_data->subscribedPlan == "weekly")
            <div class='compare-item-row d-flex justify-content-center align-items-center'>
              <a class='btn btn-teal' data-toggle="tooltip" data-placement="top" title="You have an active plan and can't change it. You can change it after your current plan ends." href="javascript:void();">Order Now</a>
            </div>
            @else
            <div class='compare-item-row d-flex justify-content-center align-items-center'>
              <a class='btn btn-teal' href="{{route('pay.auth.reccuring_billing',[
                  'id' => General::encrypt(UserAuth::getLoginId()),
                  'planname' => 'month',
              ] )}}">Order Now</a>
            </div>
            @endif
          </div>
            <!-- <div class='compare-item-row d-flex justify-content-center align-items-center'>
              <a class='btn btn-teal' href="#">Order Now</a>
            </div> -->
      </div>


      <div class='d-none d-md-block col  px-0 col-pricing col-enterprise  @if($User_data->subscribedPlan =="three-month")active-plan @endif' id='three-month-plan'>
        <div class='pricing-popular mb-2'></div>
        <div class='pricing-single pricing-enterprise'>
          <div class='title-row d-flex justify-content-center align-items-center'>
            <div class='title-wrap text-center'>
              <h2> Three Months</h2>
            </div>
          </div>
          <div class='cost-row d-flex justify-content-center align-items-center'>
            <div class='cost-wrap text-center'>
              <h3 class='cost mb-0'>${{$plan_3month->price}}</h3>
              @if($User_data->subscribedPlan =='three-month') 
                <span class="pt-4">Current active plan</span>
               @endif
            </div>
          </div>
          <div class='compare-item-row d-flex justify-content-center align-items-center'>
            <div class='circle bg-teal'>{{$plan_3month->feature_listing}}</div>
          </div>
          <div class='compare-item-row d-flex justify-content-center align-items-center'>
            <div class='circle bg-teal'>6</div>
          </div>
          <div class='compare-item-row d-flex justify-content-center align-items-center'>
            <div class='circle bg-teal'>3</div>
          </div>
          <div class='compare-item-row d-flex justify-content-center align-items-center'>
            <div class='circle bg-teal'>✓</div>
          </div>
          <div class='compare-item-row d-flex justify-content-center align-items-center'>
            <!-- <div class='circle bg-teal'>Upto {{$plan_3month->slideshow}}</div> -->
            <div class='circle bg-teal'>✓</div>
          </div>
        
          <!-- <div class='compare-item-row d-flex justify-content-center align-items-center'>
            <div class='circle bg-teal'>✓</div>
          </div> -->

          <div class='compare-item-row d-flex justify-content-center align-items-center'>
            <div class='circle bg-teal'>✓</div>
          </div>
          <div class='compare-item-row d-flex justify-content-center align-items-center'>
            <div class='circle bg-teal'>✓</div>
          </div>
          <div class='compare-item-row d-flex justify-content-center align-items-center'>
            <div class='circle bg-teal'>✓</div>
          </div>
          <div class='compare-item-row d-flex justify-content-center align-items-center'>
            <div class='circle bg-teal'>✓</div>
          </div>
          <!-- <div class='compare-item-row d-flex justify-content-center align-items-center'>
            <div class='circle bg-teal'>✗</div>
          </div> -->
          
          @if($User_data->subscribedPlan =='three-month') 
          {{-- <div class="compare-item-row d-flex justify-content-center align-items-center">
            <div class="selection-frame py-2">
              <label class="custom-toggle">
                
                 <input type="checkbox"  checked name="paymentType" value="true" {{ $User_data->payment_type == 'Automatic'? 'checked' : '' }}> &nbsp;&nbsp;<span>Auto repost</span>
              </label>
            </div>
          </div> --}}
          <div class='compare-item-row d-flex justify-content-between align-items-center px-2 '>
            <a href="#" data-link="@if($User_data->payment_type =="Paypal"){{route('paypal.cancel_subscription')}}@else{{route('subscription.cancel.auth')}}@endif" data-subid="{{$User_data->paypal_subscriptionID}}" class="btn cancel-button cancelBtn cancelSubscription mx-1">@if($User_data->subscribedPlan =='three-month' && $User_data->cancel_at == 1) Canceled @else Cancel @endif</a>

            {{-- <a class='btn btn-teal' href="{{route('pay.auth.reccuring_billing',[
                                            'id' => General::encrypt(UserAuth::getLoginId()),
                                            'planname' => 'three-month',
                                        ] )}}">Order Now</a> --}}
            <a href="{{route('updateSubscription_form',[
                                            'id' => General::encrypt($User_data->paypal_subscriptionID),
                                            'planname' => 'six-month',
                                        ] )}}" class="btn current-btn mx-1">Upgrade</a> 
          </div>
          
          @elseif($User_data->subscribedPlan == "year" ||$User_data->subscribedPlan == "six-month" || $User_data->subscribedPlan == "month" || $User_data->subscribedPlan == "weekly")
          <div class='compare-item-row d-flex justify-content-center align-items-center'>
            <a class='btn btn-teal' data-toggle="tooltip" data-placement="top" title="You have an active plan and can't change it. You can change it after your current plan ends." href="javascript:void();">Order Now</a>

            
          </div>

          
          @else
          <div class='compare-item-row d-flex justify-content-center align-items-center'>
            <a class='btn btn-teal' href="{{route('pay.auth.reccuring_billing',[
                                            'id' => General::encrypt(UserAuth::getLoginId()),
                                            'planname' => 'three-month',
                                        ] )}}">Order Now</a>
          </div>
          @endif
        </div>
      </div>


      <div class='d-none d-md-block col  px-0 col-pricing col-enterprise @if($User_data->subscribedPlan =="six-month")active-plan @endif' id='six-month-plan'>
        <div class='pricing-popular mb-2'></div>
        <div class='pricing-single pricing-enterprise'>
          <div class='title-row d-flex justify-content-center align-items-center'>
            <div class='title-wrap text-center'>
              <h2>Six Months</h2>
            </div>
          </div>
          <div class='cost-row d-flex justify-content-center align-items-center'>
            <div class='cost-wrap text-center'>
              <h3 class='cost mb-0'>${{$plan_6month->price}}</h3>
               @if($User_data->subscribedPlan =='six-month') 
                <span class="pt-4">Current active plan</span>
               @endif
            </div>
          </div>
          <div class='compare-item-row d-flex justify-content-center align-items-center'>
            <div class='circle bg-teal'>{{$plan_6month->feature_listing}}</div>
          </div>
          <div class='compare-item-row d-flex justify-content-center align-items-center'>
            <div class='circle bg-teal'>8</div>
          </div>
          <div class='compare-item-row d-flex justify-content-center align-items-center'>
            <div class='circle bg-teal'>4</div>
          </div>
          <div class='compare-item-row d-flex justify-content-center align-items-center'>
            <div class='circle bg-teal'>✓</div>
          </div>
          <div class='compare-item-row d-flex justify-content-center align-items-center'>
            <!-- <div class='circle bg-teal'>Upto {{$plan_6month->slideshow}}</div> -->
            <div class='circle bg-teal'>✓</div>
          </div>
         
          <div class='compare-item-row d-flex justify-content-center align-items-center'>
            <div class='circle bg-teal'>✓</div>
          </div>
         
          <div class='compare-item-row d-flex justify-content-center align-items-center'>
            <div class='circle bg-teal'>✓</div>
          </div>
          <!-- <div class='compare-item-row d-flex justify-content-center align-items-center'>
            <div class='circle bg-teal'>✓</div>
          </div> -->
          <div class='compare-item-row d-flex justify-content-center align-items-center'>
            <div class='circle bg-teal'>✓</div>
          </div>
          <div class='compare-item-row d-flex justify-content-center align-items-center'>
            <div class='circle bg-teal'>✓</div>
          </div>
          <!-- <div class='compare-item-row d-flex justify-content-center align-items-center'>
            <div class='circle bg-teal'>✓</div>
          </div> -->
          @if($User_data->subscribedPlan =='six-month') 
          {{-- <div class="compare-item-row d-flex justify-content-center align-items-center">
            <div class="selection-frame py-2">
              <label class="custom-toggle">
                
                <input type="checkbox"  checked name="paymentType" value="true" {{ $User_data->payment_type == 'Automatic'? 'checked' : '' }}> &nbsp;&nbsp;<span>Auto repost</span>
              </label>
            </div>
          </div> --}}
          <div class='compare-item-row d-flex justify-content-between align-items-center px-2'>
            <a href="#" data-link="@if($User_data->payment_type =="Paypal"){{route('paypal.cancel_subscription')}}@else{{route('subscription.cancel.auth')}}@endif" data-subid="{{$User_data->paypal_subscriptionID}}"class="btn cancel-button cancelBtn cancelSubscription">@if($User_data->subscribedPlan =='six-month' && $User_data->cancel_at == 1) Canceled @else Cancel @endif</a>
            <a href="{{route('pay.auth.reccuring_billing',[
                        'id' => General::encrypt($User_data->paypal_subscriptionID),
                        'planname' => 'year',
                    ] )}}" class="btn current-btn">Upgrade</a> 
          </div>
         
          @elseif($User_data->subscribedPlan == "year" ||$User_data->subscribedPlan == "three-month" || $User_data->subscribedPlan == "month" || $User_data->subscribedPlan == "weekly")
          <div class='compare-item-row d-flex justify-content-center align-items-center'>
            <a class='btn btn-teal' data-toggle="tooltip" data-placement="top" title="You have an active plan and can't change it. You can change it after your current plan ends." href="javascript:void();">Order Now</a>
          </div>
          @else
          <div class='compare-item-row d-flex justify-content-center align-items-center'>
            <a class='btn btn-teal' href="{{route('pay.auth.reccuring_billing',[
                                            'id' => General::encrypt(UserAuth::getLoginId()),
                                            'planname' => 'six-month',
                                        ] )}}">Order Now</a>
          </div>
          @endif
        </div>
      </div>


      <div class='d-none d-md-block col  px-0 col-pricing col-enterprise @if($User_data->subscribedPlan =="year")active-plan @endif' id='yearly-plan'>
        <div class='pricing-popular mb-2'></div>
        <div class='pricing-single pricing-enterprise'>
          <div class='title-row d-flex justify-content-center align-items-center'>
            <div class='title-wrap text-center'>
              <h2> One Year </h2>
            </div>
          </div>
          <div class='cost-row d-flex justify-content-center align-items-center'>
            <div class='cost-wrap text-center'>
              <h3 class='cost mb-0'>${{$plan_year->price}}</h3>
               @if($User_data->subscribedPlan =='year') 
                <span class="pt-4">Current active plan</span>
               @endif
            </div>
          </div>
          <div class='compare-item-row d-flex justify-content-center align-items-center'>
            <div class='circle bg-teal'>{{$plan_year->feature_listing}}</div>
          </div>
          <div class='compare-item-row d-flex justify-content-center align-items-center'>
            <div class='circle bg-teal'>Unlimited</div>
          </div>
          <div class='compare-item-row d-flex justify-content-center align-items-center'>
            <div class='circle bg-teal'>Unlimited</div>
          </div>
          <div class='compare-item-row d-flex justify-content-center align-items-center'>
            <div class='circle bg-teal'>✓</div>
          </div>
          <div class='compare-item-row d-flex justify-content-center align-items-center'>
            <!-- <div class='circle bg-teal'>Upto {{$plan_year->slideshow}}</div> -->
            <div class='circle bg-teal'>✓</div>
          </div>
          
          <div class='compare-item-row d-flex justify-content-center align-items-center'>
            <div class='circle bg-teal'>✓</div>
          </div>
          
          <div class='compare-item-row d-flex justify-content-center align-items-center'>
            <div class='circle bg-teal'>✓</div>
          </div>
          <div class='compare-item-row d-flex justify-content-center align-items-center'>
            <div class='circle bg-teal'>✓</div>
          </div>
          <!-- <div class='compare-item-row d-flex justify-content-center align-items-center'>
            <div class='circle bg-teal'>✓</div>
          </div> -->
          <div class='compare-item-row d-flex justify-content-center align-items-center'>
            <div class='circle bg-teal'>✓</div>
          </div>
          <!-- <div class='compare-item-row d-flex justify-content-center align-items-center'>
            <div class='circle bg-teal'>✓</div>
          </div> -->

          @if($User_data->subscribedPlan =='year') 
          {{-- <div class="compare-item-row d-flex justify-content-center align-items-center">
            <div class="selection-frame py-2">
              <label class="custom-toggle">
                <input type="checkbox" name="paymentType" value="true" {{ $User_data->payment_type == 'Automatic'? 'checked' : '' }} data-toggle="tooltip" data-placement="top" 
                title=" Set your subscription to Auto-repost to avoid expiration on your content . It will automatically be billed and keep your place at the top of the list."> 
                &nbsp;&nbsp;<span>Auto repost</span>
              </label>
            </div>
          </div> --}}
          <div class='compare-item-row d-flex justify-content-between align-items-center px-2'>
            <a href="#" data-link="@if($User_data->payment_type =="Paypal"){{route('paypal.cancel_subscription')}}@else{{route('subscription.cancel.auth')}}@endif" data-subid="{{$User_data->paypal_subscriptionID}}" class="btn cancel-button cancelBtn cancelSubscription">@if($User_data->subscribedPlan =='year' && $User_data->cancel_at == 1) Canceled @else Cancel @endif</a>
            <!-- <a href="#" class="btn current-btn">Current Plan</a> -->
          </div>
          @elseif($User_data->subscribedPlan == "six-month" ||$User_data->subscribedPlan == "three-month" || $User_data->subscribedPlan == "month" || $User_data->subscribedPlan == "weekly")
          <div class='compare-item-row d-flex justify-content-center align-items-center'>
            <a class='btn btn-teal'data-toggle="tooltip" data-placement="top" title="You have an active plan and can't change it. You can change it after your current plan ends." href="javascript:void();">Order Now</a>
          </div>
          @else
          <div class='compare-item-row d-flex justify-content-center align-items-center'>
            <a class='btn btn-teal' href="{{route('pay.auth.reccuring_billing',[
                                            'id' => General::encrypt(UserAuth::getLoginId()),
                                            'planname' => 'year',
                                        ] )}}">Order Now</a>
          </div>
          @endif
        </div>
      </div>


      <!-- <div class='d-none d-md-block col  px-0 col-pricing col-free @if($User_data->subscribedPlan =="")active-plan @endif' id='free-plan'>
        <div class='pricing-popular mb-2'></div>
        <div class='pricing-single pricing-enterprise'>
          <div class='title-row d-flex justify-content-center align-items-center'>
            <div class='title-wrap text-center'>
              <h2>Free</h2>
            </div>
          </div>
          <div class='cost-row d-flex justify-content-center align-items-center'>
            <div class='cost-wrap text-center'>
              <h3 class='cost mb-0'>$0</h3>
            </div>
          </div>
          <div class='compare-item-row d-flex justify-content-center align-items-center'>
            <div class='circle bg-teal'>3</div>
          </div>
          <div class='compare-item-row d-flex justify-content-center align-items-center'>
            <div class='circle bg-teal'>✓</div>
          </div>
          <div class='compare-item-row d-flex justify-content-center align-items-center'>
            <div class='circle bg-teal'>1</div>
          </div>
          <div class='compare-item-row d-flex justify-content-center align-items-center'>
            <div class='circle bg-teal'>✗</div>
          </div>
          <div class='compare-item-row d-flex justify-content-center align-items-center'>
            <div class='circle bg-teal'>✓</div>
          </div>
          <div class='compare-item-row d-flex justify-content-center align-items-center'>
            <div class='circle bg-teal'>✗</div>
          </div>
          <div class='compare-item-row d-flex justify-content-center align-items-center'>
            <div class='circle bg-teal'>✗</div>
          </div>
          <div class='compare-item-row d-flex justify-content-center align-items-center'>
            <a class='btn btn-teal' href="#">@if($User_data->subscribedPlan =="")Current plan @endif Free</a>
          </div>
        </div>
      </div> -->
    </div>
  </div>



  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.1/js/bootstrap.min.js"></script> -->

  <script>
    var planBtn = $('.pricing-plan');
    var pricingCol = $('.col-pricing');

    planBtn.click(function () {
      var planId = $(this).data('plan');
      var activePlan = $('#' + planId);

      planBtn.removeClass('active-btn');
      $(this).addClass('active-btn');
      pricingCol.removeClass('active-plan');
      activePlan.addClass('active-plan');
    });

//     $(document).ready(function() {
//     var planBtn = $('.pricing-plan');
//     var pricingCol = $('.col-pricing');

//     // Function to handle click event on pricing plan buttons
//     planBtn.click(function () {
//         var planId = $(this).data('plan');
//         var activePlan = $('#' + planId);

//         // Remove active class from all pricing plan buttons
//         planBtn.removeClass('active-btn');
//         // Add active class to the clicked pricing plan button
//         $(this).addClass('active-btn');
//         // Remove active class from all pricing columns
//         pricingCol.removeClass('active-plan');
//         // Add active class to the corresponding pricing column
//         activePlan.addClass('active-plan');
//     });

//     // Trigger click event on the default active button
//     // You can specify the default active button here
//     // For example, if the user's subscribed plan is '7-day-14':
//     $('.pricing-plan[data-plan="three-month-plan"]').trigger('click');
// });
  </script>


  <script type="text/javascript">
    $(document).ready(function() {
        // var isChecked1 = $('input[name="paymentType"]').is(':checked');
        // console.log(isChecked1);
        // if (isChecked1 === true) {
        //     $('.hidesection').removeClass('d-none');
        // } else {
        //     $('.hidesection').addClass('d-none');
        // }
        $('input[name="paymentType"]').on('click', function() {
            var isChecked = $(this).is(':checked');
            console.log(isChecked);
            if (isChecked === true) {
                var paymentType ='Automatic';
            } else {
                var paymentType ='Repost';
            }
            var id = {{$User_data->id}};
             var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            $.ajax({
                url: baseurl + '/payment-update',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    paymentType: paymentType,
                    id:id,
                },
                success: function(response) {
                    console.log(response);
                    toastr.success(response.success);
                },
                error: function(xhr, status, error) {
                    toastr.error(response.error);
                }
            });

        });
    });

    $(document).on("click", ".cancelBtn", function(e) {
        e.preventDefault();
        var link = $(this).attr("data-link");
         Swal.fire({
            title: 'Cancel',
            text: 'Are you sure you want to cancel? Your information will still be up for the remainder of the time you paid on the homepage , unless you decide to delete it before then. Once the subscription ends , your content will be displayed on the popular post page and the star badge is removed off your profile. There will be no refunds for feature subscriptions as stated in the email you received when you first purchased. Thank you for understanding.',
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'No',
            confirmButtonColor: '#fcd152',
            cancelButtonColor: '#1a202e',
            confirmButtonText: 'Yes, Cancel!',
        }).then((result) => {
              if (result.isConfirmed) {
                  var URL = $(this).attr('data-link');
                  var subid = $(this).attr('data-subid');
                  var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                  // alert(URL);
                  $.ajax({
                  url: URL,
                  type: 'POST',
                  headers: {
                      'X-CSRF-TOKEN': csrfToken
                  },
                  data: {
                      subid:subid
                  },
                  success: function(response) {
                      console.log(response);
                      toastr.success(response.message);
                      window.location.reload();
                  },
                  error: function(xhr, status, error) {
                      toastr.error(response.error);
                  }
              });
            }
        });


    });

    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>

</body>

@endsection