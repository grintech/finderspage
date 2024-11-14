@extends('layouts.user_dashboard.userdashboardlayout')
@section('content')


<script src="https://www.paypal.com/sdk/js?client-id=AXCsp61Xi_n27Zd05WKr6JjvLp1SeDEZzL43f2zzjNNpjqdZNXIVGljO75dguLFMwBR6LS8ZGAm3wtvM&vault=true&disable-funding=card,sofort"></script>

<?php 
      use App\Models\Admin\SubPlan;
        $plan_week = SubPlan::where('plan', 'Weekly')->first();
        $plan_month = SubPlan::where('plan', 'Monthly')->first();
        $plan_3month = SubPlan::where('plan', "Three Month's")->first();
        $plan_6month = SubPlan::where('plan', "Six Month's")->first();
        $plan_year = SubPlan::where('plan', "Yearly")->first();
?>

<style>
   .pay_icon {
      font-size: 53px;
    position: relative;
    top: 23px;
    /* padding-left: -26px; */
   /* margin-right: -86px;
    margin-left: 63px;*/
   }
   .pay_icon_paypal {
      font-size: 51px;
    position: relative;
    top: 23px;
/*    padding-left: 109px;*/

   }
   .pay_image{
      height: 90px;
    width: 185px;
    /*margin-left: 36px;
    margin-right: -106px;*/
   }
   
</style>


