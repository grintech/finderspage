@extends('layouts.user_dashboard.userdashboardlayout')
@section('content')
@php use App\Models\UserAuth; @endphp
@php use Illuminate\Support\Facades\Cookie; @endphp
<?php $User = UserAuth::getLoginUser();
// dd($User);
?>
<style type="text/css">
    /*body {
    font-family: "Inter", sans-serif;
    margin: 0;
    padding: 0;
    padding: 3rem;
    line-height: 1.5;
    color: var(--bodyTextColour);
}*/

.alert-login_popup {
  margin-block: 2.5rem;
  padding: 1.25rem;
  display: grid;
  grid-gap: 1.25rem;
  grid-template-columns: max-content auto;
  border-radius: 4px;
  transition: 0.12s ease;
  position: relative;
  overflow: hidden;
  background-color: #000 !important;
  border-left:4px solid #dc7228;
}
.alert-login_popup:before {
  content: "";
  position: absolute;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  mix-blend-mode: soft-light;
  background: linear-gradient(90deg, rgba(255, 255, 255, 0) 30%, white 56%, rgba(2, 0, 36, 0.1) 82%);
  z-index: 1;
}
.alert-login_popup .icon, .alert-login_popup .content {
  z-index: 2;
}
.alert-login_popup .icon {
  line-height: 1;
}
.alert-login_popup .title {
  font-weight: 700;
  margin-bottom: 0.75rem;
  color: #fff;
}
.alert-login_popup .content {
  max-width: 100%;
}

.alert-login_popup.alert--info .icon {
  color: #fff;
}
.alert-login_popup .progress-bar{margin-top: 10px;}



@media (max-width: 767px) {
    .alert {
        grid-template-columns: auto;
        padding: 1rem;
        grid-gap: 0.75rem;
        .icon {
            font-size: 1.5rem;
        }
        .title {
            margin-bottom: 0.5rem;
        }
    }
}

