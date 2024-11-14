@php

use App\Models\Admin\Settings;

use App\Models\User\UserAuth;

use App\Models\Admin\HomeSettings;


$favicon = Settings::get('favicon');

$logo = Settings::get('logo');

$companyName = Settings::get('company_name');

$version = '1.1';

$User_data = UserAuth::getLoginUser();
 $slideshowCount = $User_data->slideshow_limit;
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="icon" href="<?php echo asset($favicon) ?>" type="image/png">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Finder Page - User Dashboard</title>
    <!-- Custom fonts for this template-->
    <link href="{{asset('user_dashboard/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css" rel="stylesheet">
    <link href="{{asset('user_dashboard/css/sb-admin-2.css')}}" rel="stylesheet">
    <link href="{{asset('user_dashboard/css/custom.css')}}" rel="stylesheet">
    <link href="{{asset('user_dashboard/css/customSelect.css')}}" rel="stylesheet">
    <link href="{{asset('user_dashboard/css/uploadpdf.css')}}" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <!-- DataTables library -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />


    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@joeattardi/emoji-button@5.2.2/dist/emoji-button.min.css"> -->
    


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Include Select2 CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" />
    
    <!-- Include Select2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <link href="{{asset('user_dashboard/css/multiple-image-video.css')}}" rel="stylesheet">
  
    <script type="text/javascript">
        var baseurl = '<?php echo url(""); ?>';
        var maxImageCount = <?php echo isset($slideshowCount) ? $slideshowCount : 3; ?>;
   
            // alert(maxImageCount);
    </script>
    <!-- Bootstrap 4.6 JS -->
        <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
		<script src="{{asset('texteditor/editor.js')}}"></script>
		<script>
			$(document).ready(function() {
				$("#txtEditor").Editor();
			});
		</script> -->
    <!-- Bootstrap 4.6 CSS -->
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/css/bootstrap.min.css"> -->
    <!-- Font Awesome 4.7.0 (Latest version available in Font Awesome 4.x) -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="{{asset('texteditor/editor.css')}}" type="text/css" rel="stylesheet"/>
     -->
</head>
<style>
    .gallery .apnd-img:nth-child(1) {
        border: 2px solid red;
        box-shadow: 0px 0px 3px blue;
    }
    .gallery .apnd-img:nth-child(1)::after {
        content: "Featured";
        position: absolute;
        top: 75%;
        left: 5px;
        background-color: red;
        color: white;
        padding: 2px 5px;
        font-size: 12px;
        font-weight: bold;
        border-radius: 3px;
    }
</style>
<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        @include('layouts.user_dashboard.sidebar')
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                @include('layouts.user_dashboard.header')
                <!-- End of Topbar -->
                <!-- Begin Page Content -->
                @yield('content')
                <!-- /.container-fluid -->

                <!-- Review Section -->
                @if($User_data->review==0)
                <div class="dash-review">
                    <a data-toggle="modal" data-target="#reviewModal">
                        <img src="https://finderspage.com/public/user_dashboard/img/rating.png" class="img-fluid review" alt="img">
                    </a>
                </div>
                @endif
            </div>
            <!-- End of Main Content -->

        <!-- Review Modal -->
        <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="reviewModalLabel">Leave a review!</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                <div class="title">
                    Tell us how FindersPage is working for you. As a thank you, you will be allowed to have one free bump on any of your posts.
                </div>
                <form id="reviewForm" action="{{ route('review.save') }}" method="post" enctype='multipart/form-data'>
                  @csrf
                    <div class="form-group">
                        <label for="rating" class="col-form-label">Rating:</label>
                        <div class="rate">
                            <input type="radio" id="star1" name="rating" value="1">
                            <label for="star1"><i class="fas fa-star"></i></label>
                            <input type="radio" id="star2" name="rating" value="2">
                            <label for="star2"><i class="fas fa-star"></i></label>
                            <input type="radio" id="star3" name="rating" value="3">
                            <label for="star3"><i class="fas fa-star"></i></label>
                            <input type="radio" id="star4" name="rating" value="4">
                            <label for="star4"><i class="fas fa-star"></i></label>
                            <input type="radio" id="star5" name="rating" value="5">
                            <label for="star5"><i class="fas fa-star"></i></label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Video:</label>
                        <input type="file" class="form-control" id="video" name="video">
                    </div>

                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Description:</label>
                        <textarea class="form-control" id="message-text" name="description"></textarea>
                    </div>
                    <div class="form-group">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Send</button>
                    </div>
                </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to leave ?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="{{route('auth.logout')}}">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->

    

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <!-- <script src="{{asset('user_dashboard/vendor/jquery/jquery.min.js')}}"></script> -->
    <script src="{{asset('user_dashboard/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- Core plugin JavaScript-->
    <script src="{{asset('user_dashboard/vendor/jquery-easing/jquery.easing.min.js')}}"></script>
    <!-- Custom scripts for all pages-->
    <script src="{{asset('user_dashboard/js/sb-admin.js')}}"></script>

    <script src="{{asset('user_dashboard/js/sb-admin-2.min.js')}}"></script>
    <!-- select2 scripts for all pages-->
    <script src="{{asset('user_dashboard/js/select2.js')}}"></script>
    <!-- Page level plugins -->
    <!-- <script src="{{asset('user_dashboard/vendor/chart.js/Chart.min.js')}}"></script> -->
    <script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
    <!-- Page level custom scripts -->
    <script src="{{asset('user_dashboard/js/custom.js')}}"></script>
    <script src="{{asset('user_dashboard/js/uploadpdf.js')}}"></script>
    <script src="{{asset('user_dashboard/js/customSelect.js')}}"></script>

    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.ckeditor.com/ckeditor5/38.1.1/classic/ckeditor.js"></script>

    <script src="<?php echo url('public/assets/js/userAdmin.js') ?>?v=1234546546"></script>

