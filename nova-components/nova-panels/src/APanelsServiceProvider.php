<?php

namespace Akka\Nova;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Laravel\Nova\Nova;
use Laravel\Nova\Events\ServingNova;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class APanelsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->booted(function () {
            $this->routes();
        });

        Event::listen(ServingNova::class, function () {
            Nova::script('akka-panels', dirname(__DIR__) . '/dist/js/aPanels.js');
            Nova::style('akka-panels', dirname(__DIR__) . '/dist/css/aPanels.css');
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
            ->prefix('akka/panels')
            ->namespace('Akka\Nova\Http\Controllers')
            ->group(__DIR__.'/../routes/api.php');
    }
}
