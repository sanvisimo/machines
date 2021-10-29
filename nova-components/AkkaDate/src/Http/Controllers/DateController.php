<?php

namespace Akka\AkkaDate\Http\Controllers;


use App\MOdels\Activity;
use Laravel\Nova\Http\Requests\NovaRequest;

class DateController
{
    public function index(NovaRequest $request, $resourceId, $resourceName)
    {


        $data = Activity::find($resourceId);


        return response()->json([
            'resource' => $data
        ]);
    }
}
