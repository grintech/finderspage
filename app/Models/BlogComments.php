<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogComments extends Model
{
    use HasFactory;
    protected $table ="blog_comments";
    protected $fillable =[
                            'com_id',
                            'user_id',
                            'blog_id',
                            'type',
                            'comment',
                            'status',
                        ];
    public function AddComments($request){
        self::create([
                        'user_id' => $request->userid,
                        'blog_id' => $request->video_id,
                        'comment' => $request->comment,
                        'type' => isset($request->type) ? $request->type : null,
                    ]);
    }


    public function ReplyComments($request){
        self::create([
                        'com_id' => $request->comment_id,
                        'user_id' => $request->userid,
                        'blog_id' => $request->video_id,
                        'comment' => $request->comment,
                        'type' => $request->type,
                    ]);
    }
}
