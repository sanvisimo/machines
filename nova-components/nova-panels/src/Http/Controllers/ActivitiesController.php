<?php

namespace Akka\Machines\Http\Controllers;

use Akka\Models\Activity;
use Illuminate\Database\Query\Builder;
use Laravel\Nova\Http\Requests\NovaRequest;

class ActivitiesController
{
    public function old(NovaRequest $request, $resourceId)
    {

        $data = Activity::where('machine_id', $resourceId)
            ->where('active', false)
            ->get();


        return response()->json([
            'activities' => $data
        ]);
    }

    public function new(NovaRequest $request, $resourceId)
    {

        $data = Activity::where('machine_id', $resourceId)
            ->where('active', true)
            ->get();


        return response()->json([
            'activities' => $data
        ]);
    }
}
