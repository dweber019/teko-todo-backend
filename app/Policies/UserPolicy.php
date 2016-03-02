<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->hasRole('admin')) {
            return true;
        }
    }

    /**
     * Determine if the given user can be store by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $userE
     * @return bool
     */
    public function create(User $user, User $userE) {
        return false;
    }

    /**
     * Determine if the given user can be read by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $userE
     * @return bool
     */
    public function read(User $user, User $userE) {
        return $this->isEntityOwnedByUser($user, $userE);
    }

    /**
     * Determine if the given user can be update by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $userE
     * @return bool
     */
    public function update(User $user, User $userE) {
        return $this->isEntityOwnedByUser($user, $userE);
    }

    /**
     * Determine if the given user can be delete by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $userE
     * @return bool
     */
    public function delete(User $user, User $userE) {
        return false;
    }

    /**
     * Determine if the given user can be updated by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $userE
     * @return bool
     */
    public function isEntityOwnedByUser(User $user, User $userE)
    {
        return $user->id == $userE->id;
    }
}
