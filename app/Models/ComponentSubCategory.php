<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComponentSubCategory extends Model
{
    use HasFactory;

    public function component_category()
    {
        return $this->belongsTo(ComponentCategory::class);
    }
}
