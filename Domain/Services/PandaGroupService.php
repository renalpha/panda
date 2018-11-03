<?php

namespace Domain\Services;

use App\Notifications\PandaGroupUserJoined;
use Domain\Entities\PandaGroup\PandaGroup;
use Domain\Entities\PandaGroup\PandaGroupUser;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Support\Str;
use Infrastructure\Repositories\PandaGroupRepository;

/**
 * Class PandaGroupService
 * @package Domain\Services
 */
class PandaGroupService
{
    /**
     * @var PandaGroupRepository $groupRepository
     */
    public $groupRepository;

    /**
     * PandaGroupService constructor.
     * @param PandaGroupRepository $groupRepository
     */
    public function __construct(PandaGroupRepository $groupRepository)
    {
        $this->groupRepository = $groupRepository;
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
            });

            return true;
        } catch (\Exception $e) {
            dd($e->getTraceAsString());
            throw new \Exception('Could not add user to Panda group');
        }
    }

    /**
     * @param array $params
     * @return PandaGroup
     */
    public function createGroup(array $params): PandaGroup
    {
        $params['uuid'] = Str::uuid();

        $group = $this->groupRepository->create($params);

        $group->save();

        return $group;
    }

    /**
     * @param int $id
     * @param array $params
     * @return PandaGroup
     */
    public function updateGroup(int $id, array $params): PandaGroup
    {
        $group = $this->groupRepository->update($params, $id);

        $group->save();

        return $group;
    }

    /**
     * @param array $params
     * @param int|null $id
     * @return PandaGroup
     */
    public function saveGroup(array $params, int $id = null): PandaGroup
    {
        if ($id !== null) {
            return $this->updateGroup($id, $params);
        } else {
            return $this->createGroup($params);
        }
    }

    /**
     * @param $label
     * @return mixed
     */
    public function getGroupByLabel($label)
    {
        return $this->groupRepository->getGroupByLabel($label)->firstOrFail();
    }

    /**
     * @param $label
     * @param $uuid
     * @return mixed
     */
    public function getGroupByLabelAndUuid($label, $uuid)
    {
        return $this->groupRepository->findByUuid($uuid)->getGroupByLabel($label)->firstOrFail();
    }

    /**
     * @param $label
     * @return mixed|void
     */
    public function getGroupByLabelAndAuthenticatedUser($label)
    {
        $group = $this->groupRepository->getGroupByLabel($label)->firstOrFail();

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
        return $this->groupRepository->groupsByAuthenticatedUser();
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
}