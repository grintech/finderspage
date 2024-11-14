@if($communityfeaturedPost->isNotEmpty())
<h4 class="text-center pb-1">Community</h4>
    <div class="container">
        <div class="row">
                @foreach($communityfeaturedPost as $feature)
                  <div class="col-lg-2 col-md-4 col-sm-12 col-12">
                                    
                    <div class="feature-box">
                          <span class="onsale">Featured!</span>
                          <a href="{{route('community_single_post',$feature->slug)}}">
                        <div id="demo-new" class="carousel1 slide">
                            <!-- Indicators/dots -->
                            <!-- The slideshow/carousel -->
                            <div class="carousel-inner">
                                <?php
                                    $itemFeaturedImages = trim($feature->image1,'[""]');
                                    $itemFeaturedImage  = explode('","',$itemFeaturedImages);
                                    if(is_array($itemFeaturedImage)) {
                                        foreach($itemFeaturedImage as $keyitemFeaturedImage => $valueitemFeaturedImage) { if($keyitemFeaturedImage == 0) {$class='active'; } else { $class='in-active'; } ?>
                                                <div class="carousel-item <?= $class; ?>">
                                                    <img src="{{asset('images_blog_img')}}/{{ $valueitemFeaturedImage }}" alt="Los Angeles" class="d-block w-100" onerror="this.onerror=null; this.src=\'' . asset('images_blog_img/1688636936.jpg') . '\'">
                                                </div>
                                        <?php }     
                                    }
                                ?>
                                
                                
                            </div>
                        </div>

                        <div class="Name">
                             
                             <p class="job-title"><b>{{ ucfirst($feature->title) }}</b>
                        </div>
                        
                       <div class="main-days-frame">
                              
                                <span class="days-box"> 
                                <?php
                                    $givenTime = strtotime($feature->created);
                                    $currentTimestamp = time();
                                    $timeDifference = $currentTimestamp - $givenTime;

                                    $days = floor($timeDifference / (60 * 60 * 24));
                                    $hours = floor(($timeDifference % (60 * 60 * 24)) / (60 * 60));
                                    $minutes = floor(($timeDifference % (60 * 60)) / 60);
                                    $seconds = $timeDifference % 60;
                                    
                                    $timeAgo = "";
                                        if ($days > 0) {
                                            if ($days == 1) {
                                                $timeAgo .= $days . " day ago ";
                                            } else {
                                                $timeAgo .= $days . " days ago ";
                                            }
                                        } else {
                                            $timeAgo .= "Posted today"; 
                                        }
                                        echo $timeAgo;
                                    ?>

                                </span>
                            </div>
                        </a>

                        <div class="button-sell" style="margin-top: 0px;">
                            <span><a href="{{route('community_single_post',$feature->slug)}}" class="btn create-post-button" data-product-id="{{$feature->id}}">View details</a></span>
                        </div>
                        </div>

                    </div>
                @endforeach
            </div>
            
            <div class="col-lg-12 text-center" bis_skin_checked="1">
                <a href="{{route('communityViewAll')}}" class="btn fields-search">View All</a>
            </div>
        </div>
    </div>
@endif
    