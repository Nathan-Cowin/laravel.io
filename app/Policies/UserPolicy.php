<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the current logged in user can see the admin section.
     */
    public function admin(User $user): bool
    {
        return $user->isAdmin() || $user->isModerator();
    }

    /**
     * Determine if the current logged in user can ban a user.
     */
    public function ban(User $loggedInUser, User $user): bool
    {
        return ($loggedInUser->isAdmin() && ! $user->isAdmin()) ||
            ($loggedInUser->isModerator() && ! $user->isAdmin() && ! $user->isModerator());
    }

    /**
     * Determine if the current logged in user can delete a user.
     */
    public function delete(User $loggedInUser, User $user): bool
    {
        return $loggedInUser->isAdmin() && ! $user->isAdmin();
    }
}
