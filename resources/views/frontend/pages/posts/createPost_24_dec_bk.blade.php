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
      <form method="post" action="<?php echo route('post.create') ?>" class="form-validation">
        {{ @csrf_field() }}
        <div class="card">
            @include('admin.partials.flash_messages')
          <div class="form-group">
            <label for="exampleInput">Title *</label>
            <input type="text" class="form-control" id="exampleInputtext" name="title" placeholder="Enter post name" required value="{{ old('title') }}">
            @error('title')
                <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>

          <div class="form-group">
            <label for="exampleInput">Main Category *</label>
            <div class="categories-items">
                <?php foreach ($categories as $key => $value): 
                    $active = old('categories') && in_array($value->id, old('categories')) ? true : false;
                    ?>
                    <div class="category-item category-click <?php echo $active ? 'active' : '' ?>" data-id="<?php echo $value->id ?>">
                        <?php if($active):?>
                            <input type="hidden" name="categories[]" value="<?php echo $value->id ?>" />
                        <?php endif; ?>
                        <div class="category-img">
                          <img src="{{ General::renderImage($value->getResizeImagesAttribute(), 'original') }}" alt="Image" />
                          <i class="fas fa-check"></i>
                        </div>
                        <h6><?php echo $value->title ?></h6>
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
                <select multiple="multiple" id="myMulti2" name="sub_categories[]" class="form-control" required="required" data-selected="<?php echo old('sub_categories') ? implode(',',old('sub_categories')) : '' ?>">
                    <option value="">Please select your categories</option>
                </select>
            </div>
            <small id="myMulti2-error" class="text-danger"></small>
            @error('sub_categories')
                <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>

          <div class="form-group">
            <label class="form-check-label" for="exampleInput">Location<span style="font-weight: 400;"> (Choose specific location for feature ads)</span></label>
            <div class="radio">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="location" id="flexRadioDefault1" value="worldwide" <?php echo !old('location') || old('location') == 'worldwide' ? 'checked' : '' ?>>
                <label class="form-check-label" for="flexRadioDefault1">
                  Worldwide
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="location" id="flexRadioDefault2" value="multiple" <?php echo old('location') && old('location') == 'multiple' ? 'checked' : '' ?>>
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
              <label class="form-check-label" for="exampleInput">Choose your Choice</label>
              <select multiple="multiple" id="myMulti11" name="choices[]" class="form-control">
                <?php if(old('choices')): ?>
                    <?php foreach (old('choices') as $key => $value) {
                        echo '<option selected>'.$value.'</option>';
                    }
                endif; ?>
              </select>
                @error('choices')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
          </div>

          <div class="form-group ">
              <label class="form-check-label" for="exampleInput">Post Featured Image *</label><br>
              <div class="upload-btn-wrapper dynupload-section multiple-blocks" style="
    overflow: unset !important;">
                    <div 
                        class="upload-image-section"
                        data-type="image"
                        data-multiple="true"
                    >
                     <div class="show-section dynupload-section <?php echo !old('image') ? 'd-none' : "" ?>">
                            @include('admin.partials.previewFileRender', ['file' => old('image') ])
                        </div>
                        <div class="upload-section <?php echo old('image') ? 'd-none' : "" ?>">
                            <div class="button-ref mb-3">
                                <button class="btn btn-icon btn-primary btn-lg" type="button" style="width: 100%;height: 150px;opacity: 0;">
                                    <span class="btn-inner--icon"><i class="fas fa-upload"></i></span>
                                    <span class="btn-inner--text">Upload Image</span>
                                </button>
                            </div>
                            <!-- PROGRESS BAR -->
                            <div class="progress d-none">
                              <div class="progress-bar bg-default" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                            </div>
                        </div>
                      

                       
                        <!-- INPUT WITH FILE URL -->
                        <textarea name="image" style="position: absolute;top: -4000px;" required><?php echo old('image') ?></textarea>
                        
                    </div>
                </div><br>
                @error('image')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
          </div>

            <div class="form-group ">
                <label class="form-check-label" for="exampleInput">Start writing your post here. Add Images, Videos, #hashtags and more</label>
                <textarea id="editor1" name="description" placeholder="Write a text"><?php echo old('description') ?></textarea>
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
                        <input class="form-control" type="text" name="phone" placeholder="Enter your phone number" required  value="{{ old('phone') }}" />
                        @error('phone')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <div class="form-group">
                        <label>Email</label>
                        <input class="form-control" type="email" name="email"  placeholder="Enter your email" required value="{{ old('email') }}" />
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
                        <input class="form-control" type="url" name="website"  placeholder="Enter your website url"  value="{{ old('website') }}"/>
                        @error('website')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                  </div>
                  <div class="col-xs-12 col-sm-6">
                        <label class="col-xs-12">Address</label>
                        <input class="form-control" type="text" name="address" placeholder="Enter your address" value="{{ old('address') }}" />
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
                      <input class="form-control form-control_twitter" type="url" style="font-family:Arial, FontAwesome"  placeholder= "https://twitter.com/" name="twitter" value="{{ old('twitter') }}" />
                        @error('twitter')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                  </div>
                  <div class="col-xs-12 col-sm-6">              
                    <input class="form-control form-control_facebook" type="url" style="font-family:Arial, FontAwesome"  placeholder= "https://www.facebook.com/" name="facebook" value="{{ old('facebook') }}"/>
                    @error('facebook')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                  </div>
              </div>
            </div>
              
            <div class="form-group">
                <div class="row">         
                  <div class="col-xs-12 col-sm-6">                        
                      <input class="form-control form-control_instagram" type="url" style="font-family:Arial, FontAwesome"  placeholder= "https://instagram.com/" name="instagram" value="{{ old('instagram') }}"  />
                        @error('instagram')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                  </div>
                  <div class="col-xs-12 col-sm-6">              
                        <input class="form-control form-control_linkedin" type="url" style="font-family:Arial, FontAwesome"  placeholder= "https://linkedin.com/" name="linkedin" value="{{ old('linkedin') }}" />
                        @error('linkedin')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                  </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">          
                  <div class="col-xs-12 col-sm-6">                        
                      <input class="form-control form-control_youtube" type="url" style="font-family:Arial, FontAwesome"  placeholder= "https://youtube.com/" name="youtube" value="{{ old('youtube') }}"/>
                        @error('youtube')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                  </div>
                  <div class="col-xs-12 col-sm-6">              
                        <input class="form-control form-control_whatsapp" type="text" style="font-family:Arial, FontAwesome"  placeholder="Enter you whatsApp number" name="whatsapp" value="{{ old('whatsapp') }}"/>
                        @error('whatsapp')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                  </div>
                </div>
            </div>

        </div>

        <div  class="btn_section">
          <button type="submit" class="btn btn-primary">Publish</button>
          <span class="hrrr"><span>OR</span></span>
          <button type="button" class="btn btn-primary2">Feature Post on the Homepage</button>
          <p style="text-align: center;margin-top: 20px">Choose the best category that fits your needs and create a post</p>
        </div>

    </form>
</section>

<!-- ==== Section End ==== -->
@endsection

