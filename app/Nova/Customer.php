<?php

namespace App\Nova;

use Acme\StripeInspector\StripeInspector;
use App\Nova\Lenses\HasAddress;
use App\Nova\Metrics\ClientCount;
use App\Nova\Metrics\ClientsPerDay;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphToMany;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;

class Customer extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Customer::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'customer_name';

    /**
     * Get the search result subtitle for the resource.
     *
     * @return string
     */
    public function subtitle()
    {
        return __('Customer code').": ".$this->customer_code;
    }

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return __('Customers');
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return __('Customer');
    }

    /**
     * Custom priority level of the resource.
     *
     * @var int
     */
    public static $priority = 1;

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'customer_code',
        'customer_name'
    ];

    /**
     * Default ordering for index query.
     *
     * @var array
     */
    public static $sort = [
        'customer_code' => 'asc'
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

            $query->orderBy(key(static::$sort), reset(static::$sort));
        }

        if($request->user()->hasPermissionTo('view any customers')) {
            return $query;
        }

        if($request->user()->hasPermissionTo('view customers')) {
            return $query->whereHas('manutentors', function ($query) use ($request) {
                $query->whereIn('user_id', [$request->user()->id]);
            });
        }
    }

    public static function group()
    {
        return __('Admin');
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
            ID::make(__('ID'), 'id')->onlyOnForms(),
            Text::make(__('Customer code'), 'customer_code')
                ->sortable()
                ->help(
                    __('Max 10')
                )
                ->withMeta(['extraAttributes' => ['maxlength' => 10]])
                ->creationRules('required', 'unique:customers,customer_code', 'max:10')
                ->updateRules('unique:customers,customer_code,{{resourceId}}','required','max:10')
                ->displayUsing(function ($value) use ($request){
                        return view('link', [
                            'id' => $this->id,
                            'value' => $value,
                            'slug' => $this->uriKey()
                        ])->render();
                })->asHtml(),
            Text::make(__('Customer name'), 'customer_name')
                ->sortable()
                ->help(
                    __('Max 60')
                )
                ->withMeta(['extraAttributes' => ['maxlength' => 60]])
                ->rules( 'required','max:60')
                ->displayUsing(function ($value) use ($request){
                        return view('link', [
                            'id' => $this->id,
                            'value' => $value,
                            'slug' => $this->uriKey()
                        ])->render();
                })->asHtml(),
            (new Panel (__('More Info'), [
                Text::make(__('Other customer Name'),'other_customer_name')
                    ->hideFromIndex()
                    ->help(
                        __('Max 60')
                    )
                    ->withMeta(['extraAttributes' => ['maxlength' => 60]])
                    ->rules(  'max:60'),
                Text::make(__('ISO'),'iso')
                    ->hideFromIndex()
                    ->help(
                        __('Max 3')
                    )
                    ->withMeta(['extraAttributes' => ['maxlength' => 3]])
                    ->rules( 'required','max:3'),
                Text::make(__('VAT number'),'vat_number')
                    ->hideFromIndex()
                    ->help(
                        __('Max 16')
                    )
                    ->withMeta(['extraAttributes' => ['maxlength' => 16]])
                    ->rules( 'required','max:16'),
                Text::make(__('Fiscal code'),'fiscal_code')
                    ->hideFromIndex()
                    ->help(
                        __('Max 16')
                    )
                    ->withMeta(['extraAttributes' => ['maxlength' => 16]])
                    ->rules( 'max:16'),
                Text::make(__('Address'),'address')->nullable()
                    ->help(
                        __('Max 40')
                    )
                    ->withMeta(['extraAttributes' => ['maxlength' => 40]])
                    ->rules( 'max:40'),
                Text::make(__('City'),'city')->nullable()
                    ->help(
                        __('Max 40')
                    )
                    ->withMeta(['extraAttributes' => ['maxlength' => 40]])
                    ->rules( 'max:40'),
                Text::make(__('PO box'),'po_box')
                    ->nullable()
                    ->hideFromIndex(),
                Text::make(__('Province'),'province')->rules('required'),
                Text::make(__('Country'),'country')
                    ->help(
                        __('Max 3')
                    )
                    ->withMeta(['extraAttributes' => ['maxlength' => 3]])
                    ->rules( 'required','max:3'),
                Text::make(__('CRM C4C code'),'crm_c4c_code')
                    ->hideFromIndex()
                    ->help(
                        __('Max 20')
                    )
                    ->withMeta(['extraAttributes' => ['maxlength' => 20]])
                    ->rules( 'max:20'),
                Select::make(__('Type'), 'type')
                    ->options([
                        'customer' => __('Customer'),
                        'vendor' => __('Vendor'),
                        'subcontractor' => __('SubContractor')
                    ])->rules('required'),
                Text::make(__('Phone'), 'phone')->rules('required')->hideFromIndex(),
                Text::make(__('Fax'),'fax')->hideFromIndex(),
                Text::make(__('Email'),'email')->rules('required')->hideFromIndex(),
                Text::make(__('Contact person'),'contact_person')->rules('required'),
                Date::make(__('Activation date'),'activation_date')->rules('required')->hideFromIndex(),
                Text::make(__('Language'),'language')->nullable(),
                Textarea::make(__('Notes'),'note')->nullable(),
                Text::make(__('Main activity'),'main_activity')->nullable(),
                Image::make(__('Image'), 'image')->nullable(),
            ]))->withComponent('akka-accordion'),
            HasMany::make(__('Factory'), 'establishments', Establishment::class),
            BelongsToMany::make(__('Manutentors'), 'manutentors', User::class),
            MorphToMany::make(__('Contracts'), 'contracts', Contract::class),
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
        return [
//            new ClientCount,
//            new ClientsPerDay,
        ];
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
        return [
            new HasAddress
        ];
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
