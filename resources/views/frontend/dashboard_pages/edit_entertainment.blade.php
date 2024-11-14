@extends('layouts.user_dashboard.userdashboardlayout')
@section('content')
<?php  use Carbon\Carbon; ?>
<style>
    .error-message {color: #e74a3b;}
    @media only screen and (max-width:767px){
        .container {padding-bottom: 50px !important;}
    }
	.slider {position: relative; top: 4px;}
</style>
<div class="container px-sm-5 px-4 pb-4">
	<form method="post" action="<?php echo route('Entertainment.d_update',$Entertainment->slug); ?>" class="form-validation" enctype="multipart/form-data">
		{{ @csrf_field() }}
		<div class="d-sm-flex flex-column  mb-3">
            <h1 class="h3 mb-0 text-gray-800 fw-bold">Edit entertainment listing</h1>
            <p>Choose the best category that fits your needs and create a free listing</p>
        </div>
        <span>
        	@include('admin.partials.flash_messages')
        </span>
        <input type="hidden" name="categories" value="741">
        <?php 
            $currentDateTime = new DateTime();
            $givenTime = $Entertainment->created_at; // Assuming $post->created_at is a valid date string

            // Convert the given time to a Carbon instance
            $givenDateTime = Carbon::parse($givenTime);

            // Add 10 days to the given date time
            $nextTenDays = $givenDateTime->addDays(10);


        ?> 
        <div class="row bg-white border-radius pb-4 p-3">
            @if($currentDateTime > $nextTenDays)
	        <div class="col-md-6 mb-4">
	            <label class="labels">Title</label>
	            <input type="text" id="title-input" class="form-control" name="title" placeholder="Title" value="{{$Entertainment->Title}}" readonly data-toggle="tooltip" data-placement="top" title="You can't make edits as you created this post more than 10 days ago.">
	        </div>
            @else
	        <div class="col-md-6 mb-4">
	            <label class="labels">Title</label>
	            <input type="text" id="title-input" class="form-control" name="title" placeholder="Title" value="{{$Entertainment->Title}}">
	            <span class="error-message" id="title-error"></span>
	             @error('title')
	                <small class="text-danger">{{ $message }}</small>
	             @enderror
	        </div>
            @endif



            {{-- @if($currentDateTime > $nextTenDays)  
            <div class="col-md-6 mb-4">
                <label class="labels">Sub categories <sup>*</sup></label>
                @foreach($categories as $cate)
                    @if($Entertainment->sub_category == $cate->id)
                        <input type="text" value="{{$cate->title}}" class="form-control mb-2" readonly data-toggle="tooltip" data-placement="top" title="You can't make edits as you created this post more than 10 days ago.">
                        <input type="hidden" name="sub_category" value="{{$cate->id}}">
                    @endif
                @endforeach
            </div>
            @else
	        <div class="col-md-6 mb-4">
                <label class="labels">Sub categories</label>
                <select class="form-control form-control-xs selectpicker" name="sub_category" data-size="7" data-live-search="true" data-title="Sub categories" id="category_list" data-width="100%">
               
                @foreach($categories as $cate)
                <option data-tokens="{{$cate->title}}" {{ $Entertainment->sub_category == $cate->id ? 'selected' : '' }}  value="{{$cate->id}}" >{{$cate->title}}</option>
                @endforeach
              </select>
           	</div>
            @endif --}}

            <div class="col-md-6 mb-4">
                <label class="labels">Sub categories</label>
                <select class="form-control form-control-xs selectpicker" name="sub_category" data-size="7" data-live-search="true" data-title="Sub category" id="category_list" data-width="100%">
               
                @foreach($categories as $cate)
                <option data-tokens="{{$cate->title}}" {{ $Entertainment->sub_category == $cate->id ? 'selected' : '' }}  value="{{$cate->id}}" >{{$cate->title}}</option>
                @endforeach
              </select>
           	</div>

			<div class="col-md-6 mb-4">
				<label class="labels">Gender</label>
				<select class="form-control Age-range" name="gender">
					<option value="">Select</option>
					<option value="Male" {{ $Entertainment->gender == "Male" ? 'selected' : '' }} >Male</option>
					<option value="Female" {{ $Entertainment->gender == "Female" ? 'selected' : '' }}  >Female</option>

				</select>
				@error('choices')
				<small class="text-danger">{{ $message }}</small>
				@enderror

				<div class="form-group d-none" id="Male-Range">
					<div class="slider-container">
						<label class="form-check-label" for="male_age_range">Male Age</label>
						<input type="range" id="male_age_range" name="male_age_range" min="0" max="100" class="slider" style="width: 93%;" value="{{$Entertainment->male_age_range}}">
						<span id="male_age_value" class="slider-value">{{$Entertainment->male_age_range}}</span>
					</div>
					<span class="text-danger" id="range_error"></span>
				</div>
				
				<div class="form-group d-none" id="Female-Range">
					<div class="slider-container">
						<label class="form-check-label" for="female_age_range">Female Age</label>
						<input type="range" id="female_age_range" name="female_age_range" min="0" max="100" class="slider" style="width: 93%;" value="{{$Entertainment->female_age_range}}">
						<span id="female_age_value" class="slider-value">{{$Entertainment->female_age_range}}</span>
					</div>
					<span class="text-danger" id="range_error"></span>
				</div>
			</div>
            {{-- @if($currentDateTime > $nextTenDays)  
            <div class="col-md-6 mb-4">
                <label class="labels">Job type</label>
                <input type="text" value="{{ $Entertainment->paying }}" class="form-control mb-2" readonly data-toggle="tooltip" data-placement="top" title="You can't make edits as you created this post more than 10 days ago.">
                <input type="hidden" name="paying" value="{{ $Entertainment->paying }}">
            </div>
            @else
            <div class="col-md-6 mb-4">
	           <label class="labels">Paying</label>
	            <select class="form-control Paying-Nonpaying" name="paying">
	                <option value="">Select</option>
	                <option value="Paying" {{ $Entertainment->paying == "Paying" ? 'selected' : '' }} >Paying</option>
	                <option value="Non-Paying" {{ $Entertainment->paying == "Non-Paying" ? 'selected' : '' }} >Non-Paying</option>
	            </select>
	            @error('choices')
	                <small class="text-danger">{{ $message }}</small>
	            @enderror

	            <div class="form-group d-none" id="Paying">
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form-check-label" for="exampleInput">Amount ($)</label>
                            <input type="number" class="form-control" name="amount" value="{{$Entertainment->amount}}">
                            
                        </div>
                    </div>
                </div>
                <div class="form-group d-none" id="Non-Paying">
                    <label class="form-check-label" for="exampleInput">Publish</label>
                    <input type="date" name="publish_date" class="form-control" value="{{$Entertainment->publish_date}}">
                    <span class="text-danger" id="fixed_error"> </span>
                </div>
        	</div>
            @endif --}}

            <div class="col-md-6 mb-4">
	           <label class="labels">Choose your choice</label>
	            <select class="form-control Paying-Nonpaying" name="paying">
	                <option value="">Select</option>
	                <option value="Paying" {{ $Entertainment->paying == "Paying" ? 'selected' : '' }} >Paying</option>
	                <option value="Non-Paying" {{ $Entertainment->paying == "Non-Paying" ? 'selected' : '' }} >Non-Paying</option>
					<option value="SAG-AFTRA" {{ $Entertainment->paying == "SAG-AFTRA" ? 'selected' : '' }} >SAG-AFTRA</option>
					<option value="Non-Union" {{ $Entertainment->paying == "Non-Union" ? 'selected' : '' }} >Non-Union</option>
	            </select>
	            @error('choices')
	                <small class="text-danger">{{ $message }}</small>
	            @enderror

	            <div class="form-group d-none" id="Paying">
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form-check-label" for="exampleInput">Amount ($)</label>
                            <input type="number" class="form-control" name="amount" value="{{$Entertainment->amount}}">
                            
                        </div>
                    </div>
                </div>
                <div class="form-group d-none" id="Non-Paying">
                    <label class="form-check-label" for="exampleInput">Publish</label>
                    <input type="date" name="publish_date" class="form-control" value="{{$Entertainment->publish_date}}">
                    <span class="text-danger" id="fixed_error"> </span>
                </div>
        	</div>
            
            {{-- @if($currentDateTime > $nextTenDays)
        	<div class="col-md-6 mb-4">
	            <label class="labels">Role naame</label>
	            <input type="text" class="form-control" name="role_name" placeholder="Enter Role name" value="{{$Entertainment->role_name}}"  readonly data-toggle="tooltip" data-placement="top" title="You can't make edits as you created this post more than 10 days ago.">
	        </div>
            @else
        	<div class="col-md-6 mb-4">
	            <label class="labels">Role naame</label>
	            <input type="text" class="form-control" name="role_name" placeholder="Enter Role name" value="{{$Entertainment->role_name}}">
	            <span class="error-message" id="title-error"></span>
	             @error('role_name')
	                <small class="text-danger">{{ $message }}</small>
	             @enderror
	        </div>
            @endif --}}

            <div class="col-md-6 mb-4">
	            <label class="labels">Role naame</label>
	            <input type="text" class="form-control" name="role_name" placeholder="Enter Role name" value="{{$Entertainment->role_name}}">
	            <span class="error-message" id="title-error"></span>
	             @error('role_name')
	                <small class="text-danger">{{ $message }}</small>
	             @enderror
	        </div>

			

        {{-- @if($currentDateTime > $nextTenDays)
	        <div class="col-md-6 mb-4">
	            <label class="labels">Deadline date</label>
	            <input type="date" class="form-control" name="deadline" value="{{$Entertainment->deadline}}" readonly data-toggle="tooltip" data-placement="top" title="You can't make edits as you created this post more than 10 days ago.">
	        </div>
            @else
	        <div class="col-md-6 mb-4">
	            <label class="labels">Deadline date</label>
	            <input type="date" class="form-control" name="deadline" value="{{$Entertainment->deadline}}">
	            <span class="error-message" id="title-error"></span>
	             @error('Deadline')
	                <small class="text-danger">{{ $message }}</small>
	             @enderror
	        </div>
            @endif --}}

            <div class="col-md-6 mb-4">
	            <label class="labels">Deadline date</label>
	            <input type="date" class="form-control" name="deadline" value="{{$Entertainment->deadline}}">
	            <span class="error-message" id="title-error"></span>
	             @error('Deadline')
	                <small class="text-danger">{{ $message }}</small>
	             @enderror
	        </div>

            {{-- @if($currentDateTime > $nextTenDays)
	        <div class="col-md-6 mb-4">
	            <label class="labels">Name of the producer</label>
	            <input type="text" class="form-control" name="producer" placeholder="Enter producer name" value="{{$Entertainment->producer}}" readonly data-toggle="tooltip" data-placement="top" title="You can't make edits as you created this post more than 10 days ago.">
	            <span class="error-message" id="title-error"></span>
	             @error('producer')
	                <small class="text-danger">{{ $message }}</small>
	             @enderror
	        </div>
            @else
	        <div class="col-md-6 mb-4">
	            <label class="labels">Name of the producer</label>
	            <input type="text" class="form-control" name="producer" placeholder="Enter producer name" value="{{$Entertainment->producer}}">
	            <span class="error-message" id="title-error"></span>
	             @error('producer')
	                <small class="text-danger">{{ $message }}</small>
	             @enderror
	        </div>
            @endif --}}

            <div class="col-md-6 mb-4">
	            <label class="labels">Name of the producer</label>
	            <input type="text" class="form-control" name="producer" placeholder="Enter producer name" value="{{$Entertainment->producer}}">
	            <span class="error-message" id="title-error"></span>
	             @error('producer')
	                <small class="text-danger">{{ $message }}</small>
	             @enderror
	        </div>

            {{-- @if($currentDateTime > $nextTenDays)
	        <div class="col-md-6 mb-4">
	            <label class="labels">Name of the director</label>
	            <input type="text" class="form-control" name="director" placeholder="Enter director name" value="{{$Entertainment->director}}" readonly data-toggle="tooltip" data-placement="top" title="You can't make edits as you created this post more than 10 days ago.">
	        </div>
            @else
	        <div class="col-md-6 mb-4">
	            <label class="labels">Name of the director</label>
	            <input type="text" class="form-control" name="director" placeholder="Enter director name" value="{{$Entertainment->director}}">
	            <span class="error-message" id="title-error"></span>
	             @error('director')
	                <small class="text-danger">{{ $message }}</small>
	             @enderror
	        </div>
            @endif --}}

            <div class="col-md-6 mb-4">
	            <label class="labels">Name of the director</label>
	            <input type="text" class="form-control" name="director" placeholder="Enter director name" value="{{$Entertainment->director}}">
	            <span class="error-message" id="title-error"></span>
	             @error('director')
	                <small class="text-danger">{{ $message }}</small>
	             @enderror
	        </div>


            {{-- @if($currentDateTime > $nextTenDays)
	        <div class="col-md-6 mb-4">
	            <label class="labels">Name of the writer</label>
	            <input type="text" class="form-control" name="writer" placeholder="Enter writer name" value="{{$Entertainment->writer}}" readonly data-toggle="tooltip" data-placement="top" title="You can't make edits as you created this post more than 10 days ago.">
	        </div>
            @else
	        <div class="col-md-6 mb-4">
	            <label class="labels">Name of the writer</label>
	            <input type="text" class="form-control" name="writer" placeholder="Enter writer name" value="{{$Entertainment->writer}}">
	            <span class="error-message" id="title-error"></span>
	             @error('writer')
	                <small class="text-danger">{{ $message }}</small>
	             @enderror
	        </div>
            @endif --}}

            <div class="col-md-6 mb-4">
	            <label class="labels">Name of the writer</label>
	            <input type="text" class="form-control" name="writer" placeholder="Enter writer name" value="{{$Entertainment->writer}}">
	            <span class="error-message" id="title-error"></span>
	             @error('writer')
	                <small class="text-danger">{{ $message }}</small>
	             @enderror
	        </div>


            {{-- @if($currentDateTime > $nextTenDays)
	        <div class="col-md-6 mb-4">
	            <label class="labels">Name of the casting director</label>
	            <input type="text" class="form-control" name="casting_director" placeholder="Enter casting director" value="{{$Entertainment->casting_director}}" readonly data-toggle="tooltip" data-placement="top" title="You can't make edits as you created this post more than 10 days ago.">
	        </div>
            @else
	        <div class="col-md-6 mb-4">
	            <label class="labels">Name of the casting director</label>
	            <input type="text" class="form-control" name="casting_director" placeholder="Enter casting director" value="{{$Entertainment->casting_director}}">
	            <span class="error-message" id="title-error"></span>
	             @error('casting_director')
	                <small class="text-danger">{{ $message }}</small>
	             @enderror
	        </div>
            @endif --}}

            <div class="col-md-6 mb-4">
	            <label class="labels">Name of the casting director</label>
	            <input type="text" class="form-control" name="casting_director" placeholder="Enter casting director" value="{{$Entertainment->casting_director}}">
	            <span class="error-message" id="title-error"></span>
	             @error('casting_director')
	                <small class="text-danger">{{ $message }}</small>
	             @enderror
	        </div>


            {{-- @if($currentDateTime > $nextTenDays)
	        <div class="col-md-6 mb-4">
	            <label class="labels">Audition dates</label>
	            <input type="date" class="form-control" name="audition_dates" value="{{$Entertainment->audition_dates}}" readonly data-toggle="tooltip" data-placement="top" title="You can't make edits as you created this post more than 10 days ago.">
	        </div>
            @else
	        <div class="col-md-6 mb-4">
	            <label class="labels">Audition dates</label>
	            <input type="date" class="form-control" name="audition_dates" value="{{$Entertainment->audition_dates}}">
	            <span class="error-message" id="title-error"></span>
	             @error('audition_dates')
	                <small class="text-danger">{{ $message }}</small>
	             @enderror
	        </div>
            @endif --}}

            <div class="col-md-6 mb-4">
	            <label class="labels">Audition dates</label>
	            <input type="date" class="form-control" name="audition_dates" value="{{$Entertainment->audition_dates}}">
	            <span class="error-message" id="title-error"></span>
	             @error('audition_dates')
	                <small class="text-danger">{{ $message }}</small>
	             @enderror
	        </div>

	       
            {{-- @if($currentDateTime > $nextTenDays)
	        <div class="col-md-6 mb-4">
	            <label class="labels">Email</label>
	            <input type="email" class="form-control" name="email" placeholder="Enter email " value="{{$Entertainment->email}}" readonly data-toggle="tooltip" data-placement="top" title="You can't make edits as you created this post more than 10 days ago.">
	        </div>
            @else
	        <div class="col-md-6 mb-4">
	            <label class="labels">Email</label>
	            <input type="email" class="form-control" name="email" placeholder="Enter email " value="{{$Entertainment->email}}">
	            <span class="error-message" id="title-error"></span>
	             @error('email')
	                <small class="text-danger">{{ $message }}</small>
	             @enderror
	        </div>
            @endif --}}

            <div class="col-md-6 mb-4">
	            <label class="labels">Email</label>
	            <input type="email" class="form-control" name="email" placeholder="Enter email " value="{{$Entertainment->email}}">
	            <span class="error-message" id="title-error"></span>
	             @error('email')
	                <small class="text-danger">{{ $message }}</small>
	             @enderror
	        </div>


            {{-- @if($currentDateTime > $nextTenDays)
            <div class="col-md-6 mb-4">
	            <label class="labels">Phone number</label>
	            <input type="tel" class="form-control" id="phone" name="phone_no" placeholder="Enter phone " value="{{$Entertainment->phone_no}}" readonly data-toggle="tooltip" data-placement="top" title="You can't make edits as you created this post more than 10 days ago.">
	        </div>
            @else
            <div class="col-md-6 mb-4">
	            <label class="labels">Phone number</label>
	            <input type="tel" class="form-control" id="phone" name="phone_no" placeholder="Enter phone " value="{{$Entertainment->phone_no}}">
	            <span class="error-message" id="title-error"></span>
	             @error('email')
	                <small class="text-danger">{{ $message }}</small>
	             @enderror
	        </div>
            @endif --}}

            <div class="col-md-6 mb-4">
	            <label class="labels">Phone number</label>
	            <input type="tel" class="form-control" id="phone" name="phone_no" placeholder="Enter phone " value="{{$Entertainment->phone_no}}">
	            <span class="error-message" id="title-error"></span>
	             @error('email')
	                <small class="text-danger">{{ $message }}</small>
	             @enderror
	        </div>

            {{-- @if($currentDateTime > $nextTenDays)
	        <div class="col-md-6 mb-4">
	            <label class="labels">Website</label>
	            <input type="links" class="form-control" name="website" placeholder="Enter website " value="{{$Entertainment->website}}"  readonly data-toggle="tooltip" data-placement="top" title="You can't make edits as you created this post more than 10 days ago.">
	        </div>
            @else
	        <div class="col-md-6 mb-4">
	            <label class="labels">Website</label>
	            <input type="links" class="form-control" name="website" placeholder="Enter website " value="{{$Entertainment->website}}">
	            <span class="error-message" id="title-error"></span>
	             @error('email')
	                <small class="text-danger">{{ $message }}</small>
	             @enderror
	        </div>
            @endif --}}

            <div class="col-md-6 mb-4">
	            <label class="labels">Website</label>
	            <input type="links" class="form-control" name="website" placeholder="Enter website " value="{{$Entertainment->website}}">
	            <span class="error-message" id="title-error"></span>
	             @error('email')
	                <small class="text-danger">{{ $message }}</small>
	             @enderror
	        </div>


            {{-- @if($currentDateTime > $nextTenDays)
	        <div class="col-md-6 mb-4">
	            <label class="labels">Portfolio/Social Links</label>
	            <input type="link" class="form-control" name="links" placeholder="Enter links " value="{{$Entertainment->links}}" readonly data-toggle="tooltip" data-placement="top" title="You can't make edits as you created this post more than 10 days ago.">
	        </div>
            @else
	        <div class="col-md-6 mb-4">
	            <label class="labels">Portfolio/Social Links</label>
	            <input type="link" class="form-control" name="links" placeholder="Enter links " value="{{$Entertainment->links}}">
	            <span class="error-message" id="title-error"></span>
	             @error('links')
	                <small class="text-danger">{{ $message }}</small>
	             @enderror
	        </div>
            @endif --}}

            <div class="col-md-6 mb-4">
	            <label class="labels">Portfolio/Social Links</label>
	            <input type="link" class="form-control" name="links" placeholder="Enter links " value="{{$Entertainment->links}}">
	            <span class="error-message" id="title-error"></span>
	             @error('links')
	                <small class="text-danger">{{ $message }}</small>
	             @enderror
	        </div>

	        <div class="col-md-12 mb-4">
				<label class="labels">Want to reach a larger audience? Add location</label>
				<input type="text" class="form-control get_loc" name="location" placeholder="Location" value="{{ $Entertainment->location }}" > 
				<div class="searcRes" id="autocomplete-results">
                </div>
				@error('location')
				<small class="text-danger">{{ $message }}</small>
				@enderror
			</div>

	        
	        <div class="col-md-6 mb-4">
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
               
                <div class="show-img">
                	@if($Entertainment->image)
                     <?php
                                $img  = explode(',',$Entertainment->image);
                                
                                // echo "<pre>";print_r($img);die('dev');
                                 ?>
					<div class="gallery">
                        @foreach($img as $index => $images)
                        <div class='apnd-img'>
                            <img src="{{ asset('images_entrtainment') }}/{{ $images }}" id='img' imgtype="entertainment" remove_name="{{ $images }}" dataid="{{$Entertainment->id}}" class='img-responsive'>
                             @if($currentDateTime < $nextTenDays) 
                            <i class='fa fa-trash delfile'></i>
                            @endif
                            
                        </div>
                        
                        @endforeach
                    </div>
                   
                    
                    @endif
                </div>
                @error('image')
                    <small class="text-danger">{{ $message }}</small>
                @enderror 
            </div>


            
            @if($currentDateTime > $nextTenDays)
            <div class="col-md-12 mb-4">
                <label class="labels">Description</label>
                    <textarea class="form-control" name="description" placeholder="Description" readonly data-toggle="tooltip" data-placement="top" title="You can't make edits as you created this post more than 10 days ago.">{{strip_tags($Entertainment->description)}}</textarea>
            </div>
            @else
            <div class="col-md-12 mb-4">
                <label class="labels">Description</label>
                <div id="summernote">
                    <textarea id="editor1" class="form-control" name="description" placeholder="Description">{{strip_tags($Entertainment->description)}}</textarea>
                    @error('description')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            @endif
            
    	</div>

    	<!-- <div class="row bg-white border-radius mt-5 p-3"> -->
                        <!-- <div class="col-md-6 social-area" style="justify-content: center;">
                            <input type="radio"  name="post_type" value="Feature Post" {{ $Entertainment->post_type === 'Feature Post' ? 'checked' : '' }} required>
                            <label class="labels" data-toggle="tooltip" data-placement="top" title="Feature your listing on the homepage starting at just $55 per month.">Feature Listing <i class="fa fa-question popup1">
                            </i></label>
                            @error('post_type')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6 social-area" style="justify-content: center;">
                            <input type="radio"  name="post_type" value="Normal Post" {{ $Entertainment->post_type === 'Normal Post' ? 'checked' : '' }} required>
                            <label class="labels" data-toggle="tooltip" data-placement="top" title="Your free listing will expire after 30 days. If you renew it before the 30 days is up, your listing will stay up for another 30 days.">Free Listing <i class="fa fa-question popup2"  >
                                
                            </i></label>
                            @error('post_type')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div> -->
                        <input type="hidden" name="post_type" value="Normal Post" >
                    <!-- </div> -->
                 <div class="col-md-12 mb-4">
            	<div class="mt-5 text-center">
            		<button class="btn profile-button" type="submit">Publish</button>
            	</div> 
            </div> 

	</form>
</div>
<script type="text/javascript">
    jQuery(document).ready(function() {
        var selected = true;

        function updateVisibility() {
            var value = $('.Paying-Nonpaying').val();

            if (value === 'Paying' || selected) {
                $('#Paying').removeClass('d-none');
                $('#Non-Paying').addClass('d-none');
            } else if (value === 'Non-Paying' || value === 'SAG-AFTRA' || value === 'Non-Union' || selected) {
                $('#Paying').addClass('d-none');
                $('#Non-Paying').removeClass('d-none');
            } else {
                $('#Paying').addClass('d-none');
                $('#Non-Paying').addClass('d-none');
            }
        }

        updateVisibility();

        $('.Paying-Nonpaying').change(function() {
            updateVisibility();
        });
    });

  jQuery(document).ready(function() {
    function handleAgeRangeChange() {
        var value = $(".Age-range").val();

        if (value === 'Male') {
            $('#Male-Range').removeClass('d-none');
            $('#Female-Range').addClass('d-none');
        } else if (value === 'Female') {
            $('#Male-Range').addClass('d-none');
            $('#Female-Range').removeClass('d-none');
        } else {
            $('#Male-Range').addClass('d-none');
            $('#Female-Range').addClass('d-none');
        }
    }

    $(".Age-range").change(function() {
        handleAgeRangeChange();
    });

    handleAgeRangeChange();

    function updateSliderValue(slider, valueSpan) {
        valueSpan.textContent = slider.value;
    }

    var maleRange = document.getElementById('male_age_range');
    var femaleRange = document.getElementById('female_age_range');
    var maleAgeValue = document.getElementById('male_age_value');
    var femaleAgeValue = document.getElementById('female_age_value');

    if (maleRange && femaleRange) {
        maleRange.addEventListener('input', function() {
            updateSliderValue(maleRange, maleAgeValue);
        });

        femaleRange.addEventListener('input', function() {
            updateSliderValue(femaleRange, femaleAgeValue);
        });

        // Initialize slider values
        if (maleRange) {
            updateSliderValue(maleRange, maleAgeValue);
        }
        if (femaleRange) {
            updateSliderValue(femaleRange, femaleAgeValue);
        }
    }
});

  $(document).ready(function(){
          $('[data-toggle="tooltip"]').tooltip();   
        }); 

		$(document).ready(function() {
        $('.get_loc').keyup(function() {
            var address = $(this).val();
            console.log(address);
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
        });

	$(document).on("click", ".Search_val", function() {
        var searchVal = $(this).text();
        // alert(searchVal);
        $('.get_loc').val(searchVal);
        $(this).addClass('active_li');
        $('#autocomplete-results').hide();

    });
</script>
@endsection