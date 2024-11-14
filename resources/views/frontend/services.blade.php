<?php use App\Models\Admin\HomeSettings; ?>
@extends('layouts.frontlayout')
@section('content')
<?php  $phone = HomeSettings::get('phonenumber') ?>
<div id="posts-content" class="blog-single use-sidebar">
    <div class="blog-single-header-wrapper post-with-image" style="<?php echo $page->image ? '    background-size: cover;background-image:url(\'' . url($page->getResizeImagesAttribute()['large']) . '\')' : 'background-color: #1e266d;'; ?>"><div class="container blog-single-title-meta-wrapper"><div style="display:inline-block"><h1 class="blog-single-title"><?php echo $page->title ?></h1></div></div></div>
        <div class="container single-post-content">
          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
              
              <div id="post-362" class="post-362 post type-post status-publish format-standard has-post-thumbnail hentry category-technology tag-internet tag-mobile tag-popular">
                <div class="blog-single-content">
                  <div class="blog-content">
                    <h2>{{ $page->page_title }}</h2>
                    <?php echo str_replace(["&nbsp;",'<p></p>', '<ul></ul>', '<li></li>'], ['', '', ''], $page->description) ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 post-sticky-sidebar">
              <div class="right-sidebar">
                <div id="search-2" class="blog_widget widget widget_search">
                  <div class="textwidget">
                    <div class="orange-bar">
                      <div class="org-txt">Same Day Service<br>
                          <span>Call Now :</span> <b><a href="tel:{{$phone}}">{{ $phone }}</a></b><br>7 DAYS A WEEK<br>8am to 8pm
                      </div>
                      <p class="btn-row">
                          <a href="javascript:;" class="btn scroll-to" data-attr="#contact-us">Request a Service</a>
                      </p>
                    </div>
                  </div>
                </div>
                <div id="categories-3" class="blog_widget widget widget_categories">
                  <h5 class="widget-title">
                    <span>Service Areas</span>
                  </h5>
                  <?php 
                  $services = HomeSettings::get('other_services_list');
                  $services = $services ? explode("\n", $services) : [];
                  $services = array_filter($services);
                  ?>
                  <ul>
                    <?php foreach ($services as $key => $value): ?>
                    <li class="cat-item cat-item-1">
                      <a href="javacsript:;"><?php echo $value ?></a>
                    </li>
                    <?php endforeach; ?>
                  </ul>
                </div>
              </div>
            </div>
          </div>
           @include('inc.testimonial')
        <div class="vc_row-full-width vc_clearfix"></div>
        @include('inc.callus')
        <div class="vc_row-full-width vc_clearfix"></div>
        @include('inc.contact_us')
        <div class="vc_row-full-width vc_clearfix"></div>
        </div>
      </div>

@endsection