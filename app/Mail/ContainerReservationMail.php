<?php

namespace App\Mail;

use App\Models\ContainerReservation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContainerReservationMail extends Mailable
{
    use Queueable, SerializesModels;
    use Queueable, SerializesModels;

    public ContainerReservation $reservation;

    public function __construct(ContainerReservation $reservation)
    {
        $this->reservation = $reservation->load(['container', 'product', 'user']);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Container Reservation - ' . optional($this->reservation->container)->name .
            ' | WhatsApp: ' . $this->reservation->whatsapp
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mails.reservation',
            with: ['reservation' => $this->reservation],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
