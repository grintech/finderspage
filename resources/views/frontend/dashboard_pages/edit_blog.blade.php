@extends('layouts.user_dashboard.userdashboardlayout')
@section('content')
<?php  use Carbon\Carbon; ?>
<style type="text/css">
    .Hashtag {
        display: flex;
        overflow: scroll;
    }

    .mainClass-hashtag {
        margin-left: 5px;
        margin-left: 5px;
        background-color: #eec54b;
        border-radius: 5px;
    }

    h6.hashtag-item {
        padding: 4px;
        margin-top: 7px;
        font-weight: bold;
    }

    i.bi.bi-hash {
        font-size: x-large;
    }

    .hashtagHead {
        font-weight: 700;
    }

    .card.border-left-warning.shadow.loca-tion {
        overflow: visible !important;
    }
    .error-message {color: #e74a3b;}
    #summernote textarea{
        border: 1px solid #bdbdbd !important;
    }
    @media only screen and (max-width:767px){
        .container-fluid {padding-bottom: 50px !important;}
    }
</style>
<div class="container-fluid px-5">
    <form method="post" action="{{route('blogpost.update',$blog_post->slug)}}" enctype="multipart/form-data" id="blog">
        {{ @csrf_field() }}
        <!-- Page Heading -->
        <div class="d-sm-flex flex-column  mb-3">
            <h1 class="h3 mb-0 text-gray-800 fw-bold">Edit Blog</h1>
            <p>(Choose a topic you're deeply passionate about or share what's on your mind.)</p>
        </div>
        <span>
            @include('admin.partials.flash_messages')
        </span>
        <input type="hidden" name="categories" value="728">
        <?php 
            $currentDateTime = new DateTime();
            $givenTime = $blog_post->created_at; // Assuming $post->created_at is a valid date string

            // Convert the given time to a Carbon instance
            $givenDateTime = Carbon::parse($givenTime);

            // Add 10 days to the given date time
            $nextTenDays = $givenDateTime->addDays(10);


        ?> 
        <div class="row bg-white border-radius pb-4 p-3">

        @if($currentDateTime > $nextTenDays)
            <div class="col-md-6 mb-4">
                <label class="labels">Title <sup>*</sup></label>
                <input type="text" id="title-input" class="form-control" name="title" placeholder="Title" value="{{$blog_post->title}}" readonly data-toggle="tooltip" data-placement="top" title="You can't make edits as you created this post more than 10 days ago.">
            </div>
        @else
            <div class="col-md-6 mb-4">
                <label class="labels">Title <sup>*</sup></label>
                <input type="text" id="title-input" class="form-control" name="title" placeholder="Title" value="{{$blog_post->title}}">
                <span class="error-message" id="title-error"></span>
                @error('title')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        @endif



        <div class="col-md-6 mb-4">
            <label class="labels">Blog Category <sup>*</sup></label>
            <select name="subcategory" class="form-control form-control-xs selectpicker" data-size="7" data-live-search="true" data-title="Blog categories" id="sub_category" data-width="100%" required>
                <option value="">Select option</option>
        
                {{-- Loop through categories, skipping the "Other" category --}}
                @foreach($categories as $cate)
                    @if($cate->title != 'Other') <!-- Skip "Other" category -->
                        <option value="{{ $cate->id }}" {{ $blog_post->subcategory == $cate->id ? 'selected' : '' }}>
                            {{ $cate->title }}
                        </option>
                    @endif
                @endforeach
        
                {{-- Show the "Other" category separately --}}
                @foreach($categories as $cate)
                    @if($cate->title == 'Other')
                        <option class="Other-cate" value="{{ $cate->id }}" {{ $blog_post->subcategory == $cate->id ? 'selected' : '' }}>
                            {{ $cate->title }}
                        </option>
                    @endif
                @endforeach
            </select>
        
            <input type="text" class="form-control d-none mt-2" id="Other-cate-input" name="sub_category_oth" placeholder="Subcategory name" value="">
            <span class="error-message" id="subcategory-error"></span> <!-- Error message for subcategory -->
            @error('sub_categories')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        
        


            <div class="col-md-6 mb-4">
                <label class="labels">Schedule Publish Time <em>(Optional)</em></label>
                <input type="datetime-local" class="form-control" name="schedule" placeholder="Enter post name" value="{{$blog_post->schedule}}">
                @error('title')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div id="input-container" class="col-md-6 mb-4">
                <!-- Initial input field -->
                <label class="labels">Add fundraiser links</label>
                <input type="text" name="fundraiser_link" class="form-control website_url" placeholder="Add links" value="{{$blog_post->fundraiser_link}}">
            </div>

            <div class="col-md-6 mb-4">
            <label class="labels" data-toggle="tooltip" data-placement="top" title="Any photo that signals an intention to commit, solicit, promote or encourage a criminal act and/or violate the  Advertiser Agreement will not be accepted.">Blog Featured Image <em>(Select Multiple)</em> <i class="fa fa-question popup2"> </i></label>

                <div class="upload-icon "><a class="cam btn btn-warning "  href="javascript:void(0)">
                    <i class="fa fa-upload" aria-hidden="true"></i>
                        upload image
                    </a> 
                </div>
               
                <!-- <div class="gallery" id="sortableImgThumbnailPreview"></div> -->
                <!-- <div class="image-upload post_img ">
                    <label style="cursor: pointer;" for="image_upload">

                        <div class="h-100">
                            <div class="dplay-tbl">
                                <div class="dplay-tbl-cell">
                                    
                                    <i class="far fa-file-image mb-3"></i>
                                    <h6 class="mt-10 mb-70">Upload Or Drop Your Image Here</h6>
                                </div>
                            </div>
                        </div>
                       
                        <input data-required="image" type="file" name="image[]" multiple id="image_upload" class="image-input" data-traget-resolution="image_resolution" value="" accept="image/png, image/gif, image/jpeg" onchange="checkImageCount(this, maxImageCount)">
                    </label>

                </div> -->
                <div class="show-img">
                    <?php
                    $img  = explode(',', $blog_post->image);

                    // echo "<pre>";print_r($img);die('dev');
                    ?>
                   <div class="gallery">
                        @foreach($img as $index => $images)
                        <div class='apnd-img'>
                            <img src="{{ asset('images_blog_img') }}/{{ $images }}" id='img' imgtype="blogPost"  remove_name="{{ $images }}" dataid="{{$blog_post->id}}" class='img-responsive'>
                            @if($currentDateTime < $nextTenDays) 
                            <i class='fa fa-trash delfile'></i>
                            @endif
                        </div>
                        
                        @endforeach
                    </div>
                </div>
                @error('image')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-6 mb-4">
                <label class="labels">Want to reach a larger audience? Add location</label>
                <input type="text" class="form-control get_loc" name="location" placeholder="Enter your location" value="{{$blog_post->location}}">
                <div class="searcRes" id="autocomplete-results"></div>
                @error('title')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>



            <div class="accordion col-md-6 mb-4" id="comment_visibility">
                <div class="card border-left-warning shadow">
                    <div class="card-head" id="headingthree">
                        <div class="mb-0 text-black head" data-toggle="collapse" data-target="#collapsethree" aria-expanded="true" aria-controls="collapsethree">
                            <span class="left-icon"><i class="bi bi-globe"></i>Comment Option</span>
                            <span class="arrow">
                                <i class="bi bi-chevron-right" id="chevron-icon"></i>
                            </span>
                        </div>
                    </div>
                    <div id="collapsethree" class="collapse" aria-labelledby="headingthree" data-parent="#comment_visibility">
                        <div class="card-body pt-1">
                            <label class="custom-toggle d-flex justify-content-between">
                                <span>Public</span>
                                <input type="checkbox" name="comment_view_public_private" value="public" @if($blog_post->comment_view_public_private == "public") checked @endif >
                            </label>
                            <hr>
                            <label class="custom-toggle d-flex justify-content-between">
                                <span>Private</span>
                                <input type="checkbox" name="comment_view_public_private" value="private" @if($blog_post->comment_view_public_private == "private") checked @endif >
                                
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <div class="accordion col-md-6 mb-4" id="privacy_section">
                <div class="card border-left-warning shadow">
                    <div class="card-head" id="headingprivacy">
                        <div class="mb-6 text-black head" data-toggle="collapse" data-target="#collapseprivacy" aria-expanded="true" aria-controls="collapseprivacy">
                            <span class="left-icon"><i class="bi bi-shield-lock"></i>Edit privacy</span>
                            <span class="arrow">
                                <i class="bi bi-chevron-right" id="chevron-icon-privacy"></i>
                            </span>
                        </div>
                    </div>
            
                    <div id="collapseprivacy" class="collapse" aria-labelledby="headingprivacy" data-parent="#privacy_section">
                        <div class="card-body pt-1">
                            <p>Who can see your post?</p>
                            <p>Your post may show up in Feed, on your profile, in search results, and on chat box.</p>
            
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="privacyOption" id="publicOption" value="public" @if($blog_post->privacy_option == "public") checked @endif>
                                    <label class="form-check-label" for="publicOption">
                                        Public
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="privacyOption" id="connectionsOption" value="connections" @if($blog_post->privacy_option == "connections") checked @endif>
                                    <label class="form-check-label" for="connectionsOption">
                                        Connections
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="privacyOption" id="onlymeOption" value="only_me" @if($blog_post->privacy_option == "only_me") checked @endif>
                                    <label class="form-check-label" for="onlymeOption">
                                        Only me
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}

            @if($currentDateTime > $nextTenDays)
                <div class="col-md-12 mb-4">
                    <label class="labels">Add Description (Max limit 1000 words, and add up to 30 hashtags)</label>
                        <textarea class="form-control desc" rows="15" name="content" placeholder="Description" readonly data-toggle="tooltip" data-placement="top" title="You can't make edits as you created this post more than 10 days ago.">{{$blog_post->content}}</textarea>
                </div>
            @else
                <div class="col-md-12 mb-4">
                    <label class="labels">Add Description (Max limit 1000 words, and add up to 30 hashtags)</label>
                    <div id="summernote">
                        <textarea id="editor1" class="form-control desc" rows="15" name="content" placeholder="Description">{{$blog_post->content}}</textarea>
                    
                        @error('description')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            @endif

        </div>
        <input type="hidden" name="posted_by" value="user">
        <div class="mt-5 text-center"><button class="btn profile-button" type="submit">Update</button></div>
