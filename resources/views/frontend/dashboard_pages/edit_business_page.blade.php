@extends('layouts.user_dashboard.userdashboardlayout')
@section('content')
<?php
$cleanString = function ($value) {
  // Remove unwanted characters like '[' ']', '\"'
  return preg_replace('/[\[\]"]/', '', stripslashes(trim($value)));
  
};
// dd($business);
$address_1 = explode(',', $business->address_1);
$address_2 = explode(',', $business->address_2);
$country = explode(',', $business->country);
$state = explode(',', $business->state);
$city = explode(',', $business->city);
$zip_code = explode(',', $business->zip_code);
$location = explode(',', $business->location);

$all_address = [
    'address_1' => $address_1,
    'address_2' => $address_2,
    'country' => $country,
    'city' => $city,
    'state' => $state,
    'zip_code' => $zip_code,
    'location' => $location,
];
// dd($all_address);
// Initialize an empty array to hold all addresses
$all_addresses = [];

// Loop through each index (assuming all arrays have the same length)
$max_count = max(array_map('count', $all_address));

for ($i = 0; $i < $max_count; $i++) {
      $all_addresses[] = [
        'address_1' => isset($all_address['address_1'][$i]) ? $cleanString($all_address['address_1'][$i]) : '',
        'address_2' => isset($all_address['address_2'][$i]) ? $cleanString($all_address['address_2'][$i]) : '',
        'country'   => isset($all_address['country'][$i]) ? $cleanString($all_address['country'][$i]) : '',
        'state'     => isset($all_address['state'][$i]) ? $cleanString($all_address['state'][$i]) : '',
        'city'      => isset($all_address['city'][$i]) ? $cleanString($all_address['city'][$i]) : '',
        'zip_code'  => isset($all_address['zip_code'][$i]) ? $cleanString($all_address['zip_code'][$i]) : '',
        'location'  => isset($all_address['location'][$i]) ? $cleanString($all_address['location'][$i]) : '',
    ];

}

// Debug output
  // dd($all_addresses);
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
<?php
// dd($open_24);
    $data = []; 
    foreach ($status as $day => $day_status) {
        if ($day_status === 'on') {
            $open = $open_time[$day] ?? null;  // If open_time is null, it assigns null
            $close = $close_time[$day] ?? null; // If close_time is null, it assigns null
    
            // Check if both open and close times are null (indicating 24-hour operation)
            if (is_null($open) && is_null($close)) {
                $data[$day] = ucfirst($day) . ": 24 hours open";
            } else {
                // If not 24 hours, format the open and close times
                $data[$day] = ucfirst($day) . ": " . date("h:i a", strtotime($open)) . " - " . date("h:i a", strtotime($close));
            }
        } else {
            unset($data[$day]); // Remove the element from $data if $day_status is not 'on'
        }
    }
    


    // dd($data);

?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
<style>
.manage_section {display: flex;justify-content: space-between;}
.manage_section {display: flex;justify-content: space-between;}
.day {display: flex; align-items: center; margin-bottom: 15px; justify-content: center; gap: 5px;}
.day label {flex: 1;}
.day input[type="checkbox"] {margin-right: 5px;}
.days-col{display: flex;}
.time {display: flex;flex: 2;}
.time input[type="time"] {margin-right: 5px;color:#000;font-size: 12px!important; width: 85px;}
.open-24{display: flex; padding-left: 15px;}
.days-col, .time, .open-24{width: 30%;}
.days-col label, .open-24 label{font-size: 13px!important;}
.add-time {margin-left: 5px;}
.closed {display: flex;align-items: center;margin-bottom: 10px;}
.closed input[type="checkbox"] {margin-right: 10px;}
.buttons {text-align: center;}
.buttons button {margin: 5px;}
.active_btn {
  background: linear-gradient(90deg, rgba(220, 114, 40, 1) 70%, #a54db7 100%);
  color: #fff!important;
}
.stepwizard-row {
    display: table-row;
}
  .stepwizard-step p {
    margin-top: 10px;
}
.stepwizard-row {
    display: table-row;
}
.active_btn {
  background: linear-gradient(90deg, rgba(220, 114, 40, 1) 70%, #a54db7 100%);
  color: #fff!important;
}
.stepwizard {
    display: table;
    width: 100%;
    position: relative;
    visibility: hidden;
    display: none;
}
.stepwizard-step button[disabled] {
    opacity: 1 !important;
    filter: alpha(opacity=100) !important;
}
.stepwizard-row:before {
    top: 14px;
    bottom: 0;
    position: absolute;
    content: " ";
    width: 100%;
    height: 1px;
    background-color: #ccc;
    z-order: 0;
}
.stepwizard-step {
    display: table-cell;
    text-align: center;
    position: relative;
}
.btn-circle {
    width: 30px;
    height: 30px;
    text-align: center;
    padding: 6px 0;
    font-size: 12px;
    line-height: 1.428571429;
    border-radius: 15px;
}

.day-txt{font-weight: 600;}
.tp-start-time,
.tp-end-time{
  color: #976802;
  cursor: pointer;
  display: inline-block;
  transition: all ease-out 0.3s;
}

.tp-start-time:hover,
.tp-end-time:hover{
  transform: scale(1.2);
  text-shadow: 0 0 0 #976802;
  
}

/* timePicker.css */
#tp-modal.modal.fade .modal-dialog{transform: translate(0, 100%);}
#tp-modal .modal-footer{
  border: none;
}

#tp-modal .modal-header, #tp-modal .modal-footer{
  border: none;
  justify-content: center;
}
#tp-modal .modal-header h4{font-weight: 600; font-size: 20px;}
#tp-time-cont{
  display: flex;
  text-align: center;
  background: white;
  position: relative;
  align-items: stretch;
}

#tp-colon{
  display: flex;
  justify-content: center;
  align-items: center;
}

#tp-time-cont button{
  border: none;
  background: transparent;
  height: auto;
  padding: 0.5rem;
  display: flex;
  justify-content: center;
  align-items: center;
  cursor: pointer;
  outline: none!important;
  transition: all ease-out 0.3s;
}

#tp-hour-cont,
#tp-minutes-cont{
  flex-grow: 1;
}

#tp-time-cont button:hover{
  transform: scale(1.3);
  color: #976802;
}

.tp-value{
  font-size: 2rem;
  line-height: 2rem;
}

#tp-set-btn{
  background: #976802;
  border-color: #976802;
  padding: 4px 8px;
  font-size: 14px;
}
#tp-cancel-btn{padding: 4px 8px;font-size: 14px;}

.review-frame .rating {
  display: flex;
  align-items: center;
  grid-gap: .5rem;
  font-size: 2rem;
  color: #fbc743;
  margin-bottom: 2rem;
}
.review-frame .rating .star {
  cursor: pointer;
}
.review-frame .rating .star.active {
  opacity: 0;
  animation: animate .5s calc(var(--i) * .1s) ease-in-out forwards;
}

.inner-sidebar a {background-color: #000 !important; border-radius: 4px !important;}
.inner-sidebar .nav-link.active {
background-color: #dc7228 !important;
color: white !important;
}


@keyframes animate {
  0% {
    opacity: 0;
    transform: scale(1);
  }
  50% {
    opacity: 1;
    transform: scale(1.2);
  }
  100% {
    opacity: 1;
    transform: scale(1);
  }
}


.review-frame .rating .star:hover {
  transform: scale(1.1);
}
textarea{border: 1px solid #bdbdbd!important;}
.review-frame textarea {
  width: 100%;
  background: #f5f5f5;
  padding: 1rem;
  border-radius: .5rem;
  outline: none;
  resize: none;
  margin-bottom: .5rem;
}


.form-container {
  display: flex;
    justify-content: center;
  align-items: center;
  margin-bottom: 20px;
}
.upload-files-container {
  background-color: #f7fff7;
  width: 100%;
  padding: 20px;
  border-radius: 10px;
  display: flex;
    align-items: center;
    justify-content: center;
  flex-direction: column;
/*  box-shadow: rgba(0, 0, 0, 0.24) 0px 10px 20px, rgba(0, 0, 0, 0.28) 0px 6px 6px;*/
}
.drag-file-area {
  border: 2px dashed #976802;
  border-radius: 10px;
  margin: 10px 0 15px;
  padding: 30px 50px;
  width: 100%;
  text-align: center;
}
.drag-file-area .upload-icon {
  font-size: 30px;
}
.drag-file-area h3 {
  font-size: 20px;
  margin: 15px 0;
}
.drag-file-area label {
  font-size: 19px;
}
.drag-file-area label .browse-files-text {
  color: #976802;
  font-weight: bolder;
  cursor: pointer;
}
.browse-files span {
  position: relative;
  top: 0px;
}
.default-file-input {
  opacity: 0;
  display: none;
}
.cannot-upload-message {
  background-color: #ffc6c4;
  font-size: 17px;
  display: flex;
  align-items: center;
  margin: 5px 0;
  padding: 5px 10px 5px 30px;
  border-radius: 5px;
  color: #BB0000;
  display: none;
}
@keyframes fadeIn {
  0% {opacity: 0;}
  100% {opacity: 1;}
}
.cannot-upload-message span, .upload-button-icon {
  padding-right: 10px;
}
.cannot-upload-message span:last-child {
  padding-left: 20px;
  cursor: pointer;
}
.file-block {
  color: #f7fff7;
  background-color: #976802;
    transition: all 1s;
  width: 100%;
  position: relative;
  display: none;
  flex-direction: row;
  justify-content: space-between;
  align-items: center;
  margin: 10px 0 15px;
  padding: 10px 20px;
  border-radius: 5px;
  cursor: pointer;
}
.file-info {
  display: flex;
  align-items: center;
  font-size: 15px;
}
.file-icon {
  margin-right: 10px;
}
.file-name, .file-size {
  padding: 0 3px;
}
.remove-file-icon {
  cursor: pointer;
}
.form-container .progress-bar {
  display: flex;
  position: absolute;
  bottom: 0;
  left: 4.5%;
  width: 0;
  height: 5px;
  border-radius: 25px;
  background-color: #4BB543;
}
.upload-button {
  background-color: #976802;
  color: #f7fff7;
  display: flex;
  align-items: center;
  font-size: 18px;
  border: none;
  border-radius: 5px;
  margin: 10px;
  padding: 7.5px 50px;
  cursor: pointer;
}

#link-section {
    overflow-x: auto;
    white-space: nowrap;
    padding: 10px;
}

#link-section a {
    border: 1px solid;
    border-radius: 50px;
    background-color: #fff;
    padding: 3px 6px;
    display: inline-block;
    margin-right: 10px;
    text-decoration: none;
    color: #000;
}

