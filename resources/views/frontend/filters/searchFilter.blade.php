@if ($matchingRecords->isNotEmpty())
    @foreach ($matchingRecords as $record)
        <div class="col-lg-3 col-md-6 mb-3">
            <a href="{{ route('jobpost', $record->slug) }}">
                <div class="feature-box" style="position:relative;">
                    <div class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @php
                                $images = trim($record->image1, '[""]');
                                $imageArray = explode('","', $images);
                            @endphp
                            @foreach ($imageArray as $key => $image)
                                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                    <img src="{{ asset('images_blog_img/' . $image) }}" alt="Job Image" onerror="this.onerror=null;this.src='{{ asset('images_blog_img/1688636936.jpg') }}'">
                                </div>
                            @endforeach
                        </div>
                        @if (count($imageArray) > 1)
                            <button class="carousel-control-prev" type="button" data-bs-target=".carousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target=".carousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </button>
                        @endif
                    </div>
                    <p class="job-title"><b>{{ ucfirst($record->title) }}</b></p>
                    <div class="main-days-frame">
                        <span class="days-box">
                            @php
                                $days = floor((time() - strtotime($record->created)) / (60 * 60 * 24));
                                $timeAgo = $days > 0 ? ($days == 1 ? "$days day ago" : "$days days ago") : "Posted today";
                            @endphp
                            {{ $timeAgo }}
                        </span>
                    </div>
                </div>
            </a>
        </div>
    @endforeach
@endif
