<?php

namespace App\Nova;

use Akka\NovaDependencyContainer\NovaDependencyContainer;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Http\Requests\NovaRequest;

class MeasurementConfig extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\MeasurementConfig::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * Indicates if the resource should be displayed in the sidebar.
     *
     * @var bool
     */
    public static $displayInNavigation = false;

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),
            Boolean::make(__('Lubricant levels'),'lubricant_levels'),
            Boolean::make(__('Lubrican appearence'),'lubricant_appearence'),
            Boolean::make(__('Leakage'),'leakage'),
            Boolean::make(__('Temperature'),'temperature'),
            Number::make(__('Min'),'temperature_min'),
            Number::make(__('Max'),'temperature_max'),
            Boolean::make(__('Pressure'),'pressure'),
            Number::make(__('Min'),'pressure_min'),
            Number::make(__('Max'),'pressure_max'),
            Boolean::make(__('Vibration type SPM'),'vibrations_type_SPM'),
            Boolean::make(__('Vibration type SISM'),'vibrations_type_SISM'),
            BelongsTo::make('controlPlanConfig')->onlyOnDetail(),
            BelongsTo::make('component')->onlyOnDetail(),
            Image::make(__('Image'), 'image')
                ->disk('public')
                ->path('measurement_images')
                ->storeAs(function (Request $request) {
                    return ($request->image->getClientOriginalName());
                })
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
