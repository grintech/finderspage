@extends('layouts.adminlayout')

@section('content')
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
</style>
<div class="container-fluid px-5">
 				<form method="post" action="{{route('blog_post_save')}}" enctype="multipart/form-data" id="blog">
 					{{ @csrf_field() }}
                    <!-- Page Heading -->
                    <div class="d-sm-flex flex-column  mb-3">
                        <h1 class="h3 mb-0 text-gray-800 fw-bold">Create Your Own Blog</h1>
                    </div>
                    <span>
                    	@include('admin.partials.flash_messages')
                    </span>
                    <input type="hidden" name="categories" value="728">

                    <div class="row bg-white border-radius pb-4 p-3">
                        <div class="col-md-6 mb-4">
                            <label class="labels">Title <sup>*</sup></label>
                            <input type="text" class="form-control" name="title" placeholder="Enter post name" value="<?php echo old('title'); ?>">
                            <span class="error-message" id="title-error"></span>
                             @error('title')
                                <small class="text-danger">{{ $message }}</small>
                             @enderror
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="labels">Blog Category</label>
                            <select name="subcategory" class="form-control form-control-xs selectpicker"  data-size="7" data-live-search="true" data-title="Blog Category" id="state_list" data-width="100%" >
                                <option value="">Select option</option>
                                @foreach($categories as $cate)
                                <option value="{{$cate->id}}" >{{$cate->title}}</option>
                                @endforeach
                            </select>
                             <span class="error-message" id="title-error"></span>
                            @error('sub_categories')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                         
                      
                     <div class="col-md-6 mb-4">
                         <label class="labels">Blog Image</label> 
                            <div class="upload-icon"><a class="cam btn btn-warning"  href="javascript:void(0)">
                                <i class="fa fa-upload" aria-hidden="true"></i>
                                    upload image
                                </a> 
                            </div>
                           
                            <div class="gallery"></div>
                            <div class="show-img">

                                 <!-- <img src="" alt="" class="uploaded-image" id="image-container" >
                                 <i class="fas fa-times" id="cancel-btn"></i> -->
                            </div>
                            @error('image')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror 
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="labels">Want to reach a larger audience? Add Location </label>
                            <input type="text" class="form-control get_loc" name="location" placeholder="location" value="<?php echo old('location'); ?>">
                            <div class="searcRes" id="autocomplete-results"></div>
                             @error('title')
                                <small class="text-danger">{{ $message }}</small>
                             @enderror
                        </div>
                        <div class="col-md-12 mb-4">
                            <label class="labels">Add Description (Max limit 400 words, and add up to 30 hashtags)<sup>*</sup> </label>
                            <div id="summernote">
                                <textarea id="editor1"  class="form-control desc" name="content" placeholder="Write a text"><?php echo old('description'); ?></textarea>
                                <!-- <p id="wordCount">Word count: 0</p> -->
                                <div class="hashtagHead"><i class="bi bi-hash"></i>hashtags</div>
                                <div class="my-Hashtag">
                                    <div class="Hashtag">

                                    </div>
                                </div>
                                @error('description')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>


                </div>
                    <input type="hidden" name="posted_by" value="admin">
                    <div class="mt-5 text-center"><button class="btn profile-button" type="submit">Publish</button></div> 
                </div>
            </form>



<script type="text/javascript">
    $(document).ready(function() {
        $('.desc').on('input', function() {
            // Get the text input value
            var inputText = $(this).val();
             alert(inputText);
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
        var wordLimit = 400;
        var hashtagLimit = 30;

        $('.desc').on('input', function() {
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
</script>
@endsection