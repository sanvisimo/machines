<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    public function customer()
    {
        return $this->belongsToMany(Customer::class, 'customer_contract');
    }
}
