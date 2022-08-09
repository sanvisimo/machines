<?php

namespace App\Observers;

use App\Models\Activity;
use App\Models\ControlPlan;
use App\Models\ControlPlanConfig;
use App\Models\Measurement;
use App\Models\Anomaly;
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


      $fields = ['casing_integrity_check',
      'nameplate_integrity',
      'check_pressure_gauges',
      'check_sight_glasses_oil',
      'check_sight_glasses_water',
      'check_thermometers',
      'check_cleaning_protective_grid',
      'check_cleaning_junction_box',
      'check_integrity_flexible_electric',
      'check_ground_connections'];

        $anomaly = Anomaly::where('machine_id', $controlPlan->machine_id)
          ->where('field', 'global_conditions')
          ->where('solved', 0)
          ->first();
        if($controlPlan->global_conditions !== 'good'){
          if(!$anomaly) {
            $anomaly = new Anomaly();
            $anomaly->machine_id = $controlPlan->machine_id;
            $anomaly->control_plan_id = $controlPlan->id;
            $anomaly->field = 'global_conditions';
            $anomaly->value = $controlPlan->global_conditions;
            $anomaly->save();
          }
        } else {
          if($anomaly) {
            $anomaly->solved = true;
            $anomaly->save();
          }
        }

      foreach ($fields as $field){
        $anomaly = Anomaly::where('machine_id', $controlPlan->machine_id)
          ->where('field', $field)
          ->where('solved', 0)
          ->first();
          if(!$controlPlan->$field && $controlPlanConfig->$field) {
            if(!$anomaly) {
              $anomaly = new Anomaly();
              $anomaly->machine_id = $controlPlan->machine_id;
              $anomaly->control_plan_id = $controlPlan->id;
              $anomaly->field = $field;
              $anomaly->value = 'intervento';
              $anomaly->save();
            }
          } else {
            if($anomaly) {
              $anomaly->solved = true;
              $anomaly->save();
            }
          }
        }

        if($oldActivity->active && $oldActivity->type === 'control_plan') {
            $oldActivity->expiration = Carbon::now();
            $oldActivity->active = false;
            $oldActivity->save();
            $model = $controlPlan->replicate();
            $model->global_conditions = null;
            $model->machine_status = null;
            $model->created_at = Carbon::now();
            $model->updated_at = Carbon::now();
            $model->save();

            $controlPlan->measurements->map(function($measurement) use($model){
                $meas = new Measurement();
                $meas->component_id = $measurement->component_id;
                $meas->measurement_config_id = $measurement->measurement_config_id;
                $meas->position = $measurement->position;
                $meas->control_plan_id = $model->getKey();
                $meas->save();
            });

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
