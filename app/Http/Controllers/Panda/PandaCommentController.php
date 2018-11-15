<?php

namespace App\Http\Controllers\Panda;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostCommentRequest;
use App\Models\Notification;
use Domain\Services\PandaCommentService;

/**
 * Class PandaCommentController
 * @package App\Http\Controllers\Panda
 */
class PandaCommentController extends Controller
{
    /**
     * @var PandaCommentService
     */
    protected $commentService;

    /**
     * PandaCommentController constructor.
     * @param PandaCommentService $commentService
     */
    public function __construct(PandaCommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    /**
     * @param PostCommentRequest $request
     * @param string $type
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function comment(PostCommentRequest $request, string $type, string $id)
    {
        switch ($type) {
            case 'groupNotification':
                $notification = Notification::where('id', $id)->firstOrFail();
                auth()->user()->commentOn($notification, $id, [
                    'comment' => $request->comment,
                    'profile_picture' => '/images/' . auth()->user()->profile_picture,
                    'name' => auth()->user()->name,
                ]);
                break;
            case 'pandaComment':
                break;
            case 'photoAlbumComment':
                break;
            case 'photoComment':
                break;
        }

        $request->session()->flash('info', 'Comment posted.');

        return redirect()
            ->back();
    }
}