<?php

namespace App\Events;

use App\Models\Notification;
use Domain\Entities\PandaComment\PandaComment;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Class PandaGroupCommentCreated
 *
 * @package App\Events
 */
class PandaGroupCommentNotificationCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var PandaComment
     */
    protected $comment;

    /**
     * @var
     */
    protected $notification;

    /**
     * PandaGroupCommentCreated constructor.
     *
     * @param PandaComment $comment
     */
    public function __construct(PandaComment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Get group by notification.
     *
     * @param $notificationId
     * @return mixed
     */
    protected function getGroup($notificationId)
    {
        $notification = Notification::findOrFail($notificationId);

        $this->notification = $notification;

        return $notification->data['group_id'];
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'comment' => $this->comment->toArray(),
            'nortification' => $this->notification->toArray(),
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        $groupId = $this->getGroup($this->comment->commentable_id);
        return new PrivateChannel('users.group.notification.' . $groupId);
    }
}
