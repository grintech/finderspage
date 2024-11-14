@extends('layouts.adminlayout')

@section('content')

<div class="header bg-primary pb-6">

	<div class="container-fluid">

		<div class="header-body">

			<div class="row align-items-center py-4">

				<div class="col-lg-6 col-8">

					<h6 class="h2 text-white d-inline-block mb-0">Manage Post</h6>

				</div>

				<div class="col-lg-6 col-4 text-right">
					<a href="<?php echo route('admin.blogs') ?>" class="btn btn-neutral"><i class="ni ni-bold-left"></i> Back</a>
				</div>

			</div>

		</div>

	</div>

</div>

<!-- Page content -->

<div class="container-fluid mt--6">

	<div class="row">

		<div class="col-xl-12 order-xl-1">

			<div class="card">

				<!--!! FLAST MESSAGES !!-->

				@include('admin.partials.flash_messages')

				<div class="card-header">

					<div class="row align-items-center">

						<div class="col-8">

							<h3 class="mb-0">Create New Post Here.</h3>

						</div>

					</div>

				</div>

				<div class="card-body">

					<form method="post" action="<?php echo route('admin.blogs.add') ?>" class="form-validation" id="adduserform">

						<!--!! CSRF FIELD !!-->

						{{ @csrf_field() }}

						<h6 class="heading-small text-muted mb-4">Blog information</h6>

						<div class="pl-lg-4">

							<div class="form-group">

								<label class="form-control-label" for="input-first-name">Category</label>

								<select class="form-control parentCategoryselect" name="category"  required>

							      	<option value="">Select</option>

							      	<?php foreach($categories as $c): ?>



							      		<?php //if($c->sub_categories()->count() > 0): ?>

							      			<!-- <optgroup label="<?php //echo $c->title ?>"> -->

							      				

							      				<?php //foreach($c->sub_categories as $c): ?>

							      					<!-- <option value="<?php //echo $c->id ?>"><?php //echo $c->title ?></option> -->

							      				<?php //endforeach; ?>
											
											<!-- </optgroup> -->

							      		<?php //else: ?>

							      			<option 

							      				value="<?php echo $c->id ?>" >
							      			<?php echo $c->title ?></option>

							      		<?php //endif; ?>



							  		<?php endforeach; ?>

							    </select>

								@error('category')

								    <small class="text-danger">{{ $message }}</small>

								@enderror

							</div>


							<div class="form-group">

								<label class="form-control-label" for="input-first-name">Sub Category</label>

								<select class="form-control childCategoryselect" name="sub_category"  required>

							      	<option value="">Select</option>

							    </select>

								@error('category')

								    <small class="text-danger">{{ $message }}</small>

								@enderror

							</div>



							<div class="form-group job-type d-none">

									<div class="form-check">
										<input class="form-check-input worldwide" type="radio" name="job_type" id="full_time" value="worldwide" checked="">
										<label class="form-check-label form-control-label" for="flexRadioDefault1">
											Full Time
										</label>
									</div>
									@error('job_type')
										<small class="text-danger">{{ $message }}</small>
									@enderror
									<div class="form-check">
										<input class="form-check-input worldwide " type="radio" name="job_type"  value="part_time" checked="">
										<label class="form-check-label form-control-label" for="flexRadioDefault2">
											Part Time
										</label>
									</div>
									@error('job_type')
										<small class="text-danger">{{ $message }}</small>
									@enderror
								

							</div>

							<div class="form-group">

								<label class="form-control-label" for="input-first-name">Title</label>

								<input type="text" class="form-control" name="title" required placeholder="Title" value="{{ old('title') }}">

								@error('title')

								    <small class="text-danger">{{ $message }}</small>

								@enderror

							</div>

							<div class="row">

								<div class="col-lg-12">

									<div class="form-group">

										<label class="form-control-label">Description</label>

										<textarea rows="2" id="editor1" class="form-control" placeholder="Description" name="description">{{ old('description') }}</textarea>

										@error('description')

										    <small class="text-danger">{{ $message }}</small>

										@enderror

									</div>

								</div>

							</div>

						</div>

						<hr class="my-4" />

						<!-- Address -->

						<h6 class="heading-small text-muted mb-4">SEO Meta Information</h6>

						<div class="pl-lg-4">

							<div class="form-group">

								<label class="form-control-label" for="input-first-name">Meta Title</label>

								<input type="text" class="form-control" name="meta_title" placeholder="Meta Title" value="{{ old('meta_title') }}">

								@error('meta_title')

								    <small class="text-danger">{{ $message }}</small>

								@enderror

							</div>

							<div class="form-group">

								<label class="form-control-label">Meta Description</label>

								<textarea rows="2" class="form-control" placeholder="Your description" name="meta_description">{{ old('meta_description') }}</textarea>

								@error('meta_description')

								    <small class="text-danger">{{ $message }}</small>

								@enderror

							</div>

							<div class="form-group">

								<label class="form-control-label" for="input-first-name">Meta Keywords</label>

								<input type="text" class="form-control" name="meta_keywords" placeholder="Meta Keywords" value="{{ old('meta_keywords') }}">

								@error('meta_keywords')

								    <small class="text-danger">{{ $message }}</small>

								@enderror

							</div>

						</div>

						<hr class="my-4" />

						<!-- Address -->

						<h6 class="heading-small text-muted mb-4">Publish Information</h6>

						<div class="pl-lg-4">

							<div class="row">

								<div class="col-lg-6">



                         <label class="labels">Post Featured Image *</label> 
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
                                    <input data-required="image" type="file" name="image1" id="image_upload" class="image-input" data-traget-resolution="image_resolution" value=""> 
                                </label>
                              
                            </div>
                            <div class="show-img d-none">
                                 <img src="" alt="" class="uploaded-image" id="image-container" >
                                 <i class="fas fa-times" id="cancel-btn"></i>
                            </div>
                            @error('image')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror 
                        

									<!-- <div class="form-group">
										<div 

											class="upload-image-section"

											data-type="image"

											data-multiple="false"

											data-path="blogs"

											data-resize-large="920*640"

											data-resize-medium="400*250"

											data-resize-small="100*70"

										>

											<div class="upload-section">

												<div class="button-ref mb-3">

													<button class="btn btn-icon btn-primary btn-lg" type="button">

										                <span class="btn-inner--icon"><i class="fas fa-upload"></i></span>

										                <span class="btn-inner--text">Upload Image</span>

									              	</button>

									            </div>

												<div class="progress d-none">

								                  <div class="progress-bar bg-default" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>

								                </div>

								            </div>

							                

							                <textarea class="d-none" ><?php echo old('image') ?></textarea>

							                <div class="show-section <?php echo !old('image') ? 'd-none' : "" ?>">

							                	@include('admin.partials.previewFileRender', ['file' => old('image') ])

							                </div>

										</div>

									</div> -->

								</div>
								
				                   <div class="col-md-6 mb-4">
		                            <label class="labels"> Post Video</label> <small class="ml-4">Format: .mp4 | Max Size: 20MB</small>
		                            <div class="image-upload ">
		                                <label style="cursor: pointer;" for="video_upload">
		                                    <img src="" alt="" class="uploaded-image">
		                                    <div class="h-100 video_sec">
		                                           <div class="dplay-tbl">
		                                            <div class="dplay-tbl-cell">
		                                                <!-- <i class="fas fa-cloud-upload-alt mb-3"></i> -->
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
		                            </div>
		                        </div>
				                    @error('image')
				                        <small class="text-danger">{{ $message }}</small>
				                    @enderror
				             

								<div class="col-lg-6">

									<div class="form-group">

										<div class="custom-control">

											<label class="custom-toggle">

												<input type="hidden" name="status" value="0">
												

												<input type="checkbox" name="status" value="1" <?php echo (old('status') != '0' ? 'checked' : '') ?>>

												<span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>

											</label>

											<label class="custom-control-label">Do you want to publish this page ?</label>

										</div>

									</div>

								</div>

							</div>

						</div>

						<hr class="my-4" />

						<button href="#" class="btn btn-sm py-2 px-3 btn-primary float-right">

							<i class="fa fa-save"></i> Submit

						</button>

					</form>

				</div>

			</div>

		</div>

	</div>

</div>



@endsection