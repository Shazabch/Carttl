<?php

namespace App\Notifications;

use App\Models\InspectionEnquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InspectionStatusChangedNotification extends Notification
{
    use Queueable;

    public $enquiry;
    public $newStatus;
    public $comment;

    /**
     * Create a new notification instance.
     */
    public function __construct(InspectionEnquiry $enquiry, $newStatus, $comment = null)
    {
        $this->enquiry = $enquiry;
        $this->newStatus = $newStatus;
        $this->comment = $comment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(" Appointment Status Updated")
            ->greeting("Hello {$notifiable->name}!")
            ->line("Your  Appointment status has been updated.")
            ->line("Vehicle: {$this->enquiry->year} {$this->getBrandName()} {$this->getModelName()}")
            ->line("New Status: " . ucfirst($this->newStatus))
            ->when($this->comment, function ($message) {
                return $message->line("Comment: {$this->comment}");
            })
            ->action("View Details", url('/'))
            ->line("Thank you for using our service!");
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'enquiry_id' => $this->enquiry->id,
            'status' => $this->newStatus,
            'comment' => $this->comment,
            'vehicle' => $this->getBrandName() . ' ' . $this->getModelName() . ' (' . $this->enquiry->year . ')',
        ];
    }

    /**
     * Get brand name
     */
    private function getBrandName()
    {
        return $this->enquiry->brand ? $this->enquiry->brand->name : 'Unknown';
    }

    /**
     * Get model name
     */
    private function getModelName()
    {
        return $this->enquiry->vehicleModel ? $this->enquiry->vehicleModel->name : 'Unknown';
    }
}
