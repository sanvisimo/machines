<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Maintenance extends Model
{
    use HasFactory;

    protected $casts = [
        'opening_date' => 'date',
        'onsite_intervention' => 'date',
        'closed_on' => 'date',
    ];

    public static function boot()
    {
        parent::boot();

        self::saving(function($model){
            if(!$model->machine_id) {
                $element = Component::find($model->component_id);
                $model->machine_id = $element->machine_id;
            }
        });

    }

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
