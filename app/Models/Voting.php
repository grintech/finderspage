<?php
namespace App\Models;

use App\Models\AppModel;

class Voting extends AppModel
{
    protected $table = 'votings';
    protected $primaryKey = 'id';
    // public $timestamps = false;
}