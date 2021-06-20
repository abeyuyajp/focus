<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Auth;
use App\Post;
use App\Join;

class FromUserDeletedWeb extends Notification
{
    use Queueable;
    protected $from_user_deleted_name;
    protected $deleted_post_start;
    protected $deleted_post_end;
    protected $post_id;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($from_user_deleted_name, $deleted_post_start, $deleted_post_end, $post_id)
    {
        $this->from_user_deleted_name = $from_user_deleted_name;
        $this->deleted_post_start = $deleted_post_start;
        $this->deleted_post_end = $deleted_post_end;
        $this->post_id = $post_id;
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
    #public function toMail($notifiable)
    #{
        #return (new MailMessage)
                    #->line('The introduction to the notification.')
                    #->action('Notification Action', url('/'))
                    #->line('Thank you for using our application!');
    #}

    public function toDatabase($notifiable)
    {
        return[
            'from_user_deleted_name' => $this->from_user_deleted_name,
            'deleted_post_start' => $this->deleted_post_start,
            'deleted_post_end' => $this->deleted_post_end,
            'post_id' => $this->post_id,
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
