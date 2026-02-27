<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewVehicleNotification extends Notification
{
    use Queueable;
    protected $vehicle;
    protected $message;
    protected $url;

    public function __construct($vehicle)
    {
        $this->vehicle = $vehicle;
        
        // Build consistent message: Make + Model instead of title
        $make = $this->vehicle->brand ? $this->vehicle->brand->name : 'Auction';
        $model = $this->vehicle->vehicleModel ? $this->vehicle->vehicleModel->name : '';
        $vehicleName = trim($make . ' ' . $model);
        
        $this->message = $vehicleName . ' - AED ' . number_format($this->vehicle->price);
        $this->url = 'URL';
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Auction Available')
            ->greeting('Hello ' . $notifiable->name)
            ->line($this->message)
            ->line('Year: ' . ($this->vehicle->year ?? 'N/A'))
            ->line('Mileage: ' . number_format($this->vehicle->mileage ?? 0) . ' km')
            ->action('View Auction', $this->url)
            ->line('Thank you!');
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'New Auction Available',
            'message' => $this->message,
            'vehicle_id' => $this->vehicle->id,
            'price' => $this->vehicle->price,
            'mileage' => $this->vehicle->mileage,
            'year' => $this->vehicle->year,
            'make' => $this->vehicle->brand ? $this->vehicle->brand->name : null,
            'model' => $this->vehicle->vehicleModel ? $this->vehicle->vehicleModel->name : null,
            'type' => 'new_vehicle',
            'link' => $this->url,
            'created_at' => now(),
        ];
    }
}
