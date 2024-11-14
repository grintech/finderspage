@extends('layouts.frontlayout')
@section('content')

<section class="job-listing">
    <!-- <div class="visible-xs">
        <div class="container-fluid">
            <button class="btn btn-default navbar-btn" data-toggle="collapse" data-target="#filter-sidebar">
              <i class="fa fa-tasks"></i> Filters
            </button>
        </div>
    </div> -->
    <div class="container">
        <div class="row" style="display: flex; justify-content:end; margin-right: 4px;">
            <button type="button" class="btn filterBTN">Filters</button>
        </div>
        <div class="row">
            <div class="col-md-4 col-lg-3" id="FiltersJob">
            	<div class="closeIcon"><i class="fa fa-close"></i></div>
                <div class="left-side-bar">
                    <div class="job-search-box">
                        <h5>Employment Type</h5>
                        <div class="form-check mb-3">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="remember"> Full Time 
                            </label><br>
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="remember"> Part Time
                            </label><br>
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="remember"> Work From Home
                            </label><br>
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="remember"> Part Time
                            </label>
                        </div>

                    </div>
                    <div class="job-search-box mt-2">
                        <h5>Date Posted</h5>
                        <div class="form-check mb-3">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="remember">Last 24 hours 
                            </label><br>
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="remember"> one days ago
                            </label><br>
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="remember">Last 3 days
                            </label><br>
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="remember">Last 7 days
                            </label>
                        </div>

                    </div>
                    <div class="job-search-box mt-2">
                        <h5>Education level</h5>
                        <div class="form-check mb-3">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="remember">Bachelor's degree 
                            </label><br>
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="remember"> Diploma 
                            </label><br>
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="remember">Master's degree
                            </label>
                        </div>
                        <div class="filter-check">
                            <span><a href="#">Reset</a></span><span><a href="#">Apply</a></span>
                        </div>

                    </div>
                </div>
            </div>
            	<div class="col-md-8 col-lg-9 mt-2">
	           		<div class="row related-job">
	                    <div class="col-lg-12 col-md-12">
	                        <div class="job-post-header">
		                        <div class="row">

		                        	@foreach($matchingRecords as $bump)
						            @if($bump->category_id == 2)
						               <div class="col-lg-3 col-md-4 col-sm-6 col-6">
						                        <a href="{{route('jobpost',$bump->id)}}">
						                            <div class="bump-box">
						                                
						                            <div id="demo-new" class="carousel slide" data-bs-ride="carousel">
						                                <div class="carousel-inner">
						                                <?php
						                                $neimg = trim($bump->image1,'[""]');
						                                $img  = explode('","',$neimg);
						                            ?>
						                            @if($bump->image1)
						                                <img src="{{asset('images_blog_img')}}/{{$img[0]}}" alt="{{$bump->title}}" class="d-block w-100">
						                            @else
						                                <img src="./new_assets/assets/images/home.png" alt="New York" class="d-block w-100">
						                            @endif
						                                    
						                                </div>
						                            </div>

						                                <p class="job-title"><b>{{ ucfirst($bump->title) }}</b></p><br>
						                                <div class="location-job-title">
						                                    <div class="job-type">
						                                        <ul>@if($bump->pay_by =="Fixed")
						                                            <li><span><i class="bi bi-cash"></i></span>${{ $bump->fixed_pay }}</li>
						                                            @else
						                                            <li><span><i class="bi bi-cash"></i></span>${{ $bump->min_pay }} - ${{ $bump->max_pay }}</li>
						                                            @endif
						                                            <li><span><i class="bi bi-clock-fill"></i></span>{{ $bump->choices }}</li>
						                                            <li><span><i class="bi bi-briefcase-fill"></i></span>{{ $bump->supplement }}</li>
						                                            <li><span><i class="bi bi-phone"></i></span>{{ $bump->phone }}</li>
						                                        </ul>
						                                    </div>
						                                     
						                                </div>
						                                <div class="job-type job-hp">
						                                        <?php
						                                            if ($bump->post_by == 'admin') {
						                                                foreach ($admin as $add) {
						                                                    if ($bump->user_id == $add->id) {
						                                                        echo '<img src="' . asset($add->image) . '" alt="Image">';
						                                                        echo '<p>' . $bump->title . '<br><small>By ' . $add->first_name . '</small></p>';
						                                                    }
						                                                }
						                                            } else {
						                                                // Assuming $users is an array or collection
						                                                foreach ($users as $user) {
						                                                    if ($bump->user_id == $user->id) {
						                                                        echo '<img src="' . asset('assets/images/profile') . '/' . $user->image . '" alt="Image">';
						                                                        echo '<p>' . $bump->title . '<br><small>By ' . $user->first_name . '</small></p>';
						                                                    }
						                                                }
						                                            }
						                                        ?>
						                                    </div>
						                            </div>
						                        </a>
						                    </div>
						                @endif

						                @if($bump->category_id == 4)
						                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
						                    <a href="{{route('real_esate_post',$bump->id)}}">
						                    <div class="bump-box">
						                            <?php
						                                $neimg = trim($bump->image1,'[""]');
						                                $img  = explode('","',$neimg);
						                            ?>
						                            @if($bump->image1)
						                                <img src="{{asset('images_blog_img')}}/{{$img[0]}}" alt="{{$bump->title}}" class="d-block w-100">
						                            @else
						                                <img src="./new_assets/assets/images/home.png" alt="New York" class="d-block w-100">
						                            @endif
						                        
						                        

						                        <p><b>{{$bump->title}}</b></p>
						                        
						                        <div class="job-type">
						                            <ul>
						                                <li><span><i class="bi bi-cash"></i></span>${{$bump->sale_price}}</li>
						                                <li><span><i class="bi bi-briefcase-fill"></i></span>{{$bump->area_sq_ft}} Sq. Ft</li>
						                                <li><span><i class="bi bi-calendar-check"></i></span>{{$bump->year_built}}</li>
						                                <li><span><i class="bi bi-phone"></i></span>{{$bump->phone}}</li>
						                            </ul>
						                        </div>
						                        <div class="row overflow-section">
						                            <div class="loaction col-md-12">
						                                <p><i class="bi bi-pin-map"></i> {{ $bump->property_address }}</p>
						                            </div>
						                            <div class="review-section">
						                                <p>Review</p>
						                                <ul class="review">
						                                    <li><i class="bi bi-star-fill"></i></li>
						                                    <li><i class="bi bi-star-fill"></i></li>
						                                    <li><i class="bi bi-star-fill"></i></li>
						                                    <li><i class="bi bi-star-fill"></i></li>
						                                    <li><i class="bi bi-star-half"></i></li>
						                                </ul>
						                            </div>
						                            <div class="job-type job-hp">
						                                <?php
						                                    if ($bump->post_by == 'admin') {
						                                        foreach ($admin as $add) {
						                                            if ($bump->user_id == $add->id) {
						                                                echo '<img src="' . asset($add->image) . '" alt="Image">';
						                                                echo '<p>' . $bump->title . '<br><small>By ' . $add->first_name . '</small></p>';
						                                            }
						                                        }
						                                    } else {
						                                        // Assuming $users is an array or collection
						                                        foreach ($users as $user) {
						                                            if ($bump->user_id == $user->id) {
						                                                echo '<img src="' . asset('assets/images/profile') . '/' . $user->image . '" alt="Image">';
						                                                echo '<p>' . $bump->title . '<br><small>By ' . $user->first_name . '</small></p>';
						                                            }
						                                        }
						                                    }
						                                ?>
						                            </div>
						                        </div>
						                    </div>
						                </a>
						            </div>
						            @endif

						            @if($bump->category_id == 705)
						          
						                <div class="col-lg-3 col-md-4 col-sm-6 col-6">
						                        <div class="feature-box">
						                              <a href="{{route('service_single',$bump->id)}}">
						                                <?php
						                                $neimg = trim($bump->image1,'[""]');
						                                $img  = explode('","',$neimg);
						                            ?>
						                            @if($bump->image1)
						                                <img src="{{asset('images_blog_img')}}/{{$img[0]}}" alt="{{$bump->title}}" class="d-block w-100">
						                            @else
						                                <img src="./new_assets/assets/images/home.png" alt="New York" class="d-block w-100">
						                            @endif
						                            
						                            
						                            <div class="job-post-content">
						                                <h4>{{$bump->title}}</h4>
						                                <?php $cleanString = strip_tags($bump->description); ?>
						                                <span class="desc_class">{{$cleanString}}</span>
						                                <div class="job-type">
						                                    <ul class="job-list">
						                                        <li><span><i class="bi bi-cash"></i></span>{{$bump->rate}}</li>
						                                        <li><span><i class="bi bi-briefcase-fill"></i></span>{{$bump->service_date}}</li>
						                                        <li><span><i class="bi bi-briefcase-fill"></i></span>{{$bump->service_time}}</li>
						                                        <li>{{$bump->phone}}</li>
						                                        <li>{{$bump->email}}</li>
						                                        
						                                    </ul>
						                                </div>
						                            </div>
						                            <div class="job-type job-hp">
						                                <?php
						                                    if ($bump->post_by == 'admin') {
						                                        foreach ($admin as $add) {
						                                            if ($bump->user_id == $add->id) {
						                                                echo '<img src="' . asset($add->image) . '" alt="Image">';
						                                                echo '<p>' . $bump->title . '<br><small>By ' . $add->first_name . '</small></p>';
						                                            }
						                                        }
						                                    } else {
						                                        //Assuming $users is an array or collection
						                                        foreach ($users as $user) {
						                                            if ($bump->user_id == $user->id) {
						                                                echo '<img src="' . asset('assets/images/profile') . '/' . $user->image . '" alt="Image">';
						                                                echo '<p>' . $bump->title . '<br><small>By ' . $user->first_name . '</small></p>';
						                                            }
						                                        }
						                                    }
						                                ?>
						                            </div>
						                        </a>
						                        </div>
						                    </div>

						            @endif
						             @if($bump->category_id == 6)
						             <div class="col-lg-3 col-md-4 col-sm-6 col-6">
						                <div class="card shop-box p-2">
						                    <a href="{{route('shopping_post_single',$bump->id)}}">
						                       <?php
						                                $neimg = trim($bump->image1,'[""]');
						                                $img  = explode('","',$neimg);
						                            ?>
						                            @if($bump->image1)
						                                <img src="{{asset('images_blog_img')}}/{{$img[0]}}" alt="{{$bump->title}}" class="d-block w-100">
						                            @else
						                                <img src="./new_assets/assets/images/home.png" alt="New York" class="d-block w-100">
						                            @endif
						                   
						                    <div class="caption text-center">
						                       <h6 class="product-title">{{$bump->title}}</h6>
						                        <div class="price" style="font-size: 15px;padding: 0px 0px;"><del>${{$bump->product_price}}</del> ${{$bump->product_sale_price}}</div>
						                    </div>
						                    <div class="button-sell" style="margin-top: 0px;">
						                        <span><a href="#" class="btn create-post-button" data-product-id="{{$bump->id}}">Add to Cart</a></span>
						                    </div>

						                        <div class="job-type job-hp">
						                                <?php
						                                    if ($bump->post_by == 'admin') {
						                                        foreach ($admin as $add) {
						                                            if ($bump->user_id == $add->id) {
						                                                echo '<img height="50px" src="' . asset($add->image) . '" alt="">';
						                                                echo '<p><span>' . $bump->title . '</span><br><small>By ' . $add->first_name . '</small></p>';
						                                            }
						                                        }
						                                    } else {
						                                        //Assuming $users is an array or collection
						                                        foreach ($users as $user) {
						                                            if ($bump->user_id == $user->id) {
						                                                echo '<img height="50px" src="' . asset('assets/images/profile') . '/' . $user->image . '" alt="">';
						                                                echo '<p><span>' . $bump->title . '</span><br><small>By ' . $user->first_name . '</small></p>';
						                                            }
						                                        }
						                                    }
						                                ?>
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

		<script>
		    $("#menu-toggle").click(function(e) {
		  e.preventDefault();
		  $("#wrapper").toggleClass("toggled");
		});

		</script>

@endsection
