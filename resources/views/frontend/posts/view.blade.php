@extends('layouts.frontlayout')
@section('content')
<?php

use App\Models\User;
use App\Models\UserAuth;

$multiple = json_decode($post->image, true);
$allFiles = $multiple && is_array($multiple) ? $multiple : ($post->image ? [$post->image] : null);
?>

<link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-minimal@4/minimal.css" rel="stylesheet">
<!-- Breadcrumb -->
<div class="breadcrumb-main">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <a href="#"> Home / Posts / {{ $post->title }} </a>
            </div>
        </div>
    </div>
</div>
<!-- //Breadcrumb -->

<?php
$user_info = User::find($post->user_id);
$selectedCategories = Arr::pluck($post->categories, 'id');

$subCateName = Arr::pluck($post->sub_categories, 'title');

$cate_names = Arr::pluck($post->categories, 'title');
?>

<!-- ==== Find Feature Section Start ==== -->
<section class="find_feature_section product-detail-col">
    <div class="container">
        <div class="row">
            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <p style="text-align:center">{{ isset($cate_names[0]) ? $cate_names[0] : '' }} >
                    {{ isset($subCateName[0]) ? $subCateName[0] : '' }}
                </p>


                <div class="main_title black_title inner-product">
                    <h3>{{ $post->title }}</h3>
                    <p style="color:#998049;text-align: center;margin-bottom: 15px;">{{ $post->property_address }}</p>
                    <div class="meta_tag">
                        <img width="50" height="50" src="{{ $user_info->image != '' ? url('assets/images/profile/' . $user_info->image) : url('/front/images/user3.png') }}">
                        <span>by {{ $user_info->first_name . ' ' . $user_info->last_name }} | Sep 15, 2022</span>
                        <a href="{{ url('contact-us/') }}/<?php echo General::encrypt($post->id); ?>" style="margin-top:0 !important"><BUTTON ID="btn_area">Contact </BUTTON></a>

                        <!-- <img src="images/dot.png" class ="display_item"> -->
                        <div class="dropdown">
                            <button class="dropbtn" style=" background-image: url(front/images/dot.png);"></button>
                            <div class="dropdown-content">
                                <a href="#">Report</a>
                                <a href="#">Save Post </a>

                            </div>
                        </div>
                    </div>

                    <!-- <--------------------------------------------------------------------------------------------->
                    <div class="form-group" style="padding-top: 40px;">
                        <div class="row slick-section">
                            <div class="col-xs-12 col-sm-8">
                                <!--  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
                                <div class="slider slider-for">
                                    @if ($allFiles)
                                    @foreach ($post->getResizeImagesAttribute() as $a)
                                    <div><img src="{{ url(isset($a['original']) ? $a['original'] : '') }}" alt="Image">
                                    </div>
                                    @endforeach
                                    @endif
                                </div>

                                <div class="slider slider-nav">

                                    @if ($allFiles)
                                    @foreach ($post->getResizeImagesAttribute() as $a)
                                    <div><img src="{{ url(isset($a['small']) ? $a['small'] : '') }}" alt="Image"></div>
                                    @endforeach
                                    @endif
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-4 align-format">
                                @if (isset($selectedCategories[0]) && $selectedCategories[0] == 4)
                                <h6>PROPERTY DETAIL</h6>
                                <p>Units : {{ $post->units }} </p>
                                <p>Bathrooms: {{ $post->bathroom }}</p>
                                <p>Garage : {{ $post->grage }}</p>
                                <p>Area Sq Ft: {{ $post->area_sq_ft }} Sq Ft</p>
                                <p>Year Built: {{ $post->year_built }}</p>
                                @elseif(isset($selectedCategories[0]) && $selectedCategories[0] == 5)
                                <p>Product Brand Name : {{ $post->brand_name }} </p>
                                <p>Country of Origin: {{ $post->country_origin }}</p>
                                <p>Product Dimensions : {{ $post->product_length }} x {{ $post->product_width }} x
                                    {{ $post->product_height }} inch
                                </p>
                                <p>Color : {{ $post->product_color }}</p>
                                @else
                                <h6>JOB DETAIL</h6>
                                <!-- <p>Product Brand Name : {{ $post->title }} </p> -->
                                <p>Country of Origin: {{ ucfirst($post->location) }}</p>
                                <!-- <p>Product Dimensions : 6 x 5 x 16 inch</p> -->
                                <p>Choices : {{ $post->choices }}</p>
                                @php
                                $benefit = json_decode($post->benifits);
                                $supplement = json_decode($post->supplement);
                                @endphp
                                @if (!is_null($benefit))
                                <p>All Benefits :
                                    @foreach ($benefit as $benefits)
                                    <small>{{ $benefits }},</small>
                                    @endforeach
                                </p>
                                @endif
                                @if (!is_null($supplement))
                                <p>supplement Pay :
                                    @foreach ($supplement as $supp)
                                    <small>{{ $supp }},</small>
                                    @endforeach
                                </p>
                                @endif
                                @if ($post->pay_by == 'range' || !is_null($post->pay_by))
                                <p>{{ $post->pay_by }} : ${{ $post->min_pay }} To ${{ $post->max_pay }} {{$post->rate}}</p>
                                @elseif($post->pay_by == 'range' || !is_null($post->fixed_pay))
                                <p>{{ $post->pay_by }} : ${{ $post->fixed_pay }} </p>
                                @else
                                <p></p>
                                @endif
                                @endif

                                @if (UserAuth::getLoginId() != $post->user_id)
                                <div class="product-btn">
                                    <button type="">Price <span style="padding-left: 8px;font-size: 30px;">$50</span>
                                        <span style="color:red;padding-left: 8px;text-decoration-line: line-through;">$70</span>
                                    </button>
                                    <a href="{{ url('contact-us/') }}/<?php echo General::encrypt($post->id); ?>">Apply Now</a>
                                </div>
                                    @if(!empty(UserAuth::getLoginId()))
                                    <div class="detail-btn">
                                        <button type="button" class="btn btn-primary" id="details">More Details</button>
                                    </div>
                                    @else
                                    <div class="detail-btn">
                                        <a href="{{url('/')}}/signupusers" >
                                        <button type="button" class="btn btn-primary">
                                            More Details
                                        </button>
                                        </a>
                                    </div>
                                    @endif
                                @endif
                               
                                <div class="detail-section">
                                    <h6>PRODUCT DESCRIPTION</h6>
                                    <p style="line-height: 1.3;text-align: justify;"><?php echo $post->description; ?></p>
                                </div>

                                <div class="icon-links">
                                    <i class="fa fa-facebook-square" aria-hidden="true" style="font-family: 'Font Awesome 5 Brands';width: 36px;"></i><br>
                                    <i class="fa fa-twitter" aria-hidden="true" style="font-family: 'Font Awesome 5 Brands';"></i><br>
                                    <i class="fa fa-print" aria-hidden="true"></i><br>
                                    <i class="fa fa-envelope" aria-hidden="true"></i><br>
                                    <i class="fa fa-plus" aria-hidden="true" style="width: 36px;"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
