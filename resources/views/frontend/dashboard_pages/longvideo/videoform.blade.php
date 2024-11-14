@extends('layouts.user_dashboard.userdashboardlayout')
@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
<style>
	.switches-container {width: 16rem;position: relative;display: flex;padding: 0;position: relative;
background: linear-gradient(90deg, rgba(170,137,65,1) 0%, rgba(205,156,49,1) 13%, rgba(154,128,73,1) 35%, rgba(246,204,78,1) 51%, rgba(181,147,56,1) 75%, rgba(163,136,68,1) 100%);line-height: 2.5rem;border-radius: 3rem;margin-left: auto;margin-right: auto;}
.switches-container input {visibility: hidden;position: absolute;top: 0;}
.switches-container label {width: 54%;padding: 0;margin: 0;text-align: center;cursor: pointer;color: #000;font-weight: 700;}
.switch-wrapper {position: absolute;top: 0;bottom: 0;width: 54%;padding: 0.15rem;z-index: 3;transition: transform .5s cubic-bezier(.77, 0, .175, 1);}
.switch {border-radius: 3rem;background:#fff;height: 100%;width: 113px;margin-left: 0;font-weight: 700;}
.switch div {width: 100%;text-align: center;opacity: 0;display: block;transition: opacity .2s cubic-bezier(.77, 0, .175, 1) .125s;will-change: opacity;position: absolute;top: 0;left: 0;color: #000;}
/* slide the switch box from right to left */
.switches-container input:nth-of-type(1):checked~.switch-wrapper {transform: translateX(0%);}
/* slide the switch box from left to right */
.switches-container input:nth-of-type(2):checked~.switch-wrapper {transform: translateX(100%);}
/* toggle the switch box labels - first checkbox:checked - show first switch div */
.switches-container input:nth-of-type(1):checked~.switch-wrapper .switch div:nth-of-type(1) {opacity: 1;}
/* toggle the switch box labels - second checkbox:checked - show second switch div */
.switches-container input:nth-of-type(2):checked~.switch-wrapper .switch div:nth-of-type(2) {opacity: 1;}

</style>

<section class="video-frame mt-5">
	<div class="container">
		<div class="row jutify-content-center">
			<div class="col-lg-8 col-md-8 col-sm-6 mx-auto">
				<div class="card">
					<div class="card-header">
				        <div class="d-flex justify-content-between">
				          <h4 class="h3 mb-0 text-gray-800 fw-bold detail-head">Add Details</h4>
				          <button type="button" id="save_button" class="btn btn-primary save-btn ms-auto">Save</button>
				        </div>
				    </div>
				</div>
				<div class="card">
					<div class="card-header">
						<div class="d-flex justify-content-center">
							<div class="switches-container">
							    <input type="radio" id="switchMonthly" name="switchPlan" value="Monthly" checked="checked" />
							    <input type="radio" id="switchYearly" name="switchPlan" value="Yearly" />
							    <label for="switchMonthly">Long Video</label>
							    <label for="switchYearly">Short Video</label>
							    <div class="switch-wrapper">
							      <div class="switch">
							        <div>Long Video</div>
							        <div>Short Video</div>
							      </div>
							    </div>
							  </div>
						</div>
					</div>
				</div>
				<div class="card shadow mt-3">
					<div class="video-thumbnail">
						<div class="avatar-edit">
                            <input type="file" id="video-input" accept="video/*">
                            <label for="video-input"><i class="fas fa-video" aria-hidden="true"></i></label>
                        </div>
						<video id="video" width="100%" height="250"></video>
					</div>
					<div class="video-info">
						<div class="video-creator">
							<img src="https://finderspage.com/public/assets/images/profile/1682815173.jpg" alt="Image">
						</div>
						<div class="video-text">
							<span class="video-title">
								Daragh Coll
							</span>
							<span class="video-channel">@daraghcoll</span>
						</div>
					</div>
				</div>

				<div class="card border-left-warning shadow mt-3">
	                <div class="card-body py-2">
                        <div class="caption-area">
                            <input type="text" class="form-control" name="caption" id="caption" placeholder="Create a title...">
                        </div>
	                </div>
	            </div>

	            <div class="accordion mt-3" id="description">
				  <div class="card border-left-warning shadow">
				    <div class="card-head" id="headingOne">
				      <div class="mb-0 text-black head" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
				          <span class="left-icon"><i class="bi bi-justify-left"></i> Add Description</span>
				          <span class="arrow">
					      	<i class="bi bi-chevron-right" id="chevron-icon"></i>
					      </span>
				      </div>
				    </div>

				    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#description">
				      <div class="card-body pt-1">
			            <textarea class="form-control" name="desc" id="desc" placeholder="Write description here..."></textarea>
				      </div>
				    </div>
				  </div>
				</div>

				<div class="accordion mt-3" id="visibility">
				  <div class="card border-left-warning shadow">
				    <div class="card-head" id="headingTwo">
				      <div class="mb-0 text-black head" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
				          <span class="left-icon"><i class="bi bi-globe"></i> Visibility</span>
				          <span class="arrow">
					      	<i class="bi bi-chevron-right" id="chevron-icon"></i>
					      </span>
				      </div>
				    </div>

				    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#visibility">
				      <div class="card-body pt-1">
			            <label class="custom-toggle d-flex justify-content-between">
			            	<span>Public</span>
                            <input type="checkbox" name="public" value="true">
                        </label>
                        <hr>
                        <label class="custom-toggle d-flex justify-content-between">
			            	<span>Private</span>
                            <input type="checkbox" name="private" value="true">
                        </label>
				      </div>
				    </div>
				  </div>
				</div>

				<div class="accordion mt-3" id="location">
				  <div class="card border-left-warning shadow">
				    <div class="card-head" id="headingThree">
				      <div class="mb-0 text-black head" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
				          <span class="left-icon"><i class="bi bi-geo-alt"></i> Add Location</span>
				          <span class="arrow">
					      	<i class="bi bi-chevron-right" id="chevron-icon"></i>
					      </span>
				      </div>
				    </div>

				    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#location">
				      <div class="card-body pt-1">
			            <div class="location-field">
			            	<input type="text" class="form-control" name="loc" id="loc" placeholder="Enter your location...">
			            </div>
				      </div>
				    </div>
				  </div>
				</div>

				<div class="accordion mt-3" id="video-type">
				  <div class="card border-left-warning shadow">
				    <div class="card-head" id="headingFour">
				      <div class="mb-0 text-black head" data-toggle="collapse" data-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
				          <span class="left-icon"><i class="bi bi-camera-video"></i> Choose Plan for Video Post</span>
				          <span class="arrow">
					      	<i class="bi bi-chevron-right" id="chevron-icon"></i>
					      </span>
				      </div>
				    </div>

				    <div id="collapseFour" class="collapse" aria-labelledby="headingTwo" data-parent="#video-type">
				      <div class="card-body pt-1">
			            <label class="custom-toggle d-flex justify-content-between">
			            	<span>Bump Video</span>
                            <input type="checkbox" name="bump" value="true">
                        </label>
                        <hr>
                        <label class="custom-toggle d-flex justify-content-between">
			            	<span>Feature Video</span>
                            <input type="checkbox" name="feature" value="true">
                        </label>
                        <hr>
                        <label class="custom-toggle d-flex justify-content-between">
			            	<span>Free Video</span>
                            <input type="checkbox" name="free" value="true">
                        </label>
				      </div>
				    </div>
				  </div>
				</div>
			       
			</div>
		</div>
	</div>
</section>

<script>
	var textarea = document.querySelector('textarea');

textarea.addEventListener('keydown', autosize);
             
function autosize(){
  var el = this;
  setTimeout(function(){
    el.style.cssText = 'height:auto; padding:0';
    // for box-sizing other than "content-box" use:
    // el.style.cssText = '-moz-box-sizing:content-box';
    el.style.cssText = 'height:' + el.scrollHeight + 'px';
  },0);
}

$('.head').click(function(){
  $(this).parent().find('.arrow').toggleClass('arrow-animate');
});



const input = document.getElementById('video-input');
const video = document.getElementById('video');
const videoSource = document.createElement('source');

input.addEventListener('change', function () {
  const files = this.files || [];

  if (!files.length) return;

  const reader = new FileReader();

  reader.onload = function (e) {
    videoSource.setAttribute('src', e.target.result);
    video.appendChild(videoSource);
    video.load();
    video.play();
  };

  reader.onprogress = function (e) {
    console.log('progress: ', Math.round(e.loaded * 100 / e.total));
  };

  reader.readAsDataURL(files[0]);
});


</script>

@endsection