<?php

namespace App\Policies;

use App\Models\ProductOrder;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

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
    }

    /**
     * Determine whether the user can view the productOrder.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ProductOrder  $productOrder
     * @return mixed
     */
    public function view(User $user, ProductOrder $productOrder)
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
    }

    /**
     * Determine whether the user can update the productOrder.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ProductOrder  $productOrder
     * @return mixed
     */
    public function update(User $user, ProductOrder $productOrder)
    {
        //
    }

    /**
     * Determine whether the user can delete the productOrder.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ProductOrder  $productOrder
     * @return mixed
     */
    public function delete(User $user, ProductOrder $productOrder)
    {
        //
    }
}
