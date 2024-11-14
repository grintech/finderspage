@extends('layouts.user_dashboard.userdashboardlayout')
@section('content')

<style type="text/css">
    a#cropImageBtn {
        position: absolute;
        bottom: 1px;
        /* right: -148px; */
        border-radius: 12%;
        z-index: 111;
        left: 187px;
    }

    #add-input {
        font-size: 8px;
        background-color: #b2944a;
        position: absolute;
        right: 0;
        top: 0;
        margin-right: 50px;
    }

    .remove-input {
        font-size: 8px;
        background-color: #b2944a;
        position: absolute;
        right: 0;
        top: 0;
        margin-right: 15px;
    }
    #edit_profile_form textarea{
        border: 1px solid #bdbdbd !important;
    }

    .Hashtag {
        display: flex;
        overflow: scroll;
    }

    .mainClass-hashtag {
        margin-left: 5px;
        margin-left: 5px;
        background-color: #eec54b;
        border-radius: 5px;
    }

    h6.hashtag-item {
        padding: 4px;
        margin-top: 7px;
        font-weight: bold;
    }
    
    .hashtagHead {
        font-weight: 700;
    }
    li#iti-0__item-us {
    display: none;
}
</style>

<!-- Your custom script -->
<?php
// echo"<pre>"; print_r($setting);die(); 
?>
<div class="container-fluid px-2 px-md-5">
    <span>
        @include('admin.partials.flash_messages')
    </span>

    <form method="post" action="{{route('update_user_profile_das',$user->id)}}" class="form-validation" enctype="multipart/form-data" id="edit_profile_form" enctype="multipart/form-data">
        @csrf
        <!-- Page Heading -->


        <div class="d-sm-flex flex-column  mb-3">
            <h1 class="h3 mb-0 text-gray-800 fw-bold">Edit Profile</h1>
            <p>Edit your profile here</p>

            <a href="{{route('user_profile', General::encrypt($user->id))}}" style="width: 94px; text-align: right" class="btn profile-button">Back</a>
        </div>
        <div class="row">
            <div class="col-lg-3">
                <div class="card mb-4">
                    <div class="card-body text-center">
                        <div class="avatar-upload">
                            <div class="avatar-edit">
                                <input type="file" id="imageUpload" data-id="{{$user->id}}" accept=".png, .jpg, .jpeg" />
                                <label for="imageUpload">
                                    <i class="fa fa-edit" aria-hidden="true"></i>
                                </label>
                            </div>
                            <div class="avatar-preview popup">
                                <img id="imagePreview" src="{{ $user->image != '' ? asset('assets/images/profile/'.$user->image) : asset('images_blog_img/1688636936.jpg') }}" alt="Preview Image" />
                            </div>
                            <div class="show1">
                                <div class="img-show">
                                    <span class="close1" title="Close"><i class="fas fa-times"></i></span>

                                </div>
                            </div>
                            <!-- Add this button after the #imagePreview element -->
                            <a class="d-none cropimg btn btn-warning" href="javascript:;" id="cropImageBtn"><i class="fas fa-save"></i></a>
                        </div>


                        <!-- <div class="container">
                                    <div class="avatar-upload">
                                        <div class="avatar-edit">
                                            <input type='file' id="imageUpload" data-id="{{$user->id}}" accept=".png, .jpg, .jpeg" />
                                            <label for="imageUpload"><i class="fa fa-edit" aria-hidden="true"></i></label>
                                        </div>
                                        <div class="avatar-preview">
                                            <div id="imagePreview" style="background-image: url({{ $user->image != '' ? url('assets/images/profile/'.$user->image) : asset('front/images/user3.png') }});">

                                            </div>
                                        </div>
                                    </div>
                                </div> -->

                        <?php
                        $currentDate = date("Y-m-d");
                        ?>
                        <strong>{{$user->username}}@if($user->feature_end_date != null && $user->feature_end_date >= $currentDate )<i class="fas fa-star"></i>@endif</strong>
                        <?php $created_date = $user->created;
                        $currentDateTime = date('Y-m-d H:i:s');

                        // Convert the dates to timestamps
                        $created_timestamp = strtotime($created_date);
                        $current_timestamp = strtotime($currentDateTime);

                        // Calculate the difference in seconds
                        $seconds_diff = $current_timestamp - $created_timestamp;

                        // Calculate the difference in days
                        $days_diff = floor($seconds_diff / (60 * 60 * 24));

                        // echo "Number of days between $created_date and $currentDateTime is $days_diff days.";
                        ?>
                        @if($days_diff <= '30' ) <span class="badge bg-secondary">New</span>
                            @endif
                            <br>


                            <?php
                            foreach ($setting as $sett => $value) {
                                if ($value['setting_name'] == 'zodiac_section'  || $value['setting_name'] == "") {
                                    if ($value['setting_value'] == 'show' || $value['setting_value'] == "") {
                            ?>
                                        @if(isset($user->Zodiac_image))
                                        <strong class="zodiac_img"><img src="{{asset('zodiac_image')}}/{{$user->Zodiac_image}}" alt="zodiac_image"></strong> <strong>{{$user->zodiac_name}}</strong>
                                        @endif
                            <?php
                                    }
                                }
                            } ?>

                            <!-- <div class="social-links mt-2">
                                <a href="{{$user->twitter}}" target="blank" class="twitter"><i class="fab fa-twitter"></i></a>
                                <a href="{{$user->facebook}}" target="blank" class="facebook"><i class="fab fa-facebook-f"></i></a>
                                <a href="{{$user->instagram}}" target="blank" class="instagram"><i class="fab fa-instagram"></i></a>
                                <a href="{{$user->linkedin}}" target="blank" class="linkedin"><i class="fab fa-linkedin"></i></a>
                            </div> -->
                    </div>
                </div>
            </div>

            <!--  <div class="card mb-4">
                              <div class="card-body text-center">         

                                <img src="{{$user->cover_img!= ''? url('assets/images/cover_profile/'.$user->cover_img): url('user_dashboard/img/cover-image1.jpg')}}" alt="avatar"
                                  class="rounded-circle img-fluid" style="width: 120px;">
                                <h5 class="h6 mt-3 fw-bold">Cover Image</h5>
                                
                              </div>
                            </div> -->

            <div class="col-lg-9">
                <div class="card mb-4">
                    <div class="card-body">
                        <!-- Profile Edit Form -->

                        <div class="row">
                            <!-- <div class="col-md-6 mb-4">
                                                <label class="labels">Profile Image</label>
                                                <div class="image-upload">
                                                    <label style="cursor: pointer;" for="pfile_upload">
                                                        <img src="" alt="" class="uploaded-image">
                                                        <div class="h-100">
                                                            <div class="dplay-tbl">
                                                                <div class="dplay-tbl-cell">
                                                                    <i class="fas fa-cloud-upload-alt mb-3"></i>
                                                                    <h6><b>Upload an Profile Image</b></h6>
                                                                    <h6 class="mt-10 mb-70">Or Drop Your Image Here</h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <input data-required="image" type="file" name="dp" id="profile_img" class="image-input" data-traget-resolution="image_resolution" value="">
                                                    </label>
                                                </div>
                                                 <div class="show-img-profile d-none">
                                                     <img src="" width="20%" alt="" class="uploaded-image" id="image-container-profile" >
                                                     <i class="fas fa-times" id="cancel-btn-profile"></i>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-4">
                                                <label class="labels">Cover Image</label>
                                                <div class="image-upload">
                                                    <label style="cursor: pointer;" for="cfile_upload">
                                                        <img src="" alt="" class="uploaded-image">
                                                        <div class="h-100">
                                                            <div class="dplay-tbl">
                                                                <div class="dplay-tbl-cell">
                                                                    <i class="fas fa-cloud-upload-alt mb-3"></i>
                                                                    <h6><b>Upload an Cover Image</b></h6>
                                                                    <h6 class="mt-10 mb-70">Or Drop Your Cover Image Here</h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <input data-required="image" type="file" name="cover_img"  id="image_upload" class="image-input" data-traget-resolution="image_resolution" value="">
                                                    </label>
                                                </div>
                                                <div class="show-img d-none">
                                                     <img src="" alt="" class="uploaded-image" id="image-container" >
                                                     <i class="fas fa-times" id="cancel-btn"></i>
                                                </div>
                                            </div> -->
                            <input type="hidden" name="profile_percent" value="{{$Percentage['percent']}}">
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <label class="labels">How do you represent yourself?</label>
                                <select name="profession" id="profession" class="form-control">
                                    <option value="">Select</option>
                                    @foreach($categories as $cate)
                                    <option {{ $user->profession == $cate->id
                                                     ? "selected" : "" }} value="{{$cate->id}}">{{$cate->title}}</option>
                                    @endforeach()
                                    <option class="Other-cate" value="Other">Other</option>

                                </select>

                                <input type="text" class="form-control d-none mt-2" id="Other-cate-input" name="sub_category_oth" placeholder="sub_category name" value="">

                                @error('profession')
                                <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-4">
                                <label class="labels">Bio <span>(Max limit 150 words and add up to 10 hashtags)</span></label>
                                {{-- <label class="labels" style="font-size: 14px;">Describe yourself what makes you unique?</label> --}}
                                <textarea id="bio" class="form-control autosize" placeholder="Describe yourself 
