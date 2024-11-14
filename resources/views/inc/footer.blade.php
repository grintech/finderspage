<?php use App\Models\Admin\HomeSettings; ?>

	<!-- ==== Footer Section Start ==== -->

	<!-- <section class="footer_section">

		<div class="container">

			<div class="row">

				<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

					<div class="footer_area">

						<div class="row">

							<div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">

								<div class="one_third social_links">

									<div class="foot_title">

										<h3>Follow Us</h3>

									</div>

									<ul class="list-inline">

										<?php

		                                $icon = HomeSettings::get('social_icon_1') ;

		                                $link = HomeSettings::get('social_link_1');

		                                ?>

		                                <li>

		                                    <a href="<?php echo $link ?>">

		                                        <?php echo $icon ?>

		                                    </a>

		                                </li>

		                                <?php

		                                $icon = HomeSettings::get('social_icon_2') ;

		                                $link = HomeSettings::get('social_link_2');

		                                ?>

		                                <li>

		                                    <a href="<?php echo $link ?>">

		                                        <?php echo $icon ?>

		                                    </a>

		                                </li>

		                                <?php

		                                $icon = HomeSettings::get('social_icon_3') ;

		                                $link = HomeSettings::get('social_link_3');

		                                ?>

		                                <li>

		                                    <a href="<?php echo $link ?>">

		                                        <?php echo $icon ?>

		                                    </a>

		                                </li>

		                                <?php

		                                $icon = HomeSettings::get('social_icon_4') ;

		                                $link = HomeSettings::get('social_link_4');

		                                ?>

		                                <li>

		                                    <a href="<?php echo $link ?>">

		                                        <?php echo $icon ?>

		                                    </a>

		                                </li>

									</ul>

								</div>

							</div>

							<div class="col-xxl-5 col-xl-5 col-lg-5 col-md-6 col-sm-6 col-12">

								<div class="one_third useful_links">

									<div class="foot_title">

										<h3><?php echo HomeSettings::get('footer_link_title') ?></h3>

									</div>

									<ul class="list-inline">

										<?php 

										$quickLinks1 = HomeSettings::get('quick_links_1');

										$quickLinks1 =  $quickLinks1 ? json_decode($quickLinks1, true) : []; 

										?>

										<?php foreach ($quickLinks1 as $key => $value): ?>

										<li>

											<a href="<?php echo isset($value['menu_url']) ? $value['menu_url'] : '' ?>"><?php echo isset($value['menu_title']) ? $value['menu_title'] : '' ?></a>

										</li>

										<?php endforeach; ?>

										<?php 

										$quickLinks1 = HomeSettings::get('quick_links_2');

										$quickLinks1 =  $quickLinks1 ? json_decode($quickLinks1, true) : []; 

										?>

										<?php foreach ($quickLinks1 as $key => $value): ?>

										<li>

											<a href="<?php echo isset($value['menu_url']) ? $value['menu_url'] : '' ?>"><?php echo isset($value['menu_title']) ? $value['menu_title'] : '' ?></a>

										</li>

										<?php endforeach; ?>

									</ul>

								</div>

							</div>

							<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">

								<div class="one_third newsletter">

									<div class="foot_title">

										<h3><?php echo HomeSettings::get('footer_newsletter_title') ?></h3>

									</div>

									<p><?php echo HomeSettings::get('footer_newsletter_text') ?></p>

									<form action="">

										<div class="form-group">

											<input type="text" class="form-control" name="email" placeholder="Enter your email">

											<button type="button" class="btn btn-primary">Subscibe</button>

										</div>

									</form>

								</div>

							</div>

						</div>

					</div>

				</div>

			</div>

		</div>

	</section> -->

	<!-- ==== Footer Section End ==== -->



	<!-- ==== Footer Bottom Section Start ==== -->

	<!-- <section class="footer_bottom_section">

		<div class="container">

			<div class="row">

				<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

					<div class="footer_bottom_area">

						<div class="left_area">

							&copy; <?php echo date('Y') ?> FindersPage Inc.

						</div>

						<div class="right_area"></div>

					</div>

				</div>

			</div>

		</div>

	</section> -->

	<footer>
		<section id="footer-section" class="">
			<div class="container">
				<div class="row">
					<div class="col-md-4 col-12">
						<div class="footer-logo">
							<!-- <a href="{{route('homepage.index')}}"><img src="{{asset('new_assets/assets/images/finder-footer-logo.png')}}" class="img-fluid"></a> -->
							<a href="{{route('homepage.index')}}"><img src="{{asset('uploads/logos/new-logo.png')}}" class="img-fluid"></a>
						</div>
						<ul class="new-menu3">
							<li><a href="{{route('homepage.index')}}">Home</a></li> 
							<!-- <li><a href="{{route('getAllpostpost')}}">View Post</a></li>  -->
							<li><a href="{{route('homepage.about')}}">About</a></li> 
							<!-- <li><a href="#">519 walnut Ave el Segundo ca 90245</a></li>
							<li><a href="#">424-279-6090</a></li>
							<li><a href="#">finderspage@gmail.com</a></li> -->
							
							<!-- {{-- <li><a href="{{route('homepage.contact')}}">Contact Us</a></li> --}} -->

							<li>

							<div id="mc_embed_shell">
      <link href="//cdn-images.mailchimp.com/embedcode/classic-061523.css" rel="stylesheet" type="text/css">
  <style type="text/css">
        #mc_embed_signup{clear:left; font:14px Helvetica,Arial,sans-serif; width: 350px;}
        /* Add your own Mailchimp form style overrides in your site stylesheet or in this style block.
           We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */
           #mc-embedded-subscribe{background: linear-gradient(90deg, rgba(220, 114, 40, 1) 70%, #a54db7 100%); border-radius: 35px!important; font-size: 13px;}

           @media only screen and (min-width:768px) and (max-width:991px){
           #mc_embed_signup .mc-field-group input,	#mc_embed_signup #mc-embedded-subscribe-form div.mce_inline_error{width:60%;}
           }

            @media only screen and (min-width:992px) and (max-width:1199px){
           #mc_embed_signup .mc-field-group input,	#mc_embed_signup #mc-embedded-subscribe-form div.mce_inline_error{width:80%;}
           }
