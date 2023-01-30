<?php

namespace App\Policies;

use App\Models\Privilege;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PrivilegePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any privileges.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the privilege.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Privilege  $privilege
     * @return mixed
     */
    public function view(User $user, Privilege $privilege)
    {
        //
    }

    /**
     * Determine whether the user can create privileges.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the privilege.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Privilege  $privilege
     * @return mixed
     */
    public function update(User $user, Privilege $privilege)
    {
        //
    }

    /**
     * Determine whether the user can delete the privilege.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Privilege  $privilege
     * @return mixed
     */
    public function delete(User $user, Privilege $privilege)
    {
        //
    }
}
