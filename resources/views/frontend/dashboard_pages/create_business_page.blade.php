@extends('layouts.user_dashboard.userdashboardlayout')
@section('content')
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
  .stepwizard-step p {
    margin-top: 10px;
}
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

.choices__list--dropdown .choices__item {
    word-break: break-word !important;
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
      <h1 class="h3 mb-0 text-gray-800 fw-bold">Create a Business Page </h1>
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
                  <form role="form" id="businessForm" action="{{route('business_page.save')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="category" value="1" >
                    <div class="row setup-content" id="step-1">
                        <div class="col-md-12">
                          <h4 class="fw-bold">Let’s start with your Business Details</h4>
                          <p>You can add your business details so that we can help you claim your Business Page.</p>
                          <div class="form-group">
                            <label class="control-label">Business Name</label>
                            <input type="text" class="form-control" name="business_name" placeholder="Enter Business Name" value="" required>
                          </div>
                          <div class="form-group">
                            <label class="control-label">Business Type (Sub Categories)</label>
                            <select class="form-control-xs selectpicker" name="sub_category[]" multiple data-size="7" data-live-search="true" data-title="Sub categories" id="sub_category" data-width="100%">
                            @foreach($categories as $cate)
                            <option data-tokens="{{$cate->title}}" value="{{$cate->id}}">{{$cate->title}}</option>
                            @endforeach
                            <option class="Other-cate" value="Other">Other</option>
                            </select>
                            <input type="text" class="form-control d-none mt-2" id="Other-cate-input" name="sub_category_oth" placeholder="Sub category name" value="">
                          </div>




                          {{-- <div class="form-group">
                           <label class="control-label">Add a Button</label>
                           <select class="form-control" name="add_button" required>
                             <option value="Order Online">Order Online</option>
                             <option value="Book">Book</option>
                             <option value="Purchase">Purchase</option>
                             <option value="Learn More">Learn More</option>
                             <option value="Reserve">Reserve </option>
                             <option value="Gift Cards">Gift Cards</option>
                             <option value="Shop Now">Shop Now</option>
                             <option value="Watch Video">Watch Video</option>
                         </select>
                         </div> --}}

                          <label for="toggleCheckbox" class="checkbox-label">
                              Add a button
                              <input type="checkbox" name="add_button" id="toggleCheckbox">
                          </label>
                      

                          <div id="link-section" class="d-none">
                            <a href="#order_online" class="active_btn" data-target="#order_online">Order Online</a>
                            <a href="#book" data-target="#book">Book</a>
                            <a href="#purchase" data-target="#purchase">Purchase</a>
                            <a href="#learn_more" data-target="#learn_more">Learn more</a>
                            <a href="#order_food" data-target="#order_food">Order food</a>
                            <a href="#reserve" data-target="#reserve">Reserve</a>
                            <a href="#gift_cards" data-target="#gift_cards">Gift cards</a>
                            <a href="#contact_us" data-target="#contact_us">Contact us</a>
                            <a href="#shop_now" data-target="#shop_now">Shop now</a>
                            <a href="#watch_video" data-target="#watch_video">Watch video</a>
                            <a href="#sign_up" data-target="#sign_up">Sign up</a>
                            <a href="#send_email" data-target="#send_email">Send email</a>
                            <a href="#whats_app" data-target="#whats_app">Whats app</a>
                            <a href="#follow" data-target="#follow">Follow</a>
                            <a href="#start_order" data-target="#start_order">Start order</a>
                            <a href="#join" data-target="#join">Join</a>
                          </div>

                          <div id="input-section">
                            <div class="link-input" id="order_online">
                                <div class="input_wrapper order_online_sec">
                                    <input type="text" name="order_online[]" class="form-control" style="width:90%;" placeholder="Enter a link">
                                    <span class="add_btn"><i class="fa fa-plus" aria-hidden="true"></i></span>
                                </div>
                            </div>
                            <input type="text" name="book[]" id="book" class="form-control link-input" placeholder="Enter a link">
                            <input type="text" name="purchase[]" id="purchase" class="form-control link-input" placeholder="Enter a link">
                            <input type="text" name="learn_more[]" id="learn_more" class="form-control link-input" placeholder="Enter a link ">
                            <div class="link-input" id="order_food">
                                <div class="input_wrapper_food d-flex order_online_sec">
                                    <input type="text" name="order_food[]" class="form-control" style="width:90%;" placeholder="Enter a link">
                                    <span class="add_btn_food"><i class="fa fa-plus" aria-hidden="true"></i></span>
                                </div>
                            </div>
                            <!-- <input type="text" name="order_food" id="order_food" class="form-control link-input" placeholder="Enter link here"> -->
                            <input type="text" name="reserve[]" id="reserve" class="form-control link-input" placeholder="Enter a link">
                            <input type="text" name="gift_cards[]" id="gift_cards" class="form-control link-input" placeholder="Enter a link">
                            <input type="text" name="contact_us[]" id="contact_us" class="form-control link-input" placeholder="Enter a link ">
                            <input type="text" name="shop_now[]" id="shop_now" class="form-control link-input" placeholder="Enter a link">
                            <input type="text" name="watch_video[]" id="watch_video" class="form-control link-input" placeholder="Enter a link">
                            <input type="text" name="sign_up[]" id="sign_up" class="form-control link-input" placeholder="Enter a link">
                            <input type="text" name="send_email[]" id="send_email" class="form-control link-input" placeholder="Enter a link">
                            <input type="text" name="whats_app[]" id="whats_app" class="form-control link-input" placeholder="Enter a link">
                            <input type="text" name="follow[]" id="follow" class="form-control link-input" placeholder="Enter a link">
                            <input type="text" name="start_order[]" id="start_order" class="form-control link-input" placeholder="Enter a link">
                            <input type="text" name="join[]" id="join" class="form-control link-input" placeholder="Enter a link">
                          </div>

                          
                          <div class="form-group">
                            
                            <label class="control-label">Choose Your Choice</label>
                            <select class="form-control" name="choices[]" id="choices-multiple-remove-button" multiple="multiple" required>
                              <option value="Access">Access</option>
                              <option value="Accessible Restroom and Accessible Seating">Accessible restroom and accessible seating</option>
                              <option value="Accessible parking near entrance">Accessible parking near entrance</option>
                              <option value="Accepts Cash">Accepts Cash</option>
                              <option value="Accepts Credit Cards">Accepts Credit Cards</option>
                              <option value="Accepts Insurance">Accepts Insurance</option>
                              <option value="Breakfast">Breakfast</option>
                              <option value="Brunch">Brunch</option>
                              <option value="Bike Parking">Bike Parking</option>
                              <option value="Beer and Wine">Beer and wine</option>
                              <option value="By Appointment Only">By Appointment Only</option>
                              <option value="Catering">Catering</option>
                              <option value="Curbside Pickup">Curbside pickup</option>
                              <option value="Delivery">Delivery</option>
                              <option value="Dinner">Dinner</option>
                              <option value="Drive Through">Drive through</option>
                              <option value="EV Charging Station Available">EV charging station available</option>
                              <option value="Good for Kids">Good for kids</option>
                              <option value="Happy Hour">Happy hour</option>
                              <option value="Kitchen">Kitchen</option>
                              <option value="Lunch">Lunch</option>
                              <option value="No Steps or Stairs">No steps or stairs</option>
                              <option value="Online Service Hours">Online service hours</option>
                              <option value="Online Ordering">Online ordering</option>
                              <option value="Outdoor Dining">Outdoor dining</option>
                              <option value="Pickup">Pickup</option>
                              <option value="Pet Friendly">Pet friendly</option>
                              <option value="Senior Hour">Senior hour</option>
                              <option value="Take Out">Take out</option>
                              <option value="Vegetarian Options">Vegetarian options</option>
                              <option value="Rooftop Seating">Rooftop seating</option>
                              <option value="Wifi">Wifi</option>
                              <option value="Wheelchair Accessible">Wheelchair accessible</option>
                          </select>                          
                      </div>


                      <div class="form-group">
                            <label class="control-label">Choose Parking</label>
                            <select class="form-control" name="parking[]" id="choices-multiple-days-button" multiple="multiple" required>
                              <option value="Valet">Valet</option>
                              <option value="Garage, Street">Garage</option>
                              <option value="Garage, Street">Street</option>
                              <option value="Private Lot">Private Lot</option>
                              <option value="Validated">Validated</option>
                          </select>
                      </div>


                      <div class="form-group">
                            <label class="control-label">Location of service</label>
                            <select class="form-control" name="location_of_service"  id="choices-multiple-days-location" required>
                              <option value="Garage, Street">At a practice</option>
                              <option value="Garage, Street">At my home</option>
                              <option value="Private Lot">Virtual</option>
                          </select>
                      </div>
                      <div class="form-group">
                      <label class="labels">Which languages do you speak? (Please choose only languages that you speak well enough to interact with customers.)</label>
                            <select class="form-control" name="speak_language[]" id="choices-multiple-remove-button" multiple="multiple">
                              <option value="Portuguese">Portuguese</option>
                              <option value="Romanian">Romanian</option>
                              <option value="Russian">Russian</option>
                              <option value="Spanish">Spanish</option>
                              <option value="Swedish ">Swedish </option>
                              <option value="Turkish">Turkish</option>
                              <option value="Afrikaans">Afrikaans</option>
                              <option value="Arabic">Arabic</option>
                              <option value="Czech">Czech</option>
                              <option value="English">English</option>
                              <option value="Estonian">Estonian</option>
                              <option value="Finnish ">Finnish </option>
                              <option value="French">French</option>
                              <option value="German">German</option>
                              <option value="Greek">Greek</option>
                              <option value="Hebrew">Hebrew</option>
                              <option value="Hungarian">Hungarian</option>
                              <option value="Italian">Italian</option>
                              <option value="Japanese ">Japanese </option>
                              <option value="Norwegian">Norwegian</option>
                              <option value="Polish">Polish</option>
                          </select>
                      </div>


                    <div class="form-group">
                      <label>Explore holistic services</label>
                      <select class="form-control" name="holistic_services" id="therapy_options">
                        <option value="Access Consciousness">Access Consciousness</option>
                        <option value="Acupuncture">Acupuncture</option>
                        <option value="Animal Wellness">Animal Wellness</option>
                        <option value="Art Therapy">Art Therapy</option>
                        <option value="Ayurveda">Ayurveda</option>
                        <option value="Biofeedback">Biofeedback</option>
                        <option value="Body Code">Body Code</option>
                        <option value="BodyTalk">BodyTalk</option>
                        <option value="Bodywork">Bodywork</option>
                        <option value="Breathwork">Breathwork</option>
                        <option value="Chiropractic">Chiropractic</option>
                        <option value="Colon Hydrotherapy">Colon Hydrotherapy</option>
                        <option value="Counseling">Counseling</option>
                        <option value="Couples Counseling">Couples Counseling</option>
                        <option value="Craniosacral Therapy">Craniosacral Therapy</option>
                        <option value="EMDR">EMDR</option>
                        <option value="Emotional Freedom Technique">Emotional Freedom Technique</option>
                        <option value="Emotion Code">Emotion Code</option>
                        <option value="End of Life Doula">End of Life Doula</option>
                        <option value="Energy Work">Energy Work</option>
                        <option value="Epigenetics">Epigenetics</option>
                        <option value="Functional Medicine">Functional Medicine</option>
                        <option value="Healing Touch">Healing Touch</option>
                        <option value="Health Coaching">Health Coaching</option>
                        <option value="Herbalism">Herbalism</option>
                        <option value="Holistic Dentistry">Holistic Dentistry</option>
                        <option value="Holistic Primary Care">Holistic Primary Care</option>
                        <option value="Holistic Skin Care">Holistic Skin Care</option>
                        <option value="Homeopathy">Homeopathy</option>
                        <option value="Human Design">Human Design</option>
                        <option value="Hypnotherapy">Hypnotherapy</option>
                        <option value="Lactation Consulting">Lactation Consulting</option>
                        <option value="Low-Level Laser Therapy">Low-Level Laser Therapy</option>
                        <option value="Lymphatic Drainage">Lymphatic Drainage</option>
                        <option value="Marriage & Family Therapy">Marriage & Family Therapy</option>
                        <option value="Massage Therapy">Massage Therapy</option>
                        <option value="Meditation">Meditation</option>
                        <option value="Midwife">Midwife</option>
                        <option value="Myofascial Release">Myofascial Release</option>
                        <option value="Naturopathic Medicine">Naturopathic Medicine</option>
                        <option value="Network Chiropractic">Network Chiropractic</option>
                        <option value="Neurofeedback">Neurofeedback</option>
                        <option value="Neurolinguistic Programming">Neurolinguistic Programming</option>
                        <option value="Neuromuscular Therapy">Neuromuscular Therapy</option>
                        <option value="Nutrition">Nutrition</option>
                        <option value="Occupational Therapy">Occupational Therapy</option>
                        <option value="Osteopathic Medicine">Osteopathic Medicine</option>
                        <option value="Pelvic Floor Therapy">Pelvic Floor Therapy</option>
                        <option value="PEMF">PEMF</option>
                        <option value="Personal Training">Personal Training</option>
                        <option value="Physical Therapy">Physical Therapy</option>
                        <option value="Pilates">Pilates</option>
                        <option value="Plant Medicine">Plant Medicine</option>
                        <option value="Pregnancy">Pregnancy</option>
                        <option value="Psychedelic Integration">Psychedelic Integration</option>
                        <option value="Psychedelic Therapy">Psychedelic Therapy</option>
                        <option value="PSYCH-K">PSYCH-K</option>
                        <option value="Psychotherapy">Psychotherapy</option>
                        <option value="Qi Gong">Qi Gong</option>
                        <option value="Quantum Healing">Quantum Healing</option>
                        <option value="Rapid Transformational Therapy">Rapid Transformational Therapy</option>
                        <option value="Reflexology">Reflexology</option>
                        <option value="Reiki">Reiki</option>
                        <option value="Rolfing">Rolfing</option>
                        <option value="Sex Therapy">Sex Therapy</option>
                        <option value="Shamanic Journeying">Shamanic Journeying</option>
                        <option value="Somatic Experiencing">Somatic Experiencing</option>
                        <option value="Sound Therapy">Sound Therapy</option>
                        <option value="Tai Chi">Tai Chi</option>
                        <option value="Torque Release Technique">Torque Release Technique</option>
                        <option value="Trauma Release Exercises">Trauma Release Exercises</option>
                        <option value="Upper Cervical Chiropractic">Upper Cervical Chiropractic</option>
                        <option value="Yoga Therapy">Yoga Therapy</option>
                      </select>
                    </div>

                    <div class="form-group">
                        <label>State license number (optional)</label>
                        <input type="text" value="" name="state_license_number" class="form-control" placeholder="State license number" >
                    </div>

                    <div class="form-group">
                        <label>Contractor license number (optional)</label>
                        <input type="text" value="" name="contractor_license_number" class="form-control" placeholder="State license number" >
                    </div>
                    
                      
                      <label for="toggleCheckbox" class="checkbox-label">
                          Offers free consult
                          <input type="checkbox" name="offers_free_consult" id="toggleCheckbox">
                      </label>
                
                          
                          <button class="btn profile-button nextBtn btn-lg pull-right mb-1" type="button">Next</button>
                        </div>
                    </div>
                    <div class="row setup-content" id="step-2">
                        <div class="col-md-12">
                          <h4 class="fw-bold">Let’s add your Contact Info </h4>
                          <p>You can add your contact details so that we can help you claim your Business Page.</p>
                          <div class="form-group">
                            <label class="control-label">Email</label>
                            <input type="email" class="form-control" name="business_email" placeholder="Enter Your Email" value="">
                          </div>
                          <div class="form-group">
                            <label class="labels">Phone No.</label>
                            <input type="tel" class="form-control" id="phone" placeholder="1234567890" value="">
                            <input type="hidden" id="full_phone" name="phone" value="{{ old('full_phone', $business->business_phone ?? '') }}">
                          </div>
                          <div class="form-group">
                            <label class="labels">Website</label>
                            <input type="text" class="form-control" name="business_website" placeholder="Enter Your Website" value="">
                          </div>

                          <div class="form-group">
                            <label class="labels">Description</label>
                            <textarea id="editor1" class="form-control" name="business_description" placeholder="Description"><?php echo old('description'); ?></textarea>
                          </div>
                          
                          <button class="btn profile-button mb-1 prevBtn btn-lg pull-left" type="button">Previous</button>
                          
                          <button class="btn profile-button mb-1 nextBtn btn-lg pull-right" type="button">Next</button>
                        </div>
                    </div>
                    <div class="row setup-content" id="step-3">
                    <div class="col-md-12">
                        <h4 class="fw-bold">Locations</h4>
                        <p>Business location</p>
                        
                        <div id="address-container">
                            <div class="address-group">
                                <div class="form-group">
                                    <label class="labels">Address 1</label>
                                    <input type="text" class="form-control" name="address_1[]" placeholder="Enter Your Address" value="">
                                </div>
                                <div class="form-group">
                                    <label class="labels">Address 2 (Optional)</label>
                                    <input type="text" class="form-control" name="address_2[]" placeholder="Enter Your Address" value="">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Country</label>
                                    <input type="text" value="" name="country[]" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">State</label>
                                    <input type="text" value="" name="state[]" class="form-control">
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-8">
                                        <label class="control-label">City</label>
                                        <input type="text" class="form-control" name="city[]" placeholder="Enter Your City" value="">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="control-label">Postal Code</label>
                                        <input type="text" class="form-control" name="zip_code[]" maxlength="6" placeholder="111111" value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Choose Your Location</label>
                                    <input name="location[]" type="text" class="form-control get_loc" placeholder="Location">
                                    <div class="searcRes" id="autocomplete-results"></div>
                                </div>
                            </div>
                        </div>
                          <button type="button" id="add-location" class="btn btn-primary" style="float:right">Add Location</button><br><br>
                          <button class="btn profile-button mb-1 prevBtn btn-lg pull-left" type="button">Previous</button>
                          <button class="btn profile-button mb-1 nextBtn btn-lg pull-right" type="button">Next</button>
                      </div>
                    </div>

                    
                    <div class="row setup-content" id="step-4">
                    <div class="col-md-12">
                        <h4 class="fw-bold">Opening hours</h4>
                        <div class="form-group">
                          <div class="manage_section">
                            <label class="control-label">Opening Hours</label> <button type="button" class="btn managepost managebtn" data-toggle="modal" data-target="#exampleModal_hours">Manage service hours</button>
                          </div>
                           <select name="opening_hours[]" class="form-control form-control-xs selectpicker" data-size="7" data-live-search="true" data-title="Hours" id="sub_category" data-width="100%" multiple>
                           <?php
                           
                              // Sort days according to sorter
                              foreach ($data as $value) {
                                  echo "<option value=\"$value\">$value</option>";
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
                                <div class="video_gallery" id="sortableImgThumbnailPreview_video"></div>
                                @error('image')
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
                            
                              <div class="gallery" id="sortableImgThumbnailPreview"></div>
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
                                  
                                  
                                  <div class="logo_gallery" id="sortableImgThumbnailPreview"></div>
                                  
                                
                                  @error('image')
                                  <small class="text-danger">{{ $message }}</small>
                                  @enderror
                              </div>
                          </div>
                      </div>


                        <button class="btn profile-button mb-1 prevBtn btn-lg pull-left" type="button">Previous</button>
                        
                        <button class="btn profile-button mb-1 nextBtn btn-lg pull-right" type="button">Next</button>
                      </div>
                    </div>
                    <div class="row setup-content" id="step-5">
                      <div class="col-md-12">
                      <h4 class="fw-bold">Social Media Links</h4>
                        <div class="form-group">
                            <label class="labels">Facebook</label>
                            <input type="text" class="form-control" name="facebook" value="" placeholder="https://facebook.com">
                        </div>
                        <div class="form-group">
                            <label class="labels">Youtube</label>
                            <input type="text" class="form-control" name="youtube" value="" placeholder="https://youtube.com">
                        </div>
                        <div class="form-group">
                            <label class="labels">Instagram</label>
                            <input type="text" class="form-control" name="instagram" value="" placeholder="https://instagram.com">
                        </div>
                        <div class="form-group">
                            <label class="labels">Tiktok</label>
                            <input type="text" class="form-control" name="tiktok" value="" placeholder="https://tiktok.com">
                        </div>
                        <div class="form-group">
                            <label class="labels">Whatsapp</label>
                            <input type="text" class="form-control" id="whatsapp" name="whatsapp" value="" placeholder="+1 1234567890">
                        </div>

                        <button class="btn profile-button mb-1 prevBtn btn-lg pull-left" type="button">Previous</button>
                        <button class="btn profile-button mb-1 nextBtn btn-lg pull-right addCategory" id="submitButton" type="submit">Submit</button>
                      </div>
                    </div>
                   
                  </form> 
                </div>
                <div class="col-md-6">
                  <div class="business-img-frame">
                    
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
      <h5>Elevate your practice at FindersPage, our goal is simple: To bring you more clients. We connect you with real people in your area who are seeking your services.</h5>
      <div class="text-info-services">
      We believe that every person is unique, and it's our passion to refer you clients who will appreciate and benefit from your own brand. 
Take a look around and we know you'll agree that FindersPage is a world-class website. So what are you waiting for? Start getting more clients today!
      </div>
      </div>
    </div>
  </div>
</div>




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
  $(document).ready(function() {
        var multipleCancelButton = new Choices('#choices-multiple-days-button', {
            removeItemButton: true,
            maxItemCount: 100,
            searchResultLimit: 100,
            renderChoiceLimit: 100,
            shouldSort: false 
        });
    });

  $(document).ready(function() {
        var multipleCancelButton = new Choices('#choices-multiple-days-location', {
            removeItemButton: true,
            maxItemCount: 100,
            searchResultLimit: 100,
            renderChoiceLimit: 100,
            shouldSort: false 
        });
    });

  function toggleTimeInputs(day, checkbox) {
        const openTimeInput = document.getElementById('open_time_' + day);
        const closeTimeInput = document.getElementById('close_time_' + day);

        if (checkbox.checked) {
            // Set time values to blank "--:--" and disable inputs
            openTimeInput.value = '';
            closeTimeInput.value = '';
            openTimeInput.disabled = true;
            closeTimeInput.disabled = true;
        } else {
            // Re-enable inputs if unchecked and reset the time values (if needed)
            openTimeInput.disabled = false;
            closeTimeInput.disabled = false;
        }
    }
</script>

  <script src="https://cdn.jsdelivr.net/npm/jquery@3/dist/jquery.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
  <script>
    
$(document).ready(function() {
  var input = document.querySelector("#phone");
    var iti = window.intlTelInput(input, {
      initialCountry: "auto",
      geoIpLookup: function(callback) {
        fetch('https://ipinfo.io', {
          headers: {
            'Accept': 'application/json'
          }
        }).then(function(resp) {
          return resp.json()
        }).then(function(resp) {
          callback(resp.country);
        }).catch(function() {
          callback("us");
        });
      },
      utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
    });
    input.addEventListener('focusout', function() {
    // Get the full phone number with country code
    var fullPhoneNumber = iti.getNumber(); // This will give the full international phone number
    alert(fullPhoneNumber); // Alert the full phone number
  });
});


$(document).ready(function() {
    $('#add-location').on('click', function() {
        // Clone the first address group
        var newAddressGroup = $('.address-group').first().clone();

        // Clear the values in the cloned group
        newAddressGroup.find('input').val('');

        // Create and append the Remove button
        var removeButton = $('<button type="button" class="btn btn-danger remove-location">Remove</button>');
        newAddressGroup.append(removeButton);

        // Append the cloned group to the address container
        $('#address-container').append(newAddressGroup);
    });

    // Remove location functionality
    $(document).on('click', '.remove-location', function() {
        $(this).closest('.address-group').remove();
    });
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
      // alert(subcate_title);
      if (subcate_title == "") {
            // alert(subcate_title);
            $('#businessForm').submit();
            return false;
        }
        e.preventDefault();
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
</script>

@endsection