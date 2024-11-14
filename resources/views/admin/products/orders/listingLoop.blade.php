<?php use App\Libraries\FileSystem; ?>
<?php foreach($listing->items() as $k => $row): ?>
<tr>
	<td>
		<!-- MAKE SURE THIS HAS ID CORRECT AND VALUES CORRENCT. THIS WILL EFFECT ON BULK CRUTIAL ACTIONS -->
		<div class="custom-control custom-checkbox">
			<input type="checkbox" class="custom-control-input listing_check" id="listing_check<?php echo $k ?>" value="<?php echo $row->id ?>">
			<label class="custom-control-label" for="listing_check<?php echo $k ?>"></label>
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
	        <a href="<?php echo route('admin.products.view', ['id' => $row->product_id]) ?>" class="avatar norounded-circle mr-3">
	          <img alt="Image placeholder" src="<?php echo General::renderImage(FileSystem::getAllSizeImages($row->product_image), 'small') ?>">
	        </a>
	        <div class="media-body">
	        	<a href="<?php echo route('admin.products.view', ['id' => $row->product_id]) ?>">
	          		<span class="name mb-0 text-sm"><?php echo $row->product_title.'<br><small>'.$row->sample_no.'</small>' ?></span>
	          	</a>
	        </div>
	    </div>
	</td>
	<td>
		<a href="javascript:;"><?php echo $row->first_name . ' ' . $row->last_name ?></a>
	</td>
	<td>
		<a href="tel:<?php echo $row->cell_number ?>"><?php echo $row->cell_number ?></a>
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
					<?php if(Permissions::hasPermission('blog_categories', 'delete')): ?>
				
					<a class="dropdown-item" href="<?php echo route('admin.products.orders.view', ['id' => $row->id]) ?>">
					<i class="fas fa-eye text-yellow"></i>
					<span class="status">View</span>
				</a>
				<div class="dropdown-divider"></div>
					<a 
						class="dropdown-item _delete" 
						href="javascript:;"
						data-link="<?php echo route('admin.products.orders.delete', ['id' => $row->id]) ?>"
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