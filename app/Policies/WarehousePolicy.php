<?php

namespace App\Policies;

use App\Helpers\UserHelper;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class WarehousePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any warehouse.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
        $uh = new UserHelper();
        return $uh->checkPermision($user->user_id, ['view-warehouse', 'view-product-request']) ? Response::allow()
            : Response::deny('Unauthorized', 401);
    }

    /**
     * Determine whether the user can view the warehouse.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function view(User $user)
    {
        //
        $uh = new UserHelper();
        return $uh->checkPermision($user->user_id, ['super-admin']) ? Response::allow()
            : Response::deny('Unauthorized', 401);
    }

    /**
     * Determine whether the user can create warehouse.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
        $uh = new UserHelper();
        return $uh->checkPermision($user->user_id, ['super-admin', 'add-warehouse']) ? Response::allow()
            : Response::deny('Unauthorized', 401);
    }

    /**
     * Determine whether the user can update the warehouse.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function update(User $user)
    {
        //
        $uh = new UserHelper();
        return $uh->checkPermision($user->user_id, ['super-admin', 'edit-warehouse']) ? Response::allow()
            : Response::deny('Unauthorized', 401);
    }

    /**
     * Determine whether the user can delete the warehouse.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function delete(User $user)
    {
        //
        $uh = new UserHelper();
        return $uh->checkPermision($user->user_id, ['super-admin', 'delete-warehouse']) ? Response::allow()
            : Response::deny('Unauthorized', 401);
    }
}
