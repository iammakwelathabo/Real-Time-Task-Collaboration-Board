<?php

namespace App\Events;

use App\Models\Task;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TaskCreated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $task;

    public function __construct(Task $task)
    {
        // Load relationships needed in frontend
        $this->task = $task->load('user', 'assignedUser');
    }

    public function broadcastOn()
    {
        return new Channel('tasks'); // same channel as TaskUpdated
    }

    public function broadcastAs()
    {
        return 'TaskCreated'; // event name to match in JS
    }
}
