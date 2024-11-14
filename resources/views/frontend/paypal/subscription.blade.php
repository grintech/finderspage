@extends('layouts.user_dashboard.userdashboardlayout')
@section('content')
<script type="text/javascript" src="https://applepay.cdn-apple.com/jsapi/v1/apple-pay-sdk.js"></script>
<?php 
        use App\Models\Admin\SubPlan;
        $plan_week = SubPlan::where('plan', 'Weekly')->first();
        $plan_month = SubPlan::where('plan', 'Monthly')->first();
        $plan_3month = SubPlan::where('plan', "Three Month's")->first();
        $plan_6month = SubPlan::where('plan', "Six Month's")->first();
        $plan_year = SubPlan::where('plan', "Yearly")->first();
?>

<style>
   .hide{
      display:none;
   }
   .card{cursor: default;}
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
  display: inline-block;
  padding: 5px 32px;
}


body {
  font-family : 'Roboto', sans-serif;
}

.payment-loader {
  width : 150px;
  position: absolute;
  top: 89%;
  left : 19%;
  -webkit-transform: translateY(-50%) translateX(-50%);
  -moz-transform: translateY(-50%) translateX(-50%);
  -o-transform: translateY(-50%) translateX(-50%);
  transform: translateY(-50%) translateX(-50%);
  z-index: 1;
}

.payment-loader .binding {
  content : '';
  width : 60px;
  height : 4px;
  border : 2px solid #00c4bd;
  margin : 0 auto;
}

.payment-loader .pad {
  width : 80px;
  height : 55px;
  border-radius : 8px;
  border : 2px solid #00c4bd;
  padding : 6px;
  margin : 0 auto;
}

.payment-loader .chip {
  width : 12px;
  height: 8px;
  background: #00c4bd;
  border-radius: 3px;
  margin-top: 4px;
  margin-left: 3px;
}

.payment-loader .line {
  width : 52px;
  margin-top : 6px;
  margin-left : 3px;
  height : 4px;
  background: #00c4bd;
  border-radius: 100px;
  opacity : 0;
  -webkit-animation : writeline 3s infinite ease-in;
  -moz-animation : writeline 3s infinite ease-in;
  -o-animation : writeline 3s infinite ease-in;
  animation : writeline 3s infinite ease-in;
}

.payment-loader .line2 {
  width : 32px;
  margin-top : 6px;
  margin-left : 3px;
  height : 4px;
  background: #00c4bd;
  border-radius: 100px;
  opacity : 0;
  -webkit-animation : writeline2 3s infinite ease-in;
  -moz-animation : writeline2 3s infinite ease-in;
  -o-animation : writeline2 3s infinite ease-in;
  animation : writeline2 3s infinite ease-in;
}

.payment-loader .line:first-child {
  margin-top : 0;
}

.payment-loader .line.line1 {
  -webkit-animation-delay: 0s;
  -moz-animation-delay: 0s;
  -o-animation-delay: 0s;
  animation-delay: 0s;
}

.payment-loader .line.line2 {
  -webkit-animation-delay: 0.5s;
  -moz-animation-delay: 0.5s;
  -o-animation-delay: 0.5s;
  animation-delay: 0.5s;
}

.payment-loader .loader-text {
  text-align : center;
  margin-top : 20px;
  font-size : 16px;
  line-height: 16px;
  color : #5f6571;
  font-weight: bold;
}


@keyframes writeline {
  0% { width : 0px; opacity: 0; }
  33% { width : 52px; opacity : 1; }
  70% { opacity : 1; }
  100% {opacity : 0; }
}

