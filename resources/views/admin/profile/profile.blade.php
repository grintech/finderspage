<div class="card card-profile  card-body">
	<!-- <img src="<?php echo url('assets/img/theme/img-1-1000x600.jpg') ?>" alt="Image placeholder" class="card-img-top"> -->
<!-- 	<div class="row justify-content-center">
		<div class="col-12 text-center">
		
			<div class="card-profile-image">
				<?php $image = $admin->getResizeImagesAttribute(); ?>
				<a class="prof_image_sidebar">
					<img src="<?php echo isset($image['medium']) ? url($image['medium']) : url('assets/img/noprofile.jpg') ?>" class="rounded-circle">
					<span><i id="loading-image" class="fa fa-spin fa-spinne"></i></span>
				</a>
				<span class="change_profile_icon">
					<a href="javascript:;" onclick="$(this).next().click()" data-title="Change Picture" data-toggle="tooltip">
						<i class="fas fa-camera"></i>
					</a>
					<input type="file" style="display:none" name="" id="profile_img" data-url="<?php echo route('admin.profile.updatePicture') ?>" data-id="<?php echo $admin->id ?>">
				</span>
			</div>
		</div>
	</div> -->
	<label class="labels text-white">Image *[Max-Size - 1 MB]</label> 
        <div class="image-upload post_img bg-light">
            <label style="cursor: pointer;" for="image_upload">
               
                <div class="h-100">
                    <div class="dplay-tbl">
                        <div class="dplay-tbl-cell">
                            <!-- <i class="fas fa-cloud-upload-alt mb-3"></i>
                            <h6><b>Upload Image</b></h6> -->
                            <i class="far fa-file-image mb-3"></i>
                            <h6 class="mt-10 mb-70">Upload Or Drop Your Image Here</h6>
                        </div>
                    </div>
                </div>
                <!--upload-content-->
                <input data-required="image" type="file" name="image" id="image_upload" class="image-input" data-traget-resolution="image_resolution" value=""> 
            </label>
          
        </div>
        <div class="show-img d-none">

             <img src="" alt="" class="uploaded-image" id="image-container" >
             <i class="fas fa-times" id="cancel-btn"></i>
        </div>
        @error('image')
            <small class="text-danger">{{ $message }}</small>
        @enderror 
	
	<div class="card-body pt-0">
		<div class="text-left">
			<h5 class="h3">
				<?php echo $admin->first_name. ' ' . $admin->last_name; ?>
			</h5>
			<?php if($admin->address): ?>
			<div class="h5 font-weight-300">
				<i class="ni ni-pin-3 mr-2"></i> <?php echo $admin->address ?>
			</div>
			<?php endif; ?>
		</div>
	</div>
</div>