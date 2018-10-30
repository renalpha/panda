<?php

namespace Domain\Entities\PandaGroup;

use Domain\Common\AggregateRoot;
use Domain\Entities\PandaUser\PandaUser;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * Class PandaGroup
 * @package Domain\Entities\PandaGroup
 */
class PandaGroup extends AggregateRoot
{
    /**
     * @param int $id
     * @return bool
     */
    public function findUserById(int $id): bool
    {
        return $this->users->contains('user_id', $id);
    }

    /**
     * @return HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(new PandaGroupUser());
    }
}