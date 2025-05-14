<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dormitory extends Model
{
    protected $casts = [
    'amenities_ids' => 'array',
];


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
        'slot',
        'amenities_ids'
    ];

    public function amenities()
{
    return $this->belongsToMany(Amenities::class, 'dormitory_amenity', 'dormitory_id', 'amenity_id');
}

// public function amenities()
// {
//     return $this->belongsToMany(Amenities::class);
// }


    public function reserveSlots()
    {
        return $this->hasMany(Reserve_Slot::class, 'dorm_id');
    }
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function dormitory()
    {
        return $this->belongsTo(Dormitory::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
