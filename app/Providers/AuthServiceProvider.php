<?php

namespace App\Providers;

use App\Models\Component;
use App\Models\ManagedArticle;
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
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        'App\Models\Customer' => 'App\Policies\MaintainerPolicy'
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

//
//        Gate::define('create-managed_article', function (User $user, ManagedArticle $article) {
//            dd($article->component->id);
//        });
    }
}
