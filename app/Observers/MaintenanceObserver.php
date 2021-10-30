<?php

namespace App\Observers;

use App\Models\Activity;
use App\Models\Maintenance;
use Illuminate\Support\Carbon;

class MaintenanceObserver
{
    /**
     * Handle the Maintenance "created" event.
     *
     * @param  \App\Models\Maintenance  $maintenance
     * @return void
     */
    public function created(Maintenance $maintenance)
    {
       //
    }

    /**
     * Handle the Maintenance "updated" event.
     *
     * @param  \App\Models\Maintenance  $maintenance
     * @return void
     */
    public function updated(Maintenance $maintenance)
    {
        $activity = $maintenance->activity;
        if(!$activity){
            $model = new Activity;
            $model->machine_id = $maintenance->machine_id;
            $model->description = "Extraordinary Maintenance";
            $model->expiration = $maintenance->closed_on;
            $model->type = $maintenance->type;
            $model->active = false;
            $model->activitable_id = $maintenance->id;
            $model->activitable_type = '\App\Models\Maintenance';
            $model->element_id = $maintenance->component_id;
            $model->element_type = '\App\Models\Component';
            $model->save();
        } else {
            $activity->active = false;
            $activity->save();

            $model = new Activity;
            $model->machine_id = $maintenance->machine_id;
            $model->description = "Maintenance";
            $model->expiration = Carbon::now()->addDays($maintenance->periodicity);
            $model->type = $maintenance->type;
            $model->periodicity = $maintenance->periodicity;
            $model->active = true;
            $model->element_id = $maintenance->component_id;
            $model->element_type = '\App\Models\Component';
            $model->save();
        }
    }

    /**
     * Handle the Maintenance "deleted" event.
     *
     * @param  \App\Models\Maintenance  $maintenance
     * @return void
     */
    public function deleted(Maintenance $maintenance)
    {
        //
    }

    /**
     * Handle the Maintenance "restored" event.
     *
     * @param  \App\Models\Maintenance  $maintenance
     * @return void
     */
    public function restored(Maintenance $maintenance)
    {
        //
    }

    /**
     * Handle the Maintenance "force deleted" event.
     *
     * @param  \App\Models\Maintenance  $maintenance
     * @return void
     */
    public function forceDeleted(Maintenance $maintenance)
    {
        //
    }
}
