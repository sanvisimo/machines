<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class ManagedArticle extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\ManagedArticle::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public function title()
    {
        return $this->reference .' - '.$this->article->drawing;
    }

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return __('Managed Articles');
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return __('Managed Article');
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
     * Indicates if the resource should be displayed in the sidebar.
     *
     * @var bool
     */
    public static $displayInNavigation = false;

    /**
     * Return the location to redirect the user after creation.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Laravel\Nova\Resource  $resource
     * @return string
     */
    public static function redirectAfterCreate(NovaRequest $request, $resource)
    {
        return '/resources/'.Machine::uriKey().'/'.$resource->model()->component->machine->id.'?component='.$resource->model()->component->id;
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
            BelongsTo::make(__('Article'), 'article', Article::class)->showCreateRelationButton(),
            BelongsTo::make(__('Component'), 'component', Component::class),
            Text::make(__('Reference'),'reference'),
            Text::make(__('Customer part number'), 'customer_part_number'),
            Select::make(__('Measurement point'), 'measurement_point')
                ->options(static::getOptions($request))
                ->showOnCreating()
                ->hideWhenUpdating(),
            Text::make(__('Measurement point'), 'measurement_point')
                ->hideWhenCreating(),
            Text::make(__('Notes'), 'note'),
            File::make(__('Attachment'), 'attachment')
                ->disk('public')
                ->storeAs(function (Request $request) {
                    return ($request->attachment->getClientOriginalName());
                })
                ->storeOriginalName('attachment_name')
                ->hideFromIndex(),
            Boolean::make(__('Attachment'), 'attachment', function (){
                return $this->attachment;
            })->onlyOnIndex(),
        ];
    }

    static function getOptions(Request $request){
        $options = [];
        $id = $request->get('viaResourceId');
        if($id) {
            $component = \App\Models\Component::find($id);
            $components = $component->machine->components;
            $index = $components->search(function ($compo) use ($id) {
                return $compo->id == $id;
            });
            $c = $index + 1;

            $articles = $component->articles;

            for ($i = 1; $i <= $component->vibrations; $i++) {
                $art = $articles->search(function ($article) use ($c, $i) {
                    return $article->measurement_point == "C{$c}-B{$i}";
                });
                if (!is_numeric($art)) {
                    $options["C{$c}-B{$i}"] = "C{$c}-B{$i}";
                }
            }
            $pos = $component->temperature + $component->pressure + $component->payload;
            for ($i = 1; $i <= $pos; $i++) {
                $art = $articles->search(function ($article) use ($c, $i) {
                    return $article->measurement_point == "C{$c}-P{$i}";
                });
                if (!is_numeric($art)) {
                    $options["C{$c}-P{$i}"] = "C{$c}-P{$i}";
                }
            }
            return $options;
        }
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
