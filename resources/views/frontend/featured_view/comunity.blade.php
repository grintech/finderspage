@php
use App\Models\Setting;
@endphp
@extends('layouts.frontlayout')

@section('content')

<style type="text/css">
    span.onsale {
        background-color: red;
    }
    .onsale {
        z-index: 6;
        position: absolute;
        top: 0px;
        left: 6px;
        padding: 2px 10px;
        background: var(--red);
        color: #fff;
        box-shadow: -1px 2px 3px rgba(0, 0, 0, 0.3);
        border-radius: 0 5px 5px 0;
        height: 25px;
        line-height: 25px;
        font-size: 0.8rem;
        font-weight: normal;
        padding-top: 0;
        padding-bottom: 0;
        min-height: 0;
    }
    .onsale:before {
        width: 7px;
        height: 33px;
        top: 0;
        left: -6.5px;
        padding: 0 0 7px;
        background: inherit;
        border-radius: 5px 0 0 5px;
    }
    .onsale:before, .onsale:after {
        content: "";
        position: absolute;
    }
    .top-search {
        top: 0px !important;
    }
    input#get-Location {
        height: 40px;
        background-color: #eeecec;
    }
</style>

<section id="shoplisting-page">
    <div class="container">
        <div class="row">
            <h1 class="text-center" style="font-size: 2.0rem;">Community Listings</h1>

            <div class="col-md-4 col-lg-3">
                <div class="top-search">
                    <form id="searchForm">
                        <div class="row">
                            @csrf
                            <div class="col-md-12 coll-1 mb-2">
                                <div class="select-job">
                                    <select id="searcjob" class="form-select" name="searcjobParent">
                                        <option value="5" selected>Our Community</option>
                                    </select>
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
                                <div class="searcRes" id="autocomplete-results"></div>
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

            <div class="col-md-8 col-lg-9">
                <div class="row related-job">
                    <div class="col-lg-12 col-md-12">
                        <div class="job-post-header">
                            <div class="row filterRes">
                                @if ($matchingRecords->isNotEmpty())
                                    @foreach($matchingRecords as $record)
                                        <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                                            <div class="feature-box">
                                                <span class="onsale">Featured!</span>
                                                <a href="{{ route('community_single_post', ['slug' => $record->slug]) }}">
                                                    <div id="demo-new" class="carousel1 slide">
                                                        <div class="carousel-inner">
                                                            @php
                                                                $itemFeaturedImages = trim($record->image1, '[""]');
                                                                $itemFeaturedImage  = explode('","', $itemFeaturedImages);
                                                            @endphp

                                                            @foreach($itemFeaturedImage as $key => $value)
                                                                <div class="carousel-item {{ $key == 0 ? 'active' : 'in-active' }}">
                                                                    <img src="{{ asset('images_blog_img') }}/{{ $value }}" alt="Featured Image" class="d-block w-100" onerror="this.onerror=null; this.src='{{ asset('images_blog_img/1688636936.jpg') }}';">
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>

                                                    <div class="Name">
                                                        <span>{{ $record->title }}</span>
                                                    </div>

                                                    <div class="main-days-frame">
                                                        <span class="days-box">
                                                            @php
                                                                $givenTime = strtotime($record->created);
                                                                $currentTimestamp = time();
                                                                $timeDifference = $currentTimestamp - $givenTime;

                                                                $days = floor($timeDifference / (60 * 60 * 24));
                                                                $hours = floor(($timeDifference % (60 * 60 * 24)) / (60 * 60));
                                                                $minutes = floor(($timeDifference % (60 * 60)) / 60);
                                                                $seconds = $timeDifference % 60;

                                                                $timeAgo = ($days > 0) ? Setting::get_formeted_time($days) : "Posted today";
                                                            @endphp
                                                            {{ $timeAgo }}
                                                        </span>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="col-12" style="text-align: center;">
                                        <h3 style="padding: 5% 0% 2% 0%; font-size: 20px;">No data found under this category.</h3>
                                        <a href="{{ url('/') }}">
                                            <button style="margin-bottom: 5%;" class="btn create-post-button" type="button">Go to Search</button>
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

<script type="text/javascript">
    $(document).ready(function() {
        function fetchSubCategories() {
            let selectedParent = $('#searcjob').val();
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
            var searcjobChild = $('#searcjobChild option:selected').attr('data-sub_id');
            var location = $('#get-Location').val();
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
    
            $.ajax({
                url: "{{ url('/community/filter') }}",
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
                    $(".filterRes").html(response);
                    $('.lds-dual-ring').addClass('d-none');
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                    console.error('Response Text:', xhr.responseText);
                    $('.lds-dual-ring').addClass('d-none');
                }
            });
        });
    });
</script>

@endsection
