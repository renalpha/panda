<?php

namespace Infrastructure\Repositories;

use Domain\Entities\PandaGroup\PandaGroup;

/**
 * Class PandaGroupRepository
 * @package Infrastructure\Repositories
 */
class PandaGroupRepository extends AbstractRepository
{
    /**
     * PandaGroupRepository constructor.
     * @param PandaGroup $model
     */
    public function __construct(PandaGroup $model)
    {
        parent::__construct($model);
    }

    /**
     * @param string $label
     * @return $this
     */
    public function getGroupByLabel(string $label): self
    {
        $this->model = $this->model->where('label', '=', $label);
        return $this;
    }

    /**
     * @return mixed
     */
    public function groupsByAuthenticatedUser()
    {
        $this->model = $this->model
            ->select(['panda_groups.*', 'panda_groups_users.panda_group_id as panda_group_id'])
            ->join('panda_groups_users', function ($join) {
                $join->on('panda_groups_users.panda_group_id', '=', 'panda_groups.id');
            })->where('panda_groups_users.user_id', '=', auth()->user()->id)
            ->groupBy('panda_groups.id');
        return $this;
    }
}