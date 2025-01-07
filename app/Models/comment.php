<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class comment extends Model
{
    //

    protected $fillable = [
        'user_id',
        'dormitory_id',
        'content',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dormitory()
    {
        return $this->belongsTo(Dormitory::class);
    }



}
