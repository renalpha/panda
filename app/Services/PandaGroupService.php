<?php

namespace App\Services;

use Domain\Entities\PandaGroup\PandaGroup;
use Domain\Entities\PandaGroup\PandaGroupUser;
use Infrastructure\Repositories\PandaGroupRepository;

/**
 * Class PandaGroupService
 * @package App\Services
 */
class PandaGroupService
{
    /**
     * @var PandaGroupRepository $groupRepository
     */
    private $groupRepository;

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
            collect($users)->each(function ($user) use ($group) {
                PandaGroupUser::create([
                    'user_id' => $user,
                    'panda_group_id' => $group->id,
                ]);
            });

            return true;
        } catch (\Exception $e) {
            throw new \Exception('Could not add user to Panda group');
        }
    }

    /**
     * @param array $params
     * @return PandaGroup
     */
    public function createGroup(array $params): PandaGroup
    {
        $group = $this->groupRepository->create($params);

        return $group->save();
    }

    /**
     * @param int $id
     * @param array $params
     * @return PandaGroup
     */
    public function updateGroup(int $id, array $params): PandaGroup
    {
        $group = $this->groupRepository->update($params, $id);

        return $group->save();
    }

    /**
     * @param array $params
     * @param int|null $id
     * @return PandaGroup
     */
    public function saveGroup(array $params, int $id = null)
    {
        if ($id !== null) {
            return $this->updateGroup($id, $params);
        } else {
            return $this->createGroup($params);
        }
    }
}