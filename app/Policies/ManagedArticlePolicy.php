<?php

namespace App\Policies;

use App\Models\ManagedArticle;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ManagedArticlePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('view machine') || $user->hasPermissionTo('view any machine');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ManagedArticle  $managedArticle
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, ManagedArticle $managedArticle)
    {
        if ($user->hasPermissionTo('view machine')) {
            return $managedArticle->component->machine->plant->establishment->customer->manutentors->contains('id', $user->id);
        }

        return $user->hasPermissionTo('view any machine');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('manage any machine');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ManagedArticle  $managedArticle
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, ManagedArticle $managedArticle)
    {
        if ($user->hasPermissionTo('manage machine')) {
            return $managedArticle->component->machine->plant->establishment->customer->manutentors->contains('id', $user->id);
        }

        return $user->hasPermissionTo('manage any machine');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ManagedArticle  $managedArticle
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, ManagedArticle $managedArticle)
    {
        if ($user->hasPermissionTo('manage machine')) {
            return $managedArticle->component->machine->plant->establishment->customer->manutentors->contains('id', $user->id);
        }

        return $user->hasPermissionTo('manage any machine');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ManagedArticle  $managedArticle
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, ManagedArticle $managedArticle)
    {
        if ($user->hasPermissionTo('manage machine')) {
            return $managedArticle->component->machine->plant->establishment->customer->manutentors->contains('id', $user->id);
        }

        return $user->hasPermissionTo('manage any machine');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ManagedArticle  $managedArticle
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, ManagedArticle $managedArticle)
    {
        if ($user->hasPermissionTo('manage machine')) {
            return $managedArticle->component->machine->plant->establishment->customer->manutentors->contains('id', $user->id);
        }

        return $user->hasPermissionTo('manage any machine');
    }
}
