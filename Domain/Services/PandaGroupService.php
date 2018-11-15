<?php

namespace Domain\Services;

use App\Events\PandaNewActivityCreated;
use App\Notifications\PandaGroupUserJoined;
use App\Notifications\PandaPointReset;
use Domain\Entities\PandaGroup\PandaGroup;
use Domain\Entities\PandaGroup\PandaGroupUser;
use Domain\Entities\PandaUser\PandaUserPoint;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Infrastructure\Repositories\PandaGroupRepository;

/**
 * Class PandaGroupService
 * @package Domain\Services
 */
class PandaGroupService extends AbstractService
{
    /**
     * PandaGroupService constructor.
     * @param PandaGroupRepository $groupRepository
     */
    public function __construct(PandaGroupRepository $groupRepository)
    {
        $this->repository = $groupRepository;
    }

    /**
     * @param array $users
     * @param PandaGroup $group
     * @return bool
     * @throws \Exception
     */
    public function addUsersToGroup(array $users, PandaGroup $group): bool
    {
        try {
            // Filter already existing users before adding to group.
            collect($users)->filter(function ($user) use ($group) {
                if (!$group->findUserInGroup($user['user_id'])) {
                    return true;
                }
                return false;
            })->each(function ($user) use ($group) {
                PandaGroupUser::create([
                    'user_id' => $user['user_id'],
                    'panda_group_id' => $group->id,
                    'panda_group_role_id' => $user['role_id'],
                ]);

                $group->notify(new PandaGroupUserJoined($user['user_id'], $group->id));

                event(new PandaNewActivityCreated($group));
            });

            return true;
        } catch (\Exception $e) {
            dd($e->getTraceAsString());
            throw new \Exception('Could not add user to Panda group');
        }
    }

    /**
     * @param array $params
     * @param int|null $id
     * @return PandaGroup
     */
    public function saveGroup(array $params, int $id = null): PandaGroup
    {
        if ($id !== null) {
            return $this->update($id, $params);
        } else {
            $params['uuid'] = Str::uuid();
            return $this->create($params);
        }
    }

    /**
     * @param $label
     * @return mixed
     */
    public function getGroupByLabel($label)
    {
        return $this->repository->getGroupByLabel($label)->firstOrFail();
    }

    /**
     * @param $label
     * @param $uuid
     * @return mixed
     */
    public function getGroupByLabelAndUuid($label, $uuid)
    {
        return $this->repository->findByUuid($uuid)->getGroupByLabel($label)->firstOrFail();
    }

    /**
     * @param $label
     * @return mixed|void
     */
    public function getGroupByLabelAndAuthenticatedUser($label)
    {
        $group = $this->repository->getGroupByLabel($label)->firstOrFail();

        if ($group->findUserById(auth()->user()->id) === false) {
            return abort(404);
        }

        return $group;
    }

    /**
     * @return mixed
     */
    public function groupsByAuthenticatedUser()
    {
        return $this->repository->groupsByAuthenticatedUser();
    }

    /**
     * @param PandaGroup $group
     * @throws \Exception
     */
    public function deleteGroupAndUsers(PandaGroup $group): void
    {
        $this->deleteUsersFromGroup($group);

        $group->delete();
    }

    /**
     * @param PandaGroup $group
     * @param array|null $users
     */
    public function deleteUsersFromGroup(PandaGroup $group, array $users = null)
    {
        $group = $group->users();

        if (isset($users) && count($users) > 0) {
            $group = $group->whereIn('user_id', $users);
        }

        $group->delete();
    }

    /**
     * @param int $userId
     * @param Collection $groups
     */
    public function clearPointsByUser(int $userId, Collection $groups): void
    {
        foreach ($groups as $groupUser) {
            $group = $this->repository->find($groupUser->panda_group_id);
            if (isset($group)) {
                $group->notify(new PandaPointReset($userId, $groupUser->group->id));
            }
        }

        $points = PandaUserPoint::where('user_id', $userId)->get();

        foreach ($points as $point) {
            $point->delete();
        }

        // Create a 0 point to keep track of last time you did something.
        PandaUserPoint::create([
            'user_id' => $userId,
            'amount' => 0,
        ]);
    }
}