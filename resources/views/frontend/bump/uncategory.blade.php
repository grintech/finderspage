                        @if($listing_data->isEmpty() && $entertainment->isEmpty() && $blogs->isEmpty())

                            <div class="div_blank text-center p-5">
                                <h5>No data found under this category.</h5>
                            </div>
                        @else
                        @foreach($listing_data as $services)
                                <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                                    <div class="feature-box afterBefor" style="position: relative;">
                                        @if($services->bumpPost=="1")
                                        <div class="ribbon bump-ribbon" data-toggle="tooltip" data-placement="top" title="This  is bump listing .">
                                            <div class="text-div">
                                                Bumped
                                            </div>
                                        </div>
                                        @endif
                                        @if($id == 2)
                                            <a href="{{route('jobpost',$services->slug)}}">
                                        @elseif($id == 4)
                                            <a href="{{route('real_esate_post',$services->slug)}}">
                                        @elseif($id == 5)
                                            <a href="{{route('community_single_post',$services->slug)}}">
                                        @elseif($id == 6)
                                            <a href="{{route('shopping_post_single',$services->slug)}}">
                                        @elseif($id == 705)
                                            <a href="{{route('service_single',$services->slug)}}">
                                        @elseif($id == 728)
                                            <a href="{{route('blogPostSingle',$services->slug)}}">
                                        @elseif($id == 741)
                                            <a href="{{route('Entertainment.single.listing',$services->slug)}}">
                                        @endif
                                            <div class="img-area">
                                                

                                               
                                                @if($id == 2)
                                                    <?php
                                                        $neimg = trim($services->image1, '[""]');
                                                        $img  = explode('","', $neimg);
                                                    ?>
                                                    @if($services->image1)
                                                        <img src="{{asset('images_blog_img')}}/{{$img[0]}}" alt="{{$services->title}}" class="d-block w-100">
                                                    @else
                                                        <img src="{{asset('new_assets/assets/images/home.png')}}" alt="New York" class="d-block w-100">
                                                    @endif
                                                @elseif($id == 4)
                                                    <?php
                                                        $neimg = trim($services->image1, '[""]');
                                                        $img  = explode('","', $neimg);
                                                    ?>
                                                    @if($services->image1)
                                                        <img src="{{asset('images_blog_img')}}/{{$img[0]}}" alt="{{$services->title}}" class="d-block w-100">
                                                    @else
                                                        <img src="{{asset('new_assets/assets/images/home.png')}}" alt="New York" class="d-block w-100">
                                                    @endif
                                                @elseif($id == 5)
                                                    <?php
                                                        $neimg = trim($services->image1, '[""]');
                                                        $img  = explode('","', $neimg);
                                                    ?>
                                                    @if($services->image1)
                                                       <img src="{{asset('images_blog_img')}}/{{$img[0]}}" alt="{{$services->title}}" class="d-block w-100">
                                                       @else
                                                        <img src="{{asset('new_assets/assets/images/home.png')}}" alt="New York" class="d-block w-100">
                                                    @endif
                                                @elseif($id == 6)
                                                    <?php
                                                        $neimg = trim($services->image1, '[""]');
                                                        $img  = explode('","', $neimg);
                                                    ?>
                                                    @if($services->image1)
                                                        <img src="{{asset('images_blog_img')}}/{{$img[0]}}" alt="{{$services->title}}" class="d-block w-100">
                                                    @else
                                                        <img src="{{asset('new_assets/assets/images/home.png')}}" alt="New York" class="d-block w-100">
                                                    @endif
                                                @elseif($id == 705)
                                                    <?php
                                                        $neimg = trim($services->image1, '[""]');
                                                        $img  = explode('","', $neimg);
                                                    ?>
                                                    @if($services->image1)
                                                        <img src="{{asset('images_blog_img')}}/{{$img[0]}}" alt="{{$services->title}}" class="d-block w-100">
                                                    @else
                                                        <img src="{{asset('new_assets/assets/images/home.png')}}" alt="New York" class="d-block w-100">
                                                    @endif

                                                @elseif($id == 728)
                                                <?php
                                                        
                                                        $img  = explode(',', $services->image);
                                                    ?>
                                                    @if($services->image)
                                                        <img src="{{asset('images_blog_img')}}/{{$img[0]}}" alt="{{$services->title}}" class="d-block w-100">
                                                        @else
                                                        <img src="{{asset('new_assets/assets/images/home.png')}}" alt="New York" class="d-block w-100">
                                                    @endif
                                                @elseif($id == 741)
                                                    <?php
                                                        $neimg = trim($services->image, '[""]');
                                                        $img  = explode('","', $neimg);
                                                    ?>
                                                    @if($services->image)
                                                        <img src="{{asset('images_entrtainment')}}/{{$img[0]}}" alt="{{$services->title}}" class="d-block w-100">
                                                        @else
                                                        <img src="{{asset('new_assets/assets/images/home.png')}}" alt="New York" class="d-block w-100">
                                                    @endif
                                                @endif
                                            
                                                
                                            </div>
                                            <div class="job-post-content">
                                                <h4>{{$services->title}}</h4>
                                                <div class="main-days-frame">
                                                    <span class="days-box">
                                                        <?php
                                                        if($id==2){
                                                            $givenTime = strtotime($services->created);
                                                        }elseif($id==4){
                                                            $givenTime = strtotime($services->created);
                                                        }elseif($id==5){
                                                            $givenTime = strtotime($services->created);
                                                        }elseif($id==6){
                                                            $givenTime = strtotime($services->created);
                                                        }elseif($id==705){
                                                            $givenTime = strtotime($services->created);
                                                        }elseif($id==728){
                                                            $givenTime = strtotime($services->created_at);
                                                        }elseif($id==741){
                                                            $givenTime = strtotime($services->created_at);
                                                        }
                                                        // $givenTime = strtotime($services->created_at);
                                                        $currentTimestamp = time();
                                                        $timeDifference = $currentTimestamp - $givenTime;

                                                        $days = floor($timeDifference / (60 * 60 * 24));
                                                        $hours = floor(($timeDifference % (60 * 60 * 24)) / (60 * 60));
                                                        $minutes = floor(($timeDifference % (60 * 60)) / 60);
                                                        $seconds = $timeDifference % 60;

                                                        $timeAgo = "";
                                                        if ($days > 0) {
                                                            if ($days == 1) {
                                                                $timeAgo .= $days . " Day Ago ";
                                                            } else {
                                                                $timeAgo .= $days . " Days Ago ";
                                                            }
                                                        } else {
                                                            $timeAgo .= "Posted today";
                                                        }

                                                        // if ($minutes > 0) {
                                                        //     $timeAgo .= $minutes . " min, ";
                                                        // }
                                                        // $timeAgo .= $seconds . " sec ago";

                                                        echo $timeAgo;
                                                        ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                @endforeach



                                @foreach($entertainment as $services)
                                <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                                    <div class="feature-box afterBefor" style="position: relative;">
                                        @if($services->bumpPost=="1")
                                        <div class="ribbon bump-ribbon" data-toggle="tooltip" data-placement="top" title="This  is bump listing .">
                                            <div class="text-div">
                                                Bumped
                                            </div>
                                        </div>
                                        @endif
                                        
                                            <a href="{{route('Entertainment.single.listing',$services->slug)}}">
                                       
                                            <div class="img-area">
                                                    <?php
                                                        $neimg = trim($services->image, '[""]');
                                                        $img  = explode('","', $neimg);
                                                    ?>
                                                    @if($services->image)
                                                        <img src="{{asset('images_entrtainment')}}/{{$img[0]}}" alt="{{$services->title}}" class="d-block w-100">
                                                        @else
                                                        <img src="{{asset('new_assets/assets/images/home.png')}}" alt="New York" class="d-block w-100">
                                                    @endif
                                            </div>
                                            <div class="job-post-content">
                                                <h4>{{$services->title}}</h4>
                                                <div class="main-days-frame">
                                                    <span class="days-box">
                                                        <?php
                                                        
                                                        $givenTime = strtotime($services->created_at);
                                                        $currentTimestamp = time();
                                                        $timeDifference = $currentTimestamp - $givenTime;

                                                        $days = floor($timeDifference / (60 * 60 * 24));
                                                        $hours = floor(($timeDifference % (60 * 60 * 24)) / (60 * 60));
                                                        $minutes = floor(($timeDifference % (60 * 60)) / 60);
                                                        $seconds = $timeDifference % 60;

                                                        $timeAgo = "";
                                                        if ($days > 0) {
                                                            if ($days == 1) {
                                                                $timeAgo .= $days . " Day Ago ";
                                                            } else {
                                                                $timeAgo .= $days . " Days Ago ";
                                                            }
                                                        } else {
                                                            $timeAgo .= "Posted today";
                                                        }

                                                        // if ($minutes > 0) {
                                                        //     $timeAgo .= $minutes . " min, ";
                                                        // }
                                                        // $timeAgo .= $seconds . " sec ago";

                                                        echo $timeAgo;
                                                        ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                @endforeach


                                @foreach($blogs as $services)
                                <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                                    <div class="feature-box afterBefor" style="position: relative;">
                                        @if($services->bumpPost=="1")
                                        <div class="ribbon bump-ribbon" data-toggle="tooltip" data-placement="top" title="This  is bump listing .">
                                            <div class="text-div">
                                                Bumped
                                            </div>
                                        </div>
                                        @endif
                                      
                                            <a href="{{route('blogPostSingle',$services->slug)}}">
                                     
                                            <div class="img-area">
                                                <?php
                                                        
                                                        $img  = explode(',', $services->image);
                                                    ?>
                                                    @if($services->image)
                                                        <img src="{{asset('images_blog_img')}}/{{$img[0]}}" alt="{{$services->title}}" class="d-block w-100">
                                                        @else
                                                        <img src="{{asset('new_assets/assets/images/home.png')}}" alt="New York" class="d-block w-100">
                                                    @endif
                                                
                                              
                                            
                                                
                                            </div>
                                            <div class="job-post-content">
                                                <h4>{{$services->title}}</h4>
                                                <div class="main-days-frame">
                                                    <span class="days-box">
                                                        <?php
                                                        $givenTime = strtotime($services->created_at);
                                                        $currentTimestamp = time();
                                                        $timeDifference = $currentTimestamp - $givenTime;

                                                        $days = floor($timeDifference / (60 * 60 * 24));
                                                        $hours = floor(($timeDifference % (60 * 60 * 24)) / (60 * 60));
                                                        $minutes = floor(($timeDifference % (60 * 60)) / 60);
                                                        $seconds = $timeDifference % 60;

                                                        $timeAgo = "";
                                                        if ($days > 0) {
                                                            if ($days == 1) {
                                                                $timeAgo .= $days . " Day Ago ";
                                                            } else {
                                                                $timeAgo .= $days . " Days Ago ";
                                                            }
                                                        } else {
                                                            $timeAgo .= "Posted today";
                                                        }

                                                        // if ($minutes > 0) {
                                                        //     $timeAgo .= $minutes . " min, ";
                                                        // }
                                                        // $timeAgo .= $seconds . " sec ago";

                                                        echo $timeAgo;
                                                        ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                @endforeach
                            
                            @endif