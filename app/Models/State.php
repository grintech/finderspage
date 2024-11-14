<?php
namespace App\Models;

use App\Models\AppModel;

class State extends AppModel
{
    protected $table = 'states';
    protected $primaryKey = 'id';
    public $timestamps = false;
}