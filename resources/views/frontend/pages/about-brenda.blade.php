<?php use App\Models\Admin\Settings;  ?>
@extends('layouts.frontlayout')
@section('content')
<style>
    .inner_div h3 {
        text-transform: capitalize;
    }
</style>
<!-- <section id="about_new" style="background:url('https://finderspage.com/public/images_entrtainment/about-brenda-bg.jpg') no-repeat center center /cover fixed;"> -->
<section id="about_new" >
    <div class="container">
       <div class="row">
            <div class="col-lg-6 col-md-12 inner_div" id="inner_first_div_id">
                <h1><?php echo Settings::get('about_brenda_title') ?></h1>
                {{-- <h2>Public Figure/Entrepreneur </h2>
                <h4>Founder/CEO of FindersPage<h4> --}}
                <!-- <h4><?php echo Settings::get('about_brenda_short_description') ?><h4> -->
                <!-- <h3>About Me</h3>  -->

                <p><?php echo Settings::get('about_brenda_description') ?></p>

                <div class="mt-0 mb-4">
                    <a class="link_primary interview_meet_btn fw-bold" href="https://voyagela.com/interview/meet-brenda-pond-of-finderspage">Interview / Meet Brenda Pond</a>
                </div>
               
                <h5>PRESS</h5>
                <div class="mt-0 mb-4">
                    <a class="link_primary interview_meet_btn fw-bold" target="_blank" href="https://canvasrebel.com/meet-brenda-pond">https://canvasrebel.com/meet-brenda-pond/</a>
                </div>
                
                <a class="btn btn-warning mr-2" target="_blank" href=" https://statenislander.org/2023/11/25/new-platform-aims-to-cut-through-bs-bring-human-element-to-business-community-space/?fbclid=IwAR0TvWk05mo8sFhwYaW5psDPmJtniKwRxZqheeG61F0alEZrZTO3o8Zw_tI_aem_AfJf0TGyAipsQQSrk5CS2huNborbYc_1KIoyOWFwMLa_8SGqPZ9KZO_NitTxvvbNTrY"> Read More</a>

                <a class="btn btn-purple" target="_blank" href="https://healingschool11.square.site/s/order">Order Online</a>
                <!-- <p><b>I’ll continue to be a vessel. I am forever grateful for life and loved ones close to me.</b></p> -->
                <!-- <h3>PRESS</h3>  -->
                <!-- <div class="press">
                    <p class="mb-1">"Brenda Pond Surprised Us Again With A New Venture"
                    <br>-Grey Journal</p>
                    <a href="https://greyjournal.net/hustle/inspire/brenda-pond-surprised-us-again-with-a-new-venture/amp/?fbclid=IwAR3ea-jAfXLo22FtXoXaR9nqkXpV6895YsfpVydW0YR6Sy274MDQD0ZIQ1E">Read More</a>
                    <p class="par_cst mb-1">"Entrepreneurial spirit Brenda Pond debuts new company"
                    <br>-The Lifestyle Republic</p>
                    <a href="https://thelifestylerepublic.com/content/6508">Read More</a>
                </div> -->
                <!-- <div class="about-links mt-3">
                    <h3>Social Media Link :
                        <ul>
                            <li><a target="_blank" href="https://www.instagram.com/{{Settings::get('brenda_instagram')}}/"><i class="fab fa-instagram" aria-hidden="true"></i></a></li>
                            <li><a target="_blank" href="https://www.youtube.com/{{Settings::get('brenda_youtube')}}"><i class="fab fa-youtube" aria-hidden="true"></i></a></li>
                            <li><a target="_blank" href="https://www.tiktok.com/{{Settings::get('brenda_tiktok')}}"><i class="fab fa-tiktok" aria-hidden="true"></i></a></li>
                        </ul>
                    </h3>
                </div> -->
            </div>
            <div class="col-lg-6 col-md-12 inner_div" id="inner_div_id">
                <!-- <img class="img-fluid" src="https://finder.harjassinfotech.org/public/front/images/brenda.jpeg" alt="Brenda Pond"> -->

                <!-- Swiper -->
                <div class="swiper-container gallery-top">
                <div class="swiper-wrapper">

                <?php 
                    $img  = explode(',',Settings::get('image_brenda'));

                    // echo "<pre>";print_r($img);
                    
                    // echo "<pre>";print_r($img);die('dev');
                ?>
                     @foreach($img as $images)
                     <div class="swiper-slide" style="background-image:url(https://www.finderspage.com/public/images_blog_img/{{$images}})"></div>
                     @endforeach
                    <!-- <div class="swiper-slide" style="background-image:url(https://finderspage.com/public/images_blog_img/{{$images}})"></div>
                    <div class="swiper-slide" style="background-image:url(https://finderspage.com/public/front/images/bimg1.jpg)"></div>
                    <div class="swiper-slide" style="background-image:url(https://finderspage.com/public/front/images/bimg2.jpg)"></div>     
                    <div class="swiper-slide" style="background-image:url(https://finderspage.com/public/front/images/bimg3.jpg)"></div>     
                    <div class="swiper-slide" style="background-image:url(https://finderspage.com/public/front/images/bimg4.jpg)"></div> -->
                </div>
                <!-- Add Arrows -->
                <div class="swiper-button-next swiper-button-white"></div>
                <div class="swiper-button-prev swiper-button-white"></div>
                </div>
                <div class="swiper-container gallery-thumbs">
                    <div class="swiper-wrapper">
                         <?php 
                                $img  = explode(',',Settings::get('image_brenda'));

                                // echo "<pre>";print_r($img);
                                
                                // echo "<pre>";print_r($img);die('dev');
                            ?>

                            @foreach($img as $images)
                             <div class="swiper-slide" style="background-image:url(https://www.finderspage.com/public/images_blog_img/{{$images}})"></div>
                            @endforeach
                        <!-- <div class="swiper-slide" style="background-image:url(https://finderspage.com/public/front/images/bimg5.jpg)"></div>
                        <div class="swiper-slide" style="background-image:url(https://finderspage.com/public/front/images/bimg1.jpg)"></div>
                        <div class="swiper-slide" style="background-image:url(https://finderspage.com/public/front/images/bimg2.jpg)"></div>
                        <div class="swiper-slide" style="background-image:url(https://finderspage.com/public/front/images/bimg3.jpg)"></div>
                        <div class="swiper-slide" style="background-image:url(https://finderspage.com/public/front/images/bimg4.jpg)"></div> -->
                    </div>
                </div>
                <div class="right-div">


                    <div class="about-links mt-3">
                        <h3><!--Social Media Link :-->
                            <ul>
                                <li><a target="_blank" href="https://www.instagram.com/{{Settings::get('brenda_instagram')}}/"><i class="fab fa-instagram" aria-hidden="true"></i></a></li>

                                <!-- <li><a target="_blank" href="https://www.instagram.com/{{Settings::get('brenda_instagram_2')}}/"><i class="fab fa-instagram" aria-hidden="true"></i></a></li> -->

                                <li><a target="_blank" href="https://www.youtube.com/{{Settings::get('brenda_youtube')}}"><i class="fab fa-youtube" aria-hidden="true"></i></a></li>
                                <li><a target="_blank" href="https://www.tiktok.com/{{Settings::get('brenda_tiktok')}}"><i class="fab fa-tiktok" aria-hidden="true"></i></a></li>
                            </ul>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.5.0/css/swiper.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> 
   <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.5.0/js/swiper.min.js"></script>

  <!-- Initialize Swiper -->
  <script>
  var galleryThumbs = new Swiper('.gallery-thumbs', {
    spaceBetween: 10,
    slidesPerView: 4,
    freeMode: true,
    watchSlidesVisibility: true,
    watchSlidesProgress: true,
  });

  var galleryTop = new Swiper('.gallery-top', {
    spaceBetween: 10,
    thumbs: {
      swiper: galleryThumbs
    },
    autoplay: {
      delay: 3000, // Delay between slides in milliseconds
      disableOnInteraction: false, // Autoplay won't stop after interactions (swipes)
    },
  });
</script>
@endsection

