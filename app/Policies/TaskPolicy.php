<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class TaskPolicy
 * @package App\Policies
 */
class TaskPolicy
{
    use HandlesAuthorization;

    /**
     * @param $user
     * @param $ability
     * @return bool
     */
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
     * @param  \App\Models\Task  $task
     * @return bool
     */
    public function create(User $user, Task $task) {
        return $this->isEntityOwnedByUser($user,$task);
    }

    /**
     * Determine if the given tasklist can be read by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Task  $task
     * @return bool
     */
    public function read(User $user, Task $task) {
        return $this->isEntityOwnedByUser($user,$task);
    }

    /**
     * Determine if the given tasklist can be update by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Task  $task
     * @return bool
     */
    public function update(User $user, Task $task) {
        return $this->isEntityOwnedByUser($user,$task);
    }

    /**
     * Determine if the given tasklist can be delete by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Task  $task
     * @return bool
     */
    public function delete(User $user, Task $task) {
        return $this->isEntityOwnedByUser($user,$task);
    }

    /**
     * Determine if the given post can be updated by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Task  $task
     * @return bool
     */
    public function isEntityOwnedByUser(User $user, Task $task)
    {
        return $task->tasklist()->first()->have('users', $user->id) || $task->userId === $user->id;
    }
}
