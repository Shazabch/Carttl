<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingStatusChangedNotification extends Notification
{
    use Queueable;

    public $booking;
    public $newStatus;

    /**
     * Create a new notification instance.
     */
    public function __construct(Booking $booking, $newStatus)
    {
        $this->booking = $booking;
        $this->newStatus = $newStatus;
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
        $vehicle = $this->booking->vehicle;
        $vehicleTitle = $vehicle ? ($vehicle->title ?? 'Your Vehicle') : 'Your Vehicle';

        return (new MailMessage)
            ->subject("Booking Status Updated")
            ->greeting("Hello {$notifiable->name}!")
            ->line("Your booking status has been updated.")
            ->line("Vehicle: {$vehicleTitle}")
            ->line("New Status: " . ucfirst(str_replace('_', ' ', $this->newStatus)))
            ->action("View Booking", url('/'))
            ->line("Thank you for using our service!");
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $vehicle = $this->booking->vehicle;
        
        return [
            'booking_id' => $this->booking->id,
            'vehicle_id' => $this->booking->vehicle_id,
            'status' => $this->newStatus,
            'vehicle_title' => $vehicle ? ($vehicle->title ?? 'Unknown Vehicle') : 'Unknown Vehicle',
        ];
    }
}
