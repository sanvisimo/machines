<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManagedArticle extends Model
{
    use HasFactory;

    public static function boot()
    {
        parent::boot();

//        self::saving(function($model){
//
//            if(!$model->measurement_point){
//                $component = Component::find($model->component_id);
//                $components =  $component->machine->components;
//                $index = $components->search(function($compo) use ($model){
//                    return $compo->id == $model->component_id;
//                });
//                $c = $index +1;
//                $position = $component->articles->count()+1;
//                $model->measurement_point = "C".$c."-P".$position;
//            }
//        });

    }

    public function component()
    {
        return $this->belongsTo(Component::class);
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function getParent() {
        return $this->component;
    }

    public function getName() {
        return $this->reference .' - '.$this->article->drawing;
    }
}
