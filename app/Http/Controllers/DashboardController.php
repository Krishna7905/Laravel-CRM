<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Contact;
use App\Models\ActivityLog;
use App\Models\Deal;
use App\Models\Task;

class DashboardController extends Controller
{

    public function index()
{
    // Basics Counts
    $totalLeads = Lead::count();
    $totalContacts = Contact::count();
    $totalDeals = Deal::count();
    $totalTasks = Task::count();

    //  DEAL METRICS 
    $wonDeals = Deal::where('stage','won')->count();
    $lostDeals = Deal::where('stage','lost')->count();

    $totalRevenue = Deal::where('stage','won')->sum('value');

    //  TASK METRICS 
    $pendingTasks = Task::whereRaw('LOWER(status) = ?', ['pending'])->count();
    $completedTasks = Task::whereRaw('LOWER(status) = ?', ['completed'])->count();

    //  PIPELINE 
    $pipelineData = [
        'Prospecting' => Deal::where('stage','prospecting')->count(),
        'Qualification' => Deal::where('stage','qualification')->count(),
        'Proposal' => Deal::where('stage','proposal')->count(),
        'Negotiation' => Deal::where('stage','negotiation')->count(),
        'Won' => Deal::where('stage','won')->count(),
        'Lost' => Deal::where('stage','lost')->count(),
    ];

    //  MONTHLY DEALS (TREND CHART) 
    $monthlyDeals = Deal::selectRaw("MONTH(created_at) as month, COUNT(*) as total")
        ->groupBy('month')
        ->pluck('total','month');

    $months = [];
    $dealCounts = [];

    for ($i = 1; $i <= 12; $i++) {
        $months[] = date("M", mktime(0,0,0,$i,1));
        $dealCounts[] = $monthlyDeals[$i] ?? 0;
    }

    // TASK STATUS CHART 
    $taskChart = [
        $pendingTasks,
        $completedTasks
    ];

    
    $recentLeads = Lead::latest()->take(5)->get();
    $recentTasks = Task::latest()->take(5)->get();

    $recentActivities = ActivityLog::latest()->take(5)->get();

    return view('dashboard', compact(
        'totalLeads',
        'totalContacts',
        'totalDeals',
        'totalTasks',
        'wonDeals',
        'lostDeals',
        'totalRevenue',
        'pendingTasks',
        'completedTasks',
        'pipelineData',
        'months',
        'dealCounts',
        'taskChart',
        'recentLeads',
        'recentTasks',
        'recentActivities'
    ));
}
}
