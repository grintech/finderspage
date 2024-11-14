@extends('layouts.user_dashboard.userdashboardlayout')
@section('content')
<?php
use App\Models\Setting;
// echo"<pre>"; print_r($Percentage);die();
?>
<style type="text/css">
    /*a#cropImageBtn {
    position: relative;
    bottom: -4px;
    right: -22px;
    border-radius: 50%;
    z-index: 111;
}*/
    a#cropImageBtn {
        position: absolute;
        bottom: -21px;
        /* right: -148px; */
        border-radius: 12%;
        z-index: 111;
        left: 181px;
    }

    .left-text-user {
        font-weight: 800;
    }

    .r-text-value {
        display: -webkit-inline-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    @media only screen and (max-width: 767px) {
        .r-text-value {
            margin-top: 8px !important;
            font-size: 13px;
        }

        .left-text-user {
            font-size: 13px;
            margin-top: 8px;
        }
    }

    .i_button {
        color: black;
        background-color: #f3c94e;
    }

    .i_button:hover {
        color: black;
        background-color: #9b8049;
    }

    .ten_website_coloum {
        margin-top: 14px;
    }

    .showing {
        display: block !important;
    }
    .profile_dropdown .dropdown{
        right: -10px;
         bottom: -5px;
    }
    .profile_dropdown .dropdown-menu {
        left: -31px;
        bottom: 35px !important;
        top: auto !important;
        
    }

    .profile_dropdown .dropdown-menu li {
        padding: 5px;
    }
    #upload_img{
        position: absolute;
    }
    #websiteModal a {color: #db712b !important;}

</style>
<div class="container-fluid px-3 px-sm-5">
    <span>
        @include('admin.partials.flash_messages')
    </span>

    <!-- Page Heading -->
    <div class="d-sm-flex flex-column  mb-3">
        <h1 class="h3 mb-0 text-gray-800 fw-bold">Edit Profile</h1>
        <p>Edit your profile here </p>


    </div>
    <div class="row">
        <div class="col-lg-12 cover-image p-image  profile_dropdown">
            <div class="card">
                <div class="avatar-upload1">
                    <!-- <div class="avatar-edit1">
                                            <input type='file' id="CoverimageUpload" data-id="{{$user->id}}" pro-per="{{$Percentage['percent']}}" accept=".png, .jpg, .jpeg" />
                                            <label for="CoverimageUpload"><i class="fa fa-edit" aria-hidden="true"></i></label>
                                        </div> -->
                    <div class="avatar-preview1">
                        <div>

                            <img src="{{ $user->cover_img != '' ? asset('assets/images/profile/' . $user->cover_img) : asset('images_blog_img/1688624191.jpeg') }}"
                                id="imagecoverPreview" alt="cover_img">
                            <!-- <a class="cover-edit" href="#"><i class="fas fa-camera"></i> <span>Edit</span></a> -->
                            <div class="avatar-edit1">
                                <!-- <input type='file' id="CoverimageUpload" data-id="{{$user->id}}"
                                    pro-per="{{$Percentage['percent']}}" accept=".png, .jpg, .jpeg" />
                                <label for="CoverimageUpload"><i class="fas fa-camera" aria-hidden="true"></i></label>
                                @if($user->cover_img)
                                    <div class="coverimageRemove" id="coverimageRemove">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </div>
                                @endif -->
                                <div class="dropdown">
                                    <button class="btn btn-warning dropdown-toggle" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-camera"></i> Edit cover photo
                                    </button>
                                    <ul class="dropdown-menu">
                                    <input type='file' id="CoverimageUpload" data-id="{{$user->id}}"
                                    pro-per="{{$Percentage['percent']}}" accept=".png, .jpg, .jpeg" />
                                        <li> <label for="CoverimageUpload" style="font-size:13px; margin-bottom: 0 !important;"> <i class="fa fa-image mr-2" ></i>Choose cover photo</label></li>
                                        <!-- <li><i class="fa fa-upload mr-2"></i>Upload Photo</li> -->
                                        @if($user->cover_img)
                                        <li><div class="coverimageEdit" id="coverimageEdit"> <i class="fas fa-arrows-alt mr-2"></i> Reposition </div></li>
                                        <li><div class="coverimageRemove" id="coverimageRemove"> <i class="fa fa-trash mr-2"></i> Remove </div></li>
                                        @endif
                                        
                                    </ul>
                                </div>


                            </div>
                            <div class="profile-img">
                                <a class="cover-profile-pic" href="#"><img id="imagePreview"
                                        src="{{ $user->image != '' ? asset('assets/images/profile/' . $user->image) : asset('images_blog_img/1688624191.jpeg') }}"
                                        alt="Preview Image" /></a>
                                <input type="file" id="imageUpload" data-id="{{$user->id}}"
                                    accept=".png, .jpg, .jpeg" />
                                <label id="upload_img" for="imageUpload">
                                    <i class="fas fa-camera" aria-hidden="true"></i>
                                </label>
                                @if($user->image)
                                    <div class="imageRemove" id="imageRemove">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </div>
                                @endif
                                <a class="d-none cropimg btn btn-warning" href="javascript:void(0);" id="cropImageBtn"><i
                                        class="fas fa-save"></i></a>
                            </div>
                            <!-- <a href="#" class="manage-frame">Brenda Pond</a> -->
                            <?php
