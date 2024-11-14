<?php use App\Models\UserAuth; ?>
@extends('layouts.user_dashboard.userdashboardlayout')
@section('content')

<section id="post-listing" class="post-listing">
  <div class="container">
    <div class="row justify-content-end">
      <div class="col-lg-12">
        <span>
            @include('admin.partials.flash_messages')
        </span>
        <div id="btnContainer">
          <a href="javascript:void(0)" class="btn b1" data-view="grid" onclick="toggleView('grid')"><i class="fa fa-th"></i></a>
          <a href="javascript:void(0)" class="btn b1 active" data-view="list" onclick="toggleView('list')"><i class="fa fa-bars"></i></a> 
        </div>
        <!-- <a class="btn profile-button float-right mb-2" href="{{route('create_realestate')}}">Add</a> -->
      </div>
    </div>
    <div class="row mt-4">
      @foreach($matchingRecords as $blogs)
      <div class="col-lg-4 col-md-6 mb-4 job-post-listing">
        <div class="card">
          <div class="card-body">
            <div class="pic">
              <?php
                $itemFeaturedImages = trim($blogs->image1,'[""]');
                $itemFeaturedImage  = explode('","',$itemFeaturedImages);
                if(is_array($itemFeaturedImage)) {
                  foreach($itemFeaturedImage as $keyitemFeaturedImage => $valueitemFeaturedImage) { if($keyitemFeaturedImage == 0) {$class='active'; } else { $class='in-active'; } ?>
                      <div class="carousel-item <?= $class; ?>">
                        <img src="{{asset('images_blog_img')}}/{{ $valueitemFeaturedImage }}" alt="Los Angeles" class="img-fluid d-block w-100" onerror="this.onerror=null; this.src='https://finderspage.com/public/images_blog_img/1688636936.jpg';">
                      </div>
                  <?php }     
                }
              ?>
              <!-- <img src="https://finderspage.com/public/images_blog_img/1695625998_1693983622274-download-2.jpg" class="img-fluid" alt=""> -->
            </div>

              <div class="caption-frame text-center">
                <h4>{{$blogs->title}}</h4>
                <p>{{$blogs->created}}</p>
              </div>
              <div class="frame-inner">
                <table class="table">
                  
                  <tbody>
                    
                    <tr class="action-list">
                      <th valign="center">Action</th>
                      <td colspan="2" class="btn-list">
                        <?php 
                        // echo"<pre>";print_r($blogs->category_id);die(); 

                        if($blogs->category_id == 2){ ?>
                            <a href="{{route('jobpost',$blogs->slug)}}" class="btn" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a>  
                        <?php
                        }
                         if($blogs->category_id == 4){ ?>
                            <a href="{{route('real_esate_post',$blogs->slug)}}" class="btn" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a>  
                        <?php
                        }
                        if($blogs->category_id == 5){ ?>
                            <a href="{{route('community_single_post',$blogs->slug)}}" class="btn" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a>  
                        <?php
                        }
                        if($blogs->category_id == 6){ ?>
                            <a href="{{route('shopping_post_single',$blogs->slug)}}" class="btn" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a>  
                        <?php
                        }
                       if($blogs->category_id == 705){ ?>
                            <a href="{{route('service_single',$blogs->slug)}}" class="btn" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a>  
                        <?php
                        }
                        ?>
                           <a href="#" title="Unsave Post" data-Userid="{{UserAuth::getLoginId()}}" data-postid="{{$blogs->slug}}"  class="btn  btn-red Unsaved_post_btn" ><i class="fa fa-trash" aria-hidden="true"></i></a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>

    
<script>
// Get the elements with class "job-listing"
var jobListings = document.querySelectorAll(".job-post-listing");

// Check if a view preference is stored in localStorage
var currentView = localStorage.getItem("viewPreference");

// Initialize the view based on the stored preference or default to "list"
if (currentView === "grid") {
  gridView();
} else {
  listView();
}

// Function to toggle view
function toggleView(viewType) {
  if (viewType === "grid") {
    gridView();
  } else {
    listView();
  }
}

// List View
function listView() {
  for (var i = 0; i < jobListings.length; i++) {
    jobListings[i].classList.remove("grid-view");
    jobListings[i].classList.add("list-view");
  }
  // Highlight the "List" button
  document.querySelector(".btn.active").classList.remove("active");
  document.querySelector(".btn[data-view='list']").classList.add("active");
  // Store the view preference in localStorage
  localStorage.setItem("viewPreference", "list");
}

// Grid View
function gridView() {
  for (var i = 0; i < jobListings.length; i++) {
    jobListings[i].classList.remove("list-view");
    jobListings[i].classList.add("grid-view");
  }
  // Highlight the "Grid" button
  document.querySelector(".btn.active").classList.remove("active");
  document.querySelector(".btn[data-view='grid']").classList.add("active");
  // Store the view preference in localStorage
  localStorage.setItem("viewPreference", "grid");
}

</script>  


@endsection