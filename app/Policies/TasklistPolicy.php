<?php

namespace App\Policies;

use App\Models\Tasklist;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TasklistPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->hasRole('admin')) {
            return true;
        }
    }

    /**
     * Determine if the given tasklist can be store by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Tasklist  $tasklist
     * @return bool
     */
    public function create(User $user, Tasklist $tasklist) {
        return true;
    }

    /**
     * Determine if the given tasklist can be read by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Tasklist  $tasklist
     * @return bool
     */
    public function read(User $user, Tasklist $tasklist) {
        return $this->isEntityOwnedByUser($user,$tasklist);
    }

    /**
     * Determine if the given tasklist can be update by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Tasklist  $tasklist
     * @return bool
     */
    public function update(User $user, Tasklist $tasklist) {
        return $this->isEntityOwnedByUser($user,$tasklist);
    }

    /**
     * Determine if the given tasklist can be delete by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Tasklist  $tasklist
     * @return bool
     */
    public function delete(User $user, Tasklist $tasklist) {
        return $this->isEntityOwnedByUser($user,$tasklist);
    }

    /**
     * Helper function for entities
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Tasklist  $tasklist
     * @return bool
     */
    public function isEntityOwnedByUser(User $user, Tasklist $tasklist)
    {
        return $tasklist->have('users', $user->id);
    }
}
