<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\BooleanGroup;
use Laravel\Nova\Fields\Country;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\KeyValue;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\PasswordConfirmation;
use Laravel\Nova\Fields\Place;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Sparkline;
use Laravel\Nova\Fields\Stack;
use Laravel\Nova\Fields\Status;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Trix;
use DKulyk\Nova\Tabs;
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

            new APanels('titolo', [
                 ID::make(__('ID'), 'id')->sortable(),
            ]),

            new Tabs($this->title(), [
                (new Panel('Profile', [
                    new Panel('Info', [Text::make('Name')
                        ->sortable()
                        ->rules('required', 'max:255'),
                    Select::make('state')->options([
                        'active' => 'Active',
                        'suspended' => 'Suspended',
                        'not_operative' => 'Not Operative',
                    ]),
                        ])
                ]))->limit(1),

                new Panel('Profile 2', [
                    new Tabs('Tabs', [
                        new Panel('casa', [
                            ID::make(__('ID'), 'id')->sortable(),
                            Text::make('Manufacturer code'),
                        ]),
                        'Other Info' => [
                            Textarea::make('manufacturer description'),
                        ]
                    ]),
                ]),
            ]),
//            ID::make(__('ID'), 'id')->sortable(),
//            Text::make('Name')
//                ->sortable()
//                ->rules('required', 'max:255'),
//            Place::make('Address'),
//            Text::make('Phone'),
//            BelongsToMany::make('Plant'),
//            Heading::make('Aggiunti'),
//            Date::make('Birthday'),
//            Image::make('Image')->disk('public'),
//            Badge::make('Published')->map([
//                'draft' => 'danger',
//                'published' => 'success',
//            ]),
//            DateTime::make('Published At')->format('DD MMM YYYY'),
//            Boolean::make('Active'),
//            BooleanGroup::make('Permissions')->options([
//                'create' => 'Create',
//                'read' => 'Read',
//                'update' => 'Update',
//                'delete' => 'Delete',
//            ]),
//            Country::make('Country', 'country_code'),
//            KeyValue::make('Meta')->rules('json'),
//            Currency::make('price')->min(1)->max(1000)->step(0.01),
//            Password::make('Password'),
//            PasswordConfirmation::make('Password Confirmation'),
//            Select::make('Size')->options([
//                'S' => 'Small',
//                'M' => 'Medium',
//                'L' => 'Large',
//            ]),
//            Sparkline::make('Post Views')->data([1, 2, 3, 4, 5, 6, 7, 8, 9, 10])->asBarChart(),
//            Status::make('Status')
//                ->loadingWhen(['waiting', 'running'])
//                ->failedWhen(['failed']),
//            Stack::make('Details', [
//                Text::make('Longname'),
//                Text::make('Slug')->resolveUsing(function () {
//                    return Str::slug(optional($this->resource)->longname);
//                }),
//            ]),
//
//            new Tabs('Tabs', [
//                new Panel('Balance', [
//                    Text::make('Longname')->stacked(),
//                    Text::make('Slug')->stacked(),
//                ]),
//                'Other Info' => [
//                    Textarea::make('Excerpt'),
//                    Trix::make('Biography'),
//                 ]
//            ]),
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
