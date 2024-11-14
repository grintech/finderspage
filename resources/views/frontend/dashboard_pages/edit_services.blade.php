@extends('layouts.user_dashboard.userdashboardlayout')
@section('content')
<?php  use Carbon\Carbon; ?>
<?php use App\Models\UserAuth;
      $userdata = UserAuth::getLoginUser();
    //   dd($blog); 
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
<style>
.bootstrap-select.btn-group > .dropdown-toggle {height: 100%;border: 1px solid #bdbdbd; background-color: #fff;}
.bootstrap-select.btn-group > .dropdown-toggle:focus{border-color: #ac8b42; background-color: #fff;}
.select-down_discount {position: absolute;right: 12px;top: 60px;z-index: 1;font-size: 15px;}
.select-down-language {position: absolute;right: 12px;top: 60px;z-index: 1;font-size: 15px;}
.uploaded-image i {position: absolute !important;right: 6px !important;top: 4px !important;color: #ff0101 !important;margin: 0 !important;}
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
/* width: 130px; *//* height: 40px; */margin-top: -8px;border-radius: 0.35rem;border: 0px;box-shadow: none;padding: 0.375rem 0.35rem;font-size: .75rem;
font-weight: 400;line-height: 1.5;position: relative;top: -5px;}
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
    <form method="post" action="<?php echo route('edit_services', $blog->slug); ?>" class="form-validation" enctype="multipart/form-data" id="">
        {{ @csrf_field() }}
        <!-- Page Heading -->
        <div class="d-sm-flex flex-column  mb-3">
            <h1 class="h3 mb-0 text-gray-800 fw-bold">Edit Service Listing</h1>
            <!-- <p>Choose the best category that fits your needs and create a free Service post</p> -->
        </div>
        <span>
            @include('admin.partials.flash_messages')
        </span>
        <input type="hidden" name="categories" value="705">
        <?php 
            $currentDateTime = new DateTime();
            $givenTime = $blog->created; // Assuming $post->created_at is a valid date string

            // Convert the given time to a Carbon instance
            $givenDateTime = Carbon::parse($givenTime);

            // Add 10 days to the given date time
            $nextTenDays = $givenDateTime->addDays(10);

        ?> 
        <div class="row bg-white border-radius pb-4 p-3">
            @if($currentDateTime > $nextTenDays)
            <div class="col-md-6 mb-4">
                <label class="labels">Title <sup>*</sup></label>
                <input type="text" id="title-input" class="form-control" name="title" placeholder="Title" value="{{$blog->title}}" required readonly data-toggle="tooltip" data-placement="top" title="You can't make edits as you created this post more than 10 days ago.">
                <span class="error-message" id="title-error"></span>
                @error('title')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            @else
            <div class="col-md-6 mb-4">
                <label class="labels">Title <sup>*</sup></label>
                <input type="text" id="title-input" class="form-control" name="title" placeholder="Title" value="{{$blog->title}}" required>
                <span class="error-message" id="title-error"></span>
                @error('title')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            @endif


            {{-- @if($currentDateTime > $nextTenDays)  
            <div class="col-md-6 mb-4">
                <label class="labels">Service type <sup>*</sup></label>
                @foreach($categories as $cate)
                    @if($blog->sub_category == $cate->id)
                        <input type="text" value="{{$cate->title}}" class="form-control mb-2" readonly data-toggle="tooltip" data-placement="top" title="You can't make edits as you created this post more than 10 days ago.">
                        <input type="hidden" name="sub_category" value="{{$cate->id}}">
                    @endif
                @endforeach
            </div>
            @else
            <div class="col-md-6 mb-4">
                <label class="labels">Service type <sup>*</sup></label>
                <select name="sub_category" id="sub_categories" class="form-control form-control-xs selectpicker" data-size="7" data-live-search="true" data-title="Services type" id="state_list" data-width="100%" required>

                    @foreach($categories as $cate)
                    <option value="{{$cate->id}}" {{ $blog->sub_category == $cate->id ? 'selected' : '' }}>{{$cate->title}}</option>
                    @endforeach
                </select>
                <span class="error-message" id="title-error"></span>
                @error('sub_categories')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            @endif --}}


            <div class="col-md-6 mb-4">
                <label class="labels">Service type <sup>*</sup></label>
                <select name="sub_category" id="sub_categories" class="form-control form-control-xs selectpicker" data-size="7" data-live-search="true" data-title="Service type" id="state_list" data-width="100%" required>

                    @foreach($categories as $cate)
                    <option value="{{$cate->id}}" {{ $blog->sub_category == $cate->id ? 'selected' : '' }}>{{$cate->title}}</option>
                    @endforeach
                </select>
                <span class="error-message" id="title-error"></span>
                @error('sub_categories')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <!-- <div class="col-md-6 mb-4">
                            <label class="labels">Service date </label>
                            <input type="date" name="service_date" class="form-control" value="{{$blog->service_date}}">
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="labels">Service time </label>
                            <input type="time" name="service_time" class="form-control" value="@if(isset($blog->service_time)){{$blog->service_time}}@endif">
                        </div>
 -->

            {{-- @if($currentDateTime > $nextTenDays)  
            <div class="col-md-6 mb-4">
                <label class="labels">Offer</label>
                
                <input type="text" value="{{ $blog->offerd }}" class="form-control mb-2" readonly data-toggle="tooltip" data-placement="top" title="You can't make edits as you created this post more than 10 days ago.">
                <input type="hidden" name="offerd" value="{{ $blog->offerd }}">
            </div>
            @else
            <div class="col-md-6 mb-4">
                <label class="labels">Offer</label>
                <select name="offerd" class="form-control form-control-xs selectpicker" data-size="7" data-live-search="true" data-title="Offer" id="sub_category" data-width="100%">
                    <option value="All Offered" {{ $blog->offerd == 'All Offered' ? 'selected' : '' }}>All offered</option>
                    <option value="outcall" {{ $blog->offerd == 'outcall' ? 'selected' : '' }}>outcall</option>
                    <option value="Or both" {{ $blog->offerd == 'Or both' ? 'selected' : '' }}>Or both</option>
                    <option value="Offered in person" {{ $blog->offerd == 'Offered in person' ? 'selected' : '' }}>Offered in person</option>
                    <option value="Offered virtual" {{ $blog->offerd == 'Offered virtual' ? 'selected' : '' }}>Offered virtual</option>
                </select>
                @error('offerd')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            @endif --}}
            <div class="col-md-6 mb-4">
                <label class="labels">Offered</label>
                <select name="offerd[]" class="form-control form-control-xs selectpicker" data-size="7" data-live-search="true" data-title="Offered" id="sub_category" data-width="100%" multiple>
                    <?php 
                    // Decode and check if offerd is a valid array
                    $offerd = json_decode($blog->offerd);
                    if (!is_array($offerd)) {
                        $offerd = [];
                    }
                    ?>
                    <option value="Mobile" {{ in_array('Mobile', $offerd) ? 'selected' : '' }}>Mobile</option>
                    <option value="Offered in person" {{ in_array('Offered in person', $offerd) ? 'selected' : '' }}>Offered in person</option>
                    <option value="Offered virtual" {{ in_array('Offered virtual', $offerd) ? 'selected' : '' }}>Offered virtual</option>
                </select>
                @error('offerd')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="col-md-6 mb-4">
                <label class="labels">Want to reach a larger audience? Add location</label>
                <input name="location" type="text" class="form-control get_loc" id="location" value="{{$blog->location}}" placeholder="Enter location">
                <div class="searcRes" id="autocomplete-results">

                </div>
            </div>
            <!-- <div class="col-md-6 mb-4">
                            <label class="labels">Country </label>
                             <select title="Select Country" name="country" class="form-control" id="country_name" post-id="{{$blog->id}}">      
                                <option value="">Select Country</option>
                                <?php
                                foreach ($countries as $key => $element) { ?>
                                    <option  value="<?php echo $element['id']; ?>" {{ $blog->country == $element['id'] ? 'selected' : '' }}> <?php echo $element['name']; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                             @error('country')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div> -->
            <!-- <div class="col-md-6 mb-4">
                            <label class="labels">State </label>
                             <select title="Select Country" name="state"  class="form-control state1" id="state_name" >     
                                <option value="">Select State</option>
                                
                            </select>
                             @error('state')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div> -->

            <!-- <div class="col-md-6 mb-4">
                            <label class="labels">City </label>
                             <select title="Select Country" name="city" class="form-control" id="city_name">      
                                <option value="">Select City</option>
                            </select>
                             @error('city')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div> -->
            <!-- <div class="col-md-12 mb-4">
                            <label class="labels">Zip Code </label>
                            <input name="zipcode" type="text" maxlength="8" class="form-control" id="Zipcode" value="{{$blog->zipcode}}" placeholder="zipcode">
                             @error('zipcode')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div> -->

            <div class="col-md-6 mb-4">
            <label class="labels" data-toggle="tooltip" data-placement="top" title="Any photo that signals an intention to commit, solicit, promote or encourage a criminal act and/or violate the  Advertiser Agreement will not be accepted.">Post featured image <em>(Select multiple)</em> <i class="fa fa-question popup2"> </i></label>
             
                <div class="upload-icon"><a class="cam btn btn-warning" href="javascript:void(0)">
                    <i class="fa fa-upload" aria-hidden="true"></i>
                        Upload image
                    </a> 
                </div>
               

                <div class="show-img" id="image-container">
                    @if($blog->image1)
                    <?php
                    $neimg = trim($blog->image1, '[""]');
                    $img  = explode('","', $neimg);

                    // echo "<pre>";print_r($img);die('dev');
                    ?>
                    <div class="gallery">
                        @foreach($img as $index => $images)
                        <div class='apnd-img'>
                            <img src="{{ asset('images_blog_img') }}/{{ $images }}" id='img' remove_name="{{ $images }}" dataid="{{$blog->id}}" class='img-responsive'>
                            @if($currentDateTime < $nextTenDays) 
                            <i class='fa fa-trash delfile'></i>
                            @endif
                            
                        </div>
                        
                        @endforeach
                    </div>
                    @else
                    <div class="show-img" id="image-container">
                        <div class="gallery">
                        </div>
                    </div>
                    @endif
                </div>

                <script>
                    $(function() {
                        $("#image-container").sortable({
                            update: function(event, ui) {
                                var newImageOrder = [];
                                $("#image-container img").each(function() {
                                    var src = $(this).attr('src');
                                    newImageOrder.push(src);
                                });
                                console.log(newImageOrder);

                                $.ajax({
                                    url: '/edit/services/{slug}', // Replace with your actual route URL
                                    type: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    data: {
                                        newImageOrder: newImageOrder
                                    },
                                    success: function(response) {
                                        console.log(response); // Handle success response from server
                                    },
                                    error: function(xhr, status, error) {
                                        console.error(xhr.responseText); // Handle error response from server
                                    }
                                });
                            }
                        });
                    
                        $("#image-container").disableSelection();
                    });
                </script>


                @error('image')
                <small class="text-danger">{{ $message }}</small>
                @enderror

            </div>

            <?php
            $speak_languageArray = explode(",", $blog->speak_language);
            $speak_languageArray = array_map(function ($element) {
                return str_replace(array('[', ']', '"'), '', $element);
            }, $speak_languageArray);
            // echo "<pre>";print_r($blog->choice);die();
            ?>
            <div class="col-md-6 mb-4">
                <label class="labels">Which languages do you speak? (Please choose only languages that you speak well enough to interact with customers.)</label>
                <div class="position-relative">
                    <i class="fas fa-angle-down select-down-language"></i>
                    <select class="form-control" name="speak_language[]" id="choices-multiple-remove-button" multiple="multiple">
                        <option value="Portuguese" {{ in_array('Portuguese', $speak_languageArray) ? 'selected' : '' }}>Portuguese</option>
                        <option value="Romanian" {{ in_array('Romanian', $speak_languageArray) ? 'selected' : '' }}>Romanian</option>
                        <option value="Russian" {{ in_array('Russian', $speak_languageArray) ? 'selected' : '' }}>Russian</option>
                        <option value="Spanish" {{ in_array('Spanish', $speak_languageArray) ? 'selected' : '' }}>Spanish</option>
                        <option value="Swedish" {{ in_array('Swedish', $speak_languageArray) ? 'selected' : '' }}>Swedish</option>
                        <option value="Turkish" {{ in_array('Turkish', $speak_languageArray) ? 'selected' : '' }}>Turkish</option>
                        <option value="Afrikaans" {{ in_array('Afrikaans', $speak_languageArray) ? 'selected' : '' }}>Afrikaans</option>
                        <option value="Arabic" {{ in_array('Arabic', $speak_languageArray) ? 'selected' : '' }}>Arabic</option>
                        <option value="Czech" {{ in_array('Czech', $speak_languageArray) ? 'selected' : '' }}>Czech</option>
                        <option value="English" {{ in_array('English', $speak_languageArray) ? 'selected' : '' }}>English</option>
                        <option value="Estonian" {{ in_array('Estonian', $speak_languageArray) ? 'selected' : '' }}>Estonian</option>
                        <option value="Finnish" {{ in_array('Finnish', $speak_languageArray) ? 'selected' : '' }}>Finnish</option>
                        <option value="French" {{ in_array('French', $speak_languageArray) ? 'selected' : '' }}>French</option>
                        <option value="German" {{ in_array('German', $speak_languageArray) ? 'selected' : '' }}>German</option>
                        <option value="Greek" {{ in_array('Greek', $speak_languageArray) ? 'selected' : '' }}>Greek</option>
                        <option value="Hebrew" {{ in_array('Hebrew', $speak_languageArray) ? 'selected' : '' }}>Hebrew</option>
                        <option value="Hungarian" {{ in_array('Hungarian', $speak_languageArray) ? 'selected' : '' }}>Hungarian</option>
                        <option value="Italian" {{ in_array('Italian', $speak_languageArray) ? 'selected' : '' }}>Italian</option>
                        <option value="Japanese" {{ in_array('Japanese', $speak_languageArray) ? 'selected' : '' }}>Japanese</option>
                        <option value="Norwegian" {{ in_array('Norwegian', $speak_languageArray) ? 'selected' : '' }}>Norwegian</option>
                        <option value="Polish" {{ in_array('Polish', $speak_languageArray) ? 'selected' : '' }}>Polish</option>
                    </select>
                </div>
                @error('benifits')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <?php
            $benefitsArray = explode(",", $blog->special_discounts);
            $benefitsArray = array_map(function ($element) {
                return str_replace(array('[', ']', '"'), '', $element);
            }, $benefitsArray);
            // echo "<pre>";print_r($blog->choice);die();
            ?>
           
    
            <div class="col-md-6 mb-4">
                <label class="labels">Do you offer special discounts for any of the following groups?(Optional)</label>
                <div class="position-relative">
                    <i class="fas fa-angle-down select-down_discount"></i>
                    <select class="form-control" name="special_discounts[]" id="choices-multiple-remove-button" multiple="multiple">
                        <option value="">Select an discounts</option>
                        <option value="First-time clients" {{ in_array('First-time clients', $benefitsArray) ? 'selected' : '' }}>First-time clients</option>
                        <option value="Military veterans" {{ in_array('Military veterans', $benefitsArray) ? 'selected' : '' }}>Military veterans</option>
                        <option value="Students" {{ in_array('Students', $benefitsArray) ? 'selected' : '' }}>Students</option>
                        <option value="Active military" {{ in_array('Active military', $benefitsArray) ? 'selected' : '' }}>Active military</option>
                        <option value="Repeat clients" {{ in_array('Repeat clients', $benefitsArray) ? 'selected' : '' }}>Repeat clients</option>
                        <option value="Ask for details" {{ in_array('Ask for details', $benefitsArray) ? 'selected' : '' }}>Ask for details</option>
                        <option value="Senior citizens" {{ in_array('Senior citizens', $benefitsArray) ? 'selected' : '' }}>Senior citizens</option>
                        <option value="SAG/Equity members" {{ in_array('SAG/Equity members', $benefitsArray) ? 'selected' : '' }}>SAG/Equity members</option>
                        <option value="Visiting clients" {{ in_array('Visiting clients', $benefitsArray) ? 'selected' : '' }}>Visiting clients</option>
                        <option value="Birthdays" {{ in_array('Birthdays', $benefitsArray) ? 'selected' : '' }}>Birthdays</option>
                        <option value="Emergency workers" {{ in_array('Emergency workers', $benefitsArray) ? 'selected' : '' }}>Emergency workers</option>
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

            <?php
            $working_hoursArray = explode(",", $blog->working_hours);
            $working_hoursArray = array_map(function ($element) {
                return str_replace(array('[', ']', '"'), '', $element);
            }, $working_hoursArray);
            // echo "<pre>";print_r($working_hoursArray);die();
            ?>

            <div class="col-md-6 mb-4">
                <div class="manage_section">
                    <label class="labels">In-studio hours</label>
                    <button type="button" class="btn managepost managebtn" data-toggle="modal" data-target="#exampleModal_hours">Manage service hours</button>
                </div>

                <div class="position-relative" id="manageSectionDiv">
                  
                    <i class="fas fa-angle-down select-down"></i>
                    <select class="form-control day_sorter" name="working_hours[]" id="choices-multiple-days-button" multiple="multiple">
                        <?php
                        // Add each value from $data as an option once
                        foreach ($data as $sortDay => $value) {
                            $selected = in_array($value, $working_hoursArray) ? 'selected' : '';
                            echo "<option value=\"$value\" $selected>$value</option>";
                        }
                        ?>
                    </select>
              
                </div>
                @error('working_hours')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        

            <?php
            $amenitiesArray = explode(",", $blog->amenities);
            $amenitiesArray = array_map(function ($element) {
                return str_replace(array('[', ']', '"'), '', $element);
            }, $amenitiesArray);
            ?>

            {{-- @if($currentDateTime > $nextTenDays)  
            <div class="col-md-6 mb-4">
                <label class="labels">Do you offer any of the following amenities</label>
                <input type="text" value="{{ implode(', ', $amenitiesArray) }}" class="form-control mb-2" readonly data-toggle="tooltip" data-placement="top" title="You can't make edits as you created this post more than 10 days ago.">
                @foreach($amenitiesArray as $amenities)
                    <input type="hidden" name="amenities" value="{{ $amenities }}">
                @endforeach
            </div>
            @else
            <div class="col-md-6 mb-4">
                <label class="labels">Do you offer any of the following amenities</label>
                <div class="position-relative">
                    <i class="fas fa-angle-down select-down"></i>
                    <select class="form-control" name="amenities[]" id="choices-multiple-remove-button" multiple="multiple">
                        <option value="Music" {{ in_array('Music', $amenitiesArray) ? 'selected' : '' }}>Music</option>
                        <option value="Dogs allowed" {{ in_array('Dogs allowed', $amenitiesArray) ? 'selected' : '' }}>Dogs allowed</option>
                        <option value="Coffee" {{ in_array('Coffee', $amenitiesArray) ? 'selected' : '' }}>Coffee</option>
                        <option value="Metered parking" {{ in_array('Metered parking', $amenitiesArray) ? 'selected' : '' }}>Metered parking</option>
                        <option value="Private parking" {{ in_array('Private parking', $amenitiesArray) ? 'selected' : '' }}>Private parking</option>
                        <option value="Fully handicap accessible" {{ in_array('Fully handicap accessible', $amenitiesArray) ? 'selected' : '' }}>Fully handicap accessible</option>
                        <option value="Free parking" {{ in_array('Free parking', $amenitiesArray) ? 'selected' : '' }}>Free parking</option>
                        <option value="Bottled water" {{ in_array('Bottled water', $amenitiesArray) ? 'selected' : '' }}>Bottled water</option>
                        <option value="Second entrance/ Doorman" {{ in_array('Second entrance/ Doorman', $amenitiesArray) ? 'selected' : '' }}>Second entrance/ Doorman</option>
                        <option value="Private restroom" {{ in_array('Private restroom', $amenitiesArray) ? 'selected' : '' }}>Private restroom</option>
                        <option value="Tea" {{ in_array('Tea', $amenitiesArray) ? 'selected' : '' }}>Tea</option>
                        <option value="Wine" {{ in_array('Wine', $amenitiesArray) ? 'selected' : '' }}>Wine</option>
                    </select>
                </div>
                @error('benifits')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            @endif --}}

            <div class="col-md-6 mb-4">
                <label class="labels">Do you offer any of the following amenities</label>
                <div class="position-relative">
                    <i class="fas fa-angle-down select-down"></i>
                    <select class="form-control" name="amenities[]" id="choices-multiple-remove-button" multiple="multiple">
                        <option value="Music" {{ in_array('Music', $amenitiesArray) ? 'selected' : '' }}>Music</option>
                        <option value="Dogs allowed" {{ in_array('Dogs allowed', $amenitiesArray) ? 'selected' : '' }}>Dogs allowed</option>
                        <option value="Coffee" {{ in_array('Coffee', $amenitiesArray) ? 'selected' : '' }}>Coffee</option>
                        <option value="Metered parking" {{ in_array('Metered parking', $amenitiesArray) ? 'selected' : '' }}>Metered parking</option>
                        <option value="Private parking" {{ in_array('Private parking', $amenitiesArray) ? 'selected' : '' }}>Private parking</option>
                        <option value="Fully handicap accessible" {{ in_array('Fully handicap accessible', $amenitiesArray) ? 'selected' : '' }}>Fully handicap accessible</option>
                        <option value="Free parking" {{ in_array('Free parking', $amenitiesArray) ? 'selected' : '' }}>Free parking</option>
                        <option value="Bottled water" {{ in_array('Bottled water', $amenitiesArray) ? 'selected' : '' }}>Bottled water</option>
                        <option value="Second entrance/ Doorman" {{ in_array('Second entrance/ Doorman', $amenitiesArray) ? 'selected' : '' }}>Second entrance/ Doorman</option>
                        <option value="Private restroom" {{ in_array('Private restroom', $amenitiesArray) ? 'selected' : '' }}>Private restroom</option>
                        <option value="Tea" {{ in_array('Tea', $amenitiesArray) ? 'selected' : '' }}>Tea</option>
                        <option value="Wine" {{ in_array('Wine', $amenitiesArray) ? 'selected' : '' }}>Wine</option>
                    </select>
                </div>
                @error('benifits')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <?php
            $payment_prefferArray = explode(",", $blog->payment_preffer);
            $payment_prefferArray = array_map(function ($element) {
                return str_replace(array('[', ']', '"'), '', $element);
            }, $payment_prefferArray);
            ?>

            {{-- @if($currentDateTime > $nextTenDays)  
            <div class="col-md-6 mb-4">
                <label class="labels">Which of the following payment methods do you accept?</label>
                <input type="text" value="{{ implode(', ', $payment_prefferArray) }}" class="form-control mb-2" readonly data-toggle="tooltip" data-placement="top" title="You can't make edits as you created this post more than 10 days ago.">
                @foreach($payment_prefferArray as $payment_preffer)
                    <input type="hidden" name="payment_preffer" value="{{ $payment_preffer }}">
                @endforeach
            </div>
            @else
            <div class="col-md-6 mb-4">
                <label class="labels">Which of the following payment methods do you accept?</label>
                <div class="position-relative">
                    <i class="fas fa-angle-down select-down"></i>
                    <select class="form-control" name="payment_preffer[]" id="choices-multiple-remove-button" multiple="multiple">
                        <option value="American Express" {{ in_array('American Express', $payment_prefferArray) ? 'selected' : '' }}>American Express</option>
                        <option value="Apple Pay" {{ in_array('Apple Pay', $payment_prefferArray) ? 'selected' : '' }}>Apple Pay</option>
                        <option value="Dash" {{ in_array('Dash', $payment_prefferArray) ? 'selected' : '' }}>Dash</option>
                        <option value="Barter" {{ in_array('Barter', $payment_prefferArray) ? 'selected' : '' }}>Barter</option>
                        <option value="Bitcoin" {{ in_array('Bitcoin', $payment_prefferArray) ? 'selected' : '' }}>Bitcoin</option>
                        <option value="Cash" {{ in_array('Cash', $payment_prefferArray) ? 'selected' : '' }}>Cash</option>
                        <option value="Check" {{ in_array('Check', $payment_prefferArray) ? 'selected' : '' }}>Check</option>
                        <option value="Discover" {{ in_array('Discover', $payment_prefferArray) ? 'selected' : '' }}>Discover</option>
                        <option value="Ether" {{ in_array('Ether', $payment_prefferArray) ? 'selected' : '' }}>Ether</option>
                        <option value="Google Wallet" {{ in_array('Google Wallet', $payment_prefferArray) ? 'selected' : '' }}>Google Wallet</option>
                        <option value="Mastercard" {{ in_array('Mastercard', $payment_prefferArray) ? 'selected' : '' }}>Mastercard</option>
                        <option value="Paypal" {{ in_array('Paypal', $payment_prefferArray) ? 'selected' : '' }}>Paypal</option>
                        <option value="QuickPay" {{ in_array('QuickPay', $payment_prefferArray) ? 'selected' : '' }}>QuickPay</option>
                        <option value="Ripple" {{ in_array('Ripple', $payment_prefferArray) ? 'selected' : '' }}>Ripple</option>
                        <option value="Samsung Pay" {{ in_array('Samsung Pay', $payment_prefferArray) ? 'selected' : '' }}>Samsung Pay</option>
                        <option value="Square Cash" {{ in_array('Square Cash', $payment_prefferArray) ? 'selected' : '' }}>Square Cash</option>
                        <option value="Venmo" {{ in_array('Venmo', $payment_prefferArray) ? 'selected' : '' }}>Venmo</option>
                        <option value="Visa" {{ in_array('Visa', $payment_prefferArray) ? 'selected' : '' }}>Visa</option>
                        <option value="Zelle" {{ in_array('Zelle', $payment_prefferArray) ? 'selected' : '' }}>Zelle</option>
                    </select>
                </div>
                @error('benifits')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            @endif --}}

            <div class="col-md-6 mb-4">
                <label class="labels">Which of the following payment methods do you accept?</label>
                <div class="position-relative">
                    <i class="fas fa-angle-down select-down"></i>
                    <select class="form-control" name="payment_preffer[]" id="choices-multiple-remove-button" multiple="multiple">
                        <option value="American Express" {{ in_array('American Express', $payment_prefferArray) ? 'selected' : '' }}>American Express</option>
                        <option value="Apple Pay" {{ in_array('Apple Pay', $payment_prefferArray) ? 'selected' : '' }}>Apple Pay</option>
                        <option value="Dash" {{ in_array('Dash', $payment_prefferArray) ? 'selected' : '' }}>Dash</option>
                        <option value="Barter" {{ in_array('Barter', $payment_prefferArray) ? 'selected' : '' }}>Barter</option>
                        <option value="Bitcoin" {{ in_array('Bitcoin', $payment_prefferArray) ? 'selected' : '' }}>Bitcoin</option>
                        <option value="Cash" {{ in_array('Cash', $payment_prefferArray) ? 'selected' : '' }}>Cash</option>
                        <option value="Check" {{ in_array('Check', $payment_prefferArray) ? 'selected' : '' }}>Check</option>
                        <option value="Discover" {{ in_array('Discover', $payment_prefferArray) ? 'selected' : '' }}>Discover</option>
                        <option value="Ether" {{ in_array('Ether', $payment_prefferArray) ? 'selected' : '' }}>Ether</option>
                        <option value="Google Wallet" {{ in_array('Google Wallet', $payment_prefferArray) ? 'selected' : '' }}>Google Wallet</option>
                        <option value="Mastercard" {{ in_array('Mastercard', $payment_prefferArray) ? 'selected' : '' }}>Mastercard</option>
                        <option value="Paypal" {{ in_array('Paypal', $payment_prefferArray) ? 'selected' : '' }}>Paypal</option>
                        <option value="QuickPay" {{ in_array('QuickPay', $payment_prefferArray) ? 'selected' : '' }}>QuickPay</option>
                        <option value="Ripple" {{ in_array('Ripple', $payment_prefferArray) ? 'selected' : '' }}>Ripple</option>
                        <option value="Samsung Pay" {{ in_array('Samsung Pay', $payment_prefferArray) ? 'selected' : '' }}>Samsung Pay</option>
                        <option value="Square Cash" {{ in_array('Square Cash', $payment_prefferArray) ? 'selected' : '' }}>Square Cash</option>
                        <option value="Venmo" {{ in_array('Venmo', $payment_prefferArray) ? 'selected' : '' }}>Venmo</option>
                        <option value="Visa" {{ in_array('Visa', $payment_prefferArray) ? 'selected' : '' }}>Visa</option>
                        <option value="Zelle" {{ in_array('Zelle', $payment_prefferArray) ? 'selected' : '' }}>Zelle</option>
                    </select>
                </div>
                @error('benifits')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <?php
            $currency_acceptArray = explode(",", $blog->currency_accept);
            $currency_acceptArray = array_map(function ($element) {
                return str_replace(array('[', ']', '"'), '', $element);
            }, $currency_acceptArray);
            ?>

            {{-- @if($currentDateTime > $nextTenDays)  
            <div class="col-md-6 mb-4">
                <label class="labels">Enter the currency, which is rendered at your services.</label>
                <input type="text" value="{{ implode(', ', $currency_acceptArray) }}" class="form-control mb-2" readonly data-toggle="tooltip" data-placement="top" title="You can't make edits as you created this post more than 10 days ago.">
                @foreach($currency_acceptArray as $currency_accept)
                    <input type="hidden" name="currency_accept" value="{{ $currency_accept }}">
                @endforeach
            </div>
            @else
            <div class="col-md-6 mb-4">
                <label class="labels">Enter the currency, which is rendered at your services.</label>
                <div class="position-relative">
                    <i class="fas fa-angle-down select-down"></i>
                    <select class="form-control" name="currency_accept[]" id="choices-multiple-remove-button" multiple="multiple">
                        <option value="US$" {{ in_array('US$', $currency_acceptArray) ? 'selected' : '' }}>US$</option>
                        <option value="CA$" {{ in_array('CA$', $currency_acceptArray) ? 'selected' : '' }}>CA$</option>
                        <option value="pond" {{ in_array('pond', $currency_acceptArray) ? 'selected' : '' }}>£</option>
                        <option value="AU$" {{ in_array('AU$', $currency_acceptArray) ? 'selected' : '' }}>AU$</option>
                        <option value="DKK" {{ in_array('DKK', $currency_acceptArray) ? 'selected' : '' }}>DKK</option>
                        <option value="SEK" {{ in_array('SEK', $currency_acceptArray) ? 'selected' : '' }}>SEK</option>
                        <option value="NOK" {{ in_array('NOK', $currency_acceptArray) ? 'selected' : '' }}>NOK</option>
                        <option value="CHF" {{ in_array('CHF', $currency_acceptArray) ? 'selected' : '' }}>CHF</option>
                        <option value="euro" {{ in_array('euro', $currency_acceptArray) ? 'selected' : '' }}>€</option>
                        <option value="czech" {{ in_array('czech', $currency_acceptArray) ? 'selected' : '' }}>Kč</option>
                        <option value="R$" {{ in_array('R$', $currency_acceptArray) ? 'selected' : '' }}>R$</option>
                        <option value="py6" {{ in_array('py6', $currency_acceptArray) ? 'selected' : '' }}>py6</option>
                        <option value="zt" {{ in_array('zt', $currency_acceptArray) ? 'selected' : '' }}>zt</option>
                    </select>
                </div>
                @error('benifits')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            @endif --}}

            <div class="col-md-6 mb-4">
                <label class="labels">Enter the currency, which is rendered at your services.</label>
                <div class="position-relative">
                    <i class="fas fa-angle-down select-down"></i>
                    <select class="form-control" name="currency_accept[]" id="choices-multiple-remove-button" multiple="multiple">
                        <option value="US$" {{ in_array('US$', $currency_acceptArray) ? 'selected' : '' }}>US$</option>
                        <option value="CA$" {{ in_array('CA$', $currency_acceptArray) ? 'selected' : '' }}>CA$</option>
                        <option value="pond" {{ in_array('pond', $currency_acceptArray) ? 'selected' : '' }}>£</option>
                        <option value="AU$" {{ in_array('AU$', $currency_acceptArray) ? 'selected' : '' }}>AU$</option>
                        <option value="DKK" {{ in_array('DKK', $currency_acceptArray) ? 'selected' : '' }}>DKK</option>
                        <option value="SEK" {{ in_array('SEK', $currency_acceptArray) ? 'selected' : '' }}>SEK</option>
                        <option value="NOK" {{ in_array('NOK', $currency_acceptArray) ? 'selected' : '' }}>NOK</option>
                        <option value="CHF" {{ in_array('CHF', $currency_acceptArray) ? 'selected' : '' }}>CHF</option>
                        <option value="euro" {{ in_array('euro', $currency_acceptArray) ? 'selected' : '' }}>€</option>
                        <option value="czech" {{ in_array('czech', $currency_acceptArray) ? 'selected' : '' }}>Kč</option>
                        <option value="R$" {{ in_array('R$', $currency_acceptArray) ? 'selected' : '' }}>R$</option>
                        <option value="py6" {{ in_array('py6', $currency_acceptArray) ? 'selected' : '' }}>py6</option>
                        <option value="zt" {{ in_array('zt', $currency_acceptArray) ? 'selected' : '' }}>zt</option>
                    </select>
                </div>
                @error('benifits')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- @if($currentDateTime > $nextTenDays)
            <div class="col-md-6 mb-4">
                <label class="labels">Fees (optional) (Do not include phone numbers or e-mail addresses here.)</label>
                <input type="text" class="form-control" name="fees" placeholder="Enter fees" value="{{ $blog->fees }}" readonly data-toggle="tooltip" data-placement="top" title="You can't make edits as you created this post more than 10 days ago.">
            </div>
            @else
            <div class="col-md-6 mb-4">
                <label class="labels">Fees (optional) (Do not include phone numbers or e-mail addresses here.)</label>
                <input type="text" class="form-control" name="fees" placeholder="Enter fees" value="{{ $blog->fees }}">
                <span class="error-message" ></span>
            </div>
            @endif --}}

            <div class="col-md-6 mb-4">
                <label class="labels">Fees (optional) (Do not include phone numbers or e-mail addresses here.)</label>
                <input type="text" class="form-control" name="fees" placeholder="Enter fees" value="{{ $blog->fees }}">
                <span class="error-message" ></span>
            </div>


            @if($currentDateTime > $nextTenDays)
            <div class="col-md-12 mb-4">
                <label class="labels">Description</label>
                    <textarea class="form-control" name="description" placeholder="Description" readonly data-toggle="tooltip" data-placement="top" title="You can't make edits as you created this post more than 10 days ago.">{{strip_tags($blog->description)}}</textarea>
            </div>
            @else
            <div class="col-md-12 mb-4">
                <label class="labels">Description</label>
                <div id="summernote">
                    <textarea id="editor1" class="form-control" name="description" placeholder="Description">{{strip_tags($blog->description)}}</textarea>
                    @error('description')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            @endif


            <div class="col-md-12 mb-4">

                <div class="col-md-12 mt-4">
                    <label class="custom-toggle">
                        <input type="checkbox" name="personal_detail" value="true" {{ $blog->personal_detail == 'true'? 'checked' : '' }}> &nbsp;&nbsp;<span>Show your contact details. Keep in mind if you want customers to reach you outside of FindersPage you will need to make your contact details visible to the public.</span>
                    </label>
                </div>
                <div class="row">
                    <div class="col-md-6 mt-4 ">
                        <label class="custom-toggle">Email</label>
                        <input type="email"  class="form-control" name="email" value="{{$blog->email}}" placeholder="example@example.com">

                    </div>
                    <div class="col-md-6 mt-4">
                        <label class="custom-toggle">Phone number</label>
                        <input type="tel"  class="form-control" name="phone" id="phone" value="{{$blog->phone}}" placeholder="+1 1234567890">
                    </div>
                    <div class="col-md-6 mt-4">
                        <label class="custom-toggle">Website link</label>
                        <input type="text"  class="form-control" name="website" value="{{$blog->website}}" placeholder="https://test.com">
                    </div>
                    <div class="col-md-6 mt-4">
                        <label class="custom-toggle">Whatsapp</label>
                        <input type="tel"  class="form-control" id="phone" name="whatsapp" value="{{$blog->whatsapp}}" placeholder="whatsapp number">
                    </div>
                    <!-- <div class="col-md-2 mt-4">
                        <label class="custom-toggle">Twitter</label>
                        <input type="text" @if($currentDateTime > $nextTenDays) readonly @endif class="form-control" name="twitter" value="{{$blog->twitter}}" placeholder="https://twitter.com/">
                    </div>
                    <div class="col-md-2 mt-4">
                        <label class="custom-toggle">Youtube </label>
                        <input type="text" @if($currentDateTime > $nextTenDays) readonly @endif class="form-control" name="youtube" value="{{$blog->youtube}}" placeholder="https://www.youtube.com/channel">
                    </div>
                    <div class="col-md-2 mt-4">
                        <label class="custom-toggle">Facebook</label>
                        <input type="text" @if($currentDateTime > $nextTenDays) readonly @endif class="form-control" name="facebook" value="{{$blog->facebook}}" placeholder="https://www.facebook.com">
                    </div>
                    <div class="col-md-2 mt-4">
                        <label class="custom-toggle">Instagram</label>
                        <input type="text" @if($currentDateTime > $nextTenDays) readonly @endif class="form-control" name="instagram" value="{{$blog->instagram}}" placeholder="https://www.instagram.com">
                    </div>
                    <div class="col-md-2 mt-4">
                        <label class="custom-toggle">Linkedin </label>
                        <input type="text" @if($currentDateTime > $nextTenDays) readonly @endif class="form-control" name="linkedin" value="{{$blog->linkedin}}" placeholder="https://www.linkedin.com/">
                    </div>
                    <div class="col-md-2 mt-4">
                        <label class="custom-toggle">Tiktok </label>
                        <input type="text" @if($currentDateTime > $nextTenDays) readonly @endif class="form-control" name="tiktok" value="{{$blog->tiktok}}" placeholder="https://www.tiktok.com/@">
                    </div> -->
                </div>
            </div>
        </div>

        <input type="hidden" name="post_type" value="Normal Post" >
          
        
        <div class="mt-5 text-center"><button class="btn profile-button" type="submit">Update</button></div>
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
    });

    jQuery(document).ready(function() {

        var countryid = $("#country_name").val();
        var userid1 = $('#country_name').attr('post-id');

        console.log(" countryid =>" + countryid);
        console.log("userid1 =>" + userid1);
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        $.ajax({
            url: baseurl + '/edit/filter/state',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {
                id: countryid,
                userid: userid1,
            },
            success: function(response) {
                console.log(response);
                $("#state_name").html(response.option_html);
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });

        setTimeout(function() {
            var stateID1 = $(".state1").val();
            var userid2 = $('#country_name').attr('post-id');
            console.log('stateID1' + stateID1);
            console.log('userid2' + userid2);
            $.ajax({
                url: baseurl + '/edit/filter/city',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    id: stateID1,
                    userid: userid2
                },
                success: function(response) {
                    console.log(response);
                    $("#city_name").html(response.option_html);
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        }, 5000);


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
</script>


@endsection