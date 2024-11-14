@extends('layouts.frontlayout')
@section('content')
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

  .step {
    display: none;
  }

  .step.active {
    display: block;
    width: 900px;
  }
</style>
<!-- Breadcrumb -->
<div class="breadcrumb-main">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <a href="#">Home</a> / Edit Business Page
      </div>
    </div>
  </div>
</div>
<!-- //Breadcrumb -->

<div class="main_title black_title">
  <h3>Business Page</h3>
</div>
<section class="form_section">
  <form method="post" action="{{url('/update-business-profile')}}/{{ $user->id }}" class="form-validation" enctype="multipart/form-data">
    {{ @csrf_field() }}
    <div class="card step step-1 active">
      @include('admin.partials.flash_messages')
      <div class="row">
        <div class="form_title black_title">
          <h3>Business Detail</h3>
        </div>
        <div class="col-xs-12 col-sm-6">
          <label class="col-xs-12">Business Profile</label>
          <input accept="image/*" type='file' id="imgInp" name="business_dp" class="form-control" />
          @error('dp')
          <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>
        <div class="col-xs-12 col-sm-6">
          <div class="form-group">
            <label>Business Image</label>
            <img id="blah" src="{{url('/assets/images/business/')}}/{{$user->business_images}}" alt="image" style="width: 126px;" />
          </div>
        </div>
      </div>
      <hr>
      <div class="row">
        <div class="col-xs-12 col-sm-6">
          <div class="form-group">
            <label>Business Name</label>
            <input class="form-control" type="text" name="business_name" placeholder="Enter your name" required value="{{ $user->business_name }}" />
            @error('business_name')
            <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>
        </div>
        <div class="col-xs-12 col-sm-6">
          <div class="form-group">
            <label>Business Email</label>
            <input class="form-control" type="email" name="business_email" placeholder="Enter your email" required value="{{ $user->business_email }}" />
            @error('business_email')
            <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>
        </div>
      </div>

      <div class="form-group ">
        <div class="row">
          <div class="col-xs-12 col-sm-6">
            <label class="col-xs-12">Business Website URL</label>
            <input class="form-control" type="text" name="business_website" placeholder="Enter your website url" value="{{ $user->business_website }}" />
            @error('business_website')
            <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>
          <div class="col-xs-12 col-sm-6">
            <div class="form-group">
              <label>Business Phone Number</label>
              <input class="form-control" type="text" name="business_phone" placeholder="Enter your phone number" required value="{{ $user->business_phone }}" />
              @error('business_phone')
              <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>
          </div>
        </div>
      </div>
      <div class="form-group ">
        <div class="row">
          <div class="col-xs-12 col-sm-6">
            <label class="col-xs-12">Business Address</label>
            <input class="form-control" type="text" name="business_address" placeholder="Enter your address" value="{{ $user->business_address }}" />
            @error('business_address')
            <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>
          <div class="col-xs-12 col-sm-6">
            <label class="col-xs-12" for="exampleInput">Business Category</label>
            <select class="form-select" id="search-box" name="role_category[]" placeholder="Enter business name" required multiple>
              @php
              $role = json_decode($user->role_category);
              @endphp
              @if (!is_null($role))
              @foreach ($role as $roles)
              <option selected>{{ $roles }}</option>
              @endforeach
              @endif
            </select>
            @error('role_category')
            <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>
        </div>
      </div>

      <div class="hour_slt">
        <div class="row">
          <label for="exampleInput">Hours </label>
          <div class="col-lg-4">
            <label for="exampleInput">Monday </label>
          </div>
          <div class="col-lg-4">
            <select class="form-select" aria-label="Default select example" name="mon_am">
              @if($user->mon_am != 0)
              <option value="{{ $user->mon_am }}">{{ $user->mon_am }}</option>
              @endif
              @include('frontend.business.business_hours')
            </select>
          </div>
          <div class="col-lg-4">
            <select class="form-select" aria-label="Default select example" name="mon_pm">
              @if($user->mon_pm != 0)
              <option value="{{ $user->mon_pm }}">{{ $user->mon_pm }}</option>
              @endif
              @include('frontend.business.business_hours')
            </select>
          </div>
          <div class="col-lg-4">
            <label for="exampleInput">Tuesday </label>
          </div>
          <div class="col-lg-4">
            <select class="form-select" aria-label="Default select example" name="tue_am">
              @if($user->tue_am != 0)
              <option value="{{ $user->tue_am }}">{{ $user->tue_am }}</option>
              @endif
              @include('frontend.business.business_hours')
            </select>
          </div>
          <div class="col-lg-4">
            <select class="form-select" aria-label="Default select example" name="tue_pm">
              @if($user->tue_pm != 0)
              <option value="{{ $user->tue_pm }}">{{ $user->tue_pm }}</option>
              @endif
              @include('frontend.business.business_hours')
            </select>
          </div>
          <div class="col-lg-4">
            <label for="exampleInput">Wednesday </label>
          </div>
          <div class="col-lg-4">
            <select class="form-select" aria-label="Default select example" name="wed_am">
              @if($user->wed_am != 0)
              <option value="{{ $user->wed_am }}">{{ $user->wed_am }}</option>
              @endif
              @include('frontend.business.business_hours')
            </select>
          </div>
          <div class="col-lg-4">
            <select class="form-select" aria-label="Default select example" name="wed_pm">
              @if($user->wed_pm != 0)
              <option value="{{ $user->wed_pm }}">{{ $user->wed_pm }}</option>
              @endif
              @include('frontend.business.business_hours')

            </select>
          </div>
          <div class="col-lg-4">
            <label for="exampleInput">Thursday </label>
          </div>
          <div class="col-lg-4">
            <select class="form-select" aria-label="Default select example" name="thur_am">
              @if($user->thur_am != 0)
              <option value="{{ $user->thur_am }}">{{ $user->thur_am }}</option>
              @endif
              @include('frontend.business.business_hours')
            </select>
          </div>
          <div class="col-lg-4">
            <select class="form-select" aria-label="Default select example" name="thur_pm">
              @if($user->wed_pm != 0)
              <option value="{{ $user->thur_pm }}">{{ $user->thur_pm }}</option>
              @endif
              @include('frontend.business.business_hours')
            </select>
          </div>
          <div class="col-lg-4">
            <label for="exampleInput">Friday </label>
          </div>
          <div class="col-lg-4">
            <select class="form-select" aria-label="Default select example" name="fri_am">
              @if($user->fri_am != 0)
              <option value="{{ $user->fri_am }}">{{ $user->fri_am }}</option>
              @endif
              @include('frontend.business.business_hours')
            </select>
          </div>
          <div class="col-lg-4">
            <select class="form-select" aria-label="Default select example" name="fri_pm">
              @if($user->fri_pm != 0)
              <option value="{{ $user->fri_pm }}">{{ $user->fri_pm }}</option>
              @endif
              @include('frontend.business.business_hours')
            </select>
          </div>
          <div class="col-lg-4">
            <label for="exampleInput">Saturday </label>
          </div>
          <div class="col-lg-4">
            <select class="form-select" aria-label="Default select example" name="sat_am">
              @if($user->sat_am != '0')
              <option value="{{ $user->sat_am }}">{{ $user->sat_am }}</option>
              @endif
              @include('frontend.business.business_hours')
            </select>
          </div>
          <div class="col-lg-4">
            <select class="form-select" aria-label="Default select example" name="sat_pm">
              @if($user->sat_pm != '0')
              <option value="{{ $user->sat_pm }}">{{ $user->sat_pm }}</option>
              @endif
              @include('frontend.business.business_hours')
            </select>
          </div>
          <div class="col-lg-4">
            <label for="exampleInput">Sunday </label>
          </div>
          <div class="col-lg-4">
            <select class="form-select" aria-label="Default select example" name="sun_am">.
              @if($user->sun_am != '0')
              <option value="{{ $user->sun_am }}">{{ $user->sun_am }}</option>
              @endif
              @include('frontend.business.business_hours')
            </select>
          </div>
          <div class="col-lg-4">
            <select class="form-select" aria-label="Default select example" name="sun_pm">
              @if($user->sun_pm != '0')
              <option value="{{ $user->sun_pm }}">{{ $user->sun_pm }}</option>
              @endif
              @include('frontend.business.business_hours')
            </select>
          </div>
        </div>
      </div>
      <button type="button" class="next-btn btn btn-primary">Next</button>
    </div>
    <div class="card step step-2">
      <div class="from-group">
        <label class="col-xs-12">Accessibility</label>
        <div class="row">
          <div class="col-xs-12 col-sm-6">
            <div class="row">
            <div class="col col-lg-8"> Is open to All Business </div>
              <div class="col col-sm-auto"><input class="form-check-input" type="radio" name="all_business" value="yes" id="" <?php if($user->all_business == 'yes') echo "checked"; ?>/>Yes</div>
              <div class="col"><input class="form-check-input" type="radio" name="all_business" value="no" id=""  <?php if($user->all_business == 'no') echo "checked"; ?>/>No</div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-6">
            <div class="row mx-md-n5">
              <div class="col col-lg-8">Is Wheelchair Accessible </div>
              <div class="col col-sm-auto"><input class="form-check-input" type="radio" name="wheelchair" value="yes" id="" <?php if($user->wheelchair == 'yes') echo "checked"; ?>/>Yes</div>
              <div class="col"><input class="form-check-input" type="radio" name="wheelchair" value="no" id="" <?php if($user->wheelchair == 'no') echo "checked"; ?>/>No</div>
            </div>
          </div>
        </div>
      </div>
      <hr>
      <div class="from-group mt-4">
        <label class="col-xs-12">Diversity</label>
        <div class="row">
          <div class="col-xs-12 col-sm-6">
            <div class="row mx-md-n5">
              <div class="col col-lg-8">Black-owned </div>
              <div class="col col-sm-auto"><input class="form-check-input" type="radio" name="black_owned" value="yes" id="" <?php if($user->black_owned == 'yes') echo "checked"; ?>/>Yes</div>
              <div class="col"><input class="form-check-input" type="radio" name="black-owned" value="no" id="" <?php if($user->black_owned == 'no') echo "checked"; ?>/>No</div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-6">
            <div class="row mx-md-n5">
              <div class="col col-lg-8">Latinx-owned </div>
              <div class="col col-sm-auto"><input class="form-check-input" type="radio" name="latinx_owned" value="yes" id="" <?php if($user->latinx_owned == 'yes') echo "checked"; ?>/>Yes</div>
              <div class="col"><input class="form-check-input" type="radio" name="latinx-owned" value="no" id="" <?php if($user->latinx_owned == 'no') echo "checked"; ?>/>No</div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-6">
            <div class="row mx-md-n5">
              <div class="col col-lg-8">Women-owned </div>
              <div class="col col-sm-auto"><input class="form-check-input" type="radio" name="women_owned" value="yes" id="" <?php if($user->women_owned == 'yes') echo "checked"; ?>/>Yes</div>
              <div class="col"><input class="form-check-input" type="radio" name="women_owned" value="no" id=""  <?php if($user->women_owned == 'no') echo "checked"; ?>/>No</div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-6">
            <div class="row mx-md-n5">
              <div class="col col-lg-8">Asian-owned </div>
              <div class="col col-sm-auto"><input class="form-check-input" type="radio" name="asian_owned" value="yes" id=""  <?php if($user->asian_owned == 'yes') echo "checked"; ?>/>Yes</div>
              <div class="col"><input class="form-check-input" type="radio" name="asian_owned" value="no" id="" <?php if($user->asian_owned == 'no') echo "checked"; ?>/>No</div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-6">
            <div class="row mx-md-n5">
              <div class="col col-lg-8">LGBTQ-owned </div>
              <div class="col col-sm-auto"><input class="form-check-input" type="radio" name="lgbtq_owned" value="yes" id="" <?php if($user->lgbtq_owned == 'yes') echo "checked"; ?>/>Yes</div>
              <div class="col"><input class="form-check-input" type="radio" name="lgbtq_owned" value="no" id="" <?php if($user->lgbtq_owned == 'no') echo "checked"; ?>/>No</div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-6">
            <div class="row mx-md-n5">
              <div class="col col-lg-8">Veteran-owned </div>
              <div class="col col-sm-auto"><input class="form-check-input" type="radio" name="veteran_owned" value="yes" id="" <?php if($user->veteran_owned == 'yes') echo "checked"; ?>/>Yes</div>
              <div class="col"><input class="form-check-input" type="radio" name="veteran_owned" value="no" id="" <?php if($user->veteran_owned == 'no') echo "checked"; ?>/>No</div>
            </div>
          </div>
        </div>
      </div>
      <hr>
      <div class="from-group mt-4">
        <label class="col-xs-12">Eco-friendly</label>
        <div class="row">
          <div class="col-xs-12 col-sm-6">
            <div class="row mx-md-n5">
              <div class="col col-lg-8">Has Bike Parking </div>
              <div class="col col-sm-auto"><input class="form-check-input" type="radio" name="bike_parking" value="yes" id="" <?php if($user->bike_parking == 'yes') echo "checked"; ?>/>Yes</div>
              <div class="col"><input class="form-check-input" type="radio" name="bike_parking" value="no" id="" <?php if($user->bike_parking == 'no') echo "checked"; ?>/>No</div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-6">
            <div class="row mx-md-n5">
              <div class="col col-lg-8">EV charging station available </div>
              <div class="col col-sm-auto"><input class="form-check-input" type="radio" name="ev_charging" value="yes" id="" <?php if($user->ev_charging == 'yes') echo "checked"; ?>/>Yes</div>
              <div class="col"><input class="form-check-input" type="radio" name="ev_charging" value="no" id="" <?php if($user->ev_charging == 'no') echo "checked"; ?>/>No</div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-6">
            <div class="row mx-md-n5">
              <div class="col col-lg-8">Plastic-free packaging </div>
              <div class="col col-sm-auto"><input class="form-check-input" type="radio" name="plastic_free" value="yes" id="" <?php if($user->plastic_free == 'yes') echo "checked"; ?>/>Yes</div>
              <div class="col"><input class="form-check-input" type="radio" name="plastic_free" value="no" id="" <?php if($user->plastic_free == 'no') echo "checked"; ?>/>No</div>
            </div>
          </div>
        </div>
      </div>
      <hr>
      <div class="from-group mt-4">
        <label class="col-xs-12">Health & Safety</label>
        <div class="row mx-md-n5">
          <div class="col-xs-12 col-sm-6">
            <div class="row">
              <div class="col col-lg-8">Proof of vaccination required </div>
              <div class="col col-sm-auto"><input class="form-check-input" type="radio" name="vaccination_required" value="yes" id="" <?php if($user->vaccination_required == 'yes') echo "checked"; ?>/>Yes</div>
              <div class="col"><input class="form-check-input" type="radio" name="vaccination_required" value="no" id="" <?php if($user->vaccination_required == 'no') echo "checked"; ?>/>No</div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-6">
            <div class="row mx-md-n5">
              <div class="col col-lg-8">All staff fully vaccinated </div>
              <div class="col col-sm-auto"><input class="form-check-input" type="radio" name="fully_vaccinated" value="yes" id="" <?php if($user->fully_vaccinated == 'yes') echo "checked"; ?>/>Yes</div>
              <div class="col"><input class="form-check-input" type="radio" name="fully_vaccinated" value="no" id="" <?php if($user->fully_vaccinated == 'no') echo "checked"; ?>/>No</div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-6">
            <div class="row mx-md-n5">
              <div class="col col-lg-8">Masks required </div>
              <div class="col col-sm-auto"><input class="form-check-input" type="radio" name="masks_required" value="yes" id="" <?php if($user->masks_required == 'yes') echo "checked"; ?>/>Yes</div>
              <div class="col"><input class="form-check-input" type="radio" name="masks_required" value="no" id="" <?php if($user->masks_required == 'no') echo "checked"; ?>/>No</div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-6">
            <div class="row mx-md-n5">
              <div class="col col-lg-8">Staff wears masks</div>
              <div class="col col-sm-auto"><input class="form-check-input" type="radio" name="staff_wears_masks" value="yes" id="" <?php if($user->staff_wears_masks == 'yes') echo "checked"; ?>/>Yes</div>
              <div class="col"><input class="form-check-input" type="radio" name="staff_wears_masks" value="no" id="" <?php if($user->staff_wears_masks == 'no') echo "checked"; ?>/>No</div>
            </div>
          </div>
        </div>
      </div>
      <hr>
      <div class="from-group mt-4">
        <label class="col-xs-12">Payment options</label>
        <div class="row">
          <div class="col-xs-12 col-sm-6">
            <div class="row">
              <div class="col col-lg-8">Accepts Android Pay </div>
              <div class="col col-sm-auto"><input class="form-check-input" type="radio" name="android_pay" value="yes" id="" <?php if($user->android_pay == 'yes') echo "checked"; ?>/>Yes</div>
              <div class="col"><input class="form-check-input" type="radio" name="android_pay" value="no" id="" <?php if($user->android_pay == 'no') echo "checked"; ?>/>No</div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-6">
            <div class="row">
              <div class="col col-lg-8">Accepts Apple Pay </div>
              <div class="col col-sm-auto"><input class="form-check-input" type="radio" name="apple_pay" value="yes" id="" <?php if($user->apple_pay == 'yes') echo "checked"; ?>/>Yes</div>
              <div class="col"><input class="form-check-input" type="radio" name="apple_pay" value="no" id="" <?php if($user->apple_pay == 'no') echo "checked"; ?>/>No</div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-6">
            <div class="row">
              <div class="col col-lg-8">Accepts Credit Cards </div>
              <div class="col col-sm-auto"><input class="form-check-input" type="radio" name="credit_card" value="yes" id="" <?php if($user->credit_card == 'yes') echo "checked"; ?>/>Yes</div>
              <div class="col"><input class="form-check-input" type="radio" name="credit_card" value="no" id="" <?php if($user->credit_card == 'no') echo "checked"; ?>/>No</div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-6">
            <div class="row">
              <div class="col col-lg-8">Accepts Cryptocurrency </div>
              <div class="col col-sm-auto"><input class="form-check-input" type="radio" name="cryptocurrency" value="yes" id="" <?php if($user->cryptocurrency == 'yes') echo "checked"; ?>/>Yes</div>
              <div class="col"><input class="form-check-input" type="radio" name="cryptocurrency" value="no" id="" <?php if($user->cryptocurrency == 'no') echo "checked"; ?>/>No</div>
            </div>
          </div>
        </div>
      </div>
      <hr>
      <div class="from-group mt-4">
        <label class="col-xs-12">Reservations</label>
        <div class="row">
          <div class="col-xs-12 col-sm-6">
            <div class="row">
              <div class="col col-lg-8">Offers Waitlist Reservations </div>
              <div class="col col-sm-auto"><input class="form-check-input" type="radio" name="waitlist_reservations" value="yes" id="" <?php if($user->waitlist_reservations == 'yes') echo "checked"; ?>/>Yes</div>
              <div class="col"><input class="form-check-input" type="radio" name="waitlist_reservations" value="no" id="" <?php if($user->waitlist_reservations == 'no') echo "checked"; ?>/>No</div>
            </div>
          </div>
        </div>
      </div>
      <hr>
      <div class="from-group mt-4">
        <label class="col-xs-12">Services</label>
        <div class="row">
          <div class="col-xs-12 col-sm-6">
            <div class="row">
              <div class="col col-lg-8">Offers Online Ordering </div>
              <div class="col col-sm-auto"><input class="form-check-input" type="radio" name="online_ordering" value="yes" id="" <?php if($user->online_ordering == 'yes') echo "checked"; ?>/>Yes</div>
              <div class="col"><input class="form-check-input" type="radio" name="online_ordering" value="no" id="" <?php if($user->online_ordering == 'no') echo "checked"; ?>/>No</div>
            </div>
          </div>
        </div>
      </div>
      <hr>
      <div class="from-group mt-4">
        <label class="col-xs-12">Other</label>
        <div class="row">
          <div class="col-xs-12 col-sm-6">
            <div class="row">
              <div class="col col-lg-8">Dogs Allowed </div>
              <div class="col col-sm-auto"><input class="form-check-input" type="radio" name="dogs_allowed" value="yes" id="" <?php if($user->dogs_allowed == 'yes') echo "checked"; ?>/>Yes</div>
              <div class="col"><input class="form-check-input" type="radio" name="dogs_allowed" value="no" id="" <?php if($user->dogs_allowed == 'no') echo "checked"; ?>/>No</div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-6">
            <div class="row">
              <div class="col col-lg-8">Offers Military Discount </div>
              <div class="col col-sm-auto"><input class="form-check-input" type="radio" name="military" value="yes" id="" <?php if($user->military == 'yes') echo "checked"; ?>/>Yes</div>
              <div class="col"><input class="form-check-input" type="radio" name="military" value="no" id="" <?php if($user->military == 'no') echo "checked"; ?>/>No</div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-6">
            <div class="row">
              <div class="col col-lg-8">Offers Flower Delivery </div>
              <div class="col col-sm-auto"><input class="form-check-input" type="radio" name="flower_delivery" value="yes" id="" <?php if($user->flower_delivery == 'yes') echo "checked"; ?>/>Yes</div>
              <div class="col"><input class="form-check-input" type="radio" name="flower_delivery" value="no" id="" <?php if($user->flower_delivery == 'no') echo "checked"; ?>/>No</div>
            </div>
          </div>
        </div>
      </div>


    </div>
    <div class="btn_section">
      <button type="submit" class="btn btn-primary">Save</button>
    </div>
  </form>