</style>
<div id="mc_embed_signup">
    <form action="https://finderspage.us22.list-manage.com/subscribe/post?u=62f6badb28cb5f41b5e29b16e&amp;id=0a4e878f18&amp;f_id=003dd0e1f0" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" style="margin:0;">
        <div id="mc_embed_signup_scroll">
			 <!--<h2>Subscribe</h2> -->
            <!-- <div class="indicates-required"><span class="asterisk">*</span> indicates required</div> -->
            <div class="mc-field-group"><label for="mce-EMAIL" class="text-white">Email Address <span class="asterisk">*</span></label><input type="email" name="EMAIL" class="required email" id="mce-EMAIL" required="" value=""></div>
        <div id="mce-responses" class="clear foot">
            <div class="response" id="mce-error-response" style="display: none;"></div>
            <div class="response" id="mce-success-response" style="display: none;"></div>
        </div>
    <div aria-hidden="true" style="position: absolute; left: -5000px;">
        / real people should not fill this in and expect good things - do not remove this or risk form bot signups /
        <input type="text" name="b_62f6badb28cb5f41b5e29b16e_0a4e878f18" tabindex="-1" value="">
    </div>
        <div class="optionalParent">
            <div class="clear foot">
                <input type="submit" name="subscribe" id="mc-embedded-subscribe" class="button" value="Subscribe">
                <p style="margin: 0px auto; display: none;"><a href="http://eepurl.com/iLp5zg" title="Mailchimp - email marketing made easy and fun"><span style="display: inline-block; background-color: transparent; border-radius: 4px;"><img class="refferal_badge" src="https://digitalasset.intuit.com/render/content/dam/intuit/mc-fe/en_us/images/intuit-mc-rewards-text-dark.svg" alt="Intuit Mailchimp" style="width: 220px; height: 40px; display: flex; padding: 2px 0px; justify-content: center; align-items: center;"></span></a></p>
            </div>
        </div>
    </div>
