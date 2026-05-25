<?php 
use App\Models\Activity;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

function logActivity($module,$action,$description)
{

    ActivityLog::create([
        'user_id'=>Auth::id(),
        'module'=>$module,
        'action'=>$action,
        'description'=>$description
    ]);

}