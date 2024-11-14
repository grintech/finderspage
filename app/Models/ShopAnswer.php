<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Auth;
use Illuminate\Database\Eloquent\Model;

class ShopAnswer extends Model
{
    use HasFactory;
    protected $table ='shop_answers';
    protected $fillable =['post_id','question_id','answer','user_id',];

     public function addAnswers($request){

        self::create([
                        'post_id' => $request->post_id,
                        'question_id'=> $request->question_id,
                        'answer'=> $request->answer,
                        'parent_id'=> $request->parent_id,
                        'user_id'=> Auth::user()->id,
                    ]);

    }

}
