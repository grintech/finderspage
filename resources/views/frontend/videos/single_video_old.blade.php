<?php use App\Models\UserAuth; ?>
@extends('layouts.frontlayout')
@section('content')
<?php
 //  $decode = json_decode($video->mension);
 // echo "<pre>";print_r($decode);die('developert');

$LikesTotal = 0;
$DislikesTotal = 0;

foreach ($likedVideo as $liked) {
    if ($liked->video_id == $video->id){
        if ($liked->likes == 1) {
            $LikesTotal++;
        } else {
            $DislikesTotal++;
        }
    }
}

  ?>
 <div class="parent">
<section class="video-listing">
	<div class="container">
		<div class="row justify-content-center main-video mx-auto my-5">
			<div class="col-lg-4 col-md-6 main-frame">
				<div class="single-video-box">
			        <div class="single-thumbnail-container">
				        <!-- <img class="single-thumbnail-image" src="{{asset('images_blog_img/1690956940_61-YsVpu0zL._SX466_.jpg')}}" alt="Video Thumbnail"> -->
				        <video class="single-thumbnail-video" controls loop>
				            <source src="{{asset('video_short')}}/{{$video->video}}" type="video/mp4">
				            Your browser does not support the video tag.
				        </video>
				    </div>
				    <div class="single-thumbnail-caption">
				    	<h6 class="mb-0">
				    		@foreach($users as $user)
				    			@if($user->id == $video->user_id)
				    		<img class="img-fluid rounded-circle" alt="image" height="40" width="40" src="{{asset('assets/images/profile')}}/{{$user->image}}">
				    			@endif
				    		@endforeach
				    		{{$video->title}}</h6>
				    </div>
                </div>
                <div class="comment">
			  <!--       <button type="button" data-like-id="{{$video->id}}" login-id="{{UserAuth::getLoginId()}}" class="like-button social-thumb-icon 
			        	@foreach($likedVideo as $liked) 
			        		@if($liked->like_by == UserAuth::getLoginId() && $liked->likes == '1' && $liked->video_id == $video->id)
			        			liked
			        		@endif
			        	@endforeach"><i class="fas fa-thumbs-up"></i> <span>{{$LikesTotal}}</span></button>

                    <button type="button" data-dislike-id="{{$video->id}}" login-id="{{UserAuth::getLoginId()}}"  class="dislike-button social-thumb-icon 

                    	@foreach($likedVideo as $liked) 
			        		@if($liked->like_by == UserAuth::getLoginId() && $liked->likes == '0' && $liked->video_id == $video->id)
			        			disliked
			        		@endif
			        	@endforeach
			        	"><i class="fas fa-thumbs-down"></i> <span>{{$DislikesTotal}}</span></button -->
			        		 @if($video->user_id == UserAuth::getLoginId())
                    <button type="button" class="slide-toggle{{$video->id}} social-thumb-icon"><i class="far fa-comment-dots"></i> <span></span></button>
                    @endif 

                    <button type="button" class="social-thumb-icon social-share" id="toggle-share"><i class="fas fa-share"></i> <span>Share</span></button>
                   
					<div class="dropdown">
				        <button class="social-thumb-icon dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				            <i class="fas fa-ellipsis-h"></i>
				        </button>
				        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
				            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fas fa-grip-lines"></i> Description</a>

				            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#exampleModalmension"><i class="fas fa-at"></i> Mention</a>

				            <a class="dropdown-item videoSave" data-id="{{$video->id}}" href="#"><i class="fas fa-plus"></i> Save Video</a>
				        </div>
				    </div>
			    </div>
                <div id="content-share-icons" class="is-hidden">
                	<ul class="share-buttons-icons">
                        <li><a href="#" class="i1" title="Share on Email" rel="nofollow" target="_blank"><i class="fa fa-envelope"></i></a></li>
                        <li><a href="#" class="i2" title="Share on Facebook" rel="nofollow" target="_blank"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#" class="i3" title="Share on Twitter" rel="nofollow" target="_blank"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#" class="i4" title="Share on LinkedIn" rel="nofollow" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                        <li><a href="#" class="i5" title="Share on Pinterest" rel="nofollow" target="_blank"><i class="fa fa-pinterest-p"></i></a></li>
                        <li><a href="#" class="i6" title="Share on WhatsApp" rel="nofollow" target="_blank"><i class="fa fa-whatsapp"></i></a></li>
                    </ul>
                </div>
			    
			</div>
			<div class="col-lg-4 col-md-6 comments-video{{$video->id}} show-comments">
				<div class="comments-header">
					<h5>Comments <small>310</small></h5>
					<button type="button" class="slide-toggle{{$video->id}} social-thumb-icon"><i class="fas fa-close"></i></button>
				</div>
				<div class="comments-box">
					<ul class="list-unstyled">

						@foreach($vidcomments as $comm) 
			        		@if($comm->user_id == UserAuth::getLoginId() && $comm->video_id == $video->id)
			        	<li>
			        		@foreach($users as $user)
				    			@if($user->id == $video->user_id)
					    		<div class="img-icon">
									<img class="img-fluid rounded-circle" alt="image" height="40" width="40" src="{{asset('assets/images/profile')}}/{{$user->image}}">
								</div>
								<div class="comments-area">
								<h6>{{$user->first_name}}</h6>
								<p>{{$comm->comment}}</p>
							</div>
				    			@endif
				    		@endforeach
					    </li>
			        		@endif
			        	@endforeach
					</ul>
				</div>
				<div class="add-comments">
					<input type="text" id="comment-input" placeholder="Add Comment" name="add_comment">
					<button class="btn btn-warning" vid-id="{{$video->id}}" userid="{{UserAuth::getLoginId()}}" id="sendbtn">Send</button>
				</div>
			</div>
		</div>
	</div>
