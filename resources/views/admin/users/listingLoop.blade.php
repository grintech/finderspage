<?php foreach($listing->items() as $k => $row): ?>

<tr>

	<!-- <td>



		<div class="custom-control custom-checkbox">

			<input type="checkbox" class="custom-control-input listing_check" id="listing_check<?php echo $row->id ?>" value="<?php echo $row->id ?>">

			<label class="custom-control-label" for="listing_check<?php echo $row->id ?>"></label>

		</div>

	</td> -->

	<td>

		<span class="badge badge-dot mr-4">

			<i class="bg-warning"></i>

			<span class="status"><?php echo $row->id ?></span>

		</span>

		

	</td>

	<td>

		<a href="<?php echo route('user.users.view', ['id' => $row->id]) ?>" class="text-default"><?php echo $row->name ?></a>

	</td>

	<td>

		<a href="mailto:<?php echo $row->email ?>"><?php echo $row->email ?></a>

	</td>

	<td>

		@if($row->role == 'business')

		<span class="badge badge-success">Business</span>

		@else

		<span class="badge badge-danger">Individual</span>

		@endif

	</td>

	<!-- <td>

		<?php echo isset($row->last_login) &&$row->last_login ? _dt($row->last_login) : '' ?>

	</td> -->

	<td>

        <div class="custom-control">

			<label class="custom-toggle"  data-toggle="tooltip" data-placement="top" title="Use toggle to ban or unban user.">

				<?php $switchUrl =  route('user.switchUpdate', ['relation' => 'users', 'field' => 'status', 'id' => $row->id]); ?>

				<!-- <input type="checkbox" name="status" onchange="switch_action('<?php echo $switchUrl ?>', this)" value="1" <?php echo ($row->status ? 'checked' : '') ?>> -->

				<input type="checkbox" data-id="<?php echo $row->id;  ?>" name="status" value="1" <?php echo ($row->status ? 'checked' : '') ?> >

			<span class="custom-toggle-slider rounded-circle" data-label-off="OFF" data-label-on="ON"></span>

			</label>

		</div>

	</td>

	<td>

		<?php echo _dt($row->created) ?>

	</td>

	<td class="text-right">

		<?php if(Permissions::hasPermission('users', 'update') || Permissions::hasPermission('users', 'delete')): ?>

		<div class="dropdown">

			<a class="btn btn-sm btn-icon-only text-warning" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

				<i class="fas fa-ellipsis-v"></i>

			</a>

			<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">

				<a target="blank" class="dropdown-item" href="<?php echo route('user.users.view',$row->id) ?>">

					<i class="fas fa-eye text-yellow"></i>

					<span class="status">View</span>

				</a>

				<?php if(Permissions::hasPermission('users', 'update')): ?>

				<div class="dropdown-divider"></div>

				<a class="dropdown-item" href="<?php echo route('user.users.edit', ['id' => $row->id]) ?>">

					<i class="fas fa-pencil-alt text-info"></i>

					<span class="status">Edit</span>

				</a>

				<?php endif; ?>

				<?php if(Permissions::hasPermission('users', 'delete')): ?>

				<div class="dropdown-divider"></div>

				<a 

					class="dropdown-item _delete" 

					href="javascript:;"

					id="del_user"

					data-link="<?php echo route('user.users.delete', ['id' => $row->id]) ?>"

				>

					<i class="fas fa-times text-danger"></i>

					<span class="status text-danger" >Delete</span>

				</a>

				<?php endif; ?>


				<?php if(Permissions::hasPermission('users', 'delete')): ?>

				<div class="dropdown-divider"></div>

				<a 

					class="dropdown-item _delete" 

					href="javascript:;"

					id="del_user_permanent"

					data-link="<?php echo route('user.users.permanent.delete', ['id' => $row->id]) ?>"

				>

					<i class="fas fa-times text-danger"></i>

					<span class="status text-danger" >Permanent Delete</span>

				</a>

				<?php endif; ?>

			</div>

		</div>

		<?php endif; ?>

	</td>

</tr>

<?php endforeach; ?>

<script>
    $(document).on("click", "#del_user", function(e) {
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


    $(document).on("click", "#del_user_permanent", function(e) {
        e.preventDefault();
        var link = $(this).attr("data-link");
         Swal.fire({
            title: 'Delete',
            text: 'Are you sure you want to Permanent Delete?',
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


  		$(document).ready(function() {
         // var isChecked1 = $('input[name="status"]').is(':checked');
         //    console.log(isChecked1);
         //    if(isChecked1 == true){
         //    	var status = 1;
         //    }else{
         //    	var status = 0;
         //    }
         //     alert(status);


            
          $('input[name="status"]').on('click', function() {
            var isChecked = $(this).is(':checked');
            var id = $(this).attr('data-id');
            console.log(isChecked);
            if(isChecked == true){
            	var status = 1;
            }else{
            	var status = 0;
            }
            // alert(status);
            	 var csrfToken = document.head.querySelector('meta[name="csrf-token"]').content; 
             $.ajax({
                url: '{{route("user.ban")}}',
                type: 'POST',
                headers: {
                  'X-CSRF-TOKEN': csrfToken,
                },
                data: {
                    status:status,
                    id:id,
                },
                success: function(response){
                   console.log(response);
                    toastr.success(response.success);
                },
                error: function(xhr, status, error) {
                    toastr.success(response.error);
                }
              });

          });
        });
</script>

