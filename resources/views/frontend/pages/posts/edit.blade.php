@extends('layouts.frontlayout')
@section('content')
    <?php use App\Models\Admin\BlogCategoryRelation; ?>
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
        <h3>Manage Post</h3>
        <p>Choose the best category that fits your needs and create a post</p>
    </div>
    <section class="form_section">
        <form method="post" action="<?php echo route('post.edit', ['id' => base64_encode($blog->id)]); ?>" class="form-validation">
            {{ @csrf_field() }}
            <div class="card">
                @include('admin.partials.flash_messages')
                <div class="form-group">
                    <label for="exampleInput">Title *</label>
                    <input type="text" class="form-control" id="exampleInputtext" name="title"
                        placeholder="Enter post name" required value="<?php echo $blog->title; ?>">
                    @error('title')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <?php
                /** Pluck use to get normal array from associative array ***/
                $selectedCategories = Arr::pluck($blog->categories, 'id');
                $sub_selectedCategories = BlogCategoryRelation::where('blog_id', $blog->id)
                    ->pluck('sub_category_id')
                    ->toArray();
                
                ?>
                <div class="form-group">
                    <label for="exampleInput">Main Category *</label>
                    <div class="categories-items">
                        <?php foreach ($categories as $key => $value): 
                    $active = $selectedCategories && in_array($value->id, $selectedCategories) ? true : false;
                    ?>
                        <div class="category-item category-click <?php echo $active ? 'active' : ''; ?>" data-id="<?php echo $value->id; ?>">
                            <?php if($active):?>
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
                    <label class="form-check-label" for="exampleInput">Sub Categories *</label>
                    <div>
                        <select multiple="multiple" id="myMulti2" name="sub_categories[]" class="form-control"
                            required="required" data-selected="<?php echo $sub_selectedCategories ? implode(',', $sub_selectedCategories) : ''; ?>">

                            <option value="">Select</option>
                            <?php foreach($categories_sub as $c): ?>

                            <?php if($c->sub_categories()->count() > 0): ?>
                            <optgroup label="<?php echo $c->title; ?>">

                                <?php foreach($c->sub_categories as $c): ?>
                                <option value="<?php echo $c->id; ?>" <?php echo $sub_selectedCategories && in_array($c->id, $sub_selectedCategories) ? 'selected' : ''; ?>><?php echo $c->title; ?></option>
                                <?php endforeach; ?>

                            </optgroup>
                            <?php else: ?>
                            <option value="<?php echo $c->id; ?>" <?php echo $sub_selectedCategories && in_array($c->id, $sub_selectedCategories) ? 'selected' : ''; ?>><?php echo $c->title; ?></option>
                            <?php endif; ?>

                            <?php endforeach; ?>
                        </select>

                    </div>
                    <small id="myMulti2-error" class="text-danger"></small>
                    @error('sub_categories')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group realstate_cate">
                    <label for="exampleInput">Property Address *</label>
                    <input type="text" class="form-control" id="exampleInputtext" name="property_address"
                        placeholder="Enter Property Address" required value="{{ $blog->property_address }}">
                    @error('property_address')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="row realstate_cate">
                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label>Country</label>
                            <select id="country_" name="country" class="form-control">
                                <option>Select Country</option>

                                @if ($countries)
                                    @foreach ($countries as $key => $value)
                                        <option {{ $blog->country == $value->id ? 'selected' : '' }}
                                            value="{{ $value->id }}">{{ $value->short_name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('country')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label>State</label>
                            <select id="state_" name="state" class="form-control">
                                <option>Select State</option>

                            </select>
                            @error('state')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row realstate_cate">
                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label>City</label>
                            <select id="city_" name="city" class="form-control">
                                <option>Select City</option>

                            </select>
                            @error('city')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label>Zipcode</label>
                            <input class="form-control" type="text" name="zipcode" placeholder=""
                                value="{{ $blog->zipcode }}" />
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
                                    <option {{ $blog->units == $i ? 'selected' : '' }} value="{{ $i }}">
                                        {{ $i }}</option>
                                @endfor
                            </select>
                            @error('phone')
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
                                    <option {{ $blog->bathroom == $i ? 'selected' : '' }} value="{{ $i }}">
                                        {{ $i }}</option>
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
                            <label>Grage</label>
                            <select id="grage" name="grage" class="form-control">
                                <option>Select Grage</option>
                                @for ($i = 01; $i <= 10; $i++)
                                    <option {{ $blog->grage == $i ? 'selected' : '' }} value="{{ $i }}">
                                        {{ $i }}</option>
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
                                value="{{ $blog->area_sq_ft }}" />
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
                                value="{{ $blog->year_built }}" />
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
                                value="{{ $blog->price }}" />
                            @error('price')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label>Sale Price</label>
                            <input class="form-control" type="text" name="sale_price" placeholder="4000" required
                                value="{{ $blog->sale_price }}" />
                            @error('sale_price')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>



                <div class="form-group">
                    <label class="form-check-label" for="exampleInput">Location<span style="font-weight: 400;"> (Choose
                            specific location for feature posts)</span></label>
                    <div class="radio">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="location" id="flexRadioDefault1"
                                value="worldwide" <?php echo $blog->location == 'worldwide' ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="flexRadioDefault1">
                                Worldwide
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="location" id="flexRadioDefault2"
                                value="multiple" <?php echo $blog->location == 'multiple' ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="flexRadioDefault2">
                                Multiple Location
                            </label>
                        </div>
                    </div>
                    @error('location')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>


                <div class="form-group ">
                    <label class="form-check-label realstate_cate" for="exampleInput">Features</label>
                    <label class="form-check-label business_cate" for="exampleInput">Choose your Choice</label>
                    <select multiple="multiple" id="myMulti11" name="choices[]" class="form-control">
                        <?php 
                 $choices = explode('|', $blog->choices);
                 if($choices): ?>
                        <?php foreach ($choices as $key => $value) {
                        echo '<option selected>'.$value.'</option>';
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
                            @php
                                $benefit = json_decode($blog->benifits);
                            @endphp
                            @if (!is_null($benefit))
                                @foreach ($benefit as $benefits)
                                    <option selected>{{ $benefits }}</option>
                                @endforeach
                            @endif
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
                            @php
                                $supplement = json_decode($blog->supplement);
                            @endphp
                            @if (!is_null($supplement))
                                @foreach ($supplement as $benefits)
                                    <option selected>{{ $benefits }}</option>
                                @endforeach
                            @endif
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
                                <option value="Range" <?php echo $blog->pay_by == 'Range' ? 'selected' : ' '; ?>>Range</option>
                                <option value="Fixed" <?php echo $blog->pay_by == 'Fixed' ? 'selected' : ' '; ?>>Fixed</option>
                            </select>
                        </div>
                        @if (!is_null($blog->min_pay) || !is_null($blog->max_pay))
                            <div class="form-group" id="range">
                                <label class="form-check-label" for="exampleInput">Minimum</label>
                                <input type="text" name="min_pay" value="{{ $blog->min_pay ?? ' ' }}">
                                <b>To</b>
                                <label class="form-check-label" for="exampleInput">Maximum</label>
                                <input type="text" name="max_pay" value="{{ $blog->max_pay ?? ' ' }}">
                            </div>
                        @endif
                        @if (!is_null($blog->fixed_pay))
                            <div class="form-group" id="fixed">
                                <label class="form-check-label" for="exampleInput">Fixed Pay</label>
                                <input type="text" name="fixed_pay" class="form-control" placeholder="Enter amount"
                                    value="{{ $blog->fixed_pay }}">
                            </div>
                        @endif
                        <div class="form-group">
                            <label class="form-check-label" for="exampleInput">Rate</label>
                            <select name="rate">
                                <option value="per hour" <?php echo $blog->pay_by == 'per hour' ? 'selected' : ' '; ?>>per hour</option>
                                <option value="per day" <?php echo $blog->pay_by == 'per day' ? 'selected' : ' '; ?>>per day</option>
                                <option value="per week" <?php echo $blog->pay_by == 'per week' ? 'selected' : ' '; ?>>per week</option>
                                <option value="per month" <?php echo $blog->pay_by == 'per month' ? 'selected' : ' '; ?>>per month</option>
                                <option value="per year" <?php echo $blog->pay_by == 'per year' ? 'selected' : ' '; ?>>per year</option>
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
                            <textarea name="image" style="position: absolute;top: -4000px;"><?php echo old('image'); ?></textarea>
                            <div class="fixed-edit-section">
                                @include('admin.partials.previewFileRender', [
                                    'file' => $blog->image,
                                    'relationType' => 'blogs.image',
                                    'relationId' => $blog->id,
                                ])
                            </div>
                        </div>
                    </div><br>
                    @error('image')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group ">
                    <label class="form-check-label" for="exampleInput">Start writing your post here. Add Images, Videos,
                        #hashtags and more</label>
                    <textarea id="editor1" name="description" placeholder="Write a text"><?php echo $blog->description; ?></textarea>
                    @error('description')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
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
                            <input class="form-control" type="text" name="phone"
                                placeholder="Enter your phone number" required value="<?php echo $blog->phone; ?>" />
                            @error('phone')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label>Email</label>
                            <input class="form-control" type="email" name="email" placeholder="Enter your email"
                                required value="<?php echo $blog->email; ?>" />
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
                            <input class="form-control" type="url" name="website"
                                placeholder="Enter your website url" value="<?php echo $blog->website; ?>" />
                            @error('website')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <label class="col-xs-12">Address</label>
                            <input class="form-control" type="text" name="address" placeholder="Enter your address"
                                value="<?php echo $blog->address; ?>" />
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
                            <input class="form-control form-control_twitter" type="url"
                                style="font-family:Arial, FontAwesome" placeholder="https://twitter.com/" name="twitter"
                                value="<?php echo $blog->twitter; ?>" />
                            @error('twitter')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <input class="form-control form-control_facebook" type="url"
                                style="font-family:Arial, FontAwesome" placeholder="https://www.facebook.com/"
                                name="facebook" value="{{ $blog->facebook }}" />
                            @error('facebook')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <input class="form-control form-control_instagram" type="url"
                                style="font-family:Arial, FontAwesome" placeholder="https://instagram.com/"
                                name="instagram" value="{{ $blog->instagram }}" />
                            @error('instagram')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <input class="form-control form-control_linkedin" type="url"
                                style="font-family:Arial, FontAwesome" placeholder="https://linkedin.com/"
                                name="linkedin" value="{{ $blog->linkedin }}" />
                            @error('linkedin')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <input class="form-control form-control_youtube" type="url"
                                style="font-family:Arial, FontAwesome" placeholder="https://youtube.com/" name="youtube"
                                value="{{ $blog->youtube }}" />
                            @error('youtube')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <input class="form-control form-control_whatsapp" type="text"
                                style="font-family:Arial, FontAwesome" placeholder="Enter you whatsApp number"
                                name="whatsapp" value="{{ $blog->whatsapp }}" />
                            @error('whatsapp')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

            </div>

            <div class="btn_section" >
                <button type="submit" class="btn btn-primary">Publish</button>
                <span class="hrrr" style="display:none;"><span>OR</span></span>
                <button type="button" class="btn btn-primary2" style="display:none;">Feature Post on the Homepage</button>
                <p style="text-align: center;margin-top: 20px;display:none;">Choose the best category that fits your needs and create a
                    post</p>
            </div>

        </form>
    </section>



    <!-- ==== Section End ==== -->
@endsection

@section('page_script')
    <script>
        var cate_id = "{{ @$selectedCategories[0] }}";

        $(document).ready(function() {
            console.log("ready!");
            if (cate_id == 4) {
                $(".business_cate").hide();
                $(".realstate_cate").show();
            } else {
                $(".realstate_cate").hide();
                $(".business_cate").show();
            }
        });
    </script>
@endsection
