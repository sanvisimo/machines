<?php

namespace App\Observers;

use App\Models\Activity;
use App\Models\ControlPlan;
use App\Models\ControlPlanConfig;
use Illuminate\Support\Carbon;

class ControlPlanObserver
{
    /**
     * Handle the ControlPlan "created" event.
     *
     * @param  \App\Models\ControlPlan  $controlPlan
     * @return void
     */
    public function created(ControlPlan $controlPlan)
    {
        //
    }

    /**
     * Handle the ControlPlan "updated" event.
     *
     * @param  \App\Models\ControlPlan  $controlPlan
     * @return void
     */
    public function updated(ControlPlan $controlPlan)
    {
        $controlPlanConfig = ControlPlanConfig::find($controlPlan->control_plan_config_id);
//        $lastControlPlan = ControlPlan::where('control_plan_config_id', $controlPlanConfig->id)->latest()->first();
        $oldActivity = Activity::where('activitable_id', $controlPlan->id)
            ->where('activitable_type', 'App\Models\ControlPlan')->first();
        if($oldActivity->active) {
            $oldActivity->expiration = Carbon::now();
            $oldActivity->active = false;
            $oldActivity->save();
            $model = new ControlPlan;
            $model->machine_id = $controlPlan->machine_id;
            $model->control_plan_config_id = $controlPlan->control_plan_config_id;
            $model->contract = $controlPlanConfig->contract;
            $model->cost = $controlPlanConfig->cost;
            $model->periodicity = $controlPlanConfig->periodicity;
            $model->save();



            $activity = new Activity;
            $activity->expiration = Carbon::now()->addDays($controlPlanConfig->periodicity);
            $activity->machine_id = $controlPlan->machine_id;
            $activity->description = 'Control Plan';
            $activity->type = 'control_plan';
            $activity->contract = $controlPlanConfig->contract;
            $activity->fix_fee = false;
            $activity->active = true;
            $activity->element_id = $controlPlanConfig->machine_id;
            $activity->element_type = '\App\Models\Machine';
            $activity->activitable_id = $model->id;
            $activity->activitable_type = 'App\Models\ControlPlan';
            $activity->save();
        }
    }

    /**
     * Handle the ControlPlan "deleted" event.
     *
     * @param  \App\Models\ControlPlan  $controlPlan
     * @return void
     */
    public function deleted(ControlPlan $controlPlan)
    {
        //
    }

    /**
     * Handle the ControlPlan "restored" event.
     *
     * @param  \App\Models\ControlPlan  $controlPlan
     * @return void
     */
    public function restored(ControlPlan $controlPlan)
    {
        //
    }

    /**
     * Handle the ControlPlan "force deleted" event.
     *
     * @param  \App\Models\ControlPlan  $controlPlan
     * @return void
     */
    public function forceDeleted(ControlPlan $controlPlan)
    {
        //
    }
}
