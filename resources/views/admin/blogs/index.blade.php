@extends('layouts.adminlayout')

@section('content')

	<div class="header bg-primary pb-6">

		<div class="container-fluid">

			<div class="header-body">

				<div class="row align-items-center py-4">

					<div class="col-lg-6 col-7">

						<h6 class="h2 text-white d-inline-block mb-0">Manage Posts</h6>

					</div>

					<div class="col-lg-6 col-5 text-right">

						<?php /*if(Permissions::hasPermission('blogs', 'create')): ?>

						<a href="<?php echo route('admin.blogs.add') ?>" class="btn btn-neutral">New</a>

						<?php endif;*/ ?>

						@include('admin.blogs.filters')

					</div>

				</div>

			</div>

		</div>

	</div>

	<!-- Page content -->

	<div class="container-fluid mt--6">

		<div class="row">

			<div class="col">

<!--!!!!! DO NOT REMOVE listing-block CLASS. INCLUDE THIS IN PARENT DIV OF TABLE ON LISTING PAGES !!!!!-->

				<div class="card listing-block">

					<!--!! FLAST MESSAGES !!-->

					@include('admin.partials.flash_messages')

					<!-- Card header -->

					<div class="card-header border-0" style="display:none;">

						<div class="heading">

							<h3 class="mb-0">Here Is Your Posts Listing!</h3>

						</div>

						<div class="actions">

							<div class="input-group input-group-alternative input-group-merge">

								<div class="input-group-prepend">

									<span class="input-group-text"><i class="fas fa-search"></i></span>

								</div>

								<input class="form-control listing-search" placeholder="Search" type="text" value="<?php echo (isset($_GET['search']) && $_GET['search'] ? $_GET['search'] : '') ?>">

							</div>

							<?php if(Permissions::hasPermission('blogs', 'update') || Permissions::hasPermission('blogs', 'delete')): ?>

							<div class="dropdown" data-toggle="tooltip" data-title="Bulk Actions">

								<a class="btn btn-sm btn-icon-only text-warning" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

									<i class="fas fa-ellipsis-v"></i>

								</a>

								<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">

									<?php if(Permissions::hasPermission('blogs', 'update')): ?>

									<a 

										class="dropdown-item" 

										href="javascript:;"

										onclick="bulk_actions('<?php echo route('admin.blogs.bulkActions', ['action' => 'active']) ?>', 'active');"

									>

										<span class="badge badge-dot mr-4">

											<i class="bg-success"></i>

											<span class="status">Publish</span>

										</span>

									</a>

									<a 

										class="dropdown-item" 

										href="javascript:;"

										onclick="bulk_actions('<?php echo route('admin.blogs.bulkActions', ['action' => 'inactive']) ?>', 'inactive');"

									>

										<span class="badge badge-dot mr-4">

											<i class="bg-warning"></i>

											<span class="status">Unpublish</span>

										</span>

									</a>

									<div class="dropdown-divider"></div>

									<?php endif; ?>

									<?php if(Permissions::hasPermission('blogs', 'delete')): ?>

		                            <a 

		                            	href="javascript:void(0);" 

		                            	class="waves-effect waves-block dropdown-item text-danger" 

		                            	onclick="bulk_actions('<?php echo route('admin.blogs.bulkActions', ['action' => 'delete']) ?>', 'delete');">

											<i class="fas fa-times text-danger"></i>

											<span class="status text-danger">Delete</span>

		                            </a>

		                            <?php endif; ?>

								</div>

							</div>

							<?php endif; ?>

						</div>

					</div>

					<div class="table-responsive">

<!--!!!!! DO NOT REMOVE listing-table, mark_all  CLASSES. INCLUDE THIS IN ALL TABLES LISTING PAGES !!!!!-->

						<table class="table align-items-center table-flush listing-table" id="tableListing">

							<thead class="thead-light">

								<tr>

									<th class="sort">
										Id
									</th>

									<th class="sort">
										Title
									</th>

									<th class="sort">
										Category
									</th>

									<!-- <th class="sort">
										Created By
									</th> -->
									
									<th class="sort">
										Post Type
									</th>

									<th class="sort">
										Status
									</th>

									<th class="sort">
										Created ON
									</th>

									<th>
										Actions
									</th>

								</tr>

							</thead>

							<tbody class="list">

								<?php if(!empty($listing->items())): ?>

									@include('admin.blogs.listingLoop')

								<?php else: ?>

									<td align="left" colspan="7">

		                            	No records found!

		                            </td>

								<?php endif; ?>

							</tbody>

							<tfoot>

							<tr>

								<th class="sort">
									Id
								</th>

								<th class="sort">
									Title
								</th>

								<th class="sort">
									Category
								</th>

								<!-- <th class="sort">
									Created By
								</th> -->

								<th class="sort">
									Status
								</th>

								<th class="sort">
									Created ON
								</th>

								<th>
									Actions
								</th>

								</tr>

		                    </tfoot>

						</table>

					</div>

					<!-- Card footer -->

				</div>

			</div>

		</div>

	</div>

@endsection
