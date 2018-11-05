<?php

namespace Domain\Entities\PandaUser;

use Domain\Entities\PandaComment\PandaCommentTrait;
use Vinkla\Hashids\Facades\Hashids;

/**
 * Trait PandaUserTrait
 * @package Domain\Entities\PandaUser
 */
trait PandaUserTrait
{
    use PandaCommentTrait;

    /**
     * Get ecnrypted userID.
     *
     * @return string
     */
    public function getEncryptedUserIdAttribute(): string
    {
        return Hashids::encode($this->id);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function points()
    {
        return $this->hasMany(new PandaUserPoint(), 'user_id');
    }

    public function getProfilePictureAttribute()
    {
        return 'placeholder_profile.png';
    }
}