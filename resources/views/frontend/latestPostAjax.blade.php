<?php
use App\Models\UserAuth;
use App\Models\Setting;
//dd($Latest_posts);
?>
<h4 class="text-center pb-4 pt-4">Latest Post</h4>
    <div class="row">
        @foreach($Latest_posts as $post)
        @if($post->category_id == 2)
        <div class="col-lg-2 col-md-4 col-sm-6 col-6">
            
                <div class="feature-box">
                <?php $useid = UserAuth::getLoginId();?>
                            @if($existingRecord->contains('post_id', $post->id) && $existingRecord->contains('user_id', $useid) && !empty($useid))
                                <div data-postid="{{$post->id}}" data-Userid="{{UserAuth::getLoginId()}}" class="save-btn saved_post_btn" title="Save"><i class="fa fa-check" aria-hidden="true"></i>  Saved</div>
                            @else
                                <div data-postid="{{$post->id}}" data-Userid="{{UserAuth::getLoginId()}}" class="save-btn saved_post_btn" title="Save">Save</div>
                            @endif
                    <a href="{{route('jobpost',$post->id)}}">  
                <div id="demo-new" class="carousel slide" data-bs-ride="carousel">
                    
                    <div class="carousel-inner">
                        <?php
                        $neimg = trim($post->image1,'[""]');
                        $img  = explode('","',$neimg);
                        ?>
                        @if($post->image1)
                            <img src="{{asset('images_blog_img')}}/{{$img[0]}}" alt="{{$post->title}}" class="d-block w-100">
                        @else
                            <img src="{{asset('images_blog_img/1688636936.jpg')}}" alt="New York" class="d-block w-100">
                        @endif
                        
                        
                    </div>
                </div>

                    <p class="job-title"><b>{{ ucfirst($post->title) }}</b></p>
                    <div class="location-job-title">
                        <div class="job-type">
                            <div class="main-days-frame">
                                         
                                            <span class="days-box"> 
                                            <?php
                                                $givenTime = strtotime($post->created);
                                                $days = floor((time() - $givenTime) / (60 * 60 * 24));

                                                echo $days > 0 ? Setting::get_formeted_time($days) : 'Posted today';
                                            ?>
                                            </span>
                                        </div>
                        </div>
                        
                    </div>
                    
                        </a>
                </div>
            
        </div>
        @endif

        @if($post->category_id == 4)
            <div class="col-lg-2 col-md-4 col-sm-6 col-6">
            
            <div class="feature-box">
                <?php $useid = UserAuth::getLoginId();?>
                            @if($existingRecord->contains('post_id', $post->id) && $existingRecord->contains('user_id', $useid) && !empty($useid))
                                <div data-postid="{{$post->id}}" data-Userid="{{UserAuth::getLoginId()}}" class="save-btn saved_post_btn" title="Save"><i class="fa fa-check" aria-hidden="true"></i>  Saved</div>
                            @else
                                <div data-postid="{{$post->id}}" data-Userid="{{UserAuth::getLoginId()}}" class="save-btn saved_post_btn" title="Save">Save</div>
                            @endif
                    <a href="{{route('real_esate_post',$post->id)}}">
                    <div class="img-area">
                    <?php
                        $neimg = trim($post->image1,'[""]');
                        $img  = explode('","',$neimg);
                    ?>
                    @if($post->image1)
                        <img src="{{asset('images_blog_img')}}/{{$img[0]}}" alt="{{$post->title}}" class="d-block w-100">
                    @else
                        <img src="{{asset('new_assets/assets/images/home.png')}}" alt="New York" class="d-block w-100">
                    @endif
                        </div>
                

                <p><b>{{$post->title}}</b></p>
                
                <div class="main-days-frame">   
                    <span class="days-box"> 
                    <?php
                        $givenTime = strtotime($post->created);
                        $days = floor((time() - $givenTime) / (60 * 60 * 24));
                        echo $days > 0 ? Setting::get_formeted_time($days) : 'Posted today';
                    ?>
                    </span>
                </div>
                <div class="row overflow-section">
                    <div class="loaction col-md-12">
                        <p><i class="bi bi-pin-map"></i> {{ $post->property_address }}</p>
                    </div>
                    <div class="review-section">
                        <p>Review</p>
                        <ul class="review">
                            <li><i class="bi bi-star-fill"></i></li>
                            <li><i class="bi bi-star-fill"></i></li>
                            <li><i class="bi bi-star-fill"></i></li>
                            <li><i class="bi bi-star-fill"></i></li>
                            <li><i class="bi bi-star-half"></i></li>
                        </ul>
                    </div>
                </div>
                    </a>
            </div>
        
    </div>
    @endif
    @if($post->category_id == 6)
        <div class="col-lg-2 col-md-4 col-sm-6 col-6">
        <div class="card shop-box p-2">
                <?php $useid = UserAuth::getLoginId();?>
            @if($existingRecord->contains('post_id', $post->id) && $existingRecord->contains('user_id', $useid) && !empty($useid))
                                <div data-postid="{{$post->id}}" data-Userid="{{UserAuth::getLoginId()}}" class="save-btn saved_post_btn" title="Save"><i class="fa fa-check" aria-hidden="true"></i>  Saved</div>
                            @else
                                <div data-postid="{{$post->id}}" data-Userid="{{UserAuth::getLoginId()}}" class="save-btn saved_post_btn" title="Save">Save</div>
                            @endif

            <a href="{{route('shopping_post_single',$post->id)}}">
                <div class="img-area">
                <?php
                        $neimg = trim($post->image1,'[""]');
                        $img  = explode('","',$neimg);
                    ?>
                    @if($post->image1)
                        <img src="{{asset('images_blog_img')}}/{{$img[0]}}" alt="{{$post->title}}" class="d-block w-100">
                    @else
                        <img src="{{asset('new_assets/assets/images/home.png')}}" alt="New York" class="d-block w-100">
                    @endif
            </div>
            <div class="caption text-center">
                <h6 class="product-title">{{$post->title}}</h6>
                <div class="price" style="font-size: 15px;padding: 0px 0px;"><del>${{$post->product_price}}</del> ${{$post->product_sale_price}}</div>
            </div>
            <div class="button-sell" style="margin-top: 0px;">
                <span><a href="{{route('shopping_post_single',$post->id)}}" class="btn create-post-button" data-product-id="{{$post->id}}">View Details</a></span>
            </div>
                </a>

        </div>
    </div>
    @endif

    @if($post->category_id == 705)
    
        <div class="col-lg-2 col-md-4 col-sm-6 col-6">
                <div class="feature-box">
                    <?php $useid = UserAuth::getLoginId();?>
                            @if($existingRecord->contains('post_id', $post->id) && $existingRecord->contains('user_id', $useid) && !empty($useid))
                                <div data-postid="{{$post->id}}" data-Userid="{{UserAuth::getLoginId()}}" class="save-btn saved_post_btn" title="Save"><i class="fa fa-check" aria-hidden="true"></i>  Saved</div>
                            @else
                                <div data-postid="{{$post->id}}" data-Userid="{{UserAuth::getLoginId()}}" class="save-btn saved_post_btn" title="Save">Save</div>
                            @endif 
                        <a href="{{route('service_single',$post->id)}}">
                        <div class="img-area">
                        <?php
                        $neimg = trim($post->image1,'[""]');
                        $img  = explode('","',$neimg);
                    ?>
                    @if($post->image1)
                        <img src="{{asset('images_blog_img')}}/{{$img[0]}}" alt="{{$post->title}}" class="d-block w-100">
                    @else
                        <img src="{{asset('new_assets/assets/images/home.png')}}" alt="New York" class="d-block w-100">
                    @endif
                        </div>
                    
                    <div class="job-post-content">
                        <h4>{{$post->title}}</h4>
                        <div class="main-days-frame">
                                           
                                        
                                            <span class="days-box"> 
                                            <?php
                                                $givenTime = strtotime($post->created);
                                                $days = floor((time() - $givenTime) / (60 * 60 * 24));

                                                echo $days > 0 ? Setting::get_formeted_time($days) : 'Posted today';
                                            ?>

                                            </span>
                                        </div>
                    </div>
                </a>
                </div>
            </div>

    @endif

    @if($post->category_id == 725)
    
        <div class="col-lg-2 col-md-4 col-sm-6 col-6">
                <div class="feature-box">
                    <?php $useid = UserAuth::getLoginId();?>
                            @if($existingRecord->contains('post_id', $post->id) && $existingRecord->contains('user_id', $useid) && !empty($useid))
                                <div data-postid="{{$post->id}}" data-Userid="{{UserAuth::getLoginId()}}" class="save-btn saved_post_btn" title="Save"><i class="fa fa-check" aria-hidden="true"></i>  Saved</div>
                            @else
                                <div data-postid="{{$post->id}}" data-Userid="{{UserAuth::getLoginId()}}" class="save-btn saved_post_btn" title="Save">Save</div>
                            @endif  
                        <a href="{{route('event_single',$post->id)}}">
                        <div class="img-area">
                        <?php
                        $neimg = trim($post->image1,'[""]');
                        $img  = explode('","',$neimg);
                    ?>
                    @if($post->image1)
                        <img src="{{asset('images_blog_img')}}/{{$img[0]}}" alt="{{$post->title}}" class="d-block w-100">
                    @else
                        <img src="{{asset('new_assets/assets/images/home.png')}}" alt="New York" class="d-block w-100">
                    @endif
                        </div>
                    
                    <div class="job-post-content">
                        <h4>{{$post->title}}</h4>
                        <div class="main-days-frame">
                                           
                                        
                                            <span class="days-box"> 
                                            <?php
                                                $givenTime = strtotime($post->created);
                                                $days = floor((time() - $givenTime) / (60 * 60 * 24));

                                                echo $days > 0 ? Setting::get_formeted_time($days) : 'Posted today';
                                            ?>

                                            </span>
                                        </div>
                    </div>
                </a>
                </div>
            </div>

    @endif

        @if($post->category_id == 5)
    
        <div class="col-lg-2 col-md-4 col-sm-6 col-6">
                <div class="feature-box">
                    <?php $useid = UserAuth::getLoginId();?>
                            @if($existingRecord->contains('post_id', $post->id) && $existingRecord->contains('user_id', $useid) && !empty($useid))
                                <div data-postid="{{$post->id}}" data-Userid="{{UserAuth::getLoginId()}}" class="save-btn saved_post_btn" title="Save"><i class="fa fa-check" aria-hidden="true"></i>  Saved</div>
                            @else
                                <div data-postid="{{$post->id}}" data-Userid="{{UserAuth::getLoginId()}}" class="save-btn saved_post_btn" title="Save">Save</div>
                            @endif  
                        <a href="{{route('community_single_post',$post->id)}}">
                        <div class="img-area">
                        <?php
                        $neimg = trim($post->image1,'[""]');
                        $img  = explode('","',$neimg);
                    ?>
                    @if($post->image1)
                        <img src="{{asset('images_blog_img')}}/{{$img[0]}}" alt="{{$post->title}}" class="d-block w-100">
                    @else
                        <img src="{{asset('new_assets/assets/images/home.png')}}" alt="New York" class="d-block w-100">
                    @endif
                    
                        </div>
                    <div class="job-post-content">
                        <h4>{{$post->title}}</h4>
                        <div class="main-days-frame">
                                         
                                            <span class="days-box"> 
                                            <?php
                                                $givenTime = strtotime($post->created);
                                                $days = floor((time() - $givenTime) / (60 * 60 * 24));

                                                echo $days > 0 ? Setting::get_formeted_time($days) : 'Posted today';
                                            ?>

                                            </span>
                                        </div>
                    </div>
                    
                </a>
                </div>
            </div>

        @endif
    @endforeach
</div>