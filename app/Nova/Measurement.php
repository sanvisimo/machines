<?php

namespace App\Nova;

use Akka\ButtonGroup\ButtonGroup;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Measurement extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Measurement::class;

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
        $measurementConfig = \App\Models\MeasurementConfig::where('component_id', $request->viaResourceId)
            ->where('position', $request->position)
            ->first();

        return [
            ID::make(__('ID'), 'id')->sortable(),
            ButtonGroup::make(__('Anomaly'), 'anomaly')->size('w-2/3')->stacked(false),
            Text::make(__(''), 'anomaly_notes')->nullable()->size('w-1/3')->stacked(false),
            ButtonGroup::make(__('Lubricant appearence'), 'lubricant_appearence')
                ->options([
                    'low' => __('Low'),
                    'medium' => __('Medium'),
                    'high' => __('High')
                ])
                ->showOnUpdating(function() use ($measurementConfig) {
                    return $measurementConfig ? $measurementConfig->lubricant_levels : false;
                })->size('w-2/3')->stacked(false),
            Text::make(__(''),'lubricant_levels_notes')->nullable()
                ->showOnUpdating(function() use ($measurementConfig) {
                    return $measurementConfig ? $measurementConfig->lubricant_levels : false;
                })->size('w-1/3')->stacked(false),
            ButtonGroup::make(__('Lubricant appearence'), 'lubricant_appearence')
                ->options([
                    'clear' => __('Clear'),
                    'turbid' => __('Turbid'),
                    'dark' => __('Dark')
                ])
                ->showOnUpdating(function() use ($measurementConfig) {
                    return $measurementConfig ? $measurementConfig->lubricant_appearence : false;
                })->size('w-2/3')->stacked(false),
            Text::make(__(''),'lubricant_appearence_notes')->nullable()
                ->showOnUpdating(function() use ($measurementConfig) {
                    return $measurementConfig ? $measurementConfig->lubricant_appearence : false;
                })->size('w-1/3')->stacked(false),
            ButtonGroup::make(__('Leakage'), 'leakage')
                ->showOnUpdating(function() use ($measurementConfig) {
                    return $measurementConfig ? $measurementConfig->leakage : false;
                })->size('w-2/3')->stacked(false),
            Text::make(__(''),'leakage_notes')->nullable()
                ->showOnUpdating(function() use ($measurementConfig) {
                    return $measurementConfig ? $measurementConfig->leakage : false;
                })->size('w-1/3')->stacked(false),
            Number::make(static::temperatureLabel($measurementConfig), 'temperature')
                ->showOnUpdating(function() use ($measurementConfig) {
                    return $measurementConfig ? $measurementConfig->temperature : false;
                }),
            Number::make(static::pressureLabel($measurementConfig), 'pressure')
                ->showOnUpdating(function() use ($measurementConfig) {
                    return $measurementConfig ? $measurementConfig->pressure : false;
                }),
            Number::make(__('Vibration type SPM'), 'vibrations_type_SPM')
                ->showOnUpdating(function() use ($measurementConfig) {
                    return $measurementConfig ? $measurementConfig->vibrations_type_SPM : false;
                }),
            Number::make(__('Vibration type SISM 1'), 'vibrations_type_SISM_1')
                ->showOnUpdating(function() use ($measurementConfig) {
                    return $measurementConfig ? $measurementConfig->vibrations_type_SISM : false;
                }),
            Number::make(__('Vibration type SISM 2'), 'vibrations_type_SISM_2')
                ->showOnUpdating(function() use ($measurementConfig) {
                    return $measurementConfig ? $measurementConfig->vibrations_type_SISM : false;
                }),
            Number::make(__('Vibration type SISM 3'), 'vibrations_type_SISM_3')
                ->showOnUpdating(function() use ($measurementConfig) {
                    return $measurementConfig ? $measurementConfig->vibrations_type_SISM : false;
                }),
        ];
    }

    static function temperatureLabel($config) {
        return __('Temperature')." (min: ".$config->temperature_min." - max: ".$config->temperature_max.")";
    }
    static function pressureLabel($config) {
        return __('Temperature')." (min: ".$config->temperature_min." - max: ".$config->temperature_max.")";
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
