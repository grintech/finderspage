<?php 

foreach($listing->items() as $k => $row):
  // echo "<pre>"; print_r($row );die();
	?>



	<?php   

$cate_names = Arr::pluck($row->categories, 'title');

$cate_id = Arr::pluck($row->categories, 'id');
//  echo $cate_id['0'];
// echo "<pre>"; print_r($cate_id);die();


	?>

<tr>

	<td>

		<span class="badge badge-dot mr-4">

			<i class="bg-warning"></i>

			<span class="status"><?php echo $row->id ?></span>

		</span>

	</td>

	<td>

		<div class="media align-items-center">

        	<a href="#" class="avatar rounded-circle mr-3">

	          <!-- <img src="{{url('/')}}<?php echo @$row->getOneResizeImagesAttribute()['original'] ?>"> -->
	          <!-- <img src="{{asset('images_blog_img')}}/{{$row->image1}}" alt="img..."> -->
	           <?php
	                $neimg = trim($row->image1,'[""]');
	                $img  = explode('","',$neimg);
                ?>
                @if(isset($row->image1) && $row->image1 != null)
                 <img src="{{asset('images_blog_img')}}/{{$img[0]}}" alt="img..." >
               @else
               <img src="{{asset('images_blog_img/1688636936.jpg')}}" alt="img..." >
               @endif
                

	        </a>

	        <div class="media-body">

	          <span class="name mb-0 text-sm"><?php echo $row->title ?></span>

	        </div>

      	</div>

	</td>

	<td>

		<?php echo isset($cate_names[0]) ? $cate_names[0] : ''; ?>

	</td>

	<!-- <td>

		<?php
		  echo $row->owner_first_name . ' ' . $row->owner_last_name 
		
		?>
		

	</td> -->

	<td>

		<?php
		 
		if($row->bumpPost =="1"){echo"Bump Post";}elseif($row->featured_post=="on"){echo"Featured Post";}else{echo"Normal Post";}
		?>
		

	</td>

	<td>

		<div class="custom-control">

			<select name="status" data_id="<?php echo $row->id; ?>" cate-id="@if(isset($cate_id[0]) && in_array($cate_id[0], [2, 4, 5, 6, 705,7])) 
				{{ $cate_id[0] }} 
			@endif" class="status_change">
				
				<option value="1" @if($row->status == 1) selected @endif>Publish</option>
				<option value="0" @if($row->status == 0) selected @endif>Unpublish</option>
			</select>
					

			<!-- <label class="custom-toggle" style="width: 112px !important;">

				<?php $switchUrl =  route('admin.actions.switchUpdate', ['relation' => 'blogs', 'field' => 'status', 'id' => $row->id]); ?>

				<input type="checkbox" name="status" onchange="switch_action('<?php echo $switchUrl ?>', this)" value="1" <?php echo ($row->status ? 'checked' : '') ?>>

				<span class="custom-toggle-slider rounded-circle" data-label-off="UNPUBLISHED" data-label-on="PUBLISHED"></span>

			</label> -->

		</div>

	</td>

	<td>

		<?php echo _dt($row->created) ?>

	</td>

	<td class="text-right">

		<div class="dropdown">

			

			<a class="btn btn-sm btn-icon-only text-warning" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

				<i class="fas fa-ellipsis-v"></i>

			</a>

			<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">


				@if(isset($cate_id[0]) && $cate_id[0] == '2')
				<a target="blank" class="dropdown-item" href="<?php echo route('jobpost',$row->slug) ?>">

					<i class="fas fa-eye text-yellow"></i>

					<span class="status">View</span>

				</a>
				@elseif(isset($cate_id[0]) && $cate_id[0] == '4')
				<a target="blank" class="dropdown-item" href="<?php echo route('real_esate_post',$row->slug) ?>">

					<i class="fas fa-eye text-yellow"></i>

					<span class="status">View</span>

				</a>
				@elseif(isset($cate_id[0]) && $cate_id[0] == '5')
				<a target="blank" class="dropdown-item" href="<?php echo route('community_single_post',$row->slug) ?>">

					<i class="fas fa-eye text-yellow"></i>

					<span class="status">View</span>

				</a>
				@elseif(isset($cate_id[0]) && $cate_id[0] == '6')
				<a target="blank" class="dropdown-item" href="<?php echo route('shopping_post_single',$row->slug) ?>">

					<i class="fas fa-eye text-yellow"></i>

					<span class="status">View</span>

				</a>

				<a target="blank" class="dropdown-item" href="<?php echo route('blog.admin.review',$row->id) ?>">

				<i class="fa-regular fa-star text-yellow"></i>

					<span class="status">Review</span>

				</a>

				@elseif(isset($cate_id[0]) && $cate_id[0] == '705')
				<a target="blank" class="dropdown-item" href="<?php echo route('service_single',$row->slug) ?>">

					<i class="fas fa-eye text-yellow"></i>

					<span class="status">View</span>

				</a>

				@elseif(isset($cate_id[0]) && $cate_id[0] == '725')
				<a target="blank" class="dropdown-item" href="<?php echo route('event_single', ['id' => $row->id]) ?>">

					<i class="fas fa-eye text-yellow"></i>

					<span class="status">View</span>

				</a>
				@endif

				<?php if(Permissions::hasPermission('blogs', 'update')): ?>

					<div class="dropdown-divider"></div>
					@if(isset($cate_id[0]) && $cate_id[0] == '2')
					<a class="dropdown-item" href="<?php echo route('admin.blogs.edit', ['id' => $row->id]) ?>">

					<i class="fa-solid fa-pencil"></i>

						<span class="status">Edit</span>

					</a>
					@elseif(isset($cate_id[0]) && $cate_id[0] == '4')
					<a class="dropdown-item" href="<?php echo route('admin.realestate.edit', ['id' => $row->id]) ?>">

						<i class="fa-solid fa-pencil"></i>

						<span class="status">Edit</span>

					</a>
					@elseif(isset($cate_id[0]) && $cate_id[0] == '5')
					<a class="dropdown-item" href="<?php echo route('admin.blogs.edit', ['id' => $row->id]) ?>">

					<i class="fa-solid fa-pencil"></i>

						<span class="status">Edit</span>

					</a>
					@elseif(isset($cate_id[0]) && $cate_id[0] == '6')
					<a class="dropdown-item" href="<?php echo route('shopping.edit', ['id' => $row->id]) ?>">

					<i class="fa-solid fa-pencil"></i>

						<span class="status">Edit</span>

					</a>
					@elseif(isset($cate_id[0]) && $cate_id[0] == '705')
					<a class="dropdown-item" href="<?php echo route('service.edit', ['id' => $row->id]) ?>">

					<i class="fa-solid fa-pencil"></i>

						<span class="status">Edit</span>

					</a>

					@elseif(isset($cate_id[0]) && $cate_id[0] == '725')
					<a class="dropdown-item" href="<?php echo route('editEvent', ['id' => $row->id]) ?>">

						<i class="fa-solid fa-pencil"></i>

						<span class="status">Edit</span>

					</a>

					@elseif(isset($cate_id[0]) && $cate_id[0] == '7')
					<a target="blank" class="dropdown-item" href="<?php echo route('single.fundraisers',$row->slug) ?>">

						<i class="fas fa-eye text-yellow"></i>

						<span class="status">View</span>

					</a>
					@endif


				<?php endif; ?>

				<?php if(Permissions::hasPermission('blogs', 'delete')): ?>

					<div class="dropdown-divider"></div>

					<a 

						class="dropdown-item _delete"

						id="blog_delete"

						data-link="<?php echo route('admin.blogs.delete', ['id' => $row->id]) ?>"

					>

						<i class="fas fa-times text-danger"></i>

						<span class="status text-danger ">Delete</span>

					</a>

				<?php endif; ?>

			</div>

		</div>

	</td>

</tr>

<?php endforeach; ?>
<script>
    $(document).on("click", "#blog_delete", function(e) {
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

    
	$(".status_change").change(function() {
	 var status = $(this).val();
	 var id = $(this).attr('data_id');
	 var cateID = $(this).attr('cate-id');
	 var csrfToken = document.head.querySelector('meta[name="csrf-token"]').content; 
	   // alert(csrfToken);
	  $.ajax({
	    type: 'POST',
	    url: '{{route('updatestatus')}}',
	    headers: {
                'X-CSRF-TOKEN': csrfToken
            },
	    data: {
	      id: id, // Fix: use ":" instead of "="
	      status: status, // Fix: use ":" instead of "="
	      cateID: cateID, // Fix: use ":" instead of "="
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

