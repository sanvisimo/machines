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
            ID::make(__('ID'), 'id')->sortable()->hideFromDetail(),
            BelongsTo::make(__('Machine'), 'machine', Machine::class)->hideWhenUpdating(),

            ButtonGroup::make(__('Contract'),'contract')->default(1)
                ->options([
                    false => __('NO'),
                    true => __('YES'),
                ])
                ->hideFromDetail()->size('w-1/2')->stacked(false),
            Currency::make(__('Cost'), 'cost')->hideWhenUpdating(),
            Number::make(__('Periodicity'),'periodicity')->size('w-2/3')->stacked(false)->hideWhenUpdating(),
            Text::make(__('Notes'),'periodicity_note')->nullable()->size('w-1/3')->stacked(false)->hideWhenUpdating(),
            ButtonGroup::make(__('global_condition'), 'global_conditions')->options([
                'good' => __('Good'),
                'attention' => __('Attention'),
                'intervent' => __('Intervent'),
            ])->rules('required', 'min:255')->size('w-1/2')->stacked(false),
            ButtonGroup::make(__('Machine status'),'machine_status')->options([
                'run' => __('Run'),
                'stop' => __('Stop'),
                'maintenance' => __('Maintenance')
            ])->rules('required')->size('w-1/2')->stacked(false),
            ButtonGroup::make(__('casing_integrity_check'),'casing_integrity_check')->nullable()->size('w-1/2')->stacked(false),
            ButtonGroup::make(__('nameplate_integrity'),'nameplate_integrity')->nullable()->size('w-1/2')->stacked(false),
//            Text::make(__('Notes'),'nameplate_integrity_notes')->nullable()->size('w-1/3')->stacked(false),
            Number::make(__('rpm'),'rpm')->nullable()->size('w-1/2')->stacked(false),
            ButtonGroup::make(__('check_pressure_gauges'),'check_pressure_gauges')->nullable()
                ->showOnUpdating(function() use ($controlPlanConfig) {
                    return $controlPlanConfig ? $controlPlanConfig->check_pressure_gauges : false;
                })->size('w-1/2')->stacked(false),
//            Text::make(__('Notes'),'check_pressure_gauges_notes')->nullable()
//                ->showOnUpdating(function() use ($controlPlanConfig) {
//                    return $controlPlanConfig ? $controlPlanConfig->check_pressure_gauges : false;
//                })->size('w-1/3')->stacked(false),
            ButtonGroup::make(__('check_sight_glasses_oil'),'check_sight_glasses_oil')->nullable()
                ->showOnUpdating(function() use ($controlPlanConfig) {
                    return $controlPlanConfig ? $controlPlanConfig->check_sight_glasses_oil : false;
                })->size('w-1/2')->stacked(false),
//            Text::make(__('Notes'),'check_sight_glasses_oil_notes')->nullable()
//                ->showOnUpdating(function() use ($controlPlanConfig) {
//                    return $controlPlanConfig ? $controlPlanConfig->check_sight_glasses_oil : false;
//                })->size('w-1/3')->stacked(false),
            ButtonGroup::make(__('check_sight_glasses_water'),'check_sight_glasses_water')->nullable()
                ->showOnUpdating(function() use ($controlPlanConfig) {
                    return $controlPlanConfig ? $controlPlanConfig->check_sight_glasses_water : false;
                })->size('w-1/2')->stacked(false),
//            Text::make(__('Notes'),'check_sight_glasses_water_notes')->nullable()
//                ->showOnUpdating(function() use ($controlPlanConfig) {
//                    return $controlPlanConfig ? $controlPlanConfig->check_sight_glasses_water : false;
//                })->size('w-1/3')->stacked(false),
            ButtonGroup::make(__('check_thermometers'),'check_thermometers')->nullable()
                ->showOnUpdating(function() use ($controlPlanConfig) {
                    return $controlPlanConfig ? $controlPlanConfig->check_thermometers : false;
                })->size('w-1/2')->stacked(false),
//            Text::make(__('Notes'),'check_thermometers_notes')->nullable()
//                ->showOnUpdating(function() use ($controlPlanConfig) {
//                    return $controlPlanConfig ? $controlPlanConfig->check_thermometers : false;
//                })->size('w-1/3')->stacked(false),
            Number::make(__('electric_absorption'),'electric_absorption')->nullable()
                ->showOnUpdating(function() use ($controlPlanConfig) {
                    return $controlPlanConfig ? $controlPlanConfig->electric_absorption : false;
                })->size('w-1/2')->stacked(false),
