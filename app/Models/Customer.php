<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $casts = [
        'activation_date' => 'date'
    ];

    public function leader_code()
    {
        return $this->hasOne(Customer::class, 'leader_code');
    }

    public function contracts()
    {
        return $this->morphToMany(Contract::class,'contractable');
    }

    public function establishments()
    {
        return $this->hasMany(Establishment::class);
    }

    public function getName() {
        return $this->customer_name;
    }

    /**
     * The users that belong to the role.
     */
    public function manutentors()
    {
        return $this->belongsToMany(User::class);
    }
}
