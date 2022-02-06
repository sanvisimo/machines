<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ControlPlanConfig extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
        'start_date',
        'periodicity',
        'cost',
        'contract',
        'global_conditions',
        'machine_status',
        'casing_integrity_check',
        'nameplate_integrity',
        'rpm',
        'check_pressure_gauges',
        'check_sight_glasses_oil',
        'check_sight_glasses_water',
        'check_thermometers',
        'electric_absorption',
        'check_cleaning_protective_grid',
        'check_cleaning_junction_box',
        'check_integrity_flexible_electric',
        'check_ground_connections',
        'thermography',
        'laser_alignment',
        'machine_id'
    ];

    protected $casts = [
        'start_date' => 'date'
    ];

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
