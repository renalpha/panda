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
}