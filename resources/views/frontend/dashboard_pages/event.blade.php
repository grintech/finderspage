@extends('layouts.user_dashboard.userdashboardlayout')
@section('content')
<style type="text/css">
.cover-image #removeCover {
    position: absolute;
    top: 250px;
    right: 70px;
    margin: 4px 2px;
    cursor: pointer;
    background: linear-gradient(90deg, rgba(170, 137, 65, 1) 0%, rgba(205, 156, 49, 1) 13%, rgba(154, 128, 73, 1) 35%, rgba(246, 204, 78, 1) 51%, rgba(181, 147, 56, 1) 75%, rgba(163, 136, 68, 1) 100%);
    border: 1px solid #FCD152 !important;
    border-radius: 5px;
    color: #1A202E !important;
    padding: 5px 16px;
    font-size: 16px;
}   
.cover-image #removeProfile {
    position: absolute;
    top: 100px;
    left: 0px;
    margin: 4px 2px;
    cursor: pointer;
    background: linear-gradient(90deg, rgba(170, 137, 65, 1) 0%, rgba(205, 156, 49, 1) 13%, rgba(154, 128, 73, 1) 35%, rgba(246, 204, 78, 1) 51%, rgba(181, 147, 56, 1) 75%, rgba(163, 136, 68, 1) 100%);
    border: 1px solid #FCD152 !important;
    border-radius: 5px;
    color: #1A202E !important;
    padding: 5px 16px;
    font-size: 16px;
}
</style>

 <div class="container px-sm-5 px-4">
 				<form method="post" action="<?php echo route('add_event'); ?>" class="form-validation" enctype="multipart/form-data" id="eventform">
 					{{ @csrf_field() }}
                    <!-- Page Heading -->
                    <div class="d-sm-flex flex-column  mb-3">
                        <h1 class="h3 mb-0 text-gray-800 fw-bold">Create Event Post</h1>
                        <p>Choose the best category that fits your needs and create a free event post</p>
                    </div>
                    <span>
                    	@include('admin.partials.flash_messages')
                    </span>
                    <input type="hidden" name="categories" value="725">

                    <!-- <div class="row bg-white border-radius pb-4 p-3">
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
                                                <i class="fas fa-cloud-upload-alt mb-3"></i>
                                                <h6><b>Upload Image</b></h6>
                                                <h6 class="mt-10 mb-70">Or Drop Your Image Here</h6>
                                            </div>
                                        </div>
                                    </div>
                                   
                                    <input data-required="image" type="file" name="image[]" multiple id="image_upload" class="image-input" data-traget-resolution="image_resolution" value=""> 
                                </label>
                              
                            </div>
                            <div class="show-img">


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
                                                <i class="fas fa-cloud-upload-alt mb-3"></i>
                                                <h6><b>Upload Video</b></h6>
                                                <h6 class="mt-10 mb-70">Or Drop Your Video Here</h6>
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

                         <div class="custom-control">
                                <label class="custom-toggle">
                                    <input type="checkbox" name="personal_detail" value="true"  > <span>Do you want to show your contact details on the post ?</span>
                                </label>
                            </div>
                    </div> -->

               

                   
                    <!-- <div class="row bg-white border-radius mt-5 p-3">
                        <div class="col-md-4 social-area">
                            <input type="radio"  name="post_type" value="Bump Post">
                            <label class="labels" data-toggle="tooltip" data-placement="top" title="You can bump your post for only $3 per day.">Bump post  <i class="fa fa-question popup"  >
        
                            </i></label>
                            @error('bump_post')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-4 social-area">
                            <input type="radio"  name="post_type" value="Feature Post">
                            <label class="labels" data-toggle="tooltip" data-placement="top" title="Your post can now be featured starting at just $55 per month.">Feature post  <i class="fa fa-question popup1">
                            </i></label>
                            @error('bump_post')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-4 social-area">
                            <input type="radio"  name="post_type" value="Normal Post">
                            <label class="labels" data-toggle="tooltip" data-placement="top" title="Write a regular post.">Normal post  <i class="fa fa-question popup2"  >
                            </i></label>
                            @error('bump_post')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-5 text-center"><button class="btn profile-button" type="submit">Publish</button></div>  -->



                    <div class="row card cover-image">
                        <div class="img-frame">
                        <img id="imagecoverPreview" src="{{ asset('images/bannerh.png') }}" style="height: 300px;width: 100%;" class="img-fluid" alt="Image">
                            <button type="button" class="btn btn-primary" id="removeCover">
                                <i class="fa fa-trash" aria-hidden="true"></i>  
                            </button>
                        <label>
                            <input type="file" name="cover_img" onChange="preview_2(this);" style="display: none;">
                            <i class="fas fa-camera" aria-hidden="true"></i>
                        </label>
                            <a class="cover-profile-pic" href="#">
                                <img id="imagePreview" class="img-fluid" src="{{ asset('images/default.jpg') }}" width="61px" alt="">
                                
                                <button type="button" class="btn btn-primary" id="removeProfile">
                                    <i class="fa fa-trash" aria-hidden="true"></i>  
                                </button>
                                <label onclick="document.getElementById('imageInput').click()">
                                <i class="fas fa-camera" aria-hidden="true"></i>
                            </label>
                            </a>
                            
                            <input type="file" name="cover-profile" id="imageInput" onchange="previewImage(event)" style="display: none;">

                            <a href="#" class="manage-frame">Profile Name</a>
                       </div>
                    </div>

                    <div class="row bg-white border-radius pb-4 p-3 form-frame">
                        <div class="col-md-12 mb-4">
                            <label class="labels">Event Name <sup>*</sup></label>
                            <input type="text" class="form-control" name="title" placeholder="Enter event name" value="<?php echo old('title'); ?>" required>
                            <span class="error-message" id="title-error"></span>
                             @error('title')
                                <small class="text-danger">{{ $message }}</small>
                             @enderror
                        </div>
                        
                        
                        <div class="col-md-12 mb-8">
                            <label class="labels">Start Date </label>
                            <input type="datetime-local" name="event_start_date" class="form-control" value="<?php echo old('service_date') ?: date('Y-m-d') . 'T10:30'; ?>">
                        </div>

                        <div class="col-md-12 mb-8">
                            <label class="labels">End Date </label>
                            <input type="datetime-local" name="event_start_date" class="form-control" value="<?php echo old('service_date') ?: date('Y-m-d') . 'T19:30'; ?>">
                        </div>


                        <!-- <div class="col-md-6 mb-4">
                            <label class="labels">Event Price ($)</label>
                            <input type="text" name="rate" class="form-control" placeholder="$" value="<?php echo old('rate'); ?>">
                        </div> -->
                        
                        <div class="col-md-6 mb-4">
                            <label class="labels">Is it in Person or Virtual?</label>
                           <select title="In Person" name="event_virtual" class="form-control" id="selectBox">      
                                <option >Select</option>
                                <option value="In Person">In Person</option>
                                <option value="Virtual">Virtual</option>
                            </select>
                             @error('selectBox')
                                <span class="error">{{ $message }}</span>
                            @enderror

                            <div class="targetDiv" data-option="In Person" style="display: none;">
                                <div class="search-container">
                                    <i class="fa fa-map-marker"></i>
                                    <input type="text" id="locationInput" name="locationInput" placeholder="Location">
                                </div>
                                <ul id="locationList"></ul>
                            </div>

                            <div class="targetDiv" data-option="Virtual" style="display: none;">
                                <ul class="radio-list">
                                    <li>
                                        <input type="radio" id="option1" name="options" value="option1">
                                        <label for="option1">Messenger Rooms <br><small>Get together on video chat. People can join the room right from the event page.</small></label>
                                    </li>
                                    <li>
                                        <input type="radio" id="option2" name="options" value="option2">
                                        <label for="option2">Facebook Live <br> <small>Schedule a Facebook Live for your event so people can watch.</small></label>
                                    </li>
                                    <li>
                                        <input type="radio" id="option3" name="options" value="option3">
                                        <label for="option3">External Link <br> <small></small>Add a link so people know where to go when your event starts.</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="option4" name="options" value="option4">
                                        <label for="option4">Other <br> <small></small>Include clear instructions in your event details on how to participate.</label>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="labels">Who can see it?</label>
                             <select title="public" name="public" class="form-control" id="public_name">      
                                <option value="">Select</option>
                                <option value="Private">Private</option>
                                <option value="Public">Public</option>
                                <option value="Friends">Friends</option>
                                <option value="Group">Group</option>
                            </select>
                            
                        </div>

                         <!-- <div class="col-md-6 mb-4">
                            <label class="labels">Country </label>
                             <select title="Select Country" name="country" class="form-control" id="country_name">      
                                <option value="">Select Country</option>
                                <?php
                                // foreach ($countries as $key => $element) { ?>
                                    <option  value="<?php echo $element['id']; ?>"> <?php echo $element['name']; ?></option>
                                <?php
                                    // }
                                ?>
                            </select>
                             @error('country')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="labels">State </label>
                             <select title="Select Country" name="state"  class="form-control state1" id="state_name" >     
                                <option value="">Select State</option>
                                
                            </select>
                             @error('state')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="labels">City </label>
                             <select title="Select Country" name="city" class="form-control" id="city_name">      
                                <option value="">Select City</option>
                            </select>
                             @error('city')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="labels">Zip Code </label>
                            <input name="zipcode" type="text" maxlength="8" class="form-control" id="Zipcode" value="<?php echo old('zipcode'); ?>" placeholder="zipcode">
                             @error('zipcode')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div> -->

                        <!-- <div class="col-md-6 mb-4">
                            <label class="labels">Event Type </label>
                               <select title="Select Country" name="event_type" class="form-control">      
                                    <option >Event type</option>
                                    <option value="Online" >Online</option>
                                    <option value="Ofline">Ofline</option>
                                </select>
                                 @error('eventType')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                        </div> -->
                      
                        <div class="col-md-12 mb-4">
                            <label class="labels">Description</label>
                            <div id="summernote">
                                <textarea id="editor1" class="form-control" name="description" placeholder="Write a text"><?php echo old('description'); ?></textarea>

                               
                                @error('description')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                         <div class="custom-control">
                                <label class="custom-toggle">
                                    <input type="checkbox" name="personal_detail" value="true"  > <span>Do you want to show your contact details on the post ?</span>
                                </label>
                            </div>
                    </div>

                    <div class="row bg-white border-radius mt-5 p-3">
                        <div class="col-md-4 social-area d-flex justify-content-center">
                            <input type="radio"  name="post_type" value="Bump Post">
                            <label class="labels" data-toggle="tooltip" data-placement="top" title="You can bump your post for only $3 per day.">Bump Listing.. <i class="fa fa-question popup">
        
                            </i></label>
                            @error('bump_post')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-4 social-area d-flex justify-content-center">
                            <input type="radio"  name="post_type" value="Feature Post">
                            <label class="labels" data-toggle="tooltip" data-placement="top" title="Your post can now be featured starting at just $55 per month. (Popular)">Feature Listing..  <i class="fa fa-question popup1">
                            </i></label>
                            @error('bump_post')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-4 social-area d-flex justify-content-center">
                            <input type="radio"  name="post_type" value="Normal Post">
                            <label class="labels" data-toggle="tooltip" data-placement="top" title="Write a regular post.">Free Listing..  <i class="fa fa-question popup2"  >
                            </i></label>
                            @error('bump_post')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>


                    <div class="mt-5 text-center"><button class="btn profile-button" type="submit">Publish</button></div> 



                </div>
            </form>
          </div>

             <script type="text/javascript">

                const removeCover = document.getElementById('removeCover');
                const removeCoverImg = document.getElementById('imagecoverPreview');
                                                
                removeCover.addEventListener('click', function () {
                    document.getElementById("imagecoverPreview").src = "{{ asset('images/bannerh.png') }}";
                });
                
                const removeProfile = document.getElementById('removeProfile');
                const imageElement = document.getElementById('imagePreview');
                
                removeProfile.addEventListener('click', function () {
                    document.getElementById("imagePreview").src = "{{ asset('images/default.jpg') }}";
                    checkDefaultImage();
                });
                
                function checkDefaultImage() {
                    var defaultImageSrc = "{{ asset('images/default.jpg') }}";
                    var currentProfileImageSrc = document.getElementById('imagePreview').src;
                    var profileImageInput = document.getElementById('imageInput');
                    var profileImageLabel = document.getElementById('profileImageLabel');
                
                    if (currentProfileImageSrc === defaultImageSrc) {
                        // If the current profile image is the default one, enable the input field
                        profileImageInput.style.display = 'none';
                        profileImageLabel.style.display = 'none';
                    } else {
                        // If the current profile image is not the default one, disable the input field
                        profileImageInput.style.display = 'none';
                        profileImageLabel.style.display = 'none';
                    }
                }

