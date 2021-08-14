<?php

namespace App\Nova;

use Acme\StripeInspector\StripeInspector;
use App\Nova\Lenses\HasAddress;
use App\Nova\Metrics\ClientCount;
use App\Nova\Metrics\ClientsPerDay;
use App\Nova\Metrics\EstablishmentsPerClient;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Place;
use Laravel\Nova\Fields\Text;

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
//    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'firstname',
        'lastname'
    ];

    public static $group = 'Admin';

    public function title()
    {
        return $this->name . ' - ' . $this->address;
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
            Text::make('Name', 'firstname')
                ->sortable()
                ->rules('required', 'max:255'),
            Text::make('Lastname')
                ->sortable()
                ->rules('required', 'max:255'),
            Text::make('alias')
                ->sortable(),
            Place::make('Address'),
            Text::make('Phone'),
            Text::make('Fax'),
            Text::make('Authorization'),
            Image::make('Image')->disk('public'),
            HasMany::make('Establishment')
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
            new ClientCount,
            new ClientsPerDay,
            new EstablishmentsPerClient,
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
