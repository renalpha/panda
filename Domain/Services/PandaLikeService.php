<?php

namespace Domain\Services;

use App\Models\Notification;
use Domain\Entities\PandaComment\PandaComment;

/**
 * Class PandaLikeService
 *
 * @package Domain\Services
 */
class PandaLikeService
{
    /**
     * @var array
     */
    public $likeAbleTypes;

    /**
     * PandaLikeService constructor.
     */
    public function __construct()
    {
        $this->likeAbleTypes = [
            'groupNotification',
            'pandaComment',
        ];
    }

    /**
     * Like subject by type and id.
     *
     * @param string $type
     * @param string $id
     * @return bool
     * @throws \Exception
     */
    public function likeSubjectByTypeAndId(string $type, string $id): bool
    {
        switch ($type) {
            case 'groupNotification':
                $notification = Notification::where('id', $id)->firstOrFail();
                auth()->user()->toggleLike($notification);
                break;
            case 'pandaComment':
                $comment = PandaComment::where('id', $id)->firstOrFail();
                auth()->user()->toggleLike($comment);
                break;
        }
    }
}