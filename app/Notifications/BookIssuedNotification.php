<?php

namespace App\Notifications;

use App\Models\Borrowing;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Notification;

class BookIssuedNotification extends Notification
{
    use Queueable;

    /**
     * The borrowing record.
     */
    protected Borrowing $borrowing;


    /**
     * Create a new notification instance.
     */
    public function __construct(
        Borrowing $borrowing
    ) {
        $this->borrowing = $borrowing;
    }


    /**
     * Get the notification's delivery channels.
     */
    public function via(
        object $notifiable
    ): array {
        return [
            'database',
        ];
    }


    /**
     * Get the array representation of the notification.
     */
    public function toArray(
        object $notifiable
    ): array {
        $bookName =
            $this->borrowing->book?->title
            ?? 'Unknown Book';


        $borrowerName =
            $this->borrowing->borrower?->name
            ?? 'Unknown Borrower';


        return [

            'title' => 'Book Issued',

            'message' =>
                "{$bookName} has been issued to {$borrowerName}.",

            'type' => 'borrowed',

            'url' => route(
                'borrowings.show',
                $this->borrowing->id
            ),

        ];
    }
}