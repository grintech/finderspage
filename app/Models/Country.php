<?php
namespace App\Models;

use App\Models\AppModel;

class Country extends AppModel
{
    protected $table = 'countries';
    protected $primaryKey = 'id';
    public $timestamps = false;
}