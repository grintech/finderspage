@extends('layouts.adminlayout')
@section('content')

<div class="container-fluid px-3 px-md-5 pt-4">
    <div class="row">
    	<div class="col">
		  <h1 class="mt-5 d-inline">Reported Post List</h1>

		  <div class="table-responsive mt-4">
		  	<table class="table">
			  <thead class="thead-dark">
			    <tr>
			      <th scope="col">#</th>
			      <th scope="col">post Id</th>
			      <th scope="col">Reason</th>
			      <th scope="col">Reported By</th>
			       <th scope="col">Action</th> 
			    </tr>
			  </thead>
			  <tbody>

			  	@if(empty($PostReport))
		  		<p class="card-text">Data not available.</p>
		  		@endif
		  		@foreach($PostReport as $post)
				@if (!empty($post->slug))
			    <tr>
			      <td>{{$loop->iteration}}</td>
			      <td>{{$post->post_id}}</td>
			      <td>
			      	<?php $reasons = explode(',', $post->reason); ?>
			      	@foreach($reasons  as $reason)
			      		{{$reason}} ,&nbsp;
			      	@endforeach
			      	
			      </td>
			      <td><?php $userName="";?>
			      	@foreach($users  as $user)
			      		@if($user->id == $post->reported_by)
			      		<?php 	$userName = $user->first_name; ?>
			      		@endif
			      	@endforeach
			      	{{$userName}}
			      </td>

			      @if($post->type === 'Blog_post')
			      	<td>
			      		<a href="{{route('blogPostSingle',$post->slug)}}"><i class="fa fa-eye" aria-hidden="true"></i></a> 

			      		<a data-link="{{route('delete.reported_post',$post->id)}}" class="del_my_data" href="#"><i class="fas fa-times text-dangers " aria-hidden="true"></i></a> 
			  		</td>
			      @elseif($post->type == 'post')
			      	@if($post->category_id == 2 )
				      <td>
				      	<a href="{{route('jobpost',$post->post_id)}}"><i class="fa fa-eye" aria-hidden="true"></i></a> 

				      	<a data-link="{{route('delete_services',$post->post_id)}}" class="del_my_data" href="#" ><i class="fas fa-times text-dangers " aria-hidden="true"></i></a> 
				      </td>
				    @endif
				    @if($post->category_id == 4)
				      <td>
				      	<a href="{{route('real_esate_post',$post->post_id)}}"><i class="fa fa-eye" aria-hidden="true"></i></a> 

				      	<a data-link="{{route('delete_services',$post->post_id)}}" class="del_my_data" href="#"><i class="fas fa-times text-dangers " aria-hidden="true"></i></a> 
				      </td>
				    @endif
				    @if($post->category_id == 5)
				     <td>
				      	<a href="{{route('community_single_post',$post->post_id)}}"><i class="fa fa-eye" aria-hidden="true"></i></a>

				      	<a data-link="{{route('delete_services',$post->post_id)}}" class="del_my_data" href="#"><i class="fas fa-times text-dangers " aria-hidden="true"></i></a> 
				  	</td>
				    @endif
				    @if($post->category_id == 6)
				      <td>

				      <a href="{{route('shopping_post_single',$post->post_id)}}"><i class="fa fa-eye" aria-hidden="true"></i></a> 

				      <a data-link="{{route('delete_services',$post->post_id)}}" class="del_my_data" href="#"><i class="fas fa-times text-dangers " aria-hidden="true"></i></a>

				      </td>
				    @endif
				    @if($post->category_id == 705)
				      <td><a href="{{route('service_single',$post->post_id)}}"><i class="fa fa-eye" aria-hidden="true"></i></a> 

				      <a data-link="{{route('delete_services',$post->post_id)}}" class="del_my_data" href="#"><i class="fas fa-times text-dangers 	" aria-hidden="true"></i></a>
				      </td>
				    @endif
			      @elseif($post->type == 'video')
			      <td>
			      	<a href="{{route('single.video',$post->post_id)}}"><i class="fa fa-eye" aria-hidden="true"></i></a> 

			      	<a data-link="{{route('single.video',$post->post_id)}}" class="del_my_data" href="#"><i class="fas fa-times text-dangers " aria-hidden="true"></i></a> 
			      </td>
			      @endif
			    </tr> 
				@endif
			    @endforeach
			  </tbody>
			</table>
		  	

		  	
		  </div>

  <!-- Add more video cards as needed -->
        </div>
    </div>
</div> 
	<script type="text/javascript">
	$(document).on("click", ".del_my_data", function(e) {
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
                      'Your file has been deleted.',
                      'success'
                    )
            }
        });
    });
</script>



@endsection