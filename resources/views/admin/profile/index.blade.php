@extends('layouts.adminlayout')
@section('content')
<style type="text/css">
	a#cropImageBtn {
		position: absolute;
		bottom: 1px;
		/* right: -148px; */
		border-radius: 12%;
		z-index: 111;
		left: 187px;
	}

	.card-body {
		background: white;
		border-radius: 20px;
	}

	.card-body span {

		font-weight: 0 !important;
		font-size: 13px !important;
		color: 0 !important;
		font-family: 0;
	}

	textarea.autosize {
		border: 50px solid black;

	}
</style>

<!-- Your custom script -->
<?php
// echo"<pre>"; print_r($admin);die(); 
?>
<div class="container-fluid px-3 px-md-5">
	<span>
		@include('admin.partials.flash_messages')
	</span>


	<form method="post" action="<?php echo route('admin.profile') ?>" enctype="multipart/form-data">
		{{ @csrf_field() }}
		<!-- Page Heading -->


		<div class="d-sm-flex flex-column pt-3 mb-3">
			<h1 class="h2 mb-0 text-gray-800 fw-bold">Edit Profile</h1>
			<p>Edit your profile here</p>
		</div>


		<div class="row">
			<div class="col-lg-3">
				<div class="card mb-4">
					<div class="card-body text-center">
						<div class="avatar-upload">
							<div class="avatar-edit">
								<input type="file" id="imageUpload" name="image" data-id="" accept=".png, .jpg, .jpeg" />
								<label for="imageUpload">
									<i class="fa fa-edit" aria-hidden="true"></i>
								</label>
							</div>
							<div class="avatar-preview popup">
								<img id="imagePreview" src="{{ asset('assets/images/profile/' . $admin->image) }}" alt="Preview Image" />
							</div>
							<div class="show1">
								<div class="img-show">
									<span class="close1" title="Close"><i class="fas fa-times"></i></span>
									<img id="imagePreview" src="{{ asset('assets/images/profile/' . $admin->image) }}" alt="Preview Image" />
								</div>
							</div>
						</div>


						<?php
						$currentDate = date("Y-m-d");
						?>
						<!-- <strong><i class="fas fa-star"></i></strong> -->

						<span class="badge bg-secondary"><?php echo $admin->username ?></span>

						<br>
						<div class="social-links mt-2">
							<a href="" target="blank" class="twitter"><i class="fab fa-twitter"></i></a>
							<a href="" target="blank" class="facebook"><i class="fab fa-facebook-f"></i></a>
							<a href="" target="blank" class="instagram"><i class="fab fa-instagram"></i></a>
							<a href="" target="blank" class="linkedin"><i class="fab fa-linkedin"></i></a>
						</div>
					</div>
				</div>
			</div>


			<div class="col-lg-9">
				<div class="card mb-4">
					<div class="card-body">
						<!-- Profile Edit Form -->

						<div class="row">
							<div class="col-md-12 mb-4">
								<label class="labels text-dark">Bio <span> (Max limit 400 words)</span></label>
								<textarea class="form-control autosize" name="bio"><?= $admin->bio ?></textarea>
								<span class="error"></span>


							</div>
							<div class="col-md-6 mb-4">
								<label class="labels text-dark">First Name</label>
								<input type="text" class="form-control" name="first_name" placeholder="Enter first name" value="<?php echo $admin->first_name ?>" style="text-transform: capitalize;">

								<span class="error"></span>

							</div>
							<div class="col-md-6 mb-4">
								<label class="labels text-dark">Lastname</label>
								<input type="text" name="last_name" class="form-control" value="<?php echo $admin->last_name ?>" placeholder="Enter lastname name">

							</div>

							<div class="col-md-6 mb-4">
								<label class="labels text-dark">Email ID</label>
								<input type="text" name="email" class="form-control" placeholder="Enter email id" value="<?php echo $admin->email ?>">

								<span class="error"></span>

							</div>
							<div class="col-md-6 mb-4 phone_lable">
								<label class="labels text-dark">Phone Number</label>
								<input type="text" maxlength="12" class="form-control" name="phonenumber" placeholder="Enter phone number" id="phone" value="<?php echo $admin->phonenumber ?>">

								<span class="count_code"></span>
								<!-- <input type="tel" class="form-control" placeholder="" id="telephone"> -->


								<span class="error"></span>

							</div>

							<div class="col-md-6 mb-4">
								<label class="labels text-dark">Username</label>
								<input type="text" name="username" class="form-control" value="<?php echo $admin->username ?>" placeholder="Enter Username name">

								<span class="error"></span>

							</div>
							<div class="col-md-6 mb-4">
								<label class="labels text-dark">Location </label>
								<input type="text" name="address" class="form-control get_loc" placeholder="Enter Location" value="<?php echo $admin->address ?>">
								<div class="searcRes" id="autocomplete-results"></div>
								

								<span class="error"></span>

							</div>

							<div class="col-md-12 mb-4">
								<label class="labels text-dark">Date of Birth</label>
								<input name="DOB" type="date" class="form-control" id="zodiac_name" value="<?php echo $admin->DOB ?>" placeholder="">
							</div>
							<div class="col-md-12 mb-4">

							<button class="btn btn-sm py-2 px-3 btn-primary float-right">
							<i class="fa fa-save"></i> Update
						</button>
							</div>
						</div>
					</div>
				</div>
			</div>



		</div>
	</form>
