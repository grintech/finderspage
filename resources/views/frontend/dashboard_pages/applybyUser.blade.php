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
          </div>
        </div>
        <div class="row mt-4">
          @foreach($data as $newData)

          <div class="col-lg-4 col-md-6 mb-4 job-post-listing">
            <div class="card">
              <div class="card-body">
                <div class="pic">
                 <?php
                  $itemFeaturedImages = trim($newData->image,'[""]');
                  $itemFeaturedImage  = explode('","',$itemFeaturedImages);
                  if(is_array($itemFeaturedImage)) {
                      foreach($itemFeaturedImage as $keyitemFeaturedImage => $valueitemFeaturedImage) { if($keyitemFeaturedImage == 0) {$class='active'; } else { $class='in-active'; } ?>
                              <div class="carousel-item <?= $class; ?>">
                                  <img src="{{asset('images_blog_img')}}/{{ $valueitemFeaturedImage }}"  height="50px" width="50px" alt="Los Angeles" class="d-block   rounded-circle" onerror="this.onerror=null; this.src='https://finder.harjassinfotech.org/public/images_blog_img/1688636936.jpg';">
                              </div>
                      <?php }     
                  }
                  ?>
                </div>

                  <div class="caption-frame">
                    <h4>{{$newData->title}}</h4>
                    <p>{{$newData->created_at}}</p>
                  </div>
                  <div class="frame-inner">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>Status</th>
                          <th>Phone No.</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr class="status-list">
                          <td>@if($newData->status == 1) <span class="text-success"> Job-open </span>@else <span class="text-danger"> Job-close </span> @endif</td>
                          <td>{{$newData->phone_no}}</td>
                        </tr>
                        <tr class="email-list">
                          <th class="email-box">Email</th>
                          <td>{{$newData->email}}</td>
                        </tr>
                        <tr></tr>
                        <tr class="action-list">
                          <th valign="center">Document</th>
                          <td colspan="2" class="btn-list">
                            <a class="btn"  target="blank" href="{{asset('File_jobApply')}}/{{$newData->file}}"><i class="far fa-file-pdf" style="font-size:28px;color:red"></i></a>
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

<script type="text/javascript">
  $(document).on("click", "#del_apply_job", function(e) {
        e.preventDefault();
        var link = $(this).attr("data-link");
         Swal.fire({
            title: 'Widrow',
            text: 'Are you sure you want to Widrow?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#fcd152',
            cancelButtonColor: '#1a202e',
            confirmButtonText: 'Yes, Widrow!',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = link;
                Swal.fire(
              'Widrow!',
              'Your Proposal has been Widrow.',
              'success'
            )
            }
        });
    });

</script>
    
<script>
// Get the elements with class "job-listing"
var jobListings = document.querySelectorAll(".job-post-listing");

// Check if a view preference is stored in localStorage
var currentView = localStorage.getItem("viewPreference");

// Initialize the view based on the stored preference or default to "list"
if (currentView === "grid") {
  listView();
} else {
  gridView();
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