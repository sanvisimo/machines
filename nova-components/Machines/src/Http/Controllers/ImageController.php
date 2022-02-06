<?php

namespace Akka\Machines\Http\Controllers;

use App\Models\MeasurementConfig;
use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Http\Requests\NovaRequest;

class ImageController
{
  public function getImage(NovaRequest $request, $measurementId){

    $measurement = MeasurementConfig::findOrFail($measurementId);

    $url = $measurement->image ? Storage::disk('public')->url($measurement->image) : null;

    return response()->json([
      'image' => $url
    ], 201);
  }
}
