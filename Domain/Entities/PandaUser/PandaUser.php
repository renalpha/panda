<?php

namespace Domain\Entities\PandaUser;

use Domain\Common\AggregateRoot;
use Domain\Entities\PandaGroup\PandaGroup;

/**
 * Class PandaUser
 * @package Domain\Entities\PandaUser
 */
class PandaUser extends AggregateRoot
{
    /**
     * Database table.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function points()
    {
        return $this->hasMany(new PandaUserPoint(), 'user_id');
    }
}