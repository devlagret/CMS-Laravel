<?php

namespace App\Policies;

use App\Helpers\UserHelper;
use App\Models\Config;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Http\Client\Response;

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
        $uh = new UserHelper();
        return $uh->checkPermision($user->user_id, ['super-admin', 'view-role']) ? Response::allow()
            : Response::deny('Unauthorized', 401);
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
        $uh = new UserHelper();
        return $uh->checkPermision($user->user_id, ['super-admin', 'view-role']) ? Response::allow()
            : Response::deny('Unauthorized', 401);
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
        $uh = new UserHelper();
        return $uh->checkPermision($user->user_id, ['super-admin', 'view-role']) ? Response::allow()
            : Response::deny('Unauthorized', 401);
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
        $uh = new UserHelper();
        return $uh->checkPermision($user->user_id, ['super-admin', 'view-role']) ? Response::allow()
            : Response::deny('Unauthorized', 401);
    }
}
