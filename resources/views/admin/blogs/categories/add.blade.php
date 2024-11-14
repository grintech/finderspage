@extends('layouts.adminlayout')

@section('content')

<div class="header bg-primary pb-6">

	<div class="container-fluid">

		<div class="header-body">

			<div class="row align-items-center py-4">

				<div class="col-lg-6 col-8">

					<h6 class="h2 text-white d-inline-block mb-0">Manage Post Categories</h6>

				</div>

				<div class="col-lg-6 col-4 text-right">

					<a href="<?php echo route('admin.blogs.categories') ?>" class="btn btn-neutral"><i class="ni ni-bold-left"></i> Back</a>

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

						<div class="col-12">

							<h3 class="mb-0">Create New Category Here.</h3>

						</div>

					</div>

				</div>

				<div class="card-body">

					<form method="post" action="<?php echo route('admin.blogs.categories.add') ?>" class="form-validation">

						<!--!! CSRF FIELD !!-->

						{{ @csrf_field() }}

						<h6 class="heading-small text-muted mb-4">General information</h6>

						<div class="pl-lg-4">

							<div class="row">

								<div class="col-lg-12">

									<div class="form-group">

										<label class="form-control-label" for="input-first-name">Parent Category</label>

										<select class="form-control" name="parent_id" >
							      		<!-- <option class="maine-text" value="null">No Parent</strong></option> -->
							      	<?php foreach($categories as $c): ?>
							      		
							      		<?php if($c->sub_categories()->count() > 0): ?>
							      			
							      				<option class="maine-text" value="<?php echo $c->id ?>"><b><?php echo $c->title ?></strong></option>
							      				
							      				<?php foreach($c->sub_categories as $c): ?>
							      					<option
							      						class="option-text" 
							      						value="<?php echo $c->id ?>" 
							      						<?php echo old('category') && in_array($c->id, old('category'))  ? 'selected' : '' ?>
							      					> &nbsp; &nbsp; &nbsp;<?php echo $c->title ?></option>
							      				<?php endforeach; ?>

							      		<?php else: ?>
							      			<option 
							      				value="<?php echo $c->id ?>" 
							      				<?php echo old('category') && in_array($c->id, old('category'))  ? 'selected' : '' ?>
							      			><?php echo $c->title ?></option>
							      		<?php endif; ?>

							  		<?php endforeach; ?>
							    </select>

										<!-- <select class="form-control" name="parent_id">

									      	<option value="">No Parent</option>

									      	<?php foreach($categories as $c): ?>

									      	<option value="<?php echo $c->id ?>" <?php echo old('parent_id') && old('parent_id') == $c->id ? 'selected' : '' ?>><?php echo $c->title ?></option>

									  		<?php endforeach; ?>

									    </select> -->

										@error('parent_id')

										    <small class="text-danger">{{ $message }}</small>

										@enderror

									</div>

								</div>

								<div class="col-lg-12">

									<div class="form-group">

										<label class="form-control-label" for="input-first-name">Title</label>

										<input type="text" class="form-control" name="title" required placeholder="Title" value="{{ old('title') }}">

										@error('title')

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