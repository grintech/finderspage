@extends('layouts.frontlayout')
@section('content')
<div class="error_section">
    <div class="container">
        <div class="row">
            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 all_text">
                <div class="error_img">
                    <div class="col-sm-12 ">
                        <div class="col-sm-10 col-sm-offset-1 text-center">
                            <div class="four_zero_four_bg">
                                <h1 class="text-center ">404</h1>
                            </div>

                            <div class="contant_box_404">
                                <h3 class="h2">
                                    Look like you're lost
                                </h3>

                                <p>the page you are looking for not avaible!</p>

                                <a href="{{route('homepage.index')}}" class="link_404">Go to Home</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<style>
    /* .page_404 {
        padding: 50px 0;
        background: #fff;
        font-family: 'Arvo', serif;
    }

    .page_404 img {
        width: 100%;
    } */
    .all_text {
        margin-left: 60px;
    }

    @media only screen and (max-width: 600px) {
        .all_text {
            margin-left: 0px;
        }
    }

    .four_zero_four_bg {

        background-image: url(https://cdn.dribbble.com/users/285475/screenshots/2083086/dribbble_1.gif);
        height: 400px;
        background-position: center;
    }


    .four_zero_four_bg h1 {
        font-size: 80px;
    }

    .four_zero_four_bg h3 {
        font-size: 80px;
    }

    .link_404 {
        color: #fff !important;
        padding: 10px 20px;
        background: #39ac31;
        margin: 40px 0;
        display: inline-block;
    }

    .contant_box_404 {
        margin-top: -50px;
    }
</style>
@endsection