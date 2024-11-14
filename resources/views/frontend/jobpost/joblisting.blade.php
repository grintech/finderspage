@php
use App\Models\UserAuth;
use App\Models\Setting;

use Illuminate\Support\Str;
@endphp
@extends('layouts.frontlayout')

@section('content')
<style>
    .user-input-found {
        border-radius: 14px;
        border: 1px solid #000;
        padding-left: 11px;
        padding: 3px;
        margin-right: -35px;
    }

    .search {
        text-align: right;
    }

    @media only screen and (max-width: 767px) {
        .search_icon {
            border-radius: 14px;
            border: 1px solid #000;
            padding-left: 11px;
            padding: 3px;
            width: 100%;
            margin: auto;
        }

        .span_getuser {
            position: relative;
            top: -27px;
            right: 10px;
        }
    }

    .feature-box {
        overflow: inherit !important;
    }

    .top-search {
        top: 0px !important;
    }

    input#get-Location {
        height: 40px;
        background-color: #eeecec;
        font-size: 13px;
    }
    .main-cat {
        font-size: 13px;
        height: 40px !important;
    }
</style>

<section class="job-listing">
    <div class="container">
        <div class="row">
            <h1 class="text-center" style="font-size: 2.0rem;">Job Search & Employment Opportunities</h1>
                <div class="col-md-3 col-lg-3">
                    <div class="top-search">
                        <form id="searchForm">
                            <div class="row">
                                @csrf
                                <div class="col-md-12 coll-1 mb-2">
                                    <div class="select-job">
                                        <input class="form-control main-cat" id="searcjob" type="text" name="Jobs" value="Jobs" readonly>
                                    </div>
                                </div>
                    
                                <div class="col-md-12 coll-1 mb-2">
                                    <div class="select-job">
                                        <select id="searcjobChild" name="searcjobChild" class="form-select" data-live-search="true">
                                            <option value="">Sub Categories</option>
                                        </select>
                                    </div>
                                </div>
                    
                                <div class="col-md-12 coll-1 mb-2">
                                    <div class="location-search">
                                        <input type="text" name="location" class="form-control get_loc" id="get-Location" placeholder="Location">
                                        <i id="getLocation" class="bi bi-geo-alt"></i>
                                    </div>
                                    <div class="searcRes new_search_dropbox" id="autocomplete-results"></div>
                                </div>
                    
                                <div class="col-sm-12 col-md-12 coll-2 mb-2">
                                    <div class="search-fields">
                                        <button class="btn fields-search" type="submit">Search<i class="bi bi-arrow-right"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            <div class="col-md-9 mt-2">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="job-post-header">
                            <div class="row related-job">
                                @if ($matchingRecords->isNotEmpty())
                                    @foreach($matchingRecords as $Records)
                                        <div class="col-lg-3 col-md-6 mb-3">
                                            <div class="feature-box" style="position:relative;">
                                                @if($Records->bumpPost == "1")
                                                    <div class="ribbon bump-ribbon" data-toggle="tooltip" data-placement="top" title="This is a bumped listing.">
                                                        <div class="text-div">
                                                            Bumped
                                                        </div>
                                                    </div>
                                                @endif

                                                <a href="{{ route('jobpost', $Records->slug) }}">
                                                    <div class="carousel-inner">
                                                        @php
                                                            $itemFeaturedImages = trim($Records->image1, '[""]');
                                                            $itemFeaturedImage = explode('","', $itemFeaturedImages);
                                                        @endphp
                                                        @if (is_array($itemFeaturedImage))
                                                            @foreach ($itemFeaturedImage as $key => $value)
                                                                @php
                                                                    $class = $key == 0 ? 'active' : 'in-active';
                                                                @endphp
                                                                <div class="carousel-item {{ $class }}">
                                                                    <img src="{{ asset('images_blog_img/' . $value) }}" alt="Image" class="d-block w-100" onerror="this.onerror=null; this.src='{{ asset('images_blog_img/1688636936.jpg') }}'">
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    </div>

                                                    <p class="job-title">{{ ucfirst($Records->title) }}</p>

                                                    <div class="main-days-frame">
                                                        <span class="days-box">
                                                            @php
                                                                $givenTime = strtotime($Records->created);
                                                                $currentTimestamp = time();
                                                                $timeDifference = $currentTimestamp - $givenTime;

                                                                $days = floor($timeDifference / (60 * 60 * 24));
                                                                if ($days > 0) {
                                                                   
                                                                    $timeAgo = Setting::get_formeted_time($days);
                                                                } else {
                                                                    $timeAgo = "Posted today";
                                                                }
                                                            @endphp
                                                            {{ $timeAgo }}
                                                        </span>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="col-12 text-center">
                                        <h3 style="padding: 5% 0% 2% 0%; font-size: 20px;">No data found under this category.</h3>
                                        <a href="{{ url('/') }}">
                                            <button class="btn" type="button">Go to Search</button>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
$("#menu-toggle").click(function(e) {
  e.preventDefault();
  $("#wrapper").toggleClass("toggled");
});
$(document).ready(function() {
    function fetchSubCategories() {
        var selectedParent = $('#searcjob').val();

        if (selectedParent === "Jobs") {
            selectedParent = 2;
        }
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: "{{ url('/getchildcat') }}",
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": csrfToken
            },
            data: {
                selectedParent: selectedParent,    
            },
            success: function(response) {
                let optionsHtml = "<option value=''>Sub Categories</option>";
                $.each(response, function(index, item) {
                    optionsHtml += `<option data-id='${item.parentID}' data-sub_id='${item.id}' value='${item.slug}'>${item.title}</option>`;
                });
                $('#searcjobChild').html(optionsHtml);
            },
            error: function(response) {
                console.log('error', response);
            }
        });
    }

    fetchSubCategories();

    $('#searchForm').on('submit', function(e) {
        e.preventDefault();

        var searcjobParent = $('#searcjob').val();

        if (searcjobParent === "Jobs") {
            searcjobParent = 2;
        }
        var searcjobChild = $('#searcjobChild option:selected').attr('data-sub_id');
        var location = $('#get-Location').val();
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: "{{ url('/filter') }}",
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {
                searcjobParent: searcjobParent,
                searcjobChild: searcjobChild,
                location: location,
            },
            success: function(response) {
              console.log(response);
                 $(".related-job").html(response.html);
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
                console.error('Response Text:', xhr.responseText);
            }
        });
    });
});

$(document).ready(function() {
    $('.get_loc').keyup(function () {
            var address = $(this).val();
            console.log(address);
             var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
             console.log('CSRF Token:', csrfToken);
            $.ajax({
                url: site_url+'/get/place/autocomplete',
                type: 'POST',
                headers: {
                  'X-CSRF-TOKEN': csrfToken,
                },
                data: {
                    address:address,
                },
                success: function(response){
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
        // $('.Search_val').removeClass('active_li');

    });
    $(document).on("click",".Search_val",function() {
        var searchVal = $(this).text();
        // alert(searchVal);
        $('.get_loc').val(searchVal);
        $(this).addClass('active_li');
        $('#autocomplete-results').hide();

    });
</script>

@endsection