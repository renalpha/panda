<?php

namespace Domain\Services;

use Infrastructure\Repositories\PandaCommentRepository;

/**
 * Class PandaCommentService
 * @package Domain\Services
 */
class PandaCommentService
{
    /**
     * @var PandaCommentRepository
     */
    protected $commentRepository;

    /**
     * PandaCommentService constructor.
     * @param PandaCommentRepository $commentRepository
     */
    public function __construct(PandaCommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    /**
     * @param $type
     * @param string $id
     * @param array $data
     */
    public function commentSubjectByTypeAndId($type, string $id, array $data)
    {
        $comment = $this->commentRepository->create([
            'commentable_id' => $id,
            'commentable_type' => get_class($type),
            'user_id' => auth()->user()->id,
            'data' => json_encode($data),
        ]);
    }
}