</section>
<!-- ==== Section End ==== -->
<script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script>
  $(document).ready(function() {
    $('#search-box').select2({
      placeholder: 'Select Business',
      ajax: {
        url: "{{url('/checking')}}",
        dataType: 'json',
        delay: 250,
        data: function(params) {
          return {
            q: $.trim(params.term),
          };
        },
        processResults: function(data) {
          return {
            results: $.map(data, function(item) {
              return {
                text: item.category,
                id: item.category
              }
            })
          };
        },
        cache: true
      }
    });

    // $.ajax({
    //   type:'get',
    //   url: "{{url('/selectfor')}}",
    //   data : {id:'{{$user->id}}'},
    //   success:function(data){
    //     console.log(data);
    //   }
    // })

  });
</script>
<script type="text/javascript">
  imgInp.onchange = evt => {
    const [file] = imgInp.files
    if (file) {
      blah.src = URL.createObjectURL(file)
    }
  }


  const steps = Array.from(document.querySelectorAll("form .step"));
  const nextBtn = document.querySelectorAll("form .next-btn");
  const prevBtn = document.querySelectorAll("form .previous-btn");
  const form = document.querySelector("form");



  nextBtn.forEach((button) => {
    button.addEventListener("click", () => {
      changeStep("next");
    });
  });
  prevBtn.forEach((button) => {
    button.addEventListener("click", () => {
      changeStep("prev");
    });
  });



  form.addEventListener("submit", (e) => {
    e.preventDefault();
    const inputs = [];
    form.querySelectorAll("input").forEach((input) => {
      const {
        name,
        value
      } = input;
      inputs.push({
        name,
        value
      });
    });
    console.log(inputs);
    form.submit();
  });

  function changeStep(btn) {
    let index = 0;
    const active = document.querySelector(".active");
    index = steps.indexOf(active);
    console.log(index);
    console.log(steps[index]);
    steps[index].classList.remove("active");
    if (btn === "next") {
      index++;
    } else if (btn === "prev") {
      index--;
    }
    steps[index].classList.add("active");
  }
</script>
@endsection