<?php
use App\Models\Admin\Settings;
use App\Models\BlogPost;
$favicon = Settings::get('favicon');
$logo = Settings::get('logo');
$companyName = Settings::get('company_name');
$googleKey = Settings::get('google_api_key');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
	<meta name="author" content="Creative Tim">
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<title><?php echo $companyName ?></title>
	<!-- Favicon -->

	<?php if($favicon): ?>
		<link rel="icon" href="<?php echo asset($favicon) ?>" type="image/png">
	<?php endif; ?>
	<!-- Fonts -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
	<!-- ==== font Awesome css ==== -->
	<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.11.0/css/all.css" />
	<!-- Icons -->
	<link rel="stylesheet" href="<?php echo asset('assets/vendor/nucleo/css/nucleo.css') ?>" type="text/css">
	<link rel="stylesheet" href="<?php echo asset('assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') ?>" type="text/css">
	<link href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css" rel="stylesheet">
    <link href="{{asset('user_dashboard/css/sb-admin-2.css')}}" rel="stylesheet">
	<!-- Page plugins -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
	<!-- Argon CSS -->
	<!-- ==== owl carousel ==== -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" rel="stylesheet" type="text/css" />
	<!-- ==== owl carousel ==== -->
	<link href="{{asset('user_dashboard/css/custom.css')}}" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo asset('assets/css/argon.css') ?>" type="text/css">

	<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css" rel="stylesheet"/>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">


	<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

	
	<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">

	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
	<link href="{{asset('user_dashboard/css/multiple-image-video.css')}}" rel="stylesheet">

	<?php if(strpos(request()->route()->getAction()['as'], 'admin.products.add') > -1 || strpos(request()->route()->getAction()['as'], 'admin.products.edit') > -1): ?>
	<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false&key=<?php echo $googleKey ?>&libraries=places&language=en-AU"></script>
	<?php endif; ?> 
	<script src="https://kit.fontawesome.com/74c9253442.js" crossorigin="anonymous"></script>
	
	<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha384-MzXzVO2x4JpqGk4h7p0zMdShMqGrKd4MfgABfDmUETf6XhoMamvtYIfdkyEks1uA" crossorigin="anonymous"> -->
	 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>



</head>