</div>



<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
<script src="https://cdn.rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function() {

		var input = document.querySelector("#phone");
		var iti = window.intlTelInput(input, ({
			onlyCountries: ["us"]
		}));
		var previousePhoneCode = "";
		input.addEventListener("countrychange", function() {
			var countryData = iti.getSelectedCountryData();
			var newPhoneCode = "+" + countryData.dialCode;
			console.log("new phone code " + newPhoneCode);
			var previousePhone = $("#phone").val();
			console.log("previous phone code " + previousePhoneCode);
			if (previousePhoneCode == newPhoneCode) {
				var finalPhone = newPhoneCode + previousePhone;
				console.log("final one " + finalPhone);
			} else {
				if (previousePhone != "") {
					var finalPhone = previousePhone.replace(previousePhoneCode, newPhoneCode);
				} else {
					var finalPhone = newPhoneCode;
				}
			}
			console.log("final two " + finalPhone);
			// jQuery("#phone").val(finalPhone);
			jQuery(".count_code").val(finalPhone);
			previousePhoneCode = "+" + countryData.dialCode;
			console.log("updated previous phone code " + previousePhoneCode);
		});
		input.addEventListener("onchange", function() {

		});
	});

	autosize();

	function autosize() {
		var text = $('.autosize');
		

		text.each(function() {
			$(this).attr('rows', 1);
			resize($(this));
		});

		text.on('input', function() {
			resize($(this));
		});

		function resize($text) {
			$text.css('height', 'auto');
			$text.css('height', $text[0].scrollHeight + 'px');
		}
	}
</script>

<script>
	$(document).ready(function() {
		var maxLength = 250;
		var textArea = $("textarea[name='bio']");

		// Update the character count and limit whenever the user inputs text
		textArea.on('input', function() {
			var currentLength = textArea.val().length;
			var remainingLength = maxLength - currentLength;

			if (remainingLength < 0) {
				textArea.val(textArea.val().substr(0, maxLength));
				remainingLength = 0;
			}

			// Update the counter display
			$("#char-count").text(remainingLength + " characters remaining");
		});


		// addition ajax for adding others option in profile edit proffession

		$('#profession').on('change', function() {
			if ($(this).val() == "Other") {
				// alert($(this).val()+ "This");
				$('#Other-cate-input').removeClass('d-none');
				$(this).addClass('d-none');
			} else {
				$('#Other-cate-input').addClass('d-none');
			}

		});

		$('.profile-button').click(function() {
			var subcate_title = $('#Other-cate-input').val();
			var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
			$.ajax({
				url: baseurl + '/shopping/cate',
				type: 'POST',
				headers: {
					'X-CSRF-TOKEN': csrfToken
				},
				data: {
					title: subcate_title,
					parent_id: 1045,
				},
				success: function(response) {
					console.log(response);
				},
				error: function(xhr, status, error) {

				}
			});
		});




	});

	////////////////////////Profile Pic Zoom Effect////////////////////////////////////

	$(function() {
		$(".popup img").click(function() {
			let $src = $(this).attr("src");
			$(".show1").fadeIn(10);
			$(".img-show img").attr("src", $src);
		});

		$("span.close1").click(function() {
			$(".show1").fadeOut(10);
			$('.img-show img').css({
				'width': '100%',
				'height': '100%'
			});
		});

		// Close the popup when clicking outside the image
		$(document).mouseup(function(e) {
			var container = $(".img-show");
			if (!container.is(e.target) && container.has(e.target).length === 0) {
				$(".show1").fadeOut(10);
				$('.img-show img').css({
					'width': '100%',
					'height': '100%'
				});
			}
		});

		// let ovrflow_width
		$(".img-show img").draggable({

			scroll: true,
			stop: function() {},
			drag: function(e, ui) {

				let popup_img_width = $('.img-show img').width();
				let popup_width = $('.img-show').width();
				let new_img_width = popup_width - popup_img_width;

				let popup_img_height = $('.img-show img').height();
				let popup_height = $('.img-show').height();
				let new_img_height = popup_height - popup_img_height;

				if (ui.position.left > 0) {
					ui.position.left = 0;
				}
				if (ui.position.left < new_img_width) {
					ui.position.left = new_img_width;
				}

				if (ui.position.top > 0) {
					ui.position.top = 0;
				}
				if (ui.position.top < new_img_height) {
					ui.position.top = new_img_height;
				}
			}
		});

	});
</script>
<script>
	$(document).ready(function() {
		

		$('#imageUpload').change(function(e) {
			var fileInput = e.target;
			var files = fileInput.files;

			if (files && files.length > 0) {
				var reader = new FileReader();
				reader.onload = function(e) {
					$('#imagePreview').attr('src', e.target.result);

				};
				reader.readAsDataURL(files[0]);
			}
		});

		// 

		// Close the popup when clicking outside the image
		$(document).mouseup(function(e) {
			var container = $(".img-show");
			if (!container.is(e.target) && container.has(e.target).length === 0) {
				$(".show1").fadeOut(10);
			}
		});

		// Additional functions
		function uploadCroppedImage(file) {
			// Add your logic to upload the cropped image file
			console.log('Upload cropped image:', file);
		}
	});
</script>
@endsection