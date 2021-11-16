<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;

class Plant extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Plant::class;

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

    public static function group()
    {
        return __('Admin');
    }

    /**
     * Custom priority level of the resource.
     *
     * @var int
     */
    public static $priority = 3;

    /**
     * Build an "index" query for the given resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        if ($request->user()->hasPermissionTo('view any customers')) {
            return $query;
        }

        if ($request->user()->hasPermissionTo('view customers')) {
            return $query->whereHas('establishment', function ($query) use ($request) {
                $query->whereHas('customer', function ($query) use ($request) {
                    $query->whereHas('manutentors', function ($query) use ($request) {
                        $query->whereIn('user_id', [$request->user()->id]);
                    });
                });
            });
        }
    }

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return __('Plants');
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return __('Plant');
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
            ID::make(__('ID'), 'id')->sortable()->onlyOnForms(),
            Text::make(__('Plant'),'plant')
                ->help(
                    __('Max 20')
                )
                ->withMeta(['extraAttributes' => ['maxlength' => 20]])
                ->rules( 'required', 'max:20','unique:plants,plant')
                ->displayUsing(function ($value) {
                    return view('link', [
                        'id' => $this->id,
                        'value' => $value,
                        'slug' => $this->uriKey()
                    ])->render();
                })->asHtml(),
            (new Panel (__('More Info'), [
                Text::make(__('Description'),'description')
                    ->help(
                        __('Max 40')
                    )
                    ->withMeta(['extraAttributes' => ['maxlength' => 40]])
                    ->rules( 'max:40'),
                Textarea::make(__('Notes'),'note'),
                Select::make(__('Plant state'),'plant_state')->options(['active', 'suspended', 'cancel'])->rules('required'),
                Text::make(__('Internal notes'),'internal_note'),
                File::make(__('Document'),'documents')
                    ->disk('public')
                    ->storeAs(function (Request $request) {
                        return ($request->documents->getClientOriginalName());
                    })
                    ->storeOriginalName('attachment_name')
                    ->hideFromIndex(),
            ]))->withComponent('akka-accordion'),
            HasMany::make(__('Machines'), 'machines', Machine::class),
            BelongsTo::make(__('Factory'), 'establishment', Establishment::class)->showCreateRelationButton()

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
