<?php  use App\Models\JobApply; ?>
@extends('layouts.user_dashboard.userdashboardlayout')
@section('content')
<?php  use Carbon\Carbon; 
use App\Models\UserAuth;
$userData = UserAuth::getLoginUser();
?>
<style type="text/css">
</style>
<section id="post-listing" class="post-listing">
      <div class="container">
        <div class="row justify-content-end">
          <div class="col-lg-12">
            <span>
                @include('admin.partials.flash_messages')
            </span>
            <h3 class="d-inline"><b>Your fundraiser Ads</b></h3>
            <a class="btn profile-button float-right mb-2" href="{{route('fundraisers')}}">Add</a>
            <div id="btnContainer" class="d-block mt-3">
              <a href="javascript:void(0)" class="btn b1" data-view="grid" onclick="toggleView('grid')"><i class="fa fa-th"></i></a>
              <a href="javascript:void(0)" class="btn b1 active" data-view="list" onclick="toggleView('list')"><i class="fa fa-bars"></i></a> 
            </div>
            
          </div>
        </div>
        
        @php
          $givenTime = strtotime($userData->created);
          $currentTimestamp = time();
          $timeDifference = $currentTimestamp - $givenTime;

          $days = floor($timeDifference / (60 * 60 * 24));

          $alertMessage = "";

          if ($days >= 42 && $days < 45) {
            if ($days == 44) {
              $alertMessage = "Your listing expires in 1 day.";
            } else {
              $remainingDays = 45 - $days;
              $dayText = $remainingDays == 1 ? "day" : "days";
              $alertMessage = "Your listing expires in $remainingDays $dayText.";
            }
          } elseif ($days == 45) {
            $alertMessage = "Your listing has expired.";
          }
        @endphp

        <div class="pt-3 dash_highlight">
          @if ($alertMessage)
            <div class="alert alert-danger" role="alert">
              {{ $alertMessage }}
            </div>
          @endif
        </div>
      
        <div class="dash_highlight">
          <div class="alert alert-info " role="alert">
          To highlight your content to the top of the search results, simply click the <span>feature</span> or <span>bump</span> button.
          </div>
        </div>

        <div class="row mt-4">
          @foreach($blog as $blogs)

          <div class="col-lg-4 col-md-6 mb-4 job-post-listing">
            
            <div class="card">
              @if($blogs->featured_post=="on")
             <div class="ribbon bump-ribbon" data-toggle="tooltip" data-placement="top">
              <div class="text-div">
                Featured
              </div>
            </div>
            @endif

            @if($blogs->draft=='0')
             <div class="ribbon" data-toggle="tooltip" data-placement="top" title="This listing is in draft. Please edit this post and proceed with the payment to publish.">
              <div class="text-div">
                Draft
              </div>
            </div>
            @endif
              <div class="card-body">
                
                <div class="pic">
                  <?php
                    $itemFeaturedImages = trim($blogs->image1,'[""]');
                    $itemFeaturedImage  = explode('","',$itemFeaturedImages);
                    if(is_array($itemFeaturedImage)) {
                      foreach($itemFeaturedImage as $keyitemFeaturedImage => $valueitemFeaturedImage) { if($keyitemFeaturedImage == 0) {$class='active'; } else { $class='in-active'; } ?>
                          <div class="carousel-item <?= $class; ?>">
                            <img src="{{asset('images_blog_img')}}/{{ $valueitemFeaturedImage }}" alt="Los Angeles" class="img-fluid d-block w-100" onerror="this.onerror=null; this.src='https://www.finderspage.com/public/images_blog_img/1688636936.jpg';">
                          </div>
                      <?php }     
                    }
                  ?>
                  <!-- <img src="https://www.finderspage.com/public/images_blog_img/1695625998_1693983622274-download-2.jpg" class="img-fluid" alt=""> -->
                </div>

                <?php
                $timestamp = (strtotime($blogs->created));

                $date = date('d-n-Y', $timestamp);
                // $time = date('H:i:s', $timestamp);
                ?>

                  <div class="caption-frame">
                    <h4>{{$blogs->title}}</h4>
                    <p><b>Created on: </b>{{$date}}</p>
                    <p>
                      <b>
                          @php
                            $givenTime = strtotime($blogs->created);
                            $currentTimestamp = time();
                            $timeDifference = $currentTimestamp - $givenTime;

                            $days = floor($timeDifference / (60 * 60 * 24));

                            $alertMessage = "";
                            
                              if ($days == 44) {
                              echo $alertMessage = "Your listing expires in 1 day.";
                              }elseif ($days >= 45) {
                                echo $alertMessage = "Your listing has expired.";
                              } else {
                                $remainingDays = 45 - $days;
                                $dayText = $remainingDays == 1 ? "day" : "days";
                              echo $alertMessage = "Your listing expires in $remainingDays $dayText.";
                              }
                            
                          @endphp

                      </b>
                    </p>
                  </div>
                  <div class="frame-inner">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>Status</th>
                          <th>Featured</th>
                          <th>Bump Post</th>
                          <!-- <th>Applicants</th> -->
                        </tr>
                      </thead>
                      <tbody>
                        <tr class="status-list">
                          <td>@if($blogs->status == 1)<button class="btn btn-success">Published</button>@else<button class="btn btn-danger">Unpublished</button>@endif</td>
                          <td>@if($blogs->featured_post == 'on')<button class="btn btn-success">Yes</button>@else<button class="btn btn-danger">No</button>@endif</td>
                          <td>@if($blogs->bumpPost == '1')<button class="btn btn-success">Yes</button>@else<button class="btn btn-danger">No</button>@endif</td>
                          
                          <!-- <td><a href="{{route('apply.list',$blogs->id)}}" >{{JobApply::get_on_of_applicant($blogs->id)}} </a></td> -->
                          
                        </tr>
                        <tr class="action-list">
                          <th valign="center">Action</th>
                          <td colspan="3" class="btn-list">
                            <a href="{{route('single.fundraisers',$blogs->slug)}}" class="btn" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a>

                            <?php 
                            $currentDateTime = new DateTime();
                            $givenTime = $blogs->created;

                            // Convert the given time to a Carbon instance
                            $givenDateTime = Carbon::parse($givenTime);

                            // Add 10 days to the given date time
                            $nextTenDays = $givenDateTime->addDays(10);

                            // Output the next 10 days date time
                            // echo $nextTenDays;
                            // echo '<br>';
                            // echo $post->created_at;
                            ?> 
                           
                      @if($userData->subscribedPlan != '7-day-14' && $userData->subscribedPlan != '1-month-55' && !empty($userData->subscribedPlan ))

                        @if($currentDateTime <= $nextTenDays)
                          <a href="{{route('edit.fundraisers',$blogs->slug)}}" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Edit">
                            <i class="far fa-edit" ></i>
                          </a>
                        @else 
                          <a href="{{route('edit.fundraisers',$blogs->slug)}}" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Edit" >
                            <i class="far fa-edit"></i>
                          </a>
                        @endif
                       
                      @else 
                        <a href="{{route('edit.fundraisers',$blogs->slug)}}" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Edit"><i class="far fa-edit"></i></a>
                       <!-- <a href="{{route('pricing')}}" class="btn btn-warning"  data-toggle="tooltip" data-placement="top" title="Edit this listing you have to upgrade your plan" ><i class="far fa-edit"></i></a> -->
                      @endif
                      
                            <a id="blog_delete" delete-link="{{route('delete_services',$blogs->id)}}" href="#" class="btn btn-red" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a>


                           @if($blogs->bumpPost=="1")
                            <a href="#" data-toggle="tooltip" data-placement="top" title="Allready bumped"  class="btn btn-primary">Bumped</a>
                            @elseif ($userData->review=="1" && $userData->free_bump=="1")
                            <a data-toggle="tooltip" data-placement="top" title="You have a free bump" href="{{route('bump.free.success',$blogs->id)}}" class="btn btn-primary">Bump</a>
                            @elseif ($userData->bump_post_count > 0)
                            <a data-toggle="tooltip" data-placement="top" title="{{ $userData->bump_post_count }} {{ $userData->bump_post_count == 1 ? 'bump left' : 'bumps left' }}" href="{{route('bump.post_count.success',$blogs->id)}}" class="btn btn-primary">Bump</a>
                            @elseif ($userData->bump_post_count == 'Unlimited')
                            <a data-toggle="tooltip" data-placement="top" title="Unlimited bumps" href="{{route('bump.post_count.success',$blogs->id)}}" class="btn btn-primary">Bump</a>
                            @elseif (!empty($userData->subscribedPlan) || $userData->bump_post_count <= 0 )
                            <a href="{{route('pay.auth',General::encrypt($blogs->id))}}" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="You've used up all your free bump posts from your subscription plan">Bump</i></a>
                            @else
                              <a href="{{route('pay.auth',General::encrypt($blogs->id))}}" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="$5.08 to bump this listing">Bump</i></a>
                           @endif




                           @if($blogs->featured_post=="on")
                              <a href="#" data-toggle="tooltip" data-placement="top" title="This listing is already Featured"  class="btn btn-primary">Featured</a>
                            @elseif ($userData->featured_post_count > 0 || $userData->featured_post_count == 'Unlimited')
                            <a data-toggle="tooltip" data-placement="top" title="You have an {{ lcfirst($userData->featured_post_count) }} subscription plan" href="{{route('featured.post_count.success',$blogs->id)}}" class="btn btn-primary">Feature</a>
                            @else
                              <a data-toggle="tooltip" data-placement="top" title="Get featured! Starting at just ${{$plan_month->price}} for one month." href="{{route('pay.auth.reccuring_featured', ['post_id' => General::encrypt($blogs->id)])}}" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Bump">Feature</i></a>
                           @endif
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
  $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
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

$(document).on("click", "#blog_delete", function(e) {
        e.preventDefault();
        var link = $(this).attr("delete-link");
         Swal.fire({
            title: 'Delete',
            text: 'Are you sure you want to Delete?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#fcd152',
            cancelButtonColor: '#1a202e',
            confirmButtonText: 'Yes, Delete!',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = link;
                Swal.fire(
				      'Deleted!',
				      'Your Job listing has been deleted.',
				      'success'
				    )
            }
        });
    });
</script>  



@endsection