What makes you unique?" name="bio">{{$user->bio}}</textarea>
                                <div class="hashtagHead"><i class="fas fa-hashtag"></i>hashtags</div>
                                <div class="my-Hashtag">
                                    <div class="Hashtag"></div>
                                </div>
                                @error('bio')
                                <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="labels">Name</label>
                                <input type="text" class="form-control" name="first_name" placeholder="Enter first name" value="{{$user->first_name}}" style="text-transform: capitalize;">
                                @error('first_name')
                                <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- <div class="col-md-6 mb-4">
                                <label class="labels">Last Name</label>
                                <input type="text" class="form-control" name="last_name" placeholder="Enter last name" value="{{$user->last_name}}" style="text-transform: capitalize;">
                            </div> -->
                            <div class="col-md-6 mb-4">
                                <label class="labels">Username</label>
                                <input type="text" name="username" class="form-control" value="{{$user->username}}" placeholder="Enter username name">

                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="labels">Email ID</label>
                                <input type="text" name="email" class="form-control" placeholder="Enter email id" value="{{$user->email}}">
                                @error('email')
                                <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-4 phone_lable">
                                <label class="labels">Phone:</label>
                                <input type="text" maxlength="12" class="form-control" name="phonenumber" placeholder="Enter phone number" id="phone" value="{{$user->phonenumber}}">

                                <span class="count_code"></span>
                                <!--  <input type="tel" class="form-control" placeholder="" id="telephone"> -->

                                @error('email')
                                <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- <div class="col-md-6 mb-4">
                                                <label class="labels">Company Name</label>
                                                <input type="text" class="form-control" placeholder="Enter company name" value="">
                                            </div> -->

                            <div class="col-md-6 mb-4">
                                <label class="labels">ZipCode </label>
                                <input name="zipcode" type="text" maxlength="8" class="form-control" id="Zipcode" value="{{$user->zipcode}}" placeholder="Zipcode">
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="labels">Address </label>
                                <input type="text" name="address" class="form-control" placeholder="Enter address" value="{{$user->address}}">
                                @error('address')
                                <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="labels">Date of Birth</label>
                                <input name="birthday" type="date" class="form-control" id="zodiac_name" value="{{$user->dob}}" placeholder="dd-mm">
                            </div>


                            <div id="input-container" class="col-md-12 mb-4">
                                <label class="labels">Add Links</label>
                                @php
                                    $decodedWebsites = explode(',', $user->business_website);
                                    $decodedTitles = explode(',', $user->website_title);
                                @endphp
                            
                                @foreach ($decodedWebsites as $index => $website)
                                    @php
                                        $website_title = isset($decodedTitles[$index]) ? $decodedTitles[$index] : '';
                                    @endphp
                                    <div class="input-row mt-2">
                                        <input type="text" name="website_title[]" class="form-control website_title mt-2" placeholder="Title" value="{{ $website_title }}">
                                        <input type="text" name="business_website[]" class="form-control website_url mt-2" placeholder="URL" value="{{ $website }}">
                                        
                                        <button class="btn btn-warning remove-input" type="button"><i class="fa fa-minus" aria-hidden="true"></i></button>
                                        <label>
                                            <input type="radio" name="primary_website" value="{{ $index }}" {{ $loop->first ? 'checked' : '' }}>
                                            Primary
                                        </label>
                                    </div>
                                @endforeach
                            
                                <button class="btn btn-warning" id="add-input" type="button"><i class="fa fa-plus" aria-hidden="true"></i></button>
                            </div>
                            


                            <!-- @error('business_website')
                                    <span class="error">{{ $message }}</span>
                                    @enderror -->

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
            </div>


            <div class="col-lg-9">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="mb-4">Social links</h5>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="labels">Twitter </label>
                                <div class="socialIcon">
                                    <input name="twitter" type="text" class="form-control" id="Twitter" value="{{$user->twitter}}" placeholder="twitter">
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="labels">YouTube </label>
                                <div class="socialIcon">
                                    <input name="youtube" type="text" class="form-control" id="youtube" value="{{$user->youtube}}" placeholder="youtube">
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="labels">Facebook </label>
                                <div class="socialIcon">
                                    <input name="facebook" type="text" class="form-control" id="Facebook" value="{{$user->facebook}}" placeholder="facebook">
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="labels">Instagram </label>
                                <div class="socialIcon">
                                    <input name="instagram" type="text" class="form-control" id="Instagram" value="{{$user->instagram}}" placeholder="instagram">
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="labels">Linkedin </label>
                                <div class="socialIcon">
                                    <input name="linkedin" type="text" class="form-control" id="Linkedin" value="{{$user->linkedin}}" placeholder="linkedin">
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="labels">TikTok</label>
                                <div class="socialIcon">
                                <?php
                                    $tiktokHandle = $user->Tiktok;  
                                    $cleanedHandle = str_replace('@', '', $tiktokHandle);  // Remove '@'
                                ?>
                                    <input name="Tiktok" type="text" class="form-control" id="tiktok" value="{{$cleanedHandle}}" placeholder="tiktok">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn profile-button">Update Profile</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    jQuery(document).ready(function() {
        $("#country_name").on("change", function() {
            var country_id = $(this).val();
            var user_id = $(this).attr('user-id');
            // alert(user_id);
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            $.ajax({
                url: baseurl + '/filter/state',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    id: country_id,
                    userid: user_id
                },
                success: function(response) {
                    console.log(response);
                    $("#state_name").html(response.option_html);
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        });
        $("#state_name").on("change", function() {
            var country_id = $(this).val();
            var user_id = $(this).attr('user-id');
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            $.ajax({
                url: baseurl + '/filter/city',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    id: country_id,
                    userid: user_id
                },
                success: function(response) {
                    console.log(response);
                    $("#city_name").html(response.option_html);
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        });


        var input = document.querySelector("#phone");
        var iti = window.intlTelInput(input, ({
            onlyCountries: ["us"]
        }));
        var previousePhoneCode = "";
        input.addEventListener("countrychange", function() {
            var countryData = iti.getSelectedCountryData();
            var newPhoneCode = "+" + countryData.dialCode;
            console.log("new phone code " + newPhoneCode);
            var previousePhone = $("#phone").val();
            console.log("previous phone code " + previousePhoneCode);
            if (previousePhoneCode == newPhoneCode) {
                var finalPhone = newPhoneCode + previousePhone;
                console.log("final one " + finalPhone);
            } else {
                if (previousePhone != "") {
                    var finalPhone = previousePhone.replace(previousePhoneCode, newPhoneCode);
                } else {
                    var finalPhone = newPhoneCode;
                }
            }
            console.log("final two " + finalPhone);
            // jQuery("#phone").val(finalPhone);
            jQuery(".count_code").val(finalPhone);
            previousePhoneCode = "+" + countryData.dialCode;
            console.log("updated previous phone code " + previousePhoneCode);
        });
        input.addEventListener("onchange", function() {

        });
    });






    jQuery(document).ready(function() {

        var countryid = $("#country_name").val();
        var userid1 = $('#country_name').attr('user-id');

        // alert(stateID1);
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        $.ajax({
            url: baseurl + '/filter/state',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {
                id: countryid,
                userid: userid1,
            },
            success: function(response) {
                console.log(response);
                $("#state_name").html(response.option_html);
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });

        setTimeout(function() {
            var stateID1 = $("#state_name").val();
            // alert(stateID1);
            var userid2 = $('#country_name').attr('user-id');
            // alert(userid2);
            $.ajax({
                url: baseurl + '/filter/city',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    id: stateID1,
                    userid: userid2
                },
                success: function(response) {
                    console.log(response);
                    $("#city_name").html(response.option_html);
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        }, 5000);


    });



    autosize();

    function autosize() {
        var text = $('.autosize');

        text.each(function() {
            $(this).attr('rows', 1);
            resize($(this));
        });

        text.on('input', function() {
            resize($(this));
        });

        function resize($text) {
            $text.css('height', 'auto');
            $text.css('height', $text[0].scrollHeight + 'px');
        }
    }
</script>

<script>
    $(document).ready(function() {
        //     var maxLength = 250;
        //     var textArea = $("textarea[name='bio']");

        //     // Update the character count and limit whenever the user inputs text
        //     textArea.on('input', function() {
        //         var currentLength = textArea.val().length;
        //         var remainingLength = maxLength - currentLength;

        //         if (remainingLength < 0) {
        //             textArea.val(textArea.val().substr(0, maxLength));
        //             remainingLength = 0;
        //         }

        //         // Update the counter display
        //         $("#char-count").text(remainingLength + " characters remaining");
        //     });


        // addition ajax for adding others option in profile edit proffession

        $('#profession').on('change', function() {
            if ($(this).val() == "Other") {
                // alert($(this).val()+ "This");
                $('#Other-cate-input').removeClass('d-none');
                $(this).addClass('d-none');
            } else {
                $('#Other-cate-input').addClass('d-none');
            }

        });

        $('.profile-button').click(function() {
            var subcate_title = $('#Other-cate-input').val();
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            $.ajax({
                url: baseurl + '/shopping/cate',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    title: subcate_title,
                    parent_id: 1045,
                },
                success: function(response) {
                    console.log(response);
                },
                error: function(xhr, status, error) {

                }
            });
        });




    });

    ////////////////////////Profile Pic Zoom Effect////////////////////////////////////

    $(function() {
        $(".popup img").click(function() {
            let $src = $(this).attr("src");
            $(".show1").fadeIn(10);
            $(".img-show img").attr("src", $src);
        });

        $("span.close1").click(function() {
            $(".show1").fadeOut(10);
            $('.img-show img').css({
                'width': '100%',
                'height': '100%'
            });
        });

        // let ovrflow_width
        $(".img-show img").draggable({

            scroll: true,
            stop: function() {},
            drag: function(e, ui) {

                let popup_img_width = $('.img-show img').width();
                let popup_width = $('.img-show').width();
                let new_img_width = popup_width - popup_img_width;

                let popup_img_height = $('.img-show img').height();
                let popup_height = $('.img-show').height();
                let new_img_height = popup_height - popup_img_height;

                if (ui.position.left > 0) {
                    ui.position.left = 0;
                }
                if (ui.position.left < new_img_width) {
                    ui.position.left = new_img_width;
                }

                if (ui.position.top > 0) {
                    ui.position.top = 0;
                }
                if (ui.position.top < new_img_height) {
                    ui.position.top = new_img_height;
                }
            }
        });

    });

    ////////////////////////Profile Pic Zoom Effect////////////////////////////////////


    // $(document).ready(function(){
    //         $(".website_url").focusout(function(){
    //             var url = $(this).val();
    //             if(isValidURL(url)){
    //                 // Swal.fire({
    //                 //   // title: "The Internet?",
    //                 //   text: "That thing is still around?",
    //                 //   icon: "error"
    //                 // });
    //             } else {
    //                 Swal.fire({
    //                   title: "URL is not valid.",
    //                   text: "use https:// befour your url.",
    //                   icon: "error"
    //                 });
    //             }
    //         });

    //         function isValidURL(url) {
    //             // Regular expression to match a URL pattern
    //             var urlPattern = /^(https?|ftp):\/\/[^\s/$.?#].[^\s]*$/;
    //             return urlPattern.test(url);
    //         }
    //     });

    $(document).ready(function() {
    var maxWords = 150;
    var maxTags = 10;

    $('#bio').on('input', function() {
        var words = $(this).val().split(/\s+/).length;
        var tags = $(this).val().match(/#[^\s#]*/g) ? $(this).val().match(/#[^\s#]*/g).length : 0;

        if (words > maxWords) {
            Swal.fire({
                icon: 'error',
                title: 'Limit Exceeded',
                text: 'Word limit exceeded!',
            });
            $(this).val($(this).val().substr(0, $(this).val().lastIndexOf(' ')));
        }

        if (tags > maxTags) {
            Swal.fire({
                icon: 'error',
                title: 'Limit Exceeded',
                text: 'Hashtag limit exceeded!',
            });
            var val = $(this).val();
            var tagsArray = val.match(/#[^\s#]*/g);
            $(this).val(val.substring(0, val.lastIndexOf(tagsArray[tagsArray.length - 1])));
        }
    });
});
</script>


<script>
$(document).ready(function() {
    var inputCount = {{ count($decodedWebsites) }};
    var maxInputs = 5;

    $('#add-input').click(function() {
        if (inputCount < maxInputs) {
            inputCount++;

            var newInputRow = $('.input-row:first').clone();
            newInputRow.find('input').val('');
            newInputRow.find('input[type="radio"]').prop('checked', false);
            newInputRow.find('input[type="radio"]').attr('value', inputCount - 1);
            newInputRow.appendTo('#input-container');
        }
    });

    $('#input-container').on('click', '.remove-input', function() {
        if (inputCount > 1) {
            inputCount--;
            $(this).parent('.input-row').remove();
            if ($('#input-container').find('input[type="radio"][name="primary_website"]').filter(':checked').length === 0) {
                $('#input-container').find('.input-row:first').find('input[type="radio"]').prop('checked', true);
            }
        }
    });

    $('#input-container').on('change', 'input[type="radio"][name="primary_website"]', function() {
        $('#input-container').find('input[type="radio"][name="primary_website"]').not(this).prop('checked', false);
    });
});
</script>

@endsection