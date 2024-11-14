@extends('layouts.frontlayout')

@section('content')
<div class="contact-header">
    <div class="container mt-5 d-flex justify-content-center">
        <div class="col-lg-8 col-md-8 get-in text-center">
            <h1 style="font-size: 32px;">Get in touch!</h1>
            <p>Fill out the contact form or simply send a message through chat box and will get back to you as soon possible.</p>
        </div>
    </div>
</div>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-8">
            <div class="contact-form">
                 <span>
                        @include('admin.partials.flash_messages')
                    </span>
                 <form action="{{url('/submit-enquiry')}}" method="post" enctype="multipart/form-data"> 
               
                    @csrf
                    <div class="row">
                            <div class="col-lg-6">
                                <div class="field">
                                    <div class="control has-icons-left">
                                        <input type="text" name="name" id="name" class="input" placeholder="Name" required>
                                            <span class="icon is-left">
                                                <i class="fa fa-user"></i>
                                            </span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-lg-6">
                                <div class="field">
                                    <div class="control has-icons-left">
                                        <input type="email" name="email" id="email" class="input" placeholder="Email" required>
                                            <span class="icon is-left">
                                                <i class="fa fa-envelope"></i>
                                            </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="field">
                                    <div class="control has-icons-left">
                                        <input type="tel" name="phone" id="phoneNumber" class="input" placeholder="Phone Number" required>
                                            <span class="icon is-left">
                                            <i class="bi bi-telephone-fill"></i>
                                            </span>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="col-lg-6">
                                <div class="field">
                                    <div class="input-group">
                                      <input type="file" name="file" class="form-control" id="inputGroupFile01">
                                    </div>
                                </div>
                            </div> -->

                            <div class="col-lg-6">
                                <div class="field">
                                    <div class="control has-icons-left">
                                        <input type="text" name="links" id="links" class="input" placeholder="Links">
                                            <span class="icon is-left">
                                            <i class="bi bi-globe"></i>
                                            </span>
                                    </div>
                                </div>
                            </div>
                               
                            <div class="field">
                                <textarea name="description" id="message" rows="5" class="textarea is-medium" placeholder="Message"></textarea>
                            </div>
                            <div class="form-group{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
                            <!-- <label class="col-md-4 control-label">Captcha</label> -->
                            <div class="col-md-6">
                                {!! app('captcha')->display() !!}
                                 @error('g-recaptcha-response')
                                    <span class="help-block">
                                        <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                    </span>
                                 @enderror
                            </div>
                            </div>
                            <div class="new-button">
                              <button type="submit" class="contact-from-button">Submit</button>
                            </div>
                   </div>
                </form>  
            </div>
        </div>
        <!-- <div class="col-lg-4 col-md-4">
            <div class="contact-right-sidebar">
                <div class="info-box">
                    <i class="fa fa-envelope"></i>
                    <a href="mailto:info@finder.com">Email:<Br>info@finder.com</a>
                </div>
                <div class="info-box">
                     <i class="bi bi-telephone-fill"></i>
                    <a href="tel:+02 1234 567;">Call:<br>+02 1234 567</a>
                </div>
                <div class="info-box">
                    <i class="fa fa-map"></i>
                    <a href="">Location:<br>102 street 2714 Don</a>
                </div>
            </div>
        </div> -->
    </div>
</div>

<script>
  // Get the input element by its ID
  const phoneNumberInput = document.getElementById("phoneNumber");

  // Add an event listener to the input element
  phoneNumberInput.addEventListener("input", function (e) {
    // Remove any non-numeric characters from the input value using a regular expression
    let numericValue = e.target.value.replace(/\D/g, "");

    // Ensure the numeric value does not exceed 12 characters
    if (numericValue.length > 10) {
      numericValue = numericValue.slice(0, 10);
    }

    // Update the input value with the cleaned numeric value
    e.target.value = numericValue;
  });
</script>

@endsection