@extends('layouts.adminlayout')
@section('content')
<style>
	textarea.form-control {
		overflow-y: scroll !important;
	}
</style>
<div class="header bg-primary pb-6">
	<div class="container-fluid">
		<div class="header-body">
			<div class="row align-items-center py-4">
				<div class="col-lg-6 col-8">
					<h6 class="h2 text-white d-inline-block mb-0">Manage term of use page</h6>
				</div>
				<!-- <div class="col-lg-6 col-4 text-right">
					<a href="<?php echo route('admin.pages') ?>" class="btn btn-neutral"><i class="ni ni-bold-left"></i> Back</a>
				</div> -->
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
				
				<div class="card-body">
					<form method="post" action="{{route('term-of-use.save')}}" class="form-validation">
						<!--!! CSRF FIELD !!-->
						{{ @csrf_field() }}
						<h6 class="heading-small text-muted mb-4">Term of use content</h6>
						<div class="pl-lg-4">
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<label class="form-control-label">Content</label>
										<textarea rows="10" class="form-control" placeholder="Term of use content" required name="term_of_use">{{ old('term_of_use', $termOfUse->term_of_use ?? '') }}</textarea>
										@error('term_of_use')
										    <small class="text-danger">{{ $message }}</small>
										@enderror
									</div>
								</div>
							</div>
						</div>
						<hr class="my-4" />

                        <h6 class="heading-small text-muted mb-4">Privacy and policy content</h6>
						<div class="pl-lg-4">
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<label class="form-control-label">Content</label>
										<textarea rows="10" class="form-control" placeholder="Privacy and policy content" required name="privacy_policy">{{ old('privacy_policy', $termOfUse->privacy_policy ?? '') }}</textarea>
										@error('privacy_policy')
										    <small class="text-danger">{{ $message }}</small>
										@enderror
									</div>
								</div>
							</div>
						</div>
						<hr class="my-4" />
						
						<button type="submit" class="btn btn-sm py-2 px-3 btn-primary float-right">
							<i class="fa fa-save"></i> Submit
						</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
