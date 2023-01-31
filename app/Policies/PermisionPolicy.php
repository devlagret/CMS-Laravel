<?php

namespace App\Policies;

use App\Helpers\UserHelper;
use App\Models\Permision;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class PermisionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any permisions.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
        $uh = new UserHelper();
        return $uh->checkPermision($user->user_id, ['super-admin', 'add-user-role', 'view-permision']) ? Response::allow()
            : Response::deny('Unauthorized', 401);
    }

    /**
     * Determine whether the user can view the permision.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Permision  $permision
     * @return mixed
     */
    public function view(User $user, Permision $permision)
    {
        //
        $uh = new UserHelper();
        return $uh->checkPermision($user->user_id, ['super-admin', 'add-user-role', 'view-permision', 'view-user-permision']) ? Response::allow()
        : Response::deny('Unauthorized', 401);
    }

    /**
     * Determine whether the user can create permisions.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the permision.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Permision  $permision
     * @return mixed
     */
    public function update(User $user, Permision $permision)
    {
        //
    }

    /**
     * Determine whether the user can delete the permision.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Permision  $permision
     * @return mixed
     */
    public function delete(User $user, Permision $permision)
    {
        //
    }
}
