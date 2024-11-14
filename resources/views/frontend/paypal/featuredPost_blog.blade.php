@extends('layouts.user_dashboard.userdashboardlayout')
@section('content')
<?php 
         use App\Models\Admin\SubPlan;
        $plan_week = SubPlan::where('plan', 'Weekly')->first();
        $plan_month = SubPlan::where('plan', 'Monthly')->first();
        $plan_3month = SubPlan::where('plan', "Three Month's")->first();
        $plan_6month = SubPlan::where('plan', "Six Month's")->first();
        $plan_year = SubPlan::where('plan', "Yearly")->first();

     $planname ='weekly';
       
?> 
<style>
   
   .hide{
      display:none;
   }
   .card{cursor: default;}
   #sec_new{
     align-items: center;
     justify-content: center;
     display: flex;
     flex-direction: column;
   }
   .responsivePayPalWhite {
  height: 36px;
  width: 100px;
  overflow: hidden;
  margin: auto;
  padding-top: 2px;
}

.responsivePayPalWhite img {
  position: relative;
  top: 5px;
}
.payPalWhite {
  /*width:30%;
  height:42px;*/
  -webkit-border-radius: 5px;
  -moz-border-radius: 5px;
  border-radius: 5px;
  background-color:#f6c23e;
  margin: 10px auto; 
  display: inline-block;
  padding: 5px 32px;
  width: 100%;
}
.button-area{display: inline-block;
  background-color: #f6c23e;
  color: #000!important;
  font-size: 16px;
  font-weight: 600;padding: 10px; margin-top: 10px;}