#link-section a:hover {
    background-color: #dcdcdc;
}

#input-section {
    display: flex;
    flex-wrap: wrap;
}

.checkbox-label {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin: 10px;
}

.checkbox-label input[type="checkbox"] {
    margin-left: 10px;
}

.link-input {
    display: none;
    margin: 5px;
    flex: 1 1 auto;
}

.d-none {
    display: none;
}
.order_online_sec{
  gap: 10px;
  justify-content: space-between;
  align-items: center;
}
@media only screen and (max-width:767px){
/*.time {width: 100%;flex: 2;}*/
.day label {font-size:12px;}
.day input[type="checkbox"] {margin-right: 2px;}
.time input[type="time"] { margin-right: 5px;font-size:12px;} 
.container {padding-bottom: 50px !important;}
.day{align-items: flex-start;}
.days-col {flex-direction: column;}
.time{flex-direction: column; gap: 5px;}
.open-24 {flex-direction: column;padding-left: 20px;}
}

@media only screen and (max-width:360px){
/*.time {width: 100%;flex: 2;}*/
/* .day{flex-wrap:wrap;} */
.day{margin-bottom:10px;}
.day label {font-size:11px;}
/*.day input[type="checkbox"] {margin-right: 2px; width:20px; height:10px;}*/
/* input[type="checkbox"]::before {width: 10px;height: 10px;} */
.time input[type="time"] { margin-right: 5px;font-size:11px;} 
}
@media only screen and (max-width:300px){
#exampleModal_hours .modal-body {padding: 1rem 3px};
/*.day input[type="checkbox"] {margin-right: 2px; width:20px; height:10px;};*/
/* input[type="checkbox"]::before {width: 10px;height: 10px;}; */
.day{margin-bottom:10px;}
} 
</style>


  <div class="container-fluid px-md-3 px-lg-5">

  <!-- <img src="https://finderspage.com/public/front/images/coming-soon.png" alt="coming-soon.png" class="img-fluid w-100"> -->
   
    <div class="d-sm-flex flex-column  mb-3">
      <h1 class="h3 mb-0 text-gray-800 fw-bold">Edit a Business Page </h1>
      <p>Choose the best category that fits your needs and create a business page</p>
    </div>
    <span>
            @include('admin.partials.flash_messages')
        </span>
     <div class="row">
      <div class="col-12 d-flex justify-content-center">
      <div class="nav d-flex justify-content-center flex-wrap nav-pills inner-sidebar" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <a class="nav-link active mx-3 mb-3" id="v-pills-info-tab" data-toggle="pill" href="#v-pills-info" role="tab" aria-controls="v-pills-info" aria-selected="true"><i class="fas fa-info-circle"></i> <span> Business Info</span></a>
            
            <a class="nav-link mx-3 mb-3" id="v-pills-shop-tab" data-toggle="pill" href="#v-pills-shop" role="tab" aria-controls="v-pills-shop" aria-selected="false"><i class="fa fa-store"></i> <span>Shop</span></a>
            <a class="nav-link mx-3 mb-3" id="v-pills-deals-tab" data-toggle="pill" href="#v-pills-deals" role="tab" aria-controls="v-pills-deals" aria-selected="false"><i class="fas fa-handshake"></i> <span>Special Deals</span></a>
          </div>
      </div>
      <!-- <div class="col-lg-3 col-md-3 mb-3">
          
      </div> -->
      <div class="col-lg-9 col-md-9 mb-3 mx-auto">
        <div class="tab-content" id="v-pills-tabContent">
          <div class="tab-pane fade show active" id="v-pills-info" role="tabpanel" aria-labelledby="v-pills-info-tab">
            <div class=" bg-white border pb-4 p-3 mx-md-2">
              <div class="stepwizard">
                <div class="stepwizard-row setup-panel">
                  <div class="stepwizard-step">
                    <a href="#step-1" type="button" class="btn btn-primary btn-circle">1</a>
                    <p>Step 1</p>
                  </div>
                  <div class="stepwizard-step">
                    <a href="#step-2" type="button" class="btn btn-default btn-circle" disabled="disabled">2</a>
                    <p>Step 2</p>
                  </div>
                  <div class="stepwizard-step">
                    <a href="#step-3" type="button" class="btn btn-default btn-circle" disabled="disabled">3</a>
                    <p>Step 3</p>
                  </div>
                  <div class="stepwizard-step">
                    <a href="#step-4" type="button" class="btn btn-default btn-circle" disabled="disabled">4</a>
                    <p>Step 4</p>
                  </div>
                  <div class="stepwizard-step">
                    <a href="#step-5" type="button" class="btn btn-default btn-circle" disabled="disabled">5</a>
                    <p>Step 5</p>
                  </div>
                  <div class="stepwizard-step">
                    <a href="#step-6" type="button" class="btn btn-default btn-circle" disabled="disabled">6</a>
                    <p>Step 6</p>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <form role="form" id="businessForm" action="{{route('business_page.update',$business->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="category" value="1" >
                    <div class="row setup-content" id="step-1">
                        <div class="col-md-12">
                          <h4 class="fw-bold">Let’s start with your Business Details</h4>
                          <p>You can add your business details so that we can help you claim your Business Page.</p>
                          <div class="form-group">
                            <label class="control-label">Business Name</label>
                            <input type="text" class="form-control" name="business_name" placeholder="Enter Business Name" value="{{$business->business_name}}" required>
                          </div>
                          <div class="form-group">
                            <label class="control-label">Business Type (Sub Categories)</label>
                            <select class="form-control-xs selectpicker" name="sub_category[]" multiple data-size="7" data-live-search="true" data-title="Sub categories" id="sub_category" data-width="100%">
                            <?php
                                $sub_cateArray = explode(",",$business->sub_category);
                            ?>
                            @foreach($categories as $cate)
                            <option data-tokens="{{$cate->title}}" {{ in_array($cate->id, $sub_cateArray) ? 'selected' : '' }} value="{{$cate->id}}">{{$cate->title}}</option>
                            @endforeach
                            <option class="Other-cate" value="Other">Other</option>
                            </select>
                            <input type="text" class="form-control d-none mt-2" id="Other-cate-input" name="sub_category_oth" placeholder="Sub category name" value="">
                          </div>

                          {{-- <div class="form-group">
                           <label class="control-label">Add a Button</label>
                           <select class="form-control" name="add_button" required>
                             <option {{ $business->add_button == "Order Online" ? 'selected' : '' }} value="Order Online">Order Online</option>
                             <option {{ $business->add_button == "Book" ? 'selected' : '' }} value="Book">Book</option>
                             <option {{ $business->add_button == "Purchase" ? 'selected' : '' }} value="Purchase">Purchase</option>
                             <option {{ $business->add_button == "Learn Mor" ? 'selected' : '' }} value="Learn More">Learn More</option>
                             <option {{ $business->add_button == "Reserve" ? 'selected' : '' }} value="Reserve">Reserve </option>
                             <option {{ $business->add_button == "Gift Cards" ? 'selected' : '' }} value="Gift Cards">Gift Cards</option>
                             <option {{ $business->add_button == "Shop Now" ? 'selected' : '' }} value="Shop Now">Shop Now</option>
                             <option {{ $business->add_button == "Watch Video" ? 'selected' : '' }} value="Watch Video">Watch Video</option>
                         </select>
                         </div> --}}

                         <label for="toggleCheckbox" class="checkbox-label">
                          Add a button
                          <input type="checkbox" {{ $business->add_button == 'on' ? 'checked' : '' }} name="add_button" id="toggleCheckbox">
                        </label>
                  

                      <div id="link-section" class="d-none">
                        <a href="#order_online" data-button="{{$business->selected_button}}"  class="{{ $business->selected_button === 'order_online' ? 'active_btn' : '' }}" data-target="#order_online">Order Online</a>
                        <a href="#book" data-target="#book" class="{{ $business->selected_button === 'book' ? 'active_btn' : '' }}">Book</a>
                        <a href="#purchase" data-target="#purchase" class="{{ $business->selected_button === 'purchase' ? 'active_btn' : '' }}">Purchase</a>
                        <a href="#learn_more" data-target="#learn_more" class="{{ $business->selected_button == 'learn_more' ? 'active_btn' : '' }}">Learn more</a>
                        <a href="#order_food" data-target="#order_food" class="{{ $business->selected_button == 'order_food' ? 'active_btn' : '' }}">Order food</a>
                        <a href="#reserve" data-target="#reserve" class="{{ $business->selected_button == 'reserve' ? 'active_btn' : '' }}">Reserve</a>
                        <a href="#gift_cards" data-target="#gift_cards" class="{{ $business->selected_button == 'gift_cards' ? 'active_btn' : '' }}">Gift cards</a>
                        <a href="#contact_us" data-target="#contact_us" class="{{ $business->selected_button == 'contact_us' ? 'active_btn' : '' }}">Contact us</a>
                        <a href="#shop_now" data-target="#shop_now" class="{{ $business->selected_button == 'shop_now' ? 'active_btn' : '' }}">Shop now</a>
                        <a href="#watch_video" data-target="#watch_video" class="{{ $business->selected_button == 'watch_video' ? 'active_btn' : '' }}">Watch video</a>
                        <a href="#sign_up" data-target="#sign_up" class="{{ $business->selected_button == 'sign_up' ? 'active_btn' : '' }}">Sign up</a>
                        <a href="#send_email" data-target="#send_email" class="{{ $business->selected_button == 'send_email' ? 'active_btn' : '' }}">Send email</a>
                        <a href="#whats_app" data-target="#whats_app" class="{{ $business->selected_button == 'whats_app' ? 'active_btn' : '' }}">Whats app</a>
                        <a href="#follow" data-target="#follow" class="{{ $business->selected_button == 'follow' ? 'active_btn' : '' }}">Follow</a>
                        <a href="#start_order" data-target="#start_order" class="{{ $business->selected_button == 'start_order' ? 'active_btn' : '' }}">Start order</a>
                        <a href="#join" data-target="#join" class="{{ $business->selected_button == 'join' ? 'active_btn' : '' }}">Join</a>
                      </div>

                      <div id="input-section">
                          <?php
                            $Url_array = explode(",",$business->selected_button_url);
                            
                          ?>
                      <div class="link-input" id="order_online">
                                <div class="input_wrapper d-flex order_online_sec">
                                  @foreach($Url_array as $url)
                                    <input type="text" name="order_online[]" class="form-control" style="width:90%;" placeholder="Enter a link" value="{{$url}}">
                                  @endforeach
                                    <span class="add_btn"><i class="fa fa-plus" aria-hidden="true"></i></span>
                                </div>
                            </div>
                       


                        <input type="text" name="book[]" id="book" class="form-control link-input" placeholder="Enter a link" value="{{$business->selected_button_url}}">
                        <input type="text" name="purchase[]" id="purchase" class="form-control link-input" placeholder="Enter a link" value="{{$business->selected_button_url}}">
                        <input type="text" name="learn_more[]" id="learn_more" class="form-control link-input" placeholder="Enter a link " value="{{$business->selected_button_url}}">

                        <div class="link-input" id="order_food">
                            <div class="input_wrapper_food d-flex order_online_sec">
                              @foreach($Url_array as $url)
                                <input type="text" name="order_food[]" class="form-control" style="width:90%;" placeholder="Enter a link" value="{{$business->selected_button_url}}">
                              @endforeach
                                <span class="add_btn_food"><i class="fa fa-plus" aria-hidden="true"></i></span>
                            </div>
                        </div>
                        
                        <input type="text" name="reserve[]" id="reserve" class="form-control link-input" placeholder="Enter a link" value="{{$business->selected_button_url}}">
                        <input type="text" name="gift_cards[]" id="gift_cards" class="form-control link-input" placeholder="Enter a link " value="{{$business->selected_button_url}}">
                        <input type="text" name="contact_us[]" id="contact_us" class="form-control link-input" placeholder="Enter a link" value="{{$business->selected_button_url}}">
                        <input type="text" name="shop_now[]" id="shop_now" class="form-control link-input" placeholder="Enter a link" value="{{$business->selected_button_url}}">
                        <input type="text" name="watch_video[]" id="watch_video" class="form-control link-input" placeholder="Enter a link"value="{{$business->selected_button_url}}">
                        <input type="text" name="sign_up[]" id="sign_up" class="form-control link-input" placeholder="Enter a link"value="{{$business->selected_button_url}}">
                        <input type="text" name="send_email[]" id="send_email" class="form-control link-input" placeholder="Enter a link" value="{{$business->selected_button_url}}">
                        <input type="text" name="whats_app[]" id="whats_app" class="form-control link-input" placeholder="Enter a link"value="{{$business->selected_button_url}}">
                        <input type="text" name="follow[]" id="follow" class="form-control link-input" placeholder="Enter a link"value="{{$business->selected_button_url}}">
                        <input type="text" name="start_order[]" id="start_order" class="form-control link-input" placeholder="Enter a link"value="{{$business->selected_button_url}}">
                        <input type="text" name="join[]" id="join" class="form-control link-input" placeholder="Enter a link"value="{{$business->selected_button_url}}">
                      </div>
                         
                         <?php
                            $benefitsArray = explode(",", $business->choice);
                            //  echo "<pre>";print_r($business->choices);die();
                            ?>
                         <div class="form-group">
                          
                           <label class="control-label">Choose Your Choice</label>
                           <select class="form-control" name="choices[]" id="choices-multiple-remove-button" multiple="multiple" required>
                              <option value="Access" {{ in_array('Access', $benefitsArray) ? 'selected' : '' }}>Access</option>
                              <option value="Accessible Restroom and Accessible Seating" {{ in_array('Accessible Restroom and Accessible Seating', $benefitsArray) ? 'selected' : '' }}>Accessible restroom and accessible seating</option>
                              <option value="Accessible parking near entrance" {{ in_array('Accessible parking near entrance', $benefitsArray) ? 'selected' : '' }}>Accessible parking near entrance</option>
                              <option value="Accepts Cash" {{ in_array('Accepts Cash', $benefitsArray) ? 'selected' : '' }}>Accepts Cash</option>
                              <option value="Accepts Credit Cards" {{ in_array('Accepts Credit Cards', $benefitsArray) ? 'selected' : '' }}>Accepts Credit Cards</option>
                              <option value="Accepts Insurance" {{ in_array('Accepts Insurance', $benefitsArray) ? 'selected' : '' }}>Accepts Insurance</option>
                              <option value="Breakfast" {{ in_array('Breakfast', $benefitsArray) ? 'selected' : '' }}>Breakfast</option>
                              <option value="Brunch" {{ in_array('Brunch', $benefitsArray) ? 'selected' : '' }}>Brunch</option>
                              <option value="Bike Parking" {{ in_array('Bike Parking', $benefitsArray) ? 'selected' : '' }}>Bike Parking</option>
                              <option value="Beer and Wine" {{ in_array('Beer and Wine', $benefitsArray) ? 'selected' : '' }}>Beer and wine</option>
                              <option value="By Appointment Only" {{ in_array('By Appointment Only', $benefitsArray) ? 'selected' : '' }}>By Appointment Only</option>
                              <option value="Catering" {{ in_array('Catering', $benefitsArray) ? 'selected' : '' }}>Catering</option>
                              <option value="Curbside Pickup" {{ in_array('Curbside Pickup', $benefitsArray) ? 'selected' : '' }}>Curbside pickup</option>
                              <option value="Delivery" {{ in_array('Delivery', $benefitsArray) ? 'selected' : '' }}>Delivery</option>
                              <option value="Dinner" {{ in_array('Dinner', $benefitsArray) ? 'selected' : '' }}>Dinner</option>
                              <option value="Drive Through" {{ in_array('Drive Through', $benefitsArray) ? 'selected' : '' }}>Drive through</option>
                              <option value="EV Charging Station Available" {{ in_array('EV Charging Station Available', $benefitsArray) ? 'selected' : '' }}>EV charging station available</option>
                              <option value="Good for Kids" {{ in_array('Good for Kids', $benefitsArray) ? 'selected' : '' }}>Good for kids</option>
                              <option value="Happy Hour" {{ in_array('Happy Hour', $benefitsArray) ? 'selected' : '' }}>Happy hour</option>
                              <option value="Kitchen" {{ in_array('Kitchen', $benefitsArray) ? 'selected' : '' }}>Kitchen</option>
                              <option value="Lunch" {{ in_array('Lunch', $benefitsArray) ? 'selected' : '' }}>Lunch</option>
                              <option value="No Steps or Stairs" {{ in_array('No Steps or Stairs', $benefitsArray) ? 'selected' : '' }}>No steps or stairs</option>
                              <option value="Online Service Hours" {{ in_array('Online Service Hours', $benefitsArray) ? 'selected' : '' }}>Online service hours</option>
                              <option value="Online Ordering" {{ in_array('Online Ordering', $benefitsArray) ? 'selected' : '' }}>Online ordering</option>
                              <option value="Outdoor Dining" {{ in_array('Outdoor Dining', $benefitsArray) ? 'selected' : '' }}>Outdoor dining</option>
                              <option value="Pickup" {{ in_array('Pickup', $benefitsArray) ? 'selected' : '' }}>Pickup</option>
                              <option value="Pet Friendly" {{ in_array('Pet Friendly', $benefitsArray) ? 'selected' : '' }}>Pet friendly</option>
                              {{-- <option value="Parking: Choose Valet, Garage, Street, Private Lot, Validated" {{ in_array('Parking: Choose Valet, Garage, Street, Private Lot, Validated', $benefitsArray) ? 'selected' : '' }}>Parking: Choose Valet, Garage, Street, Private Lot, Validated</option> --}}
                              <option value="Senior Hour" {{ in_array('Senior Hour', $benefitsArray) ? 'selected' : '' }}>Senior hour</option>
                              <option value="Take Out" {{ in_array('Take Out', $benefitsArray) ? 'selected' : '' }}>Take out</option>
                              <option value="Vegetarian Options" {{ in_array('Vegetarian Options', $benefitsArray) ? 'selected' : '' }}>Vegetarian options</option>
                              <option value="Rooftop Seating" {{ in_array('Rooftop Seating', $benefitsArray) ? 'selected' : '' }}>Rooftop seating</option>
                              <option value="Wifi" {{ in_array('Wifi', $benefitsArray) ? 'selected' : '' }}>Wifi</option>
                              <option value="Wheelchair Accessible" {{ in_array('Wheelchair Accessible', $benefitsArray) ? 'selected' : '' }}>Wheelchair Accessible</option>
                          </select>                        
                         </div>
                         <?php
                            $parkingArray = explode(",", $business->parking);
                            //  echo "<pre>";print_r($business->choices);die();
                            ?>
                          <div class="form-group">
                              <label class="control-label">Choose Parking</label>
                              <select class="form-control" name="parking[]" id="choices-multiple-days-button" multiple="multiple">
                                <option {{ in_array('Valet', $parkingArray) ? 'selected' : '' }} value="Valet">Valet</option>
                                <option {{ in_array('Garage', $parkingArray) ? 'selected' : '' }} value="Garage">Garage</option>
                                <option {{ in_array('Street', $parkingArray) ? 'selected' : '' }} value="Street">Street</option>
                                <option {{ in_array('Private Lot', $parkingArray) ? 'selected' : '' }} value="Private Lot">Private Lot</option>
                                <option {{ in_array('Validated', $parkingArray) ? 'selected' : '' }} value="Validated">Validated</option>
                            </select>
                        </div>



                          <div class="form-group">
                            <label class="control-label">Location of service</label>
                            <select class="form-control" name="location_of_service"  id="choices-multiple-days-location" required>
                              <option {{ $business->location_of_service == "At a practice" ? 'selected' : '' }} value="At a practice">At a practice</option>
                              <option {{ $business->location_of_service == "At my home" ? 'selected' : '' }} value="At my home">At my home</option>
                              <option {{ $business->location_of_service == "Private Lot" ? 'selected' : '' }} value="Virtual">Virtual</option>
                          </select>
                      </div>
                      <?php
                        $speak_language = explode(",", $business->speak_language);
                      //  echo "<pre>";print_r($business->choices);die();
                      ?>
                      <div class="form-group">
                      <label class="labels">Which languages do you speak? (Please choose only languages that you speak well enough to interact with customers.)</label>
                            <select class="form-control" name="speak_language[]" id="choices-multiple-remove-button" multiple="multiple">
                              <option {{ in_array('Portuguese', $speak_language) ? 'selected' : '' }}  value="Portuguese">Portuguese</option>
                              <option {{ in_array('Romanian', $speak_language) ? 'selected' : '' }} value="Romanian">Romanian</option>
                              <option {{ in_array('Russian', $speak_language) ? 'selected' : '' }} value="Russian">Russian</option>
                              <option {{ in_array('Spanish', $speak_language) ? 'selected' : '' }} value="Spanish">Spanish</option>
                              <option {{ in_array('Swedish', $speak_language) ? 'selected' : '' }} value="Swedish ">Swedish </option>
                              <option {{ in_array('Turkish', $speak_language) ? 'selected' : '' }} value="Turkish">Turkish</option>
                              <option {{ in_array('Afrikaans', $speak_language) ? 'selected' : '' }} value="Afrikaans">Afrikaans</option>
                              <option {{ in_array('Arabic', $speak_language) ? 'selected' : '' }} value="Arabic">Arabic</option>
                              <option {{ in_array('Czech', $speak_language) ? 'selected' : '' }} value="Czech">Czech</option>
                              <option {{ in_array('English', $speak_language) ? 'selected' : '' }} value="English">English</option>
                              <option {{ in_array('Estonian', $speak_language) ? 'selected' : '' }} value="Estonian">Estonian</option>
                              <option {{ in_array('Finnish', $speak_language) ? 'selected' : '' }} value="Finnish ">Finnish </option>
                              <option {{ in_array('French', $speak_language) ? 'selected' : '' }} value="French">French</option>
                              <option {{ in_array('German', $speak_language) ? 'selected' : '' }} value="German">German</option>
                              <option {{ in_array('Greek', $speak_language) ? 'selected' : '' }} value="Greek">Greek</option>
                              <option {{ in_array('Hebrew', $speak_language) ? 'selected' : '' }} value="Hebrew">Hebrew</option>
                              <option {{ in_array('Hungarian', $speak_language) ? 'selected' : '' }} value="Hungarian">Hungarian</option>
                              <option {{ in_array('Italian', $speak_language) ? 'selected' : '' }} value="Italian">Italian</option>
                              <option {{ in_array('Japanese', $speak_language) ? 'selected' : '' }} value="Japanese ">Japanese </option>
                              <option {{ in_array('Norwegian', $speak_language) ? 'selected' : '' }} value="Norwegian">Norwegian</option>
                              <option {{ in_array('Polish', $speak_language) ? 'selected' : '' }} value="Polish">Polish</option>
                          </select>
                      </div>


                      <div class="form-group">
                        <label>Explore holistic services</label>
                        <select class="form-control" name="holistic_services" id="therapy_options">
                            <option value="Access Consciousness" {{ $business->holistic_services == 'Access Consciousness' ? 'selected' : '' }}>Access Consciousness</option>
                            <option value="Acupuncture" {{ $business->holistic_services == 'Acupuncture' ? 'selected' : '' }}>Acupuncture</option>
                            <option value="Animal Wellness" {{ $business->holistic_services == 'Animal Wellness' ? 'selected' : '' }}>Animal Wellness</option>
                            <option value="Art Therapy" {{ $business->holistic_services == 'Art Therapy' ? 'selected' : '' }}>Art Therapy</option>
                            <option value="Ayurveda" {{ $business->holistic_services == 'Ayurveda' ? 'selected' : '' }}>Ayurveda</option>
                            <option value="Biofeedback" {{ $business->holistic_services == 'Biofeedback' ? 'selected' : '' }}>Biofeedback</option>
                            <option value="Body Code" {{ $business->holistic_services == 'Body Code' ? 'selected' : '' }}>Body Code</option>
                            <option value="BodyTalk" {{ $business->holistic_services == 'BodyTalk' ? 'selected' : '' }}>BodyTalk</option>
                            <option value="Bodywork" {{ $business->holistic_services == 'Bodywork' ? 'selected' : '' }}>Bodywork</option>
                            <option value="Breathwork" {{ $business->holistic_services == 'Breathwork' ? 'selected' : '' }}>Breathwork</option>
                            <option value="Chiropractic" {{ $business->holistic_services == 'Chiropractic' ? 'selected' : '' }}>Chiropractic</option>
                            <option value="Colon Hydrotherapy" {{ $business->holistic_services == 'Colon Hydrotherapy' ? 'selected' : '' }}>Colon Hydrotherapy</option>
                            <option value="Counseling" {{ $business->holistic_services == 'Counseling' ? 'selected' : '' }}>Counseling</option>
                            <option value="Couples Counseling" {{ $business->holistic_services == 'Couples Counseling' ? 'selected' : '' }}>Couples Counseling</option>
                            <option value="Craniosacral Therapy" {{ $business->holistic_services == 'Craniosacral Therapy' ? 'selected' : '' }}>Craniosacral Therapy</option>
                            <option value="EMDR" {{ $business->holistic_services == 'EMDR' ? 'selected' : '' }}>EMDR</option>
                            <option value="Emotional Freedom Technique" {{ $business->holistic_services == 'Emotional Freedom Technique' ? 'selected' : '' }}>Emotional Freedom Technique</option>
                            <option value="Emotion Code" {{ $business->holistic_services == 'Emotion Code' ? 'selected' : '' }}>Emotion Code</option>
                            <option value="End of Life Doula" {{ $business->holistic_services == 'End of Life Doula' ? 'selected' : '' }}>End of Life Doula</option>
                            <option value="Energy Work" {{ $business->holistic_services == 'Energy Work' ? 'selected' : '' }}>Energy Work</option>
                            <option value="Epigenetics" {{ $business->holistic_services == 'Epigenetics' ? 'selected' : '' }}>Epigenetics</option>
                            <option value="Functional Medicine" {{ $business->holistic_services == 'Functional Medicine' ? 'selected' : '' }}>Functional Medicine</option>
                            <option value="Healing Touch" {{ $business->holistic_services == 'Healing Touch' ? 'selected' : '' }}>Healing Touch</option>
                            <option value="Health Coaching" {{ $business->holistic_services == 'Health Coaching' ? 'selected' : '' }}>Health Coaching</option>
                            <option value="Herbalism" {{ $business->holistic_services == 'Herbalism' ? 'selected' : '' }}>Herbalism</option>
                            <option value="Holistic Dentistry" {{ $business->holistic_services == 'Holistic Dentistry' ? 'selected' : '' }}>Holistic Dentistry</option>
                            <option value="Holistic Primary Care" {{ $business->holistic_services == 'Holistic Primary Care' ? 'selected' : '' }}>Holistic Primary Care</option>
                            <option value="Holistic Skin Care" {{ $business->holistic_services == 'Holistic Skin Care' ? 'selected' : '' }}>Holistic Skin Care</option>
                            <option value="Homeopathy" {{ $business->holistic_services == 'Homeopathy' ? 'selected' : '' }}>Homeopathy</option>
                            <option value="Human Design" {{ $business->holistic_services == 'Human Design' ? 'selected' : '' }}>Human Design</option>
                            <option value="Hypnotherapy" {{ $business->holistic_services == 'Hypnotherapy' ? 'selected' : '' }}>Hypnotherapy</option>
                            <option value="Lactation Consulting" {{ $business->holistic_services == 'Lactation Consulting' ? 'selected' : '' }}>Lactation Consulting</option>
                            <option value="Low-Level Laser Therapy" {{ $business->holistic_services == 'Low-Level Laser Therapy' ? 'selected' : '' }}>Low-Level Laser Therapy</option>
                            <option value="Lymphatic Drainage" {{ $business->holistic_services == 'Lymphatic Drainage' ? 'selected' : '' }}>Lymphatic Drainage</option>
                            <option value="Marriage & Family Therapy" {{ $business->holistic_services == 'Marriage & Family Therapy' ? 'selected' : '' }}>Marriage & Family Therapy</option>
                            <option value="Massage Therapy" {{ $business->holistic_services == 'Massage Therapy' ? 'selected' : '' }}>Massage Therapy</option>
                            <option value="Meditation" {{ $business->holistic_services == 'Meditation' ? 'selected' : '' }}>Meditation</option>
                            <option value="Midwife" {{ $business->holistic_services == 'Midwife' ? 'selected' : '' }}>Midwife</option>
                            <option value="Myofascial Release" {{ $business->holistic_services == 'Myofascial Release' ? 'selected' : '' }}>Myofascial Release</option>
                            <option value="Naturopathic Medicine" {{ $business->holistic_services == 'Naturopathic Medicine' ? 'selected' : '' }}>Naturopathic Medicine</option>
                            <option value="Network Chiropractic" {{ $business->holistic_services == 'Network Chiropractic' ? 'selected' : '' }}>Network Chiropractic</option>
                            <option value="Neurofeedback" {{ $business->holistic_services == 'Neurofeedback' ? 'selected' : '' }}>Neurofeedback</option>
                            <option value="Neurolinguistic Programming" {{ $business->holistic_services == 'Neurolinguistic Programming' ? 'selected' : '' }}>Neurolinguistic Programming</option>
                            <option value="Neuromuscular Therapy" {{ $business->holistic_services == 'Neuromuscular Therapy' ? 'selected' : '' }}>Neuromuscular Therapy</option>
                            <option value="Nutrition" {{ $business->holistic_services == 'Nutrition' ? 'selected' : '' }}>Nutrition</option>
                            <option value="Occupational Therapy" {{ $business->holistic_services == 'Occupational Therapy' ? 'selected' : '' }}>Occupational Therapy</option>
                            <option value="Osteopathic Medicine" {{ $business->holistic_services == 'Osteopathic Medicine' ? 'selected' : '' }}>Osteopathic Medicine</option>
                            <option value="Pelvic Floor Therapy" {{ $business->holistic_services == 'Pelvic Floor Therapy' ? 'selected' : '' }}>Pelvic Floor Therapy</option>
                            <option value="PEMF" {{ $business->holistic_services == 'PEMF' ? 'selected' : '' }}>PEMF</option>
                            <option value="Personal Training" {{ $business->holistic_services == 'Personal Training' ? 'selected' : '' }}>Personal Training</option>
                            <option value="Physical Therapy" {{ $business->holistic_services == 'Physical Therapy' ? 'selected' : '' }}>Physical Therapy</option>
                            <option value="Pilates" {{ $business->holistic_services == 'Pilates' ? 'selected' : '' }}>Pilates</option>
                            <option value="Plant Medicine" {{ $business->holistic_services == 'Plant Medicine' ? 'selected' : '' }}>Plant Medicine</option>
                            <option value="Pregnancy" {{ $business->holistic_services == 'Pregnancy' ? 'selected' : '' }}>Pregnancy</option>
                            <option value="Psychedelic Integration" {{ $business->holistic_services == 'Psychedelic Integration' ? 'selected' : '' }}>Psychedelic Integration</option>
                            <option value="Psychedelic Therapy" {{ $business->holistic_services == 'Psychedelic Therapy' ? 'selected' : '' }}>Psychedelic Therapy</option>
                            <option value="PSYCH-K" {{ $business->holistic_services == 'PSYCH-K' ? 'selected' : '' }}>PSYCH-K</option>
                            <option value="Qigong" {{ $business->holistic_services == 'Qigong' ? 'selected' : '' }}>Qigong</option>
                            <option value="Reflexology" {{ $business->holistic_services == 'Reflexology' ? 'selected' : '' }}>Reflexology</option>
                            <option value="Reiki" {{ $business->holistic_services == 'Reiki' ? 'selected' : '' }}>Reiki</option>
                            <option value="Rolfing" {{ $business->holistic_services == 'Rolfing' ? 'selected' : '' }}>Rolfing</option>
                            <option value="Sex Therapy" {{ $business->holistic_services == 'Sex Therapy' ? 'selected' : '' }}>Sex Therapy</option>
                            <option value="Shamanism" {{ $business->holistic_services == 'Shamanism' ? 'selected' : '' }}>Shamanism</option>
                            <option value="Shiatsu" {{ $business->holistic_services == 'Shiatsu' ? 'selected' : '' }}>Shiatsu</option>
                            <option value="Somatic Experiencing" {{ $business->holistic_services == 'Somatic Experiencing' ? 'selected' : '' }}>Somatic Experiencing</option>
                            <option value="Sound Healing" {{ $business->holistic_services == 'Sound Healing' ? 'selected' : '' }}>Sound Healing</option>
                            <option value="Speech Therapy" {{ $business->holistic_services == 'Speech Therapy' ? 'selected' : '' }}>Speech Therapy</option>
                            <option value="Structural Integration" {{ $business->holistic_services == 'Structural Integration' ? 'selected' : '' }}>Structural Integration</option>
                            <option value="Tai Chi" {{ $business->holistic_services == 'Tai Chi' ? 'selected' : '' }}>Tai Chi</option>
                            <option value="Thermography" {{ $business->holistic_services == 'Thermography' ? 'selected' : '' }}>Thermography</option>
                            <option value="Traditional Chinese Medicine" {{ $business->holistic_services == 'Traditional Chinese Medicine' ? 'selected' : '' }}>Traditional Chinese Medicine</option>
                            <option value="Vision Therapy" {{ $business->holistic_services == 'Vision Therapy' ? 'selected' : '' }}>Vision Therapy</option>
                            <option value="Wellness Counseling" {{ $business->holistic_services == 'Wellness Counseling' ? 'selected' : '' }}>Wellness Counseling</option>
                            <option value="Yoga" {{ $business->holistic_services == 'Yoga' ? 'selected' : '' }}>Yoga</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>State license number (optional)</label>
                        <input type="text" value="{{$business->state_license_number}}" name="state_license_number" class="form-control" placeholder="State license number" >
                    </div>

                    <div class="form-group">
                        <label>Contractor license number (optional)</label>
                        <input type="text" value="{{$business->state_license_number}}" name="contractor_license_number" class="form-control" placeholder="State license number" >
                    </div>
                      
                      <label for="toggleCheckbox" class="checkbox-label">
                          Offers free consult
                          <input type="checkbox" {{ $business->offers_free_consult == 'on' ? 'checked' : '' }} name="offers_free_consult" id="toggleCheckbox">
                      </label>



                         
                          <!-- <button class="btn profile-button btn-lg pull-left mb-1" type="button">Save</button> -->
                          <button class="btn profile-button nextBtn btn-lg pull-right mb-1" type="button">Next</button>
                        </div>
                    </div>
                    <div class="row setup-content" id="step-2">
                        <div class="col-md-12">
                          <h4 class="fw-bold">Let’s add your Contact Info</h4>
                          <p>You can add your contact detail so that we can help you claim your Business Page.</p>
                          <div class="form-group">
                            <label class="control-label">Email</label>
                            <input type="email" class="form-control" name="business_email" placeholder="Enter Your Email" value="{{$business->business_email}}">
                          </div>
                          <div class="form-group">
                            <label class="labels">Phone No.</label>
                            <input type="tel" class="form-control" id="phone" placeholder="Enter Your Phone no." value="{{$business->business_phone}}">
                            <!-- Hidden input to store the full phone number with country code -->
                            <input type="hidden" id="full_phone" name="business_phone" value="{{ old('full_phone', $business->business_phone ?? '') }}">
                            </div>
                          <div class="form-group">
                            <label class="labels">Website</label>
                            <input type="text" class="form-control" name="business_website" placeholder="Enter Your Website" value="{{$business->business_website}}">
                          </div>
                          <div class="form-group">
                            <label class="labels">Description</label>
                            <textarea id="editor1" class="form-control" name="business_description" placeholder="Descriptiont">{{$business->business_description}}</textarea>
                          </div>
                          
                          <button class="btn profile-button mb-1 prevBtn btn-lg pull-left" type="button">Previous</button>
                          <!-- <button class="btn profile-button mb-1 btn-lg pull-left" type="button">Save</button> -->
                          <button class="btn profile-button mb-1 nextBtn btn-lg pull-right" type="button">Next</button>
                        </div>
                    </div>
                    <div class="row setup-content" id="step-3">
                    <div class="col-md-12">
                        <h4 class="fw-bold">Locations</h4>
                        <p>Business location</p>
                        <!-- <div class="map">
                           <iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d2965.0824050173574!2d-93.63905729999999!3d41.998507000000004!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sWebFilings%2C+University+Boulevard%2C+Ames%2C+IA!5e0!3m2!1sen!2sus!4v1390839289319" width="100%" height="300" frameborder="0" style="border:0"></iframe>
                        </div> -->
                        
                        <div id="address-container">
                            <div class="address-group">
                              @foreach($all_addresses as $newAddress)
                                <div class="form-group">
                                    <label class="labels">Address 1</label>
                                    <input type="text" class="form-control" name="address_1[]" placeholder="Enter Your Address" value="{{stripslashes(trim($newAddress['address_1']));}}">
                                </div>
                                <div class="form-group">
                                    <label class="labels">Address 2 (Optional)</label>
                                    <input type="text" class="form-control" name="address_2[]" placeholder="Enter Your Address" value="{{stripslashes(trim($newAddress['address_2']));}}">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Country</label>
                                    <input type="text" name="country[]" class="form-control" value="{{$newAddress['country']}}">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">State</label>
                                    <input type="text"  name="state[]" class="form-control" value="{{$newAddress['state']}}">
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-8">
                                        <label class="control-label">City</label>
                                        <input type="text" class="form-control" name="city[]" placeholder="Enter Your City" value="{{$newAddress['city']}}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="control-label">Postal Code</label>
                                        <input type="text" class="form-control" name="zip_code[]" maxlength="6" placeholder="111111" value="{{$newAddress['zip_code']}}">
                                    </div>
                                </div>
                                <div class="form-group mb-4">
                                    <label class="control-label">Choose Your Location</label>
                                    <input name="location[]" type="text" class="form-control get_loc" placeholder="Location" value="{{$newAddress['location']}}">
                                    <div class="searcRes" id="autocomplete-results"></div>
                                </div>

                                <hr>

                                @endforeach
                            </div>
                        </div>
                        <button type="button" id="add-location" class="btn btn-primary" style="float:right">Add Location</button><br><br>

                          <button class="btn profile-button mb-1 prevBtn btn-lg pull-left" type="button">Previous</button>
                          <!-- <button class="btn profile-button mb-1 btn-lg pull-left" type="button">Save</button> -->
                          <button class="btn profile-button mb-1 nextBtn btn-lg pull-right" type="button">Next</button>
                      </div>
                    </div>
                    <?php
                        $working_hoursArray = explode(",", $business->opening_hours);
                        //  echo "<pre>";print_r($working_hoursArray);die();
                        ?>
                    
                    <div class="row setup-content" id="step-4">
                    <div class="col-md-12">
                        <!--<h4 class="fw-bold">Opening hours</h4>-->
                        <div class="form-group">
                           <div class="manage_section">
                            <label class="control-label">Opening Hours</label> <button type="button" class="btn managepost managebtn" data-toggle="modal" data-target="#exampleModal_hours">Manage service hours</button>
                          </div>
                           <select name="opening_hours[]" class="form-control form-control-xs selectpicker" data-size="7" data-live-search="true" data-title="Hours" id="sub_category" data-width="100%" multiple>
                           <?php
                        // Add each value from $data as an option once
                        foreach ($data as $sortDay => $value) {
                            $selected = in_array($value, $working_hoursArray) ? 'selected' : '';
                            echo "<option value=\"$value\" $selected>$value</option>";
                        }
                        ?>
                         </select>
                         </div>
                         <div class="review-frame">
                          <div class="form-container">
                            <div class="col-12 mb-4">
                                <label class="labels">Video </label>
                                <div class="upload-icon">
                                    <a class="videoChanel btn btn-warning" href="javascript:void(0)">
                                        <i class="fa fa-upload" aria-hidden="true"></i> Upload
                                    </a>
                                </div>
                                <div class="video_gallery" id="sortableImgThumbnailPreview_video">
                                <div class="apnd-img featured" data-id="0"><video style="height:100px; width:100px;" controls="" src="{{asset('/business_img')}}/{{$business->video}}" id="video0" class="video-responsive" filename="854518-hd_1920_1080_30fps.mp4"></video><i class="fa fa-trash delfile_video"></i></div>
                                </div>
                                @error('Video')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                          </div>
                          </div>
                        </div>
                          <div class="review-frame">
                          <div class="form-container">
                            <div class="col-12 mb-4">
                              <label class="labels" data-toggle="tooltip" data-placement="top" title="Any photo that signals an intention to commit, solicit, promote or encourage a criminal act and/or violate the  Advertiser Agreement will not be accepted.">Post gallery images <em>(Select multiple)</em> <i class="fa fa-question popup2"> </i></label>
                              <div class="upload-icon"><a class="cam btn btn-warning"  href="javascript:void(0)">
                                  <i class="fa fa-upload" aria-hidden="true"></i>
                                      Upload image
                                  </a> 
                              </div>

                              <?php
                                  if (!is_null($business->gallery_image) && !empty($business->gallery_image)) {
                                      $img = json_decode($business->gallery_image);

                                      if (($key = array_search($business->featured_image, $img)) !== false) {
                                          unset($img[$key]);
                                          array_unshift($img, $business->featured_image);
                                      }
                                  } else {
                                      // Handle the case where gallery_image is null or empty
                                      $img = []; // You can set $img as an empty array or handle it differently
                                  }
                              ?>
                            
                            <div class="gallery">
                              @foreach($img as $index => $images)
                              <div class='apnd-img'>
                                  <img src="{{ asset('business_img') }}/{{ $images }}" imgType='listing' filename='{{ $images }}' id='img' remove_name="{{ $images }}" dataid="{{$business->id}}" class='img-responsive'> 
                                      <i class='fa fa-trash delfile'></i>
                                  
                              </div>
                              
                              @endforeach
                          </div>
                                @error('image')
                              <small class="text-danger">{{ $message }}</small>
                              @enderror
                          </div>
                          </div>
                        </div>
                        <div class="review-frame">
                          <div class="form-container">
                              <div class="col-12 mb-4">
                                  <label class="labels" data-toggle="tooltip" data-placement="top" title="Any photo that signals an intention to commit, solicit, promote or encourage a criminal act and/or violate the Advertiser Agreement will not be accepted.">
                                      Post business logo 
                                      <i class="fa fa-question popup2"></i>
                                  </label>
                                  <div class="upload-icon">
                                      <a class="cam btn btn-warning logoUpload" href="javascript:void(0)">
                                          <i class="fa fa-upload" aria-hidden="true"></i>
                                          Upload image
                                      </a>
                                  </div>
                                  
                                  <!-- Gallery container for the uploaded logo -->
                                  <div class="logo_gallery" id="sortableImgThumbnailPreview">
                                  <div class='apnd-img'>
                                  <img src="{{ asset('business_img') }}/{{$business->business_logo}}" imgType='listing' filename='{{ $business->business_logo }}' id='img' remove_name="{{ $business->business_logo }}" dataid="{{$business->id}}" class='img-responsive'> 
                                      <i class='fa fa-trash delfile'></i>
                                  
                              </div>
                                  </div>
                                  
                                  <!-- Error message display -->
                                  @error('image')
                                  <small class="text-danger">{{ $message }}</small>
                                  @enderror
                              </div>
                          </div>
                      </div>


                        <button class="btn profile-button mb-1 prevBtn btn-lg pull-left" type="button">Previous</button>
                        <!-- <button class="btn profile-button mb-1 btn-lg pull-left" type="button">Save</button> -->
                        <button class="btn profile-button mb-1 nextBtn btn-lg pull-right" type="button">Next</button>
                      </div>
                    </div>
                    <div class="row setup-content" id="step-5">
                      <div class="col-md-12">
                      <h4 class="fw-bold">Social Media Links</h4>
                        <div class="form-group">
                            <label class="labels">Facebook</label>
                            <input type="text" class="form-control" name="facebook" value="{{$business->facebook}}" placeholder="https://facebook.com">
                        </div>
                        <div class="form-group">
                            <label class="labels">Youtube</label>
                            <input type="text" class="form-control" name="youtube" value="{{$business->youtube}}" placeholder="https://youtube.com">
                        </div>
                        <div class="form-group">
                            <label class="labels">Instagram</label>
                            <input type="text" class="form-control" name="instagram" value="{{$business->instagram}}" placeholder="https://instagram.com">
                        </div>
                        <div class="form-group">
                            <label class="labels">Tiktok</label>
                            <input type="text" class="form-control" name="tiktok" value="{{$business->tiktok}}" placeholder="https://tiktok.com">
                        </div>
                        <div class="form-group">
                            <label class="labels">Whatsapp</label>
                            <input type="text" class="form-control" id="whatsapp" name="whatsapp" value="{{$business->whatsapp}}" placeholder="+1 1234567890">
                        </div>

                        <button class="btn profile-button mb-1 prevBtn btn-lg pull-left" type="button">Previous</button>
                        <button class="btn profile-button mb-1 btn-lg pull-right" type="submit">Submit</button>
                      </div>
                    </div>
                    <!-- <div class="row setup-content" id="step-6">
                      <div class="col-md-12">
                        <button class="btn profile-button mb-1 prevBtn btn-lg pull-left" type="button">Previous</button>
                        <button class="btn profile-button mb-1 btn-lg pull-left" type="button">Cancel</button>
                        <button class="btn profile-button mb-1 nextBtn btn-lg pull-right" type="submit">Submit</button>
                      </div>
                    </div> -->
                  </form> 
                </div>
                <div class="col-md-6">
                  <div class="business-img-frame">
                    <!-- <div class="text-frame text-center">
                      <h6 class="fw-bold">If you are available to see client's in this city right now, hit the "Available Now" button.</h6>
                      <button type="button" class="btn  profile-button mb-1">Available Now</button>
                    </div> -->
                    <img src="https://finderspage.com/public/user_dashboard/img/business-img.jpg" class="img-fluid" alt="img">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="v-pills-shop" role="tabpanel" aria-labelledby="v-pills-shop-tab">
            <div class=" bg-white border pb-4 p-3 mx-md-2">
              <div class="coming-soon text-center">
                <img src="https://finderspage.com/public/front/images/coming-soon.png" alt="coming-soon.png" class="img-fluid w-50">
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="v-pills-deals" role="tabpanel" aria-labelledby="v-pills-deals-tab">
          <div class=" bg-white border pb-4 p-3 mx-md-2">
              <div class="coming-soon text-center">
                <img src="https://finderspage.com/public/front/images/coming-soon.png" alt="coming-soon.png" class="img-fluid w-50">
              </div>
            </div>
         
          </div>
      </div>

          

    </div>
  </div>
