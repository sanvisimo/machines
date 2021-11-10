<?php

namespace App\Policies;

use App\Models\Machine;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MachinePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Machine  $machine
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Machine $machine)
    {
        if($user->hasPermissionTo('view any machine')) {
            return $user->hasPermissionTo('view any machine');
        }

        if ($user->hasPermissionTo('view machine')) {
            return $machine->plant->establishment->customer->manutentors->contains('id', $user->id);
        }

        return false;
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
     * @param  \App\Models\Machine  $machine
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Machine $machine)
    {
        if($user->hasPermissionTo('manage any machine')) {
            return $user->hasPermissionTo('manage any machine');
        }

        if ($user->hasPermissionTo('manage machine')) {
            return $machine->plant->establishment->customer->manutentors->contains('id', $user->id);
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Machine  $machine
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Machine $machine)
    {
        if($user->hasPermissionTo('manage any machine')) {
            return $user->hasPermissionTo('manage any machine');
        }

        if ($user->hasPermissionTo('manage machine')) {
            return $machine->plant->establishment->customer->manutentors->contains('id', $user->id);
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Machine  $machine
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Machine $machine)
    {
        if($user->hasPermissionTo('manage any machine')) {
            return $user->hasPermissionTo('manage any machine');
        }

        if ($user->hasPermissionTo('manage machine')) {
            return $machine->plant->establishment->customer->manutentors->contains('id', $user->id);
        }

        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Machine  $machine
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Machine $machine)
    {
        if($user->hasPermissionTo('manage any machine')) {
            return $user->hasPermissionTo('manage any machine');
        }

        if ($user->hasPermissionTo('manage machine')) {
            return $machine->plant->establishment->customer->manutentors->contains('id', $user->id);
        }

        return false;
    }
}
