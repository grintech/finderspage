@extends('layouts.user_dashboard.userdashboardlayout')
@section('content')
<?php  use Carbon\Carbon;?>
<style>
    .select2-container {
        box-sizing: border-box;
        display: inline-block;
        margin: 0;
        position: relative;
        vertical-align: middle;
/*        width: 100% !important;*/
    }
    .error-message {
        color: #e74a3b;
    }
    @media only screen and (max-width:767px){
        .container-fluid {padding-bottom: 50px !important;}
    }
</style>
<div class="container px-sm-5 px-4 pb-4">
    <form method="post" action="<?php echo route('realestate_edit', $blog->slug); ?>"  enctype="multipart/form-data" id="realState_form_new">
        {{ @csrf_field() }}
        <!-- Page Heading -->
        <div class="d-sm-flex flex-column  mb-3">
            <h1 class="h3 mb-0 text-gray-800 fw-bold">Edit Real Estate Listing</h1>
            <!-- <p>Choose the best category that fits your needs and create a free post</p> -->
        </div>
        <span>
            @include('admin.partials.flash_messages')
        </span>
        <input type="hidden" name="categories" value="4">
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
                <input type="text" id="title-input" class="form-control" name="title" placeholder="Title" value="{{$blog->title}}"  readonly class="form-control mb-2" data-toggle="tooltip" data-placement="top" title="You can't make edits as you created this post more than 10 days ago.">
            </div>
            @else 
            <div class="col-md-6 mb-4">
                <label class="labels">Title <sup>*</sup></label>
                <input type="text" id="title-input" class="form-control" name="title" placeholder="Title" value="{{$blog->title}}">
                <span class="error-message" id="title-error"></span>
                @error('title')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            @endif


            <!-- <div class="col-md-6 mb-4 form-check check-frame">
                            <input class="form-check-input" id="inputRememberPassword" type="checkbox" value="" />
                            <label class="form-check-label" for="inputRememberPassword">Do you want to make this Post Featured?</label>
                        </div> -->
           
            {{-- @if($currentDateTime > $nextTenDays)  
                <div class="col-md-6 mb-4">
                    <label class="labels">Sub categories <sup>*</sup></label>
                    @foreach($categories as $cate)
                        @if($blog->sub_category == $cate->id)
                            <input type="text" value="{{ $cate->title }}" readonly class="form-control mb-2" data-toggle="tooltip" data-placement="top" title="You can't make edits as you created this post more than 10 days ago.">
                            <input type="hidden" name="sub_category" value="{{ $cate->id }}">
                            <input type="hidden" id="Other-cate-input" value="">
                        @endif
                    @endforeach
                </div>
            @else
                <div class="col-md-6 mb-4">
                    <label class="labels">Sub categories <sup>*</sup></label>
                    <select name="sub_category" id="sub_category" class="form-control form-control-xs selectpicker" data-size="7" data-live-search="true" data-title="Sub category" data-width="100%">
                        @foreach($categories as $cate)
                            <option value="{{ $cate->id }}" {{ $blog->sub_category == $cate->id ? 'selected' : '' }}>{{ $cate->title }}</option>
                        @endforeach
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
                <select name="sub_category" id="sub_category" class="form-control form-control-xs selectpicker" data-size="7" data-live-search="true" data-title="Sub categories" data-width="100%">
                    @foreach($categories as $cate)
                        <option value="{{ $cate->id }}" {{ $blog->sub_category == $cate->id ? 'selected' : '' }}>{{ $cate->title }}</option>
                    @endforeach
                    <option class="Other-cate" value="Other">Other</option>
                </select>
                <input type="text" class="form-control d-none mt-2" id="Other-cate-input" name="sub_category_oth" placeholder="sub_category name" value="">
                @error('sub_category')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
                        

            <?php
            $choices = explode(",", $blog->post_choices);
            $choices = array_map(function ($element) {
                return str_replace(array('[', ']', '"'), '', $element);
            }, $choices);
            // echo "<pre>";print_r($blog->choice);die();
            ?>


            {{-- @if($currentDateTime > $nextTenDays)  
            <div class="col-md-6 mb-4">
                <label class="labels">Choose your choice<sup>*</sup></label>
                <input type="text" value="{{ implode(', ', $choices) }}" readonly class="form-control mb-2" data-toggle="tooltip" data-placement="top" title="You can't make edits as you created this post more than 10 days ago.">
                @foreach($choices as $choice)
                    <input type="hidden" name="post_choices" value="{{ $choice }}">
                @endforeach
            </div>
            @else
            <div class="col-md-6 mb-4 " id="property-choices">
                <label class="labels">Choose your choice<sup>*</sup></label>
                    <div class="select-wrapper">
                        <select class="form-control" name="post_choices[]" id="post-choices" multiple="multiple">
                            <option value="">Select option</option>
                            <option value="apartment" {{ in_array('apartment', $choices) ? 'selected' : '' }}>Apartment</option>
                            <option value="condo" {{ in_array('condo', $choices) ? 'selected' : '' }}>Condo</option>
                            <option value="cottage" {{ in_array('cottage', $choices) ? 'selected' : '' }}>Cottage/Cabin</option>
                            <option value="duplex" {{ in_array('duplex', $choices) ? 'selected' : '' }}>Duplex</option>
                            <option value="house" {{ in_array('house', $choices) ? 'selected' : '' }}>House</option>
                            <option value="loft" {{ in_array('loft', $choices) ? 'selected' : '' }}>Loft</option>
                            <option value="townhouse" {{ in_array('townhouse', $choices) ? 'selected' : '' }}>Townhouse</option>
                            <option value="assisted-living" {{ in_array('assisted-living', $choices) ? 'selected' : '' }}>Assisted Living</option>
                            <option value="land" {{ in_array('land', $choices) ? 'selected' : '' }}>Land</option>
                            <option value="laundry" {{ in_array('laundry', $choices) ? 'selected' : '' }}>Laundry</option>
                            <option value="pets" {{ in_array('pets', $choices) ? 'selected' : '' }}>Pets Allowed</option>
                            <option value="furnished" {{ in_array('furnished', $choices) ? 'selected' : '' }}>Furnished</option>
                            <option value="no-smoking" {{ in_array('no-smoking', $choices) ? 'selected' : '' }}>No Smoking</option>
                            <option value="wheelchair-accessible" {{ in_array('wheelchair-accessible', $choices) ? 'selected' : '' }}>Wheelchair Accessible</option>
                            <option value="air-conditioning" {{ in_array('air-conditioning', $choices) ? 'selected' : '' }}>Air Conditioning</option>
                            <option value="heater-unit" {{ in_array('heater-unit', $choices) ? 'selected' : '' }}>Heater Unit</option>
                        </select>
                        <i class="fas fa-angle-down select-down"></i>
                </div>
            </div>
            @endif --}}

            <div class="col-md-6 mb-4 " id="property-choices">
                <label class="labels">Choose your choice<sup>*</sup></label>
                    <div class="select-wrapper">
                        <select class="form-control" name="post_choices[]" id="post-choices" multiple="multiple">
                            <option value="">Select option</option>
                            <option value="apartment" {{ in_array('apartment', $choices) ? 'selected' : '' }}>Apartment</option>
                            <option value="condo" {{ in_array('condo', $choices) ? 'selected' : '' }}>Condo</option>
                            <option value="cottage" {{ in_array('cottage', $choices) ? 'selected' : '' }}>Cottage/Cabin</option>
                            <option value="duplex" {{ in_array('duplex', $choices) ? 'selected' : '' }}>Duplex</option>
                            <option value="house" {{ in_array('house', $choices) ? 'selected' : '' }}>House</option>
                            <option value="loft" {{ in_array('loft', $choices) ? 'selected' : '' }}>Loft</option>
                            <option value="townhouse" {{ in_array('townhouse', $choices) ? 'selected' : '' }}>Townhouse</option>
                            <option value="assisted-living" {{ in_array('assisted-living', $choices) ? 'selected' : '' }}>Assisted Living</option>
                            <option value="land" {{ in_array('land', $choices) ? 'selected' : '' }}>Land</option>
                            <option value="laundry" {{ in_array('laundry', $choices) ? 'selected' : '' }}>Laundry</option>
                            <option value="pets" {{ in_array('pets', $choices) ? 'selected' : '' }}>Pets Allowed</option>
                            <option value="furnished" {{ in_array('furnished', $choices) ? 'selected' : '' }}>Furnished</option>
                            <option value="no-smoking" {{ in_array('no-smoking', $choices) ? 'selected' : '' }}>No Smoking</option>
                            <option value="wheelchair-accessible" {{ in_array('wheelchair-accessible', $choices) ? 'selected' : '' }}>Wheelchair Accessible</option>
                            <option value="air-conditioning" {{ in_array('air-conditioning', $choices) ? 'selected' : '' }}>Air Conditioning</option>
                            <option value="heater-unit" {{ in_array('heater-unit', $choices) ? 'selected' : '' }}>Heater Unit</option>
                        </select>
                        <i class="fas fa-angle-down select-down"></i>
                </div>
            </div>

            
            {{-- @if($currentDateTime > $nextTenDays)
            <div class="col-md-6 mb-4 property-land-area" id="landInput" style="display:none">
                <label class="labels">Land acres</label>
                <input type="number" class="form-control" name="landSize" id="landSize" placeholder="ex:1000" value="{{$blog->landSize}}" readonly data-toggle="tooltip" data-placement="top" title="You can't make edits as you created this post more than 10 days ago.">
            </div>
            @else
            <div class="col-md-6 mb-4 property-land-area" id="landInput" style="display:none">
                <label class="labels">Land acres</label>
                <input type="number" class="form-control" name="landSize" id="landSize" placeholder="ex:1000" value="{{$blog->landSize}}">
                @error('landSize')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            @endif --}}

            <div class="col-md-6 mb-4 property-land-area" id="landInput" style="display:none">
                <label class="labels">Land acres</label>
                <input type="number" class="form-control" name="landSize" id="landSize" placeholder="ex:1000" value="{{$blog->landSize}}">
                @error('landSize')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- @if($currentDateTime > $nextTenDays)
            <div class="col-md-6 mb-4">
                <label class="labels">Property address <sup>*</sup></label>
                <input type="text" class="form-control" name="property_address" id="property_address" placeholder="Type address" value="{{$blog->property_address}}" readonly data-toggle="tooltip" data-placement="top" title="You can't make edits as you created this post more than 10 days ago.">
            </div>
            @else
            <div class="col-md-6 mb-4">
                <label class="labels">Property address <sup>*</sup></label>
                <input type="text"  class="form-control" name="property_address" id="property_address" placeholder="Type address" value="{{$blog->property_address}}">
                @error('property_address')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            @endif --}}
            
            <div class="col-md-6 mb-4">
                <label class="labels">Property address <sup>*</sup></label>
                <input type="text"  class="form-control" name="property_address" id="property_address" placeholder="Type address" value="{{$blog->property_address}}">
                @error('property_address')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="col-md-6 mb-4">
                <label class="labels">Want to reach a larger audience? Add location</label>
                <input name="location" type="text" class="form-control get_loc" id="location" value="{{ $blog->location }}" placeholder="Enter location">
                <div class="searcRes" id="autocomplete-results">
                </div>
            </div>
            <!-- <div class="col-md-6 mb-4">
                <label class="labels">Country </label>
                <select title="Select Country" name="country" class="form-control" id="country_name" post-id="{{$blog->id}}">
                    <option value="">Select Country</option>
                    <?php
                    foreach ($countries as $key => $element) { ?>
                        <option value="<?php echo $element['id']; ?>" {{ $blog->country == $element['id'] ? 'selected' : '' }}> <?php echo $element['name']; ?></option>
                    <?php
                    }
                    ?>
                </select>
                @error('country')
                <span class="error">{{ $message }}</span>
                @enderror
            </div> -->
            <!-- <div class="col-md-6 mb-4">
                <label class="labels">State </label>
                <select title="Select Country" name="state" class="form-control state1" id="state_name">
                    <option value="">Select state</option>

                </select>
                @error('state')
                <span class="error">{{ $message }}</span>
                @enderror
            </div> -->

            <!-- <div class="col-md-6 mb-4">
                <label class="labels">City </label>
                <select title="Select Country" name="city" class="form-control" id="city_name">
                    <option value="">Select city</option>
                </select>
                @error('city')
                <span class="error">{{ $message }}</span>
                @enderror
            </div> -->
            <!-- <div class="col-md-6 mb-4">
                <label class="labels">Zip code</label>
                <input type="text" class="form-control" name="zipcode" id="zipcode" placeholder="Enter zipcode" maxlength="8" value="{{ $blog->zipcode}}">
                @error('zipcode')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div> -->

            {{-- @if($currentDateTime > $nextTenDays)  
            <div class="col-md-6 mb-4">
                <label class="labels">Units</label>
                <input type="text" value="{{ $blog->units }}" class="form-control mb-2" readonly data-toggle="tooltip" data-placement="top" title="You can't make edits as you created this post more than 10 days ago.">
                <input type="hidden" name="units" value="{{ $blog->units }}">
            </div>
            @else
            <div class="col-md-6 mb-4" id="property-units">
                <label class="labels">Units</label>
                <select class="form-control" name="units" id="units">
                    <option value="">Select unit</option>
                    @for ($i = 1; $i <= 10; $i++)
                        <option value="{{ $i }}" {{ $blog->units == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
                @error('units')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            @endif --}}
            
            <div class="col-md-6 mb-4" id="property-units">
                <label class="labels">Units</label>
                <select class="form-control" name="units" id="units">
                    <option value="">Select unit</option>
                    @for ($i = 1; $i <= 10; $i++)
                        <option value="{{ $i }}" {{ $blog->units == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
                @error('units')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>


            {{-- @if($currentDateTime > $nextTenDays)  
            <div class="col-md-6 mb-4">
                <label class="labels">Bathroom</label>
                <input type="text" value="{{ $blog->bathroom }}" class="form-control mb-2" readonly data-toggle="tooltip" data-placement="top" title="You can't make edits as you created this post more than 10 days ago.">
                <input type="hidden" name="bathroom" value="{{ $blog->bathroom }}">
            </div>
            @else
            <div class="col-md-6 mb-4 " id="property-bathroom">
                <label class="labels">Bathroom</label>
                <select class="form-control" name="bathroom" id="bathroom">
                    <option value="">Select bathroom</option>
                    <option>1</option>
                    @for ($i = 01; $i <= 10; $i++) <option value="{{ $i }}" {{ $blog->bathroom == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                </select>
                @error('bathroom')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            @endif --}}
            <div class="col-md-6 mb-4 " id="property-bedroom">
                <label class="labels">Bedroom</label>
                <select class="form-control" name="bedroom" id="bedroom">
                    <option value="">Select bedroom</option>
                    
                    @for ($i = 01; $i <= 10; $i++)
                        <option value="{{ $i }}" {{ $blog->bedroom == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
                    @error('bedroom')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="col-md-6 mb-4 " id="property-bathroom">
                <label class="labels">Bathroom</label>
                <select class="form-control" name="bathroom" id="bathroom">
                    <option value="">Select bathroom</option>
                    <option>1</option>
                    @for ($i = 01; $i <= 10; $i++) <option value="{{ $i }}" {{ $blog->bathroom == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                </select>
                @error('bathroom')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- @if($currentDateTime > $nextTenDays)  
            <div class="col-md-6 mb-4">
                <label class="labels">Garage</label>
                <input type="text" value="{{ $blog->grage }}" class="form-control mb-2" readonly data-toggle="tooltip" data-placement="top" title="You can't make edits as you created this post more than 10 days ago.">
                <input type="hidden" name="grage" value="{{ $blog->grage }}">
            </div>
            @else
            <div class="col-md-6 mb-4" id="property-garage">
                <label class="labels">Garage</label>
                <select class="form-control" name="grage" id="grage">
                    <option value="">Select garage</option>
                    @for ($i = 01; $i <= 10; $i++) <option value="{{ $i }}" {{ $blog->grage == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                </select>
                @error('grage')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            @endif --}}

            <div class="col-md-6 mb-4" id="property-garage">
                <label class="labels">Garage</label>
                <select class="form-control" name="grage" id="grage">
                    <option value="">Select garage</option>
                    @for ($i = 01; $i <= 10; $i++) <option value="{{ $i }}" {{ $blog->grage == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                </select>
                @error('grage')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

        {{-- @if($currentDateTime > $nextTenDays) 
            <div class="col-md-6 mb-4" id="property-area">
                <label class="labels">Area in sq ft.</label>
                <input type="number" class="form-control" name="area_sq_ft" id="area_sq_ft" placeholder="Ex:1000" value="{{$blog->grage}}" readonly data-toggle="tooltip" data-placement="top" title="You can't make edits as you created this post more than 10 days ago.">
            </div>
            @else
            <div class="col-md-6 mb-4" id="property-area">
                <label class="labels">Area in sq ft.</label>
                <input type="number" class="form-control" name="area_sq_ft" id="area_sq_ft" placeholder="Ex:1000" value="{{$blog->grage}}" oninput="formatNumber(this)">
                @error('area_sq_ft')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            @endif --}}

            <div class="col-md-6 mb-4" id="property-area">
                <label class="labels">Area in sq ft.</label>
                <input type="text" class="form-control" name="area_sq_ft" id="area_sq_ft" placeholder="Ex:1000" value="{{$blog->area_sq_ft}}" oninput="formatNumber(this)">
                @error('area_sq_ft')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- @if($currentDateTime > $nextTenDays)
            <div class="col-md-6 mb-4" id="property-built-year">
                <label class="labels">Year built</label>
                <input type="text" class="form-control" name="year_built" id="year_built" placeholder="2022" value="{{$blog->year_built}}" readonly data-toggle="tooltip" data-placement="top" title="You can't make edits as you created this post more than 10 days ago.">
            </div>
            @else
            <div class="col-md-6 mb-4" id="property-built-year">
                <label class="labels">Year built</label>
                <input type="text" class="form-control" name="year_built" id="year_built" placeholder="2022" value="{{$blog->year_built}}">
                @error('year_built')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            @endif --}}

            <div class="col-md-6 mb-4" id="property-built-year">
                <label class="labels">Year built</label>
                <input type="text" class="form-control" name="year_built" id="year_built" placeholder="2022" value="{{$blog->year_built}}">
                @error('year_built')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        
            <?php
            $choices_new = explode("|", $blog->choices);
            $choices_new = array_map(function ($element) {
                return str_replace(array('[', ']', '"'), '', $element);
            }, $choices_new);
            // echo "<pre>";print_r($choices_new);die();
            ?>

            
            {{-- @if($currentDateTime > $nextTenDays)  
            <div class="col-md-6 mb-4" id="property-features">
                <label class="labels">Features ex: 2 stories,wood floors, fireplace</label>
                <input type="text" value="{{ implode(', ', $choices_new) }}" class="form-control mb-2" readonly data-toggle="tooltip" data-placement="top" title="You can't make edits as you created this post more than 10 days ago.">
                @foreach($choices_new as $choice_new)
                    <input type="hidden" name="choices[]" value="{{ $choice_new }}">
                @endforeach
            </div>
            @else
            <div class="col-md-6 mb-4" id="property-features">
                <label class="labels">Features ex: 2 stories,wood floors, fireplace</label>
                <select class="form-control" name="choices[]" id="post-choices" multiple="multiple">
                    <option value="">Select tags</option>
                    <option value="Wood Floors" {{ in_array('Wood Floors', $choices_new) ? 'selected' : '' }}>Wood floors </option>
                    <option value="fireplace" {{ in_array('fireplace', $choices_new) ? 'selected' : '' }}>fireplace</option>
                    <option value="2 Stories" {{ in_array('2 Stories', $choices_new) ? 'selected' : '' }}>2 Stories</option>

                </select>
                @error('choices')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            @endif --}}

            <div class="col-md-6 mb-4" id="property-features">
                <label class="labels">Features ex: 2 stories,wood floors, fireplace</label>
                <select class="form-control" name="choices[]" id="post-choices" multiple="multiple">
                    <option value="">Select tags</option>
                    <option value="Wood Floors" {{ in_array('Wood Floors', $choices_new) ? 'selected' : '' }}>Wood floors </option>
                    <option value="fireplace" {{ in_array('fireplace', $choices_new) ? 'selected' : '' }}>fireplace</option>
                    <option value="2 Stories" {{ in_array('2 Stories', $choices_new) ? 'selected' : '' }}>2 Stories</option>

                </select>
                @error('choices')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            
            {{-- @if($currentDateTime > $nextTenDays)
            <div class="col-md-12 mb-4">
                <label class="labels">Regular price</label>
                <input type="number" class="form-control" name="price" id="price" placeholder="" value="{{$blog->price}}" readonly data-toggle="tooltip" data-placement="top" title="You can't make edits as you created this post more than 10 days ago.">
            </div>
            @else
            <div class="col-md-12 mb-4">
                <label class="labels">Regular price</label>
                <input type="number" class="form-control" name="price" id="price" placeholder="" value="{{$blog->price}}">
                @error('price')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            @endif  --}}

            <div class="col-md-12 mb-4">
                <label class="labels">Regular price</label>
                <input type="number" class="form-control" name="price" id="price" placeholder="" value="{{$blog->price}}">
                @error('price')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!--  <div class="col-md-6 mb-4">
                            <label class="labels">Offered price</label>
                            <input type="number" class="form-control" name="sale_price" id="sale_price" placeholder="5000" value="{{$blog->sale_price}}" >
                        </div> -->
            <div class="col-md-6 mb-4">
            <label class="labels" data-toggle="tooltip" data-placement="top" title="Any photo that signals an intention to commit, solicit, promote or encourage a criminal act and/or violate the  Advertiser Agreement will not be accepted.">Post featured image <em>(Select multiple)</em> <i class="fa fa-question popup2"> </i></label>
            
                <div class="upload-icon"><a class="cam btn btn-warning"  href="javascript:void(0)">
                    <i class="fa fa-upload" aria-hidden="true"></i>
                        Upload image
                    </a> 
                </div>

            
               
                <!-- <div class="gallery" id="sortableImgThumbnailPreview"></div> -->
                @if(!empty($blog->image1))
                <div class="show-img ">
                    <?php
                    $neimg = trim($blog->image1, '[""]');
                    $img  = explode('","', $neimg);

                    // echo "<pre>";print_r($img);die('dev');
                    ?>
                    <div class="gallery">
                    @foreach($img as $index => $images)
                    <div class='apnd-img'>
                        <img src="{{ asset('images_blog_img') }}/{{ $images }}" id='img' imgtype="listing" remove_name="{{ $images }}" dataid="{{$blog->id}}" class='img-responsive'>
                        @if($currentDateTime < $nextTenDays) 
                            <i class='fa fa-trash delfile'></i>
                            @endif
                        
                    </div>
                    
                    @endforeach
                    </div>
                </div>
                @error('image')
                <small class="text-danger">{{ $message }}</small>
                @enderror
                @else
                <div class="show-img">
                <div class="gallery">             
                </div>
                </div>
                @endif
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
                        <input data-="image" type="file" accept="video/*" id="video_upload" class="image-input" data-traget-resolution="image_resolution" name="post_video" value="">
                    </label>
                </div>
                @if(isset($blog->post_video))
                <div class="show-video">
                    <video controls id="video-tag">
                        <source id="video-source" src="{{asset('images_blog_video')}}/{{$blog->post_video}}">
                    </video>
                    <i class="fas fa-times" id="cancel-btn-1"></i>
                </div>
                @endif
            </div> --}}


            <!-- <div class="col-md-12 mb-4">
                            <div id="summernote">
                                <label class="labels" for ="post-desc" >Description</label>
                                <textarea id="post-desc" class="form-control" name="description" rows="4" cols="50">{{strip_tags($blog->description)}}</textarea>
                            </div>
                        </div> -->

            @if($currentDateTime > $nextTenDays)
            <div class="col-md-12 mb-4">
                <label class="labels">Description *</label>
                    <textarea  class="form-control" name="description" placeholder="Description" <?php echo old('description'); ?> readonly data-toggle="tooltip" data-placement="top" title="You can't make edits as you created this post more than 10 days ago.">{{strip_tags($blog->description)}}</textarea>
            </div>
            @else
            <div class="col-md-12 mb-4">
                <label class="labels">Description *</label>
                <div>
                    <textarea id="editor1"  class="form-control" name="description" placeholder="Description" <?php echo old('description'); ?>>{{strip_tags($blog->description)}}</textarea>
                    @error('description')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            @endif

            <div class="col-md-12 mb-4">
                <div class="col-md-12 mt-4">
                    <label class="custom-toggle">
                        <input type="checkbox" name="personal_detail" value="true" {{ $blog->personal_detail == 'true'? 'checked' : '' }}> &nbsp;&nbsp;<span>Show your contact details. Keep in mind if you want customers to reach you outside of FindersPage you will need to make your contact details visible to the public.</span>
                    </label>
                </div>
                <div class="row">
                    <div class="col-md-6 mt-4 ">
                        <label class="custom-toggle">Email</label>
                        <input type="email"  class="form-control" name="email" value="{{$blog->email}}" placeholder="example@example.com">

                    </div>
                    <div class="col-md-6 mt-4">
                        <label class="custom-toggle">Phone number</label>
                        <input type="tel"  class="form-control" id="phone" name="phone" value="{{$blog->phone}}" placeholder="+1 1234567890">
                    </div>
                    <div class="col-md-6 mt-4">
                        <label class="custom-toggle">Website link</label>
                        <input type="text"  class="form-control" name="website" value="{{$blog->website}}" placeholder="https://test.com">
                    </div>
                    <div class="col-md-6 mt-4">
                        <label class="custom-toggle">Whatsapp</label>
                        <input type="tel"  class="form-control" id="whatsapp" name="whatsapp" value="{{$blog->whatsapp}}" placeholder="whatsapp number">
                    </div>
                    <!-- <div class="col-md-2 mt-4">
                        <label class="custom-toggle">Twitter</label>
                        <input type="text" @if($currentDateTime > $nextTenDays) readonly @endif class="form-control" name="twitter" value="{{$blog->twitter}}" placeholder="https://twitter.com/">
                    </div>
                    <div class="col-md-2 mt-4">
                        <label class="custom-toggle">Youtube </label>
                        <input type="text" @if($currentDateTime > $nextTenDays) readonly @endif class="form-control" name="youtube" value="{{$blog->youtube}}" placeholder="https://www.youtube.com/channel">
                    </div>
                    <div class="col-md-2 mt-4">
                        <label class="custom-toggle">Facebook</label>
                        <input type="text" @if($currentDateTime > $nextTenDays) readonly @endif class="form-control" name="facebook" value="{{$blog->facebook}}" placeholder="https://www.facebook.com">
                    </div>
                    <div class="col-md-2 mt-4">
                        <label class="custom-toggle">Instagram</label>
                        <input type="text" @if($currentDateTime > $nextTenDays) readonly @endif class="form-control" name="instagram" value="{{$blog->instagram}}" placeholder="https://www.instagram.com">
                    </div>
                    <div class="col-md-2 mt-4">
                        <label class="custom-toggle">Linkedin </label>
                        <input type="text" @if($currentDateTime > $nextTenDays) readonly @endif class="form-control" name="linkedin" value="{{$blog->linkedin}}" placeholder="https://www.linkedin.com/">
                    </div>
                    <div class="col-md-2 mt-4">
                        <label class="custom-toggle">Tiktok </label>
                        <input type="text" @if($currentDateTime > $nextTenDays) readonly @endif class="form-control" name="tiktok" value="{{$blog->tiktok}}" placeholder="https://www.tiktok.com/@">
                    </div> -->
                </div>
            </div>

        </div>



        <!-- <div class="row bg-white border-radius mt-5 p-3"> -->
            <!-- <div class="col-md-6 mb-6 social-area" style="justify-content: center;">
                <input type="radio" name="post_type" value="Feature Post" {{ $blog->featured_post === 'on' ? 'checked' : '' }} required>
                <label class="labels" data-toggle="tooltip" data-placement="top" title="Feature your listing on the homepage starting at just $55 per month.">Feature Listing <i class="fa fa-question popup1">
                       
                    </i></label>
                @error('post_type')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div> -->
            <!-- <div class="col-md-6 mb-6 social-area" style="justify-content: center;">
                <input type="radio" name="post_type" value="Normal Post" {{ $blog->post_type === 'Normal Post' ? 'checked' : '' }}  required>
                <label class="labels" data-toggle="tooltip" data-placement="top" title="Your free listing will expire after 30 days. If you renew it before the 30 days is up, your listing will stay up for another 30 days.">Free Listing <i class="fa fa-question popup2">
                       
                    </i></label>
                @error('post_type')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div> -->
            <input type="hidden" name="post_type" value="Normal Post" >
        <!-- </div> -->
        <div class="mt-5 text-center"><button class="btn profile-button addCategory" type="submit">Update</button></div>
</div>
</form>

<script>
    $(document).ready(function() {
        var choiceButton = new Choices('#post-choices', {
            removeItemButton: true,
            maxItemCount: 100,
            searchResultLimit: 100,
            renderChoiceLimit: 100
        });


        var selectedOption = $("#sub_categories").val();
        // alert(selectedOption);
        if (selectedOption === "532") {
            $("#landInput").show();
            $('#property-choices').hide();
            $('#property-built-year').hide();
            $('#property-area').hide();
            $('#property-bathroom').hide();
            $('#property-units').hide();
            $('#property-garage').hide();
            $('#property-features').hide();



        } else {
            $("#landInput").hide();
            $('#property-choices').show();
            $('#property-built-year').show();
            $('#property-area').show();
            $('#property-bathroom').show();
            $('#property-units').show();
            $('#property-garage').show();
            $('#property-features').show();
        }


        $("#sub_categories").on("change", function() {
            var selectedOption = $(this).val();
            if (selectedOption === "532") {
                $("#landInput").show();
                $('#property-choices').hide();
                $('#property-built-year').hide();
                $('#property-area').hide();
                $('#property-bathroom').hide();
                $('#property-units').hide();
                $('#property-garage').hide();
                $('#property-features').hide();



            } else {
                $("#landInput").hide();
                $('#property-choices').show();
                $('#property-built-year').show();
                $('#property-area').show();
                $('#property-bathroom').show();
                $('#property-units').show();
                $('#property-garage').show();
                $('#property-features').show();
            }
        });

    });

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
        $('#sub_category').on('change', function() {
            if ($(this).val() == "Other") {
                $('#Other-cate-input').removeClass('d-none');
                $(this).addClass('d-none');
            } else {
                $('#Other-cate-input').addClass('d-none');
            }

        });

        $('.addCategory').click(function(e) {
            var subcate_title = $('#Other-cate-input').val();
            if (subcate_title == "") {
                
                $('#realState_form_new').submit();
            }
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            e.preventDefault();
            $.ajax({
                url: baseurl + '/shopping/cate',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    title: subcate_title,
                    parent_id: 4,
                },
                success: function(response) {
                    console.log(response);
                    $('#realState_form_new').submit();
                },
                error: function(xhr, status, error) {

                }
            });
        });
    });

$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip({
        trigger: 'hover focus'
    });
});

            function formatNumber(input) {
                let value = input.value.replace(/,/g, ''); // Remove existing commas
                if (!isNaN(value) && value !== '') {
                    input.value = Number(value).toLocaleString(); // Add commas
                }
            }
</script>


@endsection