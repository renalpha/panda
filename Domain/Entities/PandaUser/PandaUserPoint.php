<?php

namespace Domain\Entities\PandaUser;

use Domain\Common\Entity;

/**
 * Class PandaUserPoint
 * @package Domain\Entities\PandaUser
 */
class PandaUserPoint extends Entity
{
    /**
     * Mass assign variables.
     *
     * @var array
     */
    protected $fillable = ['amount', 'user_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(new PandaUser());
    }
}