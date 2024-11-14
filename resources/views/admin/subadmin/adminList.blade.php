@extends('layouts.adminlayout')

@section('content')
<style type="text/css">
	a.buttons-collection {
        margin-left: 1em;
    }
</style>
<div class="container-fluid px-5">
  <span>
      @include('admin.partials.flash_messages')
  </span>
    <a class="btn profile-button float-right mb-2" href="{{route('community')}}">Add</a>
	<table class="table table-striped" id="tableListing">
  <thead>
    <tr>
     <th>#</th>
    <th>Title</th>
    <th>status</th>
    <th>Featured</th>
    <th>Bump Post</th>
    <th>created At</th>
    <th>Action</th>
    </tr>
  </thead>
  <tbody>
<tr>
	<td></td>
	<td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
	<td>
		<a href="" class="btn btn-warning" >Edit</a>  
		<a href="" class="btn btn-danger" >Delete</a>
	</td>
</tr>   
  </tbody>
</table>
	
</div>
@endsection