<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    use HasFactory;

    public function machine()
    {
        return $this->belongsTo(Machine::class);
    }

    public function articles()
    {
        return $this->hasMany(ManagedArticle::class);
    }

    public function component_category()
    {
        return $this->hasOne(ComponentCategory::class);
    }

    public function component_sub_category()
    {
        return $this->hasOne(ComponentSubCategory::class);
    }
}