<section id="payment-section">
   <div class="container mt-5 mb-5">
      <div class="card p-3">
         <div class="row">
            <!-- Grid column for the image -->
            <div class="col-md-6 img-frame"> <img src="{{asset
            ('user_dashboard/img/feature-banner.png')}}" alt="Banner Image" class="img-fluid payment-img"> </div>

            <!-- Grid column for the form -->
            <div class="col-md-6 mt-4 mt-md-0" id="sec_new">
               <h1 class="strip-heading">Select your Plan to Make a Featured Post</h1>
               <div class="panel panel-default credit-card-box">
                  <div class="col-md-12">
                     <!-- Image here, but it will be hidden because it's empty -->
                  </div>
                  <div class="panel-heading display-table">
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
                     <form role="form" action="{{ route('stripe.post') }}" method="post" class="require-validation strip-form" data-cc-on-file="false" data-stripe-publishable-key="{{$public_key}}" id="payment-form">
                        @csrf
                        <div class="row" id="new_css">
                           <div class="col-lg-6">
                              <div class='form-row' title="3 posts feature on the homepage" data-toggle="tooltip" data-placement="top">
                                 <input type="radio" name="planprice" value="weekly" class="radioBtnClass" checked="checked">
                                 <label for="7-day-14">Weekly &nbsp;<span class="showprice">${{$plan_week->price}}/week</span></label>
                              </div>
                           </div>
                           <div class="col-lg-6">
                              <div class='form-row' title="10 posts feature on the homepage" data-toggle="tooltip" data-placement="top">
                                 <input type="radio" name="planprice" value="month" class="radioBtnClass " checked="checked">
                                 <label for="1-month-55">First Month &nbsp;<span class="showprice">${{$plan_month->price}}/mo</span></label>
                              </div>
                           </div>
                           <div class="col-lg-6">
                              <div class='form-row' title="20 posts feature on the homepage" data-toggle="tooltip" data-placement="top">
                                 <input type="radio" name="planprice" value="three-month" class="radioBtnClass">
                                 <label for="3-month-166">Three Month's &nbsp;<span class="showprice">${{$plan_3month->price}}/mo</span></label>
                                 
                              </div>
                           </div>
                           <div class="col-lg-6">
                              <div class='form-row' title="40 posts feature on the homepage" data-toggle="tooltip" data-placement="top">
                                 <input type="radio" name="planprice" value="six-month" class="radioBtnClass">
                                 <label for="6-month-333">Six Month's &nbsp;<span class="showprice">${{$plan_6month->price}}/mo</span></label>
                                 
                              </div>
                           </div>
                           <div class="col-lg-6">
                              <div class='form-row' title="100 posts feature on the homepage" data-toggle="tooltip" data-placement="top">
                                 <input type="radio" name="planprice" value="year" class="radioBtnClass">
                                 <label for="1-year-777">One Year &nbsp;<span class="showprice">${{$plan_year->price}}/year</span></label>
                              </div>
                           </div>
                        </div>
                        <div class="strip-section">
                           <div class='form-row row'>
                              <div class='col-xs-12 col-lg-6 form-group required'>
                                 <label class='control-label'>Name on Card</label>
                                 <input class='form-control' name="cardholdername" size='4' type='text'>
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
                           <!-- <div class='form-row'>
                              <div class='col-md-12 error form-group hide'>
                                 <div class='alert-danger alert'>Please correct the errors and try again.</div>
                              </div>
                           </div> -->

                           <div class="row">
                              <div class="col-xs-12">
                                 <button class="contact-from-button" type="submit">Pay Now</button>
                              </div>
                           </div>
                           <div class="paypal_div mt-4">
                           <div class="weekly d-none">
                           <div id="paypal-button-container-P-0YX06832B9116540VMX6SLRA"></div>
                            <script>

                             paypal.Buttons({
                                        style: {
                                            shape: 'rect',
                                            color: 'gold',
                                            layout: 'vertical',
                                            label: 'subscribe',
                                            fundingicons: false, // Disable funding icons
                                        },
                                        funding: {
                                            allowed: [paypal.FUNDING.PAYPAL] // Only allow PayPal funding
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
                                        }
                                    }).render('#paypal-button-container-P-0YX06832B9116540VMX6SLRA');

                                    function saveSubscriptionId(subscriptionId,order_id) {
                                        // Send an AJAX request to your Laravel backend
                                         var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                                          var postid = '<?php echo $post_id;?>';
                                        $.ajax({
                                            url: baseurl + '/paypal/featured_save',
                                            method: 'POST',
                                            headers: {
                                            'X-CSRF-TOKEN': csrfToken,
                                            },
                                            data: {
                                                subscriptionId: subscriptionId,
                                                order_id:order_id,
                                                post_id:postid,
                                                planname :'weekly',
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
                        </div>
                       <div class="month d-none">
                            <div id="paypal-button-container-P-7AH011683A097983LMX6SQKQ"></div>
                            
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
                                     var postid = '<?php echo $post_id;?>';
                                    $.ajax({
                                       url: baseurl + '/paypal/featured_save',
                                        type: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': csrfToken,
                                        },
                                        data: {
                                            subscriptionId: subscriptionId,
                                            order_id:order_id,
                                            post_id:postid,
                                            planname :'month',
                                            
                                        },
                                        success: function(response) {
                                            console.log(response);
                                             $('.payment-loader').addClass('d-none');
                                            window.location.href = "https://finderspage.com/pricing";
                                        },
                                        error: function(xhr, status, error) {

                                        }
                                    });

                                  }
                              }).render('#paypal-button-container-P-7AH011683A097983LMX6SQKQ'); // Renders the PayPal button
                            </script>
                        </div>
                        <div class="three-month d-none">
                            <div id="paypal-button-container-P-0CX68913A8561344BMX6STSQ"></div>
                            
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
                                     var postid = '<?php echo $post_id;?>';
                                    $.ajax({
                                        url: baseurl + '/paypal/featured_save',
                                        type: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': csrfToken,
                                        },
                                        data: {
                                            subscriptionId: subscriptionId,
                                            order_id:order_id,
                                            post_id:postid,
                                            planname :'three-month',
                                        },
                                        success: function(response) {
                                            console.log(response);
                                             $('.payment-loader').addClass('d-none');
                                            window.location.href = "https://finderspage.com/pricing";
                                        },
                                        error: function(xhr, status, error) {

                                        }
                                    });

                                  }
                              }).render('#paypal-button-container-P-0CX68913A8561344BMX6STSQ'); // Renders the PayPal button
                            </script>
                        </div>
                        <div class="six-month d-none">
                            <div id="paypal-button-container-P-37S36113VT1467646MX6SUFY"></div>
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
                                    var postid = '<?php echo $post_id;?>';
                                    $.ajax({
                                       url: baseurl + '/paypal/featured_save',
                                        type: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': csrfToken,
                                        },
                                        data: {
                                            subscriptionId: subscriptionId,
                                            order_id:order_id,
                                            post_id:postid,
                                            planname :'six-month',

                                        },
                                        success: function(response) {
                                            console.log(response);
                                             $('.payment-loader').addClass('d-none');
                                            window.location.href = "https://finderspage.com/pricing";
                                        },
                                        error: function(xhr, status, error) {

                                        }
                                    });

                                  }
                              }).render('#paypal-button-container-P-37S36113VT1467646MX6SUFY'); // Renders the PayPal button
                            </script>
                        </div>
                        <div class="year d-none">
                            <div id="paypal-button-container-P-0SV80968VE865210EMX6SUZA"></div>
                               
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
                                         var postid = '<?php echo $post_id;?>';
                                        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                                        $.ajax({
                                            url: baseurl + '/paypal/featured_save',
                                            type: 'POST',
                                            headers: {
                                                'X-CSRF-TOKEN': csrfToken,
                                            },
                                            data: {
                                                subscriptionId: subscriptionId,
                                                order_id:order_id,
                                                post_id:postid,
                                                planname :'year',
                                            },
                                            success: function(response) {
                                                console.log(response);
                                                $('.payment-loader').addClass('d-none');
                                                window.location.href = "https://finderspage.com/pricing";
                                            },
                                            error: function(xhr, status, error) {

                                            }
                                        });

                                      }
                                  }).render('#paypal-button-container-P-0SV80968VE865210EMX6SUZA'); // Renders the PayPal button
                                </script>
                                     </div>


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
                           <div class="row">
                              <div class="col-xs-12 mt-3 text-center stripe-frame">
                                 <i class="fab fa-apple-pay pay_icon"></i>
                                 <i class="fab fa-cc-paypal pay_icon_paypal"></i>
                                 <!-- 
                                    <i style="font-size: 30px" class="fas fa-credit-card"></i>
                                 <i style="font-size: 30px" class="fab fa-cc-visa"></i> -->
                                 <img class="pay_image" src="{{asset
            ('./images/stripe-payment-icon.png')}}" alt="">
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
<script type="text/javascript">
    
