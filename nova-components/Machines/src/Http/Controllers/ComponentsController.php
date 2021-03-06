<?php

namespace Akka\Machines\Http\Controllers;

use App\Models\Component;
use App\Models\MeasurementConfig;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Http\Requests\NovaRequest;

class ComponentsController
{
    public function index(NovaRequest $request, $resourceId)
    {

        $data = Component::where('machine_id', $resourceId)
            ->join("component_categories", "components.component_category_id", "=", "component_categories.id")
            ->join("component_sub_categories", "components.component_sub_category_id", "=", "component_sub_categories.id")
            ->select("components.*", "component_categories.name AS category", "component_sub_categories.name AS subcategory")
            ->get();


        return response()->json([
            'components' => $data
        ]);
    }

    public function config(NovaRequest $request, $resourceId)
    {

        $data = Component::where('machine_id', $resourceId)
            ->select("id", "name", "vibrations", "temperature", "pressure", "payload")
            ->get();


        return response()->json([
            'components' => $data
        ]);
    }

    public function attachments(NovaRequest $request, $resourceId)
    {

        $data = Component::find($resourceId);

        return response()->json([
            'attachments' => $data->attachments
        ]);
    }

    public function getConfig(NovaRequest $request, $componentId, $position)
    {

        $config = MeasurementConfig::where('component_id', $componentId)
            ->where('position', $position)
            ->first();

        return response()->json([
            'id' => $config->id
        ]);

    }
}
