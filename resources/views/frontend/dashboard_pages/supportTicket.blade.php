@extends('layouts.user_dashboard.userdashboardlayout')
@section('content')
	 <!-- Begin Page Content -->
                <div class="container-fluid px-3 px-md-5">

                    <!-- Page Heading -->
                    <div class="d-flex justify-content-between mb-3">
                        <div class="support_1">
                            <h1 class="h3 mb-0 text-gray-800 fw-bold">Support</h1>
                        <p>View all tickets data here</p>
                        </div>
                        
                        <div class="support_2">
                            <a href="{{route('support.add')}}" class="btn btn-warning" style="float: right;">New</a>
                        </div>

                        
                    </div>

                    @include('admin.partials.flash_messages')

                    <!-- Content Row -->
                    <div class="tab-area">
                        <ul class="nav nav-pills" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-new-tab" data-toggle="pill" href="#pills-new" role="tab" aria-controls="pills-new" aria-selected="true">
                                    <div class="card border-left-primary shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center bx1">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-black text-uppercase mb-1">
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
                                    <div class="card border-left-success shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center bx1">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-black text-uppercase mb-1">
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
                                    <div class="card border-left-info shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center bx1">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-black text-uppercase mb-1">
                                                        Pending Tickets <br><small>From Average Yesterday</small></div>
                                                    <div class="h5 mb-0 font-weight-bold text-info">{{$inProgress}}</div>
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
                                    <div class="card border-left-warning shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center bx1">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-black text-uppercase mb-1">
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

                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-new" role="tabpanel" aria-labelledby="pills-new-tab">
                            <div class="table-area table-responsive mt-4">
                                <table class="support-table">
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
                                        @foreach($Support as $supp)
                                        @if($supp->ticket_status == 0)
                                        <tr>
                                          <td class="assigned-to">{{$loop->iteration}}</td>
                                          <td class="ticket-title">{{$supp->ticket_title}}</td>
                                          <td class="client-name">{{$supp->created_at}}</td>
                                          <td class="create-date">
                                            @if($supp->priority == 0)
                                                <span class="badge bg-primary text-white">Low</span>
                                            @elseif($supp->priority == 1)
                                            <span class="badge bg-warning text-white">Medium</span> 
                                            @elseif($supp->priority == 2)<span class="badge bg-danger text-white">High</span>
                                            @endif
                                          </td>
                                          <td class="due-date">
                                            @if($supp->ticket_status == 0)
                                                <span class="badge bg-primary text-white">New</span>
                                            @elseif($supp->ticket_status == 1)
                                                <span class="badge bg-success text-white">Open</span>
                                            @elseif($supp->ticket_status == 2)
                                                <span class="badge bg-warning text-white">In-progress</span>
                                            @elseif($supp->ticket_status == 3)
                                                <span class="badge bg-danger text-white">Close</span>
                                            @endif
                                          </td>

                                          <td class="action">
                                              <ul class="d-flex justify-content-center list-unstyled mb-0">
                                                    <li>
                                                        <a href="{{route('support.edit',$supp->id)}}"  class="btn btn-secondary btn-sm"><i class="fas fa-edit"></i></a>
                                                    </li>
                                                    <li>
                                                        <a href="#" data-link="{{route('support.delete',$supp->id)}}" class="btn btn-danger btn-sm blog_delete"><i class="fas fa-trash"></i></a>
                                                    </li>
                                                </ul>
                                          </td>
                                        </tr>
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-open" role="tabpanel" aria-labelledby="pills-open-tab">
                            <div class="table-area table-responsive mt-4">
                                <table class="support-table">
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
                                        @foreach($Support as $supp)
                                        @if($supp->ticket_status == 1)
                                        <tr>
                                          <td class="assigned-to">{{$loop->iteration}}</td>
                                          <td class="ticket-title">{{$supp->ticket_title}}</td>
                                          <td class="client-name">{{$supp->created_at}}</td>
                                          <td class="create-date">
                                            @if($supp->priority == 0)
                                                <span class="badge bg-primary text-white">Low</span>
                                            @elseif($supp->priority == 1)
                                            <span class="badge bg-warning text-white">Medium</span> 
                                            @elseif($supp->priority == 2)<span class="badge bg-danger text-white">High</span>
                                            @endif
                                          </td>
                                          <td class="due-date">
                                            @if($supp->ticket_status == 0)
                                                <span class="badge bg-primary text-white">New</span>
                                            @elseif($supp->ticket_status == 1)
                                                <span class="badge bg-success text-white">Open</span>
                                            @elseif($supp->ticket_status == 2)
                                                <span class="badge bg-warning text-white">In-progress</span>
                                            @elseif($supp->ticket_status == 3)
                                                <span class="badge bg-danger text-white">Close</span>
                                            @endif
                                          </td>

                                          <td class="action">
                                              <ul class="d-flex justify-content-center list-unstyled mb-0">
                                                    <li>
                                                        <a href="{{route('support.edit',$supp->id)}}"  class="btn btn-secondary btn-sm"><i class="fas fa-edit"></i></a>
                                                    </li>
                                                    <li>
                                                        <a href="#" data-link="{{route('support.delete',$supp->id)}}" class="btn btn-danger btn-sm blog_delete"><i class="fas fa-trash"></i></a>
                                                    </li>
                                                </ul>
                                          </td>
                                        </tr>
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-pending" role="tabpanel" aria-labelledby="pills-pending-tab">
                            <div class="table-area table-responsive mt-4">
                                <table class="support-table">
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
                                        @foreach($Support as $supp)
                                        @if($supp->ticket_status == 2)
                                        <tr>
                                          <td class="assigned-to">{{$loop->iteration}}</td>
                                          <td class="ticket-title">{{$supp->ticket_title}}</td>
                                          <td class="client-name">{{$supp->created_at}}</td>
                                          <td class="create-date">
                                            @if($supp->priority == 0)
                                                <span class="badge bg-primary text-white">Low</span>
                                            @elseif($supp->priority == 1)
                                            <span class="badge bg-warning text-white">Medium</span> 
                                            @elseif($supp->priority == 2)<span class="badge bg-danger text-white">High</span>
                                            @endif
                                          </td>
                                          <td class="due-date">
                                            @if($supp->ticket_status == 0)
                                                <span class="badge bg-primary text-white">New</span>
                                            @elseif($supp->ticket_status == 1)
                                                <span class="badge bg-success text-white">Open</span>
                                            @elseif($supp->ticket_status == 2)
                                                <span class="badge bg-warning text-white">In-progress</span>
                                            @elseif($supp->ticket_status == 3)
                                                <span class="badge bg-danger text-white">Close</span>
                                            @endif
                                          </td>

                                          <td class="action">
                                              <ul class="d-flex justify-content-center list-unstyled mb-0">
                                                    <li>
                                                        <a href="{{route('support.edit',$supp->id)}}"  class="btn btn-secondary btn-sm"><i class="fas fa-edit"></i></a>
                                                    </li>
                                                    <li>
                                                        <a href="#" data-link="{{route('support.delete',$supp->id)}}" class="btn btn-danger btn-sm blog_delete"><i class="fas fa-trash"></i></a>
                                                    </li>
                                                </ul>
                                          </td>
                                        </tr>
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-closed" role="tabpanel" aria-labelledby="pills-closed-tab">
                            <div class="table-area table-responsive mt-4">
                                <table class="support-table">
                                    <thead>
                                        <tr>
                                          <th scope="col">#</th>
                                          <th scope="col">Ticket Title</th>
                                          <th scope="col">Create Date</th>
                                          <th scope="col">Priority</th>
                                          <th scope="col">Ticket Status</th>
                                          <!-- <th scope="col">Action</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($Support as $supp)
                                        @if($supp->ticket_status == 3)
                                        <tr>
                                          <td class="assigned-to">{{$loop->iteration}}</td>
                                          <td class="ticket-title">{{$supp->ticket_title}}</td>
                                          <td class="client-name">{{$supp->created_at}}</td>
                                          <td class="create-date">
                                            @if($supp->priority == 0)
                                                <span class="badge bg-primary text-white">Low</span>
                                            @elseif($supp->priority == 1)
                                            <span class="badge bg-warning text-white">Medium</span> 
                                            @elseif($supp->priority == 2)<span class="badge bg-danger text-white">High</span>
                                            @endif
                                          </td>
                                          <td class="due-date">
                                            @if($supp->ticket_status == 0)
                                                <span class="badge bg-primary text-white">New</span>
                                            @elseif($supp->ticket_status == 1)
                                                <span class="badge bg-success text-white">Open</span>
                                            @elseif($supp->ticket_status == 2)
                                                <span class="badge bg-warning text-white">In-progress</span>
                                            @elseif($supp->ticket_status == 3)
                                                <span class="badge bg-danger text-white">Close</span>
                                            @endif
                                          </td>

                                          <!-- <td class="action">
                                              <ul class="d-flex justify-content-center list-unstyled mb-0">
                                                    <li>
                                                        <a href="{{route('support.edit',$supp->id)}}"  class="btn btn-secondary btn-sm"><i class="fas fa-edit"></i></a>
                                                    </li>
                                                    <li>
                                                        <a href="#" data-link="{{route('support.delete',$supp->id)}}" class="btn btn-danger btn-sm blog_delete"><i class="fas fa-trash"></i></a>
                                                    </li>
                                                </ul>
                                          </td> -->
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

                   <!--  <div class="table-area table-responsive mt-4">
                        <table class="support-table">
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
                                @foreach($Support as $supp)
                                <tr>
                                  <td class="assigned-to">{{$loop->iteration}}</td>
                                  <td class="ticket-title">{{$supp->ticket_title}}</td>
                                  <td class="client-name">{{$supp->created_at}}</td>
                                  <td class="create-date">
                                    @if($supp->priority == 0)
                                        <span class="badge bg-primary text-white">Low</span>
                                    @elseif($supp->priority == 1)
                                    <span class="badge bg-warning text-white">Medium</span> 
                                    @elseif($supp->priority == 2)<span class="badge bg-danger text-white">High</span>
                                    @endif
                                  </td>
                                  <td class="due-date">
                                    @if($supp->ticket_status == 0)
                                        <span class="badge bg-primary text-white">New</span>
                                    @elseif($supp->ticket_status == 1)
                                        <span class="badge bg-success text-white">Open</span>
                                    @elseif($supp->ticket_status == 2)
                                        <span class="badge bg-warning text-white">In-progress</span>
                                    @elseif($supp->ticket_status == 3)
                                        <span class="badge bg-danger text-white">Close</span>
                                    @endif
                                  </td>

                                  <td class="action">
                                      <ul class="d-flex justify-content-center list-unstyled mb-0">
                                            <li>
                                                <a href="{{route('support.edit',$supp->id)}}"  class="btn btn-secondary btn-sm"><i class="fas fa-edit"></i></a>
                                            </li>
                                            <li>
                                                <a href="#" data-link="{{route('support.delete',$supp->id)}}" class="btn btn-danger btn-sm blog_delete"><i class="fas fa-trash"></i></a>
                                            </li>
                                        </ul>
                                  </td>
                                </tr>
                                @endforeach
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
</script>
@endsection