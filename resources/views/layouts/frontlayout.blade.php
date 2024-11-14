@php

use App\Models\Admin\Settings;

use App\Models\User\UserAuth;

use App\Models\Admin\HomeSettings;

$favicon = Settings::get('favicon');

$logo = Settings::get('logo');

$companyName = Settings::get('company_name');

$version = '1.1';
$User_data = UserAuth::getLoginUser();
@endphp

<!DOCTYPE html>

<html lang="en-US">

<head>
  <!-- Google Tag Manager -->
  <script>
    (function(w, d, s, l, i) {
      w[l] = w[l] || [];
      w[l].push({
        'gtm.start': new Date().getTime(),
        event: 'gtm.js'
      });
      var f = d.getElementsByTagName(s)[0],
        j = d.createElement(s),
        dl = l != 'dataLayer' ? '&l=' + l : '';
      j.async = true;
      j.src =
        'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
      f.parentNode.insertBefore(j, f);
    })(window, document, 'script', 'dataLayer', 'GTM-TZSGXST3');
  </script>
  <!-- End Google Tag Manager -->

 

      <?php  //dd($metaData); ?>

  <meta charset="UTF-8">

  
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  @if(isset($ogmetaData))
  <meta property="og:title" content="<?=$ogmetaData['title'];?>" />
  {{-- <meta property="og:description" content="{{ $ogmetaData['description']; }}" /> --}}
  <meta property="og:image" content="<?=$ogmetaData['image'];?>" />
  @endif
  
  

    @if(isset($metaData['title']))
      <title>{{ $metaData['title'] }}</title>
    @else
      <title><?php echo $companyName ?></title>
    @endif


    @if(isset($metaData['title']))
        <meta name="title" content="{{ $metaData['title'] }}">
    @else
        <meta name="title" content="FindersPage - Your Safe Space for Networking, Inspiration, and Brand Promotion">
    @endif

    @if(isset($metaData['description']))
        <meta name="description" content="{{ $metaData['description'] }}">
    @else
        <meta name="description" content="FindersPage: Your sanctuary for drama-free networking, inspiration, and brand promotion in a positive, equal, and politics-free community">
    @endif

    @if(isset($metaData['keywords']))
        <meta name="keywords" content="{{ $metaData['keywords'] }}">
    @else
        <meta name="keywords" content="finderspage, real estate listing, entertainment industry, services listing, business listing website, real estate listing website, community directory, jobs listing">
    @endif

    <meta name="p:domain_verify" content="51d4f3b02fc66941e0492cb57b2af7d9"/>

    <meta name="author" content="<?php echo $companyName ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <meta name="msvalidate.01" content="9528F8BE444029EFBA9D465955E6AF93" />


    <!-- ==== Favicon icon ==== -->
    <?php if ($favicon) : ?>
    <link rel="icon" href="<?php echo asset($favicon) ?>" type="image/png">
    <?php endif; ?>

    <link rel="canonical" href="{{ url()->current() }}">
    {{-- <link rel="canonical" href="https://www.finderspage.com/" /> --}}
    {{-- <link rel="canonical" href="https://www.finderspage.com/"> --}}
    <!-- Indexing Meta Tag -->
    <meta name="robots" content="index, follow">

    <!-- ==== Bootstrap CSS ==== -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />


    <!---------------royal ---------------------------->
    <link href="https://fonts.googleapis.com/css2?family=Bonheur+Royale&display=swap" rel="stylesheet">

    <!-- ==== Montserrat Fonts ==== -->

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- ==== Quattrocento Fonts ==== -->

    <link href="https://fonts.googleapis.com/css2?family=Quattrocento:wght@400;700&display=swap" rel="stylesheet">

    <!-- ==== Font Awesome CSS ==== -->

    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.15.4/css/all.css" />

    <!-- ==== Owl Carausel CSS ==== -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.css" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css" rel="stylesheet" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/css/flag-icon.min.css" rel="stylesheet">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- Include UIkit CSS -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.6.16/dist/css/uikit.min.css" />

    <!-- ==== CSS ==== -->

    <link rel="stylesheet" href="{{  asset('/front/css/style.css') }}" />
    
    <link rel="stylesheet" href="{{ asset('/front/css/style_home.css') }}" />

    <link href="{{asset('user_dashboard/css/customSelect.css')}}" rel="stylesheet">

    <!-- ==== Custom CSS ==== -->

    <link rel="stylesheet" href="{{  asset('/front/css/custom.min.css') }}" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <!-----custom css----------------->

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('new_assets/assets/style.css')}}">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">

    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css">


    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.css" /> -->
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
    
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

   


    {!! NoCaptcha::renderJs() !!}

    <script type="application/ld+json">
      {
        "@context": "https://schema.org",
        "@id": "#store-organization",
        "@type": "Organization",
        "name": "FindersPage",
        "url": "https://www.finderspage.com/",

        "logo": {
          "@type": "ImageObject",
          "url": "https://www.finderspage.com/public/uploads/logos/16635000611696-logo.png"
        }
      }
    </script>

    <script type="application/ld+json">
      {
        "@context": "http://schema.org",
        "@type": "WebSite",
        "url": "https://www.finderspage.com/",
        "name": "FindersPage - Your Safe Space for Networking, Inspiration, and Brand Promotion",
        "description": "FindersPage: Your sanctuary for drama-free networking, inspiration, and brand promotion in a positive, equal, and politics-free community",
        "SearchAction": {
          "@type": "SearchAction",
          "target": "YourSearchEndpoint{search_term_string}",
          "query-input": "required name=search_term_string"
        }
      }
    </script>

    <script type="application/ld+json">
      {
        "@context": "https://schema.org",
        "@type": "WebSite",
        "url": "https://www.finderspage.com/",
        "potentialAction": {
          "@type": "SearchAction",
          "target": {
            "@type": "EntryPoint",
            "urlTemplate": "https://www.finderspage.com/search?q={search_term_string}"
          },
          "query-input": "required name=search_term_string"
        }
      }
    </script>

    <script type="application/ld+json">
      {
        "@context": "http://schema.org",
        "@type": "BreadcrumbList",
        "itemListElement": [{
            "@type": "ListItem",
            "position": 1,
            "item": {
              "@id": "YourHomeURL",
              "name": "FindersPage - Your Safe Space for Networking, Inspiration, and Brand Promotion",
              "description": "FindersPage: Your sanctuary for drama-free networking, inspiration, and brand promotion in a positive, equal, and politics-free community"
            }
          },
          {
            "@type": "ListItem",
            "position": 2,
            "item": {
              "@id": "joblisting",
              "name": "Job Listing",
              "url": "https://www.finderspage.com/job-listing"
            }
          },
          {
            "@type": "ListItem",
            "position": 3,
            "item": {
              "@id": "RealEstateListing",
              "name": "RealEstateListing",
              "url": "https://www.finderspage.com/realestate-listing"
            }
          },
          {
            "@type": "ListItem",
            "position": 4,
            "item": {
              "@id": "ShoppingPost",
              "name": "Shopping Post",
              "url": "https://www.finderspage.com/shopping-post"
            }
          },
          {
            "@type": "ListItem",
            "position": 5,
            "item": {
              "@id": "ServiceListing",
              "name": "Service Listing",
              "url": "https://www.finderspage.com/service-listing"
            }
          },
          {
            "@type": "ListItem",
            "position": 6,
            "item": {
              "@id": "Blogs",
              "name": "Blogs",
              "url": "https://www.finderspage.com/blogs"
            }
          },
          {
            "@type": "ListItem",
            "position": 7,
            "item": {
              "@id": "Community posts",
              "name": "Community posts",
              "url": "https://www.finderspage.com/community-post"
            }
          }
        ]
      }
    </script>


