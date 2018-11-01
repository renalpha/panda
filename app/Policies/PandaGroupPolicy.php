<?php

namespace App\Policies;

use App\Models\User;
use Domain\Entities\PandaGroup\PandaGroup;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class PandaGroupPolicy
 * @package App\Policies
 */
class PandaGroupPolicy
{
    use HandlesAuthorization;

    /**
     * Manage policy for group admins.
     *
     * @param User $user
     * @param PandaGroup $group
     * @return bool
     */
    public function manage(User $user, PandaGroup $group): bool
    {
        $users = $group->users()
            ->join('panda_group_roles', 'panda_groups_users.panda_group_role_id', 'panda_group_roles.id')
            ->where('panda_group_roles.label', 'admin')
            ->get()
            ->toArray();

        return in_array($user->id, array_column($users, 'user_id'), true);
    }
}
