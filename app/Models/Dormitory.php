<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dormitory extends Model
{
    protected $fillable = [
        'user_id',
        'image',
        'name',
        'location',
        'price',
        'details',
        'contact_number',
        'map_link',
    ];
}
