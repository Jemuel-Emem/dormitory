<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class monthly_payment extends Model
{
    //
    protected $table = 'monthly_payments'; // Ensure this matches your table name

    protected $fillable = ['owner_id', 'tenant_id', 'status'];

    public function dormitory()
    {
        return $this->belongsTo(Dormitory::class, 'dormitory_id');
    }

    public function tenant()
{
    return $this->belongsTo(Tenant::class);
}
}
