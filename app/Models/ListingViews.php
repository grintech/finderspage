<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListingViews extends Model
{
    use HasFactory;
    protected $table="listing_views";
    protected $fillable = ['Post_id', 'count', 'view_by' ,'type'];
}