$(document).ready(function(){
    $(".radioBtnClass").click(function(){
        var value = $(this).val();
        // alert(value);
        if(value == 'weekly'){
            $('.weekly').removeClass('d-none');
            $('.month').addClass('d-none');
            $('.three-month').addClass('d-none');
            $('.six-month').addClass('d-none');
            $('.year').addClass('d-none');
        } else if(value == 'month'){
            $('.month').removeClass('d-none');
            $('.weekly').addClass('d-none');
            $('.three-month').addClass('d-none');
            $('.six-month').addClass('d-none');
            $('.year').addClass('d-none');
        } else if(value == 'three-month'){
            $('.month').addClass('d-none');
            $('.weekly').addClass('d-none');
            $('.three-month').removeClass('d-none');
            $('.six-month').addClass('d-none');
            $('.year').addClass('d-none');
        } else if(value == 'six-month'){
            $('.month').addClass('d-none');
            $('.weekly').addClass('d-none');
            $('.three-month').addClass('d-none');
            $('.six-month').removeClass('d-none');
            $('.year').addClass('d-none');
        } else if(value == 'year'){
            $('.month').addClass('d-none');
            $('.weekly').addClass('d-none');
            $('.three-month').addClass('d-none');
            $('.six-month').addClass('d-none');
            $('.year').removeClass('d-none');
        }
    });
});

