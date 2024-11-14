@extends('layouts.adminlayout')

@section('content')

	<div class="header bg-primary pb-6">

		<div class="container-fluid">

			<div class="header-body">

				<div class="row align-items-center py-4">

					<div class="col-lg-6 col-7">

						<h6 class="h2 text-white d-inline-block mb-0">Manage Newsletters</h6>

					</div>

					<div class="col-lg-6 col-5 text-right">

						<a class="btn btn-neutral dropdown-btn" href="<?php echo route('admin.newsletter.export') ?>">

							<i class="fas fa-download"></i> Export

						</a>

						@include('admin.newsletter.filters')

					</div>

				</div>

			</div>

		</div>

	</div>

	<!-- NewsLetter content -->

	<div class="container-fluid mt--6">

		<div class="row">

			<div class="col">

				<!--!!!!! DO NOT REMOVE listing-block CLASS. INCLUDE THIS IN PARENT DIV OF TABLE ON LISTING NEWSLETTER !!!!!-->

				<div class="card listing-block">

					<!--!! FLAST MESSAGES !!-->

					@include('admin.partials.flash_messages')

					<!-- Card header -->

					<div class="card-header border-0">

						<div class="heading">

							<h3 class="mb-0">Here Is Your newsletter Listing!</h3>

						</div>
						<div class="float-right">
						<!-- Button trigger modal -->
								<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#exampleModalCenter">
								  Send Email 
								</button>
						</div>
					</div>

					<div class="table-responsive">

						<!--!!!!! DO NOT REMOVE listing-table, mark_all  CLASSES. INCLUDE THIS IN ALL TABLES LISTING NEWSLETTER !!!!!-->
						
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

										<?php if(isset($_GET['sort']) && $_GET['sort'] == 'newsletter.id' && isset($_GET['direction']) && $_GET['direction'] == 'asc'): ?>

										<i class="fas fa-sort-down active" data-field="newsletter.id" data-sort="asc"></i>

										<?php elseif(isset($_GET['sort']) && $_GET['sort'] == 'newsletter.id' && isset($_GET['direction']) && $_GET['direction'] == 'desc'): ?>

										<i class="fas fa-sort-up active" data-field="newsletter.id" data-sort="desc"></i>

										<?php else: ?>

										<i class="fas fa-sort" data-field="newsletter.id" data-sort="asc"></i>

										<?php endif; ?>

									</th>

									<th class="sort">

										Email

										<?php if(isset($_GET['sort']) && $_GET['sort'] == 'newsletter.email' && isset($_GET['direction']) && $_GET['direction'] == 'asc'): ?>

										<i class="fas fa-sort-down active" data-field="newsletter.email" data-sort="asc"></i>

										<?php elseif(isset($_GET['sort']) && $_GET['sort'] == 'newsletter.email' && isset($_GET['direction']) && $_GET['direction'] == 'desc'): ?>

										<i class="fas fa-sort-up active" data-field="newsletter.email" data-sort="desc"></i>

										<?php else: ?>

										<i class="fas fa-sort" data-field="newsletter.email"></i>

										<?php endif; ?>

									</th>

									<th class="sort">

										Created On

										<?php if(isset($_GET['sort']) && $_GET['sort'] == 'newsletter.created' && isset($_GET['direction']) && $_GET['direction'] == 'asc'): ?>

										<i class="fas fa-sort-down active" data-field="newsletter.created" data-sort="asc"></i>

										<?php elseif(isset($_GET['sort']) && $_GET['sort'] == 'newsletter.created' && isset($_GET['direction']) && $_GET['direction'] == 'desc'): ?>

										<i class="fas fa-sort-up active" data-field="newsletter.created" data-sort="desc"></i>

										<?php else: ?>

										<i class="fas fa-sort" data-field="newsletter.created"></i>

										<?php endif; ?>

									</th>

									<th>

										Actions

									</th>

								</tr>



							</thead>

							<tbody class="list">

								<?php if(!empty($listing->items())): ?>

									@include('admin.newsletter.listingLoop')

								<?php else: ?>

									<td align="left" colspan="7">

		                            	No records found!

		                            </td>

								<?php endif; ?>

							</tbody>

						</table>

					</div>

					<!-- Card footer -->

				</div>

			</div>

		</div>

	</div>




	<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Email Editor</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{route('admin.newsletter.email')}}">
        	@csrf
        	<div class="col-md-12 mb-4" >
        	<textarea id="editor1" class="form-control" name="message" placeholder="Write a text"></textarea>
        	</div>
        	<div class="col-md-3 mb-4" >
        		<button type="submit" class="btn btn-warning">send</button>
        	</div>
        </form>
      </div>
      <div class="modal-footer">
        
      </div>
    </div>
  </div>
</div>

@endsection