<div class="col-lg-12">
    <h4 class="text-center">{{ $title }}</h4>
</div>
{{-- @php
dd($items);
@endphp --}}
@foreach ($items as $item)
    <div class="col-lg-3 col-md-4 gx-5">
        <div class="card latest-blog-box">
            <a href="{{ route($routeName, $item->slug) }}">
                @if(isset($isVideo) && $isVideo)
                    <video class="thumbnail-video" controls src="{{ asset($imagePath . '/' . $item->video) }}" loop></video>
                @else
                    @php
                        $images = explode(',', trim($item->image1, '[""]'));
                        $firstImage = $images[0] ?? '1688636936.jpg';
                        $imageUrl = asset("$imagePath/$firstImage");
                    @endphp
                    <img src="{{ $imageUrl }}" class="card-img-top" alt="img">
                @endif
                <div class="card-body p-4">
                    <h5 class="card-title">{{ $item->title }}</h5>
                </div>
                <div class="card-footer">
                    <small class="text-muted">Last updated {{ $item->created_at->diffForHumans() }}</small>
                </div>
            </a>
        </div>
    </div>
@endforeach
