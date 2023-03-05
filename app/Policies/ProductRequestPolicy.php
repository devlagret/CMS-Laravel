<?php

namespace App\Policies;

use App\Helpers\UserHelper;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ProductRequestPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any productRequest.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
        $uh = new UserHelper();
        return $uh->checkPermision($user->user_id, ['super-admin', 'view-product-request']) ? Response::allow()
            : Response::deny('Unauthorized', 401);
    }

    /**
     * Determine whether the user can view the productRequest.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function vieww(User $user)
    {
        $rid = Role::where('name', 'admingudang')->first('role_id');
        $uh = new UserHelper();
        return $user->role_id == $rid->role_id ? Response::allow()
            : Response::deny('Unauthorized', 401);
    }

    /**
     * Determine whether the user can create productRequest.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
        $uh = new UserHelper();
        return $uh->checkPermision($user->user_id, ['super-admin', 'add-product-request']) ? Response::allow()
            : Response::deny('Unauthorized', 401);
    }

    /**
     * Determine whether the user can update the productRequest.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function update(User $user)
    {
        //
        $uh = new UserHelper();
        return $uh->checkPermision($user->user_id, ['edit-product-request']) ? Response::allow()
            : Response::deny('Unauthorized', 401);
    }

    /**
     * Determine whether the user can delete the productRequest.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function delete(User $user)
    {
        //
        $uh = new UserHelper();
        return $uh->checkPermision($user->user_id, ['super-admin', 'delete-product-request']) ? Response::allow()
            : Response::deny('Unauthorized', 401);
    }
    public function checkRoleW(User $user)
    {
        $rid = Role::where('name', 'admingudang')->first();
        $uh = new UserHelper();
        return $user->role_id == $rid->role_id ? Response::allow()
            : Response::deny('Unauthorized', 401);
    }
}
