<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Customer extends Model
{
    use HasFactory, Searchable;

    protected $fillable = ['firstname', 'lastname', 'alias', 'address', 'phone', 'fax', 'authorization', 'image'];

    public function establishment()
    {
        return $this->hasMany(Establishment::class);
    }
}
