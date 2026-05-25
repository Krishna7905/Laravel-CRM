<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class EmployeeController extends Controller
{

    public function index()
    {
        $employees = User::latest()->get();
        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        return view('employees.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('employees.index')->with('success', 'Employee created successfully');
    }

    public function edit($id)
    {
        $employee = User::findOrFail($id);
        return view('employees.edit', compact('employee'));
    }

    public function update(Request $request, $id)
    {
        $employee = User::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'email' => 'required|email'
        ]);

        $employee->update([
            'name' => $request->name,
            'email' => $request->email
        ]);

        return redirect()->route('employees.index')->with('success', 'Employee updated');
    }

    public function destroy($id)
    {
        $employee = User::findOrFail($id);
        $employee->delete();

        return redirect()->route('employees.index')->with('success', 'Employee deleted');
    }
}