</style>
  <section id="payment-section">
   <div class="container mt-5 mb-5">
      <div class="card p-3">
         <div class="row">
            <!-- Grid column for the image -->
            <div class="col-md-6 img-frame">
               <img src="{{asset('user_dashboard/img/feature-banner.png')}}" alt="Banner Image" class="img-fluid payment-img">
            </div>

            <!-- Grid column for the form -->
            <div class="col-md-6 mt-4 mt-md-0" id="sec_new">
               <h1 class="strip-heading">Subscription Plans</h1>
               <div class="panel panel-default credit-card-box">
                  <div class="col-md-12">
                     <!-- Image here, but it will be hidden because it's empty -->
                  </div>
                  <div class="panel-heading display-table">
                     <h3 class="panel-title m-title" id="pay_new">Payment Details</h3>
                  </div>
                  <div class="panel-body">
                     <!-- Form content here -->
                     @if (Session::has('success'))
                     <div class="alert alert-success text-center">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                        <p>{{ Session::get('success') }}</p>
                     </div>
                     @endif
                      <!-- Form content here -->
                     @if (Session::has('error'))
                     <div class="alert alert-danger text-center">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                        <p>{{ Session::get('error') }}</p>
                     </div>
                     @endif
                     <form role="form" action="" method="post" class="require-validation strip-form" data-cc-on-file="false" data-stripe-publishable-key="" id="payment-form">
                        @csrf
                        <div class="row" id="new_css">
                           <div class="col-lg-6">
                              <div class='form-row align-start' title="3 posts feature on the homepage" data-toggle="tooltip" data-placement="top">
                                 <input type="radio" name="planname"  value="{{$plan_week->plan}}" class="radioBtnClass " >
                                 <label for="7-day-14">Weekly &nbsp; <span class="showprice">${{$plan_week->price}}/week</span></label>
                              </div>
                           </div>
                           <div class="col-lg-6">
                              <div class='form-row align-start' title="10 posts feature on the homepage" data-toggle="tooltip" data-placement="top">
                                 <input type="radio" name="planname"  value="{{$plan_month->plan}}" class="radioBtnClass " >
                                 <label for="1-month-55">Every Month &nbsp;<span class="showprice"> ${{$plan_month->price}}/mo</span></label>
                              </div>
                           </div>
                           <div class="col-lg-6">
                              <div class='form-row align-start' title="20 posts feature on the homepage" data-toggle="tooltip" data-placement="top">
                                 <input type="radio" name="planname"  value="{{$plan_3month->plan}}" class="radioBtnClass">
                                 <label for="3-month-166">Every Three Months &nbsp;<span class="showprice">${{$plan_3month->price}}/mo</span></label>
                              </div>
                           </div>
                           <div class="col-lg-6">
                              <div class='form-row align-start' title="40 posts feature on the homepage" data-toggle="tooltip" data-placement="top">
                                 <input type="radio" name="planname" value="{{$plan_6month->plan}}" class="radioBtnClass">
                                 <label for="6-month-333">Every Six Months &nbsp;<span class="showprice">${{$plan_6month->price}}/mo</span></label>
                              </div>
                           </div>
                           <div class="col-lg-6">
                              <div class='form-row align-start' title="100 posts feature on the homepage" data-toggle="tooltip" data-placement="top">
                                 <input type="radio" name="planname" value="{{$plan_year->plan}}" class="radioBtnClass">
                                 <label for="1-year-777">Yearly &nbsp;<span class="showprice">${{$plan_year->price}}/year</span></label>
                                 
                              </div>
                           </div>
                        </div>
                        
                        <script>
                        jQuery(document).ready(function() {
                           $(".radioBtnClass").on("click", function() {
                                 var plan_value = $(this).val();
                                 if(plan_value == "Weekly"){
                                    <?php $planname ='weekly'; ?>  
                                 } 
                                 if(plan_value == "Monthly"){
                                    <?php $planname ='month'; ?>  
                                 } 
                                 if(plan_value == "Three Month's"){
                                    <?php $planname ='three-month'; ?>  
                                 } 
                                 if(plan_value == "Six Month's"){
                                    <?php $planname ='six-month'; ?>  
                                 }
                                 if(plan_value == "Yearly"){
                                    <?php $planname ='year'; ?>  
                                 } 
                                 // alert(plan_value);
                           });
                        });
                     </script>
                       
                        
                        <div class="strip-section">

                        
                        <!-- <div class='form-row row'>
                           <div class='col-xs-12 col-lg-6 form-group required'>
                              <label class='control-label'>Name on Card</label>
                              <input class='form-control' size='4' name="cardholdername" type='text'>
                           </div>
                           <div class='col-xs-12 col-lg-6 form-group required'>
                              <label class='control-label'>Card Number</label>
                              <input autocomplete='off' name="cardnumber" class='form-control card-number' size='20' type='text'>
                           </div>
                        </div>
                        <div class='form-row row'>
                           <div class='col-xs-12 col-lg-4 col-md-12 form-group cvc required'>
                              <label class='control-label'>CVC</label>
                              <input autocomplete='off' name="cardcvc" class='form-control card-cvc' placeholder='ex. 311' size='4' type='text'>
                           </div>
                           <div class='col-xs-12 col-lg-4 col-md-12 form-group expiration required'>
                              <label class='control-label'>Expiration Month</label>
                              <input class='form-control card-expiry-month' name="cardexpirymonth" placeholder='MM' size='2' type='text'>
                           </div>
                           <div class='col-xs-12 col-lg-4 col-md-12 form-group expiration required'>
                              <label class='control-label'>Expiration Year</label>
                              <input class='form-control card-expiry-year' name="cardexpiryyear" placeholder='YYYY' size='4' type='text'>
                           </div>
                        </div>
                      <div class='form-row'>
                           <div class='col-md-12 error  form-group hide'>
                              <div class='alert-danger alert'></div>
                           </div>
                        </div> 
          
                        <div class="row">
                           <div class="col-xs-12">
                              <button class="contact-from-button" type="submit">Pay Now</button>
                           </div>
                           </div> -->

                           <div class="col-lg-12 text-center mt-4">

                              <div id="paypal-button-container"></div>
                        <div class="payment-loader d-none">
                            <div class="pad">
                             <div class="chip"></div>
                            <div class="line line1"></div>
                            <div class="line line2"></div>
                          </div>
                          <div class="loader-text">
                            Please wait while payment is loading
                          </div>
                        </div>
                    </div>
                        </div>
                         <div class="row">
                              <div class="col-xs-12 mt-3 text-center stripe-frame">
                                 <i class="fab fa-apple-pay pay_icon"></i>
                                 <!-- <i class="fab fa-cc-paypal pay_icon_paypal"></i> -->
                                 <!-- 
                                    <i style="font-size: 30px" class="fas fa-credit-card"></i>
                                 <i style="font-size: 30px" class="fab fa-cc-visa"></i> -->
                                 <img class="pay_image" src="{{asset
            ('./images/image_2024_05_23T04_36_49_617Z.png')}}" alt="">
                              </div>
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<script src="https://www.paypal.com/sdk/js?client-id=AatTYfa6pUOo21YMpaFDAulZWxALxdgHMcgNUPLFAX38lSnfk8v2ChMmlGXV1BCoHrQ_szgl6pALqmfI&commit=true&vault=true&intent=subscription" data-sdk-integration-source="button-factory"></script>

