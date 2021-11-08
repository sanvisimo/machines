<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Currency;
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
            Date::make(__('Start Date'), 'start_date')->default(true)->required()->size('w-1/3')->stacked(false),
            Number::make(__('Periodicity'), 'periodicity')->default(true)->required()->size('w-1/3')->stacked(false),
            Currency::make(__('Cost'), 'cost')->currency('EUR')->required()->size('w-1/3')->stacked(false),
            Boolean::make(__('Contract'), 'contract')->default(true)->size('w-1/3')->stacked(false),
            Boolean::make(__('Global Condition'), 'global_conditions')->default(true)->readonly(true)->size('w-1/3')->stacked(false),
            Boolean::make(__('Machine status'), 'machine_status')->default(true)->readonly(true)->size('w-1/3')->stacked(false),
            Boolean::make(__('Casing integrity check'), 'casing_integrity_check')->default(true)->readonly(true)->size('w-1/3')->stacked(false),
            Boolean::make(__('Nameplate integrity'), 'nameplate_integrity')->default(true)->readonly(true)->size('w-1/3')->stacked(false),
            Boolean::make(__('RPM'), 'rpm')->default(true)->readonly(true)->size('w-1/3')->stacked(false),
            Boolean::make(__('Check pressure gauges'), 'check_pressure_gauges')->size('w-1/3')->stacked(false),
            Boolean::make(__('Check sight glasses oil'), 'check_sight_glasses_oil')->size('w-1/3')->stacked(false),
            Boolean::make(__('Check sight glasses water'), 'check_sight_glasses_water')->size('w-1/3')->stacked(false),
            Boolean::make(__('Check thermometers'), 'check_thermometers')->size('w-1/3')->stacked(false),
            Boolean::make(__('Electric absorption'), 'electric_absorption')->size('w-1/3')->stacked(false),
            Boolean::make(__('Check cleaning protective grid'), 'check_cleaning_protective_grid')->size('w-1/3')->stacked(false),
            Boolean::make(__('Check cleaning junction box'), 'check_cleaning_junction_box')->size('w-1/3')->stacked(false),
            Boolean::make(__('Check integrity flexible electric'), 'check_integrity_flexible_electric')->size('w-1/3')->stacked(false),
            Boolean::make(__('Check ground connections'), 'check_ground_connections')->size('w-1/3')->stacked(false),
            Boolean::make(__('Thermography'), 'thermography')->size('w-1/3')->stacked(false),
            Boolean::make(__('Laser alignment'), 'laser_alignment')->size('w-1/3')->stacked(false),
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
