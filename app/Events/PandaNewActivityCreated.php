<?php

namespace App\Events;

use Domain\Entities\PandaGroup\PandaGroup;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Class PandaNewActivityCreated
 * @package App\Events
 */
class PandaNewActivityCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var PandaGroup
     */
    protected $group;

    /**
     * Create a new event instance.
     *
     * @param PandaGroup $group
     */
    public function __construct(PandaGroup $group)
    {
        $this->group = $group;
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'status' => 'New activity',
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('users.group.notification.' . $this->group->id);
    }
}
