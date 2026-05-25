<?php 
namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class ActivityLogService
{
    public static function log($action, $module, $description)
    {
        ActivityLog::create([
            'user_name' => Auth::check() ? Auth::user()->name : 'System',
            'action' => $action,
            'module' => $module,
            'description' => $description
        ]);
    }
}