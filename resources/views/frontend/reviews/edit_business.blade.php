@php
use App\Models\UserAuth;
@endphp

@if($filter_data->isNotEmpty())
    @foreach($filter_data as $review)
        <div class="row mb-3 align-items-start">
            <div class="col-lg-1">
                @if($review->user && $review->user->image)
                    <img src="{{ asset('assets/images/profile/' . $review->user->image) }}"
                         class="rounded-circle img-fluid shadow-1"
                         alt="member avatar"
                         width="50"
                         height="50" />
                @else
                    <img src="{{ asset('user_dashboard/img/undraw_profile.svg') }}"
                         class="rounded-circle img-fluid shadow-1"
                         alt="default avatar"
                         width="50"
                         height="50" />
                @endif
            </div>
            <div class="col-lg-11 d-flex justify-content-between align-items-start">
                <div class="flex-grow-1">
                    <p class="fw-bold lead mb-0">
                        <strong>{{ $review->user->first_name ?? 'Anonymous' }}</strong>
                    </p>

                    @if ($review->files)
                        @php
                            $files = json_decode($review->files, true);
                            $fileCount = is_array($files) ? count($files) : 1;
                        @endphp
                        <a href="#" class="text-muted" data-bs-toggle="modal" data-bs-target="#filesModal-{{ $review->id }}">
                            {{ $fileCount }} {{ $fileCount == 1 ? 'file' : 'files' }}
                        </a>
                    @endif

                    <div class="rating py-0">
                        <div class="star">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $review->rating)
                                    <i class="fas fa-star"></i>
                                @else
                                    <i class="far fa-star"></i>
                                @endif
                            @endfor
                            @php
                                $givenTime = strtotime($review->created_at);
                                $currentTimestamp = time();
                                $timeDifference = $currentTimestamp - $givenTime;

                                $weeks = floor($timeDifference / (60 * 60 * 24 * 7));
                                $days = floor($timeDifference / (60 * 60 * 24));
                                $timeAgo = $weeks > 0
                                    ? ($weeks == 1 ? "$weeks week ago" : "$weeks weeks ago")
                                    : ($days > 0 ? ($days == 1 ? "$days day ago" : "$days days ago") : "Posted today");
                            @endphp
                            <span class="text-muted ml-1">{{ $timeAgo }}</span>
                        </div>
                    </div>

                    <p class="mb-0">{{ $review->description }}</p>
                </div>

                <div class="dots-menu btn-group ms-2">
                    @if (UserAuth::getLoginId() == $review->user_id)
                        <a data-toggle="dropdown" class="btn btn-primary" onclick="showDropdown({{ $review->id }})">
                            <i class="fas fa-ellipsis-v"></i>
                        </a>
                        <ul class="dropdown-menu" id="dropdown-{{ $review->id }}">
                            <li>
                                <a class="btn button_for" data-bs-toggle="modal" id="editModal" href="#editModal-{{ $review->id }}" data-review-id="{{ $review->id }}" data-review-files="{{ $review->files }}">
                                    <i class="fa fa-pencil" style="font-size: 13px;"></i>
                                </a>
                            </li>
                            <li>
                                <a class="btn btn-danger button_for" onclick="deleteComment({{ $review->id }})">
                                    <i class="fa fa-trash-o"></i>
                                </a>
                            </li>
                        </ul>
                    @endif
                </div>
            </div>
        </div>


    <!-- Modal for displaying media -->
	@if ($review->files)
	@php
		$files = json_decode($review->files, true);
	@endphp
		<div class="modal fade" id="filesModal-{{ $review->id }}" tabindex="-1" aria-labelledby="filesModalLabel-{{ $review->id }}" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="filesModalLabel-{{ $review->id }}">Media Files</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<div id="carousel-{{ $review->id }}" class="carousel slide">
							<div class="carousel-inner">
								@foreach($files as $fileIndex => $file)
									@php
										$fileExtension = pathinfo($file, PATHINFO_EXTENSION);
										$activeClass = $fileIndex === 0 ? 'active' : '';
									@endphp
									<div class="carousel-item {{ $activeClass }}">
										@if(in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']))
											<img src="{{ asset('images_reviews/' . $file) }}" class="d-block w-100" alt="media image" />
										@elseif(in_array($fileExtension, ['mp4', 'avi', 'mov', 'wmv']))
											<video src="{{ asset('images_reviews/' . $file) }}" class="d-block w-100" controls></video>
										@else
											<p>Unsupported file type</p>
										@endif
									</div>
								@endforeach
							</div>
					
						@if(count($files) > 1)
							<a class="carousel-control-prev" href="#carousel-{{ $review->id }}" role="button" data-bs-slide="prev">
								<span class="carousel-control-prev-icon" aria-hidden="true"></span>
								<span class="visually-hidden">Previous</span>
							</a>
							<a class="carousel-control-next" href="#carousel-{{ $review->id }}" role="button" data-bs-slide="next">
								<span class="carousel-control-next-icon" aria-hidden="true"></span>
								<span class="visually-hidden">Next</span>
							</a>
						@endif
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				</div>										
			</div>
		</div>
	</div>

	@endif

	<!-- Edit Review Modal -->
	<div class="modal fade write-review" id="editModal-{{ $review->id }}" tabindex="-1" aria-labelledby="editModalLabel-{{ $review->id }}" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="editModalLabel-{{ $review->id }}">Finders Business Name</h5>
				</div>
				<div class="modal-body">
					<form id="updateReviewForm-{{ $review->id }}" enctype="multipart/form-data">
						@csrf
							<input type="hidden" name="product_id" value="{{ $business->id }}">
							<input type="hidden" name="email" value="{{ $review->user->email }}">
							<input type="hidden" name="name" value="{{ $review->user->first_name }}">
							<input type="hidden" name="blog_user_id" value="{{ $business->user_id }}">
							<input type="hidden" name="slug" value="{{ $business->slug }}">
							<input type="hidden" name="url" value="{{ route('business_page.front.single.listing', $business->slug) }}">
							<input type="hidden" name="type" value="business">
						<div class="row mb-3">
							<div class="col-lg-2">
								@if (UserAuth::getLoginId())
									<img src="{{ asset($review->user->image ? 'assets/images/profile/' . $review->user->image : 'user_dashboard/img/undraw_profile.svg') }}" class="rounded-circle img-fluid shadow-1" alt="user avatar" width="50" height="50" />
								@else
									<img src="{{ asset('user_dashboard/img/undraw_profile.svg') }}" class="rounded-circle img-fluid shadow-1" alt="default avatar" width="50" height="50" />
								@endif
							</div>
							<div class="col-lg-10">
								@if (UserAuth::getLoginId())
									<h6>{{ $review->user->first_name }}</h6>
								@else
									<h6>Anonymous</h6>
								@endif
								<p class="mb-0">Posting publicly across Google</p>
							</div>
						</div>
						<div class="mb-3">
							<div class="rating">
								<input type="hidden" name="rating" id="ratingValue-{{ $review->id }}" value="{{ $review->rating }}">
								@for ($i = 1; $i <= 5; $i++)
									<i class='bx {{ $i <= $review->rating ? 'bxs-star' : 'bx-star' }} star' data-value="{{ $i }}" style="--i: {{ $i - 1 }};"></i>
								@endfor
							</div>
						</div>
						<div class="mb-3">
							<textarea class="form-control" name="description" id="message-text-{{ $review->id }}" rows="4" placeholder="Share details of your own experience at this place">{{ $review->description }}</textarea>
						</div>
						
						<!-- File Upload -->
						<div class="file-edit-upload">
							<label for="upload-edit-{{ $review->id }}" class="file-edit-upload__label">
								<i class="fas fa-camera"></i> Add photos or videos
							</label>

    						<input id="upload-edit-{{ $review->id }}" 
    						       class="file-edit-upload__input" 
    						       type="file" 
    						       name="files[]" 
    						       multiple 
    						       data-review-id="{{ $review->id }}">
						</div>
												
						<!-- File Preview -->
                        <div class="row">
                          @if ($review->files)
                            @foreach(json_decode($review->files) as $i => $file)
                                @php
                                    $fileExtension = pathinfo($file, PATHINFO_EXTENSION);
                                    $isImage = in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif']);
                                    $isVideo = in_array(strtolower($fileExtension), ['mp4', 'webm', 'ogg']);
                                @endphp
                        
                                <div id="file-preview-{{ $i }}" class="col-md-3 mb-3 file-preview-container">
                                    <div class="position-relative">
                                        @if($isImage)
                                            <img src="{{ asset('images_reviews/' . $file) }}" alt="file" class="img-thumbnail">
                                        @elseif($isVideo)
                                            <video controls class="img-thumbnail">
                                                <source src="{{ asset('images_reviews/' . $file) }}" type="video/{{ $fileExtension }}">
                                                Your browser does not support the video tag.
                                            </video>
                                        @endif
                                        <i class="fas fa-times position-absolute top-0 start-100 translate-middle"
                                           style="cursor: pointer;"
                                           onclick="removeFile('{{ $i }}', '{{ $review->id }}', '{{ $file }}')"
                                           data-review-id="{{ $review->id }}"
                                           data-file="{{ $file }}"
                                           data-index="{{ $i }}">
                                        </i>
                                    </div>
                                </div>
                            @endforeach
                          @endif
                        </div>												
                    </div>
						<div class="modal-footer write-submit">
							<button type="button" class="btn" data-bs-dismiss="modal">Close</button>
							<button type="button" class="btn" onclick="submitEditReview(event, {{ $review->id }})">Post</button>
						</div>
					</form>
				</div>
			</div>
		</div>
    @endforeach
@endif
