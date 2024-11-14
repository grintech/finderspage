@extends('layouts.user_dashboard.userdashboardlayout')
@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css" rel="stylesheet">

<style>
@import url("https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,400&display=swap");

.rounded {border-radius: 15px !important;}
.hidden {visibility: hidden;opacity: 0;}
.btn {transition: all 0.25s ease-in-out;}
.btn-teal {background: #1A202E;color: #ffffff;}
.btn-teal:hover {background-color: rgb(221, 198, 54);color: #fff;}
.pricing-intro .sub-title {font-size: 12px;font-weight: 400;}
.pricing-plan {background: #f2f2f2;border: 1px solid #fff;cursor: pointer;transition: all 0.25s ease-in-out;}
.pricing-plan:hover {background: #1A202E;color: #fff;}
.pricing-plan.active-btn {
background: linear-gradient(90deg, rgba(170, 137, 65, 1) 0%, rgba(205, 156, 49, 1) 13%, rgba(154, 128, 73, 1) 35%, rgba(246, 204, 78, 1) 51%, rgba(181, 147, 56, 1) 75%, rgba(163, 136, 68, 1) 100%);color: #fff;}
.pricing-plans h3{font-size: 20px; font-weight: 700;}
.pricing-plan h4{font-size: 14px; font-weight: 700;}

.pricing-table h2 {font-size: 1.10em;font-weight: 600;}
.pricing-table .sub-title {font-size: 12px;font-weight: 600!important;color: #000;margin-bottom: 0!important;}
.pricing-table .active-plan {display: block !important;}
.col-compare .title-row {border-top-left-radius: 10px;}
.col-enterprise .title-row {border-top-right-radius: 0px;}
.col-free .title-row{border-top-right-radius: 10px;}
/*.pricing-compare {border-top-left-radius: 10px;border-bottom-left-radius: 10px;}*/
.pricing-enterprise {border-bottom-right-radius: 0px;}
.col-pricing:hover {z-index: 1;}
.pricing-single {background: #f7f7f7;min-height: 100px;margin-left: 1px;margin-right: 1px;transition: all 0.25s ease-in-out;border-left: 1px solid #dfdfdf;border-right: 1px solid #dfdfdf;}
.pricing-single:first-child{border-left:1px solid #dfdfdf;}
.pricing-single:nth-child(7){border-right:1px solid #dfdfdf;}
/*.pricing-single:hover:not(.pricing-compare) {box-shadow: 0 0 10px rgba(0, 0, 0, 0.25);transform: scale(1.005);}*/
/*.pricing-single:last-of-type {border-top-right-radius: 10px;border-bottom-right-radius: 10px;}
.pricing-single{border-bottom-right-radius: 0px;}*/
.col-pricing .title-row{border-top-right-radius: 10px;}
.title-row {background: #000;color: #fff;min-height: 50px;padding: 0px;}
.title-row h2{margin-bottom: 0;}
.pricing-popular {min-height: 30px;border-radius: 5px 5px 0 0;z-index: 2;margin-bottom: 8px;}
.pricing-popular h4 {font-size: 18px;font-weight: 400;}
.pricing-popular.active {
background: linear-gradient(90deg, rgba(170, 137, 65, 1) 0%, rgba(205, 156, 49, 1) 13%, rgba(154, 128, 73, 1) 35%, rgba(246, 204, 78, 1) 51%, rgba(181, 147, 56, 1) 75%, rgba(163, 136, 68, 1) 100%);color: #fff;}
.active-plan .pricing-single {
background: linear-gradient(90deg, rgba(170, 137, 65, 1) 0%, rgba(205, 156, 49, 1) 13%, rgba(154, 128, 73, 1) 35%, rgba(246, 204, 78, 1) 51%, rgba(181, 147, 56, 1) 75%, rgba(163, 136, 68, 1) 100%);}
.col-popular .btn-teal {color: #ffffff;}
.col-popular .btn-teal:hover {background-color: rgb(221, 198, 54);color: #fff;}
.cost-row {border-bottom: 1px solid #dfdfdf;min-height: 100px;background: linear-gradient(90deg, rgba(170, 137, 65, 1) 0%, rgba(205, 156, 49, 1) 13%, rgba(154, 128, 73, 1) 35%, rgba(246, 204, 78, 1) 51%, rgba(181, 147, 56, 1) 75%, rgba(163, 136, 68, 1) 100%);}
.cost-row .cost {font-size: 30px;font-weight: 700;line-height: 1em;color: #000;}
.cost-wrap .cost.price-text{font-size: 18px;color:#000;}
.active-plan .cost-row .cost{color: #000;}
.compare-item-row {height: 50px;}
.compare-item-row:last-of-type {border-bottom: none;}
.compare-item-row .circle {font-size: 15px;font-weight: 600;}
.compare-item-row .compare-title {font-weight: 700;}
.sub-plan{font-weight: 600;}
.col-compare{border-bottom: 1px solid #dfdfdf;/*border-radius: 0 0 0 10px;*/}
.col-pricing{border-bottom: 1px solid #dfdfdf;border-radius: 0 0 10px 0px;}

@media screen and (max-width: 1199px) {
.compare-item-row {height: 70px;}
}

@media screen and (max-width: 991px) {
.pricing-table {font-size: 14px;}
}

@media screen and (max-width: 767px) {
.pricing-single:not(.pricing-compare) {border-top-right-radius: 10px;border-bottom-right-radius: 10px;}
.pricing-single:not(.pricing-compare) .title-row {border-top-right-radius: 10px;}
.pricing-single:hover {box-shadow: none !important;transform: none !important;}

}

@media screen and (max-width: 460px) {
.cost-row .cost {font-size: 30px;}
.cost-row{min-height: 70px;}
.compare-item-row {height: 50px;}
}
</style>

<body>
    <div class="container my-3 my-md-5">
	    <div class="row">
	      <div class="col-12 text-center">
	        <h3 class='sub-plan pb-2 mb-0'>Weekly Plan</h3>
	      </div>
	    </div>

	    <div class="row pricing-table justify-content-center">
		    <div class="col-md-3 col-6 px-0 col-compare">
		        <div class="pricing-popular mb-2"></div>
		        <div class="pricing-single pricing-compare">
			        <div class="title-row d-flex justify-content-start align-items-center px-3">
			            <div class="title-wrap">
			              <h2>Featured</h2>
			            </div>
			        </div>
			        <div class="cost-row d-flex justify-content-start align-items-center px-3">
			            <div class="cost-wrap">
			              <h3 class="cost price-text mb-0">Pricing</h3>
			            </div>
			        </div>
			        <div class="compare-item-row d-flex justify-content-start align-items-center px-3">
			            <span class="compare-title">Featured Posts</span>
			        </div>
			        <div class="compare-item-row d-flex justify-content-start align-items-center px-3">
			            <span class="compare-title">Display Post on Home Page</span>
			        </div>
			        <div class="compare-item-row d-flex justify-content-start align-items-center px-3">
			            <span class="compare-title">Slideshow for Posts</span>
			        </div>
			        <div class="compare-item-row d-flex justify-content-start align-items-center px-3">
			            <span class="compare-title">Golden Star Badge</span>
			        </div>
			        <div class="compare-item-row d-flex justify-content-start align-items-center px-3">
			            <span class="compare-title">Cancellation</span>
			        </div>
			        <!-- <div class="compare-item-row d-flex justify-content-start align-items-center px-3">
			            <span class="compare-title">Available Now</span>
			        </div>
			        <div class="compare-item-row d-flex justify-content-start align-items-center px-3">
			            <span class="compare-title">Update Button</span>
			        </div> -->
			        <div class="compare-item-row d-flex justify-content-start align-items-center px-3">
			            <span class="compare-title"></span>
			        </div>
		        </div>
		    </div>
		    <div class="col-md-3 col-6  px-0 col-pricing col-basic" id="weekly-plan">
		        <div class="pricing-popular mb-2"></div>
		        <div class="pricing-single pricing-basic">
			        <div class="title-row d-flex justify-content-center align-items-center">
			            <div class="title-wrap text-center">
			              <h2>Weekly</h2>
			            </div>
			        </div>
			        <div class="cost-row d-flex justify-content-center align-items-center">
			            <div class="cost-wrap text-center">
			              <h3 class="cost mb-0">$14</h3>
			            </div>
			        </div>
			        <div class="compare-item-row d-flex justify-content-center align-items-center">
			            <div class="circle bg-teal">4</div>
			        </div>
			        <div class="compare-item-row d-flex justify-content-center align-items-center">
			            <div class="circle bg-teal">✓</div>
			        </div>
			        <div class="compare-item-row d-flex justify-content-center align-items-center">
			            <div class="circle bg-teal">Upto 5</div>
			        </div>
			        <div class="compare-item-row d-flex justify-content-center align-items-center">
			            <div class="circle bg-teal">✓</div>
			        </div>
			        <div class="compare-item-row d-flex justify-content-center align-items-center">
			            <div class="circle bg-teal">✓</div>
			        </div>
			        <!-- <div class="compare-item-row d-flex justify-content-center align-items-center">
			            <div class="circle bg-teal">✗</div>
			        </div>
			        <div class="compare-item-row d-flex justify-content-center align-items-center">
			            <div class="circle bg-teal">✗</div>
			        </div> -->
			        <div class="compare-item-row d-flex justify-content-center align-items-center">
			            <a class="btn btn-teal">Order Now</a>
			        </div>
		        </div>
		    </div>
		</div>
	</div>
</body>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.1/js/bootstrap.min.js"></script>
@endsection