<?php
namespace App\Models;

use App\Models\Admin\BlogCategories as AdminBlogCategories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Libraries\FileSystem;

class BlogCategories extends AdminBlogCategories
{
}