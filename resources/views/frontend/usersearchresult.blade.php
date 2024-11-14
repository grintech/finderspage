									@foreach($user as $Records) 
                                        <div class="col-lg-3 col-md-4 col-sm-6 col-6 mb-4">
                                            <div class="profile-card">
                                                  <a href="{{route('UserProfileFrontend',$Records->id)}}">
                                                    <div class="img-area">
                                                @if($Records->image)
                                                    <img src="{{asset('assets/images/profile')}}/{{$Records->image}}" alt="{{$Records->first_name}}" class="d-block rounded-circle">
                                                @else
                                                    <img src="./new_assets/assets/images/home.png" alt="New York" class="d-block rounded-circle">
                                                @endif
                                                
                                                    </div>
                                                <div class="job-post-content">
                                                    <h4>{{$Records->first_name}}</h4>
                                                    <!-- <div class="main-days-frame">
                                                        <span class="location-box">
                                                           
                                                        </span>
                                                    </div> -->
                                                </div>
                                               
                                            </a>
                                            </div>
                                        </div>
                                @endforeach
