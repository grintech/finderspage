<?php
use App\Models\Admin\Settings;
$favicon = Settings::get('favicon');
$logo = Settings::get('logo');
$companyName = Settings::get('company_name');
$recaptchaEnabled = Settings::get('admin_recaptcha');
$recaptchaSiteKey = Settings::get('recaptcha_key');
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title><?php echo $companyName ?></title>
	<?php if($favicon): ?>
		<link rel="icon" href="<?php echo url($favicon) ?>" type="image/png">
	<?php endif; ?>
	<!-- Fonts -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
	<!-- ==== font Awesome css ==== -->
	<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.11.0/css/all.css" />
	<!-- Icons -->
	<link rel="stylesheet" href="<?php echo url('assets/vendor/nucleo/css/nucleo.css') ?>" type="text/css">
	<link rel="stylesheet" href="<?php echo url('assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') ?>" type="text/css">
	<!-- Argon CSS -->
	<link rel="stylesheet" href="<?php echo url('assets/css/argon.css?v=1.2.0') ?>" type="text/css">
</head>

<body class="bg-default">
	<!-- Main content -->
	<div class="main-content">
		<section>
			@yield('content')
		</section>
	</div>
	<!-- Core -->
	<script src="<?php echo url('assets/vendor/jquery/dist/jquery.min.js') ?>"></script>
	<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
	<script src="<?php echo url('assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') ?>"></script>
	<script src="<?php echo url('assets/vendor/js-cookie/js.cookie.js') ?>"></script>
	<script src="<?php echo url('assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js') ?>"></script>
	<script src="<?php echo url('assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js') ?>"></script>
	<!-- ==== ckeditor js ==== -->
    <script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
       <!-- ==== Custom ckeditor image ==== -->
    <script src="<?php echo url('assets/js/ckeditor_image_plugin.js') ?>"></script>
    <script src="<?php echo url('assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js') ?>"></script>
	<?php if(isset($recaptchaEnabled) && $recaptchaEnabled): ?>
	<script src="https://www.google.com/recaptcha/api.js?render=<?php echo $recaptchaSiteKey ?>"></script>
	<script>
	    grecaptcha.ready(function() {
	    	// do request for recaptcha token
	    	// response is promise with passed token
	        grecaptcha.execute(
	        	'<?php echo $recaptchaSiteKey ?>', 
	        	{
	        		action:'validate_captcha'
	        	}
	        ).then(function(token) {
	            // add token value to form
	            document.getElementById('g-recaptcha-response').value = token;
	        });
	    });
	 </script>
	<?php endif; ?>
	<script src="<?php echo url('assets/js/argon.js?v=1.2.0') ?>"></script>
	<script src="<?php echo url('assets/js/custom.js?v=1.2.0') ?>"></script>
</body>

</html>