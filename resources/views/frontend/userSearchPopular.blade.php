<?php
// echo "<pre>";
// print_r($matchingRecords);
// echo "</pre>";
// die;

foreach ($matchingRecords as $record) {
    if ($record->category_id == 705) {
        ?>
        <div class="col-lg-3 col-md-4 col-sm-6 col-6">
            <div class="feature-box">
                <a href="{{route('service_single', $record->id)}}">
                    <div class="img-area">
                        <?php
                        $neimg = trim($record->image1, '[""]');
                        $img = explode('","', $neimg);
                        ?>
                        @if($record->image1)
                        <img src="{{asset('images_blog_img')}}/{{$img[0]}}" alt="{{$record->title}}" class="d-block w-100">
                        @else
                        <img src="./new_assets/assets/images/home.png" alt="New York" class="d-block w-100">
                        @endif
                    </div>

                    <div class="job-post-content">
                        <h4>{{$record->title}}</h4>
                        <div class="main-days-frame">
                            <span class="days-box">
                                <?php
                                $givenTime = strtotime($record->created);
                                $currentTimestamp = time();
                                $timeDifference = $currentTimestamp - $givenTime;

                                $days = floor($timeDifference / (60 * 60 * 24));
                                $timeAgo = ($days > 0) ? $days . " Days Ago" : "Today";

                                echo $timeAgo;
                                ?>
                            </span>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    <?php
    }

    if ($record->category_id == 4) {
        ?>
        <div class="col-lg-2 col-md-4 col-sm-6 col-6">
            <div class="feature-box">
                <a href="{{route('real_esate_post', $record->id)}}">
                    <div class="img-area">
                        <?php
                        $neimg = trim($record->image1, '[""]');
                        $img = explode('","', $neimg);
                        ?>
                        @if($record->image1)
                        <img src="{{asset('images_blog_img')}}/{{$img[0]}}" alt="{{$record->title}}" class="d-block w-100">
                        @else
                        <img src="./new_assets/assets/images/home.png" alt="New York" class="d-block w-100">
                        @endif
                    </div>

                    <p><b>{{$record->title}}</b></p>

                    <div class="main-days-frame">
                        <span class="days-box">
                            <?php
                            $givenTime = strtotime($record->created);
                            $timeDifference = $currentTimestamp - $givenTime;

                            $days = floor($timeDifference / (60 * 60 * 24));
                            $timeAgo = ($days > 0) ? $days . " Days Ago" : "Today";

                            echo $timeAgo;
                            ?>
                        </span>
                    </div>
                    <div class="row overflow-section">
                        <div class="loaction col-md-12">
                            <p><i class="bi bi-pin-map"></i> {{ $record->property_address }}</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    <?php
    }

    if ($record->category_id == 5) {
        ?>
        <div class="col-lg-3 col-md-4 col-sm-6 col-6">
            <div class="feature-box">
                <a href="{{route('community_single_post', $record->id)}}">
                    <div class="img-area">
                        <?php
                        $neimg = trim($record->image1, '[""]');
                        $img = explode('","', $neimg);
                        ?>
                        @if($record->image1)
                        <img src="{{asset('images_blog_img')}}/{{$img[0]}}" alt="{{$record->title}}" class="d-block w-100">
                        @else
                        <img src="./new_assets/assets/images/home.png" alt="New York" class="d-block w-100">
                        @endif
                    </div>
                    <div class="job-post-content">
                        <h4>{{$record->title}}</h4>
                        <div class="main-days-frame">
                            <span class="location-box">
                                @foreach($city as $ctt)@if($ctt->id == $record->city){{$ctt->name}}@endif @endforeach,
                                @foreach($state as $stt)@if($stt->id == $record->state){{$stt->name}}@endif @endforeach
                            </span>

                            <span class="days-box">
                                <?php
                                $givenTime = strtotime($record->created);
                                $timeDifference = $currentTimestamp - $givenTime;

                                $days = floor($timeDifference / (60 * 60 * 24));
                                $timeAgo = ($days > 0) ? $days . " Days Ago" : "Today";

                                echo $timeAgo;
                                ?>
                            </span>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    <?php
    }

    if ($record->category_id == 6) {
        ?>
        <div class="col-lg-3 col-md-4 col-sm-6 col-6">
            <div class="card shop-box p-2">
                <a href="{{route('shopping_post_single', $record->id)}}">
                    <?php
                    $neimg = trim($record->image1, '[""]');
                    $img = explode('","', $neimg);
                    ?>
                    @if($record->image1)
                    <img src="{{asset('images_blog_img')}}/{{$img[0]}}" alt="{{$record->title}}" class="d-block w-100">
                    @else
                    <img src="./new_assets/assets/images/home.png" alt="New York" class="d-block w-100">
                    @endif

                    <div class="caption texts-center">
                        <a href="#">
                            <h6 class="product-title">{{$record->title}}</h6>
                        </a>
                        <div class="price">
                            Price
                            <del style="font-size: 13px;">${{$record->product_price}}</del>
                            <span style="font-size: 13px;">${{$record->product_sale_price}}</span>
                        </div>
                    </div>
                    <div class="button-sell" style="margin-top: 0px;">
                        <a href="{{route('shopping_post_single', $record->id)}}" class="btn create-post-button" data-product-id="{{$record->id}}">View details</a>
                    </div>
                </a>
            </div>
        </div>
    <?php
    }

    if ($record->category_id == 2) {
        ?>
        <div class="col-lg-3 col-md-4 col-sm-6 col-6">
            <div class="feature-box">
                <a href="{{route('jobpost', $record->id)}}">
                    <div id="demo-new" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <?php
                            $neimg = trim($record->image1, '[""]');
                            $img = explode('","', $neimg);
                            ?>
                            @if($record->image1)
                            <img src="{{asset('images_blog_img')}}/{{$img[0]}}" alt="{{$record->title}}" class="d-block w-100">
                            @else
                            <img src="./new_assets/assets/images/home.png" alt="New York" class="d-block w-100">
                            @endif
                        </div>
                    </div>

                    <p class="job-title"><b>{{ ucfirst($record->title) }}</b></p><br>
                    <div class="location-job-title">
                        <div class="job-type">
                            <ul>
                                @if($record->pay_by =="Fixed")
                                <li><span><i class="bi bi-cash"></i></span>${{ $record->fixed_pay }}</li>
                                @else
                                <li><span><i class="bi bi-cash"></i></span>${{ $record->min_pay }} - ${{ $record->max_pay }}</li>
                                @endif
                                <li><span><i class="bi bi-clock-fill"></i></span>{{ $record->choices }}</li>
                                <li><span><i class="bi bi-briefcase-fill"></i></span>{{ $record->supplement }}</li>
                                <li><span><i class="bi bi-phone"></i></span>{{ $record->phone }}</li>
                            </ul>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    <?php
    }
}
?>
