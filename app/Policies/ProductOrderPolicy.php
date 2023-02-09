<?php

namespace App\Policies;

use App\Helpers\UserHelper;
use App\Models\ProductOrder;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ProductOrderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any productOrders.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
        $uh = new UserHelper();
        return $uh->checkPermision($user->user_id, ['super-admin', 'view-product-order']) ? Response::allow()
        : Response::deny('Unauthorized', 401);
    }

    /**
     * Determine whether the user can view the productOrder.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ProductOrder  $productOrder
     * @return mixed
     */
    public function view(User $user)
    {
        //
    }

    /**
     * Determine whether the user can create productOrders.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
        $uh = new UserHelper();
        return $uh->checkPermision($user->user_id, ['super-admin', 'add-product-order']) ? Response::allow()
        : Response::deny('Unauthorized', 401);
    }

    /**
     * Determine whether the user can update the productOrder.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ProductOrder  $productOrder
     * @return mixed
     */
    public function update(User $user)
    {
        //
        $uh = new UserHelper();
        return $uh->checkPermision($user->user_id, ['super-admin', 'edit-product-order']) ? Response::allow()
        : Response::deny('Unauthorized', 401);
    }

    /**
     * Determine whether the user can delete the productOrder.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ProductOrder  $productOrder
     * @return mixed
     */
    public function delete(User $user)
    {
        //
        $uh = new UserHelper();
        return $uh->checkPermision($user->user_id, ['super-admin', 'delete-product-order']) ? Response::allow()
        : Response::deny('Unauthorized', 401);
    }
}
