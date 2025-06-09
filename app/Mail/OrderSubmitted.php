<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $isAdmin;

    public function __construct(Order $order, bool $isAdmin = false)
    {
        $this->order = $order->load(['user', 'shipping', 'items.product', 'shipping.city', 'shipping.state', 'shipping.country', 'shippingPort', 'destinationPort']);
        $this->isAdmin = $isAdmin;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: ($this->isAdmin ? '📢 New Order Submitted- ' : '🛒 Your Order Confirmation- ') . $this->order->order_number,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mails.orders.submitted',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
