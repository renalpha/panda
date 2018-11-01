<?php

namespace Domain\Entities\PandaGroup;

use Domain\Entities\PandaUser\PandaUser;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class PandaGroupUser
 * @package Domain\Entities\PandaGroup
 */
class PandaGroupUser extends Pivot
{
    /**
     * @var string
     */
    protected $table = 'panda_groups_users';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(new PandaUser());
    }

    /**
     * @return BelongsTo
     */
    public function group()
    {
        return $this->belongsTo(new PandaGroup(), 'panda_group_id', 'id');
    }
}