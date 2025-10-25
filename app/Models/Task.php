<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Events\TaskCreated;
use App\Events\TaskUpdated;
use App\Events\TaskDeleted;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'status',
        'priority',
        'due_date',
        'assigned_to',
        'created_by',
        'labels',
        'position',
        'is_urgent',
        'completed_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'due_date' => 'date',
        'completed_at' => 'datetime',
        'labels' => 'array',
        'is_urgent' => 'boolean',
        'position' => 'integer',
    ];

    /**
     * Status constants
     */
    const STATUS_BACKLOG = 'backlog';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_REVIEW = 'review';
    const STATUS_DONE = 'done';

    /**
     * Priority constants
     */
    const PRIORITY_LOW = 'low';
    const PRIORITY_MEDIUM = 'medium';
    const PRIORITY_HIGH = 'high';
    const PRIORITY_URGENT = 'urgent';


    protected static function booted()
    {
        static::created(function ($task) {
            broadcast(new TaskCreated($task));
        });

        static::updated(function ($task) {
            $changes = $task->getChanges();
            broadcast(new TaskUpdated($task, $changes));
        });

        static::deleted(function ($task) {
            broadcast(new TaskDeleted($task->id, $task->user_id));
        });
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    /**
     * Get the user who created the task.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Get the user assigned to the task.
     */
    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Get all users assigned to this task (many-to-many).
     */
    public function assignedUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'task_user')->withTimestamps();
    }

    /**
     * Scope a query to only include tasks with a specific status.
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope a query to only include tasks with a specific priority.
     */
    public function scopePriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    /**
     * Scope a query to only include overdue tasks.
     */
    public function scopeOverdue($query)
    {
        return $query->where('due_date', '<', now())
            ->where('status', '!=', self::STATUS_DONE);
    }

    /**
     * Scope a query to only include urgent tasks.
     */
    public function scopeUrgent($query)
    {
        return $query->where('is_urgent', true);
    }

    /**
     * Scope a query to only include tasks assigned to a specific user.
     */
    public function scopeAssignedTo($query, $userId)
    {
        return $query->where('assigned_to', $userId);
    }

    /**
     * Scope a query to order tasks by position.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('position')->orderBy('created_at');
    }

    /**
     * Check if the task is overdue.
     */
    public function isOverdue(): bool
    {
        return $this->due_date && $this->due_date->isPast() && $this->status !== self::STATUS_DONE;
    }

    /**
     * Check if the task is completed.
     */
    public function isCompleted(): bool
    {
        return $this->status === self::STATUS_DONE;
    }

    /**
     * Mark task as completed.
     */
    public function markAsCompleted(): void
    {
        $this->update([
            'status' => self::STATUS_DONE,
            'completed_at' => now(),
        ]);
    }

    /**
     * Reopen a completed task.
     */
    public function reopen(): void
    {
        $this->update([
            'status' => self::STATUS_BACKLOG,
            'completed_at' => null,
        ]);
    }

    /**
     * Get the status color for UI.
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            self::STATUS_BACKLOG => 'gray',
            self::STATUS_IN_PROGRESS => 'yellow',
            self::STATUS_REVIEW => 'blue',
            self::STATUS_DONE => 'green',
            default => 'gray',
        };
    }

    /**
     * Get the priority color for UI.
     */
    public function getPriorityColorAttribute(): string
    {
        return match($this->priority) {
            self::PRIORITY_LOW => 'gray',
            self::PRIORITY_MEDIUM => 'blue',
            self::PRIORITY_HIGH => 'orange',
            self::PRIORITY_URGENT => 'red',
            default => 'gray',
        };
    }

    /**
     * Get the task progress percentage.
     */
    public function getProgressAttribute(): int
    {
        return match($this->status) {
            self::STATUS_BACKLOG => 0,
            self::STATUS_IN_PROGRESS => 50,
            self::STATUS_REVIEW => 75,
            self::STATUS_DONE => 100,
            default => 0,
        };
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($task) {
            if (auth()->check() && !$task->created_by) {
                $task->created_by = auth()->id();
            }

            // Set position to the end of the current status
            $maxPosition = static::where('status', $task->status)->max('position');
            $task->position = $maxPosition ? $maxPosition + 1 : 1;
        });

        static::updating(function ($task) {
            if ($task->isDirty('status') && $task->status === self::STATUS_DONE && !$task->completed_at) {
                $task->completed_at = now();
            }

            if ($task->isDirty('status') && $task->status !== self::STATUS_DONE && $task->completed_at) {
                $task->completed_at = null;
            }
        });
    }
}
