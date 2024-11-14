@extends('layouts.user_dashboard.userdashboardlayout')

@section('content')
<?php use App\Models\UserAuth;
    $userdata = UserAuth::getLoginUser();
    
    

    // dd($days, $status, $open_time, $close_time);
    
   
    //  dd($status, $open_time, $close_time); 
 
?>
<script>
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
<style type="text/css">
.mycheckbox {display: flex;justify-content: space-between;padding-right: 158px;}
.mycheckbox input.form-control {font-size: 2px;}
.select-down_discount {position: absolute;right: 12px;top: 12px;z-index: 1;font-size: 15px;}
.select-down-language {position: absolute;right: 12px;top: 12px;z-index: 1;font-size: 15px;}
#servicesForm .select-down{right: 12px !important;top: 12px !important;}
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
.managepost{
background: linear-gradient(90deg, rgba(170, 137, 65, 1) 0%, rgba(205, 156, 49, 1) 13%, rgba(154, 128, 73, 1) 35%, rgba(246, 204, 78, 1) 51%, rgba(181, 147, 56, 1) 75%, rgba(163, 136, 68, 1) 100%);
/* width: 130px; *//* height: 40px; */margin-top: -8px;border-radius: 0.35rem;border: 0px;box-shadow: none;padding: 0.375rem 0.35rem;
font-size: .75rem;font-weight: 400;line-height: 1.5;position: relative;top: -5px;}
.error-message {color: #e74a3b;}
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

<div class="container px-sm-5 px-4 pb-4">
    <form method="post" action="<?php echo route('add_services'); ?>" enctype="multipart/form-data" id="servicesForm_1">
        {{ @csrf_field() }}
        <!-- Page Heading -->
        <div class="d-sm-flex flex-column  mb-3">
            <h1 class="h3 mb-0 text-gray-800 fw-bold">Create Service Listing</h1>
            <p> If you don't want to create a business page, you can create a simple service listing below.</p>
        </div>
        <span>
            @include('admin.partials.flash_messages')
        </span>
        <input type="hidden" name="categories" value="705">

        <div class="row bg-white border-radius pb-4 p-3">
            <div class="col-md-6 mb-4">
                <label class="labels">Title <sup>*</sup></label>
                <input type="text" id="title-input" class="form-control" name="title" placeholder="Title" value="<?php echo old('title'); ?>">
                <span class="error-message" ></span>
                <!-- @error('title')
                <small class="text-danger">{{ $message }}</small>
                @enderror -->
            </div>

            <div class="col-md-6 mb-4">
                <label class="labels">Service type <sup>*</sup></label>
                
                <select name="sub_category" class="form-control form-control-xs selectpicker" data-size="7" data-live-search="true" data-title="Service type" id="sub_category" data-width="100%">

                    @foreach($categories as $cate)
                    <option value="{{$cate->id}}">{{$cate->title}}</option>
                    @endforeach
                    <option class="Other-cate" value="Other">Other</option>
                </select>

                <div class="mt-3 massage_type_box">
                    <label for="massage_type" style=" font-size:14px; font-weight: 700;" >Style(s): (Do not include phone numbers or e-mail addresses here.)</label>
                 <input type="text" class="form-control" style="font-size:13px;" placeholder="Enter massage type"  name="" id="massage_type">
                </div>

                <input type="text" class="form-control d-none mt-2" id="Other-cate-input" name="sub_category_oth" placeholder="sub_category name" value="">

                @error('sub_categories')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="col-md-6 mb-4">
                <label class="labels">Offered</label>
                <select name="offerd[]" class="form-control form-control-xs selectpicker" data-size="7" data-live-search="true" data-title="Offered" id="sub_category" data-width="100%" multiple>
                    
                    <option value="outcall">Mobile</option>
                    <option value="Offered in person">Offered in person</option>
                    <option value="Offered virtual">Offered virtual</option>
                </select>
                @error('offerd')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

    
            <div class="col-md-6 mb-4">
                <label class="labels">Want to reach a larger audience? Add Location</label>
                <input name="location" type="text" class="form-control get_loc" id="location" value="" placeholder="Location">
                <div class="searcRes" id="autocomplete-results">

                </div>
            </div>
            

            <div class="col-md-6 mb-4">
            <label class="labels" data-toggle="tooltip" data-placement="top" title="Any photo that signals an intention to commit, solicit, promote or encourage a criminal act and/or violate the  Advertiser Agreement will not be accepted.">Post featured image <em>(Select multiple)</em> <i class="fa fa-question popup2"> </i></label>
                
                <div class="upload-icon"><a class="cam btn btn-warning"  href="javascript:void(0)">
                    <i class="fa fa-upload" aria-hidden="true"></i>
                        Upload image
                    </a> 
                </div>
               
                <div class="gallery" id="sortableImgThumbnailPreview"></div>
                <div class="show-img">
                </div>
                @error('image')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            {{-- <div class="col-md-6 mb-4">
                <label class="labels"> Post video format: .mp4 | max size: 2MB <em>(Select multiple)</em></label>
                <div class="image-upload">
                    <label style="cursor: pointer;" for="video_upload">
                        <img src="" alt="" class="uploaded-image">
                        <div class="h-100">
                            <div class="dplay-tbl">
                                <div class="dplay-tbl-cell">
                                    <!-- <i class="fas fa-cloud-upload-alt mb-3"></i> -->
                                    <!-- <h6><b>Upload Video</b></h6> -->
                                    <i class="far fa-file-video mb-3"></i>
                                    <h6 class="mt-10 mb-70">Upload or drop your video here</h6>
                                </div>
                            </div>
                        </div><!--upload-content-->
                        <input data-required="image" type="file" accept="video/*" id="video_upload" class="image-input" data-traget-resolution="image_resolution" name="post_video" value="">
                    </label>
                </div>
                <div class="show-video d-none">
                    <video controls id="video-tag">
                        <source id="video-source" src="splashVideo">
                        Your browser does not support the video tag.
                    </video>
                    <i class="fas fa-times" id="cancel-btn-1"></i>
                    @error('post_video')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div> --}}
            <div class="col-md-6 mb-4">
                <label class="labels">Do you offer special discounts for any of the following groups?(Optional)</label>
                <div class="position-relative">
                <i class="fas fa-angle-down select-down_discount"></i>
                <select class="form-control" name="special_discounts[]" id="choices-multiple-remove-button" multiple="multiple">
                    <option value="First-time clients">First-time clients</option>
                    <option value="Military veterans ">Military veterans </option>
                    <option value="Students">Students</option>
                    <option value="Active military">Active military</option>
                    <option value="Repeat clients">Repeat clients</option>
                    <!-- <option value="Ask for details">Ask for details</option> -->
                    <option value="Senior citizens">Senior citizens</option>
                    <option value="SAG/Equity members">SAG/Equity members</option>
                    <option value="Visiting clients">Visiting clients</option>
                    <option value="Birthdays">Birthdays</option>
                    <option value="Emergency workers">Emergency workers</option>
                </select>
                </div>
                @error('benifits')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="col-md-6 mb-4">
                <label class="labels">Which languages do you speak? (Please choose only languages that you speak well enough to interact with customers.)</label>
                <div class="position-relative">
                <i class="fas fa-angle-down select-down-language"></i>
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
                @error('benifits')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <?php
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
            
            ?>


            <div  class="col-md-6 mb-4">
                <div class="manage_section">
                    <label class="labels">In-studio hours</label> 
                    <button type="button" class="btn managepost managebtn" data-toggle="modal" data-target="#exampleModal_hours">Manage service hours</button>
                </div>
                <div class="position-relative" id="manageSectionDiv">
                <i class="fas fa-angle-down select-down"></i>
                <select  class="form-control day_sorter" name="working_hours[]" id="choices-multiple-days-button" multiple="multiple">
                    <?php
                    // Sort days according to sorter

                    
                    foreach ($data as $sortDay => $value) {
                        echo "<option value=\"$value\">$value</option>";
                    }
                    ?>
                </select>
                </div>
                @error('working_hours')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="col-md-6 mb-4">
                <label class="labels">Do you offer any of the following amenities</label>
                <div class="position-relative">
                <i class="fas fa-angle-down select-down"></i>
                <select class="form-control" name="amenities[]" id="choices-multiple-remove-button" multiple="multiple">
                    <option value="Music">Music </option>
                    <option value="Dogs allowed">Dogs allowed</option>
                    <option value="Coffee">Coffee</option>
                    <option value="Metered parking">Metered parking</option>
                    <option value="Private parking">Private parking</option>
                    <option value="Fully handicap accessible">Fully handicap accessible</option>
                    <option value="Free parking">Free parking</option>
                    <option value="Bottled water">Bottled water</option>
                    <option value="Second entrance/ Doorman">Second entrance/ Doorman</option>
                    <option value="Private restroom ">Private restroom </option>
                    <option value="Tea">Tea</option>
                    <option value="Wine">Wine</option>
                </select>
                </div>
                @error('benifits')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-6 mb-4">
                <label class="labels">Which of the following payment methods do you accept?</label>
                <div class="position-relative">
                <i class="fas fa-angle-down select-down"></i>
                <select class="form-control" name="payment_preffer[]" id="choices-multiple-remove-button" multiple="multiple">
                    <option value="American Express">American Express</option>
                    <option value="Apple Pay">Apple Pay</option>
                    <option value="Dash">Dash</option>
                    <!-- <option value="Barter">Barter</option>
                    <option value="Bitcoin">Bitcoin</option> -->
                    <option value="Cash">Cash</option>
                    <option value="Check">Check</option>
                    <option value="Discover">Discover</option>
                    <!-- <option value="Ether">Ether</option> -->
                    <option value="Google Wallet">Google Wallet</option>
                    <option value="Mastercard">Mastercard</option>
                    <option value="Paypal">Paypal</option>
                    <option value="QuickPay">QuickPay</option>
                    <option value="Ripple">Ripple</option>
                    <!-- <option value="Samsung Pay">Samsung Pay</option> -->
                    <!-- <option value="Square Cash">Square Cash</option> -->
                    <option value="Venmo">Venmo</option>
                    <option value="Visa">Visa</option>
                    <option value="Zelle">Zelle</option>
                </select>
                </div>
                @error('benifits')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-6 mb-4">
                <label class="labels">Enter the currency, which is rendered at your services.</label>
                <div class="position-relative">
                <i class="fas fa-angle-down select-down"></i>
                <select class="form-control" name="currency_accept[]" id="choices-multiple-remove-button" multiple="multiple">
                    <option value="US$">US$</option>
                    <option value="CA$">CA$</option>
                    <option value="pond">£</option>
                    <option value="AU$">AU$</option>
                    <option value="DKK">DKK</option>
                    <option value="SEK">SEK</option>
                    <option value="NOK">NOK</option>
                    <option value="CHF">CHF</option>
                    <option value="euro">€</option>
                    <option value="czech">Kč</option>
                    <option value="R$">R$</option>
                    <option value="py6">py6</option>
                    <option value="zt">zt</option>
                </select>
                </div>
                @error('benifits')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="col-md-6 mb-4">
                <label class="labels">Fees (optional) (Do not include phone numbers or e-mail addresses here.)</label>
                <input type="text" class="form-control" name="fees" placeholder="Enter fees" value="<?php echo old('fees'); ?>">
                <span class="error-message" ></span>
               
            </div>

            <div class="col-md-12 mb-4">
                <label class="labels">Description</label>
                <div id="summernote">
                    <textarea rows="4" cols="50" id="editor1" class="form-control" name="description" placeholder="Description"><?php echo old('description'); ?></textarea>
                    @error('description')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="col-md-12 mb-4">

                <div class="col-md-12 mt-4">
                    <label class="custom-toggle">
                        <input type="checkbox" name="personal_detail" value="true"> &nbsp;&nbsp;<span>Show your contact details. Keep in mind if you want customers to reach you outside of FindersPage you will need to make your contact details visible to the public.</span>
                    </label>
                </div>
                <div class="row">
                    <div class="col-md-6 mt-4 ">
                        <label class="custom-toggle">Email</label>
                        <input type="email" class="form-control" name="email" value="" placeholder="example@example.com">

                    </div>
                    <div class="col-md-6 mt-4">
                        <label class="custom-toggle">Phone number</label>
                        <input type="tel" class="form-control" id="phone" name="phone" value="" placeholder="+1 1234567890">
                    </div>
                    <div class="col-md-6 mt-4">
                        <label class="custom-toggle">Website link</label>
                        <input type="text" class="form-control"  name="website" value="" placeholder="https://test.com">
                    </div>
                    <div class="col-md-6 mt-4">
                        <label class="custom-toggle">Whatsapp</label>
                        <input type="tel" class="form-control" id="whatsapp" name="whatsapp" value="" placeholder="whatsapp number">
                    </div>
                    <!-- <div class="col-md-2 mt-4">
                        <label class="custom-toggle">Twitter</label>
                        <input type="text" class="form-control" name="twitter" value="" placeholder="https://twitter.com/">
                    </div>
                    <div class="col-md-2 mt-4">
                        <label class="custom-toggle">Youtube </label>
                        <input type="text" class="form-control" name="youtube" value="" placeholder="https://www.youtube.com/channel">
                    </div>
                    <div class="col-md-2 mt-4">
                        <label class="custom-toggle">Facebook</label>
                        <input type="text" class="form-control" name="facebook" value="" placeholder="https://www.facebook.com">
                    </div>
                    <div class="col-md-2 mt-4">
                        <label class="custom-toggle">Instagram</label>
                        <input type="text" class="form-control" name="instagram" value="" placeholder="https://www.instagram.com">
                    </div>
                    <div class="col-md-2 mt-4">
                        <label class="custom-toggle">Linkedin </label>
                        <input type="text" class="form-control" name="linkedin" value="" placeholder="https://www.linkedin.com/">
                    </div>
                    <div class="col-md-2 mt-4">
                        <label class="custom-toggle">Tiktok </label>
                        <input type="text" class="form-control" name="tiktok" value="" placeholder="https://www.tiktok.com/@">
                    </div> -->
                </div>
            </div>
        </div>




        @include('inc.alert_message')
        <input type="hidden" name="post_type" value="Normal Post" >
         
       


        <div class="mt-5 text-center"><button class="btn profile-button addCategory" type="submit">Publish</button></div>
</div>
</form>
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
        <div class="modal-footer">
          
        </div>
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
    if (!sessionStorage.getItem('modalShown')) {
      // Set a timeout to show the modal after 5 seconds
      setTimeout(function() {
        $('#staticBackdrop_services').modal('show');
        // Mark the modal as shown in sessionStorage
        sessionStorage.setItem('modalShown', 'true');
      }, 5000); // 5000 milliseconds = 5 seconds
    }
  });
