@if (isset($BlogsView) && $BlogsView->isNotEmpty())
    @foreach($BlogsView as $post)
        <?php $img = explode(',', $post->image); ?>
        <div class="col-lg-3 col-md-4 col-6 blog-box">
            <a href="{{ route('blogPostSingle', $post->slug) }}">
                <div class="card">
                    @if(isset($post->image))
                        <img class="card-img-top" src="{{ asset('images_blog_img/' . $img[0]) }}" alt="img...">
                    @else
                        <img class="card-img-top" src="{{ asset('images_blog_img/1688636936.jpg') }}" alt="img...">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $post->title }}</h5>
                        <p class="card-title">
                            <?php
                                $givenTime = strtotime($post->created_at);
                                $currentTimestamp = time();
                                $timeDifference = $currentTimestamp - $givenTime;
                                $days = floor($timeDifference / (60 * 60 * 24));
                                $hours = floor(($timeDifference % (60 * 60 * 24)) / (60 * 60));
                                $minutes = floor(($timeDifference % (60 * 60)) / 60);
                                $seconds = $timeDifference % 60;
                                $timeAgo = $days > 0 ? ($days == 1 ? "$days day ago" : "$days days ago") : "Posted today";
                                echo $timeAgo;
                            ?>
                        </p>
                        {{-- <a href="{{ route('blogPostSingle', $post->slug) }}" class="btn blog-read-button">Read More</a> --}}
                    </div>
                </div>
            </a>
        </div>
    @endforeach
@else
    <div class="div_blank text-center p-5">
        <h5>No data found under this category.</h5>
    </div>
@endif
