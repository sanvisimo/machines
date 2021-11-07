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

    public function maintenances()
    {
        return $this->hasMany(ManagedArticle::class);
    }

    public function measurementConfig()
    {
        return $this->hasOne(MeasurementConfig::class);
    }

    public function measurements()
    {
        return $this->hasMany(Measurement::class);
    }

    public function componentCategory()
    {
        return $this->belongsTo(ComponentCategory::class);
    }

    public function componentSubCategory()
    {
        return $this->belongsTo(ComponentSubCategory::class);
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachmentable');
    }

    public function getParent() {
        return $this->machine;
    }

    public function getName() {
        return $this->name;
    }
}
