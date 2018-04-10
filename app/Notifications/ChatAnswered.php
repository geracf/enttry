<?php

namespace App\Notifications;

use App\ChatRoom;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ChatAnswered extends Notification
{
    use Queueable;

    protected $user;
    protected $chat_room;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user, ChatRoom $chat_room)
    {
        $this->user = $user;
        $this->chat_room = $chat_room;
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
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'student_id' => $this->user->id,
            'chat_room_id' => $this->chat_room->id,
            'message' => $this->user->name." has answered!",
        ];
    }
}
