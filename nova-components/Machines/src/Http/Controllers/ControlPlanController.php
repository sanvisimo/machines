<?php

namespace Akka\Machines\Http\Controllers;

use App\Models\ControlPlanConfig;
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
}