<!-- Modal -->
<div class="modal fade" id="exampleModal_hours" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Manage Service Hours</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="hoursForm" action="{{ route('hours.save') }}" method="POST">
                    @csrf
                    <div class="container px-0">
                        @foreach($days as $day)
                            <div class="day">
                                @php
                                    $day_status = isset($status[$day]) ? $status[$day] : 'off';
                                    $day_open_time = isset($open_time[$day]) ? $open_time[$day] : '';
                                    $day_close_time = isset($close_time[$day]) ? $close_time[$day] : '';
                                    $day_open_24 = isset($open_24[$day]) && $open_24[$day] === 'on' ? true : false;
                                @endphp
                                <div class="days-col">
                                  <input type="checkbox" name="status[{{ $day }}]" id="status_{{ $day }}" {{ $day_status === 'on' ? 'checked' : '' }}>
                                  <label for="status_{{ $day }}">{{ ucfirst($day) }}</label>
                                </div>

                                <!-- Time inputs -->
                                <div class="time time_{{ $day }}">
                                    <input type="time" name="open_time[{{ $day }}]" value="{{ $day_open_time }}" step="900" id="open_time_{{ $day }}" {{ $day_open_24 ? 'disabled' : '' }} required>
                                    <input type="time" name="close_time[{{ $day }}]" value="{{ $day_close_time }}" step="900" id="close_time_{{ $day }}" {{ $day_open_24 ? 'disabled' : '' }} required>
                                </div>

                                <!-- 24 Hours Toggle -->
                                <div class="open-24">
                                    <input type="checkbox" name="open_24[{{ $day }}]" id="open_24_{{ $day }}" {{ $day_open_24 ? 'checked' : '' }} onclick="toggleTimeInputs('{{ $day }}', this)">
                                    <label for="open_24_{{ $day }}">24 Hours</label>
                                </div>
                            </div>
                        @endforeach
                        <div class="buttons">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" id="saveChangesBtn" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>
  <!-- Modal -->
