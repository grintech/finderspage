@extends('layouts.frontlayout')
@section('content')
<style>
    .fa {
        font-family: 'FontAwesome';
    }
    .calend {
        display: flex;
        gap: 1rem;

    }

    #banner {
        position: relative;
    }

    #banner .inner_cal {
        text-align: center;
        background-color: #DEFFE7;
        width: 100px;
        height: 100px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        border: 2px dashed #00A44B;
        border-radius: 10px;
        margin-top: -3rem;
        margin-left: 1rem;

    }

    .date_time {
        padding: 13px 0;
    }

    .date_time span {
        color: #007435;
        font-size: 20px;
        font-family: 'Montserrat';
        font-weight: 600 !important;
        line-height: 24.38px;
    }

    .date_time p {
        font-family: 'Montserrat';
        font-size: 16px;
        line-height: 19.5px;
        font-weight: 400;

    }

    .inner_cal span {
        color: #00A44B;
        font-size: 50px;
        line-height: 30px;
        padding: 20px;
        font-weight: 600;
        font-family: Montserrat;
    }

    .btn_cust {
        background-color: #181818;
        padding: 10px 30px;
        color: #fff;
        border-radius: 40px;
        border: none;
    }

    .interesded {
        display: flex;
        justify-content: end;
        padding: 13px 0;
        align-items: center;
    }

    .btn_cst1 {
        border: none;
        background: none;
    }

    .interesded .dropdown {
        border-radius: 46px;
        box-shadow: 0px 0px 8px -2px;
        padding: 0px 3px
    }

    ul.dropdown-menu {
        top: 27px;
        left: 0;
    }

    .dropdown-menu-dark .dropdown-item.active,
    .dropdown-menu-dark .dropdown-item:active {
        background-color: #998049;
    }

    .dropdown:hover .dropdown-menu,
    .one_third {
        display: block;
        overflow: visible !important;
    }

    .dropdown-menu {
        margin-top: 0;
    }

    ul.dropdown-menu {
        top: -1px;
        right: 0;
    }

    .event h1 {
        font-family: 'Cal Roman Capitals';
        font-weight: 400 !important;
        font-size: 48px;
        line-height: 48px;
    }

    .event ul li {
        font-family: 'Montserrat';
        font-size: 16px;
        font-weight: 400;
        line-height: 42px;
    }

    .event p {
        font-family: 'Montserrat';
        font-size: 16px;
        font-weight: 400;
        line-height: 42px;
    }

    @media (max-width:990px) {
        .overlay {
            width: 84% !important;
            height: 120px !important
        }

        .feature_inn {
            margin-top: 2rem;
        }

        .main_title_business_post {
            padding-top: 0px;
        }

        .social {
            display: block !important;
            text-align: center !important;
        }

        .event h3 {
            font-weight: 600;
        }.calend{
            display:block;
        }
        .date_time span{
            font-size: 17px;
        }
        .interesded {
    justify-content: center;
}
#banner .inner_cal{
    margin-top: 15px!important;
    margin-left: 97px!important;
}
        .event h3 {
            font-size: 15px;
            font-weight: 400;
            line-height: 36px;
        }
        .event p {
    font-size: 14px;
    line-height: 37px;
}
    }

    .event h1 {
        font-size: 35px !important;
        line-height: 35px !important;
    }

    .social_icons ul {
        gap: .5rem !important;
    }

    .social p {
        margin-bottom: 2rem;
    }

    .social {
        margin: 22px 0 !important;
    }

    .event span {
        color: #998049;
    }
    }


    .map_cst {
        box-shadow: 0px 0px 30px rgba(0, 0, 0, 0.15);
        border-radius: 10px
    }

    iframe {
        border-radius: 10px;
    }

    .map_cst p {
        font-family: 'Montserrat';
        font-size: 16px;
        font-weight: 400;
        line-height: 19.5px;
    }

    .event_created {
        box-shadow: 0px 0px 30px rgba(0, 0, 0, 0.15);
        border-radius: 10px;
        margin-top: 2rem;
        padding: 15px
    }

    .event_created .text_cst {
        font-family: 'Montserrat';
        font-weight: 500;
        font-size: 20px;
        line-height: 19.5px;
        padding: 2px 0px 12px 0px;
    }

    .event_created .profile {
        font-family: 'Montserrat';
        font-weight: 500;
        font-size: 13px;
        color: #808080;
        line-height: 15.5px;
    }

    .event_created .profile p {
        padding: 10px;
    }

    .event_created ul li {
        font-family: 'Montserrat';
        font-weight: 400;
        font-size: 16px;
        line-height: 32px;
    }

    .profile {
        display: flex;
    }

    .profile span {
        font-family: 'Montserrat';
        font-weight: 600;
        font-size: 13px;
        line-height: 15.5px;
        color: #808080;
    }

    .social {
        font-family: 'Montserrat';
        font-size: 14px;
        font-weight: 500;
        line-height: 17.07px;
        display: flex;
        align-items: center;
    }

    .social p {
        margin-right: 2rem;
    }



    .social_icons i {
        box-shadow: 0px 0px 20px -10px #000;
        border-radius: 100%;
        font-size: 20px;
        padding: 10px;
        width: 42px;
        height: 42px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .related_events {
        font-family: 'Cal Roman Capitals';
        font-size: 36px;
        font-weight: 300;
        line-height: 36px;
        text-align: center;
    }

    .posted_by {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    /* .one_third{
        z-index:1;
    } */
    #feature #row {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    #feature #row img {
        border-radius: 20px;
    }

    #feature h1 {
        font-family: 'Cal Roman Capitals';
        font-weight: 400 !important;
        font-size: 36px;
        line-height: 36px;
        text-decoration: capitilizes;
        text-align: center;
        margin-bottom: 2rem;
    }

    .feature_inn {
        position: relative;
        display: flex;
        justify-content: center;
    }

    .text {
        position: absolute;
        top: 40px;
        text-align: center;
    }

    .find_feature_section {
        padding: 30px 0 !important;
    }

    .text span {
        font-family: 'Montserrat';
        font-weight: 700;
        font-size: 18px;
        line-height: 21.94px;
        color: #fff !important;
    }

    .overlay {
        position: absolute;
        background-color: #00000069;
        width: 100%;
        height: 107px;
        border-radius: 20px;
    }
