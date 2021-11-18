<?php

namespace Akka\Accordion\Http\Controllers;

use App\Models\Machine;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Http\Requests\NovaRequest;

class MachinesController
{
    public function attachments(NovaRequest $request, $resourceId)
    {

        $data = Machine::find($resourceId);

        return response()->json([
            'attachments' => $data->attachments
        ]);
    }


}
