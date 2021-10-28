<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeasurementConfig extends Model
{
    use HasFactory;

    public function measurements()
    {
        return $this->hasMany(Measurement::class);
    }

    public function controlPlanConfig()
    {
        return $this->belongsTo(ControlPlanConfig::class);
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
