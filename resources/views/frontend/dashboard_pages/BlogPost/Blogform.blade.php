@extends('layouts.user_dashboard.userdashboardlayout')
@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">

<section class="mt-5 new-blog">
  <div class="container">
    <form class="card" action="{{route('new.blogs.form.save')}}" method="post" enctype="multipart/form-data">
        @csrf
      <div class="card-header">
        <!-- <nav class="nav nav-pills nav-fill">
          <a class="nav-link tab-pills" href="#">Personal Details</a>
          <a class="nav-link tab-pills" href="#">Address Details</a>
          <a class="nav-link tab-pills" href="#">Company Details</a>
          <a class="nav-link tab-pills" href="#">Finish</a>
        </nav> -->
        <div class="d-flex justify-content-between">
          <button type="button" id="back_button" class="btn btn-warning" onclick="back()"><i class="fas fa-arrow-left"></i></button>
          <h4 class="h3 mb-0 text-gray-800 fw-bold">Blogs</h4>
          <button type="button" id="next_button" class="btn btn-primary next-btn ms-auto" onclick="next()">Next</button>
        </div>
      </div>
      <div class="card-body">
        <div class="tab d-none">
          <div class="row mb-0">
          	<div class="col-lg-12">
          		<div id="status"></div>
				  <div id="photos" class="photos row"></div>
				    <div class="form-group image-upload bg-light border text-center">
				      <label for="photo" class="control-label">
				      <div class="h-100">
                            <div class="dplay-tbl mt-3">
                                <div class="dplay-tbl-cell">
                                    <i class="fas fa-cloud-upload-alt mb-3"></i>
                                    <h6><b>Upload Image</b></h6>
                                    <h6 class="mt-10 mb-70">Or Drop Your Image Here</h6>
                                </div>
                            </div>
                        </div>
				      <div class="col-sm-10">
				        <input data-required="image" type="file" class="form-control image-input" name="image" id="photo" accept=".png, .jpg, .jpeg" onchange="readFile(this);" multiple>
				      </div></label>
				    </div>
              	</div>
              </div>
            </div>

        <div class="tab d-none">
            <div class="row activity center-items">
                <div class="col-md-7">
                    <div class="uploaded-image">
                        <img class="img-fluid" src="https://www.finderspage.com/public/images_blog_img/dummy-image-square.jpg">
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="row">
                        <div class="col-md-12 mb-2 mb-md-4">
        		            <div class="accordion" id="accordionExample_people">
        					  <div class="card border-left-warning shadow">
        					    <div class="card-head" id="headingOne">
        					      <div class="mb-0 text-black head" data-toggle="collapse" data-target="#collapseOne_people" aria-expanded="true" aria-controls="collapseOne">
        					          <span><i class="bi bi-bookmark-star"></i>Write a caption</span>
        					          <span class="arrow">
        						      	<i class="bi bi-chevron-right" id="chevron-icon"></i>
        						      </span>
        					      </div>
        					    </div>

        					    <div id="collapseOne_people" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample_people">
        					      <div class="card-body">
        				            <label class="custom-toggle d-flex justify-content-between">
                                        <textarea placeholder="Tag-People" class="form-control desc" name="caption"></textarea>
                                    </label><div class="hashtagHead "></div>
                                    <div class="my-Hashtag">
                                        <div class="Hashtag">
                
                                        </div>
                                    </div>
        					      </div>
        					    </div>
        					  </div>
        					</div>
        		        </div>
        		        
        		        <div class="col-md-12 mb-2 mb-md-4">
        		            <div class="accordion" id="accordionExample_subCate">
        					  <div class="card border-left-warning shadow">
        					    <div class="card-head" id="headingOne">
        					      <div class="mb-0 text-black head" data-toggle="collapse" data-target="#collapseOne_subCate" aria-expanded="true" aria-controls="collapseOne">
        					          <span><i class="bi bi-bookmark-star"></i>Choose subcategory</span>
        					          <span class="arrow">
        						      	<i class="bi bi-chevron-right" id="chevron-icon"></i>
        						      </span>
        					      </div>
        					    </div>

        					    <div id="collapseOne_subCate" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample_subCate">
        					      <div class="card-body">
        				            <label class="custom-toggle d-flex justify-content-between">
                                        <select name="subcategory" class="form-control-xs selectpicker" data-size="7" data-live-search="true" data-title="Blog categories" id="sub_category" data-width="100%" required>
                                            <option value="">Select option</option>
                                       
                                        </select>
                                    </label>
        					      </div>
        					    </div>
        					    
        					  </div>
        					</div>
        		        </div>
        		        
        		        <div class="col-md-12 mb-2 mb-md-4">
        		            <div class="accordion" id="accordionExample_location">
        					  <div class="card border-left-warning shadow">
        					    <div class="card-head" id="headingOne">
        					      <div class="mb-0 text-black head" data-toggle="collapse" data-target="#collapseOne_location" aria-expanded="true" aria-controls="collapseOne">
        					          <span><i class="bi bi-geo-alt"></i> Add Location</span>
        					          <span class="arrow">
        						      	<i class="bi bi-chevron-right" id="chevron-icon"></i>
        						      </span>
        					      </div>
        					    </div>

        					    <div id="collapseOne_location" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample_location">
        					      <div class="card-body">
        				            <label class="custom-toggle d-flex justify-content-between">
        				            	
                                        <input type="text" placeholder="location"  name="location"  class="form-control get_loc" value="">
                                        <div class="searcRes" id="autocomplete-results"></div>
                                    </label>
        					      </div>
        					    </div>
        					  </div>
        					</div>
        		        </div>
        		        
        		        <div class="col-md-12 mb-2 mb-md-4">
        		            <div class="accordion" id="accordionExample_share">
        					  <div class="card border-left-warning shadow">
        					    <div class="card-head" id="headingOne">
        					      <div class="mb-0 text-black head" data-toggle="collapse" data-target="#collapseOne_share" aria-expanded="true" aria-controls="collapseOne">
        					          <span><i class="bi bi-share"></i> Share</span>
        					          <span class="arrow">
        						      	<i class="bi bi-chevron-right" id="chevron-icon"></i>
        						      </span>
        					      </div>
        					    </div>

        					    <div id="collapseOne_share" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample_share">
        					      <div class="card-body">
        				            <label class="custom-toggle d-flex justify-content-between">
                                        <span>Turn off share</span>
                                        <input type="checkbox" name="share_option" value="true">
                                    </label>
        					      </div>
        					    </div>
        					  </div>
        					</div>
        		        </div>

        		        <div class="col-md-12 mb-2 mb-md-4">
        		            <div class="accordion" id="accordionExample">
        					  <div class="card border-left-warning shadow">
        					    <div class="card-head" id="headingOne">
        					      <div class="mb-0 text-black head" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
        					          <span><i class="bi bi-chat"></i> Comments</span>
        					          <span class="arrow">
        						      	<i class="bi bi-chevron-right" id="chevron-icon"></i>
        						      </span>
        					      </div>
        					    </div>

        					    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
        					      <div class="card-body">
        				            <label class="custom-toggle d-flex justify-content-between">
        				            	<span>Turn off commenting</span>
                                <input type="checkbox" name="comment_off" value="true">
                            </label>
        					      </div>
        					    </div>
        					  </div>
        					</div>
        		        </div>
                    </div>
		        </div>
		    </div>
        </div>

        <!-- <div class="tab d-none">
          <div class="mb-3">
            <label for="company_name" class="form-label">Company Name</label>
            <input type="text" class="form-control" name="company_name" id="company_name" placeholder="Please enter company name">
          </div>
          <div class="mb-3">
            <label for="company_address" class="form-label">Company Address</label>
            <textarea class="form-control" name="company_address" id="company_address" placeholder="Please enter company address"></textarea>
          </div>
        </div> -->

        <!-- <div class="tab d-none">
          <p>All Set! Please submit to continue. Thank you</p>
        </div> -->
      </div>
      <!-- <div class="card-footer text-end">
        <div class="d-flex">
          <button type="button" id="back_button" class="btn btn-link" onclick="back()">Back</button>
          <button type="button" id="next_button" class="btn btn-primary ms-auto" onclick="next()">Next</button>
        </div>
      </div> -->
       <input type="hidden" name="categories" value="728">
    </form>
  </div>
