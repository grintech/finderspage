<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Latest_post extends Model
{
    use HasFactory;
    protected $table = "latest_posts";
    protected $fillable = [
                    'user_id',
                    'to_id',
                    'post_id',
                    'category',
                    'type',
                    'status',
    ];


    public static function create_latestpost($data){
        self::create([
                "user_id" => $data['user_id'],
                "to_id" => $data['to_id'],
                "post_id" => $data['post_id'],
                "category" => $data['category'],
                "type" => $data['type'],
                "status" =>"1",
        ]);
    }



    public static function get_latestpost_data($id){

        
    $data =  Latest_post::where('user_id', 2415)->where('status',0)->get();
        dd($data);
    return  $data;
    }
}
