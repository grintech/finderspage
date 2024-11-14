<?php
use App\Models\UserAuth;

?>

<style type="text/css">
  .slick-slider .element{
  height:270px;
  width:100%;
/*  background-color:#000;*/
  color:#fff;
  border-radius:5px;
  display:inline-block;
  margin:0px !important;
  display:-webkit-box;
  display:-ms-flexbox;
  display:flex;
  -webkit-box-pack:center;
      -ms-flex-pack:center;
          justify-content:center;
  -webkit-box-align:center;
      -ms-flex-align:center;
          align-items:center;
  font-size:20px;
}
.slick-slider .element .feature-box{width: 100%; height: 100%; margin-bottom: 0;}
.slick-slider .slick-disabled {
  opacity : 0; 
  pointer-events:none;
}
.slick-slider .element .card.shop-box{height: 100%;}

.review li i {
  font-size: 1rem !important;
}
</style>


<h4 class="text-center pb-1">Shop Now</h4>
<div class="container">
  <div class="row d-flex justify-content-center slick-slider shop-slide">
      @foreach($shopping as $shop)
      <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-3">
          <div class="element element-1">
              <div class="card shop-box p-2">
                  <span class="onsale">Featured!</span>
                  <?php $useid = UserAuth::getLoginId(); ?>

                  <a href="{{ route('shopping_post_single', $shop->slug) }}">
                      <div id="demo-new-slide" class="slick-carousal">
                          <?php
                              $neimg = trim($shop->image1, '[""]');
                              $img = explode('","', $neimg);

                              if (is_array($img)) {
                                  foreach ($img as $keyitemFeaturedImage => $valueitemFeaturedImage) { ?>
                                  <div id="demo-new1" class="slick-carousal">
                                      <img src="{{ asset('images_blog_img') }}/{{ $valueitemFeaturedImage }}" alt="Image" class="d-block w-100" onerror="this.onerror=null; this.src='https://finder.harjassinfotech.org/public/images_blog_img/1688636936.jpg';">
                                  </div>
                          <?php } } ?>
                      </div>
                      
                      <div class="caption texts-center">
                          <a href="{{ route('shopping_post_single', $shop->slug) }}">
                              <h6 class="product-title">{{ $shop->title }}</h6>
                          </a>
                          <div class="price">
                              Price
                              <del style="font-size: 13px;">${{ $shop->product_price }}</del>
                              <span style="font-size: 13px;">${{ $shop->product_sale_price }}</span>
                          </div>
                      </div>

                      {{-- Display star rating --}}
                      @php
                          $totalRating = 0;
                          $reviewsForProduct = $allreview->where('product_id', $shop->id);
                          $totalReviews = count($reviewsForProduct);
                      @endphp

                      @if($totalReviews > 0)
                          @foreach($reviewsForProduct as $review)
                              @php $totalRating += $review->rating; @endphp
                          @endforeach

                          @php
                              $averageRating = $totalRating / $totalReviews;
                              $fullStars = floor($averageRating);
                              $halfStar = ($averageRating - $fullStars) >= 0.5 ? 1 : 0;
                              $emptyStars = 5 - $fullStars - $halfStar;
                          @endphp

                          <div class="average-rating">
                              <ul class="review">
                                  @for ($i = 0; $i < $fullStars; $i++)
                                      <li><i class="bi bi-star-fill"></i></li>
                                  @endfor
                                  @if ($halfStar)
                                      <li><i class="bi bi-star-half"></i></li>
                                  @endif
                                  @for ($i = 0; $i < $emptyStars; $i++)
                                      <li><i class="bi bi-star"></i></li>
                                  @endfor
                              </ul>
                          </div>
                      @else
                          <div class="average-rating">
                              <ul class="review">
                                  @for ($i = 0; $i < 5; $i++)
                                      <li><i class="bi bi-star"></i></li>
                                  @endfor
                              </ul>
                          </div>
                      @endif

                      <div class="button-sell" style="margin-top: 0px;">
                          <a href="{{ route('shopping_post_single', $shop->slug) }}" class="btn create-post-button" data-product-id="{{ $shop->id }}">View Details</a>
                      </div>
                  </a>
              </div>
          </div>
      </div>
      @endforeach

      <div class="col-lg-12 text-center">
          <a href="{{ route('shoppingViewAll') }}" class="btn fields-search">View All</a>
      </div>
  </div>
  <div class="row"></div>
</div>


    <script type="text/javascript">  
    $(".shop-slider1").slick({
        dots: false,
        arrows: false,
       slidesToShow: 6,
       infinite:true,
       slidesToScroll: 1,
       autoplay: true,
       autoplaySpeed: 2000,
      responsive: [
      {
        breakpoint: 1200,
        settings: {
          slidesToShow: 4
        }
      },
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 3
        }
      },
      {
        breakpoint: 800,
        settings: {
          slidesToShow: 2
        }
      },
      {
        breakpoint: 600,
        settings: {
          slidesToShow: 1
        }
      }
    ]
  });


  $('.slick-carousal').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2000, // Adjust as needed
        dots: false,
    });

// Image Slider Demo:
// https://codepen.io/vone8/pen/gOajmOo
    </script>