@extends('layouts.adminlayout')
@section('content')
<style type="text/css">
    .errortext{
        color: red;
    }
</style>
<div class="container px-sm-5 px-4">
    <form method="post" action="<?php echo route('shopping.edit',$blog->id); ?>" class="form-validation" enctype="multipart/form-data">
        <!-- id="shopping_form" -->
        {{ @csrf_field() }}
        <!-- Page Heading -->
        <div class="d-sm-flex flex-column  mb-3 pt-4">
            <h1 class="h3 mb-0 text-gray-800 fw-bold custom_title_heading">Edit : Shopping</h1>
            <!-- <p>Choose the best category that fits your needs and create a free post</p> -->
        </div>
        <span>
            @include('admin.partials.flash_messages')
        </span>
        <input type="hidden" name="categories" value="6">

        <div class="row bg-white border-radius pb-4 p-3">
            <div class="col-md-6 mb-4">
                <label class="labels">Title <sup>*</sup></label>
                <input type="text" class="form-control" name="title" placeholder="Enter post name" value="{{$blog->title}}" required>
                <span class="error-message" id="title-error"></span>
            </div>
            <div class="col-md-6 mb-4">
                <label class="labels">Sub Categories <sup>*</sup></label>
                <select name="sub_category" class="form-control form-control-xs selectpicker" data-size="7" data-live-search="true" data-title="Sub category" id="sub_category" data-width="100%" required>

                    <?php $i = 0;
                    $parentList = array(); ?>
                    @foreach($sub_blog_categories as $b)
                    @if($b->parent_id =="6" || $b->main_parent_id =="6")
                    <?php
                    if (empty($b->main_parent_id)) {
                        $parentList[$i]['title'] =  $b->title;
                        $parentList[$i]['id'] =  $b->id;
                        $i++;
                    }
                    ?>
                    @endif
                    @endforeach
                    <?php foreach ($parentList as $parentListKey => $parentListValue) : ?>
                        <option {{ $blog->sub_category == $parentListValue['id'] ? 'selected' : '' }} class="fw-bold" value="<?= $parentListValue['id']; ?>"><b><?= $parentListValue['title']; ?><b></option>
                        @foreach($sub_blog_categories as $b)
                        @if($b->parent_id ==$parentListValue['id'])

                        <option {{ $blog->sub_category == $b['id'] ? 'selected' : '' }} value="<?php echo $b['id']; ?>">&nbsp;&nbsp;&nbsp;&#8226;&nbsp;&nbsp;&nbsp;<?php echo $b['title']; ?></option>
                        @endif
                        @endforeach
                    <?php endforeach; ?>
                    <option class="Other-cate" value="Other">Other</option>
                </select>

                <input type="text" class="form-control d-none mt-2" id="Other-cate-input" name="sub_category_oth" placeholder="sub_category name" value="">

                @error('sub_categories')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-6 mb-4">
                <label class="labels">Product Brand Name</label>
                <input type="text" class="form-control" name="brand_name" placeholder="Product Brand Name" value="{{$blog->brand_name}}" required>
                @error('brand_name')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-6 mb-4">
                <label class="labels">Size </label>
                <select class="form-control" name="product_size">
                    <option value="">Select option</option>
                    <option {{ $blog->product_size == 'ALL' ? 'selected' : '' }} value="ALL">ALL</option>
                    <option {{ $blog->product_size == 'XS' ? 'selected' : '' }} value="XS">XS</option>
                    <option {{ $blog->product_size == 'S' ? 'selected' : '' }} value="S">S</option>
                    <option {{ $blog->product_size == 'M' ? 'selected' : '' }} value="M">M</option>
                    <option {{ $blog->product_size == 'L' ? 'selected' : '' }} value="L">L</option>
                    <option {{ $blog->product_size == 'XL' ? 'selected' : '' }} value="XL">Xl</option>
                    <option {{ $blog->product_size == 'XXL' ? 'selected' : '' }} value="XXL">XXl</option>
                </select>
                @error('product_size')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="col-md-6 mb-4">
                <label for="condition" class="form-label">Condition:</label>
                <select id="condition" name="product_condition" class="form-control" required>
                    <option {{ $blog->product_condition == 'new' ? 'selected' : '' }} value="new">New</option>
                    <option {{ $blog->product_condition == 'used' ? 'selected' : '' }} value="used">Used</option>
                    <option {{ $blog->product_condition == 'refurbished' ? 'selected' : '' }} value="refurbished">Refurbished</option>
                </select>
                @error('condition')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-6 mb-4">
                <div class="row">
                    <div class="col-md-4 mb-2">
                        <label for="delivery" class="form-label">Delivery Available:</label>
                        <div class="form-check">
                            <input type="checkbox" id="delivery" name="delivery_option" value="available" class="form-check-input" {{ $blog->delivery_option == 'available'? 'checked' : '' }}>
                            <label for="delivery" class="form-check-label">Available</label>
                        </div>
                        @error('delivery')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-2">
                        <label for="pickup" class="form-label">Pickup Options:</label>
                        <div class="form-check">
                            <input type="checkbox" id="pickup" name="pickup" value="available" class="form-check-input" {{ $blog->pickup == 'available'? 'checked' : '' }}>
                            <label for="pickup" class="form-check-label">Available</label>
                        </div>
                        @error('pickup')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-2">
                        <label for="shipping" class="form-label">Shipping Included:</label>
                        <div class="form-check">
                            <input type="checkbox" id="shipping" name="shipping" value="included" class="form-check-input" {{ $blog->shipping == 'included'? 'checked' : '' }}>
                            <label for="shipping" class="form-check-label">Included</label>
                        </div>
                        @error('shipping')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <label class="form-label">Sale Option:</label>
                <div class="form-check">
                    <input type="radio" id="online" name="saleOption" value="online" class="form-check-input"  {{ $blog->saleOption == 'online'? 'checked' : '' }}>
                    <label for="online" class="form-check-label">Sell Online for Delivery</label>
                </div>
                <!-- <div class="form-check">
                    <input type="radio" id="pickupOption" name="saleOption" value="pickup" class="form-check-input" required {{ $blog->saleOption == 'pickup'? 'checked' : '' }}>
                    <label for="pickupOption" class="form-check-label">Pickup at Location</label>
                </div>

                <div class="col-md-12 mb-4 address_input d-none">
                    <input type="text" id="pickupOption" name="address" value="{{$blog->address}}" class="form-control " placeholder="Enter your pikup address">
                </div>
                @error('saleOption')
                <small class="text-danger">{{ $message }}</small>
                @enderror -->
            </div>


            <div class="col-md-6 mb-4">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label for="bid" class="form-label">Allow Offers/Bids:</label>
                        <div class="form-check">
                            <input type="checkbox" id="bid" name="bid" value="allow" class="form-check-input" {{ $blog->bid == 'allow'? 'checked' : '' }}>
                            <label for="bid" class="form-check-label">Allow</label>
                        </div>
                        @error('bid')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-4">
                        <label for="buy" class="form-label">Buy at Face Value:</label>
                        <div class="form-check">
                            <input type="checkbox" id="buy" name="buy_at_face_value" value="allow" class="form-check-input" {{ $blog->buy_at_face_value == 'allow'? 'checked' : '' }}>
                            <label for="buy" class="form-check-label">Allow</label>
                        </div>
                        @error('buy')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="col-md-12 mb-4">
                <label class="labels">Product Description</label>
                <div id="summernote">
                    <textarea id="editor1" class="form-control" name="description" placeholder="Write a text">{{$blog->description}}</textarea>


                    @error('description')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <!-- <div class="col-md-12 mb-4">
                            <label class="labels">Additional info</label>
                            <div id="sub_summernote">
                                <textarea id="sub_editor" class="form-control" name="additional_info" placeholder="Write a text">{{$blog->additional_info}}</textarea>

                               
                                @error('additional_info')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div> -->
            <div class="col-md-6 mb-4">
                <label class="labels">Product URL / Afilate URL</label>
                <input type="link" class="form-control" name="product_url" placeholder="URL" value="{{$blog->product_url}}">
                @error('product_price')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-6 mb-4">
                <label class="labels">Want to reach a larger audience? Add location</label>
                <input name="location" type="text" class="form-control get_loc" id="location" value="{{$blog->location}}" placeholder="Location">
                <div class="searcRes" id="autocomplete-results">

                </div>
            </div>



            <div class="col-md-6 mb-4">
                <label class="labels">Product Price ($)</label>
                <input type="text" class="form-control" name="product_price" placeholder="$" value="{{$blog->product_price}}" required>

                @error('product_price')
                <small class="errortext">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-6 mb-4">
                <label class="labels">Product Sale Price ($)</label>
                <input type="text" class="form-control" name="product_sale_price" placeholder="$" value="{{$blog->product_sale_price}}" required>
                <span id="salePriceError" class="text-red"></span>
                @error('product_sale_price')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-6 mb-4">
                <label class="labels">Post Featured Image *</label>
                <div class="upload-icon"><a class="cam btn btn-warning"  href="javascript:void(0)">
                    <i class="fa fa-upload" aria-hidden="true"></i>
                        upload image
                    </a> 
                </div>
               
                <div class="gallery"></div>
                <div class="show-img">
                    <?php
                    $neimg = trim($blog->image1, '[""]');
                    $img  = explode('","', $neimg);

                    // echo "<pre>";print_r($img);die('dev');
                    ?>
                    @foreach($img as $images)
                    <img src="{{asset('images_blog_img')}}/{{$images}}" alt="Image" class="uploaded-image" id="image-container">
                    @endforeach

                </div>
                @error('image')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-6 mb-4">
                <label class="labels"> Post Video Format: .mp4 | Max size: 20MB</label>
                <div class="image-upload">
                    <label style="cursor: pointer;" for="video_upload">
                        <img src="" alt="" class="uploaded-image">
                        <div class="h-100">
                            <div class="dplay-tbl">
                                <div class="dplay-tbl-cell">
                                    <i class="far fa-file-video mb-3"></i>
                                    <h6 class="mt-10 mb-70">Upload Or Drop Your Video Here</h6>
                                </div>
                            </div>
                        </div><!--upload-content-->
                        <input data-required="image" type="file" accept="video/*" id="video_upload" class="image-input" data-traget-resolution="image_resolution" name="post_video" value="">
                    </label>
                </div>
                @if($blog->post_video)
                <div class="show-video">
                    <video controls id="video-tag">
                        <source id="video-source" src="{{asset('images_blog_video')}}/{{$blog->post_video}}">
                        Your browser does not support the video tag.
                    </video>
                    <i class="fas fa-times" id="cancel-btn-1"></i>
                    @error('post_video')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                @endif
            </div>


            <div class="col-md-12 mb-4">

                <div class="col-md-12 mt-4">
                    <label class="custom-toggle">
                        <input type="checkbox" name="personal_detail" value="true" {{ $blog->personal_detail == 'true'? 'checked' : '' }}> &nbsp;&nbsp;<span>Do you want to show your contact details.</span>
                    </label>
                </div>
                <div class=" row hidesection d-none">
                    <div class="col-md-6 mt-4 ">
                        <label class="custom-toggle">Email</label>
                        <input type="email" class="form-control" name="email" value="{{$blog->email}}" placeholder="example@example.com">

                    </div>
                    <div class="col-md-6 mt-4">
                        <label class="custom-toggle">Phone no</label>
                        <input type="tel" class="form-control" name="phone" value="{{$blog->phone}}" placeholder="+1 1234567890">
                    </div>
                    <div class="col-md-6 mt-4">
                        <label class="custom-toggle">Website link</label>
                        <input type="text" class="form-control" name="website" value="{{$blog->website}}" placeholder="https://test.com">
                    </div>
                    <div class="col-md-6 mt-4">
                        <label class="custom-toggle">Whatsapp</label>
                        <input type="tel" class="form-control" name="whatsapp" value="{{$blog->whatsapp}}" placeholder="whatsapp number">
                    </div>
                    <div class="col-md-2 mt-4">
                        <label class="custom-toggle">Twitter</label>
                        <input type="text" class="form-control" name="twitter" value="{{$blog->twitter}}" placeholder="https://twitter.com/">
                    </div>
                    <div class="col-md-2 mt-4">
                        <label class="custom-toggle">Youtube </label>
                        <input type="text" class="form-control" name="youtube" value="{{$blog->youtube}}" placeholder="https://www.youtube.com/channel">
                    </div>
                    <div class="col-md-2 mt-4">
                        <label class="custom-toggle">Facebook</label>
                        <input type="text" class="form-control" name="facebook" value="{{$blog->facebook}}" placeholder="https://www.facebook.com">
                    </div>
                    <div class="col-md-2 mt-4">
                        <label class="custom-toggle">Instagram</label>
                        <input type="text" class="form-control" name="instagram" value="{{$blog->instagram}}" placeholder="https://www.instagram.com">
                    </div>
                    <div class="col-md-2 mt-4">
                        <label class="custom-toggle">Linkedin </label>
                        <input type="text" class="form-control" name="linkedin" value="{{$blog->linkedin}}" placeholder="https://www.linkedin.com/">
                    </div>
                    <div class="col-md-2 mt-4">
                        <label class="custom-toggle">Tiktok </label>
                        <input type="text" class="form-control" name="tiktok" value="{{$blog->tiktok}}" placeholder="https://www.tiktok.com/@">
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-5 text-center"><button class="btn profile-button editCategory" type="submit">Update</button></div>
    </form>
