<?php

namespace App\Policies;

use App\Helpers\UserHelper;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ProductOrderRequestPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any productOrderRequest.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
        $uh = new UserHelper();
        return $uh->checkPermision($user->user_id, ['super-admin', 'view-role', 'view-product-order-request']) ? Response::allow()
            : Response::deny('Unauthorized', 401);
    }

    /**
     * Determine whether the user can view the productOrderRequest.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function vieww(User $user)
    {
        //
        $uh = new UserHelper();
        return $uh->checkPermision($user->user_id, ['super-admin']) ? Response::allow()
            : Response::deny('Unauthorized', 401);
    }

    /**
     * Determine whether the user can create productOrderRequest.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
        $uh = new UserHelper();
        return $uh->checkPermision($user->user_id, ['super-admin', 'add-product-order-request']) ? Response::allow()
            : Response::deny('Unauthorized', 401);
    }

    /**
     * Determine whether the user can update the productOrderRequest.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function update(User $user)
    {
        //
        $uh = new UserHelper();
        return $uh->checkPermision($user->user_id, ['super-admin']) ? Response::allow()
            : Response::deny('Unauthorized', 401);
    }

    /**
     * Determine whether the user can delete the productOrderRequest.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function delete(User $user)
    {
        //
        $uh = new UserHelper();
        return $uh->checkPermision($user->user_id, ['super-admin', 'delete-product-order-request']) ? Response::allow()
            : Response::deny('Unauthorized', 401);
    }
    public function updatew(User $user)
    {
        //
        $uh = new UserHelper();
        return $uh->checkPermision($user->user_id, ['super-admin', 'edit-product-order-request']) ? Response::allow()
            : Response::deny('Unauthorized', 401);
    }
}
