<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaveVideo extends Model
{
    use HasFactory;
    protected $table = "save_video";
    protected $fillable = [
                            'video_id',
                            'user_id'
                        ];
}