<body>
	<!-- Sidenav -->
	<nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light" id="sidenav-main">
		<div class="scrollbar-inner">
			<!-- Brand -->
			<div class="sidenav-header  align-items-center">
				<!-- <a class="navbar-brand" href="<?php echo route('admin.dashboard') ?>">
					<?php if($logo): ?>
						<img src="<?php echo asset($logo) ?>" class="navbar-brand-img" alt="...">
					<?php else: ?>
						<h2><?php echo $companyName ?></h2>
					<?php endif; ?>
				</a> -->
				<a class="navbar-brand" href="<?php echo route('admin.dashboard') ?>">
                    <img src="https://finderspage.com/public/user_dashboard/img/logo.png" class="img-fluid logo-img">
                    <img src="{{asset('images/newlogo.png')}}" class="img-fluid logo-icon">
                    <!-- <img src="https://finderspage.com/public/user_dashboard/img/logo-icon.png" class="img-fluid logo-icon"> -->
                </a>
			</div>
			<div class="navbar-inner">
					<!-- Include menu items -->
					@include('admin.partials.menu')
			</div>
		</div>
	</nav>
		<!-- Main content -->
		<div class="main-content" id="panel">
			<!-- Header -->
			@include('admin.partials.header')
			<!-- Header -->
			<!-- Content render here -->
			<section>
				@yield('content')
			</section>
			<!-- Content -->
			@include('admin.partials.footer')
		</div>
		<!-- Argon Scripts -->
		<form method="post" action="<?php echo route('admin.actions.uploadFile') ?>"  enctype="multipart/form-data" class="d-none" id="fileUploadForm">
			<?php echo csrf_field() ?>
			<input type="hidden" name="path" value="">
			<input type="hidden" name="file_type" value="">
			<input type="file" name="file">
			<input type="hidden" name="resize_large">
			<input type="hidden" name="resize_medium">
			<input type="hidden" name="resize_small">
		</form>
		
		<!-- Core -->
		<script>
			var site_url = "<?php echo url("/") ?>";
			var admin_url = "<?php echo url("/admin/") ?>";
			var current_url = "<?php echo url()->current(); ?>";
			var current_full_url = "<?php echo url()->full(); ?>";
			var previous_url = "<?php echo url()->previous(); ?>";
			var csrf_token = function(){
				return "<?php echo csrf_token() ?>";
			}
		</script>
		 
		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
		<script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.12/jquery-ui.min.js" type="text/javascript" charset="utf-8"></script>
		
		{{-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> --}}
		
		<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>

		<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>

		<script src="<?php echo asset('assets/js/superAdmin.js') ?>"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"></script>
		<script src="<?php echo asset('assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') ?>"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>


		<script src="<?php echo asset('assets/vendor/js-cookie/js.cookie.js') ?>"></script>
		<script src="<?php echo asset('assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js') ?>"></script>
		<script src="<?php echo asset('assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js') ?>"></script>
		<script src="<?php echo asset('assets/js/bootstrap-notify.js') ?>"></script>
		<script src="<?php echo asset('assets/js/jquery.form.min.js') ?>"></script>
		<script src="https://cdn.ckeditor.com/ckeditor5/38.1.1/classic/ckeditor.js"></script>
		<!-- <script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>  -->
		<script src="<?php echo asset('assets/js/ckeditor_image_plugin.js') ?>"></script>
		<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
		<script src="<?php echo asset('assets/js/argon.js') ?>"></script>
		<script src="{{asset('user_dashboard/js/customSelect.js')}}"></script>
		<script src="<?php echo asset('assets/js/tag-it.min.js') ?>"></script>
		<script src="<?php echo asset('assets/js/custom.js') ?>"></script>
		<script src="<?php echo asset('assets/js/image_upload.js') ?>"></script>
		<script src="<?php echo asset('assets/developer/developer.js') ?>"></script>
		<script src="{{asset('user_dashboard/js/multiple-image-video.js')}}"></script>
		
		<!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> -->

		<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

		<!--<script src="<?php echo asset('assets/js/developer.js') ?>"></script> -->
		<script>


		$(document).ready(function() {
			$('#tableListing').DataTable({
				  order: [[0, 'desc']]
			});
			$('#myMulti11').select2({tags: true});
		});


		$(document).ready(function() {
			$('#tableListing_payments').DataTable({
				 // order: [[0, 'desc']]
			});
			$('#myMulti11').select2({tags: true});
		});

</script>
			<script type="text/javascript">
               $(document).ready(function(){
                $(".fixedorRange").change(function(){
                   var value = $(this).val();
                  
                   if(value === 'Range'){
                    $('#range').removeClass('d-none');
                    $('#fixed').addClass('d-none');
                   }


                   if(value === 'Fixed'){
                    $('#fixed').removeClass('d-none');
                    $('#range').addClass('d-none');
                   }
                      
                    });

                
                   var value1 = $('.fixedorRange').val();
                  // alert(value1);
                   if(value1 === 'Range'){
                    $('#range').removeClass('d-none');
                    $('#fixed').addClass('d-none');
                   }


                   if(value1 === 'Fixed'){
                    $('#fixed').removeClass('d-none');
                    $('#range').addClass('d-none');
                   }
                  ClassicEditor
				    .create(document.querySelector('#Blog_editor'))
				    .then(editor => {
				        const wordLimit = 500; // Change this to your desired word limit

				        editor.model.document.on('change:data', () => {
				            const text = editor.getData();
				            const wordCount = text.split(/\s+/).filter(word => word !== '').length;

				            $('#wordCount').text('Word count: ' + wordCount);

				            if (wordCount > wordLimit) {
				                // Get the current content up to the word limit
				                const truncatedContent = text
				                    .split(/\s+/)
				                    .filter((word, index) => index < wordLimit)
				                    .join(' ');

				                // Set the truncated content to the editor
				                editor.setData(truncatedContent);

				                // Optionally, you can display an alert or other user feedback
				                alert("Word limit exceeded! You cannot enter more than " + wordLimit + " words.");
				            }
				        });
				    })
				    .catch(error => {
				        console.error(error);
				    });
             });