<section class="find_feature_section">
    <div class="container">
        <div class="row">
            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="find_feature_area">
                    <div class="main_title_business">
                        <div class="find_feature_grid">
                            <div class="main_title_business_post">
                                {{-- <div class="tab">
                                        <button class="tablinks active" onclick="openCity(event, 'tab1')">All</button>
                                        <button class="tablinks" onclick="openCity(event, 'tab1')">FIND A JOB</button>
                                        <button class="tablinks" onclick="openCity(event, 'tab1')">REAL
                                            ESTATE/LODGING</button>
                                        <button class="tablinks" onclick="openCity(event, 'tab1')">WELCOME TO OUR
                                            COMMUNITY</button>
                                        <button class="tablinks" onclick="openCity(event, 'tab1')">ONLINE SHOPPING</button>
                                    </div> --}}
                                <h1 class="related_events p-4">Related Post</h1>
                                <!-- <hr class="mt-0"> -->
                                <div id="tab1">
                                    <div class="row">
                                        @foreach ($other_post as $os)
                                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                            <div class="one_third">
                                                <a href="{{ url('/') }}/post/{{ base64_encode($os->id) }}">
                                                    <div class="img_area">
                                                        @if ($os->image && $os->image != '')
                                                        <img src="{{ url(@$os->getOneResizeImagesAttribute()['medium']) }}" alt="Image" />
                                                        @else
                                                        <img src="{{ url('/') }}front/images/3.png" alt="Image" />
                                                        @endif
                                                    </div>


                                                    <div class="posted_by">
                                                        <a href="{{ url('/') }}/post/{{ base64_encode($os->id) }}/edit">
                                                            <div class="left_area">
                                                                <img src="{{ $os->user->image != '' ? url('assets/images/profile/' . $os->user->image) : url('/front/images/user3.png') }}" alt="Image" />
                                                            </div>
                                                            <div class="right_area">
                                                                <div class="meta_area">
                                                                    <div class="name">{{ $os->title }}</div>
                                                                    <div class="by">by
                                                                        {{ $os->user->first_name . ' ' . $os->user->last_name }}
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </a>
                                                        <div class="dropdown">
                                                            <button class="btn" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                            </button>
                                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                                <!-- <li style="display: none;"><a class="dropdown-item" href="#" style="color:#ff0000;">Delete</a></li> -->

                                                                <li><a class="dropdown-item" href="{{ url('/') }}/post/{{ base64_encode($os->id) }}/edit">Edit</a>

                                                                <!-- <li style="display: none;"><a class="dropdown-item" style="border:none;" href="#">Unpublished</a></li> -->
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>


                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        $('#details').on('click', function() {
            Swal.fire({
                title: '<strong><u>User Details</u></strong>',
                icon: 'info',
                html: '<ul><li>Name : - '+ '{{ $user_info->first_name ." ". $user_info->last_name }}'  +'</li><li>Email : - '+ "{{ $user_info->email}}" +'</li><li>Contact No. : - '+ "{{ $user_info->phonenumber ?? 'No contact Number'}}" +'</li></ul>'
                    ,
                showCloseButton: true,
                showCancelButton: false,
                focusConfirm: false,
                confirmButtonText: '<i class="fa fa-thumbs-up"></i> Great!',
                confirmButtonAriaLabel: 'Thumbs up, great!',
            })

        });
    });
</script>



<!-- <------------------------------------------------------------------------------------->

<!-- ==== Find Feature Category Section End ==== -->
@endsection