@extends('layouts.app')

@section('content')

<div class="container">

    <h4 class="mb-4 fw-bold text-primary">Task Details</h4>

    <div class="card shadow-sm mb-3">
        <div class="card-body">

            <p><strong>Title:</strong> {{ $task->title }}</p>
            <p><strong>Description:</strong> {{ $task->description ?? '-' }}</p>
            <p><strong>Due Date:</strong> {{ \Carbon\Carbon::parse($task->due_date)->format('d M, Y') }}</p>
            <p><strong>Status:</strong> {{ ucfirst($task->status) }}</p>
            <p><strong>Team:</strong> {{ $task->contact->name ?? '-' }}</p>
            <p><strong>Assigned Employee:</strong> {{ $task->employee->name ?? '-' }}</p>
            <p><strong>Created At:</strong> {{ $task->created_at->format('d M, Y') }}</p>
            <p><strong>Updated At:</strong> {{ $task->updated_at->format('d M, Y') }}</p>

        </div>
    </div>

    <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Back to Tasks</a>

</div>

@endsection