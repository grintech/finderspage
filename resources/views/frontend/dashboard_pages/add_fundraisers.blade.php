@extends('layouts.user_dashboard.userdashboardlayout')
@section('content')
<?php use App\Models\UserAuth;
$userdata = UserAuth::getLoginUser();
// dd($userdata);
?>
<style>
    #add-input {
        font-size: 8px;
        background-color: #b2944a;
        position: absolute;
        right: 0;
        top: -5px;
        margin-right: 15px;
    }
    .add-links{padding-right: 50px;}
    .remove-input {
        font-size: 8px;
        background-color: #b2944a;
        position: absolute;
        right: 0;
        top: 8px;
        margin-right: 15px;
    }
    .fundraisers-display label {
      margin: 0px;
    }

    .fundraisers-display {
      display: flex;
       gap: 8px;
    }
    button.btn.dropdown-toggle.btn-default.btn-light {
    font-size: .95rem;
    height: 45px;
    border: 1px solid #bdbdbd;
   }

@media only screen and (max-width:767px){
 #add-input{top:44px;}   
}
@media only screen and (min-width:768px) and (max-width:991px){
    #add-input{top:20px;}   
}
</style>
<div class="container px-sm-5 px-4 pb-4">
    <form id="fundraiser_form" method="post" action="{{ route('add.fundraisers') }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        <!-- Page Heading -->
        <div class="d-sm-flex flex-column mb-3">
            <h1 class="h3 mb-0 text-gray-800 fw-bold">Fundraisers</h1>
        </div>
        <span>
            @include('admin.partials.flash_messages')
        </span>
        <input type="hidden" name="categories" value="7">

        <div class="row bg-white border-radius pb-4 p-3">
            <div class="col-md-6 mb-4">
                <label class="labels">Title <sup>*</sup></label>
                <input type="text" id="title-input" class="form-control" name="title" placeholder="Title">
                @error('title')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="col-md-6 mb-4">
                <label class="labels">Choose category for fundraising <sup>*</sup></label>
                <select class="form-control-xs selectpicker" name="sub_category" data-size="7" data-live-search="true" data-title="Sub category" id="sub_category" data-width="100%">

                    @foreach($categories as $cate)
                    <option data-tokens="{{$cate->title}}" value="{{$cate->id}}">{{$cate->title}}</option>
                    @endforeach
                    <option class="Other-cate" value="Other">Other</option>
                </select>
                <input type="text" class="form-control d-none mt-2" id="Other-cate-input" name="sub_category_oth" placeholder="sub_category name" value="">
                @error('fundraising_category')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="col-md-6 mb-4">
                <label class="labels">Cover image</label>
                <div class="upload-icon">
                    <a class="cam btn btn-warning" href="javascript:void(0)">
                        <i class="fa fa-upload" aria-hidden="true"></i> Upload
                    </a>
                </div>
                <div class="gallery" id="sortableImgThumbnailPreview"></div>
                @error('image')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="col-md-6 mb-4">
                <label class="labels">Video </label>
                <div class="upload-icon">
                    <a class="videoChanel btn btn-warning" href="javascript:void(0)">
                        <i class="fa fa-upload" aria-hidden="true"></i> Upload
                    </a>
                </div>
                <div class="video_gallery" id="sortableImgThumbnailPreview_video"></div>
                @error('image')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>


            <div class="col-md-12 mb-4">
                <label class="labels">How much would you like to raise? </label>
                <input type="text" class="form-control" name="raise_amount" placeholder="Add amount">
                @error('raise_amount')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div id="input-container" class="col-md-12 mb-4">
                <!-- Initial input field -->
                <label class="labels add-links">Add payment links (Paypal, ApplePay, GooglePay, Venmo, Zelle, etc.. )</label>

                <div class="input-row row mt-2">
                    <div  class="col-md-6 mb-4">
                        <input type="text" name="payment_links[]" class="form-control website_url" placeholder="Add payment links to receive payments" value="">
                    </div>
                    <div  class="col-md-6 mb-4">
                    <input type="text" name="payment_name[]" class="form-control website_url" placeholder="Payment name" value="">
                    <button class="btn btn-warning remove-input" type="button"><i class="fa fa-minus" aria-hidden="true"></i></button>
                    </div>
                </div>
                <button class="btn btn-warning" id="add-input" type="button"><i class="fa fa-plus" aria-hidden="true"></i></button>
            </div>

            <div class="col-md-12 mb-4">
                <label class="labels">Description </label>
                <textarea id="editor1" class="form-control" name="description" placeholder="Description"></textarea>
                @error('description')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <input type="hidden" name="post_type" value="Normal Post" >

            <div class="col-md-12 mb-4">
                <div class="col-md-12 mt-4">
                    <label class="custom-toggle">
                        <input type="checkbox" name="personal_detail" value="true"> &nbsp;&nbsp;
                        <span>Show your contact details. Keep in mind if you want customers to reach you outside of FindersPage you will need to make your contact details visible to the public.</span>
                    </label>
                </div>
                <div class="row">
                    <div class="col-md-6 mt-4">
                        <label class="custom-toggle">Email</label>
                        <input type="email" class="form-control" name="email" placeholder="example@example.com">
                    </div>
                    <div class="col-md-6 mt-4">
                        <label class="custom-toggle">Phone number</label>
                        <input type="tel" class="form-control" id="phone" name="phone" placeholder="+1 1234567890">
                        <span id="phone-error" style="color: red; display: none;">Please enter a valid phone number.</span>
                    </div>
                    <div class="col-md-6 mt-4">
                        <label class="custom-toggle">Website link</label>
                        <input type="text" class="form-control" name="website" placeholder="https://test.com">
                    </div>
                    <div class="col-md-6 mt-4">
                        <label class="custom-toggle">Whatsapp</label>
                        <input type="tel" class="form-control" id="whatsapp" name="whatsapp" placeholder="whatsapp number">
                    </div>
                </div>
            </div>

           

            <input type="hidden" name="post_type" value="Normal Post" >

            

            <div class="col-12">
                <button class="btn btn-warning addCategory" type="submit" id="fundraiser_submit">
                    <i class="fas fa-save"></i> Submit
                </button>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript">
