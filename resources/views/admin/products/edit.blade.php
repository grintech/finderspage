@extends('layouts.adminlayout')
@section('content')
<div class="header bg-primary pb-6">
	<div class="container-fluid">
		<div class="header-body">
			<div class="row align-items-center py-4">
				<div class="col-lg-6 col-7">
					<h6 class="h2 text-white d-inline-block mb-0">Manage Products</h6>
				</div>
				<div class="col-lg-6 col-5 text-right">
					<a href="<?php echo route('admin.products') ?>" class="btn btn-neutral"><i class="ni ni-bold-left"></i> Back</a>
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
							<h3 class="mb-0">Update Product Details Here.</h3>
						</div>
					</div>
				</div>
				<div class="card-body">
					<form method="post" action="<?php echo route('admin.products.edit', ['id' => $product->id]) ?>" class="form-validation">
						<!--!! CSRF FIELD !!-->
						{{ @csrf_field() }}
						<h6 class="heading-small text-muted mb-4">Product information</h6>
						<div class="pl-lg-4">
							<div class="form-group">
								<?php
								/** Pluck use to get normal array from associative array ***/
								$selectedCategories = Arr::pluck($product->categories, 'id');
								?>
								<label class="form-control-label" for="input-first-name">Category</label>
								<select class="form-control" name="category[]" required id="category-finder">
							      	<option value="">Select</option>
							      	<?php 
									$selected = $product->categories()->first();
									if($selected)
									{
										$parent = $selected->parent()->first();
										if($parent && $parent->parent_id)
										{
											$grandParent = $parent->parent()->first();
											echo '<option value="'.$selected->id.'">' . ($grandParent ? $grandParent->title . ' > ' : '') . $parent->title . ' > ' . $selected->title.'</option>';
										}
										else
										{
											echo '<option value="'.$selected->id.'">' . ($parent ? $parent->title . ' > ' : '') . ' ' . $selected->title.'</option>';
										}
									}
									?>

							      	<?php foreach($categories as $c): ?>

							      		<?php if($c->sub_categories()->count() > 0): ?>
							      			<optgroup label="<?php echo $c->title ?>">
							      				
							      				<?php foreach($c->sub_categories as $c): ?>
							      					<option 
							      						value="<?php echo $c->id ?>" 
							      					><?php echo $c->title ?></option>
							      				<?php endforeach; ?>

							      			</optgroup>
							      		<?php else: ?>
							      			<option 
							      				value="<?php echo $c->id ?>"
							      			><?php echo $c->title ?></option>
							      		<?php endif; ?>

							  		<?php endforeach; ?>
							    </select>
								@error('category')
								    <small class="text-danger">{{ $message }}</small>
								@enderror
							</div>
							<div class="form-group d-none" id="subcategory-dropdown">
								<label class="form-control-label" for="input-first-name">Select Sub Category</label>
								<div class="select-box">
									
								</div>
							</div>
							<div class="form-group">
								<label class="form-control-label" for="input-first-name">Sample Number</label>
								<input type="text" class="form-control" name="sample_no" placeholder="Sample Number" value="{{ $product->sample_no }}">
								@error('sample_no')
								    <small class="text-danger">{{ $message }}</small>
								@enderror
							</div>
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<label class="form-control-label" for="input-first-name">Title</label>
										<input type="text" class="form-control" name="title" required placeholder="Title" value="<?php echo $product->title ?>">
										@error('title')
										    <small class="text-danger">{{ $message }}</small>
										@enderror
									</div>

								</div>
								
							</div>
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<label class="form-control-label">Description</label>
										<textarea rows="5" class="form-control" placeholder="Description" required name="description"><?php echo $product->description ?></textarea>
										@error('description')
										    <small class="text-danger">{{ $message }}</small>
										@enderror
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<label class="form-control-label">Small Description</label>
										<textarea rows="2" class="form-control" placeholder="Small Description" required name="small_description" maxlength="95"><?php echo $product->small_description ?></textarea>
										@error('description')
										    <small class="text-danger">{{ $message }}</small>
										@enderror
									</div>
								</div>
							</div>
						</div>
						<hr class="my-4" />
						<!-- Address -->
						<h6 class="heading-small text-muted mb-4">Publish Information</h6>
						<div class="pl-lg-4">
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<!-- FILE OR IMAGE UPLOAD. FOLDER PATH SET HERE in data-path AND CHANGE THE data-multiple TO TRUE SEE MAGIC. DO NOT REMOVE THE NESTED CALSSES -->
										<div 
											class="upload-image-section"
											data-type="image"
											data-multiple="false"
											data-path="products"
											data-resize-large="680*873"
											data-resize-medium="324*416"
											data-resize-small="83*104"
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
							                <textarea class="d-none" name="image"></textarea>
							                <div class="show-section <?php echo !old('image') ? 'd-none' : "" ?>">
							                	@include('admin.partials.previewFileRender', ['file' => old('image') ])
							                </div>
							                <div class="fixed-edit-section">
							                	@include('admin.partials.previewFileRender', ['file' => $product->image, 'relationType' => 'products.image', 'relationId' => $product->id ])
							                </div>
										</div>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<div class="custom-control">
											<label class="custom-toggle">
												<input type="hidden" name="status" value="0">
												<input type="checkbox" name="status" value="1" <?php echo ($product->status != '0' ? 'checked' : '') ?>>
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