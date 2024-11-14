@extends('layouts.user_dashboard.userdashboardlayout')
@section('content')
<?php  
use Carbon\Carbon; 
use App\Models\UserAuth;
$userData = UserAuth::getLoginUser();
// dd($userData);
// dd($blog_post);
?>
<style type="text/css">
/*    .card-body p {
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
}*/
/*.blog-box .card{padding: 5px; height: 350px;}
.blog-box .card-body p {display: -webkit-inline-box;-webkit-line-clamp: 2;-webkit-box-orient: vertical;overflow: hidden;clear: both; margin-bottom: 0;font-size: 14px;}
.blog-box .card-body {background: #fff;border-radius: 20px;display:block; padding: 10px;}
.blog-box .card-body h5.card-title {display: -webkit-inline-box;-webkit-line-clamp: 2;-webkit-box-orient: vertical;overflow: hidden;height:46px;font-size: 16px !important;color: #000 !important;font-weight: 600;padding: 5px 0px;font-family: 'Poppins', sans-serif;text-transform: capitalize!important;    }
.blog-box .card-body p.card-title{font-size: 14px;display: block;}
.blog-box .card-title {margin-bottom: 0;}
.blog-box .card-img-top{height:200px; object-fit: cover;}
a.btn.blog-read-button {background: rgb(170, 137, 65);
background: linear-gradient(90deg, rgba(170, 137, 65, 1) 0%, rgba(205, 156, 49, 1) 13%, rgba(154, 128, 73, 1) 35%, rgba(246, 204, 78, 1) 51%, rgba(181, 147, 56, 1) 75%, rgba(163, 136, 68, 1) 100%);height: 30px;margin-top: 10px;border-radius: 35px;border: 0px;box-shadow: none;line-height: 17px;color: #000 !important;font-size: 14px;}*/

