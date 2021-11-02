<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factory extends Model
{
    use HasFactory;

    protected $casts = [
        'activation_date' => 'date'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function leader_code()
    {
        return $this->hasOne(Customer::class,'leader_code');
    }

    public function maintenance_contract()
    {
        return $this->hasOne(Contract::class,'maintenance_contract', 'maintenance_contract');
    }

    public function fixfee_contract()
    {
        return $this->hasOne(Contract::class, 'fixfee_contract', 'fixfee_contract');
    }

    public function monitoring_contract()
    {
        return $this->hasOne(Contract::class, 'monitoring_contract', 'monitoring_contract');
    }

    public function plants()
    {
        return $this->hasMany(Plant::class);
    }
}
