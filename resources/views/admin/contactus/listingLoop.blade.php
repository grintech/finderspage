<?php use Illuminate\Support\Str; ?>
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
		<?php echo $row->first_name; ?>
	</td>
	<td>
		<?php echo $row->last_name; ?>
	</td>
	<td>
		<a href="mailto:<?php echo $row->email; ?>"><?php echo $row->email; ?></a>
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
				<a class="dropdown-item" href="<?php echo route('admin.contactus.view', ['id' => $row->id]) ?>">
					<i class="fas fa-eye text-yellow"></i>
					<span class="status">View</span>
				</a>
				<div class="dropdown-divider"></div>

				
				<a 
					class="dropdown-item _delete" 
					href="javascript:;"
					data-link="<?php echo route('admin.contactus.delete', ['id' => $row->id]) ?>"
				>
					<i class="fas fa-times text-danger"></i>
					<span class="status text-danger">Delete</span>
				</a>
			</div>
		</div>
	</td>
</tr>
<?php endforeach; ?>