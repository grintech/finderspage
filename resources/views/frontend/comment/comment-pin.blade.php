@php
    use App\Models\UserAuth;
@endphp

<li class="comment-item{{ $comm->id }}">
    <div class="comment-header">
        <div class="img-icon">
            <a href="{{ route('UserProfileFrontend', $user->slug) }}">
                <img class="img-fluid rounded-circle" alt="image" height="40" width="40" src="{{ asset('assets/images/profile/' . $user->image) }}">
            </a>
        </div>
        
        <div class="comments-area">
            <div class="d-flex align-items-center">
                <div class="w-100">
                    <a href="{{ route('UserProfileFrontend', $user->slug) }}">
                        {{ $user->first_name }}
                        <i class="fa fa-thumb-tack" aria-hidden="true"></i>
                    </a>
                    <p>{{ $comm->comment }}</p>
                </div>
                <div class="text-center like-preview">
                    @php
                        $userId = UserAuth::getLoginId();
                        $liked_by = !empty($comm->liked_by) ? json_decode($comm->liked_by, true) : [];
                        $likeCount = count($liked_by);
                    @endphp
                    <i class="{{ in_array($userId, $liked_by) ? 'fa fa-heart' : 'fa fa-heart-o' }} like-icon" 
                       aria-hidden="true" 
                       data-comment-id="{{ $comm->id }}" 
                       data-user-id="{{ $userId }}"></i>
                    <div class="like-count" onclick="showLikesModal({{ $comm->id }})">{{ $likeCount }}</div>
                    
                    <!-- Likes Modal -->
                    <div id="likesModal" class="likes-modal" style="display: none;">
                        <div class="modal-content">
                            <span class="close" onclick="closeLikesModal()">&times;</span>
                            <h2>Likes</h2>
                            <div class="likes-list">
                                <!-- Likes list content -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="comment-actions">
                @if ($comm->status == 1)
                    <button type="button" class="btn btn-reply" data-bs-toggle="modal" data-bs-target="#replyModal{{ $comm->id }}">Reply</button>
                @else
                    <button type="button" class="btn btn-reply"><del>Reply</del></button>
                @endif
                @if (UserAuth::getLoginId() == $blog_user_id)
                    @if ($comm->status == 1)
                        <button type="button" class="btn btn-hide hide_comment" data-id="{{ $comm->id }}" blog-id="{{ $blog_id }}" blog-user="{{ $blog_user_id }}">Hide</button>
                    @else
                        <button type="button" class="btn btn-hide unhide_comment" data-id="{{ $comm->id }}" blog-id="{{ $blog_id }}" blog-user="{{ $blog_user_id }}">Unhide</button>
                    @endif
                @endif
            </div>
        </div>
        
        @if ($comm->status == 1)
            <div class="dots-menu btn-group">
                @if(UserAuth::getLoginId() == $comm->user_id || UserAuth::getLoginId() == $blog_user_id)
                    <a data-toggle="dropdown" class="btn btn-primary" onclick="showDropdown({{ $comm->id }})">
                        <i class="fas fa-ellipsis-v"></i>
                    </a>
                    <ul class="dropdown-menu" id="dropdown-{{ $comm->id }}">
                    @if (UserAuth::getLoginId() == $blog_user_id)
                        @if ($comm->pin == '0')
                            <li>
                                <a data-blog-id="{{ $blog_id }}"
                                    data-comment-id="{{ $comm->id }}"
                                    data-blog-user="{{ $blog_user_id }}"
                                    data-url="{{ $url }}"
                                    onclick="pin_comment({{ $comm->id }})">
                                    <i class="fa fa-thumb-tack" aria-hidden="true"></i>
                                </a>
                            </li>
                        @else
                            <li>
                                <a data-blog-id="{{ $blog_id }}"
                                    data-comment-id="{{ $comm->id }}"
                                    data-blog-user="{{ $blog_user_id }}"
                                    data-url="{{ $url }}"
                                    onclick="unpin_comment({{ $comm->id }})">
                                    <i class="fa fa-thumbtack-slash" aria-hidden="true"></i>
                                </a>
                            </li>
                        @endif
                    @endif
                        @if(UserAuth::getLoginId() == $comm->user_id)
                            <li>
                                <a class="btn button_for" data-bs-toggle="modal" href="#editModal{{ $comm->id }}">
                                    <i class="fa fa-pencil" style="font-size: 13px;"></i>
                                </a>
                            </li>
                        @endif
                        <li>
                            <a class="btn btn-danger button_for" onclick="deleteComment({{ $comm->id }})">
                                <i class="fa fa-trash-o"></i>
                            </a>
                        </li>
                    </ul>
                @endif
            </div>
        @endif
    </div>
</li>
