<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VehicleEnquiryNotification extends Notification
{
    use Queueable;
    protected $enquiry;
    protected $url;

    public function __construct($enquiry)
    {
        $this->enquiry = $enquiry;
        
        if($this->enquiry->type =='sale'){
           $url= url('sell-car-lsiting');
        }else{
             $url= url('purchase-car-lsiting');
        }
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }


    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Enquiry Submitted')
            ->greeting('Hello Admin,')
            ->line('A new enquiry has been submitted.')
            ->line('Name: ' . $this->enquiry->name)
            ->line('Email: ' . $this->enquiry->email)
            ->line('Message: ' . $this->enquiry->notes)
            ->action('View Enquiries', $this->url)
            ->line('Thank you!');
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'New enquiry submitted',
            'name' => $this->enquiry->name,
            'email' => $this->enquiry->email,
            'message' => $this->enquiry->notes,
            'link' => $this->url,
            'created_at' => now(),

        ];
    }
}
