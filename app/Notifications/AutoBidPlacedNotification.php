<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AutoBidPlacedNotification extends Notification implements ShouldQueue
{
    use Queueable;
    
    protected $bid;
    protected $vehicle;

    public function __construct($bid, $vehicle)
    {
        $this->bid = $bid;
        $this->vehicle = $vehicle;
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
       
        
        return (new MailMessage)
            ->subject('Automatic Bid Placed - ' . $this->vehicle->title)
            ->greeting('Hello ' . $notifiable->name)
            ->line('Your automatic bid has been placed successfully.')
            ->line('Vehicle: ' . $this->vehicle->title)
            ->line('Bid Amount: AED' . number_format($this->bid->bid_amount, 2))
            ->line('Your Max Bid: AED' . number_format($this->bid->max_bid, 2))
         
            ->line('This bid was automatically placed on your behalf based on your maximum bid settings.')
            ->line('Thank you for using our platform!');
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Automatic Bid Placed',
            'name' => $notifiable->name,
            'email' => $notifiable->email,
            'vehicle_id' => $this->vehicle->id,
            'vehicle_title' => $this->vehicle->title,
            'bid_amount' => $this->bid->bid_amount,
            'max_bid' => $this->bid->max_bid,
            'message' => 'Your automatic bid of AED' . number_format($this->bid->bid_amount, 2) . ' has been placed on ' . $this->vehicle->title,
            
            'created_at' => now(),
        ];
    }
}