$(document).ready(function(){
                 var multipleCancelButton = new Choices('#choices-multiple-remove-button', {
                    removeItemButton: true,
                    maxItemCount:100,
                    searchResultLimit:100,
                    renderChoiceLimit:100
                  }); 
                 
                 
             });


$('.gallery').miv({
  image:'.cam',
  video:'.vid'
});
		</script>
<script>
	  $(document).ready(function() {
            $(".fixedorRange").change(function() {
                var value = $(this).val();

                if (value === 'Range') {
                    $('#range').removeClass('d-none');
                    $('#fixed').addClass('d-none');
                }


                if (value === 'Fixed') {
                    $('#fixed').removeClass('d-none');
                    $('#range').addClass('d-none');
                }

            });

            ClassicEditor
                .create(document.querySelector('#editor1'))
                .then(editor => {
                    console.log(editor);

                })
                .catch(error => {
                    console.error(error);

                });

            ClassicEditor
                .create(document.querySelector("#sub_editor"))
                .catch(error => {
                    console.error(error);
                });


             ClassicEditor
    .create(document.querySelector('#Blog_editor'))
    .then(editor => {
        const wordLimit = 400; // Change this to your desired word limit
        const hashtagLimit = 30; // Maximum number of hashtags allowed

        // Function to update word count and check hashtag limit
        const updateWordCount = (text) => {
            const words = text.split(/\s+/).filter(word => word !== '');
            let hashtagCount = 0;

            words.forEach(word => {
                // Check if the word is a hashtag
                if (word.startsWith('#')) {
                    hashtagCount++;
                }
            });

            const updatedWordCount = words.map((word, index) => {
                const decreasedCount = Math.max(0, wordLimit - index);
                return {
                    word,
                    count: decreasedCount
                };
            });

            $('#wordCount').empty();
            updatedWordCount.forEach(({ word, count }) => {
                $('#wordCount').text(`Words left: ${count}`);
            });

            if (hashtagCount > hashtagLimit) {
                // Display an error if hashtag limit is exceeded
                Swal.fire({
                    icon: 'warning',
                    title: 'Hashtag Limit Exceeded!',
                    text: `You cannot use more than ${hashtagLimit} hashtags.`,
                    confirmButtonText: 'OK'
                });

                // Optionally, you can remove the excess hashtags from the editor
                const truncatedContent = text
                    .split(/\s+/)
                    .filter(word => !word.startsWith('#') || hashtagCount-- < hashtagLimit)
                    .join(' ');

                editor.setData(truncatedContent);
            }
        };

        // Initial word count on load
        const initialText = editor.getData();
        updateWordCount(initialText);

        editor.model.document.on('change:data', () => {
            const text = editor.getData();

            // Call the function to update word count and check hashtag limit on every change
            updateWordCount(text);

            const wordCount = text.split(/\s+/).filter(word => word !== '').length;
            if (wordCount > wordLimit) {
                // Truncate content if word limit is exceeded
                const truncatedContent = text
                    .split(/\s+/)
                    .filter((word, index) => index < wordLimit)
                    .join(' ');

                editor.setData(truncatedContent);

                // Display a warning for word limit exceeded
                Swal.fire({
                    icon: 'warning',
                    title: 'Word Limit Exceeded!',
                    text: `You cannot enter more than ${wordLimit} words.`,
                    confirmButtonText: 'OK'
                });
            }
        });
    })
    .catch(error => {
        console.error(error);
    });
});
</script>
</body>
</html>
