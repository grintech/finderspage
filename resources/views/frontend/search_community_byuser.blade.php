<div class="row">
    @foreach($community as $real)
    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
        <div class="feature-box">
            <a href="{{ route('jobpost', $real->id) }}">
                <div id="demo-new" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @php
                        $neimg = trim($real->image1, '[""]');
                        $img = explode('","', $neimg);
                        @endphp
                        @if($real->image1)
                        <img src="{{ asset('images_blog_img') . '/' . $img[0] }}" alt="{{ $real->title }}" class="d-block w-100">
                        @else
                        <img src="{{ asset('/new_assets/assets/images/home.png') }}" alt="New York" class="d-block w-100">
                        @endif
                    </div>
                </div>
                <p class="job-title"><b>{{ ucfirst($real->title) }}</b></p>
                <div class="location-job-title">
                    <div class="job-type">
                        <div class="main-days-frame">
                            <span class="days-box">
                                {{ \Carbon\Carbon::parse($real->created)->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    @endforeach
</div>