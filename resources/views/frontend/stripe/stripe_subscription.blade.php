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
                     <form role="form" action="{{ route('stripe.subscription.save') }}" method="post" class="require-validation strip-form" data-cc-on-file="false" data-stripe-publishable-key="{{$public_key}}" id="payment-form">
                        @csrf
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
                           <div class='form-row'>
                              <div class='col-md-12 error  form-group d-none'>
                                 <div class='alert-danger alert'></div>
                              </div>
                           </div> 
             
                           <div class="row">
                              <div class="col-xs-12">
                                 <button class="contact-from-button" type="submit">Pay Now</button>
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
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css"/>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css"/>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>


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

               .removeClass('d-none')



               .find('.alert')



               .text(response.error.message);

                setTimeout(function() {
                      $('.error').addClass('d-none');
                   }, 2000);



         } else {



            /* token contains id, last4, and card type */



            var token = response['id'];



            var postid = "{{ $user_id }}";





            $form.find('input[type=text]').empty();





            var html = '<input type="hidden" name="stripeToken" value="' + token + '"/><input type="hidden" name="post_id" value="' + postid + '"/ >';



            // $form.append("");

            $form.append(html);



            $form.get(0).submit();



         }



      }







   });

   // $(document).ready(function(){
   //          $('#plan-banner-image').slick({
   //              slidesToShow: 1,
   //              slidesToScroll: 1,
   //              autoplay: true,
   //              autoplaySpeed: 2000,
   //              arrows: true,
   //              prevArrow: '<button type="button" class="slick-prev">Previous</button>',
   //              nextArrow: '<button type="button" class="slick-next">Next</button>'
   //          });
   //      });

</script>

@endsection