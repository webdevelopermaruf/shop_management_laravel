<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Order implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $order;
    public $placedOrder;
    public function __construct($message,$placedOrder)
    {
        $this->order = $message;
        $this->placedOrder = $placedOrder;
    }

    public function broadcastOn()
    {
        return ['order-channel'];
    }
    public function broadcastAs(){
        return 'order-event';
    }
}
