<?php use App\Models\UserAuth; ?>
@extends('layouts.user_dashboard.userdashboardlayout')
@section('content')
<div class="container px-sm-5 px-4 pb-4">
 				<form method="post" action="{{route('support.update',$support->id)}}" enctype="multipart/form-data" >
 					{{ @csrf_field() }}
                    <!-- Page Heading -->
                    <div class="d-sm-flex flex-column  mb-3">
                        <h1 class="h3 mb-0 text-gray-800 fw-bold">Create a  Ticket</h1>
                    </div>
                    <span>
                    	@include('admin.partials.flash_messages')
                    </span>
                    <div class="row bg-white border-radius pb-4 p-3">
                        <div class="col-md-12 mb-4">
                            <label class="labels">Ticket title <sup>*</sup></label>
                            <input type="text" class="form-control" name="ticket_title" placeholder="Enter post name" value="{{$support->ticket_title}}">
                            <span class="error-message" id="title-error"></span>
                             @error('title')
                                <small class="text-danger">{{ $message }}</small>
                             @enderror
                        </div>

                        <!-- <div class="col-md-6 mb-4">
                            <label class="labels">Ticket priority <sup>*</sup></label>
                            <select name="priority" class="form-control form-control-xs selectpicker"  data-size="7" data-live-search="true" data-title="Sub Category" id="sub_category" data-width="100%" required>
                                <option {{ $support->priority == 0 ? 'selected' : '' }} value="0">low</option>
                                <option {{ $support->priority == 1 ? 'selected' : '' }} value="1">medium</option>
                                <option {{ $support->priority == 2 ? 'selected' : '' }} value="2">Heigh</option>
                            </select>
                             @error('priority')
                                <small class="text-danger">{{ $message }}</small>
                             @enderror
                        </div> -->
                     	
                            
                        <div class="col-md-12 mb-4">
                            <label class="labels">Description</label>
                            <div id="summernote">
                                <textarea id="editor1" class="form-control" name="discription" placeholder="Write a text">{{$support->discription}}</textarea>

                               
                                @error('description')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                       
                    	
                        <input type="hidden" name="user_id" value="{{UserAuth::getLoginId()}}">
                    <div class="mt-2 text-center"><button class="btn profile-button addCategory" type="submit">Publish</button>
                       
                        
                    
                </div>
                   
                </div>
            </form>

@endsection