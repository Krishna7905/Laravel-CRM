<?php 
namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
   public function index(Request $request)
{
    $logs = ActivityLog::latest()
        ->when($request->module, function ($query) use ($request) {
            $query->whereRaw('LOWER(module) = ?', [strtolower($request->module)]);
        })
        ->take(10)   
        ->get();     

    return view('activity_logs.index', compact('logs'));
}
}