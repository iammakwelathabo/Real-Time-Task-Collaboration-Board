<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Events\TaskUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class TaskController extends Controller
{

    public function getTasks()
    {
        $tasks = Task::with(['creator', 'assignee'])->ordered()->get(); // Add 'assignee' here
        return response()->json($tasks);
    }

    public function show(Task $task)
    {
        return response()->json($task);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'status' => 'required|in:backlog,in-progress,review,done',
                'priority' => 'nullable|in:low,medium,high,urgent',
                'due_date' => 'nullable|date',
                'labels' => 'nullable|string',
            ]);

            $labels = $request->labels ? array_map('trim', explode(',', $request->labels)) : null;

            $task = Task::create([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'status' => $validated['status'],
                'priority' => $validated['priority'] ?? 'medium',
                'due_date' => $validated['due_date'],
                'labels' => $labels,
                'assigned_to' => $validated['assigned_to'],
                'created_by' => Auth::id(),
            ]);

            // Broadcast task creation
            //broadcast(new TaskUpdated($task))->toOthers();

            return response()->json([
                'success' => true,
                'message' => 'Task created successfully!',
                'task' => $task->load('creator')
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create task: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateStatus(Request $request, Task $task)
    {
        try {
            $validated = $request->validate([
                'status' => 'required|in:backlog,in-progress,review,done'
            ]);

            $task->update(['status' => $validated['status']]);

            // Broadcast status update
            broadcast(new TaskUpdated($task))->toOthers();

            return response()->json([
                'success' => true,
                'message' => 'Task status updated successfully!',
                'task' => $task
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update task status: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, Task $task)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'status' => 'required|in:backlog,in-progress,review,done',
                'priority' => 'nullable|in:low,medium,high,urgent',
                'due_date' => 'nullable|date',
                'labels' => 'nullable|string',
                'assigned_to' => 'nullable|exists:users,id',
            ]);

            $labels = $request->labels ? array_map('trim', explode(',', $request->labels)) : null;

            $task->update([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'status' => $validated['status'],
                'priority' => $validated['priority'] ?? 'medium',
                'due_date' => $validated['due_date'],
                'labels' => $labels,
                'assigned_to' => $validated['assigned_to'],
            ]);

            // Broadcast the update
            broadcast(new TaskUpdated($task))->toOthers();

            return response()->json([
                'success' => true,
                'message' => 'Task updated successfully!',
                'task' => $task->load('assignee')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update task: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Task $task)
    {
        try {
            $task->delete();

            // (Optional) Broadcast task deletion event if you create TaskDeleted event
            // broadcast(new TaskDeleted($task->id))->toOthers();

            return response()->json([
                'success' => true,
                'message' => 'Task deleted successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete task: ' . $e->getMessage()
            ], 500);
        }
    }
}
