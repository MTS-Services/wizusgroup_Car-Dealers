<?php

namespace App\Jobs;

use App\Mail\ContainerStatusMail;
use App\Models\Container;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ContainerStatusMailSend implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Container $container;
    public bool $isAdmin;

    public function __construct(Container $container, bool $isAdmin = false)
    {
        $this->container = $container;
        $this->isAdmin = $isAdmin;
    }

    public function handle()
    {
        if ($this->isAdmin) {
            // Send to admin with 4 seconds delay
            Mail::to('admin@gmail.com')->later(now()->addSeconds(4), new ContainerStatusMail($this->container, true));
        } else {
            // Send to user immediately
            $this->container->load(['orders.user']);
            foreach ($this->container->orders as $order) {
                Mail::to($order->user->email)->send(new ContainerStatusMail($this->container, false, $order->user->full_name));
                sleep(2);
            }

        }
    }
}
