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
						<?php if(Permissions::hasPermission('slider', 'create')): ?>
						<a href="<?php echo route('admin.slider.add') ?>" class="btn btn-neutral">New</a>
						<?php endif; ?>
						@include('admin.slider.filters')
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Slider content -->
	<div class="container-fluid mt--6">
		<div class="row">
			<div class="col">
<!--!!!!! DO NOT REMOVE listing-block CLASS. INCLUDE THIS IN PARENT DIV OF TABLE ON LISTING SLIDER !!!!!-->
				<div class="card listing-block">
					<!--!! FLAST MESSAGES !!-->
					@include('admin.partials.flash_messages')
					<!-- Card header -->
					<div class="card-header border-0">
						<div class="heading">
							<h3 class="mb-0">Here Is Your Slider Listing!</h3>
						</div>
						<div class="actions">
							<div class="input-group input-group-alternative input-group-merge">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-search"></i></span>
								</div>
								<input class="form-control listing-search" placeholder="Search" type="text" value="<?php echo (isset($_GET['search']) && $_GET['search'] ? $_GET['search'] : '') ?>">
							</div>
							<div class="dropdown" data-toggle="tooltip" data-title="Bulk Actions" >
								<a class="btn btn-sm btn-icon-only text-warning" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<i class="fas fa-ellipsis-v"></i>
								</a>
								<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
									<a 
										class="dropdown-item" 
										href="javascript:;"
										onclick="bulk_actions('<?php echo route('admin.slider.bulkActions', ['action' => 'active']) ?>', 'active');"
									>
										<span class="badge badge-dot mr-4">
											<i class="bg-success"></i>
											<span class="status">Publish</span>
										</span>
									</a>
									<div class="dropdown-divider"></div>
									<a 
										class="dropdown-item" 
										href="javascript:;"
										onclick="bulk_actions('<?php echo route('admin.slider.bulkActions', ['action' => 'inactive']) ?>', 'inactive');"
									>
										<span class="badge badge-dot mr-4">
											<i class="bg-warning"></i>
											<span class="status">Unpublish</span>
										</span>
									</a>
									<div class="dropdown-divider"></div>
		                            <a 
		                            	href="javascript:void(0);" 
		                            	class="waves-effect waves-block dropdown-item text-danger" 
		                            	onclick="bulk_actions('<?php echo route('admin.slider.bulkActions', ['action' => 'delete']) ?>', 'delete');">
											<i class="fas fa-times text-danger"></i>
											<span class="status text-danger">Delete</span>
		                            </a>
								</div>
							</div>
						</div>
					</div>
					<div class="table-responsive">
<!--!!!!! DO NOT REMOVE listing-table, mark_all  CLASSES. INCLUDE THIS IN ALL TABLES LISTING SLIDER !!!!!-->
						<table class="table align-items-center table-flush listing-table">
							<thead class="thead-light">
								<tr>
									<th class="checkbox-th">
										<div class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input mark_all" id="mark_all">
											<label class="custom-control-label" for="mark_all"></label>
										</div>
									</th>
									<th class="sort">
										<!--- MAKE SURE TO USE PROPOER FIELD IN data-field AND PROPOER DIRECTION IN data-sort -->
										Id
										<?php if(isset($_GET['sort']) && $_GET['sort'] == 'slider.id' && isset($_GET['direction']) && $_GET['direction'] == 'asc'): ?>
										<i class="fas fa-sort-down active" data-field="slider.id" data-sort="asc"></i>
										<?php elseif(isset($_GET['sort']) && $_GET['sort'] == 'slider.id' && isset($_GET['direction']) && $_GET['direction'] == 'desc'): ?>
										<i class="fas fa-sort-up active" data-field="slider.id" data-sort="desc"></i>
										<?php else: ?>
										<i class="fas fa-sort" data-field="slider.id" data-sort="asc"></i>
										<?php endif; ?>
									</th>
									<th class="sort">
										Title
										<?php if(isset($_GET['sort']) && $_GET['sort'] == 'slider.title' && isset($_GET['direction']) && $_GET['direction'] == 'asc'): ?>
										<i class="fas fa-sort-down active" data-field="slider.title" data-sort="asc"></i>
										<?php elseif(isset($_GET['sort']) && $_GET['sort'] == 'slider.title' && isset($_GET['direction']) && $_GET['direction'] == 'desc'): ?>
										<i class="fas fa-sort-up active" data-field="slider.title" data-sort="desc"></i>
										<?php else: ?>
										<i class="fas fa-sort" data-field="slider.title"></i>
										<?php endif; ?>
									</th>
									<th class="sort">
										Created By
										<?php if(isset($_GET['sort']) && $_GET['sort'] == 'owner.first_name' && isset($_GET['direction']) && $_GET['direction'] == 'asc'): ?>
										<i class="fas fa-sort-down active" data-field="owner.first_name" data-sort="asc"></i>
										<?php elseif(isset($_GET['sort']) && $_GET['sort'] == 'owner.first_name' && isset($_GET['direction']) && $_GET['direction'] == 'desc'): ?>
										<i class="fas fa-sort-up active" data-field="owner.first_name" data-sort="desc"></i>
										<?php else: ?>
										<i class="fas fa-sort" data-field="owner.first_name"></i>
										<?php endif; ?>
									</th>
									<th class="sort">
										Status
										<?php if(isset($_GET['sort']) && $_GET['sort'] == 'slider.status' && isset($_GET['direction']) && $_GET['direction'] == 'asc'): ?>
										<i class="fas fa-sort-down active" data-field="slider.status" data-sort="asc"></i>
										<?php elseif(isset($_GET['sort']) && $_GET['sort'] == 'slider.status' && isset($_GET['direction']) && $_GET['direction'] == 'desc'): ?>
										<i class="fas fa-sort-up active" data-field="slider.status" data-sort="desc"></i>
										<?php else: ?>
										<i class="fas fa-sort" data-field="slider.status"></i>
										<?php endif; ?>
									</th>
									<th class="sort">
										Created ON
										<?php if(isset($_GET['sort']) && $_GET['sort'] == 'slider.created' && isset($_GET['direction']) && $_GET['direction'] == 'asc'): ?>
										<i class="fas fa-sort-down active" data-field="slider.created" data-sort="asc"></i>
										<?php elseif(isset($_GET['sort']) && $_GET['sort'] == 'slider.created' && isset($_GET['direction']) && $_GET['direction'] == 'desc'): ?>
										<i class="fas fa-sort-up active" data-field="slider.created" data-sort="desc"></i>
										<?php else: ?>
										<i class="fas fa-sort" data-field="slider.created"></i>
										<?php endif; ?>
									</th>
									<th>
										Actions
									</th>
								</tr>
							</thead>
							<tbody class="list">
								<?php if(!empty($listing->items())): ?>
									@include('admin.Slider.listingLoop')
								<?php else: ?>
									<td align="left" colspan="7">
		                            	No records found!
		                            </td>
								<?php endif; ?>
							</tbody>
							<tfoot>
		                        <tr>
		                            <th align="left" colspan="20">
		                            	@include('admin.partials.pagination', ["pagination" => $listing])
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