<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\User;
use function logActivity;

use Illuminate\Http\Request;

class ContactController extends Controller
{

    public function index(Request $request)
    {
        $query = Contact::with('assignedUser');

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%')
                ->orWhere('phone', 'like', '%' . $request->search . '%');
        }

        $contacts = $query->latest()->paginate(10);

        return view('contacts.index', compact('contacts'));
    }


    public function create()
    {
        $employees = User::all();

        return view('contacts.create', compact('employees'));
    }


    public function store(Request $request)

    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|digits:10',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $data = $request->only([
            'name',
            'email',
            'phone',
            'company',
            'assigned_to',
            'notes'
        ]);

        $data['created_by'] = auth()->id();

        Contact::create($data);

        return redirect()->route('contacts.index')
            ->with('success', 'Contact created successfully');
    }


    public function edit(Contact $contact)
    {
        $employees = User::all();

        return view('contacts.edit', compact('contact', 'employees'));
    }


    public function update(Request $request, Contact $contact)
    {
        $contact->update($request->only([
            'name',
            'email',
            'phone',
            'company',
            'assigned_to',
            'notes'
        ]));


        return redirect()->route('contacts.index')
            ->with('success', 'Contact updated');
    }
    public function show(Contact $contact)
    {
        return view('contacts.show', compact('contact'));
    }


    public function destroy(Contact $contact)
    {
        $contact->delete();

        return back()->with('success', 'Contact deleted');
    }
}
