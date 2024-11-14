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
						<a href="<?php echo route('admin.products') ?>" class="btn btn-neutral"><i class="fa fa-angle-left"></i> Back</a>
						@if($product->status)
						<a href="<?php echo route('products.detail', ['slug' => $product->slug]) ?>" target="_blank" class="btn btn-neutral"><i class="fa fa-eye"></i> View Product</a>
						@endif
						<div class="dropdown" data-toggle="tooltip" data-title="More Actions">
							<a class="btn btn-neutral" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="fas fa-ellipsis-v"></i>
							</a>
							<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
								<a class="dropdown-item" href="<?php echo route('admin.products.edit', ['id' => $product->id]) ?>">
									<i class="fas fa-pencil-alt text-info"></i>
									<span class="status">Edit</span>
								</a>
								<div class="dropdown-divider"></div>
								<a 
									class="dropdown-item _delete" 
									href="javascript:;"
									data-link="<?php echo route('admin.products.delete', ['id' => $product->id]) ?>"
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
								<h3 class="mb-0">Product Information</h3>
							</div>
						</div>
					</div>
					<div class="table-responsive">
						<!-- Projects table -->
						<table class="table align-items-center table-flush view-table">
							<tbody>
								<tr>
									<th>Id</th>
									<td><?php echo $product->id ?></td>
								</tr>
								<tr>
									<th>Title</th>
									<td><?php echo $product->title ?></td>
								</tr>
								<tr>
									<th>Short Description</th>
									<td><?php echo $product->small_description ?></td>
								</tr>
								<tr>

									<th>Categories</th>
									<td>
										<?php 
										if(isset($product->categories) && $product->categories ): 
											foreach ($product->categories as $key => $pc):
												if($pc->parent_id && $pc->parent && $pc->parent->parent_id && $pc->parent->parent )
												echo '<span class="badge badge-warning">' . $pc->parent->parent->title . '</span>&nbsp; &nbsp;';
												if($pc->parent_id && $pc->parent )
												echo '<span class="badge badge-warning">' . $pc->parent->title . '</span>&nbsp; &nbsp;';
												echo '<span class="badge badge-warning">' . $pc->title . '</span> ';
											endforeach;
										endif; 
										?>
											
										</td>
								</tr>
								<tr>
									<td colspan="2">
										<?php echo $product->description ?>
									</td>
								</tr>
								<tr>
									<td colspan="2" align="right">
										<a href="<?php echo route('admin.products.orders', ['products[]' => $product->id]) ?>" class="btn btn-primary"><i class="fas fa-arrow-right"></i> View Orders</a>
										<a href="<?php echo route('admin.products.queries', ['products[]' => $product->id]) ?>" class="btn btn-primary"><i class="fas fa-arrow-right"></i> View Queries</a>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="col-xl-4 order-xl-1">

				<?php if($product->image): ?>
				<div class="card">
					<div class="card-body">
						@include('admin.partials.viewImage', ['files' => $product->getResizeImagesAttribute()])
					</div>
				</div>
				<?php endif; ?>

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
										<?php echo $product->status ? '<span class="badge badge-success">Published</span>' : '<span class="badge badge-danger">Unpublished</span>' ?>
									</td>
								</tr>
								<tr>
									<th scope="row">
										Created By
									</th>
									<td>
										<?php echo isset($product->owner) ? $product->owner->first_name . ' ' . $product->owner->last_name : "-" ?>
									</td>
								</tr>
								<tr>
									<th scope="row">
										Created On
									</th>
									<td>
										<?php echo _dt($product->created) ?>
									</td>
								</tr>
								<tr>
									<th scope="row">
										Last Modified
									</th>
									<td>
										<?php echo _dt($product->modified) ?>
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