</form>
</div>
<script type="text/javascript" src="//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js"></script><script type="text/javascript">(function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';fnames[1]='FNAME';ftypes[1]='text';fnames[2]='LNAME';ftypes[2]='text';fnames[3]='ADDRESS';ftypes[3]='address';fnames[4]='PHONE';ftypes[4]='phone';fnames[5]='BIRTHDAY';ftypes[5]='birthday';}(jQuery));var $mcj = jQuery.noConflict(true);</script></div>
							</li>
						</ul>
					</div>
					<div class="col-md-4 col-12">
						<h5 style="color: #fff;">Follow us to learn more!</h5>
						<ul class="footer-social-icon">
							<?php
							$icon = HomeSettings::get('social_icon_1');
							$link = HomeSettings::get('social_link_1');
							?>
							<li><a target="_blank" href="<?php echo $link ?>" > 
								<?php echo $icon ?>
								</a>
							</li>

								<?php
								$icon = HomeSettings::get('social_icon_2');
								$link = HomeSettings::get('social_link_2');
								?>
							<li> <a target="_blank" href="<?php echo $link ?>" >
									<?php echo $icon ?>
								</a>
							</li>
							

								<?php
								$icon = HomeSettings::get('social_icon_3');
								$link = HomeSettings::get('social_link_3');
								?>
							<li>
								<a href="<?php echo $link ?>" target="_blank">
									<?php echo $icon ?>
								</a>
							</li>
							    <?php
								$icon = HomeSettings::get('social_icon_4');
								$link = HomeSettings::get('social_link_4');
								?>
							<li>
								<a href="<?php echo $link ?>" target="_blank">
									<?php echo $icon ?>
								</a>
							</li>

							<li><a target="_blank" href="https://www.tiktok.com/@finderspage"><i class="bi bi-tiktok"></i></a></li>
					    </ul>
						<ul class="new-menu2">
							<!-- <li><a href="{{route('homepage.index')}}">Home</a></li> -->
								<!-- <li><a href="{{route('getAllpostpost')}}">View Post</a></li> -->
								<!-- <li><a href="{{route('homepage.about')}}">About</a></li> -->
							<li>
							 @if(isset($User_data) && $User_data->review==0)
				                <div class="dash-review" style="cursor: pointer;">
				                    <a data-bs-toggle="modal" data-bs-target="#staticBackdrop">
				                        Leave a review
				                    </a>
				                </div>
                				@endif
                			</li>
							<li><a href="{{route('faq')}}">Get Help</a></li>
							<li><a href="{{route('blog.admin.blog')}}">FindersPage Blogs</a></li>
							<!-- <li><a href="#">Avoid and report a scam</a></li> -->
							<li><a href="{{route('term_of_use')}}">Terms of Use  & Privacy Policy</a></li>
							<!-- <li><a href="#">Privacy policy</a></li> -->
							<!-- <li><a href="{{route('homepage.privacyPolicy')}}">Privacy Policy</a></li> -->
							<li> <a href="{{route('avoid_scam')}}">Avoid and Report a Scam</a></li>
						</ul>
					</div>

					<div class="col-md-4 col-12">
						<div class="footer-second-sec ">
							<h5>Join FindersPage to</h5>
							<p>stay updated + inspired!</p>
							<p class="footer-design">Join our<br>community</p>
							<a class="footer-signup btn btn-success signup-btn btn-block" href="{{ route('auth.signupuser') }}">
							Sign Up
							</a>
						</div>
					</div>

				</div>
			</div>


<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"> Leave a review!</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      	<div class="title">
			Tell us how FindersPage is working for you. As a thank you, you will be allowed to have one free bump on any of your posts.
      	</div>
       <form id="reviewForm" action="{{ route('review.save') }}" method="post">
                  @csrf
                    <div class="form-group">
                        <label for="rating" class="col-form-label">Rating:</label>
                        <div class="rate">
                            <input type="radio" id="star1" name="rating" value="1">
                            <label for="star1"><i class="fas fa-star"></i></label>
                            <input type="radio" id="star2" name="rating" value="2">
                            <label for="star2"><i class="fas fa-star"></i></label>
                            <input type="radio" id="star3" name="rating" value="3">
                            <label for="star3"><i class="fas fa-star"></i></label>
                            <input type="radio" id="star4" name="rating" value="4">
                            <label for="star4"><i class="fas fa-star"></i></label>
                            <input type="radio" id="star5" name="rating" value="5">
                            <label for="star5"><i class="fas fa-star"></i></label>
                        </div>
                    </div>

					

                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Description:</label>
                        <textarea class="form-control" id="message-text" name="description"></textarea>
                    </div>

					<div class="form-group">
                        <label  class="col-form-label">Video:</label>
                        <input type="file" class="form-control"  name="video">
                    </div>

                    <div class="form-group">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Send</button>
                    </div>
                </form>
      </div>
  </div>
</div>


				
		</section>
	</footer>
	<section id="footer-bottom">
		<p>© 2023 FindersPage Inc.</p>
	</section>
	@if(Session::has('newslater_success'))
	<script type="text/javascript">

	toastr.options =
	{
		"closeButton" : true,
		"progressBar" : true
	}
	toastr.success("{{ session('newslater_success') }}");

	</script>
	
	@endif

	<script type="text/javascript">
    $(document).ready(function(){
        $('.rate label').on('click', function(){
            var selectedValue = $(this).prev('input').val();
            $('.rate label').removeClass('checked');
            $(this).addClass('checked').prevAll('label').addClass('checked');
        });

        $('#submitReview').on('click', function(){
            var rating = $('input[name="rating"]:checked').val();
            var description = $('#message-text').val();
            // Here you can perform further actions like submitting the data via AJAX
            console.log("Rating: " + rating);
            console.log("Description: " + description);
        });
    });
	</script>

	


	<!-- ==== Footer Bottom Section End ==== -->

	







