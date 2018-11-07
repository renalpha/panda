<?php

namespace Domain\Entities\PandaUser;

use Cog\Contracts\Love\Liker\Models\Liker as LikerContract;
use Cog\Laravel\Love\Liker\Models\Traits\Liker;
use Domain\Common\AggregateRoot;
use Domain\Entities\PandaGroup\PandaGroupUser;
use Illuminate\Notifications\Notifiable;

/**
 * Class PandaUser
 * @package Domain\Entities\PandaUser
 */
class PandaUser extends AggregateRoot implements LikerContract
{
    use PandaUserTrait, Liker, Notifiable;

    /**
     * Database table.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function groups()
    {
        return $this->hasMany(new PandaGroupUser(), 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function points()
    {
        return $this->hasMany(new PandaUserPoint(), 'user_id', 'id');
    }
}