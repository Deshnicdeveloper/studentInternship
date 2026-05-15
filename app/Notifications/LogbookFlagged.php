<?php

namespace App\Notifications;

use App\Models\Logbook;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LogbookFlagged extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Logbook $logbook
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Logbook Entry Requires Revision')
            ->greeting('Hello, ' . $notifiable->name)
            ->line('Your logbook entry for Week ' . $this->logbook->week_number . ' has been flagged and requires revision.')
            ->line('Coordinator Comment: ' . $this->logbook->coordinator_comment)
            ->action('Review & Update Entry', url('/student/logbook/' . $this->logbook->id . '/edit'))
            ->line('Please update your entry and resubmit.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'logbook_flagged',
            'message' => 'Your logbook entry for Week ' . $this->logbook->week_number . ' has been flagged for revision.',
            'logbook_id' => $this->logbook->id,
            'comment' => $this->logbook->coordinator_comment,
        ];
    }
}
