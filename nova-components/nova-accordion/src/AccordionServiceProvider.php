<?php

namespace Akka\Accordion;

use Illuminate\Support\Facades\Route;
use Laravel\Nova\Nova;
use Laravel\Nova\Events\ServingNova;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AccordionServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Event::listen(ServingNova::class, function () {
            Nova::script('akka-accordion', dirname(__DIR__) . '/dist/js/accordion.js');
            Nova::style('akka-accordion', dirname(__DIR__) . '/dist/css/Accordion.css');
        });
    }

    /**
     * Register the tool's routes.
     *
     * @return void
     */
    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Route::middleware(['nova'])
            ->prefix('nova-vendor/accordion')
            ->namespace('Akka\Accordion\Http\Controllers')
            ->group(__DIR__.'/../routes/api.php');
    }
}
