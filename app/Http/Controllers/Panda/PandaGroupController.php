<?php

namespace App\Http\Controllers\Panda;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostPandaGroupRequest;
use DataTables;
use Domain\Entities\PandaGroup\PandaGroup;
use Domain\Entities\PandaGroup\PandaGroupRole;
use Domain\Services\PandaGroupService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $groups = $this->groupService->groupsByAuthenticatedUser()->get();

        return view('pandaGroup.index', [
            'groups' => $groups,
        ]);
    }

    /**
     * Get group by label.
     *
     * @param string $label
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(string $label)
    {
        $group = $this->groupService->getGroupByLabelAndAuthenticatedUser($label);

        return view('pandaGroup.show', [
            'group' => $group,
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('pandaGroup.create');
    }

    /**
     * @param PandaGroup $pandaGroup
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(PandaGroup $pandaGroup)
    {
        $this->authorize('manage', $pandaGroup);

        return view('pandaGroup.edit', ['group' => $pandaGroup]);
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
            'label' => str_slug($request->name),
        ], $pandaGroup->id ?? null);

        $users = $request->users ?? [['user_id' => auth()->user()->id, 'role_id' => PandaGroupRole::where('label', 'admin')->first()->id]];

        $this->groupService->addUsersToGroup($users, $group);

        $request->session()->flash('status', isset($pandaGroup->id) && $pandaGroup->id !== null ? 'Group has successfully been updated!' : 'Group has successfully been created!');

        return redirect()
            ->route('group.show', ['label' => $group->label]);
    }

    /**
     * @param Request $request
     * @param PandaGroup $pandaGroup
     * @return RedirectResponse
     * @throws \Exception
     */
    public function remove(Request $request, PandaGroup $pandaGroup)
    {
        $this->groupService->deleteGroupAndUsers($pandaGroup);

        $request->session()->flash('status', 'Successfully deleted group');

        return redirect()
            ->back();
    }

    /**
     * Group invitation.
     *
     * @param string $label
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function invite(string $label)
    {
        if (!auth()->check()) {
            return redirect()->route('login')
                ->with('info', 'You need to be logged in.');
        }

        $group = $this->groupService->getGroupByLabel($label);

        if ($group->findUserInGroup(auth()->user())) {
            return redirect()->route('group.index')
                ->with('info', 'You are already a member of this group.');
        }

        return view('pandaGroup.invite', ['group' => $group]);
    }

    /**
     * AJAX DataTables
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
            ->addColumn('points', function ($row) {
                return $row->user->points->count();
            })
            ->make(true);
    }

    /**
     * AJAX DataTables
     * Get groups by user.
     *
     * @return mixed
     */
    public function getGroupsByUser()
    {
        $groups = $this->groupService->groupsByAuthenticatedUser()->get();

        return Datatables::of($groups)
            ->addColumn('name', function ($row) {
                return '<a href="' . route('group.show', ['label' => $row->label]) . '">' . $row->name . '</a>';
            })
            ->addColumn('members', function ($row) {
                return $row->users->count();
            })
            ->addColumn('manage', function ($row) {
//                if (auth()->user()->can('manage', $row)) {
//                    if (auth()->user()->can('group.manage')) {
                return '<a href="' . route('group.edit', ['id' => $row->panda_group_id]) . '" class="btn btn-sm btn-primary">Edit</a>
                        <a href="' . route('group.remove', ['id' => $row->panda_group_id]) . '" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Remove</a>';
//                    }
//                }
            })
            ->rawColumns(['name', 'manage'])
            ->make(true);
    }
}