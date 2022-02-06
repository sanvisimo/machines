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
use Illuminate\Support\Facades\Storage;
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

        $uploadedFile = $request->file('image');
        if($uploadedFile) {
            $input['image'] = $this->uploadFile($uploadedFile);
        }
        $config = MeasurementConfig::create($input);

        return response()->json([
            'id' => $config->getKey(),
            'resource' => $config->attributesToArray(),
        ], 201);
    }

    /**
     * Create a new resource.
     *
     * @param  \Laravel\Nova\Http\Requests\CreateResourceRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createControlPlan(CreateResourceRequest $request)
    {

        $controlPlan = new ControlPlan();

        $input = $request->all();
        unset($input['machine']);
        unset($input['machine_trashed']);
        if(!$input['contract']){
            $input['contract'] = false;
        }

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
    public function updateControlPlan(CreateResourceRequest $request, $controlPlanId)
    {

        $controlPlan = ControlPlan::findOrFail($controlPlanId);

        $input = $request->all();
        unset($input['machine']);
        unset($input['machine_trashed']);
        if(!$input['contract']){
            $input['contract'] = false;
        }
        $components = json_decode($request->input('components'));
        unset($input['components']);

        $controlPlan->fill($input);
        $controlPlan->save();

        foreach ($components as $component) {
            $meas = Measurement::findOrFail($component->id);
            $meas->fill(json_decode(json_encode($component), true));
            $meas->save();
        }

        return response()->json([
            'id' => $controlPlan->getKey(),
            'resource' => $controlPlan->attributesToArray(),
        ], 201);
    }

    /**
     * Create a new resource.
     *
     * @param  \Laravel\Nova\Http\Requests\CreateResourceRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createControlPlanConfig(CreateResourceRequest $request)
    {

        $controlPlan = new ControlPlanConfig();

        $input = $request->only($controlPlan->getFillable());

        $errors = [];
        if(empty($input['cost'])) {
            $errors['cost'] = [ __("The field is required") ];
        }
        if(empty($input['start_date'])) {
            $errors['start_date'] = [ __("The field is required.") ];
        }
        if(empty($input['periodicity'])) {
            $errors['periodicity'] = [ __("The field is required.") ];
        }

        if(!empty($errors)){
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $errors,
            ], 422);
        }

        $input['machine_id'] = $request->input('machine');

        $controlPlan->fill($input);
        $controlPlan->save();
        $components = json_decode($request->input('components'));
        foreach ($components as $component) {
            $meas = new MeasurementConfig();
            $meas->fill(json_decode(json_encode($component), true));
            $meas->control_plan_config_id = $controlPlan->getKey();
            $meas->save();
        }

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

        $input = $request->only($controlPlan->getFillable());

        $errors = [];
        if(empty($input['cost'])) {
            $errors['cost'] = [ __("The field is required") ];
        }
        if(empty($input['start_date'])) {
            $errors['start_date'] = [ __("The field is required.") ];
        }
        if(empty($input['periodicity'])) {
            $errors['periodicity'] = [ __("The field is required.") ];
        }

        if(!empty($errors)){
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $errors,
            ], 422);
        }

        $controlPlan->fill($input);
        $controlPlan->save();

        $components = json_decode($request->input('components'));
        $comps = [];
        foreach ($components as $component) {
            $meas = MeasurementConfig::findOrFail($component->id);
            $meas->fill(json_decode(json_encode($component), true));
            $uploadedFile = $request->file('image-'.$component->position);

            if($uploadedFile) {
              $meas->image = $this->uploadFile($uploadedFile);
            }
            $comps[] = $meas;
            $meas->save();
        }

        return response()->json([
            'id' => $controlPlan->getKey(),
            'resource' => $controlPlan->attributesToArray(),
            'components' => $comps
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

        $uploadedFile = $request->file('image');

        if($uploadedFile) {
            $input['image'] = $this->uploadFile($uploadedFile);
        }

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

    protected function uploadFile($uploadedFile)
    {
        $filename = $uploadedFile->getClientOriginalName();

        Storage::disk('public')->putFileAs(
            'measurement_images',
            $uploadedFile,
            $filename
        );

        return 'measurement_images/'.$filename;
    }
}
