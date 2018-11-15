<?php

namespace App\Models;

use Cog\Contracts\Love\Likeable\Models\Likeable as LikeableContract;
use Cog\Laravel\Love\Likeable\Models\Traits\Likeable;
use Domain\Entities\PandaComment\PandaComment;
use Illuminate\Notifications\DatabaseNotification;

/**
 * Class Notification
 * @package App\Models
 */
class Notification extends DatabaseNotification implements LikeableContract
{
    use Likeable, LikesUsersTrait;

    /**
     * @return mixed
     */
    public function comments()
    {
        return $this->morphMany(PandaComment::class, 'commentable')
            ->orderBy('created_at', 'desc');
    }
}