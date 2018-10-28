<?php

namespace Domain\Entities\PandaGroup;

use Domain\Common\AggregateRoot;
use Domain\Entities\PandaUser\PandaUser;

/**
 * Class PandaGroup
 * @package Domain\Entities\PandaGroup
 */
class PandaGroup extends AggregateRoot
{
    /**
     * @param PandaUser $user
     */
    public function addUserToPandaGroup(PandaUser $user)
    {

    }
}