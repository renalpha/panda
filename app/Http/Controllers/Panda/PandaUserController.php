<?php

namespace App\Http\Controllers\Panda;

use App\Http\Controllers\Controller;
use Domain\Services\PandaGroupService;
use Domain\Services\PandaUserService;
use Illuminate\Http\Request;

/**
 * Class PandaUserController
 * @package App\Http\Controllers\Panda
 */
class PandaUserController extends Controller
{
    /**
     * @var PandaGroupService
     */
    protected $groupService;

    /**
     * @var PandaUserService
     */
    protected $userService;

    /**
     * PandaUserController constructor.
     *
     * @param PandaGroupService $groupService
     * @param PandaUserService $userService
     */
    public function __construct(PandaGroupService $groupService, PandaUserService $userService)
    {
        $this->groupService = $groupService;
        $this->userService = $userService;
    }

    /**
     * Reset points.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reset(Request $request)
    {
        $userId = auth()->user()->id;

        $groups = $this->userService->findGroupsByUserId($userId);

        $this->groupService->clearPointsByUser($userId, $groups);

        $request->session()->flash('info', 'Resetted points.');

        return redirect()
            ->back();
    }
}