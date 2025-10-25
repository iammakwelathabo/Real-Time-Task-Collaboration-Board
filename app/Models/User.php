<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the tasks created by the user.
     */
    public function createdTasks(): HasMany
    {
        return $this->hasMany(Task::class, 'created_by');
    }

    /**
     * Get the tasks assigned to the user.
     */
    public function assignedTasks(): HasMany
    {
        return $this->hasMany(Task::class, 'assigned_to');
    }

    /**
     * Get all tasks where the user is assigned (many-to-many).
     */
    public function tasks(): BelongsToMany
    {
        return $this->belongsToMany(Task::class, 'task_user');
    }

    /**
     * Get the user's task statistics.
     */
    public function getTaskStatsAttribute(): array
    {
        return [
            'total' => $this->assignedTasks()->count(),
            'backlog' => $this->assignedTasks()->status(Task::STATUS_BACKLOG)->count(),
            'in_progress' => $this->assignedTasks()->status(Task::STATUS_IN_PROGRESS)->count(),
            'review' => $this->assignedTasks()->status(Task::STATUS_REVIEW)->count(),
            'done' => $this->assignedTasks()->status(Task::STATUS_DONE)->count(),
            'overdue' => $this->assignedTasks()->overdue()->count(),
        ];
    }


}
