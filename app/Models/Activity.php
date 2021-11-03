<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $casts = [
        'expiration' => 'date'
    ];

    public static function boot()
    {
        parent::boot();

        self::saving(function($model){
            if(!$model->machine_id){
                $element = $model->element_type::where('id', $model->element_id)->first();
                $model->machine_id = $element->machine_id;
            }

            if(!$model->element_id){
                $model->element_id = $model->machine_id;
                $model->element_type = "\App\Models\Machine";
            }
        });

    }

    public function activitable()
    {
        return $this->morphTo();
    }

    public function element()
    {
        return $this->morphTo();
    }

    public function machine()
    {
        return $this->belongsTo(Machine::class);
    }
}
