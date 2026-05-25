@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <h2 class="text-2xl font-bold mb-6">Create Lead</h2>

    <form method="POST" action="{{ route('leads.store') }}"
          class="bg-white shadow rounded-xl p-6 space-y-6">
        @csrf

        <div>
            <label class="block font-medium text-sm text-gray-700">Name</label>
            <input type="text" name="name" required
                   class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm">
        </div>

        <div class="grid grid-cols-2 gap-6">
            <div>
                <label class="block font-medium text-sm text-gray-700">Email</label>
                <input type="email" name="email"
                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm">
            </div>

            <div>
                <label class="block font-medium text-sm text-gray-700">Phone</label>
                <input type="text" name="phone"
                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm">
            </div>
        </div>

        <div>
            <label class="block font-medium text-sm text-gray-700">Company</label>
            <input type="text" name="company"
                   class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm">
        </div>

        <div>
            <label class="block font-medium text-sm text-gray-700">Source</label>
            <input type="text" name="source"
                   class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm"
                   placeholder="Website, Referral, LinkedIn...">
        </div>

        <div>
            <label class="block font-medium text-sm text-gray-700">Status</label>
            <select name="status"
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm">
                <option value="new">New</option>
                <option value="contacted">Contacted</option>
                <option value="qualified">Qualified</option>
                <option value="proposal_sent">Proposal Sent</option>
                <option value="converted">Converted</option>
                <option value="lost">Lost</option>
            </select>
        </div>

        <div>
            <label class="block font-medium text-sm text-gray-700">Assign To</label>
            <select name="assigned_to"
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm">
                <option value="">Unassigned</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex justify-end">
            <button type="submit"
                    class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700">
                Save Lead
            </button>
        </div>

    </form>

</div>
@endsection