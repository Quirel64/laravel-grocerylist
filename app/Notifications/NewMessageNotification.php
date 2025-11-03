<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Message;

class NewMessageNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('You received a new message')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('You have received a new message from ' . $this->message->sender->name . '.')
            ->line('Message: "' . $this->message->content . '"')
            ->action('View Profile', route('users.show', $this->message->sender_id))
            ->line('Thank you for using our platform!');
    }
}


