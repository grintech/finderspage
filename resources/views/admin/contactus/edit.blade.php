<?php use Illuminate\Support\Arr; ?>
@extends('layouts.adminlayout')
@section('content')
<div class="header bg-primary pb-6">
	<div class="container-fluid">
		<div class="header-body">
			<div class="row align-items-center py-4">
				<div class="col-lg-6 col-7">
					<h6 class="h2 text-white d-inline-block mb-0">Manage Contactus</h6>
				</div>
				<div class="col-lg-6 col-5 text-right">
					<a href="<?php echo route('admin.contactus') ?>" class="btn btn-neutral"><i class="ni ni-bold-left"></i> Back</a>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Contactus content -->
<div class="container-fluid mt--6">
	<div class="row">
		<div class="col-xl-12 order-xl-1">
			<div class="card">
				<!--!! FLAST MESSAGES !!-->
				@include('admin.partials.flash_messages')
				<div class="card-header">
					<div class="row align-items-center">
						<div class="col-8">
							<h3 class="mb-0">Update Contactus Details Here.</h3>
						</div>
					</div>
				</div>
				<div class="card-body">
					<form method="post" action="<?php echo route('admin.contactus.edit', ['id' => $page->id]) ?>" class="form-validation">
						<!--!! CSRF FIELD !!-->
						{{ @csrf_field() }}
						<h6 class="heading-small text-muted mb-4">Contactus information</h6>
						<div class="pl-lg-4">
							<div class="row">

								<div class="col-lg-6">
									<div class="form-group">
										<label class="form-control-label" for="input-first-name">First name</label>
										<input type="text" class="form-control" name="first_name" required placeholder="First name" value="{{ old('first_name') }}">
										@error('first_name')
										    <small class="text-danger">{{ $message }}</small>
										@enderror
									</div>

								</div>

								<div class="col-lg-6">
									<div class="form-group">
										<label class="form-control-label" for="input-last-name">Last name</label>
										<input type="text" id="input-last-name" class="form-control" required placeholder="Last name" name="last_name" value="{{ old('last_name') }}">
										@error('last_name')
										    <small class="text-danger">{{ $message }}</small>
										@enderror
									</div>
								</div>
								<div class="col-lg-12">
									<div class="form-group">
										<label class="form-control-label" for="input-email">Email</label>
										<input type="text" class="form-control" name="email" required placeholder="Email" value="<?php echo $page->email ?>">
										@error('email')
										    <small class="text-danger">{{ $message }}</small>
										@enderror
									</div>

								</div>
								<div class="col-lg-12">
									<div class="form-group">
										<label class="form-control-label" for="input-message">Message</label>
										<input type="text" class="form-control" name="message" required placeholder="Message" value="<?php echo $page->message ?>">
										@error('message')
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
										<div class="custom-control">
											<label class="custom-toggle">
												<input type="hidden" name="status" value="0">
												<input type="checkbox" name="status" value="1" <?php echo ($page->status != '0' ? 'checked' : '') ?>>
												<span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
											</label>
											<label class="custom-control-label">Do you want to publish this contactus ?</label>
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