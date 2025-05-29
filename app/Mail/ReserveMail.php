<?php

namespace App\Mail;

use App\Models\ProductReserve;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReserveMail extends Mailable
{
     use Queueable, SerializesModels;

      public ProductReserve $reserve;
    public function __construct(ProductReserve $reserve)
    {
        $this->reserve = $reserve;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reserve Product - ' . $this->reserve->name
        );
    }


    public function content(): Content
    {
        return new Content(
            view: 'mails.product_reserve',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
