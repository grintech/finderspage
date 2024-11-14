<?php
use App\Models\UserAuth;
use App\Models\Setting;
?>
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
<section class="job-listing">
    <div class="container">
        <div class="row">
            <h1 class="text-center" style="font-size: 2.0rem;">Blogs</h1>
            <div class="col-md-4 col-lg-3">
                <div class="top-search">
                    <form id="searchForm">
                        <div class="row">
                            @csrf
                            <div class="col-md-12 coll-1 mb-2">
                                <div class="select-job">
                                    <select id="searcjob" class="form-select" name="searcjobParent">
                                        <option value="728" selected>Blogs</option>
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
            <div class="col-md-8 col-lg-9 mt-2">
                <div class="row related-job filterRes">
                    @if(isset($BlogsView))
                        @foreach($BlogsView as $post)
                        <?php
                        $img  = explode(',', $post->image);
                        ?>
                        <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                            <div class="feature-box">
                                <span class="onsale">Featured!</span>
                                <a href="{{route('blogPostSingle',$post->slug)}}">
                                    <div id="demo-new" class="carousel1 slide">
                                        <div class="carousel-inner">
                                            <?php
                                            if (isset($post->image)) {
                                                echo "<div class='carousel-item active'>";
                                                echo "<img src='" . asset('images_blog_img/' . $img[0]) . "' alt='Image' class='d-block w-100'>";
                                                echo "</div>";
                                            } else {
                                                echo "<div class='carousel-item active'>";
                                                echo "<img src='" . asset('images_blog_img/1688636936.jpg') . "' alt='Image' class='d-block w-100'>";
                                                echo "</div>";
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="job-post-content">
                                        <h4><b>{{ $post->title }}</b></h4>
                                        <div class="job-type">
                                            <ul class="job-list">
                                                <div class="main-days-frame">
                                                    <span class="days-box">
                                                        <?php
                                                        $givenTime = strtotime($post->created_at);
                                                        $currentTimestamp = time();
                                                        $timeDifference = $currentTimestamp - $givenTime;
                                                        $days = floor($timeDifference / (60 * 60 * 24));
                                                        $timeAgo = ($days > 0) ? (Setting::get_formeted_time($days)) : "Posted today";
                                                        echo $timeAgo;
                                                        ?>
                                                    </span>
                                                </div>
                                            </ul>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <p class="card-text">Data not available.</p>
                    @endif
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
            url: "{{ url('/blog/listing/filter') }}",
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {
                searcjobParent: searcjobParent,
                searcjobChild: searcjobChild,
                location: location,
            },
            success: function(data) {
                $('.related-job').html(data.html);
            },
            error: function(xhr, status, error) {
                console.error('Error:', xhr.responseText);
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
</script>
@endsection
