<?php

namespace App\Observers;

use App\Models\Component;
use App\Models\ControlPlan;
use App\Models\Measurement;
use App\Models\MeasurementConfig;
use App\Models\ControlPlanConfig;

class ComponentObserver
{
    /**
     * Handle the Component "created" event.
     *
     * @param  \App\Models\Component  $component
     * @return void
     */
    public function created(Component $component)
    {
        $controlPlanConfig = ControlPlanConfig::where('machine_id', $component->machine_id)->first();
        if($controlPlanConfig) {
            $id = $component->id;
            $components =  $component->machine->components;
            $index = $components->search(function($compo) use ($id){
                return $compo->id == $id;
            });

            $controlPlan = ControlPlan::where('control_plan_config_id', $controlPlanConfig->id)
                ->latest()->first();

            for($i=0; $i < $component->vibrations; $i++){

                $position = $i + 1;

                $config = new MeasurementConfig;
                $config->component_id = $component->id;
                $config->control_plan_config_id = $controlPlanConfig->id;
                $config->position = "C{$index}-B{$position}";
                $config->save();

                $measurement = new Measurement;
                $measurement->component_id = $component->id;
                $measurement->measurement_config_id = $config->id;
                $measurement->position = "C{$index}-B{$position}";
                $measurement->control_plan_id = $controlPlan->id;
            }

            $pos = $component->temperature + $component->pressure + $component->payload;
            for($i = 0; $i < $pos; $i++){
                $position = $i + 1;
                $config = new MeasurementConfig;
                $config->component_id = $component->id;
                $config->control_plan_config_id = $controlPlanConfig->id;
                $config->position = "C{$index}-P{$position}";
                $config->save();

                $measurement = new Measurement;
                $measurement->component_id = $component->id;
                $measurement->measurement_config_id = $config->id;
                $measurement->position = "C{$index}-P{$position}";
                $measurement->control_plan_id = $controlPlan->id;
            }
        }

    }

    /**
     * Handle the Component "updated" event.
     *
     * @param  \App\Models\Component  $component
     * @return void
     */
    public function updated(Component $component)
    {
        //
    }

    /**
     * Handle the Component "deleted" event.
     *
     * @param  \App\Models\Component  $component
     * @return void
     */
    public function deleted(Component $component)
    {
        //
    }

    /**
     * Handle the Component "restored" event.
     *
     * @param  \App\Models\Component  $component
     * @return void
     */
    public function restored(Component $component)
    {
        //
    }

    /**
     * Handle the Component "force deleted" event.
     *
     * @param  \App\Models\Component  $component
     * @return void
     */
    public function forceDeleted(Component $component)
    {
        //
    }
}
