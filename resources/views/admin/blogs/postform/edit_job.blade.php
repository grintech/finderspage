@extends('layouts.adminlayout')

@section('content')
<style>
    label {
        font-size: 15px !important;
        color: #000;
    }


    .custom-toggle {
        width: fit-content !important;
    }
</style>
<div class="container px-sm-5 px-4">
    <form method="post" action="<?php echo route('admin.blogs.edit', $blog->id); ?>" class="form-validation" enctype="multipart/form-data" id="job_forms">

        {{ @csrf_field() }}
        <!-- Page Heading -->
        <div class="d-sm-flex flex-column pt-4  mb-3">
            <h1 class="h3 mb-0 text-gray-800 fw-bold custom_title_heading">Edit Job Listing</h1>
            <p class="text-dark">Choose the best category that fits your needs and create a free listing</p>
        </div>
        <span>
            @include('admin.partials.flash_messages')
        </span>
        <input type="hidden" name="category" value="2">

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
                <label class="labels">Sub categories <sup>*</sup></label>
                <select name="sub_category" class="form-control form-control-xs selectpicker" data-size="7" data-live-search="true" data-title="Sub Category" id="sub_category" data-width="100%" required>
                    @foreach($categories as $cate)
                    <option {{ $blog->sub_category == $cate->id ? 'selected' : '' }} value="{{$cate->id}}">{{$cate->title}}</option>

                    @endforeach
                    <option class="Other-cate" value="Other">Other</option>

                </select>
                <input type="text" class="form-control d-none mt-2" id="Other-cate-input" name="sub_category_oth" placeholder="sub_category name" value="">

                @error('sub_categories')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-6 mb-4">
                <label class="labels">Job type</label>
                <select class="form-control" name="choices" id="job_type">
                    <option>Select Choice</option>
                    <option value="Full Time" {{ $blog->choices == 'Full Time' ? 'selected' : '' }}>Full Time</option>
                    <option value="Part Time" {{ $blog->choices == 'Part Time' ? 'selected' : '' }}>Part Time</option>
                    <option value="contract" {{ $blog->choices == 'contract' ? 'selected' : '' }}>contract</option>

                </select>
                @error('choices')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>


            <?php
            $benefitsArray = explode(",", $blog->benifits);
            $benefitsArray = array_map(function ($element) {
                return str_replace(array('[', ']', '"'), '', $element);
            }, $benefitsArray);
            // echo "<pre>";print_r($blog->choice);die();
            ?>

            <div class="col-md-6 mb-4">
                <label class="labels">Are any of the following offered?</label>
                <div class="select-wrapper">
                    <select class="form-control" name="benifits[]" id="choices-multiple-remove-button" multiple="multiple" required>
                        <option value="">Select an offer</option>
                        <option value="Health Insurance" {{ in_array('Health Insurance', $benefitsArray) ? 'selected' : '' }}>Health Insurance</option>
                        <option value="Paid time off" {{ in_array('Paid time off', $benefitsArray) ? 'selected' : '' }}>Paid time off</option>
                        <option value="Dental insurance" {{ in_array('Dental insurance', $benefitsArray) ? 'selected' : '' }}>Dental insurance</option>
                        <option value="Vision insurance" {{ in_array('Vision insurance', $benefitsArray) ? 'selected' : '' }}>Vision insurance</option>
                        <option value="Flexible schedule" {{ in_array('Flexible schedule', $benefitsArray) ? 'selected' : '' }}>Flexible schedule</option>
                        <option value="Tuition reimbursement" {{ in_array('Tuition reimbursement', $benefitsArray) ? 'selected' : '' }}>Tuition reimbursement</option>
                        <option value="Referral program" {{ in_array('Referral program', $benefitsArray) ? 'selected' : '' }}>Referral program</option>
                        <option value="Employee discount" {{ in_array('Employee discount', $benefitsArray) ? 'selected' : '' }}>Employee discount</option>
                        <option value="Flexible spending account" {{ in_array('Flexible spending account', $benefitsArray) ? 'selected' : '' }}>Flexible spending account</option>
                        <option value="Health saving account" {{ in_array('Health saving account', $benefitsArray) ? 'selected' : '' }}>Health saving account</option>
                        <option value="Relocation assistance" {{ in_array('Relocation assistance', $benefitsArray) ? 'selected' : '' }}>Relocation assistance</option>
                        <option value="Parental leave" {{ in_array('Parental leave', $benefitsArray) ? 'selected' : '' }}>Parental leave</option>
                        <option value="Professional development assistance" {{ in_array('Professional development assistance', $benefitsArray) ? 'selected' : '' }}>Professional development assistance</option>
                        <option value="Employee assistance program" {{ in_array('Employee assistance program', $benefitsArray) ? 'selected' : '' }}>Employee assistance program</option>
                        <option value="Life insurance" {{ in_array('Life insurance', $benefitsArray) ? 'selected' : '' }}>Life insurance</option>
                        <option value="Retirement Plan" {{ in_array('Retirement Plan', $benefitsArray) ? 'selected' : '' }}>Retirement Plan</option>
                        <option value="other" {{ in_array('other', $benefitsArray) ? 'selected' : '' }}>Other</option>
                    </select>
                    <i class="fas fa-angle-down select-down"></i>
                </div>
                @error('benifits')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-6 mb-4">
                <label class="labels">Do you offer any of the following supplemental pay?</label>
                <select class="form-control" name="supplement" id="supplement" required>
                    <option>Select Option</option>
                    <option value="Singing Bonus" {{ $blog->choice == 'Singing Bonus' ? 'selected' : '' }}>Signing Bonus</option>
                    <option value="Comission Pay" {{ $blog->choice == 'Comission Pay' ? 'selected' : '' }}>Comission Pay</option>
                    <option value="Bonus Pay" {{ $blog->choice == 'Bonus Pay' ? 'selected' : '' }}>Bonus Pay</option>
                    <option value="Tips" {{ $blog->choice == 'Tips' ? 'selected' : '' }}>Tips</option>
                    <option value="Other" {{ $blog->choice == 'Other' ? 'selected' : '' }}>Other</option>
                </select>
                @error('supplement')
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
                             <select title="Select Country" name="country" class="form-control" id="country_name" post-id="{{$blog->id}}" >      
                                <option value="">Select Country</option>
                                <//?php
                                foreach ($countries as $key => $element) { ?>
                                    <option {{ $blog->country == $element['id'] ? 'selected' : '' }}  value="<//?php echo $element['id']; ?>"> <//?php echo $element['name']; ?></option>
                                <//?php
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
                            <label class="labels">Zipcode</label>
                            <input name="zipcode" type="text" maxlength="8" class="form-control" id="Zipcode" value="{{$blog->zipcode}}" placeholder="twitter">
                        </div> -->
            <!-- <div class="col-md-12 mb-4">
                            <label class="labels">Location <sup>*</sup></label>
                            <input name="location" type="text"  class="form-control get_loc" id="location" value="{{$blog->location}}" placeholder="Enter location">
                            <div class="searcRes" id="autocomplete-results">
                                    
                            </div>
                        </div> -->
            <div class="col-md-12"><label class="labels"></label></div>

            <div class="col-md-6 mb-4">
                <!-- <label class="labels">Show pay by</label>
                            <select class="form-control fixedorRange" name="pay_by" id="pay_by" required>
                                <option value="">Select Option</option>
                                <option {{ $blog->pay_by == 'Range' ? 'selected' : '' }} value="Range">Range</option>
                                <option {{ $blog->pay_by == 'Fixed' ? 'selected' : '' }} value="Fixed">Fixed</option>
                            </select> -->
                <!-- <div class="form-group d-none" id="range">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-check-label" for="exampleInput">Minimum ($)</label>
                                    <input type="number" class="form-control" name="min_pay" value="{{$blog->min_pay}}">
                                    
                                </div>
                                <div class="col-md-6">
                                    <label class="form-check-label" for="exampleInput">Maximum ($)</label>
                                    <input type="number" class="form-control" name="max_pay" value="{{$blog->max_pay}}">
                                </div>
                            </div>
                            
                            

                        </div> -->
                <div class="form-group ">
                    <label class="form-check-label" for="exampleInput">Starting pay at </label>
                    <input type="number" name="fixed_pay" class="form-control" placeholder="Enter amount" value="{{$blog->fixed_pay}}">
                    <span class="text-danger" id="fixed_error"> </span>
                </div>
            </div>


            <div class="col-md-6 mb-4">
                <label class="labels">Rate</label>
                <select class="form-control" name="rate" id="rete" required>
                    <option value="">Select Option</option>
                    <option {{ $blog->rate == 'per hour' ? 'selected' : '' }} value="per hour">per hour</option>
                    <option {{ $blog->rate == 'per day' ? 'selected' : '' }} value="per day">per day</option>
                    <option {{ $blog->rate == 'per week' ? 'selected' : '' }} value="per week">per week</option>
                    <option {{ $blog->rate == 'per month' ? 'selected' : '' }} value="per month">per month</option>
                    <option {{ $blog->rate == 'per year' ? 'selected' : '' }} value="per year">per year</option>
                </select>
                <span class="error-message" id="title-error"></span>
            </div>




            <div class="col-md-6 mb-4">
                <label class="labels">Post Featured Image <em>(Select Multiple)</em></label>
                <div class="upload-icon"><a class="cam btn btn-warning"  href="javascript:void(0)">
                    <i class="fa fa-upload" aria-hidden="true"></i>
                        upload image
                    </a> 
                </div>
               
                <div class="gallery"></div>
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
            </div>
            <div class="col-md-6 mb-4">
                <label class="labels"> Post video format: .mp4 | Max size: 2MB</label>
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
                        <input data-required="image" type="file" accept="video/*" id="video_upload" class="image-input" data-traget-resolution="image_resolution" name="post_video" value="">
                    </label>
                </div>
                <div class="show-video ">
                    <video controls id="video-tag">
                        <source id="video-source" src="{{asset('images_blog_video')}}/{{$blog->post_video}}">
                        Your browser does not support the video tag.
                    </video>
                    <i class="fas fa-times" id="cancel-btn-1"></i>
                    @error('post_video')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="col-md-12 mb-4">
                <label class="labels">Description *</label>
                <div id="summernote">
                    <textarea id="editor1" class="form-control" name="description" placeholder="Write a text"><?php echo old('description'); ?>{{$blog->description}}</textarea>


                    @error('description')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <!-- <div class="col-md-12 mb-4">
                                <label class="custom-toggle">
                                    <input type="checkbox" name="personal_detail" value="true" {{ $blog->personal_detail == 'true'? 'checked' : '' }} > &nbsp;&nbsp;<span>Do you want to show your contact details on the post ?</span>
                                </label>
                            </div> -->



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

        console.log(" countryid " + countryid);
        console.log("userid1 " + userid1);
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
        $('.get_loc').keyup(function() {
            var address = $(this).val();
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            console.log('CSRF Token:', csrfToken);
            $.ajax({
                url: baseurl + '/get/place/autocomplete',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                },
                data: {
                    address: address,
                },
                success: function(response) {
                    $('#autocomplete-results').show();
                    console.log(response);
                    $('#autocomplete-results').empty();
                    if (response.results) {
                        response.results.forEach(function(prediction) {
                            $('#autocomplete-results').append('<li class="Search_val">' + prediction.formatted_address + '</li>');
                        });
                    } else {
                        console.log('No predictions found.');
                    }
                },
                error: function(xhr, status, error) {

                }
            });
        });
        // $('.Search_val').removeClass('active_li');

    });
    $(document).on("click", ".Search_val", function() {
        var searchVal = $(this).text();
        // alert(searchVal);
        $('.get_loc').val(searchVal);
        $(this).addClass('active_li');
        $('#autocomplete-results').hide();

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
                    parent_id: 2,
                },
                success: function(response) {
                    console.log(response);
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