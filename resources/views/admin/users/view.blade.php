@extends('layouts.adminlayout')

@section('content')

	@include("admin.users.viewHead")

	<!-- Page content -->

	<div class="container-fluid mt--6">

		<div class="row">

			<div class="col-xl-9 order-xl-1">

				<div class="card">

					<!--!! FLAST MESSAGES !!-->

					@include('admin.partials.flash_messages')

					<div class="card-header">

						<div class="row align-items-center">

							<div class="col-8">

								<h3 class="mb-0">User Information</h3>

							</div>

						</div>

					</div>

					<div class="table-responsive">

						<!-- Projects table -->

						<table class="table align-items-center table-flush view-table">

							<tbody>

								<tr>

									<th>Id</th>

									<td><?php echo $user->id ?></td>

								</tr>
								@if(!empty($user->first_name))
								<tr>

									<th>Name</th>

									<td><?php echo $user->first_name . ' ' . $user->last_name ?></td>

								</tr>
								@endif
								@if(!empty($user->email))
								<tr>

									<th>Email</th>

									<td><?php echo $user->email ?></td>

								</tr>
								@endif
								@if(!empty($user->phonenumber))
								<tr>

									<th>Phone Number</th>

									<td><?php echo $user->phonenumber ?></td>

								</tr>
								@endif
								@if(!empty($user->dob))
								<tr>

									<th>Date of Birth</th>

									<td>{{ $user->dob ? _d($user->dob) : "" }}</td>

								</tr>
								@endif

								
								<!-- <tr>

									<th>Gender</th>

									<td>{{ ucfirst($user->gender) }}</td>

								</tr> -->
								@if(!empty($user->address))
									<tr>

										<th>Full Address</th>

										<td>{{ nl2br($user->address) }}</td>

									</tr>						
								@endif

							</tbody>

						</table>

					</div>

				</div>

			</div>

			<div class="col-xl-3 order-xl-1">

				<div class="card">

					<div class="card-body text-center">

						<?php if(isset($user->image) && $user->image): ?>

						<img src="{{asset('/assets/images/profile/')}}/{{$user->image}}">

						<?php else: ?>

						<img src="<?php echo asset('user_dashboard/img/undraw_profile.svg'); ?>" alt="..." />

						<?php endif; ?>

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

						<table class="table align-items-center table-flush view-table">

							<tbody>

								<tr>

									<th scope="row">

										Last Login

									</th>

									<td>

										<?php echo _dt($user->last_login) ?>

									</td>

								</tr>

								<tr>

									<th scope="row">

										Status

									</th>

									<td>

										<?php echo $user->active_status == 1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>' ?>

									</td>

								</tr>

								<!-- <tr>

									<th scope="row">

										Created By

									</th>

									<td>

										<?php if(isset($user->owner) && $user->owner): ?>

											<a href="<?php echo route('admin.shops.edit', ['id' => $user->owner->id]) ?>"><?php echo $user->owner->name; ?></a>

										<?php else: ?>

											Admin

										<?php endif; ?>

									</td>

								</tr> -->

								<tr>

									<th scope="row">

										Created On

									</th>

									<td>

										<?php echo _dt($user->created) ?>

									</td>

								</tr>

								<tr>

									<th scope="row">

										Last Modified

									</th>

									<td>

										<?php echo _dt($user->modified) ?>

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