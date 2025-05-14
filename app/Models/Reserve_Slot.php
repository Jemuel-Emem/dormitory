<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserve_Slot extends Model
{
    //

 //   protected $table = 'reserve_slot'; // Specify the table name if not plural of the model name

    protected $fillable = [
        'user_id',
        'dorm_id',
        'slot',
        'amenities_ids'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dorm()
    {
        return $this->belongsTo(Dormitory::class, 'dorm_id'); // Use the 'dorm_id' foreign key
    }
}
