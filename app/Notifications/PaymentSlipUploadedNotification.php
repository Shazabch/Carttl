<?php

namespace App\Notifications;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentSlipUploadedNotification extends Notification
{
    use Queueable;

    public $invoice;
    public $user;

    /**
     * Create a new notification instance.
     */
    public function __construct(Invoice $invoice, $user)
    {
        $this->invoice = $invoice;
        $this->user = $user;
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
            ->subject('Payment Slip Uploaded - Invoice #' . $this->invoice->id)
            ->greeting('Hello ' . ($notifiable->name ?? 'Admin') . ',')
            ->line('A payment slip has been uploaded for an invoice.')
            ->line('Invoice ID: ' . $this->invoice->id)
            ->line('User: ' . ($this->user->name ?? 'N/A'))
            ->line('Email: ' . ($this->user->email ?? 'N/A'))
            ->line('Type: ' . $this->invoice->type)
            
            ->line('Thank you for your attention.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'invoice_id' => $this->invoice->id,
            'user_id' => $this->user->id,
            'user_name' => $this->user->name,
            'user_email' => $this->user->email,
            'type' => $this->invoice->type,
            'message' => 'Payment slip uploaded for invoice #' . $this->invoice->id,
        ];
    }
}
