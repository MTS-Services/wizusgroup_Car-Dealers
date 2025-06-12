<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContainerRequestMail extends Mailable
{
    use Queueable, SerializesModels;
    public Order $order;
    public $isAdmin;

    public function __construct(Order $order, bool $isAdmin = false)
    {
        $this->order = $order->load(['shippingPort', 'destinationPort', 'items.product', 'shipping.city', 'shipping.state', 'shipping.country']);
        $this->isAdmin = $isAdmin;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: ($this->isAdmin ? '📢 New Container Request - ' : '🚢 Container Request Confirmation - ') . $this->order->order_number,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mails.orders.container_request',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
