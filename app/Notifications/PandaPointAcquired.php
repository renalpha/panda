<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PandaPointAcquired extends Notification
{
    use Queueable;

    /**
     * @var int
     */
    private $groupId;

    /**
     * @var int
     */
    private $userId;

    /**
     * Create a new notification instance.
     *
     * @param array $params
     */
    public function __construct(array $params)
    {
        $this->groupId = $params['group_id'];
        $this->userId = $params['user_id'];
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
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
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable): array
    {
        return [
            'panda_group_id' => $this->groupId,
            'user_id' => $this->userId,
        ];
    }
}
