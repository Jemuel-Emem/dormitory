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
        'status',
        'owner_id',
        'slot'
    ];
    public function reserveSlots()
    {
        return $this->hasMany(Reserve_Slot::class, 'dorm_id');
    }
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }


}
