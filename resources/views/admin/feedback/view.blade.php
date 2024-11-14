@extends('layouts.adminlayout')
@section('content')
	<div class="header bg-primary pb-6">
		<div class="container-fluid">
			<div class="header-body">
				<div class="row align-items-center py-4">
					<div class="col-lg-6 col-7">
						<h6 class="h2 text-white d-inline-block mb-0">Manage Feedback</h6>
					</div>
					<div class="col-lg-6 col-5 text-right">
						<a href="<?php echo route('admin.feedback') ?>" class="btn btn-neutral"><i class="fa fa-angle-left"></i> Back</a>
						
						<div class="dropdown" data-toggle="tooltip" data-title="More Actions">
							<a class="btn btn-neutral" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="fas fa-ellipsis-v"></i>
							</a>
							<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
								
								<a 
									class="dropdown-item _delete" 
									href="javascript:;"
									data-link="<?php echo route('admin.feedback.delete', ['id' => $page->id]) ?>"
								>
									<i class="fas fa-times text-danger"></i>
									<span class="status text-danger">Delete</span>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Page content -->
	<div class="container-fluid mt--6">
		<div class="row">
			<div class="col-xl-8 order-xl-1">
				<div class="card">
					<!--!! FLAST MESSAGES !!-->
					@include('admin.partials.flash_messages')
					<div class="card-header">
						<div class="row align-items-center">
							<div class="col-8">
								<h3 class="mb-0">Feedback Information</h3>
							</div>
						</div>
					</div>
					<div class="table-responsive">
						<!-- Projects table -->
						<table class="table align-items-center table-flush">
							<tbody>
								<tr>
									<th>Id</th>
									<td><?php echo $page->id ?></td>
								</tr>
								<tr>
									<th>Email</th>
									<td><?php echo $page->email ?></td>
								</tr>
								<tr>
									<th>Category</th>
									<td><?php echo ucwords($page->category) ?></td>
								</tr>
								<tr>
									<th>Rating</th>
									<td>
										<?php 
										for($i = 1; $i <= 5; $i++)
										{
											if($i < $page->rating)
												echo '<i class="fas fa-star"></i>';
											else
												echo '<i class="far fa-star"></i>';
										}
										?>
									</td>
								</tr>
								<tr>
									<th>Feedback</th>
									<td><?php echo $page->description ?></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="col-xl-4 order-xl-1">
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
								{{-- <tr>
									<th scope="row">
										Status
									</th>
									<td>
										<?php echo $page->status ? '<span class="badge badge-success">Published</span>' : '<span class="badge badge-danger">Unpublished</span>' ?>
									</td>
								</tr> --}}
								
								<tr>
									<th scope="row">
										Created On
									</th>
									<td>
										<?php echo _dt($page->created) ?>
									</td>
								</tr>
								<tr>
									<th scope="row">
										Last Modified
									</th>
									<td>
										<?php echo _dt($page->modified) ?>
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