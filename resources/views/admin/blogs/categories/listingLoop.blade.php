
<?php foreach($listing->items() as $k => $row): ?>

<tr>

	<td>

		<span class="badge badge-dot mr-4">

			<i class="bg-warning"></i>

			<span class="status"><?php echo $row->id ?></span>

		</span>

	</td>

	<td>
		<?php
			if($row->super_parent_id) {
				echo '<b>'.$row->super_parent_id. ' >'.'</b>';
			}	
		?>
		<?php echo $row->parent_title ? $row->parent_title : $row->title ?>

	</td>

	<td>

		<?php echo !$row->parent_title ? "" : $row->title ?>

	</td>

	<td>

		<?php echo $row->owner_first_name . ' ' . $row->owner_last_name ?>

	</td>

	<td>

		<?php echo _dt($row->created) ?>

	</td>

	<td class="text-right">

		<?php if(Permissions::hasPermission('blog_categories', 'update') || Permissions::hasPermission('blog_categories', 'delete')): ?>

			<div class="dropdown">

				<a class="btn btn-sm btn-icon-only text-warning" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

					<i class="fas fa-ellipsis-v"></i>

				</a>

				<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">

					<?php if(Permissions::hasPermission('blog_categories', 'update')): ?>

					<a class="dropdown-item" href="<?php echo route('admin.blogs.categories.edit', ['id' => $row->id]) ?>">

						<i class="fas fa-pencil-alt text-info"></i>

						<span class="status">Edit</span>

					</a>

					<?php endif; ?>

					

					<?php if(Permissions::hasPermission('blog_categories', 'delete')): ?>

					<div class="dropdown-divider"></div>

					<a 

						class="dropdown-item _delete" 

						id="deleteCate"

						data-link="<?php echo route('admin.blogs.categories.delete', ['id' => $row->id]) ?>"

					>

						<i class="fas fa-times text-danger"></i>

						<span class="status text-danger">Delete</span>

					</a>

					<?php endif; ?>

				</div>

			</div>

		<?php endif; ?>

	</td>

</tr>

<?php endforeach; ?>

<script>
    $(document).on("click", "#deleteCate", function(e) {
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