<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

abstract class BasePolicy
{
    use HandlesAuthorization;

    /**
     * Perform pre-authorization checks.
     *
     * @param User $user
     * @param string $ability
     *
     * @return void|bool
     */
    public function before(User $user, string $ability)
    {
        if ($user->roleId == 1) {
            return true;
        }

        return;
    }

    /**
     * Allow the user access if they have the warehouse role
     *
     * @param User $user
     *
     * @return bool
     */
    protected function isUserOfWarehouseRole(User $user): bool
    {
        return $this->isUserOfRole($user, 3);
    }

    /**
     * Check to see if the given user has the given role
     *
     * @param User $user
     * @param int $role
     *
     * @return bool
     */
    private function isUserOfRole(User $user, int $role): bool
    {
        if ($user->roleId === $role) {
            return true;
        }

        return false;
    }
}
