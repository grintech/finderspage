@extends('layouts.user_dashboard.userdashboardlayout')
@section('content')
<?php  use Carbon\Carbon; ?>

<style type="text/css">
    .errortext{
        color: red;
    }
    .drag_box{
        width: 100px;
        margin-right: 10px;
        height: 100px;
        border: 2px solid red;
        box-shadow: 0px 0px 3px blue;
        padding: 2px;
        cursor: move;
    }
    .drag_box a{
        position: absolute;
        right: 2px;
        z-index: 10;
        color: red;
        background: rgba(0,0,0,0.5);
        padding: 5px;
        font-size: 12px;
        cursor: pointer;
    }
    .drag_box img{
        width: 100%;
        height: 100%;
    }
    .drag_box span{
       background-color: red;
       color: white;
       padding: 2px 5px;
       font-size: 12px;
       font-weight: bold;
       border-radius: 3px;
       position: absolute;
       bottom: 4px;
       left: 4px;
       margin: 0;
   }
   .error-message {color: #e74a3b;}
   @media only screen and (max-width:767px){
        .container-fluid {padding-bottom: 50px !important;}
    }
</style>
<div class="container px-sm-5 px-4 pb-4">
    <form method="post" action="<?php echo route('shoppingEdit', $blog->slug); ?>" class="form-validation" enctype="multipart/form-data">
        <!-- id="shopping_form" -->
        {{ @csrf_field() }}
        <!-- Page Heading -->
        <div class="d-sm-flex flex-column  mb-3">
            <h1 class="h3 mb-0 text-gray-800 fw-bold">Edit : Shopping</h1>
            <!-- <p>Choose the best category that fits your needs and create a free post</p> -->
        </div>
        <span>
            @include('admin.partials.flash_messages')
        </span>
        <input type="hidden" name="categories" value="6">
        <?php 
            $currentDateTime = new DateTime();
            $givenTime = $blog->created; // Assuming $post->created_at is a valid date string

            // Convert the given time to a Carbon instance
            $givenDateTime = Carbon::parse($givenTime);

            // Add 10 days to the given date time
            $nextTenDays = $givenDateTime->addDays(10);

        ?> 
        <div class="row bg-white border-radius pb-4 p-3">
            @if($currentDateTime > $nextTenDays)
            <div class="col-md-6 mb-4">
                <label class="labels">Title <sup>*</sup></label>
                <input type="text" id="title-input" class="form-control" name="title" placeholder="Title" value="{{$blog->title}}" required readonly data-toggle="tooltip" data-placement="top" title="You can't make edits as you created this post more than 10 days ago.">
            </div>
            @else
            <div class="col-md-6 mb-4">
                <label class="labels">Title <sup>*</sup></label>
                <input type="text" id="title-input" class="form-control" name="title" placeholder="Title" value="{{$blog->title}}" required>
                 <span class="error-message" id="title-error"></span>
            </div>
            @endif


            {{-- @if($currentDateTime > $nextTenDays)  
            <div class="col-md-6 mb-4">
                <label class="labels">Sub categories <sup>*</sup></label>
                @foreach($sub_blog_categories as $b)
                    @if($blog->sub_category == $b->id)
                        <input type="text" value="{{ $b->title }}" class="form-control mb-2" readonly data-toggle="tooltip" data-placement="top" title="You can't make edits as you created this post more than 10 days ago.">
                        <input type="hidden" name="sub_category" value="{{ $b->id }}">
                    @endif
                @endforeach
            </div>
        @else
            <div class="col-md-6 mb-4">
                <label class="labels">Sub categories <sup>*</sup></label>
                <select name="sub_category" class="form-control form-control-xs selectpicker" data-size="7" data-live-search="true" data-title="Sub categories" id="sub_category" data-width="100%" required>
                    <?php $i = 0; $parentList = array(); ?>
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
                            @if($b->parent_id == $parentListValue['id'])
                                <option {{ $blog->sub_category == $b['id'] ? 'selected' : '' }} value="<?php echo $b['id']; ?>">&nbsp;&nbsp;&nbsp;&#8226;&nbsp;&nbsp;&nbsp;<?php echo $b['title']; ?></option>
                            @endif
                        @endforeach
                    <?php endforeach; ?>
                    <option class="Other-cate" value="Other">Other</option>
                </select>
                <input type="text" class="form-control d-none mt-2" id="Other-cate-input" name="sub_category_oth" placeholder="sub_category name" value="">
                @error('sub_category')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        @endif --}}

        <div class="col-md-6 mb-4">
            <label class="labels">Sub categories <sup>*</sup></label>
            <select name="sub_category" class="form-control form-control-xs selectpicker" data-size="7" data-live-search="true" data-title="Sub categories" id="sub_category" data-width="100%" required>
                <?php $i = 0; $parentList = array(); ?>
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
                        @if($b->parent_id == $parentListValue['id'])
                            <option {{ $blog->sub_category == $b['id'] ? 'selected' : '' }} value="<?php echo $b['id']; ?>">&nbsp;&nbsp;&nbsp;&#8226;&nbsp;&nbsp;&nbsp;<?php echo $b['title']; ?></option>
                        @endif
                    @endforeach
                <?php endforeach; ?>
                <option class="Other-cate" value="Other">Other</option>
            </select>
            <input type="text" class="form-control d-none mt-2" id="Other-cate-input" name="sub_category_oth" placeholder="sub_category name" value="">
            @error('sub_category')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>


        <div class="container vehicle-details">
            <h5>Posting Details</h5>
            <div class="row">
        
                <!-- Column 1 -->
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <label class="labels">Product brand name</label>
                            <input type="text" class="form-control" name="brand_name" placeholder="Product brand name" value="{{$blog->brand_name}}">
                            @error('brand_name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
        
                        <div class="col-md-12 mb-4">
                            <label class="labels d-inline-flex" for="auto_vin" data-toggle="tooltip" data-placement="top" title="Vehicle Identification Number">VIN</label>
                            <input type="text" class="form-control" id="auto_vin" name="vehicle_vin" placeholder="(Optional)" value="{{ $blog->vehicle_vin }}">
                        </div>
        
                        <div class="col-md-12 mb-4">
                            <label class="labels" for="auto_make_model">Make and model</label>
                            <input type="text" class="form-control" id="auto_make_model" name="vehicle_model" data-autocomplete="makemodel" maxlength="50" autocomplete="off" value="{{ $blog->vehicle_model }}">
                        </div>
        
                        <div class="col-md-12 mb-4">
                            <label class="labels" for="auto_miles">Odometer</label>
                            <input type="text" class="form-control" id="auto_miles" name="vehicle_odometer" placeholder="Miles" autocomplete="off" value="{{ $blog->vehicle_odometer }}">
                        </div>
        
                        <div class="col-md-12 mt-4">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="odometer_broken" name="odometer_break" {{ $blog->odometer_break == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="odometer_broken">Odometer broken</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="odometer_rolled_over" name="odometer_rolled_over" {{ $blog->odometer_rolled_over == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="odometer_rolled_over">Odometer rolled over</label>
                            </div>
                        </div>
                    </div>
                </div>
        
                <!-- Column 2 -->
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <label class="labels" for="condition">Condition</label>
                            <select id="condition" name="vehicle_condition" class="form-control">
                                <option value="">Select condition</option>
                                <option value="New" {{ $blog->vehicle_condition == 'New' ? 'selected' : '' }}>New</option>
                                <option value="Like-New" {{ $blog->vehicle_condition == 'Like-New' ? 'selected' : '' }}>Like New</option>
                                <option value="Excellent" {{ $blog->vehicle_condition == 'Excellent' ? 'selected' : '' }}>Excellent</option>
                                <option value="Good" {{ $blog->vehicle_condition == 'Good' ? 'selected' : '' }}>Good</option>
                                <option value="Fair" {{ $blog->vehicle_condition == 'Fair' ? 'selected' : '' }}>Fair</option>
                                <option value="Salvage" {{ $blog->vehicle_condition == 'Salvage' ? 'selected' : '' }}>Salvage</option>
                            </select>
                        </div>
        
                        <div class="col-md-12 mb-4">
                            <label class="labels" for="auto_cylinders">Cylinders</label>
                            <select id="auto_cylinders" name="vehicle_cylinders" class="form-control">
                                <option value="">Select cylinders</option>
                                <option value="3-Cylinders" {{ $blog->vehicle_cylinders == '3-Cylinders' ? 'selected' : '' }}>3 Cylinders</option>
                                <option value="4-Cylinders" {{ $blog->vehicle_cylinders == '4-Cylinders' ? 'selected' : '' }}>4 Cylinders</option>
                                <option value="5-Cylinders" {{ $blog->vehicle_cylinders == '5-Cylinders' ? 'selected' : '' }}>5 Cylinders</option>
                                <option value="6-Cylinders" {{ $blog->vehicle_cylinders == '6-Cylinders' ? 'selected' : '' }}>6 Cylinders</option>
                                <option value="8-Cylinders" {{ $blog->vehicle_cylinders == '8-Cylinders' ? 'selected' : '' }}>8 Cylinders</option>
                                <option value="10-Cylinders" {{ $blog->vehicle_cylinders == '10-Cylinders' ? 'selected' : '' }}>10 Cylinders</option>
                                <option value="12-Cylinders" {{ $blog->vehicle_cylinders == '12-Cylinders' ? 'selected' : '' }}>12 Cylinders</option>
                                <option value="Other" {{ $blog->vehicle_cylinders == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
        
                        <div class="col-md-12 mb-4">
                            <label class="labels" for="auto_drivetrain">Drive</label>
                            <select id="auto_drivetrain" name="vehicle_drive" class="form-control">
                                <option value="">Select</option>
                                <option value="FWD" {{ $blog->vehicle_drive == 'FWD' ? 'selected' : '' }}>FWD</option>
                                <option value="RWD" {{ $blog->vehicle_drive == 'RWD' ? 'selected' : '' }}>RWD</option>
                                <option value="4WD" {{ $blog->vehicle_drive == '4WD' ? 'selected' : '' }}>4WD</option>
                            </select>
                        </div>
        
                        <div class="col-md-12 mb-4">
                            <label class="labels" for="auto_fuel_type">Fuel</label>
                            <select id="auto_fuel_type" name="vehicle_fuel" class="form-control">
                                <option value="">Select fuel</option>
                                <option value="Gas" {{ $blog->vehicle_fuel == 'Gas' ? 'selected' : '' }}>Gas</option>
                                <option value="Diesel" {{ $blog->vehicle_fuel == 'Diesel' ? 'selected' : '' }}>Diesel</option>
                                <option value="Hybrid" {{ $blog->vehicle_fuel == 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
                                <option value="Electric" {{ $blog->vehicle_fuel == 'Electric' ? 'selected' : '' }}>Electric</option>
                                <option value="Other" {{ $blog->vehicle_fuel == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
        
                        <div class="col-md-12 mb-4">
                            <label class="labels" for="language">Language of posting</label>
                            <select id="language" name="language_of_posting" class="form-control">
                                <option value="">Select language</option>
                                <option value="Afrikaans" {{ $blog->language_of_posting == 'Afrikaans' ? 'selected' : '' }}>Afrikaans</option>
                                <option value="Català" {{ $blog->language_of_posting == 'Català' ? 'selected' : '' }}>Català</option>
                                <option value="Dansk" {{ $blog->language_of_posting == 'Dansk' ? 'selected' : '' }}>Dansk</option>
                                <option value="Deutsch" {{ $blog->language_of_posting == 'Deutsch' ? 'selected' : '' }}>Deutsch</option>
                                <option value="English" {{ $blog->language_of_posting == 'English' ? 'selected' : '' }}>English</option>
                                <option value="Español" {{ $blog->language_of_posting == 'Español' ? 'selected' : '' }}>Español</option>
                                <option value="Suomi" {{ $blog->language_of_posting == 'Suomi' ? 'selected' : '' }}>Suomi</option>
                                <option value="Français" {{ $blog->language_of_posting == 'Français' ? 'selected' : '' }}>Français</option>
                                <option value="Italiano" {{ $blog->language_of_posting == 'Italiano' ? 'selected' : '' }}>Italiano</option>
                                <option value="Nederlands" {{ $blog->language_of_posting == 'Nederlands' ? 'selected' : '' }}>Nederlands</option>
                                <option value="Norsk" {{ $blog->language_of_posting == 'Norsk' ? 'selected' : '' }}>Norsk</option>
                                <option value="Português" {{ $blog->language_of_posting == 'Português' ? 'selected' : '' }}>Português</option>
                                <option value="Svenska" {{ $blog->language_of_posting == 'Svenska' ? 'selected' : '' }}>Svenska</option>
                                <option value="Filipino" {{ $blog->language_of_posting == 'Filipino' ? 'selected' : '' }}>Filipino</option>
                                <option value="Türkçe" {{ $blog->language_of_posting == 'Türkçe' ? 'selected' : '' }}>Türkçe</option>
                                <option value="中文" {{ $blog->language_of_posting == '中文' ? 'selected' : '' }}>中文</option>
                                <option value="العربية" {{ $blog->language_of_posting == 'العربية' ? 'selected' : '' }}>العربية</option>
                                <option value="日本語" {{ $blog->language_of_posting == '日本語' ? 'selected' : '' }}>日本語</option>
                                <option value="한국말" {{ $blog->language_of_posting == '한국말' ? 'selected' : '' }}>한국말</option>
                                <option value="Русский" {{ $blog->language_of_posting == 'Русский' ? 'selected' : '' }}>Русский</option>
                                <option value="Tiếng Việt" {{ $blog->language_of_posting == 'Tiếng Việt' ? 'selected' : '' }}>Tiếng Việt</option>
                            </select>
                        </div>
        
                        <div class="col-md-12 mb-4">
                            <label class="labels" for="auto_paint">Paint color</label>
                            <select id="auto_paint" name="vehicle_paint_color" class="form-control">
                                <option value="">Select color</option>
                                <option value="Black" {{ $blog->vehicle_paint_color == 'Black' ? 'selected' : '' }}>Black</option>
                                <option value="Blue" {{ $blog->vehicle_paint_color == 'Blue' ? 'selected' : '' }}>Blue</option>
                                <option value="Brown" {{ $blog->vehicle_paint_color == 'Brown' ? 'selected' : '' }}>Brown</option>
                                <option value="Green" {{ $blog->vehicle_paint_color == 'Green' ? 'selected' : '' }}>Green</option>
                                <option value="Grey" {{ $blog->vehicle_paint_color == 'Grey' ? 'selected' : '' }}>Grey</option>
                                <option value="Orange" {{ $blog->vehicle_paint_color == 'Orange' ? 'selected' : '' }}>Orange</option>
                                <option value="Purple" {{ $blog->vehicle_paint_color == 'Purple' ? 'selected' : '' }}>Purple</option>
                                <option value="Red" {{ $blog->vehicle_paint_color == 'Red' ? 'selected' : '' }}>Red</option>
                                <option value="Silver" {{ $blog->vehicle_paint_color == 'Silver' ? 'selected' : '' }}>Silver</option>
                                <option value="White" {{ $blog->vehicle_paint_color == 'White' ? 'selected' : '' }}>White</option>
                                <option value="Yellow" {{ $blog->vehicle_paint_color == 'Yellow' ? 'selected' : '' }}>Yellow</option>
                                <option value="Custom" {{ $blog->vehicle_paint_color == 'Custom' ? 'selected' : '' }}>Custom</option>
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
                                <option value="Clean" {{ $blog->vehicle_title_status == 'Clean' ? 'selected' : '' }}>Clean</option>
                                <option value="Salvage" {{ $blog->vehicle_title_status == 'Salvage' ? 'selected' : '' }}>Salvage</option>
                                <option value="Rebuilt" {{ $blog->vehicle_title_status == 'Rebuilt' ? 'selected' : '' }}>Rebuilt</option>
                                <option value="Parts" {{ $blog->vehicle_title_status == 'Parts' ? 'selected' : '' }}>Parts Only</option>
                                <option value="Lien" {{ $blog->vehicle_title_status == 'Lien' ? 'selected' : '' }}>Lien</option>
                                <option value="Missing" {{ $blog->vehicle_title_status == 'Missing' ? 'selected' : '' }}>Missing</option>
                            </select>
                        </div>
        
                        <div class="col-md-12 mb-4">
                            <label class="labels" for="auto_transmission">Transmission</label>
                            <select id="auto_transmission" name="vehicle_transmission" class="form-control">
                                <option value="">Select</option>
                                <option value="Manual" {{ $blog->vehicle_transmission == 'Manual' ? 'selected' : '' }}>Manual</option>
                                <option value="Automatic" {{ $blog->vehicle_transmission == 'Automatic' ? 'selected' : '' }}>Automatic</option>
                                <option value="Other" {{ $blog->vehicle_transmission == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
        
                        <div class="col-md-12 mb-4">
                            <label class="labels" for="auto_bodytype">Type</label>
                            <select id="auto_bodytype" name="vehicle_type" class="form-control">
                                <option value="">Select type</option>
                                <option value="Bus" {{ $blog->vehicle_type == 'Bus' ? 'selected' : '' }}>Bus</option>
                                <option value="Convertible" {{ $blog->vehicle_type == 'Convertible' ? 'selected' : '' }}>Convertible</option>
                                <option value="Coupe" {{ $blog->vehicle_type == 'Coupe' ? 'selected' : '' }}>Coupe</option>
                                <option value="Hatchback" {{ $blog->vehicle_type == 'Hatchback' ? 'selected' : '' }}>Hatchback</option>
                                <option value="Minivan" {{ $blog->vehicle_type == 'Minivan' ? 'selected' : '' }}>Minivan</option>
                                <option value="Offroad" {{ $blog->vehicle_type == 'Offroad' ? 'selected' : '' }}>Offroad</option>
                                <option value="Pickup" {{ $blog->vehicle_type == 'Pickup' ? 'selected' : '' }}>Pickup</option>
                                <option value="Sedan" {{ $blog->vehicle_type == 'Sedan' ? 'selected' : '' }}>Sedan</option>
                                <option value="Truck" {{ $blog->vehicle_type == 'Truck' ? 'selected' : '' }}>Truck</option>
                                <option value="SUV" {{ $blog->vehicle_type == 'SUV' ? 'selected' : '' }}>SUV</option>
                                <option value="Wagon" {{ $blog->vehicle_type == 'Wagon' ? 'selected' : '' }}>Wagon</option>
                                <option value="Van" {{ $blog->vehicle_type == 'Van' ? 'selected' : '' }}>Van</option>
                                <option value="Other" {{ $blog->vehicle_type == 'Other' ? 'selected' : '' }}>Other</option>
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
                                    $selected = ($year == $blog->vehicle_model_year) ? 'selected' : '';
                                    echo "<option value=\"$year\" $selected>$year</option>";
                                }
                                ?>
                            </select>
                        </div>
                        
        
                        <div class="col-md-12 mt-4">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="crypto_currency_ok" name="crypto_currency" value="1" {{ $blog->crypto_currency == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="crypto_currency_ok">
                                    <span>Cryptocurrency ok</span>
                                </label>
                            </div>
        
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="delivery_available" name="delivery_available" value="1" {{ $blog->delivery_available == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="delivery_available">
                                    <span>Delivery available</span>
                                </label>
                            </div>
        
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="see_my_other" name="more_links" value="1" {{ $blog->more_links == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="see_my_other">
                                    <span>Include "more ads by this user" link</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
        {{-- @if($currentDateTime > $nextTenDays) 
        <div class="col-md-6 mb-4">
            <label class="labels">Product brand name</label>
            <input type="text" class="form-control" name="brand_name" placeholder="Product Brand Name" value="{{$blog->brand_name}}" readonly data-toggle="tooltip" data-placement="top" title="You can't make edits as you created this post more than 10 days ago.">
        </div>
        @else
        <div class="col-md-6 mb-4">
            <label class="labels">Product brand name</label>
            <input type="text" class="form-control" name="brand_name" placeholder="Product Brand Name" value="{{$blog->brand_name}}">
            @error('brand_name')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        @endif --}}

        <span id="NormalDiv" class="row">

        <div class="col-md-6 mb-4">
            <label class="labels">Product brand name</label>
            <input type="text" class="form-control" name="brand_name" placeholder="Product Brand Name" value="{{$blog->brand_name}}">
            @error('brand_name')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>


            {{-- @if($currentDateTime > $nextTenDays)  
            <div class="col-md-6 mb-4">
                <label class="labels">Size </label>
                <input type="text" value="{{ $blog->product_size }}" class="form-control mb-2" readonly data-toggle="tooltip" data-placement="top" title="You can't make edits as you created this post more than 10 days ago.">
                <input type="hidden" name="product_size" value="{{ $blog->product_size }}">
            </div>
            @else
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
            @endif --}}

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

            {{-- @if($currentDateTime > $nextTenDays)  
            <div class="col-md-6 mb-4">
                <label class="labels">Size </label>
                <input type="text" value="{{ $blog->product_condition }}" class="form-control mb-2" readonly data-toggle="tooltip" data-placement="top" title="You can't make edits as you created this post more than 10 days ago.">
                <input type="hidden" name="product_condition" value="{{ $blog->product_condition }}">
            </div>
            @else
            <div class="col-md-6 mb-4">
                <label for="condition" class="form-label">Condition:</label>
                <select id="condition" name="product_condition" class="form-control">
                    <option {{ $blog->product_condition == 'new' ? 'selected' : '' }} value="new">New</option>
                    <option {{ $blog->product_condition == 'used' ? 'selected' : '' }} value="used">Used</option>
                    <option {{ $blog->product_condition == 'refurbished' ? 'selected' : '' }} value="refurbished">Refurbished</option>
                </select>
                @error('condition')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            @endif --}}


            <div class="col-md-6 mb-4">
                <label for="condition" class="form-label">Condition:</label>
                <select id="condition" name="product_condition" class="form-control">
                    <option {{ $blog->product_condition == '' ? 'selected' : '' }} value="">Select option</option>
                    <option {{ $blog->product_condition == 'new' ? 'selected' : '' }} value="new">New</option>
                    <option {{ $blog->product_condition == 'used' ? 'selected' : '' }} value="used">Used</option>
                    <option {{ $blog->product_condition == 'refurbished' ? 'selected' : '' }} value="refurbished">Refurbished</option>
                </select>
                @error('condition')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>


            {{-- <div class="col-md-6 mb-4">
                <div class="row">
                    <div class="col-md-4 mb-2">
                        <label for="delivery" class="form-label">Delivery Available:</label>
                        <div class="form-check">
                            <input type="checkbox" 
                                   {{ $blog->delivery_option == 'available'? 'checked' : '' }} 
                                   @if($currentDateTime > $nextTenDays) disabled @endif 
                                   id="delivery" name="delivery_option" value="available" class="form-check-input">
                            <label for="delivery" class="form-check-label">Available</label>
                            @if($currentDateTime > $nextTenDays)
                            <input type="hidden" name="pickup" value="{{ $blog->delivery_option }}">
                        @endif
                        </div>
                        @error('delivery')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-2">
                        <label for="pickup" class="form-label">Pickup Options:</label>
                        <div class="form-check">
                            <input type="checkbox" 
                                   {{ $blog->pickup == 'available'? 'checked' : '' }} 
                                   @if($currentDateTime > $nextTenDays) disabled @endif 
                                   id="pickup" name="pickup" value="available" class="form-check-input">
                            <label for="pickup" class="form-check-label">Available</label>
                            @if($currentDateTime > $nextTenDays)
                                <input type="hidden" name="pickup" value="{{ $blog->pickup }}">
                            @endif
                        </div>
                        @error('pickup')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-2">
                        <label for="shipping" class="form-label">Shipping Included:</label>
                        <div class="form-check">
                            <input type="checkbox" 
                                   {{ $blog->shipping == 'included'? 'checked' : '' }} 
                                   @if($currentDateTime > $nextTenDays) disabled @endif 
                                   id="shipping" name="shipping" value="included" class="form-check-input">
                            <label for="shipping" class="form-check-label">Included</label>
                            @if($currentDateTime > $nextTenDays)
                                <input type="hidden" name="shipping" value="{{ $blog->shipping }}">
                            @endif
                        </div>
                        @error('shipping')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div> --}}


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
                <label class="form-label">Sale option:</label>
                <div class="form-check">
                    <input type="radio" id="online" name="saleOption" value="online" class="form-check-input"  {{ $blog->saleOption == 'online'? 'checked' : '' }}>
                    <label for="online" class="form-check-label">Sell online for delivery</label>
                </div>
                {{-- <div class="form-check">
                    <input type="radio" id="pickupOption" name="saleOption" value="pickup" class="form-check-input" required {{ $blog->saleOption == 'pickup'? 'checked' : '' }}>
                    <label for="pickupOption" class="form-check-label">Pickup at Location</label>
                </div>

                <div class="col-md-12 mb-4 address_input d-none">
                    <input type="text" id="pickupOption" name="address" value="{{$blog->address}}" class="form-control " placeholder="Enter your pikup address">
                </div> --}}
                @error('saleOption')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>



            {{-- <div class="col-md-6 mb-4">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label for="bid" class="form-label">Allow Offers/Bids:</label>
                        <div class="form-check">
                            <input type="checkbox" 
                                   {{ $blog->bid == 'allow'? 'checked' : '' }} 
                                   @if($currentDateTime > $nextTenDays) disabled @endif 
                                   id="bid" name="bid" value="allow" class="form-check-input">
                            <label for="bid" class="form-check-label">Allow</label>
                            @if($currentDateTime > $nextTenDays)
                                <input type="hidden" name="bid" value="{{ $blog->bid }}">
                            @endif
                        </div>
                        @error('bid')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-4">
                        <label for="buy" class="form-label">Buy at Face Value:</label>
                        <div class="form-check">
                            <input type="checkbox" 
                                   {{ $blog->buy_at_face_value == 'allow'? 'checked' : '' }} 
                                   @if($currentDateTime > $nextTenDays) disabled @endif 
                                   id="buy" name="buy_at_face_value" value="allow" class="form-check-input">
                            <label for="buy" class="form-check-label">Allow</label>
                            @if($currentDateTime > $nextTenDays)
                                <input type="hidden" name="buy_at_face_value" value="{{ $blog->buy_at_face_value }}">
                            @endif
                        </div>
                        @error('buy_at_face_value')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div> --}}

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

            
        </span>
            <div id="hiddenDiv" class="col-md-12 mb-4 pet_details">
                <!-- <h5 class="labels fw-bold">Find Your Favourite Pet</h5> -->
                <div class="row">
                    @if($currentDateTime > $nextTenDays)  
                    <div class="col-md-6 mb-4">
                        <label class="labels">Type of Animal </label>
                        <input type="text" value="{{ $blog->type_of_animal }}" class="form-control mb-2">
                        <input type="hidden" name="type_of_animal" value="{{ $blog->type_of_animal }}">
                    </div>
                    @else
                    <div class="col-md-6 mb-4">
                        <label class="labels">Type of Animal </label>
                        <select class="form-control" name="type_of_animal">
                            <option value="">Select option</option>
                            <option {{ $blog->type_of_animal == 'cat' ? 'selected' : '' }} value="cat">Cat</option>
                            <option {{ $blog->type_of_animal == 'kitten' ? 'selected' : '' }} value="kitten">Kitten</option>
                            <option {{ $blog->type_of_animal == 'dog' ? 'selected' : '' }} value="dog">Dog</option>
                            <option {{ $blog->type_of_animal == 'puppy' ? 'selected' : '' }} value="puppy">Puppy </option>
                        </select>
                     </div>
                     @endif

                    <div class="col-md-6 mb-4">
                        <label class="labels">Pet name </label>
                        <input type="text" @if($currentDateTime > $nextTenDays) readonly @endif class="form-control" name="pet_name" placeholder="Pet name" value="{{$blog->pet_name}}">
                     </div>
                    <div class="col-md-6 mb-4">
                        <label class="labels">Location </label>
                        <input type="text" @if($currentDateTime > $nextTenDays) readonly @endif class="form-control" name="location" placeholder=" Location" value="{{$blog->location}}">
                     </div>
                    <!-- <div class="col-md-6 mb-4">
                        <label class="labels">Website </label>
                        <input type="text" class="form-control" name="website" placeholder="Website Name" value="{{$blog->location}}">
                     </div> -->
                    <div class="col-md-6 mb-4">
                        <label class="labels">Breed </label>
                        <input type="text" @if($currentDateTime > $nextTenDays) readonly @endif class="form-control" name="breed" placeholder="Breed Name" value="{{$blog->breed}}">
                     </div>
                    <div class="col-md-6 mb-4">
                        <label class="labels">Color </label>
                        <input type="text" @if($currentDateTime > $nextTenDays) readonly @endif class="form-control" name="pet_color" placeholder="Color Name" value="{{$blog->pet_color}}">
                     </div>

         
                    {{-- @if($currentDateTime > $nextTenDays)  
                        <div class="col-md-6 mb-4">
                            <label class="labels">Size </label>
                            <input type="text" value="{{ $blog->pet_age }}" readonly class="form-control mb-2">
                            <input type="hidden" name="pet_age" value="{{ $blog->pet_age }}">
                        </div>
                    @else
                     <div class="col-md-6 mb-4">
                        <label class="labels">Age </label>
                        <select class="form-control" name="pet_age">
                            <option value="">Select option</option>
                            <option {{ $blog->pet_age == 'young' ? 'selected' : '' }} value="young">Young</option>
                            <option {{ $blog->pet_age == 'old' ? 'selected' : '' }} value="old">Old</option>
                        </select>
                     </div>
                     @endif --}}

                     <div class="col-md-6 mb-4">
                        <label class="labels">Age </label>
                        <select class="form-control" name="pet_age">
                            <option value="">Select option</option>
                            <option {{ $blog->pet_age == 'young' ? 'selected' : '' }} value="young">Young</option>
                            <option {{ $blog->pet_age == 'old' ? 'selected' : '' }} value="old">Old</option>
                        </select>
                     </div>


                     {{-- @if($currentDateTime > $nextTenDays)  
                     <div class="col-md-6 mb-4">
                         <label class="labels">Size </label>
                         <input type="text" value="{{ $blog->pet_gender }}" readonly class="form-control mb-2">
                         <input type="hidden" name="pet_gender" value="{{ $blog->pet_gender }}">
                     </div>
                    @else
                     <div class="col-md-6 mb-4">
                        <label class="labels">Gender </label>
                        <select class="form-control" name="pet_gender">
                            <option value="">Select option</option>
                            <option {{ $blog->pet_gender == 'male' ? 'selected' : '' }} value="male">Male</option>
                            <option {{ $blog->pet_gender == 'female' ? 'selected' : '' }} value="female">Female</option>
                        </select>
                     </div>
                     @endif --}}

                     <div class="col-md-6 mb-4">
                        <label class="labels">Gender </label>
                        <select class="form-control" name="pet_gender">
                            <option value="">Select option</option>
                            <option {{ $blog->pet_gender == 'male' ? 'selected' : '' }} value="male">Male</option>
                            <option {{ $blog->pet_gender == 'female' ? 'selected' : '' }} value="female">Female</option>
                        </select>
                     </div>

                     <div class="col-md-6 mb-4">
                        <label class="labels">Size </label>
                        <input type="number" @if($currentDateTime > $nextTenDays) readonly @endif class="form-control" name="pet_size" placeholder="Enter Size" value="{{$blog->pet_size}}">
                     </div>
                     <div class="col-md-6 mb-4">
                        <label class="labels">Coat length </label>
                        <input type="text" @if($currentDateTime > $nextTenDays) readonly @endif class="form-control" name="coat" placeholder="Coat Length" value="{{$blog->coat}}">
                     </div>
                     <div class="col-md-6 mb-4">
                        <label class="labels">Adoption fee </label>
                        <input type="number" @if($currentDateTime > $nextTenDays) readonly @endif class="form-control" name="adoption_fee" placeholder="Fees" value="{{$blog->adoption_fee}}">
                     </div>
                     <div class="col-md-6 mb-4">
                        <label class="labels">Health </label>
                        <input type="text" @if($currentDateTime > $nextTenDays) readonly @endif class="form-control" name="health" placeholder="Health" value="{{$blog->health}}">
                     </div>
                     <div class="col-md-6 mb-4">
                        <label class="labels">House trained </label>
                        <input type="text" @if($currentDateTime > $nextTenDays) readonly @endif class="form-control" name="house_trained" placeholder="House Trained" value="{{$blog->house_trained}}">
                     </div>
                </div>

            </div>

           
            @if($currentDateTime > $nextTenDays) 
                <div class="col-md-12 mb-4">
                    <label class="labels">Product description</label>
                        <textarea class="form-control" name="description" placeholder="Description" readonly="readonly" data-toggle="tooltip" data-placement="top" title="You can't make edits as you created this post more than 10 days ago.">{{strip_tags($blog->description)}}</textarea>
                        {{-- <span data-toggle="tooltip" data-placement="top" title="You can't make edits as you created this post more than 10 days ago."></span> --}}
                </div>
            @else
                <div class="col-md-12 mb-4">
                    <label class="labels">Product description</label>
                    <div id="summernote">
                        <textarea id="editor1" class="form-control" name="description" placeholder="Description">{{strip_tags($blog->description)}}</textarea>
                        @error('description')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            @endif

            {{-- <div class="col-md-12 mb-4">
                <label class="labels">Additional info</label>
                <div id="sub_summernote">
                    <textarea id="sub_editor" class="form-control" name="additional_info" placeholder="Write a text">{{$blog->additional_info}}</textare
                   
                    @error('additional_info')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div> --}}

            {{-- @if($currentDateTime > $nextTenDays) 
            <div class="col-md-6 mb-4">
                <label class="labels">Product URL / Afilate URL</label>
                <input type="link" class="form-control" name="product_url" placeholder="URL" value="{{$blog->product_url}}" readonly data-toggle="tooltip" data-placement="top" title="You can't make edits as you created this post more than 10 days ago.">
                @error('product_price')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            @else
            <div class="col-md-6 mb-4">
                <label class="labels">Product URL / Afilate URL</label>
                <input type="link" class="form-control" name="product_url" placeholder="URL" value="{{$blog->product_url}}">
                @error('product_price')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            @endif --}}

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


            {{-- @if($currentDateTime > $nextTenDays)
            <div class="col-md-6 mb-4">
                <label class="labels">Product price ($)</label>
                <input type="text" class="form-control" name="product_price" placeholder="$" value="{{$blog->product_price}}" readonly data-toggle="tooltip" data-placement="top" title="You can't make edits as you created this post more than 10 days ago.">
                @error('product_price')
                <small class="errortext">{{ $message }}</small>
                @enderror
            </div>
            @else 
            <div class="col-md-6 mb-4">
                <label class="labels">Product price ($)</label>
                <input type="text" class="form-control" name="product_price" placeholder="$" value="{{$blog->product_price}}">
                @error('product_price')
                <small class="errortext">{{ $message }}</small>
                @enderror
            </div>
            @endif --}}

            <div class="col-md-6 mb-4">
                <label class="labels">Product price ($)</label>
                <input type="text" class="form-control" name="product_price" placeholder="$" value="{{$blog->product_price}}">
                @error('product_price')
                <small class="errortext">{{ $message }}</small>
                @enderror
            </div>

            {{-- @if($currentDateTime > $nextTenDays)
            <div class="col-md-6 mb-4">
                <label class="labels">Product sale price ($)</label>
                <input type="text" class="form-control" name="product_sale_price" placeholder="$" value="{{$blog->product_sale_price}}" readonly data-toggle="tooltip" data-placement="top" title="You can't make edits as you created this post more than 10 days ago.">
                <span id="salePriceError" class="text-red"></span>
                @error('product_sale_price')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            @else
            <div class="col-md-6 mb-4">
                <label class="labels">Product sale price ($)</label>
                <input type="text" class="form-control" name="product_sale_price" placeholder="$" value="{{$blog->product_sale_price}}">
                <span id="salePriceError" class="text-red"></span>
                @error('product_sale_price')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            @endif --}}

            <div class="col-md-6 mb-4">
                <label class="labels">Product sale price ($)</label>
                <input type="text" class="form-control" name="product_sale_price" placeholder="$" value="{{$blog->product_sale_price}}">
                <span id="salePriceError" class="text-red"></span>
                @error('product_sale_price')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

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
                        <input data-required="image" type="file" name="image[]" multiple id="image_upload" class="image-input" data-traget-resolution="image_resolution" value="" accept="image/png, image/gif, image/jpeg" onchange="checkImageCount(this, maxImageCount )">
                    </label>

                </div> -->
                {{-- @if($currentDateTime > $nextTenDays) --}}
                <div class="upload-icon"><a class="cam btn btn-warning"  href="javascript:void(0)">
                    <i class="fa fa-upload" aria-hidden="true"></i>
                        Upload image
                    </a> 
                </div>
                {{--  @else --}}
                
                {{-- <div class="upload-icon"><a class="cam btn btn-warning"  href="javascript:void(0)">
                    <i class="fa fa-upload" aria-hidden="true"></i>
                        Upload image
                    </a> 
                </div> --}}
                {{-- @endif --}}
                
               
                <!-- <div class="gallery" id="sortableImgThumbnailPreview"></div> -->
                <?php
                $newImg = trim($blog->image1, '[""]');
                $img = explode('","', $newImg);
                
                if (($key = array_search($blog->featured_image, $img)) !== false) {
                    unset($img[$key]);
                    array_unshift($img, $blog->featured_image);
                }
                ?>
                
                <div class="gallery">
                    @foreach($img as $index => $images)
                    <div class='apnd-img'>
                        <img src="{{ asset('images_blog_img') }}/{{ $images }}" imgType='listing' filename='{{ $images }}' id='img' remove_name="{{ $images }}" dataid="{{$blog->id}}" class='img-responsive'> 
                        @if($currentDateTime < $nextTenDays) 
                            <i class='fa fa-trash delfile'></i>
                            @endif
                        
                    </div>
                    
                    @endforeach
                </div>
                @error('image')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            {{-- <div class="col-md-6 mb-4">
                <label class="labels"> Post video format: .mp4 | max size: 20MB</label>
                <div class="image-upload">
                    <label style="cursor: pointer;" for="video_upload">
                        <img src="" alt="" class="uploaded-image">
                        <div class="h-100">
                            <div class="dplay-tbl">
                                <div class="dplay-tbl-cell">
                                    <i class="far fa-file-video mb-3"></i>
                                    <h6 class="mt-10 mb-70">Upload or drop your video here</h6>
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
            </div> --}}


            <div class="col-md-12 mb-4">

                <div class="col-md-12 mt-4">
                    <label class="custom-toggle">
                        <input type="checkbox" name="personal_detail" value="true" {{ $blog->personal_detail == 'true'? 'checked' : '' }}> &nbsp;&nbsp;<span>Show your contact details. Keep in mind if you want customers to reach you outside of FindersPage you will need to make your contact details visible to the public.</span>
                    </label>
                </div>
                <div class="row">
                    <div class="col-md-6 mt-4 ">
                        <label class="custom-toggle">Email</label>
                        <input type="email" class="form-control" name="email" value="{{$blog->email}}" placeholder="example@example.com">

                    </div>
                    <div class="col-md-6 mt-4">
                        <label class="custom-toggle">Phone number</label>
                        <input type="tel" class="form-control" name="phone" id="phone" value="{{$blog->phone}}" placeholder="+1 1234567890">
                    </div>
                    <div class="col-md-6 mt-4">
                        <label class="custom-toggle">Website link</label>
                        <input type="text" class="form-control" name="website" value="{{$blog->website}}" placeholder="https://test.com">
                    </div>
                    <div class="col-md-6 mt-4">
                        <label class="custom-toggle">Whatsapp</label>
                        <input type="tel" class="form-control" name="whatsapp" id="whatsapp" value="{{$blog->whatsapp}}" placeholder="whatsapp number">
                    </div>
                    <!-- <div class="col-md-2 mt-4">
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
                    </div> -->
                    <input type="hidden" name="post_type" value="Normal Post" >
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
                    $('.paid_label').attr('data-original-title','$3 per paid listing.');

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

        $(document).ready(function() {
            $('.vehicle-details').hide();

            $('#sub_category').change(function() {
                var selectedValue = $(this).val(); 

                if (selectedValue == '1656' && selected === true) {
                    $('.vehicle-details').show();
                    $('#NormalDiv').hide();
                    $('#NormalDiv input[name="brand_name"]').val('').prop('disabled', true);
                } else {
                    $('.vehicle-details').hide();
                    $('#NormalDiv').show();
                    $('#NormalDiv input[name="brand_name"]').prop('disabled', false);
                }
            });

            var selected = true;

            var initialSelectedValue = $('#sub_category').val();
            if (initialSelectedValue == '1656' && selected === true) {
                $('.vehicle-details').show();
                $('#NormalDiv').hide();
            } else {
                $('.vehicle-details').hide();
                $('#NormalDiv').show();
            }
        });



$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip({
        trigger: 'hover focus'
    });
});
</script>
@endsection