$currentDate = date("Y-m-d");
                            ?>
                            <strong
                                class="manage-frame d-show">{{$user->username}}@if($user->feature_end_date != null && $user->feature_end_date >= $currentDate)<i
                                class="fas fa-star"></i>@endif</strong>
                        </div>
                        <a class="d-none cropimg btn btn-warning float-right" href="javascript:void(0);"
                            id="cropImageBtnCover"><i class="fas fa-save"></i> Save </a>
                    </div>
                </div>
            </div>


          

        </div>

        <div class="col-12">
        <div class="row mt-md-5 ">
            <div class="col-lg-3">
                <div class="card f-div mb-4">
                    <div class="card-body text-center">
                        <!-- <div class="avatar-upload">
                                    <div class="avatar-edit">
                                      <input type="file" id="imageUpload" data-id="{{$user->id}}" accept=".png, .jpg, .jpeg" />
                                      <label for="imageUpload">
                                        <i class="fa fa-edit" aria-hidden="true"></i>
                                      </label>
                                    </div>
                                    <div class="avatar-preview popup">
                                      <img id="imagePreview" src="{{ $user->image != '' ? asset('assets/images/profile/'.$user->image) : asset('front/images/user3.png') }}" alt="Preview Image" />
                                    </div>
                                    <div class="show1">
                                        <div class="img-show">
                                            <span class="close1" title="Close"><i class="fas fa-times"></i></span>
                                            <img src="">
                                        </div>
                                    </div>
                                    <a class="d-none cropimg btn btn-warning" href="javascript:void(0);" id="cropImageBtn"><i class="fas fa-save"></i></a>
                                  </div> -->

                        <div style="display: flex;">
                            <?php
$currentDate = date("Y-m-d");
                        ?>
                            <strong
                                class="m-show">{{$user->username}}@if($user->feature_end_date != null && $user->feature_end_date >= $currentDate)<i
                                class="fas fa-star"></i>@endif</strong>

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
                            @if($days_diff <= '30') <!-- <span class="badge bg-secondary">New</span> -->
                                <img src="{{ asset('front/images/images.png') }}" alt="avatar"
                                    class="rounded-circle img-fluid" style="width: 40px;">
                            @endif



                            <br>
                            <?php
