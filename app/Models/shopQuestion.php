<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;

class shopQuestion extends Model
{
    use HasFactory;
    protected $table ="shop_questions";
    protected $fillable =['post_id','question','user_id'];

    public function addQuestion($request){

        self::create([
                        'post_id' => $request->post_id,
                        'question'=> $request->question,
                        'user_id'=> Auth::user()->id,
                    ]);

    }
}
