<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TaskDeleted implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $taskId;
    public $userId;

    public function __construct(int $taskId, int $userId)
    {
        $this->taskId = $taskId;
        $this->userId = $userId;
    }

    public function broadcastOn()
    {
        return new Channel('tasks'); // same channel as other task events
    }

    public function broadcastAs()
    {
        return 'TaskDeleted';
    }
}
