<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Customer extends Model
{
    use HasFactory, Searchable;

    protected $fillable = ['firstname', 'lastname', 'alias', 'address', 'phone', 'fax', 'authorization', 'image'];

    public function leader_code()
    {
        return $this->hasOne(Customer::class);
    }

    public function maintenance_contract()
    {
        return $this->hasOne(Contract::class);
    }

    public function fixfee_contract()
    {
        return $this->hasOne(Contract::class);
    }

    public function monitoring_contract()
    {
        return $this->hasOne(Contract::class);
    }

    public function plants()
    {
        return $this->hasMany(Plant::class);
    }
}
