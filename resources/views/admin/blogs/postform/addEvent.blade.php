@extends('layouts.adminlayout')

@section('content')

<div class="container pt-3">
 				<form method="post" action="<?php echo route('event.blogs'); ?>" enctype="multipart/form-data" id="eventformSadmin">
 					{{ @csrf_field() }}
                    <!-- Page Heading -->
                    <div class="d-sm-flex flex-column pt-4  mb-3">
                        <h1 class="h3 mb-0 text-gray-800 fw-bold custom_title_heading">Create Event Post</h1>
                        <p>Choose the best category that fits your needs and create a free Service post</p>
                    </div>
                    <span>
                    	@include('admin.partials.flash_messages')
                    </span>
                    <input type="hidden" name="categories" value="725">

                    <div class="row bg-white border-radius pb-4 p-3">
                        <div class="col-md-6 mb-4">
                            <label class="labels">Title <sup>*</sup></label>
                            <input type="text" class="form-control" name="title" placeholder="Enter post name" value="<?php echo old('title'); ?>" required>
                            <span class="error-message" id="title-error"></span>
                             @error('title')
                                <small class="text-danger">{{ $message }}</small>
                             @enderror
                        </div>

                        
                        <div class="col-md-6 mb-4">
                            <label class="labels">Event Date </label>
                            <input type="date" name="event_start_date" class="form-control" value="<?php echo old('service_date'); ?>">
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="labels">Start time </label>
                            <input type="time" name="event_start_time" class="form-control" value="<?php echo old('service_time'); ?>">
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="labels">End time </label>
                            <input type="time" name="event_end_time" class="form-control" value="<?php echo old('service_time'); ?>">
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="labels">Event Price ($)</label>
                            <input type="text" name="rate" class="form-control" placeholder="$" value="<?php echo old('rate'); ?>">
                        </div>
                         <div class="col-md-6 mb-4">
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
                        </div>
                        <div class="col-md-6 mb-4">
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
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="labels">ZipCode </label>
                            <input name="zipcode" type="text" maxlength="8" class="form-control" id="Zipcode" value="<?php echo old('zipcode'); ?>" placeholder="zipcode">
                             @error('zipcode')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="labels">Event Type </label>
                               <select title="Select Country" name="event_type" class="form-control">      
                                    <option >Event type</option>
                                    <option value="Online" >Online</option>
                                    <option value="Ofline">Ofline</option>
                                </select>
                                 @error('eventType')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                        </div>
                      
                     <div class="col-md-6 mb-4">
                         <label class="labels">Post Featured Image *[Max-Size - 1 MB]</label> 
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
                                    <!--upload-content-->
                                    <input data-required="image" type="file" name="image[]" multiple id="image_upload" class="image-input" data-traget-resolution="image_resolution" value=""> 
                                </label>
                              
                            </div>
                            <div class="show-img">

                                 <!-- <img src="" alt="" class="uploaded-image" id="image-container" >
                                 <i class="fas fa-times" id="cancel-btn"></i> -->
                            </div>
                            @error('image')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror 
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="labels"> Post Video Format: .mp4 | Max Size: 2MB</label>
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
                        </div>

                        <div class="col-md-12 mb-4">
                            <label class="labels">Description</label>
                            <div id="summernote">
                                <textarea id="editor1" class="form-control" name="description" placeholder="Write a text"><?php echo old('description'); ?></textarea>

                               
                                @error('description')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                         <div class="col-md-12 d-flex" ><h6 class=" mb-3 text-gray-800 fw-bold">Do you want to show your contact details on the post?</h6>
                            <div class="custom-control">
                                <label class="custom-toggle">
                                    <input type="checkbox" name="personal_detail" value="true"  pan class="custom-toggle-slider " data-label-off="" data-label-on="ON" ></span>
                                </label>
                            </div>
                        </div>


                    
                </div>

               

                   
                    <div class="row bg-white border-radius mt-5 p-3">
                        <div class="col-md-4 social-area">
                            <input type="radio"  name="post_type" value="Bump Post">
                            <label class="labels" data-toggle="tooltip" data-placement="top" title="You can bump your post for only $3 per day.">Bump post  <i class="fa fa-question popup"  >
                                 <!-- <span class="popuptext" id="myPopupTool">You can bump your post for only $3 per day.</span> -->
                            </i></label>
                            @error('bump_post')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-4 social-area">
                            <input type="radio"  name="post_type" value="Feature Post">
                            <label class="labels" data-toggle="tooltip" data-placement="top" title="Your post can now be featured starting at just $55 per month.">Feature post  <i class="fa fa-question popup1">
                                 <!-- <span class="popuptext1" id="myPopupTool ">Your post can now be featured starting at just $55 per month.</span> -->
                            </i></label>
                            @error('bump_post')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-4 social-area">
                            <input type="radio"  name="post_type" value="Normal Post">
                            <label class="labels" data-toggle="tooltip" data-placement="top" title="Write a regular post.">Normal post  <i class="fa fa-question popup2"  >
                                 <!-- <span class="popuptext2" id="myPopupTool2">Write a regular post.</span> -->
                            </i></label>
                            @error('bump_post')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-5 text-center"><input class="btn profile-button" type="submit" value="Publish"></div> 
                </div>
            </form>
          
             <script type="text/javascript">
        jQuery(document).ready(function() {
         $("#country_name").on("change", function() {
                var country_id = $(this).val();
                var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                $.ajax({
                    url: site_url+'/filter/job/state',
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
                    url: site_url+'/filter/job/city',
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
        
</script>  

@endsection