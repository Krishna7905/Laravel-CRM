<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;
use App\Services\ActivityLogService;

class PipelineController extends Controller
{
    public function index()
    {
        $query = Lead::with('assignedUser');

        if (auth()->user()->role == 'sales') {
            $query->where('assigned_to', auth()->id());
        }

        $leads = $query->get()->groupBy('status');

        $statuses = [
            'new' => 'New',
            'contacted' => 'Contacted',
            'qualified' => 'Qualified',
            'proposal' => 'Proposal',
            'converted' => 'Converted',
            'lost' => 'Lost'
        ];

        return view('pipeline.index', compact('leads', 'statuses'));
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:leads,id',
            'status' => 'required'
        ]);

        $lead = Lead::findOrFail($request->id);

        $oldStatus = $lead->status;

        if ($oldStatus === $request->status) {
            return response()->json(['success' => true]);
        }

        $lead->update([
            'status' => $request->status
        ]);

        ActivityLogService::log(
            'Updated',
            'Lead',
            "Lead '{$lead->name}' moved from {$oldStatus} → {$request->status}"
        );

        return response()->json(['success' => true]);
    }
}
