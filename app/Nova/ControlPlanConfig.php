<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;

class ControlPlanConfig extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\ControlPlanConfig::class;

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
            BelongsTo::make(__('Machine'), 'machine', Machine::class),
            Boolean::make('contract')->default(true)->readonly(true)->size('w-1/2'),
            Boolean::make('cost')->default(true)->readonly(true)->size('w-1/2'),
            Boolean::make('periodicity')->default(true)->readonly(true)->size('w-1/2'),
            Boolean::make('global_conditions')->default(true)->readonly(true)->size('w-1/2'),
            Boolean::make('machine_status')->default(true)->readonly(true)->size('w-1/2'),
            Boolean::make('casing_integrity_check')->default(true)->readonly(true)->size('w-1/2'),
            Boolean::make('nameplate_integrity')->default(true)->readonly(true)->size('w-1/2'),
            Boolean::make('rpm')->default(true)->readonly(true)->size('w-1/2'),
            Boolean::make('check_pressure_gauges')->size('w-1/2'),
            Boolean::make(__('Check sight glasses oil'), 'check_sight_glasses_oil')->size('w-1/2'),
            Boolean::make('check_sight_glasses_water')->size('w-1/2'),
            Boolean::make('check_thermometers')->size('w-1/2'),
            Boolean::make('electric_absorption')->size('w-1/2'),
            Boolean::make('check_cleaning_protective_grid')->size('w-1/2'),
            Boolean::make('check_cleaning_junction_box')->size('w-1/2'),
            Boolean::make('check_integrity_flexible_electric')->size('w-1/2'),
            Boolean::make('check_ground_connections')->size('w-1/2'),
            Boolean::make('check_ground_connections_notes')->size('w-1/2'),
            Boolean::make('thermography')->size('w-1/2'),
            Boolean::make('laser_alignment')->size('w-1/2'),
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
