@extends('layouts.frontlayout')

@section('content')

<style type="text/css">

.blog-single-title {

  color: white;

  padding: 40px;

  margin-left: 320px;

}

.blog-single-header-wrapper.post-with-image {

  background-color: #998049 !important;

}

</style>

<div id="posts-content" class="blog-single use-sidebar">

    <div class="blog-single-header-wrapper post-with-image" style="<?php echo 'background-color: #1e266d;' ?>"><div class="container blog-single-title-meta-wrapper"><div style="display:inline-block"><h1 class="blog-single-title"><?php echo $title ?></h1></div></div></div>

        <div class="container single-post-content">

          <div class="row">

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

              <div id="post-362" class="post-362 post type-post status-publish format-standard has-post-thumbnail hentry category-technology tag-internet tag-mobile tag-popular" style="margin-bottom: 50px;">

                <div class="blog-single-content">

                  <div class="blog-content">

                    <h2>TERMS OF USE</h2>

                    <h2>Welcome to FindersPage!</h2>

                    <p> FindersPage's main focus is to provide a website that enables people to connect with each other. These Terms govern your use of FindersPage. We don’t share your personal information with users. (Such as your name, email address or other contact information). You can also go to your settings at any time to review the privacy choices you have about how we use your data. 
                     </p>



                    <p>You agree not to sell weapons, alcohol, animals, and recreational drugs. FindersPage has a zero-tolerance policy for any sexual content, bullying, and harassment. If doing so, the user will be banned, and we will voluntarily cooperate with state and federal law enforcement agencies in connection with criminal investigations. If you suspect anything, please contact us too. FP was designed for my members to find & create free posts, network for their jobs, shop, real estate, etc... With a goal to develop our community and help each other grow. A user friendly and easy platform to use without any distractions. My mission is to give back by helping you save money. Posts will be verified before being published.  No likes or comments are allowed and connections are only viewable to the members itself. This is not a competition or to boost your ego. However, views are viewable to the members for their insights and analytics. Blogs are inspirational and positive. Politics and news will be prohibited. We are here to support each other and spread love. I will continue to strive to better serve you and make a difference globally one day at a time. If you agree, then welcome and enjoy my site. Thank you for your cooperation.</p>



                    <h2>PRIVACY AND REFUND POLICY</h2>

                    <p>Protecting your privacy: FP takes precautions to prevent unauthorized access to or misuse of data about you. FP retains data as needed for FP business purposes and/or as required by law. FP makes good faith efforts to store data securely but can make no guarantees. You may access and update certain data about you via your account login. By accessing FP, you agree FP may use and disclose data collected as described here or as communicated to you. There will be no refunds for feature posts placed on the homepage or when bumped on the create free post page. If your post is not approved, you will not be charged. Thank you for understanding.</p>

                    <p>Kind Greetings, from the Founder,</p>

                    <p>(Brenda Pond)</p>

                    <?php echo str_replace(["&nbsp;",'<p></p>', '<ul></ul>', '<li></li>'], ['', '', ''], $description) ?>

                  </div>

                </div>

              </div>

            </div>

          </div>

      </div>

  </div>

</div>



@endsection