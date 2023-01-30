<?php

namespace App\Policies;

use App\Models\Supplier;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SupplierPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any suppliers.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the supplier.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Supplier  $supplier
     * @return mixed
     */
    public function view(User $user, Supplier $supplier)
    {
        //
    }

    /**
     * Determine whether the user can create suppliers.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the supplier.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Supplier  $supplier
     * @return mixed
     */
    public function update(User $user, Supplier $supplier)
    {
        //
    }

    /**
     * Determine whether the user can delete the supplier.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Supplier  $supplier
     * @return mixed
     */
    public function delete(User $user, Supplier $supplier)
    {
        //
    }
}
