<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    use HasFactory;

    public function plant()
    {
        return $this->belongsTo(Plant::class);
    }

    public function components()
    {
        return $this->hasMany(Component::class);
    }
}