</section>


@foreach($new_video as $new_vid)
<?php
  // echo "<pre>";print_r($likedVideo);die('developert');

$totalLikes = 0;
$totalDislikes = 0;

foreach ($likedVideo as $liked) {
    if ($liked->video_id == $new_vid->id) {
        if ($liked->likes == 1) {
            $totalLikes++;
        } else {
            $totalDislikes++;
        }
    }
}

  ?>
	@if($video->id != $new_vid->id)

<section class="video-listing">
	<div class="container">
		<div class="row justify-content-center main-video mx-auto my-5">
			<div class="col-lg-4 col-md-6 main-frame">
				<div class="single-video-box">
			        <div class="single-thumbnail-container">
				        <!-- <img class="single-thumbnail-image" src="{{asset('images_blog_img/1690956940_61-YsVpu0zL._SX466_.jpg')}}" alt="Video Thumbnail"> -->
				        <video class="single-thumbnail-video" id="newVideo"  controls loop>
				            <source src="{{asset('video_short')}}/{{$new_vid->video}}" type="video/mp4">
				            Your browser does not support the video tag.
				        </video>
				    </div>
				    <div class="single-thumbnail-caption">
				    	<h6 class="mb-0">
				    		@foreach($users as $user)
				    			@if($user->id == $new_vid->user_id)
				    		<img class="img-fluid rounded-circle" alt="image" height="40" width="40" src="{{asset('assets/images/profile')}}/{{$user->image}}">
				    			@endif
				    		@endforeach

				    		{{$new_vid->title}}</h6>
				    </div>
                </div>
                <div class="comment">
			<!--         <button type="button" data-like-id="{{$new_vid->id}}" login-id="{{UserAuth::getLoginId()}}" class="like-button social-thumb-icon

			        	@foreach($likedVideo as $liked) 
			        		@if($liked->like_by == UserAuth::getLoginId() && $liked->likes == '1' && $liked->video_id == $new_vid->id)
			        			liked
			        		@endif
			        	@endforeach

			        	"><i class="fas fa-thumbs-up"></i> <span>
			        		{{$totalLikes}}
			        		</span></button>

                    <button type="button" data-dislike-id="{{$new_vid->id}}" login-id="{{UserAuth::getLoginId()}}" class="dislike-button social-thumb-icon
                    	@foreach($likedVideo as $liked) 
			        		@if($liked->like_by == UserAuth::getLoginId() && $liked->likes == '0' && $liked->video_id == $new_vid->id)
			        			disliked
			        		@endif
			        	@endforeach
                    	"><i class="fas fa-thumbs-down"></i> <span>{{$totalDislikes}}</span></button> -->
                    <!-- @if($new_vid->user_id == UserAuth::getLoginId()) -->
                    <button type="button" class="slide-toggle{{$new_vid->id}} social-thumb-icon"><i class="far fa-comment-dots"></i> <span></span></button>
                    <!-- @endif -->
                     <button type="button" class="social-thumb-icon social-share" id="toggle-share1"><i class="fas fa-share"></i> <span>Share</span></button> 
					<div class="dropdown">
				        <button class="social-thumb-icon dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				            <i class="fas fa-ellipsis-h"></i>
				        </button>
				        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
				            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#exampleModal{{$new_vid->id}}"><i class="fas fa-grip-lines"></i> Description</a>

				            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#exampleModalmen{{$new_vid->id}}"><i class="fas fa-at"></i>&nbsp;Mention</a>

				            <a class="dropdown-item videoSave" data-id="{{$video->id}}" href="#"><i class="fas fa-plus"></i> Save Video</a>
				        </div>
				    </div>

					<div class="download-button" data-video-id="{{ $new_vid->id }}" data-video-url="{{asset('video_short')}}/{{$new_vid->video}}">
						<button id="download-video">
							<i class="fas fa-download"></i>
						</button>
					</div>




			    </div>
                <div id="content-share-icons1" class="is-hidden">
                	<ul class="share-buttons-icons">
                        <li><a href="#" class="i1" title="Share on Email" rel="nofollow" target="_blank"><i class="fa fa-envelope"></i></a></li>
                        <li><a href="#" class="i2" title="Share on Facebook" rel="nofollow" target="_blank"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#" class="i3" title="Share on Twitter" rel="nofollow" target="_blank"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#" class="i4" title="Share on LinkedIn" rel="nofollow" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                        <li><a href="#" class="i5" title="Share on Pinterest" rel="nofollow" target="_blank"><i class="fa fa-pinterest-p"></i></a></li>
                        <li><a href="#" class="i6" title="Share on WhatsApp" rel="nofollow" target="_blank"><i class="fa fa-whatsapp"></i></a></li>
                    </ul>
                </div>
			    
			</div>
			<div class="col-lg-4 col-md-6 comments-video{{$new_vid->id}} show-comments">
				<div class="comments-header">
					<h5>Comments <small>310</small></h5>
					<button type="button" class="slide-toggle{{$new_vid->id}} social-thumb-icon"><i class="fas fa-close"></i></button>
				</div>
				<div class="comments-box">
					<ul class="list-unstyled">
						@foreach($vidcomments as $comm) 
			        		@if($comm->user_id == UserAuth::getLoginId() && $comm->video_id == $new_vid->id)
			        	<li>
			        		@foreach($users as $user)
				    			@if($user->id == $new_vid->user_id)
					    		<div class="img-icon">
									<img class="img-fluid rounded-circle" alt="image" height="40" width="40" src="{{asset('assets/images/profile')}}/{{$user->image}}">
								</div>
								<div class="comments-area">
								<h6>{{$user->first_name}}</h6>
								<p>{{$comm->comment}}</p>
							</div>
				    			@endif
				    		@endforeach
					    </li>
			        		@endif
			        	@endforeach
					</ul>
				</div>
				<div class="add-comments">
					<input type="text"  class="comment-input" placeholder="Add Comment" name="add_comment">
					<button class="btn btn-warning sendbtn" vid-id="{{$new_vid->id}}" userid="{{UserAuth::getLoginId()}}" id="sendbtn">Send</button>
				</div>
			</div>
		</div>
	</div>
