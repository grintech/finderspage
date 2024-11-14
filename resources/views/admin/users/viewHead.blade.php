@isset($user)
<?php $class = explode('@', Route::getCurrentRoute()->getActionName())[1];	 ?>
<div class="header bg-primary <?php echo $class == 'view' ? "pb-6" : ""; ?>">
	<div class="container-fluid">
		<div class="header-body">
			<div class="row align-items-center py-4">
				<div class="col-lg-6 col-7">
					<h6 class="h2 text-white d-inline-block mb-0">Manage User</h6>
				</div>
				<div class="col-lg-6 col-5 text-right">
					<a href="<?php echo route('user.users') ?>" class="btn btn-warning text-white"><i class="fa fa-arrow-left"></i> Back</a>
					<div class="dropdown" data-toggle="tooltip" data-title="More Actions">
						<a class="btn btn-neutral" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fas fa-ellipsis-v"></i>
						</a>
						<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
							<a class="dropdown-item" href="<?php echo route('UserProfileFrontend.admin',$user->slug) ?>">
								<i class="fas fa-eye text-yellow"></i>
								<span class="status">View</span>
							</a>
							<a class="dropdown-item" href="<?php echo route('user.users.edit', ['id' => $user->id]) ?>">
								<i class="fas fa-pencil-alt text-info"></i>
								<span class="status">Edit</span>
							</a>
							<div class="dropdown-divider"></div>
							<a 
								class="dropdown-item _delete" 
								href="javascript:;"
								data-link="<?php echo route('user.users.delete', ['id' => $user->id]) ?>"
							>
								<i class="fas fa-times text-danger"></i>
								<span class="status text-danger">Delete</span>
							</a>
						</div> 
					</div>
				</div>
			</div>
			<!-- <div class="row align-items-center pb-4">
				<div class="col-lg-12 col-7">
					<a href="<?php echo route('user.users.view', ['id' => $user->id]) ?>" class="btn btn-neutral <?php echo $class == 'view' ? 'active' : ''; ?>"><i class="fas fa-user-alt"></i> Profile</a>
				</div>
			</div> -->
		</div>
	</div>
</div>
@endisset