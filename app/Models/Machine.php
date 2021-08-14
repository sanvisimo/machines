<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    use HasFactory;

    protected $casts = [
        'birthday' => 'date',
        'published_at' => 'datetime',
        'meta' => 'array',
        'permissions' => 'array'
    ];

    public function plant()
    {
        return $this->belongsTo(Plant::class);
    }
}
