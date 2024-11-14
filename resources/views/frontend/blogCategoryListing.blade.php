<?php
use App\Models\Admin\HomeSettings;
use App\Models\Admin\Testimonials;
use App\Models\UserAuth;
use Illuminate\Support\Str;

?>
@extends('layouts.frontlayout')
@section('content')

<section class="job-listing">
    <div class="container">
        <div class="row">
            <div class="col-12" style="text-align: center;padding: 5% 0px;background-color: #f5f5f5;margin-bottom: 3%;">
                <h3><b>Posts of : </b>{{ $getCategoryLabel }} > {{ $getCategoryChildLabel }}</h3>
            </div>
        </div>

        <div class="row" style="width: 100%;">
            <div class="col-md-4 col-lg-3" id="FiltersJob">
                
                @if($getCategoryLabel == 'Jobs')
                    @include('frontend.filters.jobsFilter')
                @elseif($getCategoryLabel == 'Services') 
                    @include('frontend.filters.servicesFilter')
                @elseif($getCategoryLabel == 'Shopping') 
                    @include('frontend.filters.shoppingFilter')
                @else    
                    @include('frontend.filters.realestateFilter')
                @endif
            </div>
            <div class="col-md-8 col-lg-9 mt-2">
                <div class="row related-job">
                    <div class="col-lg-12 col-md-12">
                        <div class="job-post-header">
                            <div class="row">
                            
                            @if (!$matchingRecords->isEmpty())
                                @foreach($matchingRecords as $Records)  
                                    <div class="col-lg-3 col-md-3 col-sm-6 col-6">
                                            @if($getCategoryLabel == 'Jobs')
                                                <a href="{{ url('/') }}/job-post/{{ $Records->id }}">
                                            @elseif($getCategoryLabel == 'Services') 
                                               <a href="{{route('service_single',$Records->id)}}">
                                            @elseif($getCategoryLabel == 'Shopping') 
                                                <a href="{{route('shopping_post_single',$Records->id)}}">
                                            @else    
                                                <a href="{{ url('/') }}/real_esate-post/{{$Records->id}}">
                                            @endif
                                            <?php
                                                $neimg = trim($Records->image1,'[""]');
                                                $img  = explode('","',$neimg);
                                            ?>
                                            <div class="feature-box">
                                                <img style="object-fit: cover;" src="{{ url('/') }}/images_blog_img/{{$img[0]}}" class="imgfluid" alt="..." onerror="this.onerror=null; this.src='{{ url('/') }}/images_blog_img/1688636936.jpg';">

                                                <p class="job-title"><b>{{ $Records->title }}</b></p>
                                                @if($getCategoryLabel == 'Shopping')
                                                    <div class="price">
                                                        Price
                                                        <del style="font-size: 11px;">${{$Records->product_price}}</del>
                                                        <span style="font-size: 15px;">${{$Records->product_sale_price}}</span>
                                                    </div>
                                                    <a href="{{route('shopping_post_single',$Records->id)}}" class="btn create-post-button">Add to cart</a>
                                                @endif
                                                <div class="location-job-title">
                                                    <div class="job-type">
                                                        @if($getCategoryLabel == 'Jobs')
                                                            <ul>
                                                                @if($Records->pay_by == 'Fixed')
                                                                    <li><span><i class="bi bi-cash"></i></span>Fixed  ${{$Records->fixed_pay}} / {{ ucfirst($Records->rate) }}</li>
                                                                @else
                                                                    <li><span><i class="bi bi-cash"></i></span>Range ${{$Records->min_pay}} - ${{$Records->max_pay}} / {{ ucfirst($Records->rate) }}</li>
                                                                @endif
                                                                <li><span><i class="bi bi-briefcase-fill"></i></span>{{ $Records->choices }}</li>
                                                                <li><span><i class="bi bi-clock-fill"></i></span>{{ $Records->supplement }}</li>
                                                                <li><span><i class="bi bi-phone"></i></span>{{ $Records->phone }}</li>
                                                            </ul>
                                                        @elseif($getCategoryLabel == 'Services')  
                                                            <ul class="job-list">
                                                                @if($Records->rate)
                                                                    <li><span><i class="bi bi-cash"></i></span>${{$Records->rate}}</li>
                                                                @endif

                                                                @if($Records->service_date)
                                                                    <li><span><i class="bi bi-calendar"></i></span> {{$Records->service_date}}</li>
                                                                @endif

                                                                @if($Records->rate)
                                                                    <li><span><i class="bi bi-alarm"></i></span> {{$Records->service_time}}</li>
                                                                @endif
                                                                
                                                                @if($Records->phone)
                                                                    <li><i class="bi bi-telephone"></i> {{$Records->phone}}</li>
                                                                @endif
                                                                
                                                                @if($Records->email) 
                                                                    <li><i class="bi bi-envelope"></i>  {{$Records->email}}</li>
                                                                @endif
                                                            </ul>  
                                                        @elseif($getCategoryLabel == 'Shopping')  
                                                            
                                                        @else    
                                                            <ul>
                                                                <li><span><i class="bi bi-cash"></i></span>${{$Records->sale_price}}</li>
                                                                <li><span><i class="bi bi-briefcase-fill"></i></span>{{$Records->area_sq_ft}} Sq. Ft</li>
                                                                <li><span><i class="bi bi-calendar-check"></i></span>{{$Records->year_built}}</li>
                                                                <li><span><i class="bi bi-phone"></i></span>{{$Records->phone}}</li>
                                                            </ul>
                                                        @endif
                                                        

                                                        
                                                    </div>
                                                    @if($getCategoryLabel == 'Jobs')
                                                        <div class="job-type job-hp">
                                                            <img onerror="this.onerror=null; this.src='https://placehold.jp/3d4070/ffffff/150x150.png?css=%7B%22border-radius%22%3A%2250%25%22%2C%22background%22%3A%22%20-webkit-gradient(linear%2C%20left%20top%2C%20left%20bottom%2C%20from(%23666666)%2C%20to(%23cccccc))%22%7D';" src="{{ url('/') }}/assets/images/profile/{{$Records->image}}" alt=""><p>{{ Illuminate\Support\Str::limit(strip_tags($Records->description), $limit = 20, $end = '') }}<br><small>By {{$Records->first_name}}</small></p>                                    
                                                        </div>
                                                    @elseif($getCategoryLabel == 'Services')  
                                                        <?php $cleanString = strip_tags($Records->description); ?>
                                                        <span class="desc_class">{{$cleanString}}</span>
                                                        <div class="job-type job-hp">
                                                            <img onerror="this.onerror=null; this.src='https://placehold.jp/3d4070/ffffff/150x150.png?css=%7B%22border-radius%22%3A%2250%25%22%2C%22background%22%3A%22%20-webkit-gradient(linear%2C%20left%20top%2C%20left%20bottom%2C%20from(%23666666)%2C%20to(%23cccccc))%22%7D';" src="{{ url('/') }}/assets/images/profile/{{$Records->image}}" alt=""><p>{{ Illuminate\Support\Str::limit(strip_tags($Records->description), $limit = 20, $end = '') }}<br><small>By {{$Records->first_name}}</small></p>                                    
                                                        </div>
                                                    @elseif($getCategoryLabel == 'Shopping')
                                                    @else
                                                        <div class="loaction col-md-12">
                                                            <p><i class="bi bi-pin-map"></i> {{ $Records->property_address }}</p>
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
                                                    @endif
                                                    
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            @else
                                <div class="col-12" style="text-align: center;">
                                      <h3 style="padding: 5% 0% 5% 0%;">No post found</h3>          
                                </div>
                            @endif    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</section>

@endsection