</head>

  <body>
    <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TZSGXST3" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->

    <style>
      @media (max-width: 767px) {
        /*#FiltersJob {
          display: none;
        }*/

        .filterBTN {
          display: block !important;
        }
      }

      .filterBTN {
        height: 40px;
        background: linear-gradient(90deg, rgba(170, 137, 65, 1) 0%, rgba(205, 156, 49, 1) 13%, rgba(154, 128, 73, 1) 35%, rgba(246, 204, 78, 1) 51%, rgba(181, 147, 56, 1) 75%, rgba(163, 136, 68, 1) 100%);
        border-radius: 100px;
        width: 167px;
        color: #000 !important;
        border: 0;
        outline: 0;
        line-height: 27px;
        margin-bottom: 15px;
        display: none;
      }


      /* Review icon */
.dash-review .review {
  position: fixed;
  height: 50px;
  width: 50px;
  right: 15px;
  /* bottom: 25px; */
  bottom: 65px;
  z-index: 1111;
  opacity: .8;
  transform: rotateY(-180deg);
}

.rate label {
  font-size: 45px;
  margin: 0 15px 0 15px;
  color: #ccc;
  cursor: pointer;
}

.rate input[type="radio"] {
  display: none;
}

.rate .checked {
  color: #FFDF00;
}

