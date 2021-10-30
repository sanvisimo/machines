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

    public function getMeasurement(NovaRequest $request, $componentId, $position)
    {
        $measurement = Measurement::where('component_id', $componentId)
            ->where('position', $position)
            ->latest()
            ->first();

        return response()->json([
            'measurement' => $measurement
        ]);
    }
}
