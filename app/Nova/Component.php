<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphMany;
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
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return __('Components');
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return __('Component');
    }

    /**
     * Indicates if the resource should be displayed in the sidebar.
     *
     * @var bool
     */
    public static $displayInNavigation = false;

    /**
     * Return the location to redirect the user after update.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Laravel\Nova\Resource  $resource
     * @return string
     */
    public static function redirectAfterUpdate(NovaRequest $request, $resource)
    {
        return '/resources/machines/'.$resource->machine_id;
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
            Text::make(__('Name'), 'name')->rules('required'),
            BelongsTo::make(__('Machine'), 'machine', 'App\Nova\Machine'),

            NovaBelongsToDepend::make(__('Category'), 'componentCategory', 'App\Nova\ComponentCategory')
                ->options(\App\Models\ComponentCategory::all())->size('w-1/2')->stacked(false)->rules('required'),
            NovaBelongsToDepend::make(__('Sub Category'), 'componentSubCategory', 'App\Nova\ComponentSubCategory')
                ->optionsResolve(function ($componentCategory) {
                    // Reduce the amount of unnecessary data sent
                    return $componentCategory->subs()->get(['id','name']);
                })
                ->dependsOn('componentCategory')->size('w-1/2')->stacked(false)->rules('required'),

            Text::make(__('Constructor'),'constructor')->size('w-1/3')->rules('required'),
            Text::make(__('Model'),'model')->size('w-1/3')->rules('required'),
            Text::make(__('Serial number'),'serial_number')->size('w-1/3')->rules('required'),
            Textarea::make(__('Description'),'description')->stacked(),
            Number::make(__('Point of Vibrations'), 'vibrations')->size('w-1/4')
                ->readonly(function ($request) {
                    return $request->isUpdateOrUpdateAttachedRequest();
                }),
            Number::make(__('Point of Temperature'), 'temperature')->size('w-1/4')
                ->readonly(function ($request) {
                    return $request->isUpdateOrUpdateAttachedRequest();
                }),
            Number::make(__('Point of Pressure'), 'pressure')->size('w-1/4')
                ->readonly(function ($request) {
                    return $request->isUpdateOrUpdateAttachedRequest();
                }),
            Number::make(__('Point of Payload'), 'payload')->size('w-1/4')
                ->readonly(function ($request) {
                    return $request->isUpdateOrUpdateAttachedRequest();
                }),
            MorphMany::make(__('Attachments'), 'attachments'),
            HasMany::make(__('Articles'), 'articles', ManagedArticle::class),
            HasMany::make('maintenances')->onlyOnIndex()->hideFromIndex(),
            HasMany::make('measurements')->onlyOnIndex()->hideFromIndex()
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
