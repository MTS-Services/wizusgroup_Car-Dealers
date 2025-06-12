<?php

namespace App\Mail;

use App\Models\Container;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContainerStatusMail extends Mailable
{
    use Queueable, SerializesModels;
    public Container $container;
    public $isAdmin;

    public $user_name;

    public function __construct(Container $container, bool $isAdmin = false, $user_name = 'Dear')
    {
        $this->container = $container;
        $this->isAdmin = $isAdmin;
        $this->user_name = $user_name;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: ($this->isAdmin ? '📢 Container Status Update Notification - ' : '🚢 Container Status Update Notification - ') . $this->container->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mails.orders.container_status_mail',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
