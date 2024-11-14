@extends('layouts.adminlayout')

@section('content')
<?php 
// dd($payments); 
?>
<div class="header bg-primary pb-3">

		<div class="container-fluid">

			<div class="header-body">

				<div class="row align-items-center py-4">

					<div class="col-lg-6 col-8">

						<h6 class="h2 text-white d-inline-block mb-0">All Payments</h6>

					</div>


				</div>

			</div>

		</div>

	</div>

	<!-- Page content -->

	<div class="container-fluid px-3 px-md-5">
        <div class="row"> 
		    <div class="col">
		    	<div class="card listing-block">
			    	<div class="table-responsive">
			    		<div id="tableListing_wrapper" class="dataTables_wrapper no-footer">
							<table class="table table-striped" id="tableListing_payments">
							  <thead>
							    <tr>
							      <th scope="col">#</th>
							      <th scope="col">payment id</th>
							      <th scope="col">post Title</th>
							      <th scope="col">Username</th>
							      <th scope="col">Pay For</th>
							      <th scope="col">price</th>
							      <th scope="col">duration</th>
							      <th scope="col">start date</th>
							      <th scope="col">End date</th>
							    </tr>
							  </thead>
							  <tbody>
						
							  	@foreach($payments as $pay)
							    <tr>
							       <td scope="row">{{$loop->iteration}}</td>
							       <td>{{$pay->payment_id}}</td>
							       <td><a href="#">{{$pay->title ?? 'N/A' }}</a></td>
							       <td>{{$pay->username ?? 'N/A'}}</td>
							       <td>{{$pay->type ?? 'N/A'}}</td>
							       <td>${{$pay->balance_transaction}}</td>
							       <td>{{$pay->duration}}</td>
							       <td>{{$pay->start_date}}</td>
							       <td>{{$pay->end_date}}</td>
							    </tr>
							   @endforeach
							  </tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection