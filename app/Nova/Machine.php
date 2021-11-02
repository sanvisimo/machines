<?php

namespace App\Nova;

use Akka\ControlPlanField\ControlPlanField;
use Akka\Machines\Machines;
use Akka\Machines\ControlPlan;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
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
                        Text::make(__('Manufacturer code'), 'manufacturer_code')
                            ->help(
                                __('Max 10')
                            )
                            ->withMeta(['extraAttributes' => ['maxlength' => 10]])
                            ->rules( 'max:10'),
                        Text::make(__('Manufacturer description'), 'manufacturer_description')
                            ->help(
                                __('Max 40')
                            )
                            ->withMeta(['extraAttributes' => ['maxlength' => 40]])
                            ->rules( 'max:40'),
                        Text::make(__('Type'), 'type'),
                        Text::make(__('Serial number'), 'serial_number')
                            ->help(
                                __('Max 20')
                            )
                            ->withMeta(['extraAttributes' => ['maxlength' => 20]])
                            ->rules( 'max:20'),
                        Text::make(__('Revision'), 'revision')
                            ->help(
                                __('Max 5')
                            )
                            ->withMeta(['extraAttributes' => ['maxlength' => 5]])
                            ->rules( 'max:5'),
                        Number::make(__('Power'), 'power')->step(0.01),
                        Number::make(__('Engine side RMP'), 'engine_side_rpm'),
                        Number::make(__('Process side RPM'), 'process_side_rpm'),
                        Number::make(__('Pressure min'), 'pressure_min'),
                        Number::make(__('Pressure max'), 'pressure_max'),
                        Number::make(__('Temperature min'), 'temperature_min'),
                        Number::make(__('Temperature max'), 'temperature_max'),
                        File::make(__('Documentation'), 'documentation'),
                        Date::make(__('Activation date'), 'activation_date'),
                        Textarea::make(__('Note'), 'note'),
                        Textarea::make(__('Internal note'), 'internal_note'),
                    ]))->withComponent('akka-accordion'),

                    HasMany::make(__('Activities'), 'lastActivities', Activity::class),

                    Machines::make(),
                    HasMany::make(__('Components'), 'components', 'App\Nova\Component')
                        ->hideFromIndex()
                        ->hideWhenUpdating()
                        ->hideWhenUpdating()
                        ->hideFromDetail(),
                ],
                [
                    HasMany::make(__('New Activities'), 'newActivities', Activity::class),

                    HasMany::make(__('Old Activities'), 'oldActivities', Activity::class),
                ],
                [

                    ControlPlan::make(__('Control Plan')),

                    HasOne::make(__('Control Plan config'), 'controlPlanConfig', ControlPlanConfig::class)->hideFromDetail(),
                    HasMany::make(__('Control Plans'), 'controlPlans')->hideFromDetail()
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
