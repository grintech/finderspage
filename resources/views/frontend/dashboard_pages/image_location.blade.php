
<div class="row bg-white border-radius pb-4 p-3">
    <form action="" method="" >
    @csrf
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="show-img">
                <label class="labels">Image</label>
                    <?php
                    $img  = explode(',', $getData->image);

                    // echo "<pre>";print_r($img);die('dev');
                    ?>
                    @if($img[0] != null)
                    <div class="gallery">
                        @foreach($img as $index => $images)
                        <div class='apnd-img'>
                            <img src="{{ asset('images_blog_img') }}/{{ $images }}" id='img' imgtype="blogPost" remove_name="{{ $images }}" dataid="{{$getData->id}}" class='img-responsive'><i class='fa fa-trash delfile'></i>
                            
                        </div>
                        
                        @endforeach
                    </div>
                    @endif
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12 mb-4">
            <label class="labels">Want to reach a larger audience? Add location</label>
            <input type="text" class="form-control get_loc" name="location" placeholder="Enter your location" value="{{$getData->location}}">
            <div class="searcRes" id="autocomplete-results"></div>
            @error('title')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 mb-4">
            <button type="submit" class="btn btn-primary" >Update</button>
        </div>
    </div>
</div>


<script>
    // Initialize SortableJS
    var sortable = new Sortable($('.gallery')[0], {
            animation: 150,
            onEnd: function (evt) {
                updateFeaturedTag();
            }
        });
</script>



