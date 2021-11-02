<?php

namespace Akka\Calendar\Http\Controllers;

use App\Models\Activity;
use Laravel\Nova\Http\Requests\NovaRequest;

class EventController
{
    public function index(NovaRequest $request)
    {
            dd($request->query());

//        $activities = Activity::
    }
}
