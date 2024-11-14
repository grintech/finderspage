<?php use App\Models\UserAuth; 
    $User_data = UserAuth::getLoginUser();
    // dd($User_data);
?>
@extends('layouts.user_dashboard.userdashboardlayout')
@section('content')
<!-- <style>
    .feature-banner img {
    height: 534px;
    display: block;
    border-radius: 0.35rem;
    width: 100%;
}
</style> -->
<style>
.card-selected{background-color: #000;} 
.card-selected h2{color: #fff;}  
.card-selected.card-pricing .list-unstyled li{color: #fff; border-color: rgba(255, 255, 255, 0.4);}   
.card-selected .selection-frame, .card-selected .cancel-frame {border-bottom: 1px dashed rgba(255, 255, 255, 0.4);}
.card-selected .custom-toggle span{color:#fff;}
.card-selected .custom-toggle input[type="checkbox"] {background: #cc9b31;}
.selection-frame, .cancel-frame{display: flex; justify-content: center; align-items: center;}
.selection-frame, .cancel-frame {border-bottom: 1px dashed rgba(58, 59, 69, 0.4);}
.selection-frame .selection-box{width: 50%;}   
.selection-frame .selection-box .form-control{height: 36px;}
.cancel-button {background: linear-gradient(90deg, rgba(170, 137, 65, 1) 0%, rgba(205, 156, 49, 1) 13%, rgba(154, 128, 73, 1) 35%, rgba(246, 204, 78, 1) 51%, rgba(181, 147, 56, 1) 75%, rgba(163, 136, 68, 1) 100%);border-radius: 5px;color: #000 !important;padding: 5px 20px;font-size: 16px;}
.card-selected .cancel-text{color: #fff; font-size: 10px; padding-right: 10px;}
.card-selected .current-text{color: #fff;}
.card-selected .pricing-btn-outline{background: linear-gradient(90deg, rgba(170, 137, 65, 1) 0%, rgba(205, 156, 49, 1) 13%, rgba(154, 128, 73, 1) 35%, rgba(246, 204, 78, 1) 51%, rgba(181, 147, 56, 1) 75%, rgba(163, 136, 68, 1) 100%);color: #000 !important; border:0;}

.cancel-text{color: #000; font-size: 10px; padding-right: 10px;}
.current-text{color: #000;}



@media only screen and (min-width:1200px) and (max-width:1570px){
.cancel-button{padding: 5px 10px; margin-bottom: 10px;}   
.card-selected .selection-frame, .card-selected .cancel-frame{flex-direction: column;} 
.selection-frame .btn-toggle::after {right: -6.5rem;}
.selection-frame .btn-toggle::before {left: -6rem;}
}

@media only screen and (max-width: 1520px) and (min-width: 1200px)  {

.custom-toggle {
    display: flex;
    font-size: 14px;
}
.cancel-frame.pb-2.mb-2 {
    display: flex !important;
    flex-direction: row !important;
}
}

</style>
<div class="container-fluid px-3 px-md-5">
    <!-- Page Heading -->
    <div class="d-sm-flex flex-column  mb-3">
        <h1 class="h3 mb-0 text-gray-800 fw-bold">Pricing</h1>
        <!-- <p>View monthly and annaully pricing</p> -->
    </div>
    <div class="mt-3 mb-2">
        <span>
            @include('admin.partials.flash_messages')
        </span>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-monthly" role="tabpanel" aria-labelledby="nav-monthly-tab">
                <div class="row pricing">
                    <div class="col-xl-4 col-lg-12 col-md-12">
                        <div class="feature-banner shadow-sm text-center mb-5">
                            <img class="img-fluid" src="{{asset('user_dashboard/img/feature-banner.png')}}">
                        </div>
                    </div>
                    <div class="col-xl-8 col-lg-12 col-md-12">
                        <div class="row">
                            <div class="col-md-6 col-lg-4 mb-2">
                                <div class="card card-pricing text-center px-0 mb-4 shadow-sm  @if($User_data->subscribedPlan =='7-day-14')card-selected @endif">
                                    <span class="h5 w-60 mx-auto px-4 py-1 rounded-bottom bg-yellow shadow-sm">Weekly</span>
                                    <small class="current-text">@if($User_data->subscribedPlan =='7-day-14') Currently this plan is active @else Choose this plan @endif</small>
                                    <div class="bg-transparent card-header pt-4 border-0 px-0">
                                        <h2 class="h2 fw-bold text-center mb-0" data-pricing-value="15">$<span class="price">14</span><span class="h6 ml-1">/ per week</span></h2>
                                    </div>
                                    <div class="card-body pb-0">
                                        <ul class="list-unstyled mb-2">
                                            <li>3 feature posts </li>
                                        </ul>
                                        <div class="selection-frame py-2 mb-2">
                                            <label class="custom-toggle">
                                                <span>Repost</span> &nbsp;&nbsp;
                                                <input type="checkbox" name="paymentType" value="true" {{ $User_data->payment_type == 'Automatic'? 'checked' : '' }}> &nbsp;&nbsp;<span>Auto repost</span>
                                            </label>
                                            <!-- <button type="button" class="btn btn-lg btn-toggle active" data-toggle="button" aria-pressed="true" autocomplete="Repost">
                                                <div class="handle"></div>
                                            </button> -->
                                            <!-- <span class="cancel-box"><button type="button" class="btn cancel-button">Repost</button></span>
                                            <span class="cancel-box"><button type="button" class="btn cancel-button">Automatic</button></span> -->
                                        </div>
                                        <div class="cancel-frame pb-2 mb-2">
                                            <span class="cancel-text">Would you like to cancel the current plan?</span>
                                            <span class="cancel-box1"><a href="#" data-link="{{route('subscription.cancel',['id'=>UserAuth::getLoginId(),'planname' =>'weekly'])}}" class="btn cancel-button cancelBtn">@if($User_data->subscribedPlan =='7-day-14' && $User_data->cancel_at == 1) Canceled @else Cancel @endif</a></span>
                                        </div>
                                        <a href="{{route('stripe.subscription',[
                                            'id' => General::encrypt(UserAuth::getLoginId()),
                                            'planname' => 'weekly',
                                        ])}}" class="btn pricing-btn-outline mb-3 hvr">@if($User_data->subscribedPlan =='7-day-14') Current Plan @else Order Now @endif</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4 mb-2">
                                <div class="card card-pricing popular shadow-sm text-center px-0 mb-4 @if($User_data->subscribedPlan =='1-month-55')card-selected @endif">
                                    <span class="h5 w-60 mx-auto px-4 py-1 rounded-bottom bg-yellow shadow-sm">Monthly</span>
                                    <small class="current-text">@if($User_data->subscribedPlan =='1-month-55') Currently this plan is active @else Choose this plan @endif</small>
                                    <div class="bg-transparent card-header pt-4 border-0 px-0">
                                        <h2 class="h2 fw-bold text-center mb-0" data-pricing-value="30">$<span class="price">55</span><span class="h6 ml-1">/ per month</span></h2>
                                    </div>
                                    <div class="card-body pb-0">
                                        <ul class="list-unstyled mb-2">
                                            <li>10 feature posts </li>
                                           <!--  <li>Email Support support</li>
                                            <li>Monthly updates</li>
                                            <li>Free cancelation</li> -->
                                        </ul>
                                        <div class="selection-frame py-2 mb-2">
                                            <!-- <button type="button" class="btn btn-lg btn-toggle active" data-toggle="button" aria-pressed="true" autocomplete="Repost">
                                                <div class="handle"></div>
                                            </button> -->

                                            <label class="custom-toggle">
                                                <span>Repost</span> &nbsp;&nbsp;
                                                <input type="checkbox" name="paymentType" value="true" {{ $User_data->payment_type == 'Automatic'? 'checked' : '' }}> &nbsp;&nbsp;<span> Auto repost</span>
                                            </label>
                                        </div>
                                        <div class="cancel-frame pb-2 mb-2">
                                            <span class="cancel-text">Would you like to cancel the current plan?</span>
                                            <span class="cancel-box1"><a href="#" data-link="{{route('subscription.cancel',['id'=>UserAuth::getLoginId(),'planname' =>'month'])}}" class="btn cancel-button cancelBtn">@if($User_data->subscribedPlan =='1-month-55' && $User_data->cancel_at == 1) Canceled @else Cancel @endif</a></span>
                                        </div>
                                        <a href="{{route('stripe.subscription',[
                                            'id' => General::encrypt(UserAuth::getLoginId()),
                                            'planname' => 'month',
                                        ] )}}" class="btn pricing-btn-outline mb-3 hvr">@if($User_data->subscribedPlan =='1-month-55') Current Plan @else Order Now @endif</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4 mb-2">
                                <div class="card card-pricing text-center px-0 mb-4 shadow-sm @if($User_data->subscribedPlan =='3-month-166')card-selected @endif">
                                    <span class="h5 w-60 mx-auto px-4 py-1 rounded-bottom bg-yellow shadow-sm">Three Months</span>
                                    <small class="current-text">@if($User_data->subscribedPlan =='3-month-166') Currently this plan is active @else Choose this plan @endif</small>
                                    <div class="bg-transparent card-header pt-4 border-0 px-0">
                                        <h2 class="h2 fw-bold text-center mb-0" data-pricing-value="45">$<span class="price">166</span><span class="h6 ml-1">/ every three months</span></h2>
                                    </div>
                                    <div class="card-body pb-0">
                                        <ul class="list-unstyled mb-2">
                                            <li>20 feature posts </li>
                                            <!-- <li>Email & phone support</li>
                                            <li>Monthly updates</li>
                                            <li>Free cancelation</li> -->
                                        </ul>
                                        <div class="selection-frame py-2 mb-2">
                                            <!-- <button type="button" class="btn btn-lg btn-toggle active" data-toggle="button" aria-pressed="true" autocomplete="Repost">
                                                <div class="handle"></div>
                                            </button> -->
                                            <label class="custom-toggle">
                                                <span>Repost</span> &nbsp;&nbsp;
                                                <input type="checkbox" name="paymentType" value="true"{{ $User_data->payment_type == 'Automatic'? 'checked' : '' }}> &nbsp;&nbsp;<span> Auto repost</span>
                                            </label>
                                        </div>
                                        <div class="cancel-frame pb-2 mb-2">
                                            <span class="cancel-text">Would you like to cancel the current plan?</span>
                                            <span class="cancel-box1"><a href="#"  data-link="{{route('subscription.cancel',['id'=>UserAuth::getLoginId(),'planname' =>'three-month'])}}" class="btn cancel-button cancelBtn">@if($User_data->subscribedPlan =='3-month-166' && $User_data->cancel_at == 1) Canceled @else Cancel @endif</a></span>
                                        </div>
                                        <a href="{{route('stripe.subscription',[
                                            'id' => General::encrypt(UserAuth::getLoginId()),
                                            'planname' => 'three-month',
                                        ] )}}" class="btn pricing-btn-outline mb-3 hvr">@if($User_data->subscribedPlan =='3-month-166') Current Plan @else Order Now @endif</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4 mb-2">
                                <div class="card card-pricing text-center px-0 mb-4 shadow-sm @if($User_data->subscribedPlan =='6-month-333')card-selected @endif">
                                    <span class="h5 w-60 mx-auto px-4 py-1 rounded-bottom bg-yellow shadow-sm">Six Months</span>
                                    <small class="current-text">@if($User_data->subscribedPlan =='6-month-333') Currently this plan is active @else Choose this plan @endif</small>
                                    <div class="bg-transparent card-header pt-4 border-0 px-0">
                                        <h2 class="h2 fw-bold text-center mb-0" data-pricing-value="60">$<span class="price">333</span><span class="h6 ml-1">/ every six months</span></h2>
                                    </div>
                                    <div class="card-body pb-0">
                                        <ul class="list-unstyled mb-4">
                                            <li>40 feature posts</li>
                                        </ul>
                                        <div class="selection-frame py-2 mb-2">
                                            <!-- <button type="button" class="btn btn-lg btn-toggle active" data-toggle="button" aria-pressed="true" autocomplete="Repost">
                                                <div class="handle"></div>
                                            </button> -->
                                            <label class="custom-toggle">
                                                <span>Repost</span> &nbsp;&nbsp;
                                                <input type="checkbox" name="paymentType" value="true" {{ $User_data->payment_type == 'Automatic'? 'checked' : '' }}> &nbsp;&nbsp;<span> Auto repost</span>
                                            </label>
                                        </div>
                                        <div class="cancel-frame pb-2 mb-2">
                                            <span class="cancel-text">Would you like to cancel the current plan?</span>
                                            <span class="cancel-box1"><a href="#" data-link="{{route('subscription.cancel',['id'=>UserAuth::getLoginId(),'planname' =>'six-month'])}}" class="btn cancel-button cancelBtn">@if($User_data->subscribedPlan =='6-month-333' && $User_data->cancel_at == 1) Canceled @else Cancel @endif</a></span>
                                        </div>
                                        <a href="{{route('stripe.subscription',[
                                            'id' => General::encrypt(UserAuth::getLoginId()),
                                            'planname' => 'six-month',
                                        ] )}}" class="btn pricing-btn-outline mb-3 hvr">@if($User_data->subscribedPlan =='6-month-333') Current Plan @else Order Now @endif</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4 mb-2">
                                <div class="card card-pricing text-center px-0 mb-4 shadow-sm @if($User_data->subscribedPlan =='1-year-777')card-selected @endif" >
                                    <span class="h5 w-60 mx-auto px-4 py-1 rounded-bottom bg-yellow shadow-sm">Yearly</span>
                                    <small class="current-text">@if($User_data->subscribedPlan =='1-year-777') Currently this plan is active @else Choose this plan @endif</small>
                                    <div class="bg-transparent card-header pt-4 border-0 px-0">
                                        <h2 class="h2 fw-bold text-center mb-0" data-pricing-value="60">$<span class="price">777</span><span class="h6 ml-1">/ yearly</span></h2>
                                    </div>
                                    <div class="card-body pb-0">
                                        <ul class="list-unstyled mb-4">
                                            <li>100 feature posts</li>
                                            <!-- <li>Basic support</li>
                                            <li>Monthly updates</li>
                                            <li>Free cancelation</li> -->
                                        </ul>
                                        <div class="selection-frame py-2 mb-2">
                                           <!--  <button type="button" class="btn btn-lg btn-toggle active" data-toggle="button" aria-pressed="true" autocomplete="Repost">
                                                <div class="handle"></div>
                                            </button> -->

                                            <label class="custom-toggle">
                                                <span>Repost</span> &nbsp;&nbsp;
                                                <input type="checkbox" name="paymentType" value="true" {{ $User_data->payment_type == 'Automatic'? 'checked' : '' }}> &nbsp;&nbsp;<span> Auto repost</span>
                                            </label>
                                        </div>
                                        <div class="cancel-frame pb-2 mb-2">
                                            <span class="cancel-text">Would you like to cancel the current plan?</span>
                                            <span class="cancel-box1"><a href="#"  data-link="{{route('subscription.cancel',['id'=>UserAuth::getLoginId(),'planname' =>'year'])}}" class="btn cancel-button cancelBtn">@if($User_data->subscribedPlan =='1-year-777' && $User_data->cancel_at == 1) Canceled @else Cancel @endif</a></span>
                                        </div>
                                        <a href="{{route('stripe.subscription',[
                                            'id' => General::encrypt(UserAuth::getLoginId()),
                                            'planname' => 'year',
                                        ] )}}" class="btn pricing-btn-outline mb-3 hvr">@if($User_data->subscribedPlan =='1-year-777') Current Plan @else Order Now @endif</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="tab-pane fade" id="nav-annual" role="tabpanel" aria-labelledby="nav-annual-tab">
                <div class="row pricing">
                    <div class="col-md-6 col-lg-2 mb-4">
                        <div class="card card-pricing text-center px-3 mb-4 shadow-sm">
                            <span class="h5 w-60 mx-auto px-4 py-1 rounded-bottom bg-yellow shadow-sm">Starter</span>
                            <div class="bg-transparent card-header pt-4 border-0">
                                <h2 class="h2 fw-bold text-center mb-0" data-pricing-value="15">$<span class="price">12</span><span class="h6 ml-2">/ per annum</span></h2>
                            </div>
                            <div class="card-body pb-0">
                                <ul class="list-unstyled mb-4">
                                    <li>Up to 5 users</li>
                                    <li>Basic support</li>
                                    <li>Monthly updates</li>
                                    <li>Free cancelation</li>
                                </ul>
                                <button type="button" class="btn pricing-btn-outline mb-3 hvr">Order now</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-2 mb-4">
                        <div class="card card-pricing popular shadow-sm text-center px-3 mb-4">
                            <span class="h5 w-60 mx-auto px-4 py-1 rounded-bottom bg-yellow shadow-sm">Professional</span>
                            <div class="bg-transparent card-header pt-4 border-0">
                                <h2 class="h2 fw-bold text-center mb-0" data-pricing-value="30">$<span class="price">16</span><span class="h6 text-muted ml-2">/ per annum</span></h2>
                            </div>
                            <div class="card-body pb-0">
                                <ul class="list-unstyled mb-4">
                                    <li>Up to 10 users</li>
                                    <li>Email Support support</li>
                                    <li>Monthly updates</li>
                                    <li>Free cancelation</li>
                                </ul>
                                <a href="#" target="_blank" class="btn pricing-btn mb-3">Order Now</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-2 mb-4">
                        <div class="card card-pricing text-center px-3 mb-4 shadow-sm">
                            <span class="h5 w-60 mx-auto px-4 py-1 rounded-bottom bg-yellow shadow-sm">Business</span>
                            <div class="bg-transparent card-header pt-4 border-0">
                                <h2 class="h2 fw-bold text-center mb-0" data-pricing-value="45">$<span class="price">19</span><span class="h6 text-muted ml-2">/ per annum</span></h2>
                            </div>
                            <div class="card-body pb-0">
                                <ul class="list-unstyled mb-4">
                                    <li>Up to 15 users</li>
                                    <li>Email & phone support</li>
                                    <li>Monthly updates</li>
                                    <li>Free cancelation</li>
                                </ul>
                                <button type="button" class="btn pricing-btn-outline mb-3 hvr">Order now</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-2 mb-4">
                        <div class="card card-pricing text-center px-3 mb-4 shadow-sm">
                            <span class="h5 w-60 mx-auto px-4 py-1 rounded-bottom bg-yellow shadow-sm">Enterprise</span>
                            <div class="bg-transparent card-header pt-4 border-0">
                                <h2 class="h2 fw-bold text-center mb-0" data-pricing-value="60">$<span class="price">21</span><span class="h6 text-muted ml-2">/ per annum</span></h2>
                            </div>
                            <div class="card-body pb-0">
                                <ul class="list-unstyled mb-4">
                                    <li>Up to 20 users</li>
                                    <li>Basic support</li>
                                    <li>Monthly updates</li>
                                    <li>Free cancelation</li>
                                </ul>
                                <button type="button" class="btn pricing-btn-outline mb-3 hvr">Order now</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
   </div>
</div>

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
            text: 'Are you sure you want to cancel? At anytime you cancel your subscription, the golden star badge comes off your profile. Your post will still be up for the remainder of the time you paid, unless you decide to delete it before then. Your post will be removed from the homepage and placed under the free popular post section. There will be no refunds for feature subscriptions as stated in the email you received when first purchased. Thank you for understanding.',
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'No',
            confirmButtonColor: '#fcd152',
            cancelButtonColor: '#1a202e',
            confirmButtonText: 'Yes, Cancel!',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = link;
            }
        });
    });
</script>
@endsection