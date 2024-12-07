<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class dormaccount extends Model
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
