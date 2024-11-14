@php
use App\Models\UserAuth;
use App\Models\BlogComments;
@endphp

@if(isset($result))
    <li class="comment-item">
        <div class="comment-header">
            <div class="img-icon">
                <img class="img-fluid rounded-circle" alt="User Image" height="40" width="40" src="{{ asset('assets/images/profile/' . ($userImage ?? 'default.png')) }}">
            </div>
            <div class="comments-area">
                <div class="d-flex align-items-center">
                  @if ( $result->pin == '1')
                    <div class="w-100">
                        <a href="{{ route('UserProfileFrontend', $userSlug) }}">
                            {{ $userName }}
                            <i class="fa fa-thumb-tack" aria-hidden="true"></i>
                        </a>
                        <p>{{ $result->comment }}</p>
                    </div>
                  @else
                    <div class="w-100">
                      <a href="{{ route('UserProfileFrontend', $userSlug) }}">{{ $userName }}</a>
                      <p>{{ $result->comment }}</p>
                    </div>
                  @endif
                    <!-- Like Preview Section -->
                    <div class="text-center like-preview">
                        @php
                            $userId = UserAuth::getLoginId();
                            $liked_by = !empty($result->liked_by) ? json_decode($result->liked_by, true) : [];
                            $likeCount = count($liked_by);
                        @endphp
                    
                        <i class="{{ in_array($userId, $liked_by) ? 'fa fa-heart' : 'fa fa-heart-o' }} like-icon" 
                           aria-hidden="true" 
                           data-comment-id="{{ $result->id }}" 
                           data-user-id="{{ $userId }}"></i>
                    
                        <div class="like-count" onclick="showLikesModal({{ $result->id }})">{{ $likeCount }}</div>
                    
                        <!-- Likes Modal -->
                        <div id="likesModal" class="likes-modal" style="display: none;">
                            <div class="modal-content">
                                <span class="close" onclick="closeLikesModal()">&times;</span>
                                <h2>Likes</h2>
                                <div class="likes-list">
    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="comment-actions">
                    <button type="button" class="btn btn-reply" data-bs-toggle="modal" data-bs-target="#replyModal{{ $result->id }}">Reply</button>
                    @if (UserAuth::getLoginId() == $blog_user_id)
                    <button type="button" class="btn btn-hide hide_comment" data-id="{{ $result->id }}">Hide</button>
                    @endif
                </div>
            </div>

            <div class="dots-menu btn-group">
                <a data-toggle="dropdown" class="btn btn-primary" onclick="showDropdown({{ $result->id }})"><i class='fas fa-ellipsis-v'></i></a>
                <ul class="dropdown-menu" id="dropdown-{{ $result->id }}">
                    <li><a class="btn button_for" data-bs-toggle="modal" href="#editModal{{ $result->id }}"><i class="fa fa-pencil" style="font-size: 13px;"></i></a></li>
                    <li><a class="btn btn-danger button_for" onclick="deleteComment({{ $result->id }})"><i class="fa fa-trash-o"></i></a></li>
                </ul>
            </div>
        </div>

        
        <!-- Edit Modal -->
        <div class="modal fade" id="editModal{{ $result->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $result->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel{{ $result->id }}">Edit Comment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="reply-box">
                            <input type="text" value="{{ $result->comment }}" class="form-control edit-comment" id="commentInput">
                            <button comment_id="{{ $result->id }}" blog-id="{{ $blog_id }}" blog-user="{{ $blog_user_id }}" data-url="{{ $url }}" class="btn btn-primary update-comment" data-bs-dismiss="modal">Update</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Reply Modal -->
        <div class="modal fade" id="replyModal{{ $result->id }}" tabindex="-1" aria-labelledby="replyModalLabel{{ $result->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="replyModalLabel{{ $result->id }}">Reply</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>{{ $result->comment }}</p>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="reply-box">
                                    <input type="text" class="form-control reply_text" placeholder="Write a reply..." id="reply-input-{{ $result->id }}">
                                    <button type="button" class="btn btn-primary sendreply" 
                                        blog-id="{{ $blog_id }}" 
                                        blog-user="{{ $blog_user_id }}" 
                                        userid="{{ UserAuth::getLoginId() }}" 
                                        comment-id="{{ $result->id }}" 
                                        data-url="{{ $url }}"
                                        data-bs-dismiss="modal">Reply</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </li>
@endif
