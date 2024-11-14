<?php
use App\Models\Admin\HomeSettings;
use App\Models\Admin\Testimonials;
use App\Models\UserAuth;

$testimonials = Testimonials::where('status', 1)->get();

?>
@extends('layouts.frontlayout')
@section('content')

<section id="shoplisting-page">
    <div class="container">
        <div class="row" style="display: flex; justify-content:end; margin-right: 4px;">
            <button type="button" class="btn filterBTN">Filters</button>
        </div>
        <div class="row">
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
                    <input type="range" class="form-range slider" min="0" max="10000" value="0" name="priceRange" id="price-range"  step="100"> <span  class="slider_label"></span>


                    <div class="job-search-box mt-2">
                        <div class="filter-check">
                            <span><a href="">Reset</a></span><span><a class="Shop_filter" href="#">Apply</a></span>
                            <div class="lds-dual-ring d-none"></div>

                        </div>

                    </div>
                 </div>
                </div>
            </div>
            <div class="col-md-8 col-lg-9">
                <div class="row related-job filterRes">
                    @foreach($matchRecords as $records)
                
                        <div class="col-md-6 col-lg-3 col-6">
                            
                                <div class="feature-box2">

                                    <?php $useid = UserAuth::getLoginId();?>
                    @if($existingRecord->contains('post_id', $records->id) && $existingRecord->contains('user_id', $useid) && !empty($useid))
                                     <div data-postid="{{$records->id}}" data-Userid="{{UserAuth::getLoginId()}}" class="save-btn saved_post_btn" title="Save"><i class="fa fa-check" aria-hidden="true"></i>  Saved</div>
                                    @else
                                        <div data-postid="{{$records->id}}" data-Userid="{{UserAuth::getLoginId()}}" class="save-btn saved_post_btn" title="Save">Save</div>
                                    @endif

                                    <div id="demo-new" class="carousel1 slide">
                                        
                                        <a href="{{route('shopping_post_single',$records->id)}}">
                                        <div class="carousel-inner">
                                            <?php
                                                $itemFeaturedImages = trim($records->image1,'[""]');
                                                $itemFeaturedImage  = explode('","',$itemFeaturedImages);
                                                if(is_array($itemFeaturedImage)) {
                                                    foreach($itemFeaturedImage as $keyitemFeaturedImage => $valueitemFeaturedImage) { if($keyitemFeaturedImage == 0) {$class='active'; } else { $class='in-active'; } ?>
                                                            <div class="carousel-item <?= $class; ?>">
                                                                <img src="{{asset('images_blog_img')}}/{{ $valueitemFeaturedImage }}" alt="Los Angeles" class="d-block w-100" onerror="this.onerror=null; this.src='https://finder.harjassinfotech.org/public/images_blog_img/1688636936.jpg';">
                                                            </div>
                                                    <?php }     
                                                }
                                            ?>
                         
                                        </div>
                                    </div>
                                    <h6>{{$records->title}}</h6>
                                    <div class="price">
                                        Price
                                        <del style="font-size: 13px;">${{$records->product_price}}</del>
                                        <span style="font-size: 13px;">${{$records->product_sale_price}}</span>
                                    </div>
                                    <!-- <a href="{{route('shopping_post_single',$records->id)}}" class="btn create-post-button">Add to cart</a> -->
                                    <a href="{{route('shopping_post_single',$records->id)}}" class="btn create-post-button">View Details</a>
                                     </a>
                                </div>
                           
                        </div>
                    
                @endforeach
               
                </div>

            </div>
            
        </div>
        
    </div>
</section>
<script type="text/javascript">
jQuery(document).ready(function() {
$(function()
{
$('.slider').on('input change', function(){
    console.log();
          $(this).next($('.slider_label')).html(this.value);
        });
      $('.slider_label').each(function(){
          var value = $(this).prev().attr('value');
          $(this).html(value);
        });  
  
  
})

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
                    url: site_url+'/shop/filter',
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
                         $(".filterRes").html(response);
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