<!--      <script src="{{asset('user_dashboard/js/image-uploader.js')}}"></script>
     <script src="{{asset('user_dashboard/js/image-uploader.min.js')}}"></script> -->
     <script src="{{asset('user_dashboard/js/multiple-image-video.js')}}"></script>
     <script src="{{asset('user_dashboard/js/single-image.js')}}"></script>
     <script src="{{asset('user_dashboard/js/single-video.js')}}"></script>
     
     <!-- -->
     <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
    @yield('page_script')
    

    <script type="text/javascript">
        $(document).ready(function() {
            $('#tableListing').DataTable({
                order: [
                    [0, 'desc']
                ]
            });
            $('#myMulti11').select2({
                tags: true
            });
        });
    </script>


    <script type="text/javascript">
        $(document).ready(function() {
            var multipleCancelButton = new Choices('#choices-multiple-remove-button', {
                removeItemButton: true,
                maxItemCount: 100,
                searchResultLimit: 100,
                renderChoiceLimit: 100
            });
        });

        $(document).ready(function() {
            
            // $('#image_upload').change(function() {
            //     var input = this;
            //     console.log(input);
                
            // });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $(".fixedorRange").change(function() {
                var value = $(this).val();

                if (value === 'Range') {
                    $('#range').removeClass('d-none');
                    $('#fixed').addClass('d-none');
                }


                if (value === 'Fixed') {
                    $('#fixed').removeClass('d-none');
                    $('#range').addClass('d-none');
                }

            });

            ClassicEditor
                .create(document.querySelector('#editor1'))
                .then(editor => {
                    console.log(editor);

                })
                .catch(error => {
                    console.error(error);

                });

            ClassicEditor
                .create(document.querySelector("#sub_editor"))
                .catch(error => {
                    console.error(error);
                });


             ClassicEditor
    .create(document.querySelector('#Blog_editor'))
    .then(editor => {
        const wordLimit = 400; // Change this to your desired word limit
        const hashtagLimit = 30; // Maximum number of hashtags allowed

        // Function to update word count and check hashtag limit
        const updateWordCount = (text) => {
            const words = text.split(/\s+/).filter(word => word !== '');
            let hashtagCount = 0;

            words.forEach(word => {
                // Check if the word is a hashtag
                if (word.startsWith('#')) {
                    hashtagCount++;
                }
            });

            const updatedWordCount = words.map((word, index) => {
                const decreasedCount = Math.max(0, wordLimit - index);
                return {
                    word,
                    count: decreasedCount
                };
            });

            $('#wordCount').empty();
            updatedWordCount.forEach(({ word, count }) => {
                $('#wordCount').text(`Words left: ${count}`);
            });

            if (hashtagCount > hashtagLimit) {
                // Display an error if hashtag limit is exceeded
                Swal.fire({
                    icon: 'warning',
                    title: 'Hashtag Limit Exceeded!',
                    text: `You cannot use more than ${hashtagLimit} hashtags.`,
                    confirmButtonText: 'OK'
                });

                // Optionally, you can remove the excess hashtags from the editor
                const truncatedContent = text
                    .split(/\s+/)
                    .filter(word => !word.startsWith('#') || hashtagCount-- < hashtagLimit)
                    .join(' ');

                editor.setData(truncatedContent);
            }
        };

        // Initial word count on load
        const initialText = editor.getData();
        updateWordCount(initialText);

        editor.model.document.on('change:data', () => {
            const text = editor.getData();

            // Call the function to update word count and check hashtag limit on every change
            updateWordCount(text);

            const wordCount = text.split(/\s+/).filter(word => word !== '').length;
            if (wordCount > wordLimit) {
                // Truncate content if word limit is exceeded
                const truncatedContent = text
                    .split(/\s+/)
                    .filter((word, index) => index < wordLimit)
                    .join(' ');

                editor.setData(truncatedContent);

                // Display a warning for word limit exceeded
                Swal.fire({
                    icon: 'warning',
                    title: 'Word Limit Exceeded!',
                    text: `You cannot enter more than ${wordLimit} words.`,
                    confirmButtonText: 'OK'
                });
            }
        });
    })
    .catch(error => {
        console.error(error);
    });





        });


