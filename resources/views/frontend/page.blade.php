<?php use App\Models\Admin\HomeSettings; ?>
@extends('layouts.frontlayout')
@section('content')
<?php  $phone = HomeSettings::get('phonenumber') ?>
<div id="posts-content" class="blog-single use-sidebar">
    <div class="blog-single-header-wrapper post-with-image" style="<?php echo 'background-color: #1e266d;' ?>"><div class="container blog-single-title-meta-wrapper"><div style="display:inline-block"><h1 class="blog-single-title"><?php echo $title ?></h1></div></div></div>
        <div class="container single-post-content">
          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <div id="post-362" class="post-362 post type-post status-publish format-standard has-post-thumbnail hentry category-technology tag-internet tag-mobile tag-popular" style="margin-bottom: 50px;">
                <div class="blog-single-content">
                  <div class="blog-content">
                    <h2>{{ $page_title }}</h2>
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