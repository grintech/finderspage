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
<style type="text/css">
    .mycheckbox {
        display: flex;
        justify-content: space-between;
        padding-right: 158px;
    }

    .mycheckbox input.form-control {
        font-size: 2px;
    }

    .select-down_discount {
        position: absolute;
        right: 12px;
        top: 12px;
        z-index: 1;
        font-size: 15px;
    }

    .select-down-language {
        position: absolute;
        right: 12px;
        top: 12px;
        z-index: 1;
        font-size: 15px;
    }
    #servicesForm .select-down{
        right: 12px !important;
        top: 12px !important;
    }
</style>

<div class="container px-sm-5 px-4">
    <form method="post" action="<?php echo route('admin.service'); ?>" enctype="multipart/form-data" id="servicesForm">
        {{ @csrf_field() }}
        <!-- Page Heading -->
        <div class="d-sm-flex flex-column pt-4  mb-3">
            <h1 class="h3 mb-0 text-gray-800 fw-bold custom_title_heading">Create Service Listing</h1>
            <p> If you don't want to create a business page, you can create a simple service listing below.</p>
        </div>
        <span>
            @include('admin.partials.flash_messages')
        </span>
        <input type="hidden" name="categories" value="705">

        <div class="row bg-white border-radius pb-4 p-3">
            <div class="col-md-6 mb-4">
                <label class="labels">Title <sup>*</sup></label>
                <input type="text" class="form-control" name="title" placeholder="Enter post name" value="<?php echo old('title'); ?>">
                <span class="error-message" id="title-error"></span>
                @error('title')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="col-md-6 mb-4">
                <label class="labels">Services type <sup>*</sup></label>
                
                <select name="sub_category" class="form-control form-control-xs selectpicker" data-size="7" data-live-search="true" data-title="Sub Categories" id="sub_category" data-width="100%" required>

                    @foreach($categories as $cate)
                    <option value="{{$cate->id}}">{{$cate->title}}</option>
                    @endforeach
                    <option class="Other-cate" value="Other">Other</option>
                </select>

                <input type="text" class="form-control d-none mt-2" id="Other-cate-input" name="sub_category_oth" placeholder="sub_category name" value="">

                <span class="error-message" id="title-error"></span>
                @error('sub_categories')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="col-md-6 mb-4">
                <label class="labels">Offered</label>
                <select name="offerd" class="form-control form-control-xs selectpicker" data-size="7" data-live-search="true" data-title="Offered" id="sub_category" data-width="100%" required>
                    <option value="All Offered">All Offered</option>
                    <option value="outcall">outcall</option>
                    <option value="Or both">Or both</option>
                    <option value="Offered in person">Offered in person</option>
                    <option value="Offered virtual">Offered virtual</option>
                </select>
                @error('offerd')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>



            <!-- <div class="col-md-6 mb-4 ">
                          <div class="label"> <label>Offer Incal outcall Or both</label></div>

                          <div class="mycheckbox">
                            <input type="radio" name="Offer" placeholder="" class="form-control" value="<?php echo old('Offer Incall'); ?>"> <label class="labels">Offer Incall</label>

                             <input type="radio" name="Offer" placeholder="" class="form-control" value="<?php echo old('outcall'); ?>"> <label class="labels"> outcall </label>

                              <input type="radio" name="Offer" placeholder="" class="form-control" value="<?php echo old('Or both'); ?>"> <label class="labels">Or both</label>
                            </div>
                        </div>

                         <div class="col-md-6 mb-4">
                            <div class="label"> <label>Offered in person or virtual</label></div>

                            <div class="mycheckbox">
                              <input type="radio" name="Offer" placeholder="" class="form-control" value="<?php echo old('Offered in person'); ?>"> <label class="labels">Offered in person </label>

                              <input type="radio" name="Offer" placeholder="" class="form-control" value="<?php echo old('Offered virtual'); ?>"> <label class="labels">Offered virtual </label>
                            </div>
                        </div> -->
            <div class="col-md-6 mb-4">
                <label class="labels">Want to reach a larger audience? Add Location</label>
                <input name="location" type="text" class="form-control get_loc" id="location" value="" placeholder="Location">
                <div class="searcRes" id="autocomplete-results">

                </div>
            </div>

            <!-- <div class="col-md-6 mb-4">
                            <label class="labels">Country </label>
                             <select title="Select Country" name="country" class="form-control" id="country_name">      
                                <option value="">Select Country</option>
                                <?php
                                foreach ($countries as $key => $element) { ?>
                                    <option  value="<?php echo $element['id']; ?>"> <?php echo $element['name']; ?></option>
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
                                <option value="">Select state</option>
                                
                            </select>
                             @error('state')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="labels">City </label>
                             <select title="Select Country" name="city" class="form-control" id="city_name">      
                                <option value="">Select city</option>
                            </select>
                             @error('city')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div> -->
            <!-- <div class="col-md-12 mb-4">
                            <label class="labels">ZipCode </label>
                            <input name="zipcode" type="text" maxlength="8" class="form-control" id="Zipcode" value="<?php echo old('zipcode'); ?>" placeholder="zipcode">
                             @error('zipcode')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div> -->

            <div class="col-md-6 mb-4">
                <label class="labels">Post Featured Image <em>(Select Multiple)</em></label>
                <div class="upload-icon"><a class="cam btn btn-warning"  href="javascript:void(0)">
                    <i class="fa fa-upload" aria-hidden="true"></i>
                        upload image
                    </a> 
                </div>
               
                <div class="gallery"></div>
                <div class="show-img">
                </div>
                @error('image')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-6 mb-4">
                <label class="labels"> Post Video Format: .mp4 | Max Size: 2MB <em>(Select Multiple)</em></label>
                <div class="image-upload">
                    <label style="cursor: pointer;" for="video_upload">
                        <img src="" alt="" class="uploaded-image">
                        <div class="h-100">
                            <div class="dplay-tbl">
                                <div class="dplay-tbl-cell">
                                    <!-- <i class="fas fa-cloud-upload-alt mb-3"></i> -->
                                    <!-- <h6><b>Upload Video</b></h6> -->
                                    <i class="far fa-file-video mb-3"></i>
                                    <h6 class="mt-10 mb-70">Upload Or Drop Your Video Here</h6>
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
            </div>
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
                    <option value="Ask for details">Ask for details</option>
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
            $sorter = $sorter ?? [];
            $data = [
                'monday' => 'Monday: 12 a.m.-12 p.m.',
                'tuesday' => 'Tuesday: 12 a.m.-12 p.m.',
                'wednesday' => 'Wednesday: 12 a.m.-12 p.m.',
                'thursday' => 'Thursday: 12 a.m.-12 p.m.',
                'friday' => 'Friday: 12 a.m.-12 p.m.',
                'saturday' => 'Saturday: 12 a.m.-12 p.m.',
                'sunday' => 'Sunday: 12 a.m.-12 p.m.',
                'open'   => 'Open 24 Hours'
            ];
            ?>

            <div class="col-md-6 mb-4">
                <label class="labels">In-Studio Hours</label>
                <div class="position-relative">
                <i class="fas fa-angle-down select-down"></i>
                <select class="form-control day_sorter" name="working_hours[]" id="choices-multiple-days-button" multiple="multiple">
                    <?php
                    // Sort days according to sorter
                    $sortedDays = array_replace(array_flip(array_keys($sorter)), $data);
                    foreach ($sortedDays as $day => $hours) {
                        echo "<option value=\"$hours\">$hours</option>";
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
                    <option value="Barter">Barter</option>
                    <option value="Bitcoin">Bitcoin</option>
                    <option value="Cash">Cash</option>
                    <option value="Check">Check</option>
                    <option value="Discover">Discover</option>
                    <option value="Ether">Ether</option>
                    <option value="Google Wallet">Google Wallet</option>
                    <option value="Mastercard">Mastercard</option>
                    <option value="Paypal">Paypal</option>
                    <option value="QuickPay">QuickPay</option>
                    <option value="Ripple">Ripple</option>
                    <option value="Samsung Pay">Samsung Pay</option>
                    <option value="Square Cash">Square Cash</option>
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

            <div class="col-md-12 mb-4">
                <label class="labels">Description</label>
                <div id="summernote">
                    <textarea rows="4" cols="50" id="editor1" class="form-control" name="description" placeholder="Write a text"><?php echo old('description'); ?></textarea>
                    @error('description')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="col-md-12 mb-4">

                <div class="col-md-12 mt-4">
                    <label class="custom-toggle">
                        <input type="checkbox" name="personal_detail" value="true"> &nbsp;&nbsp;<span>Do you want to show your contact details.</span>
                    </label>
                </div>
                <div class=" row hidesection d-none">
                    <div class="col-md-6 mt-4 ">
                        <label class="custom-toggle">Email</label>
                        <input type="email" class="form-control" name="email" value="" placeholder="example@example.com">

                    </div>
                    <div class="col-md-6 mt-4">
                        <label class="custom-toggle">Phone no</label>
                        <input type="tel" class="form-control" name="phone" value="" placeholder="+1 1234567890">
                    </div>
                    <div class="col-md-6 mt-4">
                        <label class="custom-toggle">Website link</label>
                        <input type="text" class="form-control" name="website" value="" placeholder="https://test.com">
                    </div>
                    <div class="col-md-6 mt-4">
                        <label class="custom-toggle">Whatsapp</label>
                        <input type="tel" class="form-control" name="whatsapp" value="" placeholder="whatsapp number">
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

        <div class="mt-5 text-center"><button class="btn profile-button addCategory" type="submit">Publish</button></div>
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
                $('#servicesForm').submit();
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
                    $('#servicesForm').submit();
                },
                error: function(xhr, status, error) {

                }
            });
        });
    });
</script>

@endsection