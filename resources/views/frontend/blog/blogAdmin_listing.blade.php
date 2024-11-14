<?php use App\Models\UserAuth; 
use App\Models\Setting; ?>
@extends('layouts.frontlayout')
@section('content')
<style>
    .top-search {
        top: 0px !important;
    }
</style>
<section class="job-listing">
    <div class="container">
        <div class="row">
            <div class="col-12 mt-2">
            <h1 style="font-size: 25px;" class="text-center">FindersPage Blogs</h1>
            <div class="row related-job">
                    <div class="col-lg-12 col-md-12">
                        <div class="job-post-header">
                            <div class="row filterBlog">
                                @if(empty($blog_post))
                                    <p class="card-text">Data not available.</p>
                                @endif

                                @foreach($blog_post as $post)

                                @if($post->posted_by=="admin") 
                                <?php
                                    $img  = explode(',',$post->image);
                                ?>
                                <div class="col-lg-3 col-md-4 col-12 blog-box">   
                                    <a href="{{route('blogPostSingle', $post->slug)}}">
                                    <div class="card">
                                    @if(isset($post->image))
                                        <img class="card-img-top" src="{{asset('images_blog_img')}}/{{$img[0]}}" alt="img..." >
                                    @else
                                        <img  class="card-img-top" src="{{asset('images_blog_img/1688636936.jpg')}}" alt="img..." >
                                    @endif
                                        <div class="card-body">
                                            <h5 class="card-title">{{$post->title}}</h5>
                                            <p class="card-title">
                                            <?php
                                                $givenTime = strtotime($post->created_at);
                                                $currentTimestamp = time();
                                                $timeDifference = $currentTimestamp - $givenTime;

                                                $days = floor($timeDifference / (60 * 60 * 24));
                                                $hours = floor(($timeDifference % (60 * 60 * 24)) / (60 * 60));
                                                $minutes = floor(($timeDifference % (60 * 60)) / 60);
                                                $seconds = $timeDifference % 60;

                                                $timeAgo = "";
                                                if ($days > 0) {
                                                    $timeAgo = Setting::get_formeted_time($days);
                                                }else { 
                                                    $timeAgo .= " Posted today. ";
                                                }
                                                    echo $timeAgo;
                                                ?>
                                            </p>
                                            {{-- <p class="card-text content-box">{!! $post->content !!}</p> --}}
                                            <a href="{{route('blogPostSingle', $post->slug)}}" class="btn blog-read-button">Read More</a>
                                        </div>
                                        </div>
                                        </a>
                                    </div>
                                    @endif
                                @endforeach

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
        let selectedParent = 728;
        let csrfToken = $('meta[name="csrf-token"]').attr('content');
        
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
        
        var searcjobParent = 728;
        var searcjobChild = $('#searcjobChild option:selected').attr('data-sub_id');
        var location = $('#get-Location').val();
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        
        $.ajax({
            url: site_url+'/blog/listing/filter',
            type: 'post',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {
                searcjobParent: searcjobParent,
                searcjobChild: searcjobChild,
                location: location,
            },
            success: function(data) {
                if (data && data.html) {
                    $('.filterBlog').html(data.html);
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
                $('.filterBlog').html('<p>Error loading posts.</p>');
            }
        });
    });
});
</script>

@endsection