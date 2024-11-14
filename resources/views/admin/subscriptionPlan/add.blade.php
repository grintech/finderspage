@extends('layouts.adminlayout')

@section('content')

<div class="container-fluid px-5">
 				<form method="post" action="{{route('sub-plan.save')}}" enctype="multipart/form-data" id="blog">
 					{{ @csrf_field() }}
                    <!-- Page Heading -->
                    <div class="d-sm-flex flex-column  mb-3">
                        <h1 class="h3 mb-0 text-gray-800 fw-bold">Create Subscription Plans</h1>
                    </div>
                    <span>
                    	@include('admin.partials.flash_messages')
                    </span>
                    <div class="row bg-white border-radius pb-4 p-3">

                        <div class="col-md-12 mb-4">
                            <label class="labels">Plan<sup>*</sup></label>
                            <select name="plan" class="form-control form-control-xs selectpicker"  data-size="7" data-live-search="true" data-title="Subscription plan" id="state_list" data-width="100%"  >
                                <option value="">Select Plan</option>
                                <option value="Weekly">Weekly</option>
                                <option value="Monthly">Monthly</option>
                                <option value="Three Month's">Three Month's</option>
                                <option value="Six Month's">Six Month's</option>
                                <option value="Yearly">Yearly</option>
                            </select>
                             <span class="error-message" id="title-error"></span>
                            @error('plan')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                         
                      
                    
                        <div class="col-md-12 mb-4">
                            <label class="labels">Pricing <sup>*</sup></label>
                            <input type="text" class="form-control" name="price" placeholder="Enter Price" value="<?php echo old('price'); ?>" >
                            <span class="error-message" id="title-error"></span>
                             @error('price')
                                <small class="text-danger">{{ $message }}</small>
                             @enderror
                        </div>


                        <div class="col-md-12 mb-4">
                            <label class="labels">No of feature listing <sup>*</sup></label>
                            <input type="text" class="form-control" name="feature_listing" placeholder="Enter feature listing" value="<?php echo old('feature_listing'); ?>" >
                            <span class="error-message" id="title-error"></span>
                             @error('feature_listing')
                                <small class="text-danger">{{ $message }}</small>
                             @enderror
                        </div>

                        <div class="col-md-12 mb-4">
                            <label class="labels">Slideshow for Posts <sup>*</sup></label>
                            <input type="number" class="form-control" name="slideshow" placeholder="Enter Price" value="<?php echo old('price'); ?>" >
                            <span class="error-message" id="title-error"></span>
                             @error('slideshow')
                                <small class="text-danger">{{ $message }}</small>
                             @enderror
                        </div>

                       <div>
                            <div class="mt-5 text-center"><button class="btn profile-button" type="submit">Publish</button></div> 
                        </div>
                        
                    
                        </div>
                        
            </form>
@endsection