<div class="modal fade" id="staticBackdrop_services" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">  <i class="fa fa-info-circle fa-2xl icon"></i> </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <h5> Elevate your practice at FindersPage, our goal is simple: To bring you more clients. We connect you with real people in your area who are seeking your services. </h5>
      <div class="text-info-services">
      We believe that every person is unique, and it's our passion to refer you clients who will appreciate and benefit from your own brand. 
Take a look around and we know you'll agree that FindersPage is a world-class website. So what are you waiting for? Start getting more clients today!
      </div>
      </div>
    </div>
  </div>
</div>
<input type="hidden" value="{{$business->selected_button}}" id="selectedBtn" >
<input type="hidden" value="{{$business->selected_button_url}}" id="selectedBtnUrl" >
<script>
  $(document).ready(function() {
    // Check if the modal has already been shown in this session
    if (!sessionStorage.getItem('modalShown_business')) {
      // Set a timeout to show the modal after 5 seconds
      setTimeout(function() {
        $('#staticBackdrop_services').modal('show');
        // Mark the modal as shown in sessionStorage
        sessionStorage.setItem('modalShown_business', 'true');
      }, 5000); // 5000 milliseconds = 5 seconds
    }
  });
</script>

  <script src="https://cdn.jsdelivr.net/npm/jquery@3/dist/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
  <script>

