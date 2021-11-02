<?php

namespace App\Providers;

use App\Models\Activity;
use App\Models\Component;
use App\Models\ControlPlan;
use App\Models\ControlPlanConfig;
use App\Models\Maintenance;
use App\Models\Measurement;
use App\Models\MeasurementConfig;
use App\Observers\ActivityObserver;
use App\Observers\ComponentObserver;
use App\Observers\ControlPlanConfigObserver;
use App\Observers\ControlPlanObserver;
use App\Observers\MaintenanceObserver;
use App\Observers\MeasurementConfigObserver;
use App\Observers\MeasurementObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Activity::observe(ActivityObserver::class);
        ControlPlanConfig::observe(ControlPlanConfigObserver::class);
        Maintenance::observe(MaintenanceObserver::class);
        MeasurementConfig::observe(MeasurementConfigObserver::class);
        ControlPlan::observe(ControlPlanObserver::class);
        Measurement::observe(MeasurementObserver::class);
        Component::observe(ComponentObserver::class);
    }
}
