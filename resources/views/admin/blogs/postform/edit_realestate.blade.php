@extends('layouts.adminlayout')

@section('content')

<style type="text/css">
    label {
        font-size: 15px !important;
        color: #000;
    }


    .custom-toggle {
        width: fit-content !important;
    }
</style>
<div class="container px-sm-5 px-4">
    <form method="post" action="<?php echo route('admin.realestate.edit', $blog->id); ?>" class="form-validation" enctype="multipart/form-data" id="realState_form">
        {{ @csrf_field() }}
        <!-- Page Heading -->
        <div class="d-sm-flex flex-column pt-4  mb-3">
            <h1 class="h3 mb-0 text-gray-800 fw-bold custom_title_heading">Edit Real Estate Listing</h1>
            <!-- <p>Choose the best category that fits your needs and create a free post</p> -->
        </div>
        <span>
            @include('admin.partials.flash_messages')
        </span>
        <input type="hidden" name="categories" value="4">
        <div class="row bg-white border-radius pb-4 p-3">
            <div class="col-md-6 mb-4">
                <label class="labels">Title <sup>*</sup></label>
                <input type="text" class="form-control" name="title" placeholder="Enter post name" value="{{$blog->title}}">
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
                <select name="sub_category" id="sub_category" class="form-control form-control-xs selectpicker" data-size="7" data-live-search="true" data-title="Sub Category" data-width="100%">

                    @foreach($categories as $cate)
                    <option value="{{$cate->id}}" {{ $blog->sub_category == $cate->id ? 'selected' : '' }}>{{$cate->title}}</option>
                    @endforeach
                    <option class="Other-cate" value="Other">Other</option>
                </select>
                <input type="text" class="form-control d-none mt-2" id="Other-cate-input" name="sub_category_oth" placeholder="sub_category name" value="">
                @error('sub_categories')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <?php
            $choices = explode(",", $blog->post_choices);
            $choices = array_map(function ($element) {
                return str_replace(array('[', ']', '"'), '', $element);
            }, $choices);
            // echo "<pre>";print_r($blog->choice);die();
            ?>

            <div class="col-md-6 mb-4 " id="property-choices">
                <label class="labels">Choose your choice<sup>*</sup></label>
                <i class="fas fa-angle-down select-down"></i>
                <select class="form-control" name="post_choices[]" id="post-choices" multiple="multiple">
                    <option value="">Select option</option>
                    <option value="apartment" {{ in_array('apartment', $choices) ? 'selected' : '' }}>Apartment</option>
                    <option value="condo" {{ in_array('condo', $choices) ? 'selected' : '' }}>Condo</option>
                    <option value="cottage" {{ in_array('cottage', $choices) ? 'selected' : '' }}>Cottage/Cabin</option>
                    <option value="duplex" {{ in_array('duplex', $choices) ? 'selected' : '' }}>Duplex</option>
                    <option value="house" {{ in_array('house', $choices) ? 'selected' : '' }}>House</option>
                    <option value="loft" {{ in_array('loft', $choices) ? 'selected' : '' }}>Loft</option>
                    <option value="townhouse" {{ in_array('townhouse', $choices) ? 'selected' : '' }}>Townhouse</option>
                    <option value="assisted-living" {{ in_array('assisted-living', $choices) ? 'selected' : '' }}>Assisted Living</option>
                    <option value="land" {{ in_array('land', $choices) ? 'selected' : '' }}>Land</option>
                    <option value="laundry" {{ in_array('laundry', $choices) ? 'selected' : '' }}>Laundry</option>
                    <option value="pets" {{ in_array('pets', $choices) ? 'selected' : '' }}>Pets Allowed</option>
                    <option value="furnished" {{ in_array('furnished', $choices) ? 'selected' : '' }}>Furnished</option>
                    <option value="no-smoking" {{ in_array('no-smoking', $choices) ? 'selected' : '' }}>No Smoking</option>
                    <option value="wheelchair-accessible" {{ in_array('wheelchair-accessible', $choices) ? 'selected' : '' }}>Wheelchair Accessible</option>
                    <option value="air-conditioning" {{ in_array('air-conditioning', $choices) ? 'selected' : '' }}>Air Conditioning</option>
                    <option value="heater-unit" {{ in_array('heater-unit', $choices) ? 'selected' : '' }}>Heater Unit</option>
                </select>
            </div>

            <div class="col-md-6 mb-4 property-land-area" id="landInput" style="display:none">
                <label class="labels">Land acres</label>
                <input type="number" class="form-control" name="landSize" id="landSize" placeholder="ex:1000" value="{{$blog->landSize}}">
                @error('landSize')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="col-md-6 mb-4">
                <label class="labels">Property address <sup>*</sup></label>
                <input type="text" class="form-control" name="property_address" id="property_address" placeholder="Enter post name" value="{{$blog->property_address}}">
                @error('property_address')
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
                        <option value="<?php echo $element['id']; ?>" {{ $blog->country == $element['id'] ? 'selected' : '' }}> <?php echo $element['name']; ?></option>
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
                <select title="Select Country" name="state" class="form-control state1" id="state_name">
                    <option value="">Select state</option>

                </select>
                @error('state')
                <span class="error">{{ $message }}</span>
                @enderror
            </div> -->

            <!-- <div class="col-md-6 mb-4">
                <label class="labels">City </label>
                <select title="Select Country" name="city" class="form-control" id="city_name">
                    <option value="">Select city</option>
                </select>
                @error('city')
                <span class="error">{{ $message }}</span>
                @enderror
            </div> -->
            <!-- <div class="col-md-6 mb-4">
                <label class="labels">Zip code</label>
                <input type="text" class="form-control" name="zipcode" id="zipcode" placeholder="Enter zipcode" maxlength="8" value="{{ $blog->zipcode}}">
                @error('zipcode')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div> -->
            <div class="col-md-6 mb-4" id="property-units">
                <label class="labels">Units</label>
                <select class="form-control" name="units" id="units">
                    <option value="">Select unit</option>
                    @for ($i = 01; $i <= 10; $i++) <option value="{{ $i }}" {{ $blog->units == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor

                </select>
                @error('units')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-6 mb-4 " id="property-bathroom">
                <label class="labels">Bathroom</label>
                <select class="form-control" name="bathroom" id="bathroom">
                    <option value="">Select bathroom</option>
                    <option>1</option>
                    @for ($i = 01; $i <= 10; $i++) <option value="{{ $i }}" {{ $blog->bathroom == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                </select>
                @error('bathroom')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-6 mb-4" id="property-garage">
                <label class="labels">Garage</label>
                <select class="form-control" name="grage" id="grage">
                    <option value="">Select garage</option>
                    @for ($i = 01; $i <= 10; $i++) <option value="{{ $i }}" {{ $blog->grage == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                </select>
                @error('grage')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-6 mb-4" id="property-area">
                <label class="labels">Area in sq ft.</label>
                <input type="number" class="form-control" name="area_sq_ft" id="area_sq_ft" placeholder="Ex:1000" value="{{$blog->grage}}">
                @error('area_sq_ft')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-6 mb-4" id="property-built-year">
                <label class="labels">Year built</label>
                <input type="text" class="form-control" name="year_built" id="year_built" placeholder="2022" value="{{$blog->year_built}}">
                @error('year_built')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <?php
            $choices_new = explode("|", $blog->choices);
            $choices_new = array_map(function ($element) {
                return str_replace(array('[', ']', '"'), '', $element);
            }, $choices_new);
            // echo "<pre>";print_r($choices_new);die();
            ?>
            <div class="col-md-12 mb-4" id="property-features">
                <label class="labels">Features </label>
                <select class="form-control" name="choices[]" id="post-choices" multiple="multiple">
                    <option value="">Select tags</option>
                    <option value="Wood Floors" {{ in_array('Wood Floors', $choices_new) ? 'selected' : '' }}>Wood floors </option>
                    <option value="fireplace" {{ in_array('fireplace', $choices_new) ? 'selected' : '' }}>fireplace</option>
                    <option value="2 Stories" {{ in_array('2 Stories', $choices_new) ? 'selected' : '' }}>2 Stories</option>

                </select>
                @error('choices')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-12 mb-4">
                <label class="labels">Asking Price ($)</label>
                <input type="number" class="form-control" name="price" id="price" placeholder="" value="{{$blog->price}}">
                @error('price')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <!--  <div class="col-md-6 mb-4">
                            <label class="labels">Offered price</label>
                            <input type="number" class="form-control" name="sale_price" id="sale_price" placeholder="5000" value="{{$blog->sale_price}}" >
                        </div> -->
            <div class="col-md-6 mb-4">
                <label class="labels">Post Featured image</label>
                <div class="upload-icon"><a class="cam btn btn-warning"  href="javascript:void(0)">
                    <i class="fa fa-upload" aria-hidden="true"></i>
                        upload image
                    </a> 
                </div>
               
                <div class="gallery"></div>
                @if(isset($blog->image1))
                <div class="show-img ">
                    <?php
                    $neimg = trim($blog->image1, '[""]');
                    $img  = explode('","', $neimg);

                    // echo "<pre>";print_r($img);die('dev');
                    ?>
                    @foreach($img as $images)
                    <img src="{{asset('images_blog_img')}}/{{$images}}" alt="Image" class="uploaded-image" id="image-container">
                    @endforeach
                </div>
                @error('image')
                <small class="text-danger">{{ $message }}</small>
                @enderror
                @endif
            </div>
            <div class="col-md-6 mb-4">
                <label class="labels"> Post video format: .mp4 | max size: 20MB</label>
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
                @if(isset($blog->post_video))
                <div class="show-video">
                    <video controls id="video-tag">
                        <source id="video-source" src="{{asset('images_blog_video')}}/{{$blog->post_video}}">
                    </video>
                    <i class="fas fa-times" id="cancel-btn-1"></i>
                </div>
                @endif
            </div>


            <!-- <div class="col-md-12 mb-4">
                            <div id="summernote">
                                <label class="labels" for ="post-desc" >Description</label>
                                <textarea id="post-desc" class="form-control" name="description" rows="4" cols="50">{{$blog->description}}</textarea>
                            </div>
                        </div> -->
            <div class="col-md-12 mb-4">
                <label class="labels">Description *</label>
                <div id="summernote">
                    <textarea id="editor1" class="form-control" name="description" placeholder="Write a text"><?php echo old('description'); ?>{{$blog->description}}</textarea>


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
                        <input type="tel" class="form-control" name="whatsapp" value="{{$blog->whatsapp}}" placeholder="whatsapp number">
                    </div>
                   
                </div>
            </div>

        </div>

        <div class="mt-5 text-center"><button class="btn profile-button addCategory" type="submit">Update</button></div>
</div>
</form>

<script>
    $(document).ready(function() {
        var choiceButton = new Choices('#post-choices', {
            removeItemButton: true,
            maxItemCount: 100,
            searchResultLimit: 100,
            renderChoiceLimit: 100
        });


        var selectedOption = $("#sub_categories").val();
        // alert(selectedOption);
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
            if (subcate_title == "") {
                $('#realState_form').submit();
            }
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            e.preventDefault();
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
                    $('#realState_form').submit();
                },
                error: function(xhr, status, error) {

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