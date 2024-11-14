<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceHour extends Model
{
    use HasFactory;

    protected $table = 'service_hours';
    protected $fillable = ['user_id','day','status','open_time','close_time','open_24'];
}
