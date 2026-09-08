<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class LibraryNotification extends Notification
{
    use Queueable;

    /**
     * Notification title.
     */
    protected string $title;

    /**
     * Notification message.
     */
    protected string $message;

    /**
     * Notification type.
     */
    protected string $type;

    /**
     * Optional URL.
     */
    protected ?string $url;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        string $title,
        string $message,
        string $type = 'info',
        ?string $url = null
    ) {
        $this->title = $title;

        $this->message = $message;

        $this->type = $type;

        $this->url = $url;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => $this->title,

            'message' => $this->message,

            'type' => $this->type,

            'url' => $this->url,
        ];
    }
}