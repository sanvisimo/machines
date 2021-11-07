<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plant extends Model
{
    use HasFactory;

    public function establishment()
    {
        return $this->belongsTo(Establishment::class);
    }

    public function machines()
    {
        return $this->hasMany(Machine::class);
    }

    public function getParent() {
        return $this->establishment;
    }

    public function getName() {
        return $this->plant;
    }
}
