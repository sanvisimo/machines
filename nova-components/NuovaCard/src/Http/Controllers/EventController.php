<?php

namespace Akka\Agenda\Http\Controllers;

use App\Models\Activity;
use Illuminate\Support\Carbon;
use Laravel\Nova\Http\Requests\NovaRequest;

class EventController
{
    public function index(NovaRequest $request)
    {

        $start = date($request->get('start'));
        $end = date($request->get('end'));

        $query = Activity::whereBetween('expiration', [$start, $end]);
        if($request->user()->hasPermissionTo('view customers') && !$request->user()->hasPermissionTo('view any customers')) {
            $query->whereHas('machine', function ($query) use ($request) {
                $query->whereHas('plant', function ($query) use ($request) {
                    $query->whereHas('establishment', function ($query) use ($request) {
                        $query->whereHas('customer', function ($query) use ($request) {
                            $query->whereHas('manutentors', function ($query) use ($request) {
                                $query->whereIn('user_id', [$request->user()->id]);
                            });
                        });
                    });
                });
            });
        }
          $activities = $query->get();

        $events = $activities->map(function ($item) {
           $item['title'] = $item['description'];
           $item['start'] = Carbon::instance($item['expiration'])->format("Y-m-d");

           $color = "";
           if($item['active']) {
               if (Carbon::now()->gt($item['expiration'])) {
                   $color = "#dc2626";
               }

               if (Carbon::now()->addDays(5)->gte($item['expiration'])) {
                   $color = "#f59e0b";
               }
           }

           $item['color'] = $color;
           return $item;
        });



        return response()->json($events);
    }
}
