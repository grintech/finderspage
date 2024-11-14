@extends('layouts.adminlayout')
@section('content')
<div class="header bg-primary pb-6">
	<div class="container-fluid">
		<div class="header-body">
			<div class="row align-items-center py-4">
				<div class="col-lg-6 col-8">
					<h6 class="h2 text-white d-inline-block mb-0">Manage Product Categories</h6>
				</div>
				<div class="col-lg-6 col-4 text-right">
					<a href="<?php echo route('admin.products.subCategories') ?>" class="btn btn-neutral"><i class="ni ni-bold-left"></i> Back</a>
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
							<h3 class="mb-0">Create New Category Here.</h3>
						</div>
					</div>
				</div>
				<div class="card-body">
					<form method="post" action="<?php echo route('admin.products.subCategories.add') ?>" class="form-validation">
						<!--!! CSRF FIELD !!-->
						{{ @csrf_field() }}
						<h6 class="heading-small text-muted mb-4">General information</h6>
						<div class="pl-lg-4">
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<label class="form-control-label" for="input-first-name">Category</label>
										<select class="form-control" name="parent_id" required>
									      	<option value="" selected>Select</option>
									      	<?php foreach($categories as $c): ?>
									      		<?php if($c->sub_categories()->count() > 0): ?>
									      			<optgroup label="<?php echo $c->title ?>">
									      				
									      				<?php foreach($c->sub_categories as $c): ?>
									      					<option 
									      						value="<?php echo $c->id ?>" 
									      						<?php echo old('category') && in_array($c->id, old('category'))  ? 'selected' : '' ?>
									      					><?php echo $c->title ?></option>
									      				<?php endforeach; ?>

									      			</optgroup>
									      		<?php else: ?>
									      			<option 
									      				value="<?php echo $c->id ?>" 
									      				<?php echo old('category') && in_array($c->id, old('category'))  ? 'selected' : '' ?>
									      			><?php echo $c->title ?></option>
									      		<?php endif; ?>

									  		<?php endforeach; ?>
									    </select>
										@error('category')
											<small id="title-error" class="text-danger">{{ $message }}</small>
										@enderror
									</div>
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