<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;


class DealController extends Controller
{

    public function index()
    {
        $deals = Deal::with(['contact', 'employee'])->latest()->get();
        return view('deals.index', compact('deals'));
    }

    public function create()
    {
        $contacts = Contact::all();
        $employees = User::all();

        return view('deals.create', compact('contacts', 'employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'contact_id' => 'required|exists:contacts,id',
            'value' => 'required|numeric|min:0',
            'stage' => 'required',
            'close_date' => 'required|date|after_or_equal:today',
            'assigned_to' => 'nullable|exists:users,id',
            'notes' => 'nullable|string'
        ]);

        Deal::create($request->all());



        return redirect()->route('deals.index')
            ->with('success', 'Deal created successfully');
    }

    public function edit(Deal $deal)
    {
        $contacts = Contact::all();
        $employees = User::all();

        return view(
            'deals.edit',
            compact('deal', 'contacts', 'employees')
        );
    }

    public function update(Request $request, Deal $deal)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'contact_id' => 'required|exists:contacts,id',
            'value' => 'required|numeric|min:0',
            'stage' => 'required',
            'close_date' => 'required|date|after_or_equal:today',
            'assigned_to' => 'nullable|exists:users,id',
            'notes' => 'nullable|string'
        ]);

        $deal->update($request->all());

        return redirect()->route('deals.index')
            ->with('success', 'Deal updated successfully');
    }

    public function destroy(Deal $deal)
    {
        $deal->delete();

        return redirect()->route('deals.index')
            ->with('success', 'Deal deleted');
    }
    public function show($id)
    {
        $deal = Deal::with(['contact', 'employee'])->findOrFail($id);

        return view('deals.show', compact('deal'));
    }
}
