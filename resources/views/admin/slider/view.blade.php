@extends('layouts.adminlayout')
@section('content')
	<div class="header bg-primary pb-6">
		<div class="container-fluid">
			<div class="header-body">
				<div class="row align-items-center py-4">
					<div class="col-lg-6 col-7">
						<h6 class="h2 text-white d-inline-block mb-0">Manage Slider</h6>
					</div>
					<div class="col-lg-6 col-5 text-right">
						<a href="<?php echo route('admin.slider') ?>" class="btn btn-neutral"><i class="fa fa-angle-left"></i> Back</a>
						<a href="#" class="btn btn-neutral" target="_blank"><i class="fa fa-eye"></i> View Page</a>
						<div class="dropdown" data-toggle="tooltip" data-title="More Actions">
							<a class="btn btn-neutral" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="fas fa-ellipsis-v"></i>
							</a>
							<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
								<a class="dropdown-item" href="<?php echo route('admin.slider.edit', ['id' => $slider->id]) ?>">
									<i class="fas fa-pencil-alt text-info"></i>
									<span class="status">Edit</span>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- slider content -->
	<div class="container-fluid mt--6">
		<div class="row">
			<div class="col-xl-8 order-xl-1">
				<div class="card">
					<!--!! FLAST MESSAGES !!-->
					@include('admin.partials.flash_messages')
					<div class="card-header">
						<div class="row align-items-center">
							<div class="col-8">
								<h3 class="mb-0">Slider Information</h3>
							</div>
						</div>
					</div>
					<div class="table-responsive">
						<!-- Projects table -->
						<table class="table align-items-center table-flush">
							<tbody>
								<tr>
									<th>Id</th>
									<td><?php echo $slider->id ?></td>
								</tr>
								<tr>
									<th>Title</th>
									<td><?php echo $slider->title ?></td>
								</tr>
								<tr>
									<td colspan="2">
										<h2>Description</h2>
										<?php echo $slider->description ?>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				
			</div>
			<div class="col-xl-4 order-xl-1">
				
							
							
				<?php if($slider->image): ?>
					
				<div class="card">

					<div class="card-body"><div class="col-8">
								<h3 class="mb-0">Slider Image</h3>
							</div>	
						<img src="<?php echo url($slider->image) ?>">
					</div>
				</div>
				<?php endif; ?>
				
				
				<div class="card d-none">
					<div class="card-header">
						<div class="row align-items-center">
							<div class="col">
								<h3 class="mb-0">This Month Visits</h3>
							</div>
							<div class="col text-right">
								<a href="#!" class="btn btn-sm py-2 px-3 btn-primary">See all</a>
							</div>
						</div>
					</div>
					<div class="table-responsive small-max-card-table">
						<!-- Projects table -->
						<table class="table align-items-center table-flush">
							<thead class="thead-light">
								<tr>
									<th scope="col">Date</th>
									<th scope="col">Visitors</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<th scope="row">
										05-01-2021
									</th>
									<td>
										340
									</td>
								</tr>
								<tr>
									<th scope="row">
										05-01-2021
									</th>
									<td>
										340
									</td>
								</tr>
								<tr>
									<th scope="row">
										05-01-2021
									</th>
									<td>
										340
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>

				<div class="card">
					<div class="card-header">
						<div class="row align-items-center">
							<div class="col">
								<h3 class="mb-0">Other Information</h3>
							</div>
						</div>
					</div>
					<div class="table-responsive">
						<!-- Projects table -->
						<table class="table align-items-center table-flush">
							<tbody>
								<tr>
									<th scope="row">
										Status
									</th>
									<td>
										<?php echo $slider->status ? '<span class="badge badge-success">Published</span>' : '<span class="badge badge-danger">Unpublished</span>' ?>
									</td>
								</tr>
								<tr>
									<th scope="row">
										Created By
									</th>
									<td>
										<?php echo isset($slider->owner) ? $slider->owner->first_name . ' ' . $slider->owner->last_name : "-" ?>
									</td>
								</tr>
								<tr>
									<th scope="row">
										Created On
									</th>
									<td>
										<?php echo _dt($slider->created) ?>
									</td>
								</tr>
								<tr>
									<th scope="row">
										Last Modified
									</th>
									<td>
										<?php echo _dt($slider->modified) ?>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection