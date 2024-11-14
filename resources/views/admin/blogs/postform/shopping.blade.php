@extends('layouts.adminlayout')
@section('content')
<style type="text/css">
    .errortext{
        color: red;
    }
    .form-check-label {
    margin-bottom: 0; margin-left: 5px;
}

</style>
 <div class="container px-sm-5 px-4">
    <form method="post" action="<?php echo route('admin.shopping'); ?>" enctype="multipart/form-data" id="shoppingForms">
     {{ @csrf_field() }}
                    <!-- Page Heading -->
                    <div class="d-sm-flex flex-column pt-4  mb-3">
                        <h1 class="h3 mb-0 text-gray-800 fw-bold custom_title_heading">Category: Shopping</h1>
                        <p>Choose the best category that fits your needs and create a free post</p>
                    </div>
                    <span>
                        @include('admin.partials.flash_messages')
                    </span>
                    <input type="hidden" name="categories" value="6">

                    <div class="row bg-white border-radius pb-4 p-3">
                        <div class="col-md-6 mb-4">
                            <label class="labels">Title <sup>*</sup></label>
                            <input type="text" class="form-control" name="title" placeholder="Enter post name" value="" required>
                            <span class="error-message" id="title-error"></span>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="labels">Sub Categories <sup>*</sup></label>
                            <select name="sub_category" class="form-control form-control-xs selectpicker"  data-size="7" data-live-search="true" data-title="Sub Categories" id="sub_category" data-width="100%" required>
                                <?php $i = 0; $parentList = array(); ?>
                            @foreach($sub_blog_categories as $b)
                                @if($b->parent_id =="6" || $b->main_parent_id =="6")
                                    <?php 
                                        if(empty($b->main_parent_id)) {
                                            $parentList[$i]['title'] =  $b->title; 
                                            $parentList[$i]['id'] =  $b->id;           
                                            $i++;
                                        }
                                    ?>
                                @endif
                            @endforeach
                               <?php foreach ($parentList as $parentListKey => $parentListValue) : ?>
                                        <option class="fw-bold" value="<?= $parentListValue['id']; ?>" ><b><?= $parentListValue['title']; ?><b></option>
                                         @foreach($sub_blog_categories as $b)
                                                @if($b->parent_id ==$parentListValue['id'])

                                                     <option value="<?php echo $b['id']; ?>" >&nbsp;&nbsp;&nbsp;&#8226;&nbsp;&nbsp;&nbsp;<?php echo$b['title']; ?></option>
                                                @endif
                                            @endforeach
                                <?php endforeach; ?>
                                <option class="Other-cate" value="Other" >Other</option> 
                            </select>
                            
                             <input type="text" class="form-control d-none mt-2" id="Other-cate-input" name="sub_category_oth" placeholder="sub_category name" value="">
                           
                             @error('sub_categories')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                         <div class="col-md-6 mb-4">
                            <label class="labels">Product Brand Name</label>
                            <input type="text" class="form-control" name="brand_name" placeholder="Product brand name" value="">
                            @error('brand_name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                       <!--  <div class="col-md-6 mb-4">
                            <label class="labels">Product sku</label>
                            <input type="text" class="form-control" name="sku" placeholder="Product sku" value="" required>
                             @error('sku')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div> -->

                        <!-- <div class="col-md-6 mb-4">
                            <label class="labels">Inventory</label>
                            <input type="number" class="form-control" name="stock" placeholder="Product stock" value="" required>
                            @error('stock')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div> -->

                         <div class="col-md-6 mb-4">
                            <label class="labels">Size </label>
                            <select class="form-control" name="product_size">
                                <option value="">Select Option</option>
                                <option value="ALL" >ALL</option>
                                <option value="XS" >XS</option>
                                <option value="S" >S</option>
                                <option value="M" >M</option>
                                <option value="L" >L</option>
                                <option value="XL" >Xl</option>
                                <option value="XXL">XXl</option>
                                
                            </select>
                             @error('product_size')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-4">
                        <label for="condition" class="form-label">Condition:</label>
                        <select id="condition" name="product_condition" class="form-control" >
                            <option value="new">New</option>
                            <option value="used">Used</option>
                            <option value="refurbished">Refurbished</option>
                        </select>
                        @error('condition')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="row">
                            <div class="col-md-6 col-lg-4 mb-2 fr1">
                                <label for="delivery" class="form-label">Delivery Available:</label>
                                <div class="form-check">
                                    <input type="checkbox" id="delivery" name="delivery_option" value="available" class="form-check-input">
                                    <label for="delivery" class="form-check-label">Available</label>
                                </div>
                                @error('delivery')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 col-lg-4 mb-2 fr1">
                                <label for="pickup" class="form-label">Pickup at location:</label>
                                <div class="form-check">
                                    <input type="checkbox" id="pickup" name="pickup" value="available" class="form-check-input">
                                    <label for="pickup" class="form-check-label">Available</label>
                                </div>
                                @error('pickup')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 col-lg-4 mb-2 fr1">
                                <label for="shipping" class="form-label">Shipping Included:</label>
                                <div class="form-check">
                                    <input type="checkbox" id="shipping" name="shipping" value="included" class="form-check-input">
                                    <label for="shipping" class="form-check-label">Included</label>
                                </div>
                                @error('shipping')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 col-lg-4 mb-2 fr1">
                                <label for="bid" class="form-label">Allow Offers/Bids:</label>
                                <div class="form-check">
                                    <input type="checkbox" id="bid" name="bid" value="allow" class="form-check-input">
                                    <label for="bid" class="form-check-label">Allow</label>
                                </div>
                                @error('bid')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 col-lg-4 mb-2 fr1">
                                <label for="buy" class="form-label">Buy at Face Value:</label>
                                <div class="form-check">
                                    <input type="checkbox" id="buy" name="buy_at_face_value" value="allow" class="form-check-input">
                                    <label for="buy" class="form-check-label">Allow</label>
                                </div>
                                @error('buy')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                <div class="col-md-6 mb-4 sl-opt">
                    <label class="form-label">Sale Option:</label>
                    <div class="form-check">
                        <input type="radio" id="online" name="saleOption" value="online" class="form-check-input" >
                        <label for="online" class="form-check-label ml-2">Sell Online for Delivery</label>
                    </div>
                    <!-- <div class="form-check">
                        <input type="radio" id="pickupOption" name="saleOption" value="pickup" class="form-check-input" required>
                        <label for="pickupOption" class="form-check-label">Pickup at Location</label>
                    </div> -->

                    <div class="col-md-12 mb-4 address_input d-none">
                        <!-- <label class="form-label">Pickup Address</label> -->
                        <input type="text" id="pickupOption" name="address" value="" class="form-control " placeholder="Enter your pikup address"> 
                    </div>
                    @error('saleOption')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                     

                    <!-- <div class="col-md-6 mb-4">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="bid" class="form-label">Allow Offers/Bids:</label>
                                <div class="form-check">
                                    <input type="checkbox" id="bid" name="bid" value="allow" class="form-check-input">
                                    <label for="bid" class="form-check-label">Allow</label>
                                </div>
                                @error('bid')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="buy" class="form-label">Buy at Face Value:</label>
                                <div class="form-check">
                                    <input type="checkbox" id="buy" name="buy_at_face_value" value="allow" class="form-check-input">
                                    <label for="buy" class="form-check-label">Allow</label>
                                </div>
                                @error('buy')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div> -->

                         


                        
                         <div class="col-md-12 mb-4">
                            <label class="labels">Product Description</label>
                            <div id="summernote">
                                <textarea id="editor1" class="form-control" name="description" placeholder="Write a text"><?php echo old('description'); ?>
                                </textarea>

                               
                                @error('description')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                         <!-- <div class="col-md-12 mb-4">
                            <label class="labels">Additional info</label>
                            <div id="sub_summernote">
                                <textarea id="sub_editor" class="form-control" name="additional_info" placeholder="Write a text"><?php echo old('additional_info'); ?></textarea>

                               
                                @error('additional_info')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div> -->
                        <div class="col-md-6 mb-4">
                            <label class="labels">Product URL / Affiliate URL</label>
                            <input type="link" class="form-control" name="product_url" placeholder="URL" value="" >
                             @error('product_price')
                                    <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="labels">Want to reach a larger audience? Add Location</label>
                            <input name="location" type="text"  class="form-control get_loc" id="location" value="" placeholder="Location">
                            <div class="searcRes" id="autocomplete-results">
                                    
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-4">
                            <label class="labels">Product Price ($)</label>
                            <input type="text" class="form-control" name="product_price" placeholder="$" value="" >
                             @error('product_price')
                                    <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="labels">Product Offer Price ($)</label>
                            <input type="text" class="form-control" name="product_sale_price" placeholder="$" value="" >
                            <span id="salePriceError" class="errortext"></span>
                            @error('product_sale_price')
                                    <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                            <div class="col-md-6 mb-4">
                         <label class="labels">Post Featured Image <em>(Select Multiple)</em></label> 
                            <div class="upload-icon"><a class="cam btn btn-warning"  href="javascript:void(0)">
                                <i class="fa fa-upload" aria-hidden="true"></i>
                                    upload image
                                </a> 
                            </div>
                           
                            <div class="gallery"></div>
                            <div class="show-img">
                            </div>
                            @error('image')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror 
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="labels"> Post Video  Format: .mp4 | max size: 20MB <em>(Select Multiple)</em></label>
                            <div class="image-upload">
                                <label style="cursor: pointer;" for="video_upload">
                                    <!-- <img src="" alt="Image" class="uploaded-image"> -->
                                    <div class="h-100">
                                           <div class="">
                                            <div class="dplay-tbl-cell">
                                                <!-- <i class="fas fa-cloud-upload-alt mb-3"></i>
                                                <h6><b>Upload Video</b></h6> -->
                                                <i class="far fa-file-video mb-3"></i>
                                                <h6 class="mt-10 mb-70">Upload Or Drop Your Video Here</h6>
                                            </div>
                                        </div>
                                    </div><!--upload-content-->
                                    <input data-required="image" type="file" accept="video/*"  id="video_upload" class="image-input" data-traget-resolution="image_resolution" name="post_video" value="">
                                </label>
                            </div>
                            <div class="show-video d-none">
                               <video controls id="video-tag">
                                  <source id="video-source" src="splashVideo">
                                  Your browser does not support the video tag.
                                </video>
                                 <i class="fas fa-times" id="cancel-btn-1"></i>
                            </div>
                        </div>
                       <div class="col-md-12 mb-4">
                              
                                    <div class="col-md-12 mt-4">
                                        <label class="custom-toggle">
                                            <input type="checkbox" name="personal_detail" value="true"> &nbsp;&nbsp;<span>Do you want to show your contact details.</span>
                                        </label>
                                    </div> 
                                     <div class=" row hidesection d-none"> 
                                        <div class="col-md-6 mt-4 ">
                                            <label class="custom-toggle">Email</label>
                                                <input type="email" class="form-control" name="email" value="" placeholder="example@example.com">
                                           
                                        </div>
                                        <div class="col-md-6 mt-4">
                                            <label class="custom-toggle">Phone no</label>
                                                <input type="tel" class="form-control" name="phone" value="" placeholder="+1 1234567890">
                                        </div>
                                        <div class="col-md-6 mt-4">
                                            <label class="custom-toggle">Website link</label>
                                                <input type="text" class="form-control" name="website" value="" placeholder="https://test.com">
                                        </div>
                                        <div class="col-md-6 mt-4">
                                            <label class="custom-toggle">Whatsapp</label>
                                                <input type="tel" class="form-control" name="whatsapp" value="" placeholder="whatsapp number">
                                        </div>
                                </div> 
                            </div> 

                    </div>
                    </div>
                    <div class="mt-5 text-center"><button class="btn profile-button addCategory" type="submit">Publish</button></div> 
                </form>
                </div>
            <script>
            $(document).ready(function() {
             var isChecked1 = $('input[name="personal_detail"]').is(':checked');
                console.log(isChecked1);
                if(isChecked1 === true){
                    $('.hidesection').removeClass('d-none');
                }else{
                    $('.hidesection').addClass('d-none');
                }
              $('input[name="personal_detail"]').on('click', function() {
                var isChecked = $(this).is(':checked');
                console.log(isChecked);
                if(isChecked === true){
                    $('.hidesection').removeClass('d-none');
                }else{
                    $('.hidesection').addClass('d-none');
                }
              });
            });

            $(document).ready(function(){
              $('[data-toggle="tooltip"]').tooltip();   
            });



            $(document).ready(function() {
              $('input[name="saleOption"]').on('click', function() {
                var saleOption = $(this).val();
                // var saleOption = $(this).is(':checked');
                console.log(saleOption);
                if(saleOption === 'pickup'){
                    $('.address_input').removeClass('d-none');
                }else{
                    $('.address_input').addClass('d-none');
                }
              });
            });

            $(document).ready(function() {

              $('#sub_category').on('change', function() {
                    if($(this).val() == "Other"){
                         $('#Other-cate-input').removeClass('d-none');
                         $(this).addClass('d-none');
                    }else{
                        $('#Other-cate-input').addClass('d-none');
                    }
                   
              });

               $('.addCategory').click(function (e) {
                    var subcate_title = $('#Other-cate-input').val();
                    if(subcate_title==""){
                        $('#shoppingForms').submit();
                    }
                     var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                     e.preventDefault();
                    $.ajax({

                        url: baseurl+'/shopping/cate',
                        type: 'POST',
                        headers: {
                          'X-CSRF-TOKEN': csrfToken
                        },
                        data: {
                            title:subcate_title,
                            parent_id:6,
                        },
                        success: function(response){
                          console.log(response);
                          $('#shoppingForms').submit();
                        },
                        error: function(xhr, status, error) {
                         
                        }
                      });
                });
            });


    $(document).ready(function() {
        // Add change event listener to the "Product Price" input
        $('input[name="product_price"]').on('input', function() {
            validateSalePrice();
        });

        // Add change event listener to the "Product Sale Price" input
        $('input[name="product_sale_price"]').on('input', function() {
            validateSalePrice();
        });

        function validateSalePrice() {
            // Get values of both inputs
            var productPrice = parseFloat($('input[name="product_price"]').val()) || 0;
            var salePrice = parseFloat($('input[name="product_sale_price"]').val()) || 0;
             // Get the error message element
            var errorMessageElement = $('#salePriceError');
            // Check if the sale price is less than the product price
            if (salePrice > productPrice) {

                 errorMessageElement.text('Sale price cannot be greater than product price');
                // If it is, set the sale price to be equal to the product price
                $('input[name="product_sale_price"]').val(productPrice);
            }else {
                // Clear the error message if the condition is not met
                errorMessageElement.text('');
            }
        }
    });
        </script>



@endsection