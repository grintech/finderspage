<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>

<style>
.new-blog-post{height: 550px;overflow: hidden;margin: 0px 0 40px;padding:0px 0;/*background-image: url("https://finderspage.com/public/new_assets/assets/images/search-background.png");background-size: cover;background-repeat: no-repeat;*/}
.blog-img-area{height: 550px;overflow: hidden; position: relative; }
.blog-img-area img{width:100%;height: 550px;object-fit: cover; position: relative;}
.blog-img-caption{position: absolute; left: 0;right: 0;top: 0;bottom: 0;text-align: center;display: flex;justify-content: center;align-items: center;}
.blog-img-caption::before{content: ''; position: absolute; width: 100%; height: 100%; top:0; bottom:0; left:0; right: 0;background-color: rgba(0, 0, 0, 0.4);}
.blog-img-caption h2{color: #fff; position: relative;}
/*.nbdr-r img, .nbdr-r .blog-img-caption, .nbdr-r .blog-img-caption::before{border-radius: 10px 0 0 10px;}
.nbdr-l img, .nbdr-l .blog-img-caption, .nbdr-l .blog-img-caption::before{border-radius: 0px 10px 10px 0px;}*/

.latest-blog-box{border: 1px solid #fcd152; border-radius: 5px;  padding: 0!important;}
.latest-blog-box img{height: 250px; width: 100%;}
.latest-blog-box .thumbnail-video{height: 250px; width: 100%;margin: 0; padding: 0; position: relative;}
.latest-blog-box .card-body{display: block;background-color: #f5f5f5;}
.latest-blog-box .card-title{font-size: 16px; font-weight: 600;display: -webkit-inline-box;-webkit-line-clamp: 2;-webkit-box-orient: vertical;overflow: hidden;text-overflow: ellipsis;}
.latest-blog-box .video-frame1{margin-top: -7px;}
.latest-blog-box .card-text{font-size: 14px;}
.latest-blog-box .card-footer{background-color: #f5f5f5;}
.latest-blog-box .card-footer small{font-size:12px;}

.shop-blog-post{background-color: #ececeb;}
.shop-blog-box {height: 250px;text-shadow: 0 1px 3px rgba(0,0,0,0.6);background-size: cover !important;color: white;position: relative;border-radius: 5px;margin-bottom: 20px;}
.shop-blog-box .card-description {position: absolute;bottom: 10px;left: 10px;}
.shop-blog-box .card-description h5 {font-size: 20px;}
.shop-blog-box .card-link {position: absolute;left: 0;top: 0;bottom: 0;width: 100%;z-index:2;background: black;opacity: 0;}
.card-link:hover{opacity: 0.1;}
.bottom-block{position: relative;height: 380px; margin-bottom: 300px;padding-top: 50px;background-color: #ececeb;}
.bottom-frame-area{position: relative; }
.bottom-frame-area .rt-img{width: 100%;height: 450px;object-fit: cover;}
.bottom-blog-box{width: 40%!important; padding:0!important; text-align: center;}
.bottom-blog-box .card-img{height: 250px; object-fit: cover;}
.bottom-blog-box .card-text{font-size: 14px;display: -webkit-inline-box;-webkit-line-clamp: 2;-webkit-box-orient: vertical;overflow: hidden;text-overflow: ellipsis;}
.bottom-blog-box .card-body{display: block;}

@media only screen and (max-width:767px){
.new-blog-post{height: auto;}	
.blog-img-area img{height: 200px;}
.blog-img-area{height: auto; overflow:visible;}	
.latest-blog-box img {height: 250px;}
.bottom-blog-box{width: 90%!important; padding:0!important; text-align: center;}
}
</style>	
</head>
<body>
<?php use App\Models\UserAuth; ?>
@extends('layouts.frontlayout')
@section('content')

<section class="new-blog-post">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-6 col-md-6 col-6 gx-0 nbdr-r">
				<div class="blog-img-area">
					<img src="https://finderspage.com/public/images_blog_img/bg1.jpg" alt="img1" class="img-fluid">
					<div class="blog-img-caption">
						<h2>Blogs</h2>
					</div>
				</div>
			</div>
			<div class="col-lg-6 col-md-6 col-6 gx-0 nbdr-l">
				<div class="blog-img-area">
					<img src="https://finderspage.com/public/images_blog_img/bg2.jpg" alt="Polar Bear Penguin Outdoor Decoration" alt="img1" class="img-fluid">
					<div class="blog-img-caption">
						<h2>Videos</h2>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="latest-blog-post py-4">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-12">
				<h4 class="text-center">Latest Posts</h4>
			</div>
			<div class="col-lg-3 col-md-3 gx-5">
				<div class="card latest-blog-box">
					<a href="#">
						<img src="https://www.finderspage.com/public/images_blog_img/1700830040_Rz1SdnvPJHiRIkw-1675427341.jpeg" class="card-img-top" alt="img">
						<div class="card-body p-4">
						    <h5 class="card-title">Black Gem Square Necklace</h5>
						</div>
						<div class="card-footer">
					      <small class="text-muted">Last updated 3 mins ago</small>
					    </div>
					</a>
				</div>
			</div>
			<div class="col-lg-3 col-md-3 gx-5">
				<div class="card latest-blog-box">
					<a href="#">
						<video class="thumbnail-video" controls="" src="https://www.finderspage.com/public/video_short/1704352273.mov" loop="">
						   <track default="" kind="captions" srclang="en" src="https://www.finderspage.com/public/assets/your-subtitles.vtt">
						</video>
						<div class="card-body p-4 video-frame1">
						    <h5 class="card-title">Eyelash Tint & Brow Lami</h5>
						</div>
						<div class="card-footer">
					      <small class="text-muted">Last updated 3 mins ago</small>
					    </div>
					</a>
				</div>
			</div>
			<div class="col-lg-3 col-md-3 gx-5">
				<div class="card latest-blog-box">
					<a href="#">
						<img src="https://www.finderspage.com/public/images_blog_img/1700828238_54671-chsmtg.jpg" class="card-img-top" alt="img">
						<div class="card-body p-4">
						    <h5 class="card-title">Polar Bear Penguin Decoration</h5>
						</div>
						<div class="card-footer">
					      <small class="text-muted">Last updated 2 days ago</small>
					    </div>
					</a>
				</div>
			</div>
			<div class="col-lg-12 text-center">
              <a href="#" class="btn fields-search text-center">View All</a>
            </div>
		</div>
	</div>
</section>

<section class="shop-blog-post py-4">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<h4 class="text-center">Shop the Look</h4>
			</div>
			<div class="col-lg-3 col-md-3 gx-5">
	            <div class="card shop-blog-box" style="background: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.2)), url('https://www.finderspage.com/public/images_blog_img/1700826567_54634-ofr4sc-416x416.jpeg');">
		            <div class="card-description">
		                <h5>Card Title</h5>
		                <p>Lovely house</p>
		            </div>
		            <a class="card-link" href="#" ></a>
	            </div>
	        </div>
			<div class="col-lg-3 col-md-3 gx-5">
	            <div class="card shop-blog-box" style="background: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.2)), url('https://www.finderspage.com/public/images_blog_img/1700829071_56010-eza4di.jpg');">
		            <div class="card-description">
		                <h5>Card Title</h5>
		                <p>Lovely house</p>
		            </div>
		            <a class="card-link" href="#" ></a>
	            </div>
	        </div>
			<div class="col-lg-3 col-md-3 gx-5">
	            <div class="card shop-blog-box" style="background: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.2)), url('https://www.finderspage.com/public/images_blog_img/1700825272_56326-1rjivx-416x416.jpeg');">
		            <div class="card-description">
		                <h5>Card Title</h5>
		                <p>Lovely house</p>
		            </div>
		            <a class="card-link" href="#" ></a>
	            </div>
	        </div>
            <div class="col-lg-3 col-md-3 gx-5">
	            <div class="card shop-blog-box" style="background: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.2)), url('https://www.finderspage.com/public/images_blog_img/1700828735_54728-9kxdxm.jpg');">
		            <div class="card-description">
		                <h5>Card Title</h5>
		                <p>Lovely house</p>
		            </div>
		            <a class="card-link" href="#" ></a>
	            </div>
	        </div>

			<div class="col-lg-12 text-center">
              <a href="#" class="btn fields-search text-center">View All</a>
            </div>
		</div>
	</div>
</section>

<section class="bottom-block">
	<div class="container-fluid">
		<div class="row bottom-frame-area">
			<div class="col-lg-6 gx-0">
				<div class="card bottom-blog-box">
					<a href="#">
						<h5 class="card-title p-2">Black Gem Square Necklace</h5>
						<img src="https://www.finderspage.com/public/images_blog_img/bg4.jpg" class="card-img" alt="img">
						<div class="card-body p-4">
						    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
						    <div><a href="#" class="btn fields-search text-center">Read More</a></div>
						</div>
					</a>
				</div>
			</div>
			<div class="col-lg-6 gx-0">
				<img src="https://www.finderspage.com/public/images_blog_img/bg3.jpg" class="img-fluid rt-img">
			</div>
		</div>
	</div>
</section>

@endsection

</body>
</html>