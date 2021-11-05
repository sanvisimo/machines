<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Article extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Article::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public function title()
    {
        return $this->drawing ." - ". $this->description;
    }

    /**
     * Get the search result subtitle for the resource.
     *
     * @return string
     */
//    public function subtitle()
//    {
//        return __('Description').": ". $this->description;
//    }


    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'part_number',
        'description',
        'drawing',
        'eb_part_number'
    ];

    public static $group = "Utils";

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
            Text::make(__('Part number'), 'part_number')->rules('required', 'max:18', 'unique:articles,part_number'),
            Text::make(__('Description'), 'description')->rules('required','max:40'),
            Text::make(__('Material'), 'material')->rules('required','max:40'),
            Text::make(__('Drawing'), 'drawing')->rules('required','max:40'),
            Text::make(__('EB part number'), 'eb_part_number')->rules('required','max:18'),
            Text::make(__('Product type'), 'product_type')->rules('required','max:4'),
            Select::make(__('State'), 'state')->options([
                'active' => __('Active'),
                'suspended' => __('Suspended'),
                'blocked' => __('Blocked')
                ])->required(),
            Text::make(__('External part number'), 'external_part_number')->rules('required','max:18'),
            Text::make(__('Supplier Code'), 'supplier_code')->rules( 'max:18'),
            Text::make(__('Supplier Description'), 'supplier_description')->rules('max:40'),
            Select::make(__('Mu'), "MU")->options([
                'PZ' => __('PZ'),
                'MT' => __('MT'),
                'LT' => __('LT'),
                'KT' => __('KT')
                ])->required(),
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
