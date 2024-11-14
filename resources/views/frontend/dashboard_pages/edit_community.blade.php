@extends('layouts.user_dashboard.userdashboardlayout')
@section('content')
<?php  use Carbon\Carbon; ?>
<style>
    .error-message {color: #e74a3b;}
    @media only screen and (max-width:767px){
        .container-fluid {padding-bottom: 50px !important;}
    }
</style>
<div class="container px-sm-5 px-4 pb-4">
    <form method="post" action="<?php echo route('our_community_edit',$blog->slug); ?>" class="form-validation" enctype="multipart/form-data" id="community_form">
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
                    <?php 
                        $currentDateTime = new DateTime();
                        $givenTime = $blog->created; // Assuming $post->created_at is a valid date string

                        // Convert the given time to a Carbon instance
                        $givenDateTime = Carbon::parse($givenTime);

                        // Add 10 days to the given date time
                        $nextTenDays = $givenDateTime->addDays(10);

                    ?> 
                    <div class="row bg-white border-radius pb-4 p-3">
                        @if($currentDateTime > $nextTenDays)
                        <div class="col-md-6 mb-4">
                            <label class="labels">Title <sup>*</sup></label>
                            <input type="text" id="title-input" class="form-control" name="title" id="title" placeholder="Title" value="{{$blog->title}}" required readonly data-toggle="tooltip" data-placement="top" title="You can't make edits as you created this post more than 10 days ago.">
                             <span class="error-message" id="title-error"></span>
                        </div>
                        @else 
                        <div class="col-md-6 mb-4">
                            <label class="labels">Title <sup>*</sup></label>
                            <input type="text" id="title-input" class="form-control" name="title" id="title" placeholder="Title" value="{{$blog->title}}" required>
                             <span class="error-message" id="title-error"></span>
                            @error('title')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        @endif 

                        <!-- <div class="col-md-6 mb-4 form-check check-frame">
                            <input class="form-check-input" id="inputRememberPassword" type="checkbox" value="" />
                            <label class="form-check-label" for="inputRememberPassword">Do you want to make this Post Featured?</label>
                        </div> -->

                    {{-- @if($currentDateTime > $nextTenDays)  
                        <div class="col-md-6 mb-4">
                            <label class="labels">Sub categories <sup>*</sup></label>
                            @foreach($categories as $cate)
                                @if($blog->sub_category == $cate->id)
                                    <input type="text" value="{{ $cate->title }}" class="form-control mb-2" readonly data-toggle="tooltip" data-placement="top" title="You can't make edits as you created this post more than 10 days ago.">
                                    <input type="hidden" name="sub_category" value="{{ $cate->id }}">
                                @endif
                            @endforeach
                        </div>
                    @else
                        <div class="col-md-6 mb-4">
                            <label class="labels">Sub categories <sup>*</sup></label>
                            <select  name="sub_category" class="form-control form-control-xs selectpicker"  data-size="7" data-live-search="true" data-title="Sub categories" id="state_list" data-width="100%"  required>
                                @foreach($categories as $cate)
                                <option {{ $blog->sub_category == $cate->id ? 'selected' : '' }} value="{{$cate->id}}" >{{$cate->title}}</option>
                                @endforeach
                                
                            </select>
                             @error('sub_categories')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    @endif --}}

                    <div class="col-md-6 mb-4">
                            <label class="labels">Sub categories <sup>*</sup></label>
                            <select  name="sub_category" class="form-control form-control-xs selectpicker"  data-size="7" data-live-search="true" data-title="Sub categories" id="state_list" data-width="100%"  required>
                                @foreach($categories as $cate)
                                <option {{ $blog->sub_category == $cate->id ? 'selected' : '' }} value="{{$cate->id}}" >{{$cate->title}}</option>
                                @endforeach
                                
                            </select>
                             @error('sub_categories')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <!-- <div class="col-md-6 mb-4">
                            <label class="labels">Date</label>
                            <input class="form-control" type="text" id="datepicker" name="datepicker" placeholder="Enter Date" />
                            <div class="input-group date">
                                <input type="date" class="form-control" value="{{$blog->event_start_date}}" id="event_start_date"  name="event_start_date" placeholder="DD-MM-YYYY" />
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
                        <!-- <div class="col-md-6 mb-4">
                            <label class="labels">Time</label>
                            <div class="input-group time">
                              <input class="form-control" type="time" id="timepicker" value="{{$blog->event_start_time}}" name="event_start_time" placeholder="--:-- --" />
                              
                               @error('event_start_time')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div> -->
                        <!-- <div class="col-md-6 mb-4">
                            <label class="labels">Post For</label>
                            <select class="form-control" name="postfor" required>
                                <option >Select option</option>
                                <option {{ $blog->postfor == 'articles' ? 'selected' : '' }} value="articles" >articles</option>
                                <option {{ $blog->postfor == 'videos' ? 'selected' : '' }} value="videos" >videos</option>
                                <option {{ $blog->postfor == 'events' ? 'selected' : '' }} value="events" >events</option>
                            </select>
                            @error('post_type')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div> -->
                        <div class="col-md-12 mb-4">
                            <label class="labels">Want to reach a larger audience? Add location</label>
                            <input name="location" type="text"  class="form-control get_loc" id="location" value="{{ $blog->location }}" placeholder="Location">
                            <div class="searcRes" id="autocomplete-results">
                                    
                            </div>
                        </div>

                        <!-- <div class="col-md-6 mb-4">
                            <label class="labels">Country </label>
                             <select title="Select Country" name="country" class="form-control" id="country_name" post-id="{{$blog->id}}" >      
                                <option>Select Country</option>
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
                            <label class="labels">Zip code</label>
                            <input type="text" class="form-control" name="zipcode" id="zipcode" placeholder="Enter zipcode" value="{{$blog->zipcode}}" required>
                            @error('zipcode')
                                    <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div> -->

                        <div class="col-md-6 mb-4">
                        <label class="labels" data-toggle="tooltip" data-placement="top" title="Any photo that signals an intention to commit, solicit, promote or encourage a criminal act and/or violate the  Advertiser Agreement will not be accepted.">Post Featured Image <em>(Select Multiple)</em> <i class="fa fa-question popup2"> </i></label>
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
                                    <input data-required="image" type="file" name="image1[]" id="image_upload" class="image-input" data-traget-resolution="image_resolution" value="" multiple accept="image/gif, image/jpeg, image/png" onchange="checkImageCount(this , maxImageCount)"> 
                                </label>
                              
                            </div> -->
                            
                            {{-- @if($currentDateTime > $nextTenDays) --}}
                            <div class="upload-icon"><a class="cam btn btn-warning"  href="javascript:void(0)">
                                <i class="fa fa-upload" aria-hidden="true"></i>
                                    Upload image
                                </a> 
                            </div>
                            {{-- @else
                            <div class="upload-icon"><a class="cam btn btn-warning"  href="javascript:void(0)">
                                <i class="fa fa-upload" aria-hidden="true"></i>
                                    Upload image
                                </a> 
                            </div>
                            @endif --}}
                           
                            <!-- <div class="gallery" id="sortableImgThumbnailPreview"></div> -->
                            
                            @error('image')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror 
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="show-img ">
                                <?php
                                 $neimg = trim($blog->image1,'[""]');
                                $img  = explode('","',$neimg);
                                
                                // echo "<pre>";print_r($img);die('dev');
                                 ?>
                                 <div class="gallery">
                                    @foreach($img as $index => $images)
                                    <div class='apnd-img'>
                                        <img src="{{ asset('images_blog_img') }}/{{ $images }}" id='img' remove_name="{{ $images }}" dataid="{{$blog->id}}" class='img-responsive'> 
                                        @if($currentDateTime < $nextTenDays) 
                                        <i class='fa fa-trash delfile'></i>
                                        @endif
                                        
                                    </div>
                                    
                                    @endforeach
                                </div>
                            </div>
                           <!--  <label class="labels"> Post video format: .mp4 | Max size: 2MB</label>
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
                            <div class="show-video ">
                               <video controls id="video-tag">
                                  <source id="video-source" src="{{asset('images_blog_video')}}/{{$blog->post_video}}">
                                  Your browser does not support the video tag.
                                </video>
                                 
                                 @error('post_video')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div> -->
                        </div>
                        
                       <div class="container">
                        <div class="row">
                            {{-- @if($currentDateTime > $nextTenDays)  
                            <div class="col-xl-6">
                                <div class="file-upload-contain">
                                    <input id="multiplefileupload" name="document[]" type="file" accept=".pdf,.xlsx,.xls" value="{{$blog->document}}" disabled />
                                </div>
                            </div>
                            @else
                            <div class="col-xl-6">
                                <div class="file-upload-contain">
                                    <input id="multiplefileupload" name="document[]" type="file" accept=".pdf,.xlsx,.xls" value="{{$blog->document}}"  multiple />
                                </div>
                            </div>
                            @endif --}}

                            <div class="col-xl-6">
                                <div class="file-upload-contain">
                                    <input id="multiplefileupload" name="document[]" type="file" accept=".pdf,.xlsx,.xls" value="{{$blog->document}}"  multiple />
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <div class="show_Docs">
                               <?php 
                                $doc_m = trim($blog->document,'[""]');
                                $doc  = explode('","',$doc_m);
                                
                                 // echo "<pre>";print_r($doc);die('dev');
                                 ?>
                                 @if($blog->document)
                                 @foreach($doc as $docs)
                                 <iframe src="{{asset('images_blog_doc')}}/{{$docs}}" width="20%" height="150px"></iframe>
                                
                                 
                                 @endforeach
                                @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($currentDateTime > $nextTenDays)
                    <div class="col-md-12 mb-4">
                        <label class="labels">Description <sup>*</sup></label>
                            <textarea class="form-control" name="description" placeholder="Description" readonly data-toggle="tooltip" data-placement="top" title="You can't make edits as you created this post more than 10 days ago.">{{strip_tags($blog->description)}}</textarea>
                    </div>
                    @else 
                    <div class="col-md-12 mb-4">
                        <label class="labels">Description <sup>*</sup></label>
                        <div id="summernote">
                            <textarea id="editor1" class="form-control" name="description" placeholder="Description">{{strip_tags($blog->description)}}</textarea>
                            @error('description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    @endif

                     <div class="col-md-12 mb-4">
                              
                                    <div class="col-md-12 mt-4">
                                        <label class="custom-toggle">
                                            <input type="checkbox" name="personal_detail" value="true" {{ $blog->personal_detail == 'true'? 'checked' : '' }}> &nbsp;&nbsp;<span>Show your contact details. Keep in mind if you want customers to reach you outside of FindersPage you will need to make your contact details visible to the public.</span>
                                        </label>
                                    </div> 
                                     <div class="row"> 
                                        <div class="col-md-6 mt-4 ">
                                            <label class="custom-toggle">Email</label>
                                                <input type="email"  class="form-control" name="email" value="{{$blog->email}}" placeholder="example@example.com">
                                           
                                        </div>
                                        <div class="col-md-6 mt-4">
                                            <label class="custom-toggle">Phone number</label>
                                                <input type="tel"  class="form-control" name="phone" id="phone" value="{{$blog->phone}}" placeholder="+1 1234567890">
                                        </div>
                                        <div class="col-md-6 mt-4">
                                            <label class="custom-toggle">Website link</label>
                                                <input type="text" class="form-control" name="website" value="{{$blog->website}}" placeholder="https://test.com">
                                        </div>
                                        <div class="col-md-6 mt-4">
                                            <label class="custom-toggle">Whatsapp</label>
                                                <input type="tel"  class="form-control" id="whatsapp" name="whatsapp" value="{{$blog->whatsapp}}" placeholder="whatsapp number">
                                        </div>
                                        <!-- <div class="col-md-2 mt-4">
                                            <label class="custom-toggle">Twitter</label>
                                                <input type="text" class="form-control" name="twitter" value="{{$blog->twitter}}" placeholder="https://twitter.com/">
                                        </div>
                                        <div class="col-md-2 mt-4">
                                            <label class="custom-toggle">Youtube </label>
                                                <input type="text" class="form-control" name="youtube" value="{{$blog->youtube}}" placeholder="https://www.youtube.com/channel">
                                        </div>
                                        <div class="col-md-2 mt-4">
                                            <label class="custom-toggle">Facebook</label>
                                                <input type="text" class="form-control" name="facebook" value="{{$blog->facebook}}" placeholder="https://www.facebook.com">
                                        </div>
                                        <div class="col-md-2 mt-4">
                                            <label class="custom-toggle">Instagram</label>
                                                <input type="text" class="form-control" name="instagram" value="{{$blog->instagram}}" placeholder="https://www.instagram.com">
                                        </div> 
                                        <div class="col-md-2 mt-4">
                                            <label class="custom-toggle">Linkedin </label>
                                                <input type="text" class="form-control" name="linkedin" value="{{$blog->linkedin}}" placeholder="https://www.linkedin.com/">
                                        </div>
                                         <div class="col-md-2 mt-4">
                                            <label class="custom-toggle">Tiktok </label>
                                                <input type="text" class="form-control" name="tiktok" value="{{$blog->tiktok}}" placeholder="https://www.tiktok.com/@">
                                        </div>  -->
                                </div> 
                            </div>
                    </div>
                 


                 

                    
                    <!-- <div class="row bg-white border-radius mt-5 p-3">
                        <div class="col-md-6 mb-6 social-area" style="justify-content: center;">
                            <input type="radio"  name="post_type" value="Feature Post" {{ $blog->featured_post === 'on' ? 'checked' : '' }} required>
                            <label class="labels" data-toggle="tooltip" data-placement="top" title="Feature your listing on the homepage starting at just $55 per month.">Feature Listing  <i class="fa fa-question popup1">
                            </i></label>
                            @error('post_type')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-6 social-area" style="justify-content: center;">
                            <input type="radio"  name="post_type" value="Normal Post" {{ $blog->post_type === 'Normal Post' ? 'checked' : '' }} >
                            <label class="labels"  data-toggle="tooltip" data-placement="top" title="Your free listing will expire after 30 days. If you renew it before the 30 days is up, your listing will stay up for another 30 days.">Free Listing  <i class="fa fa-question popup2">
                            </i></label>
                            @error('post_type')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div> -->

                    <input type="hidden" name="post_type" value="Normal Post" >

                    <div class="mt-5 text-center"><button class="btn profile-button" type="submit">Publish</button></div> 
                </form>
                </div>


<script type="text/javascript">
                $(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();   
});

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


        jQuery(document).ready(function() {

            var countryid =   $("#country_name").val();
            var userid1 = $('#country_name').attr('post-id');
            
               console.log(" countryid "+countryid);
               console.log("userid1 "+userid1);
           var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                $.ajax({
                    url: baseurl+'/edit/filter/state',
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
                            url: baseurl+'/edit/filter/city',
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