// $(function(){
//     $('.input-images').imageUploader({
//       extensions: ['.jpg', '.jpeg', '.png', '.gif', '.svg'],
//       mimes: ['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml'],
//       maxSize: undefined,
//       maxFiles: undefined,

//     });
// });
$('.gallery').miv({
  image:'.cam',
  video:'.vid'
});
    </script>
    <style>
        .ck-editor__editable {
            height: 200px !important;
        }

        #post_type-error {
            position: absolute;
            top: 150%;
        }

        .social-area .error {
            width: auto !important;
        }
    </style>

<script>
    $(document).ready(function(){
        $('.rate label').on('click', function(){
            var selectedValue = $(this).prev('input').val();
            $('.rate label').removeClass('checked');
            $(this).addClass('checked').prevAll('label').addClass('checked');
        });

        $('#submitReview').on('click', function(){
            var rating = $('input[name="rating"]:checked').val();
            var description = $('#message-text').val();
            // Here you can perform further actions like submitting the data via AJAX
            console.log("Rating: " + rating);
            console.log("Description: " + description);
        });
    });




</script>

<script>
    $(function() {
            $("#sortableImgThumbnailPreview").sortable({
             connectWith: ".RearangeBox",
            
                
              start: function( event, ui ) { 
                   $(ui.item).addClass("dragElemThumbnail");
                   ui.placeholder.height(ui.item.height());
           
               },
                stop:function( event, ui ) { 
                   $(ui.item).removeClass("dragElemThumbnail");
               }
            });
            $("#sortableImgThumbnailPreview").disableSelection();
        });




document.getElementById('files').addEventListener('change', handleFileSelect, false);

  function handleFileSelect(evt) {
    
    var files = evt.target.files; 
    var output = document.getElementById("sortableImgThumbnailPreview");
    
    // Loop through the FileList and render image files as thumbnails.
    for (var i = 0, f; f = files[i]; i++) {

      // Only process image files.
      if (!f.type.match('image.*')) {
        continue;
      }

      var reader = new FileReader();

      // Closure to capture the file information.
      reader.onload = (function(theFile) {
        return function(e) {
          // Render thumbnail.
           var imgThumbnailElem = "<div class='RearangeBox imgThumbContainer'><i class='material-icons imgRemoveBtn' onclick='removeThumbnailIMG(this)'>cancel</i><div class='IMGthumbnail' ><img  src='" + e.target.result + "'" + "title='"+ theFile.name + "'/></div><div class='imgName'>"+ theFile.name +"</div></div>";
                    
                    output.innerHTML = output.innerHTML + imgThumbnailElem; 
          
        };
      })(f);

      // Read in the image file as a data URL.
      reader.readAsDataURL(f);
    }
  }

  function removeThumbnailIMG(elm){
    elm.parentNode.outerHTML='';
  }
</script>


<script>
        $(document).ready(function() {
            $('.description').mentionsInput({
                onDataRequest: function (mode, query, callback) {
                    if (query.charAt(0) === '@') {
                        $.getJSON('/getfollower', { q: query.substring(1) }, function(responseData) {
                            var data = responseData.map(function(item) {
                                return { id: item.id, name: item.name, type: 'user' };
                            });
                            callback.call(this, data);
                        });
                    } else if (query.charAt(0) === '#') {
                        $.getJSON('/get/video/hashtag', { q: query.substring(1) }, function(responseData) {
                            var data = responseData.map(function(item) {
                                return { id: item.id, name: item.name, type: 'tag' };
                            });
                            callback.call(this, data);
                        });
                    }
                },
                onCaret: true,
                templates: {
                    mention: function (mention) {
                        if (mention.type === 'user') {
                            return '<span class="mention">@' + mention.name + '</span>';
                        } else if (mention.type === 'tag') {
                            return '<span class="tag">#' + mention.name + '</span>';
                        }
                    }
                }
            });
        });
    </script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
    const titleInput = document.getElementById('title-input');
    const errorSpan = document.getElementById('title-error');
    const maxLength = 250; // Maximum character length

    titleInput.addEventListener('input', function() {
        const currentLength = titleInput.value.length;

        if (currentLength > maxLength) {
            errorSpan.textContent = `${maxLength} character limit reached.`;
            titleInput.value = titleInput.value.slice(0, maxLength); // Truncate to max length
        } else {
            errorSpan.textContent = "";
        }
    });
});
    
    </script>

</body>

</html>