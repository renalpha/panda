<?php

namespace App\Console\Commands;

use App\Events\PandaNewActivityCreated;
use App\Notifications\PandaPointAcquired;
use Carbon\Carbon;
use Domain\Entities\PandaUser\PandaUser;
use Domain\Entities\PandaUser\PandaUserPoint;
use Domain\Services\PandaUserService;
use Illuminate\Console\Command;

/**
 * Class CheckPoints
 * @package App\Console\Commands
 */
class CheckPoints extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'panda:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Panda users check points';

    /**
     * @var PandaUserService
     */
    protected $userService;

    /**
     * Create a new command instance.
     *
     * @param PandaUserService $userService
     */
    public function __construct(PandaUserService $userService)
    {
        $this->userService = $userService;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $users = PandaUser::select('users.*')->join('panda_groups_users', function ($join) {
                $join->on('panda_groups_users.user_id', 'users.id');
            })->groupBy('users.id')->get();

            $this->info('Processing ' . count($users) . ' users.');

            $users->each(function ($user) {

                $groups = $this->userService->findGroupsByUserId($user->id);

                // From the moment that the user has registered.
                $userLastPoint = $user->created_at;

                // Override by last acquired point.
                if (isset($user->points) && $user->points()->orderBy('created_at', 'desc')->first() !== null) {
                    $userLastPoint = $user->points()->orderBy('created_at', 'desc')->first()->created_at;
                }

                $weeksPassed = $userLastPoint->diffInWeeks(Carbon::now());

                if (isset($groups)) {

                    $shouldAddPoints = false;
                    foreach ($groups as $group) {
                        if (isset($group->group) && $weeksPassed >= $group->group->weeks_count_points) {
                            $shouldAddPoints = true;
                            $group->group->notify(new PandaPointAcquired($user->id, $group->panda_group_id));
                            event(new PandaNewActivityCreated($group->group));
                        }
                    }

                    if ($shouldAddPoints === true) {
                        PandaUserPoint::create([
                            'user_id' => $user->id,
                            'amount' => 1,
                        ]);
                    }
                }
            });
        } catch (\Exception $e) {
            dd($e->getTraceAsString());
        }
    }
}
