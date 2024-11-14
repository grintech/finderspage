@php
    use App\Models\UserAuth;
@endphp

@extends('layouts.user_dashboard.userdashboardlayout')
@section('content')

<style type="text/css">
	/*Profile Card 3*/
.profile-card-3 {
  font-family: 'Open Sans', Arial, sans-serif;
  position: relative;
  float: left;
  overflow: hidden;
  width: 100%;
  text-align: center;
  height:368px;
  border:none;
  z-index: 0;
}
.profile-card-3 .background-block {
    float: left;
    width: 100%;
    height: 200px;
    overflow: hidden;
}
.profile-card-3 .background-block .background {
  width:100%;
  vertical-align: top;
  opacity: 0.9;
  -webkit-filter: blur(0.5px);
  filter: blur(0.5px);
   -webkit-transform: scale(1.8);
  transform: scale(2.8);
}
.profile-card-3 .card-content {
  width: 100%;
  padding: 15px 25px;
  color:#232323;
  float:left;
  background:#efefef;
  height:50%;
  border-radius:0 0 5px 5px;
  position: relative;
  z-index: 9999;
}
.profile-card-3 .card-content::before {
    content: '';
    background: #efefef;
    width: 120%;
    height: 100%;
    left: 11px;
    bottom: 51px;
    position: absolute;
    z-index: -1;
    transform: rotate(-13deg);
}
.profile-card-3 .profile {
  border-radius: 50%;
  position: absolute;
  bottom: 50%;
  left: 50%;
  max-width: 100px;
  opacity: 1;
  box-shadow: 3px 3px 20px rgba(0, 0, 0, 0.5);
  border: 2px solid rgba(255, 255, 255, 1);
  -webkit-transform: translate(-50%, 0%);
  transform: translate(-50%, 0%);
  z-index:99999;
}
.profile-card-3 h2 {
  margin: 0 0 5px;
  font-weight: 600;
  font-size:20px;
  text-transform: capitalize;
}
.profile-card-3 h2 small {
  display: block;
  font-size: 15px;
  margin-top:10px;
}
.profile-card-3 i {
  display: inline-block;
    font-size: 16px;
    color: #232323;
    text-align: center;
    border: 1px solid #232323;
    width: 30px;
    height: 30px;
    line-height: 30px;
    border-radius: 50%;
    margin:0 5px;
    font-family: FontAwesome;
}
.profile-card-3 .icon-block{
    float:left;
    width:100%;
    margin-top:15px;
}
.profile-card-3 .icon-block a{
    text-decoration:none;
}
.profile-card-3 i:hover {
  background-color:#232323;
  color:#fff;
  text-decoration:none;
}
#search-result {
    z-index: 1;
}
.go-back {
    background: linear-gradient(90deg, rgba(220, 114, 40, 1) 50%, #a54db7 100%);
    border-radius: 35px;
    border: 0px;
    box-shadow: none;
    color: #fff !important;
    padding: 6px 10px !important;
    font-size: 13px;
    font-weight: 500;
}
</style>

<!--Profile Card 3-->
		<div class="container">
      {{-- <div class="form-row d-flex justify-content-end">
        <div class="form-group col-md-3 search_members">
            <input type="text" class="form-control" id="searchInput" placeholder="Search members...">
            <ul class="dropdown-menu" id="search-result"></ul>
        </div>
      </div> --}}

			<div class="row mt-3">
				@foreach($followerArray as $follower)
	            <div class="col-md-3 mb-3">
                <a href="{{route('latestPostuser', $follower['slug'])}}">
	                <div class="card profile-card-3">
	                    <div class="background-block">
	                        <img src="{{$follower['cover_img']!= ''? asset('assets/images/profile/'.$follower['cover_img']): 'https://images.pexels.com/photos/459225/pexels-photo-459225.jpeg?auto=compress&cs=tinysrgb&h=650&w=940 '}} " alt="profile-sample1" class="background"/>
	                    </div>
	                    <div class="profile-thumb-block">
	                        <img src="{{$follower['image']!= ''? asset('assets/images/profile/'.$follower['image']): asset('user_dashboard/img/undraw_profile.svg')}}" alt="profile-image" class="profile"/>
	                    </div>
	                    <div class="card-content">
		                    <h2>{{$follower['first_name']}}<small>{{$follower['username']}}</small></h3>
		                    <div class="icon-block">
		                    	<!-- <a href="#"><i class="fa fa-facebook"></i></a>
		                    	<a href="#"> <i class="fa fa-twitter"></i></a>
		                    	<a href="#"> <i class="fa fa-google-plus"></i></a> -->
		                    </div>
	                    </div>
	                </div>
                </a>
	            </div>

	      @endforeach
	        </div>

            <div class="row">
                <div class="col d-flex justify-content-center">
                    <a class="go-back" href="{{ route('UserProfileFrontend', UserAuth::getloginuser()->slug) }}">
                        Go Back
                    </a>
                </div>
              </div>
        
         </div>
    
      
      <script>
          $(document).ready(function() {
              $('#searchInput').on('input', function() {
                  var searchQuery = $(this).val();
                  
                  if (searchQuery.length < 2) {
                      $('#search-result').empty().hide();
                      return;
                  }
                  
                  $.ajax({
                      url: '{{ route('search_members') }}', 
                      type: 'POST',
                      data: {
                          _token: '{{ csrf_token() }}',
                          query: searchQuery,
                      },
                      success: function(response) {
                          $('#search-result').empty().hide();
                          
                          if (response.suggestions) {
                              var resultsHtml = '';
                              response.suggestions.forEach(function(member) {
                                  var imgSrc = `{{ asset('assets/images/profile/${member.image}') }}`;
                                  
                                  resultsHtml += `
                                      <a href="${member.route}" class="result-link">
                                          <div class="row px-2">
                                              <div class="col-md-4 mb-2">
                                                  <img src="${imgSrc}" class="img-fluid rounded" alt="${member.first_name}">
                                              </div>
                                              <div class="col-md-8 mb-2">
                                                  <h4 class="h6 mb-1">${member.first_name}</h4>
                                                  <p class="mb-0 small">${member.dob}</p>
                                              </div>
                                          </div>
                                      </a>
                                  `;
                              });
                              $('#search-result').html(resultsHtml).show();
                          }
                      },
                      error: function(xhr, status, error) {
                          console.error(error);
                          $('#search-result').hide();
                      }
                  });
              });
              
              $(document).on('click', function(event) {
                  if (!$(event.target).closest('.search_members').length) {
                      $('#search-results').hide();
                  }
              });
          });
      </script>
      
@endsection