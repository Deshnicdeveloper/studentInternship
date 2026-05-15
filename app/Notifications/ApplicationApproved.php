<?php

namespace App\Notifications;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApplicationApproved extends Notification implements ShouldQueue
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
            ->subject('Your Internship Application Has Been Approved!')
            ->greeting('Congratulations, ' . $notifiable->name . '!')
            ->line('Your application for the internship position has been approved.')
            ->line('Position: ' . $this->application->internship->title)
            ->line('Company: ' . $this->application->internship->company->name)
            ->action('View Your Placement', url('/student/dashboard'))
            ->line('Your internship placement has been created. Please check your dashboard for more details.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'application_approved',
            'message' => 'Your application for ' . $this->application->internship->title . ' at ' . $this->application->internship->company->name . ' has been approved!',
            'application_id' => $this->application->id,
            'internship_id' => $this->application->internship_id,
        ];
    }
}
