<?php

namespace App\Notifications\User;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UpdateUserNotification extends Notification
{
    use Queueable;

    private $user;
    private $creator;
    private $password;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user, User $creator, $password)
    {
        $this->user = $user;
        $this->creator = $creator;
        $this->password = $password;
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
        return (new MailMessage)
            ->line($this->user->name . ' ' . $this->user->surname . ' your account has been updated by ' . $this->creator->email)
            ->line('Your email address is: ' . $this->user->email)
            ->line('Your password is: ' . $this->password)
            ->line('Please change your password immediately after login into your account!')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
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
