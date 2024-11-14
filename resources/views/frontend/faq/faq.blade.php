<?php

use App\Models\Admin\HomeSettings;
use App\Models\Admin\Testimonials;
use App\Models\UserAuth;

$testimonials = Testimonials::where('status', 1)->get();
?>
@extends('layouts.frontlayout')
@section('content')

<section class="faq mt-5 mb-5 ">
  <div class="container">
    <div class="title_block">
      <!-- <h3><b>These are the questions to get help</b> </h3> -->
      <!-- <p>Will most likely add more or update</p> -->
    </div>
    
    <div class="accordion" id="accordionExample">
      <!-------------#01----------------->
      <div class="accordion-item">
        <h1 class="accordion-header" style="font-size: 17px;">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
           How can I edit my post?
          </button>
        </h1>
        <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
          <div class="accordion-body">
            Edits for posts are self-service and user friendly. Simply click on the upper right hamburger icon to edit, save, delete, share, or report a post.
          </div>
        </div>
      </div>

      <!-------------#02----------------->
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
            How do I turn off notifications?
          </button>
        </h2>
        <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
          <div class="accordion-body">
            When you create an account, you will automatically have notifications turned on to receive alerts near you. To turn off, simply go to your settings on your profile to update.
          </div>
        </div>
      </div>

      <!-------------#03----------------->
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
           How can I edit my profile?
          </button>
        </h2>
        <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
          <div class="accordion-body">
            Click on the upper right navigation bar. It will direct you to the top of your profile to choose an option.
          </div>
        </div>
      </div>

      <!-------------#04----------------->
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsefour" aria-expanded="false" aria-controls="collapsefour">
           Why is it beneficial for me to feature my post on Finders Page ?
          </button>
        </h2>
        <div id="collapsefour" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
          <div class="accordion-body">
            Featuring your post will put you on the top of the list and get noticed first. FP is also more affordable than most advertisement sites.
          </div>
        </div>
      </div>

      <!-------------#05----------------->
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsefive" aria-expanded="false" aria-controls="collapsefive">
           Is it free to post?
          </button>
        </h2>
        <div id="collapsefive" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
          <div class="accordion-body">
            Yes, it's always free to post. Start by choosing a category that fits you best according to your location and add details.
          </div>
        </div>
      </div>

      <!-------------#06----------------->
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsesix" aria-expanded="false" aria-controls="collapsesix">
           How do I feature my post on the homepage?
          </button>
        </h2>
        <div id="collapsesix" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
          <div class="accordion-body">
            Simply click on the button that says (Feature) off your dashboard ads, posts, or videos .. you have published to subscribe on the homepage.
          </div>
        </div>
      </div>

      <!-------------#07----------------->
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseseven" aria-expanded="false" aria-controls="collapseseven">
           How do I create my free post on FindersPage?
          </button>
        </h2>
        <div id="collapseseven" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
          <div class="accordion-body">
            Just click on the (create free post) tab. Choose a category that fits you best and add details.
          </div>
        </div>
      </div>

      <!-------------#08----------------->
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseeight" aria-expanded="false" aria-controls="collapseeight">
           How do I join FindersPage?
          </button>
        </h2>
        <div id="collapseeight" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
          <div class="accordion-body">
            Simple click on the (Sign up) tab. There it will direct you to join FP to create a quick account. You will receive an email to verify your account.
          </div>
        </div>
      </div>

      <!-------------#09----------------->
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsenine" aria-expanded="false" aria-controls="collapsenine">
           How do I turn off messages from other members?
          </button>
        </h2>
        <div id="collapsenine" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
          <div class="accordion-body">
            Go to your profile, click "settings" go to "notifications" and click Chatting off.
          </div>
        </div>
      </div>

      <!-------------#10----------------->
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseten" aria-expanded="false" aria-controls="collapseten">
           How do you search for a post?

          </button>
        </h2>
        <div id="collapseten" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
          <div class="accordion-body">
            Simply just click on the tab (Find) add the location or look under the categories.
          </div>
        </div>
      </div>

      <!-------------#11----------------->
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseeleven" aria-expanded="false" aria-controls="collapseeleven">
           Making your account private?
          </button>
        </h2>
        <div id="collapseeleven" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
          <div class="accordion-body">
            To make your account private: Go to your profile. Click on the hamburger menu on the right corner of the profile cover. Click "make account private"

          </div>
        </div>
      </div>

      <!-------------#12----------------->
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsetwelve" aria-expanded="false" aria-controls="collapsetwelve">
           How do I receive the golden star badge next to my username?
          </button>
        </h2>
        <div id="collapsetwelve" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
          <div class="accordion-body">
            Members that have a subscription plan will receive a golden star badge next to their username.

            <p class="faq_note">At any time you cancel your subscription, the badge comes off, unless you decide to renew it again. Your post will also be removed from the homepage and be placed under the free popular post section.</p>
          </div>
        </div>
      </div>
    
      <!-------------#13----------------->
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsethirteen" aria-expanded="false" aria-controls="collapsethirteen">
           How to support a business for free?
          </button>
        </h2>
        <div id="collapsethirteen" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
          <div class="accordion-body">
            - Share

            - Make purchases

            - Tell your friends and family

            - Connect

            - Buy a gift card for later

            - Write a review

            - Check in

            - Tag
            
            -Mention 

          </div>
        </div>
      </div>

      <!-------------#14----------------->
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsefourteen" aria-expanded="false" aria-controls="collapsefourteen">
           What's allowed and not allowed on my post?

          </button>
        </h2>
        <div id="collapsefourteen" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
          <div class="accordion-body">
            Your post is your sacred place to network and support each other. Discuss topics you like, share the Love , and Inspirations.
            <p class="faq_note">Note: Politics and news will be prohibited. Positive vibes allowed only on FindersPage. </p>
          </div>
        </div>
      </div>

      <!-------------#15----------------->
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsefifteen" aria-expanded="false" aria-controls="collapsefifteen">
           Are the comments, connections, and views private?

          </button>
        </h2>
        <div id="collapsefifteen" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
          <div class="accordion-body">
             Yes, it will only be viewable to the member. However, the member may turn on or off the comment section at any time.
          </div>
        </div>
      </div>


      <!-------------#16----------------->
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsesixteen" aria-expanded="false" aria-controls="collapseteen">
           Are reviews optional to showcase?

          </button>
        </h2>
        <div id="collapsesixteen" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
          <div class="accordion-body">
            Yes, reviews will be optional under the shopping section and business page to showcase. Members can turn on or off their reviews if they don't want to receive feedback from their clients.
            <br>
            <br>
            Note: If you want to receive more interactions and build traffic flow, it's best to not hide your reviews from the public.
          </div>
        </div>
      </div>

      <!-------------#17----------------->
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseseventeen" aria-expanded="false" aria-controls="collapseseventeen">
           How do I view a member?

          </button>
        </h2>
        <div id="collapseseventeen" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
          <div class="accordion-body">
            Simply click on the members page on the menu bar or on their post. You may click on the members logo to view the profile and connect. Connections are private to the members only. If you want to report a member or block, simply click on the right upper hamburger icon to do so.
          </div>
        </div>
      </div>


      <!-------------#18----------------->
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseeighteen" aria-expanded="false" aria-controls="collapseeighteen">
           How do I receive a verified badge?

          </button>
        </h2>
        <div id="collapseeighteen" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
          <div class="accordion-body">
            A verified badge is a tool to help people find the real accounts of people and brands. If an account has the verified badge, we’ve confirmed that it represents who it says it does. You will have to follow the steps on your account to become verified. A verified badge is not a symbol to show importance, authority or subject matter expertise.
          </div>
        </div>
      </div>

      <!-------------#19----------------->
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseninteen" aria-expanded="false" aria-controls="collapseninteen">
           Refunds?

          </button>
        </h2>
        <div id="collapseninteen" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
          <div class="accordion-body">
            There are no refunds for the subscriptions, paid ads, and bump posts as stated on the terms of use and email confirmation with receipt you receive after placing the order. Thank you for understanding.
          </div>
        </div>
      </div>

      <!-------------#20----------------->
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsetwenty" aria-expanded="false" aria-controls="collapsetwenty">
           Is it good to pin content on your profile?

          </button>
        </h2>
        <div id="collapsetwenty" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
          <div class="accordion-body">
            Pinned posts offer a curated introduction to your brand and ensure users know who you are and what you do after scrolling through your first three posts. Pinned posts boost the reach and engagement of your most important pieces of content.
          </div>
        </div>
      </div>

      <!-------------#21----------------->
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsetwentyone" aria-expanded="false" aria-controls="collapsetwentyone">
           What is the eye emoji for?

          </button>
        </h2>
        <div id="collapsetwentyone" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
          <div class="accordion-body">
            The eye emoji is to notify you the number of views.
            Note: Number of views are only viewable to you for privacy reasons.
          </div>
        </div>
      </div>


      <!-------------#22----------------->
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsetwentytwo" aria-expanded="false" aria-controls="collapsetwentytwo">
           Can public users contact me?

          </button>
        </h2>
        <div id="collapsetwentytwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
          <div class="accordion-body">
            Yes public users can contact you from your posts if you choose to make your contact information public. Note :
            You have the option to show public or keep private from public users that are not registered on the site.
          </div>
        </div>
      </div>
      <!-------------#23----------------->
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsetwentythree" aria-expanded="false" aria-controls="collapsetwentythree">
           What are mini videos?

          </button>
        </h2>
        <div id="collapsetwentythree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
          <div class="accordion-body">
            FindersPage mini videos is a way for anyone to connect with a new audience using just a smartphone and the mini camera in the FindersPage app.
            FindersPage mini creation tools makes it easy to create mini videos that are up to 60 seconds long with our multi-segment camera.
          </div>
        </div>
      </div>

      <!-------------#24----------------->
      <!-- <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsetwentyfour" aria-expanded="false" aria-controls="collapsetwentyfour">
           At what age do you have to be to join FindersPage?

          </button>
        </h2>
        <div id="collapsetwentyfour" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
          <div class="accordion-body">
            To join FindersPage you have to be at-least 17 years of age to Join. <br>
            Note: Further verification will be requested if needed.
          </div>
        </div>
      </div> -->

      <!-------------#25----------------->
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsetwentyfive" aria-expanded="false" aria-controls="collapsetwentyfive">
           Why does the red dot appear on my profile sometimes?
          </button>
        </h2>
        <div id="collapsetwentyfive" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
          <div class="accordion-body">
            The red dot is to notify your connections that you have created a new post. It gets there attention to click on your notification and be directed to your post.
          </div>
        </div>
      </div>

      <!-------------#26----------------->
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsetwentysix" aria-expanded="false" aria-controls="collapsetwentysix">
           Billing
          </button>
        </h2>
        <div id="collapsetwentysix" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
          <div class="accordion-body">
            Some type of categories may have an associated fee. You're allowed to auto repost as well to be placed at the top. To cancel a subscription or auto repost, you must log in and disable the auto repost option before the ad expires.
          </div>
        </div>
      </div>


      <!-------------#27----------------->
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsetwentyseven" aria-expanded="false" aria-controls="collapsetwentyseven">
           Comments
          </button>
        </h2>
        <div id="collapsetwentyseven" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
          <div class="accordion-body">
            You have the option to make your comments private, so they are only visible to you. This way, comments will be hidden from the public. You can update from your dashboard at anytime.
            <br>
            <br>
            Note: Any members that are reported with bad behavior will be banned from FindersPage. FindersPage does not tolerate any bullying. Remember to keep comments respectful and follow the guidelines you agreed to.
          </div>
        </div>
      </div>

      <!-------------#28----------------->
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsetwentyeight" aria-expanded="false" aria-controls="collapsetwentyeight">
           What are long videos for?
          </button> 
        </h2>
        <div id="collapsetwentyeight" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
          <div class="accordion-body">
            Long videos are longer then 60 seconds. Usually 10 mins or longer.
          </div>
        </div>
      </div>

      <!-------------#29----------------->
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsetwentynine" aria-expanded="false" aria-controls="collapsetwentynine">
           Post Images
          </button> 
        </h2>
        <div id="collapsetwentynine" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
          <div class="accordion-body">
            Users are allowed to post up to 10 images at a time using the carousel feature, which is also known as multi-image posts. This feature can help users highlight their images in their profile , tag people, or showcase an array of products and ideas in a single post. To post multiple pictures, users can: Go to the device's gallery,  Select all images to upload, Write a description and hashtags. <br>
            Note: When users  go back to edit their post they're allowed to remove images , but cannot upload any more . And atleast one image has to stay up all times , otherwise you can delete and create a new post.
          </div>
        </div>
      </div>

      <!-------------#30----------------->
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsethirty" aria-expanded="false" aria-controls="collapsetwentynine">
           Will FindersPage pay me if I have 1k followers?
          </button> 
        </h2>
        <div id="collapsethirty" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
          <div class="accordion-body">
           No, FindersPage will not pay you because you've earned 1k or 10k, or 1 million followers. But the platform will surely open doors of opportunities for you to earn through your content once you attain 1000 followers. 

            How do you start off as an influencer?<br>
            1. Select Your Niche.<br>
            2. Optimize Your Social Media Profiles.<br>
            3. Understand Your Audience.<br>
            4. Create and Post Relevant Content.<br>
            5. Be Regular and Consistent.<br>
            6. Engage With Your Audience.<br>
            7. Let Brands Know You're Open to Collaborations. <br>
          </div>
        </div>
      </div>

      <!-------------#31----------------->
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsethirtyone" aria-expanded="false" aria-controls="collapsetwentynine">
           When do the ads expire ?
          </button> 
        </h2>
        <div id="collapsethirtyone" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
          <div class="accordion-body">
           Your free ads placed under jobs, real estate, community, shopping, services, or entertainment will expire after 38 days. If you renew it before the 38 days is up, your ads will stay up for another 38 days. So a little over a month, so you're not stressed. FindersPage wants you to be happy. <br>

            Note: Posts, videos, business page, story time, and fundraiser have no expiration date .
          </div>
        </div>
      </div>

      <!-------------#32----------------->
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsethirtytwo" aria-expanded="false" aria-controls="collapsetwentynine">
           What is auto repost and auto rebump option?
          </button> 
        </h2>
        <div id="collapsethirtytwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
          <div class="accordion-body">
          The auto-repost option will allow you to automatically create a duplicate copy of a paid posting, bump, and subscription plan when it expires. The auto-reposted copy will have the lifespan of a new post and will be placed at the top of the list for users who sort by "newest.
          </div>
        </div>
      </div>
      <!-------------#33----------------->
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsethirtythree" aria-expanded="false" aria-controls="collapsetwentynine">
          What is the age limit to join FindersPage? 
          </button> 
        </h2>
        <div id="collapsethirtythree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
          <div class="accordion-body">
          FindersPage age limit is 18 years and older. If FindersPage learns that someone is under the minimum age, they will ban the account. However, FindersPage doesn't use age verification tools when new users sign up, so teenagers may be able to access inappropriate content without restriction.
          </div>
        </div>
      </div>
      <!-------------#34----------------->
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsethirtyfour" aria-expanded="false" aria-controls="collapsetwentynine">
            How do Creators/ Influencers receive payments on FindersPage?
          </button> 
        </h2>
        <div id="collapsethirtyfour" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
          <div class="accordion-body">
            Creators/ Influencers receive payments by adding the (Thanks) button to their post and linking any payment gateway to receive tips.
          </div>
        </div>
      </div>

    </div>
</section>

@endsection