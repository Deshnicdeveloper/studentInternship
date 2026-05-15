<?php

namespace App\Notifications;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApplicationSubmitted extends Notification implements ShouldQueue
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
            ->subject('New Internship Application Submitted')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('A new internship application has been submitted.')
            ->line('**Student:** ' . $this->application->student->name)
            ->line('**Internship:** ' . $this->application->internship->title)
            ->line('**Company:** ' . $this->application->internship->company->name)
            ->action('Review Application', url('/coordinator/applications'))
            ->line('Please review the application at your earliest convenience.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'application_submitted',
            'application_id' => $this->application->id,
            'student_name' => $this->application->student->name,
            'internship_title' => $this->application->internship->title,
            'message' => $this->application->student->name . ' has applied for ' . $this->application->internship->title,
        ];
    }
}
