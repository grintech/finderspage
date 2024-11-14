@extends('layouts.adminlayout')

@section('content')


<div class="container-fluid">
 				<form method="post" action="<?php echo route('updateEvent',$blog->id); ?>" class="form-validation" enctype="multipart/form-data" id="eventformSadmin">
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
                            <input type="text" class="form-control" name="title" placeholder="Enter post name" value="{{$blog->title}}" required>
                            <span class="error-message" id="title-error"></span>
                             @error('title')
                                <small class="text-danger">{{ $message }}</small>
                             @enderror
                        </div>

                        
                        <div class="col-md-6 mb-4">
                            <label class="labels">Event Date </label>
                            <input type="date" name="event_start_date" class="form-control" value="{{$blog->event_start_date}}">
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="labels">Start time </label>
                            <input type="time" name="event_start_time" class="form-control" value="{{$blog->event_start_time}}">
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="labels">End time </label>
                            <input type="time" name="event_end_time" class="form-control" value="{{$blog->event_end_time}}">
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="labels">Event Price ($)</label>
                            <input type="text" name="rate" class="form-control" placeholder="$" value="{{$blog->rate}}">
                        </div>
                         <div class="col-md-6 mb-4">
                            <label class="labels">Country </label>
                             <select title="Select Country" name="country" class="form-control" id="country_name" post-id="{{$blog->id}}" >      
                                <option value="">Select Country</option>
                                <?php
                                foreach ($countries as $key => $element) { ?>
                                    <option {{ $blog->country == $element['id'] ? 'selected' : '' }}  value="<?php echo $element['id']; ?>"> <?php echo $element['name']; ?></option>
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
                            <input name="zipcode" type="text" maxlength="8" class="form-control" id="Zipcode" value="{{$blog->zipcode}}" placeholder="zipcode">
                             @error('zipcode')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="labels">Event Type </label>
                               <select title="Select Country" name="event_type" class="form-control">      
                                    <option >Event type</option>
                                    <option {{ $blog->event_type == 'Online' ? 'selected' : '' }} value="Online" >Online</option>

                                    <option {{ $blog->event_type == 'Offline' ? 'selected' : '' }} value="Offline">Offline</option>
                                </select>
                                 @error('eventType')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                        </div>
                      
                     <div class="col-md-6 mb-4">
                         <label class="labels">Post featured image *[Max-size - 1 MB]</label> 
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
                                    <input data-required="image" type="file" name="image1[]" id="image_upload" class="image-input" data-traget-resolution="image_resolution" value="" multiple accept="image/gif, image/jpeg, image/png"> 
                                </label>
                              
                            </div>
                            <div class="show-img ">
                                <?php
                                 $neimg = trim($blog->image1,'[""]');
                                $img  = explode('","',$neimg);
                                
                                // echo "<pre>";print_r($img);die('dev');
                                 ?>
                                 @foreach($img as $images)
                                 <img src="{{asset('images_blog_img')}}/{{$images}}" alt="" class="uploaded-image" id="image-container" >
                                 
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
                                    <input data-required="image" type="file" accept="video/*"  id="video_upload" class="image-input" data-traget-resolution="image_resolution" name="post_video" value="">
                                </label>
                            </div>
                            <div class="show-video ">
                               <video controls id="video-tag">
                                  <source id="video-source" src="{{asset('images_blog_video')}}/{{$blog->post_video}}">
                                  Your browser does not support the video tag.
                                </video>
                                 
                                 @error('post_video')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12 mb-4">
                            <label class="labels">Description</label>
                            <div id="summernote">
                                <textarea id="editor1" class="form-control" name="description" placeholder="Write a text"><?php echo old('description'); ?>{{$blog->description}}</textarea>

                               
                                @error('description')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12 d-flex" ><h6 class=" mb-3 text-gray-800 fw-bold">Do you want to show your contact details.</h6>
                            <div class="custom-control">
                                <label class="custom-toggle">
                                    <input type="checkbox" name="personal_detail" value="true"  pan class="custom-toggle-slider "  {{ $blog->personal_detail == 'true'? 'checked' : '' }}></span>
                                </label>
                            </div>
                        </div>
                    
                </div>
                    
                    <div class="row bg-white border-radius mt-5 p-3">
                      <div class="col-md-4 social-area">
                            <input type="radio"  name="post_type" value="Bump Post" {{ $blog->bumpPost === '1' ? 'checked' : '' }}>
                            <label class="labels" data-toggle="tooltip" data-placement="top" title="You can bump your post for only $3 per day.">Bump post  <i class="fa fa-question popup">
                                 <span class="popuptext" id="myPopupTool">Bump Your Post At Just $3 Per Day</span>
                            </i></label>
                            @error('bump_post')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-4 social-area">
                            <input type="radio"  name="post_type" value="Feature Post" {{ $blog->featured_post === 'on' ? 'checked' : '' }} >
                            <label class="labels" data-toggle="tooltip" data-placement="top" title="Your post can now be featured starting at just $55 per month.">Feature post  <i class="fa fa-question popup1">
                                 <span class="popuptext1" id="myPopupTool1">Featured Your Post Start At Just $55 Per Month !</span>
                            </i></label>
                            @error('bump_post')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-4 social-area">
                            <input type="radio"  name="post_type" value="Normal Post" {{ $blog->post_type === '1' ? 'checked' : '' }}>
                            <label class="labels"  data-toggle="tooltip" data-placement="top" title="Write a regular post.">Normal post  <i class="fa fa-question popup2" >
                                 <span class="popuptext2" id="myPopupTool2">Create Your Normal Post</span>
                            </i></label>
                            @error('bump_post')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-5 text-center"><button class="btn profile-button" type="submit">Publish</button></div> 
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


        jQuery(document).ready(function() {

            var countryid =   $("#country_name").val();
            var userid1 = $('#country_name').attr('post-id');
            
               console.log(" countryid "+countryid);
               console.log("userid1 "+userid1);
           var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                $.ajax({
                    url: admin_url+'/fetch/state/job',
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
                      console.log('stateID1'+stateID1);
                      console.log('userid2'+userid2);
                     $.ajax({
                            url: admin_url+'/fetch/city/job',
                            type: 'POST',
                            headers: {
                              'X-CSRF-TOKEN': csrfToken
                            },
                            data: {
                                id: stateID1,
                                userid :userid2
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
        </script> 

@endsection