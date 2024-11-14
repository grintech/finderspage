<div class="dropdown filter-dropdown">
	<a class="btn btn-neutral dropdown-btn" href="#" <?php echo (isset($_GET) && !empty($_GET) ? 'data-title="Filters are active" data-toggle="tooltip"' : '') ?>>
		<?php if(isset($_GET) && !empty($_GET)): ?>
		<span class="filter-dot text-info"><i class="fas fa-circle"></i></span>
		<?php endif; ?>
		<i class="fas fa-filter"></i> Filters
	</a>
	<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
		<form action="<?php echo route('admin.feedback') ?>" id="filters-form">
			<a href="javascript:;" class="float-right px-2 closeit"><i class="fa fa-times-circle"></i></a>
			<div class="dropdown-item">
				<div class="row">
					<div class="col-md-12">
						<label class="form-control-label">Category</label>
						<select class="form-control" name="category[]" multiple>
					      	<option value="complaint" <?php echo (isset($_GET['category']) && in_array('complaint', $_GET['category']) ? 'selected' : '') ?>>Complaint</option>
					      	<option value="suggestion" <?php echo (isset($_GET['category']) && in_array('suggestion', $_GET['category']) ? 'selected' : '') ?>>Suggestion</option>
					      	<option value="compliment" <?php echo (isset($_GET['category']) && in_array('compliment', $_GET['category']) ? 'selected' : '') ?>>Compliment</option>
					    </select>
					</div>
				</div>
			</div>
			<div class="dropdown-divider"></div>
			<div class="col-md-12">
				<label class="form-control-label">Rating</label>
				<div class="range-slider">
				  <input class="range-slider__range" name="rating" type="range" value="<?php echo (isset($_GET['rating']) && $_GET['rating'] ? $_GET['rating'] : 5) ?>" min="0" max="5">
				  <span class="range-slider__value">0</span>
				</div>
			</div>
			<div class="dropdown-divider"></div>
			<div class="dropdown-item">
				<div class="row">
					<div class="col-md-6">
						<label class="form-control-label">Created On</label>
						<input class="form-control" type="date" name="created_on[0]" value="<?php echo (isset($_GET['created_on'][0]) && !empty($_GET['created_on'][0]) ? $_GET['created_on'][0] : '' ) ?>" placeholder="DD-MM-YYYY" >
					</div>
					<div class="col-md-6">
						<label class="form-control-label">&nbsp;</label>
						<input class="form-control" type="date" name="created_on[1]" value="<?php echo (isset($_GET['created_on'][1]) && !empty($_GET['created_on'][1]) ? $_GET['created_on'][1] : '' ) ?>" placeholder="DD-MM-YYYY">
					</div>
				</div>
			</div>
			
			<div class="dropdown-divider"></div>
			<a href="<?php echo route('admin.feedback') ?>" class="btn btn-sm py-2 px-3 float-left">
				Reset All
			</a>
			<button href="#" class="btn btn-sm py-2 px-3 btn-primary float-right">
				Submit
			</button>
		</form>
	</div>
</div>