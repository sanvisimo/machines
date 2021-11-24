<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Establishment extends Model
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
        return $this->hasOne(Contract::class,'id', 'maintenance_contract');
    }

    public function fixfee_contract()
    {
        return $this->hasOne(Contract::class, 'id', 'fixfee_contract');
    }

    public function monitoring_contract()
    {
        return $this->hasOne(Contract::class, 'id', 'monitoring_contract');
    }

    public function plants()
    {
        return $this->hasMany(Plant::class);
    }

    public function getParent() {
        return $this->customer;
    }

    public function getName() {
        return $this->customer_name . ' - ' . $this->city;
    }
}
