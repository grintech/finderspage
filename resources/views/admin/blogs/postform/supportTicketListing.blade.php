@extends('layouts.adminlayout')
@section('content')

 <div class="container-fluid px-3 px-md-5">

                    <!-- Page Heading -->
                    <div class="d-flex justify-content-between mb-3 pt-4">
                        <div class="support_1">
                            <h1 class="mb-0 text-gray-800 fw-bold">Support</h1>
                        <p>View all tickets data here</p>
                        </div>
                        
                        <div class="support_2">
                            <a href="{{route('support.add')}}" class="btn btn-warning">New</a>
                        </div>
                    </div>
                    @include('admin.partials.flash_messages')
                    <!-- Content Row -->
                    <div class="tab-area">
                        <ul class="nav nav-pills" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-new-tab" data-toggle="pill" href="#pills-new" role="tab" aria-controls="pills-new" aria-selected="true">
                                   <div class="card h-100">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center bx1">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-white text-uppercase mb-1">
                                                    New Tickets <br><small>From Average Yesterday</small></div>
                                                <div class="h5 mb-0 font-weight-bold text-primary">{{$new}}</div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-ticket-alt fa-2x text-primary"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-open-tab" data-toggle="pill" href="#pills-open" role="tab" aria-controls="pills-open" aria-selected="false">
                                    <div class="card h-100">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center bx1">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-white text-uppercase mb-1">
                                                    Open Tickets <br><small>From Average Yesterday</small></div>
                                                <div class="h5 mb-0 font-weight-bold text-success">{{$open}}</div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-box-open fa-2x text-success"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-pending-tab" data-toggle="pill" href="#pills-pending" role="tab" aria-controls="pills-pending" aria-selected="false">
                                    <div class="card h-100">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center bx1">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-white text-uppercase mb-1">
                                                    Pending Tickets <br><small>From Average Yesterday</small></div>
                                                <div class="h5 mb-0 font-weight-bold text-info">{{$inprogress}}</div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-hourglass-half fa-2x text-info"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-closed-tab" data-toggle="pill" href="#pills-closed" role="tab" aria-controls="pills-closed" aria-selected="false">
                                    <div class="card h-100">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center bx1">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-white text-uppercase mb-1">
                                                    Closed Tickets <br><small>From Average Yesterday</small></div>
                                                <div class="h5 mb-0 font-weight-bold text-warning">{{$close}}</div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-lock fa-2x text-warning"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="row tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-new" role="tabpanel" aria-labelledby="pills-new-tab">
                            <div class="table-area table-responsive mt-4">
                                <table class="support-table px-3">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Ticket Title</th>
                                            <th scope="col">User Name</th>
                                            <th scope="col">Description</th>
                                            <th scope="col">Create Date</th>
                                            <th scope="col">Priority</th>
                                            <th scope="col">Ticket Status</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($supports as $spp)
                                        @if($spp->ticket_status==0)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$spp->ticket_title}}</td>
                                            <td>{{$spp->first_name}}</td>
                                            <td>{!! $spp->discription !!}</td>
                                            <td>{{$spp->created_at}}</td>
                                            <td class="create-date">
                                                @if($spp->priority == 0)
                                                    <span class="badge bg-primary text-white">Low</span>
                                                @elseif($spp->priority == 1)
                                                <span class="badge bg-warning text-white">Medium</span> 
                                                @elseif($spp->priority == 2)<span class="badge bg-danger text-white">High</span>
                                                @endif
                                            </td>
                                            <td class="due-date">
                                                @if($spp->ticket_status == 0)
                                                    <span class="badge bg-primary text-white">New</span>
                                                @elseif($spp->ticket_status == 1)
                                                    <span class="badge bg-success text-white">Open</span>
                                                @elseif($spp->ticket_status == 2)
                                                    <span class="badge bg-warning text-white">In-progress</span>
                                                @elseif($spp->ticket_status == 3)
                                                    <span class="badge bg-danger text-white">Close</span>
                                                @endif
                                            </td>
                                            <td class="action">
                                                <ul class="d-flex justify-content-center list-unstyled mb-0">
                                                    <li>
                                                <select class="form-control change_status" name="change_status" data_id="{{$spp->id}}" user-id="{{$spp->user_id}}">
                                                    <option {{ $spp->ticket_status == 0 ? ' selected' : '' }} value="0">New</option>
                                                    <option {{ $spp->ticket_status == 1 ? ' selected' : '' }} value="1">Open</option>
                                                    <option {{ $spp->ticket_status == 2 ? ' selected' : '' }} value="2">In-progress</option>
                                                    <option {{ $spp->ticket_status == 3 ? ' selected' : '' }} value="3">Close</option>
                                                </select>   
                                            </li>
                                            <li>
                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-warning rp-btn" data-toggle="modal" data-target="#exampleModalCenter">
                                                      Reply 
                                                    </button>  
                                            </li>
                                            </ul>  
                                          </td>
                                        </tr>
                                        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                          <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">Email Editor</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                                </button>
                                              </div>
                                              <div class="modal-body">
                                                <form method="POST" action="{{route('support.ticket.email')}}">
                                                    @csrf
                                                    <div class="col-md-12 mb-4" >
                                                    <input type="hidden" name="email" value="{{$spp->email}}">
                                                    <textarea id="editor1" class="form-control" name="message" placeholder="Write a text"></textarea>
                                                    </div>
                                                    <div class="col-md-3 mb-4" >
                                                        <button type="submit" class="btn btn-warning">send</button>
                                                    </div>
                                                </form>
                                              </div>
                                              <div class="modal-footer">
                                                
                                              </div>
                                            </div>
                                          </div>
                                        </div>

                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-open" role="tabpanel" aria-labelledby="pills-open-tab">
                            <div class="table-area table-responsive mt-4">
                                <table class="support-table px-3">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Ticket Title</th>
                                            <th scope="col">User Name</th>
                                            <th scope="col">Description</th>
                                            <th scope="col">Create Date</th>
                                            <th scope="col">Priority</th>
                                            <th scope="col">Ticket Status</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($supports as $spp)
                                        @if($spp->ticket_status==1)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$spp->ticket_title}}</td>
                                            <td>{{$spp->first_name}}</td>
                                            <td>{!! $spp->discription !!}</td>
                                            <td>{{$spp->created_at}}</td>
                                            <td class="create-date">
                                                @if($spp->priority == 0)
                                                    <span class="badge bg-primary text-white">Low</span>
                                                @elseif($spp->priority == 1)
                                                <span class="badge bg-warning text-white">Medium</span> 
                                                @elseif($spp->priority == 2)<span class="badge bg-danger text-white">High</span>
                                                @endif
                                            </td>
                                            <td class="due-date">
                                                @if($spp->ticket_status == 0)
                                                    <span class="badge bg-primary text-white">New</span>
                                                @elseif($spp->ticket_status == 1)
                                                    <span class="badge bg-success text-white">Open</span>
                                                @elseif($spp->ticket_status == 2)
                                                    <span class="badge bg-warning text-white">In-progress</span>
                                                @elseif($spp->ticket_status == 3)
                                                    <span class="badge bg-danger text-white">Close</span>
                                                @endif
                                            </td>
                                            <td class="action">
                                              <ul class="d-flex justify-content-center list-unstyled mb-0">
                                                    <li>
                                                       <select class="form-control change_status" name="change_status" data_id="{{$spp->id}}" user-id="{{$spp->user_id}}">
                                                            <option {{ $spp->ticket_status == 0 ? ' selected' : '' }} value="0">New</option>
                                                            <option {{ $spp->ticket_status == 1 ? ' selected' : '' }} value="1">Open</option>
                                                            <option {{ $spp->ticket_status == 2 ? ' selected' : '' }} value="2">In-progress</option>
                                                            <option {{ $spp->ticket_status == 3 ? ' selected' : '' }} value="3">Close</option>
                                                        </select>
                                                    </li>
                                                    <li>
                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-warning rp-btn" data-toggle="modal" data-target="#exampleModalCenter1">
                                                      Reply 
                                                    </button>  
                                                    </li>
                                                </ul>
                                          </td>
                                        </tr>
                                        <div class="modal fade" id="exampleModalCenter1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                          <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">Email Editor</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                                </button>
                                              </div>
                                              <div class="modal-body">
                                                <form method="POST" action="{{route('support.ticket.email')}}">
                                                    @csrf
                                                    <div class="col-md-12 mb-4" >
                                                    <input type="hidden" name="email" value="{{$spp->email}}">
                                                    <textarea id="editor1" class="form-control" name="message" placeholder="Write a text"></textarea>
                                                    </div>
                                                    <div class="col-md-3 mb-4" >
                                                        <button type="submit" class="btn btn-warning">send</button>
                                                    </div>
                                                </form>
                                              </div>
                                              <div class="modal-footer">
                                                
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-pending" role="tabpanel" aria-labelledby="pills-pending-tab">
                            <div class="table-area table-responsive mt-4">
                                <table class="support-table px-3">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Ticket Title</th>
                                            <th scope="col">User Name</th>
                                            <th scope="col">Description</th>
                                            <th scope="col">Create Date</th>
                                            <th scope="col">Priority</th>
                                            <th scope="col">Ticket Status</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($supports as $spp)
                                        @if($spp->ticket_status==2)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$spp->ticket_title}}</td>
                                            <td>{{$spp->first_name}}</td>
                                            <td>{!! $spp->discription !!}</td>
                                            <td>{{$spp->created_at}}</td>
                                            <td class="create-date">
                                                @if($spp->priority == 0)
                                                    <span class="badge bg-primary text-white">Low</span>
                                                @elseif($spp->priority == 1)
                                                <span class="badge bg-warning text-white">Medium</span> 
                                                @elseif($spp->priority == 2)<span class="badge bg-danger text-white">High</span>
                                                @endif
                                            </td>
                                            <td class="due-date">
                                                @if($spp->ticket_status == 0)
                                                    <span class="badge bg-primary text-white">New</span>
                                                @elseif($spp->ticket_status == 1)
                                                    <span class="badge bg-success text-white">Open</span>
                                                @elseif($spp->ticket_status == 2)
                                                    <span class="badge bg-warning text-white">In-progress</span>
                                                @elseif($spp->ticket_status == 3)
                                                    <span class="badge bg-danger text-white">Close</span>
                                                @endif
                                            </td>
                                            <td class="action">
                                              <ul class="d-flex justify-content-center list-unstyled mb-0">
                                                    <li>
                                                        <select class="form-control change_status" name="change_status" data_id="{{$spp->id}}"  user-id="{{$spp->user_id}}">
                                                            <option {{ $spp->ticket_status == 0 ? ' selected' : '' }} value="0">New</option>
                                                            <option {{ $spp->ticket_status == 1 ? ' selected' : '' }} value="1">Open</option>
                                                            <option {{ $spp->ticket_status == 2 ? ' selected' : '' }} value="2">In-progress</option>
                                                            <option {{ $spp->ticket_status == 3 ? ' selected' : '' }} value="3">Close</option>
                                                        </select>
                                                    </li>
                                                   <li>
                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-warning rp-btn" data-toggle="modal" data-target="#exampleModalCenter2">
                                                      Reply 
                                                    </button>  
                                                    </li>
                                                </ul>
                                          </td>
                                        </tr>
                                         <div class="modal fade" id="exampleModalCenter2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                          <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">Email Editor</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                                </button>
                                              </div>
                                              <div class="modal-body">
                                                <form method="POST" action="{{route('support.ticket.email')}}">
                                                    @csrf
                                                    <div class="col-md-12 mb-4" >
                                                    <input type="hidden" name="email" value="{{$spp->email}}">
                                                    <textarea id="editor1" class="form-control" name="message" placeholder="Write a text"></textarea>
                                                    </div>
                                                    <div class="col-md-3 mb-4" >
                                                        <button type="submit" class="btn btn-warning">send</button>
                                                    </div>
                                                </form>
                                              </div>
                                              <div class="modal-footer">
                                                
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-closed" role="tabpanel" aria-labelledby="pills-closed-tab">
                            <div class="table-area table-responsive mt-4">
                                <table class="support-table px-3">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Ticket Title</th>
                                            <th scope="col">User Name</th>
                                            <th scope="col">Description</th>
                                            <th scope="col">Create Date</th>
                                            <th scope="col">Priority</th>
                                            <th scope="col">Ticket Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($supports as $spp)
                                        @if($spp->ticket_status==3)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$spp->ticket_title}}</td>
                                            <td>{{$spp->first_name}}</td>
                                            <td>{!! $spp->discription !!}</td>
                                            <td>{{$spp->created_at}}</td>
                                            <td class="create-date">
                                                @if($spp->priority == 0)
                                                    <span class="badge bg-primary text-white">Low</span>
                                                @elseif($spp->priority == 1)
                                                <span class="badge bg-warning text-white">Medium</span> 
                                                @elseif($spp->priority == 2)<span class="badge bg-danger text-white">High</span>
                                                @endif
                                            </td>
                                            <td class="due-date">
                                                @if($spp->ticket_status == 0)
                                                    <span class="badge bg-primary text-white">New</span>
                                                @elseif($spp->ticket_status == 1)
                                                    <span class="badge bg-success text-white">Open</span>
                                                @elseif($spp->ticket_status == 2)
                                                    <span class="badge bg-warning text-white">In-progress</span>
                                                @elseif($spp->ticket_status == 3)
                                                    <span class="badge bg-danger text-white">Close</span>
                                                @endif
                                            </td>
                                        </tr>

                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>



                    <!-- <div class="row">
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-black text-uppercase mb-1">
                                                New Tickets <br><small>From Average Yesterday</small></div>
                                            <div class="h5 mb-0 font-weight-bold text-primary">105</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-ticket-alt fa-2x text-primary"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-black text-uppercase mb-1">
                                                Open Tickets <br><small>From Average Yesterday</small></div>
                                            <div class="h5 mb-0 font-weight-bold text-success">10</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-box-open fa-2x text-success"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-black text-uppercase mb-1">
                                                Pending Tickets <br><small>From Average Yesterday</small></div>
                                            <div class="h5 mb-0 font-weight-bold text-info">20</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-hourglass-half fa-2x text-info"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-black text-uppercase mb-1">
                                                Closed Tickets <br><small>From Average Yesterday</small></div>
                                            <div class="h5 mb-0 font-weight-bold text-warning">70</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-lock fa-2x text-warning"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <!-- Content Row -->

                    <!-- <div class="row table-area mt-4">
                        <table class="table table-bordered table-hover table-responsive text-dark">
                            <thead>
                                <tr>
                                  <th scope="col">#</th>
                                  <th scope="col">Ticket Title</th>
                                  <th scope="col">Create Date</th>
                                  <th scope="col">Priority</th>
                                  <th scope="col">Ticket Status</th>
                                  <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                	<td>1</td>
                                	<td>gfdgsfghfghsfggggggggfghfghghggf</td>
                                	<td>2023-11-28 12:46:10</td>
                                	<td>Medium</td>
                                	<td>Open</td>
                                	<td>edit Delete</td>
                                </tr>
                            </tbody>
                        </table>
                    </div> -->

                </div>
                <!-- /.container-fluid -->
<script type="text/javascript">
    $(document).on("click", ".blog_delete", function(e) {
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
        url: '{{route('support.ticket.status')}}',
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
            if(data.success){
            toastr.options =
              {
                "closeButton" : true,
                "progressBar" : true
              }
              toastr.success(data.success);
              window.location.reload();
          }
        }
      });
    });
</script>
	
@endsection