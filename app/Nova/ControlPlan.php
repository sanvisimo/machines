<?php

namespace App\Nova;

use Akka\ButtonGroup\ButtonGroup;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class ControlPlan extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\ControlPlan::class;

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
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        $controlPlanConfig = \App\Models\ControlPlanConfig::where('machine_id', $request->viaResourceId)->first();

        return [
            ID::make(__('ID'), 'id')->sortable(),
            BelongsTo::make(__('Machine'), 'machine', Machine::class)->hideWhenUpdating(),

            ButtonGroup::make(__('Contract'),'contract')->default(1)
                ->options([
                    0 => __('NO'),
                    1 => __('YES'),
                ]),
            Currency::make(__('Cost'), 'cost')->hideWhenUpdating(),
            Number::make(__('Periodicity'),'periodicity')->size('w-2/3')->stacked(false)->hideWhenUpdating(),
            Text::make(__('Note'),'periodicity_note')->nullable()->size('w-1/3')->stacked(false)->hideWhenUpdating(),
            ButtonGroup::make(__('Global condition'),'global_conditions')->options([
                'good' => __('Good'),
                'attention' => __('Attention'),
                'intervent' => __('Intervent'),
            ])->nullable(),
            ButtonGroup::make(__('Machine status'),'machine_status')->options([
                'run' => __('Run'),
                'stop' => __('Stop'),
                'maintenance' => __('Maintenance')
            ])->nullable(),
            ButtonGroup::make(__('Casing integrity check'),'casing_integrity_check')->nullable()->size('w-2/3')->stacked(false),
            Text::make(__('Note'),'casing_integrity_check_notes')->nullable()->size('w-1/3')->stacked(false),
            ButtonGroup::make(__('Nameplate integrity'),'nameplate_integrity')->nullable()->size('w-2/3')->stacked(false),
            Text::make(__('Note'),'nameplate_integrity_notes')->nullable()->size('w-1/3')->stacked(false),
            Number::make(__('RPM'),'rpm')->nullable(),
            ButtonGroup::make(__('Check pressure gauges'),'check_pressure_gauges')->nullable()
                ->showOnUpdating(function() use ($controlPlanConfig) {
                    return $controlPlanConfig ? $controlPlanConfig->check_pressure_gauges : false;
                })->size('w-2/3')->stacked(false),
            Text::make(__('Note'),'check_pressure_gauges_notes')->nullable()
                ->showOnUpdating(function() use ($controlPlanConfig) {
                    return $controlPlanConfig ? $controlPlanConfig->check_pressure_gauges : false;
                })->size('w-1/3')->stacked(false),
            ButtonGroup::make(__('Check sight glasses oil'),'check_sight_glasses_oil')->nullable()
                ->showOnUpdating(function() use ($controlPlanConfig) {
                    return $controlPlanConfig ? $controlPlanConfig->check_sight_glasses_oil : false;
                })->size('w-2/3')->stacked(false),
            Text::make(__('Note'),'check_sight_glasses_oil_notes')->nullable()
                ->showOnUpdating(function() use ($controlPlanConfig) {
                    return $controlPlanConfig ? $controlPlanConfig->check_sight_glasses_oil : false;
                })->size('w-1/3')->stacked(false),
            ButtonGroup::make(__('Check sight glasses water'),'check_sight_glasses_water')->nullable()
                ->showOnUpdating(function() use ($controlPlanConfig) {
                    return $controlPlanConfig ? $controlPlanConfig->check_sight_glasses_water : false;
                })->size('w-2/3')->stacked(false),
            Text::make(__('Note'),'check_sight_glasses_water_notes')->nullable()
                ->showOnUpdating(function() use ($controlPlanConfig) {
                    return $controlPlanConfig ? $controlPlanConfig->check_sight_glasses_water : false;
                })->size('w-1/3')->stacked(false),
            ButtonGroup::make(__('Check thermometers'),'check_thermometers')->nullable()
                ->showOnUpdating(function() use ($controlPlanConfig) {
                    return $controlPlanConfig ? $controlPlanConfig->check_thermometers : false;
                })->size('w-2/3')->stacked(false),
            Text::make(__('Note'),'check_thermometers_notes')->nullable()
                ->showOnUpdating(function() use ($controlPlanConfig) {
                    return $controlPlanConfig ? $controlPlanConfig->check_thermometers : false;
                })->size('w-1/3')->stacked(false),
            Number::make(__('Electric absorption'),'electric_absorption')->nullable()
                ->showOnUpdating(function() use ($controlPlanConfig) {
                    return $controlPlanConfig ? $controlPlanConfig->electric_absorption : false;
                })->size('w-2/3')->stacked(false),
            Text::make(__('Note'),'electric_absorption_notes')->nullable()
                ->showOnUpdating(function() use ($controlPlanConfig) {
                    return $controlPlanConfig ? $controlPlanConfig->electric_absorption : false;
                })->size('w-1/3')->stacked(false),
            ButtonGroup::make(__('Check cleaning protective grid'),'check_cleaning_protective_grid')->nullable()
                ->showOnUpdating(function() use ($controlPlanConfig) {
                    return $controlPlanConfig ? $controlPlanConfig->check_cleaning_protective_grid : false;
                })->size('w-2/3')->stacked(false),
            Text::make(__('Note'),'check_cleaning_protective_grid_notes')->nullable()
                ->showOnUpdating(function() use ($controlPlanConfig) {
                    return $controlPlanConfig ? $controlPlanConfig->check_cleaning_protective_grid : false;
                })->size('w-1/3')->stacked(false),
            ButtonGroup::make(__('Check cleaning junction box'),'check_cleaning_junction_box')->nullable()
                ->showOnUpdating(function() use ($controlPlanConfig) {
                    return $controlPlanConfig ? $controlPlanConfig->check_cleaning_junction_box : false;
                })->size('w-2/3')->stacked(false),
            Text::make(__('Note'),'check_cleaning_junction_box_notes')->nullable()
                ->showOnUpdating(function() use ($controlPlanConfig) {
                    return $controlPlanConfig ? $controlPlanConfig->check_cleaning_junction_box : false;
                })->size('w-1/3')->stacked(false),
            ButtonGroup::make(__('Check integrity flexible electric'),'check_integrity_flexible_electric')->nullable()
                ->showOnUpdating(function() use ($controlPlanConfig) {
                    return $controlPlanConfig ? $controlPlanConfig->check_integrity_flexible_electric : false;
                })->size('w-2/3')->stacked(false),
            Text::make(__('Note'),'check_integrity_flexible_electric_notes')->nullable()
                ->showOnUpdating(function() use ($controlPlanConfig) {
                    return $controlPlanConfig ? $controlPlanConfig->check_integrity_flexible_electric : false;
                })->size('w-1/3')->stacked(false),
            ButtonGroup::make(__('Check ground connections'),'check_ground_connections')->nullable()
                ->showOnUpdating(function() use ($controlPlanConfig) {
                    return $controlPlanConfig ? $controlPlanConfig->check_ground_connections : false;
                })->size('w-2/3')->stacked(false),
            Text::make(__('Note'),'check_ground_connections_notes')->nullable()
                ->showOnUpdating(function() use ($controlPlanConfig) {
                    return $controlPlanConfig ? $controlPlanConfig->check_ground_connections : false;
                })->size('w-1/3')->stacked(false),
            Text::make(__('Thermography'),'thermography')->nullable()
                ->showOnUpdating(function() use ($controlPlanConfig) {
                    return $controlPlanConfig ? $controlPlanConfig->thermography : false;
                })->size('w-2/3')->stacked(false),
            File::make(__('Note'),'thermography_documentation')->nullable()
                ->showOnUpdating(function() use ($controlPlanConfig) {
                    return $controlPlanConfig ? $controlPlanConfig->thermography : false;
                })->size('w-1/3')->stacked(false),
            Text::make(__('Laser Alignment'),'laser_alignment')->nullable()
                ->showOnUpdating(function() use ($controlPlanConfig) {
                    return $controlPlanConfig ? $controlPlanConfig->laser_alignment : false;
                })->size('w-2/3')->stacked(false),
            File::make(__('Note'),'laser_alignment_documentation')->nullable()
                ->showOnUpdating(function() use ($controlPlanConfig) {
                    return $controlPlanConfig ? $controlPlanConfig->laser_alignment : false;
                })->size('w-1/3')->stacked(false),
        ];
    }

    /**
     * Indicates if the resource should be displayed in the sidebar.
     *
     * @var bool
     */
    public static $displayInNavigation = false;

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
