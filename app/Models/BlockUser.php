<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlockUser extends Model
{
    use HasFactory;
    protected $table ="block_users";
    protected $fillable=['block_id','block_by'];

    public function add_block_user($request)
    {
        self::create([
            'block_id'=>$request->block_id,
            'block_by'=>$request->block_by,
        ]);
    }
}
