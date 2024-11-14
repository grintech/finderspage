@extends('layouts.adminlayout')
@section('content')
<style type="text/css">
	/**{
    margin: 0px;
    padding: 0px;
    font-family: poppins;
    box-sizing: border-box;
}*/
a{
    text-decoration: none;
}
/*#testimonials{
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    width:100%;
}*/
/*.testimonial-heading{
    letter-spacing: 1px;
    margin: 30px 0px;
    padding: 10px 20px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}
 */
/*.testimonial-heading span{
    font-size: 1.3rem;
    color: #252525;
    margin-bottom: 10px;
    letter-spacing: 2px;
    text-transform: uppercase;
}*/
/*.testimonial-box-container{
    display: flex;
    justify-content: center;
    align-items: center;
    flex-wrap: wrap;
    width:100%;
}*/
.testimonial-heading{
    margin: 0px 0px 30px;
}
.testimonial-box{
    /* width:500px; */
    box-shadow: 2px 2px 30px rgba(0,0,0,0.1);
    background-color: #ffffff;
    padding: 20px;
    height: 100%;
/*    margin: 15px;*/
    /* cursor: pointer; */
}
.profile-img{
    width:50px;
    height: 50px;
    border-radius: 50%;
    overflow: hidden;
    margin-right: 10px;
}
.profile-img img{
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
}
.profile{
    display: flex;
    align-items: center;
}
.name-user{
    display: flex;
    flex-direction: column;
}
.name-user strong{
    color: #3d3d3d;
    font-size: 1.1rem;
    letter-spacing: 0.5px;
}
.name-user span{
    color: #979797;
    font-size: 0.8rem;
}
.reviews{
    color: #f9d71c;
}
.box-top{
   
    margin-bottom: 20px;
}
.client-comment p{
    font-size: 0.9rem;
    color: #4b4b4b;
}
.testimonial-box:hover{
    transform: translateY(-10px);
    transition: all ease 0.3s;
}
.select_div .btn{
    padding: .625rem .5rem !important;
    font-size: 13px !important;

}
.client-comment p{
    display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
 
.video-box video{width: 100%;} 

@media(max-width:790px){
   
    .testimonial-heading h1{
        font-size: 1.4rem;
    }
}
@media(max-width:340px){
    .box-top{
        flex-wrap: wrap;
        margin-bottom: 10px;
    }
    .reviews{
        margin-top: 10px;
    }
}
::selection{
    color: #ffffff;
    background-color: #252525;
}

</style>
    <body>
    	<section id="testimonials">
            <div class="container px-sm-5 px-4 pt-4">
                <!--heading--->
                <div class="testimonial-heading">
                    <h1 class="mt-5 d-inline">Reviews</h1>
                    <!-- <span>Reviews</span> -->
                </div>
                <!--testimonials-box-container------>
                <!-- <div class="testimonial-box-container"> -->
                <div class="row">
                	@foreach($reviews as $review)
                    <!--BOX-1-------------->
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12 mb-4">
                        <div class="testimonial-box">
                        <!--top------------------------->
                            <div class="box-top ">
                                <!--profile----->
                                <div class="profile">
                                    <!--img---->
                                    <div class="profile-img">
                                        <img src="{{asset('/assets/images/profile')}}/{{$review->image}}" />
                                    </div>
                                    <!--name-and-username-->
                                    <div class="name-user">
                                        <strong>{{$review->first_name}}</strong>
                                        <span>{{$review->email}}</span>
                                    </div>
                                </div>
                                <!--reviews------>
                                <div class="reviews" id="starRating">
                                    <?php

                                        for ($i = 1; $i <= 5; $i++) {
                                            if ($i <= $review->rating) {
                                                // Full star
                                                echo '<i class="fas fa-star"></i>';
                                            } else {
                                                // Empty star
                                                echo '<i class="far fa-star"></i>';
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                        <div class="video-box">
                            @if(isset($review->video))
                                <video controls>
                                    <source src="{{asset('review_video')}}/{{$review->video}}" type="video/mp4">
                                    <source src="movie.ogg" type="video/ogg">
                                    Your browser does not support the video tag.
                                </video>
                            @endif
                        </div>
                        <!--Comments---------------------------------------->
                        <div class="client-comment" type="button" data-toggle="modal" data-target="#exampleModal{{$review->id}}">
                             <p>{{$review->description}}</p>
                        </div>

                        <div class="select_div row flex-wrap">
                            <div class="col-8">
                				<select class="form-control status_review w-100" id="status_review" data-id="{{$review->id}}">
                                    <option  {{ $review->status == 1 ? ' selected' : '' }} value="1">Show</option>
                                    <option  {{ $review->status == 0 ? ' selected' : '' }} value="0">Hide</option>
                                </select>
                            </div>
                            <div class="col-3 text-right">
                               <a  href="#" data-link="{{route('review.delete', $review->id)}}" class="btn btn-danger delBtn_review">Delete</a>
                            </div>
                        </div>
                    </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal{{$review->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Review</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>{{$review->description}}</p>
                            </div>
                            
                            </div>
                        </div>
                    </div>


                       @endforeach
                </div>
                <!-- </div> -->
            </div>
        </section>
                        


    
      
        
  </body>
<script type="text/javascript">
	$(document).on("change", ".status_review", function(e) {
      var status = $(this).val();
      var id = $(this).attr('data-id');
      // alert(id);
     var csrfToken = document.head.querySelector('meta[name="csrf-token"]').content; 
       // alert(csrfToken);
      $.ajax({
        type: 'POST',
        url: '{{route("review.status")}}',
        headers: {
                'X-CSRF-TOKEN': csrfToken
            },
        data: {
          id: id, // Fix: use ":" instead of "="
          status: status, // Fix: use ":" instead of "="
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
          }
        }
      });
    });

    $(document).on("click", ".delBtn_review", function(e) {
        e.preventDefault();
        var link = $(this).attr("data-link");
        // alert(link);
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
              'Review has been deleted.',
              'success'
            )
          }
        });
      });
</script>
   

@endsection