</style>
<div class="container-fluid px-3 px-md-5">
    <?php  
        $user = UserAuth::getLoginUser(); 
        $featuredEndDate = new DateTime($user->featured_end_date);
        $currentDate = new DateTime();

        // Calculate the difference
        $interval = $currentDate->diff($featuredEndDate);
        // dd($interval);

        // Get the difference in days
        $days = $interval->days;
     ?>
                     <span>
                        <!-- <div>
                            <div id="alertContainer" class="alert-login_popup alert--info">
                                <i class="fa fa-info-circle fa-2xl icon"></i> 
                                <div class="content">
                                    <div class="title">Your current subscription plan is {{$user->subscribedPlan}} and is set to expire on {{$days}}.</div>
                                    
                                    <div id="progressBar" class="progress-bar" style="width:100%;height: 7px; background: linear-gradient(90deg, rgba(170,137,65,1) 0%, rgba(205,156,49,1) 13%, rgba(154,128,73,1) 35%, rgba(246,204,78,1) 51%, rgba(181,147,56,1) 75%, rgba(163,136,68,1) 100%);"></div>	
                                </div>
                                
                            </div>
                        </div> -->



                        {{-- @include('admin.partials.flash_messages') --}}

                        
                    </span>


                        <!-- <div class="alert alert-danger alert-dismissible fade show d-none" id="profile_eer">
                            Please Complete your profile 100% ...!!  <a class="float-right" href="{{route('edit_user_profile_das', General::encrypt($user->id))}}">Go To Profile</a>
                            
                        </div> -->
                   
                    <input type="hidden" class="percent" value="{{$user->profile_percent}}">

                    <h6 class="h2 d-inline-block mb-0">Dashboard</h6>
                    <div class="view_counts">
                        <strong class="zodiac_img">
                            <img src="{{ asset('zodiac_image/eye.png') }}" alt="eye.png"></strong>
                        <span class="text-muted"> Only visible to you</span>
                    </div>
                    <!-- Content Row -->
                    <div class="dash-tabs">
                        <!-- Nav pills -->
                        <ul class="nav nav-pills mb-5 orClass" id="pills-tab" role="tablist">
                          <li class="nav-item">
                            <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">What are you creating today?</a>
                          </li>
                       <!--  <li class="nav-item main-orClass">
                           <a href="javascript:;">OR</a> 
                        </li> -->
                          <!-- <li class="nav-item">
                            <a class="nav-link" id="pills-business-tab" data-toggle="pill" href="#pills-business" role="tab" aria-controls="pills-business" aria-selected="true">Create Business Page</a>
                          </li> -->
                        </ul>

                        <div class=" col-lg-12 col-md-12 col-12 mx-auto mb-4">
                                <div class="row justify-content-center dash_home_btns">
                                <button type="button " class="mb-2 active mx-md-4 mx-2" id="dash_btn_1">Ads</button>
                                {{-- <a href="{{route('blog.add')}}"> <button class="mb-2 mx-md-4 mx-2">Blog</button></a> --}}
                                <a href="{{route('comingSoon')}}"> <button class="mb-2 mx-md-4 mx-2">Posts</button></a>
                                <a href="{{route('comingSoon')}}"> <button class="mb-2 mx-md-4 mx-2">Videos</button></a>
                                {{-- <a data-toggle="tooltip" data-placement="top" title="Stay Informed with the Latest Posts & Videos Stay updated" href="{{route('comingSoon')}}"> <button class="mb-2 mx-md-4 mx-2">Posts & Videos </button></a> --}}
                                <a href="{{route('business_page')}}"> <button class="mb-2 mx-md-4 mx-2">Business Page</button></a>
                                {{-- <a href="{{route('commingSoon_bussiness')}}"> <button class="mb-2 mx-md-4 mx-2">Business Page</button></a> --}}
                                <a href="{{route('comingSoon')}}"> <button class="mb-2 mx-md-4 mx-2">Create an event</button></a>
                                </div>
                        </div>
                            <div class="row dash_btn_content mb-5" >
                                <div class="col profile-menu">
                                   <a class="pro_file"  href="{{route('post.create')}}">
                                        <div class="img-box">
                                            <img src="{{asset('user_dashboard/img/c2.png')}}" class="img-fluid" alt="img">
                                            <div class="h5 mb-0 text-white">Jobs</div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col profile-menu">
                                    <a class="pro_file" href="{{route('create_realestate')}}">
                                        <div class="img-box">
                                            <img src="{{asset('user_dashboard/img/c3.png')}}" class="img-fluid" alt="img">
                                            <div class="h5 mb-0 text-white">Real Estate</div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col profile-menu">
                                    <a class="pro_file" href="{{route('community')}}">
                                        <div class="img-box">
                                            <img src="{{asset('user_dashboard/img/c4.png')}}" class="img-fluid" alt="img">
                                            <div class="h5 mb-0 text-white">Welcome to our Community</div>
                                        </div>
                                    </a>
                                   <!-- <div class="card border-left-warning bg-gradient-primary shadow h-100 py-2">
                                        <div class="card-body text-center">
                                            <div class="h5 mb-0 text-white">Welcome to our Community</div>
                                        </div>
                                    </div> -->
                                </div>
                                <div class="col profile-menu">
                                    <a class="pro_file" href="{{route('shopping')}}">
                                        <div class="img-box">
                                            <img src="{{asset('user_dashboard/img/c5.png')}}" class="img-fluid" alt="img">
                                            <div class="h5 mb-0 text-white">Sell or give away</div>
                                        </div>
                                    </a>
                                  
                                </div>
                                <div class="col profile-menu">
                                    <a class="pro_file" href="{{route('add_services')}}">
                                        <div class="img-box">
                                            <img src="{{asset('images_blog_img/1688651557.jfif')}}" class="img-fluid" alt="img">
                                            <div class="h5 mb-0 text-white">Services</div>
                                        </div>
                                    </a>
                                  
                                </div>

                               

                                <div class="col profile-menu">
                                    <a class="pro_file" href="{{route('Entertainment')}}">
                                        <div class="img-box">
                                            <img src="{{asset('images_blog_img/hands-heart-coins.jpg')}}" class="img-fluid" alt="img">
                                            <div class="h5 mb-0 text-white">Entertainment Industry</div>
                                        </div>
                                    </a>
                                </div>

                                <div class="col profile-menu">
                                    <a class="pro_file" href="{{route('fundraisers')}}">
                                        <div class="img-box">
                                            <img src="{{asset('images_blog_img/fundraising.jpeg')}}" class="img-fluid" alt="img">
                                            <div class="h5 mb-0 text-white">Fundraiser</div>
                                        </div>
                                    </a>
                                </div>
                            </div>

                        <div class="tab-content" id="pills-tabContent">
                          <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                          

                            <!-- <div class="row mb-5">
                                 <div class="col profile-menu">
                                   <a class="pro_file"  href="{{route('post.create')}}">
                                        <div class="img-box">
                                            <img src="https://finderspage.com/public/user_dashboard/img/c2.png" class="img-fluid" alt="img">
                                            <div class="h5 mb-0 text-white">Listing</div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col profile-menu">
                                    <a class="pro_file" href="{{route('blog.add')}}">
                                        <div class="img-box">
                                            <img src="https://finderspage.com/public/images_blog_img/1688534901.png" class="img-fluid" alt="img">
                                            <div class="h5 mb-0 text-white">Blog Away</div>
                                        </div>
                                    </a>
                                   
                                </div>
                                <div class="col profile-menu">
                                   <a class="pro_file"  href="https://finderspage.com/user-business">
                                        <div class="img-box">
                                        <img src="https://finderspage.com/public/user_dashboard/img/c5.png" class="img-fluid" alt="img">
                                            <div class="h5 mb-0 text-white">Videos</div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col profile-menu">
                                   <a class="pro_file"  href="https://finderspage.com/user-business">
                                        <div class="img-box">
                                        <img src="https://finderspage.com/public/images_blog_img/hands-heart-coins.jpg" class="img-fluid" alt="img">
                                            <div class="h5 mb-0 text-white">Business Page</div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col profile-menu">
                                   <a class="pro_file"  href="https://finderspage.com/user-business">
                                        <div class="img-box">
                                            <img src="https://finderspage.com/public/user_dashboard/img/c2.png" class="img-fluid" alt="img">
                                            <div class="h5 mb-0 text-white">Event</div>
                                        </div>
                                    </a>
                                </div>

                            </div> -->

                         

                        


                          </div>
                          <div class="tab-pane fade" id="pills-business" role="tabpanel" aria-labelledby="pills-business-tab">
                             <div class="row business-page">
                                    <div class="col-lg-12 mb-3 text-center">
                                        <!-- <h1 class="h3 mb-0 text-gray-800 fw-bold">Create Business Page</h1> -->
                                        <p>Business Page Information</p>
                                    </div>
                                    <div class="col-lg-12">
                                    <form method="post" action="https://finderspage.com/public/user-business" class="form-validation" enctype="multipart/form-data" id="crete-business_form">
                                        <div class="row justify-content-center">
                                            <div class="col-mg-12 col-md-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                       <!--  <div class="row">
                                                            <div class="col-lg-6 col-md-6 form-group">
                                                                <label class="labels">Name</label>
                                                                <input type="text" class="form-control" name="b_name" placeholder="Enter Name" required>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 form-group">
                                                                <label class="labels">Email</label>
                                                                <input type="text" class="form-control" name="bemail" placeholder="Enter Email" required>
                                                            </div>
                                                        </div> -->
                                                        <div class="row">
                                                            <div class="col-lg-6 col-md-6 form-group">
                                                                <label class="labels">Business Page Name</label>
                                                                <input type="text" class="form-control" name="page_name" placeholder="Enter Business Page Name" required>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 form-group">
                                                                <label class="labels">Business Email</label>
                                                                <input type="text" class="form-control" name="businessemail" placeholder="Enter Business Email" required>
                                                            </div>
                                                        </div>

                                                         <div class="row">
                                                            <div class="col-lg-6 col-md-6 form-group">
                                                                <label class="labels">Phone No</label>
                                                                <input type="text" class="form-control" name="phone_no" placeholder="Enter Business Phone No" required>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 form-group">
                                                                <label class="labels">Location</label>
                                                                <input type="text" class="form-control" name="location" placeholder="Location" required>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-lg-6 col-md-6 form-group">
                                                                <label class="labels">Category</label>
                                                                <select id="searccategory" class="form-control" name="searcbusinessCat" required>
                                                                    <option>Choose Category</option>
                                                                    <option value="Abbey">Abbey</option>
                                                                    <option value="Abundant Life Church">Abundant Life Church</option>
                                                                    <option value="Aboriginal and Torres Strait Islander Organisation">Aboriginal and Torres Strait Islander Organisation</option>
                                                                    <option value="Acoustical Consultant">Acoustical Consultant</option>
                                                                    <option value="Accountant">Accountant</option>
                                                                    <option value="Abrasives Supplier">Abrasives Supplier</option>
                                                                    <option value="Aboriginal Art Gallery">Aboriginal Art Gallery</option>
                                                                    <option value="Accounting Firm">Accounting Firm</option>
                                                                    <option value="Accounting School">Accounting School</option>
                                                                    <option value="Accounting Software Company">Accounting Software Company</option>
                                                                   
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 form-group">
                                                                <label class="labels">Description</label>
                                                                <textarea class="form-control" name="desc" placeholder="Enter Description"></textarea>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row">
                                                            <div class="col-lg-6 col-md-6 form-group">
                                                                <label class="labels">Profile Picture</label>
                                                                <div class="image-upload">
                                                                    <label style="cursor: pointer;" for="file_upload">
                                                                        <img src="" alt="Image" class="uploaded-image">
                                                                        <div class="h-100">
                                                                            <div class="dplay-tbl">
                                                                                <div class="dplay-tbl-cell">
                                                                                    <!-- <i class="fas fa-cloud-upload-alt mb-1"></i>
                                                                                    <h6><b>Upload Profile Picture</b></h6>
                                                                                    <h6 class="mt-10 mb-70">Or Drop Your Picture Here</h6> -->
                                                                                    <i class="far fa-file-image mb-3"></i>
                                                                                    <h6 class="mt-10 mb-70">Upload Or Drop Your Profile Image Here</h6>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <input data-required="image" type="file" name="image_name" id="file_upload" class="image-input" data-traget-resolution="image_resolution" value="">
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 form-group">
                                                                <label class="labels">Cover Photo</label>
                                                                <div class="image-upload">
                                                                    <label style="cursor: pointer;" for="photo_upload">
                                                                        <img src="" alt="Image" class="uploaded-image">
                                                                        <div class="h-100">
                                                                               <div class="dplay-tbl">
                                                                                <div class="dplay-tbl-cell">
                                                                                    <!-- <i class="fas fa-cloud-upload-alt mb-1"></i>
                                                                                    <h6><b>Upload Cover Photo</b></h6>
                                                                                    <h6 class="mt-10 mb-70">Or Drop Your Photo Here</h6> -->
                                                                                    <i class="far fa-file-image mb-3"></i>
                                                                                    <h6 class="mt-10 mb-70">Upload Or Drop Your Cover Photo Here</h6>
                                                                                </div>
                                                                            </div>
                                                                        </div><!--upload-content-->
                                                                        <input data-required="image" type="file" name="photo_name" id="photo_upload" class="image-input" data-traget-resolution="image_resolution" value="">
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="hour_slt">
                                                            <div class="col-lg-12">
                                                                    <label for="exampleInput">Hours </label>
                                                                </div>
                                                                <hr> 
                                                            <div class="row">

                                                                
                                                                    <div class="col-lg-4">
                                                                        <label for="exampleInput">Monday </label>
                                                                    </div>
                                                                    <div class="col-lg-4">
                                                                        <select class="form-select valid" aria-label="Default select example" name="mon_am" aria-invalid="false">
                                                                        <option value="12:00 AM">12:00 AM</option>
                                                                        <option>Please Select</option>
                                                                        <option value="12:00 AM">12:00 AM</option>
                                                                        <option value="01:00 AM">01:00 AM</option>
                                                                        <option value="02:00 AM">02:00 AM</option>
                                                                        <option value="03:00 AM">03:00 AM</option>
                                                                        <option value="04:00 AM">04:00 AM</option>
                                                                        <option value="05:00 AM">05:00 AM</option>
                                                                        <option value="06:00 AM">06:00 AM</option>
                                                                        <option value="07:00 AM">07:00 AM</option>
                                                                        <option value="08:00 AM">08:00 AM</option>
                                                                        <option value="09:00 AM">09:00 AM</option>
                                                                        <option value="10:00 AM">10:00 AM</option>
                                                                        <option value="11:00 AM">11:00 AM</option>
                                                                        <option value="12:00 PM">12:00 PM</option>
                                                                        <option value="01:00 PM">01:00 PM</option>
                                                                        <option value="02:00 PM">02:00 PM</option>
                                                                        <option value="03:00 PM">03:00 PM</option>
                                                                        <option value="04:00 PM">04:00 PM</option>
                                                                        <option value="05:00 PM">05:00 PM</option>
                                                                        <option value="06:00 PM">06:00 PM</option>
                                                                        <option value="07:00 PM">07:00 PM</option>
                                                                        <option value="08:00 PM">08:00 PM</option>
                                                                        <option value="09:00 PM">09:00 PM</option>
                                                                        <option value="10:00 PM">10:00 PM</option>
                                                                        <option value="11:00 PM">11:00 PM</option>
                                                                        <option value="12:00 AM">12:00 AM</option>
                                                                        <option value="closed">Closed</option>
                                                                </select>
                                                                </div>

                                                            <div class="col-lg-4">
                                                                <select class="form-select" aria-label="Default select example" name="mon_pm">
                                                                <option value="02:00 AM">02:00 AM</option>
                                                                <option>Please Select</option>
                                                                <option value="12:00 AM">12:00 AM</option>
                                                                <option value="01:00 AM">01:00 AM</option>
                                                                <option value="02:00 AM">02:00 AM</option>
                                                                <option value="03:00 AM">03:00 AM</option>
                                                                <option value="04:00 AM">04:00 AM</option>
                                                                <option value="05:00 AM">05:00 AM</option>
                                                                <option value="06:00 AM">06:00 AM</option>
                                                                <option value="07:00 AM">07:00 AM</option>
                                                                <option value="08:00 AM">08:00 AM</option>
                                                                <option value="09:00 AM">09:00 AM</option>
                                                                <option value="10:00 AM">10:00 AM</option>
                                                                <option value="11:00 AM">11:00 AM</option>
                                                                <option value="12:00 PM">12:00 PM</option>
                                                                <option value="01:00 PM">01:00 PM</option>
                                                                <option value="02:00 PM">02:00 PM</option>
                                                                <option value="03:00 PM">03:00 PM</option>
                                                                <option value="04:00 PM">04:00 PM</option>
                                                                <option value="05:00 PM">05:00 PM</option>
                                                                <option value="06:00 PM">06:00 PM</option>
                                                                <option value="07:00 PM">07:00 PM</option>
                                                                <option value="08:00 PM">08:00 PM</option>
                                                                <option value="09:00 PM">09:00 PM</option>
                                                                <option value="10:00 PM">10:00 PM</option>
                                                                <option value="11:00 PM">11:00 PM</option>
                                                                <option value="12:00 AM">12:00 AM</option>
                                                                <option value="closed">Closed</option>            </select>
                                                            </div>
                                                 
                                                                <div class="col-lg-4">
                                                                <label for="exampleInput">Tuesday </label>
                                                                </div>
                                                                <div class="col-lg-4">
                                                                <select class="form-select" aria-label="Default select example" name="tue_am">
                                                                <option value="04:00 PM">04:00 PM</option>
                                                                <option>Please Select</option>
                                                                <option value="12:00 AM">12:00 AM</option>
                                                                <option value="01:00 AM">01:00 AM</option>
                                                                <option value="02:00 AM">02:00 AM</option>
                                                                <option value="03:00 AM">03:00 AM</option>
                                                                <option value="04:00 AM">04:00 AM</option>
                                                                <option value="05:00 AM">05:00 AM</option>
                                                                <option value="06:00 AM">06:00 AM</option>
                                                                <option value="07:00 AM">07:00 AM</option>
                                                                <option value="08:00 AM">08:00 AM</option>
                                                                <option value="09:00 AM">09:00 AM</option>
                                                                <option value="10:00 AM">10:00 AM</option>
                                                                <option value="11:00 AM">11:00 AM</option>
                                                                <option value="12:00 PM">12:00 PM</option>
                                                                <option value="01:00 PM">01:00 PM</option>
                                                                <option value="02:00 PM">02:00 PM</option>
                                                                <option value="03:00 PM">03:00 PM</option>
                                                                <option value="04:00 PM">04:00 PM</option>
                                                                <option value="05:00 PM">05:00 PM</option>
                                                                <option value="06:00 PM">06:00 PM</option>
                                                                <option value="07:00 PM">07:00 PM</option>
                                                                <option value="08:00 PM">08:00 PM</option>
                                                                <option value="09:00 PM">09:00 PM</option>
                                                                <option value="10:00 PM">10:00 PM</option>
                                                                <option value="11:00 PM">11:00 PM</option>
                                                                <option value="12:00 AM">12:00 AM</option>
                                                                <option value="closed">Closed</option>            </select>
                                                                </div>
                                                                <div class="col-lg-4">
                                                                <select class="form-select" aria-label="Default select example" name="tue_pm">
                                                                <option value="04:00 PM">04:00 PM</option>
                                                                <option>Please Select</option>
                                                                <option value="12:00 AM">12:00 AM</option>
                                                                <option value="01:00 AM">01:00 AM</option>
                                                                <option value="02:00 AM">02:00 AM</option>
                                                                <option value="03:00 AM">03:00 AM</option>
                                                                <option value="04:00 AM">04:00 AM</option>
                                                                <option value="05:00 AM">05:00 AM</option>
                                                                <option value="06:00 AM">06:00 AM</option>
                                                                <option value="07:00 AM">07:00 AM</option>
                                                                <option value="08:00 AM">08:00 AM</option>
                                                                <option value="09:00 AM">09:00 AM</option>
                                                                <option value="10:00 AM">10:00 AM</option>
                                                                <option value="11:00 AM">11:00 AM</option>
                                                                <option value="12:00 PM">12:00 PM</option>
                                                                <option value="01:00 PM">01:00 PM</option>
                                                                <option value="02:00 PM">02:00 PM</option>
                                                                <option value="03:00 PM">03:00 PM</option>
                                                                <option value="04:00 PM">04:00 PM</option>
                                                                <option value="05:00 PM">05:00 PM</option>
                                                                <option value="06:00 PM">06:00 PM</option>
                                                                <option value="07:00 PM">07:00 PM</option>
                                                                <option value="08:00 PM">08:00 PM</option>
                                                                <option value="09:00 PM">09:00 PM</option>
                                                                <option value="10:00 PM">10:00 PM</option>
                                                                <option value="11:00 PM">11:00 PM</option>
                                                                <option value="12:00 AM">12:00 AM</option>
                                                                <option value="closed">Closed</option>            </select>
                                                                </div>
                                                                <div class="col-lg-4">
                                                                <label for="exampleInput">Wednesday </label>
                                                                </div>
                                                                <div class="col-lg-4">
                                                                <select class="form-select" aria-label="Default select example" name="wed_am">
                                                                <option value="02:00 PM">02:00 PM</option>
                                                                <option>Please Select</option>
                                                                <option value="12:00 AM">12:00 AM</option>
                                                                <option value="01:00 AM">01:00 AM</option>
                                                                <option value="02:00 AM">02:00 AM</option>
                                                                <option value="03:00 AM">03:00 AM</option>
                                                                <option value="04:00 AM">04:00 AM</option>
                                                                <option value="05:00 AM">05:00 AM</option>
                                                                <option value="06:00 AM">06:00 AM</option>
                                                                <option value="07:00 AM">07:00 AM</option>
                                                                <option value="08:00 AM">08:00 AM</option>
                                                                <option value="09:00 AM">09:00 AM</option>
                                                                <option value="10:00 AM">10:00 AM</option>
                                                                <option value="11:00 AM">11:00 AM</option>
                                                                <option value="12:00 PM">12:00 PM</option>
                                                                <option value="01:00 PM">01:00 PM</option>
                                                                <option value="02:00 PM">02:00 PM</option>
                                                                <option value="03:00 PM">03:00 PM</option>
                                                                <option value="04:00 PM">04:00 PM</option>
                                                                <option value="05:00 PM">05:00 PM</option>
                                                                <option value="06:00 PM">06:00 PM</option>
                                                                <option value="07:00 PM">07:00 PM</option>
                                                                <option value="08:00 PM">08:00 PM</option>
                                                                <option value="09:00 PM">09:00 PM</option>
                                                                <option value="10:00 PM">10:00 PM</option>
                                                                <option value="11:00 PM">11:00 PM</option>
                                                                <option value="12:00 AM">12:00 AM</option>
                                                                <option value="closed">Closed</option>            </select>
                                                                          </div>
                                                                          <div class="col-lg-4">
                                                                            <select class="form-select" aria-label="Default select example" name="wed_pm">
                                                                                            <option value="01:00 PM">01:00 PM</option>
                                                                                            <option>Please Select</option>
                                                                <option value="12:00 AM">12:00 AM</option>
                                                                <option value="01:00 AM">01:00 AM</option>
                                                                <option value="02:00 AM">02:00 AM</option>
                                                                <option value="03:00 AM">03:00 AM</option>
                                                                <option value="04:00 AM">04:00 AM</option>
                                                                <option value="05:00 AM">05:00 AM</option>
                                                                <option value="06:00 AM">06:00 AM</option>
                                                                <option value="07:00 AM">07:00 AM</option>
                                                                <option value="08:00 AM">08:00 AM</option>
                                                                <option value="09:00 AM">09:00 AM</option>
                                                                <option value="10:00 AM">10:00 AM</option>
                                                                <option value="11:00 AM">11:00 AM</option>
                                                                <option value="12:00 PM">12:00 PM</option>
                                                                <option value="01:00 PM">01:00 PM</option>
                                                                <option value="02:00 PM">02:00 PM</option>
                                                                <option value="03:00 PM">03:00 PM</option>
                                                                <option value="04:00 PM">04:00 PM</option>
                                                                <option value="05:00 PM">05:00 PM</option>
                                                                <option value="06:00 PM">06:00 PM</option>
                                                                <option value="07:00 PM">07:00 PM</option>
                                                                <option value="08:00 PM">08:00 PM</option>
                                                                <option value="09:00 PM">09:00 PM</option>
                                                                <option value="10:00 PM">10:00 PM</option>
                                                                <option value="11:00 PM">11:00 PM</option>
                                                                <option value="12:00 AM">12:00 AM</option>
                                                                <option value="closed">Closed</option>
                                                                            </select>
                                                                          </div>
                                                                          <div class="col-lg-4">
                                                                            <label for="exampleInput">Thursday </label>
                                                                          </div>
                                                                          <div class="col-lg-4">
                                                                            <select class="form-select" aria-label="Default select example" name="thur_am">
                                                                                            <option value="12:00 PM">12:00 PM</option>
                                                                                            <option>Please Select</option>
                                                                <option value="12:00 AM">12:00 AM</option>
                                                                <option value="01:00 AM">01:00 AM</option>
                                                                <option value="02:00 AM">02:00 AM</option>
                                                                <option value="03:00 AM">03:00 AM</option>
                                                                <option value="04:00 AM">04:00 AM</option>
                                                                <option value="05:00 AM">05:00 AM</option>
                                                                <option value="06:00 AM">06:00 AM</option>
                                                                <option value="07:00 AM">07:00 AM</option>
                                                                <option value="08:00 AM">08:00 AM</option>
                                                                <option value="09:00 AM">09:00 AM</option>
                                                                <option value="10:00 AM">10:00 AM</option>
                                                                <option value="11:00 AM">11:00 AM</option>
                                                                <option value="12:00 PM">12:00 PM</option>
                                                                <option value="01:00 PM">01:00 PM</option>
                                                                <option value="02:00 PM">02:00 PM</option>
                                                                <option value="03:00 PM">03:00 PM</option>
                                                                <option value="04:00 PM">04:00 PM</option>
                                                                <option value="05:00 PM">05:00 PM</option>
                                                                <option value="06:00 PM">06:00 PM</option>
                                                                <option value="07:00 PM">07:00 PM</option>
                                                                <option value="08:00 PM">08:00 PM</option>
                                                                <option value="09:00 PM">09:00 PM</option>
                                                                <option value="10:00 PM">10:00 PM</option>
                                                                <option value="11:00 PM">11:00 PM</option>
                                                                <option value="12:00 AM">12:00 AM</option>
                                                                <option value="closed">Closed</option>            </select>
                                                                          </div>
                                                                          <div class="col-lg-4">
                                                                            <select class="form-select" aria-label="Default select example" name="thur_pm">
                                                                                            <option value="12:00 PM">12:00 PM</option>
                                                                                            <option>Please Select</option>
                                                                <option value="12:00 AM">12:00 AM</option>
                                                                <option value="01:00 AM">01:00 AM</option>
                                                                <option value="02:00 AM">02:00 AM</option>
                                                                <option value="03:00 AM">03:00 AM</option>
                                                                <option value="04:00 AM">04:00 AM</option>
                                                                <option value="05:00 AM">05:00 AM</option>
                                                                <option value="06:00 AM">06:00 AM</option>
                                                                <option value="07:00 AM">07:00 AM</option>
                                                                <option value="08:00 AM">08:00 AM</option>
                                                                <option value="09:00 AM">09:00 AM</option>
                                                                <option value="10:00 AM">10:00 AM</option>
                                                                <option value="11:00 AM">11:00 AM</option>
                                                                <option value="12:00 PM">12:00 PM</option>
                                                                <option value="01:00 PM">01:00 PM</option>
                                                                <option value="02:00 PM">02:00 PM</option>
                                                                <option value="03:00 PM">03:00 PM</option>
                                                                <option value="04:00 PM">04:00 PM</option>
                                                                <option value="05:00 PM">05:00 PM</option>
                                                                <option value="06:00 PM">06:00 PM</option>
                                                                <option value="07:00 PM">07:00 PM</option>
                                                                <option value="08:00 PM">08:00 PM</option>
                                                                <option value="09:00 PM">09:00 PM</option>
                                                                <option value="10:00 PM">10:00 PM</option>
                                                                <option value="11:00 PM">11:00 PM</option>
                                                                <option value="12:00 AM">12:00 AM</option>
                                                                <option value="closed">Closed</option>            </select>
                                                                          </div>
                                                                          <div class="col-lg-4">
                                                                            <label for="exampleInput">Friday </label>
                                                                          </div>
                                                                          <div class="col-lg-4">
                                                                            <select class="form-select" aria-label="Default select example" name="fri_am">
                                                                                            <option value="03:00 AM">03:00 AM</option>
                                                                                            <option>Please Select</option>
                                                                <option value="12:00 AM">12:00 AM</option>
                                                                <option value="01:00 AM">01:00 AM</option>
                                                                <option value="02:00 AM">02:00 AM</option>
                                                                <option value="03:00 AM">03:00 AM</option>
                                                                <option value="04:00 AM">04:00 AM</option>
                                                                <option value="05:00 AM">05:00 AM</option>
                                                                <option value="06:00 AM">06:00 AM</option>
                                                                <option value="07:00 AM">07:00 AM</option>
                                                                <option value="08:00 AM">08:00 AM</option>
                                                                <option value="09:00 AM">09:00 AM</option>
                                                                <option value="10:00 AM">10:00 AM</option>
                                                                <option value="11:00 AM">11:00 AM</option>
                                                                <option value="12:00 PM">12:00 PM</option>
                                                                <option value="01:00 PM">01:00 PM</option>
                                                                <option value="02:00 PM">02:00 PM</option>
                                                                <option value="03:00 PM">03:00 PM</option>
                                                                <option value="04:00 PM">04:00 PM</option>
                                                                <option value="05:00 PM">05:00 PM</option>
                                                                <option value="06:00 PM">06:00 PM</option>
                                                                <option value="07:00 PM">07:00 PM</option>
                                                                <option value="08:00 PM">08:00 PM</option>
                                                                <option value="09:00 PM">09:00 PM</option>
                                                                <option value="10:00 PM">10:00 PM</option>
                                                                <option value="11:00 PM">11:00 PM</option>
                                                                <option value="12:00 AM">12:00 AM</option>
                                                                <option value="closed">Closed</option>            </select>
                                                                          </div>
                                                                          <div class="col-lg-4">
                                                                            <select class="form-select" aria-label="Default select example" name="fri_pm">
                                                                                            <option value="11:00 AM">11:00 AM</option>
                                                                                            <option>Please Select</option>
                                                                <option value="12:00 AM">12:00 AM</option>
                                                                <option value="01:00 AM">01:00 AM</option>
                                                                <option value="02:00 AM">02:00 AM</option>
                                                                <option value="03:00 AM">03:00 AM</option>
                                                                <option value="04:00 AM">04:00 AM</option>
                                                                <option value="05:00 AM">05:00 AM</option>
                                                                <option value="06:00 AM">06:00 AM</option>
                                                                <option value="07:00 AM">07:00 AM</option>
                                                                <option value="08:00 AM">08:00 AM</option>
                                                                <option value="09:00 AM">09:00 AM</option>
                                                                <option value="10:00 AM">10:00 AM</option>
                                                                <option value="11:00 AM">11:00 AM</option>
                                                                <option value="12:00 PM">12:00 PM</option>
                                                                <option value="01:00 PM">01:00 PM</option>
                                                                <option value="02:00 PM">02:00 PM</option>
                                                                <option value="03:00 PM">03:00 PM</option>
                                                                <option value="04:00 PM">04:00 PM</option>
                                                                <option value="05:00 PM">05:00 PM</option>
                                                                <option value="06:00 PM">06:00 PM</option>
                                                                <option value="07:00 PM">07:00 PM</option>
                                                                <option value="08:00 PM">08:00 PM</option>
                                                                <option value="09:00 PM">09:00 PM</option>
                                                                <option value="10:00 PM">10:00 PM</option>
                                                                <option value="11:00 PM">11:00 PM</option>
                                                                <option value="12:00 AM">12:00 AM</option>
                                                                <option value="closed">Closed</option>            </select>
                                                                          </div>
                                                                          <div class="col-lg-4">
                                                                            <label for="exampleInput">Saturday </label>
                                                                          </div>
                                                                          <div class="col-lg-4">
                                                                            <select class="form-select" aria-label="Default select example" name="sat_am">
                                                                                            <option value="01:00 AM">01:00 AM</option>
                                                                                            <option>Please Select</option>
                                                                <option value="12:00 AM">12:00 AM</option>
                                                                <option value="01:00 AM">01:00 AM</option>
                                                                <option value="02:00 AM">02:00 AM</option>
                                                                <option value="03:00 AM">03:00 AM</option>
                                                                <option value="04:00 AM">04:00 AM</option>
                                                                <option value="05:00 AM">05:00 AM</option>
                                                                <option value="06:00 AM">06:00 AM</option>
                                                                <option value="07:00 AM">07:00 AM</option>
                                                                <option value="08:00 AM">08:00 AM</option>
                                                                <option value="09:00 AM">09:00 AM</option>
                                                                <option value="10:00 AM">10:00 AM</option>
                                                                <option value="11:00 AM">11:00 AM</option>
                                                                <option value="12:00 PM">12:00 PM</option>
                                                                <option value="01:00 PM">01:00 PM</option>
                                                                <option value="02:00 PM">02:00 PM</option>
                                                                <option value="03:00 PM">03:00 PM</option>
                                                                <option value="04:00 PM">04:00 PM</option>
                                                                <option value="05:00 PM">05:00 PM</option>
                                                                <option value="06:00 PM">06:00 PM</option>
                                                                <option value="07:00 PM">07:00 PM</option>
                                                                <option value="08:00 PM">08:00 PM</option>
                                                                <option value="09:00 PM">09:00 PM</option>
                                                                <option value="10:00 PM">10:00 PM</option>
                                                                <option value="11:00 PM">11:00 PM</option>
                                                                <option value="12:00 AM">12:00 AM</option>
                                                                <option value="closed">Closed</option>            </select>
                                                                          </div>
                                                                          <div class="col-lg-4">
                                                                            <select class="form-select" aria-label="Default select example" name="sat_pm">
                                                                                            <option value="12:00 AM">12:00 AM</option>
                                                                                            <option>Please Select</option>
                                                                <option value="12:00 AM">12:00 AM</option>
                                                                <option value="01:00 AM">01:00 AM</option>
                                                                <option value="02:00 AM">02:00 AM</option>
                                                                <option value="03:00 AM">03:00 AM</option>
                                                                <option value="04:00 AM">04:00 AM</option>
                                                                <option value="05:00 AM">05:00 AM</option>
                                                                <option value="06:00 AM">06:00 AM</option>
                                                                <option value="07:00 AM">07:00 AM</option>
                                                                <option value="08:00 AM">08:00 AM</option>
                                                                <option value="09:00 AM">09:00 AM</option>
                                                                <option value="10:00 AM">10:00 AM</option>
                                                                <option value="11:00 AM">11:00 AM</option>
                                                                <option value="12:00 PM">12:00 PM</option>
                                                                <option value="01:00 PM">01:00 PM</option>
                                                                <option value="02:00 PM">02:00 PM</option>
                                                                <option value="03:00 PM">03:00 PM</option>
                                                                <option value="04:00 PM">04:00 PM</option>
                                                                <option value="05:00 PM">05:00 PM</option>
                                                                <option value="06:00 PM">06:00 PM</option>
                                                                <option value="07:00 PM">07:00 PM</option>
                                                                <option value="08:00 PM">08:00 PM</option>
                                                                <option value="09:00 PM">09:00 PM</option>
                                                                <option value="10:00 PM">10:00 PM</option>
                                                                <option value="11:00 PM">11:00 PM</option>
                                                                <option value="12:00 AM">12:00 AM</option>
                                                                <option value="closed">Closed</option>            </select>
                                                                          </div>
                                                                          <div class="col-lg-4">
                                                                            <label for="exampleInput">Sunday </label>
                                                                          </div>
                                                                          <div class="col-lg-4">
                                                                            <select class="form-select" aria-label="Default select example" name="sun_am">.
                                                                                            <option value="02:00 AM">02:00 AM</option>
                                                                                            <option>Please Select</option>
                                                                <option value="12:00 AM">12:00 AM</option>
                                                                <option value="01:00 AM">01:00 AM</option>
                                                                <option value="02:00 AM">02:00 AM</option>
                                                                <option value="03:00 AM">03:00 AM</option>
                                                                <option value="04:00 AM">04:00 AM</option>
                                                                <option value="05:00 AM">05:00 AM</option>
                                                                <option value="06:00 AM">06:00 AM</option>
                                                                <option value="07:00 AM">07:00 AM</option>
                                                                <option value="08:00 AM">08:00 AM</option>
                                                                <option value="09:00 AM">09:00 AM</option>
                                                                <option value="10:00 AM">10:00 AM</option>
                                                                <option value="11:00 AM">11:00 AM</option>
                                                                <option value="12:00 PM">12:00 PM</option>
                                                                <option value="01:00 PM">01:00 PM</option>
                                                                <option value="02:00 PM">02:00 PM</option>
                                                                <option value="03:00 PM">03:00 PM</option>
                                                                <option value="04:00 PM">04:00 PM</option>
                                                                <option value="05:00 PM">05:00 PM</option>
                                                                <option value="06:00 PM">06:00 PM</option>
                                                                <option value="07:00 PM">07:00 PM</option>
                                                                <option value="08:00 PM">08:00 PM</option>
                                                                <option value="09:00 PM">09:00 PM</option>
                                                                <option value="10:00 PM">10:00 PM</option>
                                                                <option value="11:00 PM">11:00 PM</option>
                                                                <option value="12:00 AM">12:00 AM</option>
                                                                <option value="closed">Closed</option>            </select>
                                                                          </div>
                                                                          <div class="col-lg-4">
                                                                            <select class="form-select" aria-label="Default select example" name="sun_pm">
                                                                                            <option value="04:00 PM">04:00 PM</option>
                                                                                            <option>Please Select</option>
                                                                <option value="12:00 AM">12:00 AM</option>
                                                                <option value="01:00 AM">01:00 AM</option>
                                                                <option value="02:00 AM">02:00 AM</option>
                                                                <option value="03:00 AM">03:00 AM</option>
                                                                <option value="04:00 AM">04:00 AM</option>
                                                                <option value="05:00 AM">05:00 AM</option>
                                                                <option value="06:00 AM">06:00 AM</option>
                                                                <option value="07:00 AM">07:00 AM</option>
                                                                <option value="08:00 AM">08:00 AM</option>
                                                                <option value="09:00 AM">09:00 AM</option>
                                                                <option value="10:00 AM">10:00 AM</option>
                                                                <option value="11:00 AM">11:00 AM</option>
                                                                <option value="12:00 PM">12:00 PM</option>
                                                                <option value="01:00 PM">01:00 PM</option>
                                                                <option value="02:00 PM">02:00 PM</option>
                                                                <option value="03:00 PM">03:00 PM</option>
                                                                <option value="04:00 PM">04:00 PM</option>
                                                                <option value="05:00 PM">05:00 PM</option>
                                                                <option value="06:00 PM">06:00 PM</option>
                                                                <option value="07:00 PM">07:00 PM</option>
                                                                <option value="08:00 PM">08:00 PM</option>
                                                                <option value="09:00 PM">09:00 PM</option>
                                                                <option value="10:00 PM">10:00 PM</option>
                                                                <option value="11:00 PM">11:00 PM</option>
                                                                <option value="12:00 AM">12:00 AM</option>
                                                                <option value="closed">Closed</option>            
                                                                </select>
                                                                          </div>
                                                                        </div>
                                                                      </div>
                                                        <hr>
                                                         <div class="row">
                                                            <div class="col-lg-6 col-md-6 form-group">
                                                                <label class="labels">Website Url</label>
                                                                <input type="text" class="form-control" name="page_name" placeholder="Enter Business Website Url" required>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 form-group">
                                                                <label class="labels">Business Offers</label>
                                                                <input type="text" class="form-control" name="businessemail"  required>
                                                            </div>
                                                        </div>
                                                         <hr>
                                                        <div class="form-group ">
                                                            <label class="col-xs-12" style="margin-top: 20px;">Social Media Links</label>
                                                            <div class="row mb-3">
                                                              <div class="col-xs-12 col-sm-6">
                                                                <input class="form-control form-control_twitter" type="text" style="font-family:Arial, FontAwesome" placeholder="https://twitter.com/" name="twitter" value="">
                                                                          </div>
                                                              <div class="col-xs-12 col-sm-6">
                                                                <input class="form-control form-control_facebook" type="text" style="font-family:Arial, FontAwesome" placeholder="https://www.facebook.com/" name="facebook" value="">
                                                                          </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                              <div class="col-xs-12 col-sm-6">
                                                                <input class="form-control form-control_twitter" type="text" style="font-family:Arial, FontAwesome" placeholder="https://twitter.com/" name="twitter" value="">
                                                                          </div>
                                                              <div class="col-xs-12 col-sm-6">
                                                                <input class="form-control form-control_facebook" type="text" style="font-family:Arial, FontAwesome" placeholder="https://www.facebook.com/" name="facebook" value="">
                                                                          </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                            <div class="col-xs-12 col-sm-6">
                                                                <input class="form-control form-control_twitter" type="text" style="font-family:Arial, FontAwesome" placeholder="https://twitter.com/" name="twitter" value="">
                                                            </div>
                                                              <div class="col-xs-12 col-sm-6 ">
                                                                <input class="form-control form-control_facebook" type="text" style="font-family:Arial, FontAwesome" placeholder="https://www.facebook.com/" name="facebook" value="">
                                                                </div>
                                                            </div>
                                                          </div> 
                                                           <hr>  
                                                          <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <input type="checkbox" id="customCheck1" name="customCheck1" value="Title">
                                                                <label for="customCheck1" class="mb-0"> Make it Public or Private</label>
                                                            </div>
                                                           
                                                        </div>
                                                        <div class="col-lg-12 mt-4">
                                                            <div class="text-center">                   
                                                                <button type="submit" class="btn profile-button">Create Page</button>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                          </div>
                         
                        </div>

                       

                       
                    </div>



