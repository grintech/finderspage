 <div class="card card-profile bg-danger">

	<img src="<?php echo url('assets/img/theme/img-1-1000x600.jpg') ?>" alt="Image placeholder" class="card-img-top">

	<div class="row justify-content-center">

		<div class="col-12 text-center">

		<!-- <div class="col-lg-3 order-lg-2"> -->

			<div class="card-profile-image">

				<?php $image = $user->image; 

				?>

				<a class="prof_image_sidebar">

					<img src="<?php echo isset($image) ? url('/assets/images/profile/'.$image) : url('assets/img/noprofile.jpg') ?>" class="rounded-circle">
					<!-- <img src="<?php echo isset($image['image']) ? url($image['image']) : url('assets/img/noprofile.jpg') ?>" class="rounded-circle"> -->

					<span><i id="loading-image" class="fa fa-spin fa-spinne"></i></span>

				</a>

				<span class="change_profile_icon">

					<a href="javascript:;" onclick="$(this).next().click()" data-title="Change Picture" data-toggle="tooltip">

						<i class="fas fa-camera"></i>

					</a>

					

					<input type="file" style="display:none" name="" id="profile_img" data-url="" data-id="<?php echo $user->id ?>">

				</span>

			</div>

		</div>

	</div>

	<div class="card-body pt-0">

		<div class="text-left">

			<h5 class="h3">

				<?php echo $user->first_name . ' ' . $user->last_name; ?>

			</h5>

			<?php if($user->address): ?>

			<div class="h5 font-weight-300">

				<i class="ni ni-pin-3 mr-2"></i> <?php echo $user->address ?>

			</div>

			<?php endif; ?>

		</div>

	</div>

 </div>