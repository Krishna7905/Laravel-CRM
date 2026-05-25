@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Leads</h2>
        <a href="{{ route('leads.create') }}"
           class="bg-indigo-600 text-white px-4 py-2 rounded-lg shadow hover:bg-indigo-700">
            + New Lead
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 bg-green-100 text-green-800 px-4 py-2 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow rounded-xl overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Company</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Assigned To</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Created</th>
                </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($leads as $lead)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-900">
                            {{ $lead->name }}
                            <div class="text-sm text-gray-500">{{ $lead->email }}</div>
                        </td>

                        <td class="px-6 py-4">
                            {{ $lead->company ?? '-' }}
                        </td>

                        <td class="px-6 py-4">
                            @php
                                $colors = [
                                    'new' => 'bg-blue-100 text-blue-800',
                                    'contacted' => 'bg-yellow-100 text-yellow-800',
                                    'qualified' => 'bg-purple-100 text-purple-800',
                                    'proposal_sent' => 'bg-indigo-100 text-indigo-800',
                                    'converted' => 'bg-green-100 text-green-800',
                                    'lost' => 'bg-red-100 text-red-800',
                                ];
                            @endphp

                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $colors[$lead->status] }}">
                                {{ ucfirst(str_replace('_', ' ', $lead->status)) }}
                            </span>
                        </td>

                        <td class="px-6 py-4">
                            {{ $lead->assignedUser->name ?? 'Unassigned' }}
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $lead->created_at->format('d M Y') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            No leads found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $leads->links() }}
    </div>

</div>
@endsection