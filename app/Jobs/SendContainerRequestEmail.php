<?php

namespace App\Jobs;

use App\Mail\ContainerRequestMail;
use App\Models\Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendContainerRequestEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Order $order;
    public bool $isAdmin;

    public function __construct(Order $order, bool $isAdmin = false)
    {
        $this->order = $order;
        $this->isAdmin = $isAdmin;
    }

    public function handle()
    {
        if ($this->isAdmin) {
            // Send to admin with 4 seconds delay
            Mail::to('admin@gmail.com')->later(now()->addSeconds(4), new ContainerRequestMail($this->order, true));
        } else {
            // Send to user immediately
            Mail::to($this->order->user->email)->send(new ContainerRequestMail($this->order));
        }
    }
}
