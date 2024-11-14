<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserBlocked implements ShouldBroadcast
{
    // use SerializesModels;

    // public $block_id;
    // public $block_by;
    // public $blocked_user_name;

    // public function __construct($block_id, $block_by, $blocked_user_name)
    // {
    //     $this->block_id = $block_id;
    //     $this->block_by = $block_by;
    //     $this->blocked_user_name = $blocked_user_name;
    // }

    // public function broadcastOn()
    // {
    //     return new Channel('user-blocked.' . $this->block_id);
    // }
}
