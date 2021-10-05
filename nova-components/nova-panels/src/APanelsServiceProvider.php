<?php

namespace Akka\Nova;

use Laravel\Nova\Nova;
use Laravel\Nova\Events\ServingNova;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class APanelsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Event::listen(ServingNova::class, function () {
            Nova::script('akka-panels', dirname(__DIR__) . '/dist/js/aPanels.js');
            Nova::style('akka-panels', dirname(__DIR__) . '/dist/css/aPanels.css');
        });
    }
}