foreach ($setting as $sett => $value) {
    if ($value['setting_name'] == 'zodiac_section' || $value['setting_name'] == "") {
        if ($value['setting_value'] == 'show' || $value['setting_value'] == "") {
                            ?>
                            @if(isset($user->Zodiac_image))
                                <strong class="zodiac_img"><img src="{{asset('zodiac_image')}}/{{$user->Zodiac_image}}"
                                        alt="zodiac_img"></strong> <strong>{{$user->zodiac_name}}</strong>
                            @endif
                            <?php
        }
    }
} ?>




                        </div>
                        <!--  <div class="social-links mt-2">
                                    <a href="{{$user->twitter}}" target="blank" class="twitter"><i class="fab fa-twitter"></i></a>
                                    <a href="{{$user->facebook}}" target="blank" class="facebook"><i class="fab fa-facebook-f"></i></a>
                                    <a href="{{$user->instagram}}" target="blank" class="instagram"><i class="fab fa-instagram"></i></a>
                                    <a href="{{$user->linkedin}}" target="blank" class="linkedin"><i class="fab fa-linkedin"></i></a>
                                </div> -->
                    </div>
                </div>
                @if(isset($resume_setting))
                    <div class="card mb-4">
                        <div class="card-body ">
                            <div class="container">

                                <div class="sett_ing">


                                    <?php    if ($resume_type == 'talent') { ?>
                                    <h5 class="fw-bold">Talent Resume</h5>
                                    <?php    } else if ($resume_type == 'work') { ?>
                                    <h5 class="fw-bold">Work Resume</h5>
                                    <?php        } ?>

                                    <label class="switch mt-2 " data-toggle="tooltip" data-placement="top"
                                        data-original-title="Show resume on profile page ?">
                                        <input type="checkbox" id="togBtn_resume" name="resume_section"
                                            @if($resume_setting == "show") checked @endif>
                                        <div class="slider round"><!--ADDED HTML -->
                                            <span class="on">Show</span>
                                            <span class="off">Hide</span><!--END-->
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-lg-9">
                <div class="card mb-4">
                    <div class="card-body">
                        <span class="edit-btn ">
                            <a target="blank" href="{{route('UserProfileFrontend', $user->slug)}}"
                                class="btn btn-warning">View as</a>
                        </span>
                        <!--  <span class="edit-btn ">
                                        <a href="javascript:void(0);" id="del_my_account" class="btn btn-warning" data-link="{{route('Delete_account',General::encrypt($user->id))}}">Delete My Account</a>
                                    </span> -->
                        <span class="edit-btn ">
                            <a href="{{route('edit_user_profile_das', General::encrypt($user->id))}}"
                                class="btn btn-warning">Edit</a>
                        </span>
                        @if(!empty($user->bio))
                            <h5 class="card-title inner-title">Bio</h5>
                            <?php
                                $processedText = Setting::makeLinksClickable($user->bio);
                            ?>
                            <p class="p-text mb-4" style="text-align: justify; white-space: pre-line;">{!!$processedText!!}</p>
                        @endif
                        <h5 class="card-title inner-title">Profile Details</h5>
                        <!-- <div class="row">
                                        <div class="col-lg-3 col-md-4 label left-text-user">Full Name </div>
                                        <div class="col-lg-9 col-md-8 r-text-value">{{$user->first_name}}@if($user->role == "business")<i class="fas fa-star"></i>@endif</div>
                                    </div> -->
                        <div class="row">


                            @if(!empty($user->first_name))
                                <div class="col-lg-3 col-md-4 col-4 label left-text-user"> Name:</div>
                                <div class="col-lg-3 col-md-8 col-8  r-text-value">{{$user->first_name}}</div>
                            @endif
                            <!-- @if(!empty($user->last_name))
                                        <div class="col-lg-2 col-md-6 col-4 label left-text-user">Last Name:</div>
                                        <div class="col-lg-4 col-md-6 col-8  r-text-value">{{$user->last_name}}</div>
                                    @endif -->
                            @if(!empty($user->username))
                                <div class="col-lg-3 col-md-4 col-4 label left-text-user">Username:</div>
                                <div class="col-lg-3 col-md-8 col-8  r-text-value">{{$user->username}}</div>
                            @endif

                            <!-- @if(!empty($user->profession))
                                        <div class="col-lg-2 col-md-6 col-4 label left-text-user">how you represent yourself:</div>
                                        <div class="col-lg-4 col-md-6 col-8  r-text-value">
                                            @foreach($categories as $cate)
                                                @if($user->profession == $cate->id )
                                                     {{$cate->title}}
                                                    @endif
                                                    @endforeach()
                                            </div>
                                    @endif -->

                            @if(!empty($user->email))
                                <div class="col-lg-3 col-md-4 col-4  label left-text-user">Email ID:</div>
                                <div class="col-lg-3 col-md-8 col-8  r-text-value"><a
                                        href="mailto:{{$user->email}}">{{$user->email}}</a>
                                </div>
                            @endif

                            @if(!empty($user->phonenumber))
                                <div class="col-lg-3 col-md-4 col-4  label left-text-user">Phone:</div>
                                <div class="col-lg-3 col-md-8 col-8  r-text-value"><a
                                        href="tel:{{$user->phonenumber}}">{{$user->phonenumber}}</a></div>

                            @endif


                            @if(!empty($user->business_website) && !empty($user->website_title))
                            @php
                                $decodedWebsites = explode(',', $user->business_website);
                                $decodedTitles = explode(',', $user->website_title);
                            @endphp
                        
                            <div class="col-lg-12 col-md-12 col-12 r-text-value">
                                <div class="row" style="display: flex;">
                                    @if(count($decodedWebsites) > 1)
                                        <div class="col-lg-3 col-md-4 col-4  label left-text-user">
                                            URL's:
                                        </div>
                                    @else
                                        <div class="col-lg-3 col-md-4 col-4  label left-text-user">
                                            URL:
                                        </div>
                                    @endif
                                    <div class="col-lg-4 col-md-8 col-8  r-text-value ten_website_coloum">
                                        @if(count($decodedWebsites) > 1)
                                            @php
                                                $count_web = count($decodedWebsites) - 1;
                                                $firstWebsite = $decodedWebsites[0];
                                                $firstTitle = $decodedTitles[0];
                                                $displayText = strlen($firstWebsite) > 20 ? substr($firstWebsite, 0, 20) . ' <b>' . $count_web . ' More </b>' : $firstWebsite;
                                            @endphp
                                            <p id="clickForMoreBtn" data-toggle="modal" data-target="#websiteModal">
                                                <?= $displayText ?>
                                            </p>
                                        @else
                                            @php
                                                $singleWebsite = $decodedWebsites[0];
                                                $singleTitle = $decodedTitles[0];
                                                $displayText = strlen($singleWebsite) > 20 ? substr($singleWebsite, 0, 20) . '......' : $singleWebsite;
                                            @endphp
                                            <a id="showWebsitesBtn" href="{{ $singleWebsite }}" data-toggle="modal"
                                                data-target="#websiteModal">
                                                <i class="fas fa-link fa-sm fa-fw mr-2 text-gray-400"></i>
                                                {{ $displayText }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        
                            <!-- Modal -->
                            <div class="modal fade" id="websiteModal" tabindex="-1" role="dialog"
                                aria-labelledby="websiteModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="websiteModalLabel">Links</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            @foreach ($decodedWebsites as $index => $website)
                                                @php
                                                    $title = isset($decodedTitles[$index]) ? $decodedTitles[$index] : '';
                                                    $displayWebsite = strlen($website) > 30 ? substr($website, 0, 30) . '...' : $website;
                                                @endphp
                                                <div>
                                                    <strong>Title:</strong> {{ $title }}<br>
                                                    <strong>Link:</strong> <a target="_blank" href="{{ $website }}">
                                                        <i class="fas fa-link fa-sm fa-fw mr-2 text-gray-400"></i>
                                                        {{ $displayWebsite }}
                                                    </a><br><br>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        

                            @if(!empty($user->address))
                                <div class="col-lg-3 col-md-4 col-4  label left-text-user">Address:</div>
                                <div class="col-lg-3 col-md-8 col-8  r-text-value">{{$user->address}}</div>
                            @endif

                        </div>

                        <div class="row">
                            @if(!empty($user->twitter))
                                <div class="col-lg-3 col-md-4 col-4 label left-text-user">Twitter:</div>
                                <div class="col-lg-3 col-md-8 col-8 r-text-value"><a target="blank"
                                        href="https://twitter.com/{{$user->twitter}}">https://twitter.com/{{$user->twitter}}</a>
                                </div>
                            @endif


                            @if(!empty($user->youtube))

                                <div class="col-lg-3 col-md-4 col-4 label left-text-user">Youtube:</div>
                                <div class="col-lg-3 col-md-8 col-8 r-text-value"><a target="blank"
                                        href="https://www.youtube.com/channel/{{$user->youtube}}">https://www.youtube.com/channel/{{$user->youtube}}</a>
                                </div>

                            @endif

                            @if(!empty($user->facebook))
                                <div class="col-lg-3 col-md-4 col-4 label left-text-user">Facebook:</div>
                                <div class="col-lg-3 col-md-8 col-8 r-text-value"><a target="blank"
                                        href="https://www.facebook.com/{{$user->facebook}}">https://www.facebook.com/{{$user->facebook}}</a>
                                </div>

                            @endif

                            @if(!empty($user->instagram))
                                <div class="col-lg-3 col-md-4 col-4 label left-text-user">Instagram:</div>
                                <div class="col-lg-3 col-md-8 col-8 r-text-value"><a target="blank"
                                        href="https://www.instagram.com/{{$user->instagram}}">https://www.instagram.com/{{$user->instagram}}</a>
                                </div>

                            @endif

                            @if(!empty($user->linkedin))
                                <div class="col-lg-3 col-md-4 col-4 label left-text-user">Linkedin:</div>
                                <div class="col-lg-3 col-md-8 col-8 r-text-value"><a target="blank"
                                        href="https://www.linkedin.com/company/{{$user->linkedin}}">https://www.linkedin.com/company/{{$user->linkedin}}</a>
                                </div>

                            @endif

                            @if(!empty($user->Tiktok))
                                <div class="col-lg-3 col-md-4 col-4 label left-text-user">Tiktok:</div>
                                <div class="col-lg-3 col-md-8 col-8 r-text-value"><a target="blank"
                                        href="https://www.tiktok.com/{{$user->Tiktok}}">https://www.tiktok.com/{{$user->Tiktok}}</a></div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
</div>
</div>
<script>
    $(document).on("click", "#del_my_account", function (e) {
        e.preventDefault();
        var link = $(this).attr("data-link");
        Swal.fire({
            title: 'Delete',
            text: 'Are you sure you want to Delete?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#fcd152',
            cancelButtonColor: '#1a202e',
            confirmButtonText: 'Yes, Delete!',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = link;
                Swal.fire(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                )
            }
        });
    });




    jQuery(document).ready(function () {

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
            success: function (response) {
                console.log(response);
                $("#state_name").html(response.option_html);
            },
            error: function (xhr, status, error) {
                console.log(xhr.responseText);
            }
        });

        setTimeout(function () {
            var stateID1 = $(".state1").val();
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
                success: function (response) {
                    console.log(response);
                    $("#city_name").html(response.option_html);
                },
                error: function (xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        }, 5000);



        $('#togBtn_resume').on('change', function () {
            var resume_section = $('input[name="resume_section"]').is(':checked');
            if (resume_section === true) {
                var resume = 'show';
            } else {
                var resume = 'hide';
            }
            console.log(resume + 'resume_section');
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            $.ajax({
                url: baseurl + "/resume/setting",
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": csrfToken
                },
                data: {
                    resume: resume,
                },
                success: function (response) {
                    console.log('success', response);
                    toastr.success(response.message);
                },
                error: function (response) {
                    console.log('error', response);
                    toastr.success(response.error);
                }
            });


        });


    });


    ////////////////////////Profile Pic Zoom Effect////////////////////////////////////

    $(function () {
        $(".popup img").click(function () {
            let $src = $(this).attr("src");
            $(".show1").fadeIn(10);
            $(".img-show img").attr("src", $src);
        });

        $("span.close1").click(function () {
            $(".show1").fadeOut(10);
            $('.img-show img').css({
                'width': '100%',
                'height': '100%'
            });
        });

        // let ovrflow_width
        $(".img-show img").draggable({

            scroll: true,
            stop: function () { },
            drag: function (e, ui) {

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
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
    ////////////////////////Profile Pic Zoom Effect////////////////////////////////////
</script>
<script>
    $(document).ready(function () {
        // Show modal when clicking on the button
        $('#showWebsitesBtn').click(function () {
            $('#websiteModal').modal('show');
        });
    });

    $(document).ready(function () {
        $('.profile_dropdown .dropdown-toggle').click(function () {
            $('.profile_dropdown .dropdown-menu').toggleClass('showing');
        });
    });

    $(document).ready(function () {
        $('.profile_dropdown .dropdown-menu li').click(function () {
            $('.profile_dropdown .dropdown-menu').toggleClass('showing');
        });
    })
</script>
@endsection