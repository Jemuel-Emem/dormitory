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

    // In Tenant model
public function monthlyPayment()
{
    return $this->hasOne(monthly_payment::class);
}
public function dormitory()
{
    return $this->belongsTo(Dormitory::class);
}
public function amenities()
{
    return $this->belongsToMany(Amenities::class);
}


}
