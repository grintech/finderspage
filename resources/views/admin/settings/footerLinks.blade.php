<?php use App\Models\Admin\Settings; ?>
@extends('layouts.adminlayout')
@section('content')
<div class="header bg-primary pb-6">
	<div class="container-fluid">
		<div class="header-body">
			<div class="row align-items-center py-4">
				<div class="col-lg-6 col-7">
					<h6 class="h2 text-white d-inline-block mb-0">Footer Settings</h6>

				</div>
			</div>
			@include('admin.partials.flash_messages')
		</div>
	</div>
</div>
<!-- Page content -->
<div class="container-fluid mt--6">
	<div class="row">
		<div class="col-xl-12">
			<div class="card">
				<!--!! FLAST MESSAGES !!-->
				
				<div class="card-header">
					<div class="row align-items-center">
						<div class="col-8">
							<h3 class="mb-0">Footer Content.</h3>
						</div>
					</div>
				</div>
				<div class="card-body">
					<form method="post" action="<?php echo route('admin.settings.footerLinks') ?>" class="form-validation">
						<!--!! CSRF FIELD !!-->
						{{ @csrf_field() }}
						<h6 class="heading-small text-muted mb-4">Newsletter Section</h6>
						<div class="pl-lg-4">
							<div class="form-group">
								<label class="form-control-label" for="input-first-name">Title</label>
								<input type="text" class="form-control" name="newsletter_title" required value="{{ Settings::get('newsletter_title') }}">
								@error('newsletter_title')
								    <small class="text-danger">{{ $message }}</small>
								@enderror
							</div>
							<div class="form-group">
								<label class="form-control-label" for="input-first-name">Description</label>
								<input type="text" class="form-control" name="newsletter_description" required value="{{ Settings::get('newsletter_description') }}">
								@error('newsletter_description')
								    <small class="text-danger">{{ $message }}</small>
								@enderror
							</div>
						</div>
						<hr class="my-4" />
						<!-- Address -->
						<h6 class="heading-small text-muted mb-4">Social, Logo & Description</h6>
						<div class="pl-lg-4">
							<div class="form-group">
								<label class="form-control-label" for="input-first-name">Description</label>
								<input type="text" class="form-control" name="footer_description" required value="{{ Settings::get('footer_description') }}">
								@error('footer_description')
								    <small class="text-danger">{{ $message }}</small>
								@enderror
							</div>
							<div class="form-group">
								<div class="col-md-6">
									<div class="form-group">

										<label class="form-control-label" for="input-first-name">Logo</label>
										<div 
											class="upload-image-section"
											data-type="image"
											data-multiple="false"
											data-path="aboutus"
											data-resize-medium="218*65"
											data-resize-small="108*32"
										>
											<div class="upload-section">
												<div class="button-ref mb-3">
													<button class="btn btn-icon btn-primary btn-lg" type="button">
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
							                <textarea class="d-none" name="footer_logo"></textarea>
							                <div class="show-section <?php echo !old('footer_logo') ? 'd-none' : "" ?>">
							                	@include('admin.partials.previewFileRender', ['file' => old('footer_logo') ])
							                </div>
							                <div class="fixed-edit-section clearfix">
							                	@include('admin.partials.previewFileRender', ['file' => Settings::get('footer_logo'), 'relationType' => 'settings.footer_logo', 'relationId' => [] ])
							                </div>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="form-control-label" for="input-facebook">Facebook</label>
								<input type="text" class="form-control" name="facebook" placeholder="Facebook" value="{{ Settings::get('facebook') }}">
							</div>
								<div class="form-group">
								<label class="form-control-label" for="input-twitter">Twitter</label>
								<input type="text" class="form-control" name="twitter" placeholder="Twitter" value="{{ Settings::get('twitter') }}">
							</div>
								<div class="form-group">
								<label class="form-control-label" for="input-instagram">Instagram</label>
								<input type="text" class="form-control" name="instagram" placeholder="Instagram" value="{{ Settings::get('instagram') }}">
							</div>
								<div class="form-group">
								<label class="form-control-label" for="input-youtube">YouTube</label>
								<input type="text" class="form-control" name="youtube" placeholder="YouTube" value="{{ Settings::get('youtube') }}">
							</div>
						</div>
						<hr class="my-4" />
						<button href="#" class="btn btn-sm py-2 px-3 btn-primary float-right">
							<i class="fa fa-save"></i> Submit
						</button>
					</form>
				</div>
			</div>
			<div class="card">
				<!--!! FLAST MESSAGES !!-->
				
				<div class="card-header">
					<div class="row align-items-center">
						<div class="col-8">
							<h3 class="mb-0">Footer menu</h3>
						</div>
					</div>
				</div>
				<div class="card-body">
					<form method="post" action="<?php echo route('admin.settings.footerLinks') ?>" class="form-validation">
						<!--!! CSRF FIELD !!-->
						{{ @csrf_field() }}
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label class="form-control-label" for="input-first-name">Menu Heading</label>
									<input type="text" class="form-control" name="footer1_title" required value="{{ Settings::get('footer1_title') }}">
									@error('footer1_title')
									    <small class="text-danger">{{ $message }}</small>
									@enderror
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="form-control-label" for="input-first-name">Title</label>
											<input type="text" class="form-control" name="footer1_menu1" required value="{{ Settings::get('footer1_menu1') }}">
											@error('footer1_menu1')
											    <small class="text-danger">{{ $message }}</small>
											@enderror
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="form-control-label" for="input-first-name">Link</label>
											<input type="text" class="form-control" name="footer1_menu1_link" required value="{{ Settings::get('footer1_menu1_link') }}">
											@error('footer1_menu1_link')
											    <small class="text-danger">{{ $message }}</small>
											@enderror
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="form-control-label" for="input-first-name">Title</label>
											<input type="text" class="form-control" name="footer1_menu2" required value="{{ Settings::get('footer1_menu2') }}">
											@error('footer1_menu2')
											    <small class="text-danger">{{ $message }}</small>
											@enderror
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="form-control-label" for="input-first-name">Link</label>
											<input type="text" class="form-control" name="footer1_menu2_link" required value="{{ Settings::get('footer1_menu2_link') }}">
											@error('footer1_menu2_link')
											    <small class="text-danger">{{ $message }}</small>
											@enderror
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="form-control-label" for="input-first-name">Title</label>
											<input type="text" class="form-control" name="footer1_menu3" required value="{{ Settings::get('footer1_menu3') }}">
											@error('footer1_menu3')
											    <small class="text-danger">{{ $message }}</small>
											@enderror
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="form-control-label" for="input-first-name">Link</label>
											<input type="text" class="form-control" name="footer1_menu3_link" required value="{{ Settings::get('footer1_menu3_link') }}">
											@error('footer1_menu3_link')
											    <small class="text-danger">{{ $message }}</small>
											@enderror
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="form-control-label" for="input-first-name">Title</label>
											<input type="text" class="form-control" name="footer1_menu4" required value="{{ Settings::get('footer1_menu4') }}">
											@error('footer1_menu4')
											    <small class="text-danger">{{ $message }}</small>
											@enderror
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="form-control-label" for="input-first-name">Link</label>
											<input type="text" class="form-control" name="footer1_menu4_link" required value="{{ Settings::get('footer1_menu4_link') }}">
											@error('footer1_menu4_link')
											    <small class="text-danger">{{ $message }}</small>
											@enderror
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="form-control-label" for="input-first-name">Title</label>
											<input type="text" class="form-control" name="footer1_menu5" required value="{{ Settings::get('footer1_menu5') }}">
											@error('footer1_menu5')
											    <small class="text-danger">{{ $message }}</small>
											@enderror
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="form-control-label" for="input-first-name">Link</label>
											<input type="text" class="form-control" name="footer1_menu5_link" required value="{{ Settings::get('footer1_menu5_link') }}">
											@error('footer1_menu5_link')
											    <small class="text-danger">{{ $message }}</small>
											@enderror
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label class="form-control-label" for="input-first-name">Menu Heading</label>
									<input type="text" class="form-control" name="footer2_title" required value="{{ Settings::get('footer2_title') }}">
									@error('footer2_title')
									    <small class="text-danger">{{ $message }}</small>
									@enderror
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="form-control-label" for="input-first-name">Title</label>
											<input type="text" class="form-control" name="footer2_menu1" required value="{{ Settings::get('footer2_menu1') }}">
											@error('footer2_menu1')
											    <small class="text-danger">{{ $message }}</small>
											@enderror
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="form-control-label" for="input-first-name">Link</label>
											<input type="text" class="form-control" name="footer2_menu1_link" required value="{{ Settings::get('footer2_menu1_link') }}">
											@error('footer2_menu1_link')
											    <small class="text-danger">{{ $message }}</small>
											@enderror
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="form-control-label" for="input-first-name">Title</label>
											<input type="text" class="form-control" name="footer2_menu2" required value="{{ Settings::get('footer2_menu2') }}">
											@error('footer2_menu2')
											    <small class="text-danger">{{ $message }}</small>
											@enderror
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="form-control-label" for="input-first-name">Link</label>
											<input type="text" class="form-control" name="footer2_menu2_link" required value="{{ Settings::get('footer2_menu2_link') }}">
											@error('footer2_menu2_link')
											    <small class="text-danger">{{ $message }}</small>
											@enderror
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="form-control-label" for="input-first-name">Title</label>
											<input type="text" class="form-control" name="footer2_menu3" required value="{{ Settings::get('footer2_menu3') }}">
											@error('footer2_menu3')
											    <small class="text-danger">{{ $message }}</small>
											@enderror
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="form-control-label" for="input-first-name">Link</label>
											<input type="text" class="form-control" name="footer2_menu3_link" required value="{{ Settings::get('footer2_menu3_link') }}">
											@error('footer2_menu3_link')
											    <small class="text-danger">{{ $message }}</small>
											@enderror
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="form-control-label" for="input-first-name">Title</label>
											<input type="text" class="form-control" name="footer2_menu4" required value="{{ Settings::get('footer2_menu4') }}">
											@error('footer2_menu4')
											    <small class="text-danger">{{ $message }}</small>
											@enderror
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="form-control-label" for="input-first-name">Link</label>
											<input type="text" class="form-control" name="footer2_menu4_link" required value="{{ Settings::get('footer2_menu4_link') }}">
											@error('footer2_menu4_link')
											    <small class="text-danger">{{ $message }}</small>
											@enderror
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="form-control-label" for="input-first-name">Title</label>
											<input type="text" class="form-control" name="footer2_menu5" required value="{{ Settings::get('footer2_menu5') }}">
											@error('footer2_menu5')
											    <small class="text-danger">{{ $message }}</small>
											@enderror
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="form-control-label" for="input-first-name">Link</label>
											<input type="text" class="form-control" name="footer2_menu5_link" required value="{{ Settings::get('footer2_menu5_link') }}">
											@error('footer1_menu5_link')
											    <small class="text-danger">{{ $message }}</small>
											@enderror
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label class="form-control-label" for="input-first-name">Menu Heading</label>
									<input type="text" class="form-control" name="footer3_title" required value="{{ Settings::get('footer3_title') }}">
									@error('footer3_title')
									    <small class="text-danger">{{ $message }}</small>
									@enderror
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="form-control-label" for="input-first-name">Title</label>
											<input type="text" class="form-control" name="footer3_menu1" required value="{{ Settings::get('footer3_menu1') }}">
											@error('footer3_menu1')
											    <small class="text-danger">{{ $message }}</small>
											@enderror
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="form-control-label" for="input-first-name">Link</label>
											<input type="text" class="form-control" name="footer3_menu1_link" required value="{{ Settings::get('footer3_menu1_link') }}">
											@error('footer3_menu1_link')
											    <small class="text-danger">{{ $message }}</small>
											@enderror
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="form-control-label" for="input-first-name">Title</label>
											<input type="text" class="form-control" name="footer3_menu2" required value="{{ Settings::get('footer3_menu2') }}">
											@error('footer3_menu2')
											    <small class="text-danger">{{ $message }}</small>
											@enderror
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="form-control-label" for="input-first-name">Link</label>
											<input type="text" class="form-control" name="footer3_menu2_link" required value="{{ Settings::get('footer3_menu2_link') }}">
											@error('footer3_menu2_link')
											    <small class="text-danger">{{ $message }}</small>
											@enderror
										</div>
									</div>
								</div>
							</div>
						</div>
						<hr class="my-4" />
						<button href="#" class="btn btn-sm py-2 px-3 btn-primary float-right">
							<i class="fa fa-save"></i> Submit
						</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection