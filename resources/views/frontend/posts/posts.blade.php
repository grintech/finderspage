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
	<div class="business_section" style="background-image: url('front/images/business.png');"> 
		<h2>All Posts</h2>
		<a href="#"></a>
	</div>
</section>


<!-- ==== Find Feature Section Start ==== -->
<section class="find_feature_section">
	 <form class="" id="sort_products" action="" method="GET">
	<div class="container">
		<div class="row">
			<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="find_feature_area">
					<div class="main_title">
						<div class="search_area_category">
								<div class="category_search">
										<div class="form-group">
								            <label class="form-check-label" for="exampleInput">Categories</label>
								            <select id="main_cat" name="main_cat" class="form-control">
								            	 <option value="">All</option>
								            @foreach($categories as $b)
								              <option value={{$b->id}} {{$main_cat == $b->id?'selected':''}}>{{$b->title}}</option>
								              @endforeach
								            </select>
									</div>
									<div class="form-group">
								            <label class="form-check-label" for="exampleInput">Sub Categories</label>
								            <select onchange="sort_products()" id="sub_cat" name="sub_cat" class="form-control">
								            	 <option value="">All</option>
								            @foreach($blog_categories as $b)
								              <option value={{$b->id}} {{$sub_cate == $b->id?'selected':''}}>{{$b->title}}</option>
								              @endforeach
								            </select>
									</div>
									<!-- <div class="form-group" id="type">
								            <label class="form-check-label" for="exampleInput">Type</label>
								            <select multiple="multiple" id="myMultitype" name="event_type[]" class="form-control_select">
								              <option>Type1 </option>
								              <option>Type2</option>
								              <option>Type3 </option>
								              <option>Type4</option>
								              <option>Type5</option>
								            </select>
									</div> -->

									</div>
								<div class="right_btn">
									<div class="form-group">
										 <button type="submit" class="btn-create"><a href="{{ url('/') }}/create-a-post" style="color: white;">Create New Post</a></button>
									</div>
								</div>
						</div>
					</div>
					<div class="find_feature_grid">
						<div class="row">
							
							@foreach($posts as $post)

							
							
							<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
								<div class="one_third">
									<a href="{{route('post.view', ['id' =>base64_encode($post->id)])}}">
										<div class="img_area">
										<img src="{{url(@$post->getOneResizeImagesAttribute()['medium'])}}" alt="Image" />
									</div>
									

									<div class="posted_by">
										<a href="{{route('UserProfile',['id'=> General::encrypt($post->user->id)])}}">
											<div class="left_area">
												<img src="{{$post->user->image!= ''? url('assets/images/profile/'.$post->user->image):'front/images/user3.png'}}" alt="Image" />
											</div>
											<div class="right_area">
												<div class="meta_area">
												<div class="name">{{ $post->title }}</div>
												<div class="by">by {{ $post->user->first_name.' '.$post->user->last_name }}</div>
												<div class="dropdown" style="display: none;">
												  <button class="dropbtn" style=" background-image: url(front/images/dot.png);"></button>
												  <div class="dropdown-content">
												    <a href="#">Report</a>
												    <a href="#">Save Post </a>
												  </div>
												</div>
												</div>
											</div>
										</a>
									</div>
															</a>
								</div>
							</div>

							@endforeach
							
						</div>
						<!-- <div class="load_more">
							<a href="javascript:;">Load More...</a>
						</div> -->
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
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
									<img src="/new-web/public/front/images/c2.png" alt="Image" />
									<span class="heading_text">JOBS</span>
								</a>
							</li>
							<li>
								<a href="{{url('/')}}/post/category/4">
									<img src="/new-web/public/front/images/c3.png" alt="Image" />
									<span class="heading_text">REAL ESTATE</span>
								</a>
							</li>
							<li>
								<a href="{{url('/')}}/post/category/5">
									<img src="/new-web/public/front/images/c4.png" alt="Image" />
									<span class="heading_text">WELCOME TO OUR COMMUNITY</span>
								</a>
							</li>
							<li>
								<a href="{{url('/')}}/post/category/6">
									<img src="/new-web/public/front/images/c5.png" alt="Image" />
									<span class="heading_text">SHOPPING</span>
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<script>
  function sort_products(){
            $('#sort_products').submit();
        }

    </script>
<!-- ==== Find Feature Category Section End ==== -->
@endsection