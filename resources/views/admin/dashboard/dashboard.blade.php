@extends('layouts.adminlayout')
@section('content')
	<div class="header bg-primary pb-6">
		<div class="container-fluid">
			<div class="header-body">
				<div class="row align-items-center py-2 py-md-4">
					<div class="col-lg-6 col-7">
						<h6 class="h2 text-white d-inline-block mb-0">Dashboard</h6>
					</div>
					<div class="col-lg-6 col-5 text-right">
					</div>
				</div>
				@include('admin.partials.flash_messages')
				<!-- Card stats -->
				<div class="row">
					<div class="col-xl-4 col-md-6">
						<div class="card card-stats">
							<!-- Card body -->
                            <a href="{{ route('user.users') }}">
								<div class="card-body">
									<div class="row">
										<div class="col">
											<span class="h2 font-weight-bold mb-0"><?php echo $individual ?></span>
											<h5 class="card-title text-uppercase text-muted mb-0">Total Individual</h5>
											<!-- <p class="mt-0 mt-md-2 mb-0 text-sm right_new_arrow">
							                    <a href="{{ route('admin.products') }}" class="text-success mr-2"><i class="fa fa-arrow-right"></i></a>
							                </p> -->
										</div>
										<div class="col-auto">
											<div class="box-icon">
											<i class="bi bi-person"></i>
											</div>
										</div>
									</div>	
								</div>
							</a>

						</div>
					</div>
					<!-- <div class="col-xl-4 col-md-6">
						<div class="card card-stats">
                            <a href="{{ route('admin.products', ['status' => 1]) }}">
								<div class="card-body">
									<div class="row">
										<div class="col">
											<span class="h2 font-weight-bold mb-0"><?php echo $business ?></span>
											<h5 class="card-title text-uppercase text-muted mb-0">Total Business Pages</h5>
											<p class="mt-0 mt-md-2 mb-0 text-sm right_new_arrow">
							                    <a href="{{ route('admin.products', ['status' => 1]) }}" class="text-success mr-2"><i class="fa fa-arrow-right"></i></a>
							                </p>
										</div>
										<div class="col-auto">
											<div class="box-icon">
											<i class="fas fa-file-alt" aria-hidden="true"></i>
											</div>
										</div>
									</div>
								</div>
                            </a>
						</div>
					</div> -->

					<div class="col-xl-4 col-md-6">
						<div class="card card-stats">
                            <a href="{{ route('user.users') }}">
								<div class="card-body">
									<div class="row">
										<div class="col">
											<span class="h2 font-weight-bold mb-0"><?php echo $business ?></span>
											<h5 class="card-title text-uppercase text-muted mb-0">Total Registered Members</h5>
											<!-- <p class="mt-0 mt-md-2 mb-0 text-sm right_new_arrow">
							                    <a href="{{ route('admin.products', ['status' => 1]) }}" class="text-success mr-2"><i class="fa fa-arrow-right"></i></a>
							                </p> -->
										</div>
										<div class="col-auto">
											<div class="box-icon">
											<i class="fas fa-file-alt" aria-hidden="true"></i>
											</div>
										</div>
									</div>
								</div>
                            </a>
						</div>
					</div>
					<div class="col-xl-4 col-md-6">
						<div class="card card-stats">
							<a href="{{ route('admin.blogs.categories') }}">
								<div class="card-body">
									<div class="row">
										<div class="col">
											<span class="h2 font-weight-bold mb-0"><?php echo $inactiveProducts ?></span>
											<h5 class="card-title text-uppercase text-muted mb-0">Total Categories</h5>
											<!-- <p class="mt-0 mt-md-2 mb-0 text-sm right_new_arrow">
							                    <a href="{{ route('admin.products', ['status' => 0]) }}" class="text-success mr-2"><i class="fa fa-arrow-right"></i></a>
							                </p> -->
										</div>
										<div class="col-auto">
											<div class="box-icon">
											<i class=" fas fa-th-large " aria-hidden="true"></i>
											</div>
										</div>
									</div>
								</div>
                            </a>    
						</div>
					</div>

					<div class="col-xl-4 col-md-6">
						<div class="card card-stats">
							<!-- Card body -->
							<a href="{{ route('blog_post') }}">
								<div class="card-body">
									<div class="row">
										<div class="col">
											<span class="h2 font-weight-bold mb-0"><?php echo $totalpost ?></span>
											<h5 class="card-title text-uppercase text-muted mb-0">Total Post</h5>
											<!-- <p class="mt-0 mt-md-2 mb-0 text-sm right_new_arrow">
							                    <a href="{{ route('admin.products.orders') }}" class="text-success mr-2"><i class="fa fa-arrow-right"></i> </a>
							                </p> -->
										</div>
										<div class="col-auto">
											<div class="box-icon">
											<i class="fas fa-file-medical"></i>
											</div>
										</div>
									</div>		
								</div>
                            </a>
						</div>
					</div>
					<div class="col-xl-4 col-md-6">
						<div class="card card-stats">
							<a href="{{ route('blog_post') }}">
								<div class="card-body">
									<div class="row">
										<div class="col">
											<span class="h2 font-weight-bold mb-0"><?php echo $featuredPost ?></span>
											<h5 class="card-title text-uppercase text-muted mb-0">Total Featured Post</h5>
											<!-- <p class="mt-0 mt-md-2 mb-0 text-sm right_new_arrow">
							                    <a href="{{ route('admin.products.queries') }}" class="text-success mr-2"><i class="fa fa-arrow-right"></i></a>
							                </p> -->
										</div>
										<div class="col-auto">
											<div class="box-icon">
											<i class="far fa-edit"></i>
											</div>
										</div>
									</div>
								</div>
                            </a>
						</div>
					</div>
					<div class="col-xl-4 col-md-6">
						<div class="card card-stats">
							<!-- Card body -->
							<a href="{{ route('admin.contactus') }}">
								<div class="card-body">
									<div class="row">
										<div class="col">
											<span class="h2 font-weight-bold mb-0"><?php echo $enquries ?></span>
											<h5 class="card-title text-uppercase text-muted mb-0">Total Enqueries</h5>
											<!-- <p class="mt-0 mt-md-2 mb-0 text-sm right_new_arrow">
							                    <a href="{{ route('admin.feedback') }}" class="text-success mr-2"><i class="fa fa-arrow-right"></i> </a>
							                </p> -->
										</div>
										<div class="col-auto">
											<div class="box-icon">
											<i class="bi bi-telephone"></i>
											</div>
										</div>
									</div>		
								</div>
                            </a>
						</div>
					</div>
				</div>
				<!--<div class="row">
				<div class="col-xl-4 col-md-6">
						<div class="card card-stats">
							<div class="card-body">
								<div class="row">
									<div class="col">
										<h5 class="card-title text-uppercase text-muted mb-0">Contact Requests</h5>
										<span class="h2 font-weight-bold mb-0"></span>
									</div>
									<div class="col-auto">
										<div class="icon icon-shape bg-gradient-teal text-white rounded-circle shadow">
											<i class="fad fa-handshake"></i>
										</div>
									</div>
								</div>
								<p class="mt-2 mb-0 text-sm">
				                    <a href="{{ route('admin.contactus') }}" class="text-success mr-2"><i class="fa fa-arrow-right"></i> See more</a>
				                </p>
							</div>
						</div>
					</div>
					<div class="col-xl-4 col-md-6">
						<div class="card card-stats">
							<div class="card-body">
								<div class="row">
									<div class="col">
										<h5 class="card-title text-uppercase text-muted mb-0">Newsletter Subscribers</h5>
										<span class="h2 font-weight-bold mb-0"></span>
									</div>
									<div class="col-auto">
										<div class="icon icon-shape bg-gradient-teal text-white rounded-circle shadow">
											<i class="fas fa-envelope"></i>
										</div>
									</div>
								</div>
								<p class="mt-2 mb-0 text-sm">
				                    <a href="{{ route('admin.newsletter') }}" class="text-success mr-2"><i class="fa fa-arrow-right"></i> See more</a>
				                </p>
							</div>
						</div>
					</div>
				</div> -->
			</div>
		</div>
	</div>
@endsection