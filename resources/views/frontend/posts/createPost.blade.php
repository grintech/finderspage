@extends('layouts.frontlayout')
@section('content')
<?php

$tags = array('amount','sqft','housing type to choose like','apartment','condo','cottage/cabin','duplex','house','loft','townhouse','assisted living','land','laundry','parking to choose garage','street parking','no parking');

?>
    <style>
        .upload-btn-wrapper.dynupload-section {
            width: 100% !important;
            height: auto;
            border: none !important;
            background: inherit !important;
            border-radius: 0 !important;
        }

        .upload-btn-wrapper.dynupload-section .single-image {
            border-radius: 3px;
        }
    </style>
    <!-- Breadcrumb -->
    <div class="breadcrumb-main">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <a href="#">Home</a> / Create Post
                </div>
            </div>
        </div>
    </div>
    <!-- //Breadcrumb -->

    <div class="main_title black_title">
        <h3>Create a Free Post</h3>
        <p>Choose the best category that fits your needs and create a post</p>
    </div>
    <section class="form_section">
        <form method="post" action="<?php echo route('post.create'); ?>" class="form-validation">
            {{ @csrf_field() }}
            <input class="form-check-input" type="hidden" name="location" id="flexRadioDefault1" value="worldwide">
            <div class="card">
                @include('admin.partials.flash_messages')
                <div class="form-group">
                    <label for="exampleInput">Title *</label>
                    <input type="text" class="form-control" id="exampleInputtext" name="title"
                        placeholder="Enter post name" required value="{{ old('title') }}">
                    @error('title')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="exampleInput">Main Category *</label>
                    <div class="categories-items">
                        <?php foreach ($categories as $key => $value) :
                        $active = old('categories') && in_array($value->id, old('categories')) ? true : false;
                    ?>
                        <div class="category-item category-click <?php echo $active ? 'active' : ''; ?>" data-id="<?php echo $value->id; ?>">
                            <?php if ($active) : ?>
                            <input type="hidden" name="categories[]" value="<?php echo $value->id; ?>" />
                            <?php endif; ?>
                            <div class="category-img">
                                <img src="{{ General::renderImage($value->getResizeImagesAttribute(), 'original') }}"
                                    alt="Image" />
                                <i class="fas fa-check"></i>
                            </div>
                            <h6><?php echo $value->title; ?></h6>
                        </div>
                        <?php endforeach; ?>
                        @error('category')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group ">
                    <div class="radio">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="feature" id="flexRadioDefault3"
                                value="feature_post">
                            <label class="form-check-label" for="flexRadioDefault3">
                                Do you want to make this Post Featured ?
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-check-label" for="exampleInput">Sub Categories *</label>
                    <div>
                        <select multiple="multiple" id="myMulti2" name="sub_categories[]" class="form-control"
                            required="required" data-selected="<?php echo old('sub_categories') ? implode(',', old('sub_categories')) : ''; ?>">
                            <option value="">Please select your categories</option>
                        </select>
                    </div>
                    <small id="myMulti2-error" class="text-danger"></small>
                    @error('sub_categories')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="community_cate">
                    <div class="form-group">
                        <label>Event Type</label>
                        <select id="units" name="event_type" class="form-control">
                            <option>Select Event Type</option>
                            <option value="type_1">Type 1</option>
                            <option value="type_2">Type 2</option>
                        </select>
                        @error('event_type')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group">
                                <label>Start Date</label>
                                <input class="form-control" type="date" name="event_start_date" autocomplete="off" placeholder=""
                                    required value="{{ old('event_start_date') }}" />
                                @error('event_start_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group">
                                <label>Start Time</label>
                                <input class="form-control" placeholder="08:00" type="time" name="event_start_time" placeholder=""
                                    required value="{{ old('event_start_time') }}" />
                                @error('event_start_time')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group">
                                <label>End Date</label>
                                <input autocomplete="off" class="form-control" type="date" name="event_end_date" placeholder=""
                                    required value="{{ old('event_end_date') }}" />
                                @error('event_end_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group">
                                <label>End Time</label>
                                <input class="form-control" placeholder="10:00" type="time" name="event_end_time" placeholder=""
                                    required value="{{ old('event_end_time') }}" />
                                @error('event_end_time')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInput">Event Location</label>
                        <input type="text" class="form-control" id="exampleInputtext" name="event_location"
                            placeholder="Event Location" required value="{{ old('event_location') }}">
                        @error('event_location')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group">
                                <select id="country_" name="event_country" class="form-control">
                                    <option>Select Country</option>
                                    <?php
                                if ($countries) : ?>
                                    <?php foreach ($countries as $key => $value) {
                                        echo '<option value="' . $value->id . '">' . $value->short_name . '</option>';
                                    }
                                endif; ?>
                                </select>
                                @error('country')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group">
                                <input type="text" class="form-control" id="exampleInputtext" name="state_name_"
                                    placeholder="Enter State" required value="{{ old('state_name_') }}">
                                @error('state_name_')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group">
                                <input type="text" class="form-control" id="exampleInputtext" name="city_name_"
                                    placeholder="Enter City" required value="{{ old('city_name_') }}">
                                @error('city_name_')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group">
                                <input class="form-control" type="text" name="event_zipcode" placeholder="Zipcode"
                                    required value="{{ old('event_zipcode') }}" />
                                @error('event_zipcode')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>


                <div class="form-group realstate_cate">
                    <label for="exampleInput">Property Address *</label>
                    <input type="text" class="form-control" id="exampleInputtext" name="property_address"
                        placeholder="Enter Property Address" required value="{{ old('property_address') }}">
                    @error('property_address')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="row realstate_cate">
                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label>Country</label>
                            <select id="country" name="country" class="form-control">
                                <option>Select Country</option>
                                <?php

                            if ($countries) : ?>
                                <?php foreach ($countries as $key => $value) {
                                    echo '<option value="' . $value->id . '">' . $value->short_name . '</option>';
                                }
                            endif; ?>
                            </select>
                            @error('country')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label>State</label>
                            <input type="text" class="form-control" id="exampleInputtext" name="state_name"
                                placeholder="Enter State" required value="{{ old('state_name') }}">
                            @error('state_name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row realstate_cate">
                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label>City</label>
                            <input type="text" class="form-control" id="exampleInputtext" name="city_name"
                                placeholder="Enter City" required value="{{ old('city_name') }}">
                            @error('city_name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label>Zipcode</label>
                            <input class="form-control" type="text" name="zipcode" placeholder="" required
                                value="{{ old('zipcode') }}" />
                            @error('zipcode')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>


                <div class="row realstate_cate">
                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label>Units</label>
                            <select id="units" name="units" class="form-control">
                                <option>Select Unit</option>
                                @for ($i = 01; $i <= 10; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            @error('units')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label>Bathroom</label>
                            <select id="bathroom" name="bathroom" class="form-control">
                                <option>Select Bathroom</option>
                                @for ($i = 01; $i <= 10; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            @error('bathroom')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row realstate_cate">
                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label>Garage</label>
                            <select id="grage" name="grage" class="form-control">
                                <option>Select Garage</option>
                                @for ($i = 01; $i <= 10; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            @error('grage')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label>Area in Sq Ft.</label>
                            <input class="form-control" type="text" name="area_sq_ft" placeholder="EX:1000" required
                                value="{{ old('area_sq_ft') }}" />
                            @error('area_sq_ft')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row realstate_cate">
                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label>Year Built</label>
                            <input class="form-control" type="text" name="year_built" placeholder="2022" required
                                value="{{ old('year_built') }}" />
                            @error('year_built')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row realstate_cate">
                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label>Price/Rent</label>
                            <input class="form-control" type="text" name="price" placeholder="3000" required
                                value="{{ old('price') }}" />
                            @error('price')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label>Sale Price</label>
                            <input class="form-control" type="text" name="sale_price" placeholder="4000" required
                                value="{{ old('sale_price') }}" />
                            @error('sale_price')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>


                <div class="online_shop_cate">
                    <div class="form-group">
                        <label for="exampleInput">Country of Origin</label>
                        <input type="text" class="form-control" id="exampleInputtext" name="country_origin"
                            placeholder="Country of Origin" required value="{{ old('country_origin') }}">
                        @error('country_origin')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="exampleInput">Product Brand Name</label>
                        <input type="text" class="form-control" id="exampleInputtext" name="brand_name"
                            placeholder="Product Brand Name" required value="{{ old('brand_name') }}">
                        @error('brand_name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group">
                                <label>Product Dimensions</label>
                                <input class="form-control" type="text" name="product_length" placeholder="Length"
                                    required value="{{ old('product_length') }}" />
                                @error('product_length')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <select id="bathroom" name="length_type" class="form-control">
                                    <!-- <option>Select Type</option> -->
                                    <option value="inch">Inch</option>
                                </select>
                                @error('length_type')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group">
                                <input class="form-control" type="text" name="product_width" placeholder="Width"
                                    required value="{{ old('product_width') }}" />
                                @error('product_width')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group">
                                <select id="bathroom" name="width_type" class="form-control">
                                    <!-- <option>Select Type</option> -->
                                    <option value="inch">Inch</option>
                                </select>
                                @error('length_type')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group">
                                <input class="form-control" type="text" name="product_height" placeholder="Height"
                                    required value="{{ old('product_height') }}" />
                                @error('product_height')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group">
                                <select id="bathroom" name="width_type" class="form-control">
                                    <!-- <option>Select Type</option> -->
                                    <option value="inch">Inch</option>
                                </select>
                                @error('length_type')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group">
                                <label>Product Price</label>
                                <input class="form-control" type="text" name="product_price" placeholder="3000"
                                    required value="{{ old('product_price') }}" />
                                @error('product_price')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group">
                                <label>Product Sale Price</label>
                                <input class="form-control" type="text" name="product_sale_price" placeholder="4000"
                                    required value="{{ old('product_sale_price') }}" />
                                @error('product_sale_price')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-check-label" for="exampleInput">Color</label>
                        <select multiple="multiple" id="myMulti13" name="product_color[]" class="form-control">
                            <?php if (old('product_color')) : ?>
                            <?php foreach (old('product_color') as $key => $value) {
                                echo '<option selected>' . $value . '</option>';
                            }
                        endif; ?>
                        </select>
                        @error('product_color')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group realstate_cate">
                    <label class="form-check-label" for="exampleInput">Features ex: 2 Stories,Wood Floors,
                        fireplace</label>
                    <select multiple="multiple" id="myMulti11" name="choices[]" class="form-control">
                        <?php if ($tags) : ?>
                        <?php foreach ($tags as $key => $value) {
                            echo '<option>' . $value . '</option>';
                        }
                    endif; ?>
                    </select>
                    @error('choices')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

<!-- 
                <div class="form-group">
                    <label class="form-check-label" for="exampleInput">Location<span style="font-weight: 400;"> (Choose
                            specific location for feature posts)</span></label>
                    <div class="radio">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="location" id="flexRadioDefault1"
                                value="worldwide" <?php echo !old('location') || old('location') == 'worldwide' ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="flexRadioDefault1">
                                Worldwide
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="location" id="flexRadioDefault2"
                                value="multiple" <?php echo old('location') && old('location') == 'multiple' ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="flexRadioDefault2">
                                Multiple Location
                            </label>
                        </div>
                    </div>
                    @error('location')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div> -->

                <div class="form-group business_cate">
                    <label class="form-check-label" for="exampleInput">Choose your Choice</label>
                    <select multiple="multiple" id="myMulti12" name="choices[]" class="form-control">
                        <?php if (old('choices')) : ?>
                        <?php foreach (old('choices') as $key => $value) {
                            echo '<option selected>' . $value . '</option>';
                        }
                    endif; ?>
                    </select>
                    @error('choices')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="job_benifits">
                    <div class="form-group">
                        <label class="form-check-label" for="exampleInput">Are any of the following offered ?</label>
                        <select multiple="multiple" id="benifits" name="benifits[]" class="form-control">
                            <option value="Health Insurance">Health Insurance</option>
                            <option value="Paid time off">Paid time off</option>
                            <option value="Dental insurance">Dental insurance</option>
                            <option value="401(k)">401(k)</option>
                            <option value="Vision insurance">Vision insurance</option>
                            <option value="Flexible schedule">Flexible schedule</option>
                            <option value="Tuition reimbarsement">Tuition reimbarsement</option>
                            <option value="Referral program">Referral program</option>
                            <option value="Employee discount">Employee discount</option>
                            <option value="Flexible spending account">Flexible spending account</option>
                            <option value="Health saving account">Health saving account</option>
                            <option value="Relocation assistance">Relocation assistance</option>
                            <option value="Parental leave">Parental leave</option>
                            <option value="Professional development assistance">Professional development assistance
                            </option>
                            <option value="Employee assistance program">Employee assistance program</option>
                            <option value="Life insurance">Life insurance</option>
                            <option value="401(k) matching">401(k) matching</option>
                            <option value="Retirement Plan">Retirement Plan</option>
                            <option value="other">Other</option>
                        </select>
                        @error('benifits')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-check-label" for="exampleInput">Do you offered any of the following
                            supplemental pay ?</label>
                        <select multiple="multiple" id="supplement" name="supplement[]" class="form-control">
                            <option>Select Options</option>
                            <option value="Singing bonus">Singing bonus</option>
                            <option value="Comission pay">Comission pay</option>
                            <option value="Bonus pay">Bonus pay</option>
                            <option value="Tips">Tips</option>
                            <option value="other">Other</option>
                        </select>
                        @error('supplement')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-check-label" for="exampleInput">What is the pay ?</label>
                        <div class="form-group">
                            <label class="form-check-label" for="exampleInput">show pay by</label>
                            <select name="pay_by" id="select_pay">
                                <option>Select Options</option>
                                <option value="Range">Range</option>
                                <option value="Fixed">Fixed</option>
                            </select>
                        </div>
                        <div class="form-group" id="range">
                            <label class="form-check-label" for="exampleInput">Minimum</label>
                            <input type="text" name="min_pay">
                            <b>To</b>
                            <label class="form-check-label" for="exampleInput">Maximum</label>
                            <input type="text" name="max_pay">

                        </div>
                        <div class="form-group" id="fixed">
                            <label class="form-check-label" for="exampleInput">Fixed Pay</label>
                            <input type="text" name="fixed_pay" class="form-control" placeholder="Enter amount">
                        </div>
                        <div class="form-group">
                            <label class="form-check-label" for="exampleInput">Rate</label>
                            <select name="rate">
                                <option>Select Options</option>
                                <option value="per hour">per hour</option>
                                <option value="per day">per day</option>
                                <option value="per week">per week</option>
                                <option value="per month">per month</option>
                                <option value="per year">per year</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group ">
                    <label class="form-check-label" for="exampleInput">Post Featured Image *</label><br>
                    <div class="upload-btn-wrapper dynupload-section multiple-blocks" style="overflow: unset !important;">
                        <div class="upload-image-section" data-type="image" data-multiple="true">
                            <div class="show-section dynupload-section <?php echo !old('image') ? 'd-none' : ''; ?>">
                                @include('admin.partials.previewFileRender', ['file' => old('image')])
                            </div>
                            <div class="upload-section <?php echo old('image') ? 'd-none' : ''; ?>">
                                <div class="button-ref mb-3">
                                    <button class="btn btn-icon btn-primary btn-lg" type="button"
                                        style="width: 100%;height: 150px;opacity: 0;">
                                        <span class="btn-inner--icon"><i class="fas fa-upload"></i></span>
                                        <span class="btn-inner--text">Upload Image</span>
                                    </button>
                                </div>
                                <!-- PROGRESS BAR -->
                                <div class="progress d-none">
                                    <div class="progress-bar bg-default" role="progressbar" aria-valuenow="0"
                                        aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                                </div>
                            </div>



                            <!-- INPUT WITH FILE URL -->
                            <textarea name="image" style="position: absolute;top: -4000px;" required><?php echo old('image'); ?></textarea>

                        </div>
                    </div><br>
                    @error('image')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-check-label" for="exampleInput">Post Video</label><br>
                    <div class="upload-btn-wrapper">
                        <div class="upload-image-section" data-type="video" data-multiple="false">

                            <div
                                class="upload-section {{ isset($user->business_video) && $user->business_video != '' ? 'd-none' : '' }}">
                                <div class="button-ref mb-3">
                                    <button class="btn btn-icon btn-primary btn-lg" type="button"
                                        style="width: 100%;height: 150px;opacity: 0;">
                                        <span class="btn-inner--icon"><i class="fas fa-upload"></i></span>
                                        <span class="btn-inner--text">Upload Video</span>
                                    </button>
                                </div>
                                <!-- PROGRESS BAR -->
                                <div class="progress d-none">
                                    <div class="progress-bar bg-default" role="progressbar" aria-valuenow="0"
                                        aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                                </div>
                            </div>

                            <!-- INPUT WITH FILE URL -->
                            <textarea name="post_video" style="position: absolute;top: -4000px;"><?php echo old('post_video'); ?></textarea>



                            <div class="show-section"></div>

                        </div>
                    </div><br>
                    <p><small class="text-muted">Format: .mp4 | Max Size: 20MB</small></p>
                    @error('image')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group ">
                    <label class="form-check-label" for="exampleInput">Start writing your post here. Add Images, Videos,
                        #hashtags and more</label>
                    <textarea id="editor1" name="description" placeholder="Write a text"><?php echo old('description'); ?></textarea>
                    @error('description')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>



                  <div class="poll_div community_cate">
                    <div class="row">
    <h3>Add Poll</h3>
                        <div class="col-xs-12 col-sm-12">
                            <div class="form-group">
                                 <label class="form-check-label" for="exampleInput">Add Question here</label>
                                <input type="text" class="form-control" id="exampleInputtext" name="poll_question"
                                    placeholder="Enter question" required value="Do you want attend this event?">
                                @error('poll_question')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                   <!--    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group" id="TextBoxContainer">
                                 <label class="form-check-label" for="exampleInput">Option</label>
                                <input type="text" class="form-control" id="exampleInputtext" name="poll_option[]"
                                    placeholder="Enter Option" required value="">
                            </div>
                            <input id="btnAdd" type="button" value="Add More Option" />
                        </div>
                    </div> -->
                    </div>

            </div>


            <div class="card">


                <div class="row">
                    <div class="form_title black_title">
                        <h3>Contact Detail</h3>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input class="form-control" type="text" name="phone" id="phone" 
                                placeholder="Enter your phone number" required value="{{ old('phone') }}" />
                            @error('phone')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label>Email</label>
                            <input class="form-control" type="email" name="email" placeholder="Enter your email"
                                required value="{{ old('email') }}" />
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group ">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <label class="col-xs-12">Website URL</label>
                            <input class="form-control" type="text" name="website"
                                placeholder="Enter your website url" value="{{ old('website') }}" />
                            @error('website')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <label class="col-xs-12">Address</label>
                            <input class="form-control" type="text" name="address" placeholder="Enter your address"
                                value="{{ old('address') }}" />
                            @error('address')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <hr>

                <div class="form-group ">
                    <div class="row">
                        <label class="col-xs-12" style="margin-top: 20px;">Social Media Links</label>
                        <div class="col-xs-12 col-sm-6">
                            <input class="form-control form-control_twitter" type="text"
                                style="font-family:Arial, FontAwesome" placeholder="https://twitter.com/" name="twitter"
                                value="{{ old('twitter') }}" />
                            @error('twitter')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <input class="form-control form-control_facebook" type="text"
                                style="font-family:Arial, FontAwesome" placeholder="https://www.facebook.com/"
                                name="facebook" value="{{ old('facebook') }}" />
                            @error('facebook')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <input class="form-control form-control_instagram" type="text"
                                style="font-family:Arial, FontAwesome" placeholder="https://instagram.com/"
                                name="instagram" value="{{ old('instagram') }}" />
                            @error('instagram')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <input class="form-control form-control_linkedin" type="text"
                                style="font-family:Arial, FontAwesome" placeholder="https://linkedin.com/"
                                name="linkedin" value="{{ old('linkedin') }}" />
                            @error('linkedin')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <input class="form-control form-control_youtube" type="text"
                                style="font-family:Arial, FontAwesome" placeholder="https://youtube.com/" name="youtube"
                                value="{{ old('youtube') }}" />
                            @error('youtube')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <input class="form-control form-control_whatsapp" type="text"
                                style="font-family:Arial, FontAwesome" placeholder="Enter you whatsApp number"
                                name="whatsapp" value="{{ old('whatsapp') }}" />
                            @error('whatsapp')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

            </div>

            <div class="btn_section">
                <button type="submit" class="btn btn-primary">Publish</button>
                <!-- <span class="hrrr"><span>OR</span></span> -->
                <!-- <button type="button" class="btn btn-primary2">Feature Post on the Homepage</button> -->
                <!-- <p style="text-align: center;margin-top: 20px">Choose the best category that fits your needs and create a
                    post</p> -->
            </div>

        </form>
    </section>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#range').hide();
            $('#fixed').hide();
            $('#select_pay').on('change', function() {
                var opt = $(this).val();
                console.log(opt);
                if (opt == 'Range') {
                    $('#range').show();
                    $('#fixed').hide();
                }
                if (opt == 'Fixed') {
                    $('#fixed').show();
                    $('#range').hide();
                }
            })
       
    $("#btnAdd").bind("click", function () {
        var div = $("<div />");
        div.html(GetDynamicTextBox(""));
        $("#TextBoxContainer").append(div);
    });

    $("body").on("click", ".remove", function () {
        $(this).closest("div").remove();
    });
});
function GetDynamicTextBox(value) {
    return '<input type="text" style="margin-top:5px" placeholder="Enter Option" class="form-control" name="poll_option[]" value = "' + value + '" />&nbsp;'
        +'<input type="button" value="Remove" class="remove" />'
}

    </script>

    <!-- ==== Section End ==== -->
@endsection
