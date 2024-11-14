@extends('layouts.adminlayout')

@section('content')
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
    .select-down_discount {
        position: absolute;
        right: 24px;
        top: 60px;
        z-index: 1;
        font-size: 15px;
    }

    .select-down-language {
        position: absolute;
        right: 24px;
        top: 60px;
        z-index: 1;
        font-size: 15px;
    }
</style>
<div class="container px-sm-5 px-4">
    <form method="post" action="<?php echo route('service.edit', $blog->id); ?>" class="form-validation" enctype="multipart/form-data" id="">
        {{ @csrf_field() }}
        <!-- Page Heading -->
        <div class="d-sm-flex flex-column  mb-3 pt-4">
            <h1 class="h3 mb-0 text-gray-800 fw-bold custom_title_heading">Edit Service Listing</h1>
            <!-- <p>Choose the best category that fits your needs and create a free Service post</p> -->
        </div>
        <span>
            @include('admin.partials.flash_messages')
        </span>
        <input type="hidden" name="categories" value="705">

        <div class="row bg-white border-radius pb-4 p-3">
            <div class="col-md-6 mb-4">
                <label class="labels">Title <sup>*</sup></label>
                <input type="text" class="form-control" name="title" placeholder="Enter post name" value="{{$blog->title}}" required>
                <span class="error-message" id="title-error"></span>
                @error('title')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="col-md-6 mb-4">
                <label class="labels">Services Type <sup>*</sup></label>
                <select name="sub_category" id="sub_categories" class="form-control form-control-xs selectpicker" data-size="7" data-live-search="true" data-title="Sub Category" id="state_list" data-width="100%" >

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
            <div class="col-md-6 mb-4">
                <label class="labels">Offer</label>
                <select name="offerd" class="form-control form-control-xs selectpicker" data-size="7" data-live-search="true" data-title="offer" id="sub_category" data-width="100%" >
                    <option value="All Offered" {{ $blog->offerd == 'All Offered' ? 'selected' : '' }}>All Offered</option>
                    <option value="outcall" {{ $blog->offerd == 'outcall' ? 'selected' : '' }}>outcall</option>
                    <option value="Or both" {{ $blog->offerd == 'Or both' ? 'selected' : '' }}>Or both</option>
                    <option value="Offered in person" {{ $blog->offerd == 'Offered in person' ? 'selected' : '' }}>Offered in person</option>
                    <option value="Offered virtual" {{ $blog->offerd == 'Offered virtual' ? 'selected' : '' }}>Offered virtual</option>
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
                <label class="labels">Post Featured Image</label>
                <div class="upload-icon"><a class="cam btn btn-warning"  href="javascript:void(0)">
                    <i class="fa fa-upload" aria-hidden="true"></i>
                        upload image
                    </a> 
                </div>
               
                <div class="gallery"></div>

                <div class="show-img ">
                    @if($blog->image1)
                    <?php
                    $neimg = trim($blog->image1, '[""]');
                    $img  = explode('","', $neimg);

                    // echo "<pre>";print_r($img);die('dev');
                    ?>
                    @foreach($img as $images)
                    <img src="{{asset('images_blog_img')}}/{{$images}}" alt="Image" class="uploaded-image" id="image-container">
                    @endforeach
                    @endif
                </div>

                @error('image')
                <small class="text-danger">{{ $message }}</small>
                @enderror

            </div>
            <div class="col-md-6 mb-4">
                <label class="labels"> Post Video Format: .mp4 | max size: 2MB</label>
                <div class="image-upload">
                    <label style="cursor: pointer;" for="video_upload">
                        <img src="" alt="" class="uploaded-image">
                        <div class="h-100">
                            <div class="dplay-tbl">
                                <div class="dplay-tbl-cell">
                                    <i class="far fa-file-video mb-3"></i>
                                    <h6 class="mt-10 mb-70">Upload Or Drop Your Video Here</h6>
                                </div>
                            </div>
                        </div><!--upload-content-->
                        <input data-="image" type="file" accept="video/*" id="video_upload" class="image-input" data-traget-resolution="image_resolution" name="post_video" value="">
                    </label>
                </div>

                <div class="show-video">
                    @if($blog->post_video)
                    <video controls id="video-tag">
                        <source id="video-source" src="{{asset('images_blog_video')}}/{{$blog->post_video}}">
                        Your browser does not support the video tag.
                    </video>
                    <i class="fas fa-times" id="cancel-btn-1"></i>
                    @endif
                    @error('post_video')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

            </div>

            <?php
            $speak_languageArray = explode(",", $blog->speak_language);
            $speak_languageArray = array_map(function ($element) {
                return str_replace(array('[', ']', '"'), '', $element);
            }, $speak_languageArray);
            // echo "<pre>";print_r($blog->choice);die();
            ?>
            <div class="col-md-6 mb-4 angle-frame">
                <label class="labels">Which languages do you speak? (Please choose only languages that you speak well enough to interact with customers.)</label>
                <div class="select-wrapper">
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
                    <i class="fas fa-angle-down select-down"></i>
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
            <div class="col-md-6 mb-4 angle-frame">
                <label class="labels">Do you offer special discounts for any of the following groups?(Optional)</label>
                <div class="select-wrapper">
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
                    <i class="fas fa-angle-down select-down"></i>
                </div>
                @error('benifits')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <?php
            $working_hoursArray = explode(",", $blog->working_hours);
            $working_hoursArray = array_map(function ($element) {
                return str_replace(array('[', ']', '"'), '', $element);
            }, $working_hoursArray);
            // echo "<pre>";print_r($blog->choice);die();
            ?>
            <div class="col-md-6 mb-4 angle-frame">
                <label class="labels">In-Studio Hours</label>
                <div class="select-wrapper">
                    <select class="form-control" name="working_hours[]" id="choices-multiple-days-button" multiple="multiple">
                        <option value="Monday: 12 a.m.-12 p.m." {{ in_array('Monday: 12 a.m.-12 p.m.', $working_hoursArray) ? 'selected' : '' }}>Monday: 12 a.m.-12 p.m.</option>
                        <option value="Tuesday: 12 a.m.-12 p.m." {{ in_array('Tuesday: 12 a.m.-12 p.m.', $working_hoursArray) ? 'selected' : '' }}>Tuesday: 12 a.m.-12 p.m.</option>
                        <option value="Wednesday: 12 a.m.-12 p.m." {{ in_array('Wednesday: 12 a.m.-12 p.m.', $working_hoursArray) ? 'selected' : '' }}>Wednesday: 12 a.m.-12 p.m.</option>
                        <option value="Thursday: 12 a.m.-12 p.m." {{ in_array('Thursday: 12 a.m.-12 p.m.', $working_hoursArray) ? 'selected' : '' }}>Thursday: 12 a.m.-12 p.m.</option>
                        <option value="Friday: 12 a.m.-12 p.m." {{ in_array('Friday: 12 a.m.-12 p.m.', $working_hoursArray) ? 'selected' : '' }}>Friday: 12 a.m.-12 p.m.</option>
                        <option value="Saturday: 12 a.m.-12 p.m." {{ in_array('Saturday: 12 a.m.-12 p.m.', $working_hoursArray) ? 'selected' : '' }}>Saturday: 12 a.m.-12 p.m.</option>
                        <option value="Sunday: 12 a.m.-12 p.m." {{ in_array('Sunday: 12 a.m.-12 p.m.', $working_hoursArray) ? 'selected' : '' }}>Sunday: 12 a.m.-12 p.m.</option>
                        <option value="Open 24 Hours" {{ in_array('Open 24 Hours', $working_hoursArray) ? 'selected' : '' }}>Open 24 Hours</option>
                    </select>
                    <i class="fas fa-angle-down select-down"></i>
                </div>
                @error('benifits')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>




            <?php
            $amenitiesArray = explode(",", $blog->amenities);
            $amenitiesArray = array_map(function ($element) {
                return str_replace(array('[', ']', '"'), '', $element);
            }, $amenitiesArray);
            ?>
            <div class="col-md-6 mb-4 angle-frame">
                <label class="labels">Do you offer any of the following amenities</label>
                <div class="select-wrapper">
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
                    <i class="fas fa-angle-down select-down"></i>
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
            <div class="col-md-6 mb-4 angle-frame">
                <label class="labels">Which of the following payment methods do you accept?</label>
                <div class="select-wrapper">
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
                    <i class="fas fa-angle-down select-down"></i>
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
            <div class="col-md-6 mb-4 angle-frame">
                <label class="labels">Enter the currency, which is rendered at your services.</label>
                <div class="select-wrapper">
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
                    <i class="fas fa-angle-down select-down"></i>
                </div>
                @error('benifits')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-12 mb-4">
                <label class="labels">Description</label>
                <div id="summernote">
                    <textarea id="editor1" class="form-control" name="description" placeholder="Write a text">{{$blog->description}}</textarea>


                    @error('description')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="col-md-12 mb-4">

                <div class="col-md-12 mt-4">
                    <label class="custom-toggle">
                        <input type="checkbox" name="personal_detail" value="true" {{ $blog->personal_detail == 'true'? 'checked' : '' }}> &nbsp;&nbsp;<span>Do you want to show your contact details.</span>
                    </label>
                </div>
                <div class=" row hidesection d-none">
                    <div class="col-md-6 mt-4 ">
                        <label class="custom-toggle">Email</label>
                        <input type="email" class="form-control" name="email" value="{{$blog->email}}" placeholder="example@example.com">

                    </div>
                    <div class="col-md-6 mt-4">
                        <label class="custom-toggle">Phone no</label>
                        <input type="tel" class="form-control" name="phone" value="{{$blog->phone}}" placeholder="+1 1234567890">
                    </div>
                    <div class="col-md-6 mt-4">
                        <label class="custom-toggle">Website link</label>
                        <input type="text" class="form-control" name="website" value="{{$blog->website}}" placeholder="https://test.com">
                    </div>
                    <div class="col-md-6 mt-4">
                        <label class="custom-toggle">Whatsapp</label>
                        <input type="tel" class="form-control" name="whatsapp" value="{{$blog->whatsapp}}" placeholder="whatsapp no">
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-5 text-center"><button class="btn profile-button" type="submit">Update</button></div>
</div>
</form>
</div>
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
</script>


@endsection