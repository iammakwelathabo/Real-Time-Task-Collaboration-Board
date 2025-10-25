<?php

namespace App\Events;

use App\Models\Task;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TaskUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $task;
    public $changes;

    public function __construct(Task $task, array $changes = [])
    {
        $this->task = $task->load('user', 'assignedUser');
        $this->changes = $changes;
    }

    public function broadcastOn()
    {
        return new Channel('tasks');
    }

    public function broadcastAs()
    {
        return 'TaskUpdated';
    }
}
