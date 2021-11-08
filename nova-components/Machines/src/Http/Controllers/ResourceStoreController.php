<?php

namespace Akka\Machines\Http\Controllers;

use App\Models\ControlPlan;
use App\Models\ControlPlanConfig;
use App\Models\Measurement;
use App\Models\MeasurementConfig;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Laravel\Nova\Http\Requests\CreateResourceRequest;
use Laravel\Nova\Nova;

class ResourceStoreController extends Controller
{
    /**
     * Create a new resource.
     *
     * @param  \Laravel\Nova\Http\Requests\CreateResourceRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle(CreateResourceRequest $request)
    {

        $input = $request->all();

        $config = MeasurementConfig::create($input);

        return response()->json([
            'id' => $config->getKey(),
            'resource' => $config->attributesToArray(),
        ], 201);
    }

    /**
     * Update a new resource.
     *
     * @param  \Laravel\Nova\Http\Requests\CreateResourceRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateControlPlan(CreateResourceRequest $request, $controlPlanId)
    {

        $controlPlan = ControlPlan::findOrFail($controlPlanId);

        $input = $request->all();
        unset($input['machine']);
        unset($input['machine_trashed']);

        $controlPlan->fill($input);
        $controlPlan->save();

        return response()->json([
            'id' => $controlPlan->getKey(),
            'resource' => $controlPlan->attributesToArray(),
        ], 201);
    }

    /**
     * Update a new resource.
     *
     * @param  \Laravel\Nova\Http\Requests\CreateResourceRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateControlPlanConfig(CreateResourceRequest $request, $controlPlanId)
    {

        $controlPlan = ControlPlanConfig::findOrFail($controlPlanId);

        $input = $request->all();
        unset($input['machine']);
        unset($input['machine_trashed']);
        unset($input['viaResource']);
        unset($input['viaResourceId']);
        unset($input['viaRelationship']);
        unset($input['editing']);
        unset($input['editMode']);

        $controlPlan->fill($input);
        $controlPlan->save();

        return response()->json([
            'id' => $controlPlan->getKey(),
            'resource' => $controlPlan->attributesToArray(),
        ], 201);
    }

    /**
     * Update a new resource.
     *
     * @param  \Laravel\Nova\Http\Requests\CreateResourceRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateComponentConfig(CreateResourceRequest $request, $id)
    {

        $controlPlan = MeasurementConfig::findOrFail($id);

        $input = $request->all();
        unset($input['machine']);
        unset($input['machine_trashed']);

        $controlPlan->fill($input);
        $controlPlan->save();

        return response()->json([
            'id' => $controlPlan->getKey(),
            'resource' => $controlPlan->attributesToArray(),
        ], 201);
    }

    /**
     * Update a new resource.
     *
     * @param  \Laravel\Nova\Http\Requests\CreateResourceRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateComponent(CreateResourceRequest $request, $measurementId)
    {

        $measurement = Measurement::find($measurementId);

        $input = $request->all();

        $measurement->fill($input);
        $measurement->save();

        return response()->json([
            'id' => $measurement->getKey(),
            'resource' => $measurement->attributesToArray(),
        ], 201);
    }

    /**
     * Save the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\CreateResourceRequest  $request
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    protected function storeResource(CreateResourceRequest $request, Model $model)
    {
        if (! $request->viaRelationship()) {
            $model->save();

            return;
        }

        $relation = tap($request->findParentResourceOrFail(), function ($resource) use ($request) {
            abort_unless($resource->hasRelatableField($request, $request->viaRelationship), 404);
        })->model()->{$request->viaRelationship}();

        if ($relation instanceof HasManyThrough) {
            $model->save();

            return;
        }

        $relation->save($model);
    }
}