</section>

<div
 class="modal desc-modal fade" id="exampleModal{{$new_vid->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header py-0">
        <h5 class="modal-title" id="exampleModalLabel}">Description</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       <div class="comments-box">
       	<div class="comments-area1">
			
			<p>{{$new_vid->description}}</p>
		</div>
		</div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal desc-modal fade" id="exampleModalmen{{$new_vid->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header py-0">
        <h5 class="modal-title" id="exampleModalLabel">Mensioned Member</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       <div class="comments-box">
       	<div class="comments-area1">
			
			<?php
				$decode = json_decode($new_vid->mension);

				// Check if decoding was successful
				if ($decode !== null) {
				    foreach ($decode as $Men_user) {
				        foreach ($users as $user) {
				            if ($user->username == $Men_user) {
				                echo "<div class=\"frame1\"><div class=\"img-icon1\">
				                        <img class=\"img-fluid rounded-circle\" alt=\"image\" height=\"40\" width=\"40\" src=\"" . asset('assets/images/profile') . "/" . $user->image . "\">
				                    </div>
				                    <div class=\"comments-area2\">
				                        <h6>{$user->username}</h6>
				                    </div></div>";
				            }
				        }
				    }
				}
				?>
		</div>
		</div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
	 $(document).ready(function(){
        $(".comments-video{{$new_vid->id}}").hide();
        $(".slide-toggle{{$new_vid->id}}").click(function(){
            $(".comments-video{{$new_vid->id}}").animate({
                width: "toggle"
            });
        });
    });
</script>


	@endif
@endforeach 
<script type="text/javascript">
			var vidId = "{{$new_vid->id}}";
    	const elToggle  = document.querySelector("#toggle-share");
		const elContent = document.querySelector("#content-share-icons");

		elToggle.addEventListener("click", () => {
		  elContent.classList.toggle("is-hidden");
		});
    </script>

</div>     
<!-- Modal -->
<div class="modal desc-modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header py-0">
        <h5 class="modal-title" id="exampleModalLabel">Description</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       <div class="comments-box">
       	<div class="comments-area1">
			
			<p>{{$video->description}}</p>
		</div>
		</div>
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal desc-modal fade" id="exampleModalmension" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header py-0">
        <h5 class="modal-title" id="exampleModalLabel">Description</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       <div class="comments-box">
       	<div class="comments-area1">
       	<?php
					$decode = json_decode($video->mension);

					// Check if decoding was successful
					if ($decode !== null) {
					    foreach ($decode as $Men_user) {
					        foreach ($users as $user) {
					            if ($user->username == $Men_user) {

					                echo "<div class=\"frame1\"><div class=\"img-icon1\">
					                        <img class=\"img-fluid rounded-circle\" alt=\"image\" height=\"40\" width=\"40\" src=\"" . asset('assets/images/profile') . "/" . $user->image . "\">
					                    </div>
					                    <div class=\"comments-area2\">
					                        <h6>{$user->username}</h6>
					                    </div></div>";
					            }
					        }
					    }
					}
				?>
		</div>
		</div>
      </div>
    </div>
  </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
	 $(document).ready(function(){
        $(".comments-video{{$video->id}}").hide();
        $(".slide-toggle{{$video->id}}").click(function(){
            $(".comments-video{{$video->id}}").animate({
                width: "toggle"
            });
        });
    });
</script>

 <script>
        // JavaScript code to handle like and dislike button clicks
        const likeButtons = document.querySelectorAll('.like-button');
        const dislikeButtons = document.querySelectorAll('.dislike-button');

        likeButtons.forEach(button => {
            button.addEventListener('click', () => {
                button.classList.toggle('liked');
                const sibling = button.nextElementSibling;
                if (sibling && sibling.classList.contains('disliked')) {
                    sibling.classList.remove('disliked');
                }
            });
        });

        dislikeButtons.forEach(button => {
            button.addEventListener('click', () => {
                button.classList.toggle('disliked');
                const sibling = button.previousElementSibling;
                if (sibling && sibling.classList.contains('liked')) {
                    sibling.classList.remove('liked');
                }
            });
        });
    </script>

    <script type="text/javascript">
    	const elToggle  = document.querySelector("#toggle-share");
		const elContent = document.querySelector("#content-share-icons");

		elToggle.addEventListener("click", () => {
		  elContent.classList.toggle("is-hidden");
		});
    </script>

    <script>
         $(document).ready(function () {
            // Add a click event handler to the dropdown toggle button
            $('.dropdown-toggle').click(function () {
                // Toggle the dropdown menu when the button is clicked
                $(this).next('.dropdown-menu').toggle();
            });

            // Close the dropdown menu when clicking outside of it
            $(document).click(function (e) {
                var container = $(".dropdown");
                if (!container.is(e.target) && container.has(e.target).length === 0) {
                    $(".dropdown-menu").hide();
                }
            });
        });






 		$(document).ready(function () {
            $('.like-button').click(function () {
            	var id = $(this).attr('data-like-id');
            	var login_id = $(this).attr('login-id');
            	 var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                $.ajax({
                    url: site_url+'/like_video',
                    type: 'POST',
                    headers: {
                      'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        id:id,
                        login_id:login_id
                    },
                    success: function(response) {
                      console.log(response);
                       
                    },
                    error: function(xhr, status, error) {
                      console.log(xhr);
                    }
                  });
            });


            $('.dislike-button').click(function () {
            	var id = $(this).attr('data-dislike-id');
            	var login_id = $(this).attr('login-id');
            	 var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                $.ajax({
                    url: site_url+'/dislike_video',
                    type: 'POST',
                    headers: {
                      'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                      id:id,
                      login_id:login_id,
                    },
                    success: function(response){
                      console.log(response);
                    },
                    error: function(xhr, status, error) {
                      console.log(response);
                    }
                  });
            });




            $('.sendbtn').click(function () {
            	var userid = $(this).attr('userid');
            	var video_id = $(this).attr('vid-id');
            	var comment = $('.comment-input').val();
            	
            	 var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                $.ajax({
                    url: site_url+'/video_comment',
                    type: 'POST',
                    headers: {
                      'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                      userid:userid,
                      video_id:video_id,
                      comment:comment,
                    },
                    success: function(response){
                      console.log(response);
                      window.location.reload()
                    },
                    error: function(xhr, status, error) {
                      console.log(response);
                    }
                  });
            });



             $('.videoSave').click(function () {
            	
            	var video_id = $(this).attr('data-id');
            	 var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                $.ajax({
                    url: site_url+'/video_save',
                    type: 'POST',
                    headers: {
                      'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                      video_id:video_id
                    },
                    success: function(response){
                      console.log(response);
                      
                    },
                    error: function(xhr, status, error) {
                      console.log(response);
                    }
                  });
            });


			$('.download-button').click(function() {
			// Get the data-video-id attribute from the clicked download button
			 var videoId = $(this).data('video-id');
			 var videoUrl = $(this).data('video-url');
			 var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

			 
				// Send the data to the Laravel controller via AJAX
				// $.ajax({
				// 	url: '/process-video', // The Laravel route URL
				// 	type: 'POST',
				// 	headers: {
                //       'X-CSRF-TOKEN': csrfToken
                //     },
				// 	data: {
				// 		video_id: videoId,
				// 		video_url: videoUrl
				// 	},
				// 	success: function(response) {
				// 		// Handle the response from the server
				// 		console.log(response.message);

				// 		// Create a download link for the processed video URL
				// 		var downloadLink = document.createElement('a');
				// 		downloadLink.href = response.video_url; // Assuming the Laravel controller returns the processed video URL
				// 		downloadLink.download = 'processed_video.mp4'; // You can customize the filename
				// 		downloadLink.style.display = 'none';
				// 		document.body.appendChild(downloadLink);
				// 		downloadLink.click();
				// 		document.body.removeChild(downloadLink);
				// 	},
				// 	error: function(xhr, status, error) {
				// 		// Handle any errors here
				// 		console.error(error);
				// 	}

				// });

			});
			
        });




</script>

@endsection