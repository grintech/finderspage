<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
use Exception;
use App\Models\UserAuth;
use App\Models\Admin\Users;
use App\Models\BlogPost;
use App\Models\Admin\Notification;

class PostReport extends Model
{
    use HasFactory;
    protected $table ="post_reports";
    protected $fillable =[
                            'post_id',
                            'reason',
                            'type',
                            'reported_by',
                        ];
    public function addReport($request)
    {
        self::create([
            'post_id' => $request->post_id,
            'reason' => implode(',', $request->reason),
            'type' => $request->type,
            'reported_by' => $request->user_id,
        ]);
        return true;
    }

}
