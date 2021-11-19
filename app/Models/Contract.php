<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $casts = [
        'expiration_date' => 'date'
    ];

    public function customers()
    {
        return $this->morphedByMany(Customer::class, 'contractable');
    }

    public function establishments()
    {
        return $this->morphedByMany(Establishment::class, 'contractable');
    }
}
