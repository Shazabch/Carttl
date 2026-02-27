<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BidConfirmation extends Notification
{
    use Queueable;
    protected $bid;
    protected $vehicle;
    protected $url;

    public function __construct($bid, $vehicle = null)
    {
        $this->bid = $bid;
        $this->vehicle = $vehicle;
        $this->url = 'URL';
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }


    public function toMail($notifiable)
    {
        $vehicleTitle = $this->vehicle ? $this->vehicle->title : 'the vehicle';
        $message = 'Your bid of AED' . number_format($this->bid->bid_amount) . ' on ' . $vehicleTitle . ' has been approved!';

        return (new MailMessage)
            ->subject('Bid Approved')
            ->greeting('Hello ' . $this->bid->user->name)
            ->line($message)
            ->action('View', $this->url)
            ->line('Thank you!');
    }

    public function toDatabase($notifiable)
    {
        $vehicleTitle = $this->vehicle ? $this->vehicle->title : 'the vehicle';
        $message = 'Your bid of AED' . number_format($this->bid->bid_amount) . ' on ' . $vehicleTitle . ' has been approved!';

        return [
            'title' => 'Bid Approved',
            'name' => $this->bid->user->name,
            'email' => $this->bid->user->email,
            'message' => $message,
            'bid_id' => $this->bid->id,
            'vehicle_id' => $this->bid->vehicle_id,
            'type' => 'bid_approved',
            'link' => $this->url,
            'created_at' => now(),
        ];
    }
}
