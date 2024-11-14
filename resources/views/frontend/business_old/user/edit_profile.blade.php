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
</style>
<!-- Breadcrumb -->
<div class="breadcrumb-main">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <a href="#">Home</a> / Edit Profie
      </div>
    </div>
  </div>
</div>
<!-- //Breadcrumb -->

<div class="main_title black_title">
  <h3>Profile</h3>
</div>
<section class="form_section">
  <div class="container">
    <div class="row">
      <form method="post" action="{{url('/update-user-profile')}}/{{ $user->id }}" class="form-validation" enctype="multipart/form-data" id="edit_profile_form">
        {{ @csrf_field() }}
        <div class="card">
          @include('admin.partials.flash_messages')
          <div class="row">
            <div class="form_title black_title">
              <h3>Contact Detail</h3>
            </div>
            <div class="col-xs-12 col-sm-6">
              <label class="col-xs-12">Update Profile</label>
              <input accept="image/*" type='file' id="imgInp" name="dp" class="form-control up-img" style="line-height: 35px;" />
              @error('dp')
              <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>
            <div class="col-xs-12 col-sm-6">
              <div class="form-group mb-0">
                <label>Profile Image</label><br>
                <!-- <img id="blah" src="{{url('assets/images/profile')}}/{{$user->image}}" alt="image" style="width: 126px;" /> -->
                <!-- <img id="blah" src="../assets/images/profile/1671277154.jpg" alt="image" style="width: 100px;" /> -->
                <img id="blah" src="{{$user->image!= ''? url('assets/images/profile/'.$user->image):'front/images/user3.png'}}" width="61px" alt="">
                <!-- <img id="profile_view" src="{{url('/')}}" alt="image" style="width: 126px;"/> -->
              </div>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-xs-12 col-sm-6">
              <div class="form-group">
                <label>Name</label>
                <input class="form-control" type="text" name="name" id="name" placeholder="Enter your name" required value="{{ $user->first_name }}" />
                @error('phone')
                <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
            </div>
            <div class="col-xs-12 col-sm-6">
              <div class="form-group">
                <label>Email</label>
                <input class="form-control" type="email" name="email" id="email" placeholder="Enter your email" required value="{{ $user->email }}" />
                @error('email')
                <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
            </div>
          </div>

          <div class="form-group mb-0">
            <div class="row">
              <div class="col-xs-12 col-sm-6">
                <label class="col-xs-12">Website URL</label>
                <input class="form-control" type="text" name="website" id="website" placeholder="Enter your website url" value="{{ $user->business_website }}" />
                @error('website')
                <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
              <div class="col-xs-12 col-sm-6">
                <div class="form-group">
                  <label>Phone Number</label>
                  <input class="form-control" type="text" name="phone" id="phone" maxlength="10" placeholder="Enter your phone number" required value="{{ $user->phonenumber }}" />
                  @error('phone')
                  <small class="text-danger">{{ $message }}</small>
                  @enderror
                </div>
              </div>
            </div>
          </div>
          <div class="form-group mb-0">
            <div class="row">
              <div class="col-xs-12 col-sm-6">
                <label class="col-xs-12">Address</label>
                <input class="form-control" type="text" name="address" id="address" placeholder="Enter your address" value="{{ $user->address }}" />
                @error('address')
                <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
              <div class="col-xs-12 col-sm-6">
                <div class="form-group">
                  <label>Individual Categories</label>
                  <select name="category" class="form-control" value='{{$user->role_category}}'>
                    <option class="form-control">Select Options</option>
                    @foreach($category as $cat)
                    <option value="{{$cat->category}}"   <?php if ($user->role_category == $cat->category) echo "selected='selected'";?> >{{$cat->category}}</option>
                    @endforeach
                  </select>
                  @error('category')
                  <small class="text-danger">{{ $message }}</small>
                  @enderror
                </div>
              </div>
            </div>
          </div>
        </div>
        </div>
        <div class="btn_section">
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</section>
<!-- ==== Section End ==== -->
<script type="text/javascript">
  imgInp.onchange = evt => {
    const [file] = imgInp.files
    if (file) {
      blah.src = URL.createObjectURL(file)
    }
  }
</script>
@endsection
