@extends('layouts.user_dashboard.userdashboardlayout')
@section('content')
<?php use App\Models\UserAuth;
    $userdata = UserAuth::getLoginUser();
    // dd($userdata);
    ?>
<style>
.error-message {
    color: #e74a3b;
}
@media only screen and (max-width:767px){
    .container {padding-bottom: 50px !important;}
}
</style>
<div class="container px-sm-5 px-4 pb-4">
    <form method="post" action="<?php echo route('post.create'); ?>" class="form-validation" enctype="multipart/form-data">
        {{ @csrf_field() }}
        <!-- Page Heading -->
        <div class="d-sm-flex flex-column mb-3">
            <h1 class="h3 mb-0 text-gray-800 fw-bold">Job Listing</h1>
            <p>Choose the best category that fits your needs and create a free listing</p>
        </div>
        <span>
            @include('admin.partials.flash_messages')
        </span>
        <input type="hidden" name="categories" value="2">

        <div class="row bg-white border-radius pb-4 p-3">
            <div class="col-md-6 mb-4">
                <label class="labels">Title <sup>*</sup></label>
                <input type="text" id="title-input" class="form-control" name="title" placeholder="Title">
                <span class="error-message" id="title-error"></span>
                @error('title')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>            

            <!--<div class="col-md-6 mb-4 form-check check-frame">
                <input class="form-check-input" id="inputRememberPassword" name="feature" type="checkbox" value="" />
                <label class="form-check-label" for="inputRememberPassword">Do you want to make this Post Featured?</label>
            </div> -->
            <div class="col-md-6 mb-4">
                <label class="labels">Sub categories <sup>*</sup></label>
                <select class="form-control-xs selectpicker" name="sub_category" data-size="7" data-live-search="true" data-title="Sub categories" id="sub_category" data-width="100%">

                    @foreach($categories as $cate)
                    <option data-tokens="{{$cate->title}}" value="{{$cate->id}}">{{$cate->title}}</option>
                    @endforeach
                    <option class="Other-cate" value="Other">Other</option>
                </select>
                <input type="text" class="form-control d-none mt-2" id="Other-cate-input" name="sub_category_oth" placeholder="Sub category name" value="">
            </div>
            <!-- <div class="col-md-6 mb-4">
                            <label class="labels">Sub categories <sup>*</sup></label>
                            <select class="form-control selectpicker"  name="sub_category"   required>
                                <option value="">Select option</option>
                                @foreach($categories as $cate)
                                <option data-tokens="{{$cate->title}}" value="{{$cate->id}}" >{{$cate->title}}</option>
                                @endforeach
                            </select>
                             <span class="error-message" id="title-error"></span>
                            @error('sub_categories')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div> -->
            <div class="col-md-6 mb-4">
                <label class="labels">Job type <sup>*</sup></label>
                <select class="form-control" name="choices" id="job_type">
                    <option value="">Select choice</option>
                    <option value="Full Time">Full Time</option>
                    <option value="Part Time">Part Time</option>
                    <option value="Contract">Contract</option>

                </select>
                @error('choices')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-6 mb-4 any-offer">
                <label class="labels">Are any of the following offered?</label>
                <i class="fas fa-angle-down select-down"></i>
                <select class="form-control" name="benifits[]" id="choices-multiple-remove-button" multiple="multiple" >
                    <option value="">Select an Offer</option>
                    <option value="Health Insurance">Health Insurance</option>
                    <option value="Paid time off">Paid Time Off</option>
                    <option value="Dental insurance">Dental Insurance</option>
                    <option value="Vision insurance">Vision Insurance</option>
                    <option value="Flexible schedule">Flexible Schedule</option>
                    <option value="Tuition reimbarsement">Tuition Reimbursement</option>
                    <option value="Referral program">Referral Program</option>
                    <option value="Employee discount">Employee Discount</option>
                    <option value="Flexible spending account">Flexible Spending Account</option>
                    <option value="Health saving account">Health Saving Account</option>
                    <option value="Relocation assistance">Relocation Assistance</option>
                    <option value="Parental leave">Parental Leave</option>
                    <option value="Professional development assistance">Professional Development Assistance
                    </option>
                    <option value="Employee assistance program">Employee Assistance Program</option>
                    <option value="Life insurance">Life Insurance</option>
                    <option value="Retirement Plan">Retirement Plan</option>
                    <option value="other">Other</option>
                </select>
                @error('benifits')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-6 mb-4">
                <label class="labels">Do you offer any of the following supplemental pay?</label>
                <select class="form-control" name="supplement" id="supplement" >
                    <option selected="">Select option</option>
                    <option>Signing Bonus</option>
                    <option>Comission Pay</option>
                    <option>Bonus Pay</option>
                    <option>Tips</option>
                    <option>Other</option>
                </select>
                @error('supplement')
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
                <label class="labels">Country <sup>*</sup></label>
                <select title="Select Country" name="country" class="form-control" id="country_name">
                    <option value="">Select Country</option>
                    <?php
                    foreach ($countries as $key => $element) { ?>
                        <option value=" <?php echo $element['id']; ?>"> <?php echo $element['name']; ?></option>
                    <?php
                    }
                    ?>
                </select>
                @error('country')
                <span class="error">{{ $message }}</span>
                @enderror
            </div> -->
            <!-- <div class="col-md-6 mb-4">
                <label class="labels">State <sup>*</sup></label>
                <select title="Select Country" name="state" class="form-control state1" id="state_name">
                    <option value="">Select State</option>

                </select>
                @error('state')
                <span class="error">{{ $message }}</span>
                @enderror
            </div> -->

            <!-- <div class="col-md-6 mb-4">
                <label class="labels">City <sup>*</sup></label>
                <select title="Select country" name="city" class="form-control" id="city_name">
                    <option value="">Select City</option>
                </select>
                @error('city')
                <span class="error">{{ $message }}</span>
                @enderror
            </div> -->
            <!-- <div class="col-md-6 mb-4">
                <label class="labels">Zip Code <sup>*</sup></label>
                <input name="zipcode" type="text" maxlength="8" class="form-control" id="Zipcode" value="" placeholder="zipcode">
            </div> -->

            <!-- <div class="col-md-12"><label class="labels">What is the pay?</label></div> -->


            <div class="col-md-6 mb-4">
                <label class="labels">Range <sup>*</sup></label>
                <div class="d-flex align-items-center" id="range">
                    <input type="number" step="0.01" name="min_pay" id="min_pay" class="form-control mr-2" placeholder="Minimum" required> 
                    <span class="mx-2">to</span> 
                    <input type="number" step="0.01" name="max_pay" id="max_pay" class="form-control ml-2" placeholder="Maximum (Optional)"> 
                </div>
                <span class="error-message text-danger" id="range-error"></span>
            </div>
            

            {{-- <div class="col-md-6 mb-4"> --}}
                <!-- <label class="labels">Choose Pay by <sup>*</sup></label> -->
                <!--  <select class="form-control fixedorRange" name="pay_by" id="pay_by_range">
                                <option value="">Select Option</option>
                                <option value="Range">Range</option>
                                <option value="Fixed">Fixed</option>
                            </select> -->
                <!-- <div class="form-group d-none" id="range">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-check-label" for="exampleInput">Minimum ($)<sup>*</sup></label>
                                    <input type="number" class="form-control" name="min_pay">
                                    
                                </div>
                                <div class="col-md-6">
                                    <label class="form-check-label" for="exampleInput">Maximum ($)<sup>*</sup></label>
                                    <input type="number" class="form-control" name="max_pay">
                                </div>
                            </div>
                            
                            

                        </div> -->
                {{-- <div class="form-group ">
                    <label class="form-check-label" for="exampleInput">Starting pay at</label>
                    <input type="number" name="fixed_pay" step="0.01" class="form-control" placeholder="Enter amount">
                    <span class="text-danger" id="fixed_error"> </span>
                </div>
            </div> --}}

            <div class="col-md-6 mb-4">
                <label class="labels">Rate <sup>*</sup></label>
                <select class="form-control" name="rate" id="rate" >
                    <option value="">Select option</option>
                    <option value="per hour">Per Hour</option>
                    <option value="per day">Per Day</option>
                    <option value="per week">Per Week</option>
                    <option value="per month">Per Month</option>
                    <option value="per annually">Per Annually</option>
                </select>
                <span class="error-message" id="rate-error"></span>
            </div>

            

            <!-- <div class="col-md-6 mb-4">
                <label class="labels">Post Featured Image *[Max-Size - 1 MB]<em>(Select Multiple)</em></label>
                <div class="image-upload post_img ">
                    <label style="cursor: pointer;" for="image_upload">

                        <div class="h-100">
                            <div class="dplay-tbl">
                                <div class="dplay-tbl-cell">
                                    <i class="far fa-file-image mb-3"></i>
                                    <h6 class="mt-10 mb-70">Upload Or Drop Your Image Here</h6>
                                </div>
                            </div>
                        </div>
                        <input data-required="image" type="file" name="image[]" id="image_upload" class="image-input" data-traget-resolution="image_resolution" value="" multiple accept="image/png, image/gif, image/jpeg" onchange="checkImageCount(this, maxImageCount );">
                    </label>

                </div>
                <div class="show-img">
                </div>
                @error('image')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div> -->


            {{-- <div class="col-md-6 mb-4">
                <label class="labels" data-toggle="tooltip" data-placement="top" title="Any photo that signals an intention to commit, solicit, promote or encourage a criminal act and/or violate the  Advertiser Agreement will not be accepted.">Post featured image <em>(Select multiple)</em> <i class="fa fa-question popup2"> </i></label>
                <div class="upload-icon">
                    
                    <a class="btn btn-warning" onclick="previewImages()">
                        <input type="file" id="imageInput" multiple />
                        <i class="fa fa-upload" aria-hidden="true"></i>
                        Upload image
                    </a>
                </div>
            
                <div class="gallery" id="sortableImgThumbnailPreview"></div>
                @error('image')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <script>
                function previewImages() {
                var imageInput = document.getElementById('imageInput');
                var files = imageInput.files;
                var gallery = document.getElementById('sortableImgThumbnailPreview');

                gallery.innerHTML = '';

                for (var i = 0; i < files.length; i++) {
                    var file = files[i];
                    var reader = new FileReader();
                    reader.onload = function(event) {
                        var img = document.createElement('img');
                        img.src = event.target.result;
                        img.width = 100;
                        img.height = 100;
                        gallery.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                }
            }
            </script> --}}
            <div class="col-md-6 mb-4">
                <label class="labels" data-toggle="tooltip" data-placement="top" title="Any photo that signals an intention to commit, solicit, promote or encourage a criminal act and/or violate the  Advertiser Agreement will not be accepted.">Post featured image <em>(Select multiple)</em> <i class="fa fa-question popup2"> </i></label>
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


            {{-- data-toggle="modal" data-target="#upload_image_modal" --}}

            {{-- <div class="modal fade" id="upload_image_modal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="uploadModalLabel">Upload Images</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Set logic here</p>
                    </div>
                    <div class="modal-footer"></div>
                    </div>
                </div>
            </div> --}}



            <!-- <div class="col-md-6 mb-4">
                <label class="labels"> Post Video Format: .mp4 | Max Size: 2MB <em>(Select Multiple)</em></label>
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
                        </div>
                        <input data-required="image" type="file" accept="video/*" id="video_upload" class="image-input" data-traget-resolution="image_resolution" name="post_video" value="" >
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
            </div> -->

            <div class="col-md-12 mb-4">
                <label class="labels">Description </label>
                <div id="summernote">
                    <textarea id="editor1" class="form-control" name="description" placeholder="Descriptiont"><?php echo old('description'); ?></textarea>
                    {{-- <textarea id="txtEditor" class="form-control" name="description" placeholder="Descriptiont"><?php echo old('description'); ?></textarea> --}}


                    @error('description')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <!-- <div class="col-md-12 mt-4">
                                    <label class="custom-toggle">
                                        <input type="checkbox" name="personal_detail" value="true"> &nbsp;&nbsp;<span>Do you want to show your contact details on the post ?</span>
                                    </label>
                                </div>  -->



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
                        <input type="text" class="form-control" id="phone" name="phone" value="" placeholder="+1 1234567890">
                    </div>
                    <div class="col-md-6 mt-4">
                        <label class="custom-toggle">Website link</label>
                        <input type="text" class="form-control" name="website" value="" placeholder="https://test.com">
                    </div>
                    <div class="col-md-6 mt-4">
                        <label class="custom-toggle">Whatsapp</label>
                        <input type="text" class="form-control" id="whatsapp" name="whatsapp" value="" placeholder="whatsapp number">
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
</form>
</div>

<script type="text/javascript">

    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
    jQuery(document).ready(function() {
        $(".newSelect").on("click", function() {});
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


    $(document).ready(function() {

    function validateRange() {
        
        var minPay = parseFloat($('#min_pay').val());
        var maxPay = parseFloat($('#max_pay').val());

        var errorMessage = '';

        if (minPay > maxPay || minPay == maxPay) {
            $('input[name="max_pay"]').val(minPay + 1);
            errorMessage = 'Maximum pay must be greater than to minimum pay.';
        }

        if (errorMessage) {
            $('#range-error').text(errorMessage);
        } else {
            $('#range-error').text('');
        }
    }

    $('#min_pay, #max_pay').on('blur', function() {
        validateRange();
    });

    validateRange();
});


</script>

@endsection