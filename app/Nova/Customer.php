<?php

namespace App\Nova;

use Acme\StripeInspector\StripeInspector;
use App\Nova\Lenses\HasAddress;
use App\Nova\Metrics\ClientCount;
use App\Nova\Metrics\ClientsPerDay;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;

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
            Text::make(__('Customer code'), 'customer_code')->rules('required', 'unique:customers,customer_code'),
            Text::make(__('Customer name'), 'customer_name')->required(),
            Text::make(__('Other customer Name'),'other_customer_name'),
            Text::make(__('ISO'),'iso'),
            Text::make(__('VAT number'),'vat_number'),
            Text::make(__('Fiscal Code'),'fiscal_code'),
            Text::make(__('Address'),'address')->nullable(),
            Text::make(__('City'),'city')->nullable(),
            Text::make(__('PO box'),'po_box')->nullable(),
            Text::make(__('Province'),'province'),
            Text::make(__('Country'),'country'),
            Text::make(__('CRM C4C code'),'crm_c4c_code'),
            Select::make(__('Type'), 'type')->options(['customer',  'vendor','subcontractor']),
            Text::make(__('Phone'), 'phone'),
            Text::make(__('Fax'),'fax'),
            Text::make(__('Email'),'email'),
            Text::make(__('Contact person'),'contact_person'),
            Date::make(__('Activation date'),'activation_date'),
            Text::make(__('Language'),'language'),
            Textarea::make(__('Note'),'note')->nullable(),
            Text::make(__('Main activity'),'main_activity')->nullable(),
            Image::make(__('Image'), 'image')->nullable(),
            HasOne::make(__('Maintenance contract'), 'maintenance_contract', Contract::class),
            HasOne::make(__('Fixfee contract'), 'fixfee_contract',Contract::class),
            HasOne::make(__('Monitoring contract'), 'monitoring_contract',Contract::class),
            HasMany::make(__('Factory'), 'Factory')
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