</div>
</form>
<script>
    
    

    $(document).ready(function() {
        $('.get_loc').keyup(function() {
            var address = $(this).val();
            console.log(address);
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            console.log('CSRF Token:', csrfToken);
            $.ajax({
                url: baseurl + '/get/place/autocomplete',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                },
                data: {
                    address: address,
                },
                success: function(response) {
                    $('#autocomplete-results').show();
                    console.log(response);
                    $('#autocomplete-results').empty();
                    if (response.results) {
                        response.results.forEach(function(prediction) {
                            $('#autocomplete-results').append('<li class="Search_val">' + prediction.formatted_address + '</li>');
                        });
                    } else {
                        console.log('No predictions found.');
                    }
                },
                error: function(xhr, status, error) {

                }
            });
        });
    });
    $(document).on("click", ".Search_val", function() {
        var searchVal = $(this).text();
        // alert(searchVal);
        $('.get_loc').val(searchVal);
        $(this).addClass('active_li');
        $('#autocomplete-results').hide();

    });



    $(document).ready(function() {
        $('.desc').on('input', function() {
            // Get the text input value
            var inputText = $(this).val();
            // alert(inputText);
            // if (inputText.startsWith('#') && inputText.endsWith(' ')) {
            if (inputText.startsWith('#')) {
                // Extract hashtags using a regular expression
                var hashtags = inputText.match(/#\w+/g);
                var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                // alert(hashtags);
                $.ajax({
                    url: "{{ route('get.hashtag') }}", // Use Laravel route function
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        hashtags: hashtags
                    },
                    success: function(data) {
                        // Handle the received user list data
                        console.log(data);

                        // Display the hashtags
                        displayHashtags(data);

                        // Assuming you have a div with id 'resultDiv', update its content
                        $('.Hashtag').html(data); // Update this line based on your actual HTML structure
                    },
                    error: function(error) {
                        console.error('Error fetching user list:', error);
                    }
                });
            }
        });


        $('.Hashtag').on('click', '.hashtag-item', function() {
            // Get the clicked hashtag text
            var clickedHashtag = $(this).text().trim(); // Trim to remove any leading or trailing whitespaces

            // Check if the hashtag is not empty
            if (clickedHashtag !== '') {
                // Get the current cursor position in the description box
                var descBox = $('.desc')[0]; // Get the native DOM element
                var cursorPos = descBox.selectionStart;

                // Get the current text in the description box
                var descText = $('.desc').val();

                // Insert the clicked hashtag at the cursor position
                var newText = descText.slice(0, cursorPos) + ' ' + clickedHashtag + descText.slice(cursorPos);
                // alert(newText);
                // Set the updated text in the description box
                $('.desc').val(newText);
            }

            // Remove the clicked hashtag from the appended list
            $(this).remove();
        });
    });

    function displayHashtags(hashtags) {
        // Clear the previous hashtags
        $('.Hashtag').empty();

        // Display the new hashtags
        if (hashtags) {

            // Append each hashtag as a clickable item
            $('.Hashtag').append(hashtags);
        }
    }


    $(document).ready(function() {
        var wordLimit = 1000;
        var hashtagLimit = 30;

        $('#desc').on('input', function() {
            var text = $(this).val();
            var words = text.split(/\s+/).filter(function(word) {
                return word.length > 0;
            });
            var wordCount = words.length;
            var remainingWords = wordLimit - wordCount;

            $('#wordCount').text('Words left: ' + remainingWords);

            // Count hashtags
            var hashtags = (text.match(/#/g) || []).length;
            var remainingHashtags = hashtagLimit - hashtags;

            $('#hashtagCount').text('Hashtags left: ' + remainingHashtags);

            // Trim the text if it exceeds the limits
            if (wordCount > wordLimit || hashtags > hashtagLimit) {
                var trimmedText = words.slice(0, wordLimit).join(' ');
                $(this).val(trimmedText);

                // Display SweetAlert error message
                Swal.fire({
                    icon: 'error',
                    title: 'Limit Exceeded',
                    text: 'Word or hashtag limit exceeded!',
                });
            }
        });
    });

    $(document).ready(function() {
        $('.get_loc').keyup(function() {
            var address = $(this).val();
            console.log(address);
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            console.log('CSRF Token:', csrfToken);
            $.ajax({
                url: baseurl + '/get/place/autocomplete',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                },
                data: {
                    address: address,
                },
                success: function(response) {
                    $('#autocomplete-results').show();
                    console.log(response);
                    $('#autocomplete-results').empty();
                    if (response.results) {
                        response.results.forEach(function(prediction) {
                            $('#autocomplete-results').append('<li class="Search_val">' + prediction.formatted_address + '</li>');
                        });
                    } else {
                        console.log('No predictions found.');
                    }
                },
                error: function(xhr, status, error) {

                }
            });
        });
        });

	$(document).on("click", ".Search_val", function() {
        var searchVal = $(this).text();
        // alert(searchVal);
        $('.get_loc').val(searchVal);
        $(this).addClass('active_li');
        $('#autocomplete-results').hide();

    });
 $(document).on("click", ".Search_val", function() {
    CKEDITOR.replace('editor_edit');
    CKEDITOR.instances.editor1.setReadOnly(true);
});
$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip({
        trigger: 'hover focus'
    });
});
</script>
@endsection