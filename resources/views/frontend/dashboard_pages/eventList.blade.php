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
  <a class="btn profile-button float-right mb-2" href="{{route('add_event')}}">Add</a>
	<table class="table table-striped table-responsive" id="tableListing">
  <thead>
    <tr>
     <th>#</th>
    <th>Title</th>
    <th>Status</th>
    <th>Featured</th>
    <th>Bump Post</th>
    <th>Created</th>
    <th>Action</th>
    </tr>
  </thead>
  <tbody>
@foreach($blog as $blogs)
<tr>
	<td>{{$loop->iteration}}</td>
	<td>{{$blogs->title}}</td>
	<td> @if($blogs->status == 1)<button class="btn btn-success">Publish</button>@else<button class="btn btn-danger">Unpublish</button>@endif</td>
   <td> @if($blogs->featured_post == 'on')<button class="btn btn-success">Yes</button>@else<button class="btn btn-danger">No</button>@endif</td>

    <td> @if($blogs->bumpPost == '1')<button class="btn btn-success">Yes</button>@else<button class="btn btn-danger">No</button>@endif</td>
    
    
	<td>{{$blogs->created}}</td>
	<td>
		<a href="{{route('edit_services',$blogs->id)}}" class="btn btn-warning" >Edit</a>  
		<a href="{{route('delete_services',$blogs->id)}}" class="btn btn-danger" >Delete</a> 

    <a href="{{route('event_single',$blogs->id)}}" class="btn btn-primary" ><i class="fa fa-eye" aria-hidden="true"></i></a>  
    <a href="{{route('update_event',$blogs->id)}}" class="btn btn-warning" ><i class="far fa-edit" ></i></a> 
     
    <a href="{{route('delete_services',$blogs->id)}}" class="btn btn-danger" ><i class="fa fa-trash" aria-hidden="true"></i></a>
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
            <div id="btnContainer">
              <a href="javascript:void(0)" class="btn b1" data-view="grid" onclick="toggleView('grid')"><i class="fa fa-th"></i></a>
              <a href="javascript:void(0)" class="btn b1 active" data-view="list" onclick="toggleView('list')"><i class="fa fa-bars"></i></a> 
            </div>
            <a class="btn profile-button float-right mb-2" href="{{route('add_event')}}">Add</a>
          </div>
        </div>
        <div class="row mt-4">
          @foreach($blog as $blogs)

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

                  <div class="caption-frame">
                    <h4>{{$blogs->title}}</h4>
                    <p>{{$blogs->created}}</p>
                  </div>
                  <div class="frame-inner">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>Status</th>
                          <th>Featured</th>
                          <th>Bump Post</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr class="status-list">
                          <td>@if($blogs->status == 1)<button class="btn btn-success">Publish</button>@else<button class="btn btn-danger">Unpublish</button>@endif</td>
                          <td>@if($blogs->featured_post == 'on')<button class="btn btn-success">Yes</button>@else<button class="btn btn-danger">No</button>@endif</td>
                          <td>@if($blogs->bumpPost == '1')<button class="btn btn-success">Yes</button>@else<button class="btn btn-danger">No</button>@endif</td>
                        </tr>
                        <tr class="action-list">
                          <th valign="center">Action</th>
                          <td colspan="2" class="btn-list">
                            <a href="{{route('event_single',$blogs->id)}}" class="btn" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            <a href="{{route('update_event',$blogs->id)}}" class="btn" data-toggle="tooltip" data-placement="top" title="Edit"><i class="far fa-edit" ></i></a> 
                            <a href="{{route('delete_services',$blogs->id)}}" class="btn btn-red" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            <a href="{{route('stripe.createstripe.bump',General::encrypt($blogs->id))}}" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Bump">Bump</i></a>
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