<?php

namespace App\Http\Controllers\Panda;

use App\Http\Controllers\Controller;
use Domain\Services\PandaLikeService;
use Illuminate\Http\Request;

/**
 * Class PandaLikeController
 *
 * @package App\Http\Controllers\Panda
 */
class PandaLikeController extends Controller
{
    protected $likeService;

    /**
     * PandaLikeController constructor.
     *
     * @param PandaLikeService $likeService
     */
    public function __construct(PandaLikeService $likeService)
    {
        $this->likeService = $likeService;
    }

    /**
     * Like action.
     *
     * @param Request $request
     * @param string $type
     * @param string $id
     * @throws \Exception
     */
    public function like(Request $request, string $type, string $id)
    {
        if (!in_array($type, $this->likeService->likeAbleTypes, true)) {
            throw new \Exception('This subject type is not supported...');
        }

        $this->likeService->likeSubjectByTypeAndId($type, $id);
    }
}