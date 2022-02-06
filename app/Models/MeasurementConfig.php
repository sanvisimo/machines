<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeasurementConfig extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    protected $fillable = [
        'lubricant_levels',
        'lubricant_appearence',
        'leakage',
        'temperature',
        'temperature_min',
        'temperature_max',
        'pressure',
        'pressure_min',
        'pressure_max',
        'vibrations_type_SPM',
        'vibrations_type_SISM',
        'component_id',
        'position',
        'image'
    ];

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
