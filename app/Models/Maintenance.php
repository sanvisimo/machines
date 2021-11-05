<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Maintenance extends Model
{
    use HasFactory;

    protected $casts = [
        'opening_date' => 'datetime',
        'onsite_intervention' => 'datetime',
        'closed_on' => 'datetime',
    ];

    public static function boot()
    {
        parent::boot();

        self::saving(function($model){
            if(!$model->machine_id) {
                if($model->component_id) {
                    $component = Component::find($model->component_id);
                }
                if($model->managed_article_id){
                    $article = ManagedArticle::find($model->managed_article_id);
                    $component = $article->component;
                }

                $model->machine_id = $component->machine_id;
            }
            if(!$model->closed_on) {
                $model->closed_on = Carbon::now();
                $model->duration = Carbon::now()->diffInMinutes($model->opening_date);
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
