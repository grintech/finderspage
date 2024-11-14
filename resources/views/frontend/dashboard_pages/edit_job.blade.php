@extends('layouts.user_dashboard.userdashboardlayout')
@section('content')
<?php  use Carbon\Carbon; ?>
<style>
    .select2-container {
        box-sizing: border-box;
        display: inline-block;
        margin: 0;
        position: relative;
        /* width: 100% !important; */
    }
    .error-message {
        color: #e74a3b;
    }
    @media only screen and (max-width:767px){
        .container-fluid {padding-bottom: 50px !important;}
    }
</style>
<div class="container px-sm-5 px-4 pb-4">
    <form method="post" action="<?php echo route('job_edit', $blog->slug); ?>" class="form-validation" enctype="multipart/form-data" id="job_forms">

        {{ @csrf_field() }}
        <!-- Page Heading -->
        <div class="d-sm-flex flex-column  mb-3">
            <h1 class="h3 mb-0 text-gray-800 fw-bold">Edit Job Listing</h1>
            <p>Choose the best category that fits your needs and create a free listing</p>
        </div>
        <span>
            @include('admin.partials.flash_messages')
        </span>
        <input type="hidden" name="category" value="2">
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
                <input type="text" id="title-input" nectjfghjfd="{{$nextTenDays}}" class="form-control" name="title" placeholder="Title" value="{{$blog->title}}"  readonly data-toggle="tooltip" data-placement="top" title="You can't make edits as you created this post more than 10 days ago.">
            </div>
            @else
            <div class="col-md-6 mb-4">
                <label class="labels">Title <sup>*</sup></label>
                <input type="text" id="title-input" nectjfghjfd="{{$nextTenDays}}" class="form-control" name="title" placeholder="Title" value="{{$blog->title}}" >
                <span class="error-message" id="title-error"></span>
                @error('title')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            @endif

            <!--    <div class="col-md-6 mb-4 form-check check-frame">
                            <input class="form-check-input" id="inputRememberPassword" name="feature" type="checkbox" value="" />
                            <label class="form-check-label" for="inputRememberPassword">Do you want to make this Post Featured?</label>
                        </div> -->

            {{-- @if($currentDateTime > $nextTenDays)  
            <div class="col-md-6 mb-4">
                <label class="labels">Sub categories <sup>*</sup></label>
                @foreach($categories as $cate)
                    @if($blog->sub_category == $cate->id)
                        <input type="text" value="{{$cate->title}}" class="form-control mb-2" readonly data-toggle="tooltip" data-placement="top" title="You can't make edits as you created this post more than 10 days ago.">
                        <input type="hidden" name="sub_category" value="{{$cate->id}}">
                    @endif
                @endforeach
            </div>
            @else
            <div class="col-md-6 mb-4">
                <label class="labels">Sub categories <sup>*</sup></label>
                <select name="sub_category" class="form-control form-control-xs selectpicker" data-size="7" data-live-search="true" data-title="Sub categories" id="sub_category" data-width="100%" required>
                    @foreach($categories as $cate)
                    <option {{ $blog->sub_category == $cate->id ? 'selected' : '' }} value="{{$cate->id}}">{{$cate->title}}</option>
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
                <select name="sub_category" class="form-control form-control-xs selectpicker" data-size="7" data-live-search="true" data-title="Sub categories" id="sub_category" data-width="100%" required>
                    @foreach($categories as $cate)categories
                    <option {{ $blog->sub_category == $cate->id ? 'selected' : '' }} value="{{$cate->id}}">{{$cate->title}}</option>
                    @endforeach
                    <option class="Other-cate" value="Other">Other</option>
                </select>
                <input type="text" class="form-control d-none mt-2" id="Other-cate-input" name="sub_category_oth" placeholder="sub_category name" value="">
            
                @error('sub_category')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
                  
            
            {{-- @if($currentDateTime > $nextTenDays)  
            <div class="col-md-6 mb-4">
                <label class="labels">Job type</label>
                <input type="text" value="{{ $blog->choices }}" class="form-control mb-2" readonly data-toggle="tooltip" data-placement="top" title="You can't make edits as you created this post more than 10 days ago.">
                <input type="hidden" name="choices" value="{{ $blog->choices }}">
            </div>
            @else
            <div class="col-md-6 mb-4">
                <label class="labels">Job type</label>
                <select class="form-control" name="choices" id="job_type">
                    <option value="">Select choice</option>
                    <option value="Full Time" {{ $blog->choices == 'Full Time' ? 'selected' : '' }}>Full Time</option>
                    <option value="Part Time" {{ $blog->choices == 'Part Time' ? 'selected' : '' }}>Part Time</option>
                    <option value="contract" {{ $blog->choices == 'contract' ? 'selected' : '' }}>Contract</option>
                </select>
                @error('choices')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            @endif --}}
            
            <div class="col-md-6 mb-4">
                <label class="labels">Job type</label>
                <select class="form-control" name="choices" id="job_type">
                    <option value="">Select choice</option>
                    <option value="Full Time" {{ $blog->choices == 'Full Time' ? 'selected' : '' }}>Full Time</option>
                    <option value="Part Time" {{ $blog->choices == 'Part Time' ? 'selected' : '' }}>Part Time</option>
                    <option value="contract" {{ $blog->choices == 'contract' ? 'selected' : '' }}>Contract</option>
                </select>
                @error('choices')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>


            <?php
            $benefitsArray = explode(",", $blog->benifits);
            $benefitsArray = array_map(function ($element) {
                return str_replace(array('[', ']', '"'), '', $element);
            }, $benefitsArray);
            // echo "<pre>";print_r($blog->choice);die();
            ?>


            {{-- @if($currentDateTime > $nextTenDays)  
            <div class="col-md-6 mb-4">
                <label class="labels">Are any of the following offered?</label>
                <input type="text" value="{{ implode(', ', $benefitsArray) }}" class="form-control mb-2" readonly data-toggle="tooltip" data-placement="top" title="You can't make edits as you created this post more than 10 days ago.">
                @foreach($benefitsArray as $benefit)
                    <input type="hidden" name="benifits" value="{{ $benefit }}">
                @endforeach
            </div>
            @else
            <div class="col-md-6 mb-4">
                <label class="labels">Are any of the following offered?</label>
                
                <div class="select-wrapper">
                <select class="form-control" name="benifits[]" id="choices-multiple-remove-button" multiple="multiple" required>
                    <option value="">Select an offer</option>
                    <option value="Health Insurance" {{ in_array('Health Insurance', $benefitsArray) ? 'selected' : '' }}>Health Insurance</option>
                    <option value="Paid time off" {{ in_array('Paid time off', $benefitsArray) ? 'selected' : '' }}>Paid time off</option>
                    <option value="Dental insurance" {{ in_array('Dental insurance', $benefitsArray) ? 'selected' : '' }}>Dental insurance</option>
                    <option value="Vision insurance" {{ in_array('Vision insurance', $benefitsArray) ? 'selected' : '' }}>Vision insurance</option>
                    <option value="Flexible schedule" {{ in_array('Flexible schedule', $benefitsArray) ? 'selected' : '' }}>Flexible schedule</option>
                    <option value="Tuition reimbursement" {{ in_array('Tuition reimbursement', $benefitsArray) ? 'selected' : '' }}>Tuition reimbursement</option>
                    <option value="Referral program" {{ in_array('Referral program', $benefitsArray) ? 'selected' : '' }}>Referral program</option>
                    <option value="Employee discount" {{ in_array('Employee discount', $benefitsArray) ? 'selected' : '' }}>Employee discount</option>
                    <option value="Flexible spending account" {{ in_array('Flexible spending account', $benefitsArray) ? 'selected' : '' }}>Flexible spending account</option>
                    <option value="Health saving account" {{ in_array('Health saving account', $benefitsArray) ? 'selected' : '' }}>Health saving account</option>
                    <option value="Relocation assistance" {{ in_array('Relocation assistance', $benefitsArray) ? 'selected' : '' }}>Relocation assistance</option>
                    <option value="Parental leave" {{ in_array('Parental leave', $benefitsArray) ? 'selected' : '' }}>Parental leave</option>
                    <option value="Professional development assistance" {{ in_array('Professional development assistance', $benefitsArray) ? 'selected' : '' }}>Professional development assistance</option>
                    <option value="Employee assistance program" {{ in_array('Employee assistance program', $benefitsArray) ? 'selected' : '' }}>Employee assistance program</option>
                    <option value="Life insurance" {{ in_array('Life insurance', $benefitsArray) ? 'selected' : '' }}>Life insurance</option>
                    <option value="Retirement Plan" {{ in_array('Retirement Plan', $benefitsArray) ? 'selected' : '' }}>Retirement Plan</option>
                    <option value="other" {{ in_array('other', $benefitsArray) ? 'selected' : '' }}>Other</option>
                </select>
                <i class="fas fa-angle-down select-down"></i>
                </div>
                @error('benifits')
                <small class="text-danger">{{ $message }}</small>
                @enderror

            </div>
            @endif --}}

            <div class="col-md-6 mb-4">
                <label class="labels">Are any of the following offered?</label>
                
                <div class="select-wrapper">
                <select class="form-control" name="benifits[]" id="choices-multiple-remove-button" multiple="multiple" >
                    <option value="">Select an offer</option>
                    <option value="Health Insurance" {{ in_array('Health Insurance', $benefitsArray) ? 'selected' : '' }}>Health Insurance</option>
                    <option value="Paid time off" {{ in_array('Paid time off', $benefitsArray) ? 'selected' : '' }}>Paid time off</option>
                    <option value="Dental insurance" {{ in_array('Dental insurance', $benefitsArray) ? 'selected' : '' }}>Dental insurance</option>
                    <option value="Vision insurance" {{ in_array('Vision insurance', $benefitsArray) ? 'selected' : '' }}>Vision insurance</option>
                    <option value="Flexible schedule" {{ in_array('Flexible schedule', $benefitsArray) ? 'selected' : '' }}>Flexible schedule</option>
                    <option value="Tuition reimbursement" {{ in_array('Tuition reimbursement', $benefitsArray) ? 'selected' : '' }}>Tuition reimbursement</option>
                    <option value="Referral program" {{ in_array('Referral program', $benefitsArray) ? 'selected' : '' }}>Referral program</option>
                    <option value="Employee discount" {{ in_array('Employee discount', $benefitsArray) ? 'selected' : '' }}>Employee discount</option>
                    <option value="Flexible spending account" {{ in_array('Flexible spending account', $benefitsArray) ? 'selected' : '' }}>Flexible spending account</option>
                    <option value="Health saving account" {{ in_array('Health saving account', $benefitsArray) ? 'selected' : '' }}>Health saving account</option>
                    <option value="Relocation assistance" {{ in_array('Relocation assistance', $benefitsArray) ? 'selected' : '' }}>Relocation assistance</option>
                    <option value="Parental leave" {{ in_array('Parental leave', $benefitsArray) ? 'selected' : '' }}>Parental leave</option>
                    <option value="Professional development assistance" {{ in_array('Professional development assistance', $benefitsArray) ? 'selected' : '' }}>Professional development assistance</option>
                    <option value="Employee assistance program" {{ in_array('Employee assistance program', $benefitsArray) ? 'selected' : '' }}>Employee assistance program</option>
                    <option value="Life insurance" {{ in_array('Life insurance', $benefitsArray) ? 'selected' : '' }}>Life insurance</option>
                    <option value="Retirement Plan" {{ in_array('Retirement Plan', $benefitsArray) ? 'selected' : '' }}>Retirement Plan</option>
                    <option value="other" {{ in_array('other', $benefitsArray) ? 'selected' : '' }}>Other</option>
                </select>
                <i class="fas fa-angle-down select-down"></i>
                </div>
                @error('benifits')
                <small class="text-danger">{{ $message }}</small>
                @enderror

            </div>

            {{-- @if($currentDateTime > $nextTenDays)  
            <div class="col-md-6 mb-4">
                <label class="labels">Do you offer any of the following supplemental pay?</label>
                <input type="text" value="{{ str_replace('"', '', $blog->supplement) }}" class="form-control mb-2" readonly data-toggle="tooltip" data-placement="top" title="You can't make edits as you created this post more than 10 days ago.">
                <input type="hidden" name="supplement" value="{{ $blog->supplement }}">
            </div>
            @else
            <div class="col-md-6 mb-4">
                <label class="labels">Do you offer any of the following supplemental pay?</label>
                <select class="form-control" name="supplement" id="supplement" >
                    <option value="">Select option</option>
                    <option value="Signing Bonus" {{ trim($blog->supplement) === 'Signing Bonus' ? 'selected' : '' }}>Signing Bonus</option>
                    <option value="Comission Pay" {{ trim($blog->supplement) === 'Comission Pay' ? 'selected' : '' }}>Comission Pay</option>
                    <option value="Bonus Pay" {{ trim($blog->supplement) === 'Bonus Pay' ? 'selected' : '' }}>Bonus Pay</option>
                    <option value="Tips" {{ trim($blog->supplement) === 'Tips' ? 'selected' : '' }}>Tips</option>
                    <option value="Other" {{ trim($blog->supplement) === 'Other' ? 'selected' : '' }}>Other</option>
                </select>
                @error('supplement')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            @endif --}}
            
            <div class="col-md-6 mb-4">
                <label class="labels">Do you offer any of the following supplemental pay?</label>
                <select class="form-control" name="supplement" id="supplement" >
                    <option value="">Select option</option>
                    <option value="Signing Bonus" {{ trim($blog->supplement) === 'Signing Bonus' ? 'selected' : '' }}>Signing Bonus</option>
                    <option value="Comission Pay" {{ trim($blog->supplement) === 'Comission Pay' ? 'selected' : '' }}>Comission Pay</option>
                    <option value="Bonus Pay" {{ trim($blog->supplement) === 'Bonus Pay' ? 'selected' : '' }}>Bonus Pay</option>
                    <option value="Tips" {{ trim($blog->supplement) === 'Tips' ? 'selected' : '' }}>Tips</option>
                    <option value="Other" {{ trim($blog->supplement) === 'Other' ? 'selected' : '' }}>Other</option>
                </select>
                @error('supplement')
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
                             <select title="Select Country" name="country" class="form-control" id="country_name" post-id="{{$blog->id}}" >      
                                <option value="">Select Country</option>
                                <?php
                                foreach ($countries as $key => $element) { ?>
                                    <option {{ $blog->country == $element['id'] ? 'selected' : '' }}  value="<?php echo $element['id']; ?>"> <?php echo $element['name']; ?></option>
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
                             <select title="Select Country" name="state"  class="form-control state1" id="state_name" >     
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
                            <label class="labels">Zipcode</label>
                            <input name="zipcode" type="text" maxlength="8" class="form-control" id="Zipcode" value="{{$blog->zipcode}}" placeholder="twitter">
                        </div> -->
            <!-- <div class="col-md-12 mb-4">
                            <label class="labels">Location <sup>*</sup></label>
                            <input name="location" type="text"  class="form-control get_loc" id="location" value="{{$blog->location}}" placeholder="Enter location">
                            <div class="searcRes" id="autocomplete-results">
                                    
                            </div>
                        </div> -->
            {{-- <div class="col-md-12"><label class="labels"></label></div> --}}

            {{-- @if($currentDateTime > $nextTenDays)
            <div class="col-md-6 mb-4">
                <div class="form-group ">
                    <label class="form-check-label" for="exampleInput">Starting pay at </label>
                    <input type="number" name="fixed_pay" class="form-control" placeholder="Enter amount" value="{{$blog->fixed_pay}}" readonly data-toggle="tooltip" data-placement="top" title="You can't make edits as you created this post more than 10 days ago.">
                    <span class="text-danger" id="fixed_error"> </span>
                </div>
            </div>
            @else
            <div class="col-md-6 mb-4">
                <label class="labels">Show pay by</label>
                            <select class="form-control fixedorRange" name="pay_by" id="pay_by" required>
                                <option value="">Select Option</option>
                                <option {{ $blog->pay_by == 'Range' ? 'selected' : '' }} value="Range">Range</option>
                                <option {{ $blog->pay_by == 'Fixed' ? 'selected' : '' }} value="Fixed">Fixed</option>
                            </select>
                <div class="form-group d-none" id="range">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-check-label" for="exampleInput">Minimum ($)</label>
                                    <input type="number" class="form-control" name="min_pay" value="{{$blog->min_pay}}">
                                    
                                </div>
                                <div class="col-md-6">
                                    <label class="form-check-label" for="exampleInput">Maximum ($)</label>
                                    <input type="number" class="form-control" name="max_pay" value="{{$blog->max_pay}}">
                                </div>
                            </div>
                        </div>
                <div class="form-group ">
                    <label class="form-check-label" for="exampleInput">Starting pay at </label>
                    <input type="number" name="fixed_pay" class="form-control" placeholder="Enter amount" value="{{$blog->fixed_pay}}">
                    <span class="text-danger" id="fixed_error"> </span>
                </div>
            </div>
            @endif --}}

            {{-- <div class="col-md-6 mb-4">
                <div class="form-group ">
                    <label class="form-check-label" for="exampleInput">Starting pay at </label>
                    <input type="number" name="fixed_pay" class="form-control" placeholder="Enter amount" value="{{$blog->fixed_pay}}">
                    <span class="text-danger" id="fixed_error"> </span>
                </div>
            </div> --}}

            {{-- @if($currentDateTime > $nextTenDays)  
            <div class="col-md-6 mb-4">
                <label class="labels">Rate</label>
                <input type="text" value="{{ $blog->rate }}" class="form-control mb-2" readonly data-toggle="tooltip" data-placement="top" title="You can't make edits as you created this post more than 10 days ago.">
                <input type="hidden" name="rate" value="{{ $blog->rate }}">
            </div>
            @else
            <div class="col-md-6 mb-4">
                <label class="labels">Rate</label>
                <select class="form-control" name="rate" id="rete" required>
                    <option value="">Select option</option>
                    <option {{ $blog->rate == 'per hour' ? 'selected' : '' }} value="per hour">per hour</option>
                    <option {{ $blog->rate == 'per day' ? 'selected' : '' }} value="per day">per day</option>
                    <option {{ $blog->rate == 'per week' ? 'selected' : '' }} value="per week">per week</option>
                    <option {{ $blog->rate == 'per month' ? 'selected' : '' }} value="per month">per month</option>
                </select>
                <span class="error-message" id="title-error"></span>
            </div>
            @endif --}}

            <div class="col-md-6 mb-4">
                <label class="labels">Range <sup>*</sup></label>
                <div class="d-flex align-items-center" id="range">
                    <input type="number" step="0.01" name="min_pay" id="min_pay" value="{{ $blog->min_pay }}" class="form-control mr-2" placeholder="Minimum" required> 
                    <span class="mx-2">to</span> 
                    <input type="number" step="0.01" name="max_pay" id="max_pay" value="{{ $blog->max_pay }}" class="form-control ml-2" placeholder="Maximim (Optional)"> 
                </div>
                <span class="error-message" id="range-error"></span>
            </div>

            <div class="col-md-6 mb-4">
                <label class="labels">Rate</label>
                <select class="form-control" name="rate" id="rate" required>
                    <option value="">Select option</option>
                    <option {{ $blog->rate == 'per hour' ? 'selected' : '' }} value="per hour">per hour</option>
                    <option {{ $blog->rate == 'per day' ? 'selected' : '' }} value="per day">per day</option>
                    <option {{ $blog->rate == 'per week' ? 'selected' : '' }} value="per week">per week</option>
                    <option {{ $blog->rate == 'per month' ? 'selected' : '' }} value="per month">per month</option>
                    <option {{ $blog->rate == 'per annually' ? 'selected' : '' }} value="per annually">per annually</option>
                </select>
                <span class="error-message" id="rate-error"></span>
            </div>


            <div class="col-md-6 mb-4">
                <!-- <label class="labels">Post featured image *[Max-size - 1 MB]</label> -->
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
                        <input data-required="image" type="file" name="image1[]" id="image_upload" class="image-input" data-traget-resolution="image_resolution" value="" multiple accept="image/gif, image/jpeg, image/png" onchange="checkImageCount(this)">
                    </label>

                </div> -->

                <label class="labels" data-toggle="tooltip" data-placement="top" title="Any photo that signals an intention to commit, solicit, promote or encourage a criminal act and/or violate the  Advertiser Agreement will not be accepted.">Post featured image <em>(Select multiple)</em> <i class="fa fa-question popup2"> </i></label>
                 {{-- @if($currentDateTime > $nextTenDays) --}}
                 <div class="upload-icon"><a class="cam btn btn-warning"  href="javascript:void(0)">
                    <i class="fa fa-upload" aria-hidden="true"></i>
                        Upload image
                    </a> 
                </div>
               {{-- @else --}}
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
                <div class="show-img ">
                <div class="gallery">
                    @if(!empty($blog->image1))
                    
                    <?php
                    $neimg = trim($blog->image1, '[""]');
                    $img  = explode('","', $neimg);

                    // echo "<pre>";print_r($img);die('dev');
                    ?>
                    
                        @foreach($img as $index => $images)
                        <div class='apnd-img'>
                            <img src="{{ asset('images_blog_img') }}/{{ $images }}" id='img' imgtype="listing" remove_name="{{ $images }}" dataid="{{$blog->id}}" class='img-responsive'>
                            @if($currentDateTime < $nextTenDays) 
                            <i class='fa fa-trash delfile'></i>
                            @endif
                            
                        </div>
                        @endforeach
                    
                    @endif
                    </div>
                </div>
              </div>  --}}
            <!-- <div class="col-md-6 mb-4">
                <label class="labels"> Post video format: .mp4 | Max size: 2MB</label>
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
                        </div>
                        <input data-required="image" type="file" accept="video/*" id="video_upload" class="image-input" data-traget-resolution="image_resolution" name="post_video" value="">
                    </label>
                </div>
                <div class="show-video ">
                    <video controls id="video-tag">
                        <source id="video-source" src="{{asset('images_blog_video')}}/{{$blog->post_video}}">
                        Your browser does not support the video tag.
                    </video>
                    <i class="fas fa-times" id="cancel-btn-1"></i>
                    @error('post_video')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div> -->

            @if($currentDateTime > $nextTenDays)
            <div class="col-md-12 mb-4">
                <label class="labels">Description *</label>
                    <textarea class="form-control" name="description" placeholder="Description" readonly data-toggle="tooltip" data-placement="top" title="You can't make edits as you created this post more than 10 days ago."><?php echo old('description'); ?>{!! $blog->description !!}</textarea>
            </div>
            @else 
            <div class="col-md-12 mb-4">
                <label class="labels">Description *</label>
                <div id="summernote">
                    <textarea id="editor1" class="form-control" name="description" placeholder="Description"><?php echo old('description'); ?>{!! $blog->description !!}</textarea>

                    @error('description')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            @endif

            {{-- <div class="col-md-12 mb-4">
                <label class="custom-toggle">
                    <input type="checkbox" name="personal_detail" value="true" {{ $blog->personal_detail == 'true'? 'checked' : '' }} > &nbsp;&nbsp;<span>Do you want to show your contact details on the post ?</span>
                </label>
            </div> --}}



            <div class="col-md-12 mb-4">

                <div class="col-md-12 mt-4">
                    <label class="custom-toggle">
                        <input type="checkbox" name="personal_detail" value="true" {{ $blog->personal_detail == 'true'? 'checked' : '' }}> &nbsp;&nbsp;<span>Show your contact details. Keep in mind if you want customers to reach you outside of FindersPage you will need to make your contact details visible to the public.</span>
                    </label>
                </div>
                <div class=" row ">
                    <div class="col-md-6 mt-4 ">
                        <label class="custom-toggle">Email</label>
                        <input type="email" class="form-control" name="email" value="{{$blog->email}}" placeholder="example@example.com">

                    </div>
                    <div class="col-md-6 mt-4">
                        <label class="custom-toggle">Phone number</label>
                        <input type="tel"  class="form-control" id="phone" name="phone" value="{{$blog->phone}}" placeholder="+1 1234567890">
                    </div>
                    <div class="col-md-6 mt-4">
                        <label class="custom-toggle">Website link</label>
                        <input type="text" class="form-control" name="website" value="{{$blog->website}}" placeholder="https://test.com">
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
        
            <input type="hidden" name="post_type" value="Normal Post" >
        


        <div class="mt-5 text-center"><button class="btn profile-button addCategory" type="submit">Update</button></div>

</form>
</div>
<script type="text/javascript">


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

        $('.addCategory').click(function() {
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
                    parent_id: 2,
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

        function validateRange() {
            
            var minPay = parseFloat($('#min_pay').val());
            var maxPay = parseFloat($('#max_pay').val());

            var errorMessage = '';

            if (minPay > maxPay || minPay == maxPay) {
                $('input[name="max_pay"]').val(minPay + 1);
                errorMessage = 'Maximum pay must be greater than to minimum pay.';
            }

            if (errorMessage) {
                $('#range-error').text(errorMessage);
            } else {
                $('#range-error').text('');
            }
        }

        $('#min_pay, #max_pay').on('blur', function() {
            validateRange();
        });

        validateRange();
    });

$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip({
        trigger: 'hover focus'
    });
});
</script>

@endsection