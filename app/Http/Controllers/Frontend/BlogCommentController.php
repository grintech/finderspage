<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogComments;
use App\Models\BlogPost;
use App\Models\Admin\Notification;
use App\Models\UserAuth;
use App\Models\Admin\Users;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Requests;

class BlogCommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        // dd($request->all());
        $blog_comment = new BlogComments();
        $blog_comment = $blog_comment->AddComments($request);
        $blogData = BlogPost::where('id',$request->video_id)->first();
        // dd($blogData);
        $user = UserAuth::getLoginUser();
        if($blogData->posted_by=='admin'){
            $notice = [
                'from_id' => $request->userid,
                'to_id' => 7,
                'type' => 'Blog_post',
                'rel_id' => $request->video_id,
                'url' => $request->url,
                'message' => $user->username . ' commented on your blog ' . $blogData->title . '.',
            ];
            Notification::create($notice);
        }else{
            $notice = [
                'from_id' => $request->userid,
                'to_id' => $request->blog_user,
                'type' => 'Blogpost_front',
                'rel_id' => $request->video_id,
                'url' => $request->url,
                'message' => $user->username . ' commented on your blog ' . $blogData->title . '.',
            ];
            Notification::create($notice);
        }
        
        if (!empty($blog_comment)) {
            return response()->json(['error' => 'Somthing went wrong.'], 400);
        } else {
            return response()->json(['success' => 'Comment added successfully.'], 200);
        }
    }

    public function Replystore(Request $request)
    {
        // dd($request->all());
        $blog_comment = new BlogComments();
        $blog_comment = $blog_comment->ReplyComments($request);
        $blogData = BlogPost::where('id',$request->video_id)->first();
        $to_id = BlogComments::select('user_id')->where('id', $request->comment_id)->first();
        $user = UserAuth::getLoginUser();

        $notice1 = [
            'from_id' => $request->userid,
            'to_id' => $request->blog_user,
            'type' => 'Blog_post',
            'rel_id' => $request->video_id,
            'url' => $request->url,
            'message' => $user->username . ' replied on your blog ' . $blogData->title . '.',
        ];

        $notice2 = [
            'from_id' => $request->userid,
            'to_id' => $to_id->user_id,
            'type' => 'Blog_post',
            'rel_id' => $request->video_id,
            'url' => $request->url,
            'message' => $user->username . ' replied on your blog ' . $blogData->title . '.',
        ];

        $notices = [$notice1, $notice2];

        foreach ($notices as $notice) {
            Notification::create($notice);
        }

        if (!empty($blog_comment)) {
            return response()->json(['error' => 'Somthing went wrong.'], 400);
        } else {
            return response()->json(['success' => 'Reply added successfully.'], 200);
        }
    }


    public function Hide_Comments(Request $request) {
        $id = $request->id;
        $status = $request->status;
        // dd($status);
        $blog_hide = BlogComments::find($id);
        // dd($blog_hide);
        if ($blog_hide) {
            $update = $blog_hide->update([
                'status' => $status,
            ]);
            
            if ($update) {
                return response()->json(['success' => 'Comment updated successfully.'], 200);
            } else {
                return response()->json(['error' => 'Something went wrong while updating.'], 400);
            }
        } else {
            return response()->json(['error' => 'Comment not found.'], 400);
        }
    }
    

    public function fundraiser(Request $request) 
    {
        $comment = new BlogComments();

        $user_id = $request->userid;
        $blog_id = $request->video_id;
        $blog_user_id = $request->blog_user;
        $url = $request->url;
        $type = $request->type;
        // $alreadyExist = BlogComments::where('user_id', $user_id)
        //                 ->where('blog_id', $blog_id)
        //                 ->where('type', $type)
        //                 ->exists();
        // if ($alreadyExist) 
        // {
        //     return response()->json(['error' => 'You have already commented.'], 400);
        // }
        $commentResult = $comment->AddComments($request);

        // dd($commentResult);
        if (!$commentResult) {

            $user = Users::find($user_id);
            
            $userImage = $user->image;
            $userSlug = $user->slug;
            $userName = $user->first_name;

            $result = BlogComments::latest()->first();

            // dd($result);
            $html = view('frontend.comment.comment', compact('result', 'url', 'userImage', 'userSlug', 'userName', 'blog_id', 'blog_user_id'))->render();
            return response()->json([
                'html' => $html,
                'success' => 'Comment added successfully.'
            ]);
        }

        return response()->json(['error' => 'Failed to add comment.'], 500);
    }

    public function fundraiser_likes(Request $request)
    {
        $commentId = $request->input('comment_id');
        $userID = $request->input('user_id');
    
        $comment = BlogComments::find($commentId);
    
        if ($comment) {
            $likedByArray = json_decode($comment->liked_by, true) ?? [];
    
            if ($request->action === 'like') {
                if (!in_array($userID, $likedByArray)) {
                    $likedByArray[] = $userID;
                    $comment->increment('likes');
                }
            } elseif ($request->action === 'unlike') {
                if (($key = array_search($userID, $likedByArray)) !== false) {
                    unset($likedByArray[$key]);
                    $comment->decrement('likes');
                }
            }
    
            $comment->liked_by = json_encode(array_values($likedByArray)); 
            $comment->save();
    
            return response()->json([
                'success' => true,
                'likes' => $comment->likes,
                'liked_by' => json_decode($comment->liked_by, true)
            ]);
        }
    
        return response()->json([
            'success' => false,
            'message' => 'Comment not found.',
        ], 404);
    }

    public function getCommentLikes($id)
    {
        $comment = BlogComments::find($id);

        if (!$comment) {
            return response()->json(['success' => false, 'message' => 'Comment not found.'], 404);
        }

        $likedByArray = !empty($comment->liked_by) ? json_decode($comment->liked_by, true) : [];

        $likedUsers = Users::whereIn('id', $likedByArray)->get(['id', 'first_name', 'username', 'slug', 'image']);

        return response()->json([
            'success' => true,
            'likedUsers' => $likedUsers,
        ]);
    }

    public function fundraiser_reply(Request $request)
    {
        // dd($request->all());
        $blog_id = $request->video_id;
        $blog_user_id = $request->blog_user;
        $commentId = $request->comment_id;
        $url = $request->url;
        $type = $request->type;
        $fundraiser_comment = new BlogComments();
        $fundraiser_comment = $fundraiser_comment->ReplyComments($request);

        $users = Users::all();

        if (!$fundraiser_comment) {

            $user = Users::find($request->userid);
            
            $userImage = $user->image;
            $userSlug = $user->slug;
            $userName = $user->first_name;

            $fundraiserComments = BlogComments::where('blog_id', $blog_id)
                        // ->where('status', 1)
                        ->whereNull('com_id')
                        ->where('type', $type)
                        ->get();

            $fundraiserCommentsReply = BlogComments::where('blog_id', $blog_id)
                        // ->where('status', 1)
                        ->where('type', $type)
                        ->whereNotNull('com_id')
                        ->get();
            
            $hiddenComments = BlogComments::where('blog_id', $blog_id)
                        ->where('id', $commentId)
                        ->whereNull('deleted_at')
                        ->where('com_id', null)
                        ->where('type', $type)
                        ->get();
            // dd($fundraiserComments, $fundraiserCommentsReply, $userImage, $userSlug, $userName, $url, $blog_id, $blog_user_id);

            $html = view('frontend.comment.comment_reply', compact('fundraiserComments', 'fundraiserCommentsReply', 'userImage', 'userSlug', 'userName', 'users', 'url', 'blog_id', 'blog_user_id', 'hiddenComments'))->render();
            return response()->json([
                'html' => $html,
                'success' => 'Reply added successfully.'
            ]);
        }

        return response()->json(['error' => 'Failed to add reply.'], 500);
    }

    public function fundraiser_hide_comment(Request $request) 
    {
        $commentId = $request->input('id');
        $status = $request->input('status');
    
        $blog_hide = BlogComments::find($commentId);
    
        if ($blog_hide) {
            $update = $blog_hide->update([
                'status' => $status,
            ]);
            
            if ($update) {
                return response()->json(['success' => 'Comment has been successfully hidden.'], 200);
            } else {
                return response()->json(['error' => 'Something went wrong while hiding comment.'], 400);
            }
        } else {
            return response()->json(['error' => 'Comment not found.'], 400);
        }
    }


    public function fundraiser_unhide_comment(Request $request) 
    {
        $commentId = $request->input('id');
        $status = $request->input('status');
    
        $blog_hide = BlogComments::find($commentId);
    
        if ($blog_hide) {
            $update = $blog_hide->update([
                'status' => $status,
            ]);
            
            if ($update) {
                return response()->json(['success' => 'Comment has been successfully unhidden.'], 200);
            } else {
                return response()->json(['error' => 'Something went wrong while unhiding comment.'], 400);
            }
        } else {
            return response()->json(['error' => 'Comment not found.'], 400);
        }
    }

    // public function fundraiser_show_hidden(Request $request)
    // {
    //     $blog_id = $request->video_id;
    //     $id = $request->comm_id;
    //     $blog_user_id = $request->blog_user;
    //     $type = $request->type;
    //     $url = $request->url;

    //     $users = Users::all();

    //     $hiddenComments = BlogComments::where('blog_id', $blog_id)
    //                             ->where('id', $id)
    //                             ->whereNull('deleted_at')
    //                             ->where('com_id', null)
    //                             ->where('type', $type)
    //                             ->get();

    //     $html = view('frontend.comment.comments-hidden', compact('users', 'blog_id', 'blog_user_id', 'url', 'hiddenComments'))->render();
        
    //     return response()->json(['html' => $html]);
    // }
    
    public function fundraiser_update_comment(Request $request)
    {
        $commentId = $request->commentId;
        $newComment = $request->comment;
        $type = $request->type;
        $url = $request->url;
        $blog_id = $request->blog_id;
        $blog_user_id = $request->blog_user;

        $users = Users::all();

        $comment = BlogComments::find($commentId);
    
        $comment->comment = $newComment;
        $comment->save(); // Using save() instead of update() for clarity
    
        // Fetch updated comments and replies
        $fundraiserComments = BlogComments::where('blog_id', $blog_id)
                            // ->where('status', 1)
                            ->whereNull('com_id')
                            ->where('type', $type)
                            ->get();
    
        $fundraiserCommentsReply = BlogComments::where('blog_id', $blog_id)
                            // ->where('status', 1)
                            ->where('type', $type)
                            ->whereNotNull('com_id')
                            ->get();
                            
        $hiddenComments = BlogComments::where('blog_id', $blog_id)
                            ->where('id', $commentId)
                            ->whereNull('deleted_at')
                            ->where('com_id', null)
                            ->where('type', $type)
                            ->get();

        $html = view('frontend.comment.comments-list', compact('users', 'blog_id', 'blog_user_id', 'url', 'fundraiserComments', 'fundraiserCommentsReply', 'hiddenComments'))->render();
    
        return response()->json([
            'success' => 'Comment updated successfully.',
            'html' => $html
        ]);
    }
    
    public function fundraiser_pin_comment(Request $request) 
    {
        $url = $request->url;
        $blog_id = $request->blog_id;
        $blog_user_id = $request->blog_user;
        $commentId = $request->input('comment_id');
        
        $comment = BlogComments::find($commentId);
        
        if (!$comment) {
            return response()->json(['success' => false, 'message' => 'Comment not found.']);
        }
    
        $comment->pin = '1';
        $comment->pin_created_at = now();
        $comment->save();
    

        $user = UserAuth::getUser($comment->user_id);
        
        // dd($comment, $user, $url, $blog_id, $blog_user_id);
        
        $html = view('frontend.comment.comment-pin', [
            'comm' => $comment,
            'user' => $user,
            'url' => $url,
            'blog_id' => $blog_id,
            'blog_user_id' => $blog_user_id
        ])->render();
    
        return response()->json(['success' => true, 'html' => $html]);
    }
    
    public function fundraiser_unpin_comment(Request $request)
    {
        $url = $request->url;
        $blog_id = $request->blog_id;
        $blog_user_id = $request->blog_user;
        $commentId = $request->input('comment_id');
        $comment = BlogComments::find($commentId);
    
        if (!$comment) {
            return response()->json(['success' => false, 'message' => 'Comment not found.']);
        }
    
        // Unpin the comment
        $comment->pin = '0';
        $comment->pin_created_at = null;
        $comment->save();
    
        $user = UserAuth::getUser($comment->user_id);
        $html = view('frontend.comment.comment-unpin', [
            'comm' => $comment,
            'user' => $user,
            'url' => $url,
            'blog_id' => $blog_id,
            'blog_user_id' => $blog_user_id
            ])->render();
    
        return response()->json(['success' => true, 'html' => $html]);
    }


    
    public function fundraiser_delete_comment(Request $request)
    {
        $commentId = $request->commentId;

        $comment = BlogComments::find($commentId);

        if ($comment) {
            BlogComments::where('com_id', $comment->id)
                ->forceDelete();
            return response()->json(['success' => 'Comments have been deleted.'], 200);
        } else {
            return response()->json(['error' => 'Comment not found.'], 404);
        }
    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $comment_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $comment_id)
    {
        $editedComment = $request->editedComment;
        $comment = BlogComments::find($comment_id);
        $comment->comment = $editedComment;
        $comment->save();
        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified comment from storage.
     *
     * @param  int  $comment_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($comment_id)
    {
        $comment = BlogComments::find($comment_id);

        if ($comment) {

            $comment->status = 0;
            $comment->deleted_at = now();
            $comment->save(); 

            $blog_id = $comment->blog_id;

            BlogComments::where('com_id', $comment->id)
                ->where('status', 1) 
                ->where('blog_id', $blog_id)
                ->delete();

            return response()->json(['success' => 'Comments have been marked as deleted.'], 200);
        } else {
            return response()->json(['error' => 'Comment not found.'], 404);
        }
    }
    
    
}
