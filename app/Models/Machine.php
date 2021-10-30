<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    use HasFactory;

    protected $casts = [
        'activation_date' => 'date'
    ];

    public function plant()
    {
        return $this->belongsTo(Plant::class);
    }

    public function components()
    {
        return $this->hasMany(Component::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function lastActivities()
    {
        return $this->activities()
            ->where('active', true)
            ->where('expiration', '<=', Carbon::today()->addDays(5));
    }

    public function newActivities()
    {
        return $this->activities()->where('active', 1);
    }

    public function oldActivities()
    {
        return $this->activities()->where('active', 0);
    }

    public function maintenances()
    {
        return $this->hasMany(Maintenance::class);
    }

    public function controlPlanConfig()
    {
        return $this->hasOne(ControlPlanConfig::class);
    }

    public function controlPlans()
    {
        return $this->hasMany(ControlPlan::class);
    }
}
