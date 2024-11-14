@if($matchingRecords->isNotEmpty())
    @foreach($matchingRecords as $record)
        @php
            // Prepare images
            $itemFeaturedImages = explode('","', trim($record->image1, '[""]'));
        @endphp

        <div class="col-lg-3 col-md-3 col-sm-6 col-6">
            <a href="{{ route('real_esate_post', $record->slug) }}">
                <div class="feature-box">
                    <div id="carousel-{{ $record->id }}" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            {{-- Images --}}
                            @foreach($itemFeaturedImages as $key => $image)
                                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                    <img src="{{ asset('images_blog_img/' . $image) }}" 
                                            alt="Image" 
                                            class="d-block w-100" 
                                            onerror="this.onerror=null; this.src='{{ asset('images_blog_img/1688636936.jpg') }}'">
                                </div>
                            @endforeach

                            {{-- Video --}}
                            @if($record->post_video)
                                <div class="carousel-item">
                                    <video controls class="d-block w-100">
                                        <source src="{{ asset('images_blog_video/' . $record->post_video) }}" type="video/mp4">
                                    </video>
                                </div>
                            @endif
                        </div>

                        {{-- Controls --}}
                        <button class="carousel-control-prev" type="button" data-bs-target="#carousel-{{ $record->id }}" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carousel-{{ $record->id }}" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    </div>

                    {{-- Property Details --}}
                    <p><b>{{ $record->title }}</b></p>
                    
                    <div class="job-type">
                        <ul>
                            @if($record->sale_price)
                                <li><span><i class="bi bi-cash"></i></span> ${{ number_format($record->sale_price, 2) }}</li>
                            @endif
                            @if($record->area_sq_ft)
                                <li><span><i class="bi bi-briefcase-fill"></i></span> {{ $record->area_sq_ft }} Sq. Ft</li>
                            @endif
                            @if($record->year_built)
                                <li><span><i class="bi bi-calendar-check"></i></span> {{ $record->year_built }}</li>
                            @endif
                            @if($record->phone)
                                <li><span><i class="bi bi-phone"></i></span> {{ $record->phone }}</li>
                            @endif
                        </ul>
                    </div>
                </div>
            </a>
        </div>
    @endforeach
@else
    <div class="col-12 text-center">
        <h3 style="padding: 5% 0 2%;">We couldn’t find any data, please adjust your filter settings.</h3>
        <a href="{{ url('/') }}">
            <button class="btn create-post-button">Go to Search</button>
        </a>
    </div>
@endif