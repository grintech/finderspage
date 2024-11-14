@extends('layouts.frontlayout')

@section('content')



<!-- Breadcrumb -->

<div class="breadcrumb-main">

  <div class="container">

    <div class="row">

      <div class="col-12">

        <a href="#"> Home / Posts  </a>

      </div>

    </div>

  </div>

</div>

<!-- //Breadcrumb -->



<section class="business_banner">

	<div class="business_section" style="background-image: url('/new-web/public/front/images/business.png');"> 

		<h2>{{$category_name}}</h2>

		<a href="#"></a>

	</div>

</section>



 @include('admin.partials.flash_messages')

<!-- ==== Find Feature Section Start ==== -->

<section class="find_feature_section" >

	<div class="container">

		<div class="row">

			<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

				<div class="find_feature_area">

					<div class="main_title">

						<div class="search_area_category" style="display: none;">

								<div class="category_search" >

									<div class="form-group">

								            <label class="form-check-label" for="exampleInput">Sub Categories</label>

								            <select multiple="multiple" id="myMulticategory" name="event_type[]" class="form-control">

								              <option>Business </option>

								              <option>Find a Job</option>

								              <option>Real Estate/Lodging </option>

								              <option>Welcome to our Community</option>

								              <option>Online Shopping </option>

								            </select>

									</div>

									<div class="form-group" id="type">

								            <label class="form-check-label" for="exampleInput">Type</label>

								            <select multiple="multiple" id="myMultitype" name="event_type[]" class="form-control_select">

								              <option>Type1 </option>

								              <option>Type2</option>

								              <option>Type3 </option>

								              <option>Type4</option>

								              <option>Type5</option>

								            </select>

									</div>



									</div>

								<div class="right_btn">

									<div class="form-group">

										 <button type="submit" class="btn-create"><a href="{{url('/')}}/create-a-post" style="color: white;">Create New Post</a></button>

									</div>

								</div>

						</div>

					</div>

					<div class="find_feature_grid">

						<div class="row">

						@foreach($posts as $post)

							@if($post->count() > 0)

								

								<?php

									

									//echo"<pre>"; print_r($post);	die;

									$img = 'front/images/3.png';

									// if(isset($post->getOneResizeImagesAttribute()) && isset($post->getOneResizeImagesAttribute()['medium'])) {

										// 	$img = $post->getResizeImagesAttribute()['medium'];

									// }

									?>

									<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">

										<div class="one_third">

											<a href="{{url('/')}}/post/{{base64_encode($post->id)}}">

												<div class="img_area">

												<img src="{{url(@$post->getOneResizeImagesAttribute()['medium'])}}" alt="Image" />

											</div>

											<div class="posted_by">

												<a href="{{url('/')}}/post/{{base64_encode($post->id)}}/edit">

													<div class="left_area">

														<img src="{{$post->user->image!= ''? url('assets/images/profile/'.$post->user->image):'front/images/user3.png'}}" alt="user3.png" />

													</div>

													<div class="right_area">

														<div class="meta_area">

														<div class="name">{{ $post->title }}</div>

														<div class="by">by {{ $post->user->first_name.' '.$post->user->last_name }}</div>

														<div class="dropdown">

														  <button class="dropbtn" style=" background-image: url(front/images/dot.png);"></button>

														  <div class="dropdown-content">

														    <a href="{{url('/')}}/post/{{base64_encode($post->id)}}/edit">Edit</a>

														  </div>

														</div>

														</div>

													</div>

												</a>

											</div>

											</a>

										</div>

									</div>

								

							@endif

						@endforeach	

						</div>

					</div>

				</div>

			</div>

		</div>

	</div>

</section>

<!-- ==== Find Feature Section End ==== -->



<!-- ==== Find Feature Category Section Start ==== -->

<section class="find_feature_category_section">

	<div class="container">

		<div class="row">

			<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

				<div class="find_feature_category_area">

					<div class="main_title black_title">

						<h3>Find Feature By Category</h3>

					</div>

					<div class="category_area business">

						<ul class="list-inline">

							<li>

								<a href="{{url('/')}}/post/category/2">

									<img src="/new-web/public/front/images/c2.png" alt="c2.png" />

									<span class="heading_text">FIND A JOB</span>

								</a>

							</li>

							<li>

								<a href="{{url('/')}}/post/category/4">

									<img src="/new-web/public/front/images/c3.png" alt="c3.png" />

									<span class="heading_text">REAL ESTATE/LODGING</span>

								</a>

							</li>

							<li>

								<a href="{{url('/')}}/post/category/5">

									<img src="/new-web/public/front/images/c4.png" alt="c4.png" />

									<span class="heading_text">WELCOME TO OUR COMMUNITY</span>

								</a>

							</li>

							<li>

								<a href="{{url('/')}}/post/category/6">

									<img src="/new-web/public/front/images/c5.png" alt="c5.png" />

									<span class="heading_text">ONLINE SHOPPING</span>

								</a>

							</li>

						</ul>

					</div>

				</div>

			</div>

		</div>

	</div>

</section>

<!-- ==== Find Feature Category Section End ==== -->

@endsection