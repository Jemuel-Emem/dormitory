<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class dormowner extends Model
{
    //

    protected $fillable = [
        'name',
        'address',
        'phone_number',
        'email',
        'password',
        'is_admin'
    ];
}