document.addEventListener('DOMContentLoaded', function() {
    // Select the phone input field
    var input = document.querySelector("#phone");

    // Function to determine the initial country based on the phone number
    function getCountryCode(phoneNumber) {
      // You might want to implement a more robust parsing mechanism
      // For now, we are assuming the phone number starts with the country code
      if (phoneNumber.startsWith('+1')) return 'us'; // USA
      if (phoneNumber.startsWith('+91')) return 'in'; // India
      // Add more country codes as necessary
      
      return 'us'; // Default to US if not recognized
    }

    // Get the initial country from the phone number
    var initialCountry = getCountryCode(input.value);

    // Initialize intl-tel-input
    var iti = window.intlTelInput(input, {
      initialCountry: initialCountry, // Set initial country based on the phone number
      geoIpLookup: function(callback) {
        fetch('https://ipinfo.io', { headers: { 'Accept': 'application/json' } })
          .then(function(resp) { return resp.json(); })
          .then(function(resp) { callback(resp.country); })
          .catch(function() { callback("us"); }); // Default to US if detection fails
      },
      utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
    });

    // On focusout, alert the full phone number (including the country code)
    input.addEventListener('focusout', function() {
      var fullPhoneNumber = iti.getNumber(); // Get the full phone number
      $('#full_phone').val(fullPhoneNumber);
      alert(fullPhoneNumber); // Alert the full phone number
    });
  });

    $(document).ready(function() {

    $('#sub_category').on('change', function() {
        if ($(this).val() == "Other") {
            $('#Other-cate-input').removeClass('d-none');
            $(this).addClass('d-none');
        } else {
            $('#Other-cate-input').addClass('d-none');
        }

    });

    $(document).ready(function() {
    $('#add-location').on('click', function() {
        // Define the HTML structure for a new address group
        var newAddressGroup = `
            <div class="address-group">
                <div class="form-group">
                    <label class="labels">Address 1</label>
                    <input type="text" class="form-control" name="address_1[]" placeholder="Enter Your Address">
                </div>
                <div class="form-group">
                    <label class="labels">Address 2 (Optional)</label>
                    <input type="text" class="form-control" name="address_2[]" placeholder="Enter Your Address">
                </div>
                <div class="form-group">
                    <label class="control-label">Country</label>
                    <input type="text" name="country[]" class="form-control">
                </div>
                <div class="form-group">
                    <label class="control-label">State</label>
                    <input type="text" name="state[]" class="form-control">
                </div>
                <div class="row form-group">
                    <div class="col-md-8">
                        <label class="control-label">City</label>
                        <input type="text" class="form-control" name="city[]" placeholder="Enter Your City">
                    </div>
                    <div class="col-md-4">
                        <label class="control-label">Postal Code</label>
                        <input type="text" class="form-control" name="zip_code[]" maxlength="6" placeholder="111111">
                    </div>
                </div>
                <div class="form-group mb-4">
                    <label class="control-label">Choose Your Location</label>
                    <input name="location[]" type="text" class="form-control get_loc" placeholder="Location">
                    <div class="searcRes" id="autocomplete-results"></div>
                </div>
                <button type="button" class="btn btn-danger remove-location">Remove</button>
                <hr>
            </div>
        `;

        // Append the new address group to the address container
        $('#address-container').append(newAddressGroup);
    });

    // Remove location functionality
    $(document).on('click', '.remove-location', function() {
        $(this).closest('.address-group').remove();
    });
});


    $('.addCategory').click(function(e) {
      var subcate_title = $('#Other-cate-input').val();
      var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
      if (subcate_title == "") {
                // alert(subcate_title);
                $('#businessForm').submit();
                return false;
            }
            e.preventDefault();
      $.ajax({
          url: baseurl + '/shopping/cate',
          type: 'POST',
          headers: {
              'X-CSRF-TOKEN': csrfToken
          },
          data: {
              title: subcate_title,
              parent_id: 1,
          },
          success: function(response) {
              console.log(response);
               $('#businessForm').submit();
          },
          error: function(xhr, status, error) {

          }
      });
    });
  });

  $(document).ready(function() {
    // Handle link click
    $('#link-section a').click(function(e) {
        e.preventDefault();  // Prevent default anchor behavior

        // Remove 'active' class from all links
        $('#link-section a').removeClass('active_btn');

        // Add 'active' class to the clicked link
        $(this).addClass('active_btn');

        // Get the data-target attribute to find corresponding input
        var target = $(this).data('target');

        // Remove 'd-none' class from all inputs (if you want to hide others)
        $('#input-section .link-input').addClass('d-none');
        // $('#input-section .link-input').removeClass('d-flex');

        // Show the corresponding input by removing 'd-none'
        $(target).removeClass('d-none');
        $(".input_wrapper").addClass('d-flex');
    });
});

