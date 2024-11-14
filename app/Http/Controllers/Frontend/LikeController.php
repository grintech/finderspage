<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Admin\Users;
use App\Models\UserAuth;
use App\Models\Admin\Notification;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function listing_likes(Request $request)
    {
        // dd($request->all());
        $user_id = $request->user_id;
        $blog_id = $request->blog_id;
        $blog_user_id = $request->blog_user_id;
        $cate_id = $request->cate_id;
        $type = $request->type;
        $url = $request->url;

        $user = UserAuth::getUser($user_id);

        // Find existing like for the blog and type
        $likeExists = Like::where('blog_id', $blog_id)
                          ->where('type', $type)
                          ->first();

        if ($request->action === 'like') {
            if (!$likeExists) {
                $like = new Like();
                $like->blog_id = $blog_id;
                $like->blog_user_id = $blog_user_id;
                $like->type = $type;
                $like->cate_id = $cate_id;
                $like->likes = 1; // Starting with 1 like since this is a new entry
                $like->liked_by = json_encode([$user_id => $request->reaction]);
                $like->save();
            } else {
                $likedBy = json_decode($likeExists->liked_by, true);
                $likedBy[$user_id] = $request->reaction; // Update user's reaction
                $likeExists->liked_by = json_encode($likedBy);
                $likeExists->increment('likes'); // Increment the likes count
                $likeExists->save();
            }


            $notice = [
                'from_id' => UserAuth::getLoginId(),
                'to_id' => $blog_user_id,
                'cate_id' => $cate_id,
                'type' => 'like',
                'rel_id' => $blog_id,
                'message' => $user->username . ' reacted on your post.',
                'url' => $url,
                ];
            Notification::create($notice); 

            return response()->json([
                'success' => true,
                'message' => 'Liked successfully.',
                'total_likes' => Like::where('blog_id', $blog_id)->sum('likes'),
                'liked_by' => json_decode($likeExists->liked_by ?? $like->liked_by, true),
            ]);
        } elseif ($request->action === 'unlike') {
            if ($likeExists) {
                $likedBy = json_decode($likeExists->liked_by, true);

                if (isset($likedBy[$user_id])) {
                    unset($likedBy[$user_id]); // Remove user reaction
                    $likeExists->liked_by = json_encode($likedBy);
                    $likeExists->decrement('likes'); // Decrement the likes count

                    if ($likeExists->likes <= 0) {
                        // Delete the record if no likes are left
                        $likeExists->delete();
                    } else {
                        $likeExists->save();
                    }

                    $notice = [
                        'from_id' => UserAuth::getLoginId(),
                        'to_id' => $blog_user_id,
                        'cate_id' => $cate_id,
                        'type' => 'unlike',
                        'rel_id' => $blog_id,
                        'message' => $user->username . ' removes their reaction on your post.',
                        'url' => $url,
                        ];
                    Notification::create($notice); 

                    return response()->json([
                        'success' => true,
                        'message' => 'Unliked successfully.',
                        'total_likes' => Like::where('blog_id', $blog_id)->sum('likes'),
                        'liked_by' => json_decode($likeExists->liked_by, true),
                    ]);
                }
            }

            return response()->json([
                'success' => false,
                'message' => 'You have not liked this post.',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid action.',
        ]);
    }

    public function getLikes($id)
    {
        $like = Like::find($id);

        if (!$like) {
            return response()->json(['success' => false, 'message' => 'Like not found.'], 404);
        }

        $likedByArray = !empty($like->liked_by) ? json_decode($like->liked_by, true) : [];

        $likedUsersWithReactions = [];

        if (!empty($likedByArray)) {
            $userIds = array_keys($likedByArray);
            $likedUsers = Users::whereIn('id', $userIds)->get(['id', 'first_name', 'username', 'slug', 'image']);

            $likedUsersWithReactions = $likedUsers->map(function($user) use ($likedByArray) {
                return [
                    'id' => $user->id,
                    'first_name' => $user->first_name,
                    'username' => $user->username,
                    'slug' => $user->slug,
                    'image' => $user->image,
                    'reaction' => $likedByArray[$user->id],
                    'url' => route('UserProfileFrontend', $user->slug),
                ];
            });
        }

        return response()->json([
            'success' => true,
            'likedUsers' => $likedUsersWithReactions,
        ]);
    }


}
