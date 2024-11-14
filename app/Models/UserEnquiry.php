<?php
namespace App\Models;

use App\Models\AppModel;

class UserEnquiry extends AppModel
{
    protected $table = 'user_enquiries';
    protected $primaryKey = 'id';
    public $timestamps = false;
}