$(document).ready(function() {
      var selectedBtn = $('#selectedBtn').val();
      var selectedBtnUrl = $('#selectedBtnUrl').val();
      //  alert(selectedBtn);
      // alert(selectedBtnUrl);
      if(selectedBtn !="" && selectedBtnUrl !=""){
        $("#"+selectedBtn).show();
      }
   
});
    $(document).ready(function() {
        var isChecked1 = $('input[name="add_button"]').is(':checked');
        if (isChecked1 === true) {
            $('#link-section').removeClass('d-none');
        } else {
            $('#link-section').addClass('d-none');
            $('.link-input').hide();
        }

        $('input[name="add_button"]').on('click', function() {
            var isChecked = $(this).is(':checked');
            if (isChecked === true) {
                $('#link-section').removeClass('d-none');
            } else {
                $('#link-section').addClass('d-none');
                $('#input-section .link-input').hide();
            }
        });

        $('#link-section a').on('click', function(event) {
            event.preventDefault();

            var targetSelector = $(this).data('target');
            $('#input-section .link-input').hide();
            $(targetSelector).show();

            $('html, body').animate({
                scrollLeft: $(this).offset().left
            }, 500);
        });
    });



  $(document).ready(function() {

    $('#sub_category').on('change', function() {
        if ($(this).val() == "Other") {
            $('#Other-cate-input').removeClass('d-none');
            $(this).addClass('d-none');
        } else {
            $('#Other-cate-input').addClass('d-none');
        }

    });

    $('.addCategory').click(function() {
      var subcate_title = $('#Other-cate-input').val();
      var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
      $.ajax({
          url: baseurl + '/shopping/cate',
          type: 'POST',
          headers: {
              'X-CSRF-TOKEN': csrfToken
          },
          data: {
              title: subcate_title,
              parent_id: 1,
          },
          success: function(response) {
              console.log(response);
          },
          error: function(xhr, status, error) {

          }
      });
    });
  });

  $(document).ready(function() {
    $('.link-input').on('input', function(event) {
        event.preventDefault();

        var changedInput = $(this);
        var selectedButtonId = changedInput.attr('id');
        var selectedButtonUrl = changedInput.val();

        // Remove any existing hidden inputs to avoid duplication
        $('#input-section').find('input[name="selected_button"]').remove();
        $('#input-section').find('input[name="selected_button_url"]').remove();

        // Append new hidden inputs with the current values
        $('#input-section').append('<input type="hidden" name="selected_button" value="' + selectedButtonId + '">');
        $('#input-section').append('<input type="hidden" name="selected_button_url" value="' + selectedButtonUrl + '">');
    });
});

  </script>
  <script>
    // on date time picker //
    $(function () {            

        /* setting date */
        $("#datepicker").datetimepicker({
            format : "DD-MM-YYYY"
        });
        
        /* setting time */
        $("#timepicker").datetimepicker({
            format: 'LT'
        });
        
        $("#datepicker1").datetimepicker({
            format : "DD-MM-YYYY"
        });
        
        /* setting time */
        $("#timepicker1").datetimepicker({
            format: 'LT'
        });
        
    });                

