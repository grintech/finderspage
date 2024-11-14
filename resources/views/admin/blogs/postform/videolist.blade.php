@extends('layouts.adminlayout')
@section('content')
<style>
  .form-control.change_status {
    height: 20px;
    padding: 0;
    width: 100px;
    font-size: 10px;
  }

  .video-box .card a.btn {
    padding: 0px 5px;
  }

</style>
<div class="container px-sm-5 px-4">
  <div class="new_class">
    <h1 class="mt-5 d-inline">Your Videos</h1>
    <a href="{{route('video.add')}}" class="btn btn-warning float-right ">New</a>
    <div>
      <div class="row mt-4">
        @if(empty($video))
        <p class="card-text">Data not available.</p>
        @endif
        @foreach($video as $vid)
        <div class="col-md-4 mb-4 video-box">
          <div class="card">
            <div class="card-body px-2 pt-2 pb-3 pb-md-3 pb-lg-3 pb-xl-0">
              <div class="row">
                <div class="col-xl-6 col-lg-12 col-md-12">
                  <video height="150px" width="100%" controls id="video-tag">
                    <source id="video-source" src="{{asset('video_short')}}/{{$vid->video}}">
                    Your browser does not support the video tag.
                  </video>
                </div>

                <div class="col-xl-6 col-lg-12 col-md-12">
                  <h5 class="card-title">{{$vid->title}}</h5>
                  @if(!empty($vid->location))
                  <div class="">
                    <p style="font-size: 8px; margin-top: 5px;">
                      <i class="fa fa-map-marker" aria-hidden="true" style="font-size: 10px;"></i>
                      {{ $vid->location }}
                    </p>
                  </div>
                  @endif
                  <div class="public-box">
                    <p class="card-text">@if($vid->view_as == "public") public @else Private @endif</p>
                    <span>
                      <select class="form-control change_status" name="change_status" data_id="{{$vid->id}}" user-id="{{$vid->user_id}}">
                        <option {{ $vid->status == 0 ? ' selected' : '' }} value="0">Unpublish</option>
                        <option {{ $vid->status == 1 ? ' selected' : '' }} value="1">Publish</option>
                      </select>
                    </span>
                  </div>
                  <a href="{{route('single.video',$vid->id)}}" class="btn btn-warning"><i class="fa fa-eye" aria-hidden="true"></i></a>
                  <a href="{{route('video.edit',$vid->id)}}" class="btn btn-warning"><i class="far fa-edit"></i></a>
                  <a href="#" data-link="{{route('video.Delete',$vid->id)}}" id="del_my_account" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>

                </div>
              </div>
            </div>
          </div>
        </div>
        @endforeach
      </div>

      <!-- Add more video cards as needed -->

    </div>
    <script type="text/javascript">
      $(document).on("click", "#del_my_account", function(e) {
        e.preventDefault();
        var link = $(this).attr("data-link");
        Swal.fire({
          title: 'Delete',
          text: 'Are you sure you want to Delete?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#fcd152',
          cancelButtonColor: '#1a202e',
          confirmButtonText: 'Yes, Delete!',
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = link;
            Swal.fire(
              'Deleted!',
              'Your file has been deleted.',
              'success'
            )
          }
        });
      });

      $(".change_status").change(function() {
        var status = $(this).val();
        var id = $(this).attr('data_id');
        var user_id = $(this).attr('user-id');
        var csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;
        // alert(csrfToken);
        $.ajax({
          type: 'POST',
          url: '{{route("video.status")}}',
          
          headers: {
            'X-CSRF-TOKEN': csrfToken
          },
          data: {
            id: id, // Fix: use ":" instead of "="
            status: status, // Fix: use ":" instead of "="
            user_id: user_id, // Fix: use ":" instead of "="
          },
          success: function(data) {
            console.log(data);
            if (data.success) {
              toastr.options = {
                "closeButton": true,
                "progressBar": true
              }
              toastr.success(data.success);
              // window.location.reload();
            }
          }
        });
      });
    </script>
    @endsection