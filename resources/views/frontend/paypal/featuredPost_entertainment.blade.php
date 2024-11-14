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
    #headingOne button:hover{
        text-decoration:none !important;
    }
    #headingOne button{
          align-items: center;
         font-size: 16px;
        display: flex;
        justify-content: center;
        text-decoration: none;
    }
    

    #collapseOne .contact-from-button {
        background: linear-gradient(90deg, rgba(220, 114, 40, 1) 70%, #a54db7 100%) !important;
        border: 1px solid #dc7228 !important;
        border-radius: 50px;
        color: #fff !important;
        padding: 5px 30px;
        font-size: 16px;
    }
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

  .strip-section .card-header{padding: 0.25rem 1.25rem;}
 .strip-section .card-body{padding: 15px;}
 .strip-section .form-group{text-align: left;}
  #new_css .strip-section .form-group label{margin-left: 0!important;}
  #headingOne button span{padding-left: 3px;}

 @media only screen and (max-width:991px){
    #headingOne button{font-size:13px; line-height: 18px;padding: 0.375rem 0.15rem;}
    .strip-section .card-header {padding: 1px 1rem;}
    .strip-section .form-group {margin-bottom: 10px;}
    .strip-section input.form-control {height: 35px;}
    .strip-section label.control-label{font-size: 14px;}

 }

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
                     <form role="form" action="{{route('auth.featured_save.entertainment',$post_id)}}" method="post" class="require-validation strip-form" data-cc-on-file="false" data-stripe-publishable-key="" id="payment-form">
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
                           <div class="accordion" id="accordionExample" style="margin: 0 12px;">
                              <div class="card">
                                 <div class="card-header" id="headingOne" style="background-color:#2C2E2F !important">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-center text-white" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjRweCIgaGVpZ2h0PSIxOHB4IiB2aWV3Qm94PSIwIDAgMjQgMTgiIHhtbG5zPSJodHRwOiYjeDJGOyYjeDJGO3d3dy53My5vcmcmI3gyRjsyMDAwJiN4MkY7c3ZnIj48ZyBzdHJva2U9Im5vbmUiIHN0cm9rZS13aWR0aD0iMSIgZmlsbD0ibm9uZSIgZmlsbC1ydWxlPSJldmVub2RkIj48ZyB0cmFuc2Zvcm09InRyYW5zbGF0ZSgtMy4wMDAwMDAsIC02LjAwMDAwMCkiIGZpbGw9IiNmZmZmZmYiIGZpbGwtcnVsZT0ibm9uemVybyI+PHBhdGggZD0iTTguMjc1MjEzMzgsMTIuNTEyMjY1MyBDNy45MzAwMzU0MiwxMi41MTIyNjUzIDcuNjUwMjEzMzgsMTIuMjMyNDQzMiA3LjY1MDIxMzM4LDExLjg4NzI2NTMgQzcuNjUwMjEzMzgsMTEuNTQyMDg3MyA3LjkzMDAzNTQyLDExLjI2MjI2NTMgOC4yNzUyMTMzOCwxMS4yNjIyNjUzIEwyNC43ODc5MDQyLDExLjI2MjI2NTMgQzI1LjU5NTU5MzksMTEuMjYyMjY1MyAyNi4yNSwxMS45MTc1OTA1IDI2LjI1LDEyLjcyNTUzNjggTDI2LjI1LDIyLjI4NjcyODQgQzI2LjI1LDIzLjA5NDY3NDggMjUuNTk1NTkzOSwyMy43NSAyNC43ODc5MDQyLDIzLjc1IEw1LjIxMjMxMzAyLDIzLjc1IEM0LjQwNDYyMzI1LDIzLjc1IDMuNzUsMjMuMDk0Njc0OCAzLjc1LDIyLjI4NjczOTcgTDMuNzUsNy43MTMyNzE1MiBDMy43NSw2LjkwNTMyNTE4IDQuNDA0NDA2MDgsNi4yNSA1LjIxMjI3MjEyLDYuMjUgTDI0Ljc4ODA2NjQsNi4yNTU1MjE2MyBDMjUuNTk1NjA3OSw2LjI1NTczMTQ3IDI2LjI1LDYuOTEwOTk1MDcgMjYuMjUsNy43MTg3MDM2MiBMMjYuMjUsOS4yMzU3NzE2MSBDMjYuMjUsOS41ODA5NDk1OCAyNS45NzAyNjc1LDkuODYwODExNjggMjUuNjI1MDg5NSw5Ljg2MDg2MTEyIEMyNS4yNzk5MTE1LDkuODYwOTEwNTUgMjUuMDAwMDQ5NCw5LjU4MTEyODYgMjUsOS4yMzU5NTA2MyBMMjQuOTk5NzgyNyw3LjcxODc5MzEzIEMyNC45OTk3ODI3LDcuNjAwODMxODkgMjQuOTA0NjYxMSw3LjUwNTU1MTk3IDI0Ljc4NzcyNzgsNy41MDU1MjE1OCBMNS4yMTIwOTU4Myw3LjQ5OTk5OTk4IEM1LjA5NTE1NTA2LDcuNDk5OTk5OTggNSw3LjU5NTI4ODY4IDUsNy43MTMyNjAyOCBMNS4wMDAyMTcxOCwyMi4yODY3Mjg0IEM1LjAwMDIxNzE4LDIyLjQwNDcxMTMgNS4wOTUzNzIyMywyMi41IDUuMjEyMzEzMDIsMjIuNSBMMjQuNzg3OTA0MiwyMi41IEMyNC45MDQ4NDUsMjIuNSAyNSwyMi40MDQ3MTEzIDI1LDIyLjI4NjcyODQgTDI1LDEyLjcyNTUzNjggQzI1LDEyLjYwNzU1NCAyNC45MDQ4NDQ5LDEyLjUxMjI2NTMgMjQuNzg3OTA0MiwxMi41MTIyNjUzIEw4LjI3NTIxMzM4LDEyLjUxMjI2NTMgWiIgaWQ9IlN0cm9rZS0xIj48L3BhdGg+PC9nPjwvZz48L3N2Zz4" alt="" class="paypal-logo-card paypal-logo-card-"> 
                                        <span>Debit and Credit Card</span>
                                        </button>
                                    </h2>
                                 </div>

                                 <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                    <div class="card-body">
                                       <div class="my_form">
                                          <div class='form-row row'>
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
                                          </div> 
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>

                        <div class="col-lg-12 text-center mt-3">

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
                  url: baseurl + '/paypal/featured_save/entertainment',
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