</div>
<script>
    $(document).ready(function() {
        var isChecked1 = $('input[name="personal_detail"]').is(':checked');
        console.log(isChecked1);
        if (isChecked1 === true) {
            $('.hidesection').removeClass('d-none');
        } else {
            $('.hidesection').addClass('d-none');
        }
        $('input[name="personal_detail"]').on('click', function() {
            var isChecked = $(this).is(':checked');
            console.log(isChecked);
            if (isChecked === true) {
                $('.hidesection').removeClass('d-none');
            } else {
                $('.hidesection').addClass('d-none');
            }
        });
    });

    $(document).ready(function() {
        $('input[name="saleOption"]').on('click', function() {
            var saleOption = $(this).val();
            // var saleOption = $(this).is(':checked');
            console.log(saleOption);
            if (saleOption === 'pickup') {
                $('.address_input').removeClass('d-none');
            } else {
                $('.address_input').addClass('d-none');
            }
        });
    });

    $(document).ready(function() {

        $('#sub_category').on('change', function() {
            if ($(this).val() == "Other") {
                $('#Other-cate-input').removeClass('d-none');
                $(this).addClass('d-none');
            } else {
                $('#Other-cate-input').addClass('d-none');
            }

        });

        $('.editCategory').click(function() {
            var subcate_title = $('#Other-cate-input').val();
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            $.ajax({
                url: baseurl + '/shopping/cate',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    title: subcate_title,
                    parent_id: 6,
                },
                success: function(response) {
                    console.log(response);
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