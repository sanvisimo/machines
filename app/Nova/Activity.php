<?php

namespace App\Nova;

use Akka\AkkaDate\AkkaDate;
use Akka\NovaDependencyContainer\HasDependencies;
use App\Nova\Actions\createMaintenance;
use Akka\NovaDependencyContainer\NovaDependencyContainer;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Activity extends Resource
{
    use HasDependencies;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Activity::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'description';

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return __('Activities');
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return __('Activity');
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * Return the location to redirect the user after creation.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Laravel\Nova\Resource  $resource
     * @return string
     */
    public static function redirectAfterCreate(NovaRequest $request, $resource)
    {
        return '/resources/'.Machine::uriKey().'/'.$resource->model()->machine->id;
    }

    /**
     * Build a "relatable" query for the given resource.
     *
     * This query determines which instances of the model may be attached to other resources.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  \Laravel\Nova\Fields\Field  $field
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function relatableComponents(NovaRequest $request, $query)
    {
        $resourceId = $request->get('viaResourceId');
        return $query->where('machine_id', $resourceId);
    }

    public static function relatableManagedArticles(NovaRequest $request, $query)
    {
        $resourceId = $request->get('viaResourceId');


        return $query->where('component_id', function($query) use ($resourceId) {
          $query->select('id')->from(with(new \App\Models\Component)->getTable())
          ->where('machine_id', $resourceId);
        });
    }

    public static function relatableMachines(NovaRequest $request, $query)
    {
        $resourceId = $request->get('viaResourceId');
        return $query->where('id', $resourceId);
    }

    /**
     * Default ordering for index query.
     *
     * @var array
     */
    public static $sort = [
        'expiration' => 'asc'
    ];

    /**
     * Build an "index" query for the given resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        if (empty($request->get('orderBy'))) {
            $query->getQuery()->orders = [];

            return $query->orderBy(key(static::$sort), reset(static::$sort));
        }

        return $query;
    }

    public static $perPageOptions = [1,2,5];

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
            ID::make(__('ID'), 'id')->onlyOnDetail(),

            AkkaDate::make(__('Expiration'), 'expiration')->onlyOnIndex(),
            Date::make(__('Expiration'), 'expiration')->required()->onlyOnForms(),
            BelongsTo::make(__('Machine'), 'machine', Machine::class)->hideFromIndex(),

            Text::make(__('Description'), 'description')->required(),
            Select::make(__('Type'), 'type')->options([
                    'maintenance' => __('Ordinary Maintenance'),
                    'control_plan' => __('Planned Measurement'),
                    'maintenance_no' => __('Extraordinary Maintenance'),
                    'control_plan_no' => __('Extraordinary Measurement'),
            ])->displayUsingLabels(),

            NovaDependencyContainer::make([
                Number::make(__('Periodicity'), 'periodicity')
                    ->rules('min:1')
                    ->withMeta(['extraAttributes' => ['min' => 0]])
            ])
                ->dependsOn('type', 'maintenance')
                ->dependsOn('type', 'control_plan'),

            MorphTo::make(__('Element'), 'element')->types([
                Component::class,
                ManagedArticle::class,
            ])->onlyOnIndex(),

            NovaDependencyContainer::make([
                MorphTo::make(__('Element'), 'element')->types([
                    Component::class,
                    ManagedArticle::class,
                    Machine::class
                ]),
            ])
                ->dependsOn('type', 'maintenance')
                ->dependsOn('type', 'maintenance_no'),
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
        return [
            (new createMaintenance)->showOnTableRow()
        ];
    }
}
