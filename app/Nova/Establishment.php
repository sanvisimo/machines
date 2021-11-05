<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;

class Establishment extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Establishment::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'customer_name';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $subtitle = 'customer_code';

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return __('Factories');
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return __('Factory');
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'customer_code',
        'customer_name'
    ];

    public static $group = 'Admin';

    /**
     * Custom priority level of the resource.
     *
     * @var int
     */
    public static $priority = 2;

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
            Text::make(__('Customer code'), 'customer_code')
                ->help(
                    __('Max 10')
                )
                ->withMeta(['extraAttributes' => ['maxlength' => 10]])
                ->rules('required', 'unique:establishments,customer_code', 'max:10')
                ->displayUsing(function ($value) {
                    return view('link', [
                        'id' => $this->id,
                        'value' => $value,
                        'slug' => $this->uriKey()
                    ])->render();
                })->asHtml(),
            Text::make(__('Customer name'), 'customer_name')->required()
                ->help(
                    __('Max 60')
                )
                ->withMeta(['extraAttributes' => ['maxlength' => 60]])
                ->rules( 'max:60')
                ->displayUsing(function ($value) {
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
            Text::make(__('ISO'),'iso')->required()
                ->help(
                    __('Max 3')
                )
                ->withMeta(['extraAttributes' => ['maxlength' => 3]])
                ->rules( 'max:3'),
            Text::make(__('VAT number'),'vat_number')->required()
                ->help(
                    __('Max 16')
                )
                ->withMeta(['extraAttributes' => ['maxlength' => 16]])
                ->rules( 'max:16'),
            Text::make(__('Fiscal Code'),'fiscal_code')
                ->help(
                    __('Max 16')
                )
                ->withMeta(['extraAttributes' => ['maxlength' => 16]])
                ->rules( 'max:16'),
            Text::make(__('Address'),'address')->nullable()
                ->hideFromIndex()
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
            Text::make(__('PO box'),'po_box')->nullable()->hideFromIndex(),
            Text::make(__('Province'),'province')->required()->hideFromIndex(),
            Text::make(__('Country'),'country')->required()
                ->hideFromIndex()
                ->help(
                    __('Max 3')
                )
                ->withMeta(['extraAttributes' => ['maxlength' => 3]])
                ->rules( 'max:3'),
            Text::make(__('CRM C4C code'),'crm_c4c_code')
                ->hideFromIndex()
                ->help(
                    __('Max 20')
                )
                ->withMeta(['extraAttributes' => ['maxlength' => 20]])
                ->rules( 'max:20'),
            Select::make(__('Type'), 'type')
                ->options([
                    'factory' => __('Factory')
                ])
                ->default('factory')
                ->required(),
            Text::make(__('Phone'), 'phone')->required(),
            Text::make(__('Fax'),'fax'),
            Text::make(__('Email'),'email')->required(),
            Text::make(__('Contact person'),'contact_person')->required(),
            Date::make(__('Activation date'),'activation_date')->required()->hideFromIndex(),
            Text::make(__('Language'),'language')->required()->hideFromIndex(),
            Textarea::make(__('Note'),'note')->nullable(),
            Text::make(__('Main activity'),'main_activity')->nullable(),
            Image::make(__('Image'), 'image')->nullable(),
            ]))->withComponent('akka-accordion'),
            HasMany::make(__('Plants'), 'plants'),
            BelongsTo::make(__('Customer'), 'customer')->showCreateRelationButton(),
            HasOne::make(__('Maintenance contract'), 'maintenance_contract', Contract::class),
            HasOne::make(__('Fixfee contract'), 'fixfee_contract',Contract::class),
            HasOne::make(__('Monitoring contract'), 'monitoring_contract',Contract::class),

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