<!-- Modal -->
        <div class="modal fade" id="reminderModal" tabindex="-1" aria-labelledby="reminderModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            <!-- <div class="modal-header">
                <h3 class="modal-title fs-5" id="reminderModalLabel">Reminder</h3>
                <button type="button " 
                style="color: white; background: linear-gradient(90deg, rgba(220, 114, 40, 1) 50%, rgba(205, 89, 8, 1) 100%);"
                 class="btn-close border-0 cancel_modal" data-dismiss="modal" aria-label="Close"><b>x</b></button>
            </div> -->
            <div class="modal-body">
                <div class="d-flex justify-content-end">
                 <button type="button " 
                 style="color: white; background: linear-gradient(90deg, rgba(220, 114, 40, 1) 50%, rgba(205, 89, 8, 1) 100%);"
                 class="btn-close border-0 cancel_modal" data-dismiss="modal" aria-label="Close"><b>x</b></button>
                </div>
               <div class="row align-items-center">
                <div class="col-md-5 mb-3 mb-md-0 text-center">
                    <img class=" " src="https://www.finderspage.com/public/uploads/logos/16635000611696-logo.png" alt="">
                </div>
                <div class="col-md-7 ">
                <p class="text-center">Remember to clear your cache from your computer or mobile device, it will help load new updates on FindersPage.</p>
                <div class="d-flex justify-content-center mt-3">
                <button type="button" class="btn btn-secondary cancel_modal mx-1" data-dismiss="modal">Cancel</button>
                <a href="{{url('clear-cache')}}"  class="btn btn-primary mx-1 " >Continue</a>
                </div>
                </div>
               </div>
            </div>
            <!-- <div class="modal-footer">
               
            </div> -->
            </div>
        </div>
        </div>


