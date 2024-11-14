<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserUnblocked implements ShouldBroadcast
{
    // use SerializesModels;

    // public $block_id;
    // public $block_by;

    // public function __construct($block_id, $block_by)
    // {
    //     $this->block_id = $block_id;
    //     $this->block_by = $block_by;
    // }

    // public function broadcastOn()
    // {
    //     return new Channel('user-unblocked.' . $this->block_id);
    // }
}