<script>
   jQuery(document).ready(function() {
      let planname;
      $(".radioBtnClass").on("click", function() {
         var plan_value = $(this).val();
         if (plan_value == "Weekly") {
            planname = 'weekly';
         } else if (plan_value == "Monthly") {
            planname = 'month';
         } else if (plan_value == "Three Month's") {
            planname = 'three-month';
         } else if (plan_value == "Six Month's") {
            planname = 'six-month';
         } else if (plan_value == "Yearly") {
            planname = 'year';
         }

         // Clear the PayPal button container and render the appropriate PayPal button
         renderPaypalButton(planname);
      });
   });

   function renderPaypalButton(planname) {
      let plan_id;
      if (planname == 'weekly') {
         plan_id = 'P-9EH33887VE3692325MX5HFZA';
      } else if (planname == 'month') {
         plan_id = 'P-3G703430NE033940XMI5KT7Q';
      } else if (planname == 'three-month') {
         plan_id = 'P-91P94790G73401747MI5K7GI';
      } else if (planname == 'six-month') {
         plan_id = 'P-7YJ23123PK2101504MI5LAXI';
      } else if (planname == 'year') {
         plan_id = 'P-18C84490PX9158027MI5LBVY';
      }

      if (plan_id) {
         // Clear the PayPal button container
         $('#paypal-button-container').empty();

         paypal.Buttons({
            style: {
               shape: 'rect',
               color: 'gold',
               layout: 'vertical',
               label: 'subscribe'
            },
            createSubscription: function(data, actions) {
               return actions.subscription.create({
                  plan_id: plan_id
               });
            },
            onApprove: function(data, actions) {
               $('.payment-loader').removeClass('d-none');
               var subscriptionId = data.subscriptionID;
               var order_id = data.orderID;
               var postid = '<?php echo $post_id;?>';
               var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
               $.ajax({
                  url: baseurl + '/paypal/featured_save/blogs',
                  method: 'POST',
                  headers: {
                     'X-CSRF-TOKEN': csrfToken,
                  },
                  data: {
                     subscriptionId: subscriptionId,
                     order_id: order_id,
                     post_id:postid,
                     planname:planname,
                  },
                  success: function(response) {
                     console.log(response);
                     $('.payment-loader').addClass('d-none');
                     window.location.href = "https://finderspage.com/pricing";
                  },
                  error: function(xhr, status, error) {
                     console.error(xhr.responseText);
                  }
               });
            },
            enableFunding: 'credit, debit',
            allowGuest: true
         }).render('#paypal-button-container'); // Render the PayPal button
      }
   }
</script>

@endsection