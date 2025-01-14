<?php foreach($listing->items() as $k => $row): ?>
<tr>
	<td>
		<!-- MAKE SURE THIS HAS ID CORRECT AND VALUES CORRENCT. THIS WILL EFFECT ON BULK CRUTIAL ACTIONS -->
		<div class="custom-control custom-checkbox">
			<input type="checkbox" class="custom-control-input listing_check" id="listing_check<?php echo $row->id ?>" value="<?php echo $row->id ?>">
			<label class="custom-control-label" for="listing_check<?php echo $row->id ?>"></label>
		</div>
	</td>
	<td>
		<span class="badge badge-dot mr-4">
			<i class="bg-warning"></i>
			<span class="status"><?php echo $row->id ?></span>
		</span>
	</td>
	<td style="width:30%">
		<?php echo $row->url ?>
	</td>

	<td>
		<?php echo $row->client ? $row->users_first_name . ' ' . $row->users_last_name : "" ?>
	</td>
	<td>
		<?php echo ($row->admin ? $row->admin_first_name . ' ' . $row->admin_last_name : "") ?>
	</td>
	<td>
		<?php echo $row->ip ?>
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
				<a class="dropdown-item" href="<?php echo route('admin.activities.logView', ['id' => $row->id]) ?>">
					<i class="fas fa-eye text-info"></i>
					<span class="status">View</span>
				</a>
			</div>
		</div>
	</td>
</tr>
<?php endforeach; ?>