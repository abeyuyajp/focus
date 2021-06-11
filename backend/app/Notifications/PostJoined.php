<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PostJoined extends Notification
{
    use Queueable;
    protected $from_user_name;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($from_user_name)
    {
        $this->from_user_name = $from_user_name;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
       $mail = new MailMessage();
       $mail->subject('セッションにジョインされました')
            ->greeting('こんにちは')
            ->line("{{ $this->from_user_name }} さんがセッションにジョインしました。");
            
       return $mail;
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
            //
        ];
    }
}
