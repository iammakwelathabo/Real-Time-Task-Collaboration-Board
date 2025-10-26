<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// routes/channels.php
Broadcast::channel('tasks', function ($user) {
    return true; // Or add your authorization logic
});

Broadcast::channel('task.{taskId}', function ($user, $taskId) {
    return true; // Add authorization if needed
});
