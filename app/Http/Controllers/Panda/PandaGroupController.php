<?php

namespace App\Http\Controllers\Panda;

use App\Http\Requests\PostPandaGroupRequest;
use DataTables;
use Domain\Entities\PandaGroup\PandaGroup;
use Domain\Entities\PandaGroup\PandaGroupRole;
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $groups = $this->groupService->getGroupsByAuthenticatedUser();

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
        $groups = $this->groupService->getGroupsByAuthenticatedUser();

        return Datatables::of($groups)
            ->addColumn('name', function ($row) {
                return '<a href="' . route('group.show', ['label' => $row->label]) . '">' . $row->name . '</a>';
            })
            ->addColumn('manage', function ($row) {
                if (auth()->user()->can('group.manage')) {
                    return '<a href="' . route('group.edit', ['id' => $row->id]) . '" class="btn btn-sm btn-primary">Edit</a>
                        <a href="' . route('group.remove', ['id' => $row->id]) . '" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Remove</a>';
                }
            })
            ->rawColumns(['name', 'manage'])
            ->make(true);
    }
}