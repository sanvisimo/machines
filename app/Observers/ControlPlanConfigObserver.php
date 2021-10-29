<?php

namespace App\Observers;

use App\Models\Activity;
use App\Models\ControlPlan;
use App\Models\ControlPlanConfig;

class ControlPlanConfigObserver
{
    /**
     * Handle the ControlPlanConfig "created" event.
     *
     * @param  \App\Models\ControlPlanConfig  $controlPlanConfig
     * @return void
     */
    public function created(ControlPlanConfig $controlPlanConfig)
    {
        $model = new ControlPlan;
        $model->machine_id = $controlPlanConfig->machine_id;
        $model->control_plan_config_id = $controlPlanConfig->id;
        $model->contract = $controlPlanConfig->contract;
        $model->cost = $controlPlanConfig->cost;
        $model->periodicity = $controlPlanConfig->periodicity;
        $model->save();


        $activity = new Activity;
        $activity->expiration = $controlPlanConfig->start_date;
        $activity->machine_id = $controlPlanConfig->machine_id;
        $activity->description = 'Control Plan';
        $activity->type = 'control_plan';
        $activity->contract = $controlPlanConfig->contract;
        $activity->fix_fee = false;
        $activity->active = true;
        $activity->element_id = $controlPlanConfig->machine_id;
        $activity->element_type = '\App\Models\Machine';
        $activity->activitable_id = $model->id;
        $activity->activitable_type ='App\Models\ControlPlan';
        $activity->save();
    }

    /**
     * Handle the ControlPlanConfig "updated" event.
     *
     * @param  \App\Models\ControlPlanConfig  $controlPlanConfig
     * @return void
     */
    public function updated(ControlPlanConfig $controlPlanConfig)
    {
        //
    }

    /**
     * Handle the ControlPlanConfig "deleted" event.
     *
     * @param  \App\Models\ControlPlanConfig  $controlPlanConfig
     * @return void
     */
    public function deleted(ControlPlanConfig $controlPlanConfig)
    {
        //
    }

    /**
     * Handle the ControlPlanConfig "restored" event.
     *
     * @param  \App\Models\ControlPlanConfig  $controlPlanConfig
     * @return void
     */
    public function restored(ControlPlanConfig $controlPlanConfig)
    {
        //
    }

    /**
     * Handle the ControlPlanConfig "force deleted" event.
     *
     * @param  \App\Models\ControlPlanConfig  $controlPlanConfig
     * @return void
     */
    public function forceDeleted(ControlPlanConfig $controlPlanConfig)
    {
        //
    }
}
