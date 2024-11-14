<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogsViews extends Model
{
    use HasFactory;

    protected $table="blogs_views";
    protected $fillable = ['Post_id', 'count', 'view_by' ,'type'];
}
