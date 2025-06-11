<?php

namespace App\Jobs;

use App\Mail\OrderStatusMail;
use App\Models\Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class OrderStatusMailSend implements ShouldQueue
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
            Mail::to('admin@gmail.com')->later(now()->addSeconds(4), new OrderStatusMail($this->order, true));
        } else {
            // Send to user immediately
            Mail::to($this->order->user->email)->send(new OrderStatusMail($this->order));
        }
    }
}
