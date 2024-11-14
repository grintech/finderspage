@extends('layouts.user_dashboard.userdashboardlayout')
@section('content')

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
               <img src="{{asset('user_dashboard/img/bump-img_1_new_2.jpg')}}" alt="Banner Image" class="img-fluid payment-img">
            </div>

            <!-- Grid column for the form -->
            <div class="col-md-6 mt-4 mt-md-0" id="sec_new">
               <h1 class="strip-heading">Bump your post!</h1>
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
                     <form role="form" action="{{ route('pay.auth.save.blogs',$post_id) }}" method="post" class="require-validation strip-form" data-cc-on-file="false" data-stripe-publishable-key="" id="payment-form">
                        @csrf
                        <div class="row" id="new_css">
                           <div class="col-lg-6">
                              <div class='form-row'>
                                 <input type="radio" name="planprice" value="5" class="radioBtnClass " checked="checked">
                                 <label>Bump Post Price</label>
                                 <span class="showprice"> $ 5/day </span>
                              </div>
                           </div>
                        </div>
                        <!-- <div class="strip-section">
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
                           </div> -->

                           <div class="col-lg-12 text-center mt-4">
                             <!-- <a href="{{ route('paypal.payment.blogs',$post_id) }}">
                              <div class="payPalWhite">
                                 <div class="responsivePayPalWhite">
                                   <img src="https://www.paypalobjects.com/webstatic/en_US/i/buttons/PP_logo_h_100x26.png" alt="Check out with PayPal" />
                                 </div>
                              </div>
                           </a> -->
                           <div id="paypal-button-container"></div>
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
<!-- <script src="https://www.paypal.com/sdk/js?client-id=AfT9835L_jb-46wYpduziQDZt-G6RCsUYBuWBc3rNIdwB1SKHK2AHM8FTClYytFE_UiZ-DEDKyEpnp7D&components=buttons&enable-funding=venmo&disable-funding=paylater"></script> -->
<script src="https://www.paypal.com/sdk/js?client-id=AfT9835L_jb-46wYpduziQDZt-G6RCsUYBuWBc3rNIdwB1SKHK2AHM8FTClYytFE_UiZ-DEDKyEpnp7D&components=buttons&enable-funding=venmo&disable-funding=paylater"></script>

<script>
  paypal.Buttons({
    createOrder: function(data, actions) {
      return actions.order.create({
        purchase_units: [{
          amount: {
            value: '5.00' // Replace with your amount
          }
        }]
      });
    },
    onApprove: function(data, actions) {
      return actions.order.capture().then(function(details) {
         $("#loader").show();
        console.log('Payment successful and data sent to server:', data);
        console.log('Payment successful and details sent to server:', details.status);
        var post_id = <?php echo $post_id; ?>;
        var status = details.status;
          // Show the loader
          
        // Payment was successful, send details to your server using AJAX
        $.ajax({
          url: '/payment-checkout-all', // Replace with your route
          method: 'POST',
          data: {
            post_id: post_id,
            orderID: data.orderID,
            paymentID: data.paymentID,
            payerID: data.payerID,
            paymentSource: data.paymentSource,
            email: details.payer.email_address,
            name: details.payer.name.given_name+' '+ details.payer.name.surname,
            status: status
          },
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          success: function(response) {
            // Handle the response from your server
            console.log('Payment successful and data sent to server:', response);
            // Hide the loader
            $("#loader").hide();

            if (response.success) {
                    Swal.fire({
                        title: 'Payment Successful!',
                        text: response.success,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '/user-index'; // Replace with your redirect URL
                        }
                    });
                } else if (response.error) {
                    Swal.fire({
                        title: 'Payment Failed!',
                        text: response.error,
                        icon: 'error',
                        confirmButtonText: 'Try Again'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '/user-index'; // Replace with your retry page URL
                        }
                    });
                }
            
          },
          error: function(xhr, status, error) {
            console.error('An error occurred:', error);
            // Hide the loader
            $("#loader").hide();
            // Handle the error
          }
        });
      });
    },
    onError: function(err) {
      console.error('An error occurred during the transaction', err);
      // Handle the error
    }
  }).render('#paypal-button-container');
</script>
@endsection