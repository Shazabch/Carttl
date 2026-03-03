<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OutbidNotification extends Notification implements ShouldQueue
{
    use Queueable;
    
    protected $vehicle;
    protected $newBidAmount;
    protected $bidId;

    public function __construct($vehicle, $newBidAmount, $bidId)
    {
        $this->vehicle = $vehicle;
        $this->newBidAmount = $newBidAmount;
        $this->bidId = $bidId;
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('You\'ve Been Outbid - ' . $this->vehicle->title)
            ->greeting('Hello ' . $notifiable->name)
            ->line('You\'ve Been Outbid')
            ->line('A higher bid of AED' . number_format($this->newBidAmount) . ' has been placed on ' . $this->vehicle->title)
            ->line('You can place a new bid to stay in the competition.')
            ->action('View Vehicle', url('/vehicle/' . $this->vehicle->id))
            ->line('Thank you for using our platform!');
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'You\'ve Been Outbid',
            'name' => $notifiable->name,
            'email' => $notifiable->email,
            'message' => 'A higher bid of AED' . number_format($this->newBidAmount) . ' has been placed on ' . $this->vehicle->title,
            'vehicle_id' => $this->vehicle->id,
            'vehicle_title' => $this->vehicle->title,
            'bid_id' => $this->bidId,
            'new_bid_amount' => $this->newBidAmount,
            'type' => 'outbid',
            'created_at' => now(),
        ];
    }
}
