<?php

namespace App\Policies;

use App\Helpers\UserHelper;
use App\Models\Batch;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class BatchPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any batches.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
        $uh = new UserHelper();
        return $uh->checkPermision($user->user_id, ['super-admin', 'view-batch']) ? Response::allow()
            : Response::deny('Unauthorized', 401);
    }

    /**
     * Determine whether the user can view the batch.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\batch  $batch
     * @return mixed
     */
    public function view(User $user)
    {
        //
        return 1;
    }

    /**
     * Determine whether the user can create batches.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
        $uh = new UserHelper();
        return $uh->checkPermision($user->user_id, ['super-admin', 'add-batch']) ? Response::allow()
            : Response::deny('Unauthorized', 401);
    }

    /**
     * Determine whether the user can update the batch.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\batch  $batch
     * @return mixed
     */
    public function update(User $user)
    {
        //
        $uh = new UserHelper();
        return $uh->checkPermision($user->user_id, ['super-admin', 'view-role']) ? Response::allow()
            : Response::deny('Unauthorized', 401);
    }

    public function updateb(User $user)
    {
        //
        $uh = new UserHelper();
        return $uh->checkPermision($user->user_id, ['edit-batch']) ? Response::allow()
            : Response::deny('Unauthorized', 401);
    }
    /**
     * Determine whether the user can delete the batch.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\batch  $batch
     * @return mixed
     */
    public function delete(User $user)
    {
        //
        $uh = new UserHelper();
        return $uh->checkPermision($user->user_id, ['super-admin', 'delete-batch']) ? Response::allow()
            : Response::deny('Unauthorized', 401);
    }
}
