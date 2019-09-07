<?php
declare(strict_types=1);

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TestEvent implements ShouldBroadcast
{
    public function broadcastOn(): Channel
    {
        return new Channel('test');
    }

    public function broadcastWith(): array
    {
        return ['data' => 'loadofshite'];
    }
}
