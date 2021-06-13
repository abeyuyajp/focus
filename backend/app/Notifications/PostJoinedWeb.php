<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Auth;
use App\Post;
use App\Join;

class PostJoinedWeb extends Notification
{
    use Queueable;
    protected $from_user_name;
    protected $joined_created_at;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($from_user_name, $joined_created_at)
    {
        $this->from_user_name = $from_user_name;
        $this->joined_created_at = $joined_created_at;
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
    public function toDatabase($notifiable)
    {
        //notificationsテーブルの「data」カラムに保存する値を定義する
        return[
            'from_user_name'  =>  $this->from_user_name,
            'joined_created_at'  =>  $this->joined_created_at,
            'status' => false,
        ];
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
