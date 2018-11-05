<?php

namespace Domain\Entities\PandaComment;

use Domain\Services\PandaCommentService;
use Infrastructure\Repositories\PandaCommentRepository;

/**
 * Trait PandaCommentTrait
 * @package Domain\Entities\PandaComment
 */
trait PandaCommentTrait
{
    /**
     * @return mixed
     */
    public function comments()
    {
        return $this->morphMany(PandaComment::class, 'commentable')
            ->orderBy('created_at', 'asc');
    }

    /**
     * @param $object
     * @param $id
     * @param $data
     */
    public function commentOn($object, $id, $data)
    {
        $comment = new PandaCommentService(new PandaCommentRepository(new PandaComment()));

        $comment->commentSubjectByTypeAndId($object, $id, $data);
    }
}