<?php

namespace App\Notifications;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApplicationRejected extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Application $application
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Update on Your Internship Application')
            ->greeting('Hello, ' . $notifiable->name)
            ->line('We regret to inform you that your application for the internship position has not been approved at this time.')
            ->line('Position: ' . $this->application->internship->title)
            ->line('Company: ' . $this->application->internship->company->name)
            ->line('Reason: ' . ($this->application->remarks ?? 'Not specified'))
            ->action('Browse Other Internships', url('/student/internships'))
            ->line('Please feel free to apply for other available internship positions.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'application_rejected',
            'message' => 'Your application for ' . $this->application->internship->title . ' at ' . $this->application->internship->company->name . ' was not approved.',
            'application_id' => $this->application->id,
            'internship_id' => $this->application->internship_id,
            'reason' => $this->application->remarks,
        ];
    }
}
