@php
use App\Models\UserAuth;
use App\Models\BlogComments;
@endphp

@foreach($fundraiserComments as $comm)
    @php
        $user = $users->firstWhere('id', $comm->user_id);
        $isUserAuthorized = UserAuth::getLoginId();
    @endphp

    @if($user && $comm->blog_id == $blog_id && $isUserAuthorized)
        <li class="comment-item{{ $comm->id }}">
            <div class="comment-header">
                <div class="img-icon">
                    <img class="img-fluid rounded-circle" alt="User Image" height="40" width="40" src="{{ asset('assets/images/profile/' . ($user->image ?? 'default.png')) }}">
                </div>
                <div class="comments-area">
                    <a href="{{ route('UserProfileFrontend', $user->slug) }}">{{ $user->first_name }}</a>
                    <p>{{ $comm->comment }}</p>
                    
                    <div class="comment-actions">
                        @if ($comm->status == 1)
                            <button type="button" class="btn btn-reply" data-bs-toggle="modal" data-bs-target="#replyModal{{ $comm->id }}">Reply</button>
                        @else
                            <button type="button" class="btn btn-reply"><del>Reply</del></button>
                        @endif
                        @if ($blog_user_id == $isUserAuthorized)
                         @if ($comm->status == 1)
                            <button type="button" class="btn btn-hide hide_comment" data-id="{{ $comm->id }}">Hide</button>
                         @else
                            <button type="button" class="btn btn-hide unhide_comment" data-id="{{ $comm->id }}" blog-id="{{ $blog_id }}" blog-user="{{$blog_user_id}}">Unhide</button>
                         @endif
                        @endif
                    </div>
                </div>
                
                @if($comm->user_id == $isUserAuthorized || $blog_user_id == $isUserAuthorized)
                  @if ($comm->status == 1)
                    <div class="dots-menu btn-group">
                        <a data-toggle="dropdown" class="btn btn-primary" onclick="showDropdown({{ $comm->id }})"><i class='fas fa-ellipsis-v'></i></a>
                        <ul class="dropdown-menu" id="dropdown-{{ $comm->id }}">
                            @if($comm->user_id == $isUserAuthorized)
                            <li><a class="btn button_for" data-bs-toggle="modal" href="#editModal{{ $comm->id }}"><i class="fa fa-pencil" style="font-size: 13px;"></i></a></li>
                            @endif
                            <li><a class="btn btn-danger button_for" onclick="deleteComment({{ $comm->id }})"><i class="fa fa-trash-o"></i></a></li>
                        </ul>
                    </div>
                  @endif
                @endif
            </div>

            <!-- Edit Modal -->
            <div class="modal fade" id="editModal{{ $comm->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $comm->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content my-cont">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel{{ $comm->id }}">Edit Comment</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="reply-box">
                                <input type="text" value="{{ $comm->comment }}" class="form-control edit-comment" id="commentInput">
                                <button comment_id="{{ $comm->id }}" blog-id="{{ $blog_id }}" blog-user="{{ $blog_user_id }}" data-url="{{ $url }}" class="btn btn-primary update-comment" data-bs-dismiss="modal">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
            <!-- Modal for replying to a comment -->
            <div class="modal fade" id="replyModal{{ $comm->id }}" tabindex="-1" aria-labelledby="replyModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="replyModalLabel">Reply</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>{{ $comm->comment }}</p>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="reply-box" id="reply-box-{{ $comm->id }}">
                                        <input type="text" class="form-control reply_text" placeholder="Write a reply..." id="reply-input-{{ $comm->id }}">
                                        <button type="button" class="btn btn-primary sendreply" 
                                            blog-id="{{ $blog_id }}" 
                                            blog-user="{{ $blog_user_id }}" 
                                            userid="{{ $isUserAuthorized }}" 
                                            comment-id="{{ $comm->id }}" 
                                            data-url="{{ $url }}"
                                            data-bs-dismiss="modal">Reply</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @foreach($fundraiserCommentsReply as $comReply)
                @if($comReply->com_id == $comm->id)
                    @php
                        $commentReply = BlogComments::select('user_id')->where('id', $comReply->id)->first();
                        $commentedUser = $commentReply ? UserAuth::getUser($commentReply->user_id) : null;
                    @endphp
                    <div class="comment-header" style="padding-left: 1.5rem;">
                        <div class="img-icon">
                            <img class="img-fluid rounded-circle" alt="User Image" height="40" width="40" src="{{ asset('assets/images/profile/' . ($commentedUser->image ?? 'default.png')) }}">
                        </div>
                        <div class="comments-area">
                            <a href="{{ route('UserProfileFrontend', $commentedUser->slug ?? '#') }}">{{ $commentedUser->first_name ?? 'Anonymous' }}</a>
                            <p>{{ $comReply->comment }}</p>
                        </div>
                        @if($comReply->user_id == $isUserAuthorized || $blog_user_id == $isUserAuthorized)
                        <div class="dots-menu btn-group d-flex">
                            <a data-toggle="dropdown" class="btn btn-primary" onclick="showDropdown({{ $comReply->id }})"><i class='fas fa-ellipsis-v'></i></a>
                            <ul class="dropdown-menu" id="dropdown-{{ $comReply->id }}">
                                @if($comReply->user_id == $isUserAuthorized)
                                <li><a class="dropdown-item" data-bs-toggle="modal" href="#editModal{{ $comReply->id }}"><i class="fa fa-pencil" style="font-size: 13px;"></i></a></li>
                                @endif
                                <li><a class="dropdown-item text-danger" onclick="deleteComment({{ $comReply->id }})"><i class="fa fa-trash-o"></i></a></li>
                            </ul>
                        </div>
                        @endif
                    </div>

                    <!-- Modal for replying to a comment -->
                    <div class="modal fade" id="replyModal{{ $comReply->id }}" tabindex="-1" aria-labelledby="replyModalLabel{{ $comReply->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                           <div class="modal-content">
                              <div class="modal-header">
                                    <h5 class="modal-title" id="replyModalLabel{{ $comReply->id }}">Reply</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                    <p>{{ $comReply->comment }}</p>
                                    <div class="row">
                                       <div class="col-lg-12">
                                          <div class="reply-box" id="reply-box-{{ $comReply->id }}">
                                                <input type="text" class="form-control reply_text" placeholder="Write a reply..." id="reply-input-{{ $comReply->id }}">
                                                <button type="button" class="btn btn-primary sendreply"
                                                   blog-id="{{ $blog_id }}"
                                                   blog-user="{{ $blog_user_id }}"
                                                   userid="{{ UserAuth::getLoginId() }}"
                                                   comment-id="{{ $comReply->id }}"
                                                   data-url="{{ $url }}"
                                                   data-bs-dismiss="modal">Reply</button>
                                          </div>
                                       </div>
                                    </div>
                              </div>
                           </div>
                        </div>
                  </div>

                  <!-- Modal for editing comment -->
                  <div class="modal fade" id="editModal{{ $comReply->id }}" aria-hidden="true" aria-labelledby="editModalLabel{{ $comReply->id }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                           <div class="modal-content my-cont">
                              <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel{{ $comReply->id }}">Edit Comment</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                    <div class="reply-box">
                                       <input type="text" value="{{ $comReply->comment }}" class="form-control edit-comment" id="commentInput">
                                       <button comment_id="{{ $comReply->id }}" blog-id="{{ $blog_id }}" blog-user="{{$blog_user_id}}" data-url="{{ $url }}" class="btn btn-primary update-comment" data-bs-dismiss="modal">Update</button>
                                    </div>
                              </div>
                           </div>
                        </div>
                  </div>

                @endif
            @endforeach
        </li>
    @endif
@endforeach

{{-- @foreach ($hiddenComments as $comm)
  @if ($comm->user_id == UserAuth::getLoginId())
    @php
      $commUserSlug = UserAuth::getUserSlug($comm->user_id);
      $commUser = UserAuth::getUser($comm->user_id);
    @endphp
    <li class="comment-item">
      <span class="show-hidden">
        <i class="fa fa-eye-slash" aria-hidden="true"></i> See Hidden
      </span>
      <div class="hidden-section">
        <div class="comment-header">
          <div class="img-icon">
            <img class="img-fluid rounded-circle" alt="User Image" height="40" width="40" src="{{ asset('assets/images/profile/' . $commUser->image) }}">
          </div>
          <div class="comments-area">
            <a href="{{ route('UserProfileFrontend', $commUserSlug->slug) }}">{{ $commUser->first_name }}</a>
            <p>{{ $comm->comment }}</p>
          </div>
          <div class="comment-actions">
             <button type="button" class="btn btn-hide unhide_comment" data-id="{{ $comm->id }}" blog-id="{{ $blog_id }}" blog-user="{{$blog_user_id}}">Unhide</button>
         </div>
        </div>
      </div>
    </li>
  @endif
@endforeach --}}
