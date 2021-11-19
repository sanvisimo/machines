<?php

namespace App\Observers;

use App\Models\ControlPlan;
use App\Models\Measurement;
use App\Models\MeasurementConfig;

class MeasurementConfigObserver
{
    /**
     * Handle the MeasurementConfig "created" event.
     *
     * @param  \App\Models\MeasurementConfig  $measurementConfig
     * @return void
     */
    public function created(MeasurementConfig $measurementConfig)
    {
        $controlPlan = ControlPlan::where('control_plan_config_id', $measurementConfig->control_plan_config_id)->first();

        $model = new Measurement();
        $model->component_id = $measurementConfig->component_id;
        $model->measurement_config_id = $measurementConfig->id;
        $model->position = $measurementConfig->position;
        $model->control_plan_id = $controlPlan->id;
        $model->image = $measurementConfig->image;
        $model->save();
    }

    /**
     * Handle the MeasurementConfig "updated" event.
     *
     * @param  \App\Models\MeasurementConfig  $measurementConfig
     * @return void
     */
    public function updated(MeasurementConfig $measurementConfig)
    {
        $measurement = Measurement::where('measurement_config_id', $measurementConfig->id)->latest()->first();
        $measurement->image = $measurementConfig->image;
        $measurement->save();
    }

    /**
     * Handle the MeasurementConfig "deleted" event.
     *
     * @param  \App\Models\MeasurementConfig  $measurementConfig
     * @return void
     */
    public function deleted(MeasurementConfig $measurementConfig)
    {
        //
    }

    /**
     * Handle the MeasurementConfig "restored" event.
     *
     * @param  \App\Models\MeasurementConfig  $measurementConfig
     * @return void
     */
    public function restored(MeasurementConfig $measurementConfig)
    {
        //
    }

    /**
     * Handle the MeasurementConfig "force deleted" event.
     *
     * @param  \App\Models\MeasurementConfig  $measurementConfig
     * @return void
     */
    public function forceDeleted(MeasurementConfig $measurementConfig)
    {
        //
    }
}
