@extends('layouts.adminlayout')

@section('content')



<div class="header bg-primary pb-6">

	<div class="container-fluid">

		<div class="header-body">

			<div class="row align-items-center py-4">

				<div class="col-lg-6 col-7">

					<h6 class="h2 text-white d-inline-block mb-0">Manage Posts</h6>

				</div>

				<div class="col-lg-6 col-5 text-right">

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

							<h3 class="mb-0">Update Post Details Here.</h3>

						</div>

					</div>

				</div>

				<div class="card-body">

					<form method="post" action="<?php echo route('admin.blogs.edit', ['id' => $blog->id]) ?>" class="form-validation">

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

							      				value="<?php echo $c->id ?>" 

							      				<?php
							      				  echo old('category') && in_array($c->id, old('category'))  ? 'selected' : '' 
							      				 ?>
							      				 @if($c->id == $category[0]['category_id']) selected @endif
							      			><?php echo $c->title ?></option>

							      		<?php //endif; ?>



							  		<?php endforeach; ?>

							    </select>

								@error('category')

								    <small class="text-danger">{{ $message }}</small>

								@enderror

							</div>


							<div class="form-group">

								<label class="form-control-label" for="input-first-name">Sub Category</label>

								<select class="form-control childCategoryselects" name="sub_category"  required>	
										@foreach($categories as $oldcat)
										<?php $newvar = $oldcat->sub_categories;?>
											    @foreach($newvar as $key => $cate)
											    		@if($cate->id == $blog->sub_category)
											    				<option value="{{$cate->id}}" selected="selected">{{$cate->title}}</option>
											    		@else
											    				<option value="{{$cate->id}}">{{$cate->title}}</option>
											    		@endif;
															
													@endforeach
							      @endforeach
							   </select>

								@error('category')

								    <small class="text-danger">{{ $message }}</small>

								@enderror

							</div>



							<div class="form-group job-type d-none">

									<div class="form-check">
										<input class="form-check-input worldwide" type="radio" name="job_type" id="full_time" value="<?php echo $blog->job_type?>" checked="">
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

								<input type="text" class="form-control" name="title" required placeholder="Title" value="{{$blog->title}}">

								@error('title')

								    <small class="text-danger">{{ $message }}</small>

								@enderror

							</div>

							<div class="row">

								<div class="col-lg-12">

									<div class="form-group">

										<label class="form-control-label">Description</label>

										<textarea rows="2" id="editor1" class="form-control" placeholder="Description" name="description">{{$blog->description}}</textarea>

										@error('description')

										    <small class="text-danger">{{ $message }}</small>

										@enderror

									</div>
								</div>

							</div>

							<div class="row">

								<div class="col-lg-12">

									<div class="form-group">
										<input type="checkbox" value="on" name="featured_post" {{ $blog->featured_post == 'on' ? 'checked' : '' }} >
										<label class="form-control-label">Set As Featured Post</label>

										@error('featured_post')

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

								<input type="text" class="form-control" name="meta_title" placeholder="Meta Title" value="{{$blog->meta_title}}">

								@error('meta_title')

								    <small class="text-danger">{{ $message }}</small>

								@enderror

							</div>

							<div class="form-group">

								<label class="form-control-label">Meta Description</label>

								<textarea rows="2" class="form-control" placeholder="Your description" name="meta_description">{{$blog->meta_description}}</textarea>

								@error('meta_description')

								    <small class="text-danger">{{ $message }}</small>

								@enderror

							</div>

							<div class="form-group">

								<label class="form-control-label" for="input-first-name">Meta Keywords</label>

								<input type="text" class="form-control" name="meta_keywords" placeholder="Meta Keywords" value="{{$blog->meta_keywords}}">

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

									<div class="form-group">

										<!-- FILE OR IMAGE UPLOAD. FOLDER PATH SET HERE in data-path AND CHANGE THE data-multiple TO TRUE SEE MAGIC  -->



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

									            <!-- PROGRESS BAR -->

												<div class="progress d-none">

								                  <div class="progress-bar bg-default" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>

								                </div>

								            </div>

							                <!-- INPUT WITH FILE URL -->

							                <textarea class="d-none" name="image"><?php echo old('image') ?></textarea>

							                <div class="show-section <?php echo !old('image') ? 'd-none' : "" ?>">

							                	@include('admin.partials.previewFileRender', ['file' => old('image') ])

							                </div>
							                @if($blog->image1 !="")
							                <div class="fixed-edit-section">
							                	<div class="show-section"><div class="single-image"><a href="javascript:;" class="fileRemover single-cross image" data-path="{{$blog->image1}}"><i class="fas fa-times" aria-hidden="true"></i></a><img src="{{$blog->image1}}"></div></div>
							                </div>
							                @endif

										</div>

									</div>

								</div>

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

						<div class="form-group video-sec">
		                    <h6 class="heading-small text-muted mb-4" for="exampleInput">Post Video</h6>
		                    <div class="upload-btn-wrapper">
		                        <div class="upload-image-section" data-type="video" data-multiple="false">

		                            <div
		                                class="upload-section">
		                                <div class="button-ref mb-3">
		                                    <button class="btn btn-icon btn-primary btn-lg" type="button"
		                                        style="width: 100%;height: 150px;opacity: 1;">
		                                        <span class="btn-inner--icon"><i class="fas fa-upload"></i></span>
		                                        <span class="btn-inner--text">Upload Video</span>
		                                    </button>
		                                </div>
		                                <!-- PROGRESS BAR -->
		                                <div class="progress d-none">
		                                    <div class="progress-bar bg-default" role="progressbar" aria-valuenow="0"
		                                        aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
		                                </div>
		                            </div>

		                            <!-- INPUT WITH FILE URL -->
		                           <!--  <textarea name="post_video" style="position: absolute;top: -4000px;">
		                            </textarea> -->
		                            


		                            <div class="show-section"></div>
		                            @if($blog->post_video != "")
		                            <div class="fixed-edit-section">
		                            	<div class="single-image video"><a href="javascript:;" class="fileRemover single-cross image" data-path="' + response.path + '"><i class="fas fa-times"></i></a><video width="350" height="210" controls><source src="{{$blog->post_video}}" type="video/mp4">Your browser does not support the video tag.</video></div>
							                	
							        </div>
							        @endif
							                	
							                

		                       </div>
		                    </div><br>
		                    <p><small class="tex-muted">Format: .mp4 | Max Size: 20MB</small></p>
		                    @error('image')
		                        <small class="text-danger">{{ $message }}</small>
		                    @enderror
		                </div>

		                <input type="hidden" id="uploaded_img" name="uploaded_img" value="{{$blog->image1}}">
		                <input type="hidden" id="post_video" name="post_video" value="{{$blog->post_video}}">

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