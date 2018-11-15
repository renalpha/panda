<?php

namespace Infrastructure\Repositories;

use Domain\Entities\PhotoAlbum\Photo;

/**
 * Class PhotoRepository
 * @package Infrastructure\Repositories
 */
class PhotoRepository extends AbstractRepository
{
    /**
     * PandaGroupRepository constructor.
     * @param Photo $model
     */
    public function __construct(Photo $model)
    {
        parent::__construct($model);
    }
}