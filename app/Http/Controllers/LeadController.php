<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendLeadMail;
// use App\Models\Activity;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\EmailLog;
use App\Models\ActivityLog;

class LeadController extends Controller
{

    public function bulkDelete(Request $request)
    {
        Lead::whereIn('id', $request->ids)->delete();

        return response()->json(['success' => true]);
    }

    public function bulkStatus(Request $request)
    {
        Lead::whereIn('id', $request->ids)
            ->update(['status' => $request->status]);

        return response()->json(['success' => true]);
    }
    public function index(Request $request)
    {
        $query = Lead::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%")
                    ->orWhere('company', 'like', "%$search%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if (auth()->user()->role === 'sales') {
            $query->where('assigned_to', auth()->id());
        }

        $leads = $query->latest()->paginate(10)->withQueryString();

        return view('leads.index', compact('leads'));
    }

    public function create()
    {
        $employees = User::where('role', 'employee')->get();

        $countries = [
            '+1' => 'United States',
            '+44' => 'United Kingdom',
            '+91' => 'India',
            '+61' => 'Australia',
            '+81' => 'Japan',
            '+49' => 'Germany',
            '+33' => 'France',
            '+86' => 'China',
            '+55' => 'Brazil',
            '+7' => 'Russia',
            '+39' => 'Italy',
            '+27' => 'South Africa',
            '+34' => 'Spain',
            '+46' => 'Sweden',
            '+31' => 'Netherlands',
            '+64' => 'New Zealand',
            '+20' => 'Egypt',
            '+90' => 'Turkey',
            '+82' => 'South Korea',
            '+965' => 'Kuwait',
            '+971' => 'UAE',
            '+972' => 'Israel',
            '+98' => 'Iran',
        ];

        return view('leads.create', compact('employees', 'countries'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'country_code' => 'required|string',
            'phone' => 'required|digits:10',
            'company' => 'nullable|string|max:255',
            'assigned_to' => 'nullable|exists:users,id',
            'notes' => 'nullable|string|max:1000',
        ]);

        Lead::create([
            'name' => $validated['name'],
            'email' => $validated['email'] ?? null,
            'phone' => $validated['country_code'] . $validated['phone'],
            'company' => $validated['company'] ?? null,
            'assigned_to' => $validated['assigned_to'] ?? null,
            'notes' => $validated['notes'] ?? null,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('leads.index')->with('success', 'Lead created successfully!');
    }
  public function show(Lead $lead)
{
    $lead->load('emailLogs'); 

    return view('leads.show', compact('lead'));
}


    public function edit(Lead $lead)
    {
        $employees = User::all();

        return view('leads.edit', compact('lead', 'employees'));
    }


    public function update(Request $request, Lead $lead)
    {

        $request->validate([
            'name' => 'required',
            'email' => 'nullable|email',
            'phone' => 'nullable'
        ]);

        $lead->update([

            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'company' => $request->company,
            'assigned_to' => $request->assigned_to,
            'notes' => $request->notes

        ]);

        return redirect()->route('leads.index')->with('success', 'Lead Updated');
    }


    public function destroy(Lead $lead)
{
    $lead->delete();

    return redirect()->route('leads.index')
        ->with('success', 'Lead moved to Trash');
}
    public function updateStatus(Request $request, Lead $lead)
    {

        $lead->update([
            'status' => $request->status
        ]);

        return response()->json(['success' => true]);
    }

    public function export(Request $request)
    {
        $query = Lead::query();

        // Apply filters 
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                    ->orWhere('email', 'like', "%{$request->search}%")
                    ->orWhere('phone', 'like', "%{$request->search}%");
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $leads = $query->get();

        $response = new StreamedResponse(function () use ($leads) {

            $handle = fopen('php://output', 'w');

            fputcsv($handle, ['Name', 'Email', 'Phone', 'Status']);

            foreach ($leads as $lead) {
                fputcsv($handle, [
                    $lead->name,
                    $lead->email,
                    $lead->phone,
                    $lead->status,
                ]);
            }

            fclose($handle);
        });

        $filename = 'leads.csv';

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', "attachment; filename=$filename");

        return $response;
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt'
        ]);

        $file = $request->file('file');

        $data = array_map('str_getcsv', file($file));

        foreach ($data as $index => $row) {

            if ($index == 0) continue;

            \App\Models\Lead::create([
                'name' => $row[0] ?? '',
                'email' => $row[1] ?? '',
                'phone' => $row[2] ?? '',
                'status' => $row[3] ?? 'new',
                'created_by' => auth()->id(),
            ]);
        }


        return back()->with('success', 'Leads imported successfully');
    }

    // Send Email to Lead
    public function sendMail(Request $request, $id)
    {
        $lead = Lead::findOrFail($id);

        $request->validate([
            'subject' => 'required|string|max:255',
            'body' => 'required|string'
        ]);

        $body = str_replace(
            ['{name}', '{email}'],
            [$lead->name, $lead->email],
            $request->body
        );

        try {
            Mail::to($lead->email)->send(
                new SendLeadMail($request->subject, $body)
            );
          EmailLog::create([
    'lead_id' => $lead->id,
    'user_id' => auth()->id(),
    'subject' => $request->subject,
    'body' => $body
]);
            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'email_sent',
                'subject_type' => 'Lead',
                'subject_id' => $lead->id,
                'description' => "Email sent to {$lead->email}"
            ]);

            return back()->with('success', 'Email Send successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Email failed: ' . $e->getMessage());
        }
    }
 public function trash()
{
    $leads = Lead::onlyTrashed()->latest()->get();
    return view('leads.trash', compact('leads'));
}

public function restore($id)
{
    Lead::withTrashed()->findOrFail($id)->restore();
    return back()->with('success', 'Lead restored successfully');
}

public function forceDelete($id)
{
    Lead::withTrashed()->findOrFail($id)->forceDelete();
    return back()->with('success', 'Lead deleted permanently');
}

}
