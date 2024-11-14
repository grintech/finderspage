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
               <img src="{{asset('user_dashboard/img/bump-img_1_new.jpg')}}" alt="Banner Image" class="img-fluid payment-img">
            </div>
            
            <!-- Grid column for the form -->
            <div class="col-md-6 mt-4 mt-md-0 text-center" id="sec_new">
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
                     <div class="row text-center" id="new_css">
                        <div class="col-lg-12">
                           <div class=''>
                              <input type="radio" name="planprice" value="1-day-3" class="radioBtnClass " checked="checked">
                              <label>Bump Post Price</label>
                              <span class="showprice"> $ 3/day </span>
                           </div>
                        </div>
                        <div class="col-lg-12 text-center">
                           <a href="{{ route('paypal.payment',$post_id) }}}">
                              <div class="payPalWhite">
                                 <div class="responsivePayPalWhite">
                                   <img src="https://www.paypalobjects.com/webstatic/en_US/i/buttons/PP_logo_h_100x26.png" alt="Check out with PayPal" />
                                 </div>
                              </div>
                           </a>
                        </div>
                        <div class="col-lg-12">
                           <div class="text-frame">
                              Or
                           </div>
                        </div>
                        <div class="col-lg-12">
                           <a href="#" class="btn button-area">Credit / Debit Card</a>
                        </div>
                     </div>
                     <div class="row text-center mt-4 pt-3">
                        <div class="col-md-12 banner-frame">
                           <img src="{{asset('user_dashboard/img/payment-banner.jpeg')}}" alt="Payment Banner Image" class="img-fluid payment-img">
                        </div>
                     </div>
                    <!--  <center>
                       <a href="{{ route('paypal.payment',$post_id) }}">
                            <div class="payPalWhite">
  
                              <div class="responsivePayPalWhite">
                                <img src="https://www.paypalobjects.com/webstatic/en_US/i/buttons/PP_logo_h_100x26.png" alt="Check out with PayPal" />
                              </div>
                              
                            </div>
                        </a>
                    </center>-->
                  </div>
               </div>
            </div>

         </div>
      </div>
   </div>
</section> 
@endsection