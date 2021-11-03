<?php

namespace Akka\Nova\Http\Controllers;

use App\Models\Machine;
use Illuminate\Database\Query\Builder;
use Laravel\Nova\Http\Requests\NovaRequest;

class MachinesController
{
    /**
     * @param NovaRequest $request
     * @param $resourceId
     * @return \Illuminate\Http\JsonResponse
     */
    public function duplicate(NovaRequest $request, $resourceId)
    {

        $machine = Machine::find($resourceId);
        $new_machine = $machine->replicate();
        $new_machine->save();

        return response()->json([
            'machine' => $new_machine
        ]);
    }

}
