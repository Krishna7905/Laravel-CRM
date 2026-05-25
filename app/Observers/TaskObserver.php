<?php
namespace App\Observers;

use App\Models\Task;
use App\Services\ActivityLogService;

class TaskObserver
{
    public function created(Task $task)
    {
        ActivityLogService::log('Created','Task',"Created task: {$task->title}");
    }

    public function updated(Task $task)
    {
        ActivityLogService::log('Updated','Task',"Updated task: {$task->title}");
    }

    public function deleted(Task $task)
    {
        ActivityLogService::log('Deleted','Task',"Deleted task: {$task->title}");
    }
}