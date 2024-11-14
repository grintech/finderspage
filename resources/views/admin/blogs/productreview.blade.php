@extends('layouts.adminlayout')
@section('content')
<style>
    .img-section {
  height: 50px;
  border-radius: 50%;
}
</style>
<div class="header bg-primary">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">Product Reviews</h6>
                </div>
                
            </div>
        </div>
    </div>
</div>
<div class="review-section">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="table-responsive">
                    <table class="table align-items-center table-flush listing-table">
                        <thead>
                            <th>Name</th>
                            <th>Rating</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Attachments</th>
                            <th>Report</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @foreach($ProductReview as $rev)
                            <tr>
                                <td>{{$rev->name}}</td>
                                <td>
                                    <div class="reviews" id="starRating">
                                        <?php

                                            for ($i = 1; $i <= 5; $i++) {
                                                if ($i <= $rev->rating) {
                                                    // Full star
                                                    echo '<i class="fas fa-star"></i>';
                                                } else {
                                                    // Empty star
                                                    echo '<i class="far fa-star"></i>';
                                                }
                                            }
                                        ?>
                                    </div>
                                </td>
                                <td>@if(isset($rev->title)) {{$rev->title}} @else  N/A @endif</td>
                                <td>@if(isset($rev->discription)) {{$rev->discription}} @else  N/A @endif</td>
                                <td>@if(isset($rev->file))<img dataid="{{$rev->file}}" src="{{asset('images_reviews')}}/{{$rev->file}}" class="img-section" alt="" > @else N/A @endif</td>
                                <td>@if(isset($rev->report)) <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal{{$rev->id}}">Read reports</button> @else N/A @endif</td>

                                <td><a id="delete_rev" href="javascrit:void();" data-link='{{route("blog.admin.review.del",$rev->id)}}' ><i class="fas fa-trash text-danger" aria-hidden="true"></i></a></td>
                            </tr>


                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal{{$rev->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Reports</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    @if(isset($rev->report))
                                        <?php 
                                            $reportsData = json_decode($rev->report); 
                                        ?>

                                        @foreach($reportsData->report as $repData)
                                            <div class="reportdata">
                                               <p> {{$repData}} </p>
                                            </div>
                                            <hr>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="modal-footer">
                                    
                                </div>
                                </div>
                            </div>
                            </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).on("click", "#delete_rev", function(e) {
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
</script>
@endsection