</style>
<div class="container pt-2">
		  <h1 class="mt-5 d-inline">Your Blogs</h1>
          <a  href="{{route('blog.add')}}" class="btn btn-warning float-right">New</a>
          <span>
            @include('admin.partials.flash_messages')
        </span>

        <div class="py-3 dash_highlight">
          <div class="alert alert-info " role="alert">
          To highlight your content to the top of the search results, simply click the <span>feature</span> or <span>bump</span> button.
          </div>
        </div>
		  

		  <div class="row mt-4">
		  	@if(empty($blog_post))
		  		<p class="card-text">Data not available.</p>
		  	@endif
		  	@foreach($blog_post as $post)
		  	 <?php
	                
	                $img  = explode(',',$post->image);
                ?>
             <div class="col-lg-3 col-md-4 col-12 blog-box  mb-4">   
    		    <div class="card">

                     @if($post->featured_post=="on")
                        <div class="ribbon bump-ribbon" data-toggle="tooltip" data-placement="top">
                          <div class="text-div">
                            Featured
                          </div>
                        </div>
                        @endif

                        @if($post->draft=='0')
                         <div class="ribbon" data-toggle="tooltip" data-placement="top" title="Please edit this draft if you wish to proceed to get published.">
                          <div class="text-div">
                            Draft
                          </div>
                        </div>
                        @endif
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
                                        $timeAgo .= $days . " day ago";
                                    } else {
                                        $timeAgo .= $days . " days ago";
                                    }
                                }else { $timeAgo .= " Posted today ";}

                                // if ($hours > 0) {
                                //     $timeAgo .= $hours . " hr ";
                                // }
                                // if ($minutes > 0) {
                                //     $timeAgo .= $minutes . " min ";
                                // }
                                // $timeAgo .= $seconds . " sec ago";

                                echo $timeAgo;
                            ?>
                           </p>
    				    <!-- <p class="card-text">{!! $post->content !!}</p> -->
    				    <div class="col-md-12 px-0 pt-2 pb-3">
    						<a href="{{route('blogPostSingle',['slug' => $post->slug ])}}" class="btn btn-primary"><i class="fa fa-eye  " aria-hidden="true"></i></a>
                           
                        @if($userData->subscribedPlan != '7-day-14' && $userData->subscribedPlan != '1-month-55' && !empty($userData->subscribedPlan ))
                           
    				    	<a href="{{route('blog.edit',$post->slug)}}" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Edit"><i class="far fa-edit"></i></a>
                           
                       
                         <!--else section <a href="{{route('pricing')}}" class="btn btn-warning" style="" data-toggle="tooltip" data-placement="top" title="Edit this blog you have to upgrade your plan" ><i class="far fa-edit"></i></a> -->
                         @else
                         <a href="{{route('blog.edit',$post->slug)}}" class="btn btn-warning" style="" ><i class="far fa-edit"></i></a>

                         
                        @endif

                        <!-- <a data-toggle="modal" data-target="#exampleModal_hours" href="#" Data_id="{{$post->id}}" class="btn btn-warning Edit_Image_location" style="" ><i class="far fa-edit"></i></a> -->
                            
    						<a href="#" data-link="{{route('blogpost.delete',$post->id)}}" id="del_my_blog" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            @if($post->bumpPost=="1")
                             <a href="#" data-toggle="tooltip" data-placement="top" title="this blog is already bumped"  class="btn btn-primary">Bumped</a>
                            @elseif ($userData->review=="1" && $userData->free_bump=="1")
                            <a data-toggle="tooltip" data-placement="top" title="You have a free bump" href="{{route('bump.success.business',$post->id)}}" class="btn btn-primary">Bump</a>
                            @elseif ($userData->bump_post_count > 0 || $userData->bump_post_count == 'Unlimited')
                              <a data-toggle="tooltip" data-placement="top" title="You have an {{$userData->bump_post_count}} subscription plan" href="{{route('bump.post_count.success.blogs',$post->id)}}" class="btn btn-primary">Bump</a>
                            @elseif (!empty($userData->subscribedPlan) || $userData->bump_post_count <= 0 )
                              <a data-toggle="tooltip" data-placement="top" title="You've used up all your free bump posts from your subscription plan" href="{{route('pay.auth.bump',General::encrypt($post->id))}}"  class="btn btn-primary">Bump</a>
                            @else
                            <a data-toggle="tooltip" data-placement="top" title="$5.08 to bump this blog" href="{{route('pay.auth.bump',General::encrypt($post->id))}}"  class="btn btn-primary">Bump</a>
                            @endif
                           <!--  <a data-toggle="tooltip" data-placement="top" title="$3 to bump this blog" href="{{route('pay.auth.bump',General::encrypt($post->id))}}"  class="btn btn-primary">Bump</a>-->

                           @if($post->featured_post=="on")
                              <a href="#" data-toggle="tooltip" data-placement="top" title="This blog is already Featured"  class="btn btn-primary">Featured</a>
                            @elseif ($userData->featured_post_count > 0 || $userData->featured_post_count == 'Unlimited')
                            <a data-toggle="tooltip" data-placement="top" title="You have an {{$userData->featured_post_count}} subscription plan" href="{{route('featured.post_count.success.blog',$post->id)}}" class="btn btn-primary">Feature</a>
                            @else
                              <a data-toggle="tooltip" data-placement="top" title="Get featured! Starting at just ${{$plan_month->price}} for one month." href="{{route('paypal.featured_post.blogs', ['post_id' => General::encrypt($post->id)])}}" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Bump">Feature</i></a>
                           @endif
    					</div> 
    				  </div>
    				</div>
    			</div>
		     @endforeach
		  </div>

  <!-- Add more video cards as needed -->

</div> 


<!-- Modal -->
<!-- <div class="modal fade" id="exampleModal_hours" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="dataLocation">
            <div id="dataLocation"></div>
      </div>
      <div class="modal-footer">
        
      </div>
    </div>
  </div>
</div> -->
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
                      'Your blog has been deleted.',
                      'success'
                    )
            }
        });
    });

    $(document).ready(function(){
          $('[data-toggle="tooltip"]').tooltip();   
        });



    $(".add-profile").on("click", function() {
        var blog_id = $(this).attr('data-link');
        //alert("this is country id "+country_id);
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        $.ajax({
            url: baseurl+'/pin-to-profile',
            type: 'POST',
            headers: {
            'X-CSRF-TOKEN': csrfToken
            },
            data: {
                blog_id: blog_id
                
            },
            success: function(response) {
            console.log(response);
            toastr.success(response[1]);
               
            },
            error: function(xhr, status, error) {
            console.log(xhr.responseText);
            toastr.error(response.error);
            }
        });
    });



    $(".Edit_Image_location").on("click", function() {
        var blog_id = $(this).attr('Data_id');
        //alert("this is country id "+country_id);
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        $.ajax({
            url: baseurl+'/get_blog_image_location',
            type: 'POST',
            dataType: 'json',
            headers: {
            'X-CSRF-TOKEN': csrfToken
            },
            data: {
                blog_id: blog_id
                
            },
            success: function(response) {
            console.log(response);
                $('#dataLocation').html(response.html);
               
            },
            error: function(xhr, status, error) {
            console.log(xhr.responseText);
            toastr.error(response.error);
            }
        });
    });
</script>

@endsection