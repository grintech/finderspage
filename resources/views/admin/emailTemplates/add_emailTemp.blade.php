@extends('layouts.adminlayout')
@section('content')
	
	<div class="header bg-primary pb-6">
	<div class="container-fluid">
		<div class="header-body">
			<div class="row align-items-center py-4">
				<div class="col-lg-6 col-7">
					<h6 class="h2 text-white d-inline-block mb-0">Manage Email Templates</h6>
				</div>
				<div class="col-lg-6 col-5 text-right">
					<a href="<?php echo route('admin.emailTemplates') ?>" class="btn btn-neutral"><i class="ni ni-bold-left"></i> Back</a>
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
							<h3 class="mb-0">Add Template Details Here.</h3>
						</div>
					</div>
				</div>
				<div class="card-body">
					<form method="post" action="{{route('admin.emailTemplates.save')}}" class="form-validation">
						<!--!! CSRF FIELD !!-->
						{{ @csrf_field() }}
						<h6 class="heading-small text-muted mb-4">Template information</h6>
						<div class="pl-lg-4">
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<label class="form-control-label" for="input-first-name">Title</label>
										<input type="text" class="form-control" name="title" required placeholder="Subject" value="">
										@error('title')
										    <small class="text-danger">{{ $message }}</small>
										@enderror
									</div>

								</div>
								
							</div>
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<label class="form-control-label" for="input-first-name">Slug</label>
										<input type="text" class="form-control" name="slug" required placeholder="Subject" value="">
										@error('slug')
										    <small class="text-danger">{{ $message }}</small>
										@enderror
									</div>

								</div>
								
							</div>

							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<label class="form-control-label" for="input-first-name">Type</label>
										<select class="form-control" name="type">
											<option value='admin'>Admin</option>
											<option value='client'>Client</option>
										</select>
										@error('slug')
										    <small class="text-danger">{{ $message }}</small>
										@enderror
									</div>

								</div>
								
							</div>

							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<label class="form-control-label" for="input-first-name">Subject</label>
										<input type="text" class="form-control" name="subject" required placeholder="Subject" value="">
										@error('subject')
										    <small class="text-danger">{{ $message }}</small>
										@enderror
									</div>

								</div>
								
							</div>

							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<label class="form-control-label" for="input-first-name">ShortCode</label>
										<input type="text" class="form-control" name="short_codes" required placeholder="Subject" value="">
										@error('short_codes')
										    <small class="text-danger">{{ $message }}</small>
										@enderror
									</div>

								</div>
								
							</div>
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<label class="form-control-label">Description</label>
										
										<textarea rows="2" class="form-control" id="editor1" placeholder="Description" name="description"></textarea>
										@error('description')
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

