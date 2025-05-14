<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Amenities extends Model
{
  protected $fillable = [
        'name',
        'description',
        'price', // ✅ Add this line
        'user_id'
    ];
public function dormitories()
{
    return $this->belongsToMany(Dormitory::class);
}


}
