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
	<td>
		<div class="media align-items-center">
	        <a href="#" class="avatar rounded-circle mr-3">
	          <img alt="Image placeholder" src="<?php echo General::renderImage($row->getResizeImagesAttribute(), 'large') ?>">
	        </a>
	        <div class="media-body">
	          <span class="name mb-0 text-sm"><?php echo $row->name ?></span>
	        </div>
	    </div>
	</td>
	<td>
		<?php echo $row->designation ?>
	</td>
	<td>
		<?php echo $row->owner_first_name . ' ' . $row->owner_last_name ?>
	</td>
	<td>
		<div class="custom-control">
			<label class="custom-toggle">
				<?php $switchUrl =  route('admin.actions.switchUpdate', ['relation' => 'testimonials', 'field' => 'status', 'id' => $row->id]); ?>
				<input type="checkbox" name="status" onchange="switch_action('<?php echo $switchUrl ?>', this)" value="1" <?php echo ($row->status ? 'checked' : '') ?>>
				<span class="custom-toggle-slider rounded-circle" data-label-off="OFF" data-label-on="ON"></span>
			</label>
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
				<a class="dropdown-item" href="<?php echo route('admin.testimonials.view', ['id' => $row->id]) ?>">
					<i class="fas fa-eye text-yellow"></i>
					<span class="status">View</span>
				</a>
				<div class="dropdown-divider"></div>
				<a class="dropdown-item" href="<?php echo route('admin.testimonials.edit', ['id' => $row->id]) ?>">
					<i class="fas fa-pencil-alt text-info"></i>
					<span class="status">Edit</span>
				</a>
				<div class="dropdown-divider"></div>
				<a 
					class="dropdown-item _delete" 
					href="javascript:;"
					data-link="<?php echo route('admin.testimonials.delete', ['id' => $row->id]) ?>"
				>
					<i class="fas fa-times text-danger"></i>
					<span class="status text-danger">Delete</span>
				</a>
			</div>
		</div>
	</td>
</tr>
<?php endforeach; ?>