@keyframes writeline2 {
  0% { width : 0px; opacity: 0; }
  33% { width : 32px; opacity : 1; }
  70% { opacity : 1; }
  100% {opacity : 0; }
}
</style>

  <section id="payment-section">
   <div class="container mt-5 mb-5">
      <div class="card p-3">
         <div class="row">
            <!-- Grid column for the image -->

            <div class="col-md-6 img-frame"> <img src="{{asset
            ('user_dashboard/img/feature-banner.png')}}" alt="Banner Image"
            class="img-fluid payment-img"> </div>

            <!-- <div class="col-md-6 img-frame" id="plan-banner-image">
            <img src="{{asset
            ('user_dashboard/img/monthly-plan-img.jpg')}}" alt="Banner Image"
            class="img-fluid payment-img"> 
            <img src="{{asset
            ('user_dashboard/img/six-months-img.jpg')}}" alt="Banner Image"
            class="img-fluid payment-img"> 
            <img src="{{asset
            ('user_dashboard/img/three-months-img.jpg')}}" alt="Banner Image"
            class="img-fluid payment-img"> 
            <img src="{{asset
            ('user_dashboard/img/weekly-plan-img.jpg')}}" alt="Banner Image"
            class="img-fluid payment-img"> 

            </div> -->

            <!-- Grid column for the form -->
            <div class="col-md-6 mt-4 mt-md-0" id="sec_new">
               <h1 class="strip-heading">Select your Plan to Make a Featured Post</h1>
               <div class="panel panel-default credit-card-box">
                  <div class="col-md-12">
                     <!-- Image here, but it will be hidden because it's empty -->
                  </div>
                  <div class="panel-heading display-table py-2">
                     <h3 class="panel-title" id="pay_new">Payment Details</h3>
                  </div>
                  <div class="panel-body">
                     <!-- Form content here -->
                     @if (Session::has('success'))
                     <div class="alert alert-success text-center">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                        <p>{{ Session::get('success') }}</p>
                     </div>
                     @endif
                     
                       
                        <div class="row" id="new_css">
                           <div class="col-lg-6">
                              <div class='form-row align-start' title="3 posts feature on the homepage" data-toggle="tooltip" data-placement="top">
                                 <input type="radio" name="planprice" {{ $planname == 'weekly'? 'checked' : '' }}  value="7-day-14" class="radioBtnClass " checked="checked">
                                 <label for="7-day-14">Weekly &nbsp; <span class="showprice">${{$plan_week->price}}/week</span></label>
                              </div>
                           </div>
                           <div class="col-lg-6">
                              <div class='form-row align-start' title="10 posts feature on the homepage" data-toggle="tooltip" data-placement="top">
                                 <input type="radio" name="planprice" {{ $planname == 'month'? 'checked' : '' }} value="1-month-55" class="radioBtnClass " >
                                 <label for="1-month-55">Every Month &nbsp;<span class="showprice"> ${{$plan_month->price}}/mo</span></label>
                              </div>
                           </div>
                           <div class="col-lg-6">
                              <div class='form-row align-start' title="20 posts feature on the homepage" data-toggle="tooltip" data-placement="top">
                                 <input type="radio" name="planprice" {{ $planname == 'three-month'? 'checked' : '' }} value="3-month-166" class="radioBtnClass">
                                 <label for="3-month-166">Every Three Months &nbsp;<span class="showprice">${{$plan_3month->price}}/mo</span></label>
                              </div>
                           </div>
                           <div class="col-lg-6">
                              <div class='form-row align-start' title="40 posts feature on the homepage" data-toggle="tooltip" data-placement="top">
                                 <input type="radio" name="planprice" {{ $planname == 'six-month'? 'checked' : '' }} value="6-month-333" class="radioBtnClass">
                                 <label for="6-month-333">Every Six Months &nbsp;<span class="showprice">${{$plan_6month->price}}/mo</span></label>
                              </div>
                           </div>
                           <div class="col-lg-6">
                              <div class='form-row align-start' title="100 posts feature on the homepage" data-toggle="tooltip" data-placement="top">
                                 <input type="radio" name="planprice" {{ $planname == 'year'? 'checked' : '' }} value="1-year-777" class="radioBtnClass">
                                 <label for="1-year-777">Yearly &nbsp;<span class="showprice">${{$plan_year->price}}/year</span></label>
                                 
                              </div>
                           </div>
                        </div>
                        <div class="paypal_psyment_div" >
                         @if($planname == 'weekly')
                       <div id="paypal-button-container-P-0YX06832B9116540VMX6SLRA"></div>
                            <script src="https://www.paypal.com/sdk/js?client-id=AXCsp61Xi_n27Zd05WKr6JjvLp1SeDEZzL43f2zzjNNpjqdZNXIVGljO75dguLFMwBR6LS8ZGAm3wtvM&commit=true&vault=true&intent=subscription" data-sdk-integration-source="button-factory"></script>
                            <script>
                             paypal.Buttons({
                                        style: {
                                            shape: 'rect',
                                            color: 'gold',
                                            layout: 'vertical',
                                            label: 'subscribe'
                                        },
                                        createSubscription: function(data, actions) {
                                            return actions.subscription.create({
                                                /* Creates the subscription */
                                                plan_id: 'P-0YX06832B9116540VMX6SLRA'
                                            });
                                        },
                                        onApprove: function(data, actions) {
                                            $('.payment-loader').removeClass('d-none');
                                            console.log(data);
                                            var subscriptionId = data.subscriptionID;
                                            var order_id = data.orderID;
                                            
                                            // Send the subscription ID to your Laravel backend
                                            saveSubscriptionId(subscriptionId,order_id);
                                        },
                                        enableFunding: 'credit, debit', // Enable guest checkout with credit/debit card
                                        allowGuest: true // Allow guest checkout
                                    }).render('#paypal-button-container-P-0YX06832B9116540VMX6SLRA');

                                    function saveSubscriptionId(subscriptionId,order_id) {
                                        // Send an AJAX request to your Laravel backend
                                         var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                                        $.ajax({
                                            url: baseurl + '/paypal/subscription/payment/<?php echo $planname; ?>',
                                            method: 'POST',
                                            headers: {
                                            'X-CSRF-TOKEN': csrfToken,
                                            },
                                            data: {
                                                subscriptionId: subscriptionId,
                                                order_id:order_id
                                            },
                                            success: function(response) {
                                                console.log(response);
                                                 $('.payment-loader').addClass('d-none');
                                                window.location.href = "https://finderspage.com/pricing";
                                                // Handle success if needed
                                            },
                                            error: function(xhr, status, error) {
                                                console.error(xhr.responseText);
                                                // Handle error if needed
                                            }
                                        });
                                    }

                            </script>

                            
                        @elseif($planname == 'month')
                            <div id="paypal-button-container-P-7AH011683A097983LMX6SQKQ"></div>
                            <script src="https://www.paypal.com/sdk/js?client-id=AXCsp61Xi_n27Zd05WKr6JjvLp1SeDEZzL43f2zzjNNpjqdZNXIVGljO75dguLFMwBR6LS8ZGAm3wtvM&commit=true&vault=true&intent=subscription" data-sdk-integration-source="button-factory"></script>
                            <script>
                              paypal.Buttons({
                                  style: {
                                      shape: 'rect',
                                      color: 'gold',
                                      layout: 'vertical',
                                      label: 'subscribe'
                                  },
                                  createSubscription: function(data, actions) {
                                    return actions.subscription.create({
                                      /* Creates the subscription */
                                      plan_id: 'P-7AH011683A097983LMX6SQKQ'
                                    });
                                  },
                                  onApprove: function(data, actions) {
                                    console.log(data);
                                   var subscriptionId = data.subscriptionID;
                                   var order_id = data.orderID;
                                    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                                    $.ajax({
                                        url: baseurl + '/paypal/subscription/payment/<?php echo $planname; ?>',
                                        type: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': csrfToken,
                                        },
                                        data: {
                                            subscriptionId: subscriptionId,
                                            order_id:order_id
                                            
                                        },
                                        success: function(response) {
                                            console.log(response);
                                             $('.payment-loader').addClass('d-none');
                                            window.location.href = "https://finderspage.com/pricing";
                                        },
                                        error: function(xhr, status, error) {

                                        }
                                    });

                                  },
                                  enableFunding: 'credit, debit', // Enable guest checkout with credit/debit card
                                  allowGuest: true // Allow guest checkout
                              }).render('#paypal-button-container-P-7AH011683A097983LMX6SQKQ'); // Renders the PayPal button
                            </script>

                        @elseif($planname == 'three-month')
                        <div id="paypal-button-container-P-0CX68913A8561344BMX6STSQ"></div>
                            <script src="https://www.paypal.com/sdk/js?client-id=AXCsp61Xi_n27Zd05WKr6JjvLp1SeDEZzL43f2zzjNNpjqdZNXIVGljO75dguLFMwBR6LS8ZGAm3wtvM&commit=true&vault=true&intent=subscription" data-sdk-integration-source="button-factory"></script>
                            <script>
                              paypal.Buttons({
                                  style: {
                                      shape: 'rect',
                                      color: 'gold',
                                      layout: 'vertical',
                                      label: 'subscribe'
                                  },
                                  createSubscription: function(data, actions) {
                                    return actions.subscription.create({
                                      /* Creates the subscription */
                                      plan_id: 'P-0CX68913A8561344BMX6STSQ'
                                    });
                                  },
                                  onApprove: function(data, actions) {
                                    console.log(data);
                                    $('.payment-loader').removeClass('d-none');
                                    var subscriptionId = data.subscriptionID;
                                    var order_id = data.orderID;
                                    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                                    $.ajax({
                                        url: baseurl + '/paypal/subscription/payment/<?php echo $planname; ?>',
                                        type: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': csrfToken,
                                        },
                                        data: {
                                            subscriptionId: subscriptionId,
                                            order_id:order_id
                                        },
                                        success: function(response) {
                                            console.log(response);
                                             $('.payment-loader').addClass('d-none');
                                            window.location.href = "https://finderspage.com/pricing";
                                        },
                                        error: function(xhr, status, error) {

                                        }
                                    });

                                  },
                                  enableFunding: 'credit, debit', // Enable guest checkout with credit/debit card
                                  allowGuest: true // Allow guest checkout
                              }).render('#paypal-button-container-P-0CX68913A8561344BMX6STSQ'); // Renders the PayPal button
                            </script>

                        @elseif($planname == 'six-month')
                        <div id="paypal-button-container-P-37S36113VT1467646MX6SUFY"></div>
                            <script src="https://www.paypal.com/sdk/js?client-id=AXCsp61Xi_n27Zd05WKr6JjvLp1SeDEZzL43f2zzjNNpjqdZNXIVGljO75dguLFMwBR6LS8ZGAm3wtvM&commit=true&vault=true&intent=subscription" data-sdk-integration-source="button-factory"></script>
                            <script>
                              paypal.Buttons({
                                  style: {
                                      shape: 'rect',
                                      color: 'gold',
                                      layout: 'vertical',
                                      label: 'subscribe'
                                  },
                                  createSubscription: function(data, actions) {
                                    return actions.subscription.create({
                                      /* Creates the subscription */
                                      plan_id: 'P-37S36113VT1467646MX6SUFY'
                                    });
                                  },
                                  onApprove: function(data, actions) {
                                    console.log(data);
                                    $('.payment-loader').removeClass('d-none');
                                    var subscriptionId = data.subscriptionID;
                                    var order_id = data.orderID;
                                    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                                    $.ajax({
                                        url: baseurl + '/paypal/subscription/payment/<?php echo $planname; ?>',
                                        type: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': csrfToken,
                                        },
                                        data: {
                                            subscriptionId: subscriptionId,
                                            order_id:order_id
                                        },
                                        success: function(response) {
                                            console.log(response);
                                             $('.payment-loader').addClass('d-none');
                                            window.location.href = "https://finderspage.com/pricing";
                                        },
                                        error: function(xhr, status, error) {

                                        }
                                    });

                                  },
                                  enableFunding: 'credit, debit', // Enable guest checkout with credit/debit card
                                  allowGuest: true // Allow guest checkout
                              }).render('#paypal-button-container-P-37S36113VT1467646MX6SUFY'); // Renders the PayPal button
                            </script>

                        @elseif($planname == 'year')
                        <div id="paypal-button-container-P-0SV80968VE865210EMX6SUZA"></div>
                            <script src="https://www.paypal.com/sdk/js?client-id=AXCsp61Xi_n27Zd05WKr6JjvLp1SeDEZzL43f2zzjNNpjqdZNXIVGljO75dguLFMwBR6LS8ZGAm3wtvM&commit=true&vault=true&intent=subscription" data-sdk-integration-source="button-factory"></script>
                            <script>
                              paypal.Buttons({
                                  style: {
                                      shape: 'rect',
                                      color: 'gold',
                                      layout: 'vertical',
                                      label: 'subscribe'
                                  },
                                  createSubscription: function(data, actions) {
                                    return actions.subscription.create({
                                      /* Creates the subscription */
                                      plan_id: 'P-0SV80968VE865210EMX6SUZA'
                                    });
                                  },
                                  onApprove: function(data, actions) {
                                    console.log(data);
                                    // alert(data.subscriptionID); // You can add optional success message for the subscriber here
                                    $('.payment-loader').removeClass('d-none');
                                    var subscriptionId = data.subscriptionID;
                                    var order_id = data.orderID;
                            
                                    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                                    $.ajax({
                                        url: baseurl + '/paypal/subscription/payment/<?php echo $planname; ?>',
                                        type: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': csrfToken,
                                        },
                                        data: {
                                            subscriptionId: subscriptionId,
                                            order_id:order_id
                                        },
                                        success: function(response) {
                                            console.log(response);
                                            $('.payment-loader').addClass('d-none');
                                            window.location.href = "https://finderspage.com/pricing";
                                        },
                                        error: function(xhr, status, error) {

                                        }
                                    });

                                  },
                                  enableFunding: 'credit, debit', // Enable guest checkout with credit/debit card
                                  allowGuest: true // Allow guest checkout
                              }).render('#paypal-button-container-P-0SV80968VE865210EMX6SUZA'); // Renders the PayPal button
                            </script>
                        @endif

                        


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
               </div>
            </div>
         </div>
      </div>
   </div>
</section>


@endsection