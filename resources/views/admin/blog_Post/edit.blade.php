@extends('layouts.adminlayout')

@section('content')

<div class="container-fluid px-5">
 				<form method="post" action="{{route('blog_post_update',$blog_post->slug)}}" enctype="multipart/form-data" >
 					{{ @csrf_field() }}
                    <!-- Page Heading -->
                    <div class="header-body d-sm-flex flex-column  mb-3">
                        <h6 class="h2 text-white d-inline-block mb-0">Edit your blog</h6>
                        <!-- <h1 class="h3 mb-0 text-gray-800 fw-bold">Edit your blog</h1> -->
                    </div>
                    <span>
                    	@include('admin.partials.flash_messages')
                    </span>
                    <input type="hidden" name="categories" value="728">

                    <div class="row bg-white border-radius pb-4 p-3">
                        <div class="col-md-6 mb-4">
                            <label class="labels">Title <sup>*</sup></label>
                            <input type="text" class="form-control" name="title" placeholder="Enter post name" value="{{$blog_post->title}}">
                            <span class="error-message" id="title-error"></span>
                             @error('title')
                                <small class="text-danger">{{ $message }}</small>
                             @enderror
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="labels">Blog Category</label>
                            <select name="subcategory" class="form-control form-control-xs selectpicker"  data-size="7" data-live-search="true" data-title="Blog Category" id="state_list" data-width="100%" >
                                <option value="">Select option</option>
                                @foreach($categories as $cate)
                                <option {{ $blog_post->subcategory == $cate->id ? 'selected' : '' }} value="{{$cate->id}}" >{{$cate->title}}</option>
                                @endforeach
                            </select>
                             <span class="error-message" id="title-error"></span>
                            @error('sub_categories')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                         
                      
                     <div class="col-md-6 mb-4">
                         <label class="labels">Blog Image </label> 
                            <div class="upload-icon"><a class="cam btn btn-warning"  href="javascript:void(0)">
                                <i class="fa fa-upload" aria-hidden="true"></i>
                                    upload image
                                </a> 
                            </div>
                           
                            <div class="gallery"></div>
                            <div class="show-img">
                                <?php
                                 $img  = explode(',',$blog_post->image);
                                
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
                            <label class="labels">Want to reach a larger audience? Add Location</label>
                            <input type="text" class="form-control get_loc" name="location" placeholder="Enter your location" value="<?php echo old('location'); ?>">
                            <div class="searcRes" id="autocomplete-results"></div>
                             @error('title')
                                <small class="text-danger">{{ $message }}</small>
                             @enderror
                        </div>
                        <div class="col-md-12 mb-4">
                            <label class="labels">Description <sup>*</sup></label>
                            <div id="summernote">
                                <textarea id="editor1" class="form-control" name="content" placeholder="Write a text">{{$blog_post->content}}</textarea>
                                <p id="wordCount">Word count: 0</p>

                               
                                @error('description')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                       
                        
                    
                </div>
                    <input type="hidden" name="posted_by" value="admin">
                    <div class="mt-5 text-center"><button class="btn profile-button" type="submit">update</button></div> 
                </div>
            </form>


            <script type="text/javascript">
                $(document).ready(function() {
    $('.get_loc').keyup(function () {
            var address = $(this).val();
            console.log(address);
             var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
             console.log('CSRF Token:', csrfToken);
            $.ajax({
                url: baseurl+'/get/place/autocomplete',
                type: 'POST',
                headers: {
                  'X-CSRF-TOKEN': csrfToken,
                },
                data: {
                    address:address,
                },
                success: function(response){
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
        $(document).on("click",".Search_val",function() {
            var searchVal = $(this).text();
            // alert(searchVal);
            $('.get_loc').val(searchVal);
            $(this).addClass('active_li');
              $('#autocomplete-results').hide();

        });
            </script>
@endsection