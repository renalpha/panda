<?php

namespace App\Notifications;

use Domain\Entities\PandaUser\PandaUser;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PandaPointReset extends Notification
{
    use Queueable;

    /**
     * @var int
     */
    protected $userId;

    /**
     * @var int
     */
    protected $groupId;

    /**
     * PandaGroupUserJoined constructor.
     * @param int $userId
     * @param int $groupId
     */
    public function __construct(int $userId, int $groupId)
    {
        $this->userId = $userId;
        $this->groupId = $groupId;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable): array
    {
        $name = PandaUser::find($this->userId)->name;

        return [
            'user_id' => $this->userId,
            'group_id' => $this->groupId,
            'name' => $name,
            'message' => $name . ' has resetted it\'s points. WOW!',
        ];
    }
}
