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
            <h3 class="d-inline"><b>Your Business Pages</b></h3>
             <a class="btn profile-button float-right mb-2" href="{{route('business_page')}}">Create new</a> 
            <!-- <a class="btn profile-button float-right mb-2" href="{{route('commingSoon_bussiness')}}">Create new</a> -->
            <div id="btnContainer" class="d-block mt-3">
              <a href="javascript:void(0)" class="btn b1" data-view="grid" onclick="toggleView('grid')"><i class="fa fa-th"></i></a>
              <a href="javascript:void(0)" class="btn b1 active" data-view="list" onclick="toggleView('list')"><i class="fa fa-bars"></i></a> 
            </div>
            
          </div>
        </div>
       
        @php
          $givenTime = strtotime($userData->created_at);
          $currentTimestamp = time();
          $timeDifference = $currentTimestamp - $givenTime;

          $days = floor($timeDifference / (60 * 60 * 24));

          $alertMessage = "";

          if ($days >= 42 && $days < 45) {
            if ($days == 44) {
              $alertMessage = "Your free listing expires in 1 day.";
            } else {
              $remainingDays = 45 - $days;
              $dayText = $remainingDays == 1 ? "day" : "days";
              $alertMessage = "Your free listing expires in $remainingDays $dayText.";
            }
          } elseif ($days == 45) {
            $alertMessage = "Your free listing has expired.";
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
          @foreach($business as $blogs)

          <div class="col-lg-4 col-md-6 mb-4 job-post-listing">
            
            <div class="card">
              @if($blogs->featured == "on")
              <div class="ribbon bump-ribbon" data-toggle="tooltip" data-placement="top">
               <div class="text-div">
                 Featured
               </div>
             </div>
             @endif
 
             @if($blogs->draft == '0')
              <div class="ribbon" data-toggle="tooltip" data-placement="top" title="This listing is in draft. Please edit this post and proceed with the payment to publish.">
               <div class="text-div">
                 Draft
               </div>
             </div>
             @endif
              <div class="card-body">
                <div class="pic">
                  <img src="{{ $blogs->business_logo ? asset('/business_img/' . $blogs->business_logo) :  asset('/images_blog_img/1688636936.jpg') }}" alt="...">
                </div>

                <?php
                $timestamp = (strtotime($blogs->created_at));

                $date = date('j-n-Y', $timestamp);
                // $time = date('H:i:s', $timestamp);
                ?>

                  <div class="caption-frame">
                    <h4>{{$blogs->business_name}}</h4>
                    <p><b>Created on: </b>{{ $date }}</p>
                      <label class="custom-toggle">
                         <input data-toggle="tooltip" data-placement="top" title="If you're available to see clients in your city right now, hit the Available Now button." type="checkbox" data-id="{{$blogs->id}}" @if($blogs->available_now == 1) checked @endif name="available_now" value="true"><label><strong> Available Now </strong></label>
                    </label>
                  </div>
                  <div class="frame-inner">
                    <table class="table">
                      <thead>
                        <!-- <tr>
                          <th>Status</th>
                        </tr> -->
                      </thead>
                      <tbody>
                        <tr class="status-list">
                          <td>Status </td>
                          <td>@if($blogs->status == 1)<button class="btn btn-success">Published</button>@else<button class="btn btn-danger">Unpublished</button>@endif</td>
                          
                        </tr>
                        <tr class="action-list">
                          <th valign="center">Action</th>
                          <td colspan="3" class="btn-list">
                            <a href="{{ route('business_page.front.single.listing', $blogs->slug) }}" class="btn" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a>

                            <?php 
                            $currentDateTime = new DateTime();
                            $givenTime = $blogs->created;

                            // Convert the given time to a Carbon instance
                            $givenDateTime = Carbon::parse($givenTime);

                            // Add 10 days to the given date time
                            $nextTenDays = $givenDateTime->addDays(10);
                            ?> 
                           
                      
                            <a href="{{route('business_page.edit', $blogs->slug)}}" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Edit"><i class="far fa-edit"></i></a>
                       
                    
                      
                            <a id="blog_delete" delete-link="{{route('business_page.delete', $blogs->id)}}" href="#" class="btn btn-red" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a>


                            @if($blogs->bumpPost=="1")
                             <a href="#" data-toggle="tooltip" data-placement="top" title="Allready bumped" class="btn btn-primary">Bumped</a>
                            @elseif ($userData->review=="1" && $userData->free_bump=="1")
                            <a data-toggle="tooltip" data-placement="top" title="You have a free bump" href="{{route('bump.free.success.blogs',$blogs->id)}}" class="btn btn-primary">Bump</a>
                            @elseif ($userData->bump_post_count > 0)
                            <a data-toggle="tooltip" data-placement="top" title="{{ $userData->bump_post_count }} {{ $userData->bump_post_count == 1 ? 'bump left' : 'bumps left' }}" href="{{route('bump.post_count.success',$blogs->id)}}" class="btn btn-primary">Bump</a>
                            @elseif ($userData->bump_post_count == 'Unlimited')
                            <a data-toggle="tooltip" data-placement="top" title="Unlimited bumps" href="{{route('bump.post_count.success',$blogs->id)}}" class="btn btn-primary">Bump</a>
                            @elseif (!empty($userData->subscribedPlan) || $userData->bump_post_count <= 0 )
                              <a data-toggle="tooltip" data-placement="top" title="You've used up all your free bump posts from your subscription plan" href="{{route('pay.auth.bump.business',General::encrypt($blogs->id))}}"  class="btn btn-primary">Bump</a>
                            @else
                            <a data-toggle="tooltip" data-placement="top" title="$5.08 to bump this blog" href="{{route('pay.auth.bump.business',General::encrypt($blogs->id))}}"  class="btn btn-primary">Bump</a>
                            @endif


                            @if($blogs->featured=="on")
                              <a href="#" data-toggle="tooltip" data-placement="top" title="This business is allready featured" class="btn btn-primary">Featured</a>
                            @elseif ($userData->featured_post_count > 0 || $userData->featured_post_count == "Unlimited")
                            <a data-toggle="tooltip" data-placement="top" title="You have an {{ lcfirst($userData->featured_post_count) }} subscription plan" href="{{route('featured.post_count.success.business',$blogs->id)}}" class="btn btn-primary">Feature</a>
                            @else
                              <a data-toggle="tooltip" data-placement="top" title="Get featured! Starting at just ${{$plan_month->price}} for one month." href="{{route('paypal.featured_post.business', ['post_id' => General::encrypt($blogs->id)])}}" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Bump">Feature</i></a>
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
    
    $(document).ready(function() {
        $('input[name="available_now"]').on('click', function() {
            var isChecked = $(this).is(':checked');
            var post_id = $(this).attr('data-id');
            console.log(isChecked);
            if (isChecked === true) {
              var available_now = 1;
            } else {
              var available_now = 0;
            }
            // alert(available_now);
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            $.ajax({
                url: baseurl + '/update/available/now/business',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                  available_now: available_now,
                  post_id: post_id,
                },
                success: function(response) {
                  if(response.success){
                    toastr.success(response.success);
                  }else{
                    toastr.success(response.error);
                  }
                    
                },
                error: function(xhr, status, error) {

                }
            });


        });
    });
</script>  



@endsection