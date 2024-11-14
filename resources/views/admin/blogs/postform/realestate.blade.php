@extends('layouts.adminlayout')

@section('content')
<style>
    #post_type-error {
        position: absolute;
        top: 25px;
    }

    .text-danger {
        font-size: 15px;
    }

    label {
        font-size: 15px !important;
        color: #000;
    }


    .custom-toggle {
        width: fit-content !important;
    }
</style>
<div class="container px-sm-5 px-4">
    <form method="post" action="<?php echo route('realEstate_post'); ?>" enctype="multipart/form-data" id="realState_form_new">
        {{ @csrf_field() }}
        <!-- Page Heading -->
        <div class="d-sm-flex flex-column pt-4  mb-3">
            <h1 class="h3 mb-0 text-gray-800 fw-bold custom_title_heading">Category: Create A Real Estate Listing</h1>
            <p>Choose the best category that fits your needs and create a free listing</p>
        </div>
        <span>
            @include('admin.partials.flash_messages')
        </span>
        <input type="hidden" name="categories" value="4">
        <div class="row bg-white border-radius pb-4 p-3">
            <div class="col-md-6 mb-4">
                <label class="labels">Title <sup>*</sup></label>
                <input type="text" class="form-control" name="title" placeholder="Enter post name" value="">
                 <span class="error-message" id="title-error"></span>
                @error('title')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <!-- <div class="col-md-6 mb-4 form-check check-frame">
                            <input class="form-check-input" id="inputRememberPassword" type="checkbox" value="" />
                            <label class="form-check-label" for="inputRememberPassword">Do you want to make this Post Featured?</label>
                        </div> -->
            <div class="col-md-6 mb-4">
                <label class="labels">Sub Categories <sup>*</sup></label>
                <select name="sub_category" class="form-control form-control-xs selectpicker" data-size="7" data-live-search="true" data-title="Sub Category" id="sub_category" data-width="100%" required>
                    @foreach($categories as $cate)
                    <option value="{{$cate->id}}">{{$cate->title}}</option>
                    @endforeach
                    <option class="Other-cate" value="Other">Other</option>
                </select>
                <input type="text" class="form-control d-none mt-2" id="Other-cate-input" name="sub_category_oth" placeholder="sub_category name" value="">
                @error('sub_category')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="col-md-6 mb-4 " id="property-choices">
                <label class="labels">Choose Your Choice</label>
                <i class="fas fa-angle-down select-down"></i>
                <select class="form-control" name="post_choices[]" id="post-choices" multiple="multiple">
                    <option value="apartment">Apartment</option>
                    <option value="condo">Condo</option>
                    <option value="cottage">Cottage/Cabin</option>
                    <option value="duplex">Duplex</option>
                    <option value="house">House</option>
                    <option value="loft">Loft</option>
                    <option value="townhouse">Townhouse</option>
                    <option value="assisted-living">Assisted Living</option>
                    <option value="land">Land</option>
                    <option value="laundry">Laundry</option>
                    <option value="pets">Pets Allowed</option>
                    <option value="furnished">Furnished</option>
                    <option value="no-smoking">No Smoking</option>
                    <option value="wheelchair-accessible">Wheelchair Accessible</option>
                    <option value="air-conditioning">Air Conditioning</option>
                    <option value="heater-unit">Heater Unit</option>
                </select>
            </div>

            <div class="col-md-6 mb-4 property-land-area" id="landInput" style="display:none">
                <label class="labels">Land Acres</label>
                <input type="text" class="form-control" name="landSize" id="landSize" placeholder="ex:1000" value="">
            </div>

            <div class="col-md-6 mb-4">
                <label class="labels">Property Address <sup>*</sup></label>
                <input type="text" class="form-control" name="property_address" id="property_address" placeholder="Enter post name" value="">
                @error('property_address')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-6 mb-4">
                <label class="labels">Want to reach a larger audience? Add location</label>
                <input name="location" type="text" class="form-control get_loc" id="location" value="" placeholder="Location">
                <div class="searcRes" id="autocomplete-results">

                </div>
            </div>
            <!-- <div class="col-md-6 mb-4">
                            <label class="labels">Country</label>
                            <select class="form-control" name="country" id="country_name">
                                <option value="">Select Country</option>
                               <?php
                                if ($countries) : ?>
                                <?php foreach ($countries as $key => $value) {
                                        echo '<option value="' . $value->id . '">' . $value->name . '</option>';
                                    }
                                endif; ?>
                                
                            </select>
                             @error('country')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div> -->
            <!-- <div class="col-md-6 mb-4">
                            <label class="labels">State</label>
                            <select title="Select Country" name="state"  class="form-control state1" id="state_name" >     
                                <option value="">Select State</option>
                                
                            </select>
                            @error('state_name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div> -->
            <!-- <div class="col-md-6 mb-4">
                            <label class="labels">City</label>
                            <select title="Select Country" name="city" class="form-control" id="city_name">      
                                <option value="">Select City</option>
                            </select>
                             @error('city_name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div> -->
            <!-- <div class="col-md-6 mb-4">
                            <label class="labels">Zip Code</label>
                            <input type="text" class="form-control" name="zipcode" id="zipcode" placeholder="Enter zipcode" value="">
                            @error('zipcode')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div> -->
            <div class="col-md-6 mb-4" id="property-units">
                <label class="labels">Units</label>
                <select class="form-control" name="units" id="units">
                    <option value="">Select Unit</option>
                    @for ($i = 01; $i <= 10; $i++) <option value="{{ $i }}">{{ $i }}</option>
                        @endfor

                </select>
                @error('units')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-6 mb-4 " id="property-bathroom">
                <label class="labels">Bathroom</label>
                <select class="form-control" name="bathroom" id="bathroom">
                    <option value="">Select Bathroom</option>

                    @for ($i = 01; $i <= 10; $i++) <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                </select>
                @error('bathroom')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-6 mb-4" id="property-garage">
                <label class="labels">Garage</label>
                <select class="form-control" name="grage" id="grage">
                    <option value="">Select Garage</option>
                    @for ($i = 01; $i <= 10; $i++) <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                </select>
                @error('grage')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-6 mb-4" id="property-area">
                <label class="labels">Area in sq ft.</label>
                <input type="text" class="form-control" name="area_sq_ft" id="area_sq_ft" placeholder="Ex:1000" value="">
                @error('area_sq_ft')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-6 mb-4" id="property-built-year">
                <label class="labels">Year Built </label>
                <input type="text" class="form-control" name="year_built" id="year_built" placeholder="2022" value="">
                @error('year_built')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-12 mb-4" id="property-features">
                <label class="labels">Features </label>
                <select class="form-control" name="choices[]" id="post-choices" multiple="multiple">
                    <option value="Wood Floors">Wood Floors </option>
                    <option value="fireplace">Fireplace</option>
                    <option value="2 Stories">2 Stories</option>
                </select>
                @error('choices')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-12 mb-4">
                <label class="labels">Asking Price ($)</label>
                <input type="text" class="form-control" name="price" id="price" placeholder="$">
                @error('price')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <!--  <div class="col-md-6 mb-4">
                            <label class="labels">Offered price ($)<sup>*</sup></label>
                            <input type="text" class="form-control" name="sale_price" id="sale_price" placeholder="$" value="$">
                        </div> -->
            <div class="col-md-6 mb-4">
                <label class="labels">Post Featured Image<em>(Select Multiple)</em></label>
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
                <label class="labels"> Post Video Format: .mp4 | max size: 20MB <em>(Select Multiple)</em></label>
                <div class="image-upload">
                    <label style="cursor: pointer;" for="video_upload">
                        <img src="" alt="" class="uploaded-image">
                        <div class="h-100">
                            <div class="dplay-tbl">
                                <div class="dplay-tbl-cell">
                                    <!-- <i class="fas fa-cloud-upload-alt mb-3"></i>
                                                <h6><b>Upload Video</b></h6> -->
                                    <i class="far fa-file-video mb-3"></i>
                                    <h6 class="mt-10 mb-70">Upload Or Drop Your Video Here</h6>
                                </div>
                            </div>
                        </div><!--upload-content-->
                        <input data="image" type="file" accept="video/*" id="video_upload" class="image-input" data-traget-resolution="image_resolution" name="post_video" value="">
                    </label>
                </div>
                <div class="show-video d-none">
                    <video controls id="video-tag">
                        <source id="video-source" src="splashVideo">
                        Your browser does not support the video tag.
                    </video>
                    <i class="fas fa-times" id="cancel-btn-1"></i>
                </div>
            </div>

            <div class="col-md-12 mb-4">
                <label class="labels" for="post-desc">Description</label>
                <textarea id="editor1" class="form-control" name="description" rows="8" cols="50"></textarea>
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
                    
                </div>
            </div>

        </div>

        <div class="mt-5 text-center"><button class="btn profile-button addCategory" type="submit">Publish</button>
        </div>
</div>
</form>
</div>
<script>
    $(document).ready(function() {
        var choiceButton = new Choices('#post-choices', {
            removeItemButton: true,
            maxItemCount: 100,
            searchResultLimit: 100,
            renderChoiceLimit: 100
        });


        $("#sub_categories").on("change", function() {
            var selectedOption = $(this).val();
            if (selectedOption === "532") {
                $("#landInput").show();
                $('#property-choices').hide();
                $('#property-built-year').hide();
                $('#property-area').hide();
                $('#property-bathroom').hide();
                $('#property-units').hide();
                $('#property-garage').hide();
                $('#property-features').hide();



            } else {
                $("#landInput").hide();
                $('#property-choices').show();
                $('#property-built-year').show();
                $('#property-area').show();
                $('#property-bathroom').show();
                $('#property-units').show();
                $('#property-garage').show();
                $('#property-features').show();
            }
        });


        $("#country_name").on("change", function() {
            var country_id = $(this).val();
            //alert("this is country id "+country_id);
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
            e.preventDefault();
            if (subcate_title == "") {
                $('#realState_form_new').submit();
                return false;
            }
            $.ajax({
                url: baseurl + '/shopping/cate',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    title: subcate_title,
                    parent_id: 4,
                },
                success: function(response) {
                    console.log(response);
                    $('#realState_form_new').submit();
                },
                error: function(xhr, status, error) {
                    $('#realState_form_new').submit();
                }
            });
        });
    });

    function checkImageCount(input) {
        var maxImageCount = 25;

        if (input.files && input.files.length > maxImageCount) {
            Swal.fire({
                text: 'You can only select up to ' + maxImageCount + ' images.',
                icon: 'warning',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'OK'
            });

            input.value = '';
        }
    }
</script>

@endsection