.rate {
  color: #C5C5C5;
  text-align: center;
}
.contentArea p a {
  background: #f3c94e;
}
    </style>
    <script>
      $(document).ready(function() {

        $('.job-detail p').filter(function() {
          return $(this).children().length === 1 && $(this).children('br').length === 1;
        }).remove();

        // $(".filterBTN").click(function() {
        //   $("#FiltersJob").slideToggle();
        // });

        // function closeFilters() {
        //     var hidden = $('#FiltersJob');
        //     if (hidden.hasClass('visible')) {
        //         hidden.animate({"left": "-1000px"}, "slow", function () {
        //             hidden.removeClass('visible');
        //         });
        //     }
        //   }

          $(document).ready(function(){
            // $('.filterBTN').click(function(){
            //   var hidden = $('#FiltersJob');
            //   if (hidden.hasClass('visible')){
            //     hidden.animate({"left":"-1000px"}, "slow").removeClass('visible');
            //   } else {
            //     hidden.animate({"left":"-20px"}).addClass('visible');
            //   }
            // });

            // Show the FiltersJob element by default
            $('#FiltersJob').css("left", "-20px").addClass('visible');
            
            $('.filterBTN').click(function(){
                var hidden = $('#FiltersJob');
                if (hidden.hasClass('visible')){
                    hidden.animate({"left":"-1000px"}, "slow").removeClass('visible');
                } else {
                    hidden.animate({"left":"-20px"}).addClass('visible');
                }
            });

            $('.closeIcon').click(function(){
              var hidden = $('#FiltersJob');
              if (hidden.hasClass('visible')){
                hidden.animate({"left":"-1000px"}, "slow").removeClass('visible');
              } 
            });
          });

        // Initialize Fancybox
        lightbox.option({
          'resizeDuration': 200,
          'wrapAround': true,
          'fadeDuration': 300,
        });

        

      });
    </script>
    @include('inc.header')

    @yield('content')
    
    @include('inc.footer')



    <form method="post" action="<?php echo route('actions.uploadFile') ?>" enctype="multipart/form-data" class="d-none" id="fileUploadForm">

      <?php echo csrf_field() ?>

      <input type="hidden" name="path" value="">

      <input type="hidden" name="file_type" value="">

      <input type="file" name="file">

      <input type="hidden" name="resize_large" value="950*570">

      <input type="hidden" name="resize_medium" value="433*325">

      <input type="hidden" name="resize_small" value="142*90">







    </form>




    <script>
      var site_url = "<?php echo url("/") ?>";

      var current_url = "<?php echo url()->current(); ?>";

      var current_full_url = "<?php echo url()->full(); ?>";

      var previous_url = "<?php echo url()->previous(); ?>";

      var csrf_token = function() {

        return "<?php echo csrf_token() ?>";

      }
    </script>

    <script>
      // $(document).ready(function() {
      //   $("#comment-input").emojioneArea({
          
      //     pickerPosition: "right",
      //     tonesStyle: "bullet",
      //     events: {
      //           keyup: function (editor, event) {d
      //               console.log(editor.html());
      //               console.log(this.getText());
      //           }
      //       }
      //   });
        
      //     $('#divOutside').click(function () {
      //                 $('.emojionearea-button').click()
      //             })
                  
                  
      // });
    </script>




    <!-- ==== jQuery JS ==== -->


    <script src="https://rawgit.com/mervick/emojionearea/master/dist/emojionearea.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.slick/1.4.1/slick.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://kit.fontawesome.com/74c9253442.js" crossorigin="anonymous"></script>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- ==== Bootstrap JS ==== -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>

    <!-- Include UIkit JS -->

    <script src="https://cdn.jsdelivr.net/npm/uikit@3.6.16/dist/js/uikit.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/uikit@3.6.16/dist/js/uikit-icons.min.js"></script>

    <!-- ==== Owl Carausel Js ==== -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

    <!-- ==== jQuery validation JS ==== -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>

    <!-- ==== jQuery Additional method validation JS ==== -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/additional-methods.min.js"></script>
    <!-- ==== jQuery matchHeight JS === -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.matchHeight/0.7.2/jquery.matchHeight-min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

    <!-- <script src="<?php echo url('assets/js/jquery.form.min.js') ?>"></script> -->
    <script src="{{asset('assets/js/jquery.form.min.js')}}"></script>

    <script src="{{asset('assets/js/longbow.slidercaptcha.js')}}"></script>

    <script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>

    <!-- <script src="<?php echo url('assets/js/ckeditor_image_plugin.js?v=' . $version) ?>"></script> -->
    <script src="{{asset('assets/js/ckeditor_image_plugin.js')}}"></script>

    <!-- ==== Custom js ==== -->

    <!-- <script type="text/javascript" src="<?php echo url('front/js/custom.js?v=' . $version) ?>"></script> -->
    <script type="text/javascript" src="{{asset('front/js/custom.js')}}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>


    <script src="{{asset('new_assets/assets/custom.js')}}"></script>

    


