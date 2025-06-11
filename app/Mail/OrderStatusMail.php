<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderStatusMail extends Mailable
{
    use Queueable, SerializesModels;
    public Order $order;
    public $isAdmin;

    public function __construct(Order $order, bool $isAdmin = false)
    {
        $this->order = $order;
        $this->isAdmin = $isAdmin;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: ($this->isAdmin ? '📢 Order Status Update Notification - ' : '🚢 Order Status Update Notification - ') . $this->order->order_number,
        );
    }


    public function content(): Content
    {
        return new Content(
            view: 'mails.orders.order_status_mail',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
