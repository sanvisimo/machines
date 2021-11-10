<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use Pktharindu\NovaPermissions\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  User $user
     * @return Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('view roles');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  User $user
     * @param  Role $Role
     * @return Response|bool
     */
    public function view(User $user, Role $Role)
    {
        return $user->hasPermissionTo('view roles');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  User $user
     * @return Response|bool
     */
    public function create(User $user)
    {
        return $user->hasAnyPermission(['view roles', 'create roles']);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  User $user
     * @param  Role $Role
     * @return Response|bool
     */
    public function update(User $user, Role $Role)
    {
        return $user->hasPermissionTo('edit roles');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  User $user
     * @param  Role $Role
     * @return Response|bool
     */
    public function delete(User $user, Role $Role)
    {
        return $user->hasPermissionTo('delete roles');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  User $user
     * @param  Role $Role
     * @return Response|bool
     */
    public function restore(User $user, Role $Role)
    {
        return $user->hasPermissionTo('create roles');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  User $user
     * @param  Role $Role
     * @return Response|bool
     */
    public function forceDelete(User $user, Role $Role)
    {
        return $user->hasPermissionTo('delete roles');
    }
}
