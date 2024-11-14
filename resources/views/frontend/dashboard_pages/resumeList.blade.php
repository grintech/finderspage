@extends('layouts.user_dashboard.userdashboardlayout')
@section('content')
<!-- <style type="text/css">
	a.buttons-collection {
        margin-left: 1em;
    }
</style>
<div class="container">
  <span>
      @include('admin.partials.flash_messages')
  </span>
  <a class="btn profile-button float-right mb-2" href="{{route('resume')}}">Add</a>
	<table class="table table-striped table-responsive" id="tableListing">
  <thead>
    <tr>
     <th>#</th>
    <th>Full Name</th>
    <th>Phone no</th>
    <th>Education Level</th>
    <th>Picture</th>
    <th>Uploaded Resume</th>
    <th>Created</th>
    <th>Action</th>
    </tr>
  </thead>
  <tbody>
@foreach($resume as $res)
<tr>
	<td>{{$loop->iteration}}</td>
	<td>{{$res->firstName}}&nbsp;{{$res->lastName}}</td>
	<td>{{$res->phoneNumber}}</td>
  <td>{{$res->educationLevel}}</td>  
	<td> <img src="{{asset('images_resume_img')}}/{{$res->uploadPicture}}" height="50" width="50" style="border-radius: 50%;">  </td>
	<td> <a  target="blank" href="{{asset('images_blog_doc')}}/{{$res->uploadResume}}"><img src="{{asset('new_assets/assets/images/download.png')}}" doc-path="{{asset('images_blog_doc')}}/{{$res->uploadResume}}" height="50" width="50" >  </a></td>
  <td>{{$res->created_at}}</td>
  <td>
    <a href="{{route('resume.single-post',$res->id)}}" class="btn btn-primary" ><i class="fa fa-eye" aria-hidden="true"></i></a>  
    <a href="{{route('resume.edit',$res->id)}}" class="btn btn-warning" ><i class="far fa-edit" ></i></a> 
     
    <a href="" id="resume_delete" data-link="{{route('resume.delete',$res->id)}}" class="btn btn-danger" ><i class="fa fa-trash" aria-hidden="true"></i></a>
  </td>
</tr>
@endforeach
  </tbody>
</table>
	
</div> -->



<section id="post-listing" class="post-listing">
      <div class="container">
        <div class="row justify-content-end">
          <div class="col-lg-12">
            <span>
                @include('admin.partials.flash_messages')
            </span>
            <h3 class="d-inline"><b>Your Resumes</b></h3>
            <a class="btn profile-button float-right mb-2" href="{{route('resume')}}">Add</a>
            <div id="btnContainer" class="d-block mt-3">
              <a href="javascript:void(0)" class="btn b1" data-view="grid" onclick="toggleView('grid')"><i class="fa fa-th"></i></a>
              <a href="javascript:void(0)" class="btn b1 active" data-view="list" onclick="toggleView('list')"><i class="fa fa-bars"></i></a> 
            </div>
            
          </div>
        </div>
        <div class="row mt-4">
          @foreach($resume as $res)

          <div class="col-lg-4 col-md-6 mb-4 job-post-listing">
            <div class="card">
              <div class="card-body">
                <div class="pic">
                  <?php
                    $itemFeaturedImages = trim($res->image1,'[""]');
                    $itemFeaturedImage  = explode('","',$itemFeaturedImages);
                    if(is_array($itemFeaturedImage)) {
                      foreach($itemFeaturedImage as $keyitemFeaturedImage => $valueitemFeaturedImage) { if($keyitemFeaturedImage == 0) {$class='active'; } else { $class='in-active'; } ?>
                          <div class="carousel-item <?= $class; ?>">
                            <img src="{{asset('images_resume_img')}}/{{$res->uploadPicture}}" alt="Image" class="img-fluid d-block w-100" onerror="this.onerror=null; this.src='https://finderspage.com/public/images_blog_img/1688636936.jpg';">
                          </div>
                      <?php }     
                    }
                  ?>
                  <!-- <img src="https://finderspage.com/public/images_blog_img/1695625998_1693983622274-download-2.jpg" class="img-fluid" alt=""> -->
                </div>

                <?php
                $timestamp = (strtotime($res->created_at));

                $date = date('j-n-Y', $timestamp);
                // $time = date('H:i:s', $timestamp);
                ?>

                  <div class="caption-frame text-center">
                    <h4>{{$res->firstName}}&nbsp;{{$res->lastName}}</h4>
                    <p><b>Created at: </b>{{ $date }}</p>
                  </div>
                  <div class="frame-inner">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>Phone No.</th>
                          <th>Education Level</th>
                          <th>Uploaded Resume</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr class="status-list">
                          <td>{{$res->phoneNumber}}</td>
                          <td>{{$res->educationLevel}}</td>
                          <td><a class="btn" target="blank" href="{{asset('images_blog_doc')}}/{{$res->uploadResume}}"><i class="far fa-file-pdf" style="font-size:28px;color:red"></i></a></td>
                        </tr>
                        <tr class="action-list">
                          <th valign="center">Action</th>
                          <td colspan="2" class="btn-list">
                            <a href="{{route('resume.single-post',$res->id)}}" class="btn" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            <a href="{{route('resume.edit',$res->id)}}" class="btn" data-toggle="tooltip" data-placement="top" title="Edit"><i class="far fa-edit" ></i></a> 
                            <a href="javascript:void(0);" id="resume_delete" data-link="{{route('resume.delete',$res->id)}}" class="btn btn-red" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
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
  $(document).on("click", "#resume_delete", function(e) {
        e.preventDefault();
        var link = $(this).attr("data-link");
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
              'Your file has been deleted.',
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