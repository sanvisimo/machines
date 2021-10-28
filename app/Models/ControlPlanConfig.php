<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ControlPlanConfig extends Model
{
    use HasFactory;

    public function machine()
    {
        return $this->belongsTo(Machine::class);
    }

    public function controlPlans()
    {
        return $this->hasMany(ControlPlan::class);
    }

    public function measurementConfigs()
    {
        return $this->hasMany(MeasurementConfig::class);
    }
}
