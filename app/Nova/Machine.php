<?php

namespace App\Nova;

use Akka\ControlPlanField\ControlPlanField;
use Akka\Machines\Machines;
use Akka\Machines\ControlPlan;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Akka\Nova\APanels;

class Machine extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Machine::class;

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return __('Machines');
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return __('Machine');
    }

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'name'
    ];

    public static $group = 'Admin';

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [

//            ID::make(__('ID'), 'id')->sortable()->size('w-1/4')->stacked(false),
//            Text::make(__('Name'), 'name')
//                ->sortable()
//                ->rules('required', 'max:255')->size('w-1/2')->stacked(false),
//            HasMany::make(__('Components'), 'components', 'App\Nova\Component'),
//            HasMany::make(__('Activities'), 'activities', 'App\Nova\Activity'),


//            (new Panel('Info', [Text::make('Name')
//                ->sortable()
//                ->rules('required', 'max:255'),
//            ]))->withToolbar(),

            (new APanels($this->title(), [
                [

                    new Panel('Profile', [
                        ID::make(__('ID'), 'id')->sortable(),
                        Text::make(__('Name'), 'name')
                            ->sortable()
                            ->rules('required', 'max:255'),
                        Select::make('state')->options([
                            'active' => __('Active'),
                            'suspended' => __('Suspended'),
                            'not_operative' => __('Not Operative'),
                        ])->size('w-1/2')->stacked(false),
                    ]),
                    (new Panel ("Accordion", [
                        ID::make(__('ID'), 'id')->sortable(),
                        Text::make(__('Name'), 'name'),
                        Number::make(__('Power'), 'power'),
                    ]))->withComponent('akka-accordion'),

                    HasMany::make(__('Activities'), 'lastActivities', Activity::class),

                    Machines::make(),
                ],
                [
                    HasMany::make(__('New Activities'), 'newActivities', Activity::class),

                    HasMany::make(__('Old Activities'), 'oldActivities', Activity::class),
                ],
                [

                    ControlPlan::make(__('Control Plan')),

                    HasOne::make(__('Control Plan'), 'controlPlanConfig', ControlPlanConfig::class),
                    HasMany::make(__('Control Plans'), 'controlPlans')->hideFromDetail(function() {
                        return $this->controlPlanConfig === null;
                    })
                ]
            ]))->withToolbar(),
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
