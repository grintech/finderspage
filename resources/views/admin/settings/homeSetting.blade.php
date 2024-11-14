<?php use App\Models\Admin\HomeSettings; ?>
<?php use App\Models\Admin\Settings; ?>
@extends('layouts.adminlayout')
@section('content')
<div class="header bg-primary pb-6">
	<div class="container-fluid">
		<div class="header-body">
			<div class="row align-items-center py-4">
				<div class="col-lg-6 col-7">
					<h6 class="h2 text-white d-inline-block mb-0">Manage Home Page</h6>
				</div>
			</div>
			@include('admin.partials.flash_messages')
		</div>
	</div>
</div>
<!-- Page content -->
<div class="container-fluid mt--6">
	<div class="row form-group">
		<div class="col-xl-12 order-xl-1">
			<!-- ==== Section 1 ==== -->
			<!--!! FLAST MESSAGES !!-->
			@include('admin.partials.flash_messages')
			<div class="card">
				<div class="card-header">
					<div class="row align-items-center">
						<div class="col-12">
							<h3 class="mb-0">Header Top Bar</h3>
						</div>
					</div>
				</div>
				<div class="card-body">
					<form method="post" class="form-validation">
						<!--!! CSRF FIELD !!-->
						{{ @csrf_field() }}
						<div class="form-group">
							<label class="form-control-label" for="input-title">Sliding text</label>
							<input type="text" class="form-control" name="sliding_text" placeholder="" value="{{ HomeSettings::get('sliding_text') }}">
						</div>
						<div class="form-group">
							<p>
								<small>Use Font Awesome 5.0 for icons tag.</small>
								<br>
								<small><a href="https://fontawesome.com/v5/search" target="_blank">https://fontawesome.com/v5/search</a></small>
							</p>

						</div>
						<div class="row form-group">
							<div class="col-md-6 form-group">
								<label class="form-control-label" for="input-title">Social Icon</label>
								<input type="text" class="form-control" name="social_icon_1" placeholder="" value="{{ HomeSettings::get('social_icon_1') }}">
							</div>
							<div class="col-md-6 form-group">
								<label class="form-control-label" for="input-title">Social Link</label>
								<input type="text" class="form-control" name="social_link_1" placeholder="" value="{{ HomeSettings::get('social_link_1') }}">
							</div>
						</div>
						<div class="row form-group">
							<div class="col-md-6 form-group">
								<label class="form-control-label" for="input-title">Social Icon</label>
								<input type="text" class="form-control" name="social_icon_2" placeholder="" value="{{ HomeSettings::get('social_icon_2') }}">
							</div>
							<div class="col-md-6 form-group">
								<label class="form-control-label" for="input-title">Social Link</label>
								<input type="text" class="form-control" name="social_link_2" placeholder="" value="{{ HomeSettings::get('social_link_2') }}">
							</div>
						</div>
						<div class="row form-group">
							<div class="col-md-6 form-group">
								<label class="form-control-label" for="input-title">Social Icon</label>
								<input type="text" class="form-control" name="social_icon_3" placeholder="" value="{{ HomeSettings::get('social_icon_3') }}">
							</div>
							<div class="col-md-6 form-group">
								<label class="form-control-label" for="input-title">Social Link</label>
								<input type="text" class="form-control" name="social_link_3" placeholder="" value="{{ HomeSettings::get('social_link_3') }}">
							</div>
						</div>
						<div class="row form-group">
							<div class="col-md-6 form-group">
								<label class="form-control-label" for="input-title">Social Icon</label>
								<input type="text" class="form-control" name="social_icon_4" placeholder="" value="{{ HomeSettings::get('social_icon_4') }}">
							</div>
							<div class="col-md-6 form-group">
								<label class="form-control-label" for="input-title">Social Link</label>
								<input type="text" class="form-control" name="social_link_4" placeholder="" value="{{ HomeSettings::get('social_link_4') }}">
							</div>
						</div>
						<hr class="my-4">
						<button type="submit" class="float-right btn btn-primary">Submit</button>
					</form>
				</div>
			</div>
			<!-- ==== Section 2 ==== -->
			<div class="card">
				<div class="card-header">
					<div class="row align-items-center">
						<div class="col-8">
							<h3 class="mb-0">First Section</h3>
						</div>
					</div>
				</div>
				<div class="card-body">
					<form method="post" class="form-validation">
						<!--!! CSRF FIELD !!-->
						{{ @csrf_field() }}
						<div class="form-group">
							<label class="form-control-label" for="input-title">Title</label>
							<input type="text" class="form-control" name="main_title" placeholder="" value="{{ HomeSettings::get('main_title') }}">
						</div>
						<div class="form-group">
							<label class="form-control-label" for="input-title">Sub Text</label>
							<input type="text" class="form-control" name="short_description" placeholder="" value="{{ HomeSettings::get('short_description') }}">
						</div>
						<div class="form-group">
							<label class="form-control-label" for="input-title">Button Text</label>
							<input type="text" class="form-control" name="button" placeholder="" value="{{ HomeSettings::get('button') }}">
						</div>
						<div class="form-group">
							<label class="form-control-label" for="input-title">Button Link</label>
							<input type="text" class="form-control" name="button_link" placeholder="" value="{{ HomeSettings::get('button_link') }}">
						</div>
						<div class="form-group">
							<label class="form-control-label" for="input-first-name">Banner Image</label>
							<div 
								class="upload-image-section"
								data-type="image"
								data-path="homes"
								data-resize-large="500*445"
							>
								<div class="upload-section">
									<div class="button-ref mb-3">
										<button class="btn btn-icon btn-primary btn-lg" type="button">
							                <span class="btn-inner--icon"><i class="fas fa-upload"></i></span>
							                <span class="btn-inner--text">Upload Image</span>
						              	</button>
						              	@include('admin.partials.recommended_size', ['width' => '1500px', 'height' => "700px"])
						            </div>
						            <!-- PROGRESS BAR -->
									<div class="progress d-none">
					                  <div class="progress-bar bg-default" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
					                </div>
					            </div>
				                <!-- INPUT WITH FILE URL -->
				                <textarea class="d-none" name="image">{{ HomeSettings::get('image') }}</textarea>
				                <div class="show-section <?php echo !old('image') ? 'd-none' : "" ?>">
				                	@include('admin.partials.previewFileRender', ['file' => old('image') ])
				                </div>
				                <div class="fixed-edit-section clearfix">
				                	@include('admin.partials.previewFileRender', ['file' => HomeSettings::get('image'), 'relationType' => 'home_settings.image', 'relationId' => "" ])
				                </div>
							</div>
						</div>
						<hr class="my-4">
						<button type="submit" class="float-right btn btn-primary">Submit</button>
					</form>
				</div>
			</div>

			<div class="card">
				<div class="card-header">
					<div class="row align-items-center">
						<div class="col-8">
							<h3 class="mb-0">Second Section</h3>
						</div>
					</div>
				</div>
				<div class="card-body">
					<form method="post" class="form-validation">
						<!--!! CSRF FIELD !!-->
						{{ @csrf_field() }}
						<div class="form-group">
							<label class="form-control-label" for="input-title">Title</label>
							<input type="text" class="form-control" name="home_second_title" placeholder="" value="{{ HomeSettings::get('home_second_title') }}">
						</div>
						<div class="form-group">
							<label class="form-control-label" for="input-title">Sub Text</label>
							<input type="text" class="form-control" name="home_second_subtitle" placeholder="" value="{{ HomeSettings::get('home_second_subtitle') }}">
						</div>
						<div class="form-group">
							<label class="form-control-label" for="input-title">Button Text</label>
							<input type="text" class="form-control" name="home_second_button" placeholder="" value="{{ HomeSettings::get('home_second_button') }}">
						</div>
						<div class="form-group">
							<label class="form-control-label" for="input-title">Button Link</label>
							<input type="text" class="form-control" name="home_second_button_link" placeholder="" value="{{ HomeSettings::get('home_second_button_link') }}">
						</div>
						<div class="form-group">
							<label class="form-control-label" for="input-first-name">Featured Ads</label>
							<p class="text-warning">Featured Ads dynamic selection Coming Soon.</p>
						</div>
						<hr class="my-4">
						<button type="submit" class="float-right btn btn-primary">Submit</button>
					</form>
				</div>
			</div>
			<div class="card">
				<div class="card-header">
					<div class="row align-items-center">
						<div class="col-8">
							<h3 class="mb-0">Third Section</h3>
						</div>
					</div>
				</div>
				<div class="card-body">
					<form method="post" class="form-validation">
						<!--!! CSRF FIELD !!-->
						{{ @csrf_field() }}
						<div class="form-group">
							<label class="form-control-label" for="input-title">Title</label>
							<input type="text" class="form-control" name="home_third_title" placeholder="" value="{{ HomeSettings::get('home_third_title') }}">
						</div>
						<div class="form-group">
							<label class="form-control-label" for="input-first-name">Featured Ads</label>
							<p class="text-warning">Featured Ads dynamic selection Coming Soon.</p>
						</div>
						<hr class="my-4">
						<button type="submit" class="float-right btn btn-primary">Submit</button>
					</form>
				</div>
			</div>
			<div class="card">
				<div class="card-header">
					<div class="row align-items-center">
						<div class="col-8">
							<h3 class="mb-0">Forth Section</h3>
						</div>
					</div>
				</div>
				<div class="card-body">
					<form method="post" class="form-validation">
						<!--!! CSRF FIELD !!-->
						{{ @csrf_field() }}
						<div class="form-group">
							<label class="form-control-label" for="input-title">Title</label>
							<input type="text" class="form-control" name="home_forth_title" placeholder="" value="{{ HomeSettings::get('home_forth_title') }}">
						</div>
						<div class="form-group">
							<label class="form-control-label" for="input-first-name">Featured Ads</label>
							<p class="text-warning">Categories dynamic selection Coming Soon.</p>
						</div>
						<hr class="my-4">
						<button type="submit" class="float-right btn btn-primary">Submit</button>
					</form>
				</div>
			</div>
			<div class="card">
				<div class="card-header">
					<div class="row align-items-center">
						<div class="col-8">
							<h3 class="mb-0">Fifth Section</h3>
						</div>
					</div>
				</div>
				<div class="card-body">
					<form method="post" class="form-validation">
						<!--!! CSRF FIELD !!-->
						{{ @csrf_field() }}
						<div class="form-group">
							<label class="form-control-label" for="input-title">Title</label>
							<input type="text" class="form-control" name="home_testimonial_title" placeholder="" value="{{ HomeSettings::get('home_testimonial_title') }}">
						</div>
						<div class="form-group">
							<label class="form-control-label" for="input-title">Sub Text</label>
							<input type="text" class="form-control" name="home_testimonial_subtext" placeholder="" value="{{ HomeSettings::get('home_testimonial_subtext') }}">
						</div>
						<div class="form-group">
							<p class="text-warning"><a href="{{ route('admin.testimonials') }}">Click here to manage testimonial.</a></p>
						</div>
						<hr class="my-4">
						<button type="submit" class="float-right btn btn-primary">Submit</button>
					</form>
				</div>
			</div>
			<div class="card">
				<div class="card-header">
					<div class="row align-items-center">
						<div class="col-8">
							<h3 class="mb-0">Footer Section</h3>
						</div>
					</div>
				</div>
				<div class="card-body">
					<form method="post" class="form-validation">
						<!--!! CSRF FIELD !!-->
						{{ @csrf_field() }}
						<div class="form-group">
							<label class="form-control-label" for="input-title">Text</label>
							<input type="text" class="form-control" name="footer_link_title" placeholder="" value="{{ HomeSettings::get('footer_link_title') }}">
						</div>
						<div class="form-group add_menu_options_fields" data-name="quick_links_1">
							<label class="form-control-label">Quick Links 1</label>
							@php 
								$quickLinks1 = HomeSettings::get('quick_links_1');
								$quickLinks1 =  $quickLinks1 ? json_decode($quickLinks1, true) : []; 
							@endphp
							@if(isset($quickLinks1) && $quickLinks1)
							@foreach($quickLinks1 as $k => $p)
							<div class="custom_group_option">
							    <div class="left_options_form">
							        <div class="left_f_group">
							            <div class="form-group">
							                <input type="text" class="form-control" name="quick_links_1[{{ $k }}][menu_title]" value="{{ isset($p['menu_title']) && $p['menu_title'] ? $p['menu_title'] : '' }}" placeholder="Enter title" required="">
							                <label id="quick_links_1[{{ $k }}][menu_title]-error" for="quick_links_1[{{ $k }}][menu_title]"class="error"></label>
							            </div>
							        </div>
							        <div class="right_f_group">
							            <div class="form-group">
							                <input type="text" class="form-control" name="quick_links_1[{{ $k }}][menu_url]" value="{{ isset($p['menu_url']) && $p['menu_url'] ? $p['menu_url'] : '' }}" placeholder="Enter url" required="">
							                <label id="quick_links_1[{{ $k }}][menu_url]-error" for="quick_links_1[{{ $k }}][menu_url]" class="error"></label>
							            </div>
							        </div>
							    </div>
							    <div class="close_option remove">
							        <a href="javascript:;" class="remove_create_addons_options section1_remove_addons" data-title="Remove" data-toggle="tooltip"><i class="far fa-times"></i></a>
							    </div>
							    <div class="close_option add">
							        <a href="javascript:;" class="btn-options create_addons_options section1_create_addons" data-title="Add Item" data-toggle="tooltip"><i class="far fa-plus"></i></a>
							    </div> 
							</div>
							@endforeach
							@else
							<div class="custom_group_option">
							    <div class="left_options_form">
							        <div class="left_f_group">
							            <div class="form-group">
							                <input type="text" class="form-control" name="quick_links_1[0][menu_title]" value="" placeholder="Enter title" required="">
							                <label id="quick_links_1[0][menu_title]-error" for="quick_links_1[0][menu_title]" class="error"></label>
							            </div>
							        </div>
							        <div class="right_f_group">
							            <div class="form-group">
							                <input type="text" class="form-control" name="quick_links_1[0][menu_url]" value="" placeholder="Enter url" required="">
							                <label id="quick_links_1[0][menu_url]-error" for="quick_links_1[0][menu_url]" class="error"></label>
							            </div>
							        </div>
							    </div>
							    <div class="close_option remove">
							        <a href="javascript:;" class="remove_create_addons_options section1_remove_addons" data-title="Remove" data-toggle="tooltip"><i class="far fa-times"></i></a>
							    </div>
							    <div class="close_option add">
							        <a href="javascript:;" class="btn-options create_addons_options section1_create_addons" data-title="Add Item" data-toggle="tooltip"><i class="far fa-plus"></i></a>
							    </div> 
							</div>
							@endif
						</div>
						<div class="form-group add_menu_options_fields" data-name="quick_links_2">
							<label class="form-control-label">Quick Links 2</label>
							@php 
								$quickLinks1 = HomeSettings::get('quick_links_2');
								$quickLinks1 =  $quickLinks1 ? json_decode($quickLinks1, true) : []; 
							@endphp
							@if(isset($quickLinks1) && $quickLinks1)
							@foreach($quickLinks1 as $k => $p)
							<div class="custom_group_option">
							    <div class="left_options_form">
							        <div class="left_f_group">
							            <div class="form-group">
							                <input type="text" class="form-control" name="quick_links_2[{{ $k }}][menu_title]" value="{{ isset($p['menu_title']) && $p['menu_title'] ? $p['menu_title'] : '' }}" placeholder="Enter title" required="">
							                <label id="quick_links_2[{{ $k }}][menu_title]-error" for="quick_links_2[{{ $k }}][menu_title]"class="error"></label>
							            </div>
							        </div>
							        <div class="right_f_group">
							            <div class="form-group">
							                <input type="text" class="form-control" name="quick_links_2[{{ $k }}][menu_url]" value="{{ isset($p['menu_url']) && $p['menu_url'] ? $p['menu_url'] : '' }}" placeholder="Enter url" required="">
							                <label id="quick_links_2[{{ $k }}][menu_url]-error" for="quick_links_2[{{ $k }}][menu_url]" class="error"></label>
							            </div>
							        </div>
							    </div>
							    <div class="close_option remove">
							        <a href="javascript:;" class="remove_create_addons_options section1_remove_addons" data-title="Remove" data-toggle="tooltip"><i class="far fa-times"></i></a>
							    </div>
							    <div class="close_option add">
							        <a href="javascript:;" class="btn-options create_addons_options section1_create_addons" data-title="Add Item" data-toggle="tooltip"><i class="far fa-plus"></i></a>
							    </div> 
							</div>
							@endforeach
							@else
							<div class="custom_group_option">
							    <div class="left_options_form">
							        <div class="left_f_group">
							            <div class="form-group">
							                <input type="text" class="form-control" name="quick_links_2[0][menu_title]" value="" placeholder="Enter title" required="">
							                <label id="quick_links_2[0][menu_title]-error" for="quick_links_2[0][menu_title]" class="error"></label>
							            </div>
							        </div>
							        <div class="right_f_group">
							            <div class="form-group">
							                <input type="text" class="form-control" name="quick_links_2[0][menu_url]" value="" placeholder="Enter url" required="">
							                <label id="quick_links_2[0][menu_url]-error" for="quick_links_2[0][menu_url]" class="error"></label>
							            </div>
							        </div>
							    </div>
							    <div class="close_option remove">
							        <a href="javascript:;" class="remove_create_addons_options section1_remove_addons" data-title="Remove" data-toggle="tooltip"><i class="far fa-times"></i></a>
							    </div>
							    <div class="close_option add">
							        <a href="javascript:;" class="btn-options create_addons_options section1_create_addons" data-title="Add Item" data-toggle="tooltip"><i class="far fa-plus"></i></a>
							    </div> 
							</div>
							@endif
						</div>
						<h6 class="heading-small text-muted mb-4">Newsletter Information</h6>
							<div class="form-group">
								<label class="form-control-label" for="input-title">Title</label>
								<input type="text" class="form-control" name="footer_newsletter_title" placeholder="" value="{{ HomeSettings::get('footer_newsletter_title') }}">
							</div>
							<div class="form-group">
								<label class="form-control-label" for="input-title">Sub Text</label>
								<input type="text" class="form-control" name="footer_newsletter_text" placeholder="" value="{{ HomeSettings::get('footer_newsletter_text') }}">
							</div>
							<div class="form-group">
								<p class="text-warning"><a href="{{ route('admin.newsletter') }}">Click here to to see subscribers list.</a></p>
							</div>
						<hr class="my-4">
						<button type="submit" class="float-right btn btn-primary">Submit</button>
					</form>
				</div>
			</div>

		</div>
	</div>
</div>
@endsection