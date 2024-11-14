<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repost extends Model
{
    use HasFactory;
    protected $table ="reposts";
    protected $fillable =['user_id','post_id','next_repost_at','is_paid'];
}
