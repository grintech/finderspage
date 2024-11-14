<?php

namespace App\Models\Admin;

use App\Models\AppModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProfileCategory extends AppModel
{
    protected $table = 'profile_categories';
    protected $guarded = [];
    protected $primaryKey = 'id';
    public $timestamps = false;

}