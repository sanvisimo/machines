<?php

namespace App\Observers;

use App\Models\Activity;
use App\Models\ControlPlan;
use App\Models\ControlPlanConfig;
use App\Models\Maintenance;
use App\Models\Measurement;

class ActivityObserver
{
    /**
     * Handle the Activity "created" event.
     *
     * @param  \App\Models\Activity  $activity
     * @return void
     */
    public function created(Activity $activity)
    {
        switch($activity->type) {
            case "maintenance":
            case "maintenance_no":
            case "lubrification":
                $maintenance = $activity->element_type::where('id', $activity->activitable_id)->first();
                if(!$maintenance) {
                    $model = new Maintenance;
                    $model->machine_id = $activity->machine_id;
                    $model->component_id = $activity->element_type === 'App\Models\Component' ? $activity->element_id : null;
                    $model->managed_article_id = $activity->element_type === 'App\Models\ManagedArticle' ? $activity->element_id : null;
                    $model->type = $activity->type;
                    $model->periodicity = $activity->periodicity;
                    $model->save();

                    $activity->activitable_id = $model->getKey();
                    $activity->activitable_type = 'App\Models\Maintenance';
                    $activity->save();
                }
                break;
            case "control_plan_no":
                $control_plan = $activity->element_type::where('id', $activity->activitable_id)->first();
                if(!$control_plan) {
                    $controlPlan = ControlPlan::where('machine_id', $activity->machine_id)->orderBy('created_at', 'desc')->first();
                    $controlPlanConfig = ControlPlanConfig::where('machine_id', $activity->machine_id)->first();

                    $model = new ControlPlan;
                    $model->machine_id = $controlPlan->machine_id;
                    $model->control_plan_config_id = $controlPlan->control_plan_config_id;
                    $model->contract = $controlPlanConfig->contract;
                    $model->cost = $controlPlanConfig->cost;
                    $model->periodicity = $controlPlanConfig->periodicity;
                    $model->save();

                    $controlPlan->measurements->map(function($measurement) use($model){
                        $meas = new Measurement();
                        $meas->component_id = $measurement->component_id;
                        $meas->measurement_config_id = $measurement->measurement_config_id;
                        $meas->position = $measurement->position;
                        $meas->control_plan_id = $model->getKey();
                        $meas->save();
                    });

                    $activity->activitable_id = $model->getKey();
                    $activity->activitable_type = 'App\Models\ControlPlan';
                    $activity->save();
                }
                break;
        }



    }

    /**
     * Handle the Activity "updated" event.
     *
     * @param  \App\Models\Activity  $activity
     * @return void
     */
    public function updated(Activity $activity)
    {
        //
    }

    /**
     * Handle the Activity "deleted" event.
     *
     * @param  \App\Models\Activity  $activity
     * @return void
     */
    public function deleted(Activity $activity)
    {
        //
    }

    /**
     * Handle the Activity "restored" event.
     *
     * @param  \App\Models\Activity  $activity
     * @return void
     */
    public function restored(Activity $activity)
    {
        //
    }

    /**
     * Handle the Activity "force deleted" event.
     *
     * @param  \App\Models\Activity  $activity
     * @return void
     */
    public function forceDeleted(Activity $activity)
    {
        //
    }
}
