<?php
namespace App\Models;

use App\Models\AppModel;

class City extends AppModel
{
    protected $table = 'cities';
    protected $primaryKey = 'id';
    public $timestamps = false;
}