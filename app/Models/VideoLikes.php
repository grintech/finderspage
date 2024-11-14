<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoLikes extends Model
{
    use HasFactory;
    protected $table = "like_video";
    protected $fillable = [
                            'video_id',
                            'likes',
                            'like_by'
                        ];
}