</script>
<script>
    $(document).ready(function(){
          $('[data-toggle="tooltip"]').tooltip();   
        });

   $(document).ready(function() {
      // Custom validation method to check if a radio button is selected
      $.validator.addMethod("radioRequired", function(value, element) {
         return $("input[name='" + element.name + "']:checked").length > 0;
      }, "Please select a plan.");

      // Custom validation method to check if a field contains only letters
      $.validator.addMethod("lettersOnly", function(value, element) {
         return this.optional(element) || /^[a-zA-Z\s]+$/.test(value);
      }, "Please enter letters only.");

      // Initialize the form validation
      $("#payment-form").validate({
         rules: {
            "planprice": {
               radioRequired: true
            },
            "cardholdername": {
               required: true,
               lettersOnly: true
            },
            "cardnumber": {
               required: true,
               digits: true,
               minlength: 16,
               maxlength: 16
            },
            "cardcvc": {
               required: true,
               digits: true,
               maxlength: 4
            },
            "cardexpirymonth": {
               required: true,
               digits: true,
               range: [1, 12]

            },
            "cardexpiryyear": {
               required: true,
               digits: true,
               minlength: 4,
               maxlength: 4
            }
         },
         messages: {
            "planprice": {
               radioRequired: "Please select a plan."
            },
            "cardholdername": {
               required: "Please enter the name on the card.",
               lettersOnly: "Please enter letters only."
            },
            "cardnumber": {
               required: "Please enter the card number."
            },
            "cardcvc": {
               required: "Please enter the CVC code.",
               digits: "Please enter a valid CVC code.(123)",
               maxlength: "Please enter a valid CVC."
            },
            "cardexpirymonth": {
               required: "Please enter the expiration month (MM).",
               digits: "Please enter a valid month (1-12).",
               range: "Please enter a valid month (1-12)."
            },
            "cardexpiryyear": {
               required: "Please enter the expiration year (YYYY).",
               digits: "Please enter a valid year.",
               minlength: "Please enter a valid year.",
               maxlength: "Please enter a valid year."
            }
         },
         errorPlacement: function(error, element) {
            if (element.attr("type") === "radio") {
               error.insertAfter(element.closest(".form-row"));
            } else {
               error.insertAfter(element);
            }
         }
      });

      // Perform validation checks on blur
      $("#payment-form input").on("blur", function() {
         $(this).valid();
      });
   });
</script>



<script type="text/javascript" src="https://js.stripe.com/v2/"></script>

<script type="text/javascript">
   $(function() {







      /*------------------------------------------

      

          --------------------------------------------

      

          Stripe Payment Code

      

          --------------------------------------------

      

          --------------------------------------------*/







      var $form = $(".require-validation");







      $('form.require-validation').bind('submit', function(e) {



         var palnprice = $("input[type='radio'].radioBtnClass:checked").val();

         console.log(palnprice);



         var $form = $(".require-validation"),

            inputSelector = ['input[type=email]', 'input[type=password]',



               'input[type=text]', 'input[type=file]',



               'textarea'

            ].join(', '),



            $inputs = $form.find('.required').find(inputSelector),



            $errorMessage = $form.find('div.error'),



            valid = true;



         $errorMessage.addClass('hide');







         $('.has-error').removeClass('has-error');



         $inputs.each(function(i, el) {



            var $input = $(el);



            if ($input.val() === '') {



               $input.parent().addClass('has-error');



               $errorMessage.removeClass('hide');



               e.preventDefault();



            }



         });







         if (!$form.data('cc-on-file')) {



            e.preventDefault();



            Stripe.setPublishableKey($form.data('stripe-publishable-key'));



            Stripe.createToken({



               number: $('.card-number').val(),



               cvc: $('.card-cvc').val(),



               exp_month: $('.card-expiry-month').val(),



               exp_year: $('.card-expiry-year').val()



            }, stripeResponseHandler);



         }







      });







      /*------------------------------------------

      

          --------------------------------------------

      

          Stripe Response Handler

      

          --------------------------------------------

      

          --------------------------------------------*/



      function stripeResponseHandler(status, response) {



         if (response.error) {



            $('.error')



               .removeClass('hide')



               .find('.alert')



               .text(response.error.message);



         } else {



            /* token contains id, last4, and card type */



            var token = response['id'];



            var postid = "{{ $post_id }}";





            $form.find('input[type=text]').empty();





            var html = '<input type="hidden" name="stripeToken" value="' + token + '"/><input type="hidden" name="post_id" value="' + postid + '"/ >';



            // $form.append("");

            $form.append(html);



            $form.get(0).submit();



         }



      }







   });
</script>

@endsection