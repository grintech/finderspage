@extends('layouts.adminlayout')

@section('content')

<div class="header bg-primary pb-3">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-12 col-12">
          <h6 class="h2 text-white d-inline-block mb-0">Subscription Plans List</h6>
        </div>
        <span>
          @include('admin.partials.flash_messages')
        </span>
      </div>
    </div>
  </div>
</div>

<div class="container-fluid px-3 px-md-5">

<!-- <div class="row">
	 <div class=" mb-3 ">
        <h1 class="h3 mb-0 text-gray-800 fw-bold">subscription plans list</h1>
    </div>
    <span>
    	@include('admin.partials.flash_messages')
    </span>
	
</div> -->
  <div class="row">
    <div class="col">
      <div class="card listing-block">
        <div class="table-responsive">
          <table class="table" id="tableListing_payments">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">plan</th>
                <th scope="col">price</th>
                <th scope="col">feature</th>
                <th scope="col">slideshow</th>
                <th scope="col">status</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
            	@foreach($plan as $p)
              <tr>
                <td scope="row">{{$loop->iteration}}</td>
                <td>{{$p->plan}}</td>
                <td>{{$p->price}}</td>
                <td>{{$p->feature_listing}}</td>
                <td>{{$p->slideshow}}</td>
                <td>{{$p->status}}</td>
                <td>
                	<a href="{{route('sub-plan.edit',$p->id)}}" class="btn btn-warning"><i class="far fa-edit" aria-hidden="true"></i></a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection