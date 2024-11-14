@php

  use App\Models\Admin\Settings;

  use App\Models\User\UserAuth;

  use App\Models\Admin\HomeSettings;

  $favicon = Settings::get('favicon');

  $logo = Settings::get('logo');

  $companyName = Settings::get('company_name');

  $version = '1.1';

@endphp

<!DOCTYPE html>

<html lang="en">

<head>

  <meta charset="UTF-8">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="author" content="<?php echo $companyName ?>">

    <title><?php echo $companyName ?></title>

    <meta name="keywords" content="Finders Page">

    <meta name="description" content="Finders Page">

    <!-- ==== Favicon icon ==== -->

    <?php if($favicon): ?>

    <link rel="icon" href="<?php echo url($favicon) ?>" type="image/png">

    <?php endif; ?>

  <!-- ==== Bootstrap CSS ==== -->

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- ==== Montserrat Fonts ==== -->

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- ==== Quattrocento Fonts ==== -->

    <link href="https://fonts.googleapis.com/css2?family=Quattrocento:wght@400;700&display=swap" rel="stylesheet">

  <!-- ==== Font Awesome CSS ==== -->

  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.15.4/css/all.css" />

  <!-- ==== Owl Carausel CSS ==== -->

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.css" />

  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css" rel="stylesheet"/>



  <!-- ==== CSS ==== -->

  <link rel="stylesheet" href="{{ url('front/css/style.css?v=' . $version) }}" />

  <link rel="stylesheet" href="{{ url('front/css/style_home.css?v=' . $version) }}" />

  <!-- ==== Custom CSS ==== -->

  <link rel="stylesheet" href="{{ url('front/css/custom.min.css?v=' . $version) }}" />

   <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/jquery.slick/1.4.1/slick.css">

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">

  <style>

  

  .icon-links i {

    padding: 10px;

}

.icon-links {

    position: absolute;

    right: 0;

    top: 60%;

}

  .icon-links i.fa.fa-plus {

    color: white;

    background: #d64937;

}

  .icon-links i.fa.fa-facebook-square {

    color: white;

    background: #4267B2;

}

.icon-links i.fa.fa-twitter {

    color: white;

    background: #1DA1F2;

}

.icon-links i.fa.fa-print {

    background: #657786;

    color: white;

}

.icon-links i.fa.fa-envelope {

    color: white;

    background: grey;

}

.icon-links i.fa.fa-plus {

    color: white;

    background: #d64937;

}

  .inner-product .slick-list.draggable {

    padding-top: 10px;

}

  .slider-for button.slick-prev.slick-arrow, .slider-for button.slick-next.slick-arrow {

    bottom: 200px;

}

  .related-section {

    padding-top: 0;

    padding-bottom: 0;

}

[aria-label="Previous"],[aria-label="Next"]{

    visibility: hidden;

}

[aria-label="Previous"]:after {

    content: "\f053";

    visibility: initial !important;

    font-family: 'Font Awesome 5 Pro';

    float: left;

    color: white;

    background: #8F8F8F;

    border-radius: 30px;

    padding-left: 8px;

    padding-right: 8px;

    padding-top: 4px;

    padding-bottom: 3px

}

[aria-label="Next"]:after {

    content: "\f054";

    visibility: initial;

    font-family: 'Font Awesome 5 Pro';

    color: white;

    background: #000;

    border-radius: 30px;

    padding-left: 8px;

    padding-right: 8px;

    padding-top: 4px;

    padding-bottom: 3px

}

  .action-arrow {

    display: flex;

    justify-content: space-between;

}

  .detail-section {

    padding-top: 30px;

}

  .slick-slide {

    height: auto;

}

button.slick-next.slick-arrow {

    position: absolute;

    right: 10px;

    bottom: 15px;

}

button.slick-prev.slick-arrow {

    position: absolute;

    bottom: 15px;

    left: 0;

    z-index: 999;

}

.align-format {

    text-align: left;

  padding-top: 10px;

}

.product-btn {

    display: flex;

    justify-content: space-between;

    align-items: center;

    background: #232323;

    color: white;

    width: 100%;

    border-radius: 40px;

    padding-left: 15px;

    padding-right: 10px;

    height: 50px;

    margin-top: 40px;

}



.align-format button {

    color: white;

    background: no-repeat;

    border: unset;

    display: flex;

    align-items: center;

}

.product-btn a {

    background: #998049;

    color: white;

    border-radius: 40px;

    width: 30%;

    text-align: center;

    margin-top: 0;

    padding-top: 10px;

    padding-bottom: 10px

}



/*arrow-css*/





  </style>

</head>

<body>

  @include('inc.header')

  @yield('content')

  @include('inc.footer')

  <form method="post" action="<?php echo route('actions.uploadFile') ?>"  enctype="multipart/form-data" class="d-none" id="fileUploadForm">

    <?php echo csrf_field() ?>

    <input type="hidden" name="path" value="">

    <input type="hidden" name="file_type" value="">

    <input type="file" name="file">

    <input type="hidden" name="resize_large" value="950*570" >

    <input type="hidden" name="resize_medium" value="433*325">

    <input type="hidden" name="resize_small" value="142*90"> 



   



  </form>

  <script>

    var site_url = "<?php echo url("/") ?>";

    var current_url = "<?php echo url()->current(); ?>";

    var current_full_url = "<?php echo url()->full(); ?>";

    var previous_url = "<?php echo url()->previous(); ?>";

    var csrf_token = function(){

      return "<?php echo csrf_token() ?>";

    }

  </script>

      <!-- ==== jQuery JS ==== -->

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

  <!-- ==== Bootstrap JS ==== -->

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- ==== Owl Carausel Js ==== -->

  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

  <!-- ==== jQuery validation JS ==== -->

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>

  <!-- ==== jQuery Additional method validation JS ==== -->

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/additional-methods.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>

  <!-- ==== jQuery matchHeight JS === -->

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.matchHeight/0.7.2/jquery.matchHeight-min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

  <script src="<?php echo url('assets/js/jquery.form.min.js') ?>"></script>

  <script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script> 

  <script src="<?php echo url('assets/js/ckeditor_image_plugin.js?v=' . $version) ?>"></script>

  <!-- ==== Custom js ==== -->

  <script type="text/javascript" src="<?php echo url('front/js/custom.js?v=' . $version) ?>"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>

<script>

   $('.slider-for').slick({

   slidesToShow: 1,

   slidesToScroll: 1,

   arrows: true,

   fade: true,

   asNavFor: '.slider-nav'



 });

 $('.slider-nav').slick({

   slidesToShow: 5,

   slidesToScroll: 1,

   asNavFor: '.slider-for',

   dots: false,

   focusOnSelect: true







 });
 
 $('a[data-slide]').click(function(e) {

   e.preventDefault();

   var slideno = $(this).data('slide');

   $('.slider-nav').slick('slickGoTo', slideno - 1);

 });

 







 $(document).ready(function() {

    $('.slick-arrow').click(function() {

        $('.slick-arrow.active').removeClass("active");

        $(this).addClass("active");

    });

});

</script>





</body>

</html>