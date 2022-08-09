<?php

namespace App\Nova;

use Akka\ButtonGroup\ButtonGroup;
use Akka\NovaDependencyContainer\NovaDependencyContainer;
use Carbon\Carbon;
use Google\Service\HangoutsChat\Button;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphOne;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;

class Maintenance extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Maintenance::class;

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
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return __('Maintenances');
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return __('Maintenance');
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
        $controlPlan = \App\Models\ControlPlan::where('machine_id', $resource->model()->machine->id)
          ->orderBy('id', 'DESC')->first();
        return '/resources/'. ControlPlan::uriKey().'/'.$controlPlan->id;
    }


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
            Text::make(__('Work Permit'),'work_permit')->rules('required'),
            BelongsTo::make(__('Component'), 'component', Component::class)->readonly(),
//            BelongsTo::make(__('Activity'), 'activity', 'App\Nova\Activity'),
            MorphOne::make('Activity'),
            Select::make(__('Type'), 'type')
                ->options([
                    'maintenance' => __('Ordinary Maintenance'),
                    'maintenance_no' => __('Extraordinary Maintenance')
                ])
                ->nullable()
                ->default('maintenance_no')
                ->readonly(function() {
                    return $this->resource->exists;
                }),
            DateTime::make(__('Opening Date'), 'opening_date')->nullable()->default(Carbon::now()),
            NovaDependencyContainer::make([
                Number::make(__('Periodicity'), 'periodicity')
                    ->rules('min:1')
                    ->withMeta(['extraAttributes' => ['min' => 0]])
            ])
                ->dependsOn('type', 'maintenance')
                ->hideWhenUpdating(),
            DateTime::make(__('Onsite intervention'), 'onsite_intervention')->rules('required'),
            DateTime::make(__('Closed on'), 'closed_on')->nullable(),
            Number::make(__('Duration'), 'duration')->nullable(),
            Currency::make(__('Indicative cost'), 'indicative_cost')->nullable(),

//            $table->string('drawing')->nullable();
            Text::make(__('Position'), 'position')->nullable(),
            Boolean::make(__('Extra fee'), 'extra_fee')->nullable(),
            Textarea::make(__('Task notes'), 'task_notes')->nullable(),
            Textarea::make(__('Internal notes'), 'internal_notes')->nullable(),
//            BelongsTo::make(__('Machine'), 'machine', Machine::class)->onlyOnIndex(),
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
