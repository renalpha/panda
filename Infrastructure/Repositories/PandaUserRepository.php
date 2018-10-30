<?php

namespace Infrastructure\Repositories;

use Domain\Entities\PandaUser\PandaUser;

/**
 * Class PandaUserRepository
 * @package Infrastructure\Repositories
 */
class PandaUserRepository extends AbstractRepository
{
    /**
     * PandaGroupRepository constructor.
     * @param PandaUser $model
     */
    public function __construct(PandaUser $model)
    {
        parent::__construct($model);
    }
}