@extends('layouts.adminlayout')
@section('content')
<style type="text/css">
    .card-body p {
    display: -webkit-inline-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    clear: both;
}
.card-body {
     background: #fff;
    border-radius: 20px;
}
.card-body h5.card-title {
    font-size: 16px !important;
    color: #000 !important;
    font-weight: 500;
    padding: 5px 0px;
    font-family: 'Poppins', sans-serif;
    text-transform: capitalize!important;    
}
.card-title {
    margin-bottom: 0;
}
.card-img-top{
	height:261px;
}
.blog-box .btn{padding: 2px 5px; margin-right: 0;}
.blog-box .status_blog{height: 33px;padding: 5px;width: 100px;display: inline-block;}
.avatar.rounded-circle img {
    border-radius: 50% !important;
    height: 45px;
    width: 44px;
}
</style>
<div class="container px-sm-5 px-4 pt-4">
		  <h1 class="mt-5 d-inline">Blogs</h1>
		  <a  href="{{route('blog_post')}}" class="btn btn-warning float-right">New</a>

		  <div class="row mt-4">
		  	@if(empty($blog_post))
		  		<p class="card-text">Data not available.</p>
		  	@endif
		  	@foreach($blog_post as $post)
            
		  	 <?php
	                
	                $img  = explode(',',$post->image);
                ?>
             <div class="col-lg-3 col-md-4 col-12 blog-box mb-4">   
    		    <div class="card">
    		       @if(isset($post->image))
                    <img class="card-img-top" src="{{asset('images_blog_img')}}/{{$img[0]}}" alt="img..." >
                   @else
                    <img  class="card-img-top" src="{{asset('images_blog_img/1688636936.jpg')}}" alt="img..." >
                   @endif
    				  <div class="card-body">
    				    <h5 class="card-title">{{$post->title}}</h5>
    				    <p class="card-title">
    				     <?php
                            $givenTime = strtotime($post->created_at);
                            $currentTimestamp = time();
                            $timeDifference = $currentTimestamp - $givenTime;

                            $days = floor($timeDifference / (60 * 60 * 24));
                            $hours = floor(($timeDifference % (60 * 60 * 24)) / (60 * 60));
                            $minutes = floor(($timeDifference % (60 * 60)) / 60);
                            $seconds = $timeDifference % 60;

                            $timeAgo = "";
                                if ($days > 0) {
                                    if ($days == 1) {
                                        $timeAgo .= $days . " Day ago ";
                                    } else {
                                        $timeAgo .= $days . " Days ago ";
                                    }
                                } else {
                                    $timeAgo .= "Posted today";
                                }
                                
                                // if ($hours > 0) {
                                //     if ($hours == 1) {
                                //         $timeAgo .= $hours . " hr ";
                                //     } else {
                                //         $timeAgo .= $hours . " hrs ";
                                //     }
                                // }
                                // if ($minutes > 0) {
                                //     if ($minutes == 1) {
                                //         $timeAgo .= $minutes . " min ";
                                //     } else {
                                //         $timeAgo .= $minutes . " mins ";
                                //     }
                                // }
                                // $timeAgo .= $seconds . " sec ago";

                                echo $timeAgo;
                            ?>
                           </p>
    				    <!-- <p class="card-text">{!! $post->content !!}</p> -->
        				<div class="row">
                            <div class="col-md-12 px-3">
        						<a href="{{route('blogPostSingle',$post->slug)}}" class="btn btn-warning"><i class="fa fa-eye" aria-hidden="true"></i></a>
        				    	<a href="{{route('blog_post_edit',$post->slug)}}" class="btn btn-warning"><i class="far fa-edit"></i></a>  
        						<a href="#" data-link="{{route('blog_post_delete',$post->id)}}" id="del_my_blog" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>

                           <!--  </div>
                            <div class="col-md-6"> -->
                                <select class="form-control status_blog" id="status_blog" data-id="{{$post->id}}">
                                    <option {{ $post->status == 1 ? ' selected' : '' }} value="1">Publish</option>
                                    <option {{ $post->status == 0 ? ' selected' : '' }} value="0">Unpublish</option>
                                </select>
        					</div>
        				</div>
                      </div>
    				</div>
    			</div>
		     @endforeach
		  </div>

  <!-- Add more video cards as needed -->

</div> 
	<script type="text/javascript">
	$(document).on("click", "#del_my_blog", function(e) {
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

$(document).on("change", ".status_blog", function(e) {
      var status = $(this).val();
      var id = $(this).attr('data-id');
      // alert(id);
     var csrfToken = document.head.querySelector('meta[name="csrf-token"]').content; 
       // alert(csrfToken);
      $.ajax({
        type: 'POST',
        url: '{{route("update_blog.status")}}',
        headers: {
                'X-CSRF-TOKEN': csrfToken
            },
        data: {
          id: id, // Fix: use ":" instead of "="
          status: status, // Fix: use ":" instead of "="
        },
        success: function(data) {
            console.log(data);
            if(data.Post_success){
            toastr.options =
              {
                "closeButton" : true,
                "progressBar" : true
              }
              toastr.success(data.Post_success);
          }
        }
      });
    });
</script>

@endsection