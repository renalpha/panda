<?php

namespace Infrastructure\Repositories;

use Domain\Entities\PandaComment\PandaComment;

/**
 * Class PandaCommentRepository
 * @package Infrastructure\Repositories
 */
class PandaCommentRepository extends AbstractRepository
{
    /**
     * PandaGroupRepository constructor.
     * @param PandaComment $model
     */
    public function __construct(PandaComment $model)
    {
        parent::__construct($model);
    }
}