@php
use App\Models\UserAuth;
use App\Models\Setting;
@endphp

@if($EntertainmentfeaturedPost->isNotEmpty())
<h4 class="text-center pb-1">Entertainment Industry</h4>
    <div class="container">
        <div class="row">
            @foreach($EntertainmentfeaturedPost as $feature)
             <div class="col-lg-2 col-md-6 col-sm-12 col-12 columnJoblistig mb-3">
                <div class="feature-box">
                    <span class="onsale">Featured!</span>
                        <a href="{{route('Entertainment.single.listing',$feature->slug)}}">   
                        <div id="demo-new" class="">

                            <div class="carousel-inner">
                                <?php
                                    $itemFeaturedImage  = explode(',',$feature->image);

                                    if(is_array($itemFeaturedImage)) {
                                        foreach($itemFeaturedImage as $keyitemFeaturedImage => $valueitemFeaturedImage) { if($keyitemFeaturedImage == 0) {$class='active'; } else { $class='in-active'; } ?>

                                                <div class="carousel-item <?= $class; ?>">
                                                    <img src="{{asset('images_entrtainment')}}/{{ $valueitemFeaturedImage }}" alt="Los Angeles" class="d-block w-100" onerror="this.onerror=null; this.src='{{ asset('images_blog_img/1688636936.jpg') }}';">
                                                </div>
                                        <?php }     
                                    }
                                ?>
                                
                                
                            </div>
                        </div>

                            <p class="job-title">{{ ucfirst($feature->Title) }}</p>
                            <div class="main-days-frame">
                               
                           
                                <span class="days-box"> 
                                <?php
                                    $givenTime = strtotime($feature->created_at);
                                    $days = floor((time() - $givenTime) / (60 * 60 * 24));
                                    echo $days > 0 ? Setting::get_formeted_time($days) : 'Posted today.';
                                ?>
                                </span>
                            </div>
                          </a> 

                          <div class="button-sell" style="margin-top: 0px;">
                                <span><a href="{{route('Entertainment.single.listing',$feature->slug)}}" class="btn create-post-button" data-product-id="{{$feature->id}}">View details</a></span>
                            </div>
                        </div>
                    
                </div>
                    
                   
                @endforeach
            
            <div class="col-lg-12 text-center" bis_skin_checked="1">
                <a href="{{route('entertainmentViewAll')}}" class="btn fields-search">View All</a>
            </div>
        </div>
    </div>
@endif
    