$(document).ready(function() {
    var csrfToken = $('meta[name="csrf-token"]').attr('content');

    $(document).ready(function() {
        var isChecked1 = $('input[name="personal_detail"]').is(':checked');
        console.log(isChecked1);
        if (isChecked1 === true) {
            $('.hidesection').removeClass('d-none');
        } else {
            $('.hidesection').addClass('d-none');
        }
        $('input[name="personal_detail"]').on('click', function() {
            var isChecked = $(this).is(':checked');
            console.log(isChecked);
            if (isChecked === true) {
                $('.hidesection').removeClass('d-none');
            } else {
                $('.hidesection').addClass('d-none');
            }


        });
    });


    $('#fundraiser_form').validate({
        rules: {
            title: 'required',
            fundraising_category: 'required',
            description: 'required',
            raise_amount: {
                // required: true,
                number: true
            },
            email: {
                email: true
            },
            image: {
                extension: "jpg,jpeg,png",
                filesize: 1024 * 1024 // 1MB
            }
        },
        messages: {
            title: 'Title field is required',
            fundraising_category: 'Category is required',
            raise_amount: 'Enter a valid amount',
            email: 'Enter a valid email address'
        },
        submitHandler: function(form) {
            form.submit();
        }
    });

    $('#phone, #whatsapp').on('keypress', function(e) {
        var keyCode = e.which;
        if (!(keyCode >= 48 && keyCode <= 57)) e.preventDefault();
    });
});
</script>
<script>
    $(document).ready(function() {
        // Add new input row
        $('#add-input').on('click', function() {
            var newInputRow = $('.input-row:first').clone(); // Clone the first input row
            newInputRow.find('input').val(''); // Clear the value of the cloned input
            $('#input-container').append(newInputRow); // Append the cloned row to the container
        });

        // Remove input row
        $(document).on('click', '.remove-input', function() {
            if ($('.input-row').length > 1) {
                $(this).closest('.input-row').remove(); // Remove the clicked input row
            }
        });
    });
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });


    $(document).ready(function() {

$('#sub_category').on('change', function() {
    if ($(this).val() == "Other") {
        $('#Other-cate-input').removeClass('d-none');
        $(this).addClass('d-none');
    } else {
        $('#Other-cate-input').addClass('d-none');
    }

});

$('.addCategory').click(function() {
    var subcate_title = $('#Other-cate-input').val();
    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    $.ajax({
        url: baseurl + '/shopping/cate',
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        data: {
            title: subcate_title,
            parent_id: 7,
        },
        success: function(response) {
            console.log(response);
        },
        error: function(xhr, status, error) {

        }
    });
});
});

    
</script>
@endsection
