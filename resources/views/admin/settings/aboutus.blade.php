<?php use App\Models\Admin\Settings; ?>
@extends('layouts.adminlayout')
@section('content')
<div class="header bg-primary pb-6">
	<div class="container-fluid">
		<div class="header-body">
			<div class="row align-items-center py-4">
				<div class="col-lg-6 col-7">
					<h6 class="h2 text-white d-inline-block mb-0">Manage About Us Page</h6>
				</div>
			</div>
			@include('admin.partials.flash_messages')
		</div>
	</div>
</div>
<!-- Page content -->
<div class="container-fluid mt--6">
	<div class="row">
		<div class="col-xl-9 order-xl-1">
			<!-- ==== Section 1 ==== -->
			<div class="card">
				<div class="card-header">
					<div class="row align-items-center">
						<div class="col-12">
							<h3 class="mb-0">Section 1</h3>
						</div>
					</div>
				</div>
				<div class="card-body">
					<form method="post" class="form-validation" enctype="multipart/form-data">
						<!--!! CSRF FIELD !!-->
						{{ @csrf_field() }}
						<div class="form-group">
							<label class="form-control-label" for="input-title">Title</label>
							<input type="text" class="form-control" name="about_us_title" placeholder="Title" value="{{ Settings::get('about_us_title') }}" required>
							@error('about_us_title')
							    <small class="text-danger">{{ $message }}</small>
							@enderror
						</div>
						<div class="form-group">
							<label class="form-control-label" for="input-title">Short Description</label>
							<input type="text" class="form-control" name="about_us_short_description" placeholder="Short Description" value="{{ Settings::get('about_us_short_description') }}" required>
							@error('about_us_short_description')
							    <small class="text-danger">{{ $message }}</small>
							@enderror
						</div>
						 <div class="col-md-12 mb-4">
                         <label class="labels">Image </label> 
                            <div class="image-upload post_img ">
                                <label style="cursor: pointer;" for="image_upload">
                                   
                                    <div class="h-100">
                                        <div class="dplay-tbl">
                                            <div class="dplay-tbl-cell">
                                                <i class="far fa-file-image mb-3"></i>
                                                <h6>Upload Image</h6>
                                                <h6 class="mt-10 mb-70">Or Drop Your Image Here</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <!--upload-content-->
                                    <input data-required="image" type="file" name="image" id="image_upload" class="image-input" data-traget-resolution="image_resolution" value=""> 
                                </label>
                              
                            </div>
                            <div class="show-img">
                            	@if(!empty(Settings::get('image')))
                            	
                                 <img src="{{asset('images_entrtainment')}}/{{Settings::get('image')}}" alt="" class="uploaded-image" id="image-container" >
                                 <i class="fas fa-times text-white" id="cancel-btn"></i>
                                 @endif
                            </div>
                            @error('image')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror 
                        </div>
						<div class="form-group">
							<label class="form-control-label" for="input-title">Description</label>
							<textarea type="text" class="form-control" name="about_us_description" id="editor1" placeholder="Description" required>{{ Settings::get('about_us_description') }}</textarea>
							@error('about_us_description')
							    <small class="text-danger">{{ $message }}</small>
							@enderror
						</div>
						<hr class="my-4" />
						
						
						
						<hr class="my-4" />
						<button type="submit" class="btn btn-primary float-right">Submit</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection