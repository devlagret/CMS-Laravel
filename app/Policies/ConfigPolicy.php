<?php

namespace App\Policies;

use App\Models\Config;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConfigPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any configs.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the config.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Config  $config
     * @return mixed
     */
    public function view(User $user, Config $config)
    {
        //
    }

    /**
     * Determine whether the user can create configs.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the config.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Config  $config
     * @return mixed
     */
    public function update(User $user, Config $config)
    {
        //
    }

    /**
     * Determine whether the user can delete the config.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Config  $config
     * @return mixed
     */
    public function delete(User $user, Config $config)
    {
        //
    }
}
