@php
use App\Models\UserAuth;
@endphp
@extends('layouts.user_dashboard.userdashboardlayout')
@section('content')
<style type="text/css">
    a.buttons-collection {
        margin-left: 1em;
    }
    .carousel-item {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .carousel-item img {
        object-fit: cover;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-12">
            <span>
                @include('admin.partials.flash_messages')
            </span>
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="tableListing">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Profile</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Email</th>
                            <th>Phone no</th>
                            <th>Document</th>
                            <th>Apply Date</th>
                            <th>Cover Letter</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $newData)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>
                                <?php
                                    // $user_id = $newData->user_id;
                                    $userSlug = UserAuth::getUserSlug($newData->applicant_id);
                                    $userName = UserAuth::getUser($newData->applicant_id);
                                    $itemFeaturedImages = trim($newData->image,'[""]');
                                    $itemFeaturedImage  = explode('","',$itemFeaturedImages);
                                    if (is_array($itemFeaturedImage)) {
                                        foreach ($itemFeaturedImage as $keyitemFeaturedImage => $valueitemFeaturedImage) {
                                            $class = $keyitemFeaturedImage == 0 ? 'active' : 'inactive';
                                ?>
                                            <div class="carousel-item {{ $class }}">
                                                <img src="{{asset('images_blog_img')}}/{{ $valueitemFeaturedImage }}" height="50px" width="50px" alt="Image" class="d-block rounded-circle" onerror="this.onerror=null; this.src='https://finder.harjassinfotech.org/public/images_blog_img/1688636936.jpg';">
                                            </div>
                                <?php
                                        }
                                    }
                                ?>
                            </td>
                            <td><a href="{{route('UserProfileFrontend',$userSlug->slug)}}">{{$userName->first_name}}</a></td>
                            <td>@if($newData->status == 1) <span class="text-success">Job-open</span> @else <span class="text-danger">Job-close</span> @endif</td>
                            <td>{{$newData->email}}</td>
                            <td>{{$newData->phone_no}}</td>
                            <td>
                                <a target="_blank" href="{{asset('File_jobApply')}}/{{$newData->file}}">
                                    <img src="{{asset('new_assets/assets/images/download.png')}}" doc-path="{{asset('File_jobApply')}}/{{$newData->file}}" height="50" width="50" alt="Download">
                                </a>
                            </td>
                            <td>{{$newData->created_at}}</td>
                            <td>{{$newData->cover_letter}}</td>
                            <td>
                                <a href="#" data-link="{{route('apply.destroy', $newData->id)}}" id="del_apply_job" class="btn btn-danger">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).on("click", "#del_apply_job", function(e) {
        e.preventDefault();
        var link = $(this).attr("data-link");
        Swal.fire({
            title: 'Are you sure?',
            text: 'Are you sure you want to delete this record?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#fcd152',
            cancelButtonColor: '#1a202e',
            confirmButtonText: 'Yes, delete it!',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = link;
                Swal.fire(
                    'Deleted!',
                    'The record has been deleted.',
                    'success'
                );
            }
        });
    });
</script>
@endsection
