<?php

namespace App\Http\Controllers;

use App\Models\Task;

use App\Models\User;
use App\Models\Contact;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    public function index()
    {
        $tasks = Task::with(['contact', 'employee'])
            ->latest()
            ->get();

        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        $contacts = Contact::all();
        $employees = User::all();

        return view('tasks.create', compact('contacts', 'employees'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date|after_or_equal:today',
            'status' => 'required',
            'contact_id' => 'nullable|exists:contacts,id',
            'assigned_to' => 'nullable|exists:users,id'
        ]);

        Task::create($request->all());

        return redirect()->route('tasks.index')
            ->with('success', 'Task created successfully');
    }

    public function edit(Task $task)
    {
        $contacts = Contact::all();
        $employees = User::all();

        return view(
            'tasks.edit',
            compact('task', 'contacts', 'employees')
        );
    }

    public function update(Request $request, Task $task)
    {

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date|after_or_equal:today',
            'status' => 'required',
            'contact_id' => 'nullable|exists:contacts,id',
            'assigned_to' => 'nullable|exists:users,id'
        ]);

        $task->update($request->all());

        return redirect()->route('tasks.index')
            ->with('success', 'Task updated successfully');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')
            ->with('success', 'Task deleted successfully');
    }
    public function show($id)
    {
        $task = Task::with(['contact', 'employee'])->findOrFail($id);

        return view('tasks.show', compact('task'));
    }
}
