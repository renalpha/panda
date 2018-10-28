<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostPandaGroupRequest;
use App\Services\PandaGroupService;
use Domain\Entities\PandaGroup\PandaGroup;
use Illuminate\Routing\Controller;

/**
 * Class PandaGroupController
 * @package App\Http\Controllers
 */
class PandaGroupController extends Controller
{
    /**
     * @var PandaGroupService $groupService
     */
    private $groupService;

    /**
     * PandaGroupController constructor.
     * @param PandaGroupService $groupService
     */
    public function __construct(PandaGroupService $groupService)
    {
        $this->groupService = $groupService;
    }

    public function index()
    {
        return view();
    }

    public function edit(PandaGroup $pandaGroup)
    {
        return view();
    }

    /**
     * @param PostPandaGroupRequest $request
     * @param PandaGroup|null $pandaGroup
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PostPandaGroupRequest $request, PandaGroup $pandaGroup = null)
    {
        if ($pandaGroup === null) {
            $group = $this->groupService->updateGroup([
                'name' => $request->name,
            ]);
        } else {
            $group = $this->groupService->createGroup([
                'name' => $request->name,
            ]);
        }

        if ($request->users !== null) {
            $this->groupService->addUSersToGroup($request->users, $group);
        }

        return redirect()
            ->to('/');
    }
}