<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.js"></script>
<script>
$(function() {
    $('.popup-youtube, .popup-vimeo').magnificPopup({
        disableOn: 700,
        type: 'iframe',
        mainClass: 'mfp-fade',
        removalDelay: 160,
        preloader: false,
        fixedContentPos: false
    });
});
</script> -->

<script>
    document.addEventListener("DOMContentLoaded", function() {
      if (typeof UIkit !== 'undefined') {
        var util = UIkit.util;
        var btns = util.$$('.uk-nav li a');
        var offcanvasEl = util.$('#offcanvas-nav');

        util.on(btns, 'click', function(e) {
          e.preventDefault();
          UIkit.offcanvas(offcanvasEl).hide();
        });
      } else {
        console.error('UIkit is not defined.');
      }
    });
</script>

<script>
 $(document).ready(function() {
    $('.social-button ').attr('target', '_blank');
});
</script>


<script>
    $(document).ready(function() {
      function convertToLinks(text) {
        const urlPattern = /(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig;
        const anchorPattern = /<a\b[^>]*>(.*?)<\/a>/ig;

        // Store existing anchor tags in an array and replace them with placeholders
        let anchorTags = [];
        let placeholder = "__ANCHOR__PLACEHOLDER__";

        text = text.replace(anchorPattern, function(match) {
          anchorTags.push(match);
          return placeholder;
        });

        // Replace URLs with anchor tags
        text = text.replace(urlPattern, function(url) {
          return '<a href="' + url + '" target="_blank">' + url + '</a>';
        });

        // Restore original anchor tags
        text = text.replace(new RegExp(placeholder, 'g'), function() {
          return anchorTags.shift();
        });

        return text;
      }

      const contentElement = $('.contentArea');

      if (contentElement.length > 0) {
        const contentText = contentElement.html();

        if (contentText && contentText.trim() !== '') {
          const convertedContent = convertToLinks(contentText);
          contentElement.html(convertedContent);
        }
      }
    });
</script>

    @yield('page_script')
  </body>

</html>