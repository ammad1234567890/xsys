<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class send_alert extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $thread;
    public function __construct($thread)
    {
        $this->thread= $thread;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */

    public function toDatabase($notifiable)
    {
        return [
            'thread'=>$this->thread,
            'user'=> $notifiable,
            'read_at'=>0
            //'repliedTime'=> Carbon::now()
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage(
            [
                'thread'=>$this->thread,
                'user'=> auth()->user(),
                'read_at'=>0
            ]
        );
    }


    /*
        public function toMail($notifiable)
        {
            return (new MailMessage)
                        ->line('The introduction to the notification.')
                        ->action('Notification Action', url('/'))
                        ->line('Thank you for using our application!');
        }
    */
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
