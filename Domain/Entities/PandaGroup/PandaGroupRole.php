<?php

namespace Domain\Entities\PandaGroup;

use Domain\Common\Entity;

/**
 * Class PandaGroupRole
 *
 * @package Domain\Entities\PandaGroup
 */
class PandaGroupRole extends Entity
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'label'];
}