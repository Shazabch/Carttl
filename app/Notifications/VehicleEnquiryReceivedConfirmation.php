<?php

namespace App\Notifications;


use App\Models\ContactSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VehicleEnquiryReceivedConfirmation extends Notification
{
    use Queueable;
    public $enquiry;
    public $url;
    /**
     * Create a new notification instance.
     */
    public function __construct($enquiry)
    {
        $this->enquiry = $enquiry;
         if($this->enquiry->type =='sale'){
           $url= url('');
        }else{
             $url= url('');
        }
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
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('We Have Received Your Enquiry')
            ->greeting('Hello ' . $this->enquiry->name)
            ->line('Thank you for contacting us! We have successfully received your message and will get back to you as soon as possible.')
            ->line('Thank you for your patience.');
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
