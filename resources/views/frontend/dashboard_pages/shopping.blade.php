@extends('layouts.user_dashboard.userdashboardlayout')
@section('content')
<style type="text/css">
    .errortext{
        color: red;
    }
    #hiddenDiv {
        display: none;
    }
    #NormalDiv {
        padding: 10px;
    }

  .error-message {color: #e74a3b;}
    @media only screen and (max-width:767px){
        .container {padding-bottom: 50px !important;}
    }
</style>
 <div class="container px-sm-5 px-4 ">
    <form method="post" action="<?php echo route('shopping'); ?>" enctype="multipart/form-data" id="shoppingForms">
     {{ @csrf_field() }}
                    <!-- Page Heading -->
                    <div class="d-sm-flex flex-column  mb-3">
                        <h1 class="h3 mb-0 text-gray-800 fw-bold">Category: Shopping</h1>
                        <p>Choose the best category that fits your needs and create a free post</p>
                    </div>
                    <span>
                        @include('admin.partials.flash_messages')
                    </span>
                    <input type="hidden" name="categories" value="6">

                    <div class="row bg-white border-radius pb-4 p-3">
                        <div class="col-md-6 mb-4">
                            <label class="labels">Title <sup>*</sup></label>
                            <input type="text" id="title-input" class="form-control" name="title" placeholder="Title" value="{{ old('title') }}" required>
                             <span class="error-message" id="title-error"></span>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="labels">Sub categories <sup>*</sup></label>
                            <select name="sub_category" class="form-control form-control-xs selectpicker" data-size="7" data-live-search="true" data-title="Sub categories" id="sub_category" data-width="100%" required>
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
                                    <option class="fw-bold" value="<?= $parentListValue['id']; ?>" {{ old('sub_category') == $parentListValue['id'] ? 'selected' : '' }}><b><?= $parentListValue['title']; ?><b></option>
                                    @foreach($sub_blog_categories as $b)
                                        @if($b->parent_id ==$parentListValue['id'])
                                            <option value="<?php echo $b['id']; ?>" {{ old('sub_category') == $b['id'] ? 'selected' : '' }}>&nbsp;&nbsp;&nbsp;&#8226;&nbsp;&nbsp;&nbsp;<?php echo $b['title']; ?></option>
                                        @endif
                                    @endforeach
                                <?php endforeach; ?>
                                <option class="Other-cate" value="Other" {{ old('sub_category') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>

                            
                             <input type="text" class="form-control d-none mt-2" id="Other-cate-input" name="sub_category_oth" placeholder="sub_category name" value="">
                           
                             @error('sub_categories')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        

                        <div class="container vehicle-details">
                            <h5>Posting Details</h5>
                            <div class="row">
                                
                        <div class="col-md-4">
                            <div class="row">
                                <!-- Column 1 -->
                                <div class="col-md-12 mb-4">
                                    <label class="labels">Product brand name</label>
                                    <input type="text" class="form-control" name="brand_name" placeholder="Product brand name">
                                </div>

                                <div class="col-md-12 mb-4">
                                    <label class="labels d-inline-flex" for="auto_vin" data-toggle="tooltip" data-placement="top" title="Vehicle Identification Number">VIN</label>
                                    <input type="text" class="form-control" id="auto_vin" name="vehicle_vin" placeholder="(Optional)">
                                </div>
                        
                                <div class="col-md-12 mb-4">
                                    <label class="labels" for="auto_make_model">Make and model</label>
                                    <input type="text" class="form-control" id="auto_make_model" name="vehicle_model" data-autocomplete="makemodel" maxlength="50" autocomplete="off">
                                </div>
                        
                                <div class="col-md-12 mb-4">
                                    <label class="labels" for="auto_miles">Odometer</label>
                                    <input type="text" class="form-control" id="auto_miles" name="vehicle_odometer" placeholder="Miles" autocomplete="off">
                                </div>
                        
                                <div class="col-md-12 mt-4">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="odometer_broken" name="odometer_break" value="1">
                                        <label class="form-check-label" for="odometer_broken">Odometer broken</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="odometer_rolled_over" name="odometer_rolled_over" value="1">
                                        <label class="form-check-label" for="odometer_rolled_over">Odometer rolled over</label>
                                    </div>
                                </div>

                                </div>
                            </div>
                        
                            <div class="col-md-4">
                                <div class="row">

                                <div class="col-md-12 mb-4">
                                    <label class="labels" for="condition">Condition</label>
                                    <select id="condition" name="vehicle_condition" class="form-control">
                                        <option value="">Select condition</option>
                                        <option value="New">New</option>
                                        <option value="Like-New">Like New</option>
                                        <option value="Excellent">Excellent</option>
                                        <option value="Good">Good</option>
                                        <option value="Fair">Fair</option>
                                        <option value="Salvage">Salvage</option>
                                    </select>
                                </div>
                        
                                <div class="col-md-12 mb-4">
                                    <label class="labels" for="auto_cylinders">Cylinders</label>
                                    <select id="auto_cylinders" name="vehicle_cylinders" class="form-control">
                                        <option value="">Select cylinders</option>
                                        <option value="3-Cylinders">3 Cylinders</option>
                                        <option value="4-Cylinders">4 Cylinders</option>
                                        <option value="5-Cylinders">5 Cylinders</option>
                                        <option value="6-Cylinders">6 Cylinders</option>
                                        <option value="8-Cylinders">8 Cylinders</option>
                                        <option value="10-Cylinders">10 Cylinders</option>
                                        <option value="12-Cylinders">12 Cylinders</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                        
                                <div class="col-md-12 mb-4">
                                    <label class="labels" for="auto_drivetrain">Drive</label>
                                    <select id="auto_drivetrain" name="vehicle_drive" class="form-control">
                                        <option value="">Select</option>
                                        <option value="FWD">FWD</option>
                                        <option value="RWD">RWD</option>
                                        <option value="4WD">4WD</option>
                                    </select>
                                </div>
                        
                                <div class="col-md-12 mb-4">
                                    <label class="labels" for="auto_fuel_type">Fuel</label>
                                    <select id="auto_fuel_type" name="vehicle_fuel" class="form-control">
                                        <option value="">Select fuel</option>
                                        <option value="Gas">Gas</option>
                                        <option value="Diesel">Diesel</option>
                                        <option value="Hybrid">Hybrid</option>
                                        <option value="Electric">Electric</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                        
                                <div class="col-md-12 mb-4">
                                    <label class="labels" for="language">Language of posting</label>
                                    <select id="language" name="language_of_posting" class="form-control">
                                        <option value="">Select language</option>
                                        <option value="Afrikaans">Afrikaans</option>
                                        <option value="Català">Català</option>
                                        <option value="Dansk">Dansk</option>
                                        <option value="Deutsch">Deutsch</option>
                                        <option value="English" selected>English</option>
                                        <option value="Español">Español</option>
                                        <option value="Suomi">Suomi</option>
                                        <option value="Français">Français</option>
                                        <option value="Italiano">Italiano</option>
                                        <option value="Nederlands">Nederlands</option>
                                        <option value="Norsk">Norsk</option>
                                        <option value="Português">Português</option>
                                        <option value="Svenska">Svenska</option>
                                        <option value="Filipino">Filipino</option>
                                        <option value="Türkçe">Türkçe</option>
                                        <option value="中文">中文</option>
                                        <option value="العربية">العربية</option>
                                        <option value="日本語">日本語</option>
                                        <option value="한국말">한국말</option>
                                        <option value="Русский">Русский</option>
                                        <option value="Tiếng Việt">Tiếng Việt</option>
                                    </select>
                                </div>
                        
                                <div class="col-md-12 mb-4">
                                    <label class="labels" for="auto_paint">Paint color</label>
                                    <select id="auto_paint" name="vehicle_paint_color" class="form-control">
                                        <option value="">Select color</option>
                                        <option value="Black">Black</option>
                                        <option value="Blue">Blue</option>
                                        <option value="Brown">Brown</option>
                                        <option value="Green">Green</option>
                                        <option value="Grey">Grey</option>
                                        <option value="Orange">Orange</option>
                                        <option value="Purple">Purple</option>
                                        <option value="Red">Red</option>
                                        <option value="Silver">Silver</option>
                                        <option value="White">White</option>
                                        <option value="Yellow">Yellow</option>
                                        <option value="Custom">Custom</option>
                                    </select>
                                </div>
                        
                                </div>
                            </div>

                                <!-- Column 3 -->
                            <div class="col-md-4">
                                <div class="row">

                                    <div class="col-md-12 mb-4">
                                        <label class="labels" for="auto_title_status">Title status</label>
                                        <select id="auto_title_status" name="vehicle_title_status" class="form-control">
                                            <option value="">Select</option>
                                            <option value="Clean">Clean</option>
                                            <option value="Salvage">Salvage</option>
                                            <option value="Rebuilt">Rebuilt</option>
                                            <option value="Parts">Parts Only</option>
                                            <option value="Lien">Lien</option>
                                            <option value="Missing">Missing</option>
                                        </select>
                                    </div>
                            
                                    <div class="col-md-12 mb-4">
                                        <label class="labels" for="auto_transmission">Transmission</label>
                                        <select id="auto_transmission" name="vehicle_transmission" class="form-control">
                                            <option value="">Select</option>
                                            <option value="Manual">Manual</option>
                                            <option value="Automatic">Automatic</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                            
                                    <div class="col-md-12 mb-4">
                                        <label class="labels" for="auto_bodytype">Type</label>
                                        <select id="auto_bodytype" name="vehicle_type" class="form-control">
                                            <option value="">Select type</option>
                                            <option value="Bus">Bus</option>
                                            <option value="Convertible">Convertible</option>
                                            <option value="Coupe">Coupe</option>
                                            <option value="Hatchback">Hatchback</option>
                                            <option value="Minivan">Minivan</option>
                                            <option value="Offroad">Offroad</option>
                                            <option value="Pickup">Pickup</option>
                                            <option value="Sedan">Sedan</option>
                                            <option value="Truck">Truck</option>
                                            <option value="SUV">SUV</option>
                                            <option value="Wagon">Wagon</option>
                                            <option value="Van">Van</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                            
                                    <?php
                                    $currentYear = date('Y');
                                    $startYear = 1990;
                                    $endYear = $currentYear;
                                    ?>
                                    
                                    <div class="col-md-12 mb-4">
                                        <label class="labels" for="auto_model_year">Model year</label>
                                        <select id="auto_model_year" name="vehicle_model_year" class="form-control">
                                            <?php
                                            for ($year = $startYear; $year <= $endYear; $year++) {
                                                $selected = ($year == $endYear) ? 'selected' : '';
                                                echo "<option value=\"$year\" $selected>$year</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    
                                <div class="col-md-12 mt-4">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="crypto_currency_ok" name="crypto_currency" value="1">
                                        <label class="form-check-label" for="crypto_currency_ok">
                                            <span>Cryptocurrency ok</span>
                                            {{-- <span class="text-muted">• Autofilled</span> --}}
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="delivery_available" name="delivery_available" value="1">
                                        <label class="form-check-label" for="delivery_available">
                                            <span>Delivery available</span>
                                            {{-- <span class="text-muted">• Autofilled</span> --}}
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="see_my_other" name="more_links" value="1">
                                        <label class="form-check-label" for="see_my_other">
                                            <span>Include "more ads by this user" link</span>
                                            {{-- <span class="text-muted">• Autofilled</span> --}}
                                        </label>
                                    </div>
                                </div>

                                </div>
                            </div>
                        

                            </div>
                        </div>
                        

                        

                        <span id="NormalDiv" class="row">

                         <div class="col-md-6 mb-4">
                            <label class="labels">Product brand name</label>
                            <input type="text" class="form-control" name="brand_name" placeholder="Product brand name" value="{{ old('brand_name') }}">
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

                         <div class="col-md-6 mb-4 product_size">
                                <label class="labels">Size</label>
                                <select class="form-control" name="product_size">
                                    <option value="" {{ old('product_size') == '' ? 'selected' : '' }}>Select option</option>
                                    <option value="ALL" {{ old('product_size') == 'ALL' ? 'selected' : '' }}>ALL</option>
                                    <option value="XS" {{ old('product_size') == 'XS' ? 'selected' : '' }}>XS</option>
                                    <option value="S" {{ old('product_size') == 'S' ? 'selected' : '' }}>S</option>
                                    <option value="M" {{ old('product_size') == 'M' ? 'selected' : '' }}>M</option>
                                    <option value="L" {{ old('product_size') == 'L' ? 'selected' : '' }}>L</option>
                                    <option value="XL" {{ old('product_size') == 'XL' ? 'selected' : '' }}>XL</option>
                                    <option value="XXL" {{ old('product_size') == 'XXL' ? 'selected' : '' }}>XXL</option>
                                </select>
                                @error('product_size')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>


                        <div class="col-md-6 mb-4">
                            <label for="condition" class="form-label">Condition:</label>
                            <select id="condition" name="product_condition" class="form-control">
                                <option value="" {{ old('product_condition') == '' ? 'selected' : '' }}>Select option</option>
                                <option value="new" {{ old('product_condition') == 'new' ? 'selected' : '' }}>New</option>
                                <option value="used" {{ old('product_condition') == 'used' ? 'selected' : '' }}>Used</option>
                                <option value="refurbished" {{ old('product_condition') == 'refurbished' ? 'selected' : '' }}>Refurbished</option>
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
                                    <input type="checkbox" id="delivery" name="delivery_option" {{ old('delivery_option') == 'available' ? 'checked' : '' }}  value="available" class="form-check-input">
                                    <label for="delivery" class="form-check-label">Available</label>
                                </div>
                                @error('delivery')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 col-lg-4 mb-2 fr1">
                                <label for="pickup" class="form-label">Pickup at location:</label>
                                <div class="form-check">
                                    <input type="checkbox" id="pickup" name="pickup" {{ old('pickup') == 'available' ? 'checked' : '' }} value="available" class="form-check-input">
                                    <label for="pickup" class="form-check-label">Available</label>
                                </div>
                                @error('pickup')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 col-lg-4 mb-2 fr1">
                                <label for="shipping" class="form-label">Shipping Included:</label>
                                <div class="form-check">
                                    <input type="checkbox" id="shipping" name="shipping" value="included" class="form-check-input" {{ old('shipping') == 'included' ? 'checked' : '' }}>
                                    <label for="shipping" class="form-check-label">Included</label>
                                </div>
                                @error('shipping')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 col-lg-4 mb-2 fr1">
                                <label for="bid" class="form-label">Allow Offers/Bids:</label>
                                <div class="form-check">
                                    <input type="checkbox" id="bid" name="bid" value="allow" class="form-check-input" {{ old('bid') == 'allow' ? 'checked' : '' }}>
                                    <label for="bid" class="form-check-label">Allow</label>
                                </div>
                                @error('bid')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 col-lg-4 mb-2 fr1">
                                <label for="buy" class="form-label">Buy at Face Value:</label>
                                <div class="form-check">
                                    <input type="checkbox" id="buy" name="buy_at_face_value" value="allow" class="form-check-input" {{ old('buy_at_face_value') == 'allow' ? 'checked' : '' }}>
                                    <label for="buy" class="form-check-label">Allow</label>
                                </div>
                                @error('buy')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                <div class="col-md-6 mb-4 sl-opt">
                    <label class="form-label">Sale option:</label>
                    <div class="form-check">
                        <input type="radio" id="online" name="saleOption" value="online" class="form-check-input" {{ old('saleOption') == 'online' ? 'checked' : '' }}>
                        <label for="online" class="form-check-label">Sell online for delivery</label>
                    </div>
                    <!-- <div class="form-check">
                        <input type="radio" id="pickupOption" name="saleOption" value="pickup" class="form-check-input" required>
                        <label for="pickupOption" class="form-check-label">Pickup at Location</label>
                    </div> -->

                    <div class="col-md-12 mb-4 address_input d-none">
                        <!-- <label class="form-label">Pickup Address</label> -->
                        <input type="text" id="pickupOption" name="address" value="{{ old('saleOption') }}" class="form-control " placeholder="Enter your pikup address" > 
                    </div>
                    @error('saleOption')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                     
            </span>
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

                         
                        <div id="hiddenDiv" class="col-md-12 mb-4 pet_details">
                            <!-- <h6 class="labels fw-bold">Find Your Favourite Pet</h6> -->
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="labels">Type of Animal</label>
                                    <select class="form-control" name="type_of_animal">
                                        <option value="" {{ old('type_of_animal') == '' ? 'selected' : '' }}>Select option</option>
                                        <option value="cat" {{ old('type_of_animal') == 'cat' ? 'selected' : '' }}>Cat</option>
                                        <option value="kitten" {{ old('type_of_animal') == 'kitten' ? 'selected' : '' }}>Kitten</option>
                                        <option value="dog" {{ old('type_of_animal') == 'dog' ? 'selected' : '' }}>Dog</option>
                                        <option value="puppy" {{ old('type_of_animal') == 'puppy' ? 'selected' : '' }}>Puppy</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label class="labels">Pet name </label>
                                    <input type="text" class="form-control" name="pet_name" placeholder="Pet name" value="{{ old('pet_name')}}">
                                 </div>
                                <!-- <div class="col-md-6 mb-4">
                                    <label class="labels">Location </label>
                                    <input type="text" class="form-control" name="location" placeholder=" Location" value="{{ old('location')}}">
                                 </div> -->
                                <!-- <div class="col-md-6 mb-4">
                                    <label class="labels">Website </label>
                                    <input type="text" class="form-control" name="website" placeholder="Website Name" value="">
                                 </div> -->
                                <div class="col-md-6 mb-4">
                                    <label class="labels">Breed </label>
                                    <input type="text" class="form-control" name="breed" placeholder="Breed Name" value="{{ old('breed')}}">
                                 </div>
                                <div class="col-md-6 mb-4">
                                    <label class="labels">Color </label>
                                    <input type="text" class="form-control" name="pet_color" placeholder="Color Name" value="{{ old('pet_color')}}">
                                 </div>
                                 <div class="col-md-6 mb-4">
                                    <label class="labels">Age </label>
                                    <select class="form-control" name="pet_age">
                                        <option value="" {{ old('pet_age') == '' ? 'selected' : '' }}>Select option</option>
                                        <option value="young" {{ old('pet_age') == 'young' ? 'selected' : '' }}>Young</option>
                                        <option value="old" {{ old('pet_age') == 'old' ? 'selected' : '' }}>Old</option>
                                    </select>

                                 </div>
                                 <div class="col-md-6 mb-4">
                                    <label class="labels">Gender </label>
                                    <select class="form-control" name="pet_gender">
                                        <option value="" {{ old('pet_gender') == '' ? 'selected' : '' }}>Select option</option>
                                        <option value="male" {{ old('pet_gender') == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ old('pet_gender') == 'female' ? 'selected' : '' }}>Female</option>
                                    </select>

                                 </div>
                                 <div class="col-md-6 mb-4">
                                    <label class="labels">Size </label>
                                    <input type="number" class="form-control" name="pet_size" placeholder="Enter Size" value="{{ old('pet_size')}}">
                                 </div>
                                 <div class="col-md-6 mb-4">
                                    <label class="labels">Coat length </label>
                                    <input type="text" class="form-control" name="coat" placeholder="Coat Length" value="{{ old('coat')}}">
                                 </div>
                                 <div class="col-md-6 mb-4">
                                    <label class="labels">Adoption fee </label>
                                    <input type="number" class="form-control" name="adoption_fee" placeholder="Fees" value="{{ old('adoption_fee')}}">
                                 </div>
                                 <div class="col-md-6 mb-4">
                                    <label class="labels">Health </label>
                                    <input type="text" class="form-control" name="health" placeholder="Health" value="{{ old('health')}}">
                                 </div>
                                 <div class="col-md-6 mb-4">
                                    <label class="labels">House trained </label>
                                    <input type="text" class="form-control" name="house_trained" placeholder="House Trained" value="{{ old('house_trained')}}">
                                 </div>
                                <!--  <div class="col-md-6 mb-4">
                                    <label class="labels">Contact Information </label>
                                    <input type="text" class="form-control" name="contact" placeholder="Contact Info" value="">
                                 </div> -->
                            </div>

                        </div>

                        
                         <div class="col-md-12 mb-4">
                            <label class="labels">Product description</label>
                            <div id="summernote">
                                <textarea id="editor1" class="form-control" name="description"  placeholder="Description"><?php echo old('description'); ?>
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
                        <span id="normalDiv2" class="row" style="padding: 10px;">
                        <div class="col-md-6 mb-4">
                            <label class="labels">Product URL / Affiliate URL</label>
                            <input type="link" class="form-control" name="product_url" placeholder="URL" value="{{ old('product_url') }}" >
                             @error('product_price')
                                    <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="labels">Want to reach a larger audience? Add Location</label>
                            <input name="location" type="text"  class="form-control get_loc" id="location" value="{{ old('location') }}" placeholder="Location">
                            <div class="searcRes" id="autocomplete-results">
                                    
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-4">
                            <label class="labels">Product price ($)</label>
                            <input type="text" class="form-control" name="product_price" placeholder="$" value="{{ old('product_price') }}" >
                             @error('product_price')
                                    <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="labels">Product offer price ($)</label>
                            <input type="text" class="form-control" name="product_sale_price" placeholder="$" value="{{ old('product_sale_price') }}" >
                            <span id="salePriceError" class="errortext"></span>
                            @error('product_sale_price')
                                    <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        </span>
                            <div class="col-md-6 mb-4">
                            <label class="labels" data-toggle="tooltip" data-placement="top" title="Any photo that signals an intention to commit, solicit, promote or encourage a criminal act and/or violate the  Advertiser Agreement will not be accepted.">Post featured image <em>(Select multiple)</em> <i class="fa fa-question popup2"> </i></label>
                            <!-- <div class="image-upload post_img ">
                                <label style="cursor: pointer;" for="image_upload">
                                   
                                    <div class="h-100">
                                        <div class="dplay-tbl">
                                            <div class="dplay-tbl-cell">
                                                <i class="far fa-file-image mb-3"></i>
                                                <h6 class="mt-10 mb-70">Upload Or Drop Your Image Here</h6>
                                            </div>
                                        </div>
                                    </div>
                                   
                                    <input data-required="image" type="file" name="image[]" multiple id="image_upload" class="image-input" data-traget-resolution="image_resolution" value="" onchange="checkImageCount(this, maxImageCount )"> 
                                </label>
                              
                            </div> -->
                            <div class="upload-icon"><a class="cam btn btn-warning"  href="javascript:void(0)">
                                <i class="fa fa-upload" aria-hidden="true"></i>
                                    Upload image
                                </a> 
                            </div>
                           
                            <div class="gallery" id="sortableImgThumbnailPreview"></div>
                            <div class="show-img">

                               
                            </div>
                            @error('image')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror 
                        </div>
                        {{-- <div class="col-md-6 mb-4">
                            <label class="labels"> Post video  format: .mp4 | max size: 20MB <em>(Select multiple)</em></label>
                            <div class="image-upload">
                                <label style="cursor: pointer;" for="video_upload">
                                    <!-- <img src="" alt="Image" class="uploaded-image"> -->
                                    <div class="h-100">
                                           <div class="">
                                            <div class="dplay-tbl-cell">
                                                <!-- <i class="fas fa-cloud-upload-alt mb-3"></i>
                                                <h6><b>Upload Video</b></h6> -->
                                                <i class="far fa-file-video mb-3"></i>
                                                <h6 class="mt-10 mb-70">Upload or drop your video here</h6>
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
                        </div> --}}
                       <div class="col-md-12 mb-4">
                              
                                    <div class="col-md-12 mt-4">
                                        <label class="custom-toggle">
                                            <input type="checkbox" name="personal_detail" {{ old('personal_detail') == 'true' ? 'checked' : '' }} value="true"> &nbsp;&nbsp;<span>Show your contact details. Keep in mind if you want customers to reach you outside of FindersPage you will need to make your contact details visible to the public.</span>
                                        </label>
                                    </div> 
                                     <div class="row"> 
                                        <div class="col-md-6 mt-4 ">
                                            <label class="custom-toggle">Email</label>
                                                <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="example@example.com">
                                           
                                        </div>
                                        <div class="col-md-6 mt-4">
                                            <label class="custom-toggle">Phone number</label>
                                                <input type="tel" class="form-control" name="phone" id="phone" value="{{ old('phone') }}" placeholder="+1 1234567890">
                                        </div>
                                        <div class="col-md-6 mt-4">
                                            <label class="custom-toggle">Website link</label>
                                                <input type="text" class="form-control" name="website" value="{{ old('website') }}" placeholder="https://test.com">
                                        </div>
                                        <div class="col-md-6 mt-4">
                                            <label class="custom-toggle">Whatsapp</label>
                                                <input type="tel" class="form-control" name="whatsapp" id="whatsapp" value="{{ old('whatsapp') }}" placeholder="whatsapp number">
                                        </div>
                                        <!-- <div class="col-md-2 mt-4">
                                            <label class="custom-toggle">Twitter</label>
                                                <input type="text" class="form-control" name="twitter" value="" placeholder="https://twitter.com/">
                                        </div>
                                        <div class="col-md-2 mt-4">
                                            <label class="custom-toggle">Youtube </label>
                                                <input type="text" class="form-control" name="youtube" value="" placeholder="https://www.youtube.com/channel">
                                        </div>
                                        <div class="col-md-2 mt-4">
                                            <label class="custom-toggle">Facebook</label>
                                                <input type="text" class="form-control" name="facebook" value="" placeholder="https://www.facebook.com">
                                        </div>
                                        <div class="col-md-2 mt-4">
                                            <label class="custom-toggle">Instagram</label>
                                                <input type="text" class="form-control" name="instagram" value="" placeholder="https://www.instagram.com">
                                        </div> 
                                        <div class="col-md-2 mt-4">
                                            <label class="custom-toggle">Linkedin </label>
                                                <input type="text" class="form-control" name="linkedin" value="" placeholder="https://www.linkedin.com/">
                                        </div>
                                         <div class="col-md-2 mt-4">
                                            <label class="custom-toggle">Tiktok </label>
                                                <input type="text" class="form-control" name="tiktok" value="" placeholder="https://www.tiktok.com/@">
                                        </div>  -->
                                </div> 
                            </div> 

                    </div>
                        <div class="alert_div d-none">
                            @include('inc.alert_message')
                        </div>
                    
                    <!-- <div class="container pb-4 p-3">
                       <div class="row bg-white border-radius mt-5 p-3">
                            <div class="col-md-6 social-area" style="justify-content: center;">
                                <input type="radio"  name="post_type" {{ old('post_type') == 'Feature Post' ? 'checked' : '' }} value="Feature Post"required>
                                <label class="labels" data-toggle="tooltip" data-placement="top" title="Feature your listing on the homepage starting at just $55 per month.">Feature Listing  <i class="fa fa-question popup1">
                                   
                                </i></label>
                                @error('post_type')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 social-area" style="justify-content: center;">
                                <input type="radio"  name="post_type" {{ old('post_type') == 'Normal Post' ? 'checked' : '' }} value="Normal Post" required>
                                <label class="labels paid_label" data-toggle="tooltip" data-placement="top" title="Your free listing will expire after 44 days. If you renew it before the 44 days is up, your listing will stay up for another 44 days.">Free Listing  <i class="fa fa-question popup2">
                                   
                                </i></label>
                                @error('post_type')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div> -->
                    <input type="hidden" name="post_type" value="Normal Post" >

                    <div class="mt-5 text-center pb-4"><button class="btn profile-button addCategory" type="submit">Publish</button></div> 
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

        // document.getElementById("sub_category").addEventListener("change", function() {
        //     var selectedOption = this.options[this.selectedIndex].innerHTML;
        //     var hiddenDiv = document.getElementById("hiddenDiv");
        //     if (selectedOption === "Find your favorite pet") {
        //     hiddenDiv.style.display = "block";
        //     } else {
        //     hiddenDiv.style.display = "none";
        //     }
        // });

        $(function() {
            var hiddenDiv = $("#hiddenDiv");
            var selectedValue = parseInt($("#sub_category").val()); // Get selected value on load
            if (selectedValue === 1318) {
                hiddenDiv.css("display", "block");
                $('#NormalDiv').addClass('d-none');
                $('#normalDiv2').addClass('d-none');
            } else {
                hiddenDiv.css("display", "none");
                 $('#NormalDiv').removeClass('d-none');
                 $('#normalDiv2').removeClass('d-none');
            }

            $("#sub_category").on('change', function() {
                
                var selectedValue = parseInt($(this).val());

                // alert(selectedValue);
                if (selectedValue === 1281 || selectedValue === 1283 ||selectedValue === 1282) {
                    $('.alert_div').removeClass('d-none');
                    $('.paid_label').text('Paid listing');
                    $('.paid_label').attr('data-original-title','$5.08 per paid listing.');

                }else{
                    $('.alert_div').addClass('d-none');
                    $('.paid_label').text('Free listing');
                    $('.paid_label').attr('data-original-title','Your free listing will expire after 44 days. If you renew it before the 44 days is up, your listing will stay up for another 44 days.');
                }
                if (selectedValue === 1318) {
                    hiddenDiv.css("display", "block");
                    $('#NormalDiv').addClass('d-none');
                    $('#normalDiv2').addClass('d-none');
                } else {
                    hiddenDiv.css("display", "none");
                     $('#NormalDiv').removeClass('d-none');
                     $('#normalDiv2').removeClass('d-none');
                }
            });
        });


    // Vehicle Details box jquery code

    $(document).ready(function() {
        // Initially hide vehicle-details section and ensure NormalDiv is visible
        $('.vehicle-details').hide();
        $('#NormalDiv').show();

        // When the dropdown value changes
        $('#sub_category').change(function() {
            var selectedValue = $(this).val(); 

            if (selectedValue == '1656') {
                $('.vehicle-details').show();
                $('#NormalDiv').hide();
                $('#NormalDiv input[name="brand_name"]').val('').prop('disabled', true);
            } else {
                $('.vehicle-details').hide();
                $('#NormalDiv').show();
                $('#NormalDiv input[name="brand_name"]').prop('disabled', false);
            }
        });
    });
</script>



@endsection