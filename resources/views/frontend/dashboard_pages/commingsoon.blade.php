@extends('layouts.user_dashboard.userdashboardlayout')
@section('content')
<seciton id="about-description" class="coming-soon">
    <div class="container">
        <div class="row">
            <!-- <div class="col-lg-6">
                <div class="description-img">
                    <img src="https://finder.harjassinfotech.org/public/front/images/about_img.png" class="img-fluid">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="description-content">
                    <h2>We Are Coming Soon</h2>    
                </div>
            </div>
        </div> -->
        <div class="coming">
        <img src="{{asset('front/images/coming-soon.png')}}" alt="coming-soon.png" class="img-fluid">
        </div>
    </div>
</div>
</section>


@endsection