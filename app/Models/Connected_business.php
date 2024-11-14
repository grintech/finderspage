<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Connected_business extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table ="connected_businesses";
        protected $fillable =[
                                'user_id',
                                'business_id',
                                'status',
                            ];

    public static function create_connected_business($request){
        // dd($request->all());
        Self::Create([
                        'user_id' => $request->user_id,
                        'business_id' => $request->business_id,
                    ]);
    }



    public static function get_connections_data($user_id , $business_id){
     $data = Connected_business::where('user_id',$user_id)->first();
     return $data;
    }
}