</section>

<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>


<script>
	var current = 0;
var tabs = $(".tab");
var tabs_pill = $(".tab-pills");

loadFormData(current);

function loadFormData(n) {
  $(tabs_pill[n]).addClass("active");
  $(tabs[n]).removeClass("d-none");
  $("#back_button").attr("disabled", n == 0 ? true : false);
  n == tabs.length - 1
    ? $("#next_button").text("Submit").removeAttr("onclick")
    : $("#next_button")
        .attr("type", "submit")
        .text("Next")
        .attr("onclick", "next()");
}

function next() {
  $(tabs[current]).addClass("d-none");
  $(tabs_pill[current]).removeClass("active");

  current++;
  loadFormData(current);
}

function back() {
  $(tabs[current]).addClass("d-none");
  $(tabs_pill[current]).removeClass("active");

  current--;
  loadFormData(current);
}


function readFile(input) {
    $("#status").html('Processing...');
    var counter = input.files.length;

    for (var x = 0; x < counter; x++) {
        if (input.files && input.files[x]) {
            var reader = new FileReader();

            reader.onload = (function (index) {
                return function (e) {
                    if (index === 0) {
                        // Show only the first image in .photos2
                        $(".photos2").html('<img src="' + e.target.result + '" class="single-img" alt="Image">');
                    }

                    // Show all images in .photos
                    $(".photos").append('<div class="col-md-3 col-sm-3 col-xs-3"><img src="' + e.target.result + '" class="img-thumbnail" alt="Image"></div>');
                };
            })(x);

            reader.readAsDataURL(input.files[x]);
        }
    }

    $("#status").html('');
}



var textarea = document.querySelector('textarea');

textarea.addEventListener('keydown', autosize);
             
function autosize(){
  var el = this;
  setTimeout(function(){
    el.style.cssText = 'height:auto; padding:0';
    // for box-sizing other than "content-box" use:
    // el.style.cssText = '-moz-box-sizing:content-box';
    el.style.cssText = 'height:' + el.scrollHeight + 'px';
  },0);
}

$('.head').click(function(){
  $(this).parent().find('.arrow').toggleClass('arrow-animate');
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
</script>

@endsection