<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\BooleanGroup;
use Laravel\Nova\Fields\Country;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\KeyValue;
use Laravel\Nova\Fields\Number;
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
use Laravel\Nova\Http\Requests\NovaRequest;

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
            ID::make(__('ID'), 'id')->sortable(),
            ID::make(__('ID'), 'id')->sortable(),
            Text::make('Name')
                ->sortable()
                ->rules('required', 'max:255'),
            Place::make('Address'),
            Text::make('Phone'),
            Image::make('Image')->disk('public'),
            BelongsTo::make('Plant'),
            Heading::make('Aggiunti'),
            Date::make('Birthday'),
            Image::make('Image')->disk('public'),
            Badge::make('Contact')->map([
                'draft' => 'danger',
                'published' => 'success',
            ]),
            DateTime::make('Created At')->format('DD MMM YYYY'),
            Boolean::make('Active'),
            BooleanGroup::make('Permissions')->options([
                'create' => 'Create',
                'read' => 'Read',
                'update' => 'Update',
                'delete' => 'Delete',
            ]),
            Country::make('Country', 'country_code'),
            KeyValue::make('Meta')
                ->keyLabel('Item') // Customize the key heading
                ->valueLabel('Label') // Customize the value heading
                ->actionText('Add Item'),
            Number::make('price')->min(1)->max(1000)->step(0.01),
            Password::make('Password'),
            PasswordConfirmation::make('Password Confirmation'),
            Select::make('Size')->options([
                'S' => 'Small',
                'M' => 'Medium',
                'L' => 'Large',
            ]),
            Sparkline::make('Post Views')->data([1, 2, 3, 4, 5, 6, 7, 8, 9, 10])->asBarChart(),
            Status::make('Status')
                ->loadingWhen(['waiting', 'running'])
                ->failedWhen(['failed']),
            Stack::make('Details', [
                Text::make('Name'),
                Text::make('Slug')->resolveUsing(function () {
                    return Str::slug(optional($this->resource)->name);
                }),
            ]),
            Textarea::make('Biography'),
            Trix::make('Biography'),
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
