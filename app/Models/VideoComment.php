<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoComment extends Model
{
    use HasFactory;
    protected $table = "videoComment";
    protected $fillable = [
                            'video_id',
                            'comment',
                            'user_id',
                            'status',
                            'vid_reply_id'
                        ];
}
