<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ControlPlan extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function activity()
    {
        return $this->morphOne(Activity::class, 'activitable');
    }

    public function machine()
    {
        return $this->belongsTo(Machine::class);
    }

    public function controlPlanConfig()
    {
        return $this->belongsTo(ControlPlanConfig::class);
    }

    public function measurements ()
    {
        return $this->hasMany(Measurement::class);
    }

    /**
     * Get the anomalies for the blog post.
     */
    public function anomalies()
    {
        return $this->hasMany(Anomaly::class);
    }
}
