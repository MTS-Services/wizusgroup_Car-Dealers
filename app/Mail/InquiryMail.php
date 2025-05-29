<?php

namespace App\Mail;

use App\Models\ProductInquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InquiryMail extends Mailable
{
   use Queueable, SerializesModels;

      public ProductInquiry $inquiry;
    public function __construct(ProductInquiry $inquiry)
    {
        $this->inquiry = $inquiry;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'WhatsApp Inquiry  - ' . $this->inquiry->in_name
        );
    }


    public function content(): Content
    {
        return new Content(
            view: 'mails.product_inquiry',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
