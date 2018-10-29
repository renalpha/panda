<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostPandaGroupRequest;
use App\Services\PandaGroupService;
use Domain\Entities\PandaGroup\PandaGroup;
use Illuminate\Http\RedirectResponse;
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
     * @throws \Exception
     */
    public function store(PostPandaGroupRequest $request, PandaGroup $pandaGroup = null): RedirectResponse
    {
        $group = $this->groupService->saveGroup([
            'name' => $request->name,
        ], $pandaGroup->id ?? null);

        if ($request->users !== null) {
            $this->groupService->addUsersToGroup($request->users, $group);
        }

        return redirect()
            ->to('/');
    }
}