<!-- <div class="slider">
        @foreach($video as $vid)
          <div class="col-lg-3 col-md-6 col-sm-6 col-6 columnJoblistig mb-3">
            <a href="{{route('single.video', $vid->id)}}">
                <div class="thumb-video-box">
                    <div class="thumbnail-container">
                      <img class="thumbnail-image" src="{{asset('video_short')}}/{{$vid->image}}" alt="Video Thumbnail">
                      <video class="thumbnail-video" autoplay muted loop>
                          <source src="{{asset('video_short')}}/{{$vid->video}}" type="video/mp4">
                          Your browser does not support the video tag.
                      </video>
                  </div>
                  <div class="thumbnail-caption">
                    <h6 class="mb-0">{{$vid->title}}</h6>
                    <small>15 Views</small>
                  </div>
                </div>
              </a>
          </div>
          @endforeach  
    </div> -->

<style type="text/css">
  .slick-slider.video-gallery {
    margin-bottom: 0;
  }

  .slick-slider.video-gallery .element {
    height: 362px;
    width: 100%;
    /*  background-color:#000;*/
    color: #fff;
    border-radius: 5px;
    display: inline-block;
    margin: 0px 10px;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    font-size: 20px;
  }

  .slick-slider .element .feature-box {
    width: 100%;
    height: 100%;
    margin-bottom: 0;
  }

  .slick-slider .slick-disabled {
    opacity: 0;
    pointer-events: none;
  }

  .slick-slider .element .card.shop-box {
    height: 100%;
  }

  @media only screen and (max-width:767px) {
    .slick-slider.video-gallery .element {
      height: 340px;
    }
  }
</style>

<h4 class="text-center pb-1"> Videos</h4>
<div class="container">
  <div class="row">
    <div class="slick-slider video-gallery">
      @foreach($video as $vid)
      <div class="element element-1">


        <div class="columnJoblistig mb-3">
          <a href="{{route('single.video', $vid->id)}}">
            <div class="thumb-video-box">
              <div class="thumbnail-container">
                <video class="thumbnail-video" loop muted playsinline="playsinline" poster="https://www.finderspage.com/public/{{$vid->image}}">
                  <source src="{{ asset('video_short') }}/{{ $vid->video }}" type="video/mp4">
                  <source src="{{ asset('video_short') }}/{{ $vid->video }}" type="video/webm">
                  <source src="{{ asset('video_short') }}/{{ $vid->video }}" type="video/mov">
                </video>
              </div>
              <div class="thumbnail-caption">
                <h6 class="mb-0">{{$vid->title}}</h6>
              </div>
              @if(!empty($vid->location))
              <div>
                <p style="font-size: 8px; margin-top: 5px;">
                  <i class="fa fa-map-marker" aria-hidden="true"></i>
                  {{ $vid->location }}
                </p>
              </div>
              @endif
            </div>
          </a>
        </div>

      </div>
      @endforeach
    </div>
    <div class="col-lg-12 text-center" bis_skin_checked="1">
      <a href="{{route('videoViewAll')}}" class="btn fields-search">View All</a>
    </div>

  </div>
  <script type="text/javascript">
    $(".video-gallery").slick({
      dots: false,
      arrows: false,
      slidesToShow: 6,
      infinite: true,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 2000,
      responsive: [{
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


    // Image Slider Demo:
    // https://codepen.io/vone8/pen/gOajmOo
  </script>