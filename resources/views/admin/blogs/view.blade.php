@extends('layouts.adminlayout')
@section('content')
	<div class="header bg-primary pb-6">
		<div class="container-fluid">
			<div class="header-body">
				<div class="row align-items-center py-4">
					<div class="col-lg-6 col-6">
						<h6 class="h2 text-white d-inline-block mb-0">Manage Posts</h6>
					</div>
					<div class="col-lg-6 col-6 text-right">
						<a href="<?php echo route('admin.blogs') ?>" class="btn text-white"><i class="fa fa-arrow-left"></i> Back</a>
						<a href="{{route('jobpost',$blog->id)}}" class="btn btn-neutral" target="_blank"><i class="fa fa-eye"></i> View Post</a>
						<?php if(Permissions::hasPermission('blogs', 'delete')): ?>
						<div class="dropdown" data-toggle="tooltip" data-title="More Actions">
							<a class="btn btn-neutral" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="fas fa-ellipsis-v"></i>
							</a>
							<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
								<a 
									class="dropdown-item _delete" 
									href="javascript:;"
									data-link="<?php echo route('admin.blogs.delete', ['id' => $blog->id]) ?>"
								>
									<i class="fas fa-times text-danger"></i>
									<span class="status text-danger">Delete</span>
								</a>
							</div>
						</div>
						<?php endif; ?>
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
								<h3 class="mb-0">Post Information</h3>
							</div>
						</div>
					</div>
					<div class="table-responsive">
						<!-- Projects table -->
						<table class="table align-items-center table-flush view-table">
							<tbody>
								<tr>
									<th>Id</th>
									<td><?php echo $blog->id ?></td>
								</tr>
								<tr>
									<th>Title</th>
									<td><?php echo $blog->title ?></td>
								</tr>
								<tr>

									<th>Categories</th>
									<td>
										<?php 
										$cats = [];
										if(isset($blog->categories) && $blog->categories ): 

											foreach ($blog->categories as $key => $pc):
												// echo "<pre>";print_r($pc);
												echo $cats[$pc->id] = $pc->title;
											endforeach;
										endif; 
										?>
										<?php 
										if(isset($blog->sub_categories) && $blog->sub_categories ): 
											foreach ($blog->sub_categories as $key => $pc):
												
												echo '<span class="badge badge-warning">'.$cats[$pc->parent_id] . ': ' . $pc['title'].'</span> ';
											endforeach;
										endif; 
										?>		
									</td>
								</tr>
								<!-- <tr>
									<th>Location</th>
									<td><?php echo ucfirst($blog->location) ?></td>
								</tr> -->
								<tr>
									<th>Choices</th>
									<td><?php echo ucfirst($blog->choices) ?></td>
								</tr>
								<tr>
									<td colspan="2">
										<?php echo $blog->description ?>
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
								<h3 class="mb-0">Contact Information</h3>
							</div>
						</div>
					</div>
					<div class="table-responsive">
						<!-- Projects table -->
						<table class="table align-items-center table-flush view-table">
							<tbody>
								<tr>
									<th scope="row">
										Phone Number
									</th>
									<td>
										<a href="<?php echo $blog->phone ?>" target="_blank"><?php echo $blog->phone ?></a>
									</td>
								</tr>
								<tr>
									<th scope="row">
										Email
									</th>
									<td>
										<a href="<?php echo $blog->email ?>" target="_blank"><?php echo $blog->email ?></a>
									</td>
								</tr>
								<tr>
									<th scope="row">
										Address
									</th>
									<td>
										<?php echo $blog->address ?>
									</td>
								</tr>
								<tr>
									<th scope="row">
										Website
									</th>
									<td>
										<a href="<?php echo $blog->website ?>" target="_blank"><?php echo $blog->website ?></a>
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
								<h3 class="mb-0">Social Media Information</h3>
							</div>
						</div>
					</div>
					<div class="table-responsive">
						<!-- Projects table -->
						<table class="table align-items-center table-flush view-table">
							<tbody>
								<tr>
									<th scope="row">
										Twitter
									</th>
									<td>
										<a href="<?php echo $blog->twitter ?>" target="_blank"><?php echo $blog->twitter ?></a>
									</td>
								</tr>
								<tr>
									<th scope="row">
										Facebook
									</th>
									<td>
										<a href="<?php echo $blog->facebook ?>" target="_blank"><?php echo $blog->facebook ?></a>
									</td>
								</tr>
								<tr>
									<th scope="row">
										Instagram
									</th>
									<td>
										<a href="<?php echo $blog->instagram ?>" target="_blank"><?php echo $blog->instagram ?></a>
									</td>
								</tr>
								<tr>
									<th scope="row">
										Linkedin
									</th>
									<td>
										<a href="<?php echo $blog->linkedin ?>" target="_blank"><?php echo $blog->linkedin ?></a>
									</td>
								</tr>
								<tr>
									<th scope="row">
										Youtube
									</th>
									<td>
										<a href="<?php echo $blog->youtube ?>" target="_blank"><?php echo $blog->youtube ?></a>
									</td>
								</tr>
								<tr>
									<th scope="row">
										Whatsapp
									</th>
									<td>
										<a href="https://wa.me/<?php echo $blog->whatsapp ?>" target="_blank"><?php echo $blog->whatsapp ?></a>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="col-xl-4 order-xl-1">
				<?php if($blog->image): ?>
				<div class="card">
					<div class="card-body">
						@include('admin.partials.viewImage', ['files' => $blog->getResizeImagesAttribute()])
					</div>
				</div>
				<?php endif; ?>
				
				
		<!-- 		<div class="card">
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
						
						<table class="table align-items-center table-flush view-table">
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
				</div> -->

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
						<table class="table align-items-center table-flush view-table">
							<tbody>
								<tr>
									<th scope="row">
										Status
									</th>
									<td>
										<?php echo $blog->status ? '<span class="badge badge-success">Published</span>' : '<span class="badge badge-danger">Unpublished</span>' ?>
									</td>
								</tr>
								<tr>
									<th scope="row">
										Created By
									</th>
									<td>
										<?php echo isset($blog->owner) ? $blog->owner->first_name . ' ' . $blog->owner->last_name : "-" ?>
									</td>
								</tr>
								<tr>
									<th scope="row">
										Created On
									</th>
									<td>
										<?php echo _dt($blog->created) ?>
									</td>
								</tr>
								<tr>
									<th scope="row">
										Last Modified
									</th>
									<td>
										<?php echo _dt($blog->modified) ?>
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