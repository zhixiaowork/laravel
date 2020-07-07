<?php

namespace App\Models;

use App\Models\Model;

class Admin extends Model
{

    protected $hidden = [
        'password', 'remember_token',
    ];
}
