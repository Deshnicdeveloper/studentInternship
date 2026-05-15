<?php

namespace App\Notifications;

use App\Models\Evaluation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EvaluationSubmitted extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Evaluation $evaluation
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New ' . ucfirst($this->evaluation->type) . ' Evaluation Submitted')
            ->greeting('Hello, ' . $notifiable->name)
            ->line('A supervisor has submitted a ' . $this->evaluation->type . ' evaluation.')
            ->line('Student: ' . $this->evaluation->placement->student->name)
            ->line('Company: ' . $this->evaluation->placement->internship->company->name)
            ->line('Score: ' . $this->evaluation->total_score . '%')
            ->action('View Evaluation', url('/coordinator/evaluations/' . $this->evaluation->id))
            ->line('Please review the evaluation.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'evaluation_submitted',
            'message' => ucfirst($this->evaluation->type) . ' evaluation submitted for ' . $this->evaluation->placement->student->name,
            'evaluation_id' => $this->evaluation->id,
            'placement_id' => $this->evaluation->placement_id,
            'evaluation_type' => $this->evaluation->type,
        ];
    }
}
