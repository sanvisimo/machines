<?php

namespace App\Providers;

use App\Models\Component;
use App\Models\ManagedArticle;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\Article' => 'App\Policies\ArticlePolicy',
        'Pktharindu\NovaPermissions\Role' => '\App\Policies\RolePolicy',
        'App\Models\Customer' => 'App\Policies\CustomerPolicy',
        'App\Models\Establishment' => 'App\Policies\EstablishmentPolicy',
        'App\Models\Plant' => 'App\Policies\PlantPolicy',
        'App\Models\Machine' => 'App\Policies\MachinePolicy',
        'App\Models\ManagedArticle' => 'App\Policies\ManagedArticlePolicy'
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
           $this->registerPolicies();
           foreach (config('nova-permissions.permissions') as $key => $permissions) {
                Gate::define($key, function (User $user) use ($key) {
                    if ($this->nobodyHasAccess($key)) {
                        return true;
                    }

                    return $user->hasPermissionTo($key);
                });
            }
    }
}
