@if($matchingRecords->isNotEmpty())
    @foreach($matchingRecords as $record)
        <div class="col-lg-3 col-md-4 col-sm-6 col-6">
            <a href="{{ route('community_single_post', $record->id) }}">
                <div class="feature-box">
                    <div id="carousel-{{ $record->id }}" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            {{-- Images --}}
                            @php
                                $itemFeaturedImages = explode('","', trim($record->image1, '[""]'));
                            @endphp
                            
                            @foreach($itemFeaturedImages as $key => $image)
                                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                    <img src="{{ asset('images_blog_img/' . $image) }}" 
                                            alt="Image" 
                                            class="d-block w-100" 
                                            onerror="this.onerror=null; this.src='{{ asset('images_blog_img/default.jpg') }}'">
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

                    {{-- Details --}}
                    <div class="Name"><span>{{ $record->title }}</span></div>
                    <div class="Date"><span><i class="bi bi-calendar"></i> {{ $record->event_start_date }}</span></div>
                    <div class="Time"><span><i class="bi bi-clock"></i> {{ $record->event_start_time }}</span></div>
                    <div class="Location"><span><i class="bi bi-geo-alt"></i> {{ $record->address }}</span></div>

                    {{-- Author Info --}}
                    <div class="job-type job-hp">
                        @if($record->post_by == 'admin')
                            @foreach($admins as $admin)
                                @if($record->user_id == $admin->id)
                                    <img src="{{ asset($admin->image) }}" alt="">
                                    <p>{{ $record->title }}<br><small>By {{ $admin->first_name }}</small></p>
                                @endif
                            @endforeach
                        @else
                            @foreach($users as $user)
                                @if($record->user_id == $user->id)
                                    <img src="{{ asset('assets/images/profile/' . $user->image) }}" alt="">
                                    <p>{{ $record->title }}<br><small>By {{ $user->first_name }}</small></p>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
            </a>
        </div>
    @endforeach
@else
    <div class="col-12 text-center">
        <h3 style="padding: 5% 0 2%;">We couldn’t find any data, Please adjust your filter settings.</h3>
        <a href="{{ url('/') }}">
            <button class="btn create-post-button">Go to Search</button>
        </a>
    </div>
@endif