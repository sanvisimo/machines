<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasFactory;

    public function activity()
    {
        return $this->morphOne(Activity::class, 'activitable');
    }

    public function machine()
    {
        return $this->belongsTo(Machine::class);
    }

    public function component()
    {
        return $this->belongsTo(Component::class);
    }

    public function article()
    {
        return $this->belongsTo(ManagedArticle::class);
    }
}
