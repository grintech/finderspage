@php
use App\Models\UserAuth; 
@endphp
@extends('layouts.adminlayout')
@section('content')
<style>
.form-control.change_status {
    height: 20px;
    padding: 0;
    width: 100px;
    font-size: 10px;
}
.video-box .card a.btn {
    padding: 0px 5px;
}
</style>
<div class="container px-sm-5 px-4">
	<div class="new_class">
		  <h1 class="mt-5 d-inline">Entertainment List</h1>
		  <a  href="#" class="btn btn-warning float-right ">New</a>
	<div>
		  <div class="row mt-4">
		  	@foreach($Entertainment as $blogs)
      <div class="col-lg-4 col-md-6 mb-4 job-post-listing">
        <div class="card">
          <div class="card-body">
            <div class="pic">
              <?php
                    $itemFeaturedImages = trim($blogs->image,'[""]');
                    $itemFeaturedImage  = explode('","',$itemFeaturedImages);
                    if(is_array($itemFeaturedImage)) {
                      foreach($itemFeaturedImage as $keyitemFeaturedImage => $valueitemFeaturedImage) { if($keyitemFeaturedImage == 0) {$class='active'; } else { $class='in-active'; } ?>
                          <div class="carousel-item <?= $class; ?>">
                            <img src="{{asset('images_entrtainment')}}/{{ $valueitemFeaturedImage }}" alt="Los Angeles" class="img-fluid d-block w-100" onerror="this.onerror=null; this.src='https://finderspage.com/public/images_blog_img/1688636936.jpg';">
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
                  
                  <tbody>
                    
                    <tr class="action-list">
                      <th valign="center">
                          <select name="status" data_id="<?php echo $blogs->id;  ?>"  class="change_status">
                            <option value="1" {{ $blogs->status == 1 ? ' selected' : '' }}>Publish</option>
                            <option value="0" {{  $blogs->status == 0 ? ' selected' : '' }}>Unpublish</option>
                        </select>
                      </th>
                      <td colspan="2" class="btn-list">
                            <a href="{{route('Entertainment.single.listing',$blogs->id)}}" class="btn" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a>  
                       
                           <a href="#" title="Unsave Post" data-Userid="{{UserAuth::getLoginId()}}" data-postid="{{$blogs->id}}" data-link="{{route('Entertainment.delete',$blogs->id)}}"  class="btn  btn-red Unsaved_post_btn" ><i class="fa fa-trash" aria-hidden="true"></i></a>
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

  <!-- Add more video cards as needed -->

</div> 
	<script type="text/javascript">
	$(document).on("click", "#del_my_account", function(e) {
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

    $(".change_status").change(function() {
      var status = $(this).val();
      var id = $(this).attr('data_id');
      var user_id = $(this).attr('user-id');
     var csrfToken = document.head.querySelector('meta[name="csrf-token"]').content; 
       // alert(csrfToken);
      $.ajax({
        type: 'POST',
        url: '{{route('updatestatus_ent')}}',
        headers: {
                'X-CSRF-TOKEN': csrfToken
            },
        data: {
          id: id, // Fix: use ":" instead of "="
          status: status, // Fix: use ":" instead of "="
          user_id: user_id, // Fix: use ":" instead of "="
        },
        success: function(data) {
            console.log(data);
            if(data.success){
            toastr.options =
              {
                "closeButton" : true,
                "progressBar" : true
              }
              toastr.success(data.success);
              // window.location.reload();
          }
        }
      });
    });
</script>
@endsection