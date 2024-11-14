@extends('layouts.adminlayout')
@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
<style>
    .switches-container {width: 16rem;position: relative;display: flex;padding: 0;position: relative;
background: linear-gradient(90deg, rgba(220, 114, 40, 1) 50%, rgba(205, 89, 8, 1) 100%);line-height: 2.5rem;border-radius: 3rem;margin-left: auto;margin-right: auto;}
.switches-container input {visibility: hidden;position: absolute;top: 0;}
.switches-container label {width: 54%;padding: 0;margin: 0;text-align: center;cursor: pointer;color: #fff;font-weight: 700;}
.switch-wrapper {position: absolute;top: 0;bottom: 0;width: 54%;padding: 0.15rem;z-index: 3;transition: transform .5s cubic-bezier(.77, 0, .175, 1);}
.switch {border-radius: 3rem;background:#fff;height: 100%;width: 113px;margin-left: 0;font-weight: 700;}
.switch div {width: 100%;text-align: center;opacity: 0;display: block;transition: opacity .2s cubic-bezier(.77, 0, .175, 1) .125s;will-change: opacity;position: absolute;top: -2px;left: 0;color: #000;font-size: 15px;}
/* slide the switch box from right to left */
.switches-container input:nth-of-type(1):checked~.switch-wrapper {transform: translateX(0%);}
/* slide the switch box from left to right */
.switches-container input:nth-of-type(2):checked~.switch-wrapper {transform: translateX(100%);}
/* toggle the switch box labels - first checkbox:checked - show first switch div */
.switches-container input:nth-of-type(1):checked~.switch-wrapper .switch div:nth-of-type(1) {opacity: 1;}
/* toggle the switch box labels - second checkbox:checked - show second switch div */
.switches-container input:nth-of-type(2):checked~.switch-wrapper .switch div:nth-of-type(2) {opacity: 1;}

.card.border-left-warning.shadow.showdata {
  overflow: visible !important;
}

</style>

<section class="video-frame mt-5">
    <div class="container">
        <div class="row jutify-content-center">
            <div class="col-lg-8 col-md-8 col-sm-6 mx-auto">
                <form method="post" action="{{route('video.save')}}" enctype="multipart/form-data">
                    @csrf
                     <span>
                        @include('admin.partials.flash_messages')
                        
                    </span>
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                          <h4 class="h3 mb-0 text-gray-800 fw-bold detail-head">Videos & Films</h4>
                          <!-- <button type="submit" id="save_button" class="btn btn-primary save-btn ms-auto">Save</button> -->
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-center">
                            <div class="switches-container">
                                <input type="radio" id="switchMonthly" name="video_type" value="long-video" checked />
                                <input type="radio" id="switchYearly" name="video_type" value="short-video" />
                                <label for="switchMonthly">Long Video</label>
                                <label for="switchYearly">Mini Video</label>
                                <div class="switch-wrapper">
                                  <div class="switch">
                                    <div>Long Video</div>
                                    <div>Mini Video</div>
                                  </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card shadow mt-3">
                    <div class="video-thumbnail">
                        <div class="avatar-edit">
                            <input type="file" id="video-input" accept="video/*" name="video">
                            <label for="video-input"><i class="fas fa-video" aria-hidden="true"></i></label>
                        </div>
                        <video id="video" width="100%" height="250"></video>
                    </div>
                </div>

                <div class="card border-left-warning shadow mt-3">
                    <div class="card-body py-2">
                        <div class="caption-area">
                            <input type="text" class="form-control" name="title" id="caption" placeholder="Create a title...">
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
                        <textarea class="form-control" name="description" id="desc" placeholder="Write description here..."></textarea>
                      </div>
                    </div>
                  </div>
                </div>


                <div class="accordion mt-3" id="mension">
                  <div class="card border-left-warning shadow">
                    <div class="card-head" id="headingOne">
                      <div class="mb-0 text-black head" data-toggle="collapse" data-target="#mension-user" aria-expanded="true" aria-controls="collapseOne">
                          <span class="left-icon"><i class="bi bi-people"></i>Tag people</span>
                          <span class="arrow">
                            <i class="bi bi-chevron-right" id="chevron-icon"></i>
                          </span>
                      </div>
                    </div>

                    <div id="mension-user" class="collapse" aria-labelledby="headingOne" data-parent="#mension">
                      <div class="card-body pt-1">
                        <textarea class="form-control" name="mension" id="mension_user" placeholder="Click to Add user  "></textarea>
                        <div class="my-followers">
                            <div class="video-scroller">
                                
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>



                <div class="accordion mt-3" id="sub_category">
                  <div class="card border-left-warning shadow">
                    <div class="card-head" id="headingOne">
                      <div class="mb-0 text-black head" data-toggle="collapse" data-target="#collapse_subcate" aria-expanded="true" aria-controls="collapse_subcate">
                          <span class="left-icon"><i class="bi bi-bookmarks"></i>Sub Categories <em>(Optional)</em></span>
                          <span class="arrow">
                            <i class="bi bi-chevron-right" id="chevron-icon"></i>
                          </span>
                      </div>
                    </div>

                    <div id="collapse_subcate" class="collapse" aria-labelledby="headingOne" data-parent="#sub_category">
                      <div class="card-body pt-1">
                       <select class="form-control form-control-xs selectpicker" name="sub_category" data-size="7" data-live-search="true" data-title="Sub Category" multiple id="sub_category" data-width="100%" max-options="10">
                           
                            @foreach($categories as $cate)
                            <option data-tokens="{{$cate->title}}" value="{{$cate->id}}" >{{$cate->title}}</option>
                            @endforeach
                            <option class="Other-cate" value="Other" >Other</option> 
                          </select>

                           <input type="text" class="form-control d-none mt-2" id="Other-cate-input" name="sub_category_oth" placeholder="sub_category name" value="">
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
                            <input type="checkbox" name="view_as" value="public" checked>
                        </label>
                        <hr>
                        <label class="custom-toggle d-flex justify-content-between">
                            <span>Private</span>
                            <input type="checkbox" name="view_as" value="private">
                        </label>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="accordion mt-3" id="location" > 
                  <div class="card border-left-warning shadow showdata">
                    <div class="card-head" id="headingThree">
                      <div class="mb-0 text-black head" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                          <span class="left-icon"><i class="bi bi-geo-alt"></i> Add Location</span>
                          <span class="arrow">
                            <i class="bi bi-chevron-right" id="chevron-icon"></i>
                          </span>
                      </div>
                    </div>

                    <div id="collapseThree" class="collapse show" aria-labelledby="headingThree" data-parent="#location">
                      <div class="card-body pt-1">
                        <div class="location-field">
                            <input type="text" class="form-control  get_loc" name="location" id="loc" placeholder="location">
                        </div>
                        <div class="searcRes" id="autocomplete-results"></div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="accordion mt-3" id="schedule">
                  <div class="card border-left-warning shadow">
                    <div class="card-head" id="scheduleOne">
                      <div class="mb-0 text-black head" data-toggle="collapse" data-target="#schedule_one" aria-expanded="true" aria-controls="scheduleOne">
                          <span class="left-icon"><i class="bi bi-clock"></i>Schedule Publish Time <em>(Optional)</em></span>
                          <span class="arrow">
                            <i class="bi bi-chevron-right" id="chevron-icon"></i>
                          </span>
                      </div>
                    </div>

                    <div id="schedule_one" class="collapse" aria-labelledby="scheduleOne" data-parent="#schedule">
                      <div class="card-body pt-1">
                        <input type="datetime-local" class="form-control" name="schedule" placeholder="Enter post name" value="" >
                        <span class="error-message" id="title-error"></span>
                         @error('schedule')
                            <small class="text-danger">{{ $message }}</small>
                         @enderror
                      </div>
                    </div>
                  </div>
                </div>

                <!-- <div class="accordion mt-3" id="video-type">
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
                            <input type="radio" name="post_type" value="Bump Post">
                        </label>
                        <hr>
                        <label class="custom-toggle d-flex justify-content-between">
                            <span>Feature Video</span>
                            <input type="radio" name="post_type" value="Feature Post">
                        </label>
                        <hr>
                        <label class="custom-toggle d-flex justify-content-between">
                            <span>Free Video</span>
                            <input type="radio" name="post_type" value="Normal Post" checked>
                        </label>
                      </div>
                    </div>
                  </div>
                </div> -->

                <input type="hidden" name="post_type" value="Normal Post" checked>
                <div class="card">
                    <div class="card-header">
                        <div class="text-center">
                          <!-- <h4 class="h3 mb-0 text-gray-800 fw-bold detail-head">Videos & Films</h4> -->
                          <button type="submit" id="save_button" class="btn btn-primary save-btn ms-auto">Save</button>
                        </div>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
</section>

<script>
$(document).ready(function(){
            $('input[name="video_type"]').change(function(){
                // Get the value of the checked radio button with id "switchMonthly"
                var switchMonthlyValue = $('input[name="video_type"]:checked').val();
                    
                // Display the value (you can use it as needed)
                console.log("switchMonthlyValue: " + switchMonthlyValue);
            });
        });


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


$(document).ready(function() {
$('#sub_category').on('change', function() {
        if($(this).val() == "Other"){
             $('#Other-cate-input').removeClass('d-none');
             $(this).addClass('d-none');
        }else{
            $('#Other-cate-input').addClass('d-none');
        }
       
  });
   $('.addCategory').click(function () {
        var subcate_title = $('#Other-cate-input').val();
         var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        $.ajax({
            url: baseurl+'/shopping/cate',
            type: 'POST',
            headers: {
              'X-CSRF-TOKEN': csrfToken
            },
            data: {
                title:subcate_title,
                parent_id:727,
            },
            success: function(response){
              console.log(response);
            },
            error: function(xhr, status, error) {
             
            }
          });
    });
});

$(document).ready(function () {
    var selectedUsers = [];

    $('#mension_user').on('input', function () {
        var text = $(this).val();
        if (text.includes('@')) {
            var username = text.split('@')[1];
            console.log(username);
            fetchUserList(username);
        }
    });

    $(document).on("click", ".mainClass1", function () {
        var text = $(this).find('h6').text(); // Use .text() to get the text content
        console.log(text);
        selectedUsers.push(text);
        updateTextbox();
        // Remove the selected username from the result
        $(this).remove();
    });
    function fetchUserList(username) {
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        $.ajax({
            url: '{{route('video.getuser')}}',
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken },
            data: { username: username },
            success: function (data) {
                // Handle the received user list data
                console.log(data);
                $('.video-scroller').html(data);
            },
            error: function (error) {
                console.error('Error fetching user list:', error);
            }
        });
    }

    function updateTextbox() {
    var formattedUsers = selectedUsers.map(function(user) {
            return '@' + user;
        });
        $('#mension_user').val(formattedUsers.join(', '));
    }
});

$(document).ready(function() {
    $('#sub_category').on('change', function() {
      var t_length =  $(this).length;
      alert(t_length);   
         
    });
  });
</script>

@endsection