</script>
<script>
  // stepper form //

  $(document).ready(function () {
  var navListItems = $('div.setup-panel div a'),
          allWells = $('.setup-content'),
          allNextBtn = $('.nextBtn'),
        allPrevBtn = $('.prevBtn');

  allWells.hide();

  navListItems.click(function (e) {
      e.preventDefault();
      var $target = $($(this).attr('href')),
              $item = $(this);

      if (!$item.hasClass('disabled')) {
          navListItems.removeClass('btn-primary').addClass('btn-default');
          $item.addClass('btn-primary');
          allWells.hide();
          $target.show();
          $target.find('input:eq(0)').focus();
      }
  });
  
  allPrevBtn.click(function(){
      var curStep = $(this).closest(".setup-content"),
          curStepBtn = curStep.attr("id"),
          prevStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().prev().children("a");
          prevStepWizard.removeAttr('disabled').trigger('click');
  });

  allNextBtn.click(function(){
      var curStep = $(this).closest(".setup-content"),
          curStepBtn = curStep.attr("id"),
          nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
          curInputs = curStep.find("input[type='text'],input[type='url']"),
          isValid = true;

      $(".form-group").removeClass("has-error");
      for(var i=0; i<curInputs.length; i++){
          if (!curInputs[i].validity.valid){
              isValid = false;
              $(curInputs[i]).closest(".form-group").addClass("has-error");
          }
      }
          nextStepWizard.removeAttr('disabled').trigger('click');
  });

  $('div.setup-panel div a.btn-primary').trigger('click');
});
</script>

<script>
  // add time on click //

 $(document).ready(function(){
  
  $(document).on('click', '.tp-start-time', function(){
    timePicker($(this));
  });
  
  $(document).on('click', '.tp-end-time', function(){
    startTime = $(this).closest('.tp-day-cont').find('.tp-start-time').html();
    timePicker($(this), 5, getHour(startTime));
  });
});

function timePicker($elem, minutesStep = 5, startHour = 0, startMinutes = 0, endHour = 23, endMinutes = 59, defaultTime)
{
  let currentHour = '12';
  let currentMinutes = '00';
  if(startHour < 0 || startHour > 23){
    startHour = 0;
  }
  if (endHour < startHour || endHour > 23){
    endHour = 23;
  }
  
  if (startMinutes < 0 || startMinutes > 59){
    startMinutes = 0;
  }
  if (endMinutes <= startMinutes || endMinutes > 59){
    endMinutes = 59;
  }
  
  if (minutesStep < 1 || minutesStep > 60){
    minutesStep = 5;
  }
  
  if (!defaultTime){
    let currentTime = $elem.html();
    if(isValidTime(currentTime)){
      currentHour = getHour(currentTime);
      currentMinutes = getMinutes(currentTime);
    }
  }
  let modal = '<div id="tp-modal" class="modal fade" tabindex="-1">' +
      '<div class="modal-dialog modal-sm">' +
        '<div class="modal-content">' +
          '<div class="modal-header"><h4>Set Time</h4></div>' +
          '<div class="modal-body pt-0 pl-0 pr-0 ">' +
            '<div id="tp-time-cont">' +
              '<div id="tp-hour-cont" class="mr-1 text-right">' +
                '<button id="tp-h-up" class="ml-auto"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-up" fill="currentColor" xmlns="http://www.w3.org/2000/svg">' +
              '<path fill-rule="evenodd" d="M7.646 4.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 5.707l-5.646 5.647a.5.5 0 0 1-.708-.708l6-6z"/>' +
                  '</svg></button>' +
                '<div id="tp-h-value" class="tp-value">12</div>' +
                '<button id="tp-h-down" class="ml-auto">' +
                  '<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-down" fill="currentColor" xmlns="http://www.w3.org/2000/svg">' +
              '<path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>' +
                  '</svg>' +
                '</button>' +
              '</div>' +
              '<div id="tp-colon">:</div>' +
              '<div id="tp-minutes-cont" class="ml-1 text-left">' +
                '<button id="tp-m-up"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-up" fill="currentColor" xmlns="http://www.w3.org/2000/svg">' +
              '<path fill-rule="evenodd" d="M7.646 4.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 5.707l-5.646 5.647a.5.5 0 0 1-.708-.708l6-6z"/>' +
                  '</svg></button>' +
                '<div id="tp-m-value" class="tp-value">12</div>' +
                '<button id="tp-m-down">' +
                  '<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-down" fill="currentColor" xmlns="http://www.w3.org/2000/svg">' +
              '<path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>' +
                  '</svg>' +
                '</button>' +
              '</div>' +
            '</div>' +
          '<div class="modal-footer">' +
            '<button type="button" id="tp-cancel-btn" class="btn btn-secondary" data-dismiss="modal">Cancel</button>' +
            '<button type="button" id="tp-set-btn" class="btn btn-primary">Set</button>' +
          '</div>' +
        '</div>' +
      '</div>' +
    '</div>';
  $('body').append(modal);
  
  $('#tp-h-value').html(currentHour);
  $('#tp-m-value').html(currentMinutes);
  
  $('#tp-h-up').off('click').on('click', function(){
    let val = parseInt($('#tp-h-value').html()) + 1;
    if (val == endHour + 1){
      $('#tp-h-value').html(('0' + startHour).substr(-2));
    } else {
      $('#tp-h-value').html(('0' + val).substr(-2));
    }
  });
  
  $('#tp-h-down').off('click').on('click', function(){
    let val = parseInt($('#tp-h-value').html()) - 1;
    if (val == startHour - 1){
      $('#tp-h-value').html(('0' + endHour).substr(-2));
    } else {
      $('#tp-h-value').html(('0' + val).substr(-2));
    }
  });
  
  $('#tp-m-up').off('click').on('click', function(){
    let val = parseInt($('#tp-m-value').html()) + minutesStep;
    if (val >= endMinutes + 1){
      $('#tp-m-value').html((startMinutes == 0)? '00' : ('0' + (startMinutes + minutesStep - startMinutes % minutesStep)).substr(-2));
    } else {
      $('#tp-m-value').html(('0' + val).substr(-2));
    }
  });
  
  $('#tp-m-down').off('click').on('click', function(){
    let val = parseInt($('#tp-m-value').html()) - minutesStep;
    if (val <= startMinutes - 1){
      $('#tp-m-value').html(('0' + (endMinutes - endMinutes % minutesStep)).substr(-2));
    } else {
      $('#tp-m-value').html(('0' + val).substr(-2));
    }
  });
  
  $('#tp-set-btn').off('click').on('click', function(){
    let h = $('#tp-h-value').html();
    let m = $('#tp-m-value').html();
    
    $elem.html(h + ':' + m);
    
    if ($elem.hasClass('tp-start-time')){
      let $endTimeElem = $elem.closest('.tp-day-cont').find('.tp-end-time');
      if ($endTimeElem.length > 0){
        if (compareTimes($elem.html(), $endTimeElem.html()) == 0 || compareTimes($elem.html(), $endTimeElem.html()) == 1){
          $endTimeElem.html(newEndTime($elem.html(), minutesStep));
        }
      }
    } else {
      let $startTimeElem = $elem.closest('.tp-day-cont').find('.tp-start-time');
      if ($startTimeElem.length > 0){
        if (compareTimes($startTimeElem.html(), $elem.html()) == 0 || compareTimes($startTimeElem.html(), $elem.html()) == 1){
          $elem.html(newEndTime($startTimeElem.html(), minutesStep));
        }
      }
    }
    $('#tp-modal').modal('hide');
  });
  
  $('#tp-modal').modal('show');
}
  
