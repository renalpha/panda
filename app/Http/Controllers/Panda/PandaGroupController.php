<?php

namespace App\Http\Controllers\Panda;

use App\Http\Requests\PostPandaGroupRequest;
use DataTables;
use Domain\Entities\PandaGroup\PandaGroup;
use Domain\Services\PandaGroupService;
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

    /**
     * Get group by label.
     *
     * @param string $label
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function show(string $label)
    {
        $group = $this->groupService->getGroupByLabelAndAuthenticatedUser($label);

        return view('pandaGroup.show', [
            'group' => $group,
        ]);
    }

    /**
     * @param PandaGroup $pandaGroup
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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

        $request->session()->flash('status', $pandaGroup->id !== null ? 'Group has successfully been updated!' : 'Group has successfully been created!');

        return redirect()
            ->to('/');
    }

    /**
     * Get users by group.
     *
     * @param string $label
     * @return mixed
     */
    public function getUsersOverviewGroup(string $label)
    {
        $group = $this->groupService->getGroupByLabelAndAuthenticatedUser($label);

        return Datatables::of($group->users()->get())
            ->addColumn('name', function ($row) {
                return $row->user->name;
            })
            ->addColumn('email', function ($row) {
                return $row->user->email;
            })
            ->make(true);
    }
}