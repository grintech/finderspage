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
		<?php echo $row->to ?>
	</td>
	<td>
		<?php echo $row->subject ?>
	</td>
	<td>
		<?php echo $row->cc ?>
	</td>
	<td>
		<?php echo $row->sent ? '<span class="badge badge-success">Sent</span>' : '<span class="badge badge-danger">Not Sent</span>' ?>
	</td>
	<td>
		<?php echo $row->open ? '<span class="badge badge-success">Open</span>' : '<span class="badge badge-danger">Not Open</span>' ?>
	</td>
	<td>
		<?php echo $row->created ?>
	</td>
	<td class="text-right">
		<div class="dropdown">
			<a class="btn btn-sm btn-icon-only text-warning" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<i class="fas fa-ellipsis-v"></i>
			</a>
			<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
				<a class="dropdown-item" href="<?php echo route('admin.activities.emailView', ['id' => $row->id]) ?>">
					<i class="fas fa-eye text-info"></i>
					<span class="status">View</span>
				</a>
			</div>
		</div>
	</td>
</tr>
<?php endforeach; ?>