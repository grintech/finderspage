@extends('layouts.user_dashboard.userdashboardlayout')
@section('content')
<style type="text/css">
	span.icon.is-left {
    position: absolute;
    left: 10px;
    top: 8px;
}
.field input {
    width: 100%;
    height: 40px;
    border-radius: 4px;
    border: 1px solid #8f9797;
    margin-bottom: 10px;
    padding-left: 35px;
}
.field {
    position: relative;   
}

i.fa.fa-phone {
	 position: absolute;
    left: 10px;
    top: 8px;
    transform: rotate(92deg);
}
</style>
<div class="container px-sm-5 px-4">
	<div class="row bg-white border-radius pb-4 p-3">
	
		  <span>
		      @include('admin.partials.flash_messages')
		  </span>

       <form class="row" action="{{route('apply.update',$apply->id)}}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="job_id" value="{{$apply->job_id}}">
           <div class="col-lg-6">
                 <div class="field">
                     <div class="control has-icons-left">
                         <input type="text" name="first_name" id="Name" class="form-control" placeholder="First Name" value="{{$apply->first_name}}">
                         <span class="icon is-left">
                         <i class="fa fa-user"></i>
                         </span>
                    </div>
                </div>
            </div> 
            <div class="col-lg-6">
                 <div class="field">
                     <div class="control has-icons-left">
                         <input type="text" name="last_name" id="Name" class="form-control" placeholder="Last Name" value="{{$apply->last_name}}">
                         <span class="icon is-left">
                         <i class="fa fa-user"></i>
                          </span>
                    </div>
                </div>
            </div> 
            <div class="col-lg-6">
                 <div class="field">
                     <div class="control has-icons-left">
                         <input type="email" name="email" id="email" class="form-control" placeholder="Email" value="{{$apply->email}}">
                         <span class="icon is-left">
                         <i class="fa fa-envelope"></i>
                          </span>
                    </div>
                </div>
            </div> 
            <div class="col-lg-6">
                 <div class="field">
                     <div class="control has-icons-left">
                         <input type="tel" name="phone_no" id="email" class="form-control" placeholder="Phone Number" value="{{$apply->phone_no}}">
                         <span class="icon is-left-phone">
                         <i class="fa fa-phone"></i>
                          </span>
                     </div>
                </div>
            </div> 
            <div class="col-lg-12">
                 <div class="field job-input">
                     <div class="control has-icons-left">
                         <input type="file" value="{{$apply->file}}" name="file" id="multiple" class="form-control" accept=".pdf,.doc,.docx">
                         <span class="icon is-left">
                         <i class="bi bi-cloud-upload"></i>
                         </span>

                         @if(!empty($apply->file))
                         	<a  target="blank" href="{{asset('File_jobApply')}}/{{$apply->file}}"><img src="{{asset('new_assets/assets/images/download.png')}}" doc-path="{{asset('File_jobApply')}}/{{$apply->file}}" height="50" width="50" alt="Image">  </a>
                         @endif
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="contact-from-button">Submit</button>
            </div> 
          </form>
        </div>
        </div>
@endsection