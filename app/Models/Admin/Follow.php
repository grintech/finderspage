<?php

namespace App\Models\Admin;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\AppModel;

class Follow extends AppModel
{
    use SoftDeletes;

    protected $table = 'follows';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];
    protected $dates = ['deleted_at'];


    public static function create($data)
    {
        $follow = new Follow();

        foreach ($data as $k => $v) {
            $follow->{$k} = $v;
        }
        $follow->created_at = date('Y-m-d H:i:s');
        $follow->save();
    }


    public static function create2($data)
    {
        $follow = new Follow();

        foreach ($data as $k => $v) {
            $follow->{$k} = $v;
        }
        $follow->created_at = date('Y-m-d H:i:s');
        $follow->save();
    }

}
