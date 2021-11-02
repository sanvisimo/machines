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

class Factory extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Factory::class;

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
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'customer_code',
        'customer_name'
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
            ID::make(__('ID'), 'id')->sortable(),
            ID::make(__('ID'), 'id')->sortable(),
            Text::make(__('Customer code'), 'customer_code')->rules('required', 'unique:factories,customer_code'),
            Text::make(__('Customer name'), 'customer_name')->required(),
            Text::make(__('Other customer Name'),'other_customer_name')->required(),
            Text::make(__('ISO'),'iso')->required(),
            Text::make(__('VAT number'),'vat_number')->required(),
            Text::make(__('Fiscal Code'),'fiscal_code'),
            Text::make(__('Address'),'address')->nullable(),
            Text::make(__('City'),'city')->nullable(),
            Text::make(__('PO box'),'po_box')->nullable(),
            Text::make(__('Province'),'province')->required(),
            Text::make(__('Country'),'country')->required(),
            Text::make(__('CRM C4C code'),'crm_c4c_code')->required(),
            Select::make(__('Type'), 'type')->options(['factory'])->default('factory')->required(),
            Text::make(__('Phone'), 'phone')->required(),
            Text::make(__('Fax'),'fax'),
            Text::make(__('Email'),'email')->required(),
            Text::make(__('Contact person'),'contact_person')->required(),
            Date::make(__('Activation date'),'activation_date')->required(),
            Text::make(__('Language'),'language')->required(),
            Textarea::make(__('Note'),'note')->nullable(),
            Text::make(__('Main activity'),'main_activity')->nullable(),
            Image::make(__('Image'), 'image')->nullable(),
            HasOne::make(__('Maintenance contract'), 'maintenance_contract', Contract::class),
            HasOne::make(__('Fixfee contract'), 'fixfee_contract',Contract::class),
            HasOne::make(__('Monitoring contract'), 'monitoring_contract',Contract::class),
            BelongsTo::make(__('Customer'), 'customer'),
            HasMany::make(__('Plants'), 'plants'),
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