var outImage = "imagecoverPreview";
function preview_2(obj) {
    if (FileReader) {
        var reader = new FileReader();
        reader.readAsDataURL(obj.files[0]);
        reader.onload = function (e) {
            var image = new Image();
            image.src = e.target.result;
            image.onload = function () {
                document.getElementById(outImage).src = image.src;
            };
        }
    } else {
        // Not supported
    }
}

function previewImage(event) {
    var input = event.target;
    var reader = new FileReader();

    reader.onload = function () {
        var dataURL = reader.result;
        var imagePreview = document.getElementById('imagePreview');
        imagePreview.src = dataURL;
        checkDefaultImage(); // Check if the uploaded image is default after preview
    };

    reader.readAsDataURL(input.files[0]);
}

// Initial check for default image
checkDefaultImage();

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
        
        </script>    

        <script>
     // Get references to the select box and the target divs
var selectBox = document.getElementById('selectBox');
var targetDivs = document.querySelectorAll('.targetDiv');

// Add an event listener to the select box
selectBox.addEventListener('change', function () {
  // Check the selected option value
  var selectedOption = selectBox.value;

  // Hide all target divs
  targetDivs.forEach(function (div) {
    div.style.display = 'none';
  });

  // Show the target div that matches the selected option
  var selectedDiv = document.querySelector('.targetDiv[data-option="' + selectedOption + '"]');
  if (selectedDiv) {
    selectedDiv.style.display = 'block';
  }
});

        </script>

        <script>
            // Wait for the DOM to be ready
document.addEventListener('DOMContentLoaded', function() {
    // Get references to HTML elements
    var locationInput = document.getElementById('locationInput');
    var searchButton = document.getElementById('searchButton');
    var results = document.getElementById('results');

    // Event listener for the search button
    searchButton.addEventListener('click', function() {
        // Get the user-entered location
        var location = locationInput.value;

        // Perform location-based actions here
        // You can use a mapping library like Google Maps or a location API for geocoding

        // For this example, we'll just display the entered location
        results.textContent = 'You searched for: ' + location;
    });
});

        </script>

@endsection