<!-- Modal -->
<div class="modal fade" id="staticBackdrop_services" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">  <i class="fa fa-info-circle fa-2xl icon"></i> </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="text-info-services">
      Just a friendly reminder if you want customers to reach you outside of FindersPage you will need to make your contact details visible to the public when you create a post.
      </div>
      </div>
    </div>
  </div>
</div>

            <script type="text/javascript">
             $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
            // $( document ).ready(function() {
            //     $(".pro_file").click(function(){
            //        var prc = $('.percent').val();
            //        // alert(prc);
            //         if(prc != '100'){
            //             event.preventDefault();
            //             $("#profile_eer").removeClass('d-none');
            //             }  
                    
            //     });
            // });

        </script>

 </div>
@if($User->first_time_login == 0)
<script>
    $(document).ready(function() {
       
        if (!sessionStorage.getItem('modalShown_business')) {
       
        setTimeout(function() {
            $('#staticBackdrop_services').modal('show');
          
            sessionStorage.setItem('modalShown_business', 'true');
        }, 5000); // 5000 milliseconds = 5 seconds
        }
    });
@endif
</script>
<script>
    $(document).ready(function() {
        // Check if the modal has been shown before using localStorage
        if (!localStorage.getItem('modalShown')) {
            console.log('Modal Shown');
            setTimeout(function() {
                $('#reminderModal').modal('show');
                localStorage.setItem('modalShown', 'true');
            }, 3000);
        }

        // Event listener for when the modal is hidden
        $('#reminderModal').on('hidden.bs.modal', function () {
            // Do nothing here to prevent the modal from being shown again in the session
            console.log('It works');
        });

        // Optional: If you want to handle the close button differently
        $('.cancel_modal').on('click', function() {
            console.log('Its working');
        });
    });



    
    
</script>
@endsection