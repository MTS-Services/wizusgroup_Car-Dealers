<?php

namespace App\Mail;

use App\Models\AuctionBid;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AuctionBidMail extends Mailable
{
    use Queueable, SerializesModels;

      public AuctionBid $auctionBid;
    public function __construct(AuctionBid $auctionBid)
    {
        $this->auctionBid = $auctionBid;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Auction Place Bid - ' . $this->auctionBid->first_name
        );
    }


    public function content(): Content
    {
        return new Content(
            view: 'mails.auction_bid',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
