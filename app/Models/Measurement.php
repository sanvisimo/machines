<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Measurement extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
      'anomaly',
      'anomaly_notes',
      'lubricant_levels',
      'lubricant_levels_notes',
      'lubricant_appearence',
      'lubricant_appearence_notes',
      'leakage',
      'leakage_notes',
      'temperature',
      'pressure',
      'vibrations_type_SPM',
      'vibrations_type_SISM_1',
      'vibrations_type_SISM_2',
      'vibrations_type_SISM_3',
    ];

    public function controlPlan()
    {
        return $this->belongsTo(ControlPlan::class);
    }

    public function component()
    {
        return $this->belongsTo(Component::class);
    }

    public function article()
    {
        return $this->belongsTo(ManagedArticle::class);
    }

    public function measurementConfig()
    {
        return $this->belongsTo(MeasurementConfig::class);
    }
}
