<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoCategoryRelation extends Model
{
    use HasFactory;

    protected $table = 'video_category_relation';
    protected $fillable =[
                            'video_id',
                            'category_id',
                            'sub_category_id',
                        ];

        
}
