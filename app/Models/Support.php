<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
    use HasFactory;

    protected $table = "supports";

    protected $fillable = [
                            'ticket_title',
                            'user_id',
                            'priority',
                            'discription',
                            'status',
                            'ticket_status',
                        ];

    public function add_ticket_support($request)
    {
        self::create([
                        'ticket_title' => $request->ticket_title,
                        'priority' => 2,
                        'discription' => $request->discription,
                        'user_id' => $request->user_id,
                        'status' => 0,
                        'ticket_status' => 0,
                    ]);
    }



    public function update_ticket_support($request,$id)
    {
        $this::update([
                        'ticket_title' => $request->ticket_title,
                        'priority' => 2,
                        'discription' => $request->discription,
                        'user_id' => $request->user_id,
                    ]);
    }
}
