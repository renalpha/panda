<?php

namespace Domain\Entities\PandaUser;

use App\Models\HasRolesTrait;
use Domain\Entities\PandaComment\PandaCommentTrait;
use Vinkla\Hashids\Facades\Hashids;

/**
 * Trait PandaUserTrait
 * @package Domain\Entities\PandaUser
 */
trait PandaUserTrait
{
    use HasRolesTrait, PandaCommentTrait;

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

    /**
     * Get profile picture.
     *
     * @return string
     */
    public function getProfilePictureAttribute()
    {
        return 'placeholder_profile.png';
    }

    /**
     * The channels the user receives notification broadcasts on.
     *
     * @return string
     */
    public function receivesBroadcastNotificationsOn(): string
    {
        return 'users.' . $this->id;
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return $this->hasRole('administrator');
    }
}