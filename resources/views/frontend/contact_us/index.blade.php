@extends('layouts.frontlayout')

@section('content')

<style>

  .upload-btn-wrapper.dynupload-section{

    width: 100%!important;

    height:auto;

    border:none!important;

    background:inherit!important;

    border-radius: 0!important;

}

.upload-btn-wrapper.dynupload-section .single-image{

    border-radius:3px;

}

  </style>

<!-- Breadcrumb -->

<div class="breadcrumb-main">

  <div class="container">

    <div class="row">

      <div class="col-12">

        <a href="#">Home</a> / Contact Us

      </div>

    </div>

  </div>

</div>

<!-- //Breadcrumb -->

    

<div class="main_title black_title">

    <h3>Contact Us</h3>

</div>

<section class="form_section">    

      <form method="post" action="{{url('/submit-enquiry')}}/{{ $post_id }}" class="form-validation" enctype="multipart/form-data">

        {{ @csrf_field() }} 

        <div class="card">

          @include('admin.partials.flash_messages')

            <div class="row">   

                <div class="form_title black_title">                 

                </div>

                <div class="col-xs-12 col-sm-6">

                    <div class="form-group">

                        <label>Name</label>

                        <input class="form-control" type="text" name="name" placeholder="Enter your name" required  value="" />

                        @error('name')

                            <small class="text-danger">{{ $message }}</small>

                        @enderror

                    </div>

                </div>

                <div class="col-xs-12 col-sm-6">

                    <div class="form-group">

                        <label>Email</label>

                        <input class="form-control" type="email" name="email"  placeholder="Enter your email" required value="" />

                        @error('email')

                            <small class="text-danger">{{ $message }}</small>

                        @enderror

                    </div>

                </div>

            </div>

            <div class="row">   

                <div class="col-xs-12 col-sm-6">

                    <div class="form-group">

                        <label>Phone Number</label>

                        <input class="form-control" type="text" name="phone" placeholder="Enter your phone number" required  value="{{ old('phone') }}" />

                        @error('phone')

                            <small class="text-danger">{{ $message }}</small>

                        @enderror

                    </div>

                </div>

                <div class="col-xs-12 col-sm-6">  

                  <div class="form-group">

                    <label>Upload File</label>

                      <input type="file" name="file">  

                    </div>         

                </div>

            </div>

            <div class="form-group ">

              <div class="row">

                  <div class="form-group ">

                      <label class="form-check-label" for="exampleInput">Enter your Message/Enquiry</label>

                      <textarea id="editor1" name="description" placeholder="Write a text"><?php echo old('description') ?></textarea>

                      @error('description')

                          <small class="text-danger">{{ $message }}</small>

                      @enderror

                  </div>

              </div>

            </div>

        </div>

        <div  class="btn_section">

          <button type="submit" class="btn btn-primary">Submit</button>

        </div>

    </form>

</section>



<!-- ==== Section End ==== -->

@endsection



