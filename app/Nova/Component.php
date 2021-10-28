<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Orlyapps\NovaBelongsToDepend\NovaBelongsToDepend;

class Component extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Component::class;

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
            Text::make(__('Name'), 'name'),
            BelongsTo::make(__('Machine'), 'machine', 'App\Nova\Machine'),

            NovaBelongsToDepend::make(__('Category'), 'componentCategory', 'App\Nova\ComponentCategory')
                ->placeholder('Optional Placeholder') // Add this just if you want to customize the placeholder
                ->options(\App\Models\ComponentCategory::all())->size('w-1/2')->stacked(false),
            NovaBelongsToDepend::make(__('Sub Category'), 'componentSubCategory', 'App\Nova\ComponentSubCategory')
                ->placeholder('Optional Placeholder') // Add this just if you want to customize the placeholder
                ->optionsResolve(function ($componentCategory) {
                    // Reduce the amount of unnecessary data sent
                    return $componentCategory->subs()->get(['id','name']);
                })
                ->dependsOn('componentCategory')->size('w-1/2')->stacked(false),

            Text::make(__('Constructor'),'constructor')->size('w-1/3'),
            Text::make(__('Model'),'model')->size('w-1/3'),
            Text::make(__('Serial number'),'serial_number')->size('w-1/3'),
            Textarea::make(__('Description'),'description')->stacked(),
            Number::make(__('Point of Vibrations'), 'vibrations')->size('w-1/4'),
            Number::make(__('Point of Temperature'), 'temperature')->size('w-1/4'),
            Number::make(__('Point of Pressure'), 'pressure')->size('w-1/4'),
            Number::make(__('Point of Payload'), 'payload')->size('w-1/4'),
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