</script>

    <script type="text/javascript">
        jQuery(document).ready(function() {
            $("#country_name").on("change", function() {
                var country_id = $(this).val();
                var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                $.ajax({
                    url: baseurl + '/filter/job/state',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        id: country_id

                    },
                    success: function(response) {
                        console.log(response);
                        $("#state_name").html(response.option_html);
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });

            });
        });
        $("#state_name").on("change", function() {
            var country_id = $(this).val();

            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            $.ajax({
                url: baseurl + '/filter/job/city',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    id: country_id
                },
                success: function(response) {
                    console.log(response);
                    $("#city_name").html(response.option_html);
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        });

        $(document).ready(function() {
            var isChecked1 = $('input[name="personal_detail"]').is(':checked');
            console.log(isChecked1);
            if (isChecked1 === true) {
                $('.hidesection').removeClass('d-none');
            } else {
                $('.hidesection').addClass('d-none');
            }
            $('input[name="personal_detail"]').on('click', function() {
                var isChecked = $(this).is(':checked');
                console.log(isChecked);
                if (isChecked === true) {
                    $('.hidesection').removeClass('d-none');
                } else {
                    $('.hidesection').addClass('d-none');
                }


            });
        });

        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });

        $(document).ready(function() {
        $('#saveChangesBtn').on('click', function(e) {
            e.preventDefault(); // Prevent default form submission
            var formData = $('#hoursForm').serialize(); // Serialize form data

            $.ajax({
                url: $('#hoursForm').attr('action'), // Form action URL
                type: 'POST',
                data: formData,
                success: function(response) {
                    // Handle success
                    // alert('Hours saved successfully!');
                    $('#exampleModal_hours').modal('hide'); // Hide the modal
                    // Reload the content of the div with id 'manageSectionDiv'
                    $('#manageSectionDiv').load(location.href + ' #manageSectionDiv');
                    

                    setTimeout(function() {
                    var multipleCancelButton = new Choices('#choices-multiple-days-button', {
                        removeItemButton: true,
                        maxItemCount: 100,
                        searchResultLimit: 100,
                        renderChoiceLimit: 100,
                        shouldSort: false 
                    });
                }, 1000);  // 1000 milliseconds = 1 second
                },
                error: function(xhr, status, error) {
                    // Handle error
                    alert('An error occurred while saving the hours.');
                }
            });
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
            $('.addCategory').click(function(e) {
                var subcate_title = $('#Other-cate-input').val();
                
                var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                if (subcate_title == "") {
                    // alert(subcate_title);
                    $('#servicesForm_1').submit();
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
                        parent_id: 705,
                    },
                    success: function(response) {
                        console.log(response);
                        $('#servicesForm_1').submit();
                    },
                    error: function(xhr, status, error) {

                    }
                });
            });
        });

    // Massage box jquery code

        $(document).ready(function() {
            $('.massage_type_box').hide();
            $('#sub_category').change(function() {
                var selectedValue = $(this).val(); 
                if (selectedValue == '1343') {
                    $('.massage_type_box').show(); 
                } else {
                    $('.massage_type_box').hide(); 
                }
            });
        });

    </script>

@endsection