function getHour(time){
  return time.substr(0, time.indexOf(':'));
}

function getIntHour(time){
  return parseInt(getHour(time));
}

function getMinutes(time){
  return time.substr(time.indexOf(':') + 1);
}

function getIntMinutes(time){
  return parseInt(getMinutes(time));
}

function isValidTime(time){
  let patt = /([01]?\d):([0-5]\d)/g;
  return patt.test(time);
}

function compareTimes(time1, time2){
  if (!isValidTime(time1) || !isValidTime(time2)) {
    return -1;
  }
  if (time1 == time2){
    return 0;
  } else if(getIntHour(time1) > getIntHour(time2)) {
    return 1;
  } else if(getIntHour(time1) == getIntHour(time2)) {
    if (getIntMinutes(time1) > getIntMinutes(time2)) {
      return 1;
    }
    else {
      return 2;
    }
  } else {
    return 2;
  }
}

function newEndTime(startTime, minutesStep){
  if (!isValidTime(startTime)){
    return -1;
  }
  
  let hour = getIntHour(startTime);
  let minutes = getIntMinutes(startTime);
  
  if (minutes + minutesStep > 59){
    minutes = 0;
    hour++;
    if (hour > 23){
      return startTime;
    }
  } else {
    minutes += minutesStep;
  }
  
  hour = ("0" + hour).substr(-2);
  minutes = ("0" + minutes).substr(-2);
  return hour + ":" + minutes;
}
</script>

<script>
// review rating form //

  const allStar = document.querySelectorAll('.rating .star')
const ratingValue = document.querySelector('.rating input')

allStar.forEach((item, idx)=> {
  item.addEventListener('click', function () {
    let click = 0
    ratingValue.value = idx + 1

    allStar.forEach(i=> {
      i.classList.replace('bxs-star', 'bx-star')
      i.classList.remove('active')
    })
    for(let i=0; i<allStar.length; i++) {
      if(i <= idx) {
        allStar[i].classList.replace('bx-star', 'bxs-star')
        allStar[i].classList.add('active')
      } else {
        allStar[i].style.setProperty('--i', click)
        click++
      }
    }
  })
})
</script>

<script>
  // drag drop image and videos //
  var isAdvancedUpload = function() {
  var div = document.createElement('div');
  return (('draggable' in div) || ('ondragstart' in div && 'ondrop' in div)) && 'FormData' in window && 'FileReader' in window;
}();

let draggableFileArea = document.querySelector(".drag-file-area");
let browseFileText = document.querySelector(".browse-files");
let uploadIcon = document.querySelector(".upload-icon");
let dragDropText = document.querySelector(".dynamic-message");
let fileInput = document.querySelector(".default-file-input");
let cannotUploadMessage = document.querySelector(".cannot-upload-message");
let cancelAlertButton = document.querySelector(".cancel-alert-button");
let uploadedFile = document.querySelector(".file-block");
let fileName = document.querySelector(".file-name");
let fileSize = document.querySelector(".file-size");
let progressBar = document.querySelector(".progress-bar");
let removeFileButton = document.querySelector(".remove-file-icon");
let uploadButton = document.querySelector(".upload-button");
let fileFlag = 0;

fileInput.addEventListener("click", () => {
  fileInput.value = '';
  console.log(fileInput.value);
});

fileInput.addEventListener("change", e => {
  console.log(" > " + fileInput.value)
  uploadIcon.innerHTML = 'check_circle';
  dragDropText.innerHTML = 'File Dropped Successfully!';
  document.querySelector(".label").innerHTML = `drag & drop or <span class="browse-files"> <input type="file" class="default-file-input" style=""/> <span class="browse-files-text" style="top: 0;"> browse file</span></span>`;
  uploadButton.innerHTML = `Upload`;
  fileName.innerHTML = fileInput.files[0].name;
  fileSize.innerHTML = (fileInput.files[0].size/1024).toFixed(1) + " KB";
  uploadedFile.style.cssText = "display: flex;";
  progressBar.style.width = 0;
  fileFlag = 0;
});

uploadButton.addEventListener("click", () => {
  let isFileUploaded = fileInput.value;
  if(isFileUploaded != '') {
    if (fileFlag == 0) {
        fileFlag = 1;
        var width = 0;
        var id = setInterval(frame, 50);
        function frame() {
            if (width >= 390) {
              clearInterval(id);
          uploadButton.innerHTML = `<span class="material-icons-outlined upload-button-icon"> check_circle </span> Uploaded`;
            } else {
              width += 5;
              progressBar.style.width = width + "px";
            }
        }
      }
  } else {
    cannotUploadMessage.style.cssText = "display: flex; animation: fadeIn linear 1.5s;";
  }
});

cancelAlertButton.addEventListener("click", () => {
  cannotUploadMessage.style.cssText = "display: none;";
});

if(isAdvancedUpload) {
  ["drag", "dragstart", "dragend", "dragover", "dragenter", "dragleave", "drop"].forEach( evt => 
    draggableFileArea.addEventListener(evt, e => {
      e.preventDefault();
      e.stopPropagation();
    })
  );

  ["dragover", "dragenter"].forEach( evt => {
    draggableFileArea.addEventListener(evt, e => {
      e.preventDefault();
      e.stopPropagation();
      uploadIcon.innerHTML = 'file_download';
      dragDropText.innerHTML = 'Drop your file here!';
    });
  });

  draggableFileArea.addEventListener("drop", e => {
    uploadIcon.innerHTML = 'check_circle';
    dragDropText.innerHTML = 'File Dropped Successfully!';
    document.querySelector(".label").innerHTML = `drag & drop or <span class="browse-files"> <input type="file" class="default-file-input" style=""/> <span class="browse-files-text" style="top: -23px; left: -20px;"> browse file</span> </span>`;
    uploadButton.innerHTML = `Upload`;
    
    let files = e.dataTransfer.files;
    fileInput.files = files;
    console.log(files[0].name + " " + files[0].size);
    console.log(document.querySelector(".default-file-input").value);
    fileName.innerHTML = files[0].name;
    fileSize.innerHTML = (files[0].size/1024).toFixed(1) + " KB";
    uploadedFile.style.cssText = "display: flex;";
    progressBar.style.width = 0;
    fileFlag = 0;
  });
}

removeFileButton.addEventListener("click", () => {
  uploadedFile.style.cssText = "display: none;";
  fileInput.value = '';
  uploadIcon.innerHTML = 'file_upload';
  dragDropText.innerHTML = 'Drag & drop any file here';
  document.querySelector(".label").innerHTML = `or <span class="browse-files"> <input type="file" class="default-file-input"/> <span class="browse-files-text">browse file</span> <span>from device</span> </span>`;
  uploadButton.innerHTML = `Upload`;
});



</script>
<script>
$(document).ready(function() {
    // Add new input field on click of add button
    $(document).on('click', '.add_btn', function() {
        let newInput = `
        <div class="input_wrapper d-flex order_online_sec mt-2">
            <input type="text" name="order_online[]" class="form-control" style="width:90%;" placeholder="Enter a website">
            <span class="remove_btn" style="cursor:pointer; color:red;"><i class="fa fa-minus" aria-hidden="true"></i></span>
        </div>`;
        $('#order_online').append(newInput);
    });

    // Remove input field on click of remove button
    $(document).on('click', '.remove_btn', function() {
        $(this).parent('.input_wrapper').remove();
    });
});

$(document).ready(function() {
    // Add new input field on click of add button
    $(document).on('click', '.add_btn_food', function() {
        let newInput = `
        <div class="input_wrapper_food order_online_sec d-flex  mt-2">
            <input type="text" name="order_food[]" class="form-control" style="width:90%;" placeholder="Enter a website">
            <span class="remove_btn_food" style="cursor:pointer; color:red;"><i class="fa fa-minus" aria-hidden="true"></i></span>
        </div>`;
        $('#order_food').append(newInput);
    });

    // Remove input field on click of remove button
    $(document).on('click', '.remove_btn_food', function() {
        $(this).parent('.input_wrapper_food').remove();
    });
});

$(document).ready(function() {
        var multipleCancelButton = new Choices('#choices-multiple-days-button', {
            removeItemButton: true,
            maxItemCount: 100,
            searchResultLimit: 100,
            renderChoiceLimit: 100,
            shouldSort: false 
        });
    });
</script>
@endsection