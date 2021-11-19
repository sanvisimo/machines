<?php

namespace App\Observers;

use App\Models\Activity;
use App\Models\ControlPlan;
use App\Models\Measurement;
use App\Models\MeasurementConfig;

class MeasurementObserver
{
    /**
     * Handle the Measurement "created" event.
     *
     * @param  \App\Models\Measurement  $measurement
     * @return void
     */
    public function created(Measurement $measurement)
    {
        //
    }

    /**
     * Handle the Measurement "updated" event.
     *
     * @param  \App\Models\Measurement  $measurement
     * @return void
     */
    public function updated(Measurement $measurement)
    {
        $config = MeasurementConfig::find($measurement->measurement_config_id);
        $controlPlan = ControlPlan::where('control_plan_config_id', $config->control_plan_config_id)->latest()->first();
        $oldActivity = Activity::where('activitable_id', $measurement->control_plan_id)
            ->where('activitable_type', 'App\Models\ControlPlan')->first();
        if(!$oldActivity->active) {
            $model = new Measurement();
            $model->component_id = $measurement->component_id;
            $model->measurement_config_id = $measurement->measurement_config_id;
            $model->position = $measurement->position;
            $model->control_plan_id = $controlPlan->id;
            $model->save();
        }
    }

    /**
     * Handle the Measurement "deleted" event.
     *
     * @param  \App\Models\Measurement  $measurement
     * @return void
     */
    public function deleted(Measurement $measurement)
    {
        //
    }

    /**
     * Handle the Measurement "restored" event.
     *
     * @param  \App\Models\Measurement  $measurement
     * @return void
     */
    public function restored(Measurement $measurement)
    {
        //
    }

    /**
     * Handle the Measurement "force deleted" event.
     *
     * @param  \App\Models\Measurement  $measurement
     * @return void
     */
    public function forceDeleted(Measurement $measurement)
    {
        //
    }
}