</style>

<?php
use App\Models\User; 
use App\Models\Voting;
$multiple = json_decode($post->image, true);
$date = date('d M Y',strtotime($post->event_start_date));
$end_date = date('d M Y',strtotime($post->event_end_date));
$day = date('l',strtotime($post->event_start_date));
$date_1 = date('d',strtotime($post->event_start_date));
$date_2 = date('M Y',strtotime($post->event_start_date));
$allFiles = $multiple && is_array($multiple) ? $multiple : ($post->image ? [$post->image] : null);

$ques = DB::table('poll_questions')->where('post_id',$post->id)->first();
$question = '';
$qid = '';
$options = array();
if($ques && $ques->title != '') {
    $question = $ques->title;
    $qid = $ques->id;
    $options = DB::table('poll_options')->where('poll_options.question_id',$ques->id)->leftJoin('votings', 'poll_options.id', '=', 'votings.option_id')->select('poll_options.id as id', 'poll_options.title as title', DB::raw("count(votings.option_id) as count"))->groupBy('poll_options.id')->get();
}

   ?>


<!-- Breadcrumb -->
<div class="breadcrumb-main">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <a href="#"> Home / Posts / {{$post->title}}  </a>
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


<section id="banner">
     @include('admin.partials.flash_messages')
    <div class="container">
        @if($allFiles)
        @foreach($post->getResizeImagesAttribute() as $key=>$a)
        @if($key == 0)
           <img width="1200px" height="250px" src="{{url(isset($a['original'])?$a['original']:'')}}" class="img-fluid1" alt="">
           @endif
        @endforeach
        @endif
        
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="calend">
                    <div class="inner_cal">
                        <span>{{$date_1}}</span>
                        <p>{{$date_2}}</p>
                    </div>
                    <div class="date_time">
                        <span>{{$day}}, {{$date}} {{$post->event_start_time}} To {{$end_date}} {{$post->event_end_time}}</span>
                        <p>{{$post->event_location}}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4" style="display: none;">
                <div class="interesded">
                    <button type="button" class="btn_cust me-3">Interested</button>
                    <div class="dropdown">
                        <button class="btn" type="button" id="dropdownMenuButton2" aria-expanded="false">
                            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                            <li><a class="dropdown-item" href="#">interesded1</a></li>
                            <li><a class="dropdown-item" href="#">interesded1</a></li>
                            <li><a class="dropdown-item" href="#">interesded1</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 mt-5">
                <div class="event">
                    <h1>{{$post->title}}</h1>
                    <h3>Event Detail</h3>
                    <ul>
                        <li><b>People Interested:</b> 300</li>
                        <li><b>Event By :</b> <span>{{$user_info->first_name.''.$user_info->last_name}}</span></li>
                        <li><b>Location :</b> {{$post->event_location}}</li>
                        <!-- <li><b>Duration :</b> 2 Hours</li> -->
                    </ul>
                    <p><?php echo $post->description ?></p>
                </div>
                <div class="social d-flex mt-5">
                    <p>Social Media Links</p>
                    <div class="social_icons">
                        <ul class="d-flex" style="gap:1rem;">
                            @if($post->twitter)
                            <li><i class="fa fa-twitter" style="color: #03a9f4;" aria-hidden="true"></i></li>
                            @endif
                            @if($post->facebook)
                            <li><i class="fa fa-facebook" style="color:#4867aa;" aria-hidden="true"></i></li>
                            @endif
                            @if($post->instagram)
                            <li><i class="fa fa-instagram" style="color:#e9008d;" aria-hidden="true"></i></li>
                            @endif
                            @if($post->linkedin)
                            <li><i class="fa fa-linkedin" style="color:#0077b5;" aria-hidden="true"></i></li>
                            @endif
                            @if($post->youtube)
                            <li><i class="fa fa-youtube-play" style="color:#fe0000" aria-hidden="true"></i></li>
                            @endif
                            @if($post->whatsapp)
                            <li><i class="fa fa-whatsapp" style="color: #39ae41;" aria-hidden="true"></i></li>
                            @endif

                            @if($post->twitter == "" && $post->facebook == "" && $post->instagram == "" && $post->linkedin == "" && $post->youtube == "" && $post->whatsapp == "")
                                <li>N/A</li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mt-5">
                <div class="map_cst">
                    @if(!empty($post->event_location))
                    <div class="mapouter"><div class="gmap_canvas"><iframe width="100%" height="100%" id="gmap_canvas" src="https://maps.google.com/maps?q=<?php echo $post->event_location; ?>&t=k&z=15&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe><a href="https://2yu.co">2yu</a><br><style>.mapouter{position:relative;text-align:right;height:195px;width:100%;}</style><a href="https://embedgooglemap.2yu.co/">html embed google map</a><style>.gmap_canvas {overflow:hidden;background:none!important;height:195px;width:100%;}</style></div></div>
                    @else
                    <div class="mapouter"><div class="gmap_canvas"><iframe width="100%" height="100%" id="gmap_canvas" src="https://maps.google.com/maps?q=United States&t=k&z=15&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe><a href="https://2yu.co">2yu</a><br><style>.mapouter{position:relative;text-align:right;height:100%;width:100%;}</style><a href="https://embedgooglemap.2yu.co/">html embed google map</a><style>.gmap_canvas {overflow:hidden;background:none!important;height:100%;width:100%;}</style></div></div>
                    @endif

                    <p class="p-2">{{$post->event_location}}</p>
                </div>
                <div class="event_created">
                    <p class="text_cst">Event Created By</p>
                    <div class="profile">
                        <img height="40" width="40" src="{{$user_info->image!= ''? url('assets/images/profile/'.$user_info->image):url('/front/images/user3.png')}}" class="img-fluid" alt="">
                        <p>{{ $user_info->first_name.' '.$user_info->last_name }} <br><span>Nov 12, 2022</span></p>
                    </div>
                    <ul>
                       @if($user_info->phone) <li> <img src="{{url('images/phone.png')}}" class="img-fluid me-2" alt="Image"> {{$user_info->phone}}</li>
                       @endif
                        <li><img src="{{url('images/gmail.png')}}" class="img-fluid me-2" alt="Image"> {{$user_info->email}}</li>
                    </ul>
                </div> 

                <form method="post" id="vote_form" action="<?php echo route('save_vote') ?>" class="form-validation">
                    <input type="hidden" name="post_id" value="{{base64_encode($post->id)}}">
                    <input type="hidden" name="question_id" value="{{$qid}}">
        {{ @csrf_field() }}
                <div class="event_created">
                    <p class="text_cst">{{$question}}</p>
                     <div class="form-group ">

                        @foreach($options as $o)
                        <div class="radio">
                          <div class="form-check">
                            <input class="form-check-input vote_" type="radio" name="vote" id="flexRadioDefault1" value="{{$o->id}}">
                            <label class="form-check-label" for="flexRadioDefault1">
                             {{$o->title}} ( {{$o->count}})
                            </label>
                          </div>
                        </div>
                        @endforeach
                        
          </div>  
                  
                </div>
            </form>
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
                                <!-- <div class="tab">
                                    <button class="tablinks active" onclick="openCity(event, 'tab1')">All</button>
                                    <button class="tablinks" onclick="openCity(event, 'tab1')">FIND A JOB</button>
                                    <button class="tablinks" onclick="openCity(event, 'tab1')">REAL
                                        ESTATE/LODGING</button>
                                    <button class="tablinks" onclick="openCity(event, 'tab1')">WELCOME TO OUR
                                        COMMUNITY</button>
                                    <button class="tablinks" onclick="openCity(event, 'tab1')">ONLINE SHOPPING</button>
                                </div> -->
                                <h1 class="related_events p-4">Related Events</h1>
                                <!-- <hr class="mt-0"> -->
                                <div id="tab1">
                                       <div class="row">
                                    @foreach($other_post as $os)
                                 
                                      <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                <div class="one_third">
                                    <a href="{{url('/')}}/post/{{base64_encode($os->id)}}">
                                        <div class="img_area">
                                            @if($os->image && $os->image != '')
                                        <img src="{{url(@$os->getOneResizeImagesAttribute()['medium'])}}" alt="Image" />
                                        @else
                                        <img src="{{url('/')}}front/images/3.png" alt="Image" />
                                        @endif
                                    </div>
                                    

                                    <div class="posted_by">
                                        <a href="{{url('/')}}/post/{{base64_encode($os->id)}}/edit">
                                            <div class="left_area">
                                                <img src="{{$os->user->image!= ''? url('assets/images/profile/'.$os->user->image):url('/front/images/user3.png')}}" alt="Image" />
                                            </div>
                                            <div class="right_area">
                                                <div class="meta_area">
                                                <div class="name">{{ $os->title }}</div>
                                                <div class="by">by {{ $os->user->first_name.' '.$os->user->last_name }}</div>
                                              
                                                </div>
                                            </div>
                                        </a>
                                          <div class="dropdown">
                                                        <button class="btn" type="button" id="dropdownMenuButton1"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                        </button>
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                            <!-- <li style="display: none;"><a class="dropdown-item" href="#"
                                                                    style="color:#ff0000;">Delete</a></li> -->

                                                            <li><a class="dropdown-item" href="{{ url('/') }}/post/{{ base64_encode($os->id) }}/edit">Edit</a>

                                                            <!-- <li style="display: none;"><a class="dropdown-item" style="border:none;"
                                                                    href="#">Unpublished</a></li> -->
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
<section class="find_feature_category_section">
    <div class="container">
        <div class="row">
            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="find_feature_category_area">
                    <div class="main_title black_title">
                        <h3>Find Feature By Category</h3>
                    </div>
                    <div class="category_area business">
                        <ul class="list-inline">
                            <li>
                                <a href="{{url('/')}}/post/category/2">
                                    <img src="/new-web/public/front/images/c2.png" alt="Image" />
                                    <span class="heading_text">FIND A JOB</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{url('/')}}/post/category/4">
                                    <img src="/new-web/public/front/images/c3.png" alt="Image" />
                                    <span class="heading_text">REAL ESTATE/LODGING</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{url('/')}}/post/category/5">
                                    <img src="/new-web/public/front/images/c4.png" alt="Image" />
                                    <span class="heading_text">WELCOME TO OUR COMMUNITY</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{url('/')}}/post/category/6">
                                    <img src="/new-web/public/front/images/c5.png" alt="Image" />
                                    <span class="heading_text">ONLINE SHOPPING</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script>
  $( document ).ready(function() {
         // alert("The paragraph was clicked.");
        $(".vote_").change(function(){
  // alert("The paragraph was.");

  $("#vote_form").submit();

});
    });

</script>


@endsection