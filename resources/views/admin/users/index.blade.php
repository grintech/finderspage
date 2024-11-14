@extends('layouts.adminlayout')
@section('content')
	<div class="header bg-primary pb-6">
		<div class="container-fluid">
			<div class="header-body">
				<div class="row align-items-center py-4">
					<div class="col-lg-6 col-7">
						<h6 class="h2 text-white d-inline-block mb-0">Manage Users</h6>
					</div>
					<div class="col-lg-6 col-5 text-right">
						<?php if(Permissions::hasPermission('users', 'create')): ?>
					<!--	<a href="<?php echo route('user.users.add') ?>" class="btn btn-neutral">New</a> -->
						<?php endif; ?>
						@include('admin.users.filters')
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
					
					<div class="table-responsive">
<!--!!!!! DO NOT REMOVE listing-table, mark_all  CLASSES. INCLUDE THIS IN ALL TABLES LISTING PAGES !!!!!-->
						<table class="table align-items-center table-flush listing-table" id="tableListing">
							<thead class="thead-light">
								<tr>
									<!-- <th class="checkbox-th">
										<div class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input mark_all" id="mark_all">
											<label class="custom-control-label" for="mark_all"></label>
										</div>
									</th> -->
									<th class="sort">
										<!--- MAKE SURE TO USE PROPOER FIELD IN data-field AND PROPOER DIRECTION IN data-sort -->
										Id
										<?php if(isset($_GET['sort']) && $_GET['sort'] == 'users.id' && isset($_GET['direction']) && $_GET['direction'] == 'asc'): ?>
										<i class="fas fa-sort-down active" data-field="users.id" data-sort="asc"></i>
										<?php elseif(isset($_GET['sort']) && $_GET['sort'] == 'users.id' && isset($_GET['direction']) && $_GET['direction'] == 'desc'): ?>
										<i class="fas fa-sort-up active" data-field="users.id" data-sort="desc"></i>
										<?php else: ?>
										<i class="fas fa-sort" data-field="users.id" data-sort="asc"></i>
										<?php endif; ?>
									</th>
									<th class="sort">
										Name
										<?php if(isset($_GET['sort']) && $_GET['sort'] == 'users.first_name' && isset($_GET['direction']) && $_GET['direction'] == 'asc'): ?>
										<i class="fas fa-sort-down active" data-field="users.first_name" data-sort="asc"></i>
										<?php elseif(isset($_GET['sort']) && $_GET['sort'] == 'users.first_name' && isset($_GET['direction']) && $_GET['direction'] == 'desc'): ?>
										<i class="fas fa-sort-up active" data-field="users.first_name" data-sort="desc"></i>
										<?php else: ?>
										<i class="fas fa-sort" data-field="users.first_name"></i>
										<?php endif; ?>
									</th>
									<th class="sort">
										Email
										<?php if(isset($_GET['sort']) && $_GET['sort'] == 'users.email' && isset($_GET['direction']) && $_GET['direction'] == 'asc'): ?>
										<i class="fas fa-sort-down active" data-field="users.email" data-sort="asc"></i>
										<?php elseif(isset($_GET['sort']) && $_GET['sort'] == 'users.email' && isset($_GET['direction']) && $_GET['direction'] == 'desc'): ?>
										<i class="fas fa-sort-up active" data-field="users.email" data-sort="desc"></i>
										<?php else: ?>
										<i class="fas fa-sort" data-field="users.email"></i>
										<?php endif; ?>
									</th>
									<th class="sort">
										User Type
										<?php if(isset($_GET['sort']) && $_GET['sort'] == 'users.role' && isset($_GET['direction']) && $_GET['direction'] == 'asc'): ?>
										<i class="fas fa-sort-down active" data-field="users.role" data-sort="asc"></i>
										<?php elseif(isset($_GET['sort']) && $_GET['sort'] == 'users.role' && isset($_GET['direction']) && $_GET['direction'] == 'desc'): ?>
										<i class="fas fa-sort-up active" data-field="users.role" data-sort="desc"></i>
										<?php else: ?>
										<i class="fas fa-sort" data-field="users.role"></i>
										<?php endif; ?>
									</th>
									<!-- <th class="sort">
										Last Login
										<?php if(isset($_GET['sort']) && $_GET['sort'] == 'users.last_login' && isset($_GET['direction']) && $_GET['direction'] == 'asc'): ?>
										<i class="fas fa-sort-down active" data-field="users.last_login" data-sort="asc"></i>
										<?php elseif(isset($_GET['sort']) && $_GET['sort'] == 'users.last_login' && isset($_GET['direction']) && $_GET['direction'] == 'desc'): ?>
										<i class="fas fa-sort-up active" data-field="users.last_login" data-sort="desc"></i>
										<?php else: ?>
										<i class="fas fa-sort" data-field="users.last_login"></i>
										<?php endif; ?>
									</th> -->
									<th class="sort">
										Ban Users
										<?php if(isset($_GET['sort']) && $_GET['sort'] == 'users.status' && isset($_GET['direction']) && $_GET['direction'] == 'asc'): ?>
										<i class="fas fa-sort-down active" data-field="users.status" data-sort="asc"></i>
										<?php elseif(isset($_GET['sort']) && $_GET['sort'] == 'users.status' && isset($_GET['direction']) && $_GET['direction'] == 'desc'): ?>
										<i class="fas fa-sort-up active" data-field="users.status" data-sort="desc"></i>
										<?php else: ?>
										<i class="fas fa-sort" data-field="users.status"></i>
										<?php endif; ?>
									</th>
									<th class="sort">
										Created ON
										<?php if(isset($_GET['sort']) && $_GET['sort'] == 'users.created' && isset($_GET['direction']) && $_GET['direction'] == 'asc'): ?>
										<i class="fas fa-sort-down active" data-field="users.created" data-sort="asc"></i>
										<?php elseif(isset($_GET['sort']) && $_GET['sort'] == 'users.created' && isset($_GET['direction']) && $_GET['direction'] == 'desc'): ?>
										<i class="fas fa-sort-up active" data-field="users.created" data-sort="desc"></i>
										<?php else: ?>
										<i class="fas fa-sort" data-field="users.created"></i>
										<?php endif; ?>
									</th>
									<th>
										Actions
									</th>
								</tr>
							</thead>
							<tbody class="list">
								<?php if(!empty($listing->items())): ?>
									@include('admin.users.listingLoop')
								<?php else: ?>
									<td align="left" colspan="7">
		                            	No records found!
		                            </td>
								<?php endif; ?>
							</tbody>
							<!-- <tfoot>
		                        <tr>
		                            <th align="left" >
		                            	@include('admin.partials.pagination', ["pagination" => $listing])
		                            </th>
		                        </tr>
		                    </tfoot> -->
						</table>
					</div>
					<!-- Card footer -->
				</div>
			</div>
		</div>
	</div>
	<!-- Modal -->
	<div class="modal fade" id="export" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Export Records</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	      		<p>Maximum of 3000 records can be export from all records at one time.</p>
	      		<form id="exportRecords">
	      			<!--!! CSRF FIELD !!-->
					{{ @csrf_field() }}
	      			<input type="hidden" class="filter-query" value="">
	      			<div class="form-group">
						<div class="custom-control custom-radio custom-control-inline">
							<input type="radio" id="allRecords" name="type" value="all" class="custom-control-input" checked="checked">
							<label class="custom-control-label" for="allRecords">All Records</label>
						</div>
						<div class="custom-control custom-radio custom-control-inline">
							<input type="radio" id="filtered" name="type" value="filtered" class="custom-control-input">
							<label class="custom-control-label" for="filtered">Filtered Records</label>
						</div>
					</div>
					<div class="form-group" id="daterangeFilter">
						<label class="form-control-label" for="input-first-name">Apply Date Range</label>
						<input type="text" class="form-control" id="datarangepicker" name="daterange" placeholder="MM/DD/YYYY - MM/DD/YYYY" value="">
					</div>
					<div class="form-group d-none" id="filteredMessage">
						<h3><mark><i class="fas fa-exclamation-circle"></i> Background applied filters will be applicable.</mark></h3>
					</div>
				</form>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <button type="button" id="export-excel" data-url="<?php echo route('user.users') ?>" class="btn btn-primary"><i class="fas fa-file-export"></i> Export</button>
	      </div>
	    </div>
	  </div>
	</div>
@endsection