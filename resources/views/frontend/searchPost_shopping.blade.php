<?php

use App\Models\Admin\HomeSettings;
use App\Models\Admin\Testimonials;
use App\Models\UserAuth;
use Illuminate\Support\Str;

?>
@extends('layouts.frontlayout')
@section('content')
<style type="text/css">
    .top-search {
        top: 5px;
        z-index: 1;
        position: relative;
    }
</style>
<section class="job-listing">
    <div class="container">
        <div class="row">
            <div class="col-12" style="text-align: center;padding: 10px 20px;background-color: #000;margin-bottom: 3%; border-radius:5px;">
                <div class="top-search" style="top: 0; padding: 8px 37px; border-radius: 5px; background-color: #000; border-color: #000;">
                    <form method="POST" action="{{ route('search') }}">
                        <div class="row">
                            @csrf
                            <div class="col-lg-3 col-md-6">
                                <div class="select-job">
                                    <select id="searcjob_search" class="form-select" name="searcjobParent">
                                        <option>Category</option>
                                        @foreach($blog_categories_search as $b)
                                        <option value="{{$b->id}}">{{$b->title}}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-6">
                                <div class="select-job">
                                    <select id="searcjobChild" class="form-select" name="searcjobChild">
                                        <option>Sub Category</option>
                                    </select>

                                </div>
                            </div>

                            <div class="col-lg-3 col-md-6">
                                <div class="location-search">
                                    <input type="location" name="location" class="form-control" id="exampleFormControlInput1" placeholder="location">
                                    <i class="bi bi-geo-alt"></i>
                                </div>
                            </div>

                            <div class="col-lg-3 col-sm-12 col-md-6">
                                <div class="search-fields">
                                    <!-- <a href="#">Search<i class="bi bi-arrow-right"></i></a> -->
                                    <button class="btn fields-search" type="submit">Search<i class="bi bi-arrow-right"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <h1 class="serch-value"><b><span style="color: #000;">Search Result For : </span></b>{{ $getCategoryLabel }}, {{ $getCategoryChildLabel }}</h1>
        </div>
    </div>
    <div class="container">
        <div class="row" style="float: right;margin-right: 4%;">
            <button type="button" class="btn filterBTN">Filters</button>
        </div>
    </div>
    <div class="container">
        <div class="row" style="width: 100%;">
            <div class="col-md-4 col-lg-3" id="FiltersJob">
                <div class="closeIcon"><i class="fa fa-close"></i></div>
                <div class="shoplisting-left-sidebar realstate-left-sidebar">
                    <h4>Product Search By </h4>
                    <div class="form-check mb-3">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="shop_cate" value="674"> Beauty, Health & Personal Care
                        </label><br>
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="shop_cate" value="611"> Books
                        </label><br>
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="shop_cate" value="695"> Clothing & Shoes
                        </label><br>
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="shop_cate" value="602"> Clothing, Shoes, Accessories
                        </label>
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="shop_cate" value="632"> Computers
                        </label><br>
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="shop_cate" value="625"> Electronics
                        </label><br>
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="shop_cate" value="672"> Grocery & Wine
                        </label>
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="shop_cate" value="643"> Home, Garden & Pets
                        </label>
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="shop_cate" value="682"> Household, Health & Baby Care
                        </label>
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="shop_cate" value="617"> Movies, Music & Games
                        </label>
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="shop_cate" value="665"> Pet Supplies
                        </label>
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="shop_cate" value="657"> Tools, Home Improvement
                        </label>
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="shop_cate" value="690"> Toys, Kids & Baby
                        </label>

                    </div>
                    <div class="new-price-range">
                        <label for="price-range" class="form-label">Price Range:</label>
                        <input type="range" class="form-range slider" min="0" max="10000" value="0" name="priceRange" id="price-range" step="100"> <span class="slider_label"></span>


                        <div class="job-search-box mt-2">
                            <div class="filter-check">
                                <span><a href="">Reset</a></span><span><a class="Shop_filter" href="#">Apply</a></span>
                                <div class="lds-dual-ring d-none"></div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-lg-9 mt-2">
                <div class="row related-job">
                    <div class="col-lg-12 col-md-12">
                        <div class="job-post-header">
                            <div class="row" id="res_shop">

                                @if (!$matchingRecords->isEmpty())
                                <?php
                                // echo"<pre>"; print_r($matchingRecords);die();
                                ?>
                                @foreach($matchingRecords as $Records)
                                <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                                    <div class="card shop-box p-2">
                                        <?php $useid = UserAuth::getLoginId(); ?>
                                        @if($existingRecord->contains('post_id', $Records->id) && $existingRecord->contains('user_id', $useid))
                                        <div data-postid="{{$Records->id}}" data-Userid="{{UserAuth::getLoginId()}}" class="save-btn saved_post_btn" title="Save"><i class="fa fa-check" aria-hidden="true"></i> Saved</div>
                                        @else
                                        <div data-postid="{{$Records->id}}" data-Userid="{{UserAuth::getLoginId()}}" class="save-btn saved_post_btn" title="Save">Save</div>
                                        @endif

                                        <a href="{{route('shopping_post_single',$Records->id)}}">

                                            <?php
                                            $neimg = trim($Records->image1, '[""]');
                                            $img  = explode('","', $neimg);
                                            ?>
                                            @if($Records->image1)
                                            <img src="{{asset('images_blog_img')}}/{{$img[0]}}" alt="{{$Records->title}}" class="d-block w-100">
                                            @else
                                            <img src="./new_assets/assets/images/home.png" alt="New York" class="d-block w-100">
                                            @endif

                                            <div class="caption texts-center">
                                                <a href="#">
                                                    <h6 class="product-title">{{$Records->title}}</h6>
                                                </a>
                                                <div class="price">
                                                    Price
                                                    <del style="font-size: 13px;">${{$Records->product_price}}</del>
                                                    <span style="font-size: 13px;">${{$Records->product_sale_price}}</span>
                                                </div>
                                            </div>
                                            <div class="button-sell" style="margin-top: 0px;">
                                                <a href="{{route('shopping_post_single',$Records->id)}}" class="btn create-post-button" data-product-id="{{$Records->id}}">View details</a>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                @endforeach
                                @else
                                <div class="col-12" style="text-align: center;">
                                    <h3 style="padding: 5% 0% 2% 0%;  font-size: 20px;">We couldn't find any data, Please adjust your search settings.</h3>
                                    <a href="{{ url('/') }}"> <button style="margin-bottom: 5%;" class="btn create-post-button" type="button">Go to Search</button></a>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
</section>

<script type="text/javascript">
    $(document).ready(function() {
        $('#searcjob_search').on('change', function() {
            let selectedParent = this.value;
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var optionsHtml = "";
            $.ajax({
                url: site_url + "/getchildcat",
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": csrfToken
                },
                data: {
                    selectedParent: selectedParent,
                },
                success: function(response) {
                    console.log('success', response);
                    if (selectedParent == 6) {
                        $('#searcjobChild').html(response);
                    } else {
                        $('#searcjobChild').append(optionsHtml);
                        var optionsHtml = "";

                        $.each(response, function(index, item) {
                            optionsHtml += "<option value='" + item.id + "'>" + item.title + "</option>";
                        });
                        $('#searcjobChild').empty();
                        $('#searcjobChild').append(optionsHtml);
                    }
                },
                error: function(response) {
                    console.log('error', response);
                }
            });
        });


    });

    $(document).ready(function() {
        $(".Shop_filter").on("click", function(e) {
            e.preventDefault();

            var priceRange = $('#price-range').val();
            var shop_cate = $('input[name="shop_cate"]:checked').val();

            // alert(priceRange);
            // alert(min_price);
            // alert(max_price);
            $('.lds-dual-ring').removeClass('d-none');
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            $.ajax({
                url: site_url + '/shop/filter',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    priceRange: priceRange,
                    shop_cate: shop_cate

                },
                success: function(response) {
                    console.log(response);
                    $("#res_shop").html(response);
                    $('.lds-dual-ring').addClass('d-none');
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    $('.lds-dual-ring').addClass('d-none');
                }
            });
        });
    });
</script>

@endsection