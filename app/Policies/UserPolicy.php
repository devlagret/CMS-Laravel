<?php

namespace App\Policies;

use App\Helpers\UserHelper;
use App\Models\Permision;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Privilege;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any users.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
        $uh = new UserHelper();
        return $uh->checkPermision($user->user_id, ['super-admin', 'view-all-user']) ? Response::allow()
            : Response::deny('Unauthorized', 401);
    }
    /**
     * Determine whether the user can view the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function view(User $user)
    {
        //
        $uh = new UserHelper();
        return $uh->checkPermision($user->user_id, ['super-admin', 'view-user']) ? Response::allow()
        : Response::deny('Unauthorized', 401);
    }

    /**
     * Determine whether the user can create users.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
        $uh = new UserHelper();
        return $uh->checkPermision($user->user_id, ['super-admin', 'add-user']) ? Response::allow()
        : Response::deny('Unauthorized', 401);
    }

    /**
     * Determine whether the user can update the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function update(User $user)
    {
        //
        $uh = new UserHelper();
        $r = $uh->checkPermision($user->user_id, ['super-admin', 'edit-user']);

        return $r|$user->user_id==Auth::id() ? Response::allow()
        : Response::deny('Unauthorized', 401);
    }
    /**
     * Determine whether the user can update any of the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function updateAny(User $user)
    {
        //
        $uh = new UserHelper();
        return $uh->checkPermision($user->user_id, ['super-admin', 'edit-user']) ? Response::allow()
        : Response::deny('Unauthorized', 401);
    }

    /**
     * Determine whether the user can delete the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function delete(User $user)
    {
        //
        $uh = new UserHelper();
        return $uh->checkPermision($user->user_id, ['super-admin', 'delete-user']) ? Response::allow()
        : Response::deny('Unauthorized', 401);
    }
}
