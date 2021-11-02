<?php

namespace App\Providers;

use Akka\Agenda\NuovaCard;
use CodencoDev\NovaGridSystem\NovaGridSystem;
use Day4\SwitchLocale\SwitchLocale;
use Eolica\NovaLocaleSwitcher\LocaleSwitcher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Cards\Help;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use Sloveniangooner\LocaleAnywhere\LocaleAnywhere;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Nova::serving(function (ServingNova $event) {

            $user = $event->request->user();
//            app()->setLocale('it');
            if (array_key_exists($user->locale, config('nova.locales'))) {
                $lang = $user->locale === "en" ? '/lang/en.json' : '/lang/it.json';

                Nova::translations(public_path().$lang);
                app()->setLocale($user->locale);
            }
        });
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
                ->withAuthenticationRoutes()
                ->withPasswordResetRoutes()
                ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return in_array($user->email, [
                //
            ]);
        });
    }

    /**
     * Get the cards that should be displayed on the default Nova dashboard.
     *
     * @return array
     */
    protected function cards()
    {
        return [
            new NuovaCard,
        ];
    }

    /**
     * Get the extra dashboards that should be displayed on the Nova dashboard.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [
            new NovaGridSystem,
//            new \Czemu\NovaCalendarTool\NovaCalendarTool,
            LocaleSwitcher::make()
                ->setLocales(config('nova.locales'))
                ->onSwitchLocale(function (Request $request) {

                    $locale = $request->post('locale');
                    if (array_key_exists($locale, config('nova.locales'))) {
                        $request->user()->update(['locale' => $locale]);
                    }
                }),
        ];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
