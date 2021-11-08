<?php

namespace Akka\Machines\Http\Controllers;

use App\Models\ControlPlanConfig;
use App\Models\ControlPlan;
use App\Models\Measurement;
use Laravel\Nova\Http\Requests\NovaRequest;

class ControlPlanController
{
    public function index(NovaRequest $request, $resourceId)
    {

        $data = ControlPlanConfig::where('machine_id', $resourceId)
            ->first();


        return response()->json([
            'controlPlan' => $data
        ]);
    }

    public function getControlPlan(NovaRequest $request, $machineId)
    {
        $controlPlan = ControlPlan::where('machine_id', $machineId)->latest()->first();

        return response()->json([
            'controlPlan' => $controlPlan
        ]);
    }

    public function editControlPlan(NovaRequest $request, $controlPlanId)
    {
        $controlPlan = ControlPlan::find($controlPlanId);

        return response()->json([
            'controlPlan' => $controlPlan
        ]);
    }

    public function getMeasurement(NovaRequest $request, $controlPlanId, $position)
    {
        $measurement = Measurement::where('control_plan_id', $controlPlanId)
            ->where('position', $position)
            ->latest()
            ->first();

        return response()->json([
            'measurement' => $measurement
        ]);
    }
}
