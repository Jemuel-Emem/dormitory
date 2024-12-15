<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tenant extends Model
{
    //

    protected $fillable = [
        'owner_id',
        'fullname',
        'age',
        'phone_number',
        'room_number',
        'monthly_fee',
        'due_date',
    ];
}
