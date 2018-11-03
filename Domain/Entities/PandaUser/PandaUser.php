<?php

namespace Domain\Entities\PandaUser;

use Cog\Contracts\Love\Liker\Models\Liker as LikerContract;
use Cog\Laravel\Love\Liker\Models\Traits\Liker;
use Domain\Common\AggregateRoot;


/**
 * Class PandaUser
 * @package Domain\Entities\PandaUser
 */
class PandaUser extends AggregateRoot implements LikerContract
{
    use Liker;
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