//            Text::make(__('Notes'),'electric_absorption_notes')->nullable()
//                ->showOnUpdating(function() use ($controlPlanConfig) {
//                    return $controlPlanConfig ? $controlPlanConfig->electric_absorption : false;
//                })->size('w-1/3')->stacked(false),
            ButtonGroup::make(__('check_cleaning_protective_grid'),'check_cleaning_protective_grid')->nullable()
                ->showOnUpdating(function() use ($controlPlanConfig) {
                    return $controlPlanConfig ? $controlPlanConfig->check_cleaning_protective_grid : false;
                })->size('w-1/2')->stacked(false),
//            Text::make(__('Notes'),'check_cleaning_protective_grid_notes')->nullable()
//                ->showOnUpdating(function() use ($controlPlanConfig) {
//                    return $controlPlanConfig ? $controlPlanConfig->check_cleaning_protective_grid : false;
//                })->size('w-1/3')->stacked(false),
            ButtonGroup::make(__('check_cleaning_junction_box'),'check_cleaning_junction_box')->nullable()
                ->showOnUpdating(function() use ($controlPlanConfig) {
                    return $controlPlanConfig ? $controlPlanConfig->check_cleaning_junction_box : false;
                })->size('w-1/2')->stacked(false),
//            Text::make(__('Notes'),'check_cleaning_junction_box_notes')->nullable()
//                ->showOnUpdating(function() use ($controlPlanConfig) {
//                    return $controlPlanConfig ? $controlPlanConfig->check_cleaning_junction_box : false;
//                })->size('w-1/3')->stacked(false),
            ButtonGroup::make(__('check_integrity_flexible_electric'),'check_integrity_flexible_electric')->nullable()
                ->showOnUpdating(function() use ($controlPlanConfig) {
                    return $controlPlanConfig ? $controlPlanConfig->check_integrity_flexible_electric : false;
                })->size('w-1/2')->stacked(false),
//            Text::make(__('Notes'),'check_integrity_flexible_electric_notes')->nullable()
//                ->showOnUpdating(function() use ($controlPlanConfig) {
//                    return $controlPlanConfig ? $controlPlanConfig->check_integrity_flexible_electric : false;
//                })->size('w-1/3')->stacked(false),
            ButtonGroup::make(__('check_ground_connections'),'check_ground_connections')->nullable()
                ->showOnUpdating(function() use ($controlPlanConfig) {
                    return $controlPlanConfig ? $controlPlanConfig->check_ground_connections : false;
                })->size('w-1/2')->stacked(false),
//            Text::make(__('Notes'),'check_ground_connections_notes')->nullable()
//                ->showOnUpdating(function() use ($controlPlanConfig) {
//                    return $controlPlanConfig ? $controlPlanConfig->check_ground_connections : false;
//                })->size('w-1/3')->stacked(false),
            Text::make(__('Thermography'),'thermography')->nullable()
                ->showOnUpdating(function() use ($controlPlanConfig) {
                    return $controlPlanConfig ? $controlPlanConfig->thermography : false;
                })->size('w-1/2')->stacked(false),
            File::make(__('Thermography'),'thermography_documentation')->nullable()
                ->showOnUpdating(function() use ($controlPlanConfig) {
                    return $controlPlanConfig ? $controlPlanConfig->thermography : false;
                })->size('w-1/2')->stacked(false)
                ->disk('public')
                ->storeAs(function (Request $request) {
                    return ($request->thermography_documentation->getClientOriginalName());
                })
                ->storeOriginalName('thermography_documentation_name')
                ->hideFromIndex(),
            Text::make(__('Laser Alignment'),'laser_alignment')->nullable()
                ->showOnUpdating(function() use ($controlPlanConfig) {
                    return $controlPlanConfig ? $controlPlanConfig->laser_alignment : false;
                })->size('w-2/3')->stacked(false),
            File::make(__('Laser Alignment'),'laser_alignment_documentation')->nullable()
                ->showOnUpdating(function() use ($controlPlanConfig) {
                    return $controlPlanConfig ? $controlPlanConfig->laser_alignment : false;
                })->size('w-1/3')->stacked(false)
                ->disk('public')
                ->storeAs(function (Request $request) {
                    return ($request->laser_alignment_documentation->getClientOriginalName());
                })
                ->storeOriginalName('attachment_name')
                ->hideFromIndex(),
            Text::make(__('Notes'),'casing_integrity_check_notes'),
            \Akka\Machines\ControlPlan::make(__('Control Plan')),
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

  /**
   * Return the location to redirect the user after update.
   *
   * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
   * @param  \Laravel\Nova\Resource  $resource
   * @return string
   */
  public static function redirectAfterUpdate(NovaRequest $request, $resource)
  {
    return '/resources/'. Machine::uriKey().'/'.$resource->model()->machine->id;
  }
}
