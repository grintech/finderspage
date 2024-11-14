@extends('layouts.user_dashboard.userdashboardlayout')
@section('content')
 			<div class="container px-sm-5 px-4">
 				<form method="post" action="{{route('update.video',$video->id)}}" class="form-validation" enctype="multipart/form-data" id="videoEdit_form">
 					{{ @csrf_field() }}
                    <!-- Page Heading -->
                    <div class="d-sm-flex flex-column  mb-3">
                        <h1 class="h3 mb-0 text-gray-800 fw-bold">Videos & Films</h1>
                        
                    </div>
                    <span>
                    	@include('admin.partials.flash_messages')
                    </span>
                    <input type="hidden" name="categories" value="727">
                    <div class="row bg-white border-radius pb-4 p-3">
                        <div class="col-md-6 mb-4">
                            <label class="labels">Title <sup>*</sup></label>
                            <input type="text" class="form-control" name="title" placeholder="Enter post name" value="{{$video->title}}" required>
                            <span class="error-message" id="title-error"></span>
                             @error('title')
                                <small class="text-danger">{{ $message }}</small>
                             @enderror
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="labels">Sub Categories</label>
                            <select class="form-control form-control-xs selectpicker" name="sub_category" data-size="7" data-live-search="true" data-title="Sub Category" id="sub_category" data-width="100%">
                           
                            @foreach($categories as $cate)
                            <option {{ $video->sub_category == $cate->id ? 'selected' : '' }} data-tokens="{{$cate->title}}" value="{{$cate->id}}" >{{$cate->title}}</option>
                            @endforeach
                            <option class="Other-cate" value="Other" >Other</option> 
                          </select>

                           <input type="text" class="form-control d-none mt-2" id="Other-cate-input" name="sub_category_oth" placeholder="sub_category name" value="">
                       </div>

                       <div class="col-md-6 mb-4">
                            <label class="labels">Location</label>
                            <input type="text" class="form-control" name="location" placeholder="Enter location name" value="{{$video->location}}" >
                            <span class="error-message" id="title-error"></span>
                             @error('location')
                                <small class="text-danger">{{ $message }}</small>
                             @enderror
                        </div>
                     
                        <div class="col-md-6 mb-4">
                            <label class="labels"> Upload Video </label>
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
                                    <input data-required="image" type="file" accept="video/*"  id="video_upload" class="image-input" data-traget-resolution="image_resolution" name="video" value="">
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4 show-video">
                                @if(isset($video->video))
                                   <video controls id="video-tag">
                                      <source id="video-source" src="{{asset('video_short')}}/{{$video->video}}">
                                      Your browser does not support the video tag.
                                    </video>
                                     <i class="fas fa-times" id="cancel-btn-1"></i>
                                     @error('post_video')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                @endif
                            </div>


                        <div class="col-md-12 mb-4">
                            <label class="labels">Captions</label>
                            <input type="text" class="form-control" name="captions" placeholder="Enter video Captions" value="{{$video->captions}}" required>
                            <span class="error-message" id="title-error"></span>
                             @error('captions')
                                <small class="text-danger">{{ $message }}</small>
                             @enderror
                        </div>

                        <!-- <div class="col-md-12 mb-4">
                         <label class="labels">Thumbnail Image </label> 
                            <div class="image-upload post_img ">
                                <label style="cursor: pointer;" for="image_upload">
                                   
                                    <div class="h-100">
                                        <div class="dplay-tbl">
                                            <div class="dplay-tbl-cell">
                                                <i class="fas fa-cloud-upload-alt mb-3"></i>
                                                <h6><b>Upload Image</b></h6>
                                                <h6 class="mt-10 mb-70">Or drop your image here</h6>
                                            </div>
                                        </div>
                                    </div>
                               
                                    <input data-required="image" type="file" name="image"  id="image_upload" class="image-input" data-traget-resolution="image_resolution" value="" accept="image/gif, image/jpeg, image/png" > 
                                </label>
                              
                            </div>
                            <div class="show-img">
                                @if(isset($video->image))
                                    <img src="{{asset('video_short')}}/{{$video->image}}">
                                @endif
                            </div>
                            @error('image')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror 
                        </div> -->

                          <div class="col-md-12 mb-4">
                            <label class="labels">Description</label>
                            <div id="summernote">
                                <textarea id="editor1" class="form-control" name="description" placeholder="Write a text">{{$video->description}}</textarea>

                               
                                @error('description')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            
                        </div>
                        <?php 

                           
                            $jsonString = json_decode($video->mension);
                             $array = implode(',', $jsonString);

                        ?>

                         <div class="col-md-12 mb-4">
                            <label class="labels">Mension</label>
                            <div id="summernote">
                                <textarea class="form-control" id="mension-user"  name="mension" placeholder="username">{{$array}}</textarea>

                               
                                @error('mension')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror

                                <div class="my-followers">
                                    <div class="video-scroller">
                                        
                                    </div>
                                </div>
                            
                        </div>
                        </div>


                        <div class="col-md-6 mb-4 sett_ing">
						    <span>Who can see it?</span>
						    <label class="switch">
							  <input type="checkbox" id="togBtn1" name="view_as" @if($video->view_as == "on") checked @endif>
							  <div class="slider round">
							    <span class="on">Public</span>
							    <span class="off">Private</span>
							  </div>
							</label>
						</div>
                         <div class="col-md-6 mb-4">
                            <label class="labels">Schedule Publish Time</label>
                            <input type="datetime-local" class="form-control" name="schedule" value="{{$video->schedule}}" >
                            <span class="error-message" id="title-error"></span>
                             @error('schedule')
                                <small class="text-danger">{{ $message }}</small>
                             @enderror
                        </div>

                        <div class="col-md-4 mb-4 social-area">
                            <input type="radio"  name="post_type" value="Bump Post" {{ $video->post_type === 'Bump Post' ? 'checked' : '' }}>
                            <label class="labels" data-toggle="tooltip" data-placement="top" title="You can bump your post for only $3 per day.">Bump Listing..  <i class="fa fa-question popup">
                                 <!-- <span class="popuptext" id="myPopupTool">Bump Your Post At Just $3 Per Day</span> -->
                            </i></label>
                            @error('bump_post')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-4 social-area">
                            <input type="radio"  name="post_type" value="Feature Post" {{ $video->featured_post === 'on' ? 'checked' : '' }} >
                            <label class="labels" data-toggle="tooltip" data-placement="top" title="Your post can now be featured starting at just $55 per month. (Popular)">Feature Listing..  <i class="fa fa-question popup1">
                                 <!-- <span class="popuptext1" id="myPopupTool1">Featured Your Post Start At Just $55 Per Month !</span> -->
                            </i></label>
                            @error('bump_post')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-4 social-area">
                            <input type="radio"  name="post_type" value="Normal Post" {{ $video->post_type === 'Normal Post' ? 'checked' : '' }}>
                            <label class="labels" data-toggle="tooltip" data-placement="top" title="Write a regular post.">Free Listing..  <i class="fa fa-question popup2">
                                 <!-- <span class="popuptext2" id="myPopupTool2">Create Your Normal Post</span> -->
                            </i></label>
                            @error('bump_post')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

						 <div class="col-lg-12 m-auto text-center ">
							  <input type="submit" class="btn btn-warning addCategory" value="save">

                              <!-- <div class="btn btn-dark addCategory">testBtn</div> -->
						</div>
                    
                  
              </form>
			</div>

            <script type="text/javascript">
                
                $(document).ready(function () {
                    $('#mension-user').click(function () {
                     var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    $.ajax({
                        url: baseurl+'/getfollower',
                        type: 'POST',
                        headers: {
                          'X-CSRF-TOKEN': csrfToken
                        },
                        data: {
                        },
                        success: function(response){
                          console.log(response);
                          $('.my-followers').html(response);
                        },
                        error: function(xhr, status, error) {
                          console.log(response);
                        }
                      });
                });

                $("#mension-user").focusout(function(){ 
                setTimeout(function () {
                    $('.my-followers').hide();
                 }, 600); 
                    
                });
                $("#mension-user").focusin(function(){  
                    $('.my-followers').show();
                });  

                
                $(document).on("click",".mainClass1 h6",function() {
                     // alert('hello');
                    var text = $(this).text();
                    console.log(text);
                    $("#mension-user").append(text,',');
                });
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
                    e.preventDefault();
                    var subcate_title = $('#Other-cate-input').val();
                     var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    $.ajax({
                        url: baseurl+'/shopping/cate',
                        type: 'POST',
                        headers: {
                          'X-CSRF-TOKEN': csrfToken
                        },
                        data: {
                            title:subcate_title,
                            parent_id:6,
                        },
                        success: function(response){
                          console.log(response);
                          $('#videoEdit_form').submit();
                        },
                        error: function(xhr, status, error) {
                         
                        }
                      });
                });
            });
            </script> 

@endsection