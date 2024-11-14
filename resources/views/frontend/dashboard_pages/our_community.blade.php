@extends('layouts.user_dashboard.userdashboardlayout')
@section('content')
<style>
    .error-message {color: #e74a3b;}
    @media only screen and (max-width:767px){
        .container {padding-bottom: 50px !important;}
    }
</style>
<div class="container px-sm-5 px-4 pb-4">
    <form method="post" action="<?php echo route('community'); ?>" class="form-validation" enctype="multipart/form-data" id="community_form">
        {{ @csrf_field() }}
                    <!-- Page Heading -->
                    <div class="d-sm-flex flex-column  mb-3">
                        <h1 class="h3 mb-0 text-gray-800 fw-bold">Category: Community</h1>
                        <p>Choose the best category that fits your needs and create a free post</p>
                    </div>
                     <span>
                        @include('admin.partials.flash_messages')
                    </span>
                    <input type="hidden" name="categories" value="5">

                    <div class="row bg-white border-radius pb-4 p-3">
                        <div class="col-md-6 mb-4">
                            <label class="labels">Title <sup>*</sup></label>
                            <input type="text" id="title-input" class="form-control" name="title" id="title" placeholder="Title" value="">
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
                            <label class="labels">Sub categories <sup>*</sup></label>
                            <select  name="sub_category" class="form-control form-control-xs selectpicker" data-size="7" data-live-search="true" data-title="Sub categories" id="sub_category" data-width="100%" required>
                                @foreach($categories as $cate)
                                <option value="{{$cate->id}}" >{{$cate->title}}</option>
                                @endforeach
                                <option class="Other-cate" value="Other" >Other</option> 
                            </select>
                             <input type="text" class="form-control d-none mt-2" id="Other-cate-input" name="sub_category_oth" placeholder="sub_category name" value="">
                             @error('sub_categories')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <!-- <div class="col-md-6 mb-4">
                            <label class="labels">Date</label>
                            <input class="form-control" type="text" id="datepicker" name="datepicker" placeholder="Enter Date" />
                            <div class="input-group date">
                                <input type="date" class="form-control" id="event_start_date"  name="event_start_date" placeholder="DD-MM-YYYY" />
                                <span class="input-group-append">
                                  <span class="input-group-text bg-light d-block">
                                    <i class="fa fa-calendar"></i>
                                  </span>
                                </span>

                                @error('event_start_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div> -->
                        <!--  <div class="col-md-6 mb-4">
                            <label class="labels">Time</label>
                            <div class="input-group time">
                              <input class="form-control" type="time" id="timepicker"  name="event_start_time" placeholder="--:-- --" />
                              
                               @error('event_start_time')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div> -->
                        <!-- <div class="col-md-6 mb-4">
                            <label class="labels">Post For</label>
                            <select class="form-control" name="postfor" required>
                                <option value="">Select Option</option>
                                <option value="articles" >Articles</option>
                                <option value="videos" >Videos</option>
                                <option value="events" >Events</option>
                            </select>
                            @error('post_type')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div> -->
                        <div class="col-md-12 mb-4">
                            <label class="labels">Want to reach a larger audience? Add location</label>
                            <input name="location" type="text"  class="form-control get_loc" id="location" value="" placeholder="Location">
                            <div class="searcRes" id="autocomplete-results">
                                    
                            </div>
                        </div>
                         <!-- <div class="col-md-6 mb-4">
                            <label class="labels">Country <sup>*</sup></label>
                             <select title="Select Country" name="country" class="form-control" id="country_name">      
                                <option value="">Select Country</option>
                                <?php
                                foreach ($countries as $key => $element) { ?>
                                    <option  value=" <?php echo $element['id']; ?>"> <?php echo $element['name']; ?></option>
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
                             <select title="Select Country" name="state"  class="form-control state1" id="state_name" >     
                                <option value="">Select State</option>
                                
                            </select>
                             @error('state')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div> -->

                        <!-- <div class="col-md-6 mb-4">
                            <label class="labels">City <sup>*</sup></label>
                             <select title="Select Country" name="city" class="form-control" id="city_name">      
                                <option value="">Select City</option>
                            </select>
                             @error('city')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div> -->
                        <!-- <div class="col-md-12 mb-4">
                            <label class="labels">Zip Code</label>
                            <input type="text" class="form-control" name="zipcode" id="zipcode" placeholder="Enter zipcode" value="" required>
                            @error('zipcode')
                                    <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div> -->

                        <div class="col-md-12 mb-4">
                        <label class="labels" data-toggle="tooltip" data-placement="top" title="Any photo that signals an intention to commit, solicit, promote or encourage a criminal act and/or violate the  Advertiser Agreement will not be accepted.">Post featured image <em>(Select multiple)</em> <i class="fa fa-question popup2"> </i></label>
                            <!-- <div class="image-upload post_img ">
                                <label style="cursor: pointer;" for="image_upload">
                                   
                                    <div class="h-100">
                                        <div class="dplay-tbl">
                                            <div class="dplay-tbl-cell">
                                                <i class="far fa-file-image mb-3"></i>
                                                <h6 class="mt-10 mb-70">Upload Or Drop Your Image Here</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <input data-required="image" type="file" name="image[]"  id="image_upload" class="image-input" data-traget-resolution="image_resolution" value="" multiple accept="image/gif, image/jpeg, image/png" onchange="checkImageCount(this, maxImageCount )"> 
                                </label>
                              
                            </div> -->
                            <div class="upload-icon"><a class="cam btn btn-warning"  href="javascript:void(0)">
                                <i class="fa fa-upload" aria-hidden="true"></i>
                                    upload image
                                </a> 
                            </div>
               
                             <div class="gallery" id="sortableImgThumbnailPreview"></div>
                            
                            @error('image')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
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
                                    <input data-required="image" type="file" accept="video/*"  id="video_upload" class="image-input" data-traget-resolution="image_resolution" name="post_video" value="">
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
                        
                       <div class="container">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="file-upload-contain">
                                    <input id="multiplefileupload" name="document[]" type="file" accept=".pdf,.xlsx,.xls"  multiple />
                                </div>
                            </div>
                            <div class="col-xl-8">
                                <div class="file-upload-contain">
                                   
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 mb-4">
                            <label class="labels">Description <sup>*</sup></label>
                            <div id="summernote">
                                <textarea id="editor1" class="form-control" name="description" placeholder="Description"><?php echo old('description'); ?></textarea>

                               
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
                                                <input type="tel" class="form-control" name="phone" value="" placeholder="+1 1234567890">
                                        </div>
                                        <div class="col-md-6 mt-4">
                                            <label class="custom-toggle">Website link</label>
                                                <input type="text" class="form-control" name="website" value="" placeholder="https://test.com">
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
                                        </div>  -->
                                </div> 
                            </div> 
                    </div>
         
                 

                   
                    <!-- <div class="row bg-white border-radius mt-5 p-3">
                        <div class="col-md-6 social-area" style="justify-content: center;">
                            <input type="radio"  name="post_type" value="Feature Post" required>
                            <label class="labels" data-toggle="tooltip" data-placement="top" title="Feature your listing on the homepage starting at just $55 per month.">Feature Listing  <i class="fa fa-question popup1">
                                
                            </i></label>
                            @error('post_type')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6 social-area" style="justify-content: center;">
                            <input type="radio"  name="post_type" value="Normal Post"  required>
                            <label class="labels" data-toggle="tooltip" data-placement="top" title="Your free listing will expire after 44 days. If you renew it before the 44 days is up, your listing will stay up for another 44 days.">Free Listing  <i class="fa fa-question popup2"  >
                                 
                            </i></label>
                            @error('post_type')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div> -->
                    <input type="hidden" name="post_type" value="Normal Post" >
                    
                    <div class="mt-5 text-center"><button class="btn profile-button addCategory" type="submit">Publish</button></div> 
                </form>
                </div>


<script type="text/javascript">
        jQuery(document).ready(function() {
         $("#country_name").on("change", function() {
                var country_id = $(this).val();
                var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                $.ajax({
                    url: baseurl+'/filter/job/state',
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
                    url: baseurl+'/filter/job/city',
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
            if(isChecked1 === true){
                $('.hidesection').removeClass('d-none');
            }else{
                $('.hidesection').addClass('d-none');
            }
          $('input[name="personal_detail"]').on('click', function() {
            var isChecked = $(this).is(':checked');
            console.log(isChecked);
            if(isChecked === true){
                $('.hidesection').removeClass('d-none');
            }else{
                $('.hidesection').addClass('d-none');
            }


          });
        });

        $(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();   
});

        $(document).ready(function() {

              $('#sub_category').on('change', function() {
                    if($(this).val() == "Other"){
                         $('#Other-cate-input').removeClass('d-none');
                         $(this).addClass('d-none');
                    }else{
                        $('#Other-cate-input').addClass('d-none');
                    }
                   
              });

               $('.addCategory').click(function (e) {
                    var subcate_title = $('#Other-cate-input').val();
                     var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                     e.preventDefoult();
                    $.ajax({
                        url: baseurl+'/shopping/cate',
                        type: 'POST',
                        headers: {
                          'X-CSRF-TOKEN': csrfToken
                        },
                        data: {
                            title:subcate_title,
                            parent_id:5,
                        },
                        success: function(response){
                          console.log(response);
                          $('#community_form').submit();
                        },
                        error: function(xhr, status, error) {
                         
                        }
                      });
                });
            });
        </script>
@endsection