<?php

namespace App\Policies;

use App\Models\Plant;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PlantPolicy
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
        return $user->hasPermissionTo('view customers') || $user->hasPermissionTo('view any customers');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Plant  $plant
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Plant $plant)
    {
        if ($user->hasPermissionTo('view customers')) {
            return $plant->establishment->customer->manutentors->contains('id', $user->id);
        }

        return $user->hasPermissionTo('view any customers');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('manage any customers');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Plant  $plant
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Plant $plant)
    {
        if ($user->hasPermissionTo('manage customers')) {
            return $plant->establishment->customer->manutentors->contains('id', $user->id);
        }

        return $user->hasPermissionTo('manage any customers');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Plant  $plant
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Plant $plant)
    {
        if ($user->hasPermissionTo('manage customers')) {
            return $plant->establishment->customer->manutentors->contains('id', $user->id);
        }

        return $user->hasPermissionTo('manage any customers');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Plant  $plant
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Plant $plant)
    {
        if ($user->hasPermissionTo('manage customers')) {
            return $plant->establishment->customer->manutentors->contains('id', $user->id);
        }

        return $user->hasPermissionTo('manage any customers');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Plant  $plant
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Plant $plant)
    {
        if ($user->hasPermissionTo('manage customers')) {
            return $plant->establishment->customer->manutentors->contains('id', $user->id);
        }

        return $user->